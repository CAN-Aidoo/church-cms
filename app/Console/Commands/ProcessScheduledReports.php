<?php

namespace App\Console\Commands;

use App\Jobs\ProcessScheduledReports as ProcessScheduledReportsJob;
use Illuminate\Console\Command;

class ProcessScheduledReports extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'reports:scheduled';

    /**
     * The console command description.
     */
    protected $description = 'Process all scheduled reports that are due';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Processing scheduled reports...');

        ProcessScheduledReportsJob::dispatch();

        $this->info('Scheduled reports job dispatched successfully!');

        return Command::SUCCESS;
    }
}
