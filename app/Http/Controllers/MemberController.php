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

    // ========================================
    // MEMBER PORTAL API ENDPOINTS
    // ========================================

    /**
     * Get member's own profile (authenticated member).
     */
    public function getMyProfile(Request $request)
    {
        $user = $request->user();
        $member = $user->member;

        if (! $member) {
            return response()->json([
                'success' => false,
                'message' => 'No member profile found for this user.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'member' => [
                'id' => $member->id,
                'member_id' => $member->member_id,
                'first_name' => $member->first_name,
                'last_name' => $member->last_name,
                'full_name' => $member->full_name,
                'email' => $member->email,
                'phone' => $member->phone,
                'date_of_birth' => $member->date_of_birth?->format('Y-m-d'),
                'age' => $member->age,
                'gender' => $member->gender,
                'marital_status' => $member->marital_status,
                'address' => $member->address,
                'city' => $member->city,
                'state' => $member->state,
                'country' => $member->country,
                'postal_code' => $member->postal_code,
                'join_date' => $member->join_date->format('Y-m-d'),
                'member_status' => $member->member_status,
                'occupation' => $member->occupation,
                'department' => $member->department,
                'photo_url' => $member->photo_url ? asset('storage/'.$member->photo_url) : null,
                'emergency_contact_name' => $member->emergency_contact_name,
                'emergency_contact_phone' => $member->emergency_contact_phone,
            ],
        ]);
    }

    /**
     * Update member's own profile (authenticated member).
     */
    public function updateMyProfile(Request $request)
    {
        $user = $request->user();
        $member = $user->member;

        if (! $member) {
            return response()->json([
                'success' => false,
                'message' => 'No member profile found for this user.',
            ], 404);
        }

        // Members can only update limited fields
        $validated = $request->validate([
            'phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:100',
            'state' => 'sometimes|string|max:100',
            'postal_code' => 'sometimes|string|max:20',
            'occupation' => 'sometimes|string|max:100',
            'emergency_contact_name' => 'sometimes|string|max:100',
            'emergency_contact_phone' => 'sometimes|string|max:20',
        ]);

        $member->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'member' => $member->fresh(),
        ]);
    }

    /**
     * Get member's attendance history.
     */
    public function getMyAttendance(Request $request)
    {
        $user = $request->user();
        $member = $user->member;

        if (! $member) {
            return response()->json(['success' => false, 'message' => 'No member profile found.'], 404);
        }

        $months = $request->input('months', 6);
        $startDate = now()->subMonths($months);

        $attendance = $member->attendance()
            ->where('service_date', '>=', $startDate)
            ->orderBy('service_date', 'desc')
            ->get()
            ->map(function ($record) {
                return [
                    'id' => $record->id,
                    'service_date' => $record->service_date->format('Y-m-d'),
                    'service_type' => $record->service_type,
                    'check_in_time' => $record->check_in_time,
                    'check_in_method' => $record->check_in_method,
                ];
            });

        $stats = $member->getAttendanceStats();

        return response()->json([
            'success' => true,
            'attendance' => $attendance,
            'statistics' => [
                'total_attendance' => $stats['total_attendance'],
                'attendance_rate' => $stats['attendance_rate'],
                'consecutive_attendance' => $stats['consecutive_attendance'],
                'last_attendance' => $stats['last_attendance'],
            ],
        ]);
    }

    /**
     * Get member's contribution history.
     */
    public function getMyContributions(Request $request)
    {
        $user = $request->user();
        $member = $user->member;

        if (! $member) {
            return response()->json(['success' => false, 'message' => 'No member profile found.'], 404);
        }

        $months = $request->input('months', 12);
        $startDate = now()->subMonths($months);

        $contributions = $member->transactions()
            ->where('transaction_type', 'income')
            ->where('transaction_date', '>=', $startDate)
            ->orderBy('transaction_date', 'desc')
            ->get()
            ->map(function ($transaction) {
                return [
                    'id' => $transaction->id,
                    'transaction_date' => $transaction->transaction_date->format('Y-m-d'),
                    'amount' => $transaction->amount,
                    'category' => $transaction->category,
                    'description' => $transaction->description,
                    'payment_method' => $transaction->payment_method,
                    'status' => $transaction->status,
                ];
            });

        $summary = $member->getFinancialSummary();

        return response()->json([
            'success' => true,
            'contributions' => $contributions,
            'summary' => [
                'total_giving' => $summary['total_giving'],
                'this_year_giving' => $summary['this_year_giving'],
                'last_contribution_date' => $summary['last_contribution_date'],
                'giving_frequency' => $summary['giving_frequency'],
            ],
        ]);
    }

    /**
     * Get member's program registrations.
     */
    public function getMyPrograms(Request $request)
    {
        $user = $request->user();
        $member = $user->member;

        if (! $member) {
            return response()->json(['success' => false, 'message' => 'No member profile found.'], 404);
        }

        $registrations = $member->programRegistrations()
            ->with('program')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($registration) {
                return [
                    'id' => $registration->id,
                    'program' => [
                        'id' => $registration->program->id,
                        'program_code' => $registration->program->program_code,
                        'title' => $registration->program->title,
                        'start_date' => $registration->program->start_date->format('Y-m-d'),
                        'end_date' => $registration->program->end_date?->format('Y-m-d'),
                        'status' => $registration->program->status,
                    ],
                    'registration_date' => $registration->created_at->format('Y-m-d'),
                    'status' => $registration->status,
                    'checked_in' => $registration->checked_in,
                    'check_in_time' => $registration->check_in_time,
                ];
            });

        return response()->json([
            'success' => true,
            'registrations' => $registrations,
            'total' => $registrations->count(),
        ]);
    }

    /**
     * Get member's service units and ministry involvement.
     */
    public function getMyMinistry(Request $request)
    {
        $user = $request->user();
        $member = $user->member;

        if (! $member) {
            return response()->json(['success' => false, 'message' => 'No member profile found.'], 404);
        }

        $serviceUnits = $member->serviceUnits()
            ->with('leader')
            ->get()
            ->map(function ($unit) use ($member) {
                $memberUnit = $unit->members()->where('member_id', $member->id)->first();

                return [
                    'id' => $unit->id,
                    'unit_name' => $unit->unit_name,
                    'description' => $unit->description,
                    'leader' => $unit->leader ? [
                        'id' => $unit->leader->id,
                        'full_name' => $unit->leader->full_name,
                    ] : null,
                    'position' => $memberUnit->pivot->position ?? null,
                    'joined_date' => $memberUnit->pivot->joined_date ?? null,
                    'is_active' => $memberUnit->pivot->is_active ?? true,
                ];
            });

        return response()->json([
            'success' => true,
            'service_units' => $serviceUnits,
            'total' => $serviceUnits->count(),
        ]);
    }

    /**
     * Get member's shepherd/pastoral care information.
     */
    public function getMyShepherd(Request $request)
    {
        $user = $request->user();
        $member = $user->member;

        if (! $member) {
            return response()->json(['success' => false, 'message' => 'No member profile found.'], 404);
        }

        $shepherd = $member->shepherd;

        if (! $shepherd) {
            return response()->json([
                'success' => true,
                'shepherd' => null,
                'message' => 'No shepherd assigned yet.',
            ]);
        }

        return response()->json([
            'success' => true,
            'shepherd' => [
                'id' => $shepherd->id,
                'full_name' => $shepherd->full_name,
                'email' => $shepherd->email,
                'phone' => $shepherd->phone,
                'flock_name' => $shepherd->flock_name,
                'meeting_schedule' => $shepherd->meeting_schedule,
            ],
        ]);
    }

    /**
     * Get member's family members.
     */
    public function getMyFamily(Request $request)
    {
        $user = $request->user();
        $member = $user->member;

        if (! $member) {
            return response()->json(['success' => false, 'message' => 'No member profile found.'], 404);
        }

        $family = $member->family;

        if (! $family) {
            return response()->json([
                'success' => true,
                'family' => null,
                'members' => [],
                'message' => 'Not part of any family unit.',
            ]);
        }

        $familyMembers = $family->members()
            ->where('id', '!=', $member->id)
            ->get()
            ->map(function ($familyMember) {
                return [
                    'id' => $familyMember->id,
                    'member_id' => $familyMember->member_id,
                    'full_name' => $familyMember->full_name,
                    'relationship' => $familyMember->pivot->relationship ?? 'family_member',
                    'photo_url' => $familyMember->photo_url ? asset('storage/'.$familyMember->photo_url) : null,
                ];
            });

        return response()->json([
            'success' => true,
            'family' => [
                'id' => $family->id,
                'family_name' => $family->family_name,
                'head_of_family_id' => $family->head_of_family_id,
            ],
            'members' => $familyMembers,
            'total_members' => $familyMembers->count() + 1, // +1 for the member themselves
        ]);
    }

    /**
     * Get member's documents.
     */
    public function getMyDocuments(Request $request)
    {
        $user = $request->user();
        $member = $user->member;

        if (! $member) {
            return response()->json(['success' => false, 'message' => 'No member profile found.'], 404);
        }

        $documents = $member->documents()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($doc) {
                return [
                    'id' => $doc->id,
                    'document_type' => $doc->document_type,
                    'title' => $doc->title,
                    'description' => $doc->description,
                    'file_path' => $doc->file_path,
                    'file_size' => $doc->file_size,
                    'uploaded_at' => $doc->created_at->format('Y-m-d H:i:s'),
                    'download_url' => route('api.member.documents.download', $doc->id),
                ];
            });

        return response()->json([
            'success' => true,
            'documents' => $documents,
            'total' => $documents->count(),
        ]);
    }

    /**
     * Download member document.
     */
    public function downloadDocument(Request $request, $documentId)
    {
        $user = $request->user();
        $member = $user->member;

        if (! $member) {
            return response()->json(['success' => false, 'message' => 'No member profile found.'], 404);
        }

        $document = $member->documents()->find($documentId);

        if (! $document) {
            return response()->json(['success' => false, 'message' => 'Document not found.'], 404);
        }

        $filePath = storage_path('app/private/member_documents/'.$document->file_path);

        if (! file_exists($filePath)) {
            return response()->json(['success' => false, 'message' => 'File not found on server.'], 404);
        }

        return response()->download($filePath, $document->title);
    }

    /**
     * Get member's upcoming events and important dates.
     */
    public function getMyUpcomingEvents(Request $request)
    {
        $user = $request->user();
        $member = $user->member;

        if (! $member) {
            return response()->json(['success' => false, 'message' => 'No member profile found.'], 404);
        }

        $events = [];

        // Upcoming programs
        $upcomingPrograms = \App\Models\Program::where('status', 'published')
            ->where('start_date', '>', now())
            ->orderBy('start_date')
            ->limit(10)
            ->get()
            ->map(function ($program) {
                return [
                    'type' => 'program',
                    'id' => $program->id,
                    'title' => $program->title,
                    'date' => $program->start_date->format('Y-m-d'),
                    'time' => $program->start_time,
                    'location' => $program->location,
                ];
            });

        // Birthday
        $nextBirthday = $member->date_of_birth
            ? $member->date_of_birth->setYear(now()->year)
            : null;

        if ($nextBirthday && $nextBirthday < now()) {
            $nextBirthday = $nextBirthday->setYear(now()->year + 1);
        }

        if ($nextBirthday) {
            $events[] = [
                'type' => 'birthday',
                'title' => 'Your Birthday',
                'date' => $nextBirthday->format('Y-m-d'),
                'time' => null,
            ];
        }

        // Merge and sort all events
        $allEvents = collect($events)->merge($upcomingPrograms)
            ->sortBy('date')
            ->values()
            ->all();

        return response()->json([
            'success' => true,
            'events' => $allEvents,
            'total' => count($allEvents),
        ]);
    }
}
