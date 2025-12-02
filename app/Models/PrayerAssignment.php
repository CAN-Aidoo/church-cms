<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'prayer_request_id',
        'intercessor_id',
        'assigned_at',
        'started_praying_at',
        'completed_at',
        'notes',
        'status',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'started_praying_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function prayerRequest()
    {
        return $this->belongsTo(PrayerRequest::class);
    }

    public function intercessor()
    {
        return $this->belongsTo(Member::class, 'intercessor_id');
    }

    /**
     * State Management
     */
    public function startPraying(): bool
    {
        if ($this->status === 'assigned') {
            $this->status = 'praying';
            $this->started_praying_at = now();

            return $this->save();
        }

        return false;
    }

    public function complete(): bool
    {
        if (in_array($this->status, ['assigned', 'praying'])) {
            $this->status = 'completed';
            $this->completed_at = now();

            return $this->save();
        }

        return false;
    }

    /**
     * Helper Methods
     */
    public function getDurationAttribute(): ?int
    {
        if ($this->started_praying_at && $this->completed_at) {
            return $this->started_praying_at->diffInMinutes($this->completed_at);
        }

        return null;
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'assigned' => 'bg-blue-100 text-blue-800',
            'praying' => 'bg-purple-100 text-purple-800',
            'completed' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
