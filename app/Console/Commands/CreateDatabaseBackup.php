<?php

namespace App\Console\Commands;

use App\Jobs\ProcessDatabaseBackup;
use Illuminate\Console\Command;

class CreateDatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'backup:database';

    /**
     * The console command description.
     */
    protected $description = 'Create a database backup';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Creating database backup...');

        ProcessDatabaseBackup::dispatch();

        $this->info('Database backup job dispatched successfully!');

        return Command::SUCCESS;
    }
}
