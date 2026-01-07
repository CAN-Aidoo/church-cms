@extends('layouts.app')

@section('title', 'Manage Registrations - ' . $program->name)

@section('content')
<!-- Header -->
<div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6 mb-8">
    <div>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-2">
            <a href="{{ route('programs.index') }}" class="hover:text-primary-600 transition-colors">Programs</a>
            <span>/</span>
            <a href="{{ route('programs.show', $program) }}" class="hover:text-primary-600 transition-colors">{{ $program->name }}</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Registrations</span>
        </nav>
        <h1 class="text-3xl font-heading font-bold text-slate-900">Manage Registrations</h1>
    </div>
    
    <div class="flex flex-wrap gap-3">
        <button onclick="showBulkCheckIn()" class="btn btn-outline-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Bulk Check-In
        </button>
        <div class="relative group">
            <button class="btn btn-outline-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-slate-100 hidden group-hover:block z-20">
                <a href="#" onclick="exportRegistrations('excel')" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary-600 transition-colors first:rounded-t-lg">Export to Excel</a>
                <a href="#" onclick="exportRegistrations('pdf')" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary-600 transition-colors last:rounded-b-lg">Export to PDF</a>
            </div>
        </div>
        <button onclick="sendBulkEmail()" class="btn btn-primary shadow-lg shadow-primary-500/20">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            Send Email to All
        </button>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border border-slate-100 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total Registrations</p>
            <p class="text-3xl font-bold text-slate-900">{{ $program->registrations->count() }}</p>
        </div>
        <div class="w-12 h-12 bg-primary-50 text-primary-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
    </div>

    <div class="card p-6 border border-slate-100 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Confirmed</p>
            <p class="text-3xl font-bold text-slate-900">{{ $program->registrations->where('status', 'confirmed')->count() }}</p>
        </div>
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <div class="card p-6 border border-slate-100 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Checked In</p>
            <p class="text-3xl font-bold text-slate-900">{{ $program->registrations->whereNotNull('checked_in_at')->count() }}</p>
        </div>
        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
        </div>
    </div>

    <div class="card p-6 border border-slate-100 shadow-sm flex items-center justify-between">
         <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Revenue</p>
            <p class="text-3xl font-bold text-slate-900">
                @if($program->registration_fee > 0)
                    {{ $program->registrations->where('payment_status', 'paid')->count() * $program->registration_fee }}
                @else
                    --
                @endif
            </p>
        </div>
        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>
</div>

<!-- Filters & Search -->
<div class="card border border-slate-100 shadow-sm p-4 mb-6">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" id="search-input" oninput="searchRegistrations()"
                    class="form-input pl-10 w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                    placeholder="Search by name, email, badge...">
        </div>
        
        <div class="flex gap-4">
            <select id="filter-status" onchange="filterRegistrations()" class="form-select border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="waitlist">Waitlist</option>
                <option value="cancelled">Cancelled</option>
                <option value="attended">Attended</option>
            </select>

            <select id="filter-payment" onchange="filterRegistrations()" class="form-select border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                <option value="">All Payment</option>
                <option value="unpaid">Unpaid</option>
                <option value="partial">Partial</option>
                <option value="paid">Paid</option>
                <option value="refunded">Refunded</option>
            </select>
            
            <button onclick="clearFilters()" class="btn btn-outline-secondary px-3" title="Clear Filters">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>
</div>

<!-- Registrations Table -->
<div class="card border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase text-slate-500 font-semibold tracking-wider">
                    <th class="px-6 py-4 w-10">
                        <input type="checkbox" id="select-all" class="form-checkbox w-4 h-4 text-primary-600 border-slate-300 rounded focus:ring-primary-500" onchange="toggleSelectAll()">
                    </th>
                    <th class="px-6 py-4">Badge</th>
                    <th class="px-6 py-4">Participant</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Payment</th>
                    <th class="px-6 py-4">Check-In</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($program->registrations as $registration)
                <tr class="registration-row hover:bg-slate-50/50 transition-colors"
                    data-status="{{ $registration->status }}"
                    data-payment="{{ $registration->payment_status }}"
                    data-search="{{ strtolower($registration->first_name . ' ' . $registration->last_name . ' ' . $registration->email . ' ' . $registration->badge_number) }}">
                    <td class="px-6 py-4">
                        <input type="checkbox" class="registration-checkbox form-checkbox w-4 h-4 text-primary-600 border-slate-300 rounded focus:ring-primary-500" value="{{ $registration->id }}">
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-mono text-sm text-slate-600 bg-slate-100 px-2 py-1 rounded">{{ $registration->badge_number }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center font-bold text-sm">
                                {{ substr($registration->first_name, 0, 1) }}{{ substr($registration->last_name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-slate-900">{{ $registration->first_name }} {{ $registration->last_name }}</div>
                                <div class="text-xs text-slate-500">{{ $registration->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                         <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                            {{ $registration->status === 'confirmed' ? 'bg-emerald-100 text-emerald-800' :
                               ($registration->status === 'pending' ? 'bg-amber-100 text-amber-800' :
                               ($registration->status === 'attended' ? 'bg-blue-100 text-blue-800' :
                               'bg-slate-100 text-slate-800')) }}">
                            {{ ucfirst($registration->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                            {{ $registration->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' :
                               ($registration->payment_status === 'partial' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                            {{ ucfirst($registration->payment_status) }}
                        </span>
                         @if($program->registration_fee > 0)
                            <div class="text-xs text-slate-500 mt-1">GHS {{ number_format($registration->amount_paid, 2) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($registration->checked_in_at)
                            <div class="inline-flex items-center text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded border border-emerald-100">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ $registration->checked_in_at->format('M d, g:i A') }}
                            </div>
                        @else
                            <button onclick="checkIn({{ $registration->id }})" class="btn btn-sm btn-outline-success">
                                Check In
                            </button>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                             <button onclick="viewRegistration({{ $registration->id }})" class="p-1 text-slate-400 hover:text-primary-600 transition-colors" title="View Details">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                            <button onclick="sendEmail({{ $registration->id }})" class="p-1 text-slate-400 hover:text-indigo-600 transition-colors" title="Send Email">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </button>
                            <button onclick="deleteRegistration({{ $registration->id }})" class="p-1 text-slate-400 hover:text-red-600 transition-colors" title="Delete">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <p class="font-medium text-slate-900">No registrations found</p>
                            <p class="text-sm mt-1">Share the registration link to get started</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Placeholder Modal (To be implemented with dedicated view/component logic) -->
<div id="modal-backdrop" class="fixed inset-0 bg-slate-900/50 z-40 hidden transition-opacity opacity-0"></div>
<div id="modal-container" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all scale-95 opacity-0" id="modal-content">
            <!-- Content -->
        </div>
    </div>
</div>

<script>
// Same JS logic as before, just kept for functionality
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

function searchRegistrations() {
    const searchTerm = document.getElementById('search-input').value.toLowerCase();
    document.querySelectorAll('.registration-row').forEach(row => {
        const searchData = row.dataset.search;
        row.style.display = searchData.includes(searchTerm) ? '' : 'none';
    });
}

function clearFilters() {
    document.getElementById('filter-status').value = '';
    document.getElementById('filter-payment').value = '';
    document.getElementById('search-input').value = '';
    document.querySelectorAll('.registration-row').forEach(row => {
        row.style.display = '';
    });
}

function toggleSelectAll() {
    const checked = document.getElementById('select-all').checked;
    document.querySelectorAll('.registration-checkbox').forEach(checkbox => {
        checkbox.checked = checked;
    });
}

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
</script>
@endsection
