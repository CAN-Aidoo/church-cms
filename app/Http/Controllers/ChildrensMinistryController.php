<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\ChildrenCheckin;
use App\Models\ChildrensEvent;
use App\Models\CurriculumLesson;
use App\Repositories\ChildrensMinistryRepository;
use Illuminate\Http\Request;

class ChildrensMinistryController extends Controller
{
    public function __construct(
        private ChildrensMinistryRepository $repository
    ) {}

    /**
     * Display children's ministry dashboard.
     */
    public function index()
    {
        $statistics = $this->repository->getDashboardStatistics();
        $todaysCheckins = $this->repository->getTodaysCheckins(['status' => 'checked_in']);
        $upcomingEvents = ChildrensEvent::upcoming()->limit(5)->get();

        return view('childrens-ministry.index', compact('statistics', 'todaysCheckins', 'upcomingEvents'));
    }

    /**
     * Display children list.
     */
    public function children(Request $request)
    {
        $filters = $request->only(['age_group', 'search', 'birthday_month']);
        $children = $this->repository->getChildren($filters);

        return view('childrens-ministry.children.index', compact('children', 'filters'));
    }

    /**
     * Show child profile.
     */
    public function showChild(Child $child)
    {
        $child->load(['family']);
        $attendanceHistory = $this->repository->getChildAttendanceHistory($child);

        return view('childrens-ministry.children.show', compact('child', 'attendanceHistory'));
    }

    /**
     * Display check-in interface.
     */
    public function checkinInterface()
    {
        $checkins = $this->repository->getTodaysCheckins();
        $statistics = $this->repository->getCheckinStatistics();

        return view('childrens-ministry.checkin.index', compact('checkins', 'statistics'));
    }

