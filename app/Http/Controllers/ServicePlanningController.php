<?php

namespace App\Http\Controllers;

use App\Models\ServiceSchedule;
use App\Models\ServiceVolunteer;
use App\Models\WorshipPlan;
use App\Repositories\ServicePlanningRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicePlanningController extends Controller
{
    public function __construct(
        protected ServicePlanningRepository $servicePlanningRepository
    ) {}

    /**
     * Display a listing of service schedules.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['service_type', 'status', 'date_from', 'date_to', 'preacher_id', 'search']);
        $services = $this->servicePlanningRepository->getAll($filters);
        $summary = $this->servicePlanningRepository->getDashboardSummary();

        return view('services.index', compact('services', 'summary', 'filters'));
    }

    /**
     * Show the form for creating a new service schedule.
     */
    public function create()
    {
        $preachers = \App\Models\Member::where('member_status', 'active')
            ->orderBy('first_name')
            ->get();

        return view('services.create', compact('preachers'));
    }

    /**
     * Store a newly created service schedule.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'service_type' => 'required|in:regular,special,midweek,youth,children,prayer_meeting,bible_study,other',
            'service_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'venue' => 'nullable|string|max:255',
            'theme' => 'nullable|string',
            'sermon_title' => 'nullable|string',
            'sermon_text' => 'nullable|string',
            'preacher_id' => 'nullable|exists:members,id',
            'expected_attendance' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'draft';

        $service = $this->servicePlanningRepository->create($validated);

        return redirect()
            ->route('services.show', $service)
            ->with('success', 'Service schedule created successfully.');
    }

    /**
     * Display the specified service schedule.
     */
    public function show(ServiceSchedule $service)
    {
        $service = $this->servicePlanningRepository->find($service->id);
        $statistics = $this->servicePlanningRepository->getStatistics($service);

        return view('services.show', compact('service', 'statistics'));
    }

    /**
     * Show the form for editing the service schedule.
     */
    public function edit(ServiceSchedule $service)
    {
        $preachers = \App\Models\Member::where('member_status', 'active')
            ->orderBy('first_name')
            ->get();

        return view('services.edit', compact('service', 'preachers'));
    }

    /**
     * Update the specified service schedule.
     */
    public function update(Request $request, ServiceSchedule $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'service_type' => 'required|string',
            'service_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'venue' => 'nullable|string|max:255',
            'theme' => 'nullable|string',
            'sermon_title' => 'nullable|string',
            'sermon_text' => 'nullable|string',
            'preacher_id' => 'nullable|exists:members,id',
            'expected_attendance' => 'nullable|integer|min:1',
            'actual_attendance' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $this->servicePlanningRepository->update($service, $validated);

        return redirect()
            ->route('services.show', $service)
            ->with('success', 'Service schedule updated successfully.');
    }

    /**
     * Remove the specified service schedule.
     */
    public function destroy(ServiceSchedule $service)
    {
        $this->servicePlanningRepository->delete($service);

        return redirect()
            ->route('services.index')
            ->with('success', 'Service schedule deleted successfully.');
    }

    /**
     * Publish service schedule.
     */
    public function publish(ServiceSchedule $service)
    {
        if ($this->servicePlanningRepository->publish($service)) {
            return redirect()
                ->back()
                ->with('success', 'Service schedule published successfully.');
        }

        return redirect()->back()->with('error', 'Cannot publish this service. Please ensure all required details are filled.');
    }

    /**
     * Start service.
     */
    public function start(ServiceSchedule $service)
    {
        if ($this->servicePlanningRepository->start($service)) {
            return redirect()
                ->back()
                ->with('success', 'Service started successfully.');
        }

        return redirect()->back()->with('error', 'Cannot start this service.');
    }

    /**
     * Complete service.
     */
    public function complete(ServiceSchedule $service)
    {
        if ($this->servicePlanningRepository->complete($service)) {
            return redirect()
                ->back()
                ->with('success', 'Service marked as completed.');
        }

        return redirect()->back()->with('error', 'Cannot complete this service.');
    }

    /**
     * Cancel service.
     */
    public function cancel(ServiceSchedule $service)
    {
        if ($this->servicePlanningRepository->cancel($service)) {
            return redirect()
                ->back()
                ->with('success', 'Service cancelled successfully.');
        }

        return redirect()->back()->with('error', 'Cannot cancel this service.');
    }

    /**
     * Manage worship plan.
     */
    public function manageWorshipPlan(ServiceSchedule $service)
    {
        $service = $this->servicePlanningRepository->find($service->id);

        return view('services.worship-plan', compact('service'));
    }

    /**
     * Store worship plan item.
     */
    public function storeWorshipPlanItem(Request $request, ServiceSchedule $service)
    {
        $validated = $request->validate([
            'order_number' => 'nullable|integer',
            'item_type' => 'required|in:opening_prayer,worship_song,hymn,scripture_reading,prayer,offering,special_number,sermon,altar_call,announcements,benediction,other',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:1',
            'assigned_to' => 'nullable|exists:members,id',
            'notes' => 'nullable|string',
            'song_details' => 'nullable|json',
        ]);

        $this->servicePlanningRepository->addWorshipPlanItem($service, $validated);

        return redirect()
            ->back()
            ->with('success', 'Worship plan item added successfully.');
    }

    /**
     * Update worship plan item.
     */
    public function updateWorshipPlanItem(Request $request, WorshipPlan $item)
    {
        $validated = $request->validate([
            'order_number' => 'required|integer',
            'item_type' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:1',
            'assigned_to' => 'nullable|exists:members,id',
            'notes' => 'nullable|string',
            'song_details' => 'nullable|json',
        ]);

        $this->servicePlanningRepository->updateWorshipPlanItem($item, $validated);

        return redirect()
            ->back()
            ->with('success', 'Worship plan item updated successfully.');
    }

    /**
     * Delete worship plan item.
     */
    public function destroyWorshipPlanItem(WorshipPlan $item)
    {
        $this->servicePlanningRepository->deleteWorshipPlanItem($item);

        return redirect()
            ->back()
            ->with('success', 'Worship plan item deleted successfully.');
    }

    /**
     * Reorder worship plan items.
     */
    public function reorderWorshipPlan(Request $request, ServiceSchedule $service)
    {
        $validated = $request->validate([
            'ordered_ids' => 'required|array',
            'ordered_ids.*' => 'required|integer|exists:worship_plans,id',
        ]);

        $this->servicePlanningRepository->reorderWorshipPlan($service, $validated['ordered_ids']);

        return response()->json(['success' => true]);
    }

    /**
     * Manage volunteers.
     */
    public function manageVolunteers(ServiceSchedule $service)
    {
        $service = $this->servicePlanningRepository->find($service->id);

        // Get available members for each role
        $roles = [
            'usher', 'choir', 'instrumentalist', 'tech_team', 'protocol',
            'media', 'security', 'parking', 'childrens_church',
            'altar_worker', 'offering_counter', 'intercessor',
        ];

        return view('services.volunteers', compact('service', 'roles'));
    }

    /**
     * Assign volunteer.
     */
    public function assignVolunteer(Request $request, ServiceSchedule $service)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'role' => 'required|in:usher,choir,instrumentalist,tech_team,protocol,media,security,parking,childrens_church,altar_worker,offering_counter,intercessor,other',
            'specific_duty' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'assigned';

        $this->servicePlanningRepository->assignVolunteer($service, $validated);

        return redirect()
            ->back()
            ->with('success', 'Volunteer assigned successfully.');
    }

    /**
     * Update volunteer.
     */
    public function updateVolunteer(Request $request, ServiceVolunteer $volunteer)
    {
        $validated = $request->validate([
            'role' => 'required|string',
            'specific_duty' => 'nullable|string|max:255',
            'status' => 'required|in:assigned,confirmed,declined,completed,absent',
            'notes' => 'nullable|string',
        ]);

        $this->servicePlanningRepository->updateVolunteer($volunteer, $validated);

        return redirect()
            ->back()
            ->with('success', 'Volunteer updated successfully.');
    }

    /**
     * Remove volunteer.
     */
    public function removeVolunteer(ServiceVolunteer $volunteer)
    {
        $this->servicePlanningRepository->removeVolunteer($volunteer);

        return redirect()
            ->back()
            ->with('success', 'Volunteer removed successfully.');
    }

    /**
     * Volunteer confirms assignment.
     */
    public function confirmVolunteer(ServiceVolunteer $volunteer)
    {
        $volunteer->confirm();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Assignment confirmed.');
    }

    /**
     * Duplicate service to a new date.
     */
    public function duplicate(Request $request, ServiceSchedule $service)
    {
        $validated = $request->validate([
            'new_date' => 'required|date|after:today',
        ]);

        $newService = $this->servicePlanningRepository->duplicateService(
            $service,
            \Carbon\Carbon::parse($validated['new_date'])
        );

        return redirect()
            ->route('services.show', $newService)
            ->with('success', 'Service duplicated successfully.');
    }

    /**
     * Sermon library.
     */
    public function sermonLibrary(Request $request)
    {
        $filters = $request->only(['preacher_id', 'tag', 'search']);
        $sermons = $this->servicePlanningRepository->getSermons($filters);
        $preachers = $this->servicePlanningRepository->getPreachersWithStats();

        return view('services.sermon-library', compact('sermons', 'preachers', 'filters'));
    }

    /**
     * Service calendar view.
     */
    public function calendar(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $services = ServiceSchedule::whereYear('service_date', $year)
            ->whereMonth('service_date', $month)
            ->with('preacher')
            ->get();

        return view('services.calendar', compact('services', 'month', 'year'));
    }
}
