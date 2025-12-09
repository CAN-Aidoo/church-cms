<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\ServiceUnit;
use App\Models\ServiceUnitMember;
use App\Models\DutyRoster;
use App\Repositories\ServiceUnitRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobileServiceUnitController extends Controller
{
    protected $serviceUnitRepository;

    public function __construct(ServiceUnitRepository $serviceUnitRepository)
    {
        $this->serviceUnitRepository = $serviceUnitRepository;
    }

    /**
     * Get units the authenticated user belongs to.
     */
    public function getMyUnits()
    {
        $memberId = Auth::user()->member->id;

        $units = ServiceUnit::whereHas('members', function ($query) use ($memberId) {
            $query->where('member_id', $memberId)
                  ->where('status', 'active');
        })
        ->with(['members' => function ($query) use ($memberId) {
            $query->where('member_id', $memberId);
        }])
        ->get()
        ->map(function ($unit) {
            $memberPivot = $unit->members->first()->pivot;
            return [
                'id' => $unit->id,
                'name' => $unit->name,
                'description' => $unit->description,
                'role' => $memberPivot->role, // leader, assistant_leader, member
                'next_meeting' => $unit->meeting_schedule,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $units
        ]);
    }

    /**
     * Get details of a specific unit (Leader/Asst Only).
     */
    public function show(ServiceUnit $serviceUnit)
    {
        $this->authorizeLeader($serviceUnit);

        $serviceUnit->load(['leader', 'assistantLeader']);
        
        // Get stats
        $stats = [
            'total_members' => $serviceUnit->activeMembers()->count(),
            'upcoming_duties' => $serviceUnit->dutyRosters()->upcoming()->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'unit' => $serviceUnit,
                'stats' => $stats
            ]
        ]);
    }

    /**
     * Get members of a unit (Leader/Asst Only).
     */
    public function getMembers(ServiceUnit $serviceUnit)
    {
        $this->authorizeLeader($serviceUnit);

        $members = $this->serviceUnitRepository->getUnitMembers($serviceUnit);

        return response()->json([
            'success' => true,
            'data' => $members
        ]);
    }

    /**
     * Add a member to the unit (Leader/Asst Only).
     */
    public function addMember(Request $request, ServiceUnit $serviceUnit)
    {
        $this->authorizeLeader($serviceUnit);

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'role' => 'required|in:member,trainee,assistant_leader',
            'joined_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        // Check if already a member
        if ($serviceUnit->members()->where('member_id', $validated['member_id'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Member is already in this unit'
            ], 422);
        }

        $member = \App\Models\Member::find($validated['member_id']);
        $this->serviceUnitRepository->addMember($serviceUnit, $member, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Member added successfully'
        ]);
    }

    /**
     * Get duty rosters (Leader/Asst Only).
     */
    public function getRosters(ServiceUnit $serviceUnit)
    {
        $this->authorizeLeader($serviceUnit);

        $rosters = $this->serviceUnitRepository->getDutyRosters($serviceUnit);

        return response()->json([
            'success' => true,
            'data' => $rosters
        ]);
    }

    /**
     * Create a duty roster (Leader/Asst Only).
     */
    public function createRoster(Request $request, ServiceUnit $serviceUnit)
    {
        $this->authorizeLeader($serviceUnit);

        $validated = $request->validate([
            'roster_name' => 'required|string|max:100',
            'duty_date' => 'required|date|after_or_equal:today',
            'start_time' => 'nullable',
            'end_time' => 'nullable|after:start_time',
            'duty_type' => 'required|in:sunday_service,midweek_service,special_event,rehearsal,practice,other',
            'assigned_members' => 'nullable|array',
            'assigned_members.*' => 'exists:members,id'
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'draft';

        $roster = $this->serviceUnitRepository->createDutyRoster($serviceUnit, $validated);

        if (!empty($validated['assigned_members'])) {
            foreach ($validated['assigned_members'] as $memberId) {
                $roster->assignments()->create([
                    'member_id' => $memberId,
                    'status' => 'assigned'
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Duty roster created',
            'data' => $roster
        ]);
    }

    /**
     * Helper to authorize leader actions.
     */
    protected function authorizeLeader(ServiceUnit $unit)
    {
        $memberId = Auth::user()->member->id;
        
        if ($unit->leader_id !== $memberId && $unit->assistant_leader_id !== $memberId) {
            abort(403, 'You are not a leader of this unit.');
        }
    }
}