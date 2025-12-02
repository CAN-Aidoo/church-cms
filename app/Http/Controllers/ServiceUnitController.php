<?php

namespace App\Http\Controllers;

use App\Models\DutyRoster;
use App\Models\Member;
use App\Models\ServiceUnit;
use App\Models\ServiceUnitMember;
use App\Repositories\ServiceUnitRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceUnitController extends Controller
{
    protected $serviceUnitRepository;

    public function __construct(ServiceUnitRepository $serviceUnitRepository)
    {
        $this->serviceUnitRepository = $serviceUnitRepository;
    }

    /**
     * Display a listing of service units.
     */
    public function index(Request $request)
    {
        $query = ServiceUnit::with(['leader', 'assistantLeader']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query = $this->serviceUnitRepository->search($request->search);
        }

        $units = $query->paginate(20);

        // Get statistics
        $stats = $this->serviceUnitRepository->getStatistics();

        // Get units by category for quick filter
        $categoryStats = [];
        $categories = ['music', 'technical', 'hospitality', 'security', 'admin', 'children', 'media', 'other'];
        foreach ($categories as $category) {
            $categoryStats[$category] = $this->serviceUnitRepository->countByCategory($category);
        }

        return view('service-units.index', compact('units', 'stats', 'categoryStats'));
    }

    /**
     * Show the form for creating a new service unit.
     */
    public function create()
    {
        // Get members who can be leaders
        $availableMembers = Member::where('member_status', 'active')
            ->orderBy('first_name')
            ->get();

        return view('service-units.create', compact('availableMembers'));
    }

    /**
     * Store a newly created service unit.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:service_units,code',
            'description' => 'nullable|string',
            'category' => 'required|in:music,technical,hospitality,security,admin,children,media,other',
            'leader_id' => 'nullable|exists:members,id',
            'assistant_leader_id' => 'nullable|exists:members,id|different:leader_id',
            'min_members' => 'required|integer|min:1|max:50',
            'max_members' => 'required|integer|min:1|max:100|gte:min_members',
            'meeting_schedule' => 'nullable|string|max:255',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
        ]);

        $validated['status'] = 'active';
        $validated['current_members'] = 0;

        $serviceUnit = $this->serviceUnitRepository->create($validated);

        return redirect()
            ->route('service-units.show', $serviceUnit)
            ->with('success', 'Service unit created successfully.');
    }

    /**
     * Display the specified service unit.
     */
    public function show(ServiceUnit $serviceUnit)
    {
        $serviceUnit->load(['leader', 'assistantLeader']);

        // Get unit members
        $unitMembers = $this->serviceUnitRepository->getUnitMembers($serviceUnit);

        // Get upcoming duty rosters
        $upcomingRosters = $this->serviceUnitRepository->getUpcomingDutyRosters($serviceUnit)
            ->take(5);

        // Get performance metrics (last 90 days)
        $startDate = now()->subDays(90);
        $endDate = now();
        $performance = $this->serviceUnitRepository->getPerformanceMetrics($serviceUnit, $startDate, $endDate);

        return view('service-units.show', compact('serviceUnit', 'unitMembers', 'upcomingRosters', 'performance'));
    }

    /**
     * Show the form for editing the specified service unit.
     */
    public function edit(ServiceUnit $serviceUnit)
    {
        // Get members who can be leaders
        $availableMembers = Member::where('member_status', 'active')
            ->orderBy('first_name')
            ->get();

        return view('service-units.edit', compact('serviceUnit', 'availableMembers'));
    }

    /**
     * Update the specified service unit.
     */
    public function update(Request $request, ServiceUnit $serviceUnit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:service_units,code,'.$serviceUnit->id,
            'description' => 'nullable|string',
            'category' => 'required|in:music,technical,hospitality,security,admin,children,media,other',
            'leader_id' => 'nullable|exists:members,id',
            'assistant_leader_id' => 'nullable|exists:members,id|different:leader_id',
            'min_members' => 'required|integer|min:1|max:50',
            'max_members' => 'required|integer|min:1|max:100|gte:min_members',
            'status' => 'required|in:active,inactive,suspended',
            'meeting_schedule' => 'nullable|string|max:255',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
        ]);

        $this->serviceUnitRepository->update($serviceUnit, $validated);

        return redirect()
            ->route('service-units.show', $serviceUnit)
            ->with('success', 'Service unit updated successfully.');
    }

    /**
     * Remove the specified service unit.
     */
    public function destroy(ServiceUnit $serviceUnit)
    {
        $this->serviceUnitRepository->delete($serviceUnit);

        return redirect()
            ->route('service-units.index')
            ->with('success', 'Service unit deleted successfully.');
    }

    /**
     * Show members management interface.
     */
    public function manageMembers(ServiceUnit $serviceUnit)
    {
        $unitMembers = $this->serviceUnitRepository->getUnitMembers($serviceUnit);
        $availableMembers = $this->serviceUnitRepository->getMembersWithoutUnit();

        return view('service-units.manage-members', compact('serviceUnit', 'unitMembers', 'availableMembers'));
    }

    /**
     * Add a member to the service unit.
     */
    public function addMember(Request $request, ServiceUnit $serviceUnit)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'role' => 'required|in:leader,assistant_leader,member,trainee',
            'joined_date' => 'required|date',
            'proficiency_level' => 'nullable|integer|min:1|max:5',
            'skills' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if (! $serviceUnit->hasCapacity()) {
            return redirect()
                ->back()
                ->with('error', 'Service unit has reached maximum capacity.');
        }

        $member = Member::findOrFail($validated['member_id']);

        // Convert skills string to array
        if (isset($validated['skills'])) {
            $validated['skills'] = array_filter(array_map('trim', explode(',', $validated['skills'])));
        }

        $this->serviceUnitRepository->addMember($serviceUnit, $member, $validated);

        return redirect()
            ->back()
            ->with('success', 'Member added to service unit successfully.');
    }

    /**
     * Remove a member from the service unit.
     */
    public function removeMember(Request $request, ServiceUnit $serviceUnit)
    {
        $validated = $request->validate([
            'unit_member_id' => 'required|exists:service_unit_members,id',
        ]);

        $unitMember = ServiceUnitMember::findOrFail($validated['unit_member_id']);

        $this->serviceUnitRepository->removeMember($unitMember);

        return redirect()
            ->back()
            ->with('success', 'Member removed from service unit successfully.');
    }

    /**
     * Display duty rosters.
     */
    public function dutyRosters(ServiceUnit $serviceUnit)
    {
        $rosters = $this->serviceUnitRepository->getDutyRosters($serviceUnit);
        $upcomingRosters = $this->serviceUnitRepository->getUpcomingDutyRosters($serviceUnit);

        return view('service-units.duty-rosters', compact('serviceUnit', 'rosters', 'upcomingRosters'));
    }

    /**
     * Show form to create a duty roster.
     */
    public function createDutyRoster(ServiceUnit $serviceUnit)
    {
        $unitMembers = $this->serviceUnitRepository->getUnitMembers($serviceUnit);

        return view('service-units.create-duty-roster', compact('serviceUnit', 'unitMembers'));
    }

    /**
     * Store a new duty roster.
     */
    public function storeDutyRoster(Request $request, ServiceUnit $serviceUnit)
    {
        $validated = $request->validate([
            'roster_name' => 'required|string|max:100',
            'duty_date' => 'required|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable|after:start_time',
            'duty_type' => 'required|in:sunday_service,midweek_service,special_event,rehearsal,practice,other',
            'location' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'assigned_members' => 'nullable|array',
            'assigned_members.*' => 'exists:members,id',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'draft';

        $dutyRoster = $this->serviceUnitRepository->createDutyRoster($serviceUnit, $validated);

        // Add assignments if provided
        if (isset($validated['assigned_members'])) {
            foreach ($validated['assigned_members'] as $memberId) {
                $dutyRoster->assignments()->create([
                    'member_id' => $memberId,
                    'status' => 'assigned',
                ]);
            }
        }

        return redirect()
            ->route('service-units.duty-rosters', $serviceUnit)
            ->with('success', 'Duty roster created successfully.');
    }

    /**
     * Publish a duty roster.
     */
    public function publishDutyRoster(DutyRoster $dutyRoster)
    {
        $dutyRoster->status = 'published';
        $dutyRoster->published_at = now();
        $dutyRoster->save();

        return redirect()
            ->back()
            ->with('success', 'Duty roster published successfully.');
    }

    /**
     * Display service unit analytics.
     */
    public function analytics()
    {
        $units = $this->serviceUnitRepository->getActive();
        $stats = $this->serviceUnitRepository->getStatistics();
        $needingAttention = $this->serviceUnitRepository->getNeedingAttention();
        $upcomingDuties = $this->serviceUnitRepository->getUnitsWithUpcomingDuties();

        // Get performance for each unit
        $startDate = now()->subDays(90);
        $endDate = now();

        $units = $units->map(function ($unit) use ($startDate, $endDate) {
            $unit->performance = $this->serviceUnitRepository->getPerformanceMetrics($unit, $startDate, $endDate);

            return $unit;
        });

        return view('service-units.analytics', compact('units', 'stats', 'needingAttention', 'upcomingDuties'));
    }

    /**
     * Export service units to CSV.
     */
    public function export(Request $request)
    {
        $query = ServiceUnit::with(['leader', 'assistantLeader']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $units = $query->orderBy('name')->get();

        $filename = 'service_units_export_'.now()->format('Y-m-d_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function () use ($units) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'Name',
                'Code',
                'Category',
                'Leader',
                'Assistant Leader',
                'Current Members',
                'Max Members',
                'Capacity %',
                'Status',
            ]);

            // Add data rows
            foreach ($units as $unit) {
                fputcsv($file, [
                    $unit->name,
                    $unit->code,
                    ucfirst($unit->category),
                    $unit->leader?->full_name ?? 'N/A',
                    $unit->assistantLeader?->full_name ?? 'N/A',
                    $unit->current_members,
                    $unit->max_members,
                    number_format($unit->capacity_percentage, 1).'%',
                    ucfirst($unit->status),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
