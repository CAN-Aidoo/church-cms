@extends('layouts.mobile')

@section('title', 'Events')
@section('header', 'Events')

@section('header-actions')
<button onclick="document.getElementById('searchModal').classList.remove('hidden')" class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
</button>
@endsection

@section('content')
<div class="h-full flex flex-col pb-20">
    <!-- Filters Tab (Sticky) -->
    <div class="sticky top-[56px] z-30 bg-white border-b border-slate-100 shadow-sm">
        <div class="flex overflow-x-auto hide-scrollbar px-2">
            @foreach(['upcoming' => 'Upcoming', 'today' => 'Today', 'week' => 'This Week', 'month' => 'This Month', 'past' => 'Past'] as $key => $label)
            <button onclick="filterEvents('{{ $key }}', this)" class="event-tab flex-shrink-0 px-4 py-3 text-sm font-bold border-b-2 transition-colors {{ $key === 'upcoming' ? 'border-primary-600 text-primary-600' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>
        <!-- Pills for Categories -->
        <div class="flex overflow-x-auto hide-scrollbar gap-2 px-4 py-3 bg-slate-50/50">
            <button onclick="filterCategory('all', this)" class="cat-pill px-3 py-1.5 rounded-full text-xs font-bold transition-all bg-slate-800 text-white shadow-sm">All</button>
            @foreach(['Service', 'Conferences', 'Seminars', 'Fellowship', 'Outreach'] as $cat)
            <button onclick="filterCategory('{{ strtolower($cat) }}', this)" class="cat-pill px-3 py-1.5 rounded-full text-xs font-bold transition-all bg-white border border-slate-200 text-slate-600 hover:bg-slate-100">{{ $cat }}</button>
            @endforeach
        </div>
    </div>

    <!-- Events Feed -->
    <div class="flex-1 overflow-y-auto px-4 py-4 space-y-4" id="eventsContainer">
        <!-- Skeleton Loader -->
        <div class="animate-pulse space-y-4">
             <div class="bg-white rounded-2xl h-64 w-full"></div>
             <div class="bg-white rounded-2xl h-24 w-full"></div>
             <div class="bg-white rounded-2xl h-24 w-full"></div>
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
            b.classList.remove('border-primary-600', 'text-primary-600');
            b.classList.add('border-transparent', 'text-slate-500');
        });
        btn.classList.remove('border-transparent', 'text-slate-500');
        btn.classList.add('border-primary-600', 'text-primary-600');

        loadEvents();
    }

    function filterCategory(cat, btn) {
        currentCategory = cat;

        // UI
        document.querySelectorAll('.cat-pill').forEach(b => {
             b.classList.remove('bg-slate-800', 'text-white', 'shadow-sm');
             b.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-600');
        });
        btn.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-600');
        btn.classList.add('bg-slate-800', 'text-white', 'shadow-sm');

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
            const banner = e.banner_url ? `<img src="${e.banner_url}" class="w-full h-full object-cover">` 
                : `<div class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-opacity-30">
                     <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2z"/></svg>
                   </div>`;

            return `
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden active:scale-[0.99] transition-transform">
                    <div class="relative h-48">
                        ${banner}
                        <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-md px-3 py-1 rounded-lg text-xs font-bold text-slate-800 shadow-sm border border-white/50">
                             ${e.category_label || e.category}
                        </div>
                        ${isFeatured ? '<div class="absolute top-3 right-3 bg-amber-400 text-amber-900 px-2 py-1 rounded-lg text-[10px] font-bold shadow-sm uppercase tracking-wide">Featured</div>' : ''}
                    </div>
                    <div class="p-4">
                         <div class="flex gap-4 mb-2">
                             <div class="flex-shrink-0 text-center">
                                  <span class="block text-xs font-bold text-primary-600 uppercase tracking-wider">${date.toLocaleDateString('en-US', {month: 'short'})}</span>
                                  <span class="block text-2xl font-black text-slate-800 leading-none">${date.getDate()}</span>
                             </div>
                             <div>
                                  <h3 class="font-bold text-slate-800 text-lg leading-tight line-clamp-2">${e.name}</h3>
                                  <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                      ${date.toLocaleTimeString('en-US', {hour: 'numeric', minute:'2-digit'})}
                                      <span class="mx-1">•</span>
                                      <span>${e.location || 'Main Auditorium'}</span>
                                  </p>
                             </div>
                         </div>
                         <button onclick="location.href='/mobile/events/${e.id}'" class="w-full mt-3 bg-slate-50 text-slate-600 font-bold py-2.5 rounded-xl text-sm hover:bg-slate-100 transition-colors">
                             View Details
                         </button>
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
