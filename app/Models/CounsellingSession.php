<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class CounsellingSession extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'session_code',
        'member_id',
        'counsellor_id',
        'case_id',
        'session_type',
        'session_date',
        'session_time',
        'duration_minutes',
        'mode',
        'location',
        'video_link',
        'urgency_level',
        'status',
        'booking_notes',
        'session_notes',
        'action_items',
        'progress_assessment',
        'follow_up_required',
        'follow_up_date',
        'outcome',
        'session_number',
        'booked_by',
        'cancelled_by',
        'cancellation_reason',
        'cancelled_at',
    ];

    protected $casts = [
        'session_date' => 'date',
        'action_items' => 'array',
        'follow_up_required' => 'boolean',
        'follow_up_date' => 'date',
        'duration_minutes' => 'integer',
        'session_number' => 'integer',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Session type labels.
     */
    public const SESSION_TYPES = [
        'pre_marital' => 'Pre-Marital Counselling',
        'marriage' => 'Marriage Counselling',
        'youth' => 'Youth Counselling',
        'addiction' => 'Addiction Counselling',
        'grief' => 'Grief Counselling',
        'career' => 'Career Guidance',
        'spiritual' => 'Spiritual Counselling',
        'family' => 'Family Counselling',
        'other' => 'Other',
    ];

    /**
     * Boot method to auto-generate session code.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($session) {
            if (empty($session->session_code)) {
                $session->session_code = 'CS-'.strtoupper(Str::random(12));
            }
        });
    }

    /**
     * Relationships
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function counsellor()
    {
        return $this->belongsTo(Counsellor::class);
    }

    public function case()
    {
        return $this->belongsTo(CounsellingCase::class, 'case_id');
    }

    public function bookedBy()
    {
        return $this->belongsTo(User::class, 'booked_by');
    }

    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    public function feedback()
    {
        return $this->hasOne(CounsellingFeedback::class, 'session_id');
    }

    /**
     * Get session type display name.
     */
    public function getSessionTypeDisplayAttribute(): string
    {
        return self::SESSION_TYPES[$this->session_type] ?? ucfirst(str_replace('_', ' ', $this->session_type));
    }

    /**
     * Get encrypted session notes.
     */
    public function getSessionNotesAttribute($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value; // Return as is if not encrypted
        }
    }

    /**
     * Set encrypted session notes.
     */
    public function setSessionNotesAttribute($value): void
    {
        if (! empty($value)) {
            $this->attributes['session_notes'] = Crypt::encryptString($value);
        } else {
            $this->attributes['session_notes'] = null;
        }
    }

    /**
     * Get session datetime.
     */
    public function getSessionDateTimeAttribute(): string
    {
        return $this->session_date->format('Y-m-d').' '.$this->session_time;
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'scheduled' => 'blue',
            'confirmed' => 'green',
            'in_progress' => 'yellow',
            'completed' => 'gray',
            'cancelled' => 'red',
            'rescheduled' => 'orange',
            'no_show' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get urgency badge color.
     */
    public function getUrgencyColorAttribute(): string
    {
        return match ($this->urgency_level) {
            'low' => 'gray',
            'medium' => 'blue',
            'high' => 'orange',
            'critical' => 'red',
            default => 'gray',
        };
    }

    /**
     * Check if session is past.
     */
    public function isPast(): bool
    {
        $sessionDateTime = $this->session_date->format('Y-m-d').' '.$this->session_time;

        return now()->gt($sessionDateTime);
    }

    /**
     * Check if session is upcoming.
     */
    public function isUpcoming(): bool
    {
        $sessionDateTime = $this->session_date->format('Y-m-d').' '.$this->session_time;

        return now()->lt($sessionDateTime);
    }

    /**
     * Confirm session.
     */
    public function confirm(): self
    {
        $this->update(['status' => 'confirmed']);

        return $this;
    }

    /**
     * Start session.
     */
    public function start(): self
    {
        $this->update(['status' => 'in_progress']);

        return $this;
    }

    /**
     * Complete session.
     */
    public function complete(array $data = []): self
    {
        $updateData = array_merge(['status' => 'completed'], $data);
        $this->update($updateData);

        // Update case session count
        if ($this->case_id) {
            $this->case->increment('total_sessions');
        }

        return $this;
    }

    /**
     * Cancel session.
     */
    public function cancel(string $reason, ?int $cancelledBy = null): self
    {
        $this->update([
            'status' => 'cancelled',
            'cancellation_reason' => $reason,
            'cancelled_by' => $cancelledBy ?? auth()->id(),
            'cancelled_at' => now(),
        ]);

        return $this;
    }

    /**
     * Reschedule session.
     */
    public function reschedule($newDate, $newTime): self
    {
        $this->update([
            'status' => 'rescheduled',
            'session_date' => $newDate,
            'session_time' => $newTime,
        ]);

        return $this;
    }

    /**
     * Mark as no show.
     */
    public function markNoShow(): self
    {
        $this->update(['status' => 'no_show']);

        return $this;
    }

    /**
     * Add session notes.
     */
    public function addNotes(string $notes): self
    {
        $this->update(['session_notes' => $notes]);

        return $this;
    }

    /**
     * Add action items.
     */
    public function addActionItems(array $items): self
    {
        $this->update(['action_items' => $items]);

        return $this;
    }

    /**
     * Query Scopes
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('session_date', '>=', today())
            ->whereIn('status', ['scheduled', 'confirmed']);
    }

    public function scopePast($query)
    {
        return $query->where('session_date', '<', today())
            ->orWhereIn('status', ['completed', 'no_show']);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('session_type', $type);
    }

    public function scopeByMember($query, int $memberId)
    {
        return $query->where('member_id', $memberId);
    }

    public function scopeByCounsellor($query, int $counsellorId)
    {
        return $query->where('counsellor_id', $counsellorId);
    }

    public function scopeByUrgency($query, string $urgency)
    {
        return $query->where('urgency_level', $urgency);
    }

    public function scopeRequiringFollowUp($query)
    {
        return $query->where('follow_up_required', true)
            ->where('status', 'completed');
    }

    public function scopeToday($query)
    {
        return $query->where('session_date', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('session_date', [now()->startOfWeek(), now()->endOfWeek()]);
    }
}
