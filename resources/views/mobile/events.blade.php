@extends('layouts.mobile')

@section('title', 'Events - Church App')
@section('header', 'Events & Programs')

@section('header-actions')
<button onclick="showSearchModal()" class="p-2 rounded-full hover:bg-white/10">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
    </svg>
</button>
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Filter Tabs -->
    <div class="bg-white shadow-sm sticky top-0 z-10">
        <div class="flex overflow-x-auto hide-scrollbar">
            <button onclick="filterEvents('upcoming')" class="filter-tab flex-shrink-0 px-6 py-4 font-semibold text-sm border-b-2 transition active border-blue-600 text-blue-600">
                Upcoming
            </button>
            <button onclick="filterEvents('today')" class="filter-tab flex-shrink-0 px-6 py-4 font-semibold text-sm border-b-2 transition border-transparent text-gray-600 hover:text-blue-600">
                Today
            </button>
            <button onclick="filterEvents('this_week')" class="filter-tab flex-shrink-0 px-6 py-4 font-semibold text-sm border-b-2 transition border-transparent text-gray-600 hover:text-blue-600">
                This Week
            </button>
            <button onclick="filterEvents('this_month')" class="filter-tab flex-shrink-0 px-6 py-4 font-semibold text-sm border-b-2 transition border-transparent text-gray-600 hover:text-blue-600">
                This Month
            </button>
            <button onclick="filterEvents('past')" class="filter-tab flex-shrink-0 px-6 py-4 font-semibold text-sm border-b-2 transition border-transparent text-gray-600 hover:text-blue-600">
                Past
            </button>
        </div>
    </div>

    <!-- Category Filter Chips -->
    <div class="bg-white px-4 py-3 border-b border-gray-200">
        <div class="flex items-center space-x-2 overflow-x-auto hide-scrollbar">
            <button onclick="filterCategory('all')" class="category-chip flex-shrink-0 px-4 py-2 rounded-full font-semibold text-sm transition active bg-blue-600 text-white">
                All
            </button>
            <button onclick="filterCategory('service')" class="category-chip flex-shrink-0 px-4 py-2 rounded-full font-semibold text-sm transition bg-gray-100 text-gray-700 hover:bg-gray-200">
                Services
            </button>
            <button onclick="filterCategory('conference')" class="category-chip flex-shrink-0 px-4 py-2 rounded-full font-semibold text-sm transition bg-gray-100 text-gray-700 hover:bg-gray-200">
                Conferences
            </button>
            <button onclick="filterCategory('seminar')" class="category-chip flex-shrink-0 px-4 py-2 rounded-full font-semibold text-sm transition bg-gray-100 text-gray-700 hover:bg-gray-200">
                Seminars
            </button>
            <button onclick="filterCategory('fellowship')" class="category-chip flex-shrink-0 px-4 py-2 rounded-full font-semibold text-sm transition bg-gray-100 text-gray-700 hover:bg-gray-200">
                Fellowship
            </button>
            <button onclick="filterCategory('outreach')" class="category-chip flex-shrink-0 px-4 py-2 rounded-full font-semibold text-sm transition bg-gray-100 text-gray-700 hover:bg-gray-200">
                Outreach
            </button>
        </div>
    </div>

    <!-- Events List -->
    <div class="px-4 py-6">
        <!-- Loading State -->
        <div id="loadingState" class="text-center py-12">
            <svg class="animate-spin h-10 w-10 text-blue-600 mx-auto mb-3" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-500">Loading events...</p>
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="hidden text-center py-12">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-lg font-bold text-gray-900 mb-2">No Events Found</h3>
            <p class="text-gray-600 mb-4">Check back later for upcoming events</p>
        </div>

        <!-- Events Grid -->
        <div id="eventsList" class="space-y-4">
            <!-- Dynamic content will be inserted here -->
        </div>

        <!-- Load More Button -->
        <div id="loadMoreContainer" class="hidden text-center mt-6">
            <button onclick="loadMoreEvents()" id="loadMoreBtn" class="bg-white border-2 border-gray-300 text-gray-700 font-semibold py-3 px-6 rounded-lg hover:bg-gray-50 transition">
                Load More Events
            </button>
        </div>
    </div>
</div>

<!-- Search Modal -->
<div id="searchModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50">
    <div class="bg-white h-full flex flex-col">
        <!-- Search Header -->
        <div class="px-4 py-4 border-b border-gray-200 flex items-center space-x-3">
            <button onclick="closeSearchModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <input type="text" id="searchInput" placeholder="Search events..."
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                   oninput="performSearch()">
        </div>

        <!-- Search Results -->
        <div id="searchResults" class="flex-1 overflow-y-auto px-4 py-4">
            <p class="text-gray-500 text-center py-12">Type to search events...</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentFilter = 'upcoming';
