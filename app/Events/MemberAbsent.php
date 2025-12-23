<?php

namespace App\Events;

use App\Models\Member;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MemberAbsent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Member $member;

    public int $consecutiveAbsences;

    public \Carbon\Carbon $serviceDate;

    public string $serviceType;

    /**
     * Create a new event instance.
     */
    public function __construct(
        Member $member,
        int $consecutiveAbsences,
        \Carbon\Carbon $serviceDate,
        string $serviceType
    ) {
        $this->member = $member;
        $this->consecutiveAbsences = $consecutiveAbsences;
        $this->serviceDate = $serviceDate;
        $this->serviceType = $serviceType;
    }
}
