<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DutyRosterAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'duty_roster_id',
        'member_id',
        'position',
        'status',
        'confirmed_at',
        'notes',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
    ];

    /**
     * Get the duty roster.
     */
    public function dutyRoster(): BelongsTo
    {
        return $this->belongsTo(DutyRoster::class);
    }

    /**
     * Get the member.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Scope a query to only include confirmed assignments.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include pending assignments.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'assigned');
    }
}
