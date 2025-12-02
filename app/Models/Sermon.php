<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sermon extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_schedule_id',
        'title',
        'sermon_text',
        'theme',
        'preacher_id',
        'summary',
        'full_notes',
        'key_points',
        'audio_file_path',
        'video_file_path',
        'slides_file_path',
        'duration_minutes',
        'tags',
    ];

    protected $casts = [
        'key_points' => 'array',
        'duration_minutes' => 'integer',
    ];

    /**
     * Relationships
     */
    public function serviceSchedule()
    {
        return $this->belongsTo(ServiceSchedule::class);
    }

    public function preacher()
    {
        return $this->belongsTo(Member::class, 'preacher_id');
    }

    /**
     * Helper Methods
     */
    public function hasAudio(): bool
    {
        return ! empty($this->audio_file_path);
    }

    public function hasVideo(): bool
    {
        return ! empty($this->video_file_path);
    }

    public function hasSlides(): bool
    {
        return ! empty($this->slides_file_path);
    }

    public function getTagsArrayAttribute(): array
    {
        return $this->tags ? explode(',', $this->tags) : [];
    }

    /**
     * Query Scopes
     */
    public function scopeByPreacher($query, $preacherId)
    {
        return $query->where('preacher_id', $preacherId);
    }

    public function scopeWithTag($query, $tag)
    {
        return $query->where('tags', 'like', "%{$tag}%");
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }
}
