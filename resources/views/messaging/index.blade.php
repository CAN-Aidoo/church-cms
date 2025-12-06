@extends('layouts.app')

@section('title', 'Messaging')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Messaging</h1>
        <div class="flex gap-2">
            <button class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm">
                New Message
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 h-[600px] flex overflow-hidden">
        {{-- Sidebar --}}
        <div class="w-1/3 border-r border-gray-100 flex flex-col">
            <div class="p-4 border-b border-gray-100 bg-gray-50">
                <input type="text" placeholder="Search conversations..." class="w-full rounded-lg border-gray-300 text-sm focus:ring-primary-500 focus:border-primary-500">
            </div>
            <div class="flex-1 overflow-y-auto">
                @forelse($conversations as $conversation)
                    <a href="{{ route('messaging.conversation', $conversation) }}" class="block p-4 hover:bg-gray-50 border-b border-gray-50 transition-colors {{ request()->route('conversation')?->id === $conversation->id ? 'bg-blue-50' : '' }}">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="text-sm font-semibold text-gray-900 truncate">{{ $conversation->name ?? 'Direct Message' }}</h4>
                            <span class="text-xs text-gray-400">{{ $conversation->updated_at->format('M d') }}</span>
                        </div>
                        <p class="text-xs text-gray-500 truncate">{{ $conversation->last_message_content ?? 'No messages yet' }}</p>
                    </a>
                @empty
                    <div class="p-8 text-center text-gray-500 text-sm">No conversations found.</div>
                @endforelse
            </div>
        </div>

        {{-- Main Area --}}
        <div class="flex-1 flex items-center justify-center bg-gray-50">
            <div class="text-center text-gray-500">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                <p class="text-lg font-medium">Select a conversation</p>
                <p class="text-sm mt-1">Or start a new one</p>
            </div>
        </div>
    </div>
@endsection
