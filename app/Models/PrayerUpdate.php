<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'prayer_request_id',
        'updated_by',
        'update_text',
        'update_type',
        'notify_requester',
    ];

    protected $casts = [
        'notify_requester' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function prayerRequest()
    {
        return $this->belongsTo(PrayerRequest::class);
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Helper Methods
     */
    public function getUpdateTypeLabelAttribute(): string
    {
        return match ($this->update_type) {
            'progress' => 'Progress Update',
            'note' => 'Note',
            'status_change' => 'Status Change',
            'answered' => 'Answered',
            default => ucfirst($this->update_type),
        };
    }

    public function getUpdateTypeIconAttribute(): string
    {
        return match ($this->update_type) {
            'progress' => '📈',
            'note' => '📝',
            'status_change' => '🔄',
            'answered' => '✅',
            default => '📋',
        };
    }
}
