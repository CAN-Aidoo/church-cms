@extends('layouts.admin')

@section('title', 'Generate QR Code')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Generate New QR Code</h1>
            <p class="text-muted mb-0">Create a secure QR code for various church activities</p>
        </div>
        <a href="{{ route('qr-management.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">QR Code Configuration</h6>
                </div>
                <div class="card-body">
                    <form id="qrGenerationForm">
                        @csrf

                        <!-- QR Code Type -->
                        <div class="form-group">
                            <label for="type">QR Code Type <span class="text-danger">*</span></label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Select Type...</option>
                                <option value="SERVICE_ATTENDANCE">Service Attendance</option>
                                <option value="EVENT_REGISTRATION">Event Registration</option>
                                <option value="PAYMENT">Payment</option>
                                <option value="CHECK_IN">General Check-In</option>
                                <option value="VISITOR_REGISTRATION">Visitor Registration</option>
                                <option value="EQUIPMENT_CHECKOUT">Equipment Checkout</option>
                                <option value="VERIFICATION">Verification</option>
                            </select>
                            <small class="form-text text-muted">Choose the primary purpose of this QR code</small>
                        </div>

                        <!-- Service Details (shown only for SERVICE_ATTENDANCE) -->
                        <div id="serviceDetails" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="service_date">Service Date</label>
                                        <input type="date" class="form-control" id="service_date" name="service_date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="service_type">Service Type</label>
                                        <select class="form-control" id="service_type" name="service_type">
                                            <option value="sunday_first">Sunday First Service</option>
                                            <option value="sunday_second">Sunday Second Service</option>
                                            <option value="wednesday">Wednesday Service</option>
                                            <option value="friday">Friday Service</option>
                                            <option value="special">Special Service</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="service_time">Service Time</label>
                                <input type="time" class="form-control" id="service_time" name="service_time">
                                <small class="form-text text-muted">
                                    QR will activate 30 minutes before and expire 2 hours after
                                </small>
                            </div>
                        </div>

                        <!-- Time Settings -->
                        <div class="form-group">
                            <label>Activation & Expiration</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="datetime-local" class="form-control" id="activation_time"
                                           name="activation_time" placeholder="Activation Time">
                                    <small class="form-text text-muted">Leave blank for immediate activation</small>
                                </div>
                                <div class="col-md-6">
                                    <input type="datetime-local" class="form-control" id="expiration_time"
                                           name="expiration_time" placeholder="Expiration Time">
                                    <small class="form-text text-muted">Leave blank for default (24 hours)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Location Settings -->
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Location Settings</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="location_required"
                                           name="location_required" checked>
                                    <label class="form-check-label" for="location_required">
                                        Require GPS verification
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="location_radius">Allowed Radius (meters)</label>
                                    <input type="number" class="form-control" id="location_radius"
                                           name="location_radius" value="100" min="10" max="1000">
                                    <small class="form-text text-muted">
                                        Users must be within this radius to scan (default: 100m)
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Options -->
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Advanced Options</h6>
                                <div class="form-group">
                                    <label for="max_scans">Maximum Scans</label>
                                    <input type="number" class="form-control" id="max_scans" name="max_scans"
                                           placeholder="Unlimited">
                                    <small class="form-text text-muted">
                                        Leave blank for unlimited scans
                                    </small>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="allow_family"
                                           name="allow_family">
                                    <label class="form-check-label" for="allow_family">
                                        Allow family check-in
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="requires_verification"
                                           name="requires_verification" checked>
                                    <label class="form-check-label" for="requires_verification">
                                        Require verification
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="offline_allowed"
                                           name="offline_allowed" checked>
                                    <label class="form-check-label" for="offline_allowed">
                                        Allow offline scanning
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                                Cancel
                            </button>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-qrcode"></i> Generate QR Code
                                </button>
                                <button type="button" class="btn btn-success ml-2" onclick="generateBatch()">
                                    <i class="fas fa-copy"></i> Generate Batch
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview & Tips -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">QR Code Preview</h6>
                </div>
                <div class="card-body text-center" id="qrPreview">
                    <div class="py-5">
                        <i class="fas fa-qrcode fa-5x text-gray-300 mb-3"></i>
                        <p class="text-muted">QR code will appear here after generation</p>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Tips & Best Practices</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i>
                            <small>Enable GPS verification for security</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i>
                            <small>Set appropriate expiration times</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i>
                            <small>Allow offline scanning for areas with poor signal</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i>
                            <small>Test QR codes before event day</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i>
                            <small>Print QR codes in high quality (300 DPI)</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Show/hide service details based on type
