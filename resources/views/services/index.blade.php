@extends('layouts.app')

@section('title', 'Service Planning')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Service Planning</h1>
        <p class="text-slate-500 mt-1">Manage worship services, schedules, and volunteers</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('services.calendar') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Calendar View
        </a>
        @can('create', App\Models\ServiceSchedule::class)
        <a href="{{ route('services.create') }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Create Service
        </a>
        @endcan
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border-l-4 border-l-blue-500 bg-white shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Today's Services</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $summary['today_services'] }}</h3>
            </div>
            <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-emerald-500 bg-white shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">This Week</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $summary['this_week_services'] }}</h3>
            </div>
            <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-amber-500 bg-white shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pending Volunteers</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $summary['pending_volunteers'] }}</h3>
            </div>
            <div class="p-3 bg-amber-50 rounded-xl text-amber-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-purple-500 bg-white shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Avg Attendance</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ number_format($summary['avg_attendance_rate'], 1) }}%</h3>
            </div>
            <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card border border-slate-100 shadow-sm p-4 mb-8">
    <form method="GET" action="{{ route('services.index') }}" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-4">
            <select name="service_type" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg text-sm">
                <option value="">All Service Types</option>
                <option value="regular" {{ ($filters['service_type'] ?? '') === 'regular' ? 'selected' : '' }}>Regular Service</option>
                <option value="special" {{ ($filters['service_type'] ?? '') === 'special' ? 'selected' : '' }}>Special Service</option>
                <option value="midweek" {{ ($filters['service_type'] ?? '') === 'midweek' ? 'selected' : '' }}>Midweek Service</option>
                <option value="youth" {{ ($filters['service_type'] ?? '') === 'youth' ? 'selected' : '' }}>Youth Service</option>
                <option value="children" {{ ($filters['service_type'] ?? '') === 'children' ? 'selected' : '' }}>Children Service</option>
                <option value="prayer_meeting" {{ ($filters['service_type'] ?? '') === 'prayer_meeting' ? 'selected' : '' }}>Prayer Meeting</option>
                <option value="bible_study" {{ ($filters['service_type'] ?? '') === 'bible_study' ? 'selected' : '' }}>Bible Study</option>
            </select>

            <select name="status" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg text-sm">
                <option value="">All Status</option>
                <option value="draft" {{ ($filters['status'] ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="scheduled" {{ ($filters['status'] ?? '') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="in_progress" {{ ($filters['status'] ?? '') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ ($filters['status'] ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" 
                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg text-sm">

            <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" 
                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg text-sm">
        </div>

        <div class="flex gap-2">
            <button type="submit" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
            @if(!empty($filters))
            <a href="{{ route('services.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50">
                Clear
            </a>
            @endif
        </div>
    </form>
</div>

<!-- Services List -->
<div class="space-y-4">
    @forelse($services as $service)
    <div class="card border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary-600 transition-colors">{{ $service->name }}</h3>
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize {{ $service->getStatusBadgeClass() }}">
                            {{ ucfirst(str_replace('_', ' ', $service->status)) }}
                        </span>
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-slate-100 text-slate-600">
                            {{ $service->service_type_label }}
                        </span>
                    </div>

                    @if($service->theme)
                    <p class="text-sm text-slate-500 mb-4 italic">"{{ $service->theme }}"</p>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Date & Time</p>
                                <p class="text-sm font-medium text-slate-900">{{ $service->service_date->format('M d, Y') }}</p>
                                <p class="text-xs text-slate-500">
                                    {{ \Carbon\Carbon::parse($service->start_time)->format('h:i A') }}
                                    @if($service->end_time)
                                        - {{ \Carbon\Carbon::parse($service->end_time)->format('h:i A') }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if($service->preacher)
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-purple-50 text-purple-600 rounded-lg mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Preacher</p>
                                <p class="text-sm font-medium text-slate-900">{{ $service->preacher->full_name }}</p>
                            </div>
                        </div>
                        @endif

                        @if($service->venue)
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-amber-50 text-amber-600 rounded-lg mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Venue</p>
                                <p class="text-sm font-medium text-slate-900 truncate max-w-[150px]" title="{{ $service->venue }}">{{ $service->venue }}</p>
                            </div>
                        </div>
                        @else
                        <div class="flex items-start gap-3">
                             <div class="p-2 bg-slate-50 text-slate-400 rounded-lg mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Venue</p>
                                <p class="text-sm font-medium text-slate-500">Main Sanctuary</p>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Volunteers</p>
                                <p class="text-sm font-medium text-slate-900">{{ $service->volunteers_count }} Assigned</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-row md:flex-col gap-2 mt-4 md:mt-0 w-full md:w-auto">
                    <a href="{{ route('services.show', $service) }}" class="btn btn-sm btn-outline-primary w-full md:w-auto justify-center">
                        View Details
                    </a>
                    @can('update', $service)
                    <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-ghost text-slate-500 hover:text-slate-700 w-full md:w-auto justify-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="card border border-slate-100 shadow-sm p-12 text-center bg-slate-50">
        <div class="w-20 h-20 bg-white rounded-full shadow-sm flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <h3 class="text-lg font-bold text-slate-900 mb-2">No Services Found</h3>
        <p class="text-slate-500 mb-6 max-w-sm mx-auto">Get started by planning your first service schedule, managing volunteers, and organizing worship items.</p>
        @can('create', App\Models\ServiceSchedule::class)
        <a href="{{ route('services.create') }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Create First Service
        </a>
        @endcan
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($services->hasPages())
<div class="mt-8">
    {{ $services->links() }}
</div>
@endif
@endsection