let currentCategory = 'all';
let currentPage = 1;
let totalPages = 1;
let allEvents = [];
let searchTimeout = null;

// Load events with filters
async function loadEvents(page = 1, append = false) {
    showLoading(true);

    try {
        const params = new URLSearchParams({
            page: page,
            per_page: 20,
            filter: currentFilter,
            category: currentCategory !== 'all' ? currentCategory : ''
        });

        const result = await ChurchApp.apiCall(`/api/mobile/v1/events/upcoming?${params}`, 'GET');

        if (result.success && result.data) {
            const events = result.data.events || result.data.data || [];
            const pagination = result.data.pagination;

            if (events.length === 0 && !append) {
                document.getElementById('emptyState').classList.remove('hidden');
                document.getElementById('eventsList').innerHTML = '';
                showLoading(false);
                return;
            }

            document.getElementById('emptyState').classList.add('hidden');

            const eventsHTML = events.map(event => renderEventCard(event)).join('');

            if (append) {
                document.getElementById('eventsList').insertAdjacentHTML('beforeend', eventsHTML);
            } else {
                document.getElementById('eventsList').innerHTML = eventsHTML;
            }

            // Show/hide load more button
            if (pagination && pagination.has_more) {
                document.getElementById('loadMoreContainer').classList.remove('hidden');
            } else {
                document.getElementById('loadMoreContainer').classList.add('hidden');
            }

            currentPage = page;
            totalPages = pagination?.last_page || 1;
        }
    } catch (error) {
        console.error('Failed to load events:', error);
        ChurchApp.showToast('Failed to load events', 'error');
    } finally {
        showLoading(false);
    }
}

// Render event card
function renderEventCard(event) {
    const startDate = new Date(event.start_date);
    const endDate = event.end_date ? new Date(event.end_date) : null;

    const formattedDate = startDate.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });

    const formattedTime = startDate.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit'
    });

    const categoryColors = {
        service: 'bg-blue-100 text-blue-800 border-blue-200',
        conference: 'bg-purple-100 text-purple-800 border-purple-200',
        seminar: 'bg-green-100 text-green-800 border-green-200',
        fellowship: 'bg-yellow-100 text-yellow-800 border-yellow-200',
        outreach: 'bg-pink-100 text-pink-800 border-pink-200',
        social: 'bg-indigo-100 text-indigo-800 border-indigo-200'
    };

    const categoryClass = categoryColors[event.category] || 'bg-gray-100 text-gray-800 border-gray-200';

    const isRegistered = event.is_registered || false;
    const isFull = event.is_full || false;
    const spotsLeft = event.max_participants ? (event.max_participants - (event.registered_count || 0)) : null;

    return `
        <div onclick="viewEvent('${event.id}')" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden cursor-pointer hover:shadow-lg transition">
            ${event.banner_url ? `
                <div class="relative h-48 bg-gradient-to-br from-blue-600 to-blue-700">
                    <img src="${event.banner_url}" alt="${event.title}" class="w-full h-full object-cover">
                    ${event.is_featured ? `
                        <div class="absolute top-3 right-3">
                            <span class="bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                ⭐ Featured
                            </span>
                        </div>
                    ` : ''}
                </div>
            ` : `
                <div class="relative h-48 bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center">
                    <svg class="w-20 h-20 text-white/30" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    ${event.is_featured ? `
                        <div class="absolute top-3 right-3">
                            <span class="bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                ⭐ Featured
                            </span>
                        </div>
                    ` : ''}
                </div>
            `}

            <div class="p-4">
                <!-- Category Badge -->
                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold border ${categoryClass} mb-3">
                    ${event.category_label || event.category}
                </span>

                <!-- Event Title -->
                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">${event.title}</h3>

                <!-- Event Description -->
                ${event.description ? `
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">${event.description}</p>
                ` : ''}

                <!-- Event Details -->
                <div class="space-y-2 mb-4">
                    <!-- Date & Time -->
                    <div class="flex items-center text-sm text-gray-700">
                        <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-medium">${formattedDate} at ${formattedTime}</span>
                    </div>

                    <!-- Location -->
                    ${event.location ? `
                        <div class="flex items-center text-sm text-gray-700">
                            <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="line-clamp-1">${event.location}</span>
                        </div>
                    ` : ''}

                    <!-- Capacity -->
                    ${event.max_participants ? `
                        <div class="flex items-center text-sm text-gray-700">
                            <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span>${event.registered_count || 0} / ${event.max_participants} registered</span>
                            ${spotsLeft && spotsLeft <= 10 && spotsLeft > 0 ? `
                                <span class="ml-2 text-orange-600 font-semibold">(${spotsLeft} spots left)</span>
                            ` : ''}
                        </div>
                    ` : ''}
                </div>

                <!-- Registration Status/Button -->
                <div class="pt-3 border-t border-gray-200">
                    ${isRegistered ? `
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center text-green-700 font-semibold text-sm">
                                <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Registered
                            </span>
                            <button class="text-blue-600 font-semibold text-sm hover:text-blue-700">
                                View Details →
                            </button>
                        </div>
                    ` : isFull ? `
                        <div class="bg-red-50 text-red-700 px-4 py-2 rounded-lg text-center font-semibold text-sm">
                            Event Full
                        </div>
                    ` : `
                        <button class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition">
                            Register Now
                        </button>
                    `}
                </div>
            </div>
        </div>
    `;
}

