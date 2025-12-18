@extends('layouts.admin')

@section('title', 'QR Code Management Dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">QR Code Management</h1>
            <p class="text-muted mb-0">Generate, manage, and monitor QR codes for church services</p>
        </div>
        <a href="{{ route('qr-management.create') }}" class="btn btn-primary">
            <i class="fas fa-qrcode"></i> Generate New QR Code
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Active QR Codes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['active_qr_codes'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-qrcode fa-2x text-gray-300"></i>
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
                                Scans Today
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total_scans_today'] }}
                            </div>
                            <div class="text-xs text-success mt-1">
                                <i class="fas fa-check-circle"></i> {{ $stats['successful_scans_today'] }} successful
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
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Success Rate
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['success_rate_today'], 1) }}%
                            </div>
                            <div class="progress progress-sm mt-2">
                                <div class="progress-bar bg-info" role="progressbar"
                                     style="width: {{ $stats['success_rate_today'] }}%"
                                     aria-valuenow="{{ $stats['success_rate_today'] }}"
                                     aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Unique Users Today
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['unique_users_today'] }}
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
        <!-- Active QR Codes -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Active QR Codes</h6>
                    <a href="{{ route('qr-management.index') }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    @if($activeQRCodes->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-qrcode fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">No active QR codes at the moment.</p>
                            <a href="{{ route('qr-management.create') }}" class="btn btn-primary">
                                Generate Your First QR Code
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Service Details</th>
                                        <th>Expiration</th>
                                        <th>Scans</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activeQRCodes as $qr)
                                    <tr>
                                        <td>
                                            <span class="badge badge-primary">
                                                {{ str_replace('_', ' ', $qr->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($qr->service_date)
                                                <strong>{{ \Carbon\Carbon::parse($qr->service_date)->format('M d, Y') }}</strong><br>
                                                <small class="text-muted">{{ $qr->service_type }}</small>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-muted small">
                                                {{ $qr->expiration_time->diffForHumans() }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-success">
                                                {{ $qr->total_scans }} scans
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('qr-management.show', $qr->id) }}"
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Expiring Soon -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Expiring Soon</h6>
                </div>
                <div class="card-body">
                    @if($expiringSoon->isEmpty())
                        <p class="text-muted text-center py-3">No QR codes expiring soon.</p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($expiringSoon as $qr)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ str_replace('_', ' ', $qr->type) }}</strong>
                                        <br>
                                        <small class="text-danger">
                                            <i class="fas fa-clock"></i>
                                            Expires {{ $qr->expiration_time->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-outline-primary"
                                                onclick="extendQR('{{ $qr->id }}')">
                                            <i class="fas fa-plus-circle"></i> Extend
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('qr-management.create', ['type' => 'SERVICE_ATTENDANCE']) }}"
                           class="list-group-item list-group-item-action">
                            <i class="fas fa-church text-primary"></i> Generate Service QR
                        </a>
                        <a href="{{ route('qr-management.create', ['type' => 'EVENT_REGISTRATION']) }}"
                           class="list-group-item list-group-item-action">
                            <i class="fas fa-calendar-check text-success"></i> Generate Event QR
                        </a>
                        <a href="{{ route('qr-management.create', ['type' => 'PAYMENT']) }}"
                           class="list-group-item list-group-item-action">
                            <i class="fas fa-money-bill-wave text-info"></i> Generate Payment QR
                        </a>
                        <a href="{{ route('qr-management.analytics') }}"
                           class="list-group-item list-group-item-action">
                            <i class="fas fa-chart-line text-warning"></i> View Analytics
                        </a>
                        <a href="{{ route('qr-management.settings') }}"
                           class="list-group-item list-group-item-action">
                            <i class="fas fa-cog text-secondary"></i> QR Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function extendQR(qrId) {
    Swal.fire({
        title: 'Extend QR Code',
        input: 'number',
        inputLabel: 'Extend by (minutes)',
        inputPlaceholder: '60',
        inputAttributes: {
            min: 1,
            max: 1440,
            step: 1
        },
        showCancelButton: true,
        confirmButtonText: 'Extend',
        showLoaderOnConfirm: true,
        preConfirm: (minutes) => {
            return fetch(`/api/v1/qr-management/${qrId}/extend`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                },
                body: JSON.stringify({ minutes: parseInt(minutes) })
            })
            .then(response => response.json())
            .catch(error => {
                Swal.showValidationMessage(`Request failed: ${error}`);
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed && result.value.success) {
            Swal.fire('Extended!', 'QR code expiration has been extended.', 'success')
                .then(() => location.reload());
        }
    });
}
</script>
@endpush
@endsection
