<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceVolunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_schedule_id',
        'member_id',
        'role',
        'specific_duty',
        'status',
        'confirmed_at',
        'notes',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function serviceSchedule()
    {
        return $this->belongsTo(ServiceSchedule::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Helper Methods
     */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'usher' => 'Usher',
            'choir' => 'Choir',
            'instrumentalist' => 'Instrumentalist',
            'tech_team' => 'Technical Team',
            'protocol' => 'Protocol',
            'media' => 'Media Team',
            'security' => 'Security',
            'parking' => 'Parking',
            'childrens_church' => "Children's Church",
            'altar_worker' => 'Altar Worker',
            'offering_counter' => 'Offering Counter',
            'intercessor' => 'Intercessor',
            'other' => 'Other',
            default => ucfirst(str_replace('_', ' ', $this->role)),
        };
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'assigned' => 'bg-gray-100 text-gray-800',
            'confirmed' => 'bg-green-100 text-green-800',
            'declined' => 'bg-red-100 text-red-800',
            'completed' => 'bg-blue-100 text-blue-800',
            'absent' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * State Management
     */
    public function confirm(): bool
    {
        if ($this->status === 'assigned') {
            $this->status = 'confirmed';
            $this->confirmed_at = now();

            return $this->save();
        }

        return false;
    }

    public function decline(): bool
    {
        if (in_array($this->status, ['assigned', 'confirmed'])) {
            $this->status = 'declined';

            return $this->save();
        }

        return false;
    }

    public function markCompleted(): bool
    {
        if ($this->status === 'confirmed') {
            $this->status = 'completed';

            return $this->save();
        }

        return false;
    }

    public function markAbsent(): bool
    {
        if ($this->status === 'confirmed') {
            $this->status = 'absent';

            return $this->save();
        }

        return false;
    }
}
