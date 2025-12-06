@extends('layouts.app')

@section('title', 'Visitor Reports')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Visitor Reports & Analytics</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('visitors.index') }}">Visitors</a>
            <span>/</span>
            <span>Reports</span>
        </nav>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('visitors.export', $filters) }}" class="btn btn-outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export Report
        </a>
        <a href="{{ route('visitors.index') }}" class="btn btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            All Visitors
        </a>
    </div>
</div>

<!-- Date Range Filter -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" action="{{ route('visitors.reports') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label for="date_from" class="form-label">From Date</label>
                <input type="date" id="date_from" name="date_from"
                       value="{{ $filters['date_from'] }}"
                       class="form-input">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" id="date_to" name="date_to"
                       value="{{ $filters['date_to'] }}"
                       class="form-input">
            </div>
            <button type="submit" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Apply
            </button>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="stat-card bg-gradient-primary">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $statistics['total_visitors'] }}</div>
            <div class="stat-label">Total Visitors</div>
        </div>
    </div>

    <div class="stat-card bg-gradient-to-br from-green-500 to-green-600">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $statistics['converted_to_members'] }}</div>
            <div class="stat-label">Converted to Members</div>
        </div>
    </div>

    <div class="stat-card bg-gradient-gold">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $statistics['eligible_for_conversion'] }}</div>
            <div class="stat-label">Eligible for Conversion</div>
        </div>
    </div>

    <div class="stat-card bg-gradient-to-br from-purple-500 to-purple-600">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ $statistics['conversion_rate'] }}%</div>
            <div class="stat-label">Conversion Rate</div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Monthly Trends Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Monthly Trends (Last 12 Months)</h3>
        </div>
        <div class="card-body">
            <canvas id="monthlyTrendsChart" height="300"></canvas>
        </div>
    </div>

    <!-- Conversion Funnel Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Conversion Funnel</h3>
        </div>
        <div class="card-body">
            <canvas id="conversionFunnelChart" height="300"></canvas>
        </div>
    </div>
</div>

<!-- Referral Sources & First-time vs Repeat -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Referral Sources -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Referral Sources</h3>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Source</th>
                            <th class="text-right">Count</th>
                            <th class="text-right">Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalReferrals = array_sum($referralSources);
                        @endphp
                        @forelse($referralSources as $source => $count)
                        <tr>
                            <td class="capitalize font-medium">{{ str_replace('_', ' ', $source) }}</td>
                            <td class="text-right">{{ $count }}</td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <div class="flex-1 max-w-[100px] bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full"
                                             style="width: {{ $totalReferrals > 0 ? ($count / $totalReferrals * 100) : 0 }}%"></div>
                                    </div>
                                    <span class="text-sm">{{ $totalReferrals > 0 ? number_format($count / $totalReferrals * 100, 1) : 0 }}%</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-8 text-gray-500">No referral data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- First-time vs Repeat -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">First-time vs Repeat Visitors</h3>
        </div>
        <div class="card-body">
            <canvas id="visitorTypeChart" height="300"></canvas>
        </div>
    </div>
</div>

<!-- Conversion Funnel Stats -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Conversion Funnel Breakdown</h3>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <div class="text-3xl font-bold text-blue-600 mb-2">{{ $conversionFunnel['total_visitors'] }}</div>
                <div class="text-sm text-gray-600 mb-1">Total Visitors</div>
                <div class="text-xs text-gray-500">100%</div>
            </div>
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <div class="text-3xl font-bold text-green-600 mb-2">{{ $conversionFunnel['visited_twice'] }}</div>
                <div class="text-sm text-gray-600 mb-1">Visited 2+ Times</div>
                <div class="text-xs text-gray-500">{{ $conversionFunnel['conversion_percentage']['visited_twice'] }}%</div>
            </div>
            <div class="text-center p-4 bg-gold-50 rounded-lg">
                <div class="text-3xl font-bold text-gold-600 mb-2">{{ $conversionFunnel['visited_five_times'] }}</div>
                <div class="text-sm text-gray-600 mb-1">Visited 5+ Times</div>
                <div class="text-xs text-gray-500">{{ $conversionFunnel['conversion_percentage']['visited_five_times'] }}%</div>
            </div>
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <div class="text-3xl font-bold text-purple-600 mb-2">{{ $conversionFunnel['converted_to_members'] }}</div>
                <div class="text-sm text-gray-600 mb-1">Converted to Members</div>
                <div class="text-xs text-gray-500">{{ $conversionFunnel['conversion_percentage']['converted'] }}%</div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Monthly Trends Chart
const trendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
const trendsData = @json($trends);
const trendsLabels = Object.keys(trendsData);
const newVisitorsData = trendsLabels.map(label => trendsData[label].new_visitors);
const returnVisitorsData = trendsLabels.map(label => trendsData[label].return_visitors);
const conversionsData = trendsLabels.map(label => trendsData[label].conversions);

new Chart(trendsCtx, {
    type: 'line',
    data: {
        labels: trendsLabels,
        datasets: [{
            label: 'New Visitors',
            data: newVisitorsData,
            borderColor: 'rgb(37, 99, 235)',
            backgroundColor: 'rgba(37, 99, 235, 0.1)',
            tension: 0.4
        }, {
            label: 'Return Visitors',
            data: returnVisitorsData,
            borderColor: 'rgb(34, 197, 94)',
            backgroundColor: 'rgba(34, 197, 94, 0.1)',
            tension: 0.4
        }, {
            label: 'Conversions',
            data: conversionsData,
            borderColor: 'rgb(234, 179, 8)',
            backgroundColor: 'rgba(234, 179, 8, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Conversion Funnel Chart
const funnelCtx = document.getElementById('conversionFunnelChart').getContext('2d');
const funnelData = @json($conversionFunnel);

new Chart(funnelCtx, {
    type: 'bar',
    data: {
        labels: ['Total Visitors', 'Visited 2+', 'Visited 5+', 'Converted'],
        datasets: [{
            label: 'Count',
            data: [
                funnelData.total_visitors,
                funnelData.visited_twice,
                funnelData.visited_five_times,
                funnelData.converted_to_members
            ],
            backgroundColor: [
                'rgba(37, 99, 235, 0.8)',
                'rgba(34, 197, 94, 0.8)',
                'rgba(234, 179, 8, 0.8)',
                'rgba(168, 85, 247, 0.8)'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// First-time vs Repeat Chart
const typeCtx = document.getElementById('visitorTypeChart').getContext('2d');
new Chart(typeCtx, {
    type: 'doughnut',
    data: {
        labels: ['First-time Visitors', 'Repeat Visitors'],
        datasets: [{
            data: [{{ $firstTimeVisitors }}, {{ $repeatVisitors }}],
            backgroundColor: [
                'rgba(37, 99, 235, 0.8)',
                'rgba(34, 197, 94, 0.8)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});
</script>
@endsection
