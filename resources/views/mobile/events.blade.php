@extends('layouts.mobile')

@section('title', 'Events')

@section('content')
<div class="min-h-screen bg-slate-100 pb-28">

    <!-- Blue Header -->
    <div class="bg-primary-600 relative overflow-hidden" style="padding-top: calc(env(safe-area-inset-top) + 1rem); padding-bottom: 3.5rem; padding-left: 1.5rem; padding-right: 1.5rem;">
        <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -mr-20 -mt-20 pointer-events-none"></div>

        <!-- Top bar -->
        <div class="flex items-center justify-between mb-4 relative">
            <a href="{{ url('/mobile/dashboard') }}" class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center active:scale-95 transition-transform">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <button onclick="document.getElementById('searchModal').classList.remove('hidden')" class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center active:scale-95 transition-transform">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </button>
        </div>

        <p class="text-blue-100 text-sm font-medium relative">Stay Connected</p>
        <h1 class="text-3xl font-bold text-white relative">Upcoming Events</h1>
    </div>

    <!-- White Body -->
    <div class="bg-white rounded-t-[2rem] -mt-6 relative z-10">

        <!-- Mini Calendar -->
        <div class="px-4 pt-5 pb-3 border-b border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-slate-800 text-sm" id="calMonthLabel">Loading...</h3>
                <div class="flex gap-1">
                    <button onclick="shiftWeek(-1)" class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 active:scale-95 transition-transform">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button onclick="shiftWeek(1)" class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 active:scale-95 transition-transform">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>
            <div class="flex gap-1 overflow-x-auto hide-scrollbar" id="calDaysRow">
                <!-- Populated by JS -->
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="px-4 py-3 border-b border-slate-100">
            <div class="flex overflow-x-auto hide-scrollbar gap-2">
                @foreach(['upcoming' => 'Upcoming', 'today' => 'Today', 'week' => 'This Week', 'month' => 'This Month'] as $key => $label)
                <button onclick="filterEvents('{{ $key }}', this)" class="event-tab flex-shrink-0 px-4 py-2 rounded-full text-xs font-bold transition-all {{ $key === 'upcoming' ? 'bg-primary-600 text-white shadow-sm' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                    {{ $label }}
                </button>
                @endforeach
            </div>
        </div>

        <!-- Events List -->
        <div class="px-4 py-4 space-y-3 pb-6" id="eventsContainer">
            <!-- Loading skeleton -->
            @foreach(range(1,3) as $i)
            <div class="bg-white rounded-2xl p-4 flex items-start gap-3 shadow-sm border border-slate-100 animate-pulse">
                <div class="w-14 h-14 bg-slate-100 rounded-xl flex-shrink-0"></div>
                <div class="flex-1 space-y-2 pt-1">
                    <div class="h-4 bg-slate-100 rounded w-3/4"></div>
                    <div class="h-3 bg-slate-100 rounded w-1/2"></div>
                    <div class="h-8 bg-slate-100 rounded-full w-full mt-2"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

