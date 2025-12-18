@extends('layouts.mobile')

@section('title', 'Performance Metrics - Church App')
@section('header', 'My Performance')

@section('content')
<div class="space-y-6 pb-20">
    <!-- Header with Back Button -->
    <div class="bg-white p-4 -mx-4 -mt-4 shadow-sm border-b border-gray-100 sticky top-0 z-10">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ url('/mobile/shepherd') }}" class="p-2 -ml-2 text-gray-600 hover:bg-gray-100 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-gray-900">Performance Metrics</h1>
            </div>

            <!-- Period Selector -->
            <select id="periodSelector" class="text-sm px-3 py-1.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="week">This Week</option>
                <option value="month" selected>This Month</option>
                <option value="quarter">This Quarter</option>
                <option value="year">This Year</option>
            </select>
        </div>
    </div>

    <!-- Overall Score Card -->
    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-2xl p-6 shadow-lg">
        <div class="text-center">
            <div class="text-sm opacity-90 mb-2">Overall Performance Score</div>
            <div class="text-5xl font-bold mb-2" id="overallScore">-</div>
            <div class="flex items-center justify-center gap-2">
                <div id="scoreChange" class="text-sm font-medium">
                    <!-- Populated via JS -->
                </div>
            </div>
            <div class="mt-4 text-xs opacity-75" id="scorePeriod">Loading...</div>
        </div>
    </div>

    <!-- Key Metrics Grid -->
    <div class="grid grid-cols-2 gap-4">
        <!-- Flock Size -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span class="text-xs text-gray-600 font-medium">Flock Size</span>
            </div>
            <div class="text-2xl font-bold text-gray-900" id="flockSize">-</div>
            <div class="text-xs text-gray-500 mt-1">Active members</div>
        </div>

        <!-- Visits This Period -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    </svg>
                </div>
                <span class="text-xs text-gray-600 font-medium">Visits</span>
            </div>
            <div class="text-2xl font-bold text-gray-900" id="visitsCount">-</div>
            <div class="text-xs text-gray-500 mt-1" id="visitsPeriod">This period</div>
        </div>

        <!-- Attendance Rate -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00-2-2m0 0h2a2 2 0 012 2v0a2 2 0 01-2 2h-2a2 2 0 01-2-2v0zm8-10V3m0 0l3 3m-3-3l-3 3" />
                    </svg>
                </div>
                <span class="text-xs text-gray-600 font-medium">Attendance</span>
            </div>
            <div class="text-2xl font-bold text-gray-900" id="attendanceRate">-</div>
            <div class="text-xs text-gray-500 mt-1">Flock average</div>
        </div>

        <!-- Follow-ups Pending -->
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <span class="text-xs text-gray-600 font-medium">Follow-ups</span>
            </div>
            <div class="text-2xl font-bold text-gray-900" id="followUpsCount">-</div>
            <div class="text-xs text-gray-500 mt-1">Pending</div>
        </div>
    </div>

    <!-- Engagement Breakdown -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Flock Engagement Status</h3>

        <div class="space-y-3">
            <!-- Engaged -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-sm text-gray-700">Engaged</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-900" id="engagedCount">-</span>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div id="engagedBar" class="h-full bg-green-500 transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>

            <!-- Committed -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span class="text-sm text-gray-700">Committed</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-900" id="committedCount">-</span>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div id="committedBar" class="h-full bg-blue-500 transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>

            <!-- Regular -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        <span class="text-sm text-gray-700">Regular</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-900" id="regularCount">-</span>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div id="regularBar" class="h-full bg-yellow-500 transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>

            <!-- At Risk -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <span class="text-sm text-gray-700">At Risk</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-900" id="atRiskCount">-</span>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div id="atRiskBar" class="h-full bg-red-500 transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>

            <!-- Inactive -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                        <span class="text-sm text-gray-700">Inactive</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-900" id="inactiveCount">-</span>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div id="inactiveBar" class="h-full bg-gray-500 transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Visit Activity Chart -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Visit Activity</h3>

        <div class="space-y-3">
            <!-- Home Visits -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm text-gray-700">Home Visits</span>
                    <span class="text-sm font-semibold text-gray-900" id="homeVisitsCount">-</span>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div id="homeVisitsBar" class="h-full bg-blue-500 transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>

            <!-- Hospital Visits -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm text-gray-700">Hospital Visits</span>
                    <span class="text-sm font-semibold text-gray-900" id="hospitalVisitsCount">-</span>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div id="hospitalVisitsBar" class="h-full bg-red-500 transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>

            <!-- Office Visits -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm text-gray-700">Office Visits</span>
                    <span class="text-sm font-semibold text-gray-900" id="officeVisitsCount">-</span>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div id="officeVisitsBar" class="h-full bg-green-500 transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>

            <!-- Phone Calls -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm text-gray-700">Phone Calls</span>
                    <span class="text-sm font-semibold text-gray-900" id="phoneCallsCount">-</span>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div id="phoneCallsBar" class="h-full bg-purple-500 transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Goals & Targets -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Monthly Goals</h3>

        <div class="space-y-4">
            <!-- Visit Target -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-700">Visit each member</span>
                    <span class="text-sm font-semibold text-gray-900">
                        <span id="visitedMembers">-</span> / <span id="totalMembers">-</span>
                    </span>
                </div>
                <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                    <div id="visitGoalBar" class="h-full bg-gradient-to-r from-blue-500 to-blue-600 transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>

            <!-- Minimum Visits Target -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-700">Minimum 12 visits/month</span>
                    <span class="text-sm font-semibold text-gray-900" id="minVisitsProgress">- / 12</span>
                </div>
                <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                    <div id="minVisitsBar" class="h-full bg-gradient-to-r from-green-500 to-green-600 transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>

            <!-- Attendance Goal -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-700">80% Attendance Target</span>
                    <span class="text-sm font-semibold text-gray-900" id="attendanceGoal">-%</span>
                </div>
                <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                    <div id="attendanceGoalBar" class="h-full bg-gradient-to-r from-purple-500 to-purple-600 transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Navigation -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 pb-safe z-50">
    <div class="flex justify-around items-center h-16">
        <a href="{{ url('/mobile/dashboard') }}" class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-xs mt-1">Home</span>
        </a>
        <a href="{{ url('/mobile/shepherd') }}" class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-blue-600">
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
    let performanceData = null;

    document.addEventListener('DOMContentLoaded', async () => {
        await loadPerformanceData('month');

        // Period selector
        document.getElementById('periodSelector').addEventListener('change', async (e) => {
            await loadPerformanceData(e.target.value);
        });
    });

    async function loadPerformanceData(period) {
        ChurchApp.showLoading(true);

        try {
            const result = await ChurchApp.apiCall(`/api/mobile/v1/shepherd/performance?period=${period}`, 'GET');

            if (result.success && result.data) {
                performanceData = result.data;
                renderPerformanceData(period);
            }
        } catch (error) {
            console.error('Failed to load performance data:', error);
            ChurchApp.showToast('Failed to load performance data', 'error');
        } finally {
            ChurchApp.showLoading(false);
        }
    }

    function renderPerformanceData(period) {
        const data = performanceData;
        const stats = data.statistics;
        const engagement = data.engagement_breakdown || {};
        const visits = data.visit_breakdown || {};
        const goals = data.goals || {};

        // Overall Score
        document.getElementById('overallScore').textContent = stats.overall_score || 0;
        document.getElementById('scorePeriod').textContent = getPeriodLabel(period);

        // Score Change
        const scoreChange = stats.score_change || 0;
        const scoreChangeEl = document.getElementById('scoreChange');
        if (scoreChange > 0) {
            scoreChangeEl.innerHTML = `
                <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
                +${scoreChange} from last period
            `;
        } else if (scoreChange < 0) {
            scoreChangeEl.innerHTML = `
                <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                ${scoreChange} from last period
            `;
            scoreChangeEl.classList.add('text-red-200');
        } else {
            scoreChangeEl.innerHTML = 'No change from last period';
        }

        // Key Metrics
        document.getElementById('flockSize').textContent = stats.total_flock_size || 0;
        document.getElementById('visitsCount').textContent = stats.visits_this_period || 0;
        document.getElementById('attendanceRate').textContent = (stats.attendance_rate || 0) + '%';
        document.getElementById('followUpsCount').textContent = stats.pending_followups || 0;
        document.getElementById('visitsPeriod').textContent = 'This ' + period;

        // Engagement Breakdown
        const totalMembers = stats.total_flock_size || 1;
        renderEngagementBar('engaged', engagement.Engaged || 0, totalMembers);
        renderEngagementBar('committed', engagement.Committed || 0, totalMembers);
        renderEngagementBar('regular', engagement.Regular || 0, totalMembers);
        renderEngagementBar('atRisk', engagement['At Risk'] || 0, totalMembers);
        renderEngagementBar('inactive', engagement.Inactive || 0, totalMembers);

        // Visit Activity
        const totalVisits = stats.visits_this_period || 1;
        renderVisitBar('homeVisits', visits.home || 0, totalVisits);
        renderVisitBar('hospitalVisits', visits.hospital || 0, totalVisits);
        renderVisitBar('officeVisits', visits.office || 0, totalVisits);
        renderVisitBar('phoneCalls', visits.call || 0, totalVisits);

        // Goals
        document.getElementById('visitedMembers').textContent = goals.visited_members || 0;
        document.getElementById('totalMembers').textContent = totalMembers;
        document.getElementById('minVisitsProgress').textContent = `${stats.visits_this_period || 0} / 12`;
        document.getElementById('attendanceGoal').textContent = (stats.attendance_rate || 0) + '%';

        const visitGoalPercent = Math.min(100, ((goals.visited_members || 0) / totalMembers) * 100);
        const minVisitsPercent = Math.min(100, ((stats.visits_this_period || 0) / 12) * 100);
        const attendancePercent = Math.min(100, ((stats.attendance_rate || 0) / 80) * 100);

        document.getElementById('visitGoalBar').style.width = visitGoalPercent + '%';
        document.getElementById('minVisitsBar').style.width = minVisitsPercent + '%';
        document.getElementById('attendanceGoalBar').style.width = attendancePercent + '%';
    }

    function renderEngagementBar(key, count, total) {
        const percent = (count / total) * 100;
        document.getElementById(key + 'Count').textContent = count;
        document.getElementById(key + 'Bar').style.width = percent + '%';
    }

    function renderVisitBar(key, count, total) {
        const percent = (count / total) * 100;
        document.getElementById(key + 'Count').textContent = count;
        document.getElementById(key + 'Bar').style.width = percent + '%';
    }

    function getPeriodLabel(period) {
        const labels = {
            'week': 'this week',
            'month': 'this month',
            'quarter': 'this quarter',
            'year': 'this year'
        };
        return 'Performance for ' + (labels[period] || period);
    }
</script>
@endpush
@endsection
