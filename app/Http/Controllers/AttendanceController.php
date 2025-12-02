<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Member;
use App\Repositories\AttendanceRepository;
use App\Services\AttendanceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AttendanceController extends Controller
{
    public function __construct(
        protected AttendanceRepository $attendanceRepository,
        protected AttendanceService $attendanceService
    ) {}

    /**
     * Display attendance list.
     */
    public function index(Request $request)
    {
        $filters = $request->only([
            'member_id', 'date_from', 'date_to', 'service_type',
            'status', 'search', 'sort_by', 'sort_order',
        ]);

        $perPage = $request->input('per_page', 15);
        $attendance = $this->attendanceRepository->getPaginated($filters, $perPage);

        // Get statistics for the filtered data
        $statistics = $this->attendanceRepository->getStatistics($filters);

        // Get service types for filter dropdown
        $serviceTypes = $this->attendanceRepository->getServiceTypes();

        return view('attendance.index', compact(
            'attendance',
            'statistics',
            'serviceTypes',
            'filters'
        ));
    }

    /**
     * Show form to mark attendance.
     */
    public function create(Request $request)
    {
        // Pre-select member if provided
        $memberId = $request->input('member_id');
        $member = $memberId ? Member::find($memberId) : null;

        return view('attendance.create', compact('member'));
    }

    /**
     * Show bulk attendance marking interface.
     */
    public function mark(Request $request)
    {
        // Get service date and type from request or use defaults
        $serviceDate = $request->input('service_date', now()->format('Y-m-d'));
        $serviceType = $request->input('service_type', 'sunday_first');

        // Get all active members
        $members = Member::active()->orderBy('first_name')->get();

        // Get existing attendance for this service (if any)
        $existingAttendance = $this->attendanceRepository->getByService($serviceDate, $serviceType);

        return view('attendance.mark', compact(
            'members',
            'serviceDate',
            'serviceType',
            'existingAttendance'
        ));
    }

    /**
     * Store attendance record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'service_date' => 'required|date',
            'service_type' => ['required', Rule::in(['sunday_first', 'sunday_second', 'midweek', 'prayer_meeting', 'special'])],
            'status' => ['required', Rule::in(['present', 'absent', 'excused', 'late'])],
            'notes' => 'nullable|string',
        ]);

        $validated['recorded_by'] = Auth::id();
        $validated['recorded_at'] = now();

        try {
            $attendance = $this->attendanceService->markAttendance($validated);

            return redirect()
                ->route('attendance.index')
                ->with('success', 'Attendance marked successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Store bulk attendance records.
     */
    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'service_date' => 'required|date',
            'service_type' => ['required', Rule::in(['sunday_first', 'sunday_second', 'midweek', 'prayer_meeting', 'special'])],
            'attendance' => 'required|array',
            'attendance.*.member_id' => 'required|exists:members,id',
            'attendance.*.status' => ['required', Rule::in(['present', 'absent', 'excused', 'late'])],
            'attendance.*.notes' => 'nullable|string',
        ]);

        $serviceDate = $validated['service_date'];
        $serviceType = $validated['service_type'];
        $recordedBy = Auth::id();

        $attendanceRecords = array_map(function ($record) use ($serviceDate, $serviceType, $recordedBy) {
            return [
                'member_id' => $record['member_id'],
                'service_date' => $serviceDate,
                'service_type' => $serviceType,
                'status' => $record['status'],
                'notes' => $record['notes'] ?? null,
                'recorded_by' => $recordedBy,
                'recorded_at' => now(),
            ];
        }, $validated['attendance']);

        $results = $this->attendanceService->bulkMarkAttendance($attendanceRecords);

        if ($results['created'] > 0) {
            $message = "{$results['created']} attendance record(s) marked successfully.";
            if ($results['skipped'] > 0) {
                $message .= " {$results['skipped']} record(s) were skipped (already exists).";
            }

            return redirect()
                ->route('attendance.index')
                ->with('success', $message);
        }

        return redirect()
            ->back()
            ->with('error', 'Failed to mark attendance.')
            ->withInput();
    }

    /**
     * Show attendance record.
     */
    public function show(Attendance $attendance)
    {
        $attendance->load(['member']);

        return view('attendance.show', compact('attendance'));
    }

    /**
     * Show edit form.
     */
    public function edit(Attendance $attendance)
    {
        return view('attendance.edit', compact('attendance'));
    }

    /**
     * Update attendance record.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'service_date' => 'required|date',
            'service_type' => ['required', Rule::in(['sunday_first', 'sunday_second', 'midweek', 'prayer_meeting', 'special'])],
            'status' => ['required', Rule::in(['present', 'absent', 'excused', 'late'])],
            'notes' => 'nullable|string',
        ]);

        $this->attendanceRepository->update($attendance, $validated);

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Attendance updated successfully.');
    }

    /**
     * Delete attendance record.
     */
    public function destroy(Attendance $attendance)
    {
        // Only admin and pastor can delete
        if (! Auth::user()->hasAnyRole(['admin', 'pastor'])) {
            abort(403, 'You do not have permission to delete attendance records.');
        }

        $this->attendanceRepository->delete($attendance);

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Attendance record deleted successfully.');
    }

    /**
     * Show attendance reports.
     */
    public function reports(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->endOfMonth()->format('Y-m-d'));

        $filters = [
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
        ];

        // Get comprehensive statistics
        $statistics = $this->attendanceService->getAttendanceStatistics(
            Carbon::parse($dateFrom),
            Carbon::parse($dateTo)
        );

        // Get service type analysis
        $serviceTypeAnalysis = $this->attendanceService->getServiceTypeAnalysis(
            Carbon::parse($dateFrom),
            Carbon::parse($dateTo)
        );

        // Get attendance trends (last 12 weeks)
        $trends = $this->attendanceService->getAttendanceTrends(12);

        // Get top attenders
        $topAttenders = $this->attendanceService->getTopAttenders(
            10,
            Carbon::parse($dateFrom),
            Carbon::parse($dateTo)
        );

        // Get members needing follow-up (2+ consecutive absences)
        $membersNeedingFollowUp = $this->attendanceService->getMembersNeedingFollowUp(2);

        // Get inactive members (30+ days)
        $inactiveMembers = $this->attendanceService->getInactiveMembers(30);

        return view('attendance.reports', compact(
            'statistics',
            'serviceTypeAnalysis',
            'trends',
            'topAttenders',
            'membersNeedingFollowUp',
            'inactiveMembers',
            'filters'
        ));
    }

    /**
     * Export attendance to CSV.
     */
    public function export(Request $request)
    {
        $filters = $request->only([
            'member_id', 'date_from', 'date_to', 'service_type', 'status',
        ]);

        $attendance = $this->attendanceRepository->export($filters);

        $filename = 'attendance_'.date('Y-m-d_His').'.csv';
        $handle = fopen('php://output', 'w');

        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');

        // Add CSV header
        fputcsv($handle, [
            'Member ID', 'Member Name', 'Service Date', 'Service Type',
            'Status', 'Notes', 'Recorded By', 'Recorded At',
        ]);

        // Add attendance data
        foreach ($attendance as $record) {
            fputcsv($handle, [
                $record->member->member_id,
                $record->member->full_name,
                $record->service_date->format('Y-m-d'),
                ucfirst(str_replace('_', ' ', $record->service_type)),
                ucfirst($record->status),
                $record->notes,
                $record->recorder?->full_name ?? 'N/A',
                $record->recorded_at->format('Y-m-d H:i:s'),
            ]);
        }

        fclose($handle);
        exit;
    }

    /**
     * Show attendance leaderboard.
     */
    public function leaderboard(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->endOfMonth()->format('Y-m-d'));

        $leaderboard = $this->attendanceService->getAttendanceLeaderboard(
            Carbon::parse($dateFrom),
            Carbon::parse($dateTo),
            50
        );

        return view('attendance.leaderboard', compact('leaderboard', 'dateFrom', 'dateTo'));
    }
}
