<?php

namespace App\Events;

use App\Models\Attendance;
use App\Models\Member;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AttendanceMarked
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Member $member;
    public Attendance $attendance;
    public bool $isFirstTimeAfterAbsence;
    public int $consecutiveAbsences;

    /**
     * Create a new event instance.
     */
    public function __construct(
        Member $member,
        Attendance $attendance,
        bool $isFirstTimeAfterAbsence = false,
        int $consecutiveAbsences = 0
    ) {
        $this->member = $member;
        $this->attendance = $attendance;
        $this->isFirstTimeAfterAbsence = $isFirstTimeAfterAbsence;
        $this->consecutiveAbsences = $consecutiveAbsences;
    }
}
