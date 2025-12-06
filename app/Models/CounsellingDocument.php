<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class CounsellingDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'case_id',
        'document_name',
        'document_type',
        'file_path',
        'file_size',
        'mime_type',
        'uploaded_by',
        'description',
    ];

    /**
     * Relationships
     */
    public function case()
    {
        return $this->belongsTo(CounsellingCase::class, 'case_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get file URL.
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
     * Get human-readable file size.
     */
    public function getFileSizeHumanAttribute(): string
    {
        if ($this->file_size === 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB'];
        $size = $this->file_size;
        $unitIndex = 0;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return number_format($size, 2).' '.$units[$unitIndex];
    }
}
