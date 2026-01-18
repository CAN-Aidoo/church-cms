@extends('layouts.app')

@section('title', $program->name)

@section('content')
<!-- Header -->
<div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6 mb-8">
    <div>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-2">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('programs.index') }}" class="hover:text-primary-600 transition-colors">Programs</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">{{ $program->name }}</span>
        </nav>
        
        <div class="flex items-center gap-3">
            <h1 class="text-3xl font-heading font-bold text-slate-900">{{ $program->name }}</h1>
            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $program->getStatusBadgeClass() }} capitalize">
                {{ ucfirst($program->status) }}
            </span>
             <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-slate-100 text-slate-700 capitalize">
                {{ $program->getTypeLabel() }}
            </span>
        </div>
    </div>

    <div class="flex flex-wrap gap-2">
        @can('update', $program)
            @if($program->status === 'draft')
                <form action="{{ route('programs.publish', $program) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn btn-success shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Publish
                    </button>
                </form>
            @endif

            @if($program->status === 'published' && $program->start_date->isToday())
                <form action="{{ route('programs.start', $program) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Start Program
                    </button>
                </form>
            @endif

            @if($program->status === 'ongoing' && $program->end_date->isPast())
                <form action="{{ route('programs.complete', $program) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn btn-primary shadow-sm bg-purple-600 hover:bg-purple-700 border-transparent text-white">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Mark Complete
                    </button>
                </form>
            @endif

            <a href="{{ route('programs.edit', $program) }}" class="btn btn-outline-primary">
                Edit
            </a>

            <form action="{{ route('programs.destroy', $program) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this program? All registrations and sessions will be removed.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    Delete
                </button>
            </form>

            @if(in_array($program->status, ['draft', 'published']))
                <form action="{{ route('programs.cancel', $program) }}" method="POST" class="inline"
                      onsubmit="return confirm('Are you sure you want to cancel this program?');">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        Cancel
                    </button>
                </form>
            @endif
        @endcan

        @if($program->canRegister())
            <a href="{{ route('programs.registration-form', $program) }}" class="btn btn-secondary shadow-sm" target="_blank">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                Registration Page
            </a>
        @endif
    </div>
</div>

{{-- Flyer --}}
@if($program->flyer_path)
<div class="card border border-slate-100 shadow-sm overflow-hidden mb-8">
    <div class="h-64 md:h-80 w-full relative">
         <img src="{{ Storage::url($program->flyer_path) }}" alt="{{ $program->name }}" class="hidden"> <!-- For SEO/Accessibility if needed, but styling via bg -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ Storage::url($program->flyer_path) }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
    </div>
</div>
@endif

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="card p-5 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                 <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Registrations</p>
                <p class="text-2xl font-bold text-slate-900">{{ $statistics['total_registrations'] }}</p>
            </div>
             <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-5 border border-slate-100 shadow-sm">
         <div class="flex items-center justify-between">
            <div>
                 <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Confirmed</p>
                <p class="text-2xl font-bold text-slate-900">{{ $statistics['confirmed_registrations'] }}</p>
            </div>
             <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-5 border border-slate-100 shadow-sm">
         <div class="flex items-center justify-between">
            <div>
                 <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Capacity</p>
                <p class="text-2xl font-bold text-slate-900">{{ round($statistics['capacity_percentage']) }}%</p>
            </div>
             <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-5 border border-slate-100 shadow-sm">
         <div class="flex items-center justify-between">
            <div>
                 <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Revenue</p>
                <p class="text-2xl font-bold text-slate-900">GHS {{ number_format($statistics['total_revenue'], 2) }}</p>
            </div>
             <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-5 border border-slate-100 shadow-sm">
         <div class="flex items-center justify-between">
            <div>
                 <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Avg Rating</p>
                <p class="text-2xl font-bold text-slate-900">
                    @if($statistics['average_rating'])
                        {{ number_format($statistics['average_rating'], 1) }} ⭐
                    @else
                        N/A
                    @endif
                </p>
            </div>
             <div class="p-3 bg-yellow-50 text-yellow-600 rounded-xl">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Tabs & Content -->
