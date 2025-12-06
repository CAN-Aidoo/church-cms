<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Services\FinanceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionRepository $transactionRepository,
        protected FinanceService $financeService
    ) {}

    /**
     * Display transaction list.
     */
    public function index(Request $request)
    {
        $filters = $request->only([
            'member_id', 'date_from', 'date_to', 'transaction_type',
            'category', 'status', 'payment_method', 'amount_min', 'amount_max',
            'search', 'sort_by', 'sort_order',
        ]);

        $perPage = $request->input('per_page', 15);
        $transactions = $this->transactionRepository->getPaginated($filters, $perPage);

        // Get statistics
        $statistics = $this->transactionRepository->getStatistics($filters);

        // Get financial summary
        $summary = $this->transactionRepository->getFinancialSummary(
            isset($filters['date_from']) ? Carbon::parse($filters['date_from']) : now()->startOfMonth(),
            isset($filters['date_to']) ? Carbon::parse($filters['date_to']) : now()->endOfMonth()
        );

        return view('transactions.index', compact(
            'transactions',
            'statistics',
            'summary',
            'filters'
        ));
    }

    /**
     * Show form to create transaction.
     */
    public function create(Request $request)
    {
        // Pre-select member if provided
        $memberId = $request->input('member_id');
        $member = $memberId ? Member::find($memberId) : null;

        return view('transactions.create', compact('member'));
    }

    /**
     * Store transaction.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'transaction_date' => 'required|date',
            'transaction_type' => ['required', Rule::in(['income', 'expense'])],
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => ['required', Rule::in(['cash', 'cheque', 'bank_transfer', 'mobile_money', 'card', 'other'])],
            'reference_number' => 'nullable|string|max:100',
            'description' => 'required|string',
            'receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'notes' => 'nullable|string',
        ]);

        // Handle receipt upload using secure file upload service
        if ($request->hasFile('receipt')) {
            $fileUploadService = app(\App\Services\FileUploadService::class);
            $fileType = in_array($request->file('receipt')->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])
                ? 'image'
                : 'document';
            $validated['receipt_path'] = $fileUploadService->uploadFile(
                $request->file('receipt'),
                'receipts',
                $fileType
            );
        }

        // Set status based on amount (automatic approval for small amounts)
        $approvalThreshold = config('church.dual_approval_amount', 5000);
        if ($validated['amount'] < 1000) {
            $validated['status'] = 'completed';
            $validated['approved_by'] = Auth::id();
            $validated['approved_at'] = now();
        } else {
            $validated['status'] = 'pending';
        }

        $validated['recorded_by'] = Auth::id();

        $transaction = $this->transactionRepository->create($validated);

        return redirect()
            ->route('transactions.show', $transaction)
            ->with('success', 'Transaction recorded successfully'.($validated['status'] === 'pending' ? ' and pending approval.' : '.'));
    }

    /**
     * Show transaction details.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['member', 'approver', 'recorder']);

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show edit form.
     */
    public function edit(Transaction $transaction)
    {
        // Only allow editing pending transactions
        if ($transaction->status !== 'pending') {
            return redirect()
                ->route('transactions.show', $transaction)
                ->with('error', 'Cannot edit completed or cancelled transactions.');
        }

        return view('transactions.edit', compact('transaction'));
    }

    /**
     * Update transaction.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Only allow updating pending transactions
        if ($transaction->status !== 'pending') {
            return redirect()
                ->route('transactions.show', $transaction)
                ->with('error', 'Cannot update completed or cancelled transactions.');
        }

        $validated = $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'transaction_date' => 'required|date',
            'transaction_type' => ['required', Rule::in(['income', 'expense'])],
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => ['required', Rule::in(['cash', 'cheque', 'bank_transfer', 'mobile_money', 'card', 'other'])],
            'reference_number' => 'nullable|string|max:100',
            'description' => 'required|string',
            'receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'notes' => 'nullable|string',
        ]);

        // Handle receipt upload using secure file upload service
        if ($request->hasFile('receipt')) {
            // Delete old receipt
            if ($transaction->receipt_path) {
                $fileUploadService = app(\App\Services\FileUploadService::class);
                $fileUploadService->deleteFile($transaction->receipt_path);
            }

            $fileUploadService = app(\App\Services\FileUploadService::class);
            $fileType = in_array($request->file('receipt')->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])
                ? 'image'
                : 'document';
            $validated['receipt_path'] = $fileUploadService->uploadFile(
                $request->file('receipt'),
                'receipts',
                $fileType
            );
        }

        $this->transactionRepository->update($transaction, $validated);

        return redirect()
            ->route('transactions.show', $transaction)
            ->with('success', 'Transaction updated successfully.');
    }

    /**
     * Delete transaction.
     */
    public function destroy(Transaction $transaction)
    {
        // Only admin can delete
        if (! Auth::user()->hasRole('admin')) {
            abort(403, 'You do not have permission to delete transactions.');
        }

        // Delete receipt file if exists
        if ($transaction->receipt_path) {
            Storage::disk('public')->delete($transaction->receipt_path);
        }

        $this->transactionRepository->delete($transaction);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }

    /**
     * Approve transaction.
     */
    public function approve(Transaction $transaction)
    {
        // Only pastor and admin can approve
        if (! Auth::user()->hasAnyRole(['admin', 'pastor'])) {
            abort(403, 'You do not have permission to approve transactions.');
        }

        if ($transaction->status !== 'pending') {
            return redirect()
                ->route('transactions.show', $transaction)
                ->with('error', 'This transaction has already been processed.');
        }

        $this->transactionRepository->approve($transaction, Auth::id());

        return redirect()
            ->route('transactions.show', $transaction)
            ->with('success', 'Transaction approved successfully.');
    }

    /**
     * Reject transaction.
     */
    public function reject(Request $request, Transaction $transaction)
    {
        // Only pastor and admin can reject
        if (! Auth::user()->hasAnyRole(['admin', 'pastor'])) {
            abort(403, 'You do not have permission to reject transactions.');
        }

        if ($transaction->status !== 'pending') {
            return redirect()
                ->route('transactions.show', $transaction)
                ->with('error', 'This transaction has already been processed.');
        }

        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $this->transactionRepository->reject($transaction, Auth::id(), $request->reason);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction rejected.');
    }

    /**
     * Show financial reports.
     */
    public function reports(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->endOfMonth()->format('Y-m-d'));

        $filters = [
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
        ];

        // Get comprehensive financial summary
        $summary = $this->transactionRepository->getFinancialSummary(
            Carbon::parse($dateFrom),
            Carbon::parse($dateTo)
        );

        // Get income breakdown
        $incomeBreakdown = $this->transactionRepository->getIncomeBreakdown(
            Carbon::parse($dateFrom),
            Carbon::parse($dateTo)
        );

        // Get expense breakdown
        $expenseBreakdown = $this->transactionRepository->getExpenseBreakdown(
            Carbon::parse($dateFrom),
            Carbon::parse($dateTo)
        );

        // Get monthly trends (last 12 months)
        $trends = $this->transactionRepository->getMonthlyTrends(12);

        // Get top donors
        $topDonors = $this->transactionRepository->getTopDonors(
            10,
            Carbon::parse($dateFrom),
            Carbon::parse($dateTo)
        );

        // Get pending approvals
        $pendingApprovals = $this->transactionRepository->getPendingApprovals();

        return view('transactions.reports', compact(
            'summary',
            'incomeBreakdown',
            'expenseBreakdown',
            'trends',
            'topDonors',
            'pendingApprovals',
            'filters'
        ));
    }

    /**
     * Export transactions to CSV.
     */
    public function export(Request $request)
    {
        $filters = $request->only([
            'member_id', 'date_from', 'date_to', 'transaction_type',
            'category', 'status', 'payment_method',
        ]);

        $transactions = $this->transactionRepository->export($filters);

        $filename = 'transactions_'.date('Y-m-d_His').'.csv';
        $handle = fopen('php://output', 'w');

        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');

        // Add CSV header
        fputcsv($handle, [
            'Date', 'Type', 'Category', 'Amount', 'Member', 'Payment Method',
            'Reference', 'Description', 'Status', 'Recorded By', 'Approved By',
        ]);

        // Add transaction data
        foreach ($transactions as $transaction) {
            fputcsv($handle, [
                $transaction->transaction_date->format('Y-m-d'),
                ucfirst($transaction->transaction_type),
                ucfirst($transaction->category),
                number_format($transaction->amount, 2),
                $transaction->member?->full_name ?? 'Anonymous',
                ucfirst(str_replace('_', ' ', $transaction->payment_method)),
                $transaction->reference_number,
                $transaction->description,
                ucfirst($transaction->status),
                $transaction->recorder?->full_name ?? 'System',
                $transaction->approver?->full_name ?? '-',
            ]);
        }

        fclose($handle);
        exit;
    }

    /**
     * Show pending approvals.
     */
    public function pending()
    {
        // Only pastor and admin can view
        if (! Auth::user()->hasAnyRole(['admin', 'pastor'])) {
            abort(403, 'You do not have permission to view pending approvals.');
        }

        $pendingApprovals = $this->transactionRepository->getPendingApprovals();
        $dualApprovals = $this->transactionRepository->getRequiringDualApproval();

        return view('transactions.pending', compact('pendingApprovals', 'dualApprovals'));
    }

    /**
     * Delete receipt file.
     */
    public function deleteReceipt(Transaction $transaction)
    {
        // Check authorization - only admin, pastor, or the person who recorded the transaction
        if (! Auth::user()->hasAnyRole(['admin', 'pastor', 'staff']) &&
            $transaction->recorded_by !== Auth::id()) {
            abort(403, 'You do not have permission to delete this receipt.');
        }

        if ($transaction->receipt_path) {
            $fileUploadService = app(\App\Services\FileUploadService::class);
            $fileUploadService->deleteFile($transaction->receipt_path);
            $transaction->update(['receipt_path' => null]);
        }

        return redirect()
            ->back()
            ->with('success', 'Receipt deleted successfully.');
    }

    // ========================================
    // FINANCIAL DASHBOARD API ENDPOINTS
    // ========================================

    /**
     * Get financial dashboard summary (API endpoint).
     */
    public function getDashboardSummary(Request $request)
    {
        $period = $request->input('period', 'month'); // month, quarter, year, custom
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        // Calculate date range based on period
        switch ($period) {
            case 'month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'quarter':
                $startDate = now()->startOfQuarter();
                $endDate = now()->endOfQuarter();
                break;
            case 'year':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
            case 'custom':
                $startDate = $dateFrom ? Carbon::parse($dateFrom) : now()->startOfMonth();
                $endDate = $dateTo ? Carbon::parse($dateTo) : now()->endOfMonth();
                break;
            default:
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
        }

        $summary = $this->transactionRepository->getFinancialSummary($startDate, $endDate);
        $incomeBreakdown = $this->transactionRepository->getIncomeBreakdown($startDate, $endDate);
        $expenseBreakdown = $this->transactionRepository->getExpenseBreakdown($startDate, $endDate);

        // Calculate vs previous period
        $previousStartDate = $startDate->copy()->subMonth();
        $previousEndDate = $endDate->copy()->subMonth();
        $previousSummary = $this->transactionRepository->getFinancialSummary($previousStartDate, $previousEndDate);

        $changes = [
            'income_change' => $previousSummary['total_income'] > 0
                ? (($summary['total_income'] - $previousSummary['total_income']) / $previousSummary['total_income'] * 100)
                : 0,
            'expense_change' => $previousSummary['total_expense'] > 0
                ? (($summary['total_expense'] - $previousSummary['total_expense']) / $previousSummary['total_expense'] * 100)
                : 0,
        ];

        return response()->json([
            'success' => true,
            'period' => $period,
            'date_range' => [
                'from' => $startDate->format('Y-m-d'),
                'to' => $endDate->format('Y-m-d'),
            ],
            'summary' => $summary,
            'income_breakdown' => $incomeBreakdown,
            'expense_breakdown' => $expenseBreakdown,
            'changes' => $changes,
        ]);
    }

    /**
     * Get cash flow analysis (API endpoint).
     */
    public function getCashFlow(Request $request)
    {
        $months = $request->input('months', 12);
        $trends = $this->transactionRepository->getMonthlyTrends($months);

        $cashFlow = [];
        $cumulativeBalance = 0;

        foreach ($trends as $trend) {
            $monthlyBalance = $trend->income - $trend->expense;
            $cumulativeBalance += $monthlyBalance;

            $cashFlow[] = [
                'month' => $trend->month,
                'income' => (float) $trend->income,
                'expense' => (float) $trend->expense,
                'net' => $monthlyBalance,
                'cumulative' => $cumulativeBalance,
            ];
        }

        return response()->json([
            'success' => true,
            'months' => $months,
            'cash_flow' => $cashFlow,
            'current_balance' => $cumulativeBalance,
        ]);
    }

    /**
     * Get budget analysis (API endpoint).
     */
    public function getBudgetAnalysis(Request $request)
    {
        $year = $request->input('year', now()->year);

        // Define annual budgets (this should come from a budgets table in production)
        $annualBudgets = [
            'tithe' => 120000,
            'offering' => 80000,
            'special_offering' => 40000,
            'salaries' => 60000,
            'utilities' => 24000,
            'maintenance' => 36000,
            'ministry_programs' => 48000,
            'outreach' => 30000,
        ];

        $startDate = Carbon::createFromDate($year, 1, 1)->startOfYear();
        $endDate = Carbon::createFromDate($year, 12, 31)->endOfYear();

        $actualIncome = $this->transactionRepository->getIncomeBreakdown($startDate, $endDate);
        $actualExpense = $this->transactionRepository->getExpenseBreakdown($startDate, $endDate);

        $budgetAnalysis = [];

        // Income categories
        foreach ($actualIncome as $item) {
            $category = $item->category;
            $actual = (float) $item->total;
            $budget = $annualBudgets[$category] ?? 0;

            if ($budget > 0) {
                $budgetAnalysis[] = [
                    'type' => 'income',
                    'category' => $category,
                    'budget' => $budget,
                    'actual' => $actual,
                    'variance' => $actual - $budget,
                    'variance_percent' => ($actual / $budget * 100) - 100,
                    'status' => $actual >= $budget ? 'on_track' : 'below',
                ];
            }
        }

        // Expense categories
        foreach ($actualExpense as $item) {
            $category = $item->category;
            $actual = (float) $item->total;
            $budget = $annualBudgets[$category] ?? 0;

            if ($budget > 0) {
                $budgetAnalysis[] = [
                    'type' => 'expense',
                    'category' => $category,
                    'budget' => $budget,
                    'actual' => $actual,
                    'variance' => $budget - $actual, // For expenses, under budget is good
                    'variance_percent' => 100 - ($actual / $budget * 100),
                    'status' => $actual <= $budget ? 'on_track' : 'over_budget',
                ];
            }
        }

        return response()->json([
            'success' => true,
            'year' => $year,
            'budget_analysis' => $budgetAnalysis,
        ]);
    }

    /**
     * Get giving analytics (API endpoint).
     */
    public function getGivingAnalytics(Request $request)
    {
        $months = $request->input('months', 12);
        $startDate = now()->subMonths($months);

        // Top donors
        $topDonors = $this->transactionRepository->getTopDonors(10, $startDate, now());

        // Giving frequency analysis
        $givingFrequency = Transaction::where('transaction_type', 'income')
            ->where('transaction_date', '>=', $startDate)
            ->where('status', 'completed')
            ->whereNotNull('member_id')
            ->selectRaw('member_id, COUNT(*) as transaction_count, SUM(amount) as total_amount')
            ->groupBy('member_id')
            ->get()
            ->groupBy(function ($item) {
                if ($item->transaction_count >= 40) return 'weekly';
                if ($item->transaction_count >= 10) return 'bi_weekly';
                if ($item->transaction_count >= 6) return 'monthly';
                return 'occasional';
            })
            ->map(function ($group) {
                return [
                    'count' => $group->count(),
                    'total_amount' => $group->sum('total_amount'),
                ];
            });

        // Giving methods breakdown
        $givingMethods = Transaction::where('transaction_type', 'income')
            ->where('transaction_date', '>=', $startDate)
            ->where('status', 'completed')
            ->selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('payment_method')
            ->get()
            ->map(function ($item) {
                return [
                    'method' => $item->payment_method,
                    'count' => $item->count,
                    'total' => (float) $item->total,
                    'percentage' => 0, // Will be calculated below
                ];
            });

        $totalGiving = $givingMethods->sum('total');
        $givingMethods = $givingMethods->map(function ($item) use ($totalGiving) {
            $item['percentage'] = $totalGiving > 0 ? ($item['total'] / $totalGiving * 100) : 0;
            return $item;
        });

        // Average giving per member
        $avgGivingPerMember = Transaction::where('transaction_type', 'income')
            ->where('transaction_date', '>=', $startDate)
            ->where('status', 'completed')
            ->whereNotNull('member_id')
            ->selectRaw('AVG(amount) as average')
            ->value('average') ?? 0;

        return response()->json([
            'success' => true,
            'months' => $months,
            'top_donors' => $topDonors,
            'giving_frequency' => $givingFrequency,
            'giving_methods' => $givingMethods->values(),
            'average_giving_per_member' => (float) $avgGivingPerMember,
            'total_giving' => $totalGiving,
        ]);
    }

    /**
     * Get expense analytics (API endpoint).
     */
    public function getExpenseAnalytics(Request $request)
    {
        $months = $request->input('months', 12);
        $startDate = now()->subMonths($months);

        // Expense by category
        $expenseByCategory = $this->transactionRepository->getExpenseBreakdown($startDate, now());

        // Monthly expense trend
        $monthlyExpenses = Transaction::where('transaction_type', 'expense')
            ->where('transaction_date', '>=', $startDate)
            ->where('status', 'completed')
            ->selectRaw('DATE_FORMAT(transaction_date, "%Y-%m") as month, category, SUM(amount) as total')
            ->groupBy('month', 'category')
            ->orderBy('month')
            ->get()
            ->groupBy('month')
            ->map(function ($monthGroup) {
                $categories = [];
                foreach ($monthGroup as $item) {
                    $categories[$item->category] = (float) $item->total;
                }
                return [
                    'total' => $monthGroup->sum('total'),
                    'categories' => $categories,
                ];
            });

        // Largest expenses
        $largestExpenses = Transaction::where('transaction_type', 'expense')
            ->where('transaction_date', '>=', $startDate)
            ->where('status', 'completed')
            ->orderBy('amount', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($transaction) {
                return [
                    'date' => $transaction->transaction_date->format('Y-m-d'),
                    'category' => $transaction->category,
                    'amount' => (float) $transaction->amount,
                    'description' => $transaction->description,
                ];
            });

        // Expense by payment method
        $expenseByMethod = Transaction::where('transaction_type', 'expense')
            ->where('transaction_date', '>=', $startDate)
            ->where('status', 'completed')
            ->selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('payment_method')
            ->get();

        return response()->json([
            'success' => true,
            'months' => $months,
            'expense_by_category' => $expenseByCategory,
            'monthly_expenses' => $monthlyExpenses,
            'largest_expenses' => $largestExpenses,
            'expense_by_method' => $expenseByMethod,
        ]);
    }

    /**
     * Get financial forecasting (API endpoint).
     */
    public function getForecasting(Request $request)
    {
        $months = $request->input('forecast_months', 6);
        $basedOnMonths = $request->input('based_on_months', 12);

        $historicalData = $this->transactionRepository->getMonthlyTrends($basedOnMonths);

        if ($historicalData->count() < 3) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient historical data for forecasting. Need at least 3 months of data.',
            ], 400);
        }

        // Calculate averages and growth rates
        $avgIncome = $historicalData->avg('income');
        $avgExpense = $historicalData->avg('expense');

        // Simple linear growth calculation
        $incomeGrowth = $this->calculateGrowthRate($historicalData, 'income');
        $expenseGrowth = $this->calculateGrowthRate($historicalData, 'expense');

        $forecasts = [];
        $lastDate = now();

        for ($i = 1; $i <= $months; $i++) {
            $forecastDate = $lastDate->copy()->addMonths($i);
            $projectedIncome = $avgIncome * (1 + ($incomeGrowth * $i / 100));
            $projectedExpense = $avgExpense * (1 + ($expenseGrowth * $i / 100));

            $forecasts[] = [
                'month' => $forecastDate->format('Y-m'),
                'projected_income' => round($projectedIncome, 2),
                'projected_expense' => round($projectedExpense, 2),
                'projected_net' => round($projectedIncome - $projectedExpense, 2),
                'confidence' => max(90 - ($i * 10), 50), // Confidence decreases over time
            ];
        }

        return response()->json([
            'success' => true,
            'forecast_months' => $months,
            'based_on_months' => $basedOnMonths,
            'historical_averages' => [
                'income' => round($avgIncome, 2),
                'expense' => round($avgExpense, 2),
            ],
            'growth_rates' => [
                'income' => round($incomeGrowth, 2),
                'expense' => round($expenseGrowth, 2),
            ],
            'forecasts' => $forecasts,
        ]);
    }

    /**
     * Calculate growth rate from historical data.
     */
    protected function calculateGrowthRate($historicalData, $field)
    {
        if ($historicalData->count() < 2) {
            return 0;
        }

        $first = $historicalData->first()->$field;
        $last = $historicalData->last()->$field;
        $periods = $historicalData->count() - 1;

        if ($first == 0) {
            return 0;
        }

        // Calculate compound monthly growth rate
        return (pow($last / $first, 1 / $periods) - 1) * 100;
    }
}
