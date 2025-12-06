@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent">Payment QR Code</h1>
                <p class="text-gray-600 mt-2">Members can scan this code to make payments</p>
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
                    <h2 class="text-2xl font-bold mb-2">{{ ucfirst($category) }}</h2>
                    @if($amount)
                        <p class="text-3xl font-bold text-purple-600">GHS {{ number_format($amount, 2) }}</p>
                    @else
                        <p class="text-gray-600">Enter custom amount</p>
                    @endif
                </div>

                <!-- QR Code Image -->
                <div class="flex justify-center mb-6">
                    <div class="bg-white p-8 rounded-lg border-4 border-purple-500">
                        <img src="{{ $qrImageUrl }}" alt="Payment QR Code" class="w-96 h-96">
                    </div>
                </div>

                <!-- Payment Instructions -->
                <div class="bg-purple-50 rounded-lg p-6 mb-6">
                    <h3 class="font-semibold text-purple-900 mb-3">How to Pay:</h3>
                    <ol class="list-decimal list-inside space-y-2 text-purple-800">
                        <li>Scan this QR code with your mobile banking app or camera</li>
                        <li>Verify the payment details (category and amount)</li>
                        @if(!$amount)
                        <li>Enter your desired payment amount</li>
                        @endif
                        <li>Confirm and complete the payment</li>
                        <li>Your transaction will be recorded automatically</li>
                    </ol>
                </div>

                <!-- Supported Payment Methods -->
                <div class="bg-blue-50 rounded-lg p-6 mb-6">
                    <h3 class="font-semibold text-blue-900 mb-3">Supported Payment Methods:</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex items-center bg-white p-3 rounded">
                            <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold">MTN Mobile Money</span>
                        </div>
                        <div class="flex items-center bg-white p-3 rounded">
                            <svg class="w-6 h-6 mr-2 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold">AirtelTigo Money</span>
                        </div>
                        <div class="flex items-center bg-white p-3 rounded">
                            <svg class="w-6 h-6 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold">Vodafone Cash</span>
                        </div>
                        <div class="flex items-center bg-white p-3 rounded">
                            <svg class="w-6 h-6 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold">Bank Transfer</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-2 gap-4">
                    <button onclick="printQrCode()" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print QR Code
                    </button>
                    <button onclick="downloadQrCode()" class="btn btn-purple">
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
                <form action="{{ route('qr-codes.payment') }}" method="GET">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Amount (Optional)</label>
                        <input type="number" name="amount" step="0.01" min="0" value="{{ $amount ?? '' }}" class="form-input w-full" placeholder="Leave blank for any amount">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                        <select name="category" class="form-select w-full">
                            <option value="offering" {{ $category == 'offering' ? 'selected' : '' }}>Offering</option>
                            <option value="tithe" {{ $category == 'tithe' ? 'selected' : '' }}>Tithe</option>
                            <option value="donation" {{ $category == 'donation' ? 'selected' : '' }}>Donation</option>
                            <option value="pledge" {{ $category == 'pledge' ? 'selected' : '' }}>Pledge Payment</option>
                            <option value="building_fund" {{ $category == 'building_fund' ? 'selected' : '' }}>Building Fund</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <input type="text" name="description" class="form-input w-full" placeholder="e.g., Sunday Offering">
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

            <!-- Today's Collections -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Today's Collections</h3>
                @php
                    $todayTransactions = \App\Models\Transaction::whereDate('transaction_date', today())
                        ->where('transaction_type', 'income')
                        ->where('status', 'completed')
                        ->sum('amount');
                    $todayCount = \App\Models\Transaction::whereDate('transaction_date', today())
                        ->where('transaction_type', 'income')
                        ->count();
                @endphp
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-600 text-sm">Total Amount</p>
                        <p class="text-2xl font-bold text-green-600">GHS {{ number_format($todayTransactions, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Transactions</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $todayCount }}</p>
                    </div>
                </div>
                <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-primary w-full mt-4">View All</a>
            </div>

            <!-- Security Note -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Security
                </h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        All payments are encrypted
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        QR codes expire in 30 minutes
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Transactions are audited
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
    link.download = 'payment-qr-code-{{ $category }}.png';
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
