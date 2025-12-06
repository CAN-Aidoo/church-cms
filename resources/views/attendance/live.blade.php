@extends('layouts.app')

@section('head')
<meta name="service-date" content="{{ $serviceDate }}">
<style>
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    .pulse-animation {
        animation: pulse 0.5s ease-in-out;
    }
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    .new-item {
        animation: slideIn 0.3s ease-out;
    }
    @keyframes highlight {
        0% { background-color: #fef3c7; }
        100% { background-color: transparent; }
    }
    .highlight-animation {
        animation: highlight 2s ease-out;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Live Attendance Dashboard</h1>
                <p class="text-gray-600 mt-2">Real-time service attendance tracking</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-sm text-gray-600">Live</span>
                </div>
                <a href="{{ route('attendance.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Attendance
                </a>
            </div>
        </div>
    </div>

    <!-- Service Info -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Service Date</label>
                <input type="date" id="serviceDate" value="{{ $serviceDate }}" class="form-input w-full">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Service Type</label>
                <select id="serviceType" class="form-select w-full">
                    <option value="sunday_first" {{ $serviceType == 'sunday_first' ? 'selected' : '' }}>Sunday First Service</option>
                    <option value="sunday_second" {{ $serviceType == 'sunday_second' ? 'selected' : '' }}>Sunday Second Service</option>
                    <option value="midweek" {{ $serviceType == 'midweek' ? 'selected' : '' }}>Midweek Service</option>
                    <option value="prayer_meeting" {{ $serviceType == 'prayer_meeting' ? 'selected' : '' }}>Prayer Meeting</option>
                    <option value="special" {{ $serviceType == 'special' ? 'selected' : '' }}>Special Service</option>
                </select>
            </div>
            <div class="flex items-end">
                <button onclick="updateService()" class="btn btn-primary w-full">
                    Update Service
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Present</p>
                    <p id="attendanceCount" class="text-4xl font-bold text-blue-600">{{ $todayCount }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">QR Check-ins</p>
                    <p id="qrCheckinsCount" class="text-4xl font-bold text-green-600">{{ $qrCheckinsCount }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">First Timers</p>
                    <p id="firstTimersCount" class="text-4xl font-bold text-yellow-600">{{ $firstTimersCount }}</p>
                </div>
                <div class="bg-yellow-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Attendance Rate</p>
                    <p id="attendanceRate" class="text-4xl font-bold text-purple-600">{{ $attendanceRate }}%</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Attendance Feed -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Check-ins -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Recent Check-ins</h3>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span>Auto-updating</span>
                    </div>
                </div>
                <div id="attendanceList" class="space-y-2 max-h-96 overflow-y-auto">
                    @foreach($recentAttendance as $attendance)
                    <div class="flex items-center justify-between p-3 bg-gray-50 border-l-4 border-blue-500 rounded">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $attendance->member->first_name }} {{ $attendance->member->last_name }}</p>
                            <p class="text-sm text-gray-600">{{ $attendance->check_in_time }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded">
                            {{ ucfirst(str_replace('_', ' ', $attendance->check_in_method ?? 'manual')) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Service Summary -->
        <div class="space-y-6">
            <!-- Check-in Methods -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Check-in Methods</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">QR Code</span>
                        <span class="font-semibold text-gray-800">{{ $qrCheckinsCount }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Manual</span>
                        <span class="font-semibold text-gray-800">{{ $manualCheckinsCount }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Mobile</span>
                        <span class="font-semibold text-gray-800">{{ $mobileCheckinsCount }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('attendance.mark') }}" class="btn btn-primary w-full text-sm">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Mark Attendance
                    </a>
                    <a href="{{ route('qr-codes.service') }}" class="btn btn-success w-full text-sm">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        Generate QR Code
                    </a>
                    <button onclick="exportAttendance()" class="btn btn-secondary w-full text-sm">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Export Data
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="module">
    import { AttendanceRealtime, requestNotificationPermission } from '/resources/js/realtime.js';

    // Request notification permission
    requestNotificationPermission();

    // Listen for real-time attendance updates
    const serviceDate = document.getElementById('serviceDate').value;

    AttendanceRealtime.listenForDate(serviceDate, (data) => {
        console.log('New attendance:', data);

        // Update attendance count
        const countElement = document.getElementById('attendanceCount');
        const currentCount = parseInt(countElement.textContent);
        countElement.textContent = currentCount + 1;
        countElement.classList.add('pulse-animation');
        setTimeout(() => countElement.classList.remove('pulse-animation'), 1000);

        // Update QR check-ins count if applicable
        if (data.check_in_method && data.check_in_method.includes('qr')) {
            const qrCountElement = document.getElementById('qrCheckinsCount');
            const qrCount = parseInt(qrCountElement.textContent);
            qrCountElement.textContent = qrCount + 1;
        }

        // Add to recent check-ins list
        addToAttendanceList(data);

        // Show notification
        if ('Notification' in window && Notification.permission === 'granted') {
            new Notification('New Check-in', {
                body: `${data.member_name} checked in at ${data.check_in_time}`,
                icon: '/images/church-icon.png'
            });
        }
    });

    function addToAttendanceList(data) {
        const list = document.getElementById('attendanceList');
        const item = document.createElement('div');
        item.className = 'attendance-item new-item flex items-center justify-between p-3 bg-green-50 border-l-4 border-green-500 rounded';
        item.innerHTML = `
            <div>
                <p class="font-semibold text-gray-800">${data.member_name}</p>
                <p class="text-sm text-gray-600">${data.check_in_time}</p>
            </div>
            <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded">
                ${data.check_in_method ? data.check_in_method.replace('_', ' ') : 'manual'}
            </span>
        `;
        list.prepend(item);

        // Remove oldest if more than 20
        if (list.children.length > 20) {
            list.removeChild(list.lastChild);
        }
    }

    function updateService() {
        const date = document.getElementById('serviceDate').value;
        const type = document.getElementById('serviceType').value;
        window.location.href = `/attendance/live?date=${date}&type=${type}`;
    }

    function exportAttendance() {
        const date = document.getElementById('serviceDate').value;
        const type = document.getElementById('serviceType').value;
        window.location.href = `/attendance/export?date_from=${date}&date_to=${date}&service_type=${type}`;
    }

    // Make functions available globally
    window.updateService = updateService;
    window.exportAttendance = exportAttendance;
</script>
@endpush
@endsection
