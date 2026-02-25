@extends('layouts.mobile')

@section('content')
<div class="pb-24">
    <!-- Hero Header -->
    <div class="bg-primary-600 text-white pt-safe px-6 relative overflow-hidden" style="padding-top: calc(env(safe-area-inset-top) + 1.5rem); padding-bottom: 2.5rem;">
        <!-- Decorative circles -->
        <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -mr-16 -mt-16 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-28 h-28 bg-white/5 rounded-full -ml-10 -mb-10 pointer-events-none"></div>

        <div class="flex items-start justify-between mb-6 relative">
            <div>
                <p class="text-blue-100/90 text-sm font-medium mb-0.5" id="greeting">Good morning,</p>
                <h2 class="text-2xl font-bold tracking-tight" id="userName">User</h2>
            </div>
            <a href="{{ url('/mobile/profile') }}" class="w-10 h-10 bg-white/15 rounded-full flex items-center justify-center border border-white/20 active:scale-95 transition-transform overflow-hidden flex-shrink-0">
                <img id="headerAvatar" class="hidden w-full h-full object-cover" alt="">
                <span class="text-sm font-bold text-white" id="userInitials">--</span>
            </a>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-3 gap-2 relative">
            <div class="bg-white/15 rounded-2xl p-3 border border-white/10">
                <div class="flex items-center gap-1.5 mb-1">
                    <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-[10px] text-blue-100/80 uppercase tracking-wide font-semibold">Attended</p>
                </div>
                <p class="text-xl font-bold leading-none" id="attendanceCount">0</p>
            </div>
            <div class="bg-white/15 rounded-2xl p-3 border border-white/10">
                <div class="flex items-center gap-1.5 mb-1">
                    <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-[10px] text-blue-100/80 uppercase tracking-wide font-semibold">Given</p>
                </div>
                <p class="text-xl font-bold leading-none" id="givingTotal">₵0</p>
            </div>
            <div class="bg-white/15 rounded-2xl p-3 border border-white/10">
                <div class="flex items-center gap-1.5 mb-1">
                    <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-[10px] text-blue-100/80 uppercase tracking-wide font-semibold">Events</p>
                </div>
                <p class="text-xl font-bold leading-none" id="eventCount">0</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-slate-50 px-5 pt-6 space-y-7">

        <!-- Quick Actions -->
        <div>
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Quick Actions</h3>
            <div class="grid grid-cols-4 gap-3">
                <a href="{{ url('/mobile/check-in') }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-14 h-14 rounded-2xl bg-white border border-slate-100 text-primary-600 flex items-center justify-center shadow-sm group-active:scale-95 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-[11px] font-medium text-slate-600 text-center">Check In</span>
                </a>
                <a href="{{ url('/mobile/give') }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-14 h-14 rounded-2xl bg-white border border-slate-100 text-emerald-600 flex items-center justify-center shadow-sm group-active:scale-95 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-[11px] font-medium text-slate-600 text-center">Give</span>
                </a>
                <a href="{{ url('/mobile/id-card') }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-14 h-14 rounded-2xl bg-white border border-slate-100 text-fuchsia-600 flex items-center justify-center shadow-sm group-active:scale-95 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    </div>
                    <span class="text-[11px] font-medium text-slate-600 text-center">My QR</span>
                </a>
                <a href="{{ url('/mobile/events') }}" class="flex flex-col items-center gap-2 group">
                    <div class="w-14 h-14 rounded-2xl bg-white border border-slate-100 text-amber-600 flex items-center justify-center shadow-sm group-active:scale-95 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-[11px] font-medium text-slate-600 text-center">Events</span>
                </a>
            </div>
        </div>

        <!-- Latest News -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-base font-bold text-slate-800">Latest News</h3>
                <a href="{{ url('/mobile/announcements') }}" class="text-xs font-semibold text-primary-600">View All</a>
            </div>
            <div id="announcementsList" class="flex overflow-x-auto gap-3 hide-scrollbar snap-x snap-mandatory pb-2 -mx-5 px-5">
                <!-- Loading skeleton -->
                <div class="flex-shrink-0 w-56 h-44 bg-slate-200 rounded-2xl animate-pulse snap-start"></div>
                <div class="flex-shrink-0 w-56 h-44 bg-slate-200 rounded-2xl animate-pulse snap-start"></div>
                <div class="flex-shrink-0 w-56 h-44 bg-slate-200 rounded-2xl animate-pulse snap-start"></div>
            </div>
        </div>

        <!-- Service Times -->
        <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm">
            <h3 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                <div class="w-7 h-7 bg-primary-50 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
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

    async function initDashboard() {
        try {
            ChurchApp.refreshAuth();
            await Promise.allSettled([
                loadProfile(),
                loadStats(),
                loadAnnouncements(),
                loadServices()
            ]);
        } catch (e) {
            console.error('Dashboard load error', e);
        }
    }

    async function loadProfile() {
        const res = await ChurchApp.getMyProfile();
        if (res.success) {
            const user = res.member;
            document.getElementById('userName').textContent = user.full_name || 'User';
            const initials = (user.full_name || 'U').split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            document.getElementById('userInitials').textContent = initials;
            if (user.photo_url) {
                const img = document.getElementById('headerAvatar');
                img.src = user.photo_url;
                img.classList.remove('hidden');
                document.getElementById('userInitials').classList.add('hidden');
            }
        }
    }

    async function loadStats() {
        try {
            const [attendance, giving, events] = await Promise.all([
                ChurchApp.getMyAttendance(),
                ChurchApp.getMyContributions(),
                ChurchApp.getUpcomingEvents()
            ]);
            if (attendance.success) document.getElementById('attendanceCount').textContent = attendance.data.attendance_this_month || 0;
            if (giving.success) {
                const total = giving.data.total_this_year || 0;
                document.getElementById('givingTotal').textContent = ChurchApp.formatCurrency(total).replace('GH₵', '₵');
            }
            if (events.success) document.getElementById('eventCount').textContent = events.data.summary?.this_month || 0;
        } catch (e) { console.warn('Stats error', e); }
    }

    async function loadAnnouncements() {
        const res = await ChurchApp.getAnnouncements();
        const container = document.getElementById('announcementsList');
        const gradients = [
            'from-blue-600 to-indigo-700',
            'from-emerald-600 to-teal-700',
            'from-violet-600 to-purple-700',
            'from-rose-500 to-pink-700',
            'from-amber-500 to-orange-600',
        ];

        if (res.success && res.data.announcements.length > 0) {
            container.innerHTML = res.data.announcements.slice(0, 5).map((item, i) => `
                <a href="{{ url('/mobile/announcements') }}" class="snap-start flex-shrink-0 w-56 h-44 rounded-2xl overflow-hidden relative shadow-sm block group">
                    ${item.image_url
                        ? `<img src="${window.escapeHtml(item.image_url)}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="">`
                        : `<div class="w-full h-full bg-gradient-to-br ${gradients[i % gradients.length]}"></div>`
                    }
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    ${item.is_urgent ? '<div class="absolute top-3 right-3 w-2 h-2 rounded-full bg-rose-500 shadow-lg shadow-rose-500/50"></div>' : ''}
                    <div class="absolute bottom-0 left-0 right-0 p-3">
                        <h4 class="font-bold text-white text-sm leading-tight line-clamp-2">${window.escapeHtml(item.title)}</h4>
                    </div>
                </a>
            `).join('');
        } else {
            container.innerHTML = `
                <div class="snap-start flex-shrink-0 w-56 h-44 rounded-2xl overflow-hidden relative shadow-sm bg-gradient-to-br from-blue-600 to-indigo-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-3">
                        <h4 class="font-bold text-white text-sm">Upcoming Sermon Series</h4>
                    </div>
                </div>
                <div class="snap-start flex-shrink-0 w-56 h-44 rounded-2xl overflow-hidden relative shadow-sm bg-gradient-to-br from-emerald-600 to-teal-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-3">
                        <h4 class="font-bold text-white text-sm">Community Outreach Program</h4>
                    </div>
                </div>
                <div class="snap-start flex-shrink-0 w-56 h-44 rounded-2xl overflow-hidden relative shadow-sm bg-gradient-to-br from-violet-600 to-purple-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-3">
                        <h4 class="font-bold text-white text-sm">Volunteer Opportunities</h4>
                    </div>
                </div>
            `;
        }
    }

    async function loadServices() {
        const services = [
            { day: 'Sunday', time: '7:00 AM', label: '1st Service' },
            { day: 'Sunday', time: '9:30 AM', label: '2nd Service' },
            { day: 'Wednesday', time: '7:00 PM', label: 'Bible Study' }
        ];
        const container = document.getElementById('servicesList');
        container.innerHTML = services.map(s => `
            <div class="flex items-center justify-between py-2.5 border-b border-slate-100 last:border-0">
                <div>
                    <p class="font-bold text-slate-700 text-sm"><span class="text-slate-900">${s.day}</span> ${s.label}</p>
                </div>
                <div class="bg-primary-50 px-3 py-1.5 rounded-full text-xs font-bold text-primary-600">
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
            document.getElementById('installBanner').classList.add('flex');
        }
    });

    async function installPWA() {
        if (!deferredPrompt) return;
        deferredPrompt.prompt();
        const { outcome } = await deferredPrompt.userChoice;
        if (outcome === 'accepted') dismissInstallBanner();
        deferredPrompt = null;
    }

    function dismissInstallBanner() {
        document.getElementById('installBanner').classList.add('hidden');
        localStorage.setItem('install_banner_dismissed', 'true');
    }

    // Pull to Refresh
    let touchStart = 0;
    document.addEventListener('touchstart', e => { if (window.scrollY === 0) touchStart = e.touches[0].pageY; });
    document.addEventListener('touchmove', e => {
        if (window.scrollY === 0 && touchStart > 0 && (e.touches[0].pageY - touchStart) > 0) e.preventDefault();
    }, { passive: false });
    document.addEventListener('touchend', e => {
        if (window.scrollY === 0 && touchStart > 0 && (e.changedTouches[0].pageY - touchStart) > 100) window.location.reload();
        touchStart = 0;
    });

    document.addEventListener('DOMContentLoaded', initDashboard);
</script>
@endpush
