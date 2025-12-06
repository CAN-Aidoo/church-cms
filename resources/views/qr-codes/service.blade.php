@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Service Check-in QR Code</h1>
                <p class="text-gray-600 mt-2">Display this QR code for members to check in to service</p>
            </div>
            <a href="{{ route('qr-codes.index') }}" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- QR Code Display -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold mb-2">{{ ucfirst(str_replace('_', ' ', $serviceType)) }}</h2>
                    <p class="text-gray-600">{{ \Carbon\Carbon::parse($serviceDate)->format('l, F j, Y') }}</p>
                </div>

                <!-- QR Code Image -->
                <div class="flex justify-center mb-6">
                    <div class="bg-white p-8 rounded-lg border-4 border-blue-500">
                        <img src="{{ $qrImageUrl }}" alt="Service Check-in QR Code" class="w-96 h-96">
                    </div>
                </div>

                <!-- Instructions -->
                <div class="bg-blue-50 rounded-lg p-6 mb-6">
                    <h3 class="font-semibold text-blue-900 mb-3">How to Check In:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-blue-800">
                        <li>Open your camera app or QR code scanner</li>
                        <li>Point your camera at the QR code above</li>
                        <li>Tap the notification to open the check-in page</li>
                        <li>Select your name and confirm check-in</li>
                    </ol>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-2 gap-4">
                    <button onclick="printQrCode()" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print QR Code
                    </button>
                    <button onclick="downloadQrCode()" class="btn btn-success">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Image
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Generate New Code -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Generate New Code</h3>
                <form action="{{ route('qr-codes.service') }}" method="GET">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Service Date</label>
                        <input type="date" name="service_date" value="{{ $serviceDate }}" class="form-input w-full">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Service Type</label>
                        <select name="service_type" class="form-select w-full">
                            <option value="sunday_first" {{ $serviceType == 'sunday_first' ? 'selected' : '' }}>Sunday First Service</option>
                            <option value="sunday_second" {{ $serviceType == 'sunday_second' ? 'selected' : '' }}>Sunday Second Service</option>
                            <option value="midweek" {{ $serviceType == 'midweek' ? 'selected' : '' }}>Midweek Service</option>
                            <option value="prayer_meeting" {{ $serviceType == 'prayer_meeting' ? 'selected' : '' }}>Prayer Meeting</option>
                            <option value="special" {{ $serviceType == 'special' ? 'selected' : '' }}>Special Service</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-full">Generate</button>
                </form>
            </div>

            <!-- Code Details -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Code Details</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-600">Token:</span>
                        <p class="font-mono text-xs break-all bg-gray-100 p-2 rounded mt-1">{{ $qrData['token'] }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600">Expires:</span>
                        <p class="font-semibold mt-1">{{ \Carbon\Carbon::parse($qrData['expires_at'])->format('M j, Y g:i A') }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($qrData['expires_at'])->diffForHumans() }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600">Status:</span>
                        @if(\Carbon\Carbon::now()->lt($qrData['expires_at']))
                            <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded mt-1">Active</span>
                        @else
                            <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded mt-1">Expired</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Today's Check-ins</h3>
                @php
                    $todayCheckins = \App\Models\Attendance::whereDate('service_date', today())
                        ->where('check_in_method', 'qr_code')
                        ->count();
                @endphp
                <div class="text-center">
                    <p class="text-4xl font-bold text-blue-600">{{ $todayCheckins }}</p>
                    <p class="text-gray-600 text-sm mt-1">via QR Code</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function printQrCode() {
    window.print();
}

function downloadQrCode() {
    const link = document.createElement('a');
    link.href = '{{ $qrImageUrl }}';
    link.download = 'service-qr-code-{{ $serviceDate }}.png';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .bg-white.rounded-lg.shadow-md.p-8, .bg-white.rounded-lg.shadow-md.p-8 * {
        visibility: visible;
    }
    .bg-white.rounded-lg.shadow-md.p-8 {
        position: absolute;
        left: 0;
        top: 0;
    }
}
</style>
@endsection
