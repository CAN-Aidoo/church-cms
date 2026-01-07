@extends('layouts.app')

@section('title', 'Partnerships Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Partnerships Dashboard</h1>
            <p class="text-slate-500 mt-1">Manage strategic alliances and ministry agreements.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('partnerships.partners') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-all font-bold text-sm shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                Manage Partners
            </a>
            <a href="{{ route('partnerships.agreements') }}" class="px-5 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all font-bold text-sm shadow-md hover:shadow-lg flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                View Agreements
            </a>
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Partners -->
        <div class="card p-6 border-slate-100 flex items-center justify-between group hover:shadow-md transition-all relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Total Partners</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <h3 class="text-3xl font-bold text-slate-800">{{ number_format($statistics['total_partners'] ?? 0) }}</h3>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        Active
                    </span>
                </div>
                <p class="text-xs text-slate-400 mt-2">Churches, NGOs & Sponsors</p>
            </div>
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform relative z-10">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
            </div>
            <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
        </div>

        <!-- Active Agreements -->
        <div class="card p-6 border-slate-100 flex items-center justify-between group hover:shadow-md transition-all relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Active Agreements</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <h3 class="text-3xl font-bold text-slate-800">{{ number_format($statistics['active_agreements'] ?? 0) }}</h3>
                    <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">
                        Running
                    </span>
                </div>
                <p class="text-xs text-slate-400 mt-2">Current valid contracts</p>
            </div>
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform relative z-10">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-emerald-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
        </div>

        <!-- Pending Renewals -->
        <div class="card p-6 border-slate-100 flex items-center justify-between group hover:shadow-md transition-all relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Pending Renewals</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <h3 class="text-3xl font-bold text-slate-800">{{ number_format($statistics['pending_renewals'] ?? 0) }}</h3>
                    @if(($statistics['pending_renewals'] ?? 0) > 0)
                        <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full animate-pulse">
                            Action Needed
                        </span>
                    @else
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                            On Track
                        </span>
                    @endif
                </div>
                <p class="text-xs text-slate-400 mt-2">Expiring within 30 days</p>
            </div>
            <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform relative z-10">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-amber-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity Placeholder -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card border-slate-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                Quick Actions
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <button onclick="window.location.href='{{ route('partnerships.partners') }}'" class="p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-white hover:border-primary-200 hover:shadow-md transition-all text-left group">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    </div>
                    <span class="block font-bold text-slate-700">Add Partner</span>
                    <span class="text-xs text-slate-500">Register new organization</span>
                </button>
                <button onclick="window.location.href='{{ route('partnerships.agreements') }}'" class="p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-white hover:border-emerald-200 hover:shadow-md transition-all text-left group">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <span class="block font-bold text-slate-700">New Agreement</span>
                    <span class="text-xs text-slate-500">Draft contract or MOU</span>
                </button>
            </div>
        </div>

        <div class="card border-slate-200 shadow-sm p-6 bg-gradient-to-br from-indigo-900 to-slate-900 text-white relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="text-lg font-bold mb-2">Partnership Strategy</h3>
                <p class="text-indigo-200 text-sm mb-6 leading-relaxed">Strengthen your ministry through strategic alliances. Track commitments, manage renewals, and foster relationships with clear oversight.</p>
                <div class="flex items-center gap-2 text-xs font-mono text-indigo-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    System Active and Monitoring
                </div>
            </div>
            <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-indigo-600/20 rounded-full blur-3xl"></div>
            <div class="absolute -top-8 -right-8 w-32 h-32 bg-purple-600/20 rounded-full blur-2xl"></div>
        </div>
    </div>
</div>
@endsection
