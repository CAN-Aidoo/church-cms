@extends('layouts.app')

@section('title', 'Live Attendance')

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
        0% { background-color: #ecfdf5; }
        100% { background-color: transparent; }
    }
    .highlight-animation {
        animation: highlight 2s ease-out;
    }
</style>
@endsection

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-heading font-bold text-slate-900">Live Dashboard</h1>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-white border border-emerald-200 text-emerald-700 shadow-sm animate-pulse">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                LIVE
            </span>
        </div>
        <p class="text-slate-500 mt-1">Real-time service attendance tracking</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('attendance.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            Back to Attendance
        </a>
    </div>
</div>

<!-- Service Info -->
<div class="card border border-slate-100 mb-8 p-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
        <div>
            <label class="form-label mb-1.5 block font-medium text-sm text-slate-700">Service Date</label>
            <input type="date" id="serviceDate" value="{{ $serviceDate }}" class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
        </div>
        <div>
            <label class="form-label mb-1.5 block font-medium text-sm text-slate-700">Service Type</label>
            <select id="serviceType" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                <option value="sunday_first" {{ $serviceType == 'sunday_first' ? 'selected' : '' }}>Sunday First Service</option>
                <option value="sunday_second" {{ $serviceType == 'sunday_second' ? 'selected' : '' }}>Sunday Second Service</option>
                <option value="midweek" {{ $serviceType == 'midweek' ? 'selected' : '' }}>Midweek Service</option>
                <option value="prayer_meeting" {{ $serviceType == 'prayer_meeting' ? 'selected' : '' }}>Prayer Meeting</option>
                <option value="special" {{ $serviceType == 'special' ? 'selected' : '' }}>Special Service</option>
            </select>
        </div>
        <div>
            <button onclick="updateService()" class="btn btn-primary w-full">
                Update Dashboard
            </button>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border-l-4 border-l-primary-500 bg-gradient-to-br from-white to-primary-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Present</p>
                <h3 id="attendanceCount" class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $todayCount }}</h3>
            </div>
            <div class="p-2 bg-primary-100/50 rounded-lg text-primary-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-emerald-500 bg-gradient-to-br from-white to-emerald-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">QR Check-ins</p>
                <h3 id="qrCheckinsCount" class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $qrCheckinsCount }}</h3>
            </div>
            <div class="p-2 bg-emerald-100/50 rounded-lg text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-amber-500 bg-gradient-to-br from-white to-amber-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">First Timers</p>
                <h3 id="firstTimersCount" class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $firstTimersCount }}</h3>
            </div>
            <div class="p-2 bg-amber-100/50 rounded-lg text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-indigo-500 bg-gradient-to-br from-white to-indigo-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Attendance Rate</p>
                <h3 id="attendanceRate" class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $attendanceRate }}%</h3>
            </div>
            <div class="p-2 bg-indigo-100/50 rounded-lg text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Live Attendance Feed -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Check-ins -->
    <div class="lg:col-span-2">
        <div class="card border border-slate-100 h-full flex flex-col">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 text-base">Recent Check-ins</h3>
                <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    Auto-updating
                </div>
            </div>
            <div id="attendanceList" class="p-6 space-y-3 max-h-[500px] overflow-y-auto custom-scrollbar flex-1">
                @foreach($recentAttendance as $attendance)
                <div class="flex items-center justify-between p-4 bg-white border border-slate-100 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500">
                            {{ strtoupper(substr($attendance->member->first_name, 0, 1)) }}{{ strtoupper(substr($attendance->member->last_name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">{{ $attendance->member->first_name }} {{ $attendance->member->last_name }}</p>
                            <p class="text-xs text-slate-500 font-mono">{{ $attendance->check_in_time }}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-secondary-50 text-secondary-700 ring-1 ring-inset ring-secondary-600/20">
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
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Check-in Methods</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between p-3 rounded-lg bg-emerald-50/50 border border-emerald-100">
                    <span class="text-sm font-medium text-slate-600">QR Code</span>
                    <span class="font-bold text-slate-900">{{ $qrCheckinsCount }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50 border border-slate-100">
                    <span class="text-sm font-medium text-slate-600">Manual</span>
                    <span class="font-bold text-slate-900">{{ $manualCheckinsCount }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-lg bg-blue-50/50 border border-blue-100">
                    <span class="text-sm font-medium text-slate-600">Mobile</span>
                    <span class="font-bold text-slate-900">{{ $mobileCheckinsCount }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Quick Actions</h3>
            </div>
            <div class="p-6 space-y-3">
                <a href="{{ route('attendance.mark') }}" class="btn btn-primary w-full justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Mark Attendance
                </a>
                <a href="{{ route('qr-codes.service') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 w-full justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    Generate QR Code
                </a>
                <button onclick="exportAttendance()" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 w-full justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export Data
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="module">
    // Ideally these would be imported, but for now we leave the implementation 
    // structured as it was, assuming the JS paths are correct.
    // import { AttendanceRealtime, requestNotificationPermission } from '/resources/js/realtime.js';

    // Mocking the import for the refactor if module not found, or relying on existing infrastructure.
    // Assuming the user has this setup.
    
    // START: Placeholder for actual import if it exists, otherwise simplified logic
    // We will keep the original logic but update the DOM manipulation to match new classes
    
    // For safety, let's assume the previous script worked and just update the DOM creation part.
</script>

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
        // Updated classes to match new design
        item.className = 'new-item flex items-center justify-between p-4 bg-emerald-50 border border-emerald-100 rounded-xl shadow-sm transition-shadow mb-3';
        
        // Initial of member
        const initial = data.member_name.charAt(0).toUpperCase();
        
        item.innerHTML = `
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-xs font-bold text-emerald-600">
                    ${initial}
                </div>
                <div>
                    <p class="font-bold text-slate-800">${data.member_name}</p>
                    <p class="text-xs text-slate-500 font-mono">${data.check_in_time}</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
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
