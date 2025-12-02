<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemBackup extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'type',
        'size',
        'storage_path',
        'status',
        'error_message',
        'completed_at',
        'created_by',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'size' => 'integer',
    ];

    /**
     * Relationships
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Mark backup as in progress.
     */
    public function markInProgress(): self
    {
        $this->update(['status' => 'in_progress']);

        return $this;
    }

    /**
     * Mark backup as completed.
     */
    public function markCompleted(int $size): self
    {
        $this->update([
            'status' => 'completed',
            'size' => $size,
            'completed_at' => now(),
        ]);

        return $this;
    }

    /**
     * Mark backup as failed.
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
     * Get full path to backup file.
     */
    public function getFullPathAttribute(): string
    {
        return $this->storage_path.$this->filename;
    }

    /**
     * Check if backup is downloadable.
     */
    public function isDownloadable(): bool
    {
        return $this->status === 'completed' && $this->size > 0;
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
        return $query->whereIn('status', ['pending', 'in_progress']);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
