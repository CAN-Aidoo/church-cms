@extends('layouts.admin')

@section('title', 'QR Code Settings')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">QR Code Settings</h1>
            <p class="text-muted mb-0">Configure global QR code system settings</p>
        </div>
        <a href="{{ route('qr-management.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form id="settingsForm">
                @csrf

                <!-- General Settings -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">General Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="default_location_radius">Default Location Radius (meters)</label>
                            <input type="number" class="form-control" id="default_location_radius"
                                   name="default_location_radius"
                                   value="{{ $settings['default_location_radius'] ?? 100 }}"
                                   min="10" max="1000">
                            <small class="form-text text-muted">
                                Default GPS verification radius for new QR codes
                            </small>
                        </div>

                        <div class="form-group">
                            <label>Church Coordinates</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="church_latitude"
                                           name="church_latitude" step="0.0000001"
                                           value="{{ $settings['church_coordinates']['lat'] ?? 5.6037 }}"
                                           placeholder="Latitude">
                                </div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="church_longitude"
                                           name="church_longitude" step="0.0000001"
                                           value="{{ $settings['church_coordinates']['lng'] ?? -0.1870 }}"
                                           placeholder="Longitude">
                                </div>
                            </div>
                            <small class="form-text text-muted">
                                Central location for GPS verification
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="default_expiration_hours">Default Expiration (hours)</label>
                            <input type="number" class="form-control" id="default_expiration_hours"
                                   name="default_expiration_hours"
                                   value="{{ $settings['default_expiration_hours'] ?? 24 }}"
                                   min="1" max="168">
                            <small class="form-text text-muted">
                                Default validity period for new QR codes (1-168 hours)
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-danger">Security Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="generation_rate_limit">Generation Rate Limit (per hour)</label>
                            <input type="number" class="form-control" id="generation_rate_limit"
                                   name="generation_rate_limit"
                                   value="{{ $settings['generation_rate_limit'] ?? 100 }}"
                                   min="1" max="1000">
                            <small class="form-text text-muted">
                                Maximum QR codes that can be generated per user per hour
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="scan_rate_limit">Scan Rate Limit (per minute)</label>
                            <input type="number" class="form-control" id="scan_rate_limit"
                                   name="scan_rate_limit"
                                   value="{{ $settings['scan_rate_limit'] ?? 50 }}"
                                   min="1" max="100">
                            <small class="form-text text-muted">
                                Maximum scans allowed per device per minute
                            </small>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="require_gps_verification"
                                   name="require_gps_verification"
                                   {{ ($settings['require_gps_verification'] ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="require_gps_verification">
                                Require GPS verification by default
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="enable_anomaly_detection"
                                   name="enable_anomaly_detection"
                                   {{ ($settings['enable_anomaly_detection'] ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="enable_anomaly_detection">
                                Enable anomaly detection for suspicious scans
                            </label>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Security Keys:</strong> Encryption and signing keys are managed automatically.
                            Contact system administrator to rotate keys.
                        </div>
                    </div>
                </div>

                <!-- Feature Settings -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Feature Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="allow_offline_scanning"
                                   name="allow_offline_scanning"
                                   {{ ($settings['allow_offline_scanning'] ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="allow_offline_scanning">
                                Allow offline scanning by default
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="enable_family_checkin"
                                   name="enable_family_checkin"
                                   {{ ($settings['enable_family_checkin'] ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="enable_family_checkin">
                                Enable family check-in feature
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="auto_cleanup_expired"
                                   name="auto_cleanup_expired"
                                   {{ ($settings['auto_cleanup_expired'] ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="auto_cleanup_expired">
                                Automatically cleanup expired QR codes
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="cleanup_days">Cleanup After (days)</label>
                            <input type="number" class="form-control" id="cleanup_days"
                                   name="cleanup_days"
                                   value="{{ $settings['cleanup_days'] ?? 30 }}"
                                   min="1" max="365">
                            <small class="form-text text-muted">
                                Delete expired QR codes after this many days
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Analytics Settings -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">Analytics Settings</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="enable_analytics"
                                   name="enable_analytics"
                                   {{ ($settings['enable_analytics'] ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="enable_analytics">
                                Enable analytics collection
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="track_device_info"
                                   name="track_device_info"
                                   {{ ($settings['track_device_info'] ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="track_device_info">
                                Track device information
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="track_location_data"
                                   name="track_location_data"
                                   {{ ($settings['track_location_data'] ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="track_location_data">
                                Track location data for analytics
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="analytics_retention_days">Analytics Retention (days)</label>
                            <input type="number" class="form-control" id="analytics_retention_days"
                                   name="analytics_retention_days"
                                   value="{{ $settings['analytics_retention_days'] ?? 90 }}"
                                   min="7" max="730">
                            <small class="form-text text-muted">
                                How long to retain detailed analytics data
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-secondary" onclick="resetToDefaults()">
                                <i class="fas fa-undo"></i> Reset to Defaults
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Settings
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Help & Info -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Settings Help</h6>
                </div>
                <div class="card-body">
                    <h6>Location Settings</h6>
                    <p class="text-muted small">
                        GPS verification ensures users are physically present at the church location.
                        Adjust the radius to accommodate your church's premises.
                    </p>

                    <h6>Security Settings</h6>
                    <p class="text-muted small">
                        Rate limits prevent abuse and protect against automated attacks.
                        Higher limits may be needed for large events.
                    </p>

                    <h6>Offline Scanning</h6>
                    <p class="text-muted small">
                        When enabled, users can scan QR codes without internet connectivity.
                        Scans will be synced when connection is restored.
                    </p>

                    <h6>Analytics</h6>
                    <p class="text-muted small">
                        Analytics help you understand attendance patterns and optimize service times.
                        All data is stored securely and anonymized after the retention period.
                    </p>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">System Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th>Active QR Codes:</th>
                            <td class="text-right">{{ $stats['active_qr_codes'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <th>Total Scans Today:</th>
                            <td class="text-right">{{ $stats['total_scans_today'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <th>Success Rate:</th>
                            <td class="text-right">{{ number_format($stats['success_rate_today'] ?? 0, 1) }}%</td>
                        </tr>
                        <tr>
                            <th>Encryption:</th>
                            <td class="text-right">
                                <span class="badge badge-success">AES-256-GCM</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Signature:</th>
                            <td class="text-right">
                                <span class="badge badge-success">HMAC-SHA256</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('settingsForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const settings = [];

    // Convert form data to settings array
    settings.push({
        key: 'default_location_radius',
        value: parseInt(formData.get('default_location_radius'))
    });

    settings.push({
        key: 'church_coordinates',
        value: {
            lat: parseFloat(formData.get('church_latitude')),
            lng: parseFloat(formData.get('church_longitude'))
        }
    });

    settings.push({
        key: 'default_expiration_hours',
        value: parseInt(formData.get('default_expiration_hours'))
    });

    settings.push({
        key: 'generation_rate_limit',
        value: parseInt(formData.get('generation_rate_limit'))
    });

    settings.push({
        key: 'scan_rate_limit',
        value: parseInt(formData.get('scan_rate_limit'))
    });

    // Boolean settings
    const booleanSettings = [
        'require_gps_verification',
        'enable_anomaly_detection',
        'allow_offline_scanning',
        'enable_family_checkin',
        'auto_cleanup_expired',
        'enable_analytics',
        'track_device_info',
        'track_location_data'
    ];

    booleanSettings.forEach(key => {
        settings.push({
            key: key,
            value: document.getElementById(key).checked
        });
    });

    settings.push({
        key: 'cleanup_days',
        value: parseInt(formData.get('cleanup_days'))
    });

    settings.push({
        key: 'analytics_retention_days',
        value: parseInt(formData.get('analytics_retention_days'))
    });

    try {
        const response = await fetch('/api/v1/qr-management/settings/update', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify({ settings: settings })
        });

        const result = await response.json();

        if (result.success) {
            Swal.fire('Success!', 'Settings updated successfully', 'success');
        } else {
            Swal.fire('Error', result.message, 'error');
        }
    } catch (error) {
        Swal.fire('Error', 'Failed to update settings', 'error');
        console.error(error);
    }
});

async function resetToDefaults() {
    const result = await Swal.fire({
        title: 'Reset to Defaults?',
        text: 'This will reset all settings to their default values.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, reset'
    });

    if (result.isConfirmed) {
        document.getElementById('default_location_radius').value = 100;
        document.getElementById('church_latitude').value = 5.6037;
        document.getElementById('church_longitude').value = -0.1870;
        document.getElementById('default_expiration_hours').value = 24;
        document.getElementById('generation_rate_limit').value = 100;
        document.getElementById('scan_rate_limit').value = 50;
        document.getElementById('cleanup_days').value = 30;
        document.getElementById('analytics_retention_days').value = 90;

        // Check all checkboxes
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = true;
        });

        Swal.fire('Reset!', 'Settings have been reset to defaults. Click Save to apply.', 'success');
    }
}
</script>
@endpush
@endsection
