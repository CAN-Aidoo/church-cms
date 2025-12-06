@extends('layouts.app')

@section('title', 'Conversation')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-900 tracking-tight">{{ $conversation->name ?? 'Conversation' }}</h1>
        <a href="{{ route('messaging.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Back</a>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 h-[600px] flex flex-col">
        {{-- Messages Area --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50">
            @foreach($messages as $message)
                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[70%] {{ $message->sender_id === auth()->id() ? 'bg-primary-600 text-white rounded-br-none' : 'bg-white text-gray-800 border border-gray-200 rounded-bl-none' }} p-3 rounded-2xl shadow-sm">
                        <p class="text-sm">{{ $message->content }}</p>
                        <span class="text-[10px] {{ $message->sender_id === auth()->id() ? 'text-primary-100' : 'text-gray-400' }} block mt-1 text-right">
                            {{ $message->created_at->format('H:i') }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Input Area --}}
        <div class="p-4 border-t border-gray-100 bg-white">
            <form action="{{ route('messaging.messages.send', $conversation) }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" name="content" placeholder="Type a message..." class="flex-1 rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
            </form>
        </div>
    </div>
@endsection
