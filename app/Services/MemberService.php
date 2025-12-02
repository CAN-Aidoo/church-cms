<?php

namespace App\Services;

use App\Models\Member;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MemberService
{
    /**
     * Create a new member.
     */
    public function createMember(array $data, ?User $creator = null): Member
    {
        return DB::transaction(function () use ($data, $creator) {
            // Create user account if email is provided
            $user = null;
            if (! empty($data['email']) && ! empty($data['create_account'])) {
                // Generate secure random password if not provided
                $password = $data['password'] ?? Str::random(16);

                $user = User::create([
                    'full_name' => $data['first_name'].' '.$data['last_name'],
                    'email' => $data['email'],
                    'password' => Hash::make($password),
                    'phone' => $data['phone'] ?? null,
                    'role' => 'member',
                ]);

                // Store temporary password if auto-generated (will need to be sent via email)
                // In production, send password reset link instead of plain password
                if (empty($data['password'])) {
                    $user->password_changed_at = null; // Require password change on first login
                    $user->save();
                }
            }

            // Create member record
            $member = Member::create([
                'user_id' => $user?->id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'alternate_phone' => $data['alternate_phone'] ?? null,
                'date_of_birth' => $data['date_of_birth'] ?? null,
                'gender' => $data['gender'] ?? null,
                'marital_status' => $data['marital_status'] ?? null,
                'occupation' => $data['occupation'] ?? null,
                'address' => $data['address'] ?? null,
                'city' => $data['city'] ?? null,
                'postal_code' => $data['postal_code'] ?? null,
                'country' => $data['country'] ?? 'Ghana',
                'bio' => $data['bio'] ?? null,
                'join_date' => $data['join_date'] ?? now(),
                'member_status' => $data['member_status'] ?? 'active',
                'referral_source' => $data['referral_source'] ?? null,
                'notes' => $data['notes'] ?? null,
                'created_by' => $creator?->id,
            ]);

            return $member;
        });
    }

    /**
     * Update a member.
     */
    public function updateMember(Member $member, array $data): Member
    {
        return DB::transaction(function () use ($member, $data) {
            $member->update([
                'first_name' => $data['first_name'] ?? $member->first_name,
                'last_name' => $data['last_name'] ?? $member->last_name,
                'email' => $data['email'] ?? $member->email,
                'phone' => $data['phone'] ?? $member->phone,
                'alternate_phone' => $data['alternate_phone'] ?? $member->alternate_phone,
                'date_of_birth' => $data['date_of_birth'] ?? $member->date_of_birth,
                'gender' => $data['gender'] ?? $member->gender,
                'marital_status' => $data['marital_status'] ?? $member->marital_status,
                'occupation' => $data['occupation'] ?? $member->occupation,
                'address' => $data['address'] ?? $member->address,
                'city' => $data['city'] ?? $member->city,
                'postal_code' => $data['postal_code'] ?? $member->postal_code,
                'country' => $data['country'] ?? $member->country,
                'bio' => $data['bio'] ?? $member->bio,
                'member_status' => $data['member_status'] ?? $member->member_status,
                'referral_source' => $data['referral_source'] ?? $member->referral_source,
                'notes' => $data['notes'] ?? $member->notes,
            ]);

            // Update user account if exists
            if ($member->user && ! empty($data['email'])) {
                $member->user->update([
                    'full_name' => $member->full_name,
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?? $member->user->phone,
                ]);
            }

            return $member->fresh();
        });
    }

    /**
     * Convert a visitor to a member.
     */
    public function convertVisitorToMember(Visitor $visitor, array $additionalData = []): Member
    {
        return DB::transaction(function () use ($visitor, $additionalData) {
            // Create user account
            // Generate secure random password if not provided
            $password = $additionalData['password'] ?? Str::random(16);

            $user = User::create([
                'full_name' => $visitor->full_name,
                'email' => $visitor->email ?? $additionalData['email'],
                'password' => Hash::make($password),
                'phone' => $visitor->phone,
                'role' => 'member',
            ]);

            // Require password change on first login if auto-generated
            if (empty($additionalData['password'])) {
                $user->password_changed_at = null;
                $user->save();
            }

            // Create member record
            $member = Member::create([
                'user_id' => $user->id,
                'first_name' => $visitor->first_name,
                'last_name' => $visitor->last_name,
                'email' => $visitor->email,
                'phone' => $visitor->phone,
                'address' => $visitor->address,
                'join_date' => now(),
                'member_status' => 'active',
                'referral_source' => $visitor->how_heard,
                'notes' => "Converted from visitor. First visit: {$visitor->visit_date->format('Y-m-d')}. Total visits: {$visitor->visit_count}",
            ]);

            // Mark visitor as converted
            $visitor->markAsConverted($member);

            return $member;
        });
    }

    /**
     * Upload member photo.
     */
    public function uploadPhoto(Member $member, $photoFile): string
    {
        // Delete old photo if exists
        if ($member->profile_photo_url) {
            $fileUploadService = app(\App\Services\FileUploadService::class);
            $fileUploadService->deleteFile($member->profile_photo_url);
        }

        // Use secure file upload service
        $fileUploadService = app(\App\Services\FileUploadService::class);
        $path = $fileUploadService->uploadFile($photoFile, 'members/photos', 'image');

        // Update member record
        $member->update(['profile_photo_url' => $path]);

        return Storage::disk('public')->url($path);
    }

    /**
     * Upload member photo (alternative method name for controller compatibility).
     */
    public function uploadMemberPhoto($photoFile): string
    {
        // Use secure file upload service
        $fileUploadService = app(\App\Services\FileUploadService::class);

        return $fileUploadService->uploadFile($photoFile, 'members/photos', 'image');
    }

    /**
     * Get member statistics.
     */
    public function getMemberStatistics(): array
    {
        $totalMembers = Member::count();
        $activeMembers = Member::active()->count();

        // Calculate average age
        $avgAge = Member::whereNotNull('date_of_birth')
            ->selectRaw('AVG(TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE())) as avg_age')
            ->value('avg_age');

        // Get member growth trend (last 12 months)
        $growthTrend = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthKey = $date->format('M Y');
            $growthTrend[$monthKey] = Member::whereYear('join_date', $date->year)
                ->whereMonth('join_date', $date->month)
                ->count();
        }

        return [
            'total_members' => $totalMembers,
            'active_members' => $activeMembers,
            'inactive_members' => Member::inactive()->count(),
            'pending_members' => Member::pending()->count(),
            'new_members_month' => Member::whereYear('join_date', now()->year)
                ->whereMonth('join_date', now()->month)
                ->count(),
            'new_members_30_days' => Member::where('join_date', '>=', now()->subDays(30))->count(),
            'male_count' => Member::where('gender', 'male')->count(),
            'female_count' => Member::where('gender', 'female')->count(),
            'average_age' => round($avgAge ?? 0),
            'birthdays_today' => Member::whereRaw('DATE_FORMAT(date_of_birth, "%m-%d") = DATE_FORMAT(CURDATE(), "%m-%d")')->count(),
            'birthdays_this_month' => Member::whereRaw('MONTH(date_of_birth) = MONTH(CURDATE())')->count(),
            'growth_trend' => $growthTrend,
        ];
    }

    /**
     * Get member demographics.
     */
    public function getMemberDemographics(): array
    {
        $totalMembers = Member::count();
        $maleCount = Member::where('gender', 'male')->count();
        $femaleCount = Member::where('gender', 'female')->count();

        return [
            'gender' => [
                'male' => $maleCount,
                'female' => $femaleCount,
                'other' => Member::where('gender', 'other')->count(),
                'male_percentage' => $totalMembers > 0 ? round(($maleCount / $totalMembers) * 100, 1) : 0,
                'female_percentage' => $totalMembers > 0 ? round(($femaleCount / $totalMembers) * 100, 1) : 0,
            ],
            'age_groups' => [
                '0-17 years' => Member::whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 0 AND 17')->count(),
                '18-30 years' => Member::whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 18 AND 30')->count(),
                '31-50 years' => Member::whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 31 AND 50')->count(),
                '51-70 years' => Member::whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 51 AND 70')->count(),
                '70+ years' => Member::whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) > 70')->count(),
            ],
            'marital_status' => [
                'single' => Member::where('marital_status', 'single')->count(),
                'married' => Member::where('marital_status', 'married')->count(),
                'divorced' => Member::where('marital_status', 'divorced')->count(),
                'widowed' => Member::where('marital_status', 'widowed')->count(),
            ],
        ];
    }

    /**
     * Check member engagement.
     */
    public function checkMemberEngagement(Member $member): array
    {
        $attendanceStats = $member->getAttendanceStats();
        $financialSummary = $member->getFinancialSummary();

        $engagementScore = 0;
        $factors = [
            'regular_attendance' => false,
            'financial_giving' => false,
            'recent_activity' => false,
            'complete_profile' => false,
        ];

        // Regular attendance (40 points)
        if ($attendanceStats['attendance_percentage'] >= 80) {
            $engagementScore += 40;
            $factors['regular_attendance'] = true;
        } elseif ($attendanceStats['attendance_percentage'] >= 50) {
            $engagementScore += 20;
        }

        // Financial giving (30 points)
        if ($financialSummary['total_given'] > 0) {
            $engagementScore += 30;
            $factors['financial_giving'] = true;
        }

        // Recent activity (20 points) - attended in last 30 days
        $recentAttendance = $member->attendance()
            ->where('service_date', '>=', now()->subDays(30))
            ->exists();
        if ($recentAttendance) {
            $engagementScore += 20;
            $factors['recent_activity'] = true;
        }

        // Complete profile (10 points)
        if ($member->photo_url && $member->date_of_birth && $member->phone && $member->address) {
            $engagementScore += 10;
            $factors['complete_profile'] = true;
        }

        return [
            'score' => $engagementScore,
            'level' => $engagementScore >= 70 ? 'High' : ($engagementScore >= 40 ? 'Medium' : 'Low'),
            'factors' => $factors,
        ];
    }
}
