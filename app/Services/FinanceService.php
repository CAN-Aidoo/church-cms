<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use App\Repositories\TransactionRepository;

class FinanceService
{
    public function __construct(
        protected TransactionRepository $transactionRepository
    ) {}

    /**
     * Calculate financial balance for a given period.
     */
    public function calculateBalance($startDate, $endDate): array
    {
        $income = Transaction::income()
            ->completed()
            ->dateRange($startDate, $endDate)
            ->sum('amount');

        $expenses = Transaction::expense()
            ->completed()
            ->dateRange($startDate, $endDate)
            ->sum('amount');

        return [
            'income' => $income,
            'expenses' => $expenses,
            'net_balance' => $income - $expenses,
        ];
    }

    /**
     * Get financial summary by transaction type.
     */
    public function getFinancialSummary($startDate, $endDate): array
    {
        $transactions = Transaction::completed()
            ->dateRange($startDate, $endDate)
            ->selectRaw('transaction_type, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('transaction_type')
            ->get();

        $summary = [
            'income' => [
                'tithes' => 0,
                'offerings' => 0,
                'donations' => 0,
                'other_income' => 0,
                'total' => 0,
            ],
            'expenses' => [
                'total' => 0,
            ],
        ];

        foreach ($transactions as $transaction) {
            if ($transaction->transaction_type === 'expense') {
                $summary['expenses']['total'] += $transaction->total;
            } else {
                $summary['income'][$transaction->transaction_type] = $transaction->total;
                $summary['income']['total'] += $transaction->total;
            }
        }

        $summary['net_balance'] = $summary['income']['total'] - $summary['expenses']['total'];

        return $summary;
    }

    /**
     * Get expense breakdown by category.
     */
    public function getExpenseBreakdown($startDate, $endDate): array
    {
        return Transaction::expense()
            ->completed()
            ->dateRange($startDate, $endDate)
            ->selectRaw('category, SUM(amount) as total, COUNT(*) as count')
            ->whereNotNull('category')
            ->groupBy('category')
            ->get()
            ->toArray();
    }

    /**
     * Get monthly financial trend.
     */
    public function getMonthlyTrend(int $months = 12): array
    {
        $startDate = now()->subMonths($months)->startOfMonth();

        $transactions = Transaction::completed()
            ->where('transaction_date', '>=', $startDate)
            ->selectRaw('DATE_FORMAT(transaction_date, "%Y-%m") as month')
            ->selectRaw('transaction_type')
            ->selectRaw('SUM(amount) as total')
            ->groupBy('month', 'transaction_type')
            ->orderBy('month')
            ->get();

        $trend = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $trend[$month] = [
                'income' => 0,
                'expenses' => 0,
                'net' => 0,
            ];
        }

        foreach ($transactions as $transaction) {
            if (! isset($trend[$transaction->month])) {
                continue;
            }

            if ($transaction->transaction_type === 'expense') {
                $trend[$transaction->month]['expenses'] += $transaction->total;
            } else {
                $trend[$transaction->month]['income'] += $transaction->total;
            }

            $trend[$transaction->month]['net'] =
                $trend[$transaction->month]['income'] - $trend[$transaction->month]['expenses'];
        }

        return $trend;
    }

    /**
     * Get top givers.
     */
    public function getTopGivers(int $limit = 10, $startDate = null, $endDate = null): array
    {
        $query = Transaction::whereIn('transaction_type', ['tithe', 'offering', 'donation'])
            ->completed()
            ->whereNotNull('member_id')
            ->selectRaw('member_id, SUM(amount) as total')
            ->groupBy('member_id')
            ->orderByDesc('total')
            ->limit($limit)
            ->with('member:id,first_name,last_name');

        if ($startDate && $endDate) {
            $query->dateRange($startDate, $endDate);
        }

        return $query->get()->toArray();
    }

    /**
     * Approve a transaction.
     */
    public function approveTransaction(Transaction $transaction, User $approver): bool
    {
        if ($transaction->status !== 'pending') {
            return false;
        }

        return $transaction->approve($approver);
    }

    /**
     * Check if transaction requires approval.
     */
    public function requiresApproval(float $amount): bool
    {
        return $amount >= config('church.dual_approval_amount', 5000);
    }

    /**
     * Get pending transactions requiring approval.
     */
    public function getPendingApprovals(): array
    {
        return Transaction::pending()
            ->orderBy('transaction_date', 'desc')
            ->with(['member:id,first_name,last_name', 'creator:id,full_name'])
            ->get()
            ->toArray();
    }

    /**
     * Generate financial report.
     */
    public function generateReport($type, $startDate, $endDate): array
    {
        $summary = $this->getFinancialSummary($startDate, $endDate);
        $trend = $this->getMonthlyTrend(12);
        $expenseBreakdown = $this->getExpenseBreakdown($startDate, $endDate);
        $topGivers = $this->getTopGivers(10, $startDate, $endDate);

        return [
            'period' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            'summary' => $summary,
            'trend' => $trend,
            'expense_breakdown' => $expenseBreakdown,
            'top_givers' => $topGivers,
            'generated_at' => now()->toDateTimeString(),
        ];
    }
}
