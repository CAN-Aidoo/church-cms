<?php

namespace App\Repositories;

use App\Models\AnniversaryMilestone;
use App\Models\BirthdayAutomationSetting;
use App\Models\BirthdayWish;
use App\Models\Member;
use App\Models\ServiceAnnouncement;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class BirthdayAutomationRepository
{
    /**
     * Get members with birthdays today.
     */
    public function getTodaysBirthdays(): Collection
    {
        $today = now();

        return Member::where('member_status', 'active')
            ->whereMonth('date_of_birth', $today->month)
            ->whereDay('date_of_birth', $today->day)
            ->get();
    }

    /**
     * Get members with birthdays in date range.
     */
    public function getBirthdaysInRange(Carbon $startDate, Carbon $endDate): Collection
    {
        return Member::where('member_status', 'active')
            ->whereNotNull('date_of_birth')
            ->get()
            ->filter(function ($member) use ($startDate, $endDate) {
                $birthday = Carbon::parse($member->date_of_birth);
                $birthdayThisYear = $birthday->setYear($startDate->year);

                return $birthdayThisYear->between($startDate, $endDate);
            });
    }

    /**
     * Get upcoming birthdays (next N days).
     */
    public function getUpcomingBirthdays(int $days = 7): Collection
    {
        return $this->getBirthdaysInRange(now(), now()->addDays($days));
    }

    /**
     * Create a birthday wish.
     */
    public function createBirthdayWish(Member $member, array $data): BirthdayWish
    {
        return BirthdayWish::create(array_merge([
            'member_id' => $member->id,
            'birthday_date' => $member->date_of_birth,
            'year_sent' => now()->year,
            'wish_type' => 'birthday',
            'status' => 'pending',
        ], $data));
    }

    /**
     * Get pending wishes ready to send.
     */
    public function getPendingWishes(): Collection
    {
        return BirthdayWish::pending()
            ->where('scheduled_at', '<=', now())
            ->orderBy('scheduled_at')
            ->get();
    }

    /**
     * Get failed wishes that can be retried.
     */
    public function getRetryableWishes(): Collection
    {
        return BirthdayWish::failed()
            ->where('retry_count', '<', 3)
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Check if wish already sent this year.
     */
    public function hasWishBeenSent(Member $member, string $wishType, int $year): bool
    {
        return BirthdayWish::where('member_id', $member->id)
            ->where('wish_type', $wishType)
            ->where('year_sent', $year)
            ->where('status', 'sent')
            ->exists();
    }

    /**
     * Get members with wedding anniversaries today.
     */
    public function getTodaysWeddingAnniversaries(): Collection
    {
        $today = now();

        return Member::where('member_status', 'active')
            ->where('marital_status', 'married')
            ->whereNotNull('wedding_date')
            ->whereMonth('wedding_date', $today->month)
            ->whereDay('wedding_date', $today->day)
            ->get();
    }

    /**
     * Get members with membership anniversaries today.
     */
    public function getTodaysMembershipAnniversaries(): Collection
    {
        $today = now();

        return Member::where('member_status', 'active')
            ->whereNotNull('membership_date')
            ->whereMonth('membership_date', $today->month)
            ->whereDay('membership_date', $today->day)
            ->get();
    }

    /**
     * Create anniversary milestone.
     */
    public function createMilestone(Member $member, array $data): AnniversaryMilestone
    {
        return AnniversaryMilestone::create(array_merge([
            'member_id' => $member->id,
        ], $data));
    }

    /**
     * Get upcoming milestones.
     */
    public function getUpcomingMilestones(int $days = 30): Collection
    {
        return AnniversaryMilestone::with('member')
            ->upcoming($days)
            ->unrecognized()
            ->orderBy('milestone_date')
            ->get();
    }

    /**
     * Get special milestones (25th, 50th anniversaries, etc.).
     */
    public function getSpecialMilestones(): Collection
    {
        return AnniversaryMilestone::with('member')
            ->special()
            ->unrecognized()
            ->orderBy('milestone_date')
            ->get();
    }

    /**
     * Get automation settings.
     */
    public function getSettings(?string $eventType = null)
    {
        if ($eventType) {
            return BirthdayAutomationSetting::forEventType($eventType);
        }

        return BirthdayAutomationSetting::all();
    }

    /**
     * Update automation settings.
     */
    public function updateSettings(string $eventType, array $data): BirthdayAutomationSetting
    {
        return BirthdayAutomationSetting::updateOrCreate(
            ['event_type' => $eventType],
            $data
        );
    }

    /**
     * Create service announcement.
     */
    public function createServiceAnnouncement(array $data): ServiceAnnouncement
    {
        return ServiceAnnouncement::create($data);
    }

    /**
     * Get announcements for service date.
     */
    public function getServiceAnnouncements(Carbon $serviceDate, string $serviceType = 'sunday_service'): Collection
    {
        return ServiceAnnouncement::forServiceDate($serviceDate)
            ->where('service_type', $serviceType)
            ->orderBy('announcement_type')
            ->get();
    }

    /**
     * Get undisplayed announcements.
     */
    public function getUndisplayedAnnouncements(): Collection
    {
        return ServiceAnnouncement::undisplayed()
            ->orderBy('service_date')
            ->get();
    }

    /**
     * Generate birthday announcement for service.
     */
    public function generateBirthdayAnnouncement(Carbon $serviceDate): ?ServiceAnnouncement
    {
        $birthdays = $this->getBirthdaysInRange(
            $serviceDate->copy()->subDays(7),
            $serviceDate
        );

        if ($birthdays->isEmpty()) {
            return null;
        }

        $names = $birthdays->map(fn ($member) => $member->full_name)->join(', ', ' and ');
        $text = "Let's celebrate the following members who celebrated their birthdays this week: {$names}. May God bless you abundantly!";

        return $this->createServiceAnnouncement([
            'service_date' => $serviceDate,
            'service_type' => 'sunday_service',
            'announcement_type' => 'birthdays',
            'announcement_text' => $text,
            'member_ids' => $birthdays->pluck('id')->toArray(),
        ]);
    }

    /**
     * Generate anniversary announcement for service.
     */
    public function generateAnniversaryAnnouncement(Carbon $serviceDate): ?ServiceAnnouncement
    {
        $anniversaries = $this->getTodaysWeddingAnniversaries();

        if ($anniversaries->isEmpty()) {
            return null;
        }

        $names = $anniversaries->map(function ($member) {
            $years = Carbon::parse($member->wedding_date)->diffInYears(now());

            return "{$member->full_name} ({$years} years)";
        })->join(', ', ' and ');

        $text = "We celebrate wedding anniversaries with: {$names}. May God continue to bless your marriages!";

        return $this->createServiceAnnouncement([
            'service_date' => $serviceDate,
            'service_type' => 'sunday_service',
            'announcement_type' => 'anniversaries',
            'announcement_text' => $text,
            'member_ids' => $anniversaries->pluck('id')->toArray(),
        ]);
    }

    /**
     * Get birthday statistics.
     */
    public function getStatistics(): array
    {
        $thisMonth = now();

        return [
            'birthdays_today' => $this->getTodaysBirthdays()->count(),
            'birthdays_this_week' => $this->getBirthdaysInRange(now(), now()->addDays(7))->count(),
            'birthdays_this_month' => $this->getBirthdaysInRange($thisMonth->startOfMonth(), $thisMonth->endOfMonth())->count(),
            'pending_wishes' => BirthdayWish::pending()->count(),
            'sent_this_month' => BirthdayWish::sent()
                ->whereMonth('sent_at', $thisMonth->month)
                ->whereYear('sent_at', $thisMonth->year)
                ->count(),
            'failed_wishes' => BirthdayWish::failed()->where('retry_count', '<', 3)->count(),
            'upcoming_milestones' => AnniversaryMilestone::upcoming(30)->unrecognized()->count(),
            'special_milestones' => AnniversaryMilestone::special()->unrecognized()->count(),
        ];
    }

    /**
     * Get birthday wish history for a member.
     */
    public function getMemberWishHistory(Member $member): Collection
    {
        return BirthdayWish::where('member_id', $member->id)
            ->orderBy('year_sent', 'desc')
            ->get();
    }

    /**
     * Get member milestones.
     */
    public function getMemberMilestones(Member $member): Collection
    {
        return AnniversaryMilestone::where('member_id', $member->id)
            ->orderBy('milestone_date', 'desc')
            ->get();
    }
}
