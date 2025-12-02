<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_schedule_id',
        'resource_type',
        'resource_name',
        'quantity',
        'description',
        'status',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'approved_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function serviceSchedule()
    {
        return $this->belongsTo(ServiceSchedule::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Helper Methods
     */
    public function getResourceTypeLabelAttribute(): string
    {
        return match ($this->resource_type) {
            'equipment' => 'Equipment',
            'material' => 'Material',
            'facility' => 'Facility',
            'other' => 'Other',
            default => ucfirst($this->resource_type),
        };
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-green-100 text-green-800',
            'unavailable' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * State Management
     */
    public function approve($userId): bool
    {
        if ($this->status === 'pending') {
            $this->status = 'confirmed';
            $this->approved_by = $userId;
            $this->approved_at = now();

            return $this->save();
        }

        return false;
    }

    public function markUnavailable(): bool
    {
        $this->status = 'unavailable';

        return $this->save();
    }
}
