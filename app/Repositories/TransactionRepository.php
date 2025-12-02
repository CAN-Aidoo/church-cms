<?php

namespace App\Repositories;

use App\Models\Member;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TransactionRepository
{
    /**
     * Get paginated transactions with filters.
     */
    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Transaction::with(['member', 'approver', 'recorder']);

        // Apply member filter
        if (isset($filters['member_id']) && $filters['member_id']) {
            $query->where('member_id', $filters['member_id']);
        }

        // Apply date range filter
        if (isset($filters['date_from'])) {
            $query->where('transaction_date', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to'])) {
            $query->where('transaction_date', '<=', $filters['date_to']);
        }

        // Apply transaction type filter
        if (isset($filters['transaction_type']) && $filters['transaction_type'] !== '') {
            $query->where('transaction_type', $filters['transaction_type']);
        }

        // Apply category filter
        if (isset($filters['category']) && $filters['category'] !== '') {
            $query->where('category', $filters['category']);
        }

        // Apply status filter
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        // Apply payment method filter
        if (isset($filters['payment_method']) && $filters['payment_method'] !== '') {
            $query->where('payment_method', $filters['payment_method']);
        }

        // Apply amount range filter
        if (isset($filters['amount_min'])) {
            $query->where('amount', '>=', $filters['amount_min']);
        }
        if (isset($filters['amount_max'])) {
            $query->where('amount', '<=', $filters['amount_max']);
        }

        // Apply search filter
        if (isset($filters['search']) && $filters['search'] !== '') {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('reference_number', 'like', "%{$search}%")
                    ->orWhereHas('member', function ($mq) use ($search) {
                        $mq->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
            });
        }

        // Apply sorting
        $sortBy = $filters['sort_by'] ?? 'transaction_date';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * Find transaction by ID.
     */
    public function findById(int $id): ?Transaction
    {
        return Transaction::with(['member', 'approver', 'recorder'])->find($id);
    }

    /**
     * Create transaction.
     */
    public function create(array $data): Transaction
    {
        return Transaction::create($data);
    }

    /**
     * Update transaction.
     */
    public function update(Transaction $transaction, array $data): bool
    {
        return $transaction->update($data);
    }

    /**
     * Delete transaction.
     */
    public function delete(Transaction $transaction): bool
    {
        return $transaction->delete();
    }

    /**
     * Get financial summary.
     */
    public function getFinancialSummary(Carbon $startDate, Carbon $endDate): array
    {
        $income = Transaction::income()
            ->completed()
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $expenses = Transaction::expense()
            ->completed()
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $pending = Transaction::pending()
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        return [
            'total_income' => $income,
            'total_expenses' => $expenses,
            'net_balance' => $income - $expenses,
            'pending_amount' => $pending,
            'period' => [
                'from' => $startDate->format('Y-m-d'),
                'to' => $endDate->format('Y-m-d'),
            ],
        ];
    }

    /**
     * Get income breakdown by type.
     */
    public function getIncomeBreakdown(Carbon $startDate, Carbon $endDate): array
    {
        $breakdown = Transaction::income()
            ->completed()
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();

        $result = [];
        foreach ($breakdown as $item) {
            $result[$item->category] = $item->total;
        }

        return $result;
    }

    /**
     * Get expense breakdown by category.
     */
    public function getExpenseBreakdown(Carbon $startDate, Carbon $endDate): array
    {
        $breakdown = Transaction::expense()
            ->completed()
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();

        $result = [];
        foreach ($breakdown as $item) {
            $result[$item->category] = $item->total;
        }

        return $result;
    }

    /**
     * Get monthly trends.
     */
    public function getMonthlyTrends(int $months = 12): array
    {
        $trends = [];
        $startDate = now()->subMonths($months);

        for ($i = $months - 1; $i >= 0; $i--) {
            $monthStart = now()->subMonths($i)->startOfMonth();
            $monthEnd = now()->subMonths($i)->endOfMonth();
            $monthKey = $monthStart->format('M Y');

            $income = Transaction::income()
                ->completed()
                ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                ->sum('amount');

            $expenses = Transaction::expense()
                ->completed()
                ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                ->sum('amount');

            $trends[$monthKey] = [
                'income' => $income,
                'expenses' => $expenses,
                'net' => $income - $expenses,
            ];
        }

        return $trends;
    }

    /**
     * Get pending transactions requiring approval.
     */
    public function getPendingApprovals(): Collection
    {
        return Transaction::pending()
            ->with(['member', 'recorder'])
            ->orderBy('transaction_date', 'desc')
            ->get();
    }

    /**
     * Get top donors.
     */
    public function getTopDonors(int $limit = 10, ?Carbon $startDate = null, ?Carbon $endDate = null): array
    {
        $query = Transaction::income()
            ->completed()
            ->whereNotNull('member_id')
            ->select('member_id', DB::raw('SUM(amount) as total_given'));

        if ($startDate) {
            $query->where('transaction_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('transaction_date', '<=', $endDate);
        }

        $results = $query->groupBy('member_id')
            ->orderByDesc('total_given')
            ->limit($limit)
            ->get();

        return $results->map(function ($item) {
            $member = Member::find($item->member_id);

            return [
                'member' => $member,
                'total_given' => $item->total_given,
            ];
        })->toArray();
    }

    /**
     * Get transactions by member.
     */
    public function getByMember(int $memberId, ?int $limit = null): Collection
    {
        $query = Transaction::where('member_id', $memberId)
            ->orderBy('transaction_date', 'desc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get recent transactions.
     */
    public function getRecent(int $limit = 10): Collection
    {
        return Transaction::with(['member', 'recorder'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get transaction statistics.
     */
    public function getStatistics(array $filters = []): array
    {
        $query = Transaction::query();

        // Apply date range
        if (isset($filters['date_from'])) {
            $query->where('transaction_date', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to'])) {
            $query->where('transaction_date', '<=', $filters['date_to']);
        }

        $total = (clone $query)->count();
        $totalAmount = (clone $query)->sum('amount');
        $incomeCount = (clone $query)->income()->count();
        $expenseCount = (clone $query)->expense()->count();
        $pendingCount = (clone $query)->pending()->count();
        $completedCount = (clone $query)->completed()->count();

        return [
            'total_transactions' => $total,
            'total_amount' => $totalAmount,
            'income_count' => $incomeCount,
            'expense_count' => $expenseCount,
            'pending_count' => $pendingCount,
            'completed_count' => $completedCount,
            'average_transaction' => $total > 0 ? round($totalAmount / $total, 2) : 0,
        ];
    }

    /**
     * Approve transaction.
     */
    public function approve(Transaction $transaction, int $approverId): bool
    {
        return $transaction->update([
            'status' => 'completed',
            'approved_by' => $approverId,
            'approved_at' => now(),
        ]);
    }

    /**
     * Reject transaction.
     */
    public function reject(Transaction $transaction, int $approverId, ?string $reason = null): bool
    {
        return $transaction->update([
            'status' => 'cancelled',
            'approved_by' => $approverId,
            'approved_at' => now(),
            'notes' => ($transaction->notes ? $transaction->notes."\n" : '').'Rejected: '.$reason,
        ]);
    }

    /**
     * Export transactions.
     */
    public function export(array $filters = []): Collection
    {
        $query = Transaction::with(['member', 'approver', 'recorder']);

        // Apply filters (same as getPaginated but without pagination)
        if (isset($filters['member_id']) && $filters['member_id']) {
            $query->where('member_id', $filters['member_id']);
        }

        if (isset($filters['date_from'])) {
            $query->where('transaction_date', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to'])) {
            $query->where('transaction_date', '<=', $filters['date_to']);
        }

        if (isset($filters['transaction_type']) && $filters['transaction_type'] !== '') {
            $query->where('transaction_type', $filters['transaction_type']);
        }

        if (isset($filters['category']) && $filters['category'] !== '') {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('transaction_date', 'desc')->get();
    }

    /**
     * Get member giving summary.
     */
    public function getMemberGivingSummary(int $memberId, ?Carbon $startDate = null, ?Carbon $endDate = null): array
    {
        $query = Transaction::where('member_id', $memberId)
            ->income()
            ->completed();

        if ($startDate) {
            $query->where('transaction_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('transaction_date', '<=', $endDate);
        }

        $total = $query->sum('amount');
        $tithes = (clone $query)->where('category', 'tithe')->sum('amount');
        $offerings = (clone $query)->where('category', 'offering')->sum('amount');
        $donations = (clone $query)->where('category', 'donation')->sum('amount');
        $count = $query->count();

        return [
            'total_given' => $total,
            'tithes' => $tithes,
            'offerings' => $offerings,
            'donations' => $donations,
            'transaction_count' => $count,
        ];
    }

    /**
     * Get transactions requiring dual approval.
     */
    public function getRequiringDualApproval(float $threshold = 5000): Collection
    {
        return Transaction::pending()
            ->where('amount', '>=', $threshold)
            ->with(['member', 'recorder'])
            ->orderBy('transaction_date', 'desc')
            ->get();
    }

    /**
     * Check if transaction requires dual approval.
     */
    public function requiresDualApproval(Transaction $transaction, float $threshold = 5000): bool
    {
        return $transaction->amount >= $threshold;
    }
}
