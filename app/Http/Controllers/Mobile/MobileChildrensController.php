<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\ChildCheckIn;
use App\Models\ChildIncident;
use App\Models\Member;
use App\Services\NotificationService;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MobileChildrensController extends Controller
{
    public function __construct(
        protected QrCodeService $qrCodeService,
        protected NotificationService $notificationService
    ) {}

    /**
     * Check in a child to children's ministry.
     */
    public function checkIn(Request $request)
    {
        $validated = $request->validate([
            'child_id' => 'required|exists:children,id',
            'service_type' => 'required|string',
            'allergies_confirmed' => 'required|boolean',
            'medical_notes' => 'nullable|string|max:500',
            'authorized_pickup_person' => 'nullable|string',
        ]);

        $user = $request->user();
        $member = $user->member;

        if (! $member) {
            return response()->json([
                'success' => false,
                'message' => 'No member profile found',
            ], 404);
        }

        // Get child and verify parent relationship
        $child = Child::find($validated['child_id']);

        if ($child->parent_id !== $member->id && $child->guardian_id !== $member->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to check in this child',
            ], 403);
        }

        // Check if child is already checked in today
        $existingCheckIn = ChildCheckIn::where('child_id', $child->id)
            ->whereDate('check_in_time', today())
            ->whereNull('check_out_time')
            ->first();

        if ($existingCheckIn) {
            return response()->json([
                'success' => false,
                'message' => 'Child is already checked in',
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Generate security code
            $securityCodeData = $this->qrCodeService->generateChildrenSecurityCode(
                $child->id,
                $member->id
            );

            // Create check-in record
            $checkIn = ChildCheckIn::create([
                'child_id' => $child->id,
                'parent_id' => $member->id,
                'check_in_time' => now(),
                'service_type' => $validated['service_type'],
                'security_code' => $securityCodeData['security_code'],
                'class_assigned' => $this->assignClass($child->age),
                'allergies_confirmed' => $validated['allergies_confirmed'],
                'medical_notes' => $validated['medical_notes'] ?? null,
                'authorized_pickup' => $validated['authorized_pickup_person'] ?? null,
                'checked_in_by' => $user->id,
            ]);

            DB::commit();

            // Send notification to parent
            $this->notificationService->send($user, [
                'title' => 'Child Checked In',
                'message' => "{$child->first_name} has been checked in to {$checkIn->class_assigned}. Security code: {$securityCodeData['security_code']}",
                'type' => 'child_checkin',
                'priority' => 'normal',
            ]);

            // Notify children's ministry staff
            $this->notifyChildrensStaff('check-in', $child, $checkIn);

            return response()->json([
                'success' => true,
                'message' => 'Child checked in successfully',
                'data' => [
                    'check_in_id' => $checkIn->id,
                    'child_name' => $child->full_name,
                    'security_code' => $securityCodeData['security_code'],
                    'class_assigned' => $checkIn->class_assigned,
                    'check_in_time' => $checkIn->check_in_time,
                    'pickup_instructions' => [
                        'security_code_required' => true,
                        'photo_id_required' => true,
                        'must_match_authorized_list' => true,
                    ],
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Check-in failed: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check out a child from children's ministry.
     */
    public function checkOut(Request $request)
    {
        $validated = $request->validate([
            'child_id' => 'required|exists:children,id',
            'security_code' => 'required|string|size:4',
            'pickup_person_name' => 'required|string',
            'photo_id_verified' => 'required|boolean',
        ]);

        $user = $request->user();
        $member = $user->member;

        // Get active check-in for today
        $checkIn = ChildCheckIn::where('child_id', $validated['child_id'])
            ->whereDate('check_in_time', today())
            ->whereNull('check_out_time')
            ->first();

        if (! $checkIn) {
            return response()->json([
                'success' => false,
                'message' => 'No active check-in found for this child',
            ], 404);
        }

        // Verify security code
        $isValidCode = $this->qrCodeService->validateSecurityCode(
            $validated['child_id'],
            $validated['security_code']
        );

        if (! $isValidCode) {
            // Log security violation
            $this->logSecurityViolation($checkIn, 'Invalid security code attempt');

            return response()->json([
                'success' => false,
                'message' => 'Invalid security code',
            ], 403);
        }

        // Verify parent/guardian relationship
        if ($checkIn->parent_id !== $member->id) {
            $child = $checkIn->child;
            if ($child->guardian_id !== $member->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to pick up this child',
                ], 403);
            }
        }

        // Verify photo ID if required
        if (! $validated['photo_id_verified']) {
            return response()->json([
                'success' => false,
                'message' => 'Photo ID verification required',
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Update check-in record
            $checkIn->update([
                'check_out_time' => now(),
                'checked_out_by' => $user->id,
                'pickup_person' => $validated['pickup_person_name'],
                'photo_id_verified' => true,
            ]);

            DB::commit();

            // Send notification to parent
            $this->notificationService->send($user, [
                'title' => 'Child Picked Up',
                'message' => "{$checkIn->child->first_name} has been picked up by {$validated['pickup_person_name']}",
                'type' => 'child_checkout',
                'priority' => 'normal',
            ]);

            // Notify children's ministry staff
            $this->notifyChildrensStaff('check-out', $checkIn->child, $checkIn);

            return response()->json([
                'success' => true,
                'message' => 'Child checked out successfully',
                'data' => [
                    'child_name' => $checkIn->child->full_name,
                    'check_in_time' => $checkIn->check_in_time,
                    'check_out_time' => $checkIn->check_out_time,
                    'duration_hours' => $checkIn->check_in_time->diffInHours($checkIn->check_out_time),
                    'picked_up_by' => $validated['pickup_person_name'],
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Check-out failed: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get user's children.
     */
    public function getMyChildren(Request $request)
    {
        $user = $request->user();
        $member = $user->member;

        if (! $member) {
            return response()->json([
                'success' => false,
                'message' => 'No member profile found',
            ], 404);
        }

        // Get children where member is parent or guardian
        $children = Child::where(function ($query) use ($member) {
            $query->where('parent_id', $member->id)
                ->orWhere('guardian_id', $member->id);
        })->get();

        return response()->json([
            'success' => true,
            'data' => [
                'children' => $children->map(function ($child) {
                    // Get current check-in status
                    $currentCheckIn = ChildCheckIn::where('child_id', $child->id)
                        ->whereDate('check_in_time', today())
                        ->whereNull('check_out_time')
                        ->first();

                    // Get attendance stats
                    $attendanceCount = ChildCheckIn::where('child_id', $child->id)
                        ->whereMonth('check_in_time', now()->month)
                        ->count();

                    return [
                        'id' => $child->id,
                        'full_name' => $child->full_name,
                        'date_of_birth' => $child->date_of_birth,
                        'age' => $child->age,
                        'gender' => $child->gender,
                        'photo_url' => $child->photo_url,
                        'allergies' => $child->allergies,
                        'medical_conditions' => $child->medical_conditions,
                        'emergency_contact' => $child->emergency_contact_name,
                        'emergency_phone' => $child->emergency_contact_phone,
                        'current_status' => $currentCheckIn ? [
                            'is_checked_in' => true,
                            'check_in_time' => $currentCheckIn->check_in_time,
                            'class_assigned' => $currentCheckIn->class_assigned,
                            'security_code' => $currentCheckIn->security_code,
                        ] : [
                            'is_checked_in' => false,
                        ],
                        'attendance_this_month' => $attendanceCount,
                    ];
                }),
                'summary' => [
                    'total_children' => $children->count(),
                    'checked_in_now' => $children->filter(function ($child) {
                        return ChildCheckIn::where('child_id', $child->id)
                            ->whereDate('check_in_time', today())
                            ->whereNull('check_out_time')
                            ->exists();
                    })->count(),
                ],
            ],
        ]);
    }

    /**
     * Generate security code for child pickup.
     */
    public function generateSecurityCode(Request $request)
    {
        $validated = $request->validate([
            'child_id' => 'required|exists:children,id',
        ]);

        $user = $request->user();
        $member = $user->member;

        $child = Child::find($validated['child_id']);

        // Verify parent relationship
        if ($child->parent_id !== $member->id && $child->guardian_id !== $member->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to generate code for this child',
            ], 403);
        }

        // Check if child has active check-in
        $activeCheckIn = ChildCheckIn::where('child_id', $child->id)
            ->whereDate('check_in_time', today())
            ->whereNull('check_out_time')
            ->first();

        if (! $activeCheckIn) {
            return response()->json([
                'success' => false,
                'message' => 'Child is not currently checked in',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'child_name' => $child->full_name,
                'security_code' => $activeCheckIn->security_code,
                'class_assigned' => $activeCheckIn->class_assigned,
                'check_in_time' => $activeCheckIn->check_in_time,
                'valid_until' => now()->endOfDay(),
            ],
        ]);
    }

    /**
     * Report incident involving a child.
     */
    public function reportIncident(Request $request)
    {
        $validated = $request->validate([
            'child_id' => 'required|exists:children,id',
            'incident_type' => 'required|in:injury,illness,behavior,accident,other',
            'description' => 'required|string|max:1000',
            'severity' => 'required|in:minor,moderate,serious',
            'action_taken' => 'nullable|string|max:500',
            'witnesses' => 'nullable|string|max:500',
            'photos' => 'nullable|array',
            'photos.*' => 'image|max:5120',
        ]);

        $user = $request->user();

        try {
            DB::beginTransaction();

            // Create incident report
            $incident = ChildIncident::create([
                'child_id' => $validated['child_id'],
                'incident_type' => $validated['incident_type'],
                'description' => $validated['description'],
                'severity' => $validated['severity'],
                'action_taken' => $validated['action_taken'] ?? null,
                'witnesses' => $validated['witnesses'] ?? null,
                'reported_by' => $user->id,
                'incident_date' => now(),
                'status' => 'reported',
            ]);

            $child = Child::find($validated['child_id']);

            // Notify parent immediately if serious
            if ($validated['severity'] === 'serious') {
                $parent = $child->parent;
                if ($parent && $parent->user) {
                    $this->notificationService->send($parent->user, [
                        'title' => 'Urgent: Child Incident Report',
                        'message' => "An incident involving {$child->first_name} has been reported. Please contact children's ministry immediately.",
                        'type' => 'child_incident',
                        'priority' => 'urgent',
                    ]);
                }
            }

            // Notify children's ministry leadership
            $this->notifyChildrensLeadership($incident, $child);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Incident report submitted successfully',
                'data' => [
                    'incident_id' => $incident->id,
                    'child_name' => $child->full_name,
                    'severity' => $incident->severity,
                    'parent_notified' => $validated['severity'] === 'serious',
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to submit incident report: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get child's attendance history.
     */
    public function getChildAttendanceHistory(Request $request)
    {
        $validated = $request->validate([
            'child_id' => 'required|exists:children,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $user = $request->user();
        $member = $user->member;

        $child = Child::find($validated['child_id']);

        // Verify parent relationship
        if ($child->parent_id !== $member->id && $child->guardian_id !== $member->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this child\'s records',
            ], 403);
        }

        $startDate = $validated['start_date'] ?? now()->subMonths(3);
        $endDate = $validated['end_date'] ?? now();

        $attendance = ChildCheckIn::where('child_id', $child->id)
            ->whereBetween('check_in_time', [$startDate, $endDate])
            ->orderBy('check_in_time', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'child' => [
                    'id' => $child->id,
                    'name' => $child->full_name,
                ],
                'date_range' => [
                    'start' => $startDate,
                    'end' => $endDate,
                ],
                'attendance_records' => $attendance->map(function ($record) {
                    return [
                        'date' => $record->check_in_time->format('Y-m-d'),
                        'check_in_time' => $record->check_in_time->format('H:i'),
                        'check_out_time' => $record->check_out_time ? $record->check_out_time->format('H:i') : null,
                        'class' => $record->class_assigned,
                        'service_type' => $record->service_type,
                    ];
                }),
                'statistics' => [
                    'total_attendances' => $attendance->count(),
                    'average_per_month' => round($attendance->count() / max($startDate->diffInMonths($endDate), 1), 1),
                ],
            ],
        ]);
    }

    /**
     * Assign child to appropriate class based on age.
     */
    private function assignClass(int $age): string
    {
        return match (true) {
            $age <= 2 => 'Nursery (0-2 years)',
            $age <= 4 => 'Toddlers (3-4 years)',
            $age <= 6 => 'Beginners (5-6 years)',
            $age <= 9 => 'Primary (7-9 years)',
            $age <= 12 => 'Juniors (10-12 years)',
            default => 'Teens (13+ years)',
        };
    }

    /**
     * Log security violation.
     */
    private function logSecurityViolation($checkIn, string $reason): void
    {
        DB::table('security_logs')->insert([
            'child_id' => $checkIn->child_id,
            'check_in_id' => $checkIn->id,
            'violation_type' => 'invalid_security_code',
            'description' => $reason,
            'logged_at' => now(),
        ]);
    }

    /**
     * Notify children's ministry staff.
     */
    private function notifyChildrensStaff(string $action, $child, $checkIn): void
    {
        // Notify children's ministry workers about check-in/out
    }

    /**
     * Notify children's ministry leadership.
     */
    private function notifyChildrensLeadership($incident, $child): void
    {
        // Notify leadership about incident
    }
}
