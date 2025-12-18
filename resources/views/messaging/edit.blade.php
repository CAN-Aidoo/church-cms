@extends('layouts.app')

@section('title', 'Edit Group')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Group</h1>
        <a href="{{ route('messaging.conversation', $conversation) }}" class="text-sm text-gray-500 hover:text-gray-700">Back to Chat</a>
    </div>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Only Group Admins Can Edit -->
        @if(!$conversation->isUserAdmin(auth()->id()))
        <div class="alert-warning mb-6">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <span>Only group administrators can edit group details.</span>
        </div>
        @endif

        <!-- Group Details Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="p-6 bg-gradient-to-r from-primary-50 to-blue-50 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Group Details</h3>
                <p class="text-sm text-gray-600 mt-1">Update group name, description, and avatar</p>
            </div>

            <form action="{{ route('messaging.update-group', $conversation) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Current Avatar Preview -->
                @if($conversation->avatar)
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-gray-200">
                        <img src="{{ asset('storage/' . $conversation->avatar) }}" alt="{{ $conversation->name }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Current Avatar</p>
                        <p class="text-xs text-gray-500">Upload a new image to replace</p>
                    </div>
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Group Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           required
                           value="{{ old('name', $conversation->name) }}"
                           {{ !$conversation->isUserAdmin(auth()->id()) ? 'readonly' : '' }}
                           class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror"
                           placeholder="e.g., Youth Leaders, Choir Team">
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Description <span class="text-gray-500 text-xs">(Optional)</span>
                    </label>
                    <textarea name="description"
                              rows="3"
                              {{ !$conversation->isUserAdmin(auth()->id()) ? 'readonly' : '' }}
                              class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                              placeholder="Brief description of the group's purpose...">{{ old('description', $conversation->description) }}</textarea>
                </div>

                @if($conversation->isUserAdmin(auth()->id()))
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Update Avatar <span class="text-gray-500 text-xs">(Optional)</span>
                    </label>
                    <input type="file"
                           name="avatar"
                           accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    <p class="text-xs text-gray-500 mt-1">PNG, JPG or GIF (max 2MB)</p>
                    @error('avatar')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('messaging.conversation', $conversation) }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium shadow-sm">
                        <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z"/>
                        </svg>
                        Update Group
                    </button>
                </div>
                @endif
            </form>
        </div>

        <!-- Manage Participants -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-primary-50 to-blue-50 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Participants</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $conversation->participants->count() }} member{{ $conversation->participants->count() != 1 ? 's' : '' }}</p>
                    </div>
                    @if($conversation->isUserAdmin(auth()->id()))
                    <button onclick="document.getElementById('addParticipantsModal').classList.remove('hidden')"
                            class="px-4 py-2 bg-white text-primary-600 border border-primary-600 rounded-lg hover:bg-primary-50 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                        </svg>
                        Add Participants
                    </button>
                    @endif
                </div>
            </div>

            <div class="divide-y divide-gray-100">
                @foreach($conversation->participants->sortByDesc(fn($p) => $p->is_admin) as $participant)
                <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr($participant->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $participant->user->name }}
                                @if($participant->user_id === auth()->id())
                                    <span class="text-xs text-gray-500">(You)</span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-500">
                                @if($participant->is_admin)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-primary-100 text-primary-800">
                                        Admin
                                    </span>
                                @else
                                    Member
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($conversation->isUserAdmin(auth()->id()) && $participant->user_id !== auth()->id())
                    <form action="{{ route('messaging.remove-participant', $conversation) }}" method="POST" onsubmit="return confirm('Remove this participant from the group?')">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $participant->user_id }}">
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </form>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Leave Group Button (if not admin) -->
        @if(!$conversation->isUserAdmin(auth()->id()))
        <div class="mt-6">
            <form action="{{ route('messaging.leave-group', $conversation) }}" method="POST" onsubmit="return confirm('Are you sure you want to leave this group?')">
                @csrf
                <button type="submit" class="w-full px-4 py-3 bg-red-50 text-red-600 border border-red-200 rounded-lg hover:bg-red-100 transition-colors font-medium">
                    <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                    </svg>
                    Leave Group
                </button>
            </form>
        </div>
        @endif
    </div>

    <!-- Add Participants Modal -->
    @if($conversation->isUserAdmin(auth()->id()))
    <div id="addParticipantsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full max-h-[80vh] overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Add Participants</h3>
                    <button onclick="document.getElementById('addParticipantsModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>

            <form action="{{ route('messaging.add-participants', $conversation) }}" method="POST">
                @csrf
                <div class="p-6 overflow-y-auto max-h-96">
                    <div class="space-y-2">
                        @foreach($availableMembers as $member)
                            <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
                                <input type="checkbox"
                                       name="user_ids[]"
                                       value="{{ $member->user_id }}"
                                       class="form-checkbox text-primary-600 rounded">
                                <div class="ml-3 flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-xs font-semibold">
                                        {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                                    </div>
                                    <div class="ml-2">
                                        <p class="text-sm font-medium text-gray-900">{{ $member->first_name }} {{ $member->last_name }}</p>
                                        <p class="text-xs text-gray-500">{{ ucfirst($member->role ?? 'Member') }}</p>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button"
                            onclick="document.getElementById('addParticipantsModal').classList.add('hidden')"
                            class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium shadow-sm">
                        Add Selected
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
@endsection
