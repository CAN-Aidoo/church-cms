<?php

namespace App\Listeners;

use App\Events\PrayerRequestSubmitted;
use App\Services\NotificationService;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifyPrayerTeam implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        private NotificationService $notificationService
    ) {}

    /**
     * Handle the event.
     * Notify prayer team of new prayer request
     */
    public function handle(PrayerRequestSubmitted $event): void
    {
        try {
            $prayerRequest = $event->prayerRequest;

            // Only notify for non-anonymous requests or pastoral-level requests
            if ($prayerRequest->confidentiality_level === 'pastoral') {
                // Notify only pastors
                $users = User::whereIn('role', ['admin', 'pastor'])->get();
            } elseif ($prayerRequest->confidentiality_level === 'prayer_team') {
                // Notify prayer team members (implement prayer team role later)
                $users = User::whereIn('role', ['admin', 'pastor', 'staff'])->get();
            } else {
                // Public requests
                $users = User::whereIn('role', ['admin', 'pastor', 'staff'])->get();
            }

            foreach ($users as $user) {
                $this->notificationService->send(
                    userId: $user->id,
                    type: 'prayer_request',
                    title: $event->isUrgent ? 'Urgent Prayer Request' : 'New Prayer Request',
                    message: "A new {$prayerRequest->category} prayer request has been submitted.",
                    channels: $event->isUrgent ? ['in_app', 'sms'] : ['in_app'],
                    priority: $event->isUrgent ? 'urgent' : 'normal',
                    data: [
                        'prayer_request_id' => $prayerRequest->id,
                        'category' => $prayerRequest->category,
                        'urgency' => $prayerRequest->urgency,
                        'title' => $prayerRequest->title
                    ]
                );
            }

            Log::info("Prayer team notified about prayer request: {$prayerRequest->id}");
        } catch (\Exception $e) {
            Log::error("Failed to notify prayer team: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(PrayerRequestSubmitted $event, \Throwable $exception): void
    {
        Log::error("NotifyPrayerTeam failed for prayer request {$event->prayerRequest->id}: {$exception->getMessage()}");
    }
}
