@extends('layouts.mobile')

@section('title', 'Events')
@section('header', 'Events')

@section('header-actions')
<button onclick="document.getElementById('searchModal').classList.remove('hidden')" class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
</button>
@endsection

@section('content')
<div class="h-full flex flex-col pb-20 pt-6">
    <!-- Header -->
    <div class="px-6 mb-4 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Events</h1>
            <p class="text-slate-500 text-sm font-medium">Join us for upcoming programs</p>
        </div>
        <button onclick="document.getElementById('searchModal').classList.remove('hidden')" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </button>
    </div>

    <!-- Filters Tab (Sticky) -->
    <div class="sticky top-0 z-30 bg-slate-50/95 backdrop-blur-sm border-b border-white/50 pb-2">
        <div class="flex overflow-x-auto hide-scrollbar px-6 gap-6 mb-3">
            @foreach(['upcoming' => 'Upcoming', 'today' => 'Today', 'week' => 'This Week', 'month' => 'This Month', 'past' => 'Past'] as $key => $label)
            <button onclick="filterEvents('{{ $key }}', this)" class="event-tab flex-shrink-0 text-sm font-bold transition-all {{ $key === 'upcoming' ? 'text-primary-600 scale-105' : 'text-slate-400 hover:text-slate-600' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>
        <!-- Pills for Categories -->
        <div class="flex overflow-x-auto hide-scrollbar gap-2 px-6 pb-2">
            <button onclick="filterCategory('all', this)" class="cat-pill px-4 py-2 rounded-full text-xs font-bold transition-all bg-slate-900 text-white shadow-lg shadow-slate-900/20 transform scale-100">All</button>
            @foreach(['Service', 'Conferences', 'Seminars', 'Fellowship', 'Outreach'] as $cat)
            <button onclick="filterCategory('{{ strtolower($cat) }}', this)" class="cat-pill px-4 py-2 rounded-full text-xs font-bold transition-all bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transform hover:scale-105 hover:shadow-sm">{{ $cat }}</button>
            @endforeach
        </div>
    </div>

    <!-- Events Feed -->
    <div class="flex-1 overflow-y-auto px-4 py-4 space-y-5" id="eventsContainer">
        <!-- Skeleton Loader -->
        <div class="animate-pulse space-y-5">
             @foreach(range(1,3) as $i)
             <div class="bg-white rounded-[2rem] h-72 w-full p-2">
                <div class="bg-slate-200 h-40 w-full rounded-3xl mb-4"></div>
                <div class="h-4 bg-slate-200 w-3/4 rounded mb-2 mx-4"></div>
                <div class="h-4 bg-slate-200 w-1/2 rounded mx-4"></div>
             </div>
             @endforeach
        </div>
    </div>
</div>

<!-- Search Modal -->
<div id="searchModal" class="hidden fixed inset-0 z-[60] bg-white flex flex-col animate-in fade-in slide-in-from-bottom-10 duration-200">
    <div class="px-4 py-3 border-b border-slate-100 flex items-center gap-3 pt-safe">
        <button onclick="document.getElementById('searchModal').classList.add('hidden')" class="p-2 -ml-2 text-slate-400">
             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <div class="flex-1 relative">
             <input type="text" id="searchInput" placeholder="Search events..." class="w-full bg-slate-100 border-none rounded-xl py-2.5 pl-10 pr-4 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-primary-500/20" oninput="performSearch(this.value)">
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
    let currentCategory = 'all';

    function filterEvents(period, btn) {
        currentFilter = period;
        
        // UI
        document.querySelectorAll('.event-tab').forEach(b => {
            b.classList.remove('text-primary-600', 'scale-105');
            b.classList.add('text-slate-400');
        });
        btn.classList.remove('text-slate-400');
        btn.classList.add('text-primary-600', 'scale-105');

        loadEvents();
    }

    function filterCategory(cat, btn) {
        currentCategory = cat;

        // UI
        document.querySelectorAll('.cat-pill').forEach(b => {
             b.classList.remove('bg-slate-900', 'text-white', 'shadow-lg', 'scale-100');
             b.classList.add('bg-white', 'text-slate-600', 'border', 'border-slate-200');
        });
        btn.classList.remove('bg-white', 'text-slate-600', 'border', 'border-slate-200');
        btn.classList.add('bg-slate-900', 'text-white', 'shadow-lg', 'scale-100');

        loadEvents();
    }

    async function loadEvents() {
        showLoading(true);
        try {
            const params = new URLSearchParams({
                filter: currentFilter,
                category: currentCategory === 'all' ? '' : currentCategory
            });
            const res = await ChurchApp.apiCall(`/api/mobile/v1/events/upcoming?${params}`, 'GET');
            
            if(res.success && res.data.events.length > 0) {
                 renderEvents(res.data.events);
            } else {
                 document.getElementById('eventsContainer').innerHTML = `
                    <div class="text-center py-20 px-6">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                             <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="font-bold text-slate-800">No events found</h3>
                        <p class="text-sm text-slate-500">Try changing your filters</p>
                    </div>
                `;
            }

        } catch(e) { console.error(e); }
        showLoading(false);
    }

    function renderEvents(events) {
        const html = events.map(e => {
            const date = new Date(e.start_date);
            const isFeatured = e.is_featured;
            
            // Random gradient for banner if no image
            const banner = e.banner_url ? `<img src="${e.banner_url}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">` 
                : `<div class="w-full h-full bg-gradient-to-br from-slate-200 to-slate-300 flex items-center justify-center text-slate-400">
                     <svg class="w-12 h-12 opacity-50" fill="currentColor" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2z"/></svg>
                   </div>`;

            return `
                <div onclick="location.href='/mobile/events/${e.id}'" class="group bg-white rounded-[2rem] p-2 shadow-sm border border-white/60 active:scale-[0.98] transition-all duration-300">
                    <div class="relative h-48 rounded-[1.5rem] overflow-hidden bg-slate-100">
                        ${banner}
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-60"></div>
                        
                        <!-- Date Badge -->
                        <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-md px-3 py-2 rounded-2xl flex flex-col items-center min-w-[3.5rem] shadow-lg">
                             <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">${date.toLocaleDateString('en-US', {month: 'short'})}</span>
                             <span class="text-xl font-black text-slate-800 leading-none">${date.getDate()}</span>
                        </div>

                        ${isFeatured ? '<div class="absolute top-3 right-3 bg-amber-400 text-amber-950 px-3 py-1 rounded-full text-[10px] font-black shadow-lg uppercase tracking-wide flex items-center gap-1"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> Featured</div>' : ''}
                        
                        <!-- Title Overlay -->
                        <div class="absolute bottom-4 left-4 right-4">
                             <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-3 text-white">
                                <h3 class="font-bold text-lg leading-tight mb-1 line-clamp-1">${e.name}</h3>
                                <p class="text-xs font-medium text-white/80 flex items-center gap-2">
                                     <span>${date.toLocaleTimeString('en-US', {hour: 'numeric', minute:'2-digit'})}</span>
                                     <span class="w-1 h-1 rounded-full bg-white/50"></span>
                                     <span class="truncate">${e.location || 'Main Auditorium'}</span>
                                </p>
                             </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
        document.getElementById('eventsContainer').innerHTML = html;
    }

    function showLoading(show) {
        // Implementation: toggle skeleton
    }

    async function performSearch(query) {
        if(query.length < 2) return;
        // Search Logic
    }

    document.addEventListener('DOMContentLoaded', loadEvents);
</script>
@endpush
