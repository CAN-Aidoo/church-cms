@extends('layouts.mobile')

@section('title', 'Shepherd Dashboard')

@section('content')
<div class="space-y-6 pb-20">
    <!-- Header with Stats -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-b-3xl p-6 shadow-lg -mx-4 -mt-4">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold">My Flock</h1>
                <p class="text-blue-100 opacity-90">{{ auth()->user()->member->first_name }}'s Dashboard</p>
            </div>
            <div class="bg-white/20 p-2 rounded-full backdrop-blur-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 text-center">
            <div class="bg-white/10 rounded-xl p-3 backdrop-blur-sm">
                <span class="block text-2xl font-bold" id="total-members">-</span>
                <span class="text-xs text-blue-100">Total</span>
            </div>
            <div class="bg-white/10 rounded-xl p-3 backdrop-blur-sm">
                <span class="block text-2xl font-bold" id="visits-month">-</span>
                <span class="text-xs text-blue-100">Visits (M)</span>
            </div>
            <div class="bg-white/10 rounded-xl p-3 backdrop-blur-sm">
                <span class="block text-2xl font-bold" id="attendance-rate">-</span>
                <span class="text-xs text-blue-100">Att. Rate</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-2 gap-4 px-1">
        <a href="{{ url('/mobile/shepherd/visit') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 active:scale-95 transition">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <span class="font-medium text-gray-700">Record Visit</span>
        </a>
        <a href="{{ url('/mobile/shepherd/message') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 active:scale-95 transition">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mb-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
            </div>
            <span class="font-medium text-gray-700">Message Flock</span>
        </a>
    </div>

    <!-- Flock List -->
    <div>
        <div class="flex justify-between items-center mb-4 px-1">
            <h2 class="text-lg font-bold text-gray-800">My Flock Members</h2>
            <div class="relative">
                <input type="text" id="member-search" placeholder="Search..." class="pl-8 pr-4 py-1.5 text-sm bg-gray-100 border-none rounded-lg w-32 focus:w-48 transition-all duration-300 focus:ring-2 focus:ring-blue-500">
                <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <div id="flock-list" class="space-y-3">
            <!-- Loading State -->
            <div class="animate-pulse space-y-3">
                @for ($i = 0; $i < 3; $i++)
                <div class="bg-white p-4 rounded-xl border border-gray-100 flex items-center gap-4">
                    <div class="w-10 h-10 bg-gray-200 rounded-full"></div>
                    <div class="flex-1">
                        <div class="h-4 bg-gray-200 rounded w-1/2 mb-2"></div>
                        <div class="h-3 bg-gray-200 rounded w-1/3"></div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>

<!-- Bottom Navigation for Shepherd -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 pb-safe z-50">
    <div class="flex justify-around items-center h-16">
        <a href="{{ url('/mobile/dashboard') }}" class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-xs mt-1">Home</span>
        </a>
        <a href="{{ url('/mobile/shepherd') }}" class="flex flex-col items-center justify-center w-full h-full text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="text-xs mt-1">Flock</span>
        </a>
        <a href="{{ url('/mobile/shepherd/visits') }}" class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span class="text-xs mt-1">History</span>
        </a>
    </div>
</nav>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const flockList = document.getElementById('flock-list');
        const searchInput = document.getElementById('member-search');
        
        try {
            // Load Dashboard Stats
            const dashboardRes = await ChurchApp.apiCall('/api/mobile/v1/shepherd/performance', 'GET');
            if (dashboardRes.success) {
                const stats = dashboardRes.data.statistics;
                document.getElementById('total-members').textContent = stats.total_flock_size || 0;
                document.getElementById('visits-month').textContent = stats.visits_this_month || 0;
                document.getElementById('attendance-rate').textContent = (stats.attendance_rate || 0) + '%';
            }

            // Load Flock List
            const flockRes = await ChurchApp.apiCall('/api/mobile/v1/shepherd/flock', 'GET');
            if (flockRes.success) {
                const members = flockRes.data.data; // Paginated response
                renderFlockList(members);

                // Search functionality
                searchInput.addEventListener('input', (e) => {
                    const term = e.target.value.toLowerCase();
                    const filtered = members.filter(m =>
                        m.first_name.toLowerCase().includes(term) ||
                        m.last_name.toLowerCase().includes(term)
                    );
                    renderFlockList(filtered);
                });
            }
        } catch (error) {
            console.error('Failed to load shepherd data:', error);
            ChurchApp.showToast('Failed to load data', 'error');
        }

        function renderFlockList(members) {
            if (members.length === 0) {
                flockList.innerHTML = `
                    <div class="text-center py-10 text-gray-500">
                        <p>No members found in your flock.</p>
                    </div>
                `;
                return;
            }

            const mobileBase = '{{ url('/mobile') }}';
            flockList.innerHTML = members.map(member => `
                <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4 active:bg-gray-50 transition" onclick="window.location.href='${mobileBase}/shepherd/member/${member.id}'">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-lg">
                        ${member.first_name[0]}${member.last_name[0]}
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-gray-900">${member.first_name} ${member.last_name}</h3>
                            <span class="text-xs px-2 py-0.5 rounded-full ${getEngagementColor(member.engagement_status)}">
                                ${member.engagement_status || 'Regular'}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 truncate">${member.phone || 'No phone'}</p>
                        <div class="mt-1 flex items-center gap-3 text-xs text-gray-400">
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Last seen: ${member.last_attendance ? formatDate(member.last_attendance) : 'Never'}
                            </span>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            `).join('');
        }

        function getEngagementColor(status) {
            switch(status) {
                case 'Engaged': return 'bg-green-100 text-green-700';
                case 'Committed': return 'bg-blue-100 text-blue-700';
                case 'Regular': return 'bg-yellow-100 text-yellow-700';
                case 'At Risk': return 'bg-red-100 text-red-700';
                case 'Inactive': return 'bg-gray-100 text-gray-700';
                default: return 'bg-blue-100 text-blue-700';
            }
        }

        function formatDate(dateStr) {
            if (!dateStr) return 'N/A';
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        }
    });
</script>
@endpush
@endsection
