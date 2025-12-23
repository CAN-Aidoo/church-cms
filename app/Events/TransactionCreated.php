<?php

namespace App\Events;

use App\Models\Transaction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Transaction $transaction;

    public bool $requiresApproval;

    /**
     * Create a new event instance.
     */
    public function __construct(Transaction $transaction, bool $requiresApproval = false)
    {
        $this->transaction = $transaction;
        $this->requiresApproval = $requiresApproval;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('transactions'),
            new PresenceChannel('finance-dashboard'),
        ];
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->transaction->id,
            'transaction_type' => $this->transaction->transaction_type,
            'category' => $this->transaction->category,
            'amount' => $this->transaction->amount,
            'transaction_date' => $this->transaction->transaction_date->format('Y-m-d'),
            'status' => $this->transaction->status,
            'requires_approval' => $this->requiresApproval,
            'member_name' => $this->transaction->member
                ? $this->transaction->member->first_name.' '.$this->transaction->member->last_name
                : null,
            'timestamp' => now()->toISOString(),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'transaction.created';
    }
}
