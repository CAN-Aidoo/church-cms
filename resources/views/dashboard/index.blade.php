@extends('layouts.app')

@section('title', 'Dashboard')

@section('header')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard</h1>
                <span id="realtime-indicator" class="hidden flex items-center gap-1.5 px-2 py-1 bg-green-50 text-green-700 text-xs font-medium rounded-full border border-green-200">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    Live
                </span>
            </div>
            <div class="flex items-center gap-3 mt-1">
                <p class="text-sm text-gray-500">Overview of church activities and metrics</p>
                <span id="last-refresh" class="text-xs text-gray-400 transition-colors"></span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-sm font-medium text-gray-600">{{ now()->format('l, F j, Y') }}</span>
            </div>
            <button id="start-realtime" class="flex items-center gap-2 px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Start Live Updates
            </button>
            <button id="stop-realtime" class="hidden flex items-center gap-2 px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                </svg>
                Stop Live Updates
            </button>
        </div>
    </div>
@endsection

@section('content')
    {{-- Quick Actions --}}
    <div class="mb-8">
        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
            <a href="{{ route('members.create') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-primary-200 transition-all group">
                <div class="w-10 h-10 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center mb-3 group-hover:bg-primary-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                </div>
                <span class="text-xs font-medium text-gray-700 group-hover:text-primary-600">Add Member</span>
            </a>
            
            <a href="{{ route('attendance.mark') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-accent-200 transition-all group">
                <div class="w-10 h-10 rounded-full bg-accent-50 text-accent-600 flex items-center justify-center mb-3 group-hover:bg-accent-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                </div>
                <span class="text-xs font-medium text-gray-700 group-hover:text-accent-600">Mark Attendance</span>
            </a>

            <a href="{{ route('transactions.create') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-primary-200 transition-all group">
                <div class="w-10 h-10 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center mb-3 group-hover:bg-primary-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="text-xs font-medium text-gray-700 group-hover:text-primary-600">Record Finance</span>
            </a>

            <a href="{{ route('sms.create') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-gray-200 transition-all group">
                <div class="w-10 h-10 rounded-full bg-gray-50 text-gray-600 flex items-center justify-center mb-3 group-hover:bg-gray-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                </div>
                <span class="text-xs font-medium text-gray-700 group-hover:text-gray-600">Send SMS</span>
            </a>

            <a href="{{ route('visitors.create') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-accent-200 transition-all group">
                <div class="w-10 h-10 rounded-full bg-accent-50 text-accent-600 flex items-center justify-center mb-3 group-hover:bg-accent-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <span class="text-xs font-medium text-gray-700 group-hover:text-accent-600">Add Visitor</span>
            </a>

            <a href="{{ route('services.create') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-primary-200 transition-all group">
                <div class="w-10 h-10 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center mb-3 group-hover:bg-primary-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <span class="text-xs font-medium text-gray-700 group-hover:text-primary-600">Schedule Service</span>
            </a>
        </div>
    </div>

    {{-- Key Metrics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        <!-- Total Members -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 relative overflow-hidden group hover:shadow-md transition-all" data-realtime>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Members</p>
                    <h3 id="total-members" class="text-2xl font-bold text-primary-700 mt-1">{{ number_format($metrics['total_members']['count']) }}</h3>
                    <div class="flex items-center mt-2 text-xs">
                        @if($metrics['total_members']['change'] >= 0)
                            <span class="text-green-600 flex items-center font-medium bg-green-50 px-2 py-0.5 rounded-full">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                {{ $metrics['total_members']['change'] }}
                            </span>
                        @else
                            <span class="text-red-600 flex items-center font-medium bg-red-50 px-2 py-0.5 rounded-full">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                                {{ abs($metrics['total_members']['change']) }}
                            </span>
                        @endif
                        <span class="text-gray-400 ml-2">vs last month</span>
                    </div>
                </div>
                <div class="p-2 bg-primary-50 rounded-lg group-hover:bg-primary-100 transition-colors">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Financial Balance -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Financial Balance</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">GHS {{ number_format($metrics['financial_balance']['balance'], 2) }}</h3>
                    <div class="flex flex-col mt-2 text-xs text-gray-500">
                        <span class="flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> In: {{ number_format($metrics['financial_balance']['income'], 2) }}</span>
                        <span class="flex items-center gap-1 mt-0.5"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Out: {{ number_format($metrics['financial_balance']['expenses'], 2) }}</span>
                    </div>
                </div>
                <div class="p-2 bg-accent-50 rounded-lg group-hover:bg-accent-100 transition-colors">
                    <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Attendance Rate -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Attendance Rate</p>
                    <h3 class="text-2xl font-bold text-primary-700 mt-1">{{ $metrics['attendance_rate']['rate'] }}%</h3>
                    <p class="text-xs text-gray-400 mt-2">Avg for {{ $metrics['attendance_rate']['month'] }}</p>
                </div>
                <div class="p-2 bg-blue-50 rounded-lg group-hover:bg-blue-100 transition-colors">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
            </div>
        </div>

        <!-- Today's Attendance -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 relative overflow-hidden group hover:shadow-md transition-all" data-realtime>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Today's Attendance</p>
                    <h3 id="todays-attendance" class="text-2xl font-bold text-primary-700 mt-1">0</h3>
                    <p class="text-xs text-gray-400 mt-2">Check-ins today</p>
                </div>
                <div class="p-2 bg-blue-50 rounded-lg group-hover:bg-blue-100 transition-colors">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
            </div>
        </div>

        <!-- Today's Income -->
        <div class="bg-gradient-primary rounded-xl shadow-sm border border-primary-600 p-5 relative overflow-hidden text-white group hover:shadow-blue transition-all" data-realtime>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-primary-100 uppercase tracking-wide">Today's Income</p>
                    <h3 id="todays-income" class="text-2xl font-bold mt-1">GHS 0.00</h3>
                    <p class="text-xs text-primary-200 mt-2">Collections today</p>
                </div>
                <div class="p-2 bg-white/20 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Today's Visitors -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 relative overflow-hidden group hover:shadow-md transition-all" data-realtime>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Today's Visitors</p>
                    <h3 id="todays-visitors" class="text-2xl font-bold text-gray-900 mt-1">0</h3>
                    <p class="text-xs text-gray-400 mt-2">New today</p>
                </div>
                <div class="p-2 bg-accent-50 rounded-lg group-hover:bg-accent-100 transition-colors">
                    <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 relative overflow-hidden group hover:shadow-md transition-all" data-realtime>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pending Approvals</p>
                    <h3 id="pending-approvals" class="text-2xl font-bold text-red-600 mt-1">0</h3>
                    <p class="text-xs text-gray-400 mt-2">Require action</p>
                </div>
                <div class="p-2 bg-red-50 rounded-lg group-hover:bg-red-100 transition-colors">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Active Programs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 relative overflow-hidden group hover:shadow-md transition-all" data-realtime>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Active Programs</p>
                    <h3 id="active-programs" class="text-2xl font-bold text-gray-900 mt-1">0</h3>
                    <p class="text-xs text-gray-400 mt-2">Currently ongoing</p>
                </div>
                <div class="p-2 bg-primary-50 rounded-lg group-hover:bg-primary-100 transition-colors">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
        </div>

        <!-- New Members -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">New Members</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $metrics['new_members']['count'] }}</h3>
                    <p class="text-xs text-gray-400 mt-2">Last 30 days</p>
                </div>
                <div class="p-2 bg-green-50 rounded-lg group-hover:bg-green-100 transition-colors">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
            </div>
        </div>

        <!-- Upcoming Birthdays -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Upcoming Birthdays</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $metrics['upcoming_birthdays']['count'] }}</h3>
                    <p class="text-xs text-gray-400 mt-2">Next 30 days</p>
                </div>
                <div class="p-2 bg-accent-50 rounded-lg group-hover:bg-accent-100 transition-colors">
                    <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"/></svg>
                </div>
            </div>
        </div>

        <!-- Visitors -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Recent Visitors</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $metrics['recent_visitors'] }}</h3>
                    <p class="text-xs text-gray-400 mt-2">Last 30 days</p>
                </div>
                <div class="p-2 bg-primary-50 rounded-lg group-hover:bg-primary-100 transition-colors">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            </div>
        </div>

        <!-- Active Service Units -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Service Units</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $metrics['service_units'] }}</h3>
                    <p class="text-xs text-gray-400 mt-2">Active units</p>
                </div>
                <div class="p-2 bg-gray-50 rounded-lg group-hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Real-time Activity Feed --}}
    <div class="mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-primary-50 to-accent-50">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <h3 class="font-bold text-gray-900 text-sm">Live Activity Feed</h3>
                    <span class="hidden" id="activity-live-badge">
                        <span class="flex items-center gap-1.5 px-2 py-0.5 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                            <span class="relative flex h-1.5 w-1.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-green-500"></span>
                            </span>
                            Live
                        </span>
                    </span>
                </div>
                <button id="refresh-activity" class="text-xs text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Refresh
                </button>
            </div>
            <div id="activity-feed" class="p-4 max-h-96 overflow-y-auto space-y-2">
                <div class="p-6 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm">Start live updates to see real-time activity</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
        <!-- Financial Trend -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-bold text-gray-900 mb-4 pl-3 border-l-4 border-primary-500">Financial Trend</h3>
            <div class="h-56 w-full">
                <canvas id="financialChart"></canvas>
            </div>
        </div>

        <!-- Monthly Attendance -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-bold text-gray-900 mb-4 pl-3 border-l-4 border-accent-500">Attendance Trend</h3>
            <div class="h-56 w-full">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>

        <!-- Gender Distribution -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-bold text-gray-900 mb-4 pl-3 border-l-4 border-primary-500">Gender Distribution</h3>
            <div class="h-56 w-full">
                <canvas id="genderChart"></canvas>
            </div>
        </div>

        <!-- Age Distribution -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-bold text-gray-900 mb-4 pl-3 border-l-4 border-accent-500">Age Demographics</h3>
            <div class="h-56 w-full">
                <canvas id="ageChart"></canvas>
            </div>
        </div>

        <!-- Member Status -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-bold text-gray-900 mb-4 pl-3 border-l-4 border-primary-500">Member Status</h3>
            <div class="h-56 w-full">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Weekly Activity -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-bold text-gray-900 mb-4 pl-3 border-l-4 border-accent-500">Weekly Activity</h3>
            <div class="h-56 w-full">
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>
        
        <!-- Service Units -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-bold text-gray-900 mb-4 pl-3 border-l-4 border-primary-500">Service Unit Distribution</h3>
            <div class="h-56 w-full">
                <canvas id="serviceUnitsChart"></canvas>
            </div>
        </div>

        <!-- Shepherd Groups -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-bold text-gray-900 mb-4 pl-3 border-l-4 border-accent-500">Shepherd Group Distribution</h3>
            <div class="h-56 w-full">
                <canvas id="shepherdChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Recent Items Section --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Left Col -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Recent Members -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-900 text-sm">Recent Members</h3>
                    <a href="{{ route('members.index') }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-50">
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentItems['recent_members'] as $member)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-3">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-xs">
                                                {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $member->full_name }}</div>
                                                <div class="text-xs text-gray-500">{{ $member->phone }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3">
                                        <span class="px-2 py-0.5 inline-flex text-xs leading-4 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-xs text-gray-500 text-right">
                                        {{ $member->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500 text-sm">No recent members</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Visitors -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-900 text-sm">Recent Visitors</h3>
                    <a href="{{ route('visitors.index') }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-50">
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentItems['recent_visitors'] as $visitor)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-3">
                                        <div class="flex items-center">
                                            <div class="ml-0">
                                                <div class="text-sm font-medium text-gray-900">{{ $visitor->full_name }}</div>
                                                <div class="text-xs text-gray-500">{{ $visitor->phone }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-xs text-gray-500">
                                        {{ $visitor->visit_count }} visits
                                    </td>
                                    <td class="px-6 py-3 text-xs text-gray-500 text-right">
                                        {{ $visitor->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500 text-sm">No recent visitors</td>
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
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-900 text-sm">Recent Finance</h3>
                    <a href="{{ route('transactions.index') }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium">View All</a>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($recentItems['recent_transactions'] as $transaction)
                        <div class="px-6 py-3 hover:bg-gray-50 transition-colors">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $transaction->category }}</p>
                                    <p class="text-xs text-gray-500">{{ $transaction->member->full_name ?? 'Anonymous' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type == 'income' ? '+' : '-' }}GHS {{ number_format($transaction->amount, 2) }}
                                    </p>
                                    <p class="text-xs text-gray-400">{{ $transaction->transaction_date->format('M d') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="px-6 py-4 text-center text-gray-500 text-sm">No recent transactions</p>
                    @endforelse
                </div>
            </div>

            <!-- Birthdays Today -->
            <div class="bg-gradient-primary rounded-xl shadow-sm p-5 text-white shadow-blue">
                <h3 class="font-bold mb-4 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"/></svg>
                    Birthdays Today
                </h3>
                @if(count($recentItems['todays_birthdays']) > 0)
                    <div class="space-y-2">
                        @foreach($recentItems['todays_birthdays'] as $member)
                            <div class="flex items-center gap-3 bg-white/10 p-2 rounded-lg backdrop-blur-sm">
                                <div class="h-8 w-8 rounded-full bg-white text-primary-600 flex items-center justify-center font-bold text-xs">
                                    {{ substr($member->first_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium">{{ $member->full_name }}</p>
                                    <p class="text-xs text-white/70">{{ $member->age }} years old</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-white/70">No birthdays today.</p>
                @endif
            </div>

            <!-- Pending Counselling -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-900 mb-4 text-sm">Pending Counselling</h3>
                @if(isset($recentItems['pending_counselling']) && count($recentItems['pending_counselling']) > 0)
                    <ul class="space-y-2">
                        @foreach($recentItems['pending_counselling'] as $session)
                            <li class="text-sm text-gray-600 flex justify-between items-center p-2 hover:bg-gray-50 rounded">
                                <span>{{ $session->member->full_name ?? 'Unknown' }}</span>
                                <span class="text-xs bg-accent-100 text-accent-800 px-2 py-0.5 rounded-full border border-accent-200">{{ $session->status }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-xs text-gray-500">No pending sessions.</p>
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