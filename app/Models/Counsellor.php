<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Counsellor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'license_number',
        'qualifications',
        'specializations',
        'languages',
        'bio',
        'max_sessions_per_week',
        'session_duration_minutes',
        'availability_status',
        'accepts_online_bookings',
        'is_active',
    ];

    protected $casts = [
        'qualifications' => 'array',
        'specializations' => 'array',
        'languages' => 'array',
        'max_sessions_per_week' => 'integer',
        'session_duration_minutes' => 'integer',
        'accepts_online_bookings' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Specialization options.
     */
    public const SPECIALIZATIONS = [
        'pre_marital' => 'Pre-Marital Counselling',
        'marriage' => 'Marriage Counselling',
        'youth' => 'Youth Counselling',
        'addiction' => 'Addiction Counselling',
        'grief' => 'Grief Counselling',
        'career' => 'Career Guidance',
        'spiritual' => 'Spiritual Counselling',
        'family' => 'Family Counselling',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(CounsellorSchedule::class);
    }

    public function sessions()
    {
        return $this->hasMany(CounsellingSession::class);
    }

    public function cases()
    {
        return $this->hasMany(CounsellingCase::class, 'primary_counsellor_id');
    }

    /**
     * Get counsellor's full name.
     */
    public function getFullNameAttribute(): string
    {
        return $this->user->name ?? '';
    }

    /**
     * Get specializations display.
     */
    public function getSpecializationsDisplayAttribute(): array
    {
        return array_map(function ($spec) {
            return self::SPECIALIZATIONS[$spec] ?? ucfirst(str_replace('_', ' ', $spec));
        }, $this->specializations ?? []);
    }

    /**
     * Check if counsellor is available for a specific date/time.
     */
    public function isAvailableAt(Carbon $dateTime): bool
    {
        if (! $this->is_active || $this->availability_status === 'unavailable') {
            return false;
        }

        $dayOfWeek = strtolower($dateTime->format('l'));
        $time = $dateTime->format('H:i:s');

        return $this->schedules()
            ->where('day_of_week', $dayOfWeek)
            ->where('start_time', '<=', $time)
            ->where('end_time', '>=', $time)
            ->exists();
    }

    /**
     * Get available time slots for a specific date.
     */
    public function getAvailableSlots(Carbon $date): array
    {
        $dayOfWeek = strtolower($date->format('l'));

        $schedules = $this->schedules()
            ->where('day_of_week', $dayOfWeek)
            ->get();

        if ($schedules->isEmpty()) {
            return [];
        }

        $slots = [];
        foreach ($schedules as $schedule) {
            $startTime = Carbon::parse($schedule->start_time);
            $endTime = Carbon::parse($schedule->end_time);

            while ($startTime->lt($endTime)) {
                $slotDateTime = $date->copy()->setTimeFrom($startTime);

                // Check if slot is already booked
                $isBooked = $this->sessions()
                    ->where('session_date', $date->toDateString())
                    ->where('session_time', $startTime->format('H:i:s'))
                    ->whereIn('status', ['scheduled', 'confirmed', 'in_progress'])
                    ->exists();

                if (! $isBooked && $slotDateTime->isFuture()) {
                    $slots[] = [
                        'time' => $startTime->format('H:i'),
                        'datetime' => $slotDateTime,
                        'available' => true,
                    ];
                }

                $startTime->addMinutes($this->session_duration_minutes);
            }
        }

        return $slots;
    }

    /**
     * Get current week's session count.
     */
    public function getCurrentWeekSessionCount(): int
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        return $this->sessions()
            ->whereBetween('session_date', [$startOfWeek, $endOfWeek])
            ->whereIn('status', ['scheduled', 'confirmed', 'completed'])
            ->count();
    }

    /**
     * Check if counsellor can accept more sessions this week.
     */
    public function canAcceptMoreSessions(): bool
    {
        return $this->getCurrentWeekSessionCount() < $this->max_sessions_per_week;
    }

    /**
     * Get workload percentage for current week.
     */
    public function getWorkloadPercentageAttribute(): float
    {
        if ($this->max_sessions_per_week == 0) {
            return 0;
        }

        return ($this->getCurrentWeekSessionCount() / $this->max_sessions_per_week) * 100;
    }

    /**
     * Check if specializes in a specific area.
     */
    public function specializesIn(string $specialty): bool
    {
        return in_array($specialty, $this->specializations ?? []);
    }

    /**
     * Activate counsellor.
     */
    public function activate(): self
    {
        $this->update(['is_active' => true, 'availability_status' => 'available']);

        return $this;
    }

    /**
     * Deactivate counsellor.
     */
    public function deactivate(): self
    {
        $this->update(['is_active' => false, 'availability_status' => 'unavailable']);

        return $this;
    }

    /**
     * Set availability status.
     */
    public function setAvailability(string $status): self
    {
        $this->update(['availability_status' => $status]);

        return $this;
    }

    /**
     * Query Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_active', true)
            ->whereIn('availability_status', ['available', 'limited']);
    }

    public function scopeAcceptingBookings($query)
    {
        return $query->where('is_active', true)
            ->where('accepts_online_bookings', true)
            ->where('availability_status', 'available');
    }

    public function scopeSpecializingIn($query, string $specialty)
    {
        return $query->whereJsonContains('specializations', $specialty);
    }

    public function scopeUnderCapacity($query)
    {
        return $query->where('is_active', true)
            ->whereRaw('(SELECT COUNT(*) FROM counselling_sessions WHERE counsellor_id = counsellors.id AND session_date >= ? AND session_date <= ? AND status IN (?, ?, ?)) < max_sessions_per_week',
                [now()->startOfWeek(), now()->endOfWeek(), 'scheduled', 'confirmed', 'completed']);
    }
}
