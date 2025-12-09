@extends('layouts.mobile')

@section('title', 'Announcements - Church App')
@section('header', 'Announcements')

@section('header-actions')
<button onclick="showFilterModal()" class="p-2 rounded-full hover:bg-white/10">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
    </svg>
</button>
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Priority Filter Tabs -->
    <div class="bg-white shadow-sm sticky top-0 z-10">
        <div class="flex overflow-x-auto hide-scrollbar">
            <button onclick="filterByPriority('all')" class="priority-tab flex-shrink-0 px-6 py-4 font-semibold text-sm border-b-2 transition active border-blue-600 text-blue-600">
                All
            </button>
            <button onclick="filterByPriority('urgent')" class="priority-tab flex-shrink-0 px-6 py-4 font-semibold text-sm border-b-2 transition border-transparent text-gray-600">
                🚨 Urgent
            </button>
            <button onclick="filterByPriority('high')" class="priority-tab flex-shrink-0 px-6 py-4 font-semibold text-sm border-b-2 transition border-transparent text-gray-600">
                High
            </button>
            <button onclick="filterByPriority('normal')" class="priority-tab flex-shrink-0 px-6 py-4 font-semibold text-sm border-b-2 transition border-transparent text-gray-600">
                Normal
            </button>
        </div>
    </div>

    <!-- Category Chips -->
    <div class="bg-white px-4 py-3 border-b border-gray-200">
        <div class="flex items-center space-x-2 overflow-x-auto hide-scrollbar">
            <button onclick="filterByCategory('all')" class="category-chip flex-shrink-0 px-4 py-2 rounded-full font-semibold text-sm transition active bg-blue-600 text-white">
                All
            </button>
            <button onclick="filterByCategory('general')" class="category-chip flex-shrink-0 px-4 py-2 rounded-full font-semibold text-sm transition bg-gray-100 text-gray-700">
                General
            </button>
            <button onclick="filterByCategory('event')" class="category-chip flex-shrink-0 px-4 py-2 rounded-full font-semibold text-sm transition bg-gray-100 text-gray-700">
                Events
            </button>
            <button onclick="filterByCategory('emergency')" class="category-chip flex-shrink-0 px-4 py-2 rounded-full font-semibold text-sm transition bg-gray-100 text-gray-700">
                Emergency
            </button>
            <button onclick="filterByCategory('ministry')" class="category-chip flex-shrink-0 px-4 py-2 rounded-full font-semibold text-sm transition bg-gray-100 text-gray-700">
                Ministry
            </button>
        </div>
    </div>

    <!-- Announcements List -->
    <div class="px-4 py-6">
        <!-- Loading State -->
        <div id="loadingState" class="text-center py-12">
            <svg class="animate-spin h-10 w-10 text-blue-600 mx-auto mb-3" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-500">Loading announcements...</p>
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="hidden text-center py-12">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
            </svg>
            <h3 class="text-lg font-bold text-gray-900 mb-2">No Announcements</h3>
            <p class="text-gray-600">Check back later for updates</p>
        </div>

        <!-- Announcements Grid -->
        <div id="announcementsList" class="space-y-4">
            <!-- Dynamic content -->
        </div>

        <!-- Load More -->
        <div id="loadMoreContainer" class="hidden text-center mt-6">
            <button onclick="loadMoreAnnouncements()" class="bg-white border-2 border-gray-300 text-gray-700 font-semibold py-3 px-6 rounded-lg hover:bg-gray-50 transition">
                Load More
            </button>
        </div>
    </div>
</div>

<!-- Announcement Detail Modal -->
<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 overflow-y-auto">
    <div class="min-h-screen flex items-end md:items-center justify-center">
        <div class="bg-white rounded-t-3xl md:rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Header -->
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900">Announcement Details</h3>
                <button onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div id="detailContent" class="p-6">
                <!-- Dynamic content -->
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div id="filterModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50">
    <div class="h-full flex items-end md:items-center justify-center">
        <div class="bg-white rounded-t-3xl md:rounded-xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Filter Announcements</h3>
                <button onclick="closeFilterModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="filterForm" class="space-y-6">
                <!-- Date Range -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-3">Date Range</label>
                    <div class="space-y-2">
                        <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                            <input type="radio" name="date_range" value="today" class="text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="font-medium text-gray-900">Today</span>
                        </label>
                        <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                            <input type="radio" name="date_range" value="this_week" checked class="text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="font-medium text-gray-900">This Week</span>
                        </label>
                        <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                            <input type="radio" name="date_range" value="this_month" class="text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="font-medium text-gray-900">This Month</span>
                        </label>
                        <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                            <input type="radio" name="date_range" value="all" class="text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="font-medium text-gray-900">All Time</span>
                        </label>
                    </div>
                </div>

                <!-- Apply Button -->
                <div class="pt-4 border-t border-gray-200">
                    <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-blue-700 transition">
                        Apply Filters
                    </button>
                    <button type="button" onclick="clearFilters()" class="w-full mt-2 bg-gray-100 text-gray-700 font-semibold py-3 px-4 rounded-lg hover:bg-gray-200 transition">
                        Clear All
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentPriority = 'all';
let currentCategory = 'all';
let currentDateRange = 'this_week';
let currentPage = 1;
let totalPages = 1;

