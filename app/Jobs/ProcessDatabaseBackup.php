<?php

namespace App\Jobs;

use App\Models\SystemBackup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessDatabaseBackup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 1;

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 1800; // 30 minutes

    public function __construct(
        public ?int $userId = null
    ) {}

    /**
     * Execute the job.
     * Create database backup
     */
    public function handle(): void
    {
        try {
            Log::info('Starting database backup');

            // Create backup record
            $backup = SystemBackup::create([
                'type' => 'database',
                'status' => 'processing',
                'initiated_by' => $this->userId,
                'started_at' => now(),
            ]);

            // Generate backup file name
            $fileName = 'backups/db_backup_'.now()->format('YmdHis').'.sql';

            // Execute mysqldump command
            $databaseName = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');

            $command = sprintf(
                'mysqldump -h %s -u %s -p%s %s > %s',
                escapeshellarg($host),
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($databaseName),
                storage_path('app/'.$fileName)
            );

            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                throw new \Exception("Database backup failed with code: {$returnCode}");
            }

            // Compress the backup
            $compressedFile = $fileName.'.gz';
            exec('gzip '.storage_path('app/'.$fileName));

            // Get file size
            $fileSize = Storage::size($compressedFile);

            // Update backup record
            $backup->update([
                'status' => 'completed',
                'file_path' => $compressedFile,
                'file_size' => $fileSize,
                'completed_at' => now(),
            ]);

            Log::info("Database backup completed: {$compressedFile}");
        } catch (\Exception $e) {
            if (isset($backup)) {
                $backup->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'completed_at' => now(),
                ]);
            }

            Log::error("Failed to create database backup: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("ProcessDatabaseBackup job failed: {$exception->getMessage()}");
    }
}
