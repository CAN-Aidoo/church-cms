<?php

namespace App\Repositories;

use App\Models\Child;
use App\Models\ChildrenCheckin;
use App\Models\ChildrensEvent;
use App\Models\ChildrensEventRegistration;
use App\Models\ChildrensMinistryTeacher;
use App\Models\CurriculumLesson;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ChildrensMinistryRepository
{
    /**
     * Get all children with filters.
     */
    public function getChildren(array $filters = [])
    {
        $query = Child::with('family')->active();

        if (isset($filters['age_group'])) {
            $query->byAgeGroup($filters['age_group']);
        }

        if (isset($filters['search'])) {
            $query->search($filters['search']);
        }

        if (isset($filters['birthday_month'])) {
            $query->birthdayMonth($filters['birthday_month']);
        }

        return $query->orderBy('first_name')->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Check in child.
     */
    public function checkInChild(Child $child, array $data): ChildrenCheckin
    {
        return ChildrenCheckin::create([
            'child_id' => $child->id,
            'service_id' => $data['service_id'] ?? null,
            'checkin_date' => $data['checkin_date'] ?? today(),
            'checkin_time' => $data['checkin_time'] ?? now()->format('H:i:s'),
            'classroom_assigned' => $data['classroom_assigned'] ?? $child->age_group,
            'checked_in_by' => auth()->id(),
            'status' => 'checked_in',
            'notes' => $data['notes'] ?? null,
        ]);
    }

    /**
     * Check out child.
     */
    public function checkOutChild(ChildrenCheckin $checkin, string $authorizedPerson): ChildrenCheckin
    {
        // Verify authorized person
        if (! $checkin->child->isAuthorizedForPickup($authorizedPerson)) {
            throw new \Exception('Person not authorized to pick up this child.');
        }

        return $checkin->checkOut($authorizedPerson);
    }

    /**
     * Get today's check-ins.
     */
    public function getTodaysCheckins(array $filters = [])
    {
        $query = ChildrenCheckin::with(['child', 'checkedInBy'])
            ->today();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['classroom'])) {
            $query->byClassroom($filters['classroom']);
        }

        return $query->orderBy('checkin_time', 'desc')->get();
    }

    /**
     * Get check-in statistics.
     */
    public function getCheckinStatistics($date = null): array
    {
        $date = $date ?? today();

        $checkins = ChildrenCheckin::byDate($date)->get();

        return [
            'total_checkins' => $checkins->count(),
            'currently_checked_in' => $checkins->where('status', 'checked_in')->count(),
            'checked_out' => $checkins->where('status', 'checked_out')->count(),
            'by_classroom' => $checkins->groupBy('classroom_assigned')->map->count(),
            'late_pickups' => $checkins->filter->isLatePickup()->count(),
        ];
    }

    /**
     * Get curriculum lessons.
     */
    public function getCurriculumLessons(array $filters = [])
    {
        $query = CurriculumLesson::with('creator');

        if (isset($filters['age_group'])) {
            $query->byAgeGroup($filters['age_group']);
        }

        if (isset($filters['series'])) {
            $query->bySeries($filters['series']);
        }

        if (isset($filters['published'])) {
            $query->where('is_published', $filters['published']);
        }

        if (isset($filters['search'])) {
            $query->search($filters['search']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Create curriculum lesson.
     */
    public function createCurriculumLesson(array $data): CurriculumLesson
    {
        $data['created_by'] = $data['created_by'] ?? auth()->id();

        return CurriculumLesson::create($data);
    }

    /**
     * Get teachers.
     */
    public function getTeachers(array $filters = [])
    {
        $query = ChildrensMinistryTeacher::with('user')->active();

        if (isset($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        if (isset($filters['age_group'])) {
            $query->certifiedFor($filters['age_group']);
        }

        if (isset($filters['background_check_expiring'])) {
            $query->expiringBackgroundCheck($filters['background_check_expiring']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Get available teachers for age group.
     */
    public function getAvailableTeachers(string $ageGroup, $date = null): Collection
    {
        return ChildrensMinistryTeacher::with('user')
            ->active()
            ->validBackgroundCheck()
            ->certifiedFor($ageGroup)
            ->get();
    }

    /**
     * Get events.
     */
    public function getEvents(array $filters = [])
    {
        $query = ChildrensEvent::with(['coordinator', 'registrations']);

        if (isset($filters['event_type'])) {
            $query->byType($filters['event_type']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['upcoming'])) {
            $query->upcoming();
        }

        return $query->orderBy('start_date', 'desc')->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Register child for event.
     */
    public function registerChildForEvent(ChildrensEvent $event, Child $child, array $data): ChildrensEventRegistration
    {
        if (! $event->isRegistrationOpen()) {
            throw new \Exception('Registration is not open for this event.');
        }

        $registration = ChildrensEventRegistration::create([
            'childrens_event_id' => $event->id,
            'child_id' => $child->id,
            'registration_date' => today(),
            'amount_paid' => $data['amount_paid'] ?? 0,
            'payment_status' => isset($data['amount_paid']) && $data['amount_paid'] >= $event->registration_fee ? 'paid' : 'unpaid',
            'special_requirements' => $data['special_requirements'] ?? null,
            'emergency_contact' => $data['emergency_contact'] ?? null,
            'status' => 'registered',
            'registered_by' => auth()->id(),
        ]);

        $event->incrementRegisteredCount();

        return $registration;
    }

    /**
     * Get dashboard statistics.
     */
    public function getDashboardStatistics(): array
    {
        $today = today();

        return [
            'total_children' => Child::active()->count(),
            'todays_checkins' => ChildrenCheckin::today()->count(),
            'currently_checked_in' => ChildrenCheckin::today()->checkedIn()->count(),
            'total_teachers' => ChildrensMinistryTeacher::active()->count(),
            'upcoming_events' => ChildrensEvent::upcoming()->count(),
            'expiring_background_checks' => ChildrensMinistryTeacher::expiringBackgroundCheck(30)->count(),
            'by_age_group' => [
                'nursery' => Child::active()->byAgeGroup('nursery')->count(),
                'toddlers' => Child::active()->byAgeGroup('toddlers')->count(),
                'beginners' => Child::active()->byAgeGroup('beginners')->count(),
                'primary' => Child::active()->byAgeGroup('primary')->count(),
                'junior_teens' => Child::active()->byAgeGroup('junior_teens')->count(),
                'senior_teens' => Child::active()->byAgeGroup('senior_teens')->count(),
            ],
        ];
    }

    /**
     * Get attendance report.
     */
    public function getAttendanceReport($startDate, $endDate): array
    {
        $checkins = ChildrenCheckin::whereBetween('checkin_date', [$startDate, $endDate])->get();

        return [
            'total_checkins' => $checkins->count(),
            'unique_children' => $checkins->unique('child_id')->count(),
            'by_date' => $checkins->groupBy(function ($item) {
                return $item->checkin_date->format('Y-m-d');
            })->map->count(),
            'by_classroom' => $checkins->groupBy('classroom_assigned')->map->count(),
            'average_per_day' => $checkins->count() / max(1, Carbon::parse($startDate)->diffInDays($endDate) + 1),
        ];
    }

    /**
     * Get child attendance history.
     */
    public function getChildAttendanceHistory(Child $child, int $months = 3): Collection
    {
        return ChildrenCheckin::where('child_id', $child->id)
            ->where('checkin_date', '>=', now()->subMonths($months))
            ->orderBy('checkin_date', 'desc')
            ->get();
    }

    /**
     * Get event registrations.
     */
    public function getEventRegistrations(ChildrensEvent $event, array $filters = [])
    {
        $query = ChildrensEventRegistration::with(['child', 'registeredBy'])
            ->where('childrens_event_id', $event->id);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        return $query->orderBy('registration_date', 'desc')->paginate($filters['per_page'] ?? 20);
    }
}
