<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrayerRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'category_id',
        'requester_name',
        'requester_phone',
        'requester_email',
        'request_title',
        'request_details',
        'urgency',
        'privacy_level',
        'status',
        'assigned_to',
        'answered_at',
        'testimony',
        'share_testimony',
        'is_anonymous',
        'tags',
    ];

    protected $casts = [
        'answered_at' => 'datetime',
        'share_testimony' => 'boolean',
        'is_anonymous' => 'boolean',
        'tags' => 'array',
    ];

    /**
     * Relationships
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function category()
    {
        return $this->belongsTo(PrayerCategory::class);
    }

    public function assignedIntercessor()
    {
        return $this->belongsTo(Member::class, 'assigned_to');
    }

    public function assignments()
    {
        return $this->hasMany(PrayerAssignment::class);
    }

    public function intercessors()
    {
        return $this->belongsToMany(Member::class, 'prayer_assignments', 'prayer_request_id', 'intercessor_id')
            ->withPivot('assigned_at', 'started_praying_at', 'completed_at', 'status', 'notes')
            ->withTimestamps();
    }

    public function updates()
    {
        return $this->hasMany(PrayerUpdate::class)->orderBy('created_at', 'desc');
    }

    public function testimonies()
    {
        return $this->hasMany(PrayerTestimony::class);
    }

    /**
     * Query Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAssigned($query)
    {
        return $query->where('status', 'assigned');
    }

    public function scopePraying($query)
    {
        return $query->where('status', 'praying');
    }

    public function scopeAnswered($query)
    {
        return $query->where('status', 'answered');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'assigned', 'praying']);
    }

    public function scopePublic($query)
    {
        return $query->where('privacy_level', 'public');
    }

    public function scopeUrgent($query)
    {
        return $query->whereIn('urgency', ['high', 'critical']);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByIntercessor($query, $intercessorId)
    {
        return $query->whereHas('intercessors', function ($q) use ($intercessorId) {
            $q->where('member_id', $intercessorId);
        });
    }

    /**
     * Computed Attributes
     */
    public function getDaysOpenAttribute(): int
    {
        return $this->created_at->diffInDays(now());
    }

    public function getIsAnsweredAttribute(): bool
    {
        return $this->status === 'answered';
    }

    public function getIsActiveAttribute(): bool
    {
        return in_array($this->status, ['pending', 'assigned', 'praying']);
    }

    public function getIntercessorCountAttribute(): int
    {
        return $this->assignments()->count();
    }

    /**
     * Helper Methods
     */
    public function getUrgencyBadgeClass(): string
    {
        return match ($this->urgency) {
            'low' => 'bg-gray-100 text-gray-800',
            'normal' => 'bg-blue-100 text-blue-800',
            'high' => 'bg-orange-100 text-orange-800',
            'critical' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'assigned' => 'bg-blue-100 text-blue-800',
            'praying' => 'bg-purple-100 text-purple-800',
            'answered' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getUrgencyLabelAttribute(): string
    {
        return ucfirst($this->urgency);
    }

    public function getPrivacyIconAttribute(): string
    {
        return match ($this->privacy_level) {
            'public' => '🌍',
            'pastors_only' => '🔒',
            'private' => '🔐',
            default => '📋',
        };
    }

    /**
     * State Management Methods
     */
    public function assign(int $intercessorId): bool
    {
        if ($this->status === 'pending') {
            $this->status = 'assigned';
            $this->assigned_to = $intercessorId;

            return $this->save();
        }

        return false;
    }

    public function startPraying(): bool
    {
        if (in_array($this->status, ['pending', 'assigned'])) {
            $this->status = 'praying';

            return $this->save();
        }

        return false;
    }

    public function markAnswered(?string $testimony = null, bool $shareTestimony = false): bool
    {
        if ($this->status !== 'answered') {
            $this->status = 'answered';
            $this->answered_at = now();

            if ($testimony) {
                $this->testimony = $testimony;
                $this->share_testimony = $shareTestimony;
            }

            return $this->save();
        }

        return false;
    }

    public function cancel(): bool
    {
        if ($this->status !== 'answered') {
            $this->status = 'cancelled';

            return $this->save();
        }

        return false;
    }

    /**
     * Add update/note to prayer request.
     */
    public function addUpdate(int $userId, string $updateText, string $updateType = 'note', bool $notifyRequester = false): PrayerUpdate
    {
        return $this->updates()->create([
            'updated_by' => $userId,
            'update_text' => $updateText,
            'update_type' => $updateType,
            'notify_requester' => $notifyRequester,
        ]);
    }

    /**
     * Assign intercessor to prayer request.
     */
    public function assignIntercessor(int $intercessorId, ?string $notes = null): PrayerAssignment
    {
        return $this->assignments()->create([
            'intercessor_id' => $intercessorId,
            'assigned_at' => now(),
            'status' => 'assigned',
            'notes' => $notes,
        ]);
    }

    /**
     * Get display name (handles anonymous requests).
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->is_anonymous) {
            return 'Anonymous';
        }

        if ($this->member) {
            return $this->member->first_name.' '.$this->member->last_name;
        }

        return $this->requester_name;
    }

    /**
     * Get days until critical (based on urgency).
     */
    public function getDaysUntilCriticalAttribute(): ?int
    {
        $thresholds = [
            'critical' => 1,
            'high' => 3,
            'normal' => 7,
            'low' => 14,
        ];

        $threshold = $thresholds[$this->urgency] ?? 7;
        $remaining = $threshold - $this->days_open;

        return $remaining > 0 ? $remaining : null;
    }

    /**
     * Check if request needs attention.
     */
    public function needsAttention(): bool
    {
        if ($this->status === 'pending' && $this->days_open > 1) {
            return true;
        }

        if ($this->urgency === 'critical' && $this->status !== 'praying') {
            return true;
        }

        if ($this->urgency === 'high' && $this->status === 'pending' && $this->days_open > 2) {
            return true;
        }

        return false;
    }
}
