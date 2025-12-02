<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DutyRoster extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_unit_id',
        'roster_name',
        'duty_date',
        'start_time',
        'end_time',
        'duty_type',
        'location',
        'instructions',
        'status',
        'created_by',
        'published_at',
    ];

    protected $casts = [
        'duty_date' => 'date',
        'published_at' => 'datetime',
    ];

    /**
     * Get the service unit for this roster.
     */
    public function serviceUnit(): BelongsTo
    {
        return $this->belongsTo(ServiceUnit::class);
    }

    /**
     * Get the user who created this roster.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the duty assignments for this roster.
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(DutyRosterAssignment::class);
    }

    /**
     * Scope a query to only include published rosters.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to only include upcoming rosters.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('duty_date', '>=', now()->toDateString())
            ->whereIn('status', ['draft', 'published']);
    }

    /**
     * Check if roster is past.
     */
    public function getIsPastAttribute(): bool
    {
        return $this->duty_date->isPast();
    }

    /**
     * Check if roster is today.
     */
    public function getIsTodayAttribute(): bool
    {
        return $this->duty_date->isToday();
    }

    /**
     * Get confirmed assignments count.
     */
    public function getConfirmedCountAttribute(): int
    {
        return $this->assignments()->where('status', 'confirmed')->count();
    }

    /**
     * Get total assignments count.
     */
    public function getTotalAssignmentsAttribute(): int
    {
        return $this->assignments()->count();
    }
}
