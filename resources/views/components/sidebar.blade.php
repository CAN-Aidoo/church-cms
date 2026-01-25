<aside x-data="{
    memberManagement: false,
    attendance: false,
    finance: false,
    communications: false,
    visitors: false,
    programs: false,
    prayer: false,
    milestones: false,
    counselling: false,
    childrensMinistry: false,
    welfare: false,
    media: false,
    qrManagement: false,
    partnerships: false,
    reports: false,
    settings: false
}" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition-transform duration-300 transform bg-gradient-sidebar border-r border-white/5 -translate-x-full lg:translate-x-0 shadow-2xl" :class="{ 'translate-x-0': sidebarOpen }">

    <!-- Logo -->
    <div class="flex items-center justify-center mt-8 mb-8">
        <img src="{{ asset('images/sonlife-logo.png') }}"
             alt="Sonlife City Church"
             class="h-12 w-auto">
    </div>

    <nav class="px-4 pb-6">
        <!-- Dashboard -->
        <a class="flex items-center px-4 py-3 text-white rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white/20 shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10' }}" href="{{ route('dashboard') }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>
            <span class="mx-3 font-medium">Dashboard</span>
        </a>

        @if(auth()->user()->hasAnyRole(['admin', 'pastor', 'staff']))
        <!-- MEMBER MANAGEMENT -->
        <div class="mt-4">
            <button @click="memberManagement = !memberManagement" class="flex items-center justify-between w-full px-4 py-2 text-white/60 hover:text-white transition-colors text-xs font-semibold uppercase tracking-wider">
                <span>Member Management</span>
                <svg :class="memberManagement ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="memberManagement" x-collapse class="mt-2 space-y-1">
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('members.*') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('members.index') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="mx-3 text-sm">Members</span>
                </a>
                @if(auth()->user()->hasAnyRole(['admin', 'pastor']))
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('shepherds.*') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('shepherds.index') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="mx-3 text-sm">Shepherds</span>
                </a>
                @endif
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('service-units.*') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('service-units.index') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span class="mx-3 text-sm">Service Units</span>
                </a>
            </div>
        </div>

        <!-- ATTENDANCE -->
        <div class="mt-4">
            <button @click="attendance = !attendance" class="flex items-center justify-between w-full px-4 py-2 text-white/60 hover:text-white transition-colors text-xs font-semibold uppercase tracking-wider">
                <span>Attendance</span>
                <svg :class="attendance ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="attendance" x-collapse class="mt-2 space-y-1">
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('attendance.mark') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('attendance.mark') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    <span class="mx-3 text-sm">Mark Attendance</span>
                </a>
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('attendance.index') || request()->routeIs('attendance.reports') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('attendance.index') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="mx-3 text-sm">Attendance Reports</span>
                </a>
            </div>
        </div>

        <!-- FINANCE -->
        <div class="mt-4">
            <button @click="finance = !finance" class="flex items-center justify-between w-full px-4 py-2 text-white/60 hover:text-white transition-colors text-xs font-semibold uppercase tracking-wider">
                <span>Finance</span>
                <svg :class="finance ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="finance" x-collapse class="mt-2 space-y-1">
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('transactions.*') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('transactions.index') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="mx-3 text-sm">Transactions</span>
                </a>
                @if(auth()->user()->hasAnyRole(['admin', 'pastor']))
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('transactions.pending') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('transactions.pending') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="mx-3 text-sm">Pending Approvals</span>
                </a>
                @endif
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('transactions.reports') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('transactions.reports') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                    </svg>
                    <span class="mx-3 text-sm">Financial Reports</span>
                </a>
            </div>
        </div>

        <!-- COMMUNICATIONS -->
        <div class="mt-4">
            <button @click="communications = !communications" class="flex items-center justify-between w-full px-4 py-2 text-white/60 hover:text-white transition-colors text-xs font-semibold uppercase tracking-wider">
                <span>Communications</span>
                <svg :class="communications ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="communications" x-collapse class="mt-2 space-y-1">
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('sms.*') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('sms.index') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    <span class="mx-3 text-sm">SMS Broadcast</span>
                </a>
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('notifications.*') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('notifications.index') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="mx-3 text-sm">Notifications</span>
                </a>
            </div>
        </div>

        <!-- VISITORS -->
        <div class="mt-4">
            <button @click="visitors = !visitors" class="flex items-center justify-between w-full px-4 py-2 text-white/60 hover:text-white transition-colors text-xs font-semibold uppercase tracking-wider">
                <span>Visitors</span>
                <svg :class="visitors ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="visitors" x-collapse class="mt-2 space-y-1">
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('visitors.index') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('visitors.index') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="mx-3 text-sm">All Visitors</span>
                </a>
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('visitors.eligible') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('visitors.eligible') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="mx-3 text-sm">Eligible for Conversion</span>
                </a>
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('visitors.followUp') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('visitors.followUp') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span class="mx-3 text-sm">Follow-up List</span>
                </a>
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('visitors.reports') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('visitors.reports') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="mx-3 text-sm">Visitor Reports</span>
                </a>
            </div>
        </div>

        <!-- PROGRAMS & EVENTS -->
        <div class="mt-4">
            <button @click="programs = !programs" class="flex items-center justify-between w-full px-4 py-2 text-white/60 hover:text-white transition-colors text-xs font-semibold uppercase tracking-wider">
                <span>Programs & Events</span>
                <svg :class="programs ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="programs" x-collapse class="mt-2 space-y-1">
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('programs.*') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('programs.index') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="mx-3 text-sm">All Programs</span>
                </a>
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('services.*') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('services.index') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    <span class="mx-3 text-sm">Service Planning</span>
                </a>
            </div>
        </div>

        <!-- MILESTONES -->
        <div class="mt-4">
            <button @click="milestones = !milestones" class="flex items-center justify-between w-full px-4 py-2 text-white/60 hover:text-white transition-colors text-xs font-semibold uppercase tracking-wider">
                <span>Milestones</span>
                <svg :class="milestones ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="milestones" x-collapse class="mt-2 space-y-1">
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('birthdays.*') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('birthdays.index') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"/>
                    </svg>
                    <span class="mx-3 text-sm">Birthdays</span>
                </a>
            </div>
        </div>
        @endif

        @if(auth()->user()->hasAnyRole(['admin', 'pastor']))
        <!-- COUNSELLING -->
        <div class="mt-4">
            <button @click="counselling = !counselling" class="flex items-center justify-between w-full px-4 py-2 text-white/60 hover:text-white transition-colors text-xs font-semibold uppercase tracking-wider">
                <span>Counselling</span>
                <svg :class="counselling ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="counselling" x-collapse class="mt-2 space-y-1">
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('counselling.index') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('counselling.index') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span class="mx-3 text-sm">Dashboard</span>
                </a>
            </div>
        </div>
        @endif

        @if(auth()->user()->hasAnyRole(['admin', 'pastor', 'staff']))
        <!-- CHILDREN'S MINISTRY -->
        <div class="mt-4">
            <button @click="childrensMinistry = !childrensMinistry" class="flex items-center justify-between w-full px-4 py-2 text-white/60 hover:text-white transition-colors text-xs font-semibold uppercase tracking-wider">
                <span>Children's Ministry</span>
                <svg :class="childrensMinistry ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="childrensMinistry" x-collapse class="mt-2 space-y-1">
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('childrens-ministry.*') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('childrens-ministry.index') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="mx-3 text-sm">Dashboard</span>
                </a>
            </div>
        </div>

        <!-- EQUIPMENT -->
        <div class="mt-4">
            <button @click="media = !media" class="flex items-center justify-between w-full px-4 py-2 text-white/60 hover:text-white transition-colors text-xs font-semibold uppercase tracking-wider">
                <span>Equipment</span>
                <svg :class="media ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="media" x-collapse class="mt-2 space-y-1">
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('equipment.*') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('equipment.index') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                    </svg>
                    <span class="mx-3 text-sm">All Equipment</span>
                </a>
            </div>
        </div>

        <!-- QR MANAGEMENT -->
        <div class="mt-4">
            <button @click="qrManagement = !qrManagement" class="flex items-center justify-between w-full px-4 py-2 text-white/60 hover:text-white transition-colors text-xs font-semibold uppercase tracking-wider">
                <span>QR System</span>
                <svg :class="qrManagement ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="qrManagement" x-collapse class="mt-2 space-y-1">
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('qr-management.*') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('qr-management.index') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                    <span class="mx-3 text-sm">QR Codes</span>
                </a>
            </div>
        </div>

        <!-- REPORTS -->
        <div class="mt-4">
            <button @click="reports = !reports" class="flex items-center justify-between w-full px-4 py-2 text-white/60 hover:text-white transition-colors text-xs font-semibold uppercase tracking-wider">
                <span>Reports</span>
                <svg :class="reports ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="reports" x-collapse class="mt-2 space-y-1">
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('reports.index') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="mx-3 text-sm">Custom Reports</span>
                </a>
            </div>
        </div>
        @endif

        @if(auth()->user()->hasRole('admin'))
        <!-- SETTINGS -->
        <div class="mt-4">
            <button @click="settings = !settings" class="flex items-center justify-between w-full px-4 py-2 text-white/60 hover:text-white transition-colors text-xs font-semibold uppercase tracking-wider">
                <span>Settings</span>
                <svg :class="settings ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="settings" x-collapse class="mt-2 space-y-1">
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('settings.*') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('settings.index') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="mx-3 text-sm">General Settings</span>
                </a>
                <a class="flex items-center px-4 py-2.5 text-white/80 rounded-lg transition-all duration-200 {{ request()->routeIs('settings.audit-logs') ? 'bg-white/20 text-white shadow-lg border-l-4 border-accent-400' : 'hover:bg-white/10 hover:text-white' }}" href="{{ route('settings.audit-logs') }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="mx-3 text-sm">Audit Logs</span>
                </a>
            </div>
        </div>
        @endif

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-6">
            @csrf
            <button type="submit" class="flex items-center w-full px-4 py-3 text-white/80 rounded-lg hover:bg-red-600 hover:text-white transition-colors duration-200 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span class="mx-3 font-medium">Logout</span>
            </button>
        </form>
    </nav>
</aside>
