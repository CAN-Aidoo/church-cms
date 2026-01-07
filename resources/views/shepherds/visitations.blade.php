@extends('layouts.app')

@section('title', 'Visitations History')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Visitations History</h1>
        <div class="flex items-center gap-2 mt-1 flex-wrap">
            <nav class="flex items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
                <span>/</span>
                <a href="{{ route('shepherds.index') }}" class="hover:text-primary-600 transition-colors">Shepherds</a>
                <span>/</span>
                <a href="{{ route('shepherds.show', $shepherd) }}" class="hover:text-primary-600 transition-colors">{{ $shepherd->flock_name }}</a>
                <span>/</span>
                <span class="text-slate-800 font-medium">Visitations</span>
            </nav>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('shepherds.create-visitation', $shepherd) }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Record New Visit
        </a>
    </div>
</div>

@if($followUpVisitations->count() > 0)
<div class="card border-l-4 border-l-amber-500 bg-amber-50 shadow-sm border-t border-r border-b border-amber-100 mb-8">
    <div class="px-6 py-4 border-b border-amber-100 bg-amber-100/50 flex items-center gap-2">
        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        <h2 class="text-lg font-bold text-amber-900">Follow-up Required ({{ $followUpVisitations->count() }})</h2>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($followUpVisitations as $visitation)
            <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-amber-200 shadow-sm">
                <div>
                    <p class="font-bold text-slate-800">{{ $visitation->member->full_name }}</p>
                    <div class="text-xs text-slate-500 mt-1 space-y-1">
                        <p>Visited: {{ $visitation->visit_date->format('M d, Y') }}</p>
                        <p class="text-amber-700 font-medium bg-amber-100 inline-block px-1.5 py-0.5 rounded">Due: {{ $visitation->follow_up_date->format('M d, Y') }}</p>
                    </div>
                </div>
                <a href="{{ route('shepherds.create-visitation', ['shepherd' => $shepherd, 'member_id' => $visitation->member_id]) }}" class="btn btn-sm bg-amber-100 text-amber-800 hover:bg-amber-200 border-amber-200">
                    Visit
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<div class="card border border-slate-100 shadow-sm">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
        <h2 class="text-base font-bold text-slate-800">All Visitations</h2>
        <span class="bg-slate-100 text-slate-600 text-xs font-bold px-2.5 py-0.5 rounded-full">{{ $visitations->count() }} Records</span>
    </div>
    <div class="p-0">
        @if($visitations->count() > 0)
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-slate-50 border-b border-slate-100 text-xs uppercase text-slate-500 font-semibold">
                    <tr>
                        <th class="px-6 py-3 text-left">Date</th>
                        <th class="px-6 py-3 text-left">Member</th>
                        <th class="px-6 py-3 text-left">Type</th>
                        <th class="px-6 py-3 text-left">Reason</th>
                        <th class="px-6 py-3 text-left">Notes</th>
                        <th class="px-6 py-3 text-left">Follow-up</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($visitations as $visitation)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3 text-sm font-medium text-slate-900 whitespace-nowrap">
                            {{ $visitation->visit_date->format('M d, Y') }}
                            @if($visitation->visit_time)
                            <span class="block text-xs text-slate-500 font-normal">{{ \Carbon\Carbon::parse($visitation->visit_time)->format('h:i A') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-sm text-slate-600 font-medium">{{ $visitation->member->full_name }}</td>
                        <td class="px-6 py-3">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-slate-100 text-slate-700">
                                {{ ucfirst(str_replace('_', ' ', $visitation->visit_type)) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-sm text-slate-500">{{ ucfirst(str_replace('_', ' ', $visitation->visit_reason)) }}</td>
                        <td class="px-6 py-3 text-sm text-slate-600 max-w-xs truncate">{{ $visitation->notes }}</td>
                        <td class="px-6 py-3">
                            @if($visitation->follow_up_date)
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-medium {{ $visitation->follow_up_date->isPast() ? 'bg-red-50 text-red-700' : 'bg-blue-50 text-blue-700' }}">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $visitation->follow_up_date->format('M d') }}
                            </span>
                            @else
                            <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h3 class="text-lg font-medium text-slate-900">No visitations recorded</h3>
            <p class="text-slate-500 mt-1">Record your first visitation to start tracking.</p>
            <div class="mt-6">
                <a href="{{ route('shepherds.create-visitation', $shepherd) }}" class="btn btn-primary">
                    Record New Visit
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
