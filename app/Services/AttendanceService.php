<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Member;
use App\Repositories\AttendanceRepository;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    public function __construct(
        protected AttendanceRepository $attendanceRepository
    ) {}

    /**
     * Mark attendance for a member.
     */
    public function markAttendance(array $data): Attendance
    {
        return Attendance::updateOrCreate(
            [
                'member_id' => $data['member_id'],
                'service_date' => $data['service_date'],
                'service_type' => $data['service_type'],
            ],
            [
                'status' => $data['status'],
                'notes' => $data['notes'] ?? null,
                'recorded_by' => $data['recorded_by'],
                'recorded_at' => now(),
            ]
        );
    }

    /**
     * Bulk mark attendance for multiple members.
     */
    public function bulkMarkAttendance(array $records): array
    {
        $created = 0;
        $failed = 0;
        $errors = [];

        DB::transaction(function () use ($records, &$created, &$failed, &$errors) {
            foreach ($records as $record) {
                try {
                    $this->markAttendance($record);
                    $created++;
                } catch (\Exception $e) {
                    $failed++;
                    $errors[] = [
                        'member_id' => $record['member_id'],
                        'error' => $e->getMessage(),
                    ];
                }
            }
        });

        return [
            'created' => $created,
            'failed' => $failed,
            'errors' => $errors,
        ];
    }

    /**
     * Get attendance statistics for a period.
     */
    public function getAttendanceStatistics($startDate, $endDate): array
    {
        $totalServices = Attendance::dateRange($startDate, $endDate)
            ->select('service_date', 'service_type')
            ->distinct()
            ->count();

        $totalAttendanceRecords = Attendance::dateRange($startDate, $endDate)->count();

        $presentCount = Attendance::dateRange($startDate, $endDate)
            ->where('status', 'present')
            ->count();

        $absentCount = Attendance::dateRange($startDate, $endDate)
            ->where('status', 'absent')
            ->count();

        $averageAttendance = $totalServices > 0
            ? round($presentCount / $totalServices, 2)
            : 0;

        return [
            'total_services' => $totalServices,
            'total_records' => $totalAttendanceRecords,
            'present_count' => $presentCount,
            'absent_count' => $absentCount,
            'average_attendance' => $averageAttendance,
            'attendance_rate' => $totalAttendanceRecords > 0
                ? round(($presentCount / $totalAttendanceRecords) * 100, 2)
                : 0,
        ];
    }

    /**
     * Get attendance by service type.
     */
    public function getAttendanceByServiceType($startDate, $endDate): array
    {
        return Attendance::dateRange($startDate, $endDate)
            ->selectRaw('service_type, COUNT(*) as total,
                        SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_count')
            ->groupBy('service_type')
            ->get()
            ->map(function ($item) {
                $item->attendance_rate = $item->total > 0
                    ? round(($item->present_count / $item->total) * 100, 2)
                    : 0;

                return $item;
            })
            ->toArray();
    }

    /**
     * Get weekly attendance trend.
     */
    public function getWeeklyTrend(int $weeks = 12): array
    {
        $startDate = now()->subWeeks($weeks)->startOfWeek();

        return Attendance::where('service_date', '>=', $startDate)
            ->selectRaw('YEARWEEK(service_date) as week')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_count')
            ->groupBy('week')
            ->orderBy('week')
            ->get()
            ->map(function ($item) {
                $item->attendance_rate = $item->total > 0
                    ? round(($item->present_count / $item->total) * 100, 2)
                    : 0;

                return $item;
            })
            ->toArray();
    }

    /**
     * Get members with consecutive absences.
     */
    public function getMembersWithConsecutiveAbsences(int $consecutiveAbsences = 3): array
    {
        $members = Member::active()
            ->with(['attendance' => function ($query) {
                $query->orderBy('service_date', 'desc')->limit(10);
            }])
            ->get();

        $result = [];

        foreach ($members as $member) {
            $absenceStreak = 0;
            $lastAbsenceDate = null;

            foreach ($member->attendance as $attendance) {
                if ($attendance->status === 'absent') {
                    $absenceStreak++;
                    $lastAbsenceDate = $attendance->service_date;
                } else {
                    break;
                }
            }

            if ($absenceStreak >= $consecutiveAbsences) {
                $result[] = [
                    'member' => [
                        'id' => $member->id,
                        'name' => $member->full_name,
                        'phone' => $member->phone,
                        'email' => $member->email,
                    ],
                    'absence_streak' => $absenceStreak,
                    'last_absence_date' => $lastAbsenceDate,
                    'requires_follow_up' => $absenceStreak >= 3,
                ];
            }
        }

        return $result;
    }

    /**
     * Get member attendance report.
     */
    public function getMemberAttendanceReport(Member $member, $startDate = null, $endDate = null): array
    {
        $query = $member->attendance();

        if ($startDate && $endDate) {
            $query->dateRange($startDate, $endDate);
        } else {
            // Default to last 6 months
            $query->where('service_date', '>=', now()->subMonths(6));
        }

        $attendanceRecords = $query->orderBy('service_date', 'desc')->get();

        $totalServices = $attendanceRecords->count();
        $presentCount = $attendanceRecords->where('status', 'present')->count();
        $absentCount = $attendanceRecords->where('status', 'absent')->count();
        $excusedCount = $attendanceRecords->where('status', 'excused')->count();

        return [
            'member' => [
                'id' => $member->id,
                'name' => $member->full_name,
            ],
            'statistics' => [
                'total_services' => $totalServices,
                'present_count' => $presentCount,
                'absent_count' => $absentCount,
                'excused_count' => $excusedCount,
                'attendance_percentage' => $totalServices > 0
                    ? round(($presentCount / $totalServices) * 100, 2)
                    : 0,
            ],
            'records' => $attendanceRecords->toArray(),
        ];
    }

    /**
     * Get attendance leaderboard (most consistent members).
     */
    public function getAttendanceLeaderboard(int $limit = 10, $startDate = null, $endDate = null): array
    {
        $query = Member::active()
            ->withCount(['attendance as total_services' => function ($q) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $q->dateRange($startDate, $endDate);
                }
            }])
            ->withCount(['attendance as present_count' => function ($q) use ($startDate, $endDate) {
                $q->where('status', 'present');
                if ($startDate && $endDate) {
                    $q->dateRange($startDate, $endDate);
                }
            }])
            ->having('total_services', '>', 0)
            ->orderByRaw('(present_count / total_services) DESC')
            ->limit($limit);

        return $query->get()->map(function ($member) {
            return [
                'member' => [
                    'id' => $member->id,
                    'name' => $member->full_name,
                ],
                'total_services' => $member->total_services,
                'present_count' => $member->present_count,
                'attendance_percentage' => $member->total_services > 0
                    ? round(($member->present_count / $member->total_services) * 100, 2)
                    : 0,
            ];
        })->toArray();
    }
}
