<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'category',
        'leader_id',
        'assistant_leader_id',
        'min_members',
        'max_members',
        'current_members',
        'status',
        'meeting_schedule',
        'requirements',
        'responsibilities',
    ];

    /**
     * Get the leader of this service unit.
     */
    public function leader(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'leader_id');
    }

    /**
     * Get the assistant leader of this service unit.
     */
    public function assistantLeader(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'assistant_leader_id');
    }

    /**
     * Get the service unit members.
     */
    public function unitMembers(): HasMany
    {
        return $this->hasMany(ServiceUnitMember::class);
    }

    /**
     * Get active unit members.
     */
    public function activeMembers(): HasMany
    {
        return $this->hasMany(ServiceUnitMember::class)->where('member_status', 'active');
    }

    /**
     * Get the duty rosters for this unit.
     */
    public function dutyRosters(): HasMany
    {
        return $this->hasMany(DutyRoster::class);
    }

    /**
     * Get the meetings for this unit.
     */
    public function meetings(): HasMany
    {
        return $this->hasMany(ServiceUnitMeeting::class);
    }

    /**
     * Get the trainings for this unit.
     */
    public function trainings(): HasMany
    {
        return $this->hasMany(ServiceUnitTraining::class);
    }

    /**
     * Scope a query to only include active units.
     */
    public function scopeActive($query)
    {
        return $query->where('member_status', 'active');
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Check if unit has capacity for more members.
     */
    public function hasCapacity(): bool
    {
        return $this->current_members < $this->max_members;
    }

    /**
     * Get available capacity.
     */
    public function getAvailableCapacityAttribute(): int
    {
        return max(0, $this->max_members - $this->current_members);
    }

    /**
     * Get capacity percentage.
     */
    public function getCapacityPercentageAttribute(): float
    {
        if ($this->max_members == 0) {
            return 0;
        }

        return ($this->current_members / $this->max_members) * 100;
    }

    /**
     * Check if unit meets minimum member requirement.
     */
    public function meetsMinimumRequirement(): bool
    {
        return $this->current_members >= $this->min_members;
    }

    /**
     * Get upcoming duty rosters (next 30 days).
     */
    public function getUpcomingDutiesAttribute()
    {
        return $this->dutyRosters()
            ->where('duty_date', '>=', now()->toDateString())
            ->where('duty_date', '<=', now()->addDays(30)->toDateString())
            ->where('status', '!=', 'cancelled')
            ->orderBy('duty_date')
            ->get();
    }

    /**
     * Get active trainee count.
     */
    public function getTraineeCountAttribute(): int
    {
        return $this->unitMembers()
            ->where('role', 'trainee')
            ->where('member_status', 'active')
            ->count();
    }
}
