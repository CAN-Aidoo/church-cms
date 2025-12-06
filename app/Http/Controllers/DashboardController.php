<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Member;
use App\Models\ServiceUnit;
use App\Models\Shepherd;
use App\Models\Transaction;
use App\Models\Visitor;
use App\Services\AttendanceService;
use App\Services\FinanceService;
use App\Services\MemberService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct(
        protected MemberService $memberService,
        protected FinanceService $financeService,
        protected AttendanceService $attendanceService
    ) {}

    /**
     * Display the comprehensive dashboard with all metrics, charts, and quick actions.
     */
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();

        // Get all 9 key metrics
        $metrics = $this->getKeyMetrics($now);

        // Get all 8 chart visualizations
        $charts = $this->getChartData($now);

        // Get recent items
        $recentItems = $this->getRecentItems();

        // Pending approvals (for Pastor/Admin)
        $pendingApprovals = [];
        if ($user->canApproveTransactions()) {
            $pendingApprovals = $this->financeService->getPendingApprovals();
        }

        return view('dashboard.index', compact(
            'metrics',
            'charts',
            'recentItems',
            'pendingApprovals'
        ));
    }

    /**
     * Get all 9 key metrics for dashboard cards.
     */
    private function getKeyMetrics(Carbon $now): array
    {
        $thirtyDaysAgo = $now->copy()->subDays(30);

        // 1. Total Members (with change indicator)
        $totalMembers = Member::where('member_status', 'active')->count();
        $previousMonthMembers = Member::where('member_status', 'active')
            ->where('created_at', '<', $thirtyDaysAgo)
            ->count();
        $memberChange = $totalMembers - $previousMonthMembers;
        $memberChangePercent = $previousMonthMembers > 0
            ? round(($memberChange / $previousMonthMembers) * 100, 1)
            : 0;

        // 2. New Members (last 30 days with trend)
        $newMembers = Member::where('created_at', '>=', $thirtyDaysAgo)->count();
        $previousPeriodNewMembers = Member::whereBetween('created_at', [
            $thirtyDaysAgo->copy()->subDays(30),
            $thirtyDaysAgo,
        ])->count();
        $newMembersTrend = $previousPeriodNewMembers > 0
            ? round((($newMembers - $previousPeriodNewMembers) / $previousPeriodNewMembers) * 100, 1)
            : 0;

        // 3. Financial Balance
        $income = Transaction::where('status', 'completed')
            ->whereIn('transaction_type', ['tithe', 'offering', 'donation', 'other_income'])
            ->sum('amount');
        $expenses = Transaction::where('status', 'completed')
            ->where('transaction_type', 'expense')
            ->sum('amount');
        $balance = $income - $expenses;

        // 4. Upcoming Birthdays (next 30 days)
        $upcomingBirthdays = Member::where('member_status', 'active')
            ->whereNotNull('date_of_birth')
            ->get()
            ->filter(function ($member) use ($now) {
                $birthday = Carbon::parse($member->date_of_birth);
                $nextBirthday = $birthday->copy()->year($now->year);
                if ($nextBirthday->lt($now)) {
                    $nextBirthday->addYear();
                }

                return $nextBirthday->between($now, $now->copy()->addDays(30));
            });
        $upcomingBirthdaysCount = $upcomingBirthdays->count();

        // 5. Attendance Rate (current month)
        $currentMonth = $now->format('Y-m');
        $totalServices = Attendance::whereRaw("DATE_FORMAT(service_date, '%Y-%m') = ?", [$currentMonth])
            ->distinct('service_date')
            ->count('service_date');

        if ($totalServices > 0) {
            $totalAttendance = Attendance::whereRaw("DATE_FORMAT(service_date, '%Y-%m') = ?", [$currentMonth])
                ->count();
            $expectedAttendance = $totalMembers * $totalServices;
            $attendanceRate = $expectedAttendance > 0
                ? round(($totalAttendance / $expectedAttendance) * 100, 1)
                : 0;
        } else {
            $attendanceRate = 0;
        }

        // 6. Recent Visitors
        $recentVisitors = Visitor::where('created_at', '>=', $thirtyDaysAgo)->count();

        // 7. Active Programs (placeholder - will be populated when Programs module is complete)
        $activePrograms = 0;

        // 8. Service Units
        $activeServiceUnits = ServiceUnit::where('status', 'active')->count();

        // 9. Today's Services (placeholder - will be populated when Service Planning module is complete)
        $todaysServices = 0;

        return [
            'total_members' => [
                'count' => $totalMembers,
                'change' => $memberChange,
                'change_percent' => $memberChangePercent,
            ],
            'new_members' => [
                'count' => $newMembers,
                'trend' => $newMembersTrend,
            ],
            'financial_balance' => [
                'balance' => $balance,
                'income' => $income,
                'expenses' => $expenses,
            ],
            'upcoming_birthdays' => [
                'count' => $upcomingBirthdaysCount,
                'list' => $upcomingBirthdays->take(5),
            ],
            'attendance_rate' => [
                'rate' => $attendanceRate,
                'month' => $now->format('F Y'),
            ],
            'recent_visitors' => $recentVisitors,
            'active_programs' => $activePrograms,
            'service_units' => $activeServiceUnits,
            'todays_services' => $todaysServices,
        ];
    }

    /**
     * Get data for all 8 dashboard charts.
     */
    private function getChartData(Carbon $now): array
    {
        // 1. Gender Distribution (Pie/donut chart)
        $genderDistribution = Member::where('member_status', 'active')
            ->select('gender', DB::raw('COUNT(*) as count'))
            ->groupBy('gender')
            ->pluck('count', 'gender')
            ->toArray();

        // 2. Age Distribution (Horizontal bar chart)
        $ageRanges = [
            '0-12' => [0, 12],
            '13-17' => [13, 17],
            '18-25' => [18, 25],
            '26-35' => [26, 35],
            '36-45' => [36, 45],
            '46-55' => [46, 55],
            '56-65' => [56, 65],
            '66+' => [66, 150],
        ];

        $ageDistribution = [];
        foreach ($ageRanges as $label => $range) {
            $count = Member::where('member_status', 'active')
                ->whereNotNull('date_of_birth')
                ->get()
                ->filter(function ($member) use ($range, $now) {
                    $age = $now->diffInYears(Carbon::parse($member->date_of_birth));

                    return $age >= $range[0] && $age <= $range[1];
                })
                ->count();
            $ageDistribution[$label] = $count;
        }

        // 3. Member Status (Stacked bar chart)
        $memberStatus = Member::select('member_status', DB::raw('COUNT(*) as count'))
            ->groupBy('member_status')
            ->pluck('count', 'member_status')
            ->toArray();

        // 4. Monthly Attendance (Line chart trend - last 6 months)
        $monthlyAttendance = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $monthKey = $month->format('Y-m');
            $monthLabel = $month->format('M Y');
            $count = Attendance::whereRaw("DATE_FORMAT(service_date, '%Y-%m') = ?", [$monthKey])->count();
            $monthlyAttendance[$monthLabel] = $count;
        }

        // 5. Financial Trend (Bar/line chart income vs expenses - last 6 months)
        $financialTrend = ['income' => [], 'expenses' => []];
        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $monthKey = $month->format('Y-m');
            $monthLabel = $month->format('M Y');

            $income = Transaction::where('status', 'completed')
                ->whereIn('transaction_type', ['tithe', 'offering', 'donation', 'other_income'])
                ->whereRaw("DATE_FORMAT(transaction_date, '%Y-%m') = ?", [$monthKey])
                ->sum('amount');

            $expenses = Transaction::where('status', 'completed')
                ->where('transaction_type', 'expense')
                ->whereRaw("DATE_FORMAT(transaction_date, '%Y-%m') = ?", [$monthKey])
                ->sum('amount');

            $financialTrend['income'][$monthLabel] = $income;
            $financialTrend['expenses'][$monthLabel] = $expenses;
        }

        // 6. Weekly Activity (Heatmap of activity by day - last 4 weeks)
        $weeklyActivity = [];
        for ($i = 3; $i >= 0; $i--) {
            $weekStart = $now->copy()->subWeeks($i)->startOfWeek();
            $weekEnd = $weekStart->copy()->endOfWeek();
            $weekLabel = $weekStart->format('M d');
            $activity = Attendance::whereBetween('service_date', [$weekStart, $weekEnd])->count();
            $weeklyActivity[$weekLabel] = $activity;
        }

        // 7. Service Units Distribution (Members per unit)
        $serviceUnitsDistribution = ServiceUnit::where('status', 'active')
            ->select('name', 'current_members')
            ->orderBy('current_members', 'desc')
            ->take(10)
            ->pluck('current_members', 'name')
            ->toArray();

        // 8. Shepherd Groups (Members per shepherd)
        $shepherdDistribution = Shepherd::where('status', 'active')
            ->select('flock_name', 'current_flock_size')
            ->orderBy('current_flock_size', 'desc')
            ->take(10)
            ->pluck('current_flock_size', 'flock_name')
            ->toArray();

        return [
            'gender_distribution' => $genderDistribution,
            'age_distribution' => $ageDistribution,
            'member_status' => $memberStatus,
            'monthly_attendance' => $monthlyAttendance,
            'financial_trend' => $financialTrend,
            'weekly_activity' => $weeklyActivity,
            'service_units_distribution' => $serviceUnitsDistribution,
            'shepherd_distribution' => $shepherdDistribution,
        ];
    }

    /**
     * Get recent items for dashboard display.
     */
    private function getRecentItems(): array
    {
        return [
            'recent_members' => Member::orderBy('created_at', 'desc')->take(5)->get(),
            'recent_visitors' => Visitor::orderBy('created_at', 'desc')->take(5)->get(),
            'recent_transactions' => Transaction::with(['member:id,first_name,last_name'])
                ->orderBy('transaction_date', 'desc')
                ->take(5)
                ->get(),
            'upcoming_events' => [], // Will be populated when Programs module is complete
            'todays_birthdays' => Member::where('member_status', 'active')
                ->whereNotNull('date_of_birth')
                ->get()
                ->filter(function ($member) {
                    $birthday = Carbon::parse($member->date_of_birth);

                    return $birthday->format('m-d') === Carbon::now()->format('m-d');
                })
                ->take(5),
            'pending_counselling' => [], // Will be populated when Counselling module is complete
        ];
    }

    /**
     * Get quick action data for modal forms (AJAX).
     */
    public function getQuickActionData(Request $request)
    {
        $action = $request->input('action');

        switch ($action) {
            case 'add_member':
                return response()->json([
                    'shepherds' => Shepherd::where('status', 'active')
                        ->select('id', 'flock_name', 'current_flock_size', 'max_flock_size')
                        ->get(),
                    'service_units' => ServiceUnit::where('status', 'active')
                        ->select('id', 'name', 'current_members', 'max_members')
                        ->get(),
                ]);

            case 'mark_attendance':
                return response()->json([
                    'members' => Member::where('member_status', 'active')
                        ->select('id', 'first_name', 'last_name', 'member_id')
                        ->orderBy('first_name')
                        ->get(),
                    'service_types' => ['Sunday Service', 'Mid-Week Service', 'Special Program'],
                ]);

            case 'record_transaction':
                return response()->json([
                    'categories' => Transaction::distinct()->pluck('category')->filter(),
                    'departments' => Transaction::distinct()->pluck('department')->filter(),
                    'members' => Member::where('member_status', 'active')
                        ->select('id', 'first_name', 'last_name')
                        ->orderBy('first_name')
                        ->take(100)
                        ->get(),
                ]);

            case 'send_sms':
                return response()->json([
                    'recent_groups' => [
                        'All Active Members',
                        'Birthdays Today',
                        'Birthdays This Week',
                        'Pending Members',
                    ],
                ]);

            case 'add_visitor':
                return response()->json([
                    'referral_sources' => [
                        'Family/Friend',
                        'Social Media',
                        'Website',
                        'Flyer/Poster',
                        'Radio/TV',
                        'Walk-in',
                        'Other',
                    ],
                ]);

            case 'schedule_service':
                return response()->json([
                    'service_types' => [
                        'Sunday Morning Service',
                        'Sunday Evening Service',
                        'Mid-Week Service',
                        'Prayer Meeting',
                        'Bible Study',
                        'Special Program',
                    ],
                ]);

            default:
                return response()->json(['error' => 'Invalid action'], 400);
        }
    }

    /**
     * Show user profile.
     */
    public function profile()
    {
        $user = Auth::user();
        $member = $user->member;

        $data = [
            'user' => $user,
            'member' => $member,
        ];

        // If user has a member profile, get additional stats
        if ($member) {
            $data['attendance_stats'] = $member->getAttendanceStats();
            $data['financial_summary'] = $member->getFinancialSummary();
            $data['engagement'] = $this->memberService->checkMemberEngagement($member);
        }

        return view('profile.show', $data);
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048',
        ]);

        // Update user
        $user->update([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? $user->phone,
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar_url' => $path]);
        }

        // Update associated member if exists
        if ($user->member) {
            $names = explode(' ', $validated['full_name'], 2);
            $user->member->update([
                'first_name' => $names[0],
                'last_name' => $names[1] ?? $names[0],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? $user->member->phone,
            ]);
        }

        return redirect()->route('profile')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Get real-time dashboard stats (API endpoint for AJAX polling).
     */
    public function stats(Request $request)
    {
        $now = Carbon::now();

        return response()->json([
            'total_members' => Member::where('member_status', 'active')->count(),
            'todays_attendance' => Attendance::whereDate('service_date', $now)->count(),
            'todays_income' => Transaction::where('transaction_type', 'income')
                ->where('status', 'completed')
                ->whereDate('transaction_date', $now)
                ->sum('amount'),
            'todays_visitors' => Visitor::whereDate('created_at', $now)->count(),
            'pending_approvals' => Transaction::where('status', 'pending')->count(),
            'active_programs' => \App\Models\Program::where('status', 'ongoing')->count(),
            'timestamp' => $now->toISOString(),
        ]);
    }

    /**
     * Get chart data (API endpoint for dynamic chart updates).
     */
    public function charts(Request $request)
    {
        $type = $request->input('type', 'all');
        $now = Carbon::now();

        $charts = $this->getChartData($now);

        if ($type !== 'all' && isset($charts[$type])) {
            return response()->json([$type => $charts[$type]]);
        }

        return response()->json($charts);
    }

    /**
     * Get recent activity feed (API endpoint).
     */
    public function recentActivity(Request $request)
    {
        $limit = $request->input('limit', 20);

        // Get recent activities from multiple sources
        $activities = collect();

        // Recent check-ins
        $checkIns = Attendance::with('member:id,first_name,last_name')
            ->whereDate('service_date', Carbon::today())
            ->orderBy('check_in_time', 'desc')
            ->take($limit)
            ->get()
            ->map(function ($attendance) {
                return [
                    'type' => 'check_in',
                    'icon' => 'check-circle',
                    'color' => 'green',
                    'title' => ($attendance->member->first_name ?? '') . ' ' . ($attendance->member->last_name ?? '') . ' checked in',
                    'description' => 'via ' . ($attendance->check_in_method ?? 'manual'),
                    'timestamp' => $attendance->created_at,
                ];
            });

        // Recent transactions
        $transactions = Transaction::with('member:id,first_name,last_name')
            ->where('status', 'completed')
            ->whereDate('transaction_date', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get()
            ->map(function ($transaction) {
                return [
                    'type' => 'transaction',
                    'icon' => $transaction->transaction_type === 'income' ? 'arrow-down' : 'arrow-up',
                    'color' => $transaction->transaction_type === 'income' ? 'green' : 'red',
                    'title' => $transaction->transaction_type === 'income' ? 'Income received' : 'Expense recorded',
                    'description' => 'GHS ' . number_format($transaction->amount, 2) . ' - ' . $transaction->category,
                    'timestamp' => $transaction->created_at,
                ];
            });

        // Recent member registrations
        $newMembers = Member::orderBy('created_at', 'desc')
            ->whereDate('created_at', Carbon::today())
            ->take($limit)
            ->get()
            ->map(function ($member) {
                return [
                    'type' => 'member_registered',
                    'icon' => 'user-plus',
                    'color' => 'blue',
                    'title' => 'New member registered',
                    'description' => $member->first_name . ' ' . $member->last_name,
                    'timestamp' => $member->created_at,
                ];
            });

        // Merge and sort by timestamp
        $activities = $activities
            ->concat($checkIns)
            ->concat($transactions)
            ->concat($newMembers)
            ->sortByDesc('timestamp')
            ->take($limit)
            ->values();

        return response()->json($activities);
    }
}
