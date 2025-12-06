@extends('layouts.app')

@section('title', 'Manage Registrations - ' . $program->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="{{ route('programs.index') }}" class="hover:text-blue-600">Programs</a>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
            <a href="{{ route('programs.show', $program) }}" class="hover:text-blue-600">{{ $program->name }}</a>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
            <span>Manage Registrations</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900">Manage Registrations</h1>
        <p class="text-gray-600 mt-1">{{ $program->name }}</p>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Registrations</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $program->registrations->count() }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Confirmed</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $program->registrations->where('status', 'confirmed')->count() }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Checked In</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $program->registrations->whereNotNull('checked_in_at')->count() }}</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Payment Received</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $program->registrations->where('payment_status', 'paid')->count() }}</p>
                </div>
                <div class="bg-yellow-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex flex-wrap gap-3">
            <button onclick="showBulkCheckIn()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Bulk Check-In
            </button>
            <button onclick="exportRegistrations('excel')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Export to Excel
            </button>
            <button onclick="exportRegistrations('pdf')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                Export to PDF
            </button>
            <button onclick="sendBulkEmail()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                Send Email to All
            </button>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex flex-wrap gap-4">
            <select id="filter-status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" onchange="filterRegistrations()">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="waitlist">Waitlist</option>
                <option value="cancelled">Cancelled</option>
                <option value="attended">Attended</option>
            </select>

            <select id="filter-payment" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" onchange="filterRegistrations()">
                <option value="">All Payment Status</option>
                <option value="unpaid">Unpaid</option>
                <option value="partial">Partial</option>
                <option value="paid">Paid</option>
                <option value="refunded">Refunded</option>
            </select>

            <input type="text" id="search-input" placeholder="Search by name, email, phone, badge..."
                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 flex-1"
                   oninput="searchRegistrations()">

            <button onclick="clearFilters()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                Clear Filters
            </button>
        </div>
    </div>

    {{-- Registrations Table --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="registrations-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="select-all" class="w-4 h-4 text-blue-600 border-gray-300 rounded" onchange="toggleSelectAll()">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Badge</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check-In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($program->registrations as $registration)
                    <tr class="registration-row hover:bg-gray-50"
                        data-status="{{ $registration->status }}"
                        data-payment="{{ $registration->payment_status }}"
                        data-search="{{ strtolower($registration->first_name . ' ' . $registration->last_name . ' ' . $registration->email . ' ' . $registration->phone . ' ' . $registration->badge_number) }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="registration-checkbox w-4 h-4 text-blue-600 border-gray-300 rounded" value="{{ $registration->id }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-mono text-gray-900">{{ $registration->badge_number }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-semibold">{{ substr($registration->first_name, 0, 1) }}{{ substr($registration->last_name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $registration->first_name }} {{ $registration->last_name }}</div>
                                    @if($registration->member_id)
                                    <div class="text-sm text-gray-500">Member</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $registration->email }}</div>
                            <div class="text-sm text-gray-500">{{ $registration->phone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $registration->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                   ($registration->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                   ($registration->status === 'attended' ? 'bg-blue-100 text-blue-800' :
                                   ($registration->status === 'waitlist' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800'))) }}">
                                {{ ucfirst($registration->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $registration->payment_status === 'paid' ? 'bg-green-100 text-green-800' :
                                   ($registration->payment_status === 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($registration->payment_status) }}
                            </span>
                            @if($program->registration_fee > 0)
                            <div class="text-xs text-gray-500 mt-1">GHS {{ number_format($registration->amount_paid, 2) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $registration->registered_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($registration->checked_in_at)
                                <div class="text-sm text-green-600 font-medium">
                                    <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $registration->checked_in_at->format('M d, g:i A') }}
                                </div>
                            @else
                                <button onclick="checkIn({{ $registration->id }})" class="px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition">
                                    Check In
                                </button>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <button onclick="viewRegistration({{ $registration->id }})" class="text-blue-600 hover:text-blue-900" title="View Details">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                <button onclick="sendEmail({{ $registration->id }})" class="text-purple-600 hover:text-purple-900" title="Send Email">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                    </svg>
                                </button>
                                <button onclick="deleteRegistration({{ $registration->id }})" class="text-red-600 hover:text-red-900" title="Delete">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p class="text-gray-500">No registrations yet</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- View Registration Modal (placeholder) --}}
<div id="view-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Registration Details</h3>
            <button onclick="closeModal('view-modal')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
        <div id="modal-content">
            <!-- Content loaded dynamically -->
        </div>
    </div>
</div>

<script>
// Check-in function
function checkIn(registrationId) {
    if (confirm('Check in this participant?')) {
        fetch(`/programs/registrations/${registrationId}/check-in`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

// Filter registrations
function filterRegistrations() {
    const status = document.getElementById('filter-status').value;
    const payment = document.getElementById('filter-payment').value;

    document.querySelectorAll('.registration-row').forEach(row => {
        let show = true;

        if (status && row.dataset.status !== status) show = false;
        if (payment && row.dataset.payment !== payment) show = false;

        row.style.display = show ? '' : 'none';
    });
}

// Search registrations
function searchRegistrations() {
    const searchTerm = document.getElementById('search-input').value.toLowerCase();

    document.querySelectorAll('.registration-row').forEach(row => {
        const searchData = row.dataset.search;
        row.style.display = searchData.includes(searchTerm) ? '' : 'none';
    });
}

// Clear filters
function clearFilters() {
    document.getElementById('filter-status').value = '';
    document.getElementById('filter-payment').value = '';
    document.getElementById('search-input').value = '';
    document.querySelectorAll('.registration-row').forEach(row => {
        row.style.display = '';
    });
}

// Select all checkboxes
function toggleSelectAll() {
    const checked = document.getElementById('select-all').checked;
    document.querySelectorAll('.registration-checkbox').forEach(checkbox => {
        checkbox.checked = checked;
    });
}

// Placeholder functions
function showBulkCheckIn() { alert('Bulk check-in feature coming soon'); }
function exportRegistrations(format) { alert(`Export to ${format} feature coming soon`); }
function sendBulkEmail() { alert('Bulk email feature coming soon'); }
function viewRegistration(id) { alert('View details feature coming soon'); }
function sendEmail(id) { alert('Send email feature coming soon'); }
function deleteRegistration(id) {
    if (confirm('Are you sure you want to delete this registration?')) {
        alert('Delete feature coming soon');
    }
}
function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}
</script>
@endsection