document.getElementById('type').addEventListener('change', function() {
    const serviceDetails = document.getElementById('serviceDetails');
    if (this.value === 'SERVICE_ATTENDANCE') {
        serviceDetails.style.display = 'block';
    } else {
        serviceDetails.style.display = 'none';
    }
});

// Handle form submission
document.getElementById('qrGenerationForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());

    // Convert checkboxes to booleans
    data.location_required = document.getElementById('location_required').checked;
    data.allow_family = document.getElementById('allow_family').checked;
    data.requires_verification = document.getElementById('requires_verification').checked;
    data.offline_allowed = document.getElementById('offline_allowed').checked;

    try {
        const response = await fetch('{{ route('qr-management.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            // Display QR code
            document.getElementById('qrPreview').innerHTML = `
                <img src="${result.data.image}" alt="QR Code" class="img-fluid mb-3">
                <p class="mb-2"><strong>QR ID:</strong> ${result.data.id}</p>
                <p class="mb-2"><strong>Type:</strong> ${result.data.type}</p>
                <p class="mb-3"><strong>Expires:</strong> ${new Date(result.data.expiration_time).toLocaleString()}</p>
                <div class="btn-group-vertical w-100">
                    <a href="${result.data.url}" class="btn btn-primary mb-2" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Open QR Page
                    </a>
                    <button onclick="downloadQR('${result.data.image}')" class="btn btn-success mb-2">
                        <i class="fas fa-download"></i> Download Image
                    </button>
                    <button onclick="printQR('${result.data.id}')" class="btn btn-info">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            `;

            Swal.fire('Success!', 'QR code generated successfully', 'success');
        } else {
            Swal.fire('Error', result.message, 'error');
        }
    } catch (error) {
        Swal.fire('Error', 'Failed to generate QR code', 'error');
        console.error(error);
    }
});

function downloadQR(imageUrl) {
    const link = document.createElement('a');
    link.href = imageUrl;
    link.download = `qr-code-${Date.now()}.png`;
    link.click();
}

function printQR(qrId) {
    window.open(`/qr-management/print/preview?qr_ids=${qrId}`, '_blank');
}

async function generateBatch() {
    const { value: count } = await Swal.fire({
        title: 'Generate Batch QR Codes',
        input: 'number',
        inputLabel: 'Number of QR codes (1-10)',
        inputPlaceholder: '5',
        inputAttributes: {
            min: 1,
            max: 10,
            step: 1
        },
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value || value < 1 || value > 10) {
                return 'Please enter a number between 1 and 10';
            }
        }
    });

    if (count) {
        const formData = new FormData(document.getElementById('qrGenerationForm'));
        const data = Object.fromEntries(formData.entries());
        data.count = count;
        data.location_required = document.getElementById('location_required').checked;
        data.allow_family = document.getElementById('allow_family').checked;
        data.requires_verification = document.getElementById('requires_verification').checked;
        data.offline_allowed = document.getElementById('offline_allowed').checked;

        try {
            const response = await fetch('{{ route('qr-management.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                const qrIds = result.data.map(qr => qr.id).join(',');
                Swal.fire({
                    title: 'Batch Generated!',
                    text: `${count} QR codes generated successfully`,
                    icon: 'success',
                    confirmButtonText: 'View & Print'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.open(`/qr-management/print/preview?qr_ids=${qrIds}`, '_blank');
                    }
                });
            }
        } catch (error) {
            Swal.fire('Error', 'Failed to generate batch', 'error');
        }
    }
}
</script>
@endpush
@endsection
