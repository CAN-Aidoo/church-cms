<?php

namespace App\Repositories;

use App\Models\Member;
use App\Models\Shepherd;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ShepherdRepository
{
    /**
     * Get all shepherds with pagination.
     */
    public function getPaginated(int $perPage = 20): LengthAwarePaginator
    {
        return Shepherd::with('member')
            ->orderBy('flock_name')
            ->paginate($perPage);
    }

    /**
     * Get active shepherds.
     */
    public function getActive(): Collection
    {
        return Shepherd::active()
            ->with('member')
            ->orderBy('flock_name')
            ->get();
    }

    /**
     * Get shepherds with available capacity.
     */
    public function getWithCapacity(): Collection
    {
        return Shepherd::active()
            ->hasCapacity()
            ->with('member')
            ->orderBy('current_flock_size', 'asc')
            ->get();
    }

    /**
     * Get shepherd by ID with relationships.
     */
    public function findWithRelations(int $id): ?Shepherd
    {
        return Shepherd::with(['member', 'flockMembers', 'meetings', 'visitations', 'reports'])
            ->find($id);
    }

    /**
     * Create a new shepherd.
     */
    public function create(array $data): Shepherd
    {
        return Shepherd::create($data);
    }

    /**
     * Update a shepherd.
     */
    public function update(Shepherd $shepherd, array $data): bool
    {
        return $shepherd->update($data);
    }

    /**
     * Delete a shepherd.
     */
    public function delete(Shepherd $shepherd): bool
    {
        return $shepherd->delete();
    }

    /**
     * Get shepherd statistics.
     */
    public function getStatistics(): array
    {
        return [
            'total' => Shepherd::count(),
            'active' => Shepherd::where('status', 'active')->count(),
            'inactive' => Shepherd::where('status', 'inactive')->count(),
            'on_leave' => Shepherd::where('status', 'on_leave')->count(),
            'average_flock_size' => Shepherd::active()->avg('current_flock_size') ?? 0,
            'total_flock_members' => Shepherd::active()->sum('current_flock_size'),
            'shepherds_at_capacity' => Shepherd::active()->whereColumn('current_flock_size', '>=', 'max_flock_size')->count(),
        ];
    }

    /**
     * Get flock members for a shepherd.
     */
    public function getFlockMembers(Shepherd $shepherd): Collection
    {
        return $shepherd->flockMembers()
            ->with('user')
            ->orderBy('first_name')
            ->get();
    }

    /**
     * Assign a member to a shepherd.
     */
    public function assignMember(Shepherd $shepherd, Member $member): bool
    {
        if (! $shepherd->hasCapacity()) {
            return false;
        }

        $member->shepherd_id = $shepherd->id;
        $member->save();

        // Update shepherd's current flock size
        $shepherd->current_flock_size = $shepherd->flockMembers()->count();
        $shepherd->save();

        return true;
    }

    /**
     * Unassign a member from a shepherd.
     */
    public function unassignMember(Member $member): bool
    {
        $shepherd = $member->shepherd;

        $member->shepherd_id = null;
        $member->save();

        if ($shepherd) {
            // Update shepherd's current flock size
            $shepherd->current_flock_size = $shepherd->flockMembers()->count();
            $shepherd->save();
        }

        return true;
    }

    /**
     * Get members without a shepherd.
     */
    public function getMembersWithoutShepherd(): Collection
    {
        return Member::whereNull('shepherd_id')
            ->where('member_status', 'active')
            ->orderBy('first_name')
            ->get();
    }

    /**
     * Auto-assign members to shepherds based on capacity.
     */
    public function autoAssignMembers(): array
    {
        $membersWithoutShepherd = $this->getMembersWithoutShepherd();
        $shepherdsWithCapacity = $this->getWithCapacity();

        $assigned = 0;
        $failed = 0;

        foreach ($membersWithoutShepherd as $member) {
            // Find shepherd with most capacity
            $shepherd = $shepherdsWithCapacity->sortByDesc('available_capacity')->first();

            if ($shepherd && $shepherd->hasCapacity()) {
                if ($this->assignMember($shepherd, $member)) {
                    $assigned++;

                    // Refresh shepherd capacity
                    $shepherd->refresh();
                } else {
                    $failed++;
                }
            } else {
                $failed++;
            }
        }

        return [
            'assigned' => $assigned,
            'failed' => $failed,
            'total' => $membersWithoutShepherd->count(),
        ];
    }

    /**
     * Get flock meetings for a shepherd.
     */
    public function getMeetings(Shepherd $shepherd, ?string $status = null): Collection
    {
        $query = $shepherd->meetings()->with('recorder');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('meeting_date', 'desc')->get();
    }

    /**
     * Get upcoming meetings for a shepherd.
     */
    public function getUpcomingMeetings(Shepherd $shepherd): Collection
    {
        return $shepherd->meetings()
            ->upcoming()
            ->with('recorder')
            ->orderBy('meeting_date', 'asc')
            ->get();
    }

    /**
     * Get member visitations for a shepherd.
     */
    public function getVisitations(Shepherd $shepherd, ?string $status = null): Collection
    {
        $query = $shepherd->visitations()->with('member');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('visit_date', 'desc')->get();
    }

    /**
     * Get visitations requiring follow-up.
     */
    public function getVisitationsRequiringFollowUp(Shepherd $shepherd): Collection
    {
        return $shepherd->visitations()
            ->requiresFollowUp()
            ->with('member')
            ->orderBy('follow_up_date', 'asc')
            ->get();
    }

    /**
     * Get shepherd reports.
     */
    public function getReports(Shepherd $shepherd, ?string $period = null): Collection
    {
        $query = $shepherd->reports()->with('reviewer');

        if ($period) {
            $query->where('report_period', $period);
        }

        return $query->orderBy('report_date', 'desc')->get();
    }

    /**
     * Get shepherd performance metrics.
     */
    public function getPerformanceMetrics(Shepherd $shepherd, Carbon $startDate, Carbon $endDate): array
    {
        $visitations = $shepherd->visitations()
            ->completed()
            ->whereBetween('visit_date', [$startDate, $endDate])
            ->count();

        $meetings = $shepherd->meetings()
            ->completed()
            ->whereBetween('meeting_date', [$startDate, $endDate])
            ->count();

        $reports = $shepherd->reports()
            ->submitted()
            ->whereBetween('report_date', [$startDate, $endDate])
            ->count();

        $averageAttendance = $shepherd->meetings()
            ->completed()
            ->whereBetween('meeting_date', [$startDate, $endDate])
            ->avg('attendance_count') ?? 0;

        return [
            'visitations' => $visitations,
            'meetings' => $meetings,
            'reports_submitted' => $reports,
            'average_meeting_attendance' => round($averageAttendance, 2),
            'visitations_per_member' => $shepherd->current_flock_size > 0
                ? round($visitations / $shepherd->current_flock_size, 2)
                : 0,
            'meetings_per_month' => round($meetings / max(1, $startDate->diffInMonths($endDate)), 2),
        ];
    }

    /**
     * Get all shepherds with performance data.
     */
    public function getShepherdsWithPerformance(Carbon $startDate, Carbon $endDate): Collection
    {
        return Shepherd::active()
            ->with('member')
            ->get()
            ->map(function ($shepherd) use ($startDate, $endDate) {
                $shepherd->performance = $this->getPerformanceMetrics($shepherd, $startDate, $endDate);

                return $shepherd;
            });
    }

    /**
     * Search shepherds.
     */
    public function search(string $query): Collection
    {
        return Shepherd::with('member')
            ->where('flock_name', 'like', "%{$query}%")
            ->orWhereHas('member', function ($q) use ($query) {
                $q->where('first_name', 'like', "%{$query}%")
                    ->orWhere('last_name', 'like', "%{$query}%");
            })
            ->orderBy('flock_name')
            ->get();
    }

    /**
     * Get shepherds needing attention (low activity).
     */
    public function getNeedingAttention(): Collection
    {
        $thirtyDaysAgo = now()->subDays(30);

        return Shepherd::active()
            ->with('member')
            ->get()
            ->filter(function ($shepherd) use ($thirtyDaysAgo) {
                $recentVisitations = $shepherd->visitations()
                    ->where('visit_date', '>=', $thirtyDaysAgo)
                    ->completed()
                    ->count();

                $recentMeetings = $shepherd->meetings()
                    ->where('meeting_date', '>=', $thirtyDaysAgo)
                    ->completed()
                    ->count();

                // Flag if less than 1 visitation per member or less than 1 meeting in 30 days
                return $recentVisitations < $shepherd->current_flock_size || $recentMeetings < 1;
            });
    }

    /**
     * Count all shepherds.
     */
    public function countAll(): int
    {
        return Shepherd::count();
    }

    /**
     * Count shepherds by status.
     */
    public function countByStatus(string $status): int
    {
        return Shepherd::where('status', $status)->count();
    }
}
