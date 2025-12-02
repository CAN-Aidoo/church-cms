<?php

namespace App\Repositories;

use App\Models\AnalyticsMetric;
use App\Models\Attendance;
use App\Models\CustomReport;
use App\Models\Member;
use App\Models\Program;
use App\Models\ReportExecution;
use App\Models\ReportSchedule;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReportRepository
{
    /**
     * Get all custom reports with optional filters.
     */
    public function getCustomReports(array $filters = [])
    {
        $query = CustomReport::with('creator');

        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['is_template'])) {
            $query->where('is_template', $filters['is_template']);
        }

        if (isset($filters['created_by'])) {
            $query->where('created_by', $filters['created_by']);
        }

        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%'.$filters['search'].'%')
                    ->orWhere('description', 'like', '%'.$filters['search'].'%');
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Create custom report.
     */
    public function createCustomReport(array $data): CustomReport
    {
        $data['created_by'] = $data['created_by'] ?? auth()->id();

        return CustomReport::create($data);
    }

    /**
     * Update custom report.
     */
    public function updateCustomReport(CustomReport $report, array $data): CustomReport
    {
        $report->update($data);

        return $report->fresh();
    }

    /**
     * Delete custom report.
     */
    public function deleteCustomReport(CustomReport $report): bool
    {
        // Delete associated schedules
        $report->schedules()->delete();

        // Delete associated executions and their files
        foreach ($report->executions as $execution) {
            $execution->deleteFile();
            $execution->delete();
        }

        return $report->delete();
    }

    /**
     * Execute custom report.
     */
    public function executeCustomReport(CustomReport $report, array $parameters = []): Collection
    {
        $query = $this->buildQueryFromReport($report);

        // Apply filters from parameters
        if (! empty($parameters['filters'])) {
            $query = $this->applyFilters($query, $parameters['filters']);
        }

        // Apply date range if provided
        if (! empty($parameters['date_from'])) {
            $query->where('created_at', '>=', $parameters['date_from']);
        }

        if (! empty($parameters['date_to'])) {
            $query->where('created_at', '<=', $parameters['date_to']);
        }

        // Get results
        $results = $query->get();

        // Apply calculations if configured
        if (! empty($report->calculations)) {
            $results = $this->applyCalculations($results, $report->calculations);
        }

        return $results;
    }

    /**
     * Build query from report configuration.
     */
    protected function buildQueryFromReport(CustomReport $report)
    {
        return match ($report->type) {
            'membership' => $this->buildMembershipQuery($report),
            'financial' => $this->buildFinancialQuery($report),
            'attendance' => $this->buildAttendanceQuery($report),
            'program' => $this->buildProgramQuery($report),
            default => collect([]),
        };
    }

    /**
     * Build membership query.
     */
    protected function buildMembershipQuery(CustomReport $report)
    {
        $query = Member::with(['shepherd', 'serviceUnits']);

        // Apply column selection
        if (! empty($report->columns)) {
            $query->select($this->mapColumnsToFields($report->columns, 'members'));
        }

        // Apply filters from report configuration
        if (! empty($report->filters)) {
            $query = $this->applyFilters($query, $report->filters);
        }

        // Apply grouping
        if (! empty($report->group_by)) {
            $query->orderBy($report->group_by);
        }

        return $query;
    }

    /**
     * Build financial query.
     */
    protected function buildFinancialQuery(CustomReport $report)
    {
        $query = Transaction::with(['member', 'approvedBy']);

        if (! empty($report->columns)) {
            $query->select($this->mapColumnsToFields($report->columns, 'transactions'));
        }

        if (! empty($report->filters)) {
            $query = $this->applyFilters($query, $report->filters);
        }

        if (! empty($report->group_by)) {
            $query->orderBy($report->group_by);
        }

        return $query;
    }

    /**
     * Build attendance query.
     */
    protected function buildAttendanceQuery(CustomReport $report)
    {
        $query = Attendance::with('member');

        if (! empty($report->columns)) {
            $query->select($this->mapColumnsToFields($report->columns, 'attendance'));
        }

        if (! empty($report->filters)) {
            $query = $this->applyFilters($query, $report->filters);
        }

        if (! empty($report->group_by)) {
            $query->orderBy($report->group_by);
        }

        return $query;
    }

    /**
     * Build program query.
     */
    protected function buildProgramQuery(CustomReport $report)
    {
        $query = Program::with(['registrations', 'sessions']);

        if (! empty($report->columns)) {
            $query->select($this->mapColumnsToFields($report->columns, 'programs'));
        }

        if (! empty($report->filters)) {
            $query = $this->applyFilters($query, $report->filters);
        }

        if (! empty($report->group_by)) {
            $query->orderBy($report->group_by);
        }

        return $query;
    }

    /**
     * Map column names to database fields.
     */
    protected function mapColumnsToFields(array $columns, string $table): array
    {
        // This would map report column names to actual database fields
        // For now, return the columns as-is
        return $columns;
    }

    /**
     * Apply filters to query.
     */
    protected function applyFilters($query, array $filters)
    {
        foreach ($filters as $filter) {
            $field = $filter['field'];
            $operator = $filter['operator'];
            $value = $filter['value'];

            switch ($operator) {
                case 'equals':
                    $query->where($field, '=', $value);
                    break;
                case 'not_equals':
                    $query->where($field, '!=', $value);
                    break;
                case 'contains':
                    $query->where($field, 'like', '%'.$value.'%');
                    break;
                case 'starts_with':
                    $query->where($field, 'like', $value.'%');
                    break;
                case 'ends_with':
                    $query->where($field, 'like', '%'.$value);
                    break;
                case 'greater_than':
                    $query->where($field, '>', $value);
                    break;
                case 'less_than':
                    $query->where($field, '<', $value);
                    break;
                case 'between':
                    $query->whereBetween($field, [$value['from'], $value['to']]);
                    break;
                case 'in':
                    $query->whereIn($field, $value);
                    break;
                case 'is_null':
                    $query->whereNull($field);
                    break;
                case 'is_not_null':
                    $query->whereNotNull($field);
                    break;
            }
        }

        return $query;
    }

    /**
     * Apply calculations to results.
     */
    protected function applyCalculations(Collection $results, array $calculations): Collection
    {
        foreach ($calculations as $calculation) {
            $field = $calculation['field'];
            $type = $calculation['type'];

            $calculatedValue = match ($type) {
                'sum' => $results->sum($field),
                'avg' => $results->avg($field),
                'count' => $results->count(),
                'min' => $results->min($field),
                'max' => $results->max($field),
                default => 0,
            };

            $results->put('calculated_'.$field.'_'.$type, $calculatedValue);
        }

        return $results;
    }

    /**
     * Get membership reports data.
     */
    public function getMembershipReportData(array $filters = []): array
    {
        $query = Member::query();

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['date_from'])) {
            $query->where('joined_at', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->where('joined_at', '<=', $filters['date_to']);
        }

        return [
            'total_members' => $query->count(),
            'by_gender' => (clone $query)->select('gender', DB::raw('count(*) as count'))
                ->groupBy('gender')
                ->pluck('count', 'gender')
                ->toArray(),
            'by_status' => (clone $query)->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray(),
            'by_marital_status' => (clone $query)->select('marital_status', DB::raw('count(*) as count'))
                ->groupBy('marital_status')
                ->pluck('count', 'marital_status')
                ->toArray(),
            'members' => $query->with(['shepherd', 'serviceUnits'])->get(),
        ];
    }

    /**
     * Get financial reports data.
     */
    public function getFinancialReportData(array $filters = []): array
    {
        $query = Transaction::query();

        if (! empty($filters['date_from'])) {
            $query->where('transaction_date', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->where('transaction_date', '<=', $filters['date_to']);
        }

        $income = (clone $query)->where('type', 'income')->sum('amount');
        $expenses = (clone $query)->where('type', 'expense')->sum('amount');

        return [
            'total_income' => $income,
            'total_expenses' => $expenses,
            'net_balance' => $income - $expenses,
            'by_category' => (clone $query)->select('category', 'type', DB::raw('sum(amount) as total'))
                ->groupBy('category', 'type')
                ->get()
                ->groupBy('type')
                ->toArray(),
            'by_month' => (clone $query)->select(
                DB::raw('DATE_FORMAT(transaction_date, "%Y-%m") as month'),
                'type',
                DB::raw('sum(amount) as total')
            )
                ->groupBy('month', 'type')
                ->orderBy('month')
                ->get()
                ->groupBy('month')
                ->toArray(),
            'transactions' => $query->with(['member', 'approvedBy'])->get(),
        ];
    }

    /**
     * Get attendance reports data.
     */
    public function getAttendanceReportData(array $filters = []): array
    {
        $query = Attendance::query();

        if (! empty($filters['date_from'])) {
            $query->where('service_date', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->where('service_date', '<=', $filters['date_to']);
        }

        $totalMembers = Member::where('member_status', 'active')->count();
        $attendanceRecords = $query->count();

        return [
            'total_attendance' => $attendanceRecords,
            'unique_attendees' => (clone $query)->distinct('member_id')->count('member_id'),
            'attendance_rate' => $totalMembers > 0 ? ($attendanceRecords / $totalMembers) * 100 : 0,
            'by_service_type' => (clone $query)->select('service_type', DB::raw('count(*) as count'))
                ->groupBy('service_type')
                ->pluck('count', 'service_type')
                ->toArray(),
            'by_date' => (clone $query)->select('service_date', DB::raw('count(*) as count'))
                ->groupBy('service_date')
                ->orderBy('service_date')
                ->pluck('count', 'service_date')
                ->toArray(),
            'attendance_records' => $query->with('member')->get(),
        ];
    }

    /**
     * Get program reports data.
     */
    public function getProgramReportData(array $filters = []): array
    {
        $query = Program::query();

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        return [
            'total_programs' => $query->count(),
            'total_participants' => (clone $query)->sum('participants_count'),
            'by_status' => (clone $query)->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray(),
            'by_category' => (clone $query)->select('category', DB::raw('count(*) as count'))
                ->groupBy('category')
                ->pluck('count', 'category')
                ->toArray(),
            'programs' => $query->with(['registrations', 'sessions'])->get(),
        ];
    }

    /**
     * Get report schedules.
     */
    public function getReportSchedules(array $filters = [])
    {
        $query = ReportSchedule::with(['customReport', 'creator']);

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        if (isset($filters['frequency'])) {
            $query->where('frequency', $filters['frequency']);
        }

        return $query->orderBy('next_run_at')->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Get due schedules.
     */
    public function getDueSchedules(): Collection
    {
        return ReportSchedule::with(['customReport', 'creator'])
            ->due()
            ->get();
    }

    /**
     * Get report executions.
     */
    public function getReportExecutions(array $filters = [])
    {
        $query = ReportExecution::with(['customReport', 'generator']);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['format'])) {
            $query->where('format', $filters['format']);
        }

        if (isset($filters['generated_by'])) {
            $query->where('generated_by', $filters['generated_by']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Get analytics dashboard data.
     */
    public function getAnalyticsDashboardData(int $days = 30): array
    {
        $endDate = now();
        $startDate = now()->subDays($days);

        return [
            'growth_metrics' => AnalyticsMetric::getGrowthMetrics($days),
            'engagement_score' => AnalyticsMetric::getEngagementScore(),
            'financial_health' => $this->getFinancialHealthMetrics($startDate, $endDate),
            'ministry_effectiveness' => $this->getMinistryEffectivenessMetrics($startDate, $endDate),
        ];
    }

    /**
     * Get financial health metrics.
     */
    protected function getFinancialHealthMetrics(Carbon $startDate, Carbon $endDate): array
    {
        $income = Transaction::whereIn('transaction_type', ['tithe', 'offering', 'donation', 'other_income'])
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $expenses = Transaction::where('transaction_type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        return [
            'total_income' => $income,
            'total_expenses' => $expenses,
            'net_balance' => $income - $expenses,
            'expense_ratio' => $income > 0 ? ($expenses / $income) * 100 : 0,
        ];
    }

    /**
     * Get ministry effectiveness metrics.
     */
    protected function getMinistryEffectivenessMetrics(Carbon $startDate, Carbon $endDate): array
    {
        $programsCompleted = Program::where('status', 'completed')
            ->whereBetween('end_date', [$startDate, $endDate])
            ->count();

        $avgAttendanceRate = Program::where('status', 'completed')
            ->whereBetween('end_date', [$startDate, $endDate])
            ->avg('attendance_rate') ?? 0;

        return [
            'programs_completed' => $programsCompleted,
            'avg_attendance_rate' => $avgAttendanceRate,
            'active_volunteers' => 0, // Would need service unit data
        ];
    }
}
