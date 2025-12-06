<?php

namespace App\Jobs;

use App\Events\MemberAbsent;
use App\Models\Member;
use App\Repositories\AttendanceRepository;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessAttendanceAlerts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * Execute the job.
     * Check for members with consecutive absences and trigger alerts
     */
    public function handle(AttendanceRepository $attendanceRepository): void
    {
        try {
            Log::info("Processing attendance alerts");

            $members = Member::where('status', 'active')->get();
            $alertCount = 0;

            foreach ($members as $member) {
                // Get consecutive absence count
                $consecutiveAbsences = $attendanceRepository->getConsecutiveAbsences($member->id);

                // Trigger alerts for 2+ consecutive absences
                if ($consecutiveAbsences >= 2) {
                    $lastService = $attendanceRepository->getLastServiceDate();

                    event(new MemberAbsent(
                        $member,
                        $consecutiveAbsences,
                        Carbon::parse($lastService),
                        'sunday_first' // Default service type
                    ));

                    $alertCount++;
                    Log::info("Absence alert triggered for member {$member->id}: {$consecutiveAbsences} absences");
                }
            }

            Log::info("Attendance alerts processing completed. {$alertCount} alerts triggered");
        } catch (\Exception $e) {
            Log::error("Failed to process attendance alerts: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("ProcessAttendanceAlerts job failed: {$exception->getMessage()}");
    }
}
