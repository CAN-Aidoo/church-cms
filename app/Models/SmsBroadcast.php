<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmsBroadcast extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'message',
        'recipient_group',
        'recipient_count',
        'scheduled_for',
        'sent_at',
        'status',
        'success_count',
        'failure_count',
        'cost',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'scheduled_for' => 'datetime',
        'sent_at' => 'datetime',
        'recipient_count' => 'integer',
        'success_count' => 'integer',
        'failure_count' => 'integer',
        'cost' => 'decimal:2',
    ];

    /**
     * Get the user who created this broadcast.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all recipients for this broadcast.
     */
    public function recipients(): HasMany
    {
        return $this->hasMany(SmsBroadcastRecipient::class, 'broadcast_id');
    }

    /**
     * Scope query to only draft broadcasts.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope query to only scheduled broadcasts.
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    /**
     * Scope query to only sent broadcasts.
     */
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope query for broadcasts due to be sent.
     */
    public function scopeDueToSend($query)
    {
        return $query->where('status', 'scheduled')
            ->where('scheduled_for', '<=', now());
    }

    /**
     * Get delivery rate percentage.
     */
    public function getDeliveryRateAttribute(): float
    {
        if ($this->recipient_count === 0) {
            return 0;
        }

        return round(($this->success_count / $this->recipient_count) * 100, 2);
    }

    /**
     * Get character count of message.
     */
    public function getCharacterCountAttribute(): int
    {
        return mb_strlen($this->message);
    }

    /**
     * Get SMS segment count.
     */
    public function getSegmentCountAttribute(): int
    {
        $length = $this->character_count;

        if ($length <= 160) {
            return 1;
        }

        return ceil($length / 153);
    }

    /**
     * Check if broadcast can be sent.
     */
    public function canBeSent(): bool
    {
        return in_array($this->status, ['draft', 'scheduled']) && $this->recipient_count > 0;
    }

    /**
     * Mark as sent.
     */
    public function markAsSent(): bool
    {
        return $this->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }

    /**
     * Update delivery statistics.
     */
    public function updateStats(): void
    {
        $this->update([
            'success_count' => $this->recipients()->where('status', 'delivered')->count(),
            'failure_count' => $this->recipients()->where('status', 'failed')->count(),
        ]);
    }
}
