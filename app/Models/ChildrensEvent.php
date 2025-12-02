<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildrensEvent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'event_name',
        'event_type',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'age_groups',
        'max_participants',
        'registered_count',
        'registration_fee',
        'registration_deadline',
        'flyer_url',
        'status',
        'coordinator_id',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'registration_deadline' => 'date',
        'age_groups' => 'array',
        'max_participants' => 'integer',
        'registered_count' => 'integer',
        'registration_fee' => 'decimal:2',
    ];

    /**
     * Event types.
     */
    public const EVENT_TYPES = [
        'vbs' => 'Vacation Bible School',
        'camp' => 'Children\'s Camp',
        'holiday_program' => 'Holiday Program',
        'talent_show' => 'Talent Show',
        'sports' => 'Sports Activity',
        'field_trip' => 'Field Trip',
        'workshop' => 'Workshop',
        'other' => 'Other',
    ];

    /**
     * Relationships
     */
    public function coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    public function registrations()
    {
        return $this->hasMany(ChildrensEventRegistration::class);
    }

    /**
     * Get event type display name.
     */
    public function getEventTypeDisplayAttribute(): string
    {
        return self::EVENT_TYPES[$this->event_type] ?? ucfirst(str_replace('_', ' ', $this->event_type));
    }

    /**
     * Check if event has available spots.
     */
    public function hasAvailableSpotsAttribute(): bool
    {
        if (! $this->max_participants) {
            return true;
        }

        return $this->registered_count < $this->max_participants;
    }

    /**
     * Get remaining spots.
     */
    public function getRemainingSpotsAttribute(): ?int
    {
        if (! $this->max_participants) {
            return null;
        }

        return max(0, $this->max_participants - $this->registered_count);
    }

    /**
     * Check if registration is open.
     */
    public function isRegistrationOpen(): bool
    {
        if ($this->status !== 'published') {
            return false;
        }

        if ($this->registration_deadline && $this->registration_deadline->isPast()) {
            return false;
        }

        return $this->has_available_spots;
    }

    /**
     * Increment registered count.
     */
    public function incrementRegisteredCount(): self
    {
        $this->increment('registered_count');

        return $this;
    }

    /**
     * Decrement registered count.
     */
    public function decrementRegisteredCount(): self
    {
        $this->decrement('registered_count');

        return $this;
    }

    /**
     * Publish event.
     */
    public function publish(): self
    {
        $this->update(['status' => 'published']);

        return $this;
    }

    /**
     * Start event.
     */
    public function start(): self
    {
        $this->update(['status' => 'ongoing']);

        return $this;
    }

    /**
     * Complete event.
     */
    public function complete(): self
    {
        $this->update(['status' => 'completed']);

        return $this;
    }

    /**
     * Cancel event.
     */
    public function cancel(): self
    {
        $this->update(['status' => 'cancelled']);

        return $this;
    }

    /**
     * Query Scopes
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', today())
            ->whereIn('status', ['draft', 'published']);
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('event_type', $type);
    }

    public function scopeForAgeGroup($query, string $ageGroup)
    {
        return $query->whereJsonContains('age_groups', $ageGroup);
    }
}
