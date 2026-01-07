@extends('layouts.app')

@section('title', 'Service Units Analytics')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Service Units Analytics</h1>
            <p class="text-slate-600">Overview of performance metrics and insights across all units</p>
        </div>
        <a href="{{ route('service-units.index') }}"
           class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 hover:border-slate-400 transition-all shadow-sm font-medium text-sm">
            <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Units
        </a>
    </div>

    <!-- Overall Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Units -->
        <div class="card p-6 border border-primary-100 shadow-sm bg-gradient-to-br from-primary-600 to-primary-700 text-white relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
            <div class="relative z-10">
                <p class="text-primary-100 text-sm font-medium mb-1">Total Units</p>
                <h3 class="text-3xl font-bold mb-2">{{ $stats['total_units'] }}</h3>
                <p class="text-xs text-primary-200 bg-white/10 inline-block px-2 py-0.5 rounded">{{ $stats['active_units'] }} active</p>
            </div>
            <div class="absolute bottom-4 right-4 text-primary-200/50 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
        </div>

        <!-- Total Members -->
        <div class="card p-6 border border-emerald-100 shadow-sm bg-gradient-to-br from-emerald-500 to-emerald-600 text-white relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
            <div class="relative z-10">
                <p class="text-emerald-100 text-sm font-medium mb-1">Total Members</p>
                <h3 class="text-3xl font-bold mb-2">{{ $stats['total_members'] }}</h3>
                <p class="text-xs text-emerald-100 bg-white/10 inline-block px-2 py-0.5 rounded">{{ number_format($stats['average_members_per_unit'], 1) }} avg / unit</p>
            </div>
            <div class="absolute bottom-4 right-4 text-emerald-200/50 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

        <!-- Upcoming Duties -->
        <div class="card p-6 border border-amber-100 shadow-sm bg-gradient-to-br from-amber-500 to-amber-600 text-white relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
            <div class="relative z-10">
                <p class="text-amber-100 text-sm font-medium mb-1">Upcoming Duties</p>
                <h3 class="text-3xl font-bold mb-2">{{ $upcomingDuties->count() }}</h3>
                 <p class="text-xs text-amber-100 bg-white/10 inline-block px-2 py-0.5 rounded">Next 30 days</p>
            </div>
            <div class="absolute bottom-4 right-4 text-amber-200/50 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>

        <!-- Needs Attention -->
        <div class="card p-6 border border-rose-100 shadow-sm bg-gradient-to-br from-rose-500 to-rose-600 text-white relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
            <div class="relative z-10">
                <p class="text-rose-100 text-sm font-medium mb-1">Needs Attention</p>
                <h3 class="text-3xl font-bold mb-2">{{ $needingAttention->count() }}</h3>
                 <p class="text-xs text-rose-100 bg-white/10 inline-block px-2 py-0.5 rounded">Units below minimum</p>
            </div>
            <div class="absolute bottom-4 right-4 text-rose-200/50 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Units Needing Attention -->
    @if($needingAttention->isNotEmpty())
    <div class="mb-8">
        <h2 class="text-lg font-bold text-slate-800 mb-4 px-1 flex items-center gap-2">
            <span class="bg-rose-100 text-rose-600 p-1.5 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </span>
            Units Needing Attention
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($needingAttention as $unit)
            <div class="card border border-rose-200 bg-white shadow-sm p-4 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-rose-50 rounded-bl-full -mr-8 -mt-8 z-0"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-bold text-slate-900">{{ $unit->name }}</h3>
                            <p class="text-sm text-slate-500">{{ $unit->code }} • {{ ucfirst($unit->category) }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 mt-4">
                        <div>
                            <div class="flex justify-between items-center text-xs mb-1.5">
                                <span class="text-rose-600 font-bold uppercase tracking-wide">Capacity Alert</span>
                                <span class="text-slate-700 font-medium">{{ $unit->current_members }}/{{ $unit->min_members }}</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2">
                                <div class="bg-rose-500 h-2 rounded-full transition-all duration-500" style="width: {{ min(($unit->current_members / $unit->min_members) * 100, 100) }}%"></div>
                            </div>
                            <p class="text-xs text-rose-600 mt-1.5 font-medium">Shortfall: {{ $unit->min_members - $unit->current_members }} member(s)</p>
                        </div>
                        
                        <a href="{{ route('service-units.manage-members', $unit) }}"
                           class="block text-center px-4 py-2 bg-rose-50 text-rose-700 border border-rose-100 rounded-lg hover:bg-rose-100 hover:border-rose-200 transition text-sm font-semibold">
                            Add Members
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Upcoming Duties List -->
        @if($upcomingDuties->isNotEmpty())
        <div class="lg:col-span-1">
            <div class="card border border-slate-100 shadow-sm h-full flex flex-col">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Upcoming Duties</h3>
                </div>
                <div class="p-4 flex-1 overflow-y-auto max-h-[600px] custom-scrollbar">
                    <div class="space-y-3">
                        @foreach($upcomingDuties->take(10) as $duty)
                        <div class="group border border-slate-200 rounded-xl p-3 hover:border-primary-200 hover:shadow-sm hover:bg-slate-50/50 transition-all">
                            <div class="flex items-start gap-3">
                                <div class="bg-white border border-slate-200 rounded-lg p-2 text-center min-w-[50px] shadow-sm group-hover:border-primary-100 transition-colors">
                                    <p class="text-lg font-bold text-slate-800">{{ \Carbon\Carbon::parse($duty->duty_date)->format('d') }}</p>
                                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wide">{{ \Carbon\Carbon::parse($duty->duty_date)->format('M') }}</p>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-slate-900 truncate text-sm">{{ $duty->serviceUnit->name }}</p>
                                    <p class="text-xs text-slate-500 truncate mb-1.5">{{ $duty->roster_name }}</p>
                                    <div class="flex items-center gap-2">
                                        <span class="px-1.5 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-medium border border-slate-200">
                                            {{ ucwords(str_replace('_', ' ', $duty->duty_type)) }}
                                        </span>
                                        @if($duty->start_time)
                                        <span class="text-[10px] text-slate-400">
                                            {{ \Carbon\Carbon::parse($duty->start_time)->format('g:i A') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Unit Performance Table -->
        <div class="{{ $upcomingDuties->isNotEmpty() ? 'lg:col-span-2' : 'lg:col-span-3' }}">
            <div class="card border border-slate-100 shadow-sm h-full flex flex-col">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Unit Performance Report</h3>
                </div>
                
                @if($units->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                                <th class="px-6 py-3">Unit</th>
                                <th class="px-6 py-3">Capacity</th>
                                <th class="px-6 py-3">Completion Rate</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($units as $unit)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">{{ $unit->name }}</p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-xs font-mono text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded">{{ $unit->code }}</span>
                                            <span class="text-[10px] uppercase font-bold text-slate-500">{{ $unit->category }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="w-32">
                                        <div class="flex justify-between items-center text-xs mb-1">
                                            <span class="text-slate-600 font-medium">{{ $unit->current_members }}/{{ $unit->max_members }}</span>
                                            <span class="text-slate-400">{{ number_format($unit->capacity_percentage, 0) }}%</span>
                                        </div>
                                        <div class="w-full bg-slate-100 rounded-full h-1.5">
                                            <div class="
                                                @if($unit->capacity_percentage >= 100) bg-rose-500
                                                @elseif($unit->capacity_percentage >= 80) bg-amber-500
                                                @else bg-emerald-500
                                                @endif
                                                h-1.5 rounded-full transition-all"
                                                 style="width: {{ min($unit->capacity_percentage, 100) }}%"></div>
                                        </div>
                                        @if($unit->current_members < $unit->min_members)
                                        <p class="text-[10px] text-rose-500 mt-1 font-medium flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            Below Min
                                        </p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="relative w-10 h-10">
                                            <svg class="w-full h-full transform -rotate-90">
                                                <circle cx="20" cy="20" r="16" fill="transparent" stroke="#e2e8f0" stroke-width="4"></circle>
                                                <circle cx="20" cy="20" r="16" fill="transparent" 
                                                        stroke="{{ $unit->performance['completion_rate'] >= 80 ? '#10b981' : ($unit->performance['completion_rate'] >= 60 ? '#f59e0b' : '#ef4444') }}" 
                                                        stroke-width="4" 
                                                        stroke-dasharray="100" 
                                                        stroke-dashoffset="{{ 100 - $unit->performance['completion_rate'] }}"></circle>
                                            </svg>
                                            <span class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-slate-700">
                                                {{ number_format($unit->performance['completion_rate'], 0) }}%
                                            </span>
                                        </div>
                                        <div class="text-xs text-slate-500">
                                            <p>{{ $unit->performance['completed_rosters'] }} rosters</p>
                                            <p>completed</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('service-units.show', $unit) }}"
                                       class="text-primary-600 hover:text-primary-700 text-xs font-bold uppercase tracking-wide hover:underline transition-all">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <p class="text-slate-500 font-medium">No service units found for analysis.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
