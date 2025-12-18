<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Birthday wishes - Run daily at 12:00 AM
        $schedule->command('birthdays:process')
            ->dailyAt('00:00')
            ->timezone('Africa/Accra');

        // Attendance alerts - Run daily at 9:00 AM (Monday after Sunday service)
        $schedule->command('attendance:alerts')
            ->dailyAt('09:00')
            ->timezone('Africa/Accra')
            ->mondays();

        // Scheduled reports - Run hourly to check for due reports
        $schedule->command('reports:scheduled')
            ->hourly()
            ->timezone('Africa/Accra');

        // Database backup - Run daily at 2:00 AM
        $schedule->command('backup:database')
            ->dailyAt('02:00')
            ->timezone('Africa/Accra');

        // Clean old backups - Run weekly on Sunday at 3:00 AM
        $schedule->command('backup:clean')
            ->weeklyOn(0, '03:00')
            ->timezone('Africa/Accra');

        // QR Code Generation - Generate service QR codes automatically
        // Sunday services - Generate at 6:00 AM (1 hour before first service)
        $schedule->command('qr:generate-scheduled')
            ->weeklyOn(0, '06:00')
            ->timezone('Africa/Accra');

        // Wednesday service - Generate at 4:00 PM (4 hours before service)
        $schedule->command('qr:generate-scheduled')
            ->weeklyOn(3, '16:00')
            ->timezone('Africa/Accra');

        // Friday service - Generate at 4:00 PM (4 hours before service)
        $schedule->command('qr:generate-scheduled')
            ->weeklyOn(5, '16:00')
            ->timezone('Africa/Accra');

        // Queue work - Process queued jobs
        // Note: In production, use supervisor or systemd to keep queue worker running
        // This is a fallback for development
        if (app()->environment('local')) {
            $schedule->command('queue:work --stop-when-empty')
                ->everyMinute()
                ->withoutOverlapping();
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
