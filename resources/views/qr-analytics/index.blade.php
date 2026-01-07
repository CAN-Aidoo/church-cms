@extends('layouts.app')

@section('title', 'QR Code Analytics')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">QR Code Analytics</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>QR Analytics</span>
        </nav>
    </div>
    <div class="page-actions">
        <form action="{{ route('qr-analytics.export') }}" method="POST" class="inline">
            @csrf
            <input type="hidden" name="period" value="{{ $period }}">
            <button type="submit" class="btn btn-outline">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export CSV
            </button>
        </form>

        <!-- Period Filter -->
        <div class="inline-flex rounded-lg border border-gray-300 bg-white">
            <a href="{{ route('qr-analytics.index', ['period' => 7]) }}"
               class="px-4 py-2 text-sm font-medium {{ $period == 7 ? 'bg-primary-600 text-white' : 'text-gray-700 hover:bg-gray-50' }} rounded-l-lg">
                7 Days
            </a>
            <a href="{{ route('qr-analytics.index', ['period' => 30]) }}"
               class="px-4 py-2 text-sm font-medium {{ $period == 30 ? 'bg-primary-600 text-white' : 'text-gray-700 hover:bg-gray-50' }} border-l border-gray-300">
                30 Days
            </a>
            <a href="{{ route('qr-analytics.index', ['period' => 90]) }}"
               class="px-4 py-2 text-sm font-medium {{ $period == 90 ? 'bg-primary-600 text-white' : 'text-gray-700 hover:bg-gray-50' }} border-l border-gray-300">
                90 Days
            </a>
            <a href="{{ route('qr-analytics.index', ['period' => 365]) }}"
               class="px-4 py-2 text-sm font-medium {{ $period == 365 ? 'bg-primary-600 text-white' : 'text-gray-700 hover:bg-gray-50' }} border-l border-gray-300 rounded-r-lg">
                1 Year
            </a>
        </div>
    </div>
</div>

<!-- Stat Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="stat-card stat-card-gradient-blue">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z"/>
            </svg>
        </div>
        <div class="stat-value">{{ number_format($totalMemberQRs) }}</div>
        <div class="stat-label">Member QR Codes</div>
        <div class="stat-subtext">Generated</div>
    </div>

    <div class="stat-card stat-card-gradient-purple">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z"/>
            </svg>
        </div>
        <div class="stat-value">{{ number_format($totalProgramQRs) }}</div>
        <div class="stat-label">Program QR Codes</div>
        <div class="stat-subtext">Active</div>
    </div>

    <div class="stat-card stat-card-gradient-gold">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="stat-value">{{ number_format($totalScans) }}</div>
        <div class="stat-label">Total Scans</div>
        <div class="stat-subtext">Last {{ $period }} days</div>
    </div>

    <div class="stat-card bg-white text-gray-900 border border-gray-200">
        <div class="stat-icon text-primary-600">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
            </svg>
        </div>
        <div class="stat-value">{{ number_format($uniqueScanners) }}</div>
        <div class="stat-label">Unique Scanners</div>
        <div class="stat-subtext">Different members</div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Scan Trends Line Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Scan Trends</h3>
        </div>
        <div class="card-body">
            <canvas id="scanTrendsChart" height="300"></canvas>
        </div>
    </div>

    <!-- Check-In Method Breakdown Doughnut Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Check-In Methods</h3>
        </div>
        <div class="card-body">
            <canvas id="checkInMethodsChart" height="300"></canvas>
        </div>
    </div>
</div>

<!-- Tables Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Top Scanned Members -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Top Scanned Members</h3>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th class="text-center">Total Scans</th>
                            <th>Last Scan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topMembers as $member)
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    @if($member->photo_url)
                                    <img src="{{ Storage::url($member->photo_url) }}"
                                         alt="{{ $member->full_name }}"
                                         class="w-8 h-8 rounded-full object-cover mr-3">
                                    @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-primary flex items-center justify-center text-white text-xs font-bold mr-3">
                                        {{ strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1)) }}
                                    </div>
                                    @endif
                                    <a href="{{ route('members.show', $member) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                        {{ $member->full_name }}
                                    </a>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-primary-100 text-primary-800">
                                    {{ number_format($member->qr_scan_count) }}
                                </span>
                            </td>
                            <td class="text-sm text-gray-600">
                                {{ $member->last_qr_scan ? $member->last_qr_scan->format('M d, Y g:i A') : 'Never' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-8 text-gray-500">
                                No scan data available
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Peak Scan Times -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Peak Scan Times</h3>
        </div>
        <div class="card-body">
            @if(count($peakTimes) > 0)
            <div class="space-y-3">
                @foreach($peakTimes as $time)
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-gray-700">{{ $time['hour'] }}</span>
                        <span class="text-sm font-semibold text-gray-900">{{ number_format($time['count']) }} scans</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-primary h-2 rounded-full" style="width: {{ $time['percentage'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8 text-gray-500">
                No scan time data available
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Program QR Usage -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Program QR Usage</h3>
    </div>
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Program Name</th>
                        <th class="text-center">QR Type</th>
                        <th class="text-center">Reg Scans</th>
                        <th class="text-center">Check-in Scans</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($programStats as $program)
                    <tr>
                        <td>
                            <a href="{{ route('programs.show', $program) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                {{ $program->name }}
                            </a>
                        </td>
                        <td class="text-center">
                            <div class="flex justify-center gap-1">
                                @if($program->registration_qr_code)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                    Reg
                                </span>
                                @endif
                                @if($program->check_in_qr_code)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                    Check
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="text-center text-sm font-semibold">{{ number_format($program->reg_scans ?? 0) }}</td>
                        <td class="text-center text-sm font-semibold">{{ number_format($program->checkin_scans ?? 0) }}</td>
                        <td>
                            <span class="badge {{ $program->getStatusBadgeClass() }}">
                                {{ ucfirst($program->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-gray-500">
                            No program QR data available
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Scan Trends Line Chart
const scanTrendsCtx = document.getElementById('scanTrendsChart').getContext('2d');
new Chart(scanTrendsCtx, {
    type: 'line',
    data: {
        labels: @json($scanTrends['dates']),
        datasets: [{
            label: 'QR Scans',
            data: @json($scanTrends['counts']),
            borderColor: '#2563eb',
            backgroundColor: 'rgba(37, 99, 235, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointRadius: 4,
            pointHoverRadius: 6,
            pointBackgroundColor: '#2563eb',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
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
                mode: 'index',
                intersect: false,
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#2563eb',
                borderWidth: 1,
                padding: 12,
                displayColors: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Check-In Methods Doughnut Chart
const checkInMethodsCtx = document.getElementById('checkInMethodsChart').getContext('2d');
new Chart(checkInMethodsCtx, {
    type: 'doughnut',
    data: {
        labels: ['QR Code', 'Manual', 'Other'],
        datasets: [{
            data: @json($checkInMethods),
            backgroundColor: [
                '#2563eb',
                '#64748b',
                '#eab308'
            ],
            borderColor: '#fff',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true,
                    font: {
                        size: 13
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#2563eb',
                borderWidth: 1,
                padding: 12,
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.parsed || 0;
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        return label + ': ' + value + ' (' + percentage + '%)';
                    }
                }
            }
        }
    }
});
</script>
@endpush

@endsection
