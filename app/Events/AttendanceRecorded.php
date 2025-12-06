<?php

namespace App\Events;

use App\Models\Attendance;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AttendanceRecorded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $attendance;
    public $memberName;
    public $serviceDate;
    public $serviceType;

    /**
     * Create a new event instance.
     */
    public function __construct(Attendance $attendance)
    {
        $this->attendance = $attendance;
        $this->memberName = $attendance->member->first_name . ' ' . $attendance->member->last_name;
        $this->serviceDate = $attendance->service_date->format('Y-m-d');
        $this->serviceType = $attendance->service_type;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('attendance'),
            new Channel('attendance.' . $this->serviceDate),
            new PresenceChannel('staff-dashboard'),
        ];
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->attendance->id,
            'member_id' => $this->attendance->member_id,
            'member_name' => $this->memberName,
            'service_date' => $this->serviceDate,
            'service_type' => $this->serviceType,
            'status' => $this->attendance->status,
            'check_in_time' => $this->attendance->check_in_time,
            'check_in_method' => $this->attendance->check_in_method,
            'timestamp' => now()->toISOString(),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'attendance.recorded';
    }
}
