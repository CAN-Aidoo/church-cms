@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">QR Code Management</h1>
        <p class="text-gray-600 mt-2">Generate and manage QR codes for various church activities</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Check-ins Today</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['total_checkins_today'] }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Active Service Codes</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['active_service_codes'] }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Registrations Today</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['registrations_today'] }}</p>
                </div>
                <div class="bg-yellow-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Code Categories -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Service Check-in -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold">Service Check-in</h3>
            </div>
            <p class="text-gray-600 mb-4">Generate QR code for service attendance tracking</p>
            <a href="{{ route('qr-codes.service') }}" class="btn btn-primary w-full">Generate Code</a>
        </div>

        <!-- Member Registration -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-green-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold">Member Registration</h3>
            </div>
            <p class="text-gray-600 mb-4">QR code for new member self-registration</p>
            <a href="{{ route('qr-codes.member-registration') }}" class="btn btn-success w-full">Generate Code</a>
        </div>

        <!-- Visitor Registration -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-yellow-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold">Visitor Registration</h3>
            </div>
            <p class="text-gray-600 mb-4">QR code for first-time visitor registration</p>
            <a href="{{ route('qr-codes.visitor-registration') }}" class="btn btn-warning w-full">Generate Code</a>
        </div>

        <!-- Payment -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-purple-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold">Payment</h3>
            </div>
            <p class="text-gray-600 mb-4">Generate payment QR code for offerings</p>
            <button onclick="showPaymentModal()" class="btn btn-purple w-full">Generate Code</button>
        </div>

        <!-- Personal QR Code -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-indigo-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold">My QR Code</h3>
            </div>
            <p class="text-gray-600 mb-4">Your personal check-in QR code</p>
            <a href="{{ route('qr-codes.personal') }}" class="btn btn-indigo w-full">View My Code</a>
        </div>

        <!-- Equipment -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-red-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold">Equipment Tracking</h3>
            </div>
            <p class="text-gray-600 mb-4">Generate QR codes for equipment</p>
            <a href="{{ route('equipment.index') }}" class="btn btn-danger w-full">View Equipment</a>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Generate Payment QR Code</h3>
            <form action="{{ route('qr-codes.payment') }}" method="GET">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Amount (Optional)</label>
                    <input type="number" name="amount" step="0.01" min="0" class="form-input w-full" placeholder="Leave blank for any amount">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                    <select name="category" class="form-select w-full">
                        <option value="offering">Offering</option>
                        <option value="tithe">Tithe</option>
                        <option value="donation">Donation</option>
                        <option value="pledge">Pledge Payment</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <input type="text" name="description" class="form-input w-full" placeholder="e.g., Sunday Offering">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="hidePaymentModal()" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showPaymentModal() {
    document.getElementById('paymentModal').classList.remove('hidden');
}

function hidePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
}
</script>
@endsection
