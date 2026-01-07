@extends('layouts.app')

@section('title', $shepherd->flock_name)

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">{{ $shepherd->flock_name }}</h1>
        <div class="flex items-center gap-2 mt-1 flex-wrap">
            <nav class="flex items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
                <span>/</span>
                <a href="{{ route('shepherds.index') }}" class="hover:text-primary-600 transition-colors">Shepherds</a>
                <span>/</span>
                <span class="text-slate-800 font-medium">Details</span>
            </nav>
            <span class="text-slate-300">|</span>
            <div class="flex items-center gap-2">
                <span class="text-sm text-slate-600">Shepherd:</span>
                <span class="text-sm font-medium text-slate-900">{{ $shepherd->full_name }}</span>
            </div>
        </div>
    </div>
    <div class="flex items-center gap-3 flex-wrap">
        <span class="inline-flex items-center rounded-md px-2.5 py-1.5 text-sm font-medium ring-1 ring-inset {{ $shepherd->status === 'active' ? 'bg-emerald-50 text-emerald-700 ring-emerald-600/20' : ($shepherd->status === 'on_leave' ? 'bg-amber-50 text-amber-700 ring-amber-600/20' : 'bg-slate-100 text-slate-700 ring-slate-600/20') }}">
            {{ ucfirst(str_replace('_', ' ', $shepherd->status)) }}
        </span>
        @can('update', $shepherd)
        <a href="{{ route('shepherds.edit', $shepherd) }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Edit
        </a>
        @endcan
        <a href="{{ route('shepherds.manage-flock', $shepherd) }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Manage Flock
        </a>
    </div>
</div>

