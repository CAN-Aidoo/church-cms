<?php

namespace App\Events;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionApproved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Transaction $transaction;
    public User $approvedBy;

    /**
     * Create a new event instance.
     */
    public function __construct(Transaction $transaction, User $approvedBy)
    {
        $this->transaction = $transaction;
        $this->approvedBy = $approvedBy;
    }
}
