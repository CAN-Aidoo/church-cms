@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent">Member Self-Registration QR Code</h1>
                <p class="text-gray-600 mt-2">New members can scan this code to register themselves</p>
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
                    <h2 class="text-2xl font-bold mb-2">New Member Registration</h2>
                    <p class="text-gray-600">Scan to join our church family</p>
                </div>

                <!-- QR Code Image -->
                <div class="flex justify-center mb-6">
                    <div class="bg-white p-8 rounded-lg border-4 border-green-500">
                        <img src="{{ $qrImageUrl }}" alt="Member Registration QR Code" class="w-96 h-96">
                    </div>
                </div>

                <!-- Instructions -->
                <div class="bg-green-50 rounded-lg p-6 mb-6">
                    <h3 class="font-semibold text-green-900 mb-3">Registration Steps:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-green-800">
                        <li>Scan the QR code with your smartphone camera</li>
                        <li>Fill in your personal information</li>
                        <li>Upload a profile photo (optional)</li>
                        <li>Submit your registration</li>
                        <li>Wait for admin approval (usually within 24 hours)</li>
                        <li>Receive login credentials via email/SMS</li>
                    </ol>
                </div>

                <!-- Information Needed -->
                <div class="bg-blue-50 rounded-lg p-6 mb-6">
                    <h3 class="font-semibold text-blue-900 mb-3">Information Required:</h3>
                    <ul class="grid grid-cols-2 gap-2 text-blue-800 text-sm">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Full Name
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Date of Birth
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Phone Number
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Email Address
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Home Address
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Marital Status
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
                        <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded mt-1">Permanent</span>
                    </div>
                </div>
            </div>

            <!-- Usage Stats -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Registration Stats</h3>
                @php
                    $pendingMembers = \App\Models\Member::where('status', 'pending')->count();
                    $recentRegistrations = \App\Models\Member::where('created_at', '>=', now()->subDays(7))->count();
                @endphp
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-600 text-sm">Pending Approvals</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $pendingMembers }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Last 7 Days</p>
                        <p class="text-2xl font-bold text-green-600">{{ $recentRegistrations }}</p>
                    </div>
                </div>
                <a href="{{ route('members.index', ['status' => 'pending']) }}" class="btn btn-sm btn-primary w-full mt-4">View Pending</a>
            </div>

            <!-- Tips -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Display Tips</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Display at church entrance
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Add to bulletin/newsletter
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Share on social media
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Include in welcome packets
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
    link.download = 'member-registration-qr-code.png';
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
