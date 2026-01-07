@extends('layouts.app')

@section('title', 'Flock Meetings')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Flock Meetings</h1>
        <div class="flex items-center gap-2 mt-1 flex-wrap">
            <nav class="flex items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
                <span>/</span>
                <a href="{{ route('shepherds.index') }}" class="hover:text-primary-600 transition-colors">Shepherds</a>
                <span>/</span>
                <a href="{{ route('shepherds.show', $shepherd) }}" class="hover:text-primary-600 transition-colors">{{ $shepherd->flock_name }}</a>
                <span>/</span>
                <span class="text-slate-800 font-medium">Meetings</span>
            </nav>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('shepherds.create-meeting', $shepherd) }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Schedule Meeting
        </a>
    </div>
</div>

@if($upcomingMeetings->count() > 0)
<div class="card border border-slate-100 shadow-sm mb-8">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <h2 class="text-lg font-bold text-slate-800">Upcoming Meetings</h2>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($upcomingMeetings as $meeting)
            <div class="flex flex-col p-4 bg-white rounded-xl border border-slate-200 shadow-sm hover:border-primary-200 transition-colors relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-16 h-16 text-primary-500 transform rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-primary-50 text-primary-700 capitalize">
                            {{ $meeting->meeting_type }}
                        </span>
                        @if($meeting->is_today)
                        <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Today</span>
                        @endif
                    </div>
                    
                    <h3 class="text-lg font-bold text-slate-900 mb-1">
                        {{ $meeting->meeting_date->format('M d, Y') }}
                    </h3>
                    @if($meeting->meeting_time)
                    <p class="text-sm text-slate-500 flex items-center gap-1.5 mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ \Carbon\Carbon::parse($meeting->meeting_time)->format('h:i A') }}
                    </p>
                    @endif
                    
                    @if($meeting->location)
                    <p class="text-sm text-slate-600 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $meeting->location }}
                    </p>
                    @endif

                    <div class="mt-4 pt-3 border-t border-slate-100 flex justify-end">
                        <a href="#" class="btn btn-sm bg-white border border-slate-200 text-slate-600 hover:text-slate-900">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<div class="card border border-slate-100 shadow-sm">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
        <h2 class="text-base font-bold text-slate-800">Meeting History</h2>
        <span class="bg-slate-100 text-slate-600 text-xs font-bold px-2.5 py-0.5 rounded-full">{{ $meetings->count() }} Records</span>
    </div>
    <div class="p-0">
        @if($meetings->count() > 0)
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-slate-50 border-b border-slate-100 text-xs uppercase text-slate-500 font-semibold">
                    <tr>
                        <th class="px-6 py-3 text-left">Date</th>
                        <th class="px-6 py-3 text-left">Type</th>
                        <th class="px-6 py-3 text-left">Location</th>
                        <th class="px-6 py-3 text-left">Agenda</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($meetings as $meeting)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3 text-sm font-medium text-slate-900 whitespace-nowrap">
                            {{ $meeting->meeting_date->format('M d, Y') }}
                            @if($meeting->meeting_time)
                            <span class="block text-xs text-slate-500 font-normal">{{ \Carbon\Carbon::parse($meeting->meeting_time)->format('h:i A') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-slate-100 text-slate-700 capitalize">
                                {{ $meeting->meeting_type }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-sm text-slate-600">{{ $meeting->location ?? '-' }}</td>
                        <td class="px-6 py-3 text-sm text-slate-600 max-w-xs truncate">{{ $meeting->agenda ?? '-' }}</td>
                        <td class="px-6 py-3">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium 
                                {{ $meeting->status === 'completed' ? 'bg-emerald-50 text-emerald-700' : ($meeting->status === 'scheduled' ? 'bg-blue-50 text-blue-700' : 'bg-slate-50 text-slate-700') }} capitalize">
                                {{ $meeting->status }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-right">
                            <button class="btn btn-sm btn-icon btn-ghost text-slate-400 hover:text-primary-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-lg font-medium text-slate-900">No meetings recorded</h3>
            <p class="text-slate-500 mt-1">Schedule your first flock meeting.</p>
            <div class="mt-6">
                <a href="{{ route('shepherds.create-meeting', $shepherd) }}" class="btn btn-primary">
                    Schedule Meeting
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
