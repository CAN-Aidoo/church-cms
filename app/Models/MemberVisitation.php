<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberVisitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'shepherd_id',
        'member_id',
        'visit_date',
        'visit_time',
        'visit_type',
        'visit_reason',
        'notes',
        'prayer_requests',
        'action_items',
        'follow_up_date',
        'status',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'follow_up_date' => 'date',
    ];

    /**
     * Get the shepherd who conducted the visitation.
     */
    public function shepherd(): BelongsTo
    {
        return $this->belongsTo(Shepherd::class);
    }

    /**
     * Get the member who was visited.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Scope a query to only include completed visitations.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include pending visitations.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include visitations requiring follow-up.
     */
    public function scopeRequiresFollowUp($query)
    {
        return $query->whereNotNull('follow_up_date')
            ->where('follow_up_date', '<=', now()->toDateString());
    }

    /**
     * Check if follow-up is due.
     */
    public function getIsFollowUpDueAttribute(): bool
    {
        return $this->follow_up_date && $this->follow_up_date->isPast();
    }

    /**
     * Check if visitation is recent (within 30 days).
     */
    public function getIsRecentAttribute(): bool
    {
        return $this->visit_date->diffInDays(now()) <= 30;
    }
}
