@extends('layouts.mobile')

@section('content')
<div class="pb-24">
    <!-- Header / Welcome Section -->
    <!-- Minimal Header -->
    <div class="bg-primary-600 text-white pt-safe pb-8 px-6 rounded-b-[2rem] shadow-sm relative z-10">
        <div class="flex items-center justify-between mb-6 pt-4">
            <div>
                 <p class="text-blue-100/90 text-sm font-medium mb-0.5" id="greeting">Welcome,</p>
                 <h2 class="text-2xl font-bold tracking-tight" id="userName">User</h2>
            </div>
            <a href="{{ url('/mobile/profile') }}" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center border border-white/20 active:scale-95 transition-transform">
                 <span class="text-sm font-bold text-white" id="userInitials">--</span>
            </a>
        </div>

        <!-- Quick Stats (In Header for better contrast) -->
        <div class="grid grid-cols-3 gap-2">
             <div class="bg-white/10 rounded-xl p-2.5 text-center border border-white/5 backdrop-blur-sm">
                <p class="text-lg font-bold mb-0 leading-tight" id="attendanceCount">0</p>
                <p class="text-[10px] text-blue-100 opacity-80 uppercase tracking-wide font-medium">Attended</p>
            </div>
            <div class="bg-white/10 rounded-xl p-2.5 text-center border border-white/5 backdrop-blur-sm">
                <p class="text-lg font-bold mb-0 leading-tight" id="givingTotal">0</p>
                <p class="text-[10px] text-blue-100 opacity-80 uppercase tracking-wide font-medium">Given</p>
            </div>
            <div class="bg-white/10 rounded-xl p-2.5 text-center border border-white/5 backdrop-blur-sm">
                <p class="text-lg font-bold mb-0 leading-tight" id="eventCount">0</p>
                <p class="text-[10px] text-blue-100 opacity-80 uppercase tracking-wide font-medium">Events</p>
            </div>
        </div>
    </div>

    <!-- Main Content Body -->
    <div class="px-5 -mt-0 pt-6 space-y-8">
        
        <!-- Quick Actions -->
        <div>
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Quick Actions</h3>
            <div class="grid grid-cols-4 gap-3">
                 <a href="{{ url('/mobile/check-in') }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-13 h-13 rounded-2xl bg-white border border-slate-100 text-primary-600 flex items-center justify-center shadow-sm group-active:scale-95 transition-all">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-[11px] font-medium text-slate-600 text-center">Check In</span>
                </a>
                <a href="{{ url('/mobile/give') }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-13 h-13 rounded-2xl bg-white border border-slate-100 text-emerald-600 flex items-center justify-center shadow-sm group-active:scale-95 transition-all">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-[11px] font-medium text-slate-600 text-center">Give</span>
                </a>
                <a href="{{ url('/mobile/qr-code') }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-13 h-13 rounded-2xl bg-white border border-slate-100 text-fuchsia-600 flex items-center justify-center shadow-sm group-active:scale-95 transition-all">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    </div>
                    <span class="text-[11px] font-medium text-slate-600 text-center">My QR</span>
                </a>
                 <a href="{{ url('/mobile/events') }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-13 h-13 rounded-2xl bg-white border border-slate-100 text-amber-600 flex items-center justify-center shadow-sm group-active:scale-95 transition-all">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-[11px] font-medium text-slate-600 text-center">Events</span>
                </a>
            </div>
        </div>

        <!-- Ministry & Services -->
        <div>
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Ministry & Services</h3>
            <div class="grid grid-cols-4 gap-3">
                <a href="{{ url('/mobile/equipment-management') }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-13 h-13 rounded-2xl bg-white border border-slate-100 text-blue-600 flex items-center justify-center shadow-sm group-active:scale-95 transition-all">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                    </div>
                    <span class="text-[11px] font-medium text-slate-600 text-center">Equipment</span>
                </a>
                <a href="{{ url('/mobile/service-unit/dashboard') }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-13 h-13 rounded-2xl bg-white border border-slate-100 text-purple-600 flex items-center justify-center shadow-sm group-active:scale-95 transition-all">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <span class="text-[11px] font-medium text-slate-600 text-center">My Unit</span>
                </a>
                <a href="{{ url('/mobile/children-ministry') }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-13 h-13 rounded-2xl bg-white border border-slate-100 text-pink-600 flex items-center justify-center shadow-sm group-active:scale-95 transition-all">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <span class="text-[11px] font-medium text-slate-600 text-center">Children</span>
                </a>
                <a href="{{ url('/mobile/shepherd/dashboard') }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-13 h-13 rounded-2xl bg-white border border-slate-100 text-teal-600 flex items-center justify-center shadow-sm group-active:scale-95 transition-all">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span class="text-[11px] font-medium text-slate-600 text-center">Shepherd</span>
                </a>
            </div>
        </div>

        <!-- Announcements -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-base font-bold text-slate-800">Latest News</h3>
                <a href="{{ url('/mobile/announcements') }}" class="text-xs font-semibold text-primary-600">View All</a>
            </div>
            <div id="announcementsList" class="flex overflow-x-auto gap-3 hide-scrollbar snap-x snap-mandatory pb-2 -mx-5 px-5">
                <!-- Loading Skeleton -->
                 <div class="flex-shrink-0 w-64 h-28 bg-white rounded-xl border border-slate-100 shadow-sm p-4 animate-pulse"></div>
            </div>
        </div>

        <!-- Service Times -->
        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm">
             <h3 class="text-sm font-bold text-slate-800 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Service Times
             </h3>
             <div id="servicesList" class="space-y-3">
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
            // NO auth check needed - Laravel middleware protects this page
            // If user can access this page, they're authenticated!
            ChurchApp.refreshAuth();

            // Profile & Stats (Parallel)
            await Promise.allSettled([
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
