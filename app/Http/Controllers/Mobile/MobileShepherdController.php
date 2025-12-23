<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Shepherd;
use App\Models\ShepherdVisit;
use App\Services\NotificationService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MobileShepherdController extends Controller
{
    public function __construct(
        protected SmsService $smsService,
        protected NotificationService $notificationService
    ) {}

    /**
     * Get shepherd's flock members.
     */
    public function getMyFlock(Request $request)
    {
        $user = $request->user();

        // Find shepherd record for this user
        $shepherd = Shepherd::where('user_id', $user->id)->first();

        if (! $shepherd) {
            return response()->json([
                'success' => false,
                'message' => 'You are not assigned as a shepherd',
            ], 403);
        }

        // Get flock members
        $flockMembers = Member::where('shepherd_id', $shepherd->id)
            ->with(['user', 'family'])
            ->get();

        // Calculate statistics
        $now = now();
        $thisMonth = $now->format('Y-m');

        return response()->json([
            'success' => true,
            'data' => [
                'shepherd' => [
                    'id' => $shepherd->id,
                    'name' => $shepherd->name,
                    'shepherd_code' => $shepherd->shepherd_code,
                    'flock_size' => $flockMembers->count(),
                    'max_flock_size' => config('church.max_flock_size', 15),
                ],
                'flock_members' => $flockMembers->map(function ($member) use ($thisMonth) {
                    // Get recent attendance
                    $attendanceThisMonth = DB::table('attendance')
                        ->where('member_id', $member->id)
                        ->where('service_date', 'like', $thisMonth.'%')
                        ->count();

                    // Get last visit
                    $lastVisit = ShepherdVisit::where('member_id', $member->id)
                        ->where('shepherd_id', $member->shepherd_id)
                        ->latest('visit_date')
                        ->first();

                    // Determine status
                    $daysSinceVisit = $lastVisit ? now()->diffInDays($lastVisit->visit_date) : 999;
                    $status = $this->getMemberStatus($attendanceThisMonth, $daysSinceVisit);

                    return [
                        'id' => $member->id,
                        'member_id' => $member->member_id,
                        'full_name' => $member->full_name,
                        'phone' => $member->phone,
                        'email' => $member->email,
                        'address' => $member->address,
                        'photo_url' => $member->photo_url,
                        'family_size' => $member->family ? $member->family->count() : 0,
                        'status' => $status,
                        'attendance' => [
                            'this_month' => $attendanceThisMonth,
                            'status' => $attendanceThisMonth >= 3 ? 'regular' : ($attendanceThisMonth > 0 ? 'irregular' : 'absent'),
                        ],
                        'last_visit' => $lastVisit ? [
                            'date' => $lastVisit->visit_date,
                            'days_ago' => $daysSinceVisit,
                            'type' => $lastVisit->visit_type,
                        ] : null,
                        'needs_attention' => $status === 'at_risk' || $daysSinceVisit > 60,
                        'quick_actions' => [
                            'call' => "tel:{$member->phone}",
                            'sms' => "sms:{$member->phone}",
                            'whatsapp' => 'https://wa.me/'.preg_replace('/[^0-9]/', '', $member->phone),
                        ],
                    ];
                }),
                'statistics' => [
                    'total_members' => $flockMembers->count(),
                    'regular_attenders' => $flockMembers->filter(function ($m) use ($thisMonth) {
                        return DB::table('attendance')
                            ->where('member_id', $m->id)
                            ->where('service_date', 'like', $thisMonth.'%')
                            ->count() >= 3;
                    })->count(),
                    'at_risk' => $flockMembers->filter(function ($m) use ($thisMonth) {
                        return DB::table('attendance')
                            ->where('member_id', $m->id)
                            ->where('service_date', 'like', $thisMonth.'%')
                            ->count() === 0;
                    })->count(),
                    'need_visit' => $flockMembers->filter(function ($m) {
                        $lastVisit = ShepherdVisit::where('member_id', $m->id)
                            ->latest('visit_date')
                            ->first();

                        return ! $lastVisit || now()->diffInDays($lastVisit->visit_date) > 60;
                    })->count(),
                ],
            ],
        ]);
    }

    /**
     * Record a shepherd visit.
     */
    public function recordVisit(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'visit_type' => 'required|in:home_visit,hospital_visit,phone_call,counselling,fellowship',
            'visit_date' => 'required|date|before_or_equal:today',
            'duration_minutes' => 'nullable|integer|min:1',
            'notes' => 'nullable|string|max:1000',
            'prayer_points' => 'nullable|string|max:500',
            'follow_up_needed' => 'nullable|boolean',
            'follow_up_date' => 'nullable|date|after:today',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'photos' => 'nullable|array',
            'photos.*' => 'image|max:5120', // 5MB per image
        ]);

        $user = $request->user();
        $shepherd = Shepherd::where('user_id', $user->id)->first();

        if (! $shepherd) {
            return response()->json([
                'success' => false,
                'message' => 'You are not assigned as a shepherd',
            ], 403);
        }

        // Verify member is in shepherd's flock
        $member = Member::where('id', $validated['member_id'])
            ->where('shepherd_id', $shepherd->id)
            ->first();

        if (! $member) {
            return response()->json([
                'success' => false,
                'message' => 'This member is not in your flock',
            ], 403);
        }

        try {
            DB::beginTransaction();

            // Create visit record
            $visit = ShepherdVisit::create([
                'shepherd_id' => $shepherd->id,
                'member_id' => $member->id,
                'visit_date' => $validated['visit_date'],
                'visit_type' => $validated['visit_type'],
                'duration_minutes' => $validated['duration_minutes'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'prayer_points' => $validated['prayer_points'] ?? null,
                'follow_up_needed' => $validated['follow_up_needed'] ?? false,
                'follow_up_date' => $validated['follow_up_date'] ?? null,
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'recorded_via' => 'mobile_app',
            ]);

            // Update shepherd's visit statistics
            $shepherd->increment('total_visits');
            $shepherd->update(['last_visit_date' => $validated['visit_date']]);

            DB::commit();

            // Send notification to pastoral team if follow-up needed
            if ($validated['follow_up_needed'] ?? false) {
                $this->notifyFollowUpNeeded($shepherd, $member, $visit);
            }

            return response()->json([
                'success' => true,
                'message' => 'Visit recorded successfully',
                'data' => [
                    'visit_id' => $visit->id,
                    'member_name' => $member->full_name,
                    'visit_date' => $visit->visit_date,
                    'visit_type' => $visit->visit_type,
                    'follow_up_scheduled' => $visit->follow_up_needed,
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to record visit: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get shepherd's visit history.
     */
    public function visitHistory(Request $request)
    {
        $user = $request->user();
        $shepherd = Shepherd::where('user_id', $user->id)->first();

        if (! $shepherd) {
            return response()->json([
                'success' => false,
                'message' => 'You are not assigned as a shepherd',
            ], 403);
        }

        $period = $request->input('period', 'month'); // month, quarter, year
        $startDate = match ($period) {
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            'quarter' => now()->startOfQuarter(),
            'year' => now()->startOfYear(),
            default => now()->startOfMonth(),
        };

        $visits = ShepherdVisit::with('member')
            ->where('shepherd_id', $shepherd->id)
            ->where('visit_date', '>=', $startDate)
            ->orderBy('visit_date', 'desc')
            ->get();

        // Group visits by member
        $visitsByMember = $visits->groupBy('member_id');

        return response()->json([
            'success' => true,
            'data' => [
                'period' => $period,
                'date_range' => [
                    'start' => $startDate->format('Y-m-d'),
                    'end' => now()->format('Y-m-d'),
                ],
                'visits' => $visits->map(function ($visit) {
                    return [
                        'id' => $visit->id,
                        'member' => [
                            'id' => $visit->member->id,
                            'name' => $visit->member->full_name,
                            'phone' => $visit->member->phone,
                        ],
                        'visit_date' => $visit->visit_date,
                        'visit_type' => $visit->visit_type,
                        'duration_minutes' => $visit->duration_minutes,
                        'notes' => $visit->notes,
                        'prayer_points' => $visit->prayer_points,
                        'follow_up_needed' => $visit->follow_up_needed,
                        'follow_up_date' => $visit->follow_up_date,
                        'has_location' => $visit->latitude && $visit->longitude,
                    ];
                }),
                'statistics' => [
                    'total_visits' => $visits->count(),
                    'unique_members_visited' => $visitsByMember->count(),
                    'visits_by_type' => [
                        'home_visit' => $visits->where('visit_type', 'home_visit')->count(),
                        'hospital_visit' => $visits->where('visit_type', 'hospital_visit')->count(),
                        'phone_call' => $visits->where('visit_type', 'phone_call')->count(),
                        'counselling' => $visits->where('visit_type', 'counselling')->count(),
                        'fellowship' => $visits->where('visit_type', 'fellowship')->count(),
                    ],
                    'follow_ups_pending' => $visits->where('follow_up_needed', true)
                        ->where('follow_up_date', '>=', now())
                        ->count(),
                    'total_duration_hours' => round($visits->sum('duration_minutes') / 60, 1),
                ],
            ],
        ]);
    }

    /**
     * Send bulk message to flock members.
     */
    public function messageFlock(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'send_via' => 'required|in:sms,whatsapp,both',
            'member_ids' => 'nullable|array', // If empty, send to all flock
            'member_ids.*' => 'exists:members,id',
        ]);

        $user = $request->user();
        $shepherd = Shepherd::where('user_id', $user->id)->first();

        if (! $shepherd) {
            return response()->json([
                'success' => false,
                'message' => 'You are not assigned as a shepherd',
            ], 403);
        }

        // Get recipients
        $query = Member::where('shepherd_id', $shepherd->id);

        if (! empty($validated['member_ids'])) {
            $query->whereIn('id', $validated['member_ids']);
        }

        $recipients = $query->get();

        if ($recipients->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No recipients found',
            ], 400);
        }

        try {
            $sent = 0;
            $failed = 0;

            foreach ($recipients as $member) {
                if (! $member->phone) {
                    $failed++;

                    continue;
                }

                // Send SMS
                if (in_array($validated['send_via'], ['sms', 'both'])) {
                    try {
                        $this->smsService->sendSms(
                            $member->phone,
                            "From Shepherd {$shepherd->name}: ".$validated['message']
                        );
                        $sent++;
                    } catch (\Exception $e) {
                        $failed++;
                    }
                }

                // WhatsApp would be implemented here
                // For now, we just return WhatsApp web links
            }

            return response()->json([
                'success' => true,
                'message' => "Message sent to {$sent} members",
                'data' => [
                    'total_recipients' => $recipients->count(),
                    'sent' => $sent,
                    'failed' => $failed,
                    'method' => $validated['send_via'],
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send messages: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get shepherd performance dashboard.
     */
    public function getPerformanceDashboard(Request $request)
    {
        $user = $request->user();
        $shepherd = Shepherd::where('user_id', $user->id)->first();

        if (! $shepherd) {
            return response()->json([
                'success' => false,
                'message' => 'You are not assigned as a shepherd',
            ], 403);
        }

        $thisMonth = now()->format('Y-m');
        $lastMonth = now()->subMonth()->format('Y-m');

        // Get flock statistics
        $flockMembers = Member::where('shepherd_id', $shepherd->id)->get();

        // Attendance this month
        $attendanceThisMonth = DB::table('attendance')
            ->whereIn('member_id', $flockMembers->pluck('id'))
            ->where('service_date', 'like', $thisMonth.'%')
            ->count();

        // Visits this month
        $visitsThisMonth = ShepherdVisit::where('shepherd_id', $shepherd->id)
            ->where('visit_date', 'like', $thisMonth.'%')
            ->count();

        // Visits last month
        $visitsLastMonth = ShepherdVisit::where('shepherd_id', $shepherd->id)
            ->where('visit_date', 'like', $lastMonth.'%')
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'shepherd_info' => [
                    'name' => $shepherd->name,
                    'shepherd_code' => $shepherd->shepherd_code,
                    'years_serving' => $shepherd->created_at->diffInYears(now()),
                ],
                'flock_stats' => [
                    'total_members' => $flockMembers->count(),
                    'active_members' => $flockMembers->where('member_status', 'active')->count(),
                    'attendance_rate' => $flockMembers->count() > 0
                        ? round(($attendanceThisMonth / ($flockMembers->count() * 4)) * 100, 1)
                        : 0,
                ],
                'visit_stats' => [
                    'this_month' => $visitsThisMonth,
                    'last_month' => $visitsLastMonth,
                    'total_all_time' => $shepherd->total_visits ?? 0,
                    'average_per_month' => round(($shepherd->total_visits ?? 0) / max($shepherd->created_at->diffInMonths(now()), 1), 1),
                ],
                'goals' => [
                    'monthly_visit_target' => 12, // Visit each member once per month
                    'current_progress' => $visitsThisMonth,
                    'percentage' => round(($visitsThisMonth / 12) * 100, 1),
                ],
            ],
        ]);
    }

    /**
     * Get member status based on attendance and visit history.
     */
    private function getMemberStatus(int $attendanceThisMonth, int $daysSinceVisit): string
    {
        if ($attendanceThisMonth === 0 || $daysSinceVisit > 90) {
            return 'at_risk';
        } elseif ($attendanceThisMonth >= 3 && $daysSinceVisit <= 30) {
            return 'engaged';
        } else {
            return 'active';
        }
    }

    /**
     * Notify pastoral team of follow-up needed.
     */
    private function notifyFollowUpNeeded($shepherd, $member, $visit): void
    {
        // Implementation depends on notification system
        // This would notify pastoral staff that a member needs follow-up
    }
}
