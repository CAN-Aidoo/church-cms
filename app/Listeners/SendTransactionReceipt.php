<?php

namespace App\Listeners;

use App\Events\TransactionApproved;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendTransactionReceipt implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        private NotificationService $notificationService
    ) {}

    /**
     * Handle the event.
     * Send receipt to member when transaction is approved
     */
    public function handle(TransactionApproved $event): void
    {
        try {
            $transaction = $event->transaction;

            // Only send receipt for income transactions with a member
            if ($transaction->type !== 'income' || !$transaction->member_id) {
                return;
            }

            $member = $transaction->member;

            if (!$member->user_id) {
                Log::info("Skipping receipt for transaction {$transaction->id}: Member has no user account");
                return;
            }

            $this->notificationService->send(
                userId: $member->user_id,
                type: 'transaction_receipt',
                title: 'Transaction Receipt',
                message: "Thank you for your {$transaction->category} of GHS " . number_format($transaction->amount, 2),
                channels: ['email', 'in_app'],
                data: [
                    'transaction_id' => $transaction->id,
                    'type' => $transaction->type,
                    'category' => $transaction->category,
                    'amount' => $transaction->amount,
                    'transaction_date' => $transaction->transaction_date->format('Y-m-d'),
                    'reference_number' => $transaction->reference_number
                ]
            );

            Log::info("Receipt sent for transaction: {$transaction->id}");
        } catch (\Exception $e) {
            Log::error("Failed to send transaction receipt: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(TransactionApproved $event, \Throwable $exception): void
    {
        Log::error("SendTransactionReceipt failed for transaction {$event->transaction->id}: {$exception->getMessage()}");
    }
}
