<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use App\Models\Visitor;
use App\Repositories\VisitorRepository;
use App\Services\MemberService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VisitorController extends Controller
{
    public function __construct(
        protected VisitorRepository $visitorRepository,
        protected MemberService $memberService
    ) {}

    /**
     * Display visitor list.
     */
    public function index(Request $request)
    {
        $filters = $request->only([
            'date_from', 'date_to', 'status', 'converted',
            'visit_count_min', 'visit_count_max', 'search',
            'sort_by', 'sort_order',
        ]);

        $perPage = $request->input('per_page', 15);
        $visitors = $this->visitorRepository->getPaginated($filters, $perPage);

        // Get statistics
        $statistics = $this->visitorRepository->getStatistics($filters);

        if ($request->wantsJson()) {
            return response()->json([
                'visitors' => $visitors,
                'statistics' => $statistics,
                'filters' => $filters,
            ]);
        }

        return view('visitors.index', compact(
            'visitors',
            'statistics',
            'filters'
        ));
    }

    /**
     * Show form to create visitor.
     */
    public function create()
    {
        return view('visitors.create');
    }

    /**
     * Store visitor.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:100|unique:visitors,email',
            'phone' => 'required|string|max:20|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'how_heard' => 'nullable|string|max:100',
            'interests' => 'nullable|string',
            'notes' => 'nullable|string',
            'visit_date' => 'nullable|date|before_or_equal:today',
        ]);

        // Combine address components if city/state provided
        if (! empty($validated['city']) || ! empty($validated['state'])) {
            $location = [];
            if (! empty($validated['city'])) {
                $location[] = $validated['city'];
            }
            if (! empty($validated['state'])) {
                $location[] = $validated['state'];
            }

            $locationStr = implode(', ', $location);

            if (! empty($validated['address'])) {
                $validated['address'] .= "\n".$locationStr;
            } else {
                $validated['address'] = $locationStr;
            }
        }

        // Append interests to notes since it's not a DB column
        if (! empty($validated['interests'])) {
            $interestNote = 'Interests: '.$validated['interests'];
            if (! empty($validated['notes'])) {
                $validated['notes'] .= "\n".$interestNote;
            } else {
                $validated['notes'] = $interestNote;
            }
        }

        $visitor = $this->visitorRepository->create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Visitor registered successfully.',
                'visitor' => $visitor,
            ], 201);
        }

        return redirect()
            ->route('visitors.show', $visitor)
            ->with('success', 'Visitor registered successfully.');
    }

    /**
     * Show visitor details.
     */
    public function show(Visitor $visitor)
    {
        $visitor->load('convertedMember');

        // Check if eligible for conversion
        $eligibleForConversion = $visitor->visit_count >= 5 && ! $visitor->converted_member_id;

        if (request()->wantsJson()) {
            return response()->json([
                'visitor' => $visitor,
                'eligible_for_conversion' => $eligibleForConversion,
            ]);
        }

        return view('visitors.show', compact('visitor', 'eligibleForConversion'));
    }

    /**
     * Show edit form.
     */
    public function edit(Visitor $visitor)
    {
        // Don't allow editing converted visitors
        if ($visitor->converted_member_id) {
            return redirect()
                ->route('visitors.show', $visitor)
                ->with('error', 'Cannot edit converted visitors. Update their member profile instead.');
        }

        return view('visitors.edit', compact('visitor'));
    }

    /**
     * Update visitor.
     */
    public function update(Request $request, Visitor $visitor)
    {
        // Don't allow updating converted visitors
        if ($visitor->converted_member_id) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Cannot update converted visitors.'], 403);
            }
            return redirect()
                ->route('visitors.show', $visitor)
                ->with('error', 'Cannot update converted visitors.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:100|unique:visitors,email,'.$visitor->id,
            'phone' => 'required|string|max:20|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'how_heard' => 'nullable|string|max:100',
            'interests' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive,converted',
        ]);

        // Combine address components
        if (! empty($validated['city']) || ! empty($validated['state'])) {
            $location = [];
            if (! empty($validated['city'])) {
                $location[] = $validated['city'];
            }
            if (! empty($validated['state'])) {
                $location[] = $validated['state'];
            }

            $locationStr = implode(', ', $location);

            if (! empty($validated['address'])) {
                // Check if address already contains this to avoid duplication on multiple updates
                if (! str_contains($validated['address'], $locationStr)) {
                    $validated['address'] .= "\n".$locationStr;
                }
            } else {
                $validated['address'] = $locationStr;
            }
        }

        // Handle interests
        if (! empty($validated['interests'])) {
            $interestNote = 'Interests: '.$validated['interests'];
            if (! empty($validated['notes'])) {
                if (! str_contains($validated['notes'], 'Interests: '.$validated['interests'])) {
                    $validated['notes'] .= "\n".$interestNote;
                }
            } else {
                $validated['notes'] = $interestNote;
            }
        }

        $this->visitorRepository->update($visitor, $validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Visitor updated successfully.',
                'visitor' => $visitor->fresh(),
            ]);
        }

        return redirect()
            ->route('visitors.show', $visitor)
            ->with('success', 'Visitor updated successfully.');
    }

    /**
     * Delete visitor.
     */
    public function destroy(Visitor $visitor)
    {
        // Only admin can delete
        if (! Auth::user()->hasRole('admin')) {
            if (request()->wantsJson()) {
                return response()->json(['error' => 'You do not have permission to delete visitors.'], 403);
            }
            abort(403, 'You do not have permission to delete visitors.');
        }

        // Don't allow deleting converted visitors
        if ($visitor->converted_member_id) {
            if (request()->wantsJson()) {
                return response()->json(['error' => 'Cannot delete converted visitors.'], 403);
            }
            return redirect()
                ->route('visitors.index')
                ->with('error', 'Cannot delete converted visitors.');
        }

        $this->visitorRepository->delete($visitor);

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Visitor deleted successfully.']);
        }

        return redirect()
            ->route('visitors.index')
            ->with('success', 'Visitor deleted successfully.');
    }

    /**
     * Record a visit.
     */
    public function recordVisit(Request $request, Visitor $visitor)
    {
        $validated = $request->validate([
            'visit_date' => 'nullable|date|before_or_equal:today',
        ]);

        $visitDate = isset($validated['visit_date']) ? Carbon::parse($validated['visit_date']) : null;

        $this->visitorRepository->recordVisit($visitor, $visitDate);

        // Check if now eligible for conversion
        if ($visitor->fresh()->visit_count >= 5) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Visit recorded! This visitor is now eligible for conversion to member.',
                    'visitor' => $visitor->fresh(),
                    'eligible_for_conversion' => true,
                ]);
            }
            return redirect()
                ->route('visitors.show', $visitor)
                ->with('success', 'Visit recorded! This visitor is now eligible for conversion to member.');
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Visit recorded successfully.',
                'visitor' => $visitor->fresh(),
            ]);
        }

        return redirect()
            ->route('visitors.show', $visitor)
            ->with('success', 'Visit recorded successfully.');
    }

    /**
     * Show conversion page.
     */
    public function convertForm(Visitor $visitor)
    {
        // Check eligibility
        if ($visitor->visit_count < 5) {
            return redirect()
                ->route('visitors.show', $visitor)
                ->with('error', 'Visitor must have at least 5 visits to convert to member.');
        }

        if ($visitor->converted_member_id) {
            return redirect()
                ->route('visitors.show', $visitor)
                ->with('error', 'This visitor has already been converted to member.');
        }

        return view('visitors.convert', compact('visitor'));
    }

    /**
     * Convert visitor to member.
     */
    public function convert(Request $request, Visitor $visitor)
    {
        // Check eligibility
        if ($visitor->visit_count < 5) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Visitor must have at least 5 visits to convert.'], 400);
            }
            return redirect()
                ->route('visitors.show', $visitor)
                ->with('error', 'Visitor must have at least 5 visits to convert.');
        }

        if ($visitor->converted_member_id) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Visitor already converted.'], 400);
            }
            return redirect()
                ->route('visitors.show', $visitor)
                ->with('error', 'Visitor already converted.');
        }

        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'required|in:male,female',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'occupation' => 'nullable|string|max:100',
            'join_date' => 'required|date|before_or_equal:today',
        ]);

        DB::transaction(function () use ($visitor, $validated) {
            // Create user account
            $user = User::create([
                'full_name' => $visitor->first_name.' '.$visitor->last_name,
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'member',
                'is_active' => true,
            ]);

            // Generate unique member ID
            $memberId = $this->memberService->generateUniqueMemberId();

            // Create member record
            $member = Member::create([
                'user_id' => $user->id,
                'member_id' => $memberId,
                'first_name' => $visitor->first_name,
                'last_name' => $visitor->last_name,
                'email' => $validated['email'],
                'phone' => $visitor->phone,
                'address' => $visitor->address,
                'city' => $visitor->city,
                'state' => $visitor->state,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'],
                'marital_status' => $validated['marital_status'] ?? null,
                'occupation' => $validated['occupation'] ?? null,
                'join_date' => $validated['join_date'],
                'status' => 'pending', // Pending until completion of onboarding
            ]);

            // Link visitor to member
            $this->visitorRepository->convertToMember($visitor, $member);
        });

        $visitor->refresh();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Visitor successfully converted to member!',
                'visitor' => $visitor,
                'member_id' => $visitor->convertedMember->id,
            ]);
        }

        return redirect()
            ->route('members.show', $visitor->convertedMember)
            ->with('success', 'Visitor successfully converted to member! Please complete their profile and assign to a shepherd.');
    }

    /**
     * Show visitors eligible for conversion.
     */
    public function eligible()
    {
        $eligibleVisitors = $this->visitorRepository->getEligibleForConversion();

        return view('visitors.eligible', compact('eligibleVisitors'));
    }

    /**
     * Show visitors needing follow-up.
     */
    public function followUp()
    {
        $needingFollowUp = $this->visitorRepository->getNeedingFollowUp(14);
        $notReturned = $this->visitorRepository->getNotReturned(30);

        return view('visitors.follow-up', compact('needingFollowUp', 'notReturned'));
    }

    /**
     * Show visitor reports.
     */
    public function reports(Request $request)
    {
        $startDate = $request->input('date_from', now()->startOfMonth());
        $endDate = $request->input('date_to', now()->endOfMonth());

        $filters = [
            'date_from' => $startDate,
            'date_to' => $endDate,
        ];

        // Get statistics
        $statistics = $this->visitorRepository->getStatistics($filters);

        // Get monthly trends
        $trends = $this->visitorRepository->getMonthlyTrends(12);

        // Get referral sources
        $referralSources = $this->visitorRepository->getReferralSourceBreakdown(
            Carbon::parse($startDate),
            Carbon::parse($endDate)
        );

        // Get conversion funnel
        $conversionFunnel = $this->visitorRepository->getConversionFunnel();

        // Get first-time vs repeat
        $firstTimeVisitors = $this->visitorRepository->getFirstTimeVisitors(
            Carbon::parse($startDate),
            Carbon::parse($endDate)
        )->count();

        $repeatVisitors = $this->visitorRepository->getRepeatVisitors(
            Carbon::parse($startDate),
            Carbon::parse($endDate)
        )->count();

        return view('visitors.reports', compact(
            'statistics',
            'trends',
            'referralSources',
            'conversionFunnel',
            'firstTimeVisitors',
            'repeatVisitors',
            'filters'
        ));
    }

    /**
     * Export visitors to CSV.
     */
    public function export(Request $request)
    {
        $filters = $request->only([
            'date_from', 'date_to', 'status', 'converted',
        ]);

        $visitors = $this->visitorRepository->export($filters);

        $filename = 'visitors_'.date('Y-m-d_His').'.csv';
        $handle = fopen('php://output', 'w');

        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');

        // Add CSV header
        fputcsv($handle, [
            'Name', 'Email', 'Phone', 'First Visit', 'Last Visit', 'Visit Count',
            'Status', 'Referral Source', 'Converted', 'Member ID',
        ]);

        // Add visitor data
        foreach ($visitors as $visitor) {
            fputcsv($handle, [
                $visitor->first_name.' '.$visitor->last_name,
                $visitor->email,
                $visitor->phone,
                $visitor->first_visit_date?->format('Y-m-d'),
                $visitor->last_visit_date?->format('Y-m-d'),
                $visitor->visit_count,
                ucfirst($visitor->status),
                $visitor->referral_source ?? '-',
                $visitor->converted_member_id ? 'Yes' : 'No',
                $visitor->convertedMember?->member_id ?? '-',
            ]);
        }

        fclose($handle);
        exit;
    }

    /**
     * Mark visitor as inactive.
     */
    public function markInactive(Request $request, Visitor $visitor)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $this->visitorRepository->markAsInactive($visitor, $validated['reason']);

        return redirect()
            ->route('visitors.index')
            ->with('success', 'Visitor marked as inactive.');
    }

    /**
     * Search visitors (AJAX).
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        $limit = $request->input('limit', 10);

        $visitors = $this->visitorRepository->search($query, $limit);

        return response()->json($visitors);
    }
}
