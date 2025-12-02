<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Repositories\MemberRepository;
use App\Services\MemberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function __construct(
        protected MemberRepository $memberRepository,
        protected MemberService $memberService
    ) {}

    /**
     * Display a listing of members.
     */
    public function index(Request $request)
    {
        $filters = $request->only([
            'search', 'status', 'gender', 'marital_status',
            'age_min', 'age_max', 'join_date_from', 'join_date_to',
            'sort_by', 'sort_order',
        ]);

        $perPage = $request->input('per_page', 15);
        $members = $this->memberRepository->getPaginated($filters, $perPage);
        $statistics = $this->memberRepository->getStatistics();

        return view('members.index', compact('members', 'statistics', 'filters'));
    }

    /**
     * Show the form for creating a new member.
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Store a newly created member.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:members,email',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date|before:today',
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'marital_status' => ['required', Rule::in(['single', 'married', 'divorced', 'widowed'])],
            'address' => 'required|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'join_date' => 'required|date',
            'member_status' => ['nullable', Rule::in(['active', 'inactive', 'pending', 'suspended'])],
            'occupation' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $this->memberService->uploadMemberPhoto($request->file('photo'));
            $validated['photo_url'] = $photoPath;
        }

        // Set default member status
        $validated['member_status'] = $validated['member_status'] ?? 'active';

        // Create member
        $member = $this->memberRepository->create($validated);

        return redirect()
            ->route('members.show', $member)
            ->with('success', 'Member created successfully.');
    }

    /**
     * Display the specified member.
     */
    public function show(Member $member)
    {
        // Get member statistics
        $attendanceStats = $member->getAttendanceStats();
        $financialSummary = $member->getFinancialSummary();
        $engagement = $this->memberService->checkMemberEngagement($member);

        // Get recent activity
        $recentAttendance = $member->attendance()
            ->orderBy('service_date', 'desc')
            ->limit(10)
            ->get();

        $recentTransactions = $member->transactions()
            ->orderBy('transaction_date', 'desc')
            ->limit(10)
            ->get();

        return view('members.show', compact(
            'member',
            'attendanceStats',
            'financialSummary',
            'engagement',
            'recentAttendance',
            'recentTransactions'
        ));
    }

    /**
     * Show the form for editing the specified member.
     */
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    /**
     * Update the specified member.
     */
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('members', 'email')->ignore($member->id)],
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date|before:today',
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'marital_status' => ['required', Rule::in(['single', 'married', 'divorced', 'widowed'])],
            'address' => 'required|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'join_date' => 'required|date',
            'member_status' => ['required', Rule::in(['active', 'inactive', 'pending', 'suspended'])],
            'occupation' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($member->photo_url) {
                Storage::disk('public')->delete($member->photo_url);
            }

            $photoPath = $this->memberService->uploadMemberPhoto($request->file('photo'));
            $validated['photo_url'] = $photoPath;
        }

        // Update member
        $this->memberRepository->update($member, $validated);

        return redirect()
            ->route('members.show', $member)
            ->with('success', 'Member updated successfully.');
    }

    /**
     * Remove the specified member.
     */
    public function destroy(Member $member)
    {
        // Check if user can delete members
        if (! Auth::user()->hasAnyRole(['admin', 'pastor'])) {
            abort(403, 'You do not have permission to delete members.');
        }

        $this->memberRepository->delete($member);

        return redirect()
            ->route('members.index')
            ->with('success', 'Member deleted successfully.');
    }

    /**
     * Export members to CSV.
     */
    public function export(Request $request)
    {
        $filters = $request->only([
            'search', 'status', 'gender', 'marital_status',
            'age_min', 'age_max', 'join_date_from', 'join_date_to',
        ]);

        $members = $this->memberRepository->export($filters);

        $filename = 'members_'.date('Y-m-d_His').'.csv';
        $handle = fopen('php://output', 'w');

        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');

        // Add CSV header
        fputcsv($handle, [
            'Member ID', 'First Name', 'Last Name', 'Email', 'Phone',
            'Date of Birth', 'Age', 'Gender', 'Marital Status',
            'Address', 'City', 'State', 'Country', 'Postal Code',
            'Join Date', 'Status', 'Occupation', 'Department',
            'Emergency Contact', 'Emergency Phone',
        ]);

        // Add member data
        foreach ($members as $member) {
            fputcsv($handle, [
                $member->member_id,
                $member->first_name,
                $member->last_name,
                $member->email,
                $member->phone,
                $member->date_of_birth?->format('Y-m-d'),
                $member->age,
                ucfirst($member->gender),
                ucfirst($member->marital_status),
                $member->address,
                $member->city,
                $member->state,
                $member->country,
                $member->postal_code,
                $member->join_date->format('Y-m-d'),
                ucfirst($member->member_status),
                $member->occupation,
                $member->department,
                $member->emergency_contact_name,
                $member->emergency_contact_phone,
            ]);
        }

        fclose($handle);
        exit;
    }

    /**
     * Bulk actions on members.
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => ['required', Rule::in(['activate', 'deactivate', 'suspend', 'delete'])],
            'member_ids' => 'required|array|min:1',
            'member_ids.*' => 'exists:members,id',
        ]);

        $memberIds = $validated['member_ids'];
        $action = $validated['action'];

        switch ($action) {
            case 'activate':
                $this->memberRepository->bulkUpdateStatus($memberIds, 'active');
                $message = 'Members activated successfully.';
                break;

            case 'deactivate':
                $this->memberRepository->bulkUpdateStatus($memberIds, 'inactive');
                $message = 'Members deactivated successfully.';
                break;

            case 'suspend':
                $this->memberRepository->bulkUpdateStatus($memberIds, 'suspended');
                $message = 'Members suspended successfully.';
                break;

            case 'delete':
                if (! Auth::user()->hasAnyRole(['admin', 'pastor'])) {
                    abort(403, 'You do not have permission to delete members.');
                }

                Member::whereIn('id', $memberIds)->delete();
                $message = 'Members deleted successfully.';
                break;
        }

        return redirect()
            ->route('members.index')
            ->with('success', $message);
    }

    /**
     * Search members (AJAX).
     */
    public function search(Request $request)
    {
        $term = $request->input('term', '');
        $members = $this->memberRepository->search($term);

        return response()->json([
            'results' => $members->map(function ($member) {
                return [
                    'id' => $member->id,
                    'text' => $member->full_name.' ('.$member->email.')',
                    'member_id' => $member->member_id,
                    'email' => $member->email,
                    'phone' => $member->phone,
                ];
            }),
        ]);
    }

    /**
     * Show member statistics page.
     */
    public function statistics()
    {
        $statistics = $this->memberService->getMemberStatistics();
        $demographics = $this->memberService->getMemberDemographics();
        $upcomingBirthdays = $this->memberRepository->getUpcomingBirthdays(30);
        $incompleteProfiles = $this->memberRepository->getIncompleteProfiles();

        return view('members.statistics', compact(
            'statistics',
            'demographics',
            'upcomingBirthdays',
            'incompleteProfiles'
        ));
    }

    /**
     * Delete member photo.
     */
    public function deletePhoto(Member $member)
    {
        if ($member->photo_url) {
            Storage::disk('public')->delete($member->photo_url);
            $member->update(['photo_url' => null]);
        }

        return redirect()
            ->back()
            ->with('success', 'Photo deleted successfully.');
    }
}
