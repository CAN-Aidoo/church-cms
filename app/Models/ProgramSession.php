<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'title',
        'description',
        'session_date',
        'start_time',
        'end_time',
        'venue',
        'speaker_name',
        'speaker_bio',
        'materials_required',
        'max_attendees',
        'current_attendees',
    ];

    protected $casts = [
        'session_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function attendance()
    {
        return $this->hasMany(ProgramAttendance::class, 'session_id');
    }

    public function getDurationMinutesAttribute(): int
    {
        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);

        return $start->diffInMinutes($end);
    }

    public function getAttendanceRateAttribute(): float
    {
        $confirmed = $this->program->getConfirmedRegistrationsCount();
        if ($confirmed === 0) {
            return 0;
        }

        return ($this->current_attendees / $confirmed) * 100;
    }
}
