@extends('layouts.app')

@section('title', 'Dashboard')

@section('header')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-3xl font-heading font-bold text-slate-900 tracking-tight">Dashboard</h1>
                <span id="realtime-indicator" class="hidden flex items-center gap-1.5 px-2.5 py-1 bg-green-50 text-green-700 text-xs font-medium rounded-full border border-green-200 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    Live Updates
                </span>
            </div>
            <div class="flex items-center gap-3 mt-1.5">
                <p class="text-slate-500">Overview of church performance and daily activities</p>
                <span id="last-refresh" class="text-xs text-slate-400 transition-colors border-l border-slate-200 pl-3"></span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-3 bg-white px-4 py-2.5 rounded-xl shadow-sm border border-slate-100">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-sm font-medium text-slate-700">{{ now()->format('l, F j, Y') }}</span>
            </div>
            <button id="start-realtime" class="btn btn-primary shadow-blue-500/20">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Start Live
            </button>
            <button id="stop-realtime" class="hidden btn bg-red-600 text-white hover:bg-red-700 shadow-red-500/20">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                </svg>
                Stop Live
            </button>
        </div>
    </div>
@endsection

@section('content')
    {{-- Quick Actions --}}
    <div class="mb-10">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-5 pl-1">Quick Actions</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-5">
            <a href="{{ route('members.create') }}" class="card hover:shadow-card-hover group flex flex-col items-center justify-center p-6 transition-all duration-300 border border-slate-100">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shadow-sm group-hover:shadow-blue-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                </div>
                <span class="text-sm font-medium text-slate-700 group-hover:text-blue-600 transition-colors">Add Member</span>
            </a>
            
            <a href="{{ route('attendance.mark') }}" class="card hover:shadow-card-hover group flex flex-col items-center justify-center p-6 transition-all duration-300 border border-slate-100">
                <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300 shadow-sm group-hover:shadow-orange-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                </div>
                <span class="text-sm font-medium text-slate-700 group-hover:text-orange-600 transition-colors">Mark Check-in</span>
            </a>

            <a href="{{ route('transactions.create') }}" class="card hover:shadow-card-hover group flex flex-col items-center justify-center p-6 transition-all duration-300 border border-slate-100">
                <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mb-4 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300 shadow-sm group-hover:shadow-green-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="text-sm font-medium text-slate-700 group-hover:text-green-600 transition-colors">Record Finance</span>
            </a>

            <a href="{{ route('sms.create') }}" class="card hover:shadow-card-hover group flex flex-col items-center justify-center p-6 transition-all duration-300 border border-slate-100">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-4 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300 shadow-sm group-hover:shadow-purple-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                </div>
                <span class="text-sm font-medium text-slate-700 group-hover:text-purple-600 transition-colors">Send Broadcast</span>
            </a>

            <a href="{{ route('visitors.create') }}" class="card hover:shadow-card-hover group flex flex-col items-center justify-center p-6 transition-all duration-300 border border-slate-100">
                <div class="w-12 h-12 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center mb-4 group-hover:bg-pink-600 group-hover:text-white transition-colors duration-300 shadow-sm group-hover:shadow-pink-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <span class="text-sm font-medium text-slate-700 group-hover:text-pink-600 transition-colors">New Visitor</span>
            </a>

            <a href="{{ route('services.create') }}" class="card hover:shadow-card-hover group flex flex-col items-center justify-center p-6 transition-all duration-300 border border-slate-100">
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center mb-4 group-hover:bg-teal-600 group-hover:text-white transition-colors duration-300 shadow-sm group-hover:shadow-teal-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <span class="text-sm font-medium text-slate-700 group-hover:text-teal-600 transition-colors">Schedule Event</span>
            </a>
        </div>
    </div>

    {{-- Key Metrics --}}
    {{-- Key Metrics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-10">
        <!-- Total Members -->
        <div class="card p-5 relative overflow-hidden group hover:shadow-card-hover transition-all border border-slate-100" data-realtime>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Members</p>
                    <h3 id="total-members" class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ number_format($metrics['total_members']['count']) }}</h3>
                    <div class="flex items-center mt-3 text-xs">
                        @if($metrics['total_members']['change'] >= 0)
                            <span class="text-emerald-600 flex items-center font-medium bg-emerald-50 px-2 py-0.5 rounded-md">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                {{ $metrics['total_members']['change'] }}
                            </span>
                        @else
                            <span class="text-red-600 flex items-center font-medium bg-red-50 px-2 py-0.5 rounded-md">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                                {{ abs($metrics['total_members']['change']) }}
                            </span>
                        @endif
                        <span class="text-slate-400 ml-2">vs last month</span>
                    </div>
                </div>
                <div class="p-3 bg-blue-50 rounded-xl group-hover:bg-blue-100 transition-colors">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Financial Balance -->
        <div class="card p-5 relative overflow-hidden group hover:shadow-card-hover transition-all border border-slate-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Financial Balance</p>
                    <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">GHS {{ number_format($metrics['financial_balance']['balance'], 2) }}</h3>
                    <div class="flex flex-col mt-3 text-xs text-slate-500 gap-1">
                        <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> In: <span class="font-medium text-slate-700">{{ number_format($metrics['financial_balance']['income'], 2) }}</span></span>
                        <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Out: <span class="font-medium text-slate-700">{{ number_format($metrics['financial_balance']['expenses'], 2) }}</span></span>
                    </div>
                </div>
                <div class="p-3 bg-emerald-50 rounded-xl group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Attendance Rate -->
        <div class="card p-5 relative overflow-hidden group hover:shadow-card-hover transition-all border border-slate-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Attendance Rate</p>
                    <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $metrics['attendance_rate']['rate'] }}%</h3>
                    <p class="text-xs text-slate-400 mt-3">Avg for {{ $metrics['attendance_rate']['month'] }}</p>
                </div>
                <div class="p-3 bg-indigo-50 rounded-xl group-hover:bg-indigo-100 transition-colors">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
            </div>
        </div>

        <!-- Today's Attendance -->
        <div class="card p-5 relative overflow-hidden group hover:shadow-card-hover transition-all border border-slate-100" data-realtime>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Today's Attendance</p>
                    <h3 id="todays-attendance" class="text-3xl font-heading font-bold text-slate-900 mt-2">0</h3>
                    <p class="text-xs text-slate-400 mt-3">Check-ins today</p>
                </div>
                <div class="p-3 bg-amber-50 rounded-xl group-hover:bg-amber-100 transition-colors">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
            </div>
        </div>

        <!-- Today's Income -->
        <div class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl shadow-lg shadow-primary-500/30 p-5 relative overflow-hidden text-white group hover:shadow-primary-500/40 transition-all border border-white/10" data-realtime>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-primary-100 uppercase tracking-wider">Today's Income</p>
                    <h3 id="todays-income" class="text-3xl font-heading font-bold mt-2">GHS 0.00</h3>
                    <p class="text-xs text-primary-200 mt-3">Collections today</p>
                </div>
                <div class="p-3 bg-white/10 rounded-xl backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Today's Visitors -->
        <div class="card p-5 relative overflow-hidden group hover:shadow-card-hover transition-all border border-slate-100" data-realtime>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Today's Visitors</p>
                    <h3 id="todays-visitors" class="text-3xl font-heading font-bold text-slate-900 mt-2">0</h3>
                    <p class="text-xs text-slate-400 mt-3">New today</p>
                </div>
                <div class="p-3 bg-pink-50 rounded-xl group-hover:bg-pink-100 transition-colors">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="card p-5 relative overflow-hidden group hover:shadow-card-hover transition-all border border-slate-100" data-realtime>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pending Approvals</p>
                    <h3 id="pending-approvals" class="text-3xl font-heading font-bold text-red-600 mt-2">0</h3>
                    <p class="text-xs text-slate-400 mt-3">Require action</p>
                </div>
                <div class="p-3 bg-red-50 rounded-xl group-hover:bg-red-100 transition-colors">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Active Programs -->
        <div class="card p-5 relative overflow-hidden group hover:shadow-card-hover transition-all border border-slate-100" data-realtime>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Programs</p>
                    <h3 id="active-programs" class="text-3xl font-heading font-bold text-slate-900 mt-2">0</h3>
                    <p class="text-xs text-slate-400 mt-3">Currently ongoing</p>
                </div>
                <div class="p-3 bg-purple-50 rounded-xl group-hover:bg-purple-100 transition-colors">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
        </div>

        <!-- New Members -->
        <div class="card p-5 relative overflow-hidden group hover:shadow-card-hover transition-all border border-slate-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">New Members</p>
                    <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $metrics['new_members']['count'] }}</h3>
                    <p class="text-xs text-slate-400 mt-3">Last 30 days</p>
                </div>
                <div class="p-3 bg-teal-50 rounded-xl group-hover:bg-teal-100 transition-colors">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
            </div>
        </div>

        <!-- Upcoming Birthdays -->
        <div class="card p-5 relative overflow-hidden group hover:shadow-card-hover transition-all border border-slate-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Upcoming Birthdays</p>
                    <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $metrics['upcoming_birthdays']['count'] }}</h3>
                    <p class="text-xs text-slate-400 mt-3">Next 30 days</p>
                </div>
                <div class="p-3 bg-yellow-50 rounded-xl group-hover:bg-yellow-100 transition-colors">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"/></svg>
                </div>
            </div>
        </div>

        <!-- Visitors -->
        <div class="card p-5 relative overflow-hidden group hover:shadow-card-hover transition-all border border-slate-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Recent Visitors</p>
                    <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $metrics['recent_visitors'] }}</h3>
                    <p class="text-xs text-slate-400 mt-3">Last 30 days</p>
                </div>
                <div class="p-3 bg-cyan-50 rounded-xl group-hover:bg-cyan-100 transition-colors">
                    <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            </div>
        </div>

        <!-- Active Service Units -->
        <div class="card p-5 relative overflow-hidden group hover:shadow-card-hover transition-all border border-slate-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Service Units</p>
                    <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $metrics['service_units'] }}</h3>
                    <p class="text-xs text-slate-400 mt-3">Active units</p>
                </div>
                <div class="p-3 bg-violet-50 rounded-xl group-hover:bg-violet-100 transition-colors">
                    <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Real-time Activity Feed --}}
    <div class="mb-10">
        <div class="card overflow-hidden border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 bg-blue-100/50 rounded-lg">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">Live Activity Feed</h3>
                    <span class="hidden" id="activity-live-badge">
                        <span class="flex items-center gap-1.5 px-2 py-0.5 bg-emerald-100 text-emerald-700 text-xs font-medium rounded-full">
                            <span class="relative flex h-1.5 w-1.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                            </span>
                            Live
                        </span>
                    </span>
                </div>
                <button id="refresh-activity" class="text-xs text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1.5 px-2 py-1 rounded-md hover:bg-slate-50 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Refresh
                </button>
            </div>
            <div id="activity-feed" class="p-4 max-h-96 overflow-y-auto space-y-3 bg-white">
                <div class="p-8 text-center text-slate-400">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium">Start live updates to see real-time activity</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-10">
        <!-- Financial Trend -->
        <div class="card p-6 border border-slate-100">
            <h3 class="text-sm font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span class="w-1 h-4 bg-primary-500 rounded-full"></span>
                Financial Trend
            </h3>
            <div class="h-64 w-full">
                <canvas id="financialChart"></canvas>
            </div>
        </div>

        <!-- Monthly Attendance -->
        <div class="card p-6 border border-slate-100">
            <h3 class="text-sm font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span class="w-1 h-4 bg-amber-500 rounded-full"></span>
                Attendance Trend
            </h3>
            <div class="h-64 w-full">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>

        <!-- Gender Distribution -->
        <div class="card p-6 border border-slate-100">
            <h3 class="text-sm font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span class="w-1 h-4 bg-primary-500 rounded-full"></span>
                Gender Distribution
            </h3>
            <div class="h-64 w-full">
                <canvas id="genderChart"></canvas>
            </div>
        </div>

        <!-- Age Distribution -->
        <div class="card p-6 border border-slate-100">
            <h3 class="text-sm font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span class="w-1 h-4 bg-amber-500 rounded-full"></span>
                Age Demographics
            </h3>
            <div class="h-64 w-full">
                <canvas id="ageChart"></canvas>
            </div>
        </div>

        <!-- Member Status -->
        <div class="card p-6 border border-slate-100">
            <h3 class="text-sm font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span class="w-1 h-4 bg-primary-500 rounded-full"></span>
                Member Status
            </h3>
            <div class="h-64 w-full">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Weekly Activity -->
        <div class="card p-6 border border-slate-100">
            <h3 class="text-sm font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span class="w-1 h-4 bg-amber-500 rounded-full"></span>
                Weekly Activity
            </h3>
            <div class="h-64 w-full">
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>
        
        <!-- Service Units -->
        <div class="card p-6 border border-slate-100">
            <h3 class="text-sm font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span class="w-1 h-4 bg-primary-500 rounded-full"></span>
                Service Unit Distribution
            </h3>
            <div class="h-64 w-full">
                <canvas id="serviceUnitsChart"></canvas>
            </div>
        </div>

        <!-- Shepherd Groups -->
        <div class="card p-6 border border-slate-100">
            <h3 class="text-sm font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span class="w-1 h-4 bg-amber-500 rounded-full"></span>
                Shepherd Group Distribution
            </h3>
            <div class="h-64 w-full">
                <canvas id="shepherdChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Recent Items Section --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Left Col -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Recent Members -->
            <div class="card overflow-hidden border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-sm">Recent Members</h3>
                    <a href="{{ route('members.index') }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <tbody class="divide-y divide-slate-50">
                            @forelse($recentItems['recent_members'] as $member)
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-9 w-9 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-xs ring-2 ring-white shadow-sm">
                                                {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-slate-900 group-hover:text-primary-600 transition-colors">{{ $member->full_name }}</div>
                                                <div class="text-xs text-slate-500">{{ $member->phone }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-4 font-medium rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-400 text-right">
                                        {{ $member->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-slate-500 text-sm">No recent members</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Visitors -->
            <div class="card overflow-hidden border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-sm">Recent Visitors</h3>
                    <a href="{{ route('visitors.index') }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <tbody class="divide-y divide-slate-50">
                            @forelse($recentItems['recent_visitors'] as $visitor)
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="ml-0">
                                                <div class="text-sm font-medium text-slate-900 group-hover:text-primary-600 transition-colors">{{ $visitor->full_name }}</div>
                                                <div class="text-xs text-slate-500">{{ $visitor->phone }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-500">
                                        <span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md font-medium">{{ $visitor->visit_count }} visits</span>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-400 text-right">
                                        {{ $visitor->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-slate-500 text-sm">No recent visitors</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Col -->
        <div class="space-y-6">
            <!-- Recent Transactions -->
            <div class="card overflow-hidden border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-sm">Recent Finance</h3>
                    <a href="{{ route('transactions.index') }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium hover:underline">View All</a>
                </div>
                <div class="divide-y divide-slate-50">
                    @forelse($recentItems['recent_transactions'] as $transaction)
                        <div class="px-6 py-4 hover:bg-slate-50/80 transition-colors group">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-slate-900 group-hover:text-primary-600 transition-colors">{{ $transaction->category }}</p>
                                    <p class="text-xs text-slate-500">{{ $transaction->member->full_name ?? 'Anonymous' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold {{ $transaction->type == 'income' ? 'text-emerald-600' : 'text-red-600' }}">
                                        {{ $transaction->type == 'income' ? '+' : '-' }}GHS {{ number_format($transaction->amount, 2) }}
                                    </p>
                                    <p class="text-xs text-slate-400">{{ $transaction->transaction_date->format('M d') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="px-6 py-8 text-center text-slate-500 text-sm">No recent transactions</p>
                    @endforelse
                </div>
            </div>

            <!-- Birthdays Today -->
            <div class="bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl shadow-lg shadow-primary-500/30 p-6 text-white relative overflow-hidden">
                <!-- Decorative Circle -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                
                <h3 class="font-bold mb-5 flex items-center gap-2 text-sm z-10 relative">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"/></svg>
                    Birthdays Today
                </h3>
                @if(count($recentItems['todays_birthdays']) > 0)
                    <div class="space-y-3 relative z-10">
                        @foreach($recentItems['todays_birthdays'] as $member)
                            <div class="flex items-center gap-3 bg-white/10 p-2.5 rounded-xl backdrop-blur-sm hover:bg-white/20 transition-colors border border-white/10">
                                <div class="h-9 w-9 rounded-full bg-white text-primary-600 flex items-center justify-center font-bold text-xs shadow-sm">
                                    {{ substr($member->first_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium">{{ $member->full_name }}</p>
                                    <p class="text-xs text-white/80">{{ $member->age }} years old</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-white/70 bg-white/5 p-4 rounded-xl text-center border border-white/5">No birthdays today.</p>
                @endif
            </div>

            <!-- Pending Counselling -->
            <div class="card overflow-hidden border border-slate-100 p-6">
                <h3 class="font-bold text-slate-800 mb-5 text-sm">Pending Counselling</h3>
                @if(isset($recentItems['pending_counselling']) && count($recentItems['pending_counselling']) > 0)
                    <ul class="space-y-2">
                        @foreach($recentItems['pending_counselling'] as $session)
                            <li class="text-sm text-slate-600 flex justify-between items-center p-3 hover:bg-slate-50 rounded-lg transition-colors border border-transparent hover:border-slate-100">
                                <span class="font-medium">{{ $session->member->full_name ?? 'Unknown' }}</span>
                                <span class="text-xs bg-amber-100 text-amber-800 px-2.5 py-0.5 rounded-full font-medium">{{ $session->status }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-slate-500 text-center py-4 bg-slate-50 rounded-xl border border-slate-100 border-dashed">No pending sessions.</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    @keyframes pulse-once {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .pulse-once {
        animation: pulse-once 0.5s ease-in-out;
    }

    #activity-feed::-webkit-scrollbar {
        width: 6px;
    }

    #activity-feed::-webkit-scrollbar-track {
        background: #f3f4f6;
        border-radius: 3px;
    }

    #activity-feed::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 3px;
    }

    #activity-feed::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="{{ asset('js/dashboard-realtime.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const charts = @json($charts);
        
        // Theme Colors
        const colors = {
            primary: '#2563eb', // Blue 600
            secondary: '#1d4ed8', // Blue 700
            accent: '#eab308', // Gold
            success: '#22c55e',
            danger: '#ef4444',
            gray: '#9ca3af',
            primaryLight: '#dbeafe', // Blue 100
            accentLight: '#fef9c3', // Yellow 100
        };

        // Common Chart Options
        const commonOptions = {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 6,
                        padding: 15,
                        font: { family: "'Inter', sans-serif", size: 11 }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(17, 24, 39, 0.9)',
                    titleFont: { family: "'Inter', sans-serif", size: 13 },
                    bodyFont: { family: "'Inter', sans-serif", size: 12 },
                    padding: 10,
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    grid: { color: '#f3f4f6', drawBorder: false },
                    ticks: { font: { family: "'Inter', sans-serif", size: 10 }, color: '#6b7280', padding: 8 }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { family: "'Inter', sans-serif", size: 10 }, color: '#6b7280', autoSkip: true, maxRotation: 0 }
                }
            },
            layout: {
                padding: 0
            },
            elements: {
                bar: { borderRadius: 4 },
                line: { tension: 0.4 }
            }
        };

        // 1. Financial Trend (Bar)
        new Chart(document.getElementById('financialChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(charts.financial_trend.income),
                datasets: [
                    { 
                        label: 'Income', 
                        data: Object.values(charts.financial_trend.income), 
                        backgroundColor: colors.primary, 
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    },
                    { 
                        label: 'Expenses', 
                        data: Object.values(charts.financial_trend.expenses), 
                        backgroundColor: colors.accent, 
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    }
                ]
            },
            options: commonOptions
        });

        // 2. Attendance Trend (Line)
        new Chart(document.getElementById('attendanceChart'), {
            type: 'line',
            data: {
                labels: Object.keys(charts.monthly_attendance),
                datasets: [{
                    label: 'Attendance',
                    data: Object.values(charts.monthly_attendance),
                    borderColor: colors.primary,
                    backgroundColor: 'rgba(37, 99, 235, 0.05)',
                    borderWidth: 2,
                    fill: true,
                    pointRadius: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: colors.primary,
                    pointHoverRadius: 5
                }]
            },
            options: commonOptions
        });

        // 3. Gender Distribution (Doughnut)
        new Chart(document.getElementById('genderChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(charts.gender_distribution),
                datasets: [{
                    data: Object.values(charts.gender_distribution),
                    backgroundColor: [colors.primary, colors.accent],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                ...commonOptions,
                cutout: '75%',
                scales: { x: { display: false }, y: { display: false } }
            }
        });

        // 4. Age Distribution (Horizontal Bar)
        new Chart(document.getElementById('ageChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(charts.age_distribution),
                datasets: [{
                    label: 'Count',
                    data: Object.values(charts.age_distribution),
                    backgroundColor: colors.primary,
                }]
            },
            options: { 
                ...commonOptions, 
                indexAxis: 'y',
                scales: { 
                    x: { grid: { color: '#f3f4f6' }, ticks: { display: false } },
                    y: { grid: { display: false } }
                } 
            }
        });

        // 5. Member Status (Stacked Bar)
        new Chart(document.getElementById('statusChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(charts.member_status),
                datasets: [{
                    label: 'Count',
                    data: Object.values(charts.member_status),
                    backgroundColor: [colors.primary, colors.accent, colors.gray, colors.danger],
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    x: { grid: { display: false } },
                    y: { display: false }
                }
            }
        });

        // 6. Weekly Activity (Bar)
        new Chart(document.getElementById('weeklyChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(charts.weekly_activity),
                datasets: [{
                    label: 'Activity',
                    data: Object.values(charts.weekly_activity),
                    backgroundColor: colors.accent,
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    x: { grid: { display: false } },
                    y: { display: false }
                }
            }
        });

        // 7. Service Units Distribution (Bar)
        new Chart(document.getElementById('serviceUnitsChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(charts.service_units_distribution),
                datasets: [{
                    label: 'Members',
                    data: Object.values(charts.service_units_distribution),
                    backgroundColor: colors.primary,
                }]
            },
            options: { 
                ...commonOptions, 
                indexAxis: 'y',
                scales: { 
                    x: { display: false },
                    y: { grid: { display: false } }
                } 
            }
        });

        // 8. Shepherd Groups (Bar)
        new Chart(document.getElementById('shepherdChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(charts.shepherd_distribution),
                datasets: [{
                    label: 'Members',
                    data: Object.values(charts.shepherd_distribution),
                    backgroundColor: colors.accent,
                }]
            },
            options: { 
                ...commonOptions, 
                indexAxis: 'y',
                scales: { 
                    x: { display: false },
                    y: { grid: { display: false } }
                } 
            }
        });

        // Initialize Real-time Dashboard
        const dashboardRealtime = new DashboardRealtime({
            updateInterval: 10000, // Update every 10 seconds
            statsEndpoint: '/api/v1/dashboard/stats',
            chartsEndpoint: '/api/v1/dashboard/charts',
            activityEndpoint: '/api/v1/dashboard/recent-activity'
        });

        // Store dashboard instance globally
        window.dashboardRealtime = dashboardRealtime;

        // Start/Stop button handlers
        const startBtn = document.getElementById('start-realtime');
        const stopBtn = document.getElementById('stop-realtime');
        const realtimeIndicator = document.getElementById('realtime-indicator');
        const activityBadge = document.getElementById('activity-live-badge');

        if (startBtn) {
            startBtn.addEventListener('click', function() {
                dashboardRealtime.start();
                startBtn.classList.add('hidden');
                stopBtn.classList.remove('hidden');
                realtimeIndicator.classList.remove('hidden');
                activityBadge.classList.remove('hidden');
            });
        }

        if (stopBtn) {
            stopBtn.addEventListener('click', function() {
                dashboardRealtime.stop();
                stopBtn.classList.add('hidden');
                startBtn.classList.remove('hidden');
                realtimeIndicator.classList.add('hidden');
                activityBadge.classList.add('hidden');
            });
        }

        // Manual refresh activity button
        const refreshActivityBtn = document.getElementById('refresh-activity');
        if (refreshActivityBtn) {
            refreshActivityBtn.addEventListener('click', function() {
                dashboardRealtime.updateActivity();

                // Add spin animation
                const icon = this.querySelector('svg');
                icon.classList.add('animate-spin');
                setTimeout(() => {
                    icon.classList.remove('animate-spin');
                }, 500);
            });
        }

        // Register chart instances for real-time updates
        dashboardRealtime.registerChart('financial', window.Chart.getChart('financialChart'));
        dashboardRealtime.registerChart('attendance', window.Chart.getChart('attendanceChart'));

        console.log('Dashboard initialized with real-time capabilities');
    });
</script>
@endpush