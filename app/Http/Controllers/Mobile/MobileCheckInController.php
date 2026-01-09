<?php

namespace App\Http\Controllers\Mobile;

use App\Events\AttendanceRecorded;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Member;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MobileCheckInController extends Controller
{
    public function __construct(
        protected QrCodeService $qrCodeService
    ) {}

    /**
     * Member check-in via QR code.
     */
    public function memberCheckIn(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
            'location' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $tokenData = $this->qrCodeService->validateToken($validated['token'], 'member');

        if (! $tokenData) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired QR code',
            ], 400);
        }

        $member = Member::find($tokenData['member_id']);
        if (! $member) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found',
            ], 404);
        }

        // Create attendance record
        $attendance = Attendance::create([
            'member_id' => $member->id,
            'service_date' => now()->toDateString(),
            'service_type' => $request->input('service_type', 'sunday_service'),
            'check_in_time' => now()->toTimeString(),
            'status' => 'present',
            'check_in_method' => 'qr_code',
            'location' => $validated['location'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
        ]);

        // Broadcast attendance event for real-time updates
        broadcast(new AttendanceRecorded($attendance))->toOthers();

        // Invalidate token after use
        $this->qrCodeService->invalidateToken($validated['token'], 'member');

        return response()->json([
            'success' => true,
            'message' => 'Check-in successful',
            'data' => [
                'member_name' => $member->first_name.' '.$member->last_name,
                'check_in_time' => $attendance->check_in_time,
                'service_date' => $attendance->service_date,
            ],
        ]);
    }

    /**
     * Service check-in via dynamic QR code.
     */
    public function serviceCheckIn(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
        ]);

        $tokenData = $this->qrCodeService->validateToken($validated['token'], 'service');

        if (! $tokenData) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired service QR code',
            ], 400);
        }

        $member = $request->user()->member;
        
        if (! $member) {
             return response()->json([
                'success' => false,
                'message' => 'Member profile not linked to this user account.',
            ], 404);
        }

        // Check for duplicate check-in
        $existingAttendance = Attendance::where('member_id', $member->id)
            ->where('service_date', $tokenData['service_date'])
            ->where('service_type', $tokenData['service_type'])
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Already checked in for this service',
            ], 400);
        }

        // Create attendance record
        $attendance = Attendance::create([
            'member_id' => $member->id,
            'service_date' => $tokenData['service_date'],
            'service_type' => $tokenData['service_type'],
            'check_in_time' => now()->toTimeString(),
            'status' => 'present',
            'check_in_method' => 'qr_code_service',
        ]);

        // Broadcast attendance event for real-time updates
        broadcast(new AttendanceRecorded($attendance))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'Service check-in successful',
            'data' => [
                'member_name' => $member->first_name.' '.$member->last_name,
                'service_date' => $attendance->service_date,
                'service_type' => $attendance->service_type,
                'check_in_time' => $attendance->check_in_time,
            ],
        ]);
    }

    /**
     * Family check-in with single scan.
     */
    public function familyCheckIn(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
            'family_members' => 'required|array',
            'family_members.*' => 'exists:members,id',
        ]);

        $tokenData = $this->qrCodeService->validateToken($validated['token'], 'service');

        if (! $tokenData) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired QR code',
            ], 400);
        }

        $checkedIn = [];
        $alreadyCheckedIn = [];

        // Eager load members to avoid N+1 lookup
        $members = Member::whereIn('id', $validated['family_members'])->get()->keyBy('id');

        // Check existing attendances for this service/date in one query
        $existingAttendances = Attendance::whereIn('member_id', $validated['family_members'])
            ->where('service_date', $tokenData['service_date'])
            ->where('service_type', $tokenData['service_type'])
            ->pluck('member_id')
            ->toArray();

        DB::transaction(function () use ($validated, $tokenData, $members, $existingAttendances, &$checkedIn, &$alreadyCheckedIn) {
            foreach ($validated['family_members'] as $memberId) {
                $member = $members->get($memberId);
                if (!$member) continue;

                // Check for duplicate
                if (in_array($memberId, $existingAttendances)) {
                    $alreadyCheckedIn[] = $member->first_name.' '.$member->last_name;
                    continue;
                }

                // Create attendance
                $attendance = Attendance::create([
                    'member_id' => $memberId,
                    'service_date' => $tokenData['service_date'],
                    'service_type' => $tokenData['service_type'],
                    'check_in_time' => now()->toTimeString(),
                    'status' => 'present',
                    'check_in_method' => 'qr_code_family',
                ]);

                // Broadcast attendance event for real-time updates
                broadcast(new AttendanceRecorded($attendance))->toOthers();

                $checkedIn[] = $member->first_name.' '.$member->last_name;
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Family check-in completed',
            'data' => [
                'checked_in' => $checkedIn,
                'already_checked_in' => $alreadyCheckedIn,
                'total_checked_in' => count($checkedIn),
            ],
        ]);
    }

    /**
     * Generate personal QR code for member.
     */
    public function generatePersonalQr(Request $request)
    {
        $member = $request->user()->member;

        if (! $member) {
            return response()->json([
                'success' => false,
                'message' => 'Member profile not found',
            ], 404);
        }

        $qrData = $this->qrCodeService->generateMemberCheckInCode($member);

        return response()->json([
            'success' => true,
            'data' => [
                'qr_code_url' => $this->qrCodeService->generateQrImageUrl($qrData['data']),
                'token' => $qrData['token'],
                'expires_at' => $qrData['expires_at'],
            ],
        ]);
    }
}
