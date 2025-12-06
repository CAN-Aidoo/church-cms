<?php

namespace App\Console\Commands;

use App\Jobs\ProcessAttendanceAlerts as ProcessAttendanceAlertsJob;
use Illuminate\Console\Command;

class ProcessAttendanceAlerts extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'attendance:alerts';

    /**
     * The console command description.
     */
    protected $description = 'Process attendance alerts for members with consecutive absences';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Processing attendance alerts...');

        ProcessAttendanceAlertsJob::dispatch();

        $this->info('Attendance alerts job dispatched successfully!');

        return Command::SUCCESS;
    }
}
