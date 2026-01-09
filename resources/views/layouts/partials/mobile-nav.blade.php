<nav class="fixed bottom-0 left-0 right-0 glass border-t border-slate-200/50 pb-safe z-50">
    <div class="flex justify-around items-center h-16 px-1">
        <!-- Home -->
        <a href="{{ url('/mobile/dashboard') }}" class="relative group flex flex-col items-center justify-center w-full h-full">
            <div class="transition-all duration-200 {{ request()->is('mobile/dashboard') ? 'text-primary-600 -translate-y-1' : 'text-slate-400 group-active:scale-95' }}">
                <svg class="w-6 h-6" fill="{{ request()->is('mobile/dashboard') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <span class="text-[10px] font-medium mt-1 transition-colors {{ request()->is('mobile/dashboard') ? 'text-primary-600' : 'text-slate-400' }}">Home</span>
            @if(request()->is('mobile/dashboard'))
                <span class="absolute -bottom-[2px] w-1 h-1 rounded-full bg-primary-600"></span>
            @endif
        </a>

        <!-- Units -->
        <a href="{{ url('/mobile/service-unit') }}" class="relative group flex flex-col items-center justify-center w-full h-full">
            <div class="transition-all duration-200 {{ request()->is('mobile/service-unit*') ? 'text-primary-600 -translate-y-1' : 'text-slate-400 group-active:scale-95' }}">
                <svg class="w-6 h-6" fill="{{ request()->is('mobile/service-unit*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <span class="text-[10px] font-medium mt-1 transition-colors {{ request()->is('mobile/service-unit*') ? 'text-primary-600' : 'text-slate-400' }}">Units</span>
        </a>

        <!-- Scan / Check-in (Center Action) -->
        <div class="relative flex flex-col items-center justify-center w-full h-full">
            <a href="{{ url('/mobile/check-in') }}" class="absolute -top-6 group">
                <div class="w-14 h-14 bg-primary-600 rounded-full shadow-lg shadow-primary-900/20 flex items-center justify-center text-white transform transition-transform group-active:scale-95 border-4 border-white z-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 17h.01M9 20h.01M12 20h.01M12 17h.01M12 14h.01M15 11h.01M15 14h.01" />
                    </svg>
                </div>
                <span class="absolute top-9 left-1/2 transform -translate-x-1/2 text-[10px] font-medium text-slate-500 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">Scan</span>
            </a>
        </div>

        <!-- Give -->
        <a href="{{ url('/mobile/give') }}" class="relative group flex flex-col items-center justify-center w-full h-full">
            <div class="transition-all duration-200 {{ request()->is('mobile/give') ? 'text-primary-600 -translate-y-1' : 'text-slate-400 group-active:scale-95' }}">
                <svg class="w-6 h-6" fill="{{ request()->is('mobile/give') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="text-[10px] font-medium mt-1 transition-colors {{ request()->is('mobile/give') ? 'text-primary-600' : 'text-slate-400' }}">Give</span>
        </a>

        <!-- Profile -->
        <a href="{{ url('/mobile/profile') }}" class="relative group flex flex-col items-center justify-center w-full h-full">
            <div class="transition-all duration-200 {{ request()->is('mobile/profile*') ? 'text-primary-600 -translate-y-1' : 'text-slate-400 group-active:scale-95' }}">
                <svg class="w-6 h-6" fill="{{ request()->is('mobile/profile*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <span class="text-[10px] font-medium mt-1 transition-colors {{ request()->is('mobile/profile*') ? 'text-primary-600' : 'text-slate-400' }}">Profile</span>
        </a>
    </div>
</nav>
