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
}
