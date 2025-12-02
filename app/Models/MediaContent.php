<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaContent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'media_content';

    protected $fillable = [
        'title', 'description', 'content_type', 'service_id', 'program_id',
        'content_date', 'speaker', 'sermon_title', 'sermon_series', 'file_paths',
        'thumbnail_path', 'duration_seconds', 'file_size', 'tags', 'views_count',
        'downloads_count', 'is_published', 'published_at', 'visibility',
        'uploaded_by', 'edited_by',
    ];

    protected $casts = [
        'file_paths' => 'array',
        'tags' => 'array',
        'content_date' => 'date',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
        'downloads_count' => 'integer',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function editor()
    {
        return $this->belongsTo(MediaTeamMember::class, 'edited_by');
    }

    public function publish(): self
    {
        $this->update(['is_published' => true, 'published_at' => now()]);

        return $this;
    }

    public function incrementViews(): self
    {
        $this->increment('views_count');

        return $this;
    }

    public function incrementDownloads(): self
    {
        $this->increment('downloads_count');

        return $this;
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('content_type', $type);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('content_date', 'desc');
    }
}
