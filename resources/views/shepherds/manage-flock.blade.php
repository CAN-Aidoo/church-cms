@extends('layouts.app')

@section('title', 'Manage Flock')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Manage Flock</h1>
        <div class="flex items-center gap-2 mt-1 flex-wrap">
            <nav class="flex items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
                <span>/</span>
                <a href="{{ route('shepherds.index') }}" class="hover:text-primary-600 transition-colors">Shepherds</a>
                <span>/</span>
                <a href="{{ route('shepherds.show', $shepherd) }}" class="hover:text-primary-600 transition-colors">{{ $shepherd->flock_name }}</a>
                <span>/</span>
                <span class="text-slate-800 font-medium">Manage Flock</span>
            </nav>
        </div>
    </div>
    <div class="flex flex-col items-end">
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Capacity</span>
        <div class="flex items-center gap-2">
            <span class="text-2xl font-heading font-bold {{ $shepherd->capacity_percentage >= 100 ? 'text-red-600' : ($shepherd->capacity_percentage >= 80 ? 'text-amber-600' : 'text-emerald-600') }}">
                {{ $shepherd->current_flock_size }}
            </span>
            <span class="text-slate-400 text-lg">/ {{ $shepherd->max_flock_size }}</span>
        </div>
    </div>
</div>

<!-- Capacity Bar -->
<div class="card border border-slate-100 shadow-sm mb-6">
    <div class="p-6">
        <div class="flex justify-between text-sm font-medium text-slate-600 mb-2">
            <span>Flock Capacity Utilization</span>
            <span>{{ number_format($shepherd->capacity_percentage, 0) }}%</span>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-3 mb-2">
            <div class="h-3 rounded-full transition-all duration-500 {{ $shepherd->capacity_percentage >= 100 ? 'bg-red-500' : ($shepherd->capacity_percentage >= 80 ? 'bg-amber-500' : 'bg-emerald-500') }}"
                 style="width: {{ min($shepherd->capacity_percentage, 100) }}%"></div>
        </div>
        <div class="flex items-center gap-2 text-xs">
            @if($shepherd->hasCapacity())
            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-slate-600"><span class="font-bold text-slate-800">{{ $shepherd->available_capacity }}</span> spots available for new members</span>
            @else
            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <span class="text-red-600 font-medium">Flock is at maximum capacity</span>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Current Flock Members -->
    <div class="card border border-slate-100 shadow-sm h-full flex flex-col">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="p-1.5 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h2 class="text-base font-bold text-slate-800">Current Members</h2>
            </div>
            <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-0.5 rounded-full">{{ $flockMembers->count() }}</span>
        </div>
        <div class="p-4 flex-1 overflow-y-auto max-h-[600px] custom-scrollbar">
            @if($flockMembers->count() > 0)
            <div class="space-y-3">
                @foreach($flockMembers as $member)
                <div class="flex items-center justify-between p-3 bg-white border border-slate-100 rounded-xl hover:border-slate-200 hover:shadow-sm transition-all group">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->full_name }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-white">
                        @else
                        <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-sm ring-2 ring-white">
                            {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                        </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-slate-900 truncate">{{ $member->full_name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ $member->phone }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('members.show', $member) }}" target="_blank" class="btn btn-sm btn-icon btn-ghost text-slate-400 hover:text-primary-600" title="View Profile">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                        <form method="POST" action="{{ route('shepherds.unassign-member', $shepherd) }}" class="inline" onsubmit="return confirm('Remove {{ $member->full_name }} from this flock?')">
                            @csrf
                            <input type="hidden" name="member_id" value="{{ $member->id }}">
                            <button type="submit" class="btn btn-sm btn-icon btn-ghost text-slate-400 hover:text-red-600" title="Remove from Flock">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 flex flex-col items-center justify-center h-full">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <p class="text-slate-500 font-medium">No members assigned</p>
                <p class="text-xs text-slate-400 mt-1 max-w-[200px]">Use the panel on the right to assign members to this flock.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Unassigned Members -->
    <div class="card border border-slate-100 shadow-sm h-full flex flex-col">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="p-1.5 bg-emerald-50 text-emerald-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <h2 class="text-base font-bold text-slate-800">Assign Members</h2>
            </div>
            <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2.5 py-0.5 rounded-full">{{ $unassignedMembers->count() }}</span>
        </div>
        <div class="p-4 flex-1 flex flex-col">
            @if($unassignedMembers->count() > 0)
            <div class="mb-4 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text"
                       id="searchUnassigned"
                       placeholder="Search members to assign..."
                       class="form-input w-full pl-10 border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg text-sm"
                       onkeyup="filterMembers()">
            </div>
            
            <div class="overflow-y-auto max-h-[540px] custom-scrollbar space-y-3 flex-1" id="unassignedList">
                @foreach($unassignedMembers as $member)
                <div class="member-item flex items-center justify-between p-3 bg-slate-50 border border-slate-100 rounded-xl hover:border-emerald-200 hover:bg-emerald-50/30 transition-all group"
                     data-name="{{ strtolower($member->full_name) }}"
                     data-phone="{{ $member->phone }}">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->full_name }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-white">
                        @else
                        <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center font-bold text-sm ring-2 ring-white">
                            {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                        </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-slate-900 truncate">{{ $member->full_name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ $member->phone }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('shepherds.assign-member', $shepherd) }}" class="inline">
                        @csrf
                        <input type="hidden" name="member_id" value="{{ $member->id }}">
                        <button type="submit"
                                class="btn btn-sm btn-icon bg-emerald-100 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-colors"
                                title="Assign to Flock"
                                @if(!$shepherd->hasCapacity()) disabled @endif>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </button>
                    </form>
                </div>
                @endforeach
                <div id="noResults" class="hidden text-center py-8">
                    <p class="text-slate-500 text-sm">No members found matching your search</p>
                </div>
            </div>
            @else
            <div class="text-center py-12 flex flex-col items-center justify-center h-full">
                <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <p class="text-slate-900 font-medium">All Set!</p>
                <p class="text-sm text-slate-500 mt-1">All active members are currently assigned to flocks.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function filterMembers() {
    const searchInput = document.getElementById('searchUnassigned').value.toLowerCase();
    const memberItems = document.querySelectorAll('.member-item');
    let hasResults = false;

    memberItems.forEach(item => {
        const name = item.getAttribute('data-name');
        const phone = item.getAttribute('data-phone');

        if (name.includes(searchInput) || phone.includes(searchInput)) {
            item.style.display = 'flex';
            hasResults = true;
        } else {
            item.style.display = 'none';
        }
    });

    const noResults = document.getElementById('noResults');
    if (noResults) {
        noResults.style.display = hasResults ? 'none' : 'block';
    }
}
</script>
@endsection
