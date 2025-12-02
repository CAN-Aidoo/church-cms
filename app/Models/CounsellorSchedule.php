<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounsellorSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'counsellor_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_recurring',
        'effective_date',
        'end_date',
    ];

    protected $casts = [
        'is_recurring' => 'boolean',
        'effective_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Relationships
     */
    public function counsellor()
    {
        return $this->belongsTo(Counsellor::class);
    }

    /**
     * Get day display name.
     */
    public function getDayDisplayAttribute(): string
    {
        return ucfirst($this->day_of_week);
    }

    /**
     * Check if schedule is active.
     */
    public function isActive(): bool
    {
        $today = today();

        if ($this->effective_date && $this->effective_date->gt($today)) {
            return false;
        }

        if ($this->end_date && $this->end_date->lt($today)) {
            return false;
        }

        return true;
    }
}
