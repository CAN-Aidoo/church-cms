@extends('layouts.app')

@section('title', 'Children\'s Ministry Dashboard')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Children's Ministry</h1>
        <p class="text-sm text-slate-500 mt-1">Overview and quick actions</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('childrens-ministry.checkin') }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            Check-in Console
        </a>
        <a href="{{ route('childrens-ministry.events.create') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Create Event
        </a>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Children -->
    <div class="card p-6 border border-slate-100 shadow-sm relative overflow-hidden group hover:border-primary-200 transition-all">
        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
            <svg class="w-20 h-20 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
        </div>
        <div class="relative z-10">
            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Total Children</p>
            <h3 class="text-3xl font-bold text-slate-900">{{ $statistics['total_children'] ?? 0 }}</h3>
            <div class="mt-4 flex items-center text-sm">
                <a href="{{ route('childrens-ministry.children') }}" class="text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1">
                    View Registry
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Today's Check-ins -->
    <div class="card p-6 border border-slate-100 shadow-sm relative overflow-hidden group hover:border-emerald-200 transition-all">
        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
            <svg class="w-20 h-20 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-9 14l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path></svg>
        </div>
        <div class="relative z-10">
            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Checked In Today</p>
            <h3 class="text-3xl font-bold text-slate-900">{{ $statistics['todays_checkins'] ?? 0 }}</h3>
            <div class="mt-4 flex items-center text-sm">
                 <a href="{{ route('childrens-ministry.checkin') }}" class="text-emerald-600 hover:text-emerald-700 font-medium flex items-center gap-1">
                    Open Console
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Volunteers -->
    <div class="card p-6 border border-slate-100 shadow-sm relative overflow-hidden group hover:border-purple-200 transition-all">
        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
            <svg class="w-20 h-20 text-purple-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
        </div>
        <div class="relative z-10">
            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Volunteers</p>
            <h3 class="text-3xl font-bold text-slate-900">{{ $statistics['volunteers'] ?? 0 }}</h3>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-slate-500">Active this month</span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Check-ins -->
    <div class="card border border-slate-100 shadow-sm h-full">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 text-base">Recent Check-ins</h3>
            <a href="{{ route('childrens-ministry.checkin') }}" class="text-xs font-medium text-primary-600 hover:text-primary-700">View All</a>
        </div>
        <div class="p-0">
            @if(isset($todaysCheckins) && count($todaysCheckins) > 0)
                <div class="divide-y divide-slate-100">
                    @foreach($todaysCheckins->take(5) as $checkin)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-sm border-2 border-white shadow-sm">
                                    {{ substr($checkin->child->first_name ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-slate-900">{{ $checkin->child->full_name ?? 'Unknown' }}</p>
                                    <p class="text-xs text-slate-500">{{ $checkin->created_at->format('h:i A') }} • {{ $checkin->child->age_group ?? 'Ungrouped' }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-emerald-50 text-emerald-700">
                                Checked In
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-slate-500 text-sm">No check-ins yet today.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="card border border-slate-100 shadow-sm h-full">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 text-base">Upcoming Events</h3>
            <a href="{{ route('childrens-ministry.events') }}" class="text-xs font-medium text-primary-600 hover:text-primary-700">View Calendar</a>
        </div>
        <div class="p-0">
            @if(isset($upcomingEvents) && count($upcomingEvents) > 0)
                <div class="divide-y divide-slate-100">
                    @foreach($upcomingEvents as $event)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="text-center min-w-[50px]">
                                    <span class="block text-xs font-bold text-slate-400 uppercase">{{ $event->start_date->format('M') }}</span>
                                    <span class="block text-xl font-bold text-slate-800">{{ $event->start_date->format('d') }}</span>
                                </div>
                                <div>
                                    <a href="{{ route('childrens-ministry.events.show', $event) }}" class="font-medium text-slate-900 hover:text-primary-600 transition-colors">{{ $event->event_name }}</a>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ ucfirst(str_replace('_', ' ', $event->event_type)) }}</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-slate-300 transform group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                         <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <p class="text-slate-500 text-sm">No upcoming events scheduled.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
