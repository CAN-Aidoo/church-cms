<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'session_id',
        'registration_id',
        'checked_in_at',
        'attendance_method',
        'notes',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function session()
    {
        return $this->belongsTo(ProgramSession::class, 'session_id');
    }

    public function registration()
    {
        return $this->belongsTo(ProgramRegistration::class, 'registration_id');
    }
}
