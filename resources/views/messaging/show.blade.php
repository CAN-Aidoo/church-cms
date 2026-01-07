@extends('layouts.app')

@section('title', 'Conversation Details')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Header -->
    <div class="flex items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Conversation Details</h1>
            <p class="text-slate-600">Info, settings, and media for this chat.</p>
        </div>
        <a href="{{ route('messaging.conversation', $conversation) }}" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-all font-bold text-sm shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Chat
        </a>
    </div>

    <div class="space-y-6">
        <!-- Overview Card -->
        <div class="card border border-slate-100 shadow-sm overflow-hidden p-8 text-center bg-white relative">
            <div class="absolute top-0 right-0 w-32 h-32 bg-slate-50 rounded-bl-full -mr-8 -mt-8 opacity-50 pointer-events-none"></div>
            
            <div class="relative z-10 font-bold mb-6">
                 @if($conversation->is_group && $conversation->avatar)
                    <img src="{{ asset('storage/' . $conversation->avatar) }}" alt="{{ $conversation->name }}" class="w-24 h-24 rounded-2xl mx-auto mb-4 object-cover shadow-sm border border-slate-200">
                @else
                    <div class="w-24 h-24 rounded-2xl mx-auto mb-4 bg-slate-100 flex items-center justify-center text-slate-500 text-4xl font-bold border border-slate-200">
                        {{ strtoupper(substr($conversation->name ?? 'U', 0, 1)) }}
                    </div>
                @endif
                
                <h2 class="text-2xl font-bold text-slate-800 mb-1">{{ $conversation->name ?? 'Direct Message' }}</h2>
                @if($conversation->is_group)
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-wide">{{ $conversation->participants_count ?? 0 }} Participants</p>
                    @if($conversation->description)
                        <p class="text-slate-600 mt-4 max-w-lg mx-auto">{{ $conversation->description }}</p>
                    @endif
                @else
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-wide">Direct Conversation</p>
                @endif
            </div>

            <div class="flex justify-center gap-3">
                 @if($conversation->is_group && $conversation->isUserAdmin(auth()->id()))
                    <a href="{{ route('messaging.edit', $conversation) }}" class="px-5 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all font-bold text-sm shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Group Settings
                    </a>
                @endif
                <button onclick="document.getElementById('searchModal').classList.remove('hidden')" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-all font-bold text-sm shadow-sm flex items-center gap-2">
                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    Search Messages
                </button>
            </div>
        </div>

        <!-- Participants Card (Group Only) -->
        @if($conversation->is_group)
        <div class="card border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 text-base">Participants</h3>
                 <a href="{{ route('messaging.edit', $conversation) }}" class="text-xs font-bold text-primary-600 hover:text-primary-700">View All</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-6">
                 @foreach($conversation->participants->take(6) as $participant)
                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold border border-slate-200">
                        {{ substr($participant->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-800 truncate">{{ $participant->user->name }}</p>
                        <p class="text-[10px] uppercase tracking-wide text-slate-500">{{ $participant->is_admin ? 'Admin' : 'Member' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Media Stats -->
        <div class="grid grid-cols-3 gap-6">
            <div class="card p-6 border border-slate-100 text-center hover:shadow-md transition-shadow">
                <span class="inline-block p-3 rounded-full bg-blue-50 text-blue-600 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </span>
                <h3 class="text-2xl font-bold text-slate-800">{{ $mediaCount['images'] ?? 0 }}</h3>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Photos</p>
            </div>
            <div class="card p-6 border border-slate-100 text-center hover:shadow-md transition-shadow">
                <span class="inline-block p-3 rounded-full bg-purple-50 text-purple-600 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                </span>
                <h3 class="text-2xl font-bold text-slate-800">{{ $mediaCount['videos'] ?? 0 }}</h3>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Videos</p>
            </div>
            <div class="card p-6 border border-slate-100 text-center hover:shadow-md transition-shadow">
                 <span class="inline-block p-3 rounded-full bg-emerald-50 text-emerald-600 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </span>
                <h3 class="text-2xl font-bold text-slate-800">{{ $mediaCount['files'] ?? 0 }}</h3>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Files</p>
            </div>
        </div>

        <!-- Danger Zone / Actions -->
        <div class="card border border-slate-100 shadow-sm overflow-hidden">
             <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Options</h3>
            </div>
            <div class="divide-y divide-slate-100">
                <!-- Notifications Toggle -->
                <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                     <span class="text-sm font-bold text-slate-700">Mute Notifications</span>
                     <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                     </label>
                </div>
                 <!-- Archive -->
                 @if($conversation->is_archived)
                    <form action="{{ route('messaging.unarchive', $conversation) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left p-4 text-sm font-bold text-slate-700 hover:bg-slate-50 transition-colors">Unarchive Chat</button>
                    </form>
                @else
                     <form action="{{ route('messaging.archive', $conversation) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left p-4 text-sm font-bold text-slate-700 hover:bg-slate-50 transition-colors">Archive Chat</button>
                    </form>
                @endif
                
                <!-- Block User (Direct) -->
                 @if(!$conversation->is_group)
                    <button onclick="document.getElementById('blockUserModal').classList.remove('hidden')" class="w-full text-left p-4 text-sm font-bold text-rose-600 hover:bg-rose-50 transition-colors">Block User</button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Search Modal -->
<div id="searchModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden">
        <div class="p-4 border-b border-slate-100 bg-slate-50">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                <input type="text" placeholder="Search in conversation..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:border-primary-500 focus:ring-primary-500">
            </div>
        </div>
        <div class="p-8 text-center" id="searchResults">
            <p class="text-sm text-slate-400">Enter a keyword to search messages.</p>
        </div>
        <div class="p-3 bg-slate-50 border-t border-slate-100 text-right">
            <button onclick="document.getElementById('searchModal').classList.add('hidden')" class="text-xs font-bold text-slate-500 hover:text-slate-700">Close</button>
        </div>
    </div>
</div>

<!-- Block User Modal -->
@if(!$conversation->is_group)
<div id="blockUserModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm overflow-hidden text-center">
        <div class="p-6">
            <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Block this user?</h3>
            <p class="text-sm text-slate-500 mb-6">They will not be able to message you or see your online status. This conversation will be archived.</p>
            
            <form action="{{ route('messaging.block-user') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ $conversation->participants->firstWhere('user_id', '!=', auth()->id())->user_id ?? '' }}">
                <div class="flex gap-3 justify-center">
                    <button type="button" onclick="document.getElementById('blockUserModal').classList.add('hidden')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 font-bold text-sm hover:bg-slate-50">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 font-bold text-sm shadow-sm">Confirm Block</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
