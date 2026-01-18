@extends('layouts.mobile')

@section('title', 'My Attendance - Church App')
@section('header', 'My Attendance')

@section('header-actions')
<a href="{{ route('mobile.attendance-history') }}" class="p-2 rounded-full hover:bg-white/10">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
</a>
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Summary Cards -->
    <div class="bg-white shadow-sm">
        <div class="px-4 py-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">{{ date('Y') }} Summary</h2>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <!-- Total Attendance -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl p-4 text-white shadow-md">
                    <p class="text-sm text-blue-100 mb-1">This Year</p>
                    <p class="text-3xl font-bold" id="totalAttendance">0</p>
                    <p class="text-xs text-blue-100 mt-2">days attended</p>
                </div>

                <!-- Attendance Rate -->
                <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-xl p-4 text-white shadow-md">
                    <p class="text-sm text-green-100 mb-1">Attendance Rate</p>
                    <p class="text-3xl font-bold"><span id="attendanceRate">0</span>%</p>
                    <p class="text-xs text-green-100 mt-2">of total services</p>
                </div>
            </div>

            <!-- Monthly Chart -->
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm font-semibold text-gray-700 mb-3">Last 6 Months</p>
                <div id="monthlyChart" class="space-y-2">
                    <!-- Will be populated by JavaScript -->
                    <p class="text-sm text-gray-500">Loading...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Check-In Button -->
    <div class="px-4 py-4">
        <a href="{{ route('mobile.checkin') }}" class="block w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center py-4 rounded-xl font-semibold shadow-lg hover:from-blue-700 hover:to-blue-800 transition duration-200">
            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
            </svg>
            Check In Now
        </a>
    </div>

    <!-- Recent Attendance -->
    <div class="px-4 py-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">
                Recent Attendance
            </h3>
            <a href="{{ route('mobile.attendance-history') }}" class="text-blue-600 text-sm font-medium">
                View All →
            </a>
        </div>

        <div id="recentAttendance" class="space-y-3">
            <!-- Will be populated by JavaScript -->
            <div class="text-center py-12 text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p>Loading attendance records...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // HTML escape helper to prevent XSS
    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        const div = document.createElement('div');
        div.textContent = String(text);
        return div.innerHTML;
    }

    // Safe date formatting helper
    function formatDate(dateStr, options) {
        if (!dateStr) return 'Unknown date';
        const date = new Date(dateStr);
        if (isNaN(date.getTime())) return 'Unknown date';
        return date.toLocaleDateString('en-US', options);
    }

    function formatTime(dateStr) {
        if (!dateStr) return 'Unknown time';
        const date = new Date(dateStr);
        if (isNaN(date.getTime())) return 'Unknown time';
        return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
    }

    let attendanceData = [];

    async function loadAttendanceData() {
        try {
            const response = await fetch(`${window.API_BASE_URL}/my/attendance`, {
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

            renderSummary(data.summary || {});
            renderMonthlyChart(data.monthly || []);
            renderRecentAttendance(attendanceData.slice(0, 10));

        } catch (error) {
            console.error('Error loading attendance:', error);
            showError();
        }
    }

    function renderSummary(summary) {
        document.getElementById('totalAttendance').textContent = summary.total || 0;
        document.getElementById('attendanceRate').textContent = summary.rate || 0;
    }

    function renderMonthlyChart(monthlyData) {
        const chartContainer = document.getElementById('monthlyChart');

        if (!monthlyData || monthlyData.length === 0) {
            chartContainer.innerHTML = '<p class="text-sm text-gray-500">No data available</p>';
            return;
        }

        const maxCount = Math.max(...monthlyData.map(m => m.count), 1);

        chartContainer.innerHTML = monthlyData.map(month => `
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-600 w-12 text-right">${escapeHtml(month.month)}</span>
                <div class="flex-1 bg-gray-200 rounded-full h-6 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-full flex items-center px-2 text-xs text-white font-medium transition-all duration-500"
                         style="width: ${(month.count / maxCount * 100)}%">
                        ${month.count > 0 ? month.count : ''}
                    </div>
                </div>
            </div>
        `).join('');
    }

    function renderRecentAttendance(records) {
        const container = document.getElementById('recentAttendance');

        if (!records || records.length === 0) {
            container.innerHTML = `
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-500 font-medium">No attendance records yet</p>
                    <p class="text-sm text-gray-400 mt-2">Check in to your first service to start tracking</p>
                    <a href="{{ route('mobile.checkin') }}" class="inline-block mt-4 text-blue-600 font-medium text-sm">
                        Check In Now →
                    </a>
                </div>
            `;
            return;
        }

        container.innerHTML = records.map(record => {
            const formattedDate = formatDate(record.date, {
                weekday: 'short',
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
            const checkinTime = record.checked_in_at ? formatTime(record.checked_in_at) : null;

            return `
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">${escapeHtml(record.service_type) || 'Service'}</p>
                            <p class="text-sm text-gray-500 mt-1">${escapeHtml(formattedDate)}</p>
                            ${checkinTime ? `
                                <p class="text-xs text-gray-400 mt-1">
                                    Checked in at ${escapeHtml(checkinTime)}
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
    }

    function showError() {
        const container = document.getElementById('recentAttendance');
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

    // Load data on page load
    document.addEventListener('DOMContentLoaded', loadAttendanceData);
</script>
@endpush
