<?php

namespace App\Jobs;

use App\Models\CustomReport;
use App\Models\ReportExecution;
use App\Repositories\ReportRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GenerateReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 2;

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 900; // 15 minutes

    public function __construct(
        public CustomReport $report,
        public string $format,
        public ?int $userId = null
    ) {}

    /**
     * Execute the job.
     * Generate report and save to storage
     */
    public function handle(ReportRepository $reportRepository): void
    {
        try {
            Log::info("Generating report: {$this->report->id} in format: {$this->format}");

            // Create execution record
            $execution = ReportExecution::create([
                'custom_report_id' => $this->report->id,
                'executed_by' => $this->userId,
                'status' => 'processing',
                'format' => $this->format,
                'started_at' => now(),
            ]);

            // Generate report data
            $data = $reportRepository->executeCustomReport($this->report);

            // Generate file based on format
            $fileName = $this->generateFileName();
            $filePath = null;

            switch ($this->format) {
                case 'pdf':
                    $filePath = $this->generatePdf($data, $fileName);
                    break;
                case 'excel':
                    $filePath = $this->generateExcel($data, $fileName);
                    break;
                case 'csv':
                    $filePath = $this->generateCsv($data, $fileName);
                    break;
            }

            // Update execution record
            $execution->update([
                'status' => 'completed',
                'file_path' => $filePath,
                'file_size' => Storage::size($filePath),
                'row_count' => count($data),
                'completed_at' => now(),
            ]);

            Log::info("Report generation completed: {$this->report->id}");
        } catch (\Exception $e) {
            if (isset($execution)) {
                $execution->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'completed_at' => now(),
                ]);
            }

            Log::error("Failed to generate report {$this->report->id}: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Generate unique file name
     */
    private function generateFileName(): string
    {
        $timestamp = now()->format('YmdHis');
        $sanitizedName = preg_replace('/[^A-Za-z0-9_-]/', '_', $this->report->name);

        return "reports/{$sanitizedName}_{$timestamp}";
    }

    /**
     * Generate PDF report
     */
    private function generatePdf(array $data, string $fileName): string
    {
        // Implementation would use PDF library (e.g., DomPDF, TCPDF)
        // For now, return placeholder
        $filePath = "{$fileName}.pdf";
        Storage::put($filePath, 'PDF content placeholder');

        return $filePath;
    }

    /**
     * Generate Excel report
     */
    private function generateExcel(array $data, string $fileName): string
    {
        // Implementation would use Excel library (e.g., Maatwebsite/Laravel-Excel)
        // For now, return placeholder
        $filePath = "{$fileName}.xlsx";
        Storage::put($filePath, 'Excel content placeholder');

        return $filePath;
    }

    /**
     * Generate CSV report
     */
    private function generateCsv(array $data, string $fileName): string
    {
        $filePath = "{$fileName}.csv";

        if (empty($data)) {
            Storage::put($filePath, '');

            return $filePath;
        }

        // Create CSV content
        $csv = fopen('php://temp', 'r+');

        // Add headers
        fputcsv($csv, array_keys($data[0]));

        // Add data rows
        foreach ($data as $row) {
            fputcsv($csv, $row);
        }

        rewind($csv);
        $content = stream_get_contents($csv);
        fclose($csv);

        Storage::put($filePath, $content);

        return $filePath;
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("GenerateReport job failed for report {$this->report->id}: {$exception->getMessage()}");
    }
}
