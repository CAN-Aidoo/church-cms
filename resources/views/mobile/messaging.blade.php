@extends('layouts.mobile')

@section('title', 'Messages - Church App')
@section('header', 'Messages')

@section('header-actions')
<button onclick="showNewConversationModal()" class="p-2 rounded-full hover:bg-white/10">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
    </svg>
</button>
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Search -->
    <div class="px-4 py-3 bg-white border-b border-gray-200">
        <input type="text" id="searchInput" placeholder="Search conversations..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Conversations List -->
    <div class="divide-y divide-gray-200">
        <div id="conversationsList">
            <div class="text-center py-12 text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <p>Loading conversations...</p>
            </div>
        </div>
    </div>
</div>

<!-- New Conversation Modal -->
<div id="newConversationModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full">
        <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900">New Conversation</h3>
            <button onclick="closeNewConversationModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="newConversationForm" class="p-6 space-y-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Select Member</label>
                <select id="memberSelect" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Loading members...</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Message</label>
                <textarea id="initialMessage" rows="4" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-3 px-6 rounded-lg hover:from-blue-700 hover:to-blue-800 transition">
                Start Conversation
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // HTML escape helper to prevent XSS
    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        const div = document.createElement('div');
        div.textContent = String(text);
        return div.innerHTML;
    }

    let conversations = [];

    async function loadConversations() {
        try {
            const response = await fetch(`${window.API_BASE_URL}/messaging/conversations`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                if (response.status === 401) {
                    window.location.href = '/mobile/login';
                    return;
                }
                throw new Error('Failed to fetch conversations');
            }

            const data = await response.json();
            conversations = data.conversations || [];
            renderConversations();

        } catch (error) {
            console.error('Error loading conversations:', error);
            showError();
        }
    }

    function renderConversations() {
        const container = document.getElementById('conversationsList');

        if (conversations.length === 0) {
            container.innerHTML = `
                <div class="text-center py-12 px-4">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <p class="text-gray-500 font-medium">No conversations yet</p>
                    <p class="text-sm text-gray-400 mt-2">Start a conversation with a church member</p>
                    <button onclick="showNewConversationModal()" class="mt-4 text-blue-600 font-medium text-sm">
                        New Conversation →
                    </button>
                </div>
            `;
            return;
        }

        container.innerHTML = conversations.map(conv => {
            const date = new Date(conv.last_message_at || conv.created_at);
            const timeAgo = formatTimeAgo(date);
            const unreadBadge = conv.unread_count > 0 ? `
                <span class="bg-blue-600 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">
                    ${conv.unread_count}
                </span>
            ` : '';

            return `
                <a href="{{ url('/mobile/messaging') }}/${conv.id}" class="block bg-white px-4 py-4 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                            ${conv.name ? escapeHtml(conv.name.charAt(0).toUpperCase()) : 'C'}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="font-semibold text-gray-900 truncate">${escapeHtml(conv.name) || 'Conversation'}</h4>
                                <span class="text-xs text-gray-500 flex-shrink-0">${timeAgo}</span>
                            </div>
                            <p class="text-sm text-gray-600 truncate">${escapeHtml(conv.last_message) || 'No messages yet'}</p>
                        </div>
                        ${unreadBadge}
                    </div>
                </a>
            `;
        }).join('');
    }

    function formatTimeAgo(date) {
        const seconds = Math.floor((new Date() - date) / 1000);
        if (seconds < 60) return 'Just now';
        const minutes = Math.floor(seconds / 60);
        if (minutes < 60) return `${minutes}m ago`;
        const hours = Math.floor(minutes / 60);
        if (hours < 24) return `${hours}h ago`;
        const days = Math.floor(hours / 24);
        if (days < 7) return `${days}d ago`;
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    }

    function showNewConversationModal() {
        document.getElementById('newConversationModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        loadMembers();
    }

    function closeNewConversationModal() {
        document.getElementById('newConversationModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    async function loadMembers() {
        // This would load available members to message
        document.getElementById('memberSelect').innerHTML = '<option value="">Select a member...</option>';
    }

    function showError() {
        document.getElementById('conversationsList').innerHTML = `
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-gray-700 font-medium">Failed to load conversations</p>
                <button onclick="loadConversations()" class="mt-4 text-blue-600 font-medium text-sm hover:underline">
                    Try Again
                </button>
            </div>
        `;
    }

    document.addEventListener('DOMContentLoaded', loadConversations);
</script>
@endpush
