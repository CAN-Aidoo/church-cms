<?php

namespace App\Http\Controllers;

use App\Models\FlockMeeting;
use App\Models\Member;
use App\Models\MemberVisitation;
use App\Models\Shepherd;
use App\Repositories\ShepherdRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShepherdController extends Controller
{
    protected $shepherdRepository;

    public function __construct(ShepherdRepository $shepherdRepository)
    {
        $this->shepherdRepository = $shepherdRepository;
    }

    /**
     * Display a listing of shepherds.
     */
    public function index(Request $request)
    {
        $query = Shepherd::with('member');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query = $this->shepherdRepository->search($request->search);
        }

        $shepherds = $query->paginate(20);

        // Get statistics
        $stats = $this->shepherdRepository->getStatistics();

        return view('shepherds.index', compact('shepherds', 'stats'));
    }

    /**
     * Show the form for creating a new shepherd.
     */
    public function create()
    {
        // Get members who can be shepherds (not already shepherds)
        $availableMembers = Member::where('member_status', 'active')
            ->whereDoesntHave('shepherdRole')
            ->orderBy('first_name')
            ->get();

        return view('shepherds.create', compact('availableMembers'));
    }

    /**
     * Store a newly created shepherd.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id|unique:shepherds,member_id',
            'flock_name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'max_flock_size' => 'required|integer|min:1|max:20',
            'appointed_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'active';
        $validated['current_flock_size'] = 0;

        $shepherd = $this->shepherdRepository->create($validated);

        return redirect()
            ->route('shepherds.show', $shepherd)
            ->with('success', 'Shepherd appointed successfully.');
    }

    /**
     * Display the specified shepherd.
     */
    public function show(Shepherd $shepherd)
    {
        $shepherd->load(['member', 'flockMembers']);

        // Get recent activity (last 30 days)
        $startDate = now()->subDays(30);
        $endDate = now();

        $recentVisitations = $this->shepherdRepository->getVisitations($shepherd)
            ->where('visit_date', '>=', $startDate)
            ->take(10);

        $recentMeetings = $this->shepherdRepository->getMeetings($shepherd)
            ->where('meeting_date', '>=', $startDate)
            ->take(10);

        $upcomingMeetings = $this->shepherdRepository->getUpcomingMeetings($shepherd)
            ->take(5);

        $followUpVisitations = $this->shepherdRepository->getVisitationsRequiringFollowUp($shepherd);

        // Get performance metrics
        $performance = $this->shepherdRepository->getPerformanceMetrics($shepherd, $startDate, $endDate);

        return view('shepherds.show', compact(
            'shepherd',
            'recentVisitations',
            'recentMeetings',
            'upcomingMeetings',
            'followUpVisitations',
            'performance'
        ));
    }

    /**
     * Show the form for editing the specified shepherd.
     */
    public function edit(Shepherd $shepherd)
    {
        return view('shepherds.edit', compact('shepherd'));
    }

    /**
     * Update the specified shepherd.
     */
    public function update(Request $request, Shepherd $shepherd)
    {
        $validated = $request->validate([
            'flock_name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'max_flock_size' => 'required|integer|min:1|max:20',
            'status' => 'required|in:active,inactive,on_leave',
            'appointed_date' => 'required|date',
            'end_date' => 'nullable|date|after:appointed_date',
            'notes' => 'nullable|string',
        ]);

        $this->shepherdRepository->update($shepherd, $validated);

        return redirect()
            ->route('shepherds.show', $shepherd)
            ->with('success', 'Shepherd updated successfully.');
    }

    /**
     * Remove the specified shepherd.
     */
    public function destroy(Shepherd $shepherd)
    {
        // Unassign all members first
        foreach ($shepherd->flockMembers as $member) {
            $this->shepherdRepository->unassignMember($member);
        }

        $this->shepherdRepository->delete($shepherd);

        return redirect()
            ->route('shepherds.index')
            ->with('success', 'Shepherd removed successfully.');
    }

    /**
     * Show flock management interface.
     */
    public function manageFlock(Shepherd $shepherd)
    {
        $flockMembers = $this->shepherdRepository->getFlockMembers($shepherd);
        $unassignedMembers = $this->shepherdRepository->getMembersWithoutShepherd();

        return view('shepherds.manage-flock', compact('shepherd', 'flockMembers', 'unassignedMembers'));
    }

    /**
     * Assign a member to shepherd's flock.
     */
    public function assignMember(Request $request, Shepherd $shepherd)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        $member = Member::findOrFail($validated['member_id']);

        if (! $shepherd->hasCapacity()) {
            return redirect()
                ->back()
                ->with('error', 'Shepherd has reached maximum flock capacity.');
        }

        if ($this->shepherdRepository->assignMember($shepherd, $member)) {
            return redirect()
                ->back()
                ->with('success', 'Member assigned to flock successfully.');
        }

        return redirect()
            ->back()
            ->with('error', 'Failed to assign member.');
    }

    /**
     * Unassign a member from shepherd's flock.
     */
    public function unassignMember(Request $request, Shepherd $shepherd)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        $member = Member::findOrFail($validated['member_id']);

        if ($this->shepherdRepository->unassignMember($member)) {
            return redirect()
                ->back()
                ->with('success', 'Member removed from flock successfully.');
        }

        return redirect()
            ->back()
            ->with('error', 'Failed to remove member.');
    }

    /**
     * Auto-assign members without shepherds.
     */
    public function autoAssign()
    {
        $result = $this->shepherdRepository->autoAssignMembers();

        return redirect()
            ->route('shepherds.index')
            ->with('success', "Auto-assignment complete: {$result['assigned']} members assigned, {$result['failed']} failed.");
    }

    /**
     * Display visitation reports.
     */
    public function visitations(Shepherd $shepherd)
    {
        $visitations = $this->shepherdRepository->getVisitations($shepherd);
        $followUpVisitations = $this->shepherdRepository->getVisitationsRequiringFollowUp($shepherd);

        return view('shepherds.visitations', compact('shepherd', 'visitations', 'followUpVisitations'));
    }

    /**
     * Show form to record a visitation.
     */
    public function createVisitation(Shepherd $shepherd)
    {
        $flockMembers = $this->shepherdRepository->getFlockMembers($shepherd);

        return view('shepherds.create-visitation', compact('shepherd', 'flockMembers'));
    }

    /**
     * Store a new visitation.
     */
    public function storeVisitation(Request $request, Shepherd $shepherd)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'visit_date' => 'required|date',
            'visit_time' => 'nullable',
            'visit_type' => 'required|in:home_visit,hospital_visit,phone_call,counseling,follow_up,other',
            'visit_reason' => 'required|in:routine,pastoral_care,crisis,new_member,inactive_member,other',
            'notes' => 'required|string',
            'prayer_requests' => 'nullable|string',
            'action_items' => 'nullable|string',
            'follow_up_date' => 'nullable|date|after:visit_date',
        ]);

        $validated['shepherd_id'] = $shepherd->id;
        $validated['status'] = 'completed';

        MemberVisitation::create($validated);

        return redirect()
            ->route('shepherds.visitations', $shepherd)
            ->with('success', 'Visitation recorded successfully.');
    }

    /**
     * Display flock meetings.
     */
    public function meetings(Shepherd $shepherd)
    {
        $meetings = $this->shepherdRepository->getMeetings($shepherd);
        $upcomingMeetings = $this->shepherdRepository->getUpcomingMeetings($shepherd);

        return view('shepherds.meetings', compact('shepherd', 'meetings', 'upcomingMeetings'));
    }

    /**
     * Show form to schedule a meeting.
     */
    public function createMeeting(Shepherd $shepherd)
    {
        return view('shepherds.create-meeting', compact('shepherd'));
    }

    /**
     * Store a new meeting.
     */
    public function storeMeeting(Request $request, Shepherd $shepherd)
    {
        $validated = $request->validate([
            'meeting_date' => 'required|date',
            'meeting_time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'meeting_type' => 'required|in:regular,special,emergency,social',
            'agenda' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $validated['shepherd_id'] = $shepherd->id;
        $validated['recorded_by'] = Auth::id();
        $validated['status'] = 'scheduled';

        FlockMeeting::create($validated);

        return redirect()
            ->route('shepherds.meetings', $shepherd)
            ->with('success', 'Meeting scheduled successfully.');
    }

    /**
     * Display shepherd reports.
     */
    public function reports(Shepherd $shepherd)
    {
        $reports = $this->shepherdRepository->getReports($shepherd);

        return view('shepherds.reports', compact('shepherd', 'reports'));
    }

    /**
     * Display comprehensive shepherd analytics.
     */
    public function analytics()
    {
        $startDate = now()->subMonths(3);
        $endDate = now();

        $shepherds = $this->shepherdRepository->getShepherdsWithPerformance($startDate, $endDate);
        $stats = $this->shepherdRepository->getStatistics();
        $needingAttention = $this->shepherdRepository->getNeedingAttention();

        return view('shepherds.analytics', compact('shepherds', 'stats', 'needingAttention'));
    }

    /**
     * Export shepherds to CSV.
     */
    public function export(Request $request)
    {
        $query = Shepherd::with('member');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $shepherds = $query->orderBy('flock_name')->get();

        $filename = 'shepherds_export_'.now()->format('Y-m-d_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function () use ($shepherds) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'Flock Name',
                'Shepherd Name',
                'Status',
                'Current Flock Size',
                'Max Flock Size',
                'Capacity %',
                'Appointed Date',
                'Years of Service',
            ]);

            // Add data rows
            foreach ($shepherds as $shepherd) {
                fputcsv($file, [
                    $shepherd->flock_name,
                    $shepherd->full_name,
                    ucfirst($shepherd->status),
                    $shepherd->current_flock_size,
                    $shepherd->max_flock_size,
                    number_format($shepherd->capacity_percentage, 1).'%',
                    $shepherd->appointed_date->format('Y-m-d'),
                    $shepherd->years_of_service,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
