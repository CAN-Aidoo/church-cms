<?php

namespace App\Events;

use App\Models\Visitor;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VisitorEligibleForConversion
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Visitor $visitor;

    public int $visitCount;

    /**
     * Create a new event instance.
     * Triggered when visitor reaches 5th visit
     */
    public function __construct(Visitor $visitor, int $visitCount)
    {
        $this->visitor = $visitor;
        $this->visitCount = $visitCount;
    }
}
