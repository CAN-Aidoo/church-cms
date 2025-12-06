<?php

namespace App\Http\Controllers;

use App\Models\AnniversaryMilestone;
use App\Models\BirthdayAutomationSetting;
use App\Models\BirthdayWish;
use App\Models\ServiceAnnouncement;
use App\Repositories\BirthdayAutomationRepository;
use App\Services\BirthdayAutomationService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BirthdayController extends Controller
{
    protected $repository;

    protected $service;

    public function __construct(
        BirthdayAutomationRepository $repository,
        BirthdayAutomationService $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display birthday dashboard.
     */
    public function index()
    {
        $stats = $this->repository->getStatistics();
        $todaysBirthdays = $this->repository->getTodaysBirthdays();
        $upcomingBirthdays = $this->repository->getUpcomingBirthdays(7);
        $upcomingMilestones = $this->repository->getUpcomingMilestones(30);
        $recentWishes = BirthdayWish::with('member')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('birthdays.index', compact(
            'stats',
            'todaysBirthdays',
            'upcomingBirthdays',
            'upcomingMilestones',
            'recentWishes'
        ));
    }

    /**
     * Display upcoming birthdays calendar.
     */
    public function calendar(Request $request)
    {
        $days = $request->get('days', 30);
        $report = $this->service->getUpcomingBirthdaysReport($days);

        return view('birthdays.calendar', compact('report', 'days'));
    }

    /**
     * Display birthday wish history.
     */
    public function history(Request $request)
    {
        $query = BirthdayWish::with('member');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('wish_type')) {
            $query->where('wish_type', $request->wish_type);
        }

        if ($request->filled('year')) {
            $query->where('year_sent', $request->year);
        }

        $wishes = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get available years for filter
        $years = BirthdayWish::selectRaw('DISTINCT year_sent')
            ->orderBy('year_sent', 'desc')
            ->pluck('year_sent');

        return view('birthdays.history', compact('wishes', 'years'));
    }

    /**
     * Display milestones.
     */
    public function milestones()
    {
        $upcomingMilestones = $this->repository->getUpcomingMilestones(90);
        $specialMilestones = $this->repository->getSpecialMilestones();
        $recognizedMilestones = AnniversaryMilestone::with('member')
            ->where('recognition_given', true)
            ->orderBy('recognized_on', 'desc')
            ->take(20)
            ->get();

        return view('birthdays.milestones', compact(
            'upcomingMilestones',
            'specialMilestones',
            'recognizedMilestones'
        ));
    }

    /**
     * Mark milestone as recognized.
     */
    public function recognizeMilestone(Request $request, AnniversaryMilestone $milestone)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        $milestone->markAsRecognized($validated['notes'] ?? null);

        return redirect()
            ->back()
            ->with('success', 'Milestone marked as recognized.');
    }

    /**
     * Display service announcements.
     */
    public function announcements(Request $request)
    {
        $query = ServiceAnnouncement::query();

        // Filter by service date
        if ($request->filled('service_date')) {
            $query->whereDate('service_date', $request->service_date);
        } else {
            // Default to upcoming announcements
            $query->where('service_date', '>=', now()->toDateString());
        }

        if ($request->filled('displayed')) {
            $query->where('displayed', $request->displayed === 'yes');
        }

        $announcements = $query->orderBy('service_date', 'desc')
            ->paginate(20);

        $nextSunday = $this->getNextSunday();

        return view('birthdays.announcements', compact('announcements', 'nextSunday'));
    }

    /**
     * Mark announcement as displayed.
     */
    public function markAnnouncementDisplayed(ServiceAnnouncement $announcement)
    {
        $announcement->markAsDisplayed();

        return redirect()
            ->back()
            ->with('success', 'Announcement marked as displayed.');
    }

    /**
     * Display automation settings.
     */
    public function settings()
    {
        $settings = $this->repository->getSettings();

        // Ensure all event types have settings
        $eventTypes = ['birthday', 'wedding_anniversary', 'membership_anniversary', 'ministry_anniversary'];
        $settingsMap = $settings->keyBy('event_type');

        foreach ($eventTypes as $eventType) {
            if (! $settingsMap->has($eventType)) {
                $settingsMap[$eventType] = new BirthdayAutomationSetting([
                    'event_type' => $eventType,
                    'enabled' => true,
                    'sms_enabled' => true,
                    'send_time' => '00:00:00',
                    'sms_template' => $this->getDefaultTemplate($eventType),
                ]);
            }
        }

        return view('birthdays.settings', ['settings' => $settingsMap]);
    }

    /**
     * Update automation settings.
     */
    public function updateSettings(Request $request, string $eventType)
    {
        $validated = $request->validate([
            'enabled' => 'required|boolean',
            'sms_enabled' => 'required|boolean',
            'email_enabled' => 'required|boolean',
            'send_time' => 'required',
            'sms_template' => 'required|string',
            'email_subject' => 'nullable|string',
            'email_template' => 'nullable|string',
            'notify_pastor' => 'required|boolean',
            'announce_in_service' => 'required|boolean',
            'special_milestones' => 'nullable|array',
            'special_milestone_message' => 'nullable|string',
        ]);

        $this->repository->updateSettings($eventType, $validated);

        return redirect()
            ->back()
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Manually trigger birthday processing.
     */
    public function processBirthdays()
    {
        $results = $this->service->processDailyBirthdays();

        return redirect()
            ->route('birthdays.index')
            ->with('success', "Processed: {$results['birthdays_found']} birthdays, {$results['wishes_sent']} wishes sent, {$results['wishes_failed']} failed.");
    }

    /**
     * Retry failed wishes.
     */
    public function retryFailed()
    {
        $results = $this->service->retryFailedWishes();

        return redirect()
            ->back()
            ->with('success', "Retried {$results['retried']} wishes: {$results['succeeded']} succeeded, {$results['failed']} failed.");
    }

    /**
     * Get default message template.
     */
    protected function getDefaultTemplate(string $eventType): string
    {
        return match ($eventType) {
            'birthday' => "Happy Birthday {first_name}! May this new year of your life be filled with God's blessings, joy, and divine favor. We celebrate you today! - {church_name}",
            'wedding_anniversary' => 'Happy {years} Year Wedding Anniversary {full_name}! May God continue to bless and strengthen your marriage. Congratulations! - {church_name}',
            'membership_anniversary' => 'Congratulations {full_name} on {years} years of faithful membership! Thank you for your commitment and service. God bless you! - {church_name}',
            'ministry_anniversary' => 'Celebrating {years} years of your faithful ministry service! Thank you {full_name} for your dedication. May God continue to use you mightily! - {church_name}',
            default => 'God bless you {first_name}! - {church_name}',
        };
    }

    /**
     * Get next Sunday.
     */
    protected function getNextSunday(): Carbon
    {
        $today = now();

        return $today->dayOfWeek === Carbon::SUNDAY
            ? $today
            : $today->next(Carbon::SUNDAY);
    }

    /**
     * Get birthday automation analytics (AJAX endpoint).
     */
    public function analytics(Request $request)
    {
        $months = $request->input('months', 12);
        $startDate = now()->subMonths($months);

        $analytics = [
            'total_wishes_sent' => BirthdayWish::where('created_at', '>=', $startDate)
                ->where('status', 'sent')
                ->count(),
            'total_wishes_failed' => BirthdayWish::where('created_at', '>=', $startDate)
                ->where('status', 'failed')
                ->count(),
            'success_rate' => 0,
            'monthly_breakdown' => [],
            'by_event_type' => [],
            'by_delivery_method' => [],
        ];

        // Calculate success rate
        $totalAttempted = $analytics['total_wishes_sent'] + $analytics['total_wishes_failed'];
        if ($totalAttempted > 0) {
            $analytics['success_rate'] = round(($analytics['total_wishes_sent'] / $totalAttempted) * 100, 2);
        }

        // Monthly breakdown
        $analytics['monthly_breakdown'] = BirthdayWish::where('created_at', '>=', $startDate)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count, SUM(CASE WHEN status = "sent" THEN 1 ELSE 0 END) as sent')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // By event type
        $analytics['by_event_type'] = BirthdayWish::where('created_at', '>=', $startDate)
            ->selectRaw('wish_type, COUNT(*) as count')
            ->groupBy('wish_type')
            ->get();

        // By delivery method
        $analytics['by_delivery_method'] = BirthdayWish::where('created_at', '>=', $startDate)
            ->selectRaw('delivery_method, COUNT(*) as count')
            ->groupBy('delivery_method')
            ->get();

        return response()->json([
            'success' => true,
            'analytics' => $analytics
        ]);
    }

    /**
     * Get upcoming celebrations (AJAX endpoint).
     */
    public function upcomingCelebrations(Request $request)
    {
        $days = $request->input('days', 7);

        $celebrations = [
            'birthdays' => $this->repository->getUpcomingBirthdays($days),
            'milestones' => $this->repository->getUpcomingMilestones($days),
            'wedding_anniversaries' => $this->repository->getUpcomingWeddingAnniversaries($days),
            'membership_anniversaries' => $this->repository->getUpcomingMembershipAnniversaries($days),
        ];

        return response()->json([
            'success' => true,
            'celebrations' => $celebrations,
            'total_count' => collect($celebrations)->flatten(1)->count()
        ]);
    }

    /**
     * Generate automated service announcements (AJAX endpoint).
     */
    public function generateAnnouncements(Request $request)
    {
        $validated = $request->validate([
            'service_date' => 'required|date',
        ]);

        $serviceDate = Carbon::parse($validated['service_date']);

        // Get all celebrations for that day
        $birthdays = $this->repository->getBirthdaysOnDate($serviceDate);
        $milestones = $this->repository->getMilestonesOnDate($serviceDate);

        $generated = [];

        // Generate birthday announcements
        if ($birthdays->isNotEmpty()) {
            $announcement = $this->service->generateBirthdayAnnouncement($birthdays, $serviceDate);
            if ($announcement) {
                $generated[] = [
                    'type' => 'birthday',
                    'count' => $birthdays->count(),
                    'text' => $announcement
                ];
            }
        }

        // Generate milestone announcements
        foreach ($milestones as $milestone) {
            $announcement = $this->service->generateMilestoneAnnouncement($milestone, $serviceDate);
            if ($announcement) {
                $generated[] = [
                    'type' => 'milestone',
                    'milestone_type' => $milestone->milestone_type,
                    'text' => $announcement
                ];
            }
        }

        return response()->json([
            'success' => true,
            'announcements' => $generated,
            'count' => count($generated)
        ]);
    }

    /**
     * Test automation workflow (AJAX endpoint).
     */
    public function testWorkflow(Request $request)
    {
        $validated = $request->validate([
            'event_type' => 'required|in:birthday,wedding_anniversary,membership_anniversary,ministry_anniversary',
            'test_member_id' => 'required|exists:members,id',
        ]);

        $result = $this->service->testAutomationWorkflow(
            $validated['event_type'],
            $validated['test_member_id']
        );

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
            'preview' => $result['preview'] ?? null,
            'details' => $result['details'] ?? []
        ]);
    }

    /**
     * Get automation schedule preview (AJAX endpoint).
     */
    public function schedulePreview(Request $request)
    {
        $days = $request->input('days', 30);

        $schedule = [];
        $startDate = now();

        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dateStr = $date->toDateString();

            $daySchedule = [
                'date' => $dateStr,
                'day_name' => $date->format('l'),
                'birthdays' => 0,
                'anniversaries' => 0,
                'milestones' => 0,
                'total' => 0,
            ];

            // Count birthdays
            $birthdayCount = $this->repository->getBirthdaysOnDate($date)->count();
            $daySchedule['birthdays'] = $birthdayCount;

            // Count anniversaries
            $anniversaryCount = $this->repository->getWeddingAnniversariesOnDate($date)->count();
            $daySchedule['anniversaries'] = $anniversaryCount;

            // Count milestones
            $milestoneCount = $this->repository->getMilestonesOnDate($date)->count();
            $daySchedule['milestones'] = $milestoneCount;

            $daySchedule['total'] = $birthdayCount + $anniversaryCount + $milestoneCount;

            $schedule[] = $daySchedule;
        }

        return response()->json([
            'success' => true,
            'schedule' => $schedule,
            'summary' => [
                'total_days' => $days,
                'total_events' => collect($schedule)->sum('total'),
                'busiest_day' => collect($schedule)->sortByDesc('total')->first()
            ]
        ]);
    }

    /**
     * Bulk schedule wishes (AJAX endpoint).
     */
    public function bulkSchedule(Request $request)
    {
        $validated = $request->validate([
            'event_type' => 'required|in:birthday,wedding_anniversary,membership_anniversary',
            'member_ids' => 'required|array',
            'member_ids.*' => 'exists:members,id',
            'send_date' => 'required|date|after_or_equal:today',
        ]);

        $results = $this->service->bulkScheduleWishes(
            $validated['event_type'],
            $validated['member_ids'],
            Carbon::parse($validated['send_date'])
        );

        return response()->json([
            'success' => true,
            'scheduled' => $results['scheduled'],
            'failed' => $results['failed'],
            'message' => "Scheduled {$results['scheduled']} wishes successfully."
        ]);
    }

    /**
     * Get milestone recognition suggestions (AJAX endpoint).
     */
    public function recognitionSuggestions()
    {
        $suggestions = [
            'silver_anniversaries' => $this->repository->getUpcomingMilestonesByType('wedding_25'),
            'golden_anniversaries' => $this->repository->getUpcomingMilestonesByType('wedding_50'),
            'long_term_members' => $this->repository->getUpcomingMilestonesByType('membership_10'),
            'ministry_veterans' => $this->repository->getUpcomingMilestonesByType('ministry_10'),
        ];

        $totalSuggestions = collect($suggestions)->flatten(1)->count();

        return response()->json([
            'success' => true,
            'suggestions' => $suggestions,
            'total_count' => $totalSuggestions
        ]);
    }
}
