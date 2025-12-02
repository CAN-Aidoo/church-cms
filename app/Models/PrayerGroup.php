<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'leader_id',
        'meeting_frequency',
        'meeting_day',
        'meeting_time',
        'meeting_location',
        'is_active',
    ];

    protected $casts = [
        'meeting_time' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function leader()
    {
        return $this->belongsTo(Member::class, 'leader_id');
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'prayer_group_members')
            ->withPivot('role', 'joined_at', 'is_active')
            ->withTimestamps();
    }

    public function activeMembers()
    {
        return $this->members()->wherePivot('is_active', true);
    }

    public function meetings()
    {
        return $this->hasMany(PrayerMeeting::class);
    }

    /**
     * Query Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Helper Methods
     */
    public function getMemberCountAttribute(): int
    {
        return $this->activeMembers()->count();
    }

    public function getFrequencyLabelAttribute(): string
    {
        return match ($this->meeting_frequency) {
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'biweekly' => 'Bi-weekly',
            'monthly' => 'Monthly',
            'adhoc' => 'Ad-hoc',
            default => ucfirst($this->meeting_frequency),
        };
    }

    /**
     * Add member to prayer group.
     */
    public function addMember(int $memberId, string $role = 'member'): void
    {
        $this->members()->attach($memberId, [
            'role' => $role,
            'joined_at' => now(),
            'is_active' => true,
        ]);
    }

    /**
     * Remove member from prayer group.
     */
    public function removeMember(int $memberId): void
    {
        $this->members()->updateExistingPivot($memberId, [
            'is_active' => false,
        ]);
    }
}
