<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // Member Events
        \App\Events\MemberRegistered::class => [
            \App\Listeners\SendWelcomeEmail::class,
            \App\Listeners\SendWelcomeSms::class,
            \App\Listeners\AssignMemberToShepherd::class,
            \App\Listeners\NotifyPastoralTeam::class,
        ],

        \App\Events\MemberStatusChanged::class => [
            // Add listeners for status changes
        ],

        // Attendance Events
        \App\Events\AttendanceMarked::class => [
            \App\Listeners\SendWelcomeBackMessage::class,
        ],

        \App\Events\MemberAbsent::class => [
            \App\Listeners\SendAbsenceReminder::class,
        ],

        // Transaction Events
        \App\Events\TransactionCreated::class => [
            \App\Listeners\NotifyApproversOfTransaction::class,
        ],

        \App\Events\TransactionApproved::class => [
            \App\Listeners\SendTransactionReceipt::class,
        ],

        // Visitor Events
        \App\Events\VisitorRegistered::class => [
            \App\Listeners\SendVisitorFollowUp::class,
        ],

        \App\Events\VisitorEligibleForConversion::class => [
            \App\Listeners\NotifyStaffOfEligibleVisitor::class,
        ],

        // Prayer Request Events
        \App\Events\PrayerRequestSubmitted::class => [
            \App\Listeners\NotifyPrayerTeam::class,
        ],

        \App\Events\PrayerRequestAnswered::class => [
            \App\Listeners\SendTestimonyThanks::class,
        ],

        // Birthday Events
        \App\Events\BirthdayToday::class => [
            \App\Listeners\SendBirthdayWishes::class,
        ],

        // Program Events
        \App\Events\ProgramRegistrationReceived::class => [
            \App\Listeners\SendProgramConfirmation::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
