<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Repositories\MessagingRepository;
use Illuminate\Http\Request;

class MessagingController extends Controller
{
    public function __construct(
        private MessagingRepository $repository
    ) {}

    /**
     * Display messaging dashboard.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['type', 'archived', 'search']);
        $conversations = $this->repository->getUserConversations(auth()->id(), $filters);
        $statistics = $this->repository->getStatistics(auth()->id());

        return view('messaging.index', compact('conversations', 'statistics', 'filters'));
    }

    /**
     * Show conversation.
     */
    public function showConversation(Conversation $conversation)
    {
        // Check access
        if (! $conversation->hasParticipant(auth()->id())) {
            abort(403, 'You are not a participant in this conversation.');
        }

        $messages = $this->repository->getConversationMessages($conversation->id);
        $conversation->markAsReadForUser(auth()->id());

        return view('messaging.conversation', compact('conversation', 'messages'));
    }

    /**
     * Get conversation messages (AJAX).
     */
    public function getMessages(Request $request, Conversation $conversation)
    {
        // Check access
        if (! $conversation->hasParticipant(auth()->id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $filters = $request->only(['before_id', 'after_id', 'limit']);
        $messages = $this->repository->getConversationMessages($conversation->id, $filters);

        return response()->json([
            'messages' => $messages,
        ]);
    }

    /**
     * Start direct conversation.
     */
    public function startDirectConversation(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Check if user is blocked
        if ($this->repository->isUserBlocked(auth()->id(), $validated['user_id'])) {
            return redirect()
                ->back()
                ->with('error', 'You have blocked this user.');
        }

        if ($this->repository->isUserBlocked($validated['user_id'], auth()->id())) {
            return redirect()
                ->back()
                ->with('error', 'This user has blocked you.');
        }

        $conversation = $this->repository->getOrCreateDirectConversation(
            auth()->id(),
            $validated['user_id']
        );

        return redirect()->route('messaging.conversation', $conversation);
    }

    /**
     * Create group conversation.
     */
    public function createGroup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'participant_ids' => 'required|array|min:1',
            'participant_ids.*' => 'exists:users,id',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('conversation-avatars', 'public');
        }

        $conversation = $this->repository->createGroupConversation(
            $validated,
            $validated['participant_ids']
        );

        return redirect()
            ->route('messaging.conversation', $conversation)
            ->with('success', 'Group created successfully.');
    }

    /**
     * Update group.
     */
    public function updateGroup(Request $request, Conversation $conversation)
    {
        // Check if user is admin
        if (! $conversation->isUserAdmin(auth()->id())) {
            abort(403, 'Only group admins can update the group.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('conversation-avatars', 'public');
        }

        $conversation->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Group updated successfully.');
    }

    /**
     * Add participants to group.
     */
    public function addParticipants(Request $request, Conversation $conversation)
    {
        // Check if user is admin
        if (! $conversation->isUserAdmin(auth()->id())) {
            abort(403, 'Only group admins can add participants.');
        }

        $validated = $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
        ]);

        foreach ($validated['user_ids'] as $userId) {
            $conversation->addParticipant($userId);
        }

