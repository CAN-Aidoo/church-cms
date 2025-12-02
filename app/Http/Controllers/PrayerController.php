<?php

namespace App\Http\Controllers;

use App\Models\PrayerRequest;
use App\Models\PrayerTestimony;
use App\Repositories\PrayerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrayerController extends Controller
{
    public function __construct(
        protected PrayerRepository $prayerRepository
    ) {}

    /**
     * Display prayer requests dashboard.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'urgency', 'category_id', 'privacy_level', 'intercessor_id', 'search']);
        $prayerRequests = $this->prayerRepository->getAll($filters);
        $statistics = $this->prayerRepository->getDashboardStatistics();
        $categories = $this->prayerRepository->getCategories();

        return view('prayer.index', compact('prayerRequests', 'statistics', 'categories', 'filters'));
    }

    /**
     * Show prayer wall (public view).
     */
    public function prayerWall()
    {
        $publicRequests = $this->prayerRepository->getPublic(50);
        $urgentRequests = $this->prayerRepository->getUrgent();

        return view('prayer.wall', compact('publicRequests', 'urgentRequests'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $categories = $this->prayerRepository->getCategories();

        return view('prayer.create', compact('categories'));
    }

    /**
     * Store new prayer request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:prayer_categories,id',
            'requester_name' => 'required|string|max:255',
            'requester_phone' => 'nullable|string|max:20',
            'requester_email' => 'nullable|email|max:255',
            'request_title' => 'required|string|max:255',
            'request_details' => 'required|string',
            'urgency' => 'required|in:low,normal,high,critical',
            'privacy_level' => 'required|in:public,pastors_only,private',
            'is_anonymous' => 'nullable|boolean',
            'tags' => 'nullable|array',
        ]);

        // Set member_id if authenticated and not anonymous
        if (Auth::check() && ! ($validated['is_anonymous'] ?? false)) {
            $validated['member_id'] = Auth::user()->member?->id;
        }

        $validated['status'] = 'pending';

        $prayerRequest = $this->prayerRepository->create($validated);

        return redirect()
            ->route('prayer.show', $prayerRequest)
            ->with('success', 'Prayer request submitted successfully. We will pray for you.');
    }

    /**
     * Display prayer request details.
     */
    public function show(PrayerRequest $prayerRequest)
    {
        $prayerRequest = $this->prayerRepository->find($prayerRequest->id);

        // Check privacy permissions
        if (! $this->canViewPrayerRequest($prayerRequest)) {
            abort(403, 'You do not have permission to view this prayer request.');
        }

        return view('prayer.show', compact('prayerRequest'));
    }

    /**
     * Show edit form.
     */
    public function edit(PrayerRequest $prayerRequest)
    {
        $this->authorize('update', $prayerRequest);

        $categories = $this->prayerRepository->getCategories();

        return view('prayer.edit', compact('prayerRequest', 'categories'));
    }

    /**
     * Update prayer request.
     */
    public function update(Request $request, PrayerRequest $prayerRequest)
    {
        // Check authorization - staff and above, or the requester
        $user = Auth::user();
        $isRequester = $prayerRequest->member_id === $user->member?->id;

        if (! $user->hasAnyRole(['admin', 'pastor', 'staff']) && ! $isRequester) {
            abort(403, 'You do not have permission to update this prayer request.');
        }

        $validated = $request->validate([
            'category_id' => 'nullable|exists:prayer_categories,id',
            'request_title' => 'required|string|max:255',
            'request_details' => 'required|string',
            'urgency' => 'required|in:low,normal,high,critical',
            'privacy_level' => 'required|in:public,pastors_only,private',
            'tags' => 'nullable|array',
        ]);

        $this->prayerRepository->update($prayerRequest, $validated);

        return redirect()
            ->route('prayer.show', $prayerRequest)
            ->with('success', 'Prayer request updated successfully.');
    }

    /**
     * Delete prayer request.
     */
    public function destroy(PrayerRequest $prayerRequest)
    {
        // Check authorization - only admin and pastor can delete, or the requester
        $user = Auth::user();
        $isRequester = $prayerRequest->member_id === $user->member?->id;

        if (! $user->hasAnyRole(['admin', 'pastor']) && ! $isRequester) {
            abort(403, 'You do not have permission to delete this prayer request.');
        }

        $this->prayerRepository->delete($prayerRequest);

        return redirect()
            ->route('prayer.index')
            ->with('success', 'Prayer request deleted successfully.');
    }

    /**
     * Assign prayer request to intercessor.
     */
    public function assign(Request $request, PrayerRequest $prayerRequest)
    {
        $validated = $request->validate([
            'intercessor_id' => 'required|exists:members,id',
            'notes' => 'nullable|string',
        ]);

        $this->prayerRepository->assignToIntercessor(
            $prayerRequest,
            $validated['intercessor_id'],
            $validated['notes'] ?? null
        );

        return redirect()
            ->back()
            ->with('success', 'Prayer request assigned successfully.');
    }

    /**
     * Add update to prayer request.
     */
    public function addUpdate(Request $request, PrayerRequest $prayerRequest)
    {
        $validated = $request->validate([
            'update_text' => 'required|string',
            'update_type' => 'required|in:progress,note,status_change,answered',
            'notify_requester' => 'nullable|boolean',
        ]);

        $this->prayerRepository->addUpdate(
            $prayerRequest,
            Auth::id(),
            $validated['update_text'],
            $validated['update_type'],
            $validated['notify_requester'] ?? false
        );

        return redirect()
            ->back()
            ->with('success', 'Update added successfully.');
    }

    /**
     * Mark prayer request as answered.
     */
    public function markAnswered(Request $request, PrayerRequest $prayerRequest)
    {
        $validated = $request->validate([
            'testimony' => 'nullable|string',
            'share_testimony' => 'nullable|boolean',
        ]);

        $this->prayerRepository->markAnswered(
            $prayerRequest,
            $validated['testimony'] ?? null,
            $validated['share_testimony'] ?? false
        );

        if (! empty($validated['testimony'])) {
            // Create testimony record
            $this->prayerRepository->createTestimony([
                'prayer_request_id' => $prayerRequest->id,
                'member_id' => $prayerRequest->member_id,
                'title' => $prayerRequest->request_title,
                'testimony' => $validated['testimony'],
                'testimony_date' => now(),
                'share_publicly' => $validated['share_testimony'] ?? false,
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Prayer marked as answered. Praise God!');
    }

    /**
     * My prayer requests.
     */
    public function myRequests()
    {
        $member = Auth::user()->member;

        if (! $member) {
            return redirect()->route('prayer.index');
        }

        $myRequests = PrayerRequest::where('member_id', $member->id)
            ->with(['category', 'assignedIntercessor'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('prayer.my-requests', compact('myRequests'));
    }

    /**
     * My assignments (for intercessors).
     */
    public function myAssignments()
    {
        $member = Auth::user()->member;

        if (! $member) {
            return redirect()->route('prayer.index');
        }

        $myAssignments = $this->prayerRepository->getForIntercessor($member->id);
        $statistics = $this->prayerRepository->getIntercessorStatistics($member->id);

        return view('prayer.my-assignments', compact('myAssignments', 'statistics'));
    }

    /**
     * Analytics dashboard.
     */
    public function analytics()
    {
        $statistics = $this->prayerRepository->getDashboardStatistics();
        $categoryStats = $this->prayerRepository->getStatisticsByCategory();
        $urgencyStats = $this->prayerRepository->getStatisticsByUrgency();
        $monthlyStats = $this->prayerRepository->getMonthlyStatistics(12);

        return view('prayer.analytics', compact('statistics', 'categoryStats', 'urgencyStats', 'monthlyStats'));
    }

    /**
     * Testimonies page.
     */
    public function testimonies(Request $request)
    {
        $filters = $request->only(['is_approved', 'share_publicly', 'search']);
        $testimonies = $this->prayerRepository->getTestimonies($filters);

        return view('prayer.testimonies', compact('testimonies', 'filters'));
    }

    /**
     * Public testimonies wall.
     */
    public function testimoniesWall()
    {
        $testimonies = $this->prayerRepository->getPublicTestimonies(20);

        return view('prayer.testimonies-wall', compact('testimonies'));
    }

    /**
     * Approve testimony.
     */
    public function approveTestimony(PrayerTestimony $testimony)
    {
        $testimony->approve(Auth::id());

        return redirect()
            ->back()
            ->with('success', 'Testimony approved successfully.');
    }

    /**
     * Check if user can view prayer request based on privacy level.
     */
    protected function canViewPrayerRequest(PrayerRequest $prayerRequest): bool
    {
        // Public requests - everyone can see
        if ($prayerRequest->privacy_level === 'public') {
            return true;
        }

        // User is not logged in
        if (! Auth::check()) {
            return false;
        }

        $user = Auth::user();

        // Own request
        if ($prayerRequest->member_id && $prayerRequest->member_id === $user->member?->id) {
            return true;
        }

        // Assigned intercessor
        if ($prayerRequest->assigned_to && $prayerRequest->assigned_to === $user->member?->id) {
            return true;
        }

        // Pastors and admins can see pastors_only
        if ($prayerRequest->privacy_level === 'pastors_only') {
            return in_array($user->role, ['admin', 'pastor']);
        }

        // Private - only creator and admins
        if ($prayerRequest->privacy_level === 'private') {
            return $user->role === 'admin';
        }

        return false;
    }
}
