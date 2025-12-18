@extends('layouts.app')

@section('title', 'Conversation Details')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Conversation Details</h1>
        <a href="{{ route('messaging.conversation', $conversation) }}" class="text-sm text-gray-500 hover:text-gray-700">Back to Chat</a>
    </div>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Conversation Info Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8 text-center border-b border-gray-100">
                @if($conversation->type === 'group' && $conversation->avatar)
                    <img src="{{ asset('storage/' . $conversation->avatar) }}"
                         alt="{{ $conversation->name }}"
                         class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-primary-100 object-cover">
                @else
                    <div class="w-24 h-24 rounded-full mx-auto mb-4 bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-3xl font-bold">
                        @if($conversation->type === 'direct')
                            {{ strtoupper(substr($conversation->otherParticipant(auth()->id())->name, 0, 1)) }}
                        @else
                            {{ strtoupper(substr($conversation->name, 0, 1)) }}
                        @endif
                    </div>
                @endif

                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    @if($conversation->type === 'direct')
                        {{ $conversation->otherParticipant(auth()->id())->name }}
                    @else
                        {{ $conversation->name }}
                    @endif
                </h2>

                @if($conversation->type === 'group')
                    <p class="text-gray-600 mb-1">{{ $conversation->participants->count() }} participants</p>
                    @if($conversation->description)
                        <p class="text-sm text-gray-500 max-w-md mx-auto">{{ $conversation->description }}</p>
                    @endif
                @else
                    <p class="text-sm text-gray-500">Direct Conversation</p>
                @endif

                <div class="flex justify-center gap-3 mt-6">
                    @if($conversation->type === 'group' && $conversation->isUserAdmin(auth()->id()))
                        <a href="{{ route('messaging.edit', $conversation) }}"
                           class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                            </svg>
                            Edit Group
                        </a>
                    @endif

                    <button onclick="document.getElementById('searchModal').classList.remove('hidden')"
                            class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                        </svg>
                        Search Messages
                    </button>
                </div>
            </div>
        </div>

        <!-- Media & Files -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Media & Files</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-2xl font-bold text-gray-900">{{ $mediaCount['images'] ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Photos</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-2xl font-bold text-gray-900">{{ $mediaCount['files'] ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Files</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-2xl font-bold text-gray-900">{{ $mediaCount['videos'] ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Videos</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Participants (Group Only) -->
        @if($conversation->type === 'group')
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">
                    Participants ({{ $conversation->participants->count() }})
                </h3>
                @if($conversation->isUserAdmin(auth()->id()))
                    <a href="{{ route('messaging.edit', $conversation) }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                        Manage
                    </a>
                @endif
            </div>
            <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                @foreach($conversation->participants->sortByDesc(fn($p) => $p->is_admin)->take(10) as $participant)
                <div class="p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($participant->user->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ $participant->user->name }}
                            @if($participant->user_id === auth()->id())
                                <span class="text-xs text-gray-500">(You)</span>
                            @endif
                        </p>
                        <p class="text-xs text-gray-500">
                            @if($participant->is_admin)
                                <span class="text-primary-600 font-medium">Admin</span>
                            @else
                                Member
                            @endif
                        </p>
                    </div>
                </div>
                @endforeach
                @if($conversation->participants->count() > 10)
                <div class="p-4 text-center">
                    <a href="{{ route('messaging.edit', $conversation) }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                        View all {{ $conversation->participants->count() }} participants
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Conversation Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Settings</h3>
            </div>
            <div class="divide-y divide-gray-100">
                <!-- Notifications -->
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Notifications</p>
                            <p class="text-xs text-gray-500">Receive notifications for new messages</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                    </label>
                </div>

                <!-- Archive -->
                <div class="p-4">
                    @if($conversation->is_archived)
                    <form action="{{ route('messaging.unarchive', $conversation) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 text-left hover:bg-gray-50 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                                <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Unarchive Conversation</p>
                                <p class="text-xs text-gray-500">Move back to active conversations</p>
                            </div>
                        </button>
                    </form>
                    @else
                    <form action="{{ route('messaging.archive', $conversation) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 text-left hover:bg-gray-50 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                                <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Archive Conversation</p>
                                <p class="text-xs text-gray-500">Hide from main inbox</p>
                            </div>
                        </button>
                    </form>
                    @endif
                </div>

                <!-- Block/Report (Direct Only) -->
                @if($conversation->type === 'direct')
                <div class="p-4">
                    <button onclick="document.getElementById('blockModal').classList.remove('hidden')"
                            class="w-full flex items-center gap-3 text-left hover:bg-red-50 p-2 rounded-lg transition-colors text-red-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium">Block User</p>
                            <p class="text-xs text-red-500">Prevent this user from messaging you</p>
                        </div>
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Search Modal -->
    <div id="searchModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Search Messages</h3>
                    <button onclick="document.getElementById('searchModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
                <input type="text"
                       placeholder="Search in this conversation..."
                       class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
            </div>
            <div class="p-6 max-h-96 overflow-y-auto">
                <p class="text-sm text-gray-500 text-center py-8">Type to search messages in this conversation</p>
            </div>
        </div>
    </div>

    <!-- Block User Modal (Direct Only) -->
    @if($conversation->type === 'direct')
    <div id="blockModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Block User</h3>
            </div>
            <form action="{{ route('messaging.block-user') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ $conversation->otherParticipant(auth()->id())->id }}">
                <div class="p-6">
                    <p class="text-sm text-gray-700 mb-4">
                        Are you sure you want to block <strong>{{ $conversation->otherParticipant(auth()->id())->name }}</strong>?
                        They won't be able to send you messages or see when you're online.
                    </p>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Reason (Optional)
                        </label>
                        <textarea name="reason"
                                  rows="3"
                                  class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                                  placeholder="Why are you blocking this user?"></textarea>
                    </div>
                </div>
                <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button"
                            onclick="document.getElementById('blockModal').classList.add('hidden')"
                            class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium shadow-sm">
                        Block User
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
@endsection
