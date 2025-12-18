@extends('layouts.app')

@section('title', 'Start New Conversation')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Start New Conversation</h1>
        <a href="{{ route('messaging.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
    </div>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto" x-data="{ conversationType: 'direct' }">
        <!-- Conversation Type Selector -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Conversation Type</h3>
            <div class="grid grid-cols-2 gap-4">
                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all"
                       :class="conversationType === 'direct' ? 'border-primary-500 bg-primary-50' : 'border-gray-200 hover:border-gray-300'">
                    <input type="radio" name="type" value="direct" x-model="conversationType" class="form-radio text-primary-600">
                    <div class="ml-3">
                        <p class="font-medium text-gray-900">Direct Message</p>
                        <p class="text-xs text-gray-500">One-on-one conversation</p>
                    </div>
                </label>
                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all"
                       :class="conversationType === 'group' ? 'border-primary-500 bg-primary-50' : 'border-gray-200 hover:border-gray-300'">
                    <input type="radio" name="type" value="group" x-model="conversationType" class="form-radio text-primary-600">
                    <div class="ml-3">
                        <p class="font-medium text-gray-900">Group Chat</p>
                        <p class="text-xs text-gray-500">Multiple participants</p>
                    </div>
                </label>
            </div>
        </div>

        <!-- Direct Message Form -->
        <div x-show="conversationType === 'direct'" x-cloak>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('messaging.start-direct') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Select Recipient <span class="text-red-500">*</span>
                        </label>
                        <select name="user_id" required class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Choose a member...</option>
                            @foreach($members as $member)
                                <option value="{{ $member->user_id }}">
                                    {{ $member->first_name }} {{ $member->last_name }}
                                    @if($member->role) ({{ ucfirst($member->role) }}) @endif
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Start a private conversation with another member</p>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('messaging.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium shadow-sm">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                            </svg>
                            Start Conversation
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Group Chat Form -->
        <div x-show="conversationType === 'group'" x-cloak>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('messaging.create-group') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Group Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               required
                               value="{{ old('name') }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500"
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
                                  class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                                  placeholder="Brief description of the group's purpose...">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Group Avatar <span class="text-gray-500 text-xs">(Optional)</span>
                        </label>
                        <input type="file"
                               name="avatar"
                               accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG or GIF (max 2MB)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Add Participants <span class="text-red-500">*</span>
                        </label>
                        <div class="border border-gray-300 rounded-lg p-3 max-h-64 overflow-y-auto">
                            @foreach($members as $member)
                                <label class="flex items-center py-2 hover:bg-gray-50 px-2 rounded cursor-pointer">
                                    <input type="checkbox"
                                           name="participant_ids[]"
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
                        <p class="text-xs text-gray-500 mt-2">Select at least one participant</p>
                        @error('participant_ids')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('messaging.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium shadow-sm">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                            </svg>
                            Create Group
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
    [x-cloak] { display: none !important; }
    </style>
@endsection
