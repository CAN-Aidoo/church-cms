<?php

namespace App\Jobs;

use App\Events\BirthdayToday;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessBirthdayWishes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 60;

    /**
     * Execute the job.
     * Process all birthdays for today
     */
    public function handle(): void
    {
        try {
            $today = Carbon::today();

            // Find all members with birthdays today
            $members = Member::whereRaw('MONTH(date_of_birth) = ?', [$today->month])
                ->whereRaw('DAY(date_of_birth) = ?', [$today->day])
                ->where('status', 'active')
                ->get();

            Log::info("Processing birthdays for {$members->count()} members");

            foreach ($members as $member) {
                $age = $today->year - Carbon::parse($member->date_of_birth)->year;

                // Check if it's a milestone birthday (18, 21, 30, 40, 50, 60, 70, 80, 90, 100)
                $milestones = [18, 21, 30, 40, 50, 60, 70, 80, 90, 100];
                $isMilestone = in_array($age, $milestones);

                // Dispatch birthday event
                event(new BirthdayToday($member, $age, $isMilestone));

                Log::info("Birthday event dispatched for member: {$member->id}, Age: {$age}");
            }

            Log::info('Birthday processing completed successfully');
        } catch (\Exception $e) {
            Log::error("Failed to process birthdays: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("ProcessBirthdayWishes job failed: {$exception->getMessage()}");
    }
}
