<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'reply_to_id',
        'type',
        'content',
        'attachments',
        'metadata',
        'is_edited',
        'edited_at',
        'is_deleted',
        'deleted_at',
        'is_pinned',
        'pinned_at',
        'pinned_by',
        'is_important',
        'disappear_after_hours',
        'disappear_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'metadata' => 'array',
        'is_edited' => 'boolean',
        'edited_at' => 'datetime',
        'is_deleted' => 'boolean',
        'deleted_at' => 'datetime',
        'is_pinned' => 'boolean',
        'pinned_at' => 'datetime',
        'is_important' => 'boolean',
        'disappear_at' => 'datetime',
        'disappear_after_hours' => 'integer',
    ];

    /**
     * Boot method.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($message) {
            // Set disappear_at if disappear_after_hours is set
            if ($message->disappear_after_hours) {
                $message->disappear_at = now()->addHours($message->disappear_after_hours);
            }

            // Update conversation's last_message_at
            if ($message->conversation_id) {
                Conversation::find($message->conversation_id)?->updateLastMessage();
            }
        });
    }

    /**
     * Relationships
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function replyTo()
    {
        return $this->belongsTo(Message::class, 'reply_to_id');
    }

    public function replies()
    {
        return $this->hasMany(Message::class, 'reply_to_id');
    }

    public function readReceipts()
    {
        return $this->hasMany(MessageReadReceipt::class);
    }

    public function reactions()
    {
        return $this->hasMany(MessageReaction::class);
    }

    public function files()
    {
        return $this->hasMany(MessageFile::class);
    }

    public function reports()
    {
        return $this->hasMany(MessageReport::class);
    }

    public function stars()
    {
        return $this->hasMany(StarredMessage::class);
    }

    /**
     * Get message content (handle deleted messages).
     */
    public function getDisplayContentAttribute(): string
    {
        if ($this->is_deleted) {
            return 'This message was deleted';
        }

        return $this->content ?? '';
    }

    /**
     * Check if message is read by user.
     */
    public function isReadBy(int $userId): bool
    {
        return $this->readReceipts()
            ->where('user_id', $userId)
            ->whereNotNull('read_at')
            ->exists();
    }

    /**
     * Mark as read by user.
     */
    public function markAsRead(int $userId): void
    {
        $this->readReceipts()->updateOrCreate(
            ['user_id' => $userId],
            [
                'read_at' => now(),
                'delivered_at' => now(),
            ]
        );
    }

    /**
     * Mark as delivered to user.
     */
    public function markAsDelivered(int $userId): void
    {
        $this->readReceipts()->updateOrCreate(
            ['user_id' => $userId],
            ['delivered_at' => now()]
        );
    }

    /**
     * Edit message.
     */
    public function edit(string $newContent): self
    {
        $this->update([
            'content' => $newContent,
            'is_edited' => true,
            'edited_at' => now(),
        ]);

        return $this;
    }

    /**
     * Delete message (soft).
     */
    public function softDelete(): self
    {
        $this->update([
            'is_deleted' => true,
            'deleted_at' => now(),
            'content' => null,
        ]);

        // Delete attachments
        if ($this->attachments) {
            foreach ($this->attachments as $attachment) {
                Storage::delete($attachment);
            }
            $this->update(['attachments' => null]);
        }

        return $this;
    }

    /**
     * Pin message.
     */
    public function pin(int $pinnedBy): self
    {
        // Unpin other messages in conversation
        Message::where('conversation_id', $this->conversation_id)
            ->where('id', '!=', $this->id)
            ->update(['is_pinned' => false, 'pinned_at' => null, 'pinned_by' => null]);

        $this->update([
            'is_pinned' => true,
            'pinned_at' => now(),
            'pinned_by' => $pinnedBy,
        ]);

        return $this;
    }

    /**
     * Unpin message.
     */
    public function unpin(): self
    {
        $this->update([
            'is_pinned' => false,
            'pinned_at' => null,
            'pinned_by' => null,
        ]);

        return $this;
    }

    /**
     * Mark as important.
     */
    public function markImportant(): self
    {
        $this->update(['is_important' => true]);

        return $this;
    }

    /**
     * Add reaction.
     */
    public function addReaction(int $userId, string $emoji): void
    {
        $this->reactions()->updateOrCreate(
            [
                'user_id' => $userId,
                'emoji' => $emoji,
            ]
        );
    }

    /**
     * Remove reaction.
     */
    public function removeReaction(int $userId, string $emoji): void
    {
        $this->reactions()
            ->where('user_id', $userId)
            ->where('emoji', $emoji)
            ->delete();
    }

    /**
     * Star message for user.
     */
    public function star(int $userId): void
    {
        StarredMessage::firstOrCreate([
            'message_id' => $this->id,
            'user_id' => $userId,
        ]);
    }

    /**
     * Unstar message for user.
     */
    public function unstar(int $userId): void
    {
        StarredMessage::where('message_id', $this->id)
            ->where('user_id', $userId)
            ->delete();
    }

    /**
     * Check if starred by user.
     */
    public function isStarredBy(int $userId): bool
    {
        return $this->stars()->where('user_id', $userId)->exists();
    }

    /**
     * Get reaction counts.
     */
    public function getReactionCountsAttribute(): array
    {
        return $this->reactions()
            ->selectRaw('emoji, COUNT(*) as count')
            ->groupBy('emoji')
            ->pluck('count', 'emoji')
            ->toArray();
    }

    /**
     * Query Scopes
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('is_deleted', false);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeImportant($query)
    {
        return $query->where('is_important', true);
    }

    public function scopeWithAttachments($query)
    {
        return $query->whereNotNull('attachments');
    }

    public function scopeSearchContent($query, string $search)
    {
        return $query->where('content', 'like', "%{$search}%");
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('disappear_at')
            ->where('disappear_at', '<=', now());
    }
}
