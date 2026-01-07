@extends('layouts.app')

@section('title', 'Group Settings')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <!-- Header -->
    <div class="flex items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-3">
             <a href="{{ route('messaging.conversation', $conversation) }}" class="p-2 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-slate-50 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Group Settings</h1>
                <p class="text-slate-600 text-sm">Manage participants and group details.</p>
            </div>
        </div>
    </div>

    <!-- Permission Warning -->
    @if(!$conversation->isUserAdmin(auth()->id()))
        <div class="alert alert-warning mb-6 flex items-start gap-4 p-4 bg-amber-50 border border-amber-100 rounded-xl text-amber-800">
             <svg class="w-6 h-6 flex-shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
             <div>
                 <h4 class="font-bold text-sm">Read Only Access</h4>
                 <p class="text-xs mt-1 text-amber-700">You are a participant in this group but not an administrator. You can view details but cannot edit them or add/remove members.</p>
             </div>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-8">
        <!-- Group Details Form -->
        <div class="card border border-slate-100 shadow-sm overflow-hidden">
             <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Group Info</h3>
            </div>
            
            <form action="{{ route('messaging.update-group', $conversation) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <div class="flex items-start gap-6 mb-6">
                    <div class="relative group">
                         @if($conversation->avatar)
                            <div class="w-20 h-20 rounded-xl overflow-hidden shadow-sm border border-slate-200">
                                <img src="{{ asset('storage/' . $conversation->avatar) }}" alt="{{ $conversation->name }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-20 h-20 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-1 space-y-4">
                        <div>
                             <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Group Name</label>
                             <input type="text" name="name" value="{{ old('name', $conversation->name) }}" {{ !$conversation->isUserAdmin(auth()->id()) ? 'readonly' : '' }} class="form-input w-full rounded-lg border-slate-200 text-sm font-bold text-slate-800 disabled:bg-slate-50 disabled:text-slate-500">
                        </div>
                         
                         @if($conversation->isUserAdmin(auth()->id()))
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Change Avatar</label>
                                <input type="file" name="avatar" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Description</label>
                    <textarea name="description" rows="3" {{ !$conversation->isUserAdmin(auth()->id()) ? 'readonly' : '' }} class="form-textarea w-full rounded-lg border-slate-200 text-sm disabled:bg-slate-50 disabled:text-slate-500">{{ old('description', $conversation->description) }}</textarea>
                </div>

                @if($conversation->isUserAdmin(auth()->id()))
                    <div class="flex justify-end pt-4 mt-6 border-t border-slate-100">
                        <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all font-bold text-sm shadow-md">
                            Save Changes
                        </button>
                    </div>
                @endif
            </form>
        </div>

        <!-- Participants List -->
        <div class="card border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <div>
                     <h3 class="font-bold text-slate-800 text-base">Participants</h3>
                     <p class="text-xs text-slate-500">{{ $conversation->participants->count() }} members</p>
                </div>
                @if($conversation->isUserAdmin(auth()->id()))
                    <button onclick="document.getElementById('addParticipantsModal').classList.remove('hidden')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-primary-600 hover:bg-primary-50 hover:border-primary-200 transition-all font-bold text-xs flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        Add People
                    </button>
                @endif
            </div>

            <div class="divide-y divide-slate-50 max-h-96 overflow-y-auto">
                 @foreach($conversation->participants->sortByDesc(fn($p) => $p->is_admin) as $participant)
                    <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold border border-slate-200">
                                {{ substr($participant->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                    {{ $participant->user->name }}
                                    @if($participant->user_id === auth()->id())
                                        <span class="text-[10px] text-slate-400 font-medium">(You)</span>
                                    @endif
                                </h4>
                                <p class="text-xs text-slate-500">
                                     @if($participant->is_admin)
                                        <span class="text-primary-600 font-bold">Admin</span>
                                    @else
                                        Member
                                    @endif
                                </p>
                            </div>
                        </div>

                         @if($conversation->isUserAdmin(auth()->id()) && $participant->user_id !== auth()->id())
                             <form action="{{ route('messaging.remove-participant', $conversation) }}" method="POST" onsubmit="return confirm('Remove this person from the group?');">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $participant->user_id }}">
                                <button type="submit" class="p-2 text-slate-300 hover:text-rose-600 transition-colors rounded-lg hover:bg-rose-50 opacity-0 group-hover:opacity-100" title="Remove User">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                 @endforeach
            </div>
        </div>
        
        <!-- Leave Group -->
         @if(!$conversation->isUserAdmin(auth()->id()))
        <div class="text-center">
             <form action="{{ route('messaging.leave-group', $conversation) }}" method="POST" onsubmit="return confirm('Are you sure you want to leave this group?');">
                @csrf
                <button type="submit" class="text-rose-600 hover:text-rose-700 text-sm font-bold hover:underline">
                    Leave Group
                </button>
            </form>
        </div>
        @endif
    </div>
</div>

<!-- Add Participants Modal -->
@if($conversation->isUserAdmin(auth()->id()))
<div id="addParticipantsModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">
         <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="font-bold text-lg text-slate-800">Add Participants</h3>
            <button onclick="document.getElementById('addParticipantsModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        
        <form action="{{ route('messaging.add-participants', $conversation) }}" method="POST">
             @csrf
             <div class="p-6">
                <!-- Search could go here -->
                <div class="max-h-60 overflow-y-auto border border-slate-200 rounded-xl p-1">
                    @forelse($availableMembers ?? [] as $member)
                        <label class="flex items-center p-3 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors">
                            <input type="checkbox" name="user_ids[]" value="{{ $member->user_id }}" class="form-checkbox text-primary-600 rounded w-5 h-5 border-slate-300 focus:ring-primary-500">
                            <div class="ml-3 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-500">
                                    {{ strtoupper(substr($member->first_name, 0, 1)) }}
                                </div>
                                <div>
                                     <p class="text-sm font-bold text-slate-700">{{ $member->first_name }} {{ $member->last_name }}</p>
                                     <p class="text-[10px] text-slate-400 uppercase tracking-wide">{{ ucfirst($member->role ?? 'Member') }}</p>
                                </div>
                            </div>
                        </label>
                    @empty
                        <p class="text-center text-slate-400 py-6 text-sm">No new members available to add.</p>
                    @endforelse
                </div>
             </div>
             
             <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('addParticipantsModal').classList.add('hidden')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 font-bold text-sm">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-bold text-sm shadow-sm">Add Selected</button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
