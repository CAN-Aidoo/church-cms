<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'name',
        'description',
        'avatar',
        'settings',
        'created_by',
        'last_message_at',
        'is_archived',
    ];

    protected $casts = [
        'settings' => 'array',
        'last_message_at' => 'datetime',
        'is_archived' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants()
    {
        return $this->hasMany(ConversationParticipant::class);
    }

    public function activeParticipants()
    {
        return $this->hasMany(ConversationParticipant::class)->where('is_active', true);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    /**
     * Get conversation name for display.
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->type === 'group') {
            return $this->name ?? 'Group Chat';
        }

        // For direct messages, show the other person's name
        $currentUserId = auth()->id();
        $otherParticipant = $this->participants()
            ->where('user_id', '!=', $currentUserId)
            ->with('user')
            ->first();

        return $otherParticipant?->user->name ?? 'Direct Message';
    }

    /**
     * Get unread count for a user.
     */
    public function getUnreadCountForUser(int $userId): int
    {
        $participant = $this->participants()->where('user_id', $userId)->first();

        if (! $participant) {
            return 0;
        }

        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('created_at', '>', $participant->last_read_at ?? $participant->joined_at)
            ->count();
    }

    /**
     * Mark as read for user.
     */
    public function markAsReadForUser(int $userId): void
    {
        $this->participants()
            ->where('user_id', $userId)
            ->update(['last_read_at' => now()]);
    }

    /**
     * Check if user is participant.
     */
    public function hasParticipant(int $userId): bool
    {
        return $this->participants()
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->exists();
    }

    /**
     * Add participant.
     */
    public function addParticipant(int $userId, string $role = 'member'): ConversationParticipant
    {
        return $this->participants()->updateOrCreate(
            ['user_id' => $userId],
            [
                'role' => $role,
                'is_active' => true,
                'joined_at' => now(),
                'left_at' => null,
            ]
        );
    }

    /**
     * Remove participant.
     */
    public function removeParticipant(int $userId): void
    {
        $this->participants()
            ->where('user_id', $userId)
            ->update([
                'is_active' => false,
                'left_at' => now(),
            ]);
    }

    /**
     * Archive conversation.
     */
    public function archive(): self
    {
        $this->update(['is_archived' => true]);

        return $this;
    }

    /**
     * Unarchive conversation.
     */
    public function unarchive(): self
    {
        $this->update(['is_archived' => false]);

        return $this;
    }

    /**
     * Update last message timestamp.
     */
    public function updateLastMessage(): self
    {
        $this->update(['last_message_at' => now()]);

        return $this;
    }

    /**
     * Get participant role.
     */
    public function getParticipantRole(int $userId): ?string
    {
        return $this->participants()
            ->where('user_id', $userId)
            ->value('role');
    }

    /**
     * Check if user is admin/owner.
     */
    public function isUserAdmin(int $userId): bool
    {
        $role = $this->getParticipantRole($userId);

        return in_array($role, ['owner', 'admin']);
    }

    /**
     * Find or create direct conversation between two users.
     */
    public static function findOrCreateDirect(int $userId1, int $userId2): self
    {
        // Find existing direct conversation
        $conversation = self::where('type', 'direct')
            ->whereHas('participants', function ($q) use ($userId1) {
                $q->where('user_id', $userId1);
            })
            ->whereHas('participants', function ($q) use ($userId2) {
                $q->where('user_id', $userId2);
            })
            ->first();

        if ($conversation) {
            return $conversation;
        }

        // Create new conversation
        $conversation = self::create([
            'type' => 'direct',
            'created_by' => $userId1,
        ]);

        $conversation->addParticipant($userId1);
        $conversation->addParticipant($userId2);

        return $conversation;
    }

    /**
     * Query Scopes
     */
    public function scopeDirect($query)
    {
        return $query->where('type', 'direct');
    }

    public function scopeGroup($query)
    {
        return $query->where('type', 'group');
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->whereHas('participants', function ($q) use ($userId) {
            $q->where('user_id', $userId)->where('is_active', true);
        });
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('last_message_at', 'desc');
    }

    public function scopeWithUnreadCount($query, int $userId)
    {
        return $query->withCount(['messages as unread_count' => function ($q) use ($userId) {
            $q->where('sender_id', '!=', $userId)
                ->whereDoesntHave('readReceipts', function ($rq) use ($userId) {
                    $rq->where('user_id', $userId)->whereNotNull('read_at');
                });
        }]);
    }
}
