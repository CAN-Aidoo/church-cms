@extends('layouts.app')

@section('title', $conversation->name ?? 'Conversation')

@section('content')
<div class="h-[calc(100vh-theme('spacing.32'))] min-h-[600px] flex gap-6 container mx-auto px-4 py-8 max-w-7xl">
    <!-- Sidebar (Hidden on mobile when chat is active, ideally responsive toggle) -->
    <div class="hidden lg:flex w-80 lg:w-96 flex-col bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Conversations</h2>
        </div>
        <!-- Simplified List for Context -->
         <div class="flex-1 overflow-y-auto divide-y divide-slate-50">
             <!-- Ideally we'd pass $conversations here too, or use a view composer. For now, a placeholder link to back -->
             <a href="{{ route('messaging.index') }}" class="block p-4 hover:bg-slate-50 transition-colors text-center text-primary-600 font-bold text-sm">
                View All Conversations
             </a>
        </div>
    </div>

    <!-- Chat Area -->
    <div class="flex-1 flex flex-col bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden relative">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-100 bg-white z-10 flex justify-between items-center shadow-sm">
            <div class="flex items-center gap-3">
                <a href="{{ route('messaging.index') }}" class="lg:hidden p-2 -ml-2 text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </a>
                
                <div class="relative">
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
                
                <div>
                    <h1 class="text-base font-bold text-slate-900 leading-tight">{{ $conversation->name ?? 'Conversation' }}</h1>
                    @if($conversation->is_group)
                        <p class="text-xs text-slate-500">{{ $conversation->participants_count ?? 2 }} participants</p>
                    @else
                         <p class="text-xs {{ $conversation->is_online ? 'text-emerald-600 font-medium' : 'text-slate-400' }}">
                            {{ $conversation->is_online ? 'Online' : 'Offline' }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-1">
                @if($conversation->is_group && $conversation->isUserAdmin(auth()->id()))
                    <button onclick="/* Open Settings Modal */" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-lg transition-colors" title="Group Settings">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </button>
                @endif
            </div>
        </div>

        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-slate-50/30 scroll-smooth" id="messages-container">
            @forelse($messages as $message)
                <div class="flex flex-col {{ $message->sender_id === auth()->id() ? 'items-end' : 'items-start' }} group">
                    <div class="flex items-end gap-2 max-w-[85%] md:max-w-[70%]">
                        @if($message->sender_id !== auth()->id())
                            <div class="w-8 h-8 rounded-full bg-slate-200 flex-shrink-0 flex items-center justify-center text-xs font-bold text-slate-500 mb-1">
                                {{ substr($message->sender->name ?? 'U', 0, 1) }}
                            </div>
                        @endif

                        <div class="relative px-4 py-2.5 shadow-sm
                            {{ $message->sender_id === auth()->id() 
                                ? 'bg-primary-600 text-white rounded-2xl rounded-tr-sm' 
                                : 'bg-white border border-slate-100 text-slate-800 rounded-2xl rounded-tl-sm' }}">
                            
                            @if($message->type === 'image')
                                <img src="{{ asset('storage/' . $message->content) }}" class="max-w-full rounded-lg mb-1" alt="Image attachment">
                            @else
                                <p class="text-sm leading-relaxed whitespace-pre-wrap">{{ $message->content }}</p>
                            @endif

                             <span class="text-[10px] absolute -bottom-5 {{ $message->sender_id === auth()->id() ? 'right-1' : 'left-1' }} text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                {{ $message->created_at->format('M d, H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center h-full text-slate-400">
                    <p class="text-sm">No messages yet. Say hello! 👋</p>
                </div>
            @endforelse
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-white border-t border-slate-100">
            <form action="{{ route('messaging.messages.send', $conversation) }}" method="POST" enctype="multipart/form-data" class="flex items-end gap-3">
                @csrf
                <button type="button" class="p-2.5 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-xl transition-colors shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                </button>
                
                <div class="flex-1 bg-slate-50 border border-slate-200 rounded-xl focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-primary-500 transition-all">
                    <textarea 
                        name="content" 
                        rows="1" 
                        placeholder="Type a message..." 
                        class="w-full bg-transparent border-0 focus:ring-0 p-3 text-sm resize-none max-h-32 text-slate-800 placeholder:text-slate-400"
                        oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"
                        required
                    ></textarea>
                </div>
                
                <button type="submit" class="p-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl shadow-sm hover:shadow-md transition-all shrink-0">
                    <svg class="w-6 h-6 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Auto-scroll to bottom
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;
</script>
@endsection
