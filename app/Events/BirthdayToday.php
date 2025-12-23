<?php

namespace App\Events;

use App\Models\Member;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BirthdayToday
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Member $member;

    public int $age;

    public bool $isMilestone;

    /**
     * Create a new event instance.
     */
    public function __construct(Member $member, int $age, bool $isMilestone = false)
    {
        $this->member = $member;
        $this->age = $age;
        $this->isMilestone = $isMilestone;
    }
}
