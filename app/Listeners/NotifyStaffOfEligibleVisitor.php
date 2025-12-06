<?php

namespace App\Listeners;

use App\Events\VisitorEligibleForConversion;
use App\Services\NotificationService;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifyStaffOfEligibleVisitor implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        private NotificationService $notificationService
    ) {}

    /**
     * Handle the event.
     * Notify staff when visitor is eligible for membership conversion (5th visit)
     */
    public function handle(VisitorEligibleForConversion $event): void
    {
        try {
            $visitor = $event->visitor;

            // Get all staff, pastors, and admins
            $staff = User::whereIn('role', ['admin', 'pastor', 'staff'])->get();

            foreach ($staff as $user) {
                $this->notificationService->send(
                    userId: $user->id,
                    type: 'visitor_conversion',
                    title: 'Visitor Eligible for Membership',
                    message: "{$visitor->first_name} {$visitor->last_name} has completed {$event->visitCount} visits and is eligible for membership conversion.",
                    channels: ['in_app', 'email'],
                    priority: 'high',
                    data: [
                        'visitor_id' => $visitor->id,
                        'visitor_name' => $visitor->first_name . ' ' . $visitor->last_name,
                        'visit_count' => $event->visitCount,
                        'phone' => $visitor->phone,
                        'email' => $visitor->email
                    ]
                );
            }

            Log::info("Staff notified about eligible visitor: {$visitor->id}");
        } catch (\Exception $e) {
            Log::error("Failed to notify staff of eligible visitor: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(VisitorEligibleForConversion $event, \Throwable $exception): void
    {
        Log::error("NotifyStaffOfEligibleVisitor failed for visitor {$event->visitor->id}: {$exception->getMessage()}");
    }
}
