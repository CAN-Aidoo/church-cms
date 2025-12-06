<?php

namespace App\Jobs;

use App\Models\ReportSchedule;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessScheduledReports implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * Execute the job.
     * Process all scheduled reports that are due
     */
    public function handle(): void
    {
        try {
            Log::info("Processing scheduled reports");

            $now = Carbon::now();

            // Find all active schedules that are due
            $dueSchedules = ReportSchedule::where('is_active', true)
                ->where(function ($query) use ($now) {
                    $query->whereNull('last_run_at')
                        ->orWhere('next_run_at', '<=', $now);
                })
                ->get();

            Log::info("Found {$dueSchedules->count()} due scheduled reports");

            foreach ($dueSchedules as $schedule) {
                try {
                    // Dispatch report generation job
                    GenerateReport::dispatch(
                        $schedule->customReport,
                        $schedule->format,
                        null // System generated
                    );

                    // Calculate next run time based on frequency
                    $nextRun = $this->calculateNextRun($schedule->frequency, $now);

                    // Update schedule
                    $schedule->update([
                        'last_run_at' => $now,
                        'next_run_at' => $nextRun,
                        'run_count' => $schedule->run_count + 1,
                    ]);

                    Log::info("Scheduled report dispatched: {$schedule->id}");
                } catch (\Exception $e) {
                    Log::error("Failed to process scheduled report {$schedule->id}: {$e->getMessage()}");
                    continue;
                }
            }

            Log::info("Scheduled reports processing completed");
        } catch (\Exception $e) {
            Log::error("Failed to process scheduled reports: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Calculate next run time based on frequency
     */
    private function calculateNextRun(string $frequency, Carbon $from): Carbon
    {
        return match($frequency) {
            'daily' => $from->copy()->addDay(),
            'weekly' => $from->copy()->addWeek(),
            'monthly' => $from->copy()->addMonth(),
            'quarterly' => $from->copy()->addMonths(3),
            'yearly' => $from->copy()->addYear(),
            default => $from->copy()->addDay(),
        };
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("ProcessScheduledReports job failed: {$exception->getMessage()}");
    }
}
