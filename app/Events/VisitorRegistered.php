<?php

namespace App\Events;

use App\Models\Visitor;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VisitorRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Visitor $visitor;

    public bool $isFirstVisit;

    /**
     * Create a new event instance.
     */
    public function __construct(Visitor $visitor, bool $isFirstVisit = true)
    {
        $this->visitor = $visitor;
        $this->isFirstVisit = $isFirstVisit;
    }
}