// Filter events by time period
function filterEvents(filter) {
    currentFilter = filter;
    currentPage = 1;

    // Update active tab
    document.querySelectorAll('.filter-tab').forEach(tab => {
        tab.classList.remove('active', 'border-blue-600', 'text-blue-600');
        tab.classList.add('border-transparent', 'text-gray-600');
    });

    event.target.classList.add('active', 'border-blue-600', 'text-blue-600');
    event.target.classList.remove('border-transparent', 'text-gray-600');

    loadEvents();
}

// Filter by category
function filterCategory(category) {
    currentCategory = category;
    currentPage = 1;

    // Update active chip
    document.querySelectorAll('.category-chip').forEach(chip => {
        chip.classList.remove('active', 'bg-blue-600', 'text-white');
        chip.classList.add('bg-gray-100', 'text-gray-700');
    });

    event.target.classList.add('active', 'bg-blue-600', 'text-white');
    event.target.classList.remove('bg-gray-100', 'text-gray-700');

    loadEvents();
}

// Load more events
function loadMoreEvents() {
    if (currentPage < totalPages) {
        loadEvents(currentPage + 1, true);
    }
}

// View event details
function viewEvent(id) {
    window.location.href = `/mobile/events/${id}`;
}

// Search modal
function showSearchModal() {
    document.getElementById('searchModal').classList.remove('hidden');
    setTimeout(() => {
        document.getElementById('searchInput').focus();
    }, 100);
}

function closeSearchModal() {
    document.getElementById('searchModal').classList.add('hidden');
    document.getElementById('searchInput').value = '';
    document.getElementById('searchResults').innerHTML = '<p class="text-gray-500 text-center py-12">Type to search events...</p>';
}

// Perform search
async function performSearch() {
    const query = document.getElementById('searchInput').value.trim();

    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }

    if (query.length === 0) {
        document.getElementById('searchResults').innerHTML = '<p class="text-gray-500 text-center py-12">Type to search events...</p>';
        return;
    }

    searchTimeout = setTimeout(async () => {
        try {
            const result = await ChurchApp.apiCall(`/api/mobile/v1/events/search?q=${encodeURIComponent(query)}`, 'GET');

            if (result.success && result.data) {
                const events = result.data.events || result.data || [];

                if (events.length === 0) {
                    document.getElementById('searchResults').innerHTML = `
                        <p class="text-gray-500 text-center py-12">No events found for "${query}"</p>
                    `;
                } else {
                    const resultsHTML = events.map(event => `
                        <div onclick="viewEvent('${event.id}')" class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 mb-3 cursor-pointer hover:border-blue-600 transition">
                            <h4 class="font-bold text-gray-900 mb-1">${event.title}</h4>
                            <p class="text-sm text-gray-600 mb-2">${new Date(event.start_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</p>
                            ${event.location ? `<p class="text-xs text-gray-500">${event.location}</p>` : ''}
                        </div>
                    `).join('');

                    document.getElementById('searchResults').innerHTML = resultsHTML;
                }
            }
        } catch (error) {
            console.error('Search error:', error);
        }
    }, 300);
}

// Show/hide loading state
function showLoading(isLoading) {
    if (isLoading) {
        document.getElementById('loadingState').classList.remove('hidden');
        document.getElementById('eventsList').classList.add('hidden');
    } else {
        document.getElementById('loadingState').classList.add('hidden');
        document.getElementById('eventsList').classList.remove('hidden');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    loadEvents();
});
</script>

<style>
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}

.hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.line-clamp-1 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
}

.line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
</style>
@endpush
