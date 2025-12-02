<?php

namespace App\Http\Controllers;

use App\Models\CounsellingCase;
use App\Models\CounsellingResource;
use App\Models\CounsellingSession;
use App\Models\Counsellor;
use App\Repositories\CounsellingRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CounsellingController extends Controller
{
    public function __construct(
        private CounsellingRepository $repository
    ) {}

    /**
     * Display counselling dashboard.
     */
    public function index()
    {
        $statistics = $this->repository->getDashboardStatistics();
        $todaysSessions = $this->repository->getTodaysSessions();
        $activeCases = $this->repository->getActiveCases();

        return view('counselling.index', compact('statistics', 'todaysSessions', 'activeCases'));
    }

    /**
     * Display counsellors list.
     */
    public function counsellors(Request $request)
    {
        $filters = $request->only(['active', 'availability_status', 'specialization', 'accepting_bookings']);
        $counsellors = $this->repository->getCounsellors($filters);

        return view('counselling.counsellors.index', compact('counsellors', 'filters'));
    }

    /**
     * Show counsellor details.
     */
    public function showCounsellor(Counsellor $counsellor)
    {
        $counsellor->load(['user', 'schedules']);
        $statistics = $this->repository->getCounsellorStatistics($counsellor);
        $activeCases = $this->repository->getCounsellorActiveCases($counsellor);

        return view('counselling.counsellors.show', compact('counsellor', 'statistics', 'activeCases'));
    }

    /**
     * Show create counsellor form.
     */
    public function createCounsellor()
    {
        $specializations = Counsellor::SPECIALIZATIONS;

        return view('counselling.counsellors.create', compact('specializations'));
    }

    /**
     * Store new counsellor.
     */
    public function storeCounsellor(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:counsellors,user_id',
            'license_number' => 'nullable|string|max:255',
            'qualifications' => 'nullable|array',
            'specializations' => 'required|array|min:1',
            'languages' => 'nullable|array',
            'bio' => 'nullable|string',
            'max_sessions_per_week' => 'required|integer|min:1|max:50',
            'session_duration_minutes' => 'required|integer|min:15|max:180',
            'accepts_online_bookings' => 'nullable|boolean',
        ]);

        $validated['is_active'] = true;
        $validated['availability_status'] = 'available';

        $counsellor = Counsellor::create($validated);

        return redirect()
            ->route('counselling.counsellors.show', $counsellor)
            ->with('success', 'Counsellor added successfully.');
    }

    /**
     * Update counsellor.
     */
    public function updateCounsellor(Request $request, Counsellor $counsellor)
    {
        $validated = $request->validate([
            'license_number' => 'nullable|string|max:255',
            'qualifications' => 'nullable|array',
            'specializations' => 'required|array|min:1',
            'languages' => 'nullable|array',
            'bio' => 'nullable|string',
            'max_sessions_per_week' => 'required|integer|min:1|max:50',
            'session_duration_minutes' => 'required|integer|min:15|max:180',
            'availability_status' => 'required|in:available,limited,unavailable',
            'accepts_online_bookings' => 'nullable|boolean',
        ]);

        $counsellor->update($validated);

        return redirect()
            ->route('counselling.counsellors.show', $counsellor)
            ->with('success', 'Counsellor updated successfully.');
    }

    /**
     * Activate counsellor.
     */
    public function activateCounsellor(Counsellor $counsellor)
    {
        $counsellor->activate();

        return redirect()
            ->back()
            ->with('success', 'Counsellor activated successfully.');
    }

    /**
     * Deactivate counsellor.
     */
    public function deactivateCounsellor(Counsellor $counsellor)
    {
        $counsellor->deactivate();

        return redirect()
            ->back()
            ->with('success', 'Counsellor deactivated successfully.');
    }

    /**
     * Display sessions list.
     */
    public function sessions(Request $request)
    {
        $filters = $request->only(['status', 'session_type', 'member_id', 'counsellor_id', 'urgency', 'upcoming', 'past', 'today', 'this_week']);
        $sessions = $this->repository->getSessions($filters);

        return view('counselling.sessions.index', compact('sessions', 'filters'));
    }

    /**
     * Show session details.
     */
    public function showSession(CounsellingSession $session)
    {
        $session->load(['member', 'counsellor.user', 'case', 'bookedBy']);

        return view('counselling.sessions.show', compact('session'));
    }

    /**
     * Show booking form.
     */
    public function createSession(Request $request)
    {
        $sessionTypes = CounsellingSession::SESSION_TYPES;
        $memberId = $request->input('member_id');
        $member = $memberId ? \App\Models\Member::find($memberId) : null;

        return view('counselling.sessions.create', compact('sessionTypes', 'member'));
    }

    /**
     * Get available counsellors for session type.
     */
    public function getAvailableCounsellors(Request $request)
    {
        $validated = $request->validate([
            'session_type' => 'required|string',
            'preferred_date' => 'required|date',
        ]);

        $date = Carbon::parse($validated['preferred_date']);
        $counsellors = $this->repository->getAvailableCounsellors($validated['session_type'], $date);

        return response()->json([
            'counsellors' => $counsellors->map(function ($counsellor) use ($date) {
                return [
                    'id' => $counsellor->id,
                    'name' => $counsellor->full_name,
                    'specializations' => $counsellor->specializations_display,
                    'available_slots' => $counsellor->getAvailableSlots($date),
                ];
            }),
        ]);
    }

    /**
     * Store new session.
     */
    public function storeSession(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'counsellor_id' => 'required|exists:counsellors,id',
            'case_id' => 'nullable|exists:counselling_cases,id',
            'session_type' => 'required|in:pre_marital,marriage,youth,addiction,grief,career,spiritual,family,other',
            'session_date' => 'required|date|after_or_equal:today',
            'session_time' => 'required|date_format:H:i',
            'duration_minutes' => 'nullable|integer|min:15|max:180',
            'mode' => 'required|in:in_person,phone,video,email',
            'location' => 'nullable|string|max:255',
            'video_link' => 'nullable|url',
            'urgency_level' => 'required|in:low,medium,high,critical',
            'booking_notes' => 'nullable|string',
        ]);

        // Check slot availability
        $date = Carbon::parse($validated['session_date']);
        if (! $this->repository->isSlotAvailable($validated['counsellor_id'], $date, $validated['session_time'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'The selected time slot is not available.');
        }

        $session = $this->repository->createSession($validated);

        return redirect()
            ->route('counselling.sessions.show', $session)
            ->with('success', 'Session booked successfully.');
    }

    /**
     * Update session.
     */
    public function updateSession(Request $request, CounsellingSession $session)
    {
        $validated = $request->validate([
            'session_notes' => 'nullable|string',
            'action_items' => 'nullable|array',
            'progress_assessment' => 'nullable|string',
            'follow_up_required' => 'nullable|boolean',
            'follow_up_date' => 'nullable|date',
            'outcome' => 'nullable|in:resolved,ongoing,referred,discontinued',
        ]);

        $session->update($validated);

        return redirect()
            ->route('counselling.sessions.show', $session)
            ->with('success', 'Session updated successfully.');
    }

    /**
     * Confirm session.
     */
    public function confirmSession(CounsellingSession $session)
    {
        $session->confirm();

        return redirect()
            ->back()
            ->with('success', 'Session confirmed.');
    }

    /**
     * Start session.
     */
    public function startSession(CounsellingSession $session)
    {
        $session->start();

        return redirect()
            ->back()
            ->with('success', 'Session started.');
    }

    /**
     * Complete session.
     */
    public function completeSession(Request $request, CounsellingSession $session)
    {
        $validated = $request->validate([
            'session_notes' => 'required|string',
            'action_items' => 'nullable|array',
            'progress_assessment' => 'nullable|string',
            'outcome' => 'required|in:resolved,ongoing,referred,discontinued',
            'follow_up_required' => 'nullable|boolean',
            'follow_up_date' => 'nullable|date|required_if:follow_up_required,true',
        ]);

        $session->complete($validated);

        return redirect()
            ->route('counselling.sessions.show', $session)
            ->with('success', 'Session completed successfully.');
    }

    /**
     * Cancel session.
     */
    public function cancelSession(Request $request, CounsellingSession $session)
    {
        $validated = $request->validate([
            'cancellation_reason' => 'required|string',
        ]);

        $session->cancel($validated['cancellation_reason']);

        return redirect()
            ->back()
            ->with('success', 'Session cancelled.');
    }

    /**
     * Reschedule session.
     */
    public function rescheduleSession(Request $request, CounsellingSession $session)
    {
        $validated = $request->validate([
            'session_date' => 'required|date|after_or_equal:today',
            'session_time' => 'required|date_format:H:i',
        ]);

        // Check new slot availability
        $date = Carbon::parse($validated['session_date']);
        if (! $this->repository->isSlotAvailable($session->counsellor_id, $date, $validated['session_time'])) {
            return redirect()
                ->back()
                ->with('error', 'The selected time slot is not available.');
        }

        $session->reschedule($validated['session_date'], $validated['session_time']);

        return redirect()
            ->route('counselling.sessions.show', $session)
            ->with('success', 'Session rescheduled successfully.');
    }

    /**
     * Display cases list.
     */
    public function cases(Request $request)
    {
        $filters = $request->only(['status', 'priority', 'counsellor_id', 'member_id', 'overdue']);
        $cases = $this->repository->getCases($filters);

        return view('counselling.cases.index', compact('cases', 'filters'));
    }

    /**
     * Show case details.
     */
    public function showCase(CounsellingCase $case)
    {
        $case->load(['member', 'primaryCounsellor.user', 'sessions', 'documents', 'referrals']);

        return view('counselling.cases.show', compact('case'));
    }

    /**
     * Show create case form.
     */
    public function createCase(Request $request)
    {
        $issueCategories = CounsellingCase::ISSUE_CATEGORIES;
        $memberId = $request->input('member_id');
        $member = $memberId ? \App\Models\Member::find($memberId) : null;

        return view('counselling.cases.create', compact('issueCategories', 'member'));
    }

    /**
     * Store new case.
     */
    public function storeCase(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'primary_counsellor_id' => 'required|exists:counsellors,id',
            'case_title' => 'required|string|max:255',
            'case_description' => 'nullable|string',
            'issue_categories' => 'required|array|min:1',
            'priority' => 'required|in:low,medium,high,critical',
            'planned_sessions' => 'nullable|integer|min:1',
            'goals' => 'nullable|array',
        ]);

        $case = $this->repository->createCase($validated);

        return redirect()
            ->route('counselling.cases.show', $case)
            ->with('success', 'Case created successfully.');
    }

    /**
     * Update case.
     */
    public function updateCase(Request $request, CounsellingCase $case)
    {
        $validated = $request->validate([
            'case_title' => 'required|string|max:255',
            'case_description' => 'nullable|string',
            'issue_categories' => 'required|array|min:1',
            'priority' => 'required|in:low,medium,high,critical',
            'planned_sessions' => 'nullable|integer|min:1',
        ]);

        $case->update($validated);

        return redirect()
            ->route('counselling.cases.show', $case)
            ->with('success', 'Case updated successfully.');
    }

    /**
     * Activate case.
     */
    public function activateCase(CounsellingCase $case)
    {
        $case->activate();

        return redirect()
            ->back()
            ->with('success', 'Case activated.');
    }

    /**
     * Put case on hold.
     */
    public function holdCase(CounsellingCase $case)
    {
        $case->putOnHold();

        return redirect()
            ->back()
            ->with('success', 'Case put on hold.');
    }

    /**
     * Close case.
     */
    public function closeCase(Request $request, CounsellingCase $case)
    {
        $validated = $request->validate([
            'closure_reason' => 'required|in:resolved,referred,discontinued,unresponsive,other',
            'closure_notes' => 'nullable|string',
        ]);

        $case->close($validated['closure_reason'], $validated['closure_notes']);

        return redirect()
            ->route('counselling.cases.show', $case)
            ->with('success', 'Case closed successfully.');
    }

    /**
     * Display resources library.
     */
    public function resources(Request $request)
    {
        $filters = $request->only(['resource_type', 'category', 'is_public', 'is_featured', 'search']);
        $resources = $this->repository->getResources($filters);

        return view('counselling.resources.index', compact('resources', 'filters'));
    }

    /**
     * Show resource details.
     */
    public function showResource(CounsellingResource $resource)
    {
        $resource->incrementViews();
        $resource->load('creator');

        return view('counselling.resources.show', compact('resource'));
    }

    /**
     * Show create resource form.
     */
    public function createResource()
    {
        $resourceTypes = CounsellingResource::RESOURCE_TYPES;
        $categories = CounsellingCase::ISSUE_CATEGORIES;

        return view('counselling.resources.create', compact('resourceTypes', 'categories'));
    }

    /**
     * Store new resource.
     */
    public function storeResource(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'resource_type' => 'required|in:article,video,audio,book,worksheet,guide,other',
            'categories' => 'required|array|min:1',
            'file' => 'nullable|file|max:10240',
            'external_url' => 'nullable|url',
            'content' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'reading_time_minutes' => 'nullable|integer|min:1',
            'is_public' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'tags' => 'nullable|array',
        ]);

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('counselling-resources', 'public');
        }

        $validated['created_by'] = auth()->id();

        $resource = CounsellingResource::create($validated);

        return redirect()
            ->route('counselling.resources.show', $resource)
            ->with('success', 'Resource created successfully.');
    }

    /**
     * Update resource.
     */
    public function updateResource(Request $request, CounsellingResource $resource)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'resource_type' => 'required|in:article,video,audio,book,worksheet,guide,other',
            'categories' => 'required|array|min:1',
            'external_url' => 'nullable|url',
            'content' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'reading_time_minutes' => 'nullable|integer|min:1',
            'is_public' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'tags' => 'nullable|array',
        ]);

        $resource->update($validated);

        return redirect()
            ->route('counselling.resources.show', $resource)
            ->with('success', 'Resource updated successfully.');
    }

    /**
     * Download resource.
     */
    public function downloadResource(CounsellingResource $resource)
    {
        if (! $resource->fileExists()) {
            return redirect()
                ->back()
                ->with('error', 'File not found.');
        }

        $resource->incrementDownloads();

        return response()->download(storage_path('app/public/'.$resource->file_path));
    }

    /**
     * Display reports.
     */
    public function reports(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonths(3)->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $report = $this->repository->getCounsellingReport(
            Carbon::parse($startDate),
            Carbon::parse($endDate)
        );

        return view('counselling.reports', compact('report', 'startDate', 'endDate'));
    }
}
