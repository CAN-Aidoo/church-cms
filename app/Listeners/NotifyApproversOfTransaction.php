<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use App\Services\NotificationService;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifyApproversOfTransaction implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        private NotificationService $notificationService
    ) {}

    /**
     * Handle the event.
     * Notify approvers when transaction requires approval
     */
    public function handle(TransactionCreated $event): void
    {
        try {
            if (!$event->requiresApproval) {
                return;
            }

            $transaction = $event->transaction;

            // Determine approvers based on amount
            $approvers = User::whereIn('role', ['admin', 'pastor'])->get();

            foreach ($approvers as $approver) {
                $this->notificationService->send(
                    userId: $approver->id,
                    type: 'finance_approval',
                    title: 'Transaction Approval Required',
                    message: "A {$transaction->type} transaction of GHS " . number_format($transaction->amount, 2) . " requires your approval.",
                    channels: ['in_app', 'email'],
                    priority: $transaction->amount > 5000 ? 'high' : 'normal',
                    data: [
                        'transaction_id' => $transaction->id,
                        'type' => $transaction->type,
                        'amount' => $transaction->amount,
                        'category' => $transaction->category,
                        'description' => $transaction->description
                    ]
                );
            }

            Log::info("Approvers notified for transaction: {$transaction->id}");
        } catch (\Exception $e) {
            Log::error("Failed to notify approvers: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(TransactionCreated $event, \Throwable $exception): void
    {
        Log::error("NotifyApproversOfTransaction failed for transaction {$event->transaction->id}: {$exception->getMessage()}");
    }
}
