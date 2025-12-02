<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorshipPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_schedule_id',
        'order_number',
        'item_type',
        'title',
        'description',
        'duration_minutes',
        'assigned_to',
        'notes',
        'song_details',
    ];

    protected $casts = [
        'order_number' => 'integer',
        'duration_minutes' => 'integer',
        'song_details' => 'array',
    ];

    /**
     * Relationships
     */
    public function serviceSchedule()
    {
        return $this->belongsTo(ServiceSchedule::class);
    }

    public function assignedMember()
    {
        return $this->belongsTo(Member::class, 'assigned_to');
    }

    /**
     * Helper Methods
     */
    public function getItemTypeLabelAttribute(): string
    {
        return match ($this->item_type) {
            'opening_prayer' => 'Opening Prayer',
            'worship_song' => 'Worship Song',
            'hymn' => 'Hymn',
            'scripture_reading' => 'Scripture Reading',
            'prayer' => 'Prayer',
            'offering' => 'Offering',
            'special_number' => 'Special Number',
            'sermon' => 'Sermon',
            'altar_call' => 'Altar Call',
            'announcements' => 'Announcements',
            'benediction' => 'Benediction',
            'other' => 'Other',
            default => ucfirst(str_replace('_', ' ', $this->item_type)),
        };
    }

    public function getIconAttribute(): string
    {
        return match ($this->item_type) {
            'opening_prayer', 'prayer' => '🙏',
            'worship_song', 'hymn' => '🎵',
            'scripture_reading' => '📖',
            'offering' => '💰',
            'special_number' => '🎤',
            'sermon' => '📢',
            'altar_call' => '✝️',
            'announcements' => '📣',
            'benediction' => '🙌',
            default => '📋',
        };
    }
}
