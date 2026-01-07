@extends('layouts.app')

@section('title', 'Visitor Reports')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Visitor Reports & Analytics</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('visitors.index') }}" class="hover:text-primary-600 transition-colors">Visitors</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Reports</span>
        </nav>
    </div>
    <div class="flex items-center gap-3 flex-wrap">
        <a href="{{ route('visitors.export', $filters) }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export Report
        </a>
        <a href="{{ route('visitors.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            All Visitors
        </a>
    </div>
</div>

<!-- Date Range Filter -->
<div class="card border border-slate-100 shadow-sm mb-8">
    <div class="p-6">
        <form method="GET" action="{{ route('visitors.reports') }}" class="flex flex-col md:flex-row items-end gap-4">
            <div class="w-full md:flex-1">
                <label for="date_from" class="form-label mb-1.5 block font-medium text-sm text-slate-700">From Date</label>
                <input type="date" id="date_from" name="date_from"
                       value="{{ $filters['date_from'] }}"
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
            </div>
            <div class="w-full md:flex-1">
                <label for="date_to" class="form-label mb-1.5 block font-medium text-sm text-slate-700">To Date</label>
                <input type="date" id="date_to" name="date_to"
                       value="{{ $filters['date_to'] }}"
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
            </div>
            <button type="submit" class="btn btn-primary w-full md:w-auto shadow-lg shadow-primary-500/30">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                Apply Filters
            </button>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border-l-4 border-l-primary-500 bg-gradient-to-br from-white to-primary-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Visitors</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $statistics['total_visitors'] }}</h3>
            </div>
            <div class="p-3 bg-primary-50 rounded-xl text-primary-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-emerald-500 bg-gradient-to-br from-white to-emerald-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Converted</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $statistics['converted_to_members'] }}</h3>
            </div>
            <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-amber-500 bg-gradient-to-br from-white to-amber-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Eligible</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $statistics['eligible_for_conversion'] }}</h3>
            </div>
            <div class="p-3 bg-amber-50 rounded-xl text-amber-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-purple-500 bg-gradient-to-br from-white to-purple-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Conversion Rate</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $statistics['conversion_rate'] }}%</h3>
            </div>
            <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Monthly Trends Chart -->
    <div class="card border border-slate-100 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Monthly Trends (Last 12 Months)</h3>
        </div>
        <div class="p-6">
            <canvas id="monthlyTrendsChart" height="300"></canvas>
        </div>
    </div>

    <!-- Conversion Funnel Chart -->
    <div class="card border border-slate-100 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Conversion Funnel</h3>
        </div>
        <div class="p-6">
            <canvas id="conversionFunnelChart" height="300"></canvas>
        </div>
    </div>
</div>

