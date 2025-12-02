<?php

namespace App\Console\Commands;

use App\Services\BirthdayAutomationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessDailyBirthdays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'birthdays:process
                            {--retry : Retry failed wishes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process daily birthdays and send automated wishes';

    /**
     * Execute the console command.
     */
    public function handle(BirthdayAutomationService $service): int
    {
        $this->info('Processing daily birthdays and anniversaries...');

        try {
            // Process today's birthdays
            $results = $service->processDailyBirthdays();

            $this->info("Birthdays found: {$results['birthdays_found']}");
            $this->info("Wishes sent: {$results['wishes_sent']}");
            $this->info("Wishes failed: {$results['wishes_failed']}");
            $this->info("Milestones created: {$results['milestones_created']}");
            $this->info("Announcements created: {$results['announcements_created']}");

            // Retry failed wishes if option provided
            if ($this->option('retry')) {
                $this->info('Retrying failed wishes...');
                $retryResults = $service->retryFailedWishes();
                $this->info("Retried: {$retryResults['retried']}");
                $this->info("Succeeded: {$retryResults['succeeded']}");
                $this->info("Failed: {$retryResults['failed']}");
            }

            $this->info('Birthday processing completed successfully!');

            Log::info('Birthday automation completed', $results);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Birthday processing failed: '.$e->getMessage());
            Log::error('Birthday automation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return Command::FAILURE;
        }
    }
}
