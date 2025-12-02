<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LiveStream extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_id', 'stream_title', 'stream_description', 'scheduled_start',
        'scheduled_end', 'actual_start', 'actual_end', 'platforms', 'stream_urls',
        'stream_keys', 'status', 'peak_viewers', 'total_views', 'viewer_stats',
        'is_recorded', 'recording_url', 'technician_id', 'technical_notes',
    ];

    protected $casts = [
        'platforms' => 'array',
        'stream_urls' => 'array',
        'stream_keys' => 'array',
        'viewer_stats' => 'array',
        'scheduled_start' => 'datetime',
        'scheduled_end' => 'datetime',
        'actual_start' => 'datetime',
        'actual_end' => 'datetime',
        'is_recorded' => 'boolean',
    ];

    public function technician()
    {
        return $this->belongsTo(MediaTeamMember::class, 'technician_id');
    }

    public function goLive(): self
    {
        $this->update(['status' => 'live', 'actual_start' => now()]);

        return $this;
    }

    public function end(): self
    {
        $this->update(['status' => 'ended', 'actual_end' => now()]);

        return $this;
    }

    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_start', '>', now());
    }
}
