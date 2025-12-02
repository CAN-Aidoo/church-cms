<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ReportExecution extends Model
{
    use HasFactory;

    protected $fillable = [
        'custom_report_id',
        'report_schedule_id',
        'report_name',
        'report_type',
        'parameters',
        'format',
        'file_path',
        'file_size',
        'rows_count',
        'status',
        'error_message',
        'started_at',
        'completed_at',
        'generated_by',
    ];

    protected $casts = [
        'parameters' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'file_size' => 'integer',
        'rows_count' => 'integer',
    ];

    /**
     * Relationships
     */
    public function customReport()
    {
        return $this->belongsTo(CustomReport::class);
    }

    public function reportSchedule()
    {
        return $this->belongsTo(ReportSchedule::class);
    }

    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    /**
     * Mark execution as processing.
     */
    public function markProcessing(): self
    {
        $this->update([
            'status' => 'processing',
            'started_at' => now(),
        ]);

        return $this;
    }

    /**
     * Mark execution as completed.
     */
    public function markCompleted(string $filePath, int $fileSize, int $rowsCount): self
    {
        $this->update([
            'status' => 'completed',
            'file_path' => $filePath,
            'file_size' => $fileSize,
            'rows_count' => $rowsCount,
            'completed_at' => now(),
        ]);

        return $this;
    }

    /**
     * Mark execution as failed.
     */
    public function markFailed(string $errorMessage): self
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
            'completed_at' => now(),
        ]);

        return $this;
    }

    /**
     * Get execution duration in seconds.
     */
    public function getDurationAttribute(): ?int
    {
        if (! $this->started_at || ! $this->completed_at) {
            return null;
        }

        return $this->completed_at->diffInSeconds($this->started_at);
    }

    /**
     * Get human-readable file size.
     */
    public function getFileSizeHumanAttribute(): string
    {
        if ($this->file_size === 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unitIndex = 0;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return number_format($size, 2).' '.$units[$unitIndex];
    }

    /**
     * Check if file exists.
     */
    public function fileExists(): bool
    {
        return $this->file_path && Storage::exists($this->file_path);
    }

    /**
     * Delete associated file.
     */
    public function deleteFile(): bool
    {
        if ($this->fileExists()) {
            return Storage::delete($this->file_path);
        }

        return true;
    }

    /**
     * Check if report is downloadable.
     */
    public function isDownloadable(): bool
    {
        return $this->status === 'completed' && $this->fileExists();
    }

    /**
     * Query Scopes
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'processing']);
    }

    public function scopeByFormat($query, string $format)
    {
        return $query->where('format', $format);
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Delete old executions.
     */
    public static function deleteOldExecutions(int $days = 90): int
    {
        $oldExecutions = self::where('created_at', '<', now()->subDays($days))->get();

        $count = 0;
        foreach ($oldExecutions as $execution) {
            $execution->deleteFile();
            $execution->delete();
            $count++;
        }

        return $count;
    }
}
