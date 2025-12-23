<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shepherd extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'flock_name',
        'description',
        'max_flock_size',
        'current_flock_size',
        'status',
        'appointed_date',
        'end_date',
        'notes',
    ];

    protected $casts = [
        'appointed_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the member who is the shepherd.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the flock members assigned to this shepherd.
     */
    public function flockMembers(): HasMany
    {
        return $this->hasMany(Member::class, 'shepherd_id');
    }

    /**
     * Get the flock meetings for this shepherd.
     */
    public function meetings(): HasMany
    {
        return $this->hasMany(FlockMeeting::class);
    }

    /**
     * Get the member visitations conducted by this shepherd.
     */
    public function visitations(): HasMany
    {
        return $this->hasMany(MemberVisitation::class);
    }

    /**
     * Get the shepherd reports.
     */
    public function reports(): HasMany
    {
        return $this->hasMany(ShepherdReport::class);
    }

    /**
     * Scope a query to only include active shepherds.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active'); // Fixed: Changed member_status to status
    }

    /**
     * Scope a query to only include shepherds with available capacity.
     */
    public function scopeHasCapacity($query)
    {
        return $query->whereColumn('current_flock_size', '<', 'max_flock_size');
    }

    /**
     * Check if shepherd has capacity for more members.
     */
    public function hasCapacity(): bool
    {
        return $this->current_flock_size < $this->max_flock_size;
    }

    /**
     * Get available capacity.
     */
    public function getAvailableCapacityAttribute(): int
    {
        return max(0, $this->max_flock_size - $this->current_flock_size);
    }

    /**
     * Get capacity percentage.
     */
    public function getCapacityPercentageAttribute(): float
    {
        if ($this->max_flock_size == 0) {
            return 0;
        }

        return ($this->current_flock_size / $this->max_flock_size) * 100;
    }

    /**
     * Get the shepherd's full name.
     */
    public function getFullNameAttribute(): string
    {
        return $this->member->full_name ?? 'Unknown';
    }

    /**
     * Get years of service.
     */
    public function getYearsOfServiceAttribute(): int
    {
        $endDate = $this->end_date ?? now();

        return $this->appointed_date->diffInYears($endDate);
    }

    /**
     * Get recent visitations (last 30 days).
     */
    public function getRecentVisitationsAttribute()
    {
        return $this->visitations()
            ->where('visit_date', '>=', now()->subDays(30))
            ->where('status', 'completed')
            ->count();
    }

    /**
     * Get recent meetings (last 30 days).
     */
    public function getRecentMeetingsAttribute()
    {
        return $this->meetings()
            ->where('meeting_date', '>=', now()->subDays(30))
            ->where('status', 'completed')
            ->count();
    }
}
