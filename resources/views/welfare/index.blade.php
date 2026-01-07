@extends('layouts.app')

@section('title', 'Welfare Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Welfare Dashboard</h1>
            <p class="text-slate-600">Overview of welfare cases, programs, and disbursements.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('welfare.cases.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all font-bold text-sm shadow-sm group">
                <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Welfare Case
            </a>
            <a href="{{ route('welfare.programs.create') }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-all font-bold text-sm shadow-sm">
                <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Create Program
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Active Cases -->
        <div class="card p-6 border border-blue-100 shadow-sm bg-gradient-to-br from-blue-600 to-blue-700 text-white relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
            <div class="relative z-10">
                <p class="text-blue-100 text-sm font-bold uppercase tracking-wide mb-1">Active Cases</p>
                <h3 class="text-3xl font-extrabold mb-2">{{ number_format($statistics['active_cases'] ?? 0) }}</h3>
                <a href="{{ route('welfare.cases', ['status' => 'active']) }}" class="inline-flex items-center text-xs text-blue-100 hover:text-white transition-colors">
                    View list <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>
            <div class="absolute bottom-4 right-4 text-blue-300/30 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
        </div>

        <!-- Pending Review -->
        <div class="card p-6 border border-amber-100 shadow-sm bg-gradient-to-br from-amber-500 to-amber-600 text-white relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
            <div class="relative z-10">
                <p class="text-amber-100 text-sm font-bold uppercase tracking-wide mb-1">Pending Review</p>
                <h3 class="text-3xl font-extrabold mb-2">{{ number_format($statistics['pending_cases'] ?? 0) }}</h3>
                <a href="{{ route('welfare.cases', ['status' => 'pending']) }}" class="inline-flex items-center text-xs text-amber-100 hover:text-white transition-colors">
                    Needs attention <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>
            <div class="absolute bottom-4 right-4 text-amber-200/40 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Total Disbursed -->
        <div class="card p-6 border border-emerald-100 shadow-sm bg-gradient-to-br from-emerald-500 to-emerald-600 text-white relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
            <div class="relative z-10">
                <p class="text-emerald-100 text-sm font-bold uppercase tracking-wide mb-1">Total Disbursed</p>
                <h3 class="text-3xl font-extrabold mb-2">GHS {{ number_format($statistics['total_disbursed'] ?? 0, 2) }}</h3>
                <a href="{{ route('welfare.fund-transactions') }}" class="inline-flex items-center text-xs text-emerald-100 hover:text-white transition-colors">
                    View finances <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>
            <div class="absolute bottom-4 right-4 text-emerald-200/40 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- High Priority Cases -->
        <div class="card border border-slate-100 shadow-sm overflow-hidden h-full flex flex-col">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-base text-slate-800">High Priority Cases</h3>
                <a href="{{ route('welfare.cases', ['priority' => 'high']) }}" class="text-xs text-primary-600 hover:text-primary-700 font-bold uppercase tracking-wide">View All</a>
            </div>
            <div class="divide-y divide-slate-100 flex-1">
                @forelse($highPriorityCases as $case)
                <div class="p-4 hover:bg-slate-50 transition-colors group">
                    <div class="flex justify-between items-start mb-2">
                         <span class="px-2 py-0.5 text-[10px] rounded-full font-bold uppercase tracking-wide
                            {{ $case->priority === 'critical' ? 'bg-rose-100 text-rose-700 border border-rose-200' : 'bg-orange-100 text-orange-700 border border-orange-200' }}">
                            {{ $case->priority }}
                        </span>
                        <span class="text-xs text-slate-400">{{ $case->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <a href="{{ route('welfare.cases.show', $case) }}" class="block">
                        <h4 class="text-sm font-bold text-slate-800 group-hover:text-primary-600 transition-colors mb-1 truncate">{{ $case->case_title }}</h4>
                    </a>
                    
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs text-slate-500 font-medium">To: {{ $case->beneficiary_name ?? 'Unknown' }}</span>
                    </div>

                    <div class="flex justify-between items-center mt-2">
                        <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-2 py-1 rounded">
                            {{ ucfirst(str_replace('_', ' ', $case->case_category)) }}
                        </span>
                        <a href="{{ route('welfare.cases.show', $case) }}" class="p-1.5 rounded-full text-slate-400 hover:text-primary-600 hover:bg-primary-50 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-500">
                    <p>No high priority cases found.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Active Programs -->
        <div class="card border border-slate-100 shadow-sm overflow-hidden h-full flex flex-col">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-base text-slate-800">Active Programs</h3>
                 <a href="{{ route('welfare.programs') }}" class="text-xs text-primary-600 hover:text-primary-700 font-bold uppercase tracking-wide">View All</a>
            </div>
            <div class="divide-y divide-slate-100 flex-1">
                 @forelse($activePrograms as $program)
                <div class="p-4 hover:bg-slate-50 transition-colors">
                     <div class="flex justify-between items-start mb-2">
                        <h4 class="text-sm font-bold text-slate-800 truncate">{{ $program->program_name }}</h4>
                        <span class="text-[10px] font-bold uppercase tracking-wide text-green-600 bg-green-50 px-2 py-0.5 rounded border border-green-100">
                            Active
                        </span>
                    </div>
                    
                    <p class="text-xs text-slate-500 mb-3 capitalize">{{ str_replace('_', ' ', $program->program_type) }}</p>

                    <div class="space-y-1">
                        <div class="flex justify-between text-xs text-slate-500 mb-1">
                            <span>Budget Usage</span>
                            <span class="font-medium text-slate-700">{{ number_format(($program->amount_spent / max(1, $program->budget_allocated)) * 100, 1) }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                             <div class="h-full rounded-full transition-all duration-500
                                {{ ($program->amount_spent / max(1, $program->budget_allocated)) > 0.9 ? 'bg-rose-500' : 'bg-primary-500' }}" 
                                style="width: {{ min(100, ($program->amount_spent / max(1, $program->budget_allocated)) * 100) }}%"></div>
                        </div>
                        <div class="flex justify-between text-[10px] text-slate-400 mt-1">
                            <span>Spent: GHS {{ number_format($program->amount_spent) }}</span>
                            <span>Budget: GHS {{ number_format($program->budget_allocated) }}</span>
                        </div>
                    </div>
                </div>
                 @empty
                <div class="p-8 text-center text-slate-500">
                    <p>No active programs running.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="card p-6 border border-slate-100 bg-slate-50">
        <h3 class="font-bold text-base text-slate-800 mb-4">Quick Actions</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('welfare.reports') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:border-primary-300 hover:text-primary-700 transition font-medium text-sm shadow-sm flex items-center gap-2">
                 <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Generate Report
            </a>
            <a href="{{ route('welfare.fund-transactions') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:border-emerald-300 hover:text-emerald-700 transition font-medium text-sm shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Record Transaction
            </a>
        </div>
    </div>
</div>
@endsection
