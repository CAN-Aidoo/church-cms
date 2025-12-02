<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'member_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'special_requirements',
        'status',
        'amount_paid',
        'payment_status',
        'payment_reference',
        'badge_number',
        'checked_in_at',
        'registered_at',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'checked_in_at' => 'datetime',
        'registered_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function attendance()
    {
        return $this->hasMany(ProgramAttendance::class, 'registration_id');
    }

    public function feedback()
    {
        return $this->hasOne(ProgramFeedback::class, 'registration_id');
    }

    public function certificate()
    {
        return $this->hasOne(ProgramCertificate::class, 'registration_id');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function isCheckedIn(): bool
    {
        return ! is_null($this->checked_in_at);
    }

    public function checkIn(): void
    {
        if (! $this->isCheckedIn()) {
            $this->checked_in_at = now();
            $this->status = 'attended';
            $this->save();
        }
    }

    public function confirm(): bool
    {
        if ($this->status === 'pending') {
            $this->status = 'confirmed';

            return $this->save();
        }

        return false;
    }

    public function moveToWaitlist(): bool
    {
        $this->status = 'waitlist';

        return $this->save();
    }

    public function cancel(): bool
    {
        if (! in_array($this->status, ['attended', 'cancelled'])) {
            $this->status = 'cancelled';

            return $this->save();
        }

        return false;
    }
}
