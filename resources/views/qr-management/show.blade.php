@extends('layouts.admin')

@section('title', 'QR Code Details')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">QR Code Details</h1>
            <p class="text-muted mb-0">ID: <code>{{ $qrCode->id }}</code></p>
        </div>
        <div>
            <a href="{{ route('qr-management.index') }}" class="btn btn-secondary mr-2">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <button onclick="printQR('{{ $qrCode->id }}')" class="btn btn-primary">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
    </div>

    <div class="row">
        <!-- QR Code Display -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">QR Code</h6>
                </div>
                <div class="card-body text-center">
                    <div id="qrCodeDisplay" class="mb-3">
                        <!-- QR code image will be loaded here -->
                    </div>
                    <p><strong>Status:</strong>
                        @if($qrCode->revoked)
                            <span class="badge badge-danger">Revoked</span>
                        @elseif($qrCode->isExpired())
                            <span class="badge badge-secondary">Expired</span>
                        @elseif($qrCode->isPending())
                            <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-success">Active</span>
                        @endif
                    </p>
                    <div class="btn-group-vertical w-100">
                        <button onclick="downloadQR()" class="btn btn-success mb-2">
                            <i class="fas fa-download"></i> Download
                        </button>
                        @if(!$qrCode->revoked)
                            <button onclick="revokeQR()" class="btn btn-danger mb-2">
                                <i class="fas fa-ban"></i> Revoke
                            </button>
                            @if(!$qrCode->isExpired())
                                <button onclick="extendQR()" class="btn btn-warning">
                                    <i class="fas fa-clock"></i> Extend
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="card shadow mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Total Scans:</strong>
                        <span class="float-right badge badge-primary">{{ $qrCode->total_scans }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Unique Users:</strong>
                        <span class="float-right badge badge-info">{{ $qrCode->unique_users }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Success Rate:</strong>
                        <span class="float-right badge badge-success">{{ number_format($qrCode->success_rate, 1) }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details & Configuration -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Configuration Details</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th>Type:</th>
                                    <td>
                                        <span class="badge badge-primary">
                                            {{ str_replace('_', ' ', $qrCode->type) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Service Date:</th>
                                    <td>{{ $qrCode->service_date ? \Carbon\Carbon::parse($qrCode->service_date)->format('M d, Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Service Type:</th>
                                    <td>{{ $qrCode->service_type ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Generated By:</th>
                                    <td>{{ $qrCode->generator->name ?? 'System' }}</td>
                                </tr>
                                <tr>
                                    <th>Generated At:</th>
                                    <td>{{ $qrCode->generated_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th>Activation:</th>
                                    <td>{{ $qrCode->activation_time->format('M d, Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Expiration:</th>
                                    <td>
                                        {{ $qrCode->expiration_time->format('M d, Y H:i:s') }}
                                        <br>
                                        <small class="text-muted">{{ $qrCode->expiration_time->diffForHumans() }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Location Required:</th>
                                    <td>
                                        @if($qrCode->location_required)
                                            <span class="badge badge-success">Yes</span>
                                            ({{ $qrCode->location_radius }}m radius)
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Max Scans:</th>
                                    <td>{{ $qrCode->max_scans ?? 'Unlimited' }}</td>
                                </tr>
                                <tr>
                                    <th>Offline Allowed:</th>
                                    <td>
                                        @if($qrCode->offline_allowed)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics Tab -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Analytics</h6>
                </div>
                <div class="card-body">
                    <canvas id="scanTrendsChart" height="80"></canvas>
                </div>
            </div>

            <!-- Scan Logs -->
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-warning">Recent Scan Logs</h6>
                    <button onclick="exportLogs()" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>User</th>
                                    <th>Device</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Processing</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($scanLogs as $log)
                                <tr>
                                    <td>{{ $log->scan_time->format('M d, H:i:s') }}</td>
                                    <td>
                                        @if($log->user)
                                            {{ $log->user->name }}
                                        @else
                                            <span class="text-muted">Guest</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->device_type === 'ios')
                                            <i class="fab fa-apple"></i>
                                        @elseif($log->device_type === 'android')
                                            <i class="fab fa-android"></i>
                                        @else
                                            <i class="fas fa-globe"></i>
                                        @endif
                                        {{ ucfirst($log->device_type) }}
                                    </td>
                                    <td>
                                        @if($log->distance_from_church)
                                            {{ $log->distance_from_church }}m
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->success)
                                            <span class="badge badge-success">Success</span>
                                        @else
                                            <span class="badge badge-danger" title="{{ $log->error_reason }}">
                                                Failed
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $log->processing_time }}ms</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No scan logs yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
const qrId = '{{ $qrCode->id }}';

// Load QR code image
document.addEventListener('DOMContentLoaded', async function() {
    try {
        const response = await fetch(`/api/v1/qr-management/${qrId}`, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        const data = await response.json();

        // Display QR code (placeholder - need actual image generation)
        document.getElementById('qrCodeDisplay').innerHTML =
            `<div class="alert alert-info">QR Code Image</div>`;
    } catch (error) {
        console.error('Failed to load QR code', error);
    }
});

// Chart
const ctx = document.getElementById('scanTrendsChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($analytics['hourly_distribution'] ?? array_fill(0, 24, 0)).map((_, i) => i + ':00'),
        datasets: [{
            label: 'Scans per Hour',
            data: @json(array_values($analytics['hourly_distribution'] ?? array_fill(0, 24, 0))),
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.05)',
            tension: 0.3
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
        }
    }
});

function downloadQR() {
    // Implementation for downloading QR code image
    alert('Download functionality - integrate with actual QR image');
}

function printQR(qrId) {
    window.open(`/qr-management/print/preview?qr_ids=${qrId}`, '_blank');
}

async function revokeQR() {
    const result = await Swal.fire({
        title: 'Revoke QR Code?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, revoke it!'
    });

    if (result.isConfirmed) {
        try {
            const response = await fetch(`/api/v1/qr-management/${qrId}/revoke`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
            });
            const data = await response.json();

            if (data.success) {
                Swal.fire('Revoked!', 'QR code has been revoked.', 'success')
                    .then(() => location.reload());
            }
        } catch (error) {
            Swal.fire('Error', 'Failed to revoke QR code', 'error');
        }
    }
}

async function extendQR() {
    const { value: minutes } = await Swal.fire({
        title: 'Extend QR Code',
        input: 'number',
        inputLabel: 'Extend by (minutes)',
        inputPlaceholder: '60',
        showCancelButton: true
    });

    if (minutes) {
        try {
            const response = await fetch(`/api/v1/qr-management/${qrId}/extend`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                },
                body: JSON.stringify({ minutes: parseInt(minutes) })
            });
            const data = await response.json();

            if (data.success) {
                Swal.fire('Extended!', 'Expiration has been extended.', 'success')
                    .then(() => location.reload());
            }
        } catch (error) {
            Swal.fire('Error', 'Failed to extend QR code', 'error');
        }
    }
}

function exportLogs() {
    window.location.href = `/api/v1/qr-management/${qrId}/scan-logs?export=csv`;
}
</script>
@endpush
@endsection
