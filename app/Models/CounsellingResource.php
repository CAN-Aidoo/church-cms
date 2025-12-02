<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class CounsellingResource extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'resource_type',
        'categories',
        'file_path',
        'external_url',
        'content',
        'author',
        'reading_time_minutes',
        'is_public',
        'is_featured',
        'views_count',
        'downloads_count',
        'tags',
        'created_by',
    ];

    protected $casts = [
        'categories' => 'array',
        'tags' => 'array',
        'is_public' => 'boolean',
        'is_featured' => 'boolean',
        'reading_time_minutes' => 'integer',
        'views_count' => 'integer',
        'downloads_count' => 'integer',
    ];

    /**
     * Resource type options.
     */
    public const RESOURCE_TYPES = [
        'article' => 'Article',
        'video' => 'Video',
        'audio' => 'Audio',
        'book' => 'Book',
        'worksheet' => 'Worksheet',
        'guide' => 'Guide',
        'other' => 'Other',
    ];

    /**
     * Relationships
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get resource type display name.
     */
    public function getResourceTypeDisplayAttribute(): string
    {
        return self::RESOURCE_TYPES[$this->resource_type] ?? ucfirst($this->resource_type);
    }

    /**
     * Get file URL.
     */
    public function getFileUrlAttribute(): ?string
    {
        if ($this->file_path) {
            return Storage::url($this->file_path);
        }

        return $this->external_url;
    }

    /**
     * Get icon based on resource type.
     */
    public function getIconAttribute(): string
    {
        return match ($this->resource_type) {
            'article' => 'document-text',
            'video' => 'video-camera',
            'audio' => 'musical-note',
            'book' => 'book-open',
            'worksheet' => 'clipboard-list',
            'guide' => 'light-bulb',
            default => 'document',
        };
    }

    /**
     * Increment views count.
     */
    public function incrementViews(): self
    {
        $this->increment('views_count');

        return $this;
    }

    /**
     * Increment downloads count.
     */
    public function incrementDownloads(): self
    {
        $this->increment('downloads_count');

        return $this;
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(): self
    {
        $this->update(['is_featured' => ! $this->is_featured]);

        return $this;
    }

    /**
     * Make public.
     */
    public function makePublic(): self
    {
        $this->update(['is_public' => true]);

        return $this;
    }

    /**
     * Make private.
     */
    public function makePrivate(): self
    {
        $this->update(['is_public' => false]);

        return $this;
    }

    /**
     * Check if file exists.
     */
    public function fileExists(): bool
    {
        return $this->file_path && Storage::exists($this->file_path);
    }

    /**
     * Delete file.
     */
    public function deleteFile(): bool
    {
        if ($this->fileExists()) {
            return Storage::delete($this->file_path);
        }

        return false;
    }

    /**
     * Query Scopes
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('resource_type', $type);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->whereJsonContains('categories', $category);
    }

    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%")
                ->orWhereJsonContains('tags', $search);
        });
    }

    public function scopePopular($query, int $limit = 10)
    {
        return $query->orderBy('views_count', 'desc')->limit($limit);
    }
}
