<?php

namespace App\Events;

use App\Models\Member;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MemberRegistered implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Member $member;

    public bool $convertedFromVisitor;

    /**
     * Create a new event instance.
     */
    public function __construct(Member $member, bool $convertedFromVisitor = false)
    {
        $this->member = $member;
        $this->convertedFromVisitor = $convertedFromVisitor;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('members'),
            new PresenceChannel('admin-dashboard'),
        ];
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->member->id,
            'member_id' => $this->member->member_id,
            'name' => $this->member->first_name.' '.$this->member->last_name,
            'email' => $this->member->email,
            'phone' => $this->member->phone,
            'status' => $this->member->status,
            'converted_from_visitor' => $this->convertedFromVisitor,
            'timestamp' => now()->toISOString(),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'member.registered';
    }
}
