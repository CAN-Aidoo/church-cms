<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FlockMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'shepherd_id',
        'meeting_date',
        'meeting_time',
        'location',
        'meeting_type',
        'agenda',
        'notes',
        'attendance_count',
        'status',
        'recorded_by',
    ];

    protected $casts = [
        'meeting_date' => 'date',
    ];

    /**
     * Get the shepherd for this meeting.
     */
    public function shepherd(): BelongsTo
    {
        return $this->belongsTo(Shepherd::class);
    }

    /**
     * Get the user who recorded this meeting.
     */
    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Get the attendance records for this meeting.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(FlockMeetingAttendance::class, 'meeting_id');
    }

    /**
     * Scope a query to only include completed meetings.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include scheduled meetings.
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    /**
     * Scope a query to only include upcoming meetings.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'scheduled')
            ->where('meeting_date', '>=', now()->toDateString());
    }

    /**
     * Calculate attendance percentage.
     */
    public function getAttendancePercentageAttribute(): float
    {
        $flockSize = $this->shepherd->current_flock_size;
        if ($flockSize == 0) {
            return 0;
        }

        return ($this->attendance_count / $flockSize) * 100;
    }

    /**
     * Check if meeting is past.
     */
    public function getIsPastAttribute(): bool
    {
        return $this->meeting_date->isPast();
    }

    /**
     * Check if meeting is today.
     */
    public function getIsTodayAttribute(): bool
    {
        return $this->meeting_date->isToday();
    }

    /**
     * Check if meeting is upcoming (within 7 days).
     */
    public function getIsUpcomingAttribute(): bool
    {
        return $this->meeting_date->isFuture() && $this->meeting_date->diffInDays(now()) <= 7;
    }
}
