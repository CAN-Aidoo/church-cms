@extends('layouts.mobile')

@section('title', 'Ministry Units')

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

        <h1 class="text-3xl font-bold text-white relative">Ministry Units</h1>
        <p class="text-blue-100 text-sm font-medium mt-1 relative">Find your place to serve</p>
    </div>

    <!-- White Body -->
    <div class="bg-white rounded-t-[2rem] -mt-6 relative z-10">

        <!-- Filter Tabs -->
        <div class="px-4 pt-5 pb-3 border-b border-slate-100">
            <div class="flex gap-2 overflow-x-auto hide-scrollbar">
                <button onclick="filterUnits('all', this)" data-filter="all"
                        class="unit-filter-btn flex-shrink-0 px-5 py-2 rounded-full text-sm font-bold transition-all bg-primary-600 text-white shadow-sm">
                    All Units
                </button>
                <button onclick="filterUnits('my', this)" data-filter="my"
                        class="unit-filter-btn flex-shrink-0 px-5 py-2 rounded-full text-sm font-bold transition-all bg-white border border-slate-200 text-slate-600">
                    My Units
                </button>
                <button onclick="filterUnits('creative', this)" data-filter="creative"
                        class="unit-filter-btn flex-shrink-0 px-5 py-2 rounded-full text-sm font-bold transition-all bg-white border border-slate-200 text-slate-600">
                    Creative
                </button>
                <button onclick="filterUnits('service', this)" data-filter="service"
                        class="unit-filter-btn flex-shrink-0 px-5 py-2 rounded-full text-sm font-bold transition-all bg-white border border-slate-200 text-slate-600">
                    Service
                </button>
            </div>
        </div>

        <!-- Units List -->
        <div class="px-4 py-4 space-y-3 pb-6" id="unitsList">
            <!-- Loading skeleton -->
            @foreach(range(1,4) as $i)
            <div class="bg-white rounded-2xl p-4 flex items-center gap-3 shadow-sm border border-slate-100 animate-pulse">
                <div class="w-14 h-14 bg-slate-100 rounded-2xl flex-shrink-0"></div>
                <div class="flex-1 space-y-2">
                    <div class="h-4 bg-slate-100 rounded w-2/3"></div>
                    <div class="h-3 bg-slate-100 rounded w-1/2"></div>
                </div>
                <div class="w-16 h-8 bg-slate-100 rounded-full"></div>
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
            <input type="text" placeholder="Search ministry units..."
                   class="w-full bg-slate-100 border-none rounded-xl py-2.5 pl-10 pr-4 text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-primary-500/20"
                   oninput="searchUnits(this.value)">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
    </div>
    <div class="flex-1 overflow-y-auto px-4 py-4" id="searchResults">
        <p class="text-center text-slate-400 text-sm mt-10">Start typing to search units...</p>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Unit icon colour configs — keyed by partial name match
    const UNIT_STYLES = {
        'youth':      { bg: 'bg-blue-100',   text: 'text-blue-600',   icon: 'people' },
        'worship':    { bg: 'bg-purple-100',  text: 'text-purple-600', icon: 'music' },
        'media':      { bg: 'bg-orange-100',  text: 'text-orange-600', icon: 'video' },
        'children':   { bg: 'bg-pink-100',    text: 'text-pink-600',   icon: 'child' },
        'usher':      { bg: 'bg-emerald-100', text: 'text-emerald-600',icon: 'greet' },
        'greeting':   { bg: 'bg-emerald-100', text: 'text-emerald-600',icon: 'greet' },
        'hospitality':{ bg: 'bg-gray-100',    text: 'text-gray-600',   icon: 'food' },
        'prayer':     { bg: 'bg-indigo-100',  text: 'text-indigo-600', icon: 'pray' },
        'default':    { bg: 'bg-primary-100', text: 'text-primary-600',icon: 'people' },
    };

    const UNIT_ICONS = {
        people: `<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>`,
        music:  `<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>`,
        video:  `<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.723v6.554a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>`,
        child:  `<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
        greet:  `<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>`,
        food:   `<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M3 12h18M3 18h18"/></svg>`,
        pray:   `<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/></svg>`,
    };

    function getUnitStyle(name) {
        const lower = (name || '').toLowerCase();
        for (const [key, style] of Object.entries(UNIT_STYLES)) {
            if (key !== 'default' && lower.includes(key)) return style;
        }
        return UNIT_STYLES.default;
    }

    let allUnits = [];
    let myUnitIds = new Set();
    let currentFilter = 'all';

    // Category classification
    const CREATIVE_KEYWORDS = ['worship', 'media', 'drama', 'dance', 'choir', 'music', 'art'];
    const SERVICE_KEYWORDS   = ['usher', 'greet', 'hospitality', 'prayer', 'security', 'parking'];

    function classifyUnit(name) {
        const lower = (name || '').toLowerCase();
        if (CREATIVE_KEYWORDS.some(k => lower.includes(k))) return 'creative';
        if (SERVICE_KEYWORDS.some(k => lower.includes(k)))   return 'service';
        return 'other';
    }

    function filterUnits(filter, btn) {
        currentFilter = filter;
        document.querySelectorAll('.unit-filter-btn').forEach(b => {
            b.classList.remove('bg-primary-600', 'text-white', 'shadow-sm');
            b.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-600');
        });
        btn.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-600');
        btn.classList.add('bg-primary-600', 'text-white', 'shadow-sm');
        renderUnits(allUnits);
    }

    function renderUnits(units) {
        let filtered = units;
        if (currentFilter === 'my')       filtered = units.filter(u => myUnitIds.has(u.id));
        else if (currentFilter === 'creative') filtered = units.filter(u => classifyUnit(u.name) === 'creative');
        else if (currentFilter === 'service')  filtered = units.filter(u => classifyUnit(u.name) === 'service');

        const container = document.getElementById('unitsList');

        if (filtered.length === 0) {
            container.innerHTML = `
                <div class="text-center py-16 px-6">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-700">No units found</h3>
                    <p class="text-sm text-slate-400 mt-1">Try a different filter</p>
                </div>`;
            return;
        }

        container.innerHTML = filtered.map(unit => {
            const style = getUnitStyle(unit.name);
            const isMember = myUnitIds.has(unit.id);
            return `
                <div class="bg-white rounded-2xl p-4 flex items-center gap-3 shadow-sm border border-slate-100 active:scale-[0.99] transition-transform">
                    <div class="w-14 h-14 ${style.bg} ${style.text} rounded-2xl flex items-center justify-center flex-shrink-0">
                        ${UNIT_ICONS[style.icon] || UNIT_ICONS.people}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-slate-800 text-sm leading-tight">${window.escapeHtml(unit.name)}</h4>
                        <p class="text-xs text-slate-400 mt-0.5 line-clamp-1">${window.escapeHtml(unit.description || 'Serving the congregation')}</p>
                    </div>
                    ${isMember
                        ? `<span class="flex-shrink-0 px-3 py-1.5 rounded-full border border-emerald-200 bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wide">Member</span>`
                        : `<button onclick="joinUnit(${unit.id}, this)" class="flex-shrink-0 px-4 py-2 rounded-full bg-primary-600 text-white text-xs font-bold shadow-sm shadow-primary-600/30 active:scale-95 transition-transform">Join</button>`
                    }
                </div>
            `;
        }).join('');
    }

    async function joinUnit(unitId, btn) {
        btn.disabled = true;
        btn.textContent = '...';
        try {
            const res = await ChurchApp.apiCall(`/api/mobile/v1/service-unit/${unitId}/members`, 'POST', {});
            if (res.success) {
                myUnitIds.add(unitId);
                ChurchApp.showToast('You have joined this unit!', 'success');
                renderUnits(allUnits);
            } else {
                ChurchApp.showToast(res.message || 'Could not join unit', 'error');
                btn.disabled = false;
                btn.textContent = 'Join';
            }
        } catch (e) {
            ChurchApp.showToast('Could not join unit. Try again.', 'error');
            btn.disabled = false;
            btn.textContent = 'Join';
        }
    }

    function searchUnits(query) {
        const results = document.getElementById('searchResults');
        if (!query || query.length < 2) {
            results.innerHTML = '<p class="text-center text-slate-400 text-sm mt-10">Start typing to search units...</p>';
            return;
        }
        const filtered = allUnits.filter(u =>
            (u.name || '').toLowerCase().includes(query.toLowerCase()) ||
            (u.description || '').toLowerCase().includes(query.toLowerCase())
        );
        if (filtered.length === 0) {
            results.innerHTML = '<p class="text-center text-slate-400 text-sm mt-10">No units found</p>';
            return;
        }
        results.innerHTML = filtered.map(unit => {
            const style = getUnitStyle(unit.name);
            const isMember = myUnitIds.has(unit.id);
            return `
                <div class="flex items-center gap-3 p-3 hover:bg-slate-50 rounded-xl transition-colors">
                    <div class="w-10 h-10 ${style.bg} ${style.text} rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-slate-800 text-sm">${window.escapeHtml(unit.name)}</p>
                        <p class="text-xs text-slate-400 truncate">${window.escapeHtml(unit.description || '')}</p>
                    </div>
                    ${isMember ? '<span class="text-[10px] font-bold text-emerald-600 uppercase">Member</span>' : ''}
                </div>`;
        }).join('');
    }

    // Default sample units (shown while API loads or as fallback)
    const SAMPLE_UNITS = [
        { id: 1, name: 'Youth Ministry',        description: 'Impacting the next generation' },
        { id: 2, name: 'Worship Team',           description: 'Leading the congregation in praise' },
        { id: 3, name: 'Media Dept',             description: 'Visuals, sound and live streaming' },
        { id: 4, name: "Children's Ministry",    description: 'Nurturing young hearts in faith' },
        { id: 5, name: 'Ushering & Greeters',   description: 'Welcoming guests with a smile' },
        { id: 6, name: 'Hospitality',            description: 'Food and refreshment service' },
    ];

    async function loadUnits() {
        try {
            const [unitsRes, myRes] = await Promise.allSettled([
                ChurchApp.apiCall('/api/v1/my/ministry-involvement', 'GET'),
                ChurchApp.apiCall('/api/v1/my/ministry-involvement', 'GET')
            ]);

            if (myRes.status === 'fulfilled' && myRes.value.success) {
                (myRes.value.data?.units || []).forEach(u => myUnitIds.add(u.id));
            }

            // Try fetching all service units — fallback to sample if unavailable
            const allRes = await ChurchApp.apiCall('/api/mobile/v1/service-unit/my-units', 'GET').catch(() => null);
            if (allRes && allRes.success && allRes.data?.units?.length > 0) {
                allUnits = allRes.data.units;
            } else {
                allUnits = SAMPLE_UNITS;
            }
        } catch (e) {
            allUnits = SAMPLE_UNITS;
        }
        renderUnits(allUnits);
    }

    document.addEventListener('DOMContentLoaded', loadUnits);
</script>
@endpush
