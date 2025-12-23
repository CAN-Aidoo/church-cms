<?php

namespace App\Jobs;

use App\Models\SmsBroadcast;
use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendBulkSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 120;

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 600; // 10 minutes

    public function __construct(
        public SmsBroadcast $broadcast
    ) {}

    /**
     * Execute the job.
     * Send SMS to all recipients in the broadcast
     */
    public function handle(SmsService $smsService): void
    {
        try {
            Log::info("Processing SMS broadcast: {$this->broadcast->id}");

            // Update status to sending
            $this->broadcast->update(['status' => 'sending']);

            $recipients = json_decode($this->broadcast->recipients, true);
            $successCount = 0;
            $failCount = 0;
            $failedNumbers = [];

            // Process in batches to avoid rate limiting
            $batches = array_chunk($recipients, 50);

            foreach ($batches as $batch) {
                foreach ($batch as $recipient) {
                    try {
                        $smsService->sendSms(
                            to: $recipient['phone'],
                            message: $this->broadcast->message
                        );

                        $successCount++;

                        // Small delay to respect rate limits
                        usleep(100000); // 0.1 second
                    } catch (\Exception $e) {
                        $failCount++;
                        $failedNumbers[] = $recipient['phone'];
                        Log::warning("Failed to send SMS to {$recipient['phone']}: {$e->getMessage()}");
                    }
                }

                // Delay between batches
                if (count($batches) > 1) {
                    sleep(2);
                }
            }

            // Update broadcast with results
            $this->broadcast->update([
                'status' => 'completed',
                'sent_count' => $successCount,
                'failed_count' => $failCount,
                'sent_at' => now(),
                'failed_recipients' => $failCount > 0 ? json_encode($failedNumbers) : null,
            ]);

            Log::info("SMS broadcast completed: {$this->broadcast->id}. Success: {$successCount}, Failed: {$failCount}");
        } catch (\Exception $e) {
            $this->broadcast->update(['status' => 'failed']);
            Log::error("Failed to process SMS broadcast {$this->broadcast->id}: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        $this->broadcast->update(['status' => 'failed']);
        Log::error("SendBulkSms job failed for broadcast {$this->broadcast->id}: {$exception->getMessage()}");
    }
}
