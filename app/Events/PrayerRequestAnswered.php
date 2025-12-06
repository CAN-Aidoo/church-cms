<?php

namespace App\Events;

use App\Models\PrayerRequest;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PrayerRequestAnswered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public PrayerRequest $prayerRequest;
    public ?string $testimony;

    /**
     * Create a new event instance.
     */
    public function __construct(PrayerRequest $prayerRequest, ?string $testimony = null)
    {
        $this->prayerRequest = $prayerRequest;
        $this->testimony = $testimony;
    }
}
