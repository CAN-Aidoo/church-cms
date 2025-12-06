<?php

namespace App\Jobs;

use App\Repositories\MemberRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ExportMembers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 2;

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 600; // 10 minutes

    public function __construct(
        public array $filters,
        public string $format,
        public int $userId
    ) {}

    /**
     * Execute the job.
     * Export members to CSV or Excel
     */
    public function handle(MemberRepository $memberRepository): void
    {
        try {
            Log::info("Exporting members with filters", $this->filters);

            // Get members based on filters
            $members = $memberRepository->export($this->filters);

            // Generate file
            $fileName = $this->generateFileName();
            $filePath = null;

            if ($this->format === 'csv') {
                $filePath = $this->generateCsv($members, $fileName);
            } else {
                $filePath = $this->generateExcel($members, $fileName);
            }

            // Notify user that export is ready
            // Could send notification with download link

            Log::info("Member export completed: {$filePath}");
        } catch (\Exception $e) {
            Log::error("Failed to export members: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Generate unique file name
     */
    private function generateFileName(): string
    {
        $timestamp = now()->format('YmdHis');
        return "exports/members_{$timestamp}";
    }

    /**
     * Generate CSV export
     */
    private function generateCsv(array $members, string $fileName): string
    {
        $filePath = "{$fileName}.csv";

        if (empty($members)) {
            Storage::put($filePath, '');
            return $filePath;
        }

        $csv = fopen('php://temp', 'r+');

        // Headers
        $headers = [
            'Member ID', 'First Name', 'Middle Name', 'Last Name',
            'Email', 'Phone', 'Gender', 'Date of Birth',
            'Marital Status', 'Occupation', 'Address',
            'Membership Date', 'Baptism Status', 'Status'
        ];
        fputcsv($csv, $headers);

        // Data rows
        foreach ($members as $member) {
            fputcsv($csv, [
                $member['member_id'] ?? '',
                $member['first_name'] ?? '',
                $member['middle_name'] ?? '',
                $member['last_name'] ?? '',
                $member['email'] ?? '',
                $member['phone'] ?? '',
                $member['gender'] ?? '',
                $member['date_of_birth'] ?? '',
                $member['marital_status'] ?? '',
                $member['occupation'] ?? '',
                $member['address'] ?? '',
                $member['membership_date'] ?? '',
                $member['baptism_status'] ?? '',
                $member['status'] ?? '',
            ]);
        }

        rewind($csv);
        $content = stream_get_contents($csv);
        fclose($csv);

        Storage::put($filePath, $content);
        return $filePath;
    }

    /**
     * Generate Excel export
     */
    private function generateExcel(array $members, string $fileName): string
    {
        // Would use Maatwebsite/Laravel-Excel package
        $filePath = "{$fileName}.xlsx";
        Storage::put($filePath, 'Excel placeholder');
        return $filePath;
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("ExportMembers job failed: {$exception->getMessage()}");
    }
}
