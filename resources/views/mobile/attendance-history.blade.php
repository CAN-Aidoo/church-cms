@extends('layouts.mobile')

@section('title', 'Attendance History - Church App')
@section('header', 'Attendance History')

@section('header-actions')
<button onclick="showFilterModal()" class="p-2 rounded-full hover:bg-white/10">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
    </svg>
</button>
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Filter Chips -->
    <div id="activeFilters" class="hidden px-4 py-3 bg-white border-b border-gray-200">
        <div class="flex items-center space-x-2 overflow-x-auto hide-scrollbar">
            <span class="text-sm text-gray-600 flex-shrink-0">Filters:</span>
            <div id="filterChips" class="flex space-x-2">
                <!-- Filter chips will be added here -->
            </div>
            <button onclick="clearFilters()" class="text-sm text-blue-600 hover:underline flex-shrink-0">
                Clear all
            </button>
        </div>
    </div>

    <!-- Attendance List -->
    <div class="px-4 py-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">
                Records (<span id="recordCount">0</span>)
            </h3>
            <button onclick="exportHistory()" class="text-blue-600 text-sm font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export
            </button>
        </div>

        <div id="attendanceList" class="space-y-3">
            <!-- Will be populated by JavaScript -->
            <div class="text-center py-12 text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p>Loading attendance history...</p>
            </div>
        </div>

        <!-- Load More Button -->
        <div id="loadMoreContainer" class="hidden mt-6 text-center">
            <button onclick="loadMoreRecords()" id="loadMoreBtn" class="bg-white border-2 border-gray-300 text-gray-700 font-semibold py-3 px-6 rounded-lg hover:bg-gray-50 transition duration-200">
                Load More
            </button>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div id="filterModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl max-w-md w-full mx-4 max-h-[80vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900">Filter Records</h3>
            <button onclick="closeFilterModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="filterForm" class="p-6 space-y-6">
            <!-- Date Range -->
            <div>
                <label class="block text-gray-700 font-semibold mb-3">Date Range</label>
                <div class="space-y-2">
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="radio" name="date_range" value="this_month" checked class="text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">This Month</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="radio" name="date_range" value="last_month" class="text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">Last Month</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="radio" name="date_range" value="this_year" class="text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">This Year</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="radio" name="date_range" value="all_time" class="text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">All Time</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="radio" name="date_range" value="custom" class="text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">Custom Range</span>
                    </label>
                </div>

                <!-- Custom Date Range -->
                <div id="customDateRange" class="hidden mt-3 space-y-3 p-4 bg-gray-50 rounded-lg">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">From</label>
                        <input type="date" name="start_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">To</label>
                        <input type="date" name="end_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Service Type Filter -->
            <div>
                <label class="block text-gray-700 font-semibold mb-3">Service Type</label>
                <div class="space-y-2">
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" name="service_type[]" value="all" checked class="text-blue-600 focus:ring-blue-500 mr-3 rounded">
                        <span class="font-medium text-gray-900">All Services</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" name="service_type[]" value="Sunday Service" class="text-blue-600 focus:ring-blue-500 mr-3 rounded">
                        <span class="font-medium text-gray-900">Sunday Service</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" name="service_type[]" value="Bible Study" class="text-blue-600 focus:ring-blue-500 mr-3 rounded">
                        <span class="font-medium text-gray-900">Bible Study</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" name="service_type[]" value="Prayer Meeting" class="text-blue-600 focus:ring-blue-500 mr-3 rounded">
                        <span class="font-medium text-gray-900">Prayer Meeting</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" name="service_type[]" value="Special Event" class="text-blue-600 focus:ring-blue-500 mr-3 rounded">
                        <span class="font-medium text-gray-900">Special Event</span>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="resetFilters()" class="flex-1 bg-gray-100 text-gray-700 font-semibold py-3 px-6 rounded-lg hover:bg-gray-200 transition duration-200">
                    Reset
                </button>
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-3 px-6 rounded-lg hover:from-blue-700 hover:to-blue-800 transition duration-200">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let attendanceData = [];
    let filteredData = [];
    let currentPage = 1;
    const itemsPerPage = 20;
    let filters = {
        dateRange: 'this_month',
        startDate: null,
        endDate: null,
        serviceTypes: ['all']
    };

    async function loadAttendanceData() {
        try {
            const params = new URLSearchParams();
            if (filters.dateRange === 'custom' && filters.startDate && filters.endDate) {
                params.append('start_date', filters.startDate);
                params.append('end_date', filters.endDate);
            } else {
                params.append('range', filters.dateRange);
            }

            const response = await fetch(`${window.API_BASE_URL}/my/attendance?${params}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                if (response.status === 401) {
                    window.location.href = '/mobile/login';
                    return;
                }
                throw new Error('Failed to fetch attendance data');
            }

            const data = await response.json();
            attendanceData = data.attendance || [];
            applyFilters();

        } catch (error) {
            console.error('Error loading attendance:', error);
            showError();
        }
    }

    function applyFilters() {
        filteredData = attendanceData.filter(record => {
            // Service type filter
            if (!filters.serviceTypes.includes('all')) {
                if (!filters.serviceTypes.includes(record.service_type)) {
                    return false;
                }
            }
            return true;
        });

        currentPage = 1;
        renderAttendanceList();
        updateFilterChips();
    }

    function renderAttendanceList() {
        const container = document.getElementById('attendanceList');
        const startIndex = 0;
        const endIndex = currentPage * itemsPerPage;
        const displayData = filteredData.slice(startIndex, endIndex);

        document.getElementById('recordCount').textContent = filteredData.length;

        if (filteredData.length === 0) {
            container.innerHTML = `
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-500 font-medium">No attendance records found</p>
                    <p class="text-sm text-gray-400 mt-2">Try adjusting your filters</p>
                </div>
            `;
            document.getElementById('loadMoreContainer').classList.add('hidden');
            return;
        }

        container.innerHTML = displayData.map(record => {
            const date = new Date(record.date);
            const formattedDate = date.toLocaleDateString('en-US', {
                weekday: 'short',
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });

            return `
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">${record.service_type || 'Service'}</p>
                            <p class="text-sm text-gray-500 mt-1">${formattedDate}</p>
                            ${record.checked_in_at ? `
                                <p class="text-xs text-gray-400 mt-1">
                                    Checked in at ${new Date(record.checked_in_at).toLocaleTimeString('en-US', {
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })}
                                </p>
                            ` : ''}
                        </div>
                        <div class="ml-4">
                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        // Show/hide load more button
        const loadMoreContainer = document.getElementById('loadMoreContainer');
        if (endIndex < filteredData.length) {
            loadMoreContainer.classList.remove('hidden');
        } else {
            loadMoreContainer.classList.add('hidden');
        }
    }

    function loadMoreRecords() {
        currentPage++;
        renderAttendanceList();
    }

    function showFilterModal() {
        document.getElementById('filterModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeFilterModal() {
        document.getElementById('filterModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function updateFilterChips() {
        const chipsContainer = document.getElementById('filterChips');
        const activeFiltersDiv = document.getElementById('activeFilters');
        const chips = [];

        // Date range chip
        const rangeLabels = {
            'this_month': 'This Month',
            'last_month': 'Last Month',
            'this_year': 'This Year',
            'all_time': 'All Time',
            'custom': 'Custom Range'
        };

        if (filters.dateRange !== 'this_month') {
            chips.push(`
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    ${rangeLabels[filters.dateRange]}
                </span>
            `);
        }

        // Service type chips
        if (!filters.serviceTypes.includes('all') && filters.serviceTypes.length > 0) {
            filters.serviceTypes.forEach(type => {
                chips.push(`
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                        ${type}
                    </span>
                `);
            });
        }

        if (chips.length > 0) {
            chipsContainer.innerHTML = chips.join('');
            activeFiltersDiv.classList.remove('hidden');
        } else {
            activeFiltersDiv.classList.add('hidden');
        }
    }

    function resetFilters() {
        filters = {
            dateRange: 'this_month',
            startDate: null,
            endDate: null,
            serviceTypes: ['all']
        };
        document.getElementById('filterForm').reset();
        document.querySelector('input[name="date_range"][value="this_month"]').checked = true;
        document.querySelector('input[name="service_type[]"][value="all"]').checked = true;
    }

    function clearFilters() {
        resetFilters();
        applyFilters();
        closeFilterModal();
    }

    function exportHistory() {
        // Create CSV content
        const csvContent = [
            ['Date', 'Service Type', 'Check-In Time'],
            ...filteredData.map(record => [
                record.date,
                record.service_type || 'Service',
                record.checked_in_at || 'N/A'
            ])
        ].map(row => row.join(',')).join('\n');

        // Download
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `attendance-history-${new Date().toISOString().split('T')[0]}.csv`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }

    function showError() {
        const container = document.getElementById('attendanceList');
        container.innerHTML = `
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-gray-700 font-medium">Failed to load attendance data</p>
                <button onclick="loadAttendanceData()" class="mt-4 text-blue-600 font-medium text-sm hover:underline">
                    Try Again
                </button>
            </div>
        `;
    }

    // Event listeners
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault();

        filters.dateRange = document.querySelector('input[name="date_range"]:checked').value;

        if (filters.dateRange === 'custom') {
            filters.startDate = document.querySelector('input[name="start_date"]').value;
            filters.endDate = document.querySelector('input[name="end_date"]').value;
        }

        const serviceTypeInputs = document.querySelectorAll('input[name="service_type[]"]:checked');
        filters.serviceTypes = Array.from(serviceTypeInputs).map(input => input.value);

        closeFilterModal();
        loadAttendanceData();
    });

    // Show custom date range when selected
    document.querySelectorAll('input[name="date_range"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const customDateRange = document.getElementById('customDateRange');
            if (this.value === 'custom') {
                customDateRange.classList.remove('hidden');
            } else {
                customDateRange.classList.add('hidden');
            }
        });
    });

    // Handle "All Services" checkbox
    document.querySelector('input[name="service_type[]"][value="all"]').addEventListener('change', function() {
        const otherCheckboxes = document.querySelectorAll('input[name="service_type[]"]:not([value="all"])');
        if (this.checked) {
            otherCheckboxes.forEach(cb => cb.checked = false);
        }
    });

    document.querySelectorAll('input[name="service_type[]"]:not([value="all"])').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                document.querySelector('input[name="service_type[]"][value="all"]').checked = false;
            }
        });
    });

    // Load data on page load
    document.addEventListener('DOMContentLoaded', loadAttendanceData);
</script>
@endpush
