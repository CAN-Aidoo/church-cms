<?php

namespace App\Repositories;

use App\Models\Attendance;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AttendanceRepository
{
    /**
     * Get paginated attendance records with filters.
     */
    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Attendance::with(['member']);

        // Apply member filter
        if (isset($filters['member_id']) && $filters['member_id']) {
            $query->where('member_id', $filters['member_id']);
        }

        // Apply service date range filter
        if (isset($filters['date_from'])) {
            $query->where('service_date', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to'])) {
            $query->where('service_date', '<=', $filters['date_to']);
        }

        // Apply service type filter
        if (isset($filters['service_type']) && $filters['service_type'] !== '') {
            $query->where('service_type', $filters['service_type']);
        }

        // Apply status filter
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        // Apply search filter
        if (isset($filters['search']) && $filters['search'] !== '') {
            $search = $filters['search'];
            $query->whereHas('member', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('member_id', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $sortBy = $filters['sort_by'] ?? 'service_date';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * Find attendance by ID.
     */
    public function findById(int $id): ?Attendance
    {
        return Attendance::with(['member'])->find($id);
    }

    /**
     * Create attendance record.
     */
    public function create(array $data): Attendance
    {
        return Attendance::create($data);
    }

    /**
     * Update attendance record.
     */
    public function update(Attendance $attendance, array $data): bool
    {
        return $attendance->update($data);
    }

    /**
     * Delete attendance record.
     */
    public function delete(Attendance $attendance): bool
    {
        return $attendance->delete();
    }

    /**
     * Bulk create attendance records.
     */
    public function bulkCreate(array $attendanceRecords): int
    {
        return DB::transaction(function () use ($attendanceRecords) {
            $created = 0;
            foreach ($attendanceRecords as $record) {
                // Check if record already exists (prevent duplicates)
                $exists = Attendance::where('member_id', $record['member_id'])
                    ->where('service_date', $record['service_date'])
                    ->where('service_type', $record['service_type'])
                    ->exists();

                if (! $exists) {
                    Attendance::create($record);
                    $created++;
                }
            }

            return $created;
        });
    }

    /**
     * Get attendance for specific service.
     */
    public function getByService(string $serviceDate, string $serviceType): Collection
    {
        return Attendance::with(['member'])
            ->where('service_date', $serviceDate)
            ->where('service_type', $serviceType)
            ->orderBy('member_id')
            ->get();
    }

    /**
     * Get attendance statistics.
     */
    public function getStatistics(array $filters = []): array
    {
        $query = Attendance::query();

        // Apply date range
        if (isset($filters['date_from'])) {
            $query->where('service_date', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to'])) {
            $query->where('service_date', '<=', $filters['date_to']);
        }

        $total = (clone $query)->count();
        $present = (clone $query)->where('status', 'present')->count();
        $absent = (clone $query)->where('status', 'absent')->count();
        $excused = (clone $query)->where('status', 'excused')->count();
        $late = (clone $query)->where('status', 'late')->count();

        return [
            'total_records' => $total,
            'present_count' => $present,
            'absent_count' => $absent,
            'excused_count' => $excused,
            'late_count' => $late,
            'attendance_rate' => $total > 0 ? round(($present / $total) * 100, 2) : 0,
        ];
    }

    /**
     * Get attendance by date range.
     */
    public function getByDateRange(Carbon $startDate, Carbon $endDate): Collection
    {
        return Attendance::with(['member'])
            ->whereBetween('service_date', [$startDate, $endDate])
            ->orderBy('service_date', 'desc')
            ->get();
    }

    /**
     * Get member attendance history.
     */
    public function getMemberHistory(int $memberId, int $limit = 10): Collection
    {
        return Attendance::where('member_id', $memberId)
            ->orderBy('service_date', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get service attendance summary.
     */
    public function getServiceSummary(string $serviceDate, string $serviceType): array
    {
        $attendance = Attendance::where('service_date', $serviceDate)
            ->where('service_type', $serviceType)
            ->get();

        $total = $attendance->count();
        $present = $attendance->where('status', 'present')->count();
        $absent = $attendance->where('status', 'absent')->count();
        $excused = $attendance->where('status', 'excused')->count();
        $late = $attendance->where('status', 'late')->count();

        return [
            'service_date' => $serviceDate,
            'service_type' => $serviceType,
            'total_marked' => $total,
            'present' => $present,
            'absent' => $absent,
            'excused' => $excused,
            'late' => $late,
            'attendance_rate' => $total > 0 ? round(($present / $total) * 100, 2) : 0,
        ];
    }

    /**
     * Get members with consecutive absences.
     */
    public function getMembersWithConsecutiveAbsences(int $consecutiveAbsences = 2): array
    {
        $members = [];
        $allMembers = Member::active()->get();

        foreach ($allMembers as $member) {
            $recentAttendance = Attendance::where('member_id', $member->id)
                ->orderBy('service_date', 'desc')
                ->limit($consecutiveAbsences)
                ->pluck('status')
                ->toArray();

            // Check if all recent records are absent
            if (count($recentAttendance) >= $consecutiveAbsences &&
                count(array_filter($recentAttendance, fn ($s) => $s === 'absent')) === $consecutiveAbsences) {
                $members[] = [
                    'member' => $member,
                    'consecutive_absences' => $consecutiveAbsences,
                    'last_present' => Attendance::where('member_id', $member->id)
                        ->where('status', 'present')
                        ->orderBy('service_date', 'desc')
                        ->value('service_date'),
                ];
            }
        }

        return $members;
    }

    /**
     * Get attendance trends (last N weeks).
     */
    public function getTrends(int $weeks = 12): array
    {
        $trends = [];
        // Use current time as end point, look back $weeks
        for ($i = $weeks - 1; $i >= 0; $i--) {
            $weekStart = now()->subWeeks($i)->startOfWeek();
            $weekEnd = now()->subWeeks($i)->endOfWeek();

            // Using whereBetween on date string column might need care with time components if datetime, but service_date is date
            $weekAttendance = Attendance::whereBetween('service_date', [
                $weekStart->format('Y-m-d'),
                $weekEnd->format('Y-m-d')
            ])->get();

            $total = $weekAttendance->count();
            $present = $weekAttendance->where('status', 'present')->count();

            $trends[$weekStart->format('M d')] = [
                'total' => $total,
                'present' => $present,
                'rate' => $total > 0 ? round(($present / $total) * 100, 2) : 0,
            ];
        }

        return $trends;
    }

    /**
     * Get top attenders.
     */
    public function getTopAttenders(int $limit = 10, ?Carbon $startDate = null, ?Carbon $endDate = null): array
    {
        $query = Attendance::select('member_id', DB::raw('COUNT(*) as attendance_count'))
            ->where('status', 'present');

        if ($startDate) {
            $query->where('service_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('service_date', '<=', $endDate);
        }

        $results = $query->groupBy('member_id')
            ->orderByDesc('attendance_count')
            ->limit($limit)
            ->get();

        return $results->map(function ($item) {
            $member = Member::find($item->member_id);

            return [
                'member' => $member,
                'attendance_count' => $item->attendance_count,
            ];
        })->toArray();
    }

    /**
     * Get average attendance by service type.
     */
    public function getAverageByServiceType(?Carbon $startDate = null, ?Carbon $endDate = null): array
    {
        $query = Attendance::query();

        if ($startDate) {
            $query->where('service_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('service_date', '<=', $endDate);
        }

        $data = $query->select('service_type',
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_count')
        )
            ->groupBy('service_type')
            ->get();

        $result = [];
        foreach ($data as $item) {
            $result[$item->service_type] = [
                'total' => $item->total,
                'present' => $item->present_count,
                'rate' => $item->total > 0 ? round(($item->present_count / $item->total) * 100, 2) : 0,
            ];
        }

        return $result;
    }

    /**
     * Export attendance records.
     */
    public function export(array $filters = []): Collection
    {
        $query = Attendance::with(['member']);

        // Apply filters (same as getPaginated but without pagination)
        if (isset($filters['member_id']) && $filters['member_id']) {
            $query->where('member_id', $filters['member_id']);
        }

        if (isset($filters['date_from'])) {
            $query->where('service_date', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to'])) {
            $query->where('service_date', '<=', $filters['date_to']);
        }

        if (isset($filters['service_type']) && $filters['service_type'] !== '') {
            $query->where('service_type', $filters['service_type']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('service_date', 'desc')->get();
    }

    /**
     * Check if attendance exists for service.
     */
    public function existsForService(int $memberId, string $serviceDate, string $serviceType): bool
    {
        return Attendance::where('member_id', $memberId)
            ->where('service_date', $serviceDate)
            ->where('service_type', $serviceType)
            ->exists();
    }

    /**
     * Get unique service types.
     */
    public function getServiceTypes(): array
    {
        return Attendance::distinct()
            ->pluck('service_type')
            ->toArray();
    }
}