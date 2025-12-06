<?php

namespace App\Listeners;

use App\Events\BirthdayToday;
use App\Services\SmsService;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendBirthdayWishes implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        private SmsService $smsService,
        private NotificationService $notificationService
    ) {}

    /**
     * Handle the event.
     * Send birthday wishes via SMS and in-app notification
     */
    public function handle(BirthdayToday $event): void
    {
        try {
            $member = $event->member;

            // Send SMS if phone number available
            if (!empty($member->phone)) {
                $message = $event->isMilestone
                    ? "Happy {$event->age}th Birthday, {$member->first_name}! 🎉 What a special milestone! May God continue to bless you abundantly. Enjoy your special day!"
                    : "Happy Birthday, {$member->first_name}! 🎂 Wishing you a blessed year ahead filled with God's goodness and grace!";

                $this->smsService->sendSms(
                    to: $member->phone,
                    message: $message
                );
            }

            // Send in-app notification if user account exists
            if ($member->user_id) {
                $this->notificationService->send(
                    userId: $member->user_id,
                    type: 'birthday',
                    title: 'Happy Birthday!',
                    message: $event->isMilestone
                        ? "Congratulations on turning {$event->age}! May this milestone year be filled with blessings."
                        : "Wishing you a wonderful birthday filled with love, joy, and God's blessings!",
                    channels: ['in_app'],
                    data: [
                        'member_id' => $member->id,
                        'age' => $event->age,
                        'is_milestone' => $event->isMilestone
                    ]
                );
            }

            Log::info("Birthday wishes sent to member: {$member->id}");
        } catch (\Exception $e) {
            Log::error("Failed to send birthday wishes: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(BirthdayToday $event, \Throwable $exception): void
    {
        Log::error("SendBirthdayWishes failed for member {$event->member->id}: {$exception->getMessage()}");
    }
}
