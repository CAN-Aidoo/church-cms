<?php

namespace App\Events;

use App\Models\ProgramRegistration;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProgramRegistrationReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ProgramRegistration $registration;
    public bool $requiresPayment;

    /**
     * Create a new event instance.
     */
    public function __construct(ProgramRegistration $registration, bool $requiresPayment = false)
    {
        $this->registration = $registration;
        $this->requiresPayment = $requiresPayment;
    }
}
