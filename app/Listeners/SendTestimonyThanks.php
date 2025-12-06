<?php

namespace App\Listeners;

use App\Events\PrayerRequestAnswered;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendTestimonyThanks implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        private NotificationService $notificationService
    ) {}

    /**
     * Handle the event.
     * Send thank you message when prayer request is answered
     */
    public function handle(PrayerRequestAnswered $event): void
    {
        try {
            $prayerRequest = $event->prayerRequest;

            if (!$prayerRequest->submitted_by) {
                return;
            }

            $this->notificationService->send(
                userId: $prayerRequest->submitted_by,
                type: 'prayer_answered',
                title: 'Praise Report!',
                message: "Hallelujah! Your prayer request has been marked as answered. We give glory to God!",
                channels: ['in_app', 'email'],
                priority: 'normal',
                data: [
                    'prayer_request_id' => $prayerRequest->id,
                    'title' => $prayerRequest->title,
                    'testimony' => $event->testimony
                ]
            );

            Log::info("Testimony thanks sent for prayer request: {$prayerRequest->id}");
        } catch (\Exception $e) {
            Log::error("Failed to send testimony thanks: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(PrayerRequestAnswered $event, \Throwable $exception): void
    {
        Log::error("SendTestimonyThanks failed for prayer request {$event->prayerRequest->id}: {$exception->getMessage()}");
    }
}
