<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BirthdayWish extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'birthday_date',
        'year_sent',
        'wish_type',
        'delivery_method',
        'message',
        'status',
        'scheduled_at',
        'sent_at',
        'sms_id',
        'email_id',
        'error_message',
        'retry_count',
    ];

    protected $casts = [
        'birthday_date' => 'date',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    /**
     * Get the member who received the wish.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Scope: Get pending wishes.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Get sent wishes.
     */
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope: Get failed wishes.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope: Get wishes scheduled for today.
     */
    public function scopeScheduledForToday($query)
    {
        return $query->whereDate('scheduled_at', today());
    }

    /**
     * Scope: Get wishes by type.
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('wish_type', $type);
    }

    /**
     * Mark the wish as sent.
     */
    public function markAsSent(?string $messageId = null, string $channel = 'sms'): void
    {
        $this->status = 'sent';
        $this->sent_at = now();

        if ($channel === 'sms') {
            $this->sms_id = $messageId;
        } else {
            $this->email_id = $messageId;
        }

        $this->save();
    }

    /**
     * Mark the wish as failed.
     */
    public function markAsFailed(string $errorMessage): void
    {
        $this->status = 'failed';
        $this->error_message = $errorMessage;
        $this->retry_count++;
        $this->save();
    }

    /**
     * Check if can retry.
     */
    public function canRetry(): bool
    {
        return $this->retry_count < 3 && $this->status === 'failed';
    }

    /**
     * Check if overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === 'pending'
            && $this->scheduled_at
            && $this->scheduled_at->isPast();
    }
}
