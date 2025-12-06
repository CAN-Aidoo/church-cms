@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-yellow-600 to-yellow-800 bg-clip-text text-transparent">Visitor Registration QR Code</h1>
                <p class="text-gray-600 mt-2">First-time visitors can scan this code to register</p>
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
                    <h2 class="text-2xl font-bold mb-2">Welcome to Our Church!</h2>
                    <p class="text-gray-600">We're glad you're here. Please register as a visitor</p>
                </div>

                <!-- QR Code Image -->
                <div class="flex justify-center mb-6">
                    <div class="bg-white p-8 rounded-lg border-4 border-yellow-500">
                        <img src="{{ $qrImageUrl }}" alt="Visitor Registration QR Code" class="w-96 h-96">
                    </div>
                </div>

                <!-- Instructions -->
                <div class="bg-yellow-50 rounded-lg p-6 mb-6">
                    <h3 class="font-semibold text-yellow-900 mb-3">Registration Steps:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-yellow-800">
                        <li>Scan this QR code with your smartphone</li>
                        <li>Fill in your basic contact information</li>
                        <li>Let us know how you heard about us</li>
                        <li>Submit your registration</li>
                        <li>Enjoy the service!</li>
                    </ol>
                </div>

                <!-- What to Expect -->
                <div class="bg-blue-50 rounded-lg p-6 mb-6">
                    <h3 class="font-semibold text-blue-900 mb-3">What Happens Next:</h3>
                    <ul class="space-y-2 text-blue-800">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            We'll send you a welcome message
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            A follow-up team member may contact you
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            After 5 visits, you can become a member
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Your information is kept confidential
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-2 gap-4">
                    <button onclick="printQrCode()" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print QR Code
                    </button>
                    <button onclick="downloadQrCode()" class="btn btn-warning">
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
            <!-- Code Details -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Code Details</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-600">Registration URL:</span>
                        <p class="font-mono text-xs break-all bg-gray-100 p-2 rounded mt-1">{{ $qrData['url'] }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600">Token:</span>
                        <p class="font-mono text-xs break-all bg-gray-100 p-2 rounded mt-1">{{ $qrData['token'] }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600">Status:</span>
                        <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded mt-1">Active</span>
                    </div>
                </div>
            </div>

            <!-- Visitor Stats -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Visitor Statistics</h3>
                @php
                    $todayVisitors = \App\Models\Visitor::whereDate('first_visit_date', today())->count();
                    $thisWeekVisitors = \App\Models\Visitor::whereBetween('first_visit_date', [now()->startOfWeek(), now()->endOfWeek()])->count();
                    $eligibleForMembership = \App\Models\Visitor::where('visit_count', '>=', 5)
                        ->whereNull('converted_member_id')
                        ->count();
                @endphp
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-600 text-sm">Today's Visitors</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $todayVisitors }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">This Week</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $thisWeekVisitors }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Eligible for Membership</p>
                        <p class="text-2xl font-bold text-green-600">{{ $eligibleForMembership }}</p>
                    </div>
                </div>
                <a href="{{ route('visitors.index') }}" class="btn btn-sm btn-primary w-full mt-4">View All Visitors</a>
            </div>

            <!-- Display Tips -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Display Locations</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                        </svg>
                        Welcome desk/lobby
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                        </svg>
                        Information booth
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                        </svg>
                        Parking lot signs
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                        </svg>
                        Church website
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
    link.download = 'visitor-registration-qr-code.png';
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
