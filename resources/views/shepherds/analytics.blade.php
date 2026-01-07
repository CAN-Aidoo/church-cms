@extends('layouts.app')

@section('title', 'Shepherd Analytics')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Shepherd Analytics</h1>
        <p class="text-slate-500 mt-1">Performance metrics and insights (Last 90 days)</p>
    </div>
    <a href="{{ route('shepherds.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Shepherds
    </a>
</div>

<!-- Summary Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border-l-4 border-l-blue-500 bg-white shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Shepherds</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $stats['active'] }}</h3>
            </div>
            <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-emerald-500 bg-white shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total in Flocks</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $stats['total_flock_members'] }}</h3>
            </div>
            <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-amber-500 bg-white shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Avg. Flock Size</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ number_format($stats['average_flock_size'], 1) }}</h3>
            </div>
            <div class="p-3 bg-amber-50 rounded-xl text-amber-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-red-500 bg-white shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">At Capacity</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $stats['shepherds_at_capacity'] }}</h3>
            </div>
            <div class="p-3 bg-red-50 rounded-xl text-red-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Shepherds Needing Attention -->
@if($needingAttention->count() > 0)
<div class="card border-l-4 border-l-red-500 bg-red-50 shadow-sm border-t border-r border-b border-red-100 mb-8">
    <div class="px-6 py-4 border-b border-red-100 bg-red-100/50 flex items-center gap-2">
        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        <h2 class="text-lg font-bold text-red-900">Shepherds Needing Attention ({{ $needingAttention->count() }})</h2>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($needingAttention as $shepherd)
            <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-red-200 shadow-sm">
                <div class="flex-1">
                    <p class="font-bold text-slate-800">{{ $shepherd->flock_name }}</p>
                    <p class="text-sm text-slate-600">{{ $shepherd->full_name }}</p>
                    <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Low activity in last 30 days
                    </p>
                </div>
                <a href="{{ route('shepherds.show', $shepherd) }}" class="btn btn-sm bg-red-50 text-red-700 hover:bg-red-100 border-red-100">
                    View
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Shepherd Performance Table -->
<div class="card border border-slate-100 shadow-sm">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
        <h2 class="text-lg font-heading font-bold text-slate-800">Shepherd Performance (Last 90 Days)</h2>
    </div>
    <div class="p-0">
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-slate-50 border-b border-slate-100 text-xs uppercase text-slate-500 font-semibold">
                    <tr>
                        <th class="px-6 py-3 text-left">Shepherd</th>
                        <th class="px-6 py-3 text-left">Flock Size</th>
                        <th class="px-6 py-3 text-left">Capacity</th>
                        <th class="px-6 py-3 text-left">Visits</th>
                        <th class="px-6 py-3 text-left">Visits/Mem</th>
                        <th class="px-6 py-3 text-left">Meetings</th>
                        <th class="px-6 py-3 text-left">Avg Attd</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($shepherds as $shepherd)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3">
                            <div>
                                <p class="font-medium text-slate-900">{{ $shepherd->flock_name }}</p>
                                <p class="text-xs text-slate-500">{{ $shepherd->full_name }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-3">
                            <span class="font-semibold text-slate-700">{{ $shepherd->current_flock_size }}</span>
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-16 bg-slate-100 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full {{ $shepherd->capacity_percentage >= 100 ? 'bg-red-500' : ($shepherd->capacity_percentage >= 80 ? 'bg-amber-500' : 'bg-emerald-500') }}"
                                         style="width: {{ min($shepherd->capacity_percentage, 100) }}%"></div>
                                </div>
                                <span class="text-xs text-slate-500">{{ number_format($shepherd->capacity_percentage, 0) }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                {{ $shepherd->performance['visitations'] }}
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            <span class="font-medium text-sm {{ $shepherd->performance['visitations_per_member'] >= 1 ? 'text-emerald-600' : ($shepherd->performance['visitations_per_member'] >= 0.5 ? 'text-amber-600' : 'text-red-600') }}">
                                {{ $shepherd->performance['visitations_per_member'] }}
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                {{ $shepherd->performance['meetings'] }}
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            <span class="font-medium text-slate-700">
                                {{ $shepherd->performance['average_meeting_attendance'] }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('shepherds.show', $shepherd) }}" class="btn btn-sm btn-icon btn-ghost text-slate-400 hover:text-primary-600" title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <a href="{{ route('shepherds.manage-flock', $shepherd) }}" class="btn btn-sm btn-icon btn-ghost text-slate-400 hover:text-primary-600" title="Manage Flock">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
