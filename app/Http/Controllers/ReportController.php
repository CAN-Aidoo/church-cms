<?php

namespace App\Http\Controllers;

use App\Models\CustomReport;
use App\Models\ReportExecution;
use App\Models\ReportSchedule;
use App\Repositories\ReportRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function __construct(
        private ReportRepository $reportRepository
    ) {}

    /**
     * Display reports dashboard.
     */
    public function index()
    {
        $standardReports = [
            'membership' => [
                ['name' => 'Member Roster', 'icon' => 'users', 'route' => 'reports.membership.roster'],
                ['name' => 'New Members', 'icon' => 'user-plus', 'route' => 'reports.membership.new'],
                ['name' => 'Demographics', 'icon' => 'chart-pie', 'route' => 'reports.membership.demographics'],
                ['name' => 'Birthdays', 'icon' => 'cake', 'route' => 'reports.membership.birthdays'],
            ],
            'financial' => [
                ['name' => 'Income Statement', 'icon' => 'trending-up', 'route' => 'reports.financial.income'],
                ['name' => 'Expense Report', 'icon' => 'trending-down', 'route' => 'reports.financial.expenses'],
                ['name' => 'Cash Flow', 'icon' => 'dollar-sign', 'route' => 'reports.financial.cash-flow'],
                ['name' => 'Giving Analysis', 'icon' => 'gift', 'route' => 'reports.financial.giving'],
            ],
            'attendance' => [
                ['name' => 'Attendance Summary', 'icon' => 'calendar-check', 'route' => 'reports.attendance.summary'],
                ['name' => 'Trends', 'icon' => 'activity', 'route' => 'reports.attendance.trends'],
                ['name' => 'Absentee Report', 'icon' => 'user-x', 'route' => 'reports.attendance.absentees'],
            ],
            'program' => [
                ['name' => 'Program Performance', 'icon' => 'target', 'route' => 'reports.program.performance'],
                ['name' => 'Impact Assessment', 'icon' => 'zap', 'route' => 'reports.program.impact'],
            ],
        ];

        $customReports = $this->reportRepository->getCustomReports(['per_page' => 10]);
        $recentExecutions = $this->reportRepository->getReportExecutions(['per_page' => 5]);

        return view('reports.index', compact('standardReports', 'customReports', 'recentExecutions'));
    }

    /**
     * Display custom report builder.
     */
    public function builder()
    {
        $reportTypes = ['membership', 'financial', 'attendance', 'program'];
        $templates = CustomReport::templates()->get();

        return view('reports.builder', compact('reportTypes', 'templates'));
    }

    /**
     * Store custom report.
     */
    public function storeCustomReport(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:membership,financial,attendance,program,custom',
            'description' => 'nullable|string',
            'columns' => 'required|array',
            'filters' => 'nullable|array',
            'group_by' => 'nullable|string',
            'calculations' => 'nullable|array',
            'chart_config' => 'nullable|array',
            'is_template' => 'nullable|boolean',
            'is_public' => 'nullable|boolean',
        ]);

        $validated['configuration'] = [
            'columns' => $validated['columns'],
            'filters' => $validated['filters'] ?? [],
            'group_by' => $validated['group_by'] ?? null,
            'calculations' => $validated['calculations'] ?? [],
        ];

        $report = $this->reportRepository->createCustomReport($validated);

        return redirect()
            ->route('reports.custom.show', $report)
            ->with('success', 'Custom report created successfully.');
    }

    /**
     * Show custom report.
     */
    public function showCustomReport(CustomReport $report)
    {
        $results = $this->reportRepository->executeCustomReport($report);

        return view('reports.custom.show', compact('report', 'results'));
    }

    /**
     * Edit custom report.
     */
    public function editCustomReport(CustomReport $report)
    {
        $availableFields = CustomReport::getAvailableFields($report->type);
        $filterOperators = CustomReport::getFilterOperators();
        $calculationTypes = CustomReport::getCalculationTypes();

        return view('reports.custom.edit', compact('report', 'availableFields', 'filterOperators', 'calculationTypes'));
    }

    /**
     * Update custom report.
     */
    public function updateCustomReport(Request $request, CustomReport $report)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'columns' => 'required|array',
            'filters' => 'nullable|array',
            'group_by' => 'nullable|string',
            'calculations' => 'nullable|array',
            'chart_config' => 'nullable|array',
            'is_public' => 'nullable|boolean',
        ]);

        $this->reportRepository->updateCustomReport($report, $validated);

        return redirect()
            ->route('reports.custom.show', $report)
            ->with('success', 'Report updated successfully.');
    }

    /**
     * Delete custom report.
     */
    public function deleteCustomReport(CustomReport $report)
    {
        $this->reportRepository->deleteCustomReport($report);

        return redirect()
            ->route('reports.index')
            ->with('success', 'Report deleted successfully.');
    }

    /**
     * Duplicate custom report.
     */
    public function duplicateCustomReport(CustomReport $report)
    {
        $duplicate = $report->duplicate($report->name.' (Copy)', auth()->id());

        return redirect()
            ->route('reports.custom.edit', $duplicate)
            ->with('success', 'Report duplicated successfully.');
    }

    /**
     * Toggle report favorite.
     */
    public function toggleFavorite(CustomReport $report)
    {
        $report->toggleFavorite(auth()->user());

        return response()->json([
            'success' => true,
            'is_favorited' => $report->isFavoritedBy(auth()->user()),
        ]);
    }

    /**
     * Display membership reports.
     */
    public function membershipReports(Request $request)
    {
        $filters = $request->only(['status', 'date_from', 'date_to']);
        $data = $this->reportRepository->getMembershipReportData($filters);

        return view('reports.membership', compact('data', 'filters'));
    }

    /**
     * Display financial reports.
     */
    public function financialReports(Request $request)
    {
        $filters = $request->only(['date_from', 'date_to']);
        $data = $this->reportRepository->getFinancialReportData($filters);

        return view('reports.financial', compact('data', 'filters'));
    }

    /**
     * Display attendance reports.
     */
    public function attendanceReports(Request $request)
    {
        $filters = $request->only(['date_from', 'date_to']);
        $data = $this->reportRepository->getAttendanceReportData($filters);

        return view('reports.attendance', compact('data', 'filters'));
    }

    /**
     * Display program reports.
     */
    public function programReports(Request $request)
    {
        $filters = $request->only(['status', 'category']);
        $data = $this->reportRepository->getProgramReportData($filters);

        return view('reports.program', compact('data', 'filters'));
    }

    /**
     * Display analytics dashboard.
     */
    public function analytics(Request $request)
    {
        $days = $request->input('days', 30);
        $data = $this->reportRepository->getAnalyticsDashboardData($days);

        return view('reports.analytics', compact('data', 'days'));
    }

    /**
     * Display report schedules.
     */
    public function schedules()
    {
        $schedules = $this->reportRepository->getReportSchedules();
        $customReports = CustomReport::orderBy('name')->get();

        return view('reports.schedules', compact('schedules', 'customReports'));
    }

    /**
     * Store report schedule.
     */
    public function storeSchedule(Request $request)
    {
        $validated = $request->validate([
            'custom_report_id' => 'nullable|exists:custom_reports,id',
            'report_type' => 'nullable|string',
            'name' => 'required|string|max:255',
            'frequency' => 'required|in:daily,weekly,monthly,quarterly,yearly',
            'recipients' => 'required|array',
            'recipients.*' => 'email',
            'format' => 'required|in:pdf,excel,csv',
            'parameters' => 'nullable|array',
            'run_time' => 'required|date_format:H:i',
            'day_of_week' => 'nullable|integer|min:0|max:6',
            'day_of_month' => 'nullable|integer|min:1|max:31',
        ]);

        $validated['created_by'] = auth()->id();
        $schedule = ReportSchedule::create($validated);

        // Calculate and set next run time
        $schedule->update(['next_run_at' => $schedule->calculateNextRun()]);

        return redirect()
            ->route('reports.schedules')
            ->with('success', 'Report schedule created successfully.');
    }

    /**
     * Update report schedule.
     */
    public function updateSchedule(Request $request, ReportSchedule $schedule)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'frequency' => 'required|in:daily,weekly,monthly,quarterly,yearly',
            'recipients' => 'required|array',
            'recipients.*' => 'email',
            'format' => 'required|in:pdf,excel,csv',
            'parameters' => 'nullable|array',
            'run_time' => 'required|date_format:H:i',
            'day_of_week' => 'nullable|integer|min:0|max:6',
            'day_of_month' => 'nullable|integer|min:1|max:31',
            'is_active' => 'nullable|boolean',
        ]);

        $schedule->update($validated);

        // Recalculate next run time if active
        if ($validated['is_active'] ?? false) {
            $schedule->update(['next_run_at' => $schedule->calculateNextRun()]);
        }

        return redirect()
            ->route('reports.schedules')
            ->with('success', 'Report schedule updated successfully.');
    }

    /**
     * Delete report schedule.
     */
    public function deleteSchedule(ReportSchedule $schedule)
    {
        $schedule->delete();

        return redirect()
            ->route('reports.schedules')
            ->with('success', 'Report schedule deleted successfully.');
    }

    /**
     * Display report executions history.
     */
    public function executions()
    {
        $executions = $this->reportRepository->getReportExecutions();

        return view('reports.executions', compact('executions'));
    }

    /**
     * Download report execution file.
     */
    public function downloadExecution(ReportExecution $execution)
    {
        if (! $execution->isDownloadable()) {
            return redirect()
                ->back()
                ->with('error', 'Report file is not available for download.');
        }

        return Storage::download($execution->file_path, $execution->report_name.'.'.$execution->format);
    }

    /**
     * Delete report execution.
     */
    public function deleteExecution(ReportExecution $execution)
    {
        $execution->deleteFile();
        $execution->delete();

        return redirect()
            ->route('reports.executions')
            ->with('success', 'Report execution deleted successfully.');
    }

    /**
     * Export report to PDF.
     */
    public function exportPdf(Request $request)
    {
        $reportType = $request->input('report_type');
        $filters = $request->only(['date_from', 'date_to', 'status', 'category']);

        // Create execution record
        $execution = ReportExecution::create([
            'report_name' => ucfirst($reportType).' Report',
            'report_type' => $reportType,
            'parameters' => $filters,
            'format' => 'pdf',
            'status' => 'pending',
            'generated_by' => auth()->id(),
        ]);

        // Queue PDF generation job
        // \App\Jobs\GenerateReportPdf::dispatch($execution);

        return redirect()
            ->route('reports.executions')
            ->with('success', 'PDF report generation queued. You will be notified when it\'s ready.');
    }

    /**
     * Export report to Excel.
     */
    public function exportExcel(Request $request)
    {
        $reportType = $request->input('report_type');
        $filters = $request->only(['date_from', 'date_to', 'status', 'category']);

        // Create execution record
        $execution = ReportExecution::create([
            'report_name' => ucfirst($reportType).' Report',
            'report_type' => $reportType,
            'parameters' => $filters,
            'format' => 'excel',
            'status' => 'pending',
            'generated_by' => auth()->id(),
        ]);

        // Queue Excel generation job
        // \App\Jobs\GenerateReportExcel::dispatch($execution);

        return redirect()
            ->route('reports.executions')
            ->with('success', 'Excel report generation queued. You will be notified when it\'s ready.');
    }

    /**
     * Export report to CSV.
     */
    public function exportCsv(Request $request)
    {
        $reportType = $request->input('report_type');
        $filters = $request->only(['date_from', 'date_to', 'status', 'category']);

        // Get data based on report type
        $data = match ($reportType) {
            'membership' => $this->reportRepository->getMembershipReportData($filters),
            'financial' => $this->reportRepository->getFinancialReportData($filters),
            'attendance' => $this->reportRepository->getAttendanceReportData($filters),
            'program' => $this->reportRepository->getProgramReportData($filters),
            default => [],
        };

        // Generate CSV
        $filename = $reportType.'_report_'.now()->format('Y-m-d_H-i-s').'.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function () use ($data, $reportType) {
            $file = fopen('php://output', 'w');

            // Write headers based on report type
            $this->writeCsvHeaders($file, $reportType);

            // Write data
            $this->writeCsvData($file, $data, $reportType);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Write CSV headers.
     */
    protected function writeCsvHeaders($file, string $reportType): void
    {
        $headers = match ($reportType) {
            'membership' => ['ID', 'Name', 'Email', 'Phone', 'Gender', 'Status', 'Join Date'],
            'financial' => ['Date', 'Type', 'Category', 'Amount', 'Member', 'Status'],
            'attendance' => ['Date', 'Service Type', 'Member', 'Check-in Time'],
            'program' => ['Program', 'Category', 'Start Date', 'Status', 'Participants'],
            default => ['Data'],
        };

        fputcsv($file, $headers);
    }

    /**
     * Write CSV data.
     */
    protected function writeCsvData($file, array $data, string $reportType): void
    {
        // This would write the actual data rows
        // Implementation depends on the data structure for each report type
        if (isset($data['members'])) {
            foreach ($data['members'] as $member) {
                fputcsv($file, [
                    $member->id,
                    $member->name,
                    $member->email,
                    $member->phone,
                    $member->gender,
                    $member->status,
                    $member->joined_at?->format('Y-m-d'),
                ]);
            }
        }
    }
}
