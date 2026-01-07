<header class="flex items-center justify-between px-6 py-4 bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-20 transition-all duration-300">
    <div class="flex items-center">
        <button @click="sidebarOpen = true" class="text-slate-500 focus:outline-none lg:hidden hover:text-primary-600 transition-colors">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <div class="relative mx-4 lg:mx-0 group">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-slate-400 group-focus-within:text-primary-500 transition-colors" viewBox="0 0 24 24" fill="none">
                    <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>

            <input class="w-32 pl-10 pr-4 py-2 rounded-xl border border-slate-200 bg-slate-50/50 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-primary-100 focus:border-primary-300 transition-all sm:w-64" type="text" placeholder="Search...">
        </div>
    </div>

    <div class="flex items-center gap-4">
        <div x-data="{ notificationOpen: false }" class="relative">
            <button @click="notificationOpen = ! notificationOpen" class="flex text-slate-400 hover:text-primary-600 focus:outline-none transition-colors relative">
                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 17H20L18.5951 15.5951C18.2141 15.2141 18 14.6973 18 14.1585V11C18 8.38757 16.3304 6.16509 14 5.34142V5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5V5.34142C7.66962 6.16509 6 8.38757 6 11V14.1585C6 14.6973 5.78595 15.2141 5.40493 15.5951L4 17H9M15 17V18C15 19.6569 13.6569 21 12 21C10.3431 21 9 19.6569 9 18V17M15 17H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <div x-show="notificationOpen" 
                 @click.away="notificationOpen = false" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-1"
                 class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-soft border border-slate-100 overflow-hidden z-10" 
                 style="display: none;">
                
                <div class="px-4 py-3 border-b border-slate-50">
                    <h3 class="text-sm font-semibold text-slate-900">Notifications</h3>
                </div>
                
                <div class="max-h-64 overflow-y-auto">
                    <a href="#" class="flex items-start px-4 py-3 hover:bg-slate-50 transition-colors">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-slate-900">New Member</p>
                            <p class="text-xs text-slate-500 mt-0.5">John Doe joined recently.</p>
                            <p class="text-xs text-primary-600 mt-1">2 min ago</p>
                        </div>
                    </a>
                </div>
                <div class="px-4 py-2 border-t border-slate-50 text-center bg-slate-50">
                    <a href="{{ route('notifications.index') }}" class="text-xs font-medium text-primary-600 hover:text-primary-700">View All</a>
                </div>
            </div>
        </div>

        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = ! dropdownOpen" class="flex items-center gap-2 focus:outline-none group">
                <div class="relative block h-9 w-9 rounded-full overflow-hidden shadow-sm border-2 border-white ring-2 ring-slate-100 group-hover:ring-primary-200 transition-all">
                    <img class="h-full w-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=3b82f6&color=fff" alt="Your avatar">
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-sm font-medium text-slate-700 group-hover:text-primary-600 transition-colors">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
                <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600 hidden md:block transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="dropdownOpen" 
                 @click.away="dropdownOpen = false" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-1"
                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-soft border border-slate-100 py-1 z-10"
                 style="display: none;">
                
                <div class="px-4 py-3 border-b border-slate-50 md:hidden">
                    <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                </div>

                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">Profile</a>
                <a href="{{ route('settings.index') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">Settings</a>
                
                <div class="border-t border-slate-100 my-1"></div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">Logout</button>
                </form>
            </div>
        </div>
    </div>
</header>
