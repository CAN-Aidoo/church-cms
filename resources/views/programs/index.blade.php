@extends('layouts.app')

@section('title', 'Programs & Events')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Programs & Events</h1>
        <p class="text-slate-500 mt-1">Manage church programs, conferences, and special events.</p>
    </div>
    @can('create', App\Models\Program::class)
    <div class="flex items-center gap-3">
        <a href="{{ route('programs.create') }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Create Program
        </a>
    </div>
    @endcan
</div>

<!-- Summary Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="card p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Programs</p>
                <p class="text-3xl font-bold text-slate-900">{{ $summary['total'] }}</p>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
               <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Upcoming</p>
                <p class="text-3xl font-bold text-slate-900">{{ $summary['upcoming'] }}</p>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Ongoing</p>
                <p class="text-3xl font-bold text-slate-900">{{ $summary['ongoing'] }}</p>
            </div>
            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Completed (Year)</p>
                <p class="text-3xl font-bold text-slate-900">{{ $summary['completed_this_year'] }}</p>
            </div>
            <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border border-slate-100 shadow-sm bg-gradient-to-br from-primary-600 to-primary-700 text-white">
        <div class="flex items-center justify-between">
            <div>
                 <p class="text-xs font-bold text-primary-100 uppercase tracking-wider mb-1">Participants (Year)</p>
                <p class="text-3xl font-bold text-white">{{ number_format($summary['total_participants_this_year']) }}</p>
            </div>
            <div class="p-3 bg-white/10 rounded-xl text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card border border-slate-100 shadow-sm mb-6">
    <div class="p-4">
        <form method="GET" action="{{ route('programs.index') }}" class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 gap-4 items-end">
            <div>
                <label for="status" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Status</label>
                <select name="status" id="status" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    <option value="">All Status</option>
                    <option value="draft" {{ ($filters['status'] ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ ($filters['status'] ?? '') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="ongoing" {{ ($filters['status'] ?? '') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ ($filters['status'] ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div>
                <label for="type" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Type</label>
                <select name="type" id="type" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    <option value="">All Types</option>
                    <option value="conference" {{ ($filters['type'] ?? '') === 'conference' ? 'selected' : '' }}>Conference</option>
                    <option value="seminar" {{ ($filters['type'] ?? '') === 'seminar' ? 'selected' : '' }}>Seminar</option>
                    <option value="crusade" {{ ($filters['type'] ?? '') === 'crusade' ? 'selected' : '' }}>Crusade</option>
                    <option value="retreat" {{ ($filters['type'] ?? '') === 'retreat' ? 'selected' : '' }}>Retreat</option>
                    <option value="workshop" {{ ($filters['type'] ?? '') === 'workshop' ? 'selected' : '' }}>Workshop</option>
                    <option value="training" {{ ($filters['type'] ?? '') === 'training' ? 'selected' : '' }}>Training</option>
                </select>
            </div>

            <div class="md:col-span-2 lg:col-span-3">
                <label for="search" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search programs..." class="form-input w-full pl-10 border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary flex-1 justify-center">Filter</button>
                @if(!empty($filters))
                <a href="{{ route('programs.index') }}" class="btn btn-secondary px-3" title="Clear Filters">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Programs Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($programs as $program)
    <div class="card border border-slate-100 shadow-sm flex flex-col h-full group hover:border-primary-200 hover:shadow-md transition-all overflow-hidden">
        {{-- Flyer Image --}}
        <div class="relative h-48 bg-slate-100 overflow-hidden">
            @if($program->flyer_path)
                <img src="{{ Storage::url($program->flyer_path) }}" alt="{{ $program->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
            @else
                <div class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                    <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            @endif
             <div class="absolute top-3 right-3 flex gap-2">
                 <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-bold shadow-sm backdrop-blur-sm bg-white/90 text-slate-700 capitalize">
                    {{ ucfirst($program->type) }}
                </span>
                <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-bold shadow-sm backdrop-blur-sm
                    {{ $program->status === 'published' ? 'bg-emerald-500/90 text-white' : 
                      ($program->status === 'completed' ? 'bg-blue-500/90 text-white' : 'bg-slate-500/90 text-white') }} capitalize">
                    {{ ucfirst($program->status) }}
                </span>
            </div>
        </div>

        {{-- Content --}}
        <div class="p-6 flex-1 flex flex-col">
            <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-primary-600 transition-colors line-clamp-1">
                <a href="{{ route('programs.show', $program) }}">{{ $program->name }}</a>
            </h3>
            
            <p class="text-sm text-slate-600 mb-4 line-clamp-2 flex-1">{{ $program->description }}</p>

            <div class="space-y-3 mb-6">
                <div class="flex items-center text-sm text-slate-600">
                    <div class="w-8 flex justify-center mr-2">
                         <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                   <span class="font-medium">{{ $program->start_date->format('M d, Y') }}</span>
                    @if($program->end_date->ne($program->start_date))
                        <span class="mx-1">-</span>
                        <span class="font-medium">{{ $program->end_date->format('M d, Y') }}</span>
                    @endif
                </div>

                @if($program->venue_name)
                <div class="flex items-center text-sm text-slate-600">
                    <div class="w-8 flex justify-center mr-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <span class="truncate">{{ $program->venue_name }}</span>
                </div>
                @endif
                
                @if($program->requires_registration)
                <div class="flex items-center justify-between text-sm pt-2 border-t border-slate-100 mt-2">
                    <div class="flex items-center text-slate-600">
                         <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="font-bold text-slate-800">{{ $program->current_participants }}</span>
                         @if($program->max_participants)
                            <span class="text-slate-400 mx-1">/</span> {{ $program->max_participants }}
                        @endif
                    </div>
                    <div>
                        @if($program->registration_fee > 0)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-blue-50 text-blue-700">
                                GHS {{ number_format($program->registration_fee, 2) }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-emerald-50 text-emerald-700">
                                Free
                            </span>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <div class="flex gap-3">
                <a href="{{ route('programs.show', $program) }}" class="flex-1 btn btn-outline-primary justify-center text-sm py-2">
                    Details
                </a>
                @if($program->canRegister())
                <a href="{{ route('programs.registration-form', $program) }}" class="flex-1 btn btn-primary justify-center text-sm py-2 shadow-md shadow-primary-500/20">
                    Register
                </a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-16 text-center bg-slate-50 rounded-xl border border-dashed border-slate-300">
        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-200">
            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-slate-900 mb-2">No Programs Found</h3>
        <p class="text-slate-500 mb-6 max-w-md mx-auto">Get started by planning your next church event, conference, or service gathering.</p>
        @can('create', App\Models\Program::class)
        <a href="{{ route('programs.create') }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
            Create First Program
        </a>
        @endcan
    </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($programs->hasPages())
<div class="mt-8">
    {{ $programs->links() }}
</div>
@endif
@endsection
