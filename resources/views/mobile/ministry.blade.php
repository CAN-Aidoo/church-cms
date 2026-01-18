@extends('layouts.mobile')

@section('title', 'My Ministry - Church App')
@section('header', 'My Ministry')

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Overview Cards -->
    <div class="bg-white shadow-sm">
        <div class="px-4 py-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Overview</h2>

            <div class="grid grid-cols-2 gap-4">
                <!-- Service Units -->
                <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl p-4 text-white shadow-md">
                    <p class="text-sm text-purple-100 mb-1">Service Units</p>
                    <p class="text-3xl font-bold" id="unitCount">0</p>
                    <p class="text-xs text-purple-100 mt-2">units assigned</p>
                </div>

                <!-- Active Duties -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl p-4 text-white shadow-md">
                    <p class="text-sm text-blue-100 mb-1">Active Duties</p>
                    <p class="text-3xl font-bold" id="dutyCount">0</p>
                    <p class="text-xs text-blue-100 mt-2">this month</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Units -->
    <div class="px-4 py-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">My Service Units</h3>

        <div id="serviceUnits" class="space-y-3">
            <div class="text-center py-12 text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p>Loading service units...</p>
            </div>
        </div>
    </div>

    <!-- Upcoming Duties -->
    <div class="px-4 py-6 bg-white mt-4">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Upcoming Duties</h3>

        <div id="upcomingDuties" class="space-y-3">
            <p class="text-sm text-gray-500">Loading...</p>
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

    let ministryData = {};

    async function loadMinistryData() {
        try {
            // Load ministry involvement
            const ministryResponse = await fetch(`${window.API_BASE_URL}/my/ministry`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (!ministryResponse.ok) throw new Error('Failed to fetch ministry data');

            const ministryData = await ministryResponse.json();

            // Load service units
            const unitsResponse = await fetch(`${window.MOBILE_API_BASE_URL}/service-unit/my-units`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (!unitsResponse.ok) throw new Error('Failed to fetch service units');

            const unitsData = await unitsResponse.json();

            renderOverview(ministryData, unitsData);
            renderServiceUnits(unitsData.units || []);
            renderUpcomingDuties(ministryData.upcoming_duties || []);

        } catch (error) {
            console.error('Error loading ministry data:', error);
            showError();
        }
    }

    function renderOverview(ministry, units) {
        document.getElementById('unitCount').textContent = units.units?.length || 0;
        document.getElementById('dutyCount').textContent = ministry.active_duties_count || 0;
    }

    function renderServiceUnits(units) {
        const container = document.getElementById('serviceUnits');

        if (units.length === 0) {
            container.innerHTML = `
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p class="text-gray-500 font-medium">No service units assigned</p>
                    <p class="text-sm text-gray-400 mt-2">Contact your church admin to get involved</p>
                </div>
            `;
            return;
        }

        container.innerHTML = units.map(unit => {
            const roleColors = {
                'leader': 'bg-purple-100 text-purple-800',
                'assistant_leader': 'bg-blue-100 text-blue-800',
                'member': 'bg-gray-100 text-gray-800'
            };

            return `
                <a href="{{ url('/mobile/service-unit/dashboard') }}" class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-semibold text-gray-900">${escapeHtml(unit.name)}</h4>
                        <span class="px-2 py-1 rounded-full text-xs font-medium ${roleColors[unit.role] || roleColors.member}">
                            ${escapeHtml(unit.role)}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600">${escapeHtml(unit.description) || 'No description'}</p>
                    <div class="flex items-center gap-4 mt-3 text-xs text-gray-500">
                        <span>${unit.member_count || 0} members</span>
                        <span>${unit.upcoming_duties || 0} upcoming duties</span>
                    </div>
                </a>
            `;
        }).join('');
    }

    function renderUpcomingDuties(duties) {
        const container = document.getElementById('upcomingDuties');

        if (duties.length === 0) {
            container.innerHTML = '<p class="text-sm text-gray-500">No upcoming duties</p>';
            return;
        }

        container.innerHTML = duties.map(duty => {
            const date = new Date(duty.date);
            const formattedDate = date.toLocaleDateString('en-US', {
                weekday: 'short',
                month: 'short',
                day: 'numeric'
            });

            return `
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                    <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">${escapeHtml(duty.service_unit)}</p>
                        <p class="text-sm text-gray-600">${escapeHtml(duty.duty_name)}</p>
                        <p class="text-xs text-gray-500">${formattedDate}</p>
                    </div>
                </div>
            `;
        }).join('');
    }

    function showError() {
        document.getElementById('serviceUnits').innerHTML = `
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-gray-700 font-medium">Failed to load ministry data</p>
                <button onclick="loadMinistryData()" class="mt-4 text-blue-600 font-medium text-sm hover:underline">
                    Try Again
                </button>
            </div>
        `;
    }

    document.addEventListener('DOMContentLoaded', loadMinistryData);
</script>
@endpush
