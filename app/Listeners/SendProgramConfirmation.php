<?php

namespace App\Listeners;

use App\Events\ProgramRegistrationReceived;
use App\Services\NotificationService;
use App\Services\SmsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendProgramConfirmation implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        private NotificationService $notificationService,
        private SmsService $smsService
    ) {}

    /**
     * Handle the event.
     * Send registration confirmation to participant
     */
    public function handle(ProgramRegistrationReceived $event): void
    {
        try {
            $registration = $event->registration;
            $program = $registration->program;
            $member = $registration->member;

            // Send in-app and email notification
            if ($member->user_id) {
                $this->notificationService->send(
                    userId: $member->user_id,
                    type: 'program_registration',
                    title: 'Program Registration Confirmed',
                    message: "Your registration for {$program->name} has been confirmed!",
                    channels: ['in_app', 'email'],
                    data: [
                        'program_id' => $program->id,
                        'program_name' => $program->name,
                        'start_date' => $program->start_date->format('Y-m-d'),
                        'venue' => $program->venue,
                        'registration_code' => $registration->registration_code,
                        'requires_payment' => $event->requiresPayment,
                        'amount' => $program->registration_fee
                    ]
                );
            }

            // Send SMS confirmation
            if (!empty($member->phone)) {
                $message = "Your registration for {$program->name} is confirmed! ";
                $message .= "Date: " . $program->start_date->format('M d, Y') . ". ";
                $message .= "Venue: {$program->venue}. ";

                if ($event->requiresPayment) {
                    $message .= "Registration fee: GHS " . number_format($program->registration_fee, 2) . ". ";
                }

                $message .= "Code: {$registration->registration_code}";

                $this->smsService->sendSms(
                    to: $member->phone,
                    message: $message
                );
            }

            Log::info("Program confirmation sent for registration: {$registration->id}");
        } catch (\Exception $e) {
            Log::error("Failed to send program confirmation: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(ProgramRegistrationReceived $event, \Throwable $exception): void
    {
        Log::error("SendProgramConfirmation failed for registration {$event->registration->id}: {$exception->getMessage()}");
    }
}
