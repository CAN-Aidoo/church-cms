@extends('layouts.mobile')

@section('title', 'Conversation - Church App')
@section('header', 'Conversation')

@section('content')
<div class="flex flex-col h-screen bg-gray-50">
    <!-- Messages Container -->
    <div id="messagesContainer" class="flex-1 overflow-y-auto p-4 space-y-3">
        <div class="text-center py-12 text-gray-500">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <p>Loading messages...</p>
        </div>
    </div>

    <!-- Message Input -->
    <div class="bg-white border-t border-gray-200 p-4 pb-safe">
        <form id="messageForm" class="flex gap-2">
            <input type="text" id="messageInput" placeholder="Type a message..." required class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-600 text-white p-3 rounded-xl hover:bg-blue-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const conversationId = {{ $conversationId }};
    let messages = [];

    async function loadMessages() {
        try {
            const response = await fetch(`${window.API_BASE_URL}/messaging/conversations/${conversationId}/messages`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Failed to fetch messages');

            const data = await response.json();
            messages = data.messages || [];
            renderMessages();
            markAsRead();

        } catch (error) {
            console.error('Error loading messages:', error);
        }
    }

    function renderMessages() {
        const container = document.getElementById('messagesContainer');

        if (messages.length === 0) {
            container.innerHTML = `
                <div class="text-center py-12">
                    <p class="text-gray-500">No messages yet. Start the conversation!</p>
                </div>
            `;
            return;
        }

        container.innerHTML = messages.map(msg => {
            const isOwn = msg.is_own;
            const date = new Date(msg.created_at);
            const time = date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });

            return `
                <div class="flex ${isOwn ? 'justify-end' : 'justify-start'}">
                    <div class="max-w-[75%]">
                        ${!isOwn ? `<p class="text-xs text-gray-500 mb-1 px-2">${msg.sender_name}</p>` : ''}
                        <div class="${isOwn ? 'bg-blue-600 text-white' : 'bg-white border border-gray-200 text-gray-900'} rounded-2xl px-4 py-3 shadow-sm">
                            <p class="text-sm">${msg.message}</p>
                        </div>
                        <p class="text-xs text-gray-400 mt-1 px-2">${time}</p>
                    </div>
                </div>
            `;
        }).join('');

        // Scroll to bottom
        container.scrollTop = container.scrollHeight;
    }

    async function sendMessage(message) {
        try {
            const response = await fetch(`${window.API_BASE_URL}/messaging/conversations/${conversationId}/messages`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin',
                body: JSON.stringify({ message })
            });

            if (!response.ok) throw new Error('Failed to send message');

            await loadMessages();

        } catch (error) {
            console.error('Error sending message:', error);
            alert('Failed to send message');
        }
    }

    async function markAsRead() {
        try {
            await fetch(`${window.API_BASE_URL}/messaging/conversations/${conversationId}/mark-read`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin'
            });
        } catch (error) {
            console.error('Error marking as read:', error);
        }
    }

    document.getElementById('messageForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const input = document.getElementById('messageInput');
        const message = input.value.trim();

        if (!message) return;

        input.value = '';
        await sendMessage(message);
    });

    document.addEventListener('DOMContentLoaded', () => {
        loadMessages();
        // Poll for new messages every 5 seconds
        setInterval(loadMessages, 5000);
    });
</script>
@endpush