<!-- Referral Sources & First-time vs Repeat -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Referral Sources -->
    <div class="card border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Referral Sources</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100">Source</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Count</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Percentage</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 bg-white">
                    @php
                        $totalReferrals = array_sum($referralSources);
                    @endphp
                    @forelse($referralSources as $source => $count)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 capitalize font-medium text-slate-700">{{ str_replace('_', ' ', $source) }}</td>
                        <td class="px-6 py-4 text-right text-slate-700 font-medium">{{ $count }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <div class="w-24 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-primary-500 h-1.5 rounded-full"
                                         style="width: {{ $totalReferrals > 0 ? ($count / $totalReferrals * 100) : 0 }}%"></div>
                                </div>
                                <span class="text-xs font-medium text-slate-500 w-12 text-right">{{ $totalReferrals > 0 ? number_format($count / $totalReferrals * 100, 1) : 0 }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-8 text-slate-500">No referral data available</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- First-time vs Repeat -->
    <div class="card border border-slate-100 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">First-time vs Repeat Visitors</h3>
        </div>
        <div class="p-6">
            <canvas id="visitorTypeChart" height="300"></canvas>
        </div>
    </div>
</div>

<!-- Conversion Funnel Stats -->
<div class="card border border-slate-100 shadow-sm mb-6">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
        <h3 class="font-bold text-slate-800 text-base">Conversion Funnel Breakdown</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center p-6 bg-blue-50/50 rounded-xl border border-blue-100">
                <div class="text-3xl font-heading font-bold text-blue-600 mb-2">{{ $conversionFunnel['total_visitors'] }}</div>
                <div class="text-sm font-medium text-blue-900 mb-1">Total Visitors</div>
                <div class="text-xs font-medium text-blue-500 uppercase tracking-wider">100%</div>
            </div>
            <div class="text-center p-6 bg-emerald-50/50 rounded-xl border border-emerald-100">
                <div class="text-3xl font-heading font-bold text-emerald-600 mb-2">{{ $conversionFunnel['visited_twice'] }}</div>
                <div class="text-sm font-medium text-emerald-900 mb-1">Visited 2+ Times</div>
                <div class="text-xs font-medium text-emerald-500 uppercase tracking-wider">{{ $conversionFunnel['conversion_percentage']['visited_twice'] }}%</div>
            </div>
            <div class="text-center p-6 bg-amber-50/50 rounded-xl border border-amber-100">
                <div class="text-3xl font-heading font-bold text-amber-600 mb-2">{{ $conversionFunnel['visited_five_times'] }}</div>
                <div class="text-sm font-medium text-amber-900 mb-1">Visited 5+ Times</div>
                <div class="text-xs font-medium text-amber-500 uppercase tracking-wider">{{ $conversionFunnel['conversion_percentage']['visited_five_times'] }}%</div>
            </div>
            <div class="text-center p-6 bg-purple-50/50 rounded-xl border border-purple-100">
                <div class="text-3xl font-heading font-bold text-purple-600 mb-2">{{ $conversionFunnel['converted_to_members'] }}</div>
                <div class="text-sm font-medium text-purple-900 mb-1">Converted to Members</div>
                <div class="text-xs font-medium text-purple-500 uppercase tracking-wider">{{ $conversionFunnel['conversion_percentage']['converted'] }}%</div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#64748b';

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
            borderColor: '#3b82f6', // primary-500
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            borderWidth: 2,
            pointBackgroundColor: '#ffffff',
            pointBorderColor: '#3b82f6',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            fill: true
        }, {
            label: 'Return Visitors',
            data: returnVisitorsData,
            borderColor: '#10b981', // emerald-500
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            tension: 0.4,
            borderWidth: 2,
            pointBackgroundColor: '#ffffff',
            pointBorderColor: '#10b981',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            fill: true
        }, {
            label: 'Conversions',
            data: conversionsData,
            borderColor: '#f59e0b', // amber-500
            backgroundColor: 'rgba(245, 158, 11, 0.1)',
            tension: 0.4,
            borderWidth: 2,
            pointBackgroundColor: '#ffffff',
            pointBorderColor: '#f59e0b',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                align: 'end',
                labels: {
                    usePointStyle: true,
                    boxWidth: 8,
                    padding: 20,
                    font: {
                        size: 12
                    }
                }
            },
            tooltip: {
                backgroundColor: '#1e293b',
                padding: 12,
                titleFont: {
                    size: 13,
                    weight: 'bold'
                },
                bodyFont: {
                    size: 12
                },
                cornerRadius: 8,
                displayColors: true
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: '#f1f5f9',
                    borderDash: [2, 2]
                },
                ticks: {
                    font: {
                        size: 11
                    },
                    padding: 10
                },
                border: {
                    display: false
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: {
                        size: 11
                    },
                    padding: 10
                },
                border: {
                    display: false
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index',
        },
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
                '#3b82f6', // primary-500
                '#10b981', // emerald-500
                '#f59e0b', // amber-500
                '#a855f7'  // purple-500
            ],
            borderRadius: 6,
            barPercentage: 0.6,
            categoryPercentage: 0.8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: '#1e293b',
                padding: 12,
                cornerRadius: 8
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: '#f1f5f9',
                    borderDash: [2, 2]
                },
                border: {
                    display: false
                }
            },
            x: {
                grid: {
                    display: false
                },
                border: {
                    display: false
                }
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
                '#3b82f6', // primary-500
                '#10b981'  // emerald-500
            ],
            borderWidth: 0,
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 20
                }
            }
        }
    }
});
</script>
@endsection
