<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'icon',
        'action_url',
        'metadata',
        'is_read',
        'read_at',
        'priority',
        'expires_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user who owns the notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: Get unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope: Get read notifications.
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope: Get notifications by type.
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: Get high priority notifications.
     */
    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', ['high', 'urgent']);
    }

    /**
     * Scope: Get non-expired notifications.
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
                ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(): void
    {
        if (! $this->is_read) {
            $this->is_read = true;
            $this->read_at = now();
            $this->save();
        }
    }

    /**
     * Mark notification as unread.
     */
    public function markAsUnread(): void
    {
        $this->is_read = false;
        $this->read_at = null;
        $this->save();
    }

    /**
     * Check if notification is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Get icon for notification type.
     */
    public function getDefaultIcon(): string
    {
        if ($this->icon) {
            return $this->icon;
        }

        return match ($this->type) {
            'birthday' => '🎂',
            'anniversary' => '💑',
            'attendance_alert' => '⚠️',
            'finance_approval' => '💰',
            'duty_roster' => '📋',
            'meeting_reminder' => '📅',
            'success' => '✅',
            'warning' => '⚠️',
            'error' => '❌',
            default => 'ℹ️',
        };
    }

    /**
     * Get CSS class for notification type.
     */
    public function getTypeClass(): string
    {
        return match ($this->type) {
            'success', 'birthday' => 'bg-green-50 border-green-200 text-green-800',
            'warning', 'attendance_alert' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
            'error' => 'bg-red-50 border-red-200 text-red-800',
            'finance_approval' => 'bg-blue-50 border-blue-200 text-blue-800',
            'anniversary' => 'bg-purple-50 border-purple-200 text-purple-800',
            default => 'bg-gray-50 border-gray-200 text-gray-800',
        };
    }
}
