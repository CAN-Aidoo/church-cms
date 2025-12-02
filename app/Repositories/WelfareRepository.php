<?php

namespace App\Repositories;

use App\Models\WelfareCase;
use App\Models\WelfareFundTransaction;
use App\Models\WelfareProgram;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class WelfareRepository
{
    /**
     * Get cases with filters.
     */
    public function getCases(array $filters = [])
    {
        $query = WelfareCase::with(['beneficiary', 'submittedBy']);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['case_category'])) {
            $query->byCategory($filters['case_category']);
        }

        if (isset($filters['priority'])) {
            $query->byPriority($filters['priority']);
        }

        if (isset($filters['verification_status'])) {
            $query->where('verification_status', $filters['verification_status']);
        }

        if (isset($filters['beneficiary_id'])) {
            $query->where('beneficiary_id', $filters['beneficiary_id']);
        }

        if (isset($filters['date_from']) && isset($filters['date_to'])) {
            $query->whereBetween('case_date', [$filters['date_from'], $filters['date_to']]);
        }

        return $query->orderBy('priority_score', 'desc')
            ->orderBy('case_date', 'desc')
            ->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Create welfare case.
     */
    public function createCase(array $data): WelfareCase
    {
        $data['submitted_by'] = $data['submitted_by'] ?? auth()->id();

        return WelfareCase::create($data);
    }

    /**
     * Get pending cases.
     */
    public function getPendingCases(): Collection
    {
        return WelfareCase::with(['beneficiary', 'submittedBy'])
            ->whereIn('status', ['submitted', 'under_review'])
            ->orderBy('priority_score', 'desc')
            ->get();
    }

    /**
     * Get high priority cases.
     */
    public function getHighPriorityCases(): Collection
    {
        return WelfareCase::with(['beneficiary', 'submittedBy'])
            ->highPriority()
            ->whereNotIn('status', ['rejected', 'closed'])
            ->orderBy('case_date')
            ->get();
    }

    /**
     * Get programs with filters.
     */
    public function getPrograms(array $filters = [])
    {
        $query = WelfareProgram::with('coordinator');

        if (isset($filters['program_type'])) {
            $query->byType($filters['program_type']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Get active programs.
     */
    public function getActivePrograms(): Collection
    {
        return WelfareProgram::with('coordinator')
            ->active()
            ->get();
    }

    /**
     * Create program.
     */
    public function createProgram(array $data): WelfareProgram
    {
        return WelfareProgram::create($data);
    }

    /**
     * Get fund transactions.
     */
    public function getTransactions(array $filters = [])
    {
        $query = WelfareFundTransaction::with(['case', 'member', 'recordedBy']);

        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['date_from']) && isset($filters['date_to'])) {
            $query->whereBetween('transaction_date', [$filters['date_from'], $filters['date_to']]);
        }

        return $query->orderBy('transaction_date', 'desc')->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Create fund transaction.
     */
    public function createTransaction(array $data): WelfareFundTransaction
    {
        $data['recorded_by'] = $data['recorded_by'] ?? auth()->id();

        return WelfareFundTransaction::create($data);
    }

    /**
     * Get fund balance.
     */
    public function getFundBalance(): float
    {
        $collections = WelfareFundTransaction::where('type', 'collection')->sum('amount');
        $disbursements = WelfareFundTransaction::where('type', 'disbursement')->sum('amount');

        return $collections - $disbursements;
    }

    /**
     * Get dashboard statistics.
     */
    public function getDashboardStatistics(): array
    {
        return [
            'total_cases' => WelfareCase::count(),
            'pending_cases' => WelfareCase::whereIn('status', ['submitted', 'under_review'])->count(),
            'approved_cases' => WelfareCase::approved()->count(),
            'pending_verification' => WelfareCase::pendingVerification()->count(),
            'pending_disbursement' => WelfareCase::pendingDisbursement()->count(),
            'active_programs' => WelfareProgram::active()->count(),
            'total_beneficiaries' => WelfareCase::distinct('beneficiary_id')->count('beneficiary_id'),
            'fund_balance' => $this->getFundBalance(),
            'this_month_disbursed' => WelfareCase::whereMonth('approved_at', now()->month)
                ->sum('amount_disbursed'),
            'cases_by_category' => WelfareCase::selectRaw('case_category, COUNT(*) as count')
                ->groupBy('case_category')
                ->pluck('count', 'case_category')
                ->toArray(),
            'cases_by_status' => WelfareCase::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray(),
        ];
    }

    /**
     * Get welfare report.
     */
    public function getWelfareReport(Carbon $startDate, Carbon $endDate): array
    {
        $cases = WelfareCase::whereBetween('case_date', [$startDate, $endDate])->get();
        $transactions = WelfareFundTransaction::whereBetween('transaction_date', [$startDate, $endDate])->get();

        return [
            'period' => [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d'),
            ],
            'cases' => [
                'total' => $cases->count(),
                'approved' => $cases->where('status', 'approved')->count(),
                'rejected' => $cases->where('status', 'rejected')->count(),
                'disbursed' => $cases->where('status', 'disbursed')->count(),
                'by_category' => $cases->groupBy('case_category')->map->count(),
                'by_priority' => $cases->groupBy('priority')->map->count(),
                'total_requested' => $cases->sum('amount_requested'),
                'total_approved' => $cases->sum('amount_approved'),
                'total_disbursed' => $cases->sum('amount_disbursed'),
            ],
            'fund' => [
                'collections' => $transactions->where('type', 'collection')->sum('amount'),
                'disbursements' => $transactions->where('type', 'disbursement')->sum('amount'),
                'by_category' => $transactions->groupBy('category')->map(fn ($items) => $items->sum('amount')),
            ],
            'beneficiaries' => [
                'unique' => $cases->unique('beneficiary_id')->count(),
                'members' => $cases->whereNotNull('beneficiary_id')->count(),
                'non_members' => $cases->whereNull('beneficiary_id')->count(),
            ],
        ];
    }

    /**
     * Get program statistics.
     */
    public function getProgramStatistics(WelfareProgram $program): array
    {
        return [
            'total_beneficiaries' => $program->beneficiaries_count,
            'active_beneficiaries' => $program->beneficiaries()->where('member_status', 'active')->count(),
            'graduated_beneficiaries' => $program->beneficiaries()->where('status', 'graduated')->count(),
            'budget_allocated' => $program->budget_allocated,
            'budget_spent' => $program->budget_spent,
            'budget_remaining' => $program->budget_remaining,
            'budget_utilization' => $program->budget_utilization,
        ];
    }
}
