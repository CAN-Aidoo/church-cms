@extends('layouts.app')

@section('title', 'Prayer Analytics')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Prayer Analytics</h1>
            <p class="text-slate-600">Insights into prayer requests and intercession activities</p>
        </div>
        <a href="{{ route('prayer.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 hover:border-slate-400 transition-all shadow-sm font-medium text-sm">
            <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Requests
        </a>
    </div>

    <!-- Overall Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Active -->
        <div class="card p-6 border border-primary-100 shadow-sm bg-gradient-to-br from-primary-600 to-primary-700 text-white relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
            <div class="relative z-10">
                <p class="text-primary-100 text-sm font-medium mb-1">Total Active</p>
                <h3 class="text-3xl font-bold mb-2">{{ $statistics['total_active'] ?? 0 }}</h3>
                <p class="text-xs text-primary-200 bg-white/10 inline-block px-2 py-0.5 rounded">Requests being prayed for</p>
            </div>
            <div class="absolute bottom-4 right-4 text-primary-200/50 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
        </div>

        <!-- Answered Prayers -->
        <div class="card p-6 border border-emerald-100 shadow-sm bg-gradient-to-br from-emerald-500 to-emerald-600 text-white relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
            <div class="relative z-10">
                <p class="text-emerald-100 text-sm font-medium mb-1">Answered Prayers</p>
                <h3 class="text-3xl font-bold mb-2">{{ $statistics['answered_total'] ?? 0 }}</h3>
                <p class="text-xs text-emerald-100 bg-white/10 inline-block px-2 py-0.5 rounded">
                    {{ $statistics['answered_this_month'] ?? 0 }} this month
                </p>
            </div>
            <div class="absolute bottom-4 right-4 text-emerald-200/50 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Intercessors -->
        <div class="card p-6 border border-indigo-100 shadow-sm bg-gradient-to-br from-indigo-500 to-indigo-600 text-white relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
            <div class="relative z-10">
                <p class="text-indigo-100 text-sm font-medium mb-1">Active Intercessors</p>
                <h3 class="text-3xl font-bold mb-2">{{ $statistics['active_intercessors'] ?? 0 }}</h3>
                <p class="text-xs text-indigo-100 bg-white/10 inline-block px-2 py-0.5 rounded">Mobilized for prayer</p>
            </div>
            <div class="absolute bottom-4 right-4 text-indigo-200/50 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

        <!-- Avg Response Time -->
        <div class="card p-6 border border-slate-200 shadow-sm bg-white text-slate-800 relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-slate-500 text-sm font-medium mb-1">Avg Response Time</p>
                <h3 class="text-3xl font-bold mb-2">{{ $statistics['avg_response_time'] ?? '24h' }}</h3>
                <p class="text-xs text-slate-400">Time to assignment/action</p>
            </div>
            <div class="absolute bottom-4 right-4 text-slate-100 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Requests by Category -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Requests by Category</h3>
            </div>
            <div class="p-6">
                @if(count($categoryStats ?? []) > 0)
                <div class="space-y-4">
                    @foreach($categoryStats as $stat)
                    <div>
                        <div class="flex justify-between items-center text-sm mb-1">
                            <span class="font-medium text-slate-700">{{ $stat['name'] }}</span>
                            <span class="text-slate-500">{{ $stat['count'] }} requests</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5">
                            <div class="bg-primary-500 h-2.5 rounded-full" style="width: {{ $stat['percentage'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-center text-slate-500 py-8">No data available yet.</p>
                @endif
            </div>
        </div>

        <!-- Requests by Urgency -->
        <div class="card border border-slate-100 shadow-sm">
             <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Urgency Distribution</h3>
            </div>
            <div class="p-6">
                @if(count($urgencyStats ?? []) > 0)
                <div class="space-y-4">
                    @foreach($urgencyStats as $stat)
                    <div>
                         <div class="flex justify-between items-center text-sm mb-1">
                            <span class="font-medium text-slate-700 capitalize">{{ $stat['urgency'] }}</span>
                            <span class="text-slate-500">{{ $stat['count'] }} requests</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5">
                            <div class="h-2.5 rounded-full 
                                @if($stat['urgency'] === 'critical') bg-rose-500
                                @elseif($stat['urgency'] === 'high') bg-amber-500
                                @elseif($stat['urgency'] === 'normal') bg-blue-500
                                @else bg-slate-400
                                @endif" 
                                style="width: {{ $stat['percentage'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-center text-slate-500 py-8">No data available yet.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Monthly Trends (Placeholder Visualization) -->
    <div class="card border border-slate-100 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Monthly Activity Trends</h3>
        </div>
        <div class="p-6">
             @if(count($monthlyStats ?? []) > 0)
            <div class="relative h-64 flex items-end gap-2 justify-between px-4 pb-8 border-b border-slate-200">
                @foreach($monthlyStats as $stat)
                <div class="flex flex-col items-center justify-end h-full w-full group relative">
                    <div class="w-full max-w-[40px] bg-blue-100 hover:bg-blue-200 rounded-t transition-all relative group-hover:shadow-md" style="height: {{ max(5, $stat['count'] * 2) }}%">
                        <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-slate-800 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                            {{ $stat['count'] }}
                        </div>
                    </div>
                    <span class="absolute -bottom-8 text-xs text-slate-500 transform -rotate-45 origin-top-left whitespace-nowrap">{{ $stat['month'] }}</span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center text-slate-500 py-12">No monthly data available.</p>
            @endif
            <div class="mt-12 text-center">
                 <p class="text-sm text-slate-500">Prayer requests received per month</p>
            </div>
        </div>
    </div>
</div>
@endsection
