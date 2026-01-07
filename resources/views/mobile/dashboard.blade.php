@extends('layouts.mobile')

@section('content')
<div class="pb-24">
    <!-- Header / Welcome Section -->
    <div class="relative bg-primary-600 text-white pt-safe pb-24 rounded-b-[2.5rem] overflow-hidden shadow-lg shadow-primary-900/20">
        <!-- Abstract Background Shapes -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10">
            <div class="absolute -top-24 -left-24 w-64 h-64 rounded-full bg-white blur-3xl"></div>
            <div class="absolute top-1/2 right-0 w-48 h-48 rounded-full bg-indigo-400 blur-2xl"></div>
        </div>

        <div class="px-6 pt-6 relative z-10">
            <div class="flex items-start justify-between mb-8">
                <div class="flex flex-col">
                     <p class="text-blue-100 text-sm font-medium mb-1 opacity-90" id="greeting">Welcome back,</p>
                     <h2 class="text-2xl font-bold tracking-tight leading-tight min-h-[2rem]" id="userName">Loading...</h2>
                </div>
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/30 shadow-inner flex-shrink-0">
                     <span class="text-lg font-bold" id="userInitials">--</span>
                </div>
            </div>

            <!-- Quick Stats Cards (Overlay) -->
            <div class="grid grid-cols-3 gap-3">
                 <div class="glass bg-white/10 rounded-2xl p-3 text-center border border-white/10 backdrop-blur-md">
                    <p class="text-xl font-bold mb-1" id="attendanceCount">--</p>
                    <p class="text-[10px] text-blue-100 uppercase tracking-wider font-semibold">Attended</p>
                </div>
                <div class="glass bg-white/10 rounded-2xl p-3 text-center border border-white/10 backdrop-blur-md">
                    <p class="text-xl font-bold mb-1" id="givingTotal">--</p>
                    <p class="text-[10px] text-blue-100 uppercase tracking-wider font-semibold">Given</p>
                </div>
                <div class="glass bg-white/10 rounded-2xl p-3 text-center border border-white/10 backdrop-blur-md">
                    <p class="text-xl font-bold mb-1" id="eventCount">--</p>
                    <p class="text-[10px] text-blue-100 uppercase tracking-wider font-semibold">Events</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Grid -->
    <div class="px-6 -mt-10 relative z-20 mb-8">
        <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 p-5 border border-slate-100">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Quick Actions</h3>
            <div class="grid grid-cols-4 gap-4">
                 <a href="{{ url('/mobile/check-in') }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center transition-colors group-active:bg-indigo-100">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-xs font-medium text-slate-600 text-center leading-tight">Check In</span>
                </a>
                <a href="{{ url('/mobile/give') }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center transition-colors group-active:bg-emerald-100">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-xs font-medium text-slate-600 text-center leading-tight">Give</span>
                </a>
                <a href="{{ url('/mobile/qr-code') }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center transition-colors group-active:bg-purple-100">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    </div>
                    <span class="text-xs font-medium text-slate-600 text-center leading-tight">My QR</span>
                </a>
                 <a href="{{ url('/mobile/events') }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center transition-colors group-active:bg-amber-100">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-xs font-medium text-slate-600 text-center leading-tight">Events</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="px-6 space-y-8">
        
        <!-- Announcements -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-800">Announcements</h3>
                <a href="{{ url('/mobile/announcements') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700">See All</a>
            </div>
            <div id="announcementsList" class="flex overflow-x-auto gap-4 hide-scrollbar snap-x snap-mandatory pb-4 -mx-6 px-6">
                <!-- Loading Skeleton -->
                 <div class="flex-shrink-0 w-72 h-32 bg-slate-100 rounded-2xl animate-pulse"></div>
            </div>
        </div>

        <!-- Upcoming Events List -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-800">Coming Up</h3>
                <a href="{{ url('/mobile/events') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700">See All</a>
            </div>
            <div id="eventsList" class="space-y-3">
                 <div class="h-20 bg-slate-100 rounded-xl animate-pulse"></div>
                 <div class="h-20 bg-slate-100 rounded-xl animate-pulse"></div>
            </div>
        </div>

        <!-- Service Times -->
        <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-2xl p-5 border border-slate-200">
             <h3 class="text-lg font-bold text-slate-800 mb-4">Service Times</h3>
             <div id="servicesList" class="space-y-4">
                 <!-- Populated by JS -->
             </div>
        </div>
    </div>

    <!-- Install Prompt -->
    <div id="installBanner" class="hidden fixed bottom-20 left-4 right-4 bg-slate-900 text-white p-4 rounded-xl shadow-2xl z-40 flex items-center justify-between">
        <div>
            <h4 class="font-bold text-sm">Get the App</h4>
            <p class="text-xs text-slate-400 mt-0.5">Install for a better experience</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="dismissInstallBanner()" class="text-xs font-medium text-slate-400">Not now</button>
             <button onclick="installPWA()" class="bg-primary-600 px-4 py-2 rounded-lg text-xs font-bold text-white shadow-lg shadow-primary-900/50">Install</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Time-based greeting
    const hour = new Date().getHours();
    const greetingText = hour < 12 ? 'Good morning,' : (hour < 18 ? 'Good afternoon,' : 'Good evening,');
    document.getElementById('greeting').textContent = greetingText;

    // Data Loading Functions (Refactored to cleaner async/await)
    async function initDashboard() {
        try {
            // Profile & Stats (Parallel)
            await Promise.all([
                loadProfile(),
                loadStats(),
                loadAnnouncements(),
                loadEvents(),
                loadServices()
            ]);
        } catch (e) {
            console.error('Partial load error', e);
        }
    }

    async function loadProfile() {
        // Mockable auth check
        ChurchApp.refreshAuth();
        if (!ChurchApp.isAuthenticated()) {
            window.location.href = '{{ url('/mobile/login') }}';
            return;
        }

        const res = await ChurchApp.getMyProfile();
        if (res.success) {
            const user = res.member;
            document.getElementById('userName').textContent = user.full_name;
            const initials = user.full_name.split(' ').map(n=>n[0]).join('').substring(0,2).toUpperCase();
            document.getElementById('userInitials').textContent = initials;
        }
    }

    async function loadStats() {
        try {
            const [attendance, giving, events] = await Promise.all([
                 ChurchApp.getMyAttendance(),
                 ChurchApp.getMyContributions(),
                 ChurchApp.getUpcomingEvents()
            ]);

            if(attendance.success) document.getElementById('attendanceCount').textContent = attendance.data.attendance_this_month || 0;
            if(giving.success) {
                const total = giving.data.total_this_year || 0;
                document.getElementById('givingTotal').textContent = ChurchApp.formatCurrency(total).replace('GH₵', '₵');
            }
            if(events.success) document.getElementById('eventCount').textContent = events.data.summary.this_month || 0;

        } catch(e) { console.warn('Stats error', e); }
    }

    async function loadAnnouncements() {
        const res = await ChurchApp.getAnnouncements();
        const container = document.getElementById('announcementsList');
        
        if (res.success && res.data.announcements.length > 0) {
            container.innerHTML = res.data.announcements.slice(0, 5).map(item => `
                <div class="snap-center flex-shrink-0 w-72 bg-white rounded-2xl p-4 shadow-sm border border-slate-100 relative overflow-hidden">
                    ${item.is_urgent ? '<div class="absolute top-0 right-0 bg-rose-500 w-2 h-2 rounded-full m-3"></div>' : ''}
                    <h4 class="font-bold text-slate-800 line-clamp-1 mb-1">${item.title}</h4>
                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">${item.content}</p>
                    <p class="text-[10px] text-slate-400 mt-3 font-medium uppercase tracking-wide">${new Date(item.published_at).toLocaleDateString()}</p>
                </div>
            `).join('');
        } else {
             container.innerHTML = '<div class="w-full text-center py-4 text-sm text-slate-400 italic">No announcements today</div>';
        }
    }

    async function loadEvents() {
        const res = await ChurchApp.getUpcomingEvents();
        const container = document.getElementById('eventsList');
        const mobileBase = '{{ url('/mobile') }}';

        if (res.success && res.data.events.length > 0) {
            container.innerHTML = res.data.events.slice(0, 3).map(event => `
                <a href="${mobileBase}/events/${event.id}" class="flex items-center gap-4 bg-white p-3 rounded-2xl shadow-sm border border-slate-100 active:scale-[0.99] transition-transform">
                    <div class="w-14 h-14 flex-shrink-0 bg-indigo-50 rounded-xl flex flex-col items-center justify-center text-indigo-600">
                        <span class="text-xs font-bold uppercase">${new Date(event.start_date).toLocaleDateString('en-US', { month: 'short' })}</span>
                        <span class="text-lg font-bold leading-none">${new Date(event.start_date).getDate()}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-slate-800 truncate">${event.name}</h4>
                        <p class="text-xs text-slate-500 truncate">${event.location || 'Church Main Auditorium'}</p>
                    </div>
                     <div class="text-slate-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
            `).join('');
        } else {
            container.innerHTML = '<div class="text-center py-6 text-sm text-slate-400">No upcoming events</div>';
        }
    }

    async function loadServices() {
        // Static fallback for demo if API fails or returns empty
        const services = [
            { day: 'Sunday', time: '7:00 AM', label: '1st Service' },
            { day: 'Sunday', time: '9:30 AM', label: '2nd Service' },
            { day: 'Wednesday', time: '6:00 PM', label: 'Midweek Service' }
        ];
        
        const container = document.getElementById('servicesList');
        container.innerHTML = services.map(s => `
            <div class="flex items-center justify-between py-2 border-b border-slate-200/50 last:border-0">
                <div>
                     <p class="font-bold text-slate-700 text-sm">${s.day}</p>
                     <p class="text-xs text-slate-500">${s.label}</p>
                </div>
                <div class="bg-white px-3 py-1 rounded-full border border-slate-200 text-xs font-bold text-slate-600">
                    ${s.time}
                </div>
            </div>
        `).join('');
    }

    // PWA Install Logic
    let deferredPrompt;
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        if (!localStorage.getItem('install_banner_dismissed')) {
            document.getElementById('installBanner').classList.remove('hidden');
        }
    });

    async function installPWA() {
        if (!deferredPrompt) return;
        deferredPrompt.prompt();
        const { outcome } = await deferredPrompt.userChoice;
        if (outcome === 'accepted') {
            dismissInstallBanner();
        }
        deferredPrompt = null;
    }

    function dismissInstallBanner() {
        document.getElementById('installBanner').classList.add('hidden');
        localStorage.setItem('install_banner_dismissed', 'true');
    }

    // Pull to Refresh
    let touchStart = 0;
    document.addEventListener('touchstart', e => { if(window.scrollY === 0) touchStart = e.touches[0].pageY; });
    document.addEventListener('touchmove', e => {
        if(window.scrollY === 0 && touchStart > 0 && (e.touches[0].pageY - touchStart) > 0) e.preventDefault(); 
    }, {passive: false});
    document.addEventListener('touchend', e => {
        if(window.scrollY === 0 && touchStart > 0 && (e.changedTouches[0].pageY - touchStart) > 100) window.location.reload();
        touchStart = 0;
    });

    // Init
    document.addEventListener('DOMContentLoaded', initDashboard);
</script>
@endpush
