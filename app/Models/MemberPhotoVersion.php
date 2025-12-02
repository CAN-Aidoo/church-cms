<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MemberPhotoVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'photo_url',
        'photo_type',
        'width',
        'height',
        'file_size',
        'is_current',
        'uploaded_by',
    ];

    protected $casts = [
        'is_current' => 'boolean',
        'width' => 'integer',
        'height' => 'integer',
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
     * Get photo URL.
     */
    public function getUrlAttribute(): string
    {
        return Storage::url($this->photo_url);
    }

    /**
     * Check if photo file exists.
     */
    public function fileExists(): bool
    {
        return Storage::exists($this->photo_url);
    }

    /**
     * Delete photo file.
     */
    public function deleteFile(): bool
    {
        if ($this->fileExists()) {
            return Storage::delete($this->photo_url);
        }

        return true;
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

    /**
     * Get image dimensions as string.
     */
    public function getDimensionsAttribute(): string
    {
        return $this->width && $this->height ?
               "{$this->width} × {$this->height}" :
               'Unknown';
    }

    /**
     * Set as current photo for member.
     */
    public function setAsCurrent(): self
    {
        // Unset all other photos as current
        self::where('member_id', $this->member_id)
            ->where('id', '!=', $this->id)
            ->update(['is_current' => false]);

        // Set this photo as current
        $this->update(['is_current' => true]);

        // Update member's profile photo
        $this->member->update(['profile_photo_url' => $this->photo_url]);

        return $this;
    }

    /**
     * Query Scopes
     */
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('photo_type', $type);
    }

    public function scopeRecent($query, int $count = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($count);
    }
}
