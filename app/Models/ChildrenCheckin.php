<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChildrenCheckin extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'service_id',
        'checkin_date',
        'checkin_time',
        'checkout_time',
        'classroom_assigned',
        'security_code',
        'name_tag_printed',
        'checked_in_by',
        'checked_out_by',
        'checkout_authorized_person',
        'status',
        'notes',
    ];

    protected $casts = [
        'checkin_date' => 'date',
    ];

    /**
     * Boot method to auto-generate security code.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($checkin) {
            if (empty($checkin->security_code)) {
                $checkin->security_code = strtoupper(Str::random(6));
            }
        });
    }

    /**
     * Relationships
     */
    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function service()
    {
        return $this->belongsTo(ServiceSchedule::class, 'service_id');
    }

    public function checkedInBy()
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }

    public function checkedOutBy()
    {
        return $this->belongsTo(User::class, 'checked_out_by');
    }

    /**
     * Check out child.
     */
    public function checkOut(string $authorizedPerson, ?int $userId = null): self
    {
        $this->update([
            'checkout_time' => now()->format('H:i:s'),
            'checked_out_by' => $userId ?? auth()->id(),
            'checkout_authorized_person' => $authorizedPerson,
            'status' => 'checked_out',
        ]);

        return $this;
    }

    /**
     * Print name tag.
     */
    public function printNameTag(): self
    {
        $this->update(['name_tag_printed' => 'yes']);

        return $this;
    }

    /**
     * Get duration of stay in minutes.
     */
    public function getDurationInMinutesAttribute(): ?int
    {
        if (! $this->checkout_time) {
            return null;
        }

        $checkin = \Carbon\Carbon::parse($this->checkin_time);
        $checkout = \Carbon\Carbon::parse($this->checkout_time);

        return $checkout->diffInMinutes($checkin);
    }

    /**
     * Check if checkout is late (more than 30 minutes after service end).
     */
    public function isLatePickup(): bool
    {
        if (! $this->service || $this->status === 'checked_out') {
            return false;
        }

        $serviceEndTime = \Carbon\Carbon::parse($this->service->end_time);
        $now = now();

        return $now->greaterThan($serviceEndTime->addMinutes(30));
    }

    /**
     * Query Scopes
     */
    public function scopeCheckedIn($query)
    {
        return $query->where('status', 'checked_in');
    }

    public function scopeCheckedOut($query)
    {
        return $query->where('status', 'checked_out');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('checkin_date', today());
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('checkin_date', $date);
    }

    public function scopeByClassroom($query, string $classroom)
    {
        return $query->where('classroom_assigned', $classroom);
    }
}