// Load announcements
async function loadAnnouncements(page = 1, append = false) {
    showLoading(true);

    try {
        const params = new URLSearchParams({
            page: page,
            per_page: 20,
            priority: currentPriority !== 'all' ? currentPriority : '',
            category: currentCategory !== 'all' ? currentCategory : '',
            date_range: currentDateRange
        });

        const result = await ChurchApp.apiCall(`/api/mobile/v1/announcements?${params}`, 'GET');

        if (result.success && result.data) {
            const announcements = result.data.announcements || result.data.data || [];
            const pagination = result.data.pagination;

            if (announcements.length === 0 && !append) {
                document.getElementById('emptyState').classList.remove('hidden');
                document.getElementById('announcementsList').innerHTML = '';
                showLoading(false);
                return;
            }

            document.getElementById('emptyState').classList.add('hidden');

            const html = announcements.map(announcement => renderAnnouncementCard(announcement)).join('');

            if (append) {
                document.getElementById('announcementsList').insertAdjacentHTML('beforeend', html);
            } else {
                document.getElementById('announcementsList').innerHTML = html;
            }

            // Show/hide load more
            if (pagination && pagination.has_more) {
                document.getElementById('loadMoreContainer').classList.remove('hidden');
            } else {
                document.getElementById('loadMoreContainer').classList.add('hidden');
            }

            currentPage = page;
            totalPages = pagination?.last_page || 1;
        }
    } catch (error) {
        console.error('Failed to load announcements:', error);
        ChurchApp.showToast('Failed to load announcements', 'error');
    } finally {
        showLoading(false);
    }
}

// Render announcement card
function renderAnnouncementCard(announcement) {
    const priorityColors = {
        urgent: 'bg-red-100 text-red-800 border-red-200',
        high: 'bg-orange-100 text-orange-800 border-orange-200',
        normal: 'bg-blue-100 text-blue-800 border-blue-200',
        low: 'bg-gray-100 text-gray-800 border-gray-200'
    };

    const categoryIcons = {
        general: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        event: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
        emergency: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
        ministry: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>'
    };

    const priorityClass = priorityColors[announcement.priority] || priorityColors.normal;
    const categoryIcon = categoryIcons[announcement.category] || categoryIcons.general;

    const date = new Date(announcement.created_at);
    const timeAgo = getTimeAgo(date);

    return `
        <div onclick="viewAnnouncement('${announcement.id}')" class="bg-white rounded-xl shadow-sm border-l-4 ${announcement.priority === 'urgent' ? 'border-red-500' : announcement.priority === 'high' ? 'border-orange-500' : 'border-blue-500'} p-4 cursor-pointer hover:shadow-lg transition">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border ${priorityClass}">
                        ${announcement.priority === 'urgent' ? '🚨 ' : ''}${announcement.priority_label || announcement.priority}
                    </span>
                    <span class="text-xs text-gray-500">${announcement.category_label || announcement.category}</span>
                </div>
                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${categoryIcon}
                </svg>
            </div>

            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">${announcement.title}</h3>
            <p class="text-gray-600 text-sm mb-3 line-clamp-3">${announcement.content}</p>

            <div class="flex items-center justify-between text-xs text-gray-500">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    ${timeAgo}
                </div>
                ${announcement.author_name ? `
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        ${announcement.author_name}
                    </div>
                ` : ''}
            </div>

            ${announcement.attachments && announcement.attachments.length > 0 ? `
                <div class="mt-3 pt-3 border-t border-gray-200">
                    <div class="flex items-center text-xs text-blue-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                        </svg>
                        ${announcement.attachments.length} attachment${announcement.attachments.length > 1 ? 's' : ''}
                    </div>
                </div>
            ` : ''}
        </div>
    `;
}

// Get time ago
function getTimeAgo(date) {
    const seconds = Math.floor((new Date() - date) / 1000);

    let interval = seconds / 31536000;
    if (interval > 1) return Math.floor(interval) + ' years ago';

    interval = seconds / 2592000;
    if (interval > 1) return Math.floor(interval) + ' months ago';

    interval = seconds / 86400;
    if (interval > 1) return Math.floor(interval) + ' days ago';

    interval = seconds / 3600;
    if (interval > 1) return Math.floor(interval) + ' hours ago';

    interval = seconds / 60;
    if (interval > 1) return Math.floor(interval) + ' minutes ago';

    return Math.floor(seconds) + ' seconds ago';
}

