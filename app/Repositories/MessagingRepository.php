<?php

namespace App\Repositories;

use App\Models\BlockedUser;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Collection;

class MessagingRepository
{
    /**
     * Get user's conversations.
     */
    public function getUserConversations(int $userId, array $filters = [])
    {
        $query = Conversation::forUser($userId)
            ->with(['latestMessage.sender', 'activeParticipants.user'])
            ->withUnreadCount($userId);

        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['archived'])) {
            $query->where('is_archived', $filters['archived']);
        } else {
            $query->active();
        }

        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                    ->orWhereHas('messages', function ($mq) use ($filters) {
                        $mq->searchContent($filters['search']);
                    });
            });
        }

        return $query->recent()->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Get conversation messages.
     */
    public function getConversationMessages(int $conversationId, array $filters = []): Collection
    {
        $query = Message::where('conversation_id', $conversationId)
            ->with(['sender', 'replyTo.sender', 'reactions', 'files'])
            ->notDeleted();

        if (isset($filters['before_id'])) {
            $query->where('id', '<', $filters['before_id']);
        }

        if (isset($filters['after_id'])) {
            $query->where('id', '>', $filters['after_id']);
        }

        return $query->orderBy('created_at', 'desc')
            ->limit($filters['limit'] ?? 50)
            ->get()
            ->reverse()
            ->values();
    }

    /**
     * Create or get direct conversation.
     */
    public function getOrCreateDirectConversation(int $userId1, int $userId2): Conversation
    {
        return Conversation::findOrCreateDirect($userId1, $userId2);
    }

    /**
     * Create group conversation.
     */
    public function createGroupConversation(array $data, array $participantIds): Conversation
    {
        $conversation = Conversation::create([
            'type' => 'group',
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'avatar' => $data['avatar'] ?? null,
            'settings' => $data['settings'] ?? null,
            'created_by' => auth()->id(),
        ]);

        // Add creator as owner
        $conversation->addParticipant(auth()->id(), 'owner');

        // Add other participants
        foreach ($participantIds as $participantId) {
            if ($participantId != auth()->id()) {
                $conversation->addParticipant($participantId, 'member');
            }
        }

        return $conversation;
    }

    /**
     * Send message.
     */
    public function sendMessage(int $conversationId, array $data): Message
    {
        $message = Message::create([
            'conversation_id' => $conversationId,
            'sender_id' => auth()->id(),
            'reply_to_id' => $data['reply_to_id'] ?? null,
            'type' => $data['type'] ?? 'text',
            'content' => $data['content'] ?? null,
            'attachments' => $data['attachments'] ?? null,
            'metadata' => $data['metadata'] ?? null,
            'is_important' => $data['is_important'] ?? false,
            'disappear_after_hours' => $data['disappear_after_hours'] ?? null,
        ]);

        // Mark as delivered to all participants
        $conversation = Conversation::find($conversationId);
        $participants = $conversation->activeParticipants()
            ->where('user_id', '!=', auth()->id())
            ->pluck('user_id');

        foreach ($participants as $userId) {
            $message->markAsDelivered($userId);
        }

        return $message;
    }

    /**
     * Get unread messages count for user.
     */
    public function getUnreadCount(int $userId): int
    {
        return Conversation::forUser($userId)
            ->withUnreadCount($userId)
            ->get()
            ->sum('unread_count');
    }

    /**
     * Search messages.
     */
    public function searchMessages(int $userId, string $query, array $filters = [])
    {
        $messagesQuery = Message::whereHas('conversation', function ($q) use ($userId) {
            $q->forUser($userId);
        })
            ->with(['conversation', 'sender'])
            ->notDeleted()
            ->searchContent($query);

        if (isset($filters['conversation_id'])) {
            $messagesQuery->where('conversation_id', $filters['conversation_id']);
        }

        if (isset($filters['type'])) {
            $messagesQuery->byType($filters['type']);
        }

        if (isset($filters['has_attachments']) && $filters['has_attachments']) {
            $messagesQuery->withAttachments();
        }

        if (isset($filters['date_from'])) {
            $messagesQuery->where('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $messagesQuery->where('created_at', '<=', $filters['date_to']);
        }

        return $messagesQuery->orderBy('created_at', 'desc')
            ->paginate($filters['per_page'] ?? 20);
    }

    /**
     * Get starred messages for user.
     */
    public function getStarredMessages(int $userId): Collection
    {
        return Message::whereHas('stars', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
            ->with(['conversation', 'sender'])
            ->notDeleted()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Block user.
     */
    public function blockUser(int $blockerId, int $blockedId, ?string $reason = null): void
    {
        BlockedUser::firstOrCreate(
            [
                'blocker_id' => $blockerId,
                'blocked_id' => $blockedId,
            ],
            ['reason' => $reason]
        );
    }

    /**
     * Unblock user.
     */
    public function unblockUser(int $blockerId, int $blockedId): void
    {
        BlockedUser::where('blocker_id', $blockerId)
            ->where('blocked_id', $blockedId)
            ->delete();
    }

    /**
     * Check if user is blocked.
     */
    public function isUserBlocked(int $blockerId, int $blockedId): bool
    {
        return BlockedUser::where('blocker_id', $blockerId)
            ->where('blocked_id', $blockedId)
            ->exists();
    }

    /**
     * Get blocked users.
     */
    public function getBlockedUsers(int $userId): Collection
    {
        return BlockedUser::where('blocker_id', $userId)
            ->with('blocked')
            ->get()
            ->pluck('blocked');
    }

    /**
     * Report message.
     */
    public function reportMessage(int $messageId, int $reportedBy, string $reason, ?string $description = null): void
    {
        \App\Models\MessageReport::create([
            'message_id' => $messageId,
            'reported_by' => $reportedBy,
            'reason' => $reason,
            'description' => $description,
        ]);
    }

    /**
     * Get messaging statistics.
     */
    public function getStatistics(int $userId): array
    {
        return [
            'total_conversations' => Conversation::forUser($userId)->count(),
            'direct_conversations' => Conversation::forUser($userId)->direct()->count(),
            'group_conversations' => Conversation::forUser($userId)->group()->count(),
            'unread_count' => $this->getUnreadCount($userId),
            'starred_messages' => Message::whereHas('stars', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })->count(),
            'blocked_users' => BlockedUser::where('blocker_id', $userId)->count(),
        ];
    }

    /**
     * Clean up expired messages.
     */
    public function cleanupExpiredMessages(): int
    {
        $expiredMessages = Message::expired()->get();

        foreach ($expiredMessages as $message) {
            $message->softDelete();
        }

        return $expiredMessages->count();
    }
}