    /**
     * Process check-in.
     */
    public function processCheckin(Request $request)
    {
        $validated = $request->validate([
            'child_id' => 'required|exists:children,id',
            'service_id' => 'nullable|exists:service_schedules,id',
            'classroom_assigned' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $child = Child::findOrFail($validated['child_id']);
        $checkin = $this->repository->checkInChild($child, $validated);

        return redirect()
            ->route('childrens-ministry.checkin')
            ->with('success', "Child {$child->full_name} checked in successfully. Security code: {$checkin->security_code}");
    }

    /**
     * Process check-out.
     */
    public function processCheckout(Request $request, ChildrenCheckin $checkin)
    {
        $validated = $request->validate([
            'authorized_person' => 'required|string',
            'security_code' => 'required|string',
        ]);

        if ($checkin->security_code !== $validated['security_code']) {
            return redirect()
                ->back()
                ->with('error', 'Invalid security code.');
        }

        try {
            $this->repository->checkOutChild($checkin, $validated['authorized_person']);

            return redirect()
                ->route('childrens-ministry.checkin')
                ->with('success', "Child {$checkin->child->full_name} checked out successfully.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display curriculum lessons.
     */
    public function curriculumLessons(Request $request)
    {
        $filters = $request->only(['age_group', 'series', 'published', 'search']);
        $lessons = $this->repository->getCurriculumLessons($filters);

        return view('childrens-ministry.curriculum.index', compact('lessons', 'filters'));
    }

    /**
     * Show curriculum lesson.
     */
    public function showLesson(CurriculumLesson $lesson)
    {
        $lesson->load(['creator', 'schedules']);

        return view('childrens-ministry.curriculum.show', compact('lesson'));
    }

    /**
     * Create curriculum lesson form.
     */
    public function createLesson()
    {
        $ageGroups = CurriculumLesson::AGE_GROUPS;

        return view('childrens-ministry.curriculum.create', compact('ageGroups'));
    }

    /**
     * Store curriculum lesson.
     */
    public function storeLesson(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'series' => 'nullable|string|max:255',
            'age_group' => 'required|in:nursery,toddlers,beginners,primary,juniors,teens',
            'bible_story' => 'required|string',
            'bible_reference' => 'required|string|max:255',
            'memory_verse' => 'required|string',
            'lesson_objective' => 'nullable|string',
            'lesson_content' => 'nullable|string',
            'activities' => 'nullable|array',
            'craft_projects' => 'nullable|array',
            'resources' => 'nullable|array',
            'duration_minutes' => 'nullable|integer|min:15|max:180',
            'is_published' => 'nullable|boolean',
        ]);

        $lesson = $this->repository->createCurriculumLesson($validated);

        return redirect()
            ->route('childrens-ministry.curriculum.show', $lesson)
            ->with('success', 'Lesson created successfully.');
    }

    /**
     * Edit curriculum lesson.
     */
    public function editLesson(CurriculumLesson $lesson)
    {
        $ageGroups = CurriculumLesson::AGE_GROUPS;

        return view('childrens-ministry.curriculum.edit', compact('lesson', 'ageGroups'));
    }

    /**
     * Update curriculum lesson.
     */
    public function updateLesson(Request $request, CurriculumLesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'series' => 'nullable|string|max:255',
            'age_group' => 'required|in:nursery,toddlers,beginners,primary,juniors,teens',
            'bible_story' => 'required|string',
            'bible_reference' => 'required|string|max:255',
            'memory_verse' => 'required|string',
            'lesson_objective' => 'nullable|string',
            'lesson_content' => 'nullable|string',
            'activities' => 'nullable|array',
            'craft_projects' => 'nullable|array',
            'resources' => 'nullable|array',
            'duration_minutes' => 'nullable|integer|min:15|max:180',
            'is_published' => 'nullable|boolean',
        ]);

        $lesson->update($validated);

        return redirect()
            ->route('childrens-ministry.curriculum.show', $lesson)
            ->with('success', 'Lesson updated successfully.');
    }

    /**
     * Delete curriculum lesson.
     */
    public function deleteLesson(CurriculumLesson $lesson)
    {
        $lesson->delete();

        return redirect()
            ->route('childrens-ministry.curriculum')
            ->with('success', 'Lesson deleted successfully.');
    }

    /**
     * Publish lesson.
     */
    public function publishLesson(CurriculumLesson $lesson)
    {
        $lesson->publish();

        return redirect()
            ->back()
            ->with('success', 'Lesson published successfully.');
    }

    /**
     * Display events.
     */
    public function events(Request $request)
    {
        $filters = $request->only(['event_type', 'status', 'upcoming']);
        $events = $this->repository->getEvents($filters);

        return view('childrens-ministry.events.index', compact('events', 'filters'));
    }

    /**
     * Show event.
     */
    public function showEvent(ChildrensEvent $event)
    {
        $event->load(['coordinator', 'registrations.child']);
        $registrations = $this->repository->getEventRegistrations($event);

        return view('childrens-ministry.events.show', compact('event', 'registrations'));
    }

    /**
     * Create event form.
     */
    public function createEvent()
    {
        $eventTypes = ChildrensEvent::EVENT_TYPES;
        $ageGroups = CurriculumLesson::AGE_GROUPS;

        return view('childrens-ministry.events.create', compact('eventTypes', 'ageGroups'));
    }

    /**
     * Store event.
     */
    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'event_type' => 'required|in:vbs,camp,holiday_program,talent_show,sports,field_trip,workshop,other',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'age_groups' => 'nullable|array',
            'max_participants' => 'nullable|integer|min:1',
            'registration_fee' => 'nullable|numeric|min:0',
            'registration_deadline' => 'nullable|date',
            'coordinator_id' => 'required|exists:users,id',
        ]);

        $validated['status'] = 'draft';
        $event = ChildrensEvent::create($validated);

        return redirect()
            ->route('childrens-ministry.events.show', $event)
            ->with('success', 'Event created successfully.');
    }

    /**
     * Update event.
     */
    public function updateEvent(Request $request, ChildrensEvent $event)
    {
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'age_groups' => 'nullable|array',
            'max_participants' => 'nullable|integer|min:1',
            'registration_fee' => 'nullable|numeric|min:0',
            'registration_deadline' => 'nullable|date',
        ]);

        $event->update($validated);

        return redirect()
            ->route('childrens-ministry.events.show', $event)
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Register child for event.
     */
    public function registerForEvent(Request $request, ChildrensEvent $event)
    {
        $validated = $request->validate([
            'child_id' => 'required|exists:children,id',
            'amount_paid' => 'nullable|numeric|min:0',
            'special_requirements' => 'nullable|string',
            'emergency_contact' => 'nullable|array',
        ]);

        try {
            $child = Child::findOrFail($validated['child_id']);
            $registration = $this->repository->registerChildForEvent($event, $child, $validated);

            return redirect()
                ->route('childrens-ministry.events.show', $event)
                ->with('success', "Child {$child->full_name} registered successfully.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Publish event.
     */
    public function publishEvent(ChildrensEvent $event)
    {
        $event->publish();

        return redirect()
            ->back()
            ->with('success', 'Event published successfully.');
    }

    /**
     * Start event.
     */
    public function startEvent(ChildrensEvent $event)
    {
        $event->start();

        return redirect()
            ->back()
            ->with('success', 'Event started successfully.');
    }

    /**
     * Complete event.
     */
    public function completeEvent(ChildrensEvent $event)
    {
        $event->complete();

        return redirect()
            ->back()
            ->with('success', 'Event completed successfully.');
    }

    /**
     * Delete event.
     */
    public function destroyEvent($event)
    {
        $event = ChildrensEvent::findOrFail($event);

        // Only allow deletion of draft, completed, or cancelled events
        if (!in_array($event->status, ['draft', 'completed', 'cancelled'])) {
            return redirect()->back()
                ->with('error', 'Only draft, completed, or cancelled events can be deleted. Events that are published or active should be cancelled first.');
        }

        // Check if there are registered participants
        $registeredCount = $event->registrations()->count();
        if ($registeredCount > 0) {
            return redirect()->back()
                ->with('error', "Cannot delete event with {$registeredCount} registered participant(s). Please cancel registrations first.");
        }

        $event->delete();

        return redirect()->route('childrens-ministry.events')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Display reports.
     */
    public function reports(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonths(3)->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $attendanceReport = $this->repository->getAttendanceReport($startDate, $endDate);

        return view('childrens-ministry.reports', compact('attendanceReport', 'startDate', 'endDate'));
    }
}