// Filter by priority
function filterByPriority(priority) {
    currentPriority = priority;
    currentPage = 1;

    document.querySelectorAll('.priority-tab').forEach(tab => {
        tab.classList.remove('active', 'border-blue-600', 'text-blue-600');
        tab.classList.add('border-transparent', 'text-gray-600');
    });

    event.target.classList.add('active', 'border-blue-600', 'text-blue-600');
    event.target.classList.remove('border-transparent', 'text-gray-600');

    loadAnnouncements();
}

// Filter by category
function filterByCategory(category) {
    currentCategory = category;
    currentPage = 1;

    document.querySelectorAll('.category-chip').forEach(chip => {
        chip.classList.remove('active', 'bg-blue-600', 'text-white');
        chip.classList.add('bg-gray-100', 'text-gray-700');
    });

    event.target.classList.add('active', 'bg-blue-600', 'text-white');
    event.target.classList.remove('bg-gray-100', 'text-gray-700');

    loadAnnouncements();
}

// Load more
function loadMoreAnnouncements() {
    if (currentPage < totalPages) {
        loadAnnouncements(currentPage + 1, true);
    }
}

// View announcement details
async function viewAnnouncement(id) {
    document.getElementById('detailModal').classList.remove('hidden');

    try {
        const result = await ChurchApp.apiCall(`/api/mobile/v1/announcements/${id}`, 'GET');

        if (result.success && result.data) {
            const announcement = result.data;
            renderAnnouncementDetail(announcement);
        }
    } catch (error) {
        console.error('Failed to load announcement:', error);
        ChurchApp.showToast('Failed to load announcement details', 'error');
        closeDetailModal();
    }
}

// Render announcement detail
function renderAnnouncementDetail(announcement) {
    const date = new Date(announcement.created_at);
    const formattedDate = date.toLocaleDateString('en-US', {
        weekday: 'long',
        month: 'long',
        day: 'numeric',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });

    let html = `
        <div class="mb-4">
            <div class="flex items-center space-x-2 mb-3">
                <span class="px-3 py-1 rounded-full text-xs font-semibold ${announcement.priority === 'urgent' ? 'bg-red-100 text-red-800' : announcement.priority === 'high' ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800'}">
                    ${announcement.priority_label || announcement.priority}
                </span>
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                    ${announcement.category_label || announcement.category}
                </span>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-3">${announcement.title}</h2>

            <div class="flex items-center text-sm text-gray-600 mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                ${formattedDate}
                ${announcement.author_name ? ` • By ${announcement.author_name}` : ''}
            </div>
        </div>

        <div class="prose prose-sm max-w-none mb-6">
            ${announcement.content.replace(/\n/g, '<br>')}
        </div>
    `;

    if (announcement.attachments && announcement.attachments.length > 0) {
        html += `
            <div class="border-t border-gray-200 pt-4">
                <h4 class="font-semibold text-gray-900 mb-3">Attachments</h4>
                <div class="space-y-2">
                    ${announcement.attachments.map(att => `
                        <a href="${att.url}" target="_blank" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="font-medium text-gray-900">${att.name}</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        </a>
                    `).join('')}
                </div>
            </div>
        `;
    }

    document.getElementById('detailContent').innerHTML = html;
}

// Close detail modal
function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
}

// Show filter modal
function showFilterModal() {
    document.getElementById('filterModal').classList.remove('hidden');
}

// Close filter modal
function closeFilterModal() {
    document.getElementById('filterModal').classList.add('hidden');
}

// Apply filters
document.getElementById('filterForm').addEventListener('submit', (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    currentDateRange = formData.get('date_range');
    currentPage = 1;
    loadAnnouncements();
    closeFilterModal();
});

// Clear filters
function clearFilters() {
    currentPriority = 'all';
    currentCategory = 'all';
    currentDateRange = 'this_week';
    currentPage = 1;
    document.getElementById('filterForm').reset();
    loadAnnouncements();
    closeFilterModal();
}

// Show/hide loading
function showLoading(isLoading) {
    if (isLoading) {
        document.getElementById('loadingState').classList.remove('hidden');
        document.getElementById('announcementsList').classList.add('hidden');
    } else {
        document.getElementById('loadingState').classList.add('hidden');
        document.getElementById('announcementsList').classList.remove('hidden');
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    loadAnnouncements();
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

.line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.line-clamp-3 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}
</style>
@endpush
