<?php

namespace App\Events;

use App\Models\Member;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MemberStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Member $member;
    public string $oldStatus;
    public string $newStatus;
    public ?string $reason;

    /**
     * Create a new event instance.
     */
    public function __construct(Member $member, string $oldStatus, string $newStatus, ?string $reason = null)
    {
        $this->member = $member;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->reason = $reason;
    }
}
