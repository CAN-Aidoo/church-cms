<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsBroadcastRecipient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'broadcast_id',
        'member_id',
        'phone_number',
        'status',
        'delivery_timestamp',
        'twilio_message_sid',
        'error_code',
        'error_message',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'delivery_timestamp' => 'datetime',
    ];

    /**
     * Get the broadcast this recipient belongs to.
     */
    public function broadcast(): BelongsTo
    {
        return $this->belongsTo(SmsBroadcast::class, 'broadcast_id');
    }

    /**
     * Get the member associated with this recipient.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Scope query to only pending recipients.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope query to only sent recipients.
     */
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope query to only delivered recipients.
     */
    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    /**
     * Scope query to only failed recipients.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Mark as sent.
     */
    public function markAsSent(string $messageSid): bool
    {
        return $this->update([
            'status' => 'sent',
            'twilio_message_sid' => $messageSid,
            'delivery_timestamp' => now(),
        ]);
    }

    /**
     * Mark as delivered.
     */
    public function markAsDelivered(): bool
    {
        return $this->update([
            'status' => 'delivered',
            'delivery_timestamp' => now(),
        ]);
    }

    /**
     * Mark as failed.
     */
    public function markAsFailed(string $errorCode, string $errorMessage): bool
    {
        return $this->update([
            'status' => 'failed',
            'error_code' => $errorCode,
            'error_message' => $errorMessage,
        ]);
    }
}
