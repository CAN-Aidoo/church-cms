<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceUnitMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_unit_id',
        'meeting_title',
        'meeting_date',
        'meeting_time',
        'location',
        'agenda',
        'minutes',
        'attendance_count',
        'conducted_by',
        'notes',
        'status',
    ];

    protected $casts = [
        'meeting_date' => 'date',
        'meeting_time' => 'datetime',
    ];

    /**
     * Get the service unit this meeting belongs to.
     */
    public function serviceUnit(): BelongsTo
    {
        return $this->belongsTo(ServiceUnit::class);
    }

    /**
     * Get the member who conducted the meeting.
     */
    public function conductor(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'conducted_by');
    }
}
