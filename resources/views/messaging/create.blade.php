@extends('layouts.app')

@section('title', 'Start New Conversation')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Header -->
    <div class="flex items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">New Message</h1>
            <p class="text-slate-600">Start meeting or chatting with the community.</p>
        </div>
        <a href="{{ route('messaging.index') }}" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-all font-bold text-sm shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Messages
        </a>
    </div>

    <div x-data="{ conversationType: '{{ request('type', 'direct') }}' }" class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Type Selection Sidebar -->
        <div class="space-y-4">
             <div 
                @click="conversationType = 'direct'"
                class="card p-4 border cursor-pointer transition-all duration-200 group relative overflow-hidden"
                :class="conversationType === 'direct' ? 'border-primary-500 bg-primary-50 ring-1 ring-primary-500' : 'border-slate-200 hover:border-primary-200 hover:shadow-md bg-white'"
            >
                <div class="relative z-10 flex flex-col items-center text-center p-2">
                    <div class="w-12 h-12 rounded-full mb-3 flex items-center justify-center transition-colors"
                         :class="conversationType === 'direct' ? 'bg-primary-100 text-primary-600' : 'bg-slate-100 text-slate-500 group-hover:bg-primary-50 group-hover:text-primary-500'">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-1">Direct Message</h3>
                    <p class="text-xs text-slate-500">Private one-on-one chat with a member.</p>
                </div>
            </div>

            <div 
                @click="conversationType = 'group'"
                class="card p-4 border cursor-pointer transition-all duration-200 group relative overflow-hidden"
                :class="conversationType === 'group' ? 'border-primary-500 bg-primary-50 ring-1 ring-primary-500' : 'border-slate-200 hover:border-primary-200 hover:shadow-md bg-white'"
            >
                <div class="relative z-10 flex flex-col items-center text-center p-2">
                    <div class="w-12 h-12 rounded-full mb-3 flex items-center justify-center transition-colors"
                         :class="conversationType === 'group' ? 'bg-primary-100 text-primary-600' : 'bg-slate-100 text-slate-500 group-hover:bg-primary-50 group-hover:text-primary-500'">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-1">Group Chat</h3>
                    <p class="text-xs text-slate-500">Collaborate with multiple people.</p>
                </div>
            </div>
        </div>

        <!-- forms -->
        <div class="md:col-span-2">
            <!-- Direct Message Form -->
            <div x-show="conversationType === 'direct'" x-cloak class="transition-all duration-300">
                <div class="card border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 text-base">New Conversation</h3>
                    </div>
                    <form action="{{ route('messaging.start-direct') }}" method="POST" class="p-6">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Select Member to Chat With</label>
                            <select name="user_id" required class="form-select w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="">Search or select a member...</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->user_id }}">
                                        {{ $member->first_name }} {{ $member->last_name }} ({{ ucfirst($member->role ?? 'Member') }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-slate-400 mt-2">Only members who have not blocked you will appear here.</p>
                        </div>
                        
                         <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                             <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all font-bold text-sm shadow-md hover:shadow-lg transform active:scale-95 flex items-center gap-2">
                                <span>Start Chat</span>
                                <svg class="w-4 h-4 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Group Chat Form -->
            <div x-show="conversationType === 'group'" x-cloak class="transition-all duration-300">
                <div class="card border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 text-base">Create Group</h3>
                    </div>
                    <form action="{{ route('messaging.create-group') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Group Name</label>
                            <input type="text" name="name" required class="form-input w-full rounded-lg border-slate-200 text-sm font-medium focus:border-primary-500 focus:ring-primary-500" placeholder="e.g. Welfare Committee">
                        </div>

                         <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Topic / Description</label>
                            <textarea name="description" rows="2" class="form-textarea w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500"></textarea>
                        </div>
                        
                        <div>
                             <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Group Avatar</label>
                             <input type="file" name="avatar" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition-colors">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Add Participants</label>
                            <div class="border border-slate-200 rounded-xl p-0.5 max-h-60 overflow-y-auto bg-slate-50/50">
                                @foreach($members as $member)
                                    <label class="flex items-center p-3 hover:bg-white rounded-lg cursor-pointer transition-colors border border-transparent hover:border-slate-100 group">
                                        <input type="checkbox" name="participant_ids[]" value="{{ $member->user_id }}" class="form-checkbox text-primary-600 rounded w-5 h-5 border-slate-300 focus:ring-primary-500 transition-all">
                                        <div class="ml-3 flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-500 group-hover:bg-primary-100 group-hover:text-primary-600 transition-colors">
                                                {{ strtoupper(substr($member->first_name, 0, 1)) }}
                                            </div>
                                            <div>
                                                 <p class="text-sm font-bold text-slate-700 group-hover:text-slate-900">{{ $member->first_name }} {{ $member->last_name }}</p>
                                                 <p class="text-[10px] text-slate-400 uppercase tracking-wide">{{ ucfirst($member->role ?? 'Member') }}</p>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            <p class="text-xs text-slate-400 mt-2 ml-1">Select at least one person to start the group.</p>
                        </div>
                        
                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                             <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all font-bold text-sm shadow-md hover:shadow-lg transform active:scale-95 flex items-center gap-2">
                                <span>Create Group</span>
                                <svg class="w-4 h-4 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