<!-- Performance Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border-l-4 border-l-blue-500 bg-white shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Flock Members</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $shepherd->current_flock_size }}</h3>
                <p class="text-xs text-slate-500 mt-1">{{ $shepherd->available_capacity }} capacity left</p>
            </div>
            <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-emerald-500 bg-white shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Visitations (30d)</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $performance['visitations'] }}</h3>
                <p class="text-xs text-slate-500 mt-1">{{ $performance['visitations_per_member'] }} per member</p>
            </div>
            <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-amber-500 bg-white shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Meetings (30d)</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $performance['meetings'] }}</h3>
                <p class="text-xs text-slate-500 mt-1">{{ $performance['meetings_per_month'] }} per month</p>
            </div>
            <div class="p-3 bg-amber-50 rounded-xl text-amber-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-purple-500 bg-white shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Avg. Attendance</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ number_format($performance['average_meeting_attendance'], 1) }}</h3>
                <p class="text-xs text-slate-500 mt-1">Per meeting</p>
            </div>
            <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Follow-up Required -->
        @if($followUpVisitations->count() > 0)
        <div class="card border-l-4 border-l-amber-500 bg-amber-50 shadow-sm border-t border-r border-b border-amber-100">
            <div class="px-6 py-4 border-b border-amber-100 bg-amber-100/50 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <h2 class="text-lg font-bold text-amber-900">Follow-up Required</h2>
            </div>
            <div class="p-6 space-y-3">
                @foreach($followUpVisitations as $visitation)
                <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-amber-200 shadow-sm">
                    <div>
                        <p class="font-bold text-slate-800">{{ $visitation->member->full_name }}</p>
                        <div class="flex items-center gap-3 mt-1">
                            <p class="text-xs text-slate-500">
                                Last visit: <span class="font-medium">{{ $visitation->visit_date->format('M d, Y') }}</span>
                            </p>
                            <p class="text-xs font-semibold text-amber-700 bg-amber-100 px-2 py-0.5 rounded">
                                Due: {{ $visitation->follow_up_date->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('shepherds.create-visitation', ['shepherd' => $shepherd, 'member_id' => $visitation->member_id]) }}" class="btn btn-sm bg-amber-100 text-amber-800 hover:bg-amber-200 border-amber-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Visit
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Upcoming Meetings -->
        @if($upcomingMeetings->count() > 0)
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-lg font-heading font-bold text-slate-800">Upcoming Meetings</h2>
                <a href="{{ route('shepherds.create-meeting', $shepherd) }}" class="btn btn-sm btn-primary">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Schedule
                </a>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($upcomingMeetings as $meeting)
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-100 hover:border-slate-200 transition-colors">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="badge badge-info text-xs">{{ ucfirst($meeting->meeting_type) }}</span>
                                @if($meeting->is_today)
                                <span class="badge badge-danger text-xs">Today</span>
                                @elseif($meeting->is_upcoming)
                                <span class="badge badge-warning text-xs">Upcoming</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-4">
                                <div>
                                    <p class="font-bold text-slate-900">{{ $meeting->meeting_date->format('M d, Y') }}</p>
                                    @if($meeting->meeting_time)
                                    <p class="text-sm text-slate-500">{{ $meeting->meeting_time }}</p>
                                    @endif
                                </div>
                                @if($meeting->location)
                                <div class="hidden sm:block pl-4 border-l border-slate-200">
                                    <p class="text-sm text-slate-600 flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $meeting->location }}
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('shepherds.meetings', $shepherd) }}" class="btn btn-sm bg-white border border-slate-200 text-slate-600 hover:text-slate-900 ml-4">
                            View
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('shepherds.meetings', $shepherd) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium inline-flex items-center gap-1">
                        View all meetings <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Visitations -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-lg font-heading font-bold text-slate-800">Recent Visitations</h2>
                <a href="{{ route('shepherds.create-visitation', $shepherd) }}" class="btn btn-sm btn-primary">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Record Visit
                </a>
            </div>
            <div class="p-0">
                @if($recentVisitations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead class="bg-slate-50 border-b border-slate-100 text-xs uppercase text-slate-500 font-semibold">
                            <tr>
                                <th class="px-6 py-3 text-left">Date</th>
                                <th class="px-6 py-3 text-left">Member</th>
                                <th class="px-6 py-3 text-left">Type</th>
                                <th class="px-6 py-3 text-left">Reason</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentVisitations as $visitation)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-3 text-sm font-medium text-slate-900">{{ $visitation->visit_date->format('M d, Y') }}</td>
                                <td class="px-6 py-3 text-sm text-slate-600">{{ $visitation->member->full_name }}</td>
                                <td class="px-6 py-3">
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-slate-100 text-slate-700">
                                        {{ ucfirst(str_replace('_', ' ', $visitation->visit_type)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-sm text-slate-500">{{ ucfirst(str_replace('_', ' ', $visitation->visit_reason)) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-slate-100 text-center">
                    <a href="{{ route('shepherds.visitations', $shepherd) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium inline-flex items-center gap-1">
                        View all visitations <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                @else
                <div class="text-center py-8">
                    <p class="text-slate-500">No recent visitations recorded</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Flock Members -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-lg font-heading font-bold text-slate-800">Flock Members ({{ $shepherd->current_flock_size }})</h2>
                <a href="{{ route('shepherds.manage-flock', $shepherd) }}" class="btn btn-sm btn-primary">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Manage
                </a>
            </div>
            <div class="p-6">
                @if($shepherd->flockMembers->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($shepherd->flockMembers->take(10) as $member)
                    <div class="flex items-center gap-3 p-3 bg-white border border-slate-100 rounded-xl hover:border-slate-200 hover:shadow-sm transition-all group">
                        @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->full_name }}" class="w-10 h-10 rounded-full object-cover border border-slate-200">
                        @else
                        <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-sm border border-slate-200">
                            {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                        </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-slate-900 truncate">{{ $member->full_name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ $member->phone }}</p>
                        </div>
                        <a href="{{ route('members.show', $member) }}" class="text-slate-400 hover:text-primary-600 opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                    </div>
                    @endforeach
                </div>
                @if($shepherd->flockMembers->count() > 10)
                <div class="mt-4 text-center">
                    <a href="{{ route('shepherds.manage-flock', $shepherd) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium inline-flex items-center gap-1">
                        View all {{ $shepherd->current_flock_size }} members <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                @endif
                @else
                <div class="text-center py-8">
                    <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-2">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <p class="text-slate-500">No flock members assigned yet</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Shepherd Info -->
        <div class="card border border-slate-100 shadow-sm h-fit">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Shepherd Info</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-lg border border-slate-200">
                        {{ substr($shepherd->full_name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-900">{{ $shepherd->full_name }}</p>
                        <p class="text-xs text-slate-500">Appointed {{ $shepherd->appointed_date->format('M Y') }}</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-slate-600">Flock Capacity</span>
                        <span class="font-medium text-slate-900">{{ number_format($shepherd->capacity_percentage, 0) }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="h-2 rounded-full transition-all duration-500 {{ $shepherd->capacity_percentage >= 100 ? 'bg-red-500' : ($shepherd->capacity_percentage >= 80 ? 'bg-amber-500' : 'bg-emerald-500') }}"
                             style="width: {{ min($shepherd->capacity_percentage, 100) }}%"></div>
                    </div>
                    <p class="text-xs text-slate-400 mt-1 text-right">{{ $shepherd->current_flock_size }} / {{ $shepherd->max_flock_size }} members</p>
                </div>

                <div class="pt-4 border-t border-slate-100 grid grid-cols-2 gap-4">
                    <div>
                        <span class="block text-xs text-slate-500 uppercase tracking-wider">Service</span>
                        <span class="font-medium text-slate-900">{{ $shepherd->years_of_service }} {{ $shepherd->years_of_service == 1 ? 'Year' : 'Years' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-slate-500 uppercase tracking-wider">Status</span>
                        <span class="font-medium text-emerald-600 capitalize">{{ str_replace('_', ' ', $shepherd->status) }}</span>
                    </div>
                </div>

                @if($shepherd->description)
                <div class="pt-4 border-t border-slate-100">
                    <span class="block text-xs text-slate-500 uppercase tracking-wider mb-1">Description</span>
                    <p class="text-sm text-slate-700 leading-relaxed">{{ $shepherd->description }}</p>
                </div>
                @endif
                
                @if($shepherd->notes)
                <div class="pt-4 border-t border-slate-100">
                    <span class="block text-xs text-slate-500 uppercase tracking-wider mb-1">Notes</span>
                    <p class="text-sm text-slate-700 leading-relaxed bg-yellow-50 p-3 rounded-lg border border-yellow-100 text-yellow-800">{{ $shepherd->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Quick Actions</h3>
            </div>
            <div class="p-4 space-y-2">
                <a href="{{ route('shepherds.create-visitation', $shepherd) }}" class="btn w-full bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 justify-start">
                    <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Record Visitation
                </a>
                <a href="{{ route('shepherds.create-meeting', $shepherd) }}" class="btn w-full bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 justify-start">
                    <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Schedule Meeting
                </a>
                <div class="border-t border-slate-100 my-2"></div>
                <a href="{{ route('shepherds.visitations', $shepherd) }}" class="btn w-full bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 justify-start">
                    <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    View All Visitations
                </a>
                <a href="{{ route('shepherds.meetings', $shepherd) }}" class="btn w-full bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 justify-start">
                    <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    View All Meetings
                </a>
                <a href="{{ route('shepherds.reports', $shepherd) }}" class="btn w-full bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 justify-start">
                    <svg class="w-4 h-4 mr-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    View Reports
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
