<?php

namespace App\Repositories;

use App\Models\DutyRoster;
use App\Models\Member;
use App\Models\ServiceUnit;
use App\Models\ServiceUnitMember;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ServiceUnitRepository
{
    /**
     * Get all service units with pagination.
     */
    public function getPaginated(int $perPage = 20): LengthAwarePaginator
    {
        return ServiceUnit::with(['leader', 'assistantLeader'])
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * Get active service units.
     */
    public function getActive(): Collection
    {
        return ServiceUnit::active()
            ->with(['leader', 'assistantLeader'])
            ->orderBy('name')
            ->get();
    }

    /**
     * Get service units by category.
     */
    public function getByCategory(string $category): Collection
    {
        return ServiceUnit::category($category)
            ->with(['leader', 'assistantLeader'])
            ->orderBy('name')
            ->get();
    }

    /**
     * Get service unit by ID with relationships.
     */
    public function findWithRelations(int $id): ?ServiceUnit
    {
        return ServiceUnit::with(['leader', 'assistantLeader', 'unitMembers.member', 'dutyRosters', 'meetings', 'trainings'])
            ->find($id);
    }

    /**
     * Create a new service unit.
     */
    public function create(array $data): ServiceUnit
    {
        return ServiceUnit::create($data);
    }

    /**
     * Update a service unit.
     */
    public function update(ServiceUnit $serviceUnit, array $data): bool
    {
        return $serviceUnit->update($data);
    }

    /**
     * Delete a service unit.
     */
    public function delete(ServiceUnit $serviceUnit): bool
    {
        return $serviceUnit->delete();
    }

    /**
     * Get service unit statistics.
     */
    public function getStatistics(): array
    {
        return [
            'total' => ServiceUnit::count(),
            'active' => ServiceUnit::where('status', 'active')->count(),
            'inactive' => ServiceUnit::where('status', 'inactive')->count(),
            'total_members' => ServiceUnitMember::where('status', 'active')->count(),
            'average_members_per_unit' => ServiceUnitMember::where('status', 'active')
                ->selectRaw('COUNT(*) / (SELECT COUNT(*) FROM service_units WHERE status = "active") as avg')
                ->value('avg') ?? 0,
        ];
    }

    /**
     * Get unit members for a service unit.
     */
    public function getUnitMembers(ServiceUnit $serviceUnit, ?string $status = 'active'): Collection
    {
        $query = $serviceUnit->unitMembers()->with('member');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('role', 'asc')
            ->orderBy('joined_date', 'asc')
            ->get();
    }

    /**
     * Add a member to a service unit.
     */
    public function addMember(ServiceUnit $serviceUnit, Member $member, array $data): ServiceUnitMember
    {
        $unitMember = ServiceUnitMember::create(array_merge($data, [
            'service_unit_id' => $serviceUnit->id,
            'member_id' => $member->id,
            'status' => 'active',
        ]));

        // Update current members count
        $serviceUnit->current_members = $serviceUnit->activeMembers()->count();
        $serviceUnit->save();

        return $unitMember;
    }

    /**
     * Remove a member from a service unit.
     */
    public function removeMember(ServiceUnitMember $unitMember): bool
    {
        $serviceUnit = $unitMember->serviceUnit;

        $unitMember->status = 'inactive';
        $unitMember->left_date = now();
        $unitMember->save();

        // Update current members count
        $serviceUnit->current_members = $serviceUnit->activeMembers()->count();
        $serviceUnit->save();

        return true;
    }

    /**
     * Get members not in any service unit.
     */
    public function getMembersWithoutUnit(): Collection
    {
        $membersInUnits = ServiceUnitMember::where('status', 'active')
            ->pluck('member_id')
            ->unique();

        return Member::where('member_status', 'active')
            ->whereNotIn('id', $membersInUnits)
            ->orderBy('first_name')
            ->get();
    }

    /**
     * Get duty rosters for a service unit.
     */
    public function getDutyRosters(ServiceUnit $serviceUnit, ?string $status = null): Collection
    {
        $query = $serviceUnit->dutyRosters()->with(['creator', 'assignments.member']);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('duty_date', 'desc')->get();
    }

    /**
     * Get upcoming duty rosters.
     */
    public function getUpcomingDutyRosters(ServiceUnit $serviceUnit): Collection
    {
        return $serviceUnit->dutyRosters()
            ->upcoming()
            ->with(['creator', 'assignments.member'])
            ->orderBy('duty_date', 'asc')
            ->get();
    }

    /**
     * Create a duty roster.
     */
    public function createDutyRoster(ServiceUnit $serviceUnit, array $data): DutyRoster
    {
        return DutyRoster::create(array_merge($data, [
            'service_unit_id' => $serviceUnit->id,
        ]));
    }

    /**
     * Get unit performance metrics.
     */
    public function getPerformanceMetrics(ServiceUnit $serviceUnit, Carbon $startDate, Carbon $endDate): array
    {
        $completedRosters = $serviceUnit->dutyRosters()
            ->where('status', 'completed')
            ->whereBetween('duty_date', [$startDate, $endDate])
            ->count();

        $totalRosters = $serviceUnit->dutyRosters()
            ->whereBetween('duty_date', [$startDate, $endDate])
            ->count();

        $completedMeetings = $serviceUnit->meetings()
            ->where('status', 'completed')
            ->whereBetween('meeting_date', [$startDate, $endDate])
            ->count();

        $averageAttendance = $serviceUnit->meetings()
            ->where('status', 'completed')
            ->whereBetween('meeting_date', [$startDate, $endDate])
            ->avg('attendance_count') ?? 0;

        $completedTrainings = $serviceUnit->trainings()
            ->where('status', 'completed')
            ->whereBetween('training_date', [$startDate, $endDate])
            ->count();

        return [
            'completed_rosters' => $completedRosters,
            'total_rosters' => $totalRosters,
            'completion_rate' => $totalRosters > 0 ? ($completedRosters / $totalRosters) * 100 : 0,
            'completed_meetings' => $completedMeetings,
            'average_meeting_attendance' => round($averageAttendance, 2),
            'completed_trainings' => $completedTrainings,
        ];
    }

    /**
     * Search service units.
     */
    public function search(string $query): Collection
    {
        return ServiceUnit::with(['leader', 'assistantLeader'])
            ->where('name', 'like', "%{$query}%")
            ->orWhere('code', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orderBy('name')
            ->get();
    }

    /**
     * Get units needing attention (below minimum members).
     */
    public function getNeedingAttention(): Collection
    {
        return ServiceUnit::active()
            ->with(['leader', 'assistantLeader'])
            ->get()
            ->filter(function ($unit) {
                return ! $unit->meetsMinimumRequirement();
            });
    }

    /**
     * Get units with upcoming duties (next 7 days).
     */
    public function getUnitsWithUpcomingDuties(): Collection
    {
        $sevenDaysFromNow = now()->addDays(7)->toDateString();

        return ServiceUnit::active()
            ->with(['leader'])
            ->whereHas('dutyRosters', function ($query) use ($sevenDaysFromNow) {
                $query->where('duty_date', '>=', now()->toDateString())
                    ->where('duty_date', '<=', $sevenDaysFromNow)
                    ->where('status', '!=', 'cancelled');
            })
            ->get();
    }

    /**
     * Count all service units.
     */
    public function countAll(): int
    {
        return ServiceUnit::count();
    }

    /**
     * Count service units by status.
     */
    public function countByStatus(string $status): int
    {
        return ServiceUnit::where('status', $status)->count();
    }

    /**
     * Count service units by category.
     */
    public function countByCategory(string $category): int
    {
        return ServiceUnit::where('category', $category)->count();
    }
}
