<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class MemberDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'document_type',
        'document_name',
        'file_path',
        'file_type',
        'file_size',
        'category',
        'tags',
        'description',
        'issue_date',
        'expiry_date',
        'uploaded_by',
    ];

    protected $casts = [
        'tags' => 'array',
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'file_size' => 'integer',
    ];

    /**
     * Relationships
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get human-readable file size.
     */
    public function getFileSizeHumanAttribute(): string
    {
        $size = $this->file_size;

        if ($size === 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $unitIndex = 0;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return number_format($size, 2).' '.$units[$unitIndex];
    }

    /**
     * Check if document is expired.
     */
    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    /**
     * Check if document is expiring soon (within 30 days).
     */
    public function isExpiringSoon(int $days = 30): bool
    {
        if (! $this->expiry_date) {
            return false;
        }

        return $this->expiry_date->isFuture() &&
               $this->expiry_date->diffInDays(now()) <= $days;
    }

    /**
     * Get document URL.
     */
    public function getUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    /**
     * Check if file exists.
     */
    public function fileExists(): bool
    {
        return Storage::exists($this->file_path);
    }

    /**
     * Delete file from storage.
     */
    public function deleteFile(): bool
    {
        if ($this->fileExists()) {
            return Storage::delete($this->file_path);
        }

        return true;
    }

    /**
     * Get document icon based on file type.
     */
    public function getIconAttribute(): string
    {
        return match ($this->file_type) {
            'application/pdf' => 'file-pdf',
            'image/jpeg', 'image/png', 'image/gif' => 'file-image',
            'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'file-word',
            'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'file-excel',
            default => 'file',
        };
    }

    /**
     * Query Scopes
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('document_type', $type);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('expiry_date')
            ->where('expiry_date', '<', now());
    }

    public function scopeExpiringSoon($query, int $days = 30)
    {
        return $query->whereNotNull('expiry_date')
            ->where('expiry_date', '>', now())
            ->where('expiry_date', '<=', now()->addDays($days));
    }

    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expiry_date')
                ->orWhere('expiry_date', '>=', now());
        });
    }
}
