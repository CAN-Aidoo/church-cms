@extends('layouts.admin')

@section('title', 'QR Codes List')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">QR Codes</h1>
            <p class="text-muted mb-0">Manage all generated QR codes</p>
        </div>
        <a href="{{ route('qr-management.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Generate New
        </a>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="form-inline" method="GET">
                <label class="mr-2">Type:</label>
                <select class="form-control mr-3" name="type">
                    <option value="">All Types</option>
                    <option value="SERVICE_ATTENDANCE" {{ request('type') == 'SERVICE_ATTENDANCE' ? 'selected' : '' }}>
                        Service Attendance
                    </option>
                    <option value="EVENT_REGISTRATION" {{ request('type') == 'EVENT_REGISTRATION' ? 'selected' : '' }}>
                        Event Registration
                    </option>
                    <option value="PAYMENT" {{ request('type') == 'PAYMENT' ? 'selected' : '' }}>Payment</option>
                </select>

                <label class="mr-2">Status:</label>
                <select class="form-control mr-3" name="status">
                    <option value="">All Statuses</option>
                    <option value="ACTIVE" {{ request('status') == 'ACTIVE' ? 'selected' : '' }}>Active</option>
                    <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>Pending</option>
                    <option value="EXPIRED" {{ request('status') == 'EXPIRED' ? 'selected' : '' }}>Expired</option>
                    <option value="REVOKED" {{ request('status') == 'REVOKED' ? 'selected' : '' }}>Revoked</option>
                </select>

                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('qr-management.index') }}" class="btn btn-secondary ml-2">Clear</a>
            </form>
        </div>
    </div>

    <!-- QR Codes Table -->
    <div class="card shadow mb-4">
        <div class="card-body">
            @if($qrCodes->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-qrcode fa-4x text-gray-300 mb-3"></i>
                    <p class="text-muted">No QR codes found.</p>
                    <a href="{{ route('qr-management.create') }}" class="btn btn-primary">
                        Generate Your First QR Code
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Service Details</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th>Expiration</th>
                                <th>Scans</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($qrCodes as $qr)
                            <tr>
                                <td>
                                    <code>{{ substr($qr->id, 0, 8) }}...</code>
                                </td>
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
                                    <small>{{ $qr->generated_at->format('M d, Y H:i') }}</small><br>
                                    <small class="text-muted">by {{ $qr->generator->name ?? 'System' }}</small>
                                </td>
                                <td>
                                    @if($qr->revoked)
                                        <span class="badge badge-danger">Revoked</span>
                                    @elseif($qr->isExpired())
                                        <span class="badge badge-secondary">Expired</span>
                                    @elseif($qr->isPending())
                                        <span class="badge badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-success">Active</span>
                                    @endif
                                </td>
                                <td>
                                    @if($qr->isExpired())
                                        <span class="text-danger">
                                            {{ $qr->expiration_time->diffForHumans() }}
                                        </span>
                                    @else
                                        <span class="text-muted">
                                            {{ $qr->expiration_time->diffForHumans() }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-info">
                                        {{ $qr->total_scans }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('qr-management.show', $qr->id) }}"
                                           class="btn btn-info" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(!$qr->revoked && !$qr->isExpired())
                                            <button onclick="revokeQR('{{ $qr->id }}')"
                                                    class="btn btn-danger" title="Revoke">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $qrCodes->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
async function revokeQR(qrId) {
    const result = await Swal.fire({
        title: 'Revoke QR Code?',
        text: 'This action cannot be undone. The QR code will no longer be scannable.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
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
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        } catch (error) {
            Swal.fire('Error', 'Failed to revoke QR code', 'error');
        }
    }
}
</script>
@endpush
@endsection