        return redirect()
            ->back()
            ->with('success', 'Participants added successfully.');
    }

    /**
     * Remove participant from group.
     */
    public function removeParticipant(Request $request, Conversation $conversation)
    {
        // Check if user is admin
        if (! $conversation->isUserAdmin(auth()->id())) {
            abort(403, 'Only group admins can remove participants.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $conversation->removeParticipant($validated['user_id']);

        return redirect()
            ->back()
            ->with('success', 'Participant removed successfully.');
    }

    /**
     * Leave group.
     */
    public function leaveGroup(Conversation $conversation)
    {
        $conversation->removeParticipant(auth()->id());

        return redirect()
            ->route('messaging.index')
            ->with('success', 'You have left the group.');
    }

    /**
     * Send message.
     */
    public function sendMessage(Request $request, Conversation $conversation)
    {
        // Check access
        if (! $conversation->hasParticipant(auth()->id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'content' => 'required_without:attachments|string',
            'type' => 'nullable|in:text,image,video,audio,file,location,announcement',
            'reply_to_id' => 'nullable|exists:messages,id',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240',
            'is_important' => 'nullable|boolean',
            'disappear_after_hours' => 'nullable|integer|min:1|max:168',
        ]);

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            $paths = [];
            foreach ($request->file('attachments') as $file) {
                $paths[] = $file->store('message-attachments', 'public');
            }
            $validated['attachments'] = $paths;
        }

        $message = $this->repository->sendMessage($conversation->id, $validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message->load(['sender', 'replyTo.sender']),
            ]);
        }

        return redirect()->back();
    }

    /**
     * Edit message.
     */
    public function editMessage(Request $request, Message $message)
    {
        // Check if user is sender
        if ($message->sender_id !== auth()->id()) {
            abort(403, 'You can only edit your own messages.');
        }

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $message->edit($validated['content']);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
            ]);
        }

        return redirect()->back();
    }

    /**
     * Delete message.
     */
    public function deleteMessage(Message $message)
    {
        // Check if user is sender or group admin
        $canDelete = $message->sender_id === auth()->id() ||
                     $message->conversation->isUserAdmin(auth()->id());

        if (! $canDelete) {
            abort(403, 'Unauthorized to delete this message.');
        }

        $message->softDelete();

        return redirect()
            ->back()
            ->with('success', 'Message deleted.');
    }

    /**
     * Pin message.
     */
    public function pinMessage(Message $message)
    {
        // Check if user is admin
        if (! $message->conversation->isUserAdmin(auth()->id())) {
            abort(403, 'Only group admins can pin messages.');
        }

        $message->pin(auth()->id());

        return redirect()->back();
    }

    /**
     * Unpin message.
     */
    public function unpinMessage(Message $message)
    {
        // Check if user is admin
        if (! $message->conversation->isUserAdmin(auth()->id())) {
            abort(403, 'Only group admins can unpin messages.');
        }

        $message->unpin();

        return redirect()->back();
    }

    /**
     * React to message.
     */
    public function reactToMessage(Request $request, Message $message)
    {
        $validated = $request->validate([
            'emoji' => 'required|string|max:10',
        ]);

        $message->addReaction(auth()->id(), $validated['emoji']);

        if ($request->expectsJson()) {
            return response()->json([
                'reactions' => $message->fresh()->reaction_counts,
            ]);
        }

        return redirect()->back();
    }

    /**
     * Remove reaction.
     */
    public function removeReaction(Request $request, Message $message)
    {
        $validated = $request->validate([
            'emoji' => 'required|string|max:10',
        ]);

        $message->removeReaction(auth()->id(), $validated['emoji']);

        if ($request->expectsJson()) {
            return response()->json([
                'reactions' => $message->fresh()->reaction_counts,
            ]);
        }

        return redirect()->back();
    }

    /**
     * Star message.
     */
    public function starMessage(Message $message)
    {
        $message->star(auth()->id());

        return redirect()->back();
    }

    /**
     * Unstar message.
     */
    public function unstarMessage(Message $message)
    {
        $message->unstar(auth()->id());

        return redirect()->back();
    }

    /**
     * Get starred messages.
     */
    public function starredMessages()
    {
        $messages = $this->repository->getStarredMessages(auth()->id());

        return view('messaging.starred', compact('messages'));
    }

    /**
     * Search messages.
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'query' => 'required|string|min:2',
            'conversation_id' => 'nullable|exists:conversations,id',
            'type' => 'nullable|in:text,image,video,audio,file,location',
            'has_attachments' => 'nullable|boolean',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
        ]);

        $results = $this->repository->searchMessages(
            auth()->id(),
            $validated['query'],
            $validated
        );

        return view('messaging.search', compact('results', 'validated'));
    }

    /**
     * Block user.
     */
    public function blockUser(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'reason' => 'nullable|string',
        ]);

        $this->repository->blockUser(
            auth()->id(),
            $validated['user_id'],
            $validated['reason'] ?? null
        );

        return redirect()
            ->back()
            ->with('success', 'User blocked successfully.');
    }

    /**
     * Unblock user.
     */
    public function unblockUser(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $this->repository->unblockUser(auth()->id(), $validated['user_id']);

        return redirect()
            ->back()
            ->with('success', 'User unblocked successfully.');
    }

    /**
     * Get blocked users.
     */
    public function blockedUsers()
    {
        $blockedUsers = $this->repository->getBlockedUsers(auth()->id());

        return view('messaging.blocked', compact('blockedUsers'));
    }

    /**
     * Report message.
     */
    public function reportMessage(Request $request, Message $message)
    {
        $validated = $request->validate([
            'reason' => 'required|in:spam,harassment,inappropriate,offensive,other',
            'description' => 'nullable|string',
        ]);

        $this->repository->reportMessage(
            $message->id,
            auth()->id(),
            $validated['reason'],
            $validated['description'] ?? null
        );

        return redirect()
            ->back()
            ->with('success', 'Message reported successfully.');
    }

    /**
     * Archive conversation.
     */
    public function archiveConversation(Conversation $conversation)
    {
        $conversation->archive();

        return redirect()
            ->back()
            ->with('success', 'Conversation archived.');
    }

    /**
     * Unarchive conversation.
     */
    public function unarchiveConversation(Conversation $conversation)
    {
        $conversation->unarchive();

        return redirect()
            ->back()
            ->with('success', 'Conversation unarchived.');
    }

    /**
     * Mark conversation as read.
     */
    public function markAsRead(Conversation $conversation)
    {
        $conversation->markAsReadForUser(auth()->id());

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back();
    }
}
