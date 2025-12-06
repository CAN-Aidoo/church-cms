<?php

namespace App\Listeners;

use App\Events\VisitorRegistered;
use App\Services\SmsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendVisitorFollowUp implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        private SmsService $smsService
    ) {}

    /**
     * Handle the event.
     * Send welcome message to first-time visitor within 24 hours
     */
    public function handle(VisitorRegistered $event): void
    {
        try {
            if (!$event->isFirstVisit) {
                return;
            }

            $visitor = $event->visitor;

            if (empty($visitor->phone)) {
                Log::info("Skipping visitor follow-up for visitor {$visitor->id}: No phone number");
                return;
            }

            $message = "Hello {$visitor->first_name}, thank you for visiting our church! "
                     . "We're excited to have you and hope to see you again soon. "
                     . "God bless you!";

            // Delay sending by 2 hours to avoid immediate spam
            $this->smsService->sendSms(
                to: $visitor->phone,
                message: $message
            );

            Log::info("Follow-up SMS sent to visitor: {$visitor->id}");
        } catch (\Exception $e) {
            Log::error("Failed to send visitor follow-up: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Delay execution by 2 hours
     */
    public function viaQueue(): string
    {
        return 'notifications';
    }

    public function delay(): \DateTimeInterface|\DateInterval|int
    {
        return now()->addHours(2);
    }

    /**
     * Handle a job failure.
     */
    public function failed(VisitorRegistered $event, \Throwable $exception): void
    {
        Log::error("SendVisitorFollowUp failed for visitor {$event->visitor->id}: {$exception->getMessage()}");
    }
}
