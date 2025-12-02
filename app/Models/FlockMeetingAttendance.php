<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlockMeetingAttendance extends Model
{
    use HasFactory;

    protected $table = 'flock_meeting_attendance';

    protected $fillable = [
        'meeting_id',
        'member_id',
        'status',
        'notes',
    ];

    /**
     * Get the meeting for this attendance record.
     */
    public function meeting(): BelongsTo
    {
        return $this->belongsTo(FlockMeeting::class, 'meeting_id');
    }

    /**
     * Get the member for this attendance record.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Scope a query to only include present members.
     */
    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    /**
     * Scope a query to only include absent members.
     */
    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }
}
