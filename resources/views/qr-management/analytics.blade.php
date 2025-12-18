@extends('layouts.admin')

@section('title', 'QR Code Analytics')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">QR Code Analytics</h1>
            <p class="text-muted mb-0">Real-time monitoring and performance insights</p>
        </div>
        <div>
            <button class="btn btn-outline-primary mr-2" onclick="refreshData()">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
            <button class="btn btn-primary" onclick="exportAnalytics()">
                <i class="fas fa-download"></i> Export Report
            </button>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="form-inline" id="dateRangeForm">
                <label class="mr-2">Date Range:</label>
                <input type="date" class="form-control mr-2" id="start_date" name="start_date"
                       value="{{ $dateRange['start']->format('Y-m-d') }}">
                <label class="mx-2">to</label>
                <input type="date" class="form-control mr-2" id="end_date" name="end_date"
                       value="{{ $dateRange['end']->format('Y-m-d') }}">
                <button type="submit" class="btn btn-primary">Apply</button>
            </form>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Scans
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($scanStats['total_scans']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-camera fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Successful
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($scanStats['successful_scans']) }}
                            </div>
                            <div class="text-xs text-muted mt-1">
                                {{ $scanStats['total_scans'] > 0 ? number_format(($scanStats['successful_scans'] / $scanStats['total_scans']) * 100, 1) : 0 }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Failed
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($scanStats['failed_scans']) }}
                            </div>
                            <div class="text-xs text-muted mt-1">
                                {{ $scanStats['total_scans'] > 0 ? number_format(($scanStats['failed_scans'] / $scanStats['total_scans']) * 100, 1) : 0 }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Unique Users
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($scanStats['unique_users']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Device Breakdown Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Device Breakdown</h6>
                </div>
                <div class="card-body">
                    <canvas id="deviceChart"></canvas>
                    <div class="mt-3">
                        <div class="row text-center">
                            <div class="col">
                                <strong>iOS</strong><br>
                                <span class="text-primary">{{ $scanStats['device_breakdown']['ios'] }}</span>
                            </div>
                            <div class="col">
                                <strong>Android</strong><br>
                                <span class="text-success">{{ $scanStats['device_breakdown']['android'] }}</span>
                            </div>
                            <div class="col">
                                <strong>Web</strong><br>
                                <span class="text-info">{{ $scanStats['device_breakdown']['web'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Breakdown -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">Error Analysis</h6>
                </div>
                <div class="card-body">
                    @if(count($scanStats['error_breakdown']) > 0)
                        <canvas id="errorChart"></canvas>
                        <div class="table-responsive mt-3">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Error Type</th>
                                        <th class="text-right">Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($scanStats['error_breakdown'] as $error => $count)
                                    <tr>
                                        <td>{{ str_replace('_', ' ', $error) }}</td>
                                        <td class="text-right">{{ $count }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <p class="text-muted">No errors recorded!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Performance Metrics</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center mb-3">
                            <div class="border rounded p-3">
                                <i class="fas fa-clock fa-2x text-primary mb-2"></i>
                                <h5 class="mb-0">{{ number_format($scanStats['avg_processing_time'], 2) }}ms</h5>
                                <small class="text-muted">Avg Processing Time</small>
                            </div>
                        </div>
                        <div class="col-md-3 text-center mb-3">
                            <div class="border rounded p-3">
                                <i class="fas fa-wifi fa-2x text-warning mb-2"></i>
                                <h5 class="mb-0">{{ $scanStats['offline_syncs'] }}</h5>
                                <small class="text-muted">Offline Syncs</small>
                            </div>
                        </div>
                        <div class="col-md-3 text-center mb-3">
                            <div class="border rounded p-3">
                                <i class="fas fa-qrcode fa-2x text-info mb-2"></i>
                                <h5 class="mb-0">{{ $stats['active_qr_codes'] }}</h5>
                                <small class="text-muted">Active QR Codes</small>
                            </div>
                        </div>
                        <div class="col-md-3 text-center mb-3">
                            <div class="border rounded p-3">
                                <i class="fas fa-calendar-day fa-2x text-success mb-2"></i>
                                <h5 class="mb-0">{{ $stats['total_scans_today'] }}</h5>
                                <small class="text-muted">Scans Today</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Recent Scan Activity</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>QR Type</th>
                            <th>User</th>
                            <th>Device</th>
                            <th>Status</th>
                            <th>Processing</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentActivity as $activity)
                        <tr>
                            <td>{{ $activity->scan_time->format('M d, H:i:s') }}</td>
                            <td>
                                <span class="badge badge-primary">
                                    {{ str_replace('_', ' ', $activity->qrCode->type) }}
                                </span>
                            </td>
                            <td>
                                @if($activity->user)
                                    {{ $activity->user->name }}
                                @else
                                    <span class="text-muted">Guest</span>
                                @endif
                            </td>
                            <td>
                                @if($activity->device_type === 'ios')
                                    <i class="fab fa-apple text-secondary"></i>
                                @elseif($activity->device_type === 'android')
                                    <i class="fab fa-android text-success"></i>
                                @else
                                    <i class="fas fa-globe text-info"></i>
                                @endif
                                {{ ucfirst($activity->device_type) }}
                            </td>
                            <td>
                                @if($activity->success)
                                    <span class="badge badge-success">Success</span>
                                @else
                                    <span class="badge badge-danger">
                                        {{ $activity->error_reason }}
                                    </span>
                                @endif
                            </td>
                            <td>{{ $activity->processing_time }}ms</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
// Device Breakdown Chart
const deviceCtx = document.getElementById('deviceChart').getContext('2d');
new Chart(deviceCtx, {
    type: 'doughnut',
    data: {
        labels: ['iOS', 'Android', 'Web'],
        datasets: [{
            data: [
                {{ $scanStats['device_breakdown']['ios'] }},
                {{ $scanStats['device_breakdown']['android'] }},
                {{ $scanStats['device_breakdown']['web'] }}
            ],
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc']
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'bottom'
            }
        }
    }
});

// Error Breakdown Chart
@if(count($scanStats['error_breakdown']) > 0)
const errorCtx = document.getElementById('errorChart').getContext('2d');
new Chart(errorCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($scanStats['error_breakdown'])) !!}.map(label => label.replace(/_/g, ' ')),
        datasets: [{
            label: 'Error Count',
            data: {!! json_encode(array_values($scanStats['error_breakdown'])) !!},
            backgroundColor: '#e74a3b'
        }]
    },
    options: {
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
@endif

// Date range form
document.getElementById('dateRangeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    window.location.href = `?start_date=${startDate}&end_date=${endDate}`;
});

function refreshData() {
    location.reload();
}

function exportAnalytics() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    window.location.href = `/api/v1/qr-management/export/analytics?start_date=${startDate}&end_date=${endDate}`;
}
</script>
@endpush
@endsection
