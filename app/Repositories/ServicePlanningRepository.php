<?php

namespace App\Repositories;

use App\Models\Sermon;
use App\Models\ServiceResource;
use App\Models\ServiceSchedule;
use App\Models\ServiceVolunteer;
use App\Models\WorshipPlan;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ServicePlanningRepository
{
    /**
     * Get all service schedules with optional filters.
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = ServiceSchedule::with(['preacher', 'creator', 'worshipPlan', 'volunteers'])
            ->withCount('volunteers');

        // Apply filters
        if (! empty($filters['service_type'])) {
            $query->where('service_type', $filters['service_type']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['date_from'])) {
            $query->where('service_date', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->where('service_date', '<=', $filters['date_to']);
        }

        if (! empty($filters['preacher_id'])) {
            $query->where('preacher_id', $filters['preacher_id']);
        }

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%'.$filters['search'].'%')
                    ->orWhere('theme', 'like', '%'.$filters['search'].'%')
                    ->orWhere('sermon_title', 'like', '%'.$filters['search'].'%');
            });
        }

        return $query->orderBy('service_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(20);
    }

    /**
     * Get upcoming services.
     */
    public function getUpcoming(int $limit = 10): Collection
    {
        return ServiceSchedule::upcoming()
            ->with(['preacher', 'worshipPlan', 'volunteers'])
            ->withCount('volunteers')
            ->take($limit)
            ->get();
    }

    /**
     * Get today's services.
     */
    public function getToday(): Collection
    {
        return ServiceSchedule::today()
            ->with(['preacher', 'worshipPlan', 'volunteers'])
            ->get();
    }

    /**
     * Get this week's services.
     */
    public function getThisWeek(): Collection
    {
        return ServiceSchedule::thisWeek()
            ->with(['preacher', 'worshipPlan', 'volunteers'])
            ->get();
    }

    /**
     * Find service schedule by ID.
     */
    public function find(int $id): ?ServiceSchedule
    {
        return ServiceSchedule::with([
            'preacher',
            'creator',
            'worshipPlan.assignedMember',
            'volunteers.member',
            'resources',
            'announcements',
            'sermon',
            'feedback',
        ])
            ->withCount(['volunteers', 'feedback'])
            ->find($id);
    }

    /**
     * Create new service schedule.
     */
    public function create(array $data): ServiceSchedule
    {
        return ServiceSchedule::create($data);
    }

    /**
     * Update service schedule.
     */
    public function update(ServiceSchedule $service, array $data): bool
    {
        return $service->update($data);
    }

    /**
     * Delete service schedule.
     */
    public function delete(ServiceSchedule $service): bool
    {
        return $service->delete();
    }

    /**
     * Add worship plan item to service.
     */
    public function addWorshipPlanItem(ServiceSchedule $service, array $data): WorshipPlan
    {
        // Set order number if not provided
        if (! isset($data['order_number'])) {
            $maxOrder = $service->worshipPlan()->max('order_number') ?? 0;
            $data['order_number'] = $maxOrder + 1;
        }

        return $service->worshipPlan()->create($data);
    }

    /**
     * Update worship plan item.
     */
    public function updateWorshipPlanItem(WorshipPlan $item, array $data): bool
    {
        return $item->update($data);
    }

    /**
     * Delete worship plan item.
     */
    public function deleteWorshipPlanItem(WorshipPlan $item): bool
    {
        return $item->delete();
    }

    /**
     * Reorder worship plan items.
     */
    public function reorderWorshipPlan(ServiceSchedule $service, array $orderedIds): bool
    {
        foreach ($orderedIds as $index => $id) {
            WorshipPlan::where('id', $id)
                ->where('service_schedule_id', $service->id)
                ->update(['order_number' => $index + 1]);
        }

        return true;
    }

    /**
     * Assign volunteer to service.
     */
    public function assignVolunteer(ServiceSchedule $service, array $data): ServiceVolunteer
    {
        return $service->volunteers()->create($data);
    }

    /**
     * Update volunteer assignment.
     */
    public function updateVolunteer(ServiceVolunteer $volunteer, array $data): bool
    {
        return $volunteer->update($data);
    }

    /**
     * Remove volunteer from service.
     */
    public function removeVolunteer(ServiceVolunteer $volunteer): bool
    {
        return $volunteer->delete();
    }

    /**
     * Bulk assign volunteers from template.
     */
    public function bulkAssignVolunteers(ServiceSchedule $service, array $volunteers): int
    {
        $count = 0;
        foreach ($volunteers as $volunteerData) {
            $service->volunteers()->create($volunteerData);
            $count++;
        }

        return $count;
    }

    /**
     * Get available volunteers for a role.
     */
    public function getAvailableVolunteers(string $role, Carbon $serviceDate): Collection
    {
        // Get members in the service unit for this role
        // Exclude those already assigned to services on the same date
        return \App\Models\Member::whereHas('serviceUnits', function ($q) use ($role) {
            $q->where('name', 'like', '%'.$role.'%');
        })
            ->whereDoesntHave('serviceVolunteer', function ($q) use ($serviceDate) {
                $q->whereHas('serviceSchedule', function ($sq) use ($serviceDate) {
                    $sq->whereDate('service_date', $serviceDate);
                });
            })
            ->where('member_status', 'active')
            ->orderBy('first_name')
            ->get();
    }

    /**
     * Add resource to service.
     */
    public function addResource(ServiceSchedule $service, array $data): ServiceResource
    {
        return $service->resources()->create($data);
    }

    /**
     * Create or update sermon.
     */
    public function saveSermon(ServiceSchedule $service, array $data): Sermon
    {
        return $service->sermon()->updateOrCreate(
            ['service_schedule_id' => $service->id],
            $data
        );
    }

    /**
     * Get service statistics.
     */
    public function getStatistics(ServiceSchedule $service): array
    {
        return [
            'worship_items_count' => $service->worshipPlan()->count(),
            'volunteers_count' => $service->volunteers()->count(),
            'volunteers_confirmed' => $service->volunteers()->where('status', 'confirmed')->count(),
            'volunteers_pending' => $service->volunteers()->where('status', 'assigned')->count(),
            'resources_count' => $service->resources()->count(),
            'resources_confirmed' => $service->resources()->where('status', 'confirmed')->count(),
            'volunteer_completion_rate' => $service->volunteer_completion_rate,
            'attendance_rate' => $service->attendance_rate,
            'average_rating' => $service->average_rating,
            'feedback_count' => $service->feedback()->count(),
        ];
    }

    /**
     * Get volunteer statistics by role.
     */
    public function getVolunteerStatsByRole(ServiceSchedule $service): array
    {
        return $service->getVolunteersByRole();
    }

    /**
     * Get services summary for dashboard.
     */
    public function getDashboardSummary(): array
    {
        $today = Carbon::today();
        $thisWeek = ServiceSchedule::thisWeek()->get();
        $thisMonth = ServiceSchedule::whereBetween('service_date', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
        ])->get();

        return [
            'today_services' => ServiceSchedule::today()->count(),
            'this_week_services' => $thisWeek->count(),
            'this_month_services' => $thisMonth->count(),
            'pending_volunteers' => ServiceVolunteer::whereHas('serviceSchedule', function ($q) {
                $q->where('service_date', '>=', Carbon::today());
            })
                ->where('status', 'assigned')
                ->count(),
            'upcoming_count' => ServiceSchedule::upcoming()->count(),
            'avg_attendance_rate' => $thisMonth->avg('attendance_rate') ?? 0,
            'total_volunteers_this_month' => ServiceVolunteer::whereHas('serviceSchedule', function ($q) {
                $q->whereBetween('service_date', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth(),
                ]);
            })->count(),
        ];
    }

    /**
     * Get sermon library.
     */
    public function getSermons(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $query = Sermon::with(['preacher', 'serviceSchedule']);

        if (! empty($filters['preacher_id'])) {
            $query->where('preacher_id', $filters['preacher_id']);
        }

        if (! empty($filters['tag'])) {
            $query->withTag($filters['tag']);
        }

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%'.$filters['search'].'%')
                    ->orWhere('theme', 'like', '%'.$filters['search'].'%')
                    ->orWhere('sermon_text', 'like', '%'.$filters['search'].'%');
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get preachers with sermon counts.
     */
    public function getPreachersWithStats(): Collection
    {
        return \App\Models\Member::whereHas('sermons')
            ->withCount('sermons')
            ->orderBy('sermons_count', 'desc')
            ->get();
    }

    /**
     * Publish service (draft -> scheduled).
     */
    public function publish(ServiceSchedule $service): bool
    {
        return $service->schedule();
    }

    /**
     * Start service (scheduled -> in_progress).
     */
    public function start(ServiceSchedule $service): bool
    {
        return $service->start();
    }

    /**
     * Complete service (in_progress -> completed).
     */
    public function complete(ServiceSchedule $service): bool
    {
        return $service->complete();
    }

    /**
     * Cancel service.
     */
    public function cancel(ServiceSchedule $service): bool
    {
        return $service->cancel();
    }

    /**
     * Copy service schedule to a new date.
     */
    public function duplicateService(ServiceSchedule $service, Carbon $newDate): ServiceSchedule
    {
        $newService = $service->replicate();
        $newService->service_date = $newDate;
        $newService->status = 'draft';
        $newService->actual_attendance = null;
        $newService->save();

        // Copy worship plan
        foreach ($service->worshipPlan as $item) {
            $newItem = $item->replicate();
            $newItem->service_schedule_id = $newService->id;
            $newItem->save();
        }

        // Copy volunteer assignments
        foreach ($service->volunteers as $volunteer) {
            $newVolunteer = $volunteer->replicate();
            $newVolunteer->service_schedule_id = $newService->id;
            $newVolunteer->status = 'assigned';
            $newVolunteer->confirmed_at = null;
            $newVolunteer->save();
        }

        return $newService;
    }
}
