<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Member;
use App\Models\Visitor;
use App\Services\SmsService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class MobileRegistrationController extends Controller
{
    public function __construct(
        protected SmsService $smsService,
        protected NotificationService $notificationService
    ) {}

    /**
     * Mobile member self-registration (Step 1: Phone verification).
     */
    public function registerMember(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|regex:/^[+][0-9]{10,15}$/',
            'email' => 'nullable|email|unique:users,email',
        ]);

        // Check if phone already exists
        $existingUser = User::where('phone', $validated['phone'])->first();
        if ($existingUser) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number already registered. Please log in instead.'
            ], 400);
        }

        // Generate OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = now()->addMinutes(10);

        // Store OTP in cache
        Cache::put("otp:{$validated['phone']}", [
            'otp' => $otp,
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'expires_at' => $expiresAt
        ], $expiresAt);

        // Send OTP via SMS
        $message = "Your Church CMS verification code is: {$otp}. Valid for 10 minutes.";
        $this->smsService->sendSms($validated['phone'], $message);

        return response()->json([
            'success' => true,
            'message' => 'Verification code sent to your phone',
            'data' => [
                'phone' => $validated['phone'],
                'expires_in_minutes' => 10,
            ]
        ]);
    }

    /**
     * Verify OTP and create member profile (Step 2).
     */
    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|string|size:6',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Retrieve and validate OTP
        $cachedData = Cache::get("otp:{$validated['phone']}");

        if (!$cachedData) {
            return response()->json([
                'success' => false,
                'message' => 'Verification code expired. Please request a new one.'
            ], 400);
        }

        if ($cachedData['otp'] !== $validated['otp']) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Create user account with LIMITED access
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'] ?? $validated['phone'] . '@mobile.church.local',
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'role' => 'member', // Mobile member role
                'is_verified' => false, // Not verified by admin yet
                'phone_verified_at' => now(),
                'email_verified_at' => isset($validated['email']) ? now() : null,
            ]);

            // Generate unique member ID
            $memberCode = 'M-' . date('Y') . '-' . str_pad(Member::count() + 1, 6, '0', STR_PAD_LEFT);

            // Create member profile
            $member = Member::create([
                'user_id' => $user->id,
                'member_id' => $memberCode,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'address' => $validated['address'] ?? null,
                'member_status' => 'pending', // Pending admin verification
                'membership_date' => now(),
                'source' => 'mobile_self_registration',
            ]);

            // Clear OTP from cache
            Cache::forget("otp:{$validated['phone']}");

            // Notify admin about new registration
            $this->notificationService->notifyAdminOfNewMobileRegistration($member);

            // Create access token
            $token = $user->createToken('mobile-app', ['limited-access'])->plainTextToken;

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! Your account is pending admin verification.',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'is_verified' => $user->is_verified,
                    ],
                    'member' => [
                        'id' => $member->id,
                        'member_id' => $member->member_id,
                        'full_name' => $member->full_name,
                        'status' => $member->member_status,
                    ],
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'permissions' => [
                        'can_view_announcements' => true,
                        'can_update_profile' => true,
                        'can_checkin_as_visitor' => true,
                        'can_make_contributions' => false, // Requires verification
                        'can_register_for_programs' => false, // Requires verification
                        'can_access_directory' => false, // Requires verification
                    ]
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Visitor self-registration via QR code.
     */
    public function registerVisitor(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[+][0-9]{10,15}$/',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'how_heard' => 'nullable|string',
            'prayer_request' => 'nullable|string',
            'service_type' => 'nullable|string',
        ]);

        try {
            // Check if visitor already exists
            $existingVisitor = Visitor::where('phone', $validated['phone'])
                ->where('converted_to_member', false)
                ->first();

            if ($existingVisitor) {
                // Record another visit
                $existingVisitor->increment('visit_count');
                $existingVisitor->update(['last_visit' => now()]);

                $message = "Welcome back! This is visit #{$existingVisitor->visit_count}.";

                // Check if eligible for member conversion (5 visits)
                if ($existingVisitor->visit_count >= 5) {
                    $message .= " You're eligible to become a member! Please contact our team.";
                }

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'data' => [
                        'visitor_id' => $existingVisitor->id,
                        'visit_count' => $existingVisitor->visit_count,
                        'eligible_for_membership' => $existingVisitor->visit_count >= 5,
                    ]
                ]);
            }

            // Create new visitor
            $visitor = Visitor::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'address' => $validated['address'] ?? null,
                'how_they_heard' => $validated['how_heard'] ?? null,
                'prayer_request' => $validated['prayer_request'] ?? null,
                'first_visit_date' => now(),
                'last_visit' => now(),
                'visit_count' => 1,
                'status' => 'active',
                'source' => 'qr_self_registration',
            ]);

            // Send welcome SMS
            $welcomeMessage = "Welcome to our church! Thank you for visiting us today. We hope to see you again soon!";
            $this->smsService->sendSms($validated['phone'], $welcomeMessage);

            // Notify admin/pastoral team
            $this->notificationService->notifyOfNewVisitor($visitor);

            return response()->json([
                'success' => true,
                'message' => 'Welcome! Your registration is complete. A welcome message has been sent to your phone.',
                'data' => [
                    'visitor_id' => $visitor->id,
                    'visit_count' => 1,
                    'eligible_for_membership' => false,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Resend OTP.
     */
    public function resendOtp(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
        ]);

        // Generate new OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = now()->addMinutes(10);

        // Get existing cached data if any
        $existingData = Cache::get("otp:{$validated['phone']}", []);

        // Update OTP in cache
        Cache::put("otp:{$validated['phone']}", [
            'otp' => $otp,
            'phone' => $validated['phone'],
            'email' => $existingData['email'] ?? null,
            'expires_at' => $expiresAt
        ], $expiresAt);

        // Send OTP via SMS
        $message = "Your new Church CMS verification code is: {$otp}. Valid for 10 minutes.";
        $this->smsService->sendSms($validated['phone'], $message);

        return response()->json([
            'success' => true,
            'message' => 'New verification code sent to your phone',
            'data' => [
                'phone' => $validated['phone'],
                'expires_in_minutes' => 10,
            ]
        ]);
    }

    /**
     * Check registration status (for pending members).
     */
    public function checkStatus(Request $request)
    {
        $user = $request->user();
        $member = $user->member;

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'No member profile found'
            ], 404);
        }

        $isVerified = $user->is_verified && $member->member_status === 'active';

        return response()->json([
            'success' => true,
            'data' => [
                'is_verified' => $isVerified,
                'status' => $member->member_status,
                'registration_date' => $member->membership_date,
                'days_pending' => $member->membership_date->diffInDays(now()),
                'permissions' => [
                    'can_view_announcements' => true,
                    'can_update_profile' => true,
                    'can_checkin_as_visitor' => true,
                    'can_make_contributions' => $isVerified,
                    'can_register_for_programs' => $isVerified,
                    'can_access_directory' => $isVerified,
                    'can_submit_prayer_requests' => $isVerified,
                    'can_use_messaging' => $isVerified,
                ],
                'message' => $isVerified
                    ? 'Your account is fully verified!'
                    : 'Your account is pending admin verification. Some features are limited.'
            ]
        ]);
    }
}
