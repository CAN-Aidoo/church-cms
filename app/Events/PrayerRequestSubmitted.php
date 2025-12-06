<?php

namespace App\Events;

use App\Models\PrayerRequest;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PrayerRequestSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public PrayerRequest $prayerRequest;
    public bool $isUrgent;

    /**
     * Create a new event instance.
     */
    public function __construct(PrayerRequest $prayerRequest, bool $isUrgent = false)
    {
        $this->prayerRequest = $prayerRequest;
        $this->isUrgent = $isUrgent;
    }
}
