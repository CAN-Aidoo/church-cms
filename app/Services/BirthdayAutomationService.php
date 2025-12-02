<?php

namespace App\Services;

use App\Models\AnniversaryMilestone;
use App\Models\BirthdayWish;
use App\Models\Member;
use App\Repositories\BirthdayAutomationRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BirthdayAutomationService
{
    public function __construct(
        protected BirthdayAutomationRepository $repository,
        protected SmsService $smsService
    ) {}

    /**
     * Process all birthday automation tasks for today.
     */
    public function processDailyBirthdays(): array
    {
        $results = [
            'birthdays_found' => 0,
            'wishes_sent' => 0,
            'wishes_failed' => 0,
            'milestones_created' => 0,
            'announcements_created' => 0,
        ];

        try {
            // Get today's birthdays
            $birthdays = $this->repository->getTodaysBirthdays();
            $results['birthdays_found'] = $birthdays->count();

            // Send birthday wishes
            foreach ($birthdays as $member) {
                if ($this->sendBirthdayWish($member)) {
                    $results['wishes_sent']++;
                } else {
                    $results['wishes_failed']++;
                }
            }

            // Process wedding anniversaries
            $weddingAnniversaries = $this->repository->getTodaysWeddingAnniversaries();
            foreach ($weddingAnniversaries as $member) {
                $years = Carbon::parse($member->wedding_date)->diffInYears(now());

                // Create milestone for special years
                if ($this->isSpecialAnniversary($years)) {
                    $this->createAnniversaryMilestone($member, 'wedding_anniversary', $years);
                    $results['milestones_created']++;
                }

                // Send anniversary wish
                if ($this->sendAnniversaryWish($member, $years)) {
                    $results['wishes_sent']++;
                } else {
                    $results['wishes_failed']++;
                }
            }

            // Process membership anniversaries
            $membershipAnniversaries = $this->repository->getTodaysMembershipAnniversaries();
            foreach ($membershipAnniversaries as $member) {
                $years = Carbon::parse($member->membership_date)->diffInYears(now());

                // Create milestone for significant years
                if (in_array($years, [1, 5, 10, 15, 20, 25, 30])) {
                    $this->createAnniversaryMilestone($member, 'membership_anniversary', $years);
                    $results['milestones_created']++;
                }
            }

            // Generate service announcements for upcoming Sunday
            $nextSunday = $this->getNextSunday();
            $this->repository->generateBirthdayAnnouncement($nextSunday);
            $this->repository->generateAnniversaryAnnouncement($nextSunday);
            $results['announcements_created'] = 2;

        } catch (\Exception $e) {
            Log::error('Birthday automation failed: '.$e->getMessage());
            throw $e;
        }

        return $results;
    }

    /**
     * Send birthday wish to a member.
     */
    public function sendBirthdayWish(Member $member): bool
    {
        try {
            // Check if already sent this year
            if ($this->repository->hasWishBeenSent($member, 'birthday', now()->year)) {
                return false;
            }

            // Get settings
            $settings = $this->repository->getSettings('birthday');
            if (! $settings || ! $settings->enabled) {
                return false;
            }

            // Parse message
            $age = Carbon::parse($member->date_of_birth)->age;
            $message = $settings->getParsedMessage($member, [
                '{age}' => $age,
            ]);

            // Create wish record
            $wish = $this->repository->createBirthdayWish($member, [
                'delivery_method' => $settings->sms_enabled ? 'sms' : 'email',
                'message' => $message,
                'scheduled_at' => now(),
            ]);

            // Send SMS
            if ($settings->sms_enabled && $member->phone) {
                $smsResult = $this->smsService->sendSms($member->phone, $message);

                if ($smsResult['success']) {
                    $wish->markAsSent($smsResult['message_id'], 'sms');

                    return true;
                } else {
                    $wish->markAsFailed($smsResult['error'] ?? 'SMS delivery failed');

                    return false;
                }
            }

            // Send Email (if SMS not enabled)
            if ($settings->email_enabled && $member->email) {
                // Email implementation would go here
                $wish->markAsSent(null, 'email');

                return true;
            }

            return false;

        } catch (\Exception $e) {
            Log::error("Failed to send birthday wish to member {$member->id}: ".$e->getMessage());

            return false;
        }
    }

    /**
     * Send anniversary wish to a member.
     */
    public function sendAnniversaryWish(Member $member, int $years): bool
    {
        try {
            // Check if already sent this year
            if ($this->repository->hasWishBeenSent($member, 'wedding_anniversary', now()->year)) {
                return false;
            }

            // Get settings
            $settings = $this->repository->getSettings('wedding_anniversary');
            if (! $settings || ! $settings->enabled) {
                return false;
            }

            // Use special message for milestone anniversaries
            $isSpecial = $this->isSpecialAnniversary($years);
            $message = $isSpecial && $settings->special_milestone_message
                ? $settings->getParsedMessage($member, ['{years}' => $years, '{ordinal}' => $this->getOrdinal($years)])
                : $settings->getParsedMessage($member, ['{years}' => $years]);

            // Create wish record
            $wish = BirthdayWish::create([
                'member_id' => $member->id,
                'birthday_date' => $member->wedding_date,
                'year_sent' => now()->year,
                'wish_type' => 'wedding_anniversary',
                'delivery_method' => $settings->sms_enabled ? 'sms' : 'email',
                'message' => $message,
                'scheduled_at' => now(),
                'status' => 'pending',
            ]);

            // Send SMS
            if ($settings->sms_enabled && $member->phone) {
                $smsResult = $this->smsService->sendSms($member->phone, $message);

                if ($smsResult['success']) {
                    $wish->markAsSent($smsResult['message_id'], 'sms');

                    return true;
                } else {
                    $wish->markAsFailed($smsResult['error'] ?? 'SMS delivery failed');

                    return false;
                }
            }

            return false;

        } catch (\Exception $e) {
            Log::error("Failed to send anniversary wish to member {$member->id}: ".$e->getMessage());

            return false;
        }
    }

    /**
     * Create anniversary milestone.
     */
    public function createAnniversaryMilestone(Member $member, string $milestoneType, int $years): AnniversaryMilestone
    {
        return $this->repository->createMilestone($member, [
            'milestone_type' => $milestoneType,
            'milestone_date' => now()->toDateString(),
            'years_completed' => $years,
            'is_special' => $this->isSpecialAnniversary($years),
        ]);
    }

    /**
     * Retry failed wishes.
     */
    public function retryFailedWishes(): array
    {
        $results = [
            'retried' => 0,
            'succeeded' => 0,
            'failed' => 0,
        ];

        $retryable = $this->repository->getRetryableWishes();
        $results['retried'] = $retryable->count();

        foreach ($retryable as $wish) {
            try {
                $member = $wish->member;

                if ($wish->delivery_method === 'sms' && $member->phone) {
                    $smsResult = $this->smsService->sendSms($member->phone, $wish->message);

                    if ($smsResult['success']) {
                        $wish->markAsSent($smsResult['message_id'], 'sms');
                        $results['succeeded']++;
                    } else {
                        $wish->markAsFailed($smsResult['error'] ?? 'SMS delivery failed');
                        $results['failed']++;
                    }
                }
            } catch (\Exception $e) {
                $wish->markAsFailed($e->getMessage());
                $results['failed']++;
            }
        }

        return $results;
    }

    /**
     * Check if anniversary year is special.
     */
    protected function isSpecialAnniversary(int $years): bool
    {
        return in_array($years, [1, 5, 10, 25, 50]);
    }

    /**
     * Get ordinal suffix for number.
     */
    protected function getOrdinal(int $number): string
    {
        $suffixes = ['th', 'st', 'nd', 'rd'];
        $mod100 = $number % 100;

        if ($mod100 >= 11 && $mod100 <= 13) {
            return $number.'th';
        }

        $mod10 = $number % 10;

        return $number.($suffixes[$mod10] ?? 'th');
    }

    /**
     * Get next Sunday date.
     */
    protected function getNextSunday(): Carbon
    {
        $today = now();

        return $today->dayOfWeek === Carbon::SUNDAY
            ? $today
            : $today->next(Carbon::SUNDAY);
    }

    /**
     * Generate upcoming birthday report.
     */
    public function getUpcomingBirthdaysReport(int $days = 30): array
    {
        $birthdays = $this->repository->getUpcomingBirthdays($days);

        $groupedByDate = $birthdays->groupBy(function ($member) {
            return Carbon::parse($member->date_of_birth)->format('m-d');
        })->map(function ($members) {
            return $members->map(function ($member) {
                return [
                    'id' => $member->id,
                    'name' => $member->full_name,
                    'phone' => $member->phone,
                    'age' => Carbon::parse($member->date_of_birth)->age + 1, // Next birthday age
                    'date' => Carbon::parse($member->date_of_birth)->format('M d'),
                ];
            });
        });

        return [
            'total' => $birthdays->count(),
            'grouped_by_date' => $groupedByDate,
        ];
    }
}