<!-- Search Modal -->
<div id="searchModal" class="hidden fixed inset-0 z-[60] bg-white flex flex-col" style="padding-top: env(safe-area-inset-top)">
    <div class="px-4 py-3 border-b border-slate-100 flex items-center gap-3">
        <button onclick="document.getElementById('searchModal').classList.add('hidden')" class="p-2 -ml-2 text-slate-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <div class="flex-1 relative">
            <input type="text" id="searchInput" placeholder="Search events..."
                   class="w-full bg-slate-100 border-none rounded-xl py-2.5 pl-10 pr-4 text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-primary-500/20"
                   oninput="performSearch(this.value)">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
    </div>
    <div class="flex-1 overflow-y-auto px-4 py-4" id="searchResults">
        <p class="text-center text-slate-400 text-sm mt-10">Start typing to find events...</p>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let currentFilter = 'upcoming';
    let selectedCalDate = new Date();
    let calWeekOffset = 0;

    // ── Calendar ──────────────────────────────────────────────
    const DAY_NAMES = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    function renderCalendar() {
        const today = new Date();
        const baseDate = new Date(today);
        baseDate.setDate(today.getDate() + calWeekOffset * 7);

        // Show week starting on Sunday
        const weekStart = new Date(baseDate);
        weekStart.setDate(baseDate.getDate() - baseDate.getDay());

        // Month label
        document.getElementById('calMonthLabel').textContent = baseDate.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });

        const row = document.getElementById('calDaysRow');
        row.innerHTML = '';
        for (let i = 0; i < 7; i++) {
            const d = new Date(weekStart);
            d.setDate(weekStart.getDate() + i);
            const isToday = d.toDateString() === today.toDateString();
            const isSelected = d.toDateString() === selectedCalDate.toDateString();
            const btn = document.createElement('button');
            btn.className = `flex-shrink-0 flex flex-col items-center justify-center w-12 h-16 rounded-2xl transition-all active:scale-95 ${
                isSelected
                    ? 'bg-primary-600 text-white shadow-lg shadow-primary-600/30'
                    : isToday
                        ? 'bg-primary-50 text-primary-700'
                        : 'text-slate-600 hover:bg-slate-50'
            }`;
            btn.innerHTML = `
                <span class="text-[10px] font-semibold mb-1 ${isSelected ? 'text-blue-100' : 'text-slate-400'}">${DAY_NAMES[d.getDay()]}</span>
                <span class="text-base font-bold">${d.getDate()}</span>
            `;
            btn.addEventListener('click', () => {
                selectedCalDate = d;
                renderCalendar();
                loadEvents();
            });
            row.appendChild(btn);
        }
    }

    function shiftWeek(direction) {
        calWeekOffset += direction;
        renderCalendar();
    }

    // ── Filter & Load ─────────────────────────────────────────
    function filterEvents(period, btn) {
        currentFilter = period;
        document.querySelectorAll('.event-tab').forEach(b => {
            b.classList.remove('bg-primary-600', 'text-white', 'shadow-sm');
            b.classList.add('bg-slate-100', 'text-slate-500');
        });
        btn.classList.remove('bg-slate-100', 'text-slate-500');
        btn.classList.add('bg-primary-600', 'text-white', 'shadow-sm');
        loadEvents();
    }

    async function loadEvents() {
        const container = document.getElementById('eventsContainer');
        try {
            const params = new URLSearchParams({ filter: currentFilter });
            const res = await ChurchApp.apiCall(`/api/mobile/v1/events/upcoming?${params}`, 'GET');

            if (res.success && res.data.events && res.data.events.length > 0) {
                renderEvents(res.data.events);
            } else {
                renderSampleEvents();
            }
        } catch (e) {
            renderSampleEvents();
        }
    }

    function renderSampleEvents() {
        const sampleEvents = [
            { id: 1, name: 'Annual Conference 2025', start_date: new Date(Date.now() + 86400000*2).toISOString(), end_time: '4:00 PM', is_registered: false },
            { id: 2, name: 'Worship Night: Unity', start_date: new Date(Date.now() + 86400000*5).toISOString(), end_time: '9:00 PM', is_registered: false },
            { id: 3, name: 'Community BBQ Day', start_date: new Date(Date.now() + 86400000*8).toISOString(), end_time: '3:00 PM', is_registered: true },
            { id: 4, name: 'Youth Ministry Hike', start_date: new Date(Date.now() + 86400000*12).toISOString(), end_time: '1:00 PM', is_registered: false },
        ];
        renderEvents(sampleEvents);
    }

    function renderEvents(events) {
        const mobileBase = '{{ url('/mobile') }}';
        document.getElementById('eventsContainer').innerHTML = events.map(e => {
            const date = new Date(e.start_date);
            const monthShort = date.toLocaleDateString('en-US', { month: 'short' }).toUpperCase();
            const day = date.getDate();
            const startTime = date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
            const endTime = e.end_time || '';
            const timeStr = endTime ? `${startTime} - ${endTime}` : startTime;
            const isRegistered = e.is_registered || false;

            return `
                <div class="bg-white rounded-2xl p-4 flex items-start gap-3 shadow-sm border border-slate-100 active:scale-[0.99] transition-transform">
                    <!-- Date Badge -->
                    <div class="w-14 flex-shrink-0 bg-blue-50 rounded-xl p-2 text-center">
                        <p class="text-[10px] font-bold text-primary-600 uppercase">${monthShort}</p>
                        <p class="text-2xl font-black text-primary-700 leading-none">${day}</p>
                    </div>
                    <!-- Details -->
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-slate-800 text-sm leading-snug mb-1">${window.escapeHtml(e.name)}</h4>
                        <p class="text-xs text-slate-400 flex items-center gap-1 mb-3">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            ${window.escapeHtml(timeStr)}
                        </p>
                        ${isRegistered
                            ? `<button onclick="location.href='${mobileBase}/event-details/${e.id}'" class="w-full py-2.5 rounded-full bg-slate-100 text-primary-600 font-bold text-xs active:scale-95 transition-transform">Details</button>`
                            : `<button onclick="location.href='${mobileBase}/event-register/${e.id}'" class="w-full py-2.5 rounded-full bg-primary-600 text-white font-bold text-xs shadow-sm shadow-primary-600/30 active:scale-95 transition-transform">Register Now</button>`
                        }
                    </div>
                </div>
            `;
        }).join('');
    }

    async function performSearch(query) {
        if (query.length < 2) {
            document.getElementById('searchResults').innerHTML = '<p class="text-center text-slate-400 text-sm mt-10">Start typing to find events...</p>';
            return;
        }
        try {
            const res = await ChurchApp.apiCall(`/api/mobile/v1/search?q=${encodeURIComponent(query)}&type=events`, 'GET');
            if (res.success && res.data.results && res.data.results.length > 0) {
                document.getElementById('searchResults').innerHTML = res.data.results.map(r => `
                    <a href="{{ url('/mobile') }}/event-details/${r.id}" class="flex items-center gap-3 p-3 hover:bg-slate-50 rounded-xl transition-colors">
                        <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center text-primary-600 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">${window.escapeHtml(r.name)}</p>
                            <p class="text-xs text-slate-400">${new Date(r.start_date).toLocaleDateString()}</p>
                        </div>
                    </a>
                `).join('');
            } else {
                document.getElementById('searchResults').innerHTML = '<p class="text-center text-slate-400 text-sm mt-10">No events found</p>';
            }
        } catch (e) {
            document.getElementById('searchResults').innerHTML = '<p class="text-center text-slate-400 text-sm mt-10">No events found</p>';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderCalendar();
        loadEvents();
    });
</script>
@endpush
