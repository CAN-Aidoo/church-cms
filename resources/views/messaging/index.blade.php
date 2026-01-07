@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div class="h-[calc(100vh-theme('spacing.32'))] min-h-[600px] flex gap-6 container mx-auto px-4 py-8 max-w-7xl">
    <!-- Sidebar -->
    <div class="w-full md:w-80 lg:w-96 flex flex-col bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <!-- Header & Search -->
        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-xl font-bold text-slate-800">Messages</h1>
                <div class="flex gap-2">
                    <button class="p-2 text-slate-400 hover:text-primary-600 hover:bg-white rounded-lg transition-all" title="New Group" onclick="window.location.href='{{ route('messaging.start-group') }}'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </button>
                    <button class="p-2 text-slate-400 hover:text-primary-600 hover:bg-white rounded-lg transition-all" title="New Direct Message" onclick="window.location.href='{{ route('messaging.start-direct') }}'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </button>
                </div>
            </div>
            
            <form action="{{ route('messaging.index') }}" method="GET" class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search messages..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:border-primary-500 focus:ring-primary-500 transition-shadow">
            </form>
        </div>

        <!-- Conversation List -->
        <div class="flex-1 overflow-y-auto divide-y divide-slate-50">
            @forelse($conversations as $conversation)
                <a href="{{ route('messaging.conversation', $conversation) }}" class="block p-4 hover:bg-slate-50 transition-colors relative group {{ request()->route('conversation')?->id === $conversation->id ? 'bg-primary-50/50 hover:bg-primary-50 border-r-2 border-primary-500' : '' }}">
                    <div class="flex items-start gap-3">
                        <!-- Avatar -->
                        <div class="relative flex-shrink-0">
                            @if($conversation->is_group)
                                <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold border border-indigo-200">
                                    {{ substr($conversation->name, 0, 1) }}
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold border border-slate-200">
                                    {{ substr($conversation->name ?? 'U', 0, 1) }}
                                </div>
                                @if($conversation->is_online)
                                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></span>
                                @endif
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-0.5">
                                <h4 class="text-sm font-bold text-slate-800 truncate pr-2 {{ $conversation->unread_count > 0 ? 'text-slate-900' : '' }}">
                                    {{ $conversation->name }}
                                </h4>
                                <span class="text-[10px] text-slate-400 flex-shrink-0">{{ $conversation->updated_at->diffForHumans(null, true, true) }}</span>
                            </div>
                            <p class="text-xs truncate {{ $conversation->unread_count > 0 ? 'text-slate-800 font-semibold' : 'text-slate-500' }}">
                                @if($conversation->last_message_sender_id === auth()->id())
                                    <span class="text-slate-400">You:</span>
                                @endif
                                {{ $conversation->last_message_content ?? 'Started a conversation' }}
                            </p>
                        </div>
                    </div>

                    @if($conversation->unread_count > 0)
                        <span class="absolute top-1/2 -translate-y-1/2 right-4 w-5 h-5 bg-primary-600 text-white text-[10px] font-bold flex items-center justify-center rounded-full shadow-sm">
                            {{ $conversation->unread_count }}
                        </span>
                    @endif
                </a>
            @empty
                <div class="p-8 text-center">
                    <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                    </div>
                    <p class="text-sm text-slate-500 font-medium">No messages yet.</p>
                    <button onclick="window.location.href='{{ route('messaging.start-direct') }}'" class="mt-2 text-xs font-bold text-primary-600 hover:text-primary-700">Start new chat</button>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Empty State / Placeholder for Desktop -->
    <div class="hidden md:flex flex-1 bg-slate-50 rounded-2xl border border-slate-200 border-dashed flex-col items-center justify-center text-center p-8">
        <div class="w-24 h-24 bg-white rounded-full shadow-sm flex items-center justify-center mb-6">
            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
        </div>
        <h2 class="text-xl font-bold text-slate-800 mb-2">Select a Conversation</h2>
        <p class="text-slate-500 max-w-sm mx-auto mb-8">Choose a chat from the sidebar or start a new conversation to connect with members and groups.</p>
        
        <div class="flex gap-4">
             <a href="{{ route('messaging.start-direct') }}" class="px-6 py-2.5 bg-white text-slate-700 border border-slate-200 hover:border-primary-300 hover:text-primary-700 rounded-lg font-bold text-sm transition-all shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                Direct Message
            </a>
            <a href="{{ route('messaging.start-group') }}" class="px-6 py-2.5 bg-primary-600 text-white hover:bg-primary-700 rounded-lg font-bold text-sm transition-all shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                Create Group
            </a>
        </div>
    </div>
</div>
@endsection
