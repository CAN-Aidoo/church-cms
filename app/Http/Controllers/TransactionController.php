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
}
