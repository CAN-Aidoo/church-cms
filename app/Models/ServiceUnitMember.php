<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceUnitMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_unit_id',
        'member_id',
        'role',
        'joined_date',
        'left_date',
        'status',
        'skills',
        'proficiency_level',
        'notes',
    ];

    protected $casts = [
        'joined_date' => 'date',
        'left_date' => 'date',
        'skills' => 'array',
    ];

    /**
     * Get the service unit.
     */
    public function serviceUnit(): BelongsTo
    {
        return $this->belongsTo(ServiceUnit::class);
    }

    /**
     * Get the member.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Scope a query to only include active members.
     */
    public function scopeActive($query)
    {
        return $query->where('member_status', 'active');
    }

    /**
     * Scope a query to filter by role.
     */
    public function scopeRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Get years of service in this unit.
     */
    public function getYearsOfServiceAttribute(): int
    {
        $endDate = $this->left_date ?? now();

        return $this->joined_date->diffInYears($endDate);
    }

    /**
     * Check if member is a leader.
     */
    public function isLeader(): bool
    {
        return in_array($this->role, ['leader', 'assistant_leader']);
    }
}
