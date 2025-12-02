<?php

namespace App\Http\Controllers;

use App\Models\WelfareCase;
use App\Models\WelfareProgram;
use App\Repositories\WelfareRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WelfareController extends Controller
{
    public function __construct(
        private WelfareRepository $repository
    ) {}

    /**
     * Display welfare dashboard.
     */
    public function index()
    {
        $statistics = $this->repository->getDashboardStatistics();
        $pendingCases = $this->repository->getPendingCases();
        $highPriorityCases = $this->repository->getHighPriorityCases();
        $activePrograms = $this->repository->getActivePrograms();

        return view('welfare.index', compact('statistics', 'pendingCases', 'highPriorityCases', 'activePrograms'));
    }

    /**
     * Display cases list.
     */
    public function cases(Request $request)
    {
        $filters = $request->only(['status', 'case_category', 'priority', 'verification_status', 'beneficiary_id', 'date_from', 'date_to']);
        $cases = $this->repository->getCases($filters);

        return view('welfare.cases.index', compact('cases', 'filters'));
    }

    /**
     * Show case details.
     */
    public function showCase(WelfareCase $case)
    {
        $case->load(['beneficiary', 'submittedBy', 'verifiedBy', 'approvedBy', 'visits', 'transactions', 'impactAssessments', 'committeeDecisions']);

        return view('welfare.cases.show', compact('case'));
    }

    /**
     * Show create case form.
     */
    public function createCase(Request $request)
    {
        $categories = WelfareCase::CATEGORIES;
        $memberId = $request->input('member_id');
        $member = $memberId ? \App\Models\Member::find($memberId) : null;

        return view('welfare.cases.create', compact('categories', 'member'));
    }

    /**
     * Store new case.
     */
    public function storeCase(Request $request)
    {
        $validated = $request->validate([
            'beneficiary_id' => 'nullable|exists:members,id',
            'beneficiary_name' => 'required_without:beneficiary_id|string|max:255',
            'beneficiary_phone' => 'nullable|string|max:20',
            'beneficiary_email' => 'nullable|email',
            'address' => 'nullable|string',
            'case_category' => 'required|in:medical,education,housing,food,emergency,bereavement,job_loss,other',
            'case_title' => 'required|string|max:255',
            'case_description' => 'required|string',
            'amount_requested' => 'nullable|numeric|min:0',
            'priority' => 'required|in:low,medium,high,critical',
            'supporting_documents' => 'nullable|array',
        ]);

        // If beneficiary is a member, auto-fill their details
        if (isset($validated['beneficiary_id'])) {
            $member = \App\Models\Member::find($validated['beneficiary_id']);
            $validated['beneficiary_name'] = $member->full_name;
            $validated['beneficiary_phone'] = $member->phone;
            $validated['beneficiary_email'] = $member->email;
            $validated['address'] = $member->address;
        }

        $case = $this->repository->createCase($validated);

        return redirect()
            ->route('welfare.cases.show', $case)
            ->with('success', 'Case submitted successfully.');
    }

    /**
     * Update case.
     */
    public function updateCase(Request $request, WelfareCase $case)
    {
        $validated = $request->validate([
            'case_title' => 'required|string|max:255',
            'case_description' => 'required|string',
            'amount_requested' => 'nullable|numeric|min:0',
            'priority' => 'required|in:low,medium,high,critical',
        ]);

        $case->update($validated);

        return redirect()
            ->route('welfare.cases.show', $case)
            ->with('success', 'Case updated successfully.');
    }

    /**
     * Mark case as under review.
     */
    public function markUnderReview(WelfareCase $case)
    {
        $case->markUnderReview();

        return redirect()
            ->back()
            ->with('success', 'Case marked as under review.');
    }

    /**
     * Verify case.
     */
    public function verifyCase(Request $request, WelfareCase $case)
    {
        $validated = $request->validate([
            'verification_notes' => 'nullable|string',
        ]);

        $case->verify(auth()->id(), $validated['verification_notes'] ?? null);

        return redirect()
            ->back()
            ->with('success', 'Case verified successfully.');
    }

    /**
     * Reject verification.
     */
    public function rejectVerification(Request $request, WelfareCase $case)
    {
        $validated = $request->validate([
            'verification_notes' => 'required|string',
        ]);

        $case->rejectVerification(auth()->id(), $validated['verification_notes']);

        return redirect()
            ->back()
            ->with('success', 'Verification rejected.');
    }

    /**
     * Approve case.
     */
    public function approveCase(Request $request, WelfareCase $case)
    {
        $validated = $request->validate([
            'amount_approved' => 'required|numeric|min:0',
            'approval_notes' => 'nullable|string',
        ]);

        $case->approve($validated['amount_approved'], auth()->id(), $validated['approval_notes'] ?? null);

        return redirect()
            ->back()
            ->with('success', 'Case approved successfully.');
    }

    /**
     * Reject case.
     */
    public function rejectCase(Request $request, WelfareCase $case)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $case->reject($validated['rejection_reason']);

        return redirect()
            ->back()
            ->with('success', 'Case rejected.');
    }

    /**
     * Close case.
     */
    public function closeCase(WelfareCase $case)
    {
        $case->close();

        return redirect()
            ->back()
            ->with('success', 'Case closed successfully.');
    }

    /**
     * Display programs list.
     */
    public function programs(Request $request)
    {
        $filters = $request->only(['program_type', 'status']);
        $programs = $this->repository->getPrograms($filters);

        return view('welfare.programs.index', compact('programs', 'filters'));
    }

    /**
     * Show program details.
     */
    public function showProgram(WelfareProgram $program)
    {
        $program->load(['coordinator', 'beneficiaries.beneficiary']);
        $statistics = $this->repository->getProgramStatistics($program);

        return view('welfare.programs.show', compact('program', 'statistics'));
    }

    /**
     * Show create program form.
     */
    public function createProgram()
    {
        $programTypes = WelfareProgram::PROGRAM_TYPES;

        return view('welfare.programs.create', compact('programTypes'));
    }

    /**
     * Store new program.
     */
    public function storeProgram(Request $request)
    {
        $validated = $request->validate([
            'program_name' => 'required|string|max:255',
            'program_type' => 'required|in:widows_orphans,elderly_care,scholarships,medical_assistance,food_bank,disaster_relief,other',
            'description' => 'nullable|string',
            'budget_allocated' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'eligibility_criteria' => 'nullable|array',
            'coordinator_id' => 'required|exists:users,id',
        ]);

        $validated['status'] = 'active';

        $program = $this->repository->createProgram($validated);

        return redirect()
            ->route('welfare.programs.show', $program)
            ->with('success', 'Program created successfully.');
    }

    /**
     * Update program.
     */
    public function updateProgram(Request $request, WelfareProgram $program)
    {
        $validated = $request->validate([
            'program_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'budget_allocated' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'eligibility_criteria' => 'nullable|array',
            'coordinator_id' => 'required|exists:users,id',
        ]);

        $program->update($validated);

        return redirect()
            ->route('welfare.programs.show', $program)
            ->with('success', 'Program updated successfully.');
    }

    /**
     * Activate program.
     */
    public function activateProgram(WelfareProgram $program)
    {
        $program->activate();

        return redirect()
            ->back()
            ->with('success', 'Program activated.');
    }

    /**
     * Pause program.
     */
    public function pauseProgram(WelfareProgram $program)
    {
        $program->pause();

        return redirect()
            ->back()
            ->with('success', 'Program paused.');
    }

    /**
     * Complete program.
     */
    public function completeProgram(WelfareProgram $program)
    {
        $program->complete();

        return redirect()
            ->back()
            ->with('success', 'Program completed.');
    }

    /**
     * Display fund transactions.
     */
    public function fundTransactions(Request $request)
    {
        $filters = $request->only(['type', 'category', 'date_from', 'date_to']);
        $transactions = $this->repository->getTransactions($filters);
        $balance = $this->repository->getFundBalance();

        return view('welfare.fund-transactions', compact('transactions', 'filters', 'balance'));
    }

    /**
     * Record fund transaction.
     */
    public function recordTransaction(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:collection,disbursement,transfer,adjustment',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'case_id' => 'nullable|exists:welfare_cases,id',
            'member_id' => 'nullable|exists:members,id',
            'reference_number' => 'nullable|string|max:255',
            'payment_method' => 'nullable|in:cash,bank_transfer,cheque,mobile_money,other',
            'notes' => 'nullable|string',
        ]);

        $transaction = $this->repository->createTransaction($validated);

        // If disbursement for a case, update case disbursed amount
        if ($validated['type'] === 'disbursement' && $validated['case_id']) {
            $case = WelfareCase::find($validated['case_id']);
            $case->recordDisbursement($validated['amount']);
        }

        return redirect()
            ->route('welfare.fund-transactions')
            ->with('success', 'Transaction recorded successfully.');
    }

    /**
     * Display reports.
     */
    public function reports(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonths(3)->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $report = $this->repository->getWelfareReport(
            Carbon::parse($startDate),
            Carbon::parse($endDate)
        );

        return view('welfare.reports', compact('report', 'startDate', 'endDate'));
    }
}