<div class="card border border-slate-100 shadow-sm mb-6 bg-white overflow-hidden">
    <div class="border-b border-slate-200 bg-slate-50/50">
        <nav class="flex -mb-px overflow-x-auto">
            <button onclick="showTab('overview')" id="tab-overview" class="tab-button active group inline-flex items-center px-6 py-4 border-b-2 font-medium text-sm transition-colors duration-200 border-primary-500 text-primary-600">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Overview
            </button>
            <button onclick="showTab('sessions')" id="tab-sessions" class="tab-button group inline-flex items-center px-6 py-4 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Sessions <span class="bg-white text-slate-600 ml-2 py-0.5 px-2.5 rounded-full text-xs font-semibold shadow-sm border border-slate-200">{{ $program->sessions->count() }}</span>
            </button>
            <button onclick="showTab('registrations')" id="tab-registrations" class="tab-button group inline-flex items-center px-6 py-4 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Registrations <span class="bg-white text-slate-600 ml-2 py-0.5 px-2.5 rounded-full text-xs font-semibold shadow-sm border border-slate-200">{{ $program->registrations->count() }}</span>
            </button>
            <button onclick="showTab('feedback')" id="tab-feedback" class="tab-button group inline-flex items-center px-6 py-4 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                Feedback <span class="bg-white text-slate-600 ml-2 py-0.5 px-2.5 rounded-full text-xs font-semibold shadow-sm border border-slate-200">{{ $statistics['feedback_count'] }}</span>
            </button>
            <button onclick="showTab('resources')" id="tab-resources" class="tab-button group inline-flex items-center px-6 py-4 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Resources <span class="bg-white text-slate-600 ml-2 py-0.5 px-2.5 rounded-full text-xs font-semibold shadow-sm border border-slate-200">{{ $program->resources->count() }}</span>
            </button>
            <button onclick="showTab('qr-codes')" id="tab-qr-codes" class="tab-button group inline-flex items-center px-6 py-4 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                QR Codes
            </button>
        </nav>
    </div>

    {{-- Overview Tab --}}
    <div id="content-overview" class="tab-content p-6 block">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-lg font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">Program Details</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-slate-500 mb-1">Description</dt>
                        <dd class="text-sm text-slate-700 leading-relaxed">{{ $program->description }}</dd>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-slate-500 mb-1">Duration</dt>
                            <dd class="text-sm font-medium text-slate-900">
                                {{ $program->start_date->format('M d, Y') }} - {{ $program->end_date->format('M d, Y') }}
                                <span class="text-xs text-slate-400 block mt-0.5">({{ $program->start_date->diffInDays($program->end_date) + 1 }} days)</span>
                            </dd>
                        </div>
                        @if($program->start_time && $program->end_time)
                        <div>
                            <dt class="text-sm font-medium text-slate-500 mb-1">Time</dt>
                            <dd class="text-sm font-medium text-slate-900">
                                {{ \Carbon\Carbon::parse($program->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($program->end_time)->format('g:i A') }}
                            </dd>
                        </div>
                        @endif
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500 mb-1">Category</dt>
                        <dd class="text-sm font-medium text-slate-900 flex items-center">
                            <span class="inline-block w-2 h-2 rounded-full bg-primary-400 mr-2"></span>
                            {{ ucwords(str_replace('_', ' ', $program->category)) }}
                        </dd>
                    </div>
                    @if($program->target_audience)
                    <div>
                        <dt class="text-sm font-medium text-slate-500 mb-1">Target Audience</dt>
                        <dd class="text-sm font-medium text-slate-900">{{ $program->target_audience }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            <div>
                <h3 class="text-lg font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">Venue & Registration</h3>
                <dl class="space-y-4">
                    @if($program->venue_name)
                    <div>
                        <dt class="text-sm font-medium text-slate-500 mb-1">Venue</dt>
                        <dd class="text-sm font-medium text-slate-900">{{ $program->venue_name }}</dd>
                    </div>
                    @endif
                    @if($program->venue_address)
                    <div>
                        <dt class="text-sm font-medium text-slate-500 mb-1">Address</dt>
                        <dd class="text-sm text-slate-700">{{ $program->venue_address }}</dd>
                    </div>
                    @endif
                    @if($program->venue_gps)
                    <div>
                        <dt class="text-sm font-medium text-slate-500 mb-1">GPS Address</dt>
                        <dd class="text-sm font-mono bg-slate-100 text-slate-700 px-2 py-1 rounded inline-block">{{ $program->venue_gps }}</dd>
                    </div>
                    @endif
                    
                    @if($program->requires_registration)
                        <div class="mt-6 pt-4 border-t border-slate-100">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-slate-500 mb-1">Registration Fee</dt>
                                    <dd class="text-sm font-bold text-slate-900">
                                        @if($program->registration_fee > 0)
                                            GHS {{ number_format($program->registration_fee, 2) }}
                                        @else
                                            Free
                                        @endif
                                    </dd>
                                </div>
                                @if($program->max_participants)
                                <div>
                                    <dt class="text-sm font-medium text-slate-500 mb-1">Capacity</dt>
                                    <dd class="text-sm text-slate-900">
                                        <div class="flex items-center gap-2">
                                            <div class="w-full bg-slate-200 rounded-full h-1.5 max-w-[80px]">
                                                <div class="bg-primary-500 h-1.5 rounded-full" style="width: {{ min(100, $statistics['capacity_percentage']) }}%"></div>
                                            </div>
                                            <span class="text-xs font-medium">{{ $program->current_participants }}/{{ $program->max_participants }}</span>
                                        </div>
                                    </dd>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    {{-- Sessions Tab --}}
    <div id="content-sessions" class="tab-content hidden p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-slate-900">Program Sessions</h3>
            @can('update', $program)
            <a href="{{ route('programs.manage-sessions', $program) }}" class="btn btn-sm btn-primary">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Manage Sessions
            </a>
            @endcan
        </div>

        <div class="space-y-4">
        @forelse($program->sessions as $session)
            <div class="bg-slate-50 rounded-lg p-5 border border-slate-100 hover:border-slate-200 transition-colors">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <h4 class="text-lg font-bold text-slate-900 mb-1">{{ $session->title }}</h4>
                        </div>
                        @if($session->description)
                        <p class="text-sm text-slate-600 mb-3">{{ $session->description }}</p>
                        @endif
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-2">
                            <div class="flex items-center text-sm text-slate-600">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>{{ $session->session_date->format('M d') }} <span class="text-slate-300 mx-1">|</span> {{ \Carbon\Carbon::parse($session->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($session->end_time)->format('g:i A') }}</span>
                            </div>
                            
                            @if($session->venue)
                            <div class="flex items-center text-sm text-slate-600">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="truncate">{{ $session->venue }}</span>
                            </div>
                            @endif

                            @if($session->speaker_name)
                            <div class="flex items-center text-sm text-slate-600">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span class="truncate">{{ $session->speaker_name }}</span>
                            </div>
                            @endif

                            <div class="flex items-center text-sm text-slate-600">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <span>{{ $session->current_attendees }} @if($session->max_attendees) / {{ $session->max_attendees }} @endif Attendees</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-slate-50 rounded-lg border border-dashed border-slate-300">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-slate-500 font-medium">No sessions scheduled yet</p>
            </div>
        @endforelse
        </div>
    </div>

    {{-- Registrations Tab --}}
    <div id="content-registrations" class="tab-content hidden p-0">
        <div class="flex justify-between items-center p-6 border-b border-slate-200 bg-slate-50/50">
            <h3 class="text-lg font-bold text-slate-900">Participant Registrations</h3>
            @can('update', $program)
            <a href="{{ route('programs.manage-registrations', $program) }}" class="btn btn-sm btn-primary">
                Manage Registrations
            </a>
            @endcan
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500 font-semibold tracking-wider">
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Contact</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Payment</th>
                        <th class="px-6 py-4">Registered</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($program->registrations->take(10) as $registration)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $registration->first_name }} {{ $registration->last_name }}</div>
                            @if($registration->badge_number)
                            <div class="text-xs text-slate-500 mt-0.5">{{ $registration->badge_number }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-slate-600">{{ $registration->email }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">{{ $registration->phone }}</div>
                        </td>
                        <td class="px-6 py-4">
                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                                {{ $registration->status === 'confirmed' ? 'bg-emerald-100 text-emerald-800' :
                                   ($registration->status === 'pending' ? 'bg-amber-100 text-amber-800' :
                                   ($registration->status === 'attended' ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-800')) }}">
                                {{ $registration->status }}
                            </span>
                        </td>
                         <td class="px-6 py-4">
                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                                {{ $registration->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' :
                                   ($registration->payment_status === 'partial' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                                {{ $registration->payment_status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $registration->registered_at->format('M d, Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            No registrations found for this program.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($program->registrations->count() > 10)
        <div class="p-4 border-t border-slate-200 bg-slate-50/50 text-center">
            <a href="{{ route('programs.manage-registrations', $program) }}" class="text-sm font-medium text-primary-600 hover:text-primary-700">
                View all {{ $program->registrations->count() }} registrations →
            </a>
        </div>
        @endif
    </div>

    {{-- Feedback Tab --}}
    <div id="content-feedback" class="tab-content hidden p-6">
        <h3 class="text-lg font-bold text-slate-900 mb-6">Program Feedback</h3>

        @if($program->feedback->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-indigo-50 rounded-xl p-5 border border-indigo-100">
                    <p class="text-sm font-medium text-indigo-600 mb-1">Average Rating</p>
                    <p class="text-3xl font-bold text-indigo-900">{{ number_format($statistics['average_rating'], 1) }} ⭐</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                    <p class="text-sm font-medium text-blue-600 mb-1">Total Responses</p>
                    <p class="text-3xl font-bold text-blue-900">{{ $statistics['feedback_count'] }}</p>
                </div>
                <div class="bg-emerald-50 rounded-xl p-5 border border-emerald-100">
                    <p class="text-sm font-medium text-emerald-600 mb-1">Would Recommend</p>
                    <p class="text-3xl font-bold text-emerald-900">{{ $program->feedback->where('would_recommend', true)->count() }}</p>
                </div>
            </div>

            <div class="space-y-4">
                @foreach($program->feedback->take(5) as $feedback)
                <div class="bg-white rounded-lg p-5 border border-slate-100 shadow-sm">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="font-bold text-slate-800">{{ $feedback->registration->first_name }} {{ $feedback->registration->last_name }}</p>
                            <p class="text-xs text-slate-500">{{ $feedback->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="bg-yellow-50 px-2 py-1 rounded text-yellow-700 text-sm font-bold border border-yellow-200">
                            {{ $feedback->overall_rating }} ⭐
                        </div>
                    </div>
                    @if($feedback->comments)
                    <p class="text-sm text-slate-600 mt-2 bg-slate-50 p-3 rounded-lg">{{ $feedback->comments }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        @else
        <div class="text-center py-12 bg-slate-50 rounded-lg border border-dashed border-slate-300">
             <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
            <p class="text-slate-500 font-medium">No feedback submitted yet</p>
        </div>
        @endif
    </div>

    {{-- Resources Tab --}}
    <div id="content-resources" class="tab-content hidden p-6">
        <h3 class="text-lg font-bold text-slate-900 mb-6">Program Resources</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($program->resources as $resource)
            <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-3">
                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wide
                        {{ $resource->resource_type === 'equipment' ? 'bg-blue-100 text-blue-800' :
                           ($resource->resource_type === 'facility' ? 'bg-purple-100 text-purple-800' :
                           ($resource->resource_type === 'personnel' ? 'bg-orange-100 text-orange-800' : 'bg-slate-100 text-slate-800')) }}">
                        {{ $resource->resource_type }}
                    </span>
                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                        {{ $resource->status === 'confirmed' ? 'text-emerald-700 bg-emerald-50 border border-emerald-200' : 
                          ($resource->status === 'pending' ? 'text-amber-700 bg-amber-50 border border-amber-200' : 'text-slate-600 bg-slate-100') }}">
                        {{ $resource->status }}
                    </span>
                </div>
                <h4 class="text-lg font-bold text-slate-900 mb-1">{{ $resource->resource_name }}</h4>
                
                <div class="flex items-center gap-4 mt-4 pt-4 border-t border-slate-100 text-sm">
                    @if($resource->quantity)
                    <div class="text-slate-600">
                        <span class="font-medium text-slate-900">Qty:</span> {{ $resource->quantity }}
                    </div>
                    @endif
                    @if($resource->cost)
                    <div class="text-slate-600">
                        <span class="font-medium text-slate-900">Cost:</span> GHS {{ number_format($resource->cost, 2) }}
                    </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-slate-50 rounded-lg border border-dashed border-slate-300">
                 <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <p class="text-slate-500 font-medium">No resources allocated yet</p>
            </div>
        @endforelse
        </div>
    </div>

    {{-- QR Codes Tab --}}
    <div id="content-qr-codes" class="tab-content hidden p-6" x-data="{
        regQREnabled: {{ $program->qr_registration_enabled ? 'true' : 'false' }},
        checkQREnabled: {{ $program->qr_checkin_enabled ? 'true' : 'false' }}
    }">
        <h3 class="text-lg font-bold text-slate-900 mb-6">QR Code Management</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            {{-- Registration QR --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h4 class="text-lg font-bold text-slate-900">Registration QR</h4>
                        <p class="text-xs text-slate-500 mt-1">For public registration link</p>
                    </div>
                     <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" x-model="regQREnabled" @change="toggleRegistrationQR({{ $program->id }})" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                    </label>
                </div>

                <div x-show="regQREnabled" class="space-y-6">
                    @if($program->registration_qr_code)
                    <div class="flex justify-center bg-slate-50 p-6 rounded-lg border border-dashed border-slate-300">
                        <img src="{{ route('programs.qr-image', ['program' => $program->id, 'type' => 'registration']) }}"
                             alt="Registration QR Code"
                             class="w-48 h-48 rounded shadow-sm bg-white p-2">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('programs.download-qr', ['program' => $program->id, 'type' => 'registration']) }}" class="btn btn-outline-primary justify-center text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download PNG
                        </a>
                        <a href="{{ route('programs.print-registration-qr', $program->id) }}" target="_blank" class="btn btn-outline-secondary justify-center text-sm">
                             <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Print Poster
                        </a>
                        <button onclick="regenerateRegQR({{ $program->id }})" class="btn btn-ghost text-slate-500 hover:text-red-600 text-xs w-full col-span-2">
                            Regenerate Code
                        </button>
                    </div>
                    @else
                    <div class="text-center py-6">
                        <button onclick="generateRegQR({{ $program->id }})" class="btn btn-primary">Generate QR Code</button>
                    </div>
                    @endif
                </div>
                 <div x-show="!regQREnabled" class="text-center py-12 text-slate-400 bg-slate-50 rounded-lg border border-dashed border-slate-200">
                    QR capability disabled
                </div>
            </div>

            {{-- Check-In QR --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                         <h4 class="text-lg font-bold text-slate-900">Check-In QR</h4>
                        <p class="text-xs text-slate-500 mt-1">For event attendance tracking</p>
                    </div>
                     <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" x-model="checkQREnabled" @change="toggleCheckInQR({{ $program->id }})" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    </label>
                </div>
                
                 <div x-show="checkQREnabled" class="space-y-6">
                    @if($program->check_in_qr_code)
                    <div class="flex justify-center bg-slate-50 p-6 rounded-lg border border-dashed border-slate-300">
                        <img src="{{ route('programs.qr-image', ['program' => $program->id, 'type' => 'checkin']) }}"
                             alt="Check-In QR Code"
                             class="w-48 h-48 rounded shadow-sm bg-white p-2">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                         <a href="{{ route('programs.download-qr', ['program' => $program->id, 'type' => 'checkin']) }}" class="btn btn-outline-primary justify-center text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download PNG
                        </a>
                        <a href="{{ route('programs.print-checkin-qr', $program->id) }}" target="_blank" class="btn btn-outline-secondary justify-center text-sm">
                             <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Print Poster
                        </a>
                        <button onclick="regenerateCheckQR({{ $program->id }})" class="btn btn-ghost text-slate-500 hover:text-red-600 text-xs w-full col-span-2">
                            Regenerate Code
                        </button>
                    </div>
                    @else
                    <div class="text-center py-6">
                        <button onclick="generateCheckQR({{ $program->id }})" class="btn btn-primary">Generate QR Code</button>
                    </div>
                    @endif
                </div>
                 <div x-show="!checkQREnabled" class="text-center py-12 text-slate-400 bg-slate-50 rounded-lg border border-dashed border-slate-200">
                    QR capability disabled
                </div>
            </div>
        </div>

        @if(isset($qrStats))
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-6 text-white shadow-lg">
            <h4 class="text-lg font-bold mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                QR Scan Statistics
            </h4>
            <div class="grid grid-cols-3 gap-6 text-center divide-x divide-white/10">
                <div>
                     <p class="text-3xl font-bold tracking-tight">{{ $qrStats['registration_scans'] ?? 0 }}</p>
                    <p class="text-xs text-slate-400 uppercase tracking-wider mt-1">Registration</p>
                </div>
                <div>
                     <p class="text-3xl font-bold tracking-tight">{{ $qrStats['checkin_scans'] ?? 0 }}</p>
                    <p class="text-xs text-slate-400 uppercase tracking-wider mt-1">Check-in</p>
                </div>
                <div>
                     <p class="text-3xl font-bold tracking-tight text-emerald-400">{{ ($qrStats['registration_scans'] ?? 0) + ($qrStats['checkin_scans'] ?? 0) }}</p>
                    <p class="text-xs text-slate-400 uppercase tracking-wider mt-1">Total Scans</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    function showTab(tabName) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
            tab.classList.remove('block');
        });
        
        // Show selected tab
        const selectedTab = document.getElementById('content-' + tabName);
        if(selectedTab) {
            selectedTab.classList.remove('hidden');
            selectedTab.classList.add('block');
        }
        
        // Update tab styling
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active', 'border-primary-500', 'text-primary-600');
            btn.classList.add('border-transparent', 'text-slate-500');
        });
        
        const activeBtn = document.getElementById('tab-' + tabName);
        if(activeBtn) {
            activeBtn.classList.remove('border-transparent', 'text-slate-500');
            activeBtn.classList.add('active', 'border-primary-500', 'text-primary-600');
        }
    }

    // Keep existing JS functions for QR codes, just update styling in alerts if needed
    function toggleRegistrationQR(programId) {
        fetch(`/programs/${programId}/toggle-qr-registration`, {
             method: 'POST',
             headers: {
                 'Content-Type': 'application/json',
                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
             }
         })
         .then(response => response.json())
         .then(data => {
             if (!data.success) {
                 alert('Error toggling registration QR: ' + (data.message || 'Unknown error'));
                 window.location.reload();
             }
         })
         .catch(error => { console.error('Error:', error); alert('Error.'); window.location.reload(); });
    }

    function toggleCheckInQR(programId) {
         fetch(`/programs/${programId}/toggle-qr-checkin`, {
             method: 'POST',
             headers: {
                 'Content-Type': 'application/json',
                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
             }
         })
         .then(response => response.json())
         .then(data => {
             if (!data.success) {
                 alert('Error moving QR: ' + data.message);
                 window.location.reload();
             }
         })
         .catch(e => { console.error(e); alert('Error.'); window.location.reload(); });
    }
    
    function generateRegQR(pid) {
        if(!confirm('Generate new QR?')) return;
        fetch(`/programs/${pid}/generate-registration-qr`, { method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Content-Type': 'application/json'}})
        .then(r=>r.json()).then(d=>{ if(d.success) window.location.reload(); else alert(d.message); });
    }
    
    function generateCheckQR(pid) {
        if(!confirm('Generate new QR?')) return;
         fetch(`/programs/${pid}/generate-checkin-qr`, { method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Content-Type': 'application/json'}})
        .then(r=>r.json()).then(d=>{ if(d.success) window.location.reload(); else alert(d.message); });
    }
    
    function regenerateRegQR(pid) {
        if(!confirm('Regenerate QR? Old one will stop working.')) return;
         fetch(`/programs/${pid}/regenerate-registration-qr`, { method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Content-Type': 'application/json'}})
        .then(r=>r.json()).then(d=>{ if(d.success) window.location.reload(); else alert(d.message); });
    }
    
    function regenerateCheckQR(pid) {
        if(!confirm('Regenerate QR? Old one will stop working.')) return;
         fetch(`/programs/${pid}/regenerate-checkin-qr`, { method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Content-Type': 'application/json'}})
        .then(r=>r.json()).then(d=>{ if(d.success) window.location.reload(); else alert(d.message); });
    }
</script>
@endsection
