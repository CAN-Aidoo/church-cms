@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-indigo-800 bg-clip-text text-transparent">My Personal QR Code</h1>
                <p class="text-gray-600 mt-2">Use this QR code for quick check-in at church services</p>
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
                <!-- Member Info -->
                <div class="flex items-center mb-6 pb-6 border-b">
                    @if($member->profile_photo_url)
                        <img src="{{ $member->profile_photo_url }}" alt="{{ $member->first_name }}" class="w-20 h-20 rounded-full object-cover mr-4">
                    @else
                        <div class="w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center mr-4">
                            <span class="text-2xl font-bold text-indigo-600">{{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}</span>
                        </div>
                    @endif
                    <div>
                        <h2 class="text-2xl font-bold">{{ $member->first_name }} {{ $member->last_name }}</h2>
                        <p class="text-gray-600">Member ID: {{ $member->member_id }}</p>
                        <p class="text-sm text-gray-500">{{ $member->email }}</p>
                    </div>
                </div>

                <!-- QR Code Image -->
                <div class="flex justify-center mb-6">
                    <div class="bg-white p-8 rounded-lg border-4 border-indigo-500">
                        <img src="{{ $qrImageUrl }}" alt="Personal QR Code" class="w-80 h-80">
                    </div>
                </div>

                <!-- Usage Instructions -->
                <div class="bg-indigo-50 rounded-lg p-6 mb-6">
                    <h3 class="font-semibold text-indigo-900 mb-3">How to Use Your QR Code:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-indigo-800">
                        <li>Save this QR code to your phone (screenshot or download)</li>
                        <li>At church, show this code to the check-in station</li>
                        <li>Staff will scan your code to mark you present</li>
                        <li>You can also scan the service QR code with this saved on your device</li>
                    </ol>
                </div>

                <!-- Security Notice -->
                <div class="bg-yellow-50 rounded-lg p-6 mb-6 border-l-4 border-yellow-400">
                    <div class="flex">
                        <svg class="w-6 h-6 text-yellow-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-yellow-900 mb-1">Security Notice</h4>
                            <p class="text-sm text-yellow-800">This QR code is unique to you. Do not share it with others. It expires in 24 hours and refreshes automatically.</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-3 gap-4">
                    <button onclick="printQrCode()" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print
                    </button>
                    <button onclick="downloadQrCode()" class="btn btn-success">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download
                    </button>
                    <button onclick="shareQrCode()" class="btn btn-indigo">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                        </svg>
                        Share
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Code Details -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Code Details</h3>
                <div class="space-y-3 text-sm">
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
                <button onclick="refreshCode()" class="btn btn-sm btn-primary w-full mt-4">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh Code
                </button>
            </div>

            <!-- Attendance Summary -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">My Attendance</h3>
                @php
                    $thisMonth = \App\Models\Attendance::where('member_id', $member->id)
                        ->whereBetween('service_date', [now()->startOfMonth(), now()->endOfMonth()])
                        ->count();
                    $thisYear = \App\Models\Attendance::where('member_id', $member->id)
                        ->whereBetween('service_date', [now()->startOfYear(), now()->endOfYear()])
                        ->count();
                    $lastCheckIn = \App\Models\Attendance::where('member_id', $member->id)
                        ->latest('service_date')
                        ->first();
                @endphp
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-600 text-sm">This Month</p>
                        <p class="text-2xl font-bold text-indigo-600">{{ $thisMonth }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">This Year</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $thisYear }}</p>
                    </div>
                    @if($lastCheckIn)
                    <div>
                        <p class="text-gray-600 text-sm">Last Check-in</p>
                        <p class="font-semibold text-sm">{{ $lastCheckIn->service_date->format('M j, Y') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Tips -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Quick Tips</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Save as phone wallpaper for quick access
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Code refreshes daily for security
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Works offline once saved
                    </li>
                </ul>
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
    link.download = 'my-qr-code-{{ $member->member_id }}.png';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function shareQrCode() {
    if (navigator.share) {
        navigator.share({
            title: 'My Church QR Code',
            text: 'My personal church check-in QR code',
            url: '{{ $qrImageUrl }}'
        });
    } else {
        alert('Share feature not supported on this browser');
    }
}

function refreshCode() {
    window.location.reload();
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
