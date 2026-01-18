@extends('layouts.mobile')

@section('title', 'My Prayer Requests - Church App')
@section('header', 'My Prayer Requests')

@section('header-actions')
<a href="{{ route('mobile.prayer.wall') }}" class="p-2 rounded-full hover:bg-white/10" title="Prayer Wall">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
    </svg>
</a>
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Create New Request Button -->
    <div class="px-4 py-4 bg-white border-b border-gray-200">
        <button onclick="showCreateModal()" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center py-3 rounded-xl font-semibold shadow-md hover:from-blue-700 hover:to-blue-800 transition duration-200">
            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            New Prayer Request
        </button>
    </div>

    <!-- Filter Tabs -->
    <div class="px-4 py-3 bg-white border-b border-gray-200">
        <div class="flex space-x-2 overflow-x-auto hide-scrollbar">
            <button onclick="filterByStatus('all')" data-status="all" class="status-filter px-4 py-2 rounded-lg font-medium text-sm transition whitespace-nowrap bg-blue-600 text-white">
                All
            </button>
            <button onclick="filterByStatus('pending')" data-status="pending" class="status-filter px-4 py-2 rounded-lg font-medium text-sm transition whitespace-nowrap bg-gray-100 text-gray-700">
                Pending
            </button>
            <button onclick="filterByStatus('answered')" data-status="answered" class="status-filter px-4 py-2 rounded-lg font-medium text-sm transition whitespace-nowrap bg-gray-100 text-gray-700">
                Answered
            </button>
            <button onclick="filterByStatus('archived')" data-status="archived" class="status-filter px-4 py-2 rounded-lg font-medium text-sm transition whitespace-nowrap bg-gray-100 text-gray-700">
                Archived
            </button>
        </div>
    </div>

    <!-- Prayer Requests List -->
    <div class="px-4 py-6">
        <div id="requestsList" class="space-y-3">
            <!-- Will be populated by JavaScript -->
            <div class="text-center py-12 text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p>Loading prayer requests...</p>
            </div>
        </div>
    </div>
</div>

<!-- Create/Edit Modal -->
<div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900" id="modalTitle">New Prayer Request</h3>
            <button onclick="closeCreateModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="requestForm" class="p-6 space-y-4">
            <input type="hidden" id="requestId" value="">

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Title</label>
                <input type="text" id="title" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Request</label>
                <textarea id="request" rows="6" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Category (Optional)</label>
                <select id="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select category...</option>
                    <option value="Health">Health</option>
                    <option value="Family">Family</option>
                    <option value="Finances">Finances</option>
                    <option value="Guidance">Guidance</option>
                    <option value="Thanksgiving">Thanksgiving</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeCreateModal()" class="flex-1 bg-gray-100 text-gray-700 font-semibold py-3 px-6 rounded-lg hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-3 px-6 rounded-lg hover:from-blue-700 hover:to-blue-800 transition">
                    <span id="submitText">Submit</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // HTML escape helper to prevent XSS
    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        const div = document.createElement('div');
        div.textContent = String(text);
        return div.innerHTML;
    }

    let prayerRequests = [];
    let currentFilter = 'all';

    async function loadPrayerRequests() {
        try {
            const response = await fetch(`${window.API_BASE_URL}/prayer/my-requests`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                if (response.status === 401) {
                    window.location.href = '/mobile/login';
                    return;
                }
                throw new Error('Failed to fetch prayer requests');
            }

            const data = await response.json();
            prayerRequests = data.requests || [];
            renderRequests();

        } catch (error) {
            console.error('Error loading prayer requests:', error);
            showError();
        }
    }

    function renderRequests() {
        const container = document.getElementById('requestsList');
        let filtered = prayerRequests;

        if (currentFilter !== 'all') {
            filtered = prayerRequests.filter(r => r.status === currentFilter);
        }

        if (filtered.length === 0) {
            container.innerHTML = `
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-gray-500 font-medium">No prayer requests yet</p>
                    <p class="text-sm text-gray-400 mt-2">Submit your first prayer request</p>
                    <button onclick="showCreateModal()" class="mt-4 text-blue-600 font-medium text-sm">
                        Create Request →
                    </button>
                </div>
            `;
            return;
        }

        container.innerHTML = filtered.map(request => {
            const statusColors = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'answered': 'bg-green-100 text-green-800',
                'archived': 'bg-gray-100 text-gray-800'
            };

            const date = new Date(request.created_at);
            const formattedDate = date.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });

            return `
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-start justify-between mb-2">
                        <h4 class="font-semibold text-gray-900 flex-1">${escapeHtml(request.title)}</h4>
                        <span class="px-2 py-1 rounded-full text-xs font-medium ${statusColors[request.status] || statusColors.pending}">
                            ${escapeHtml(request.status)}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">${escapeHtml(request.request)}</p>
                    ${request.category ? `<span class="inline-block px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-full mb-2">${escapeHtml(request.category)}</span>` : ''}
                    <div class="flex items-center justify-between text-xs text-gray-500 mt-3">
                        <span>${formattedDate}</span>
                        <div class="flex gap-2">
                            <button onclick="editRequest(${request.id})" class="text-blue-600 hover:underline">Edit</button>
                            <button onclick="deleteRequest(${request.id})" class="text-red-600 hover:underline">Delete</button>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    function filterByStatus(status) {
        currentFilter = status;

        // Update button styles
        document.querySelectorAll('.status-filter').forEach(btn => {
            if (btn.dataset.status === status) {
                btn.classList.remove('bg-gray-100', 'text-gray-700');
                btn.classList.add('bg-blue-600', 'text-white');
            } else {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            }
        });

        renderRequests();
    }

    function showCreateModal() {
        document.getElementById('modalTitle').textContent = 'New Prayer Request';
        document.getElementById('submitText').textContent = 'Submit';
        document.getElementById('requestForm').reset();
        document.getElementById('requestId').value = '';
        document.getElementById('createModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function editRequest(id) {
        const request = prayerRequests.find(r => r.id === id);
        if (!request) return;

        document.getElementById('modalTitle').textContent = 'Edit Prayer Request';
        document.getElementById('submitText').textContent = 'Update';
        document.getElementById('requestId').value = request.id;
        document.getElementById('title').value = request.title;
        document.getElementById('request').value = request.request;
        document.getElementById('category').value = request.category || '';
        document.getElementById('createModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    async function deleteRequest(id) {
        if (!confirm('Are you sure you want to delete this prayer request?')) return;

        try {
            const response = await fetch(`${window.API_BASE_URL}/prayer/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Failed to delete');

            // Reload the list
            await loadPrayerRequests();

            // Show success message
            window.dispatchEvent(new CustomEvent('notify', {
                detail: { message: 'Prayer request deleted', type: 'success' }
            }));

        } catch (error) {
            console.error('Error deleting request:', error);
            alert('Failed to delete prayer request');
        }
    }

    document.getElementById('requestForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const requestId = document.getElementById('requestId').value;
        const data = {
            title: document.getElementById('title').value,
            request: document.getElementById('request').value,
            category: document.getElementById('category').value
        };

        try {
            const url = requestId
                ? `${window.API_BASE_URL}/prayer/${requestId}`
                : `${window.API_BASE_URL}/prayer`;

            const method = requestId ? 'PUT' : 'POST';

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin',
                body: JSON.stringify(data)
            });

            if (!response.ok) throw new Error('Failed to save');

            closeCreateModal();
            await loadPrayerRequests();

            window.dispatchEvent(new CustomEvent('notify', {
                detail: { message: requestId ? 'Prayer request updated' : 'Prayer request submitted', type: 'success' }
            }));

        } catch (error) {
            console.error('Error saving request:', error);
            alert('Failed to save prayer request');
        }
    });

    function showError() {
        document.getElementById('requestsList').innerHTML = `
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-gray-700 font-medium">Failed to load prayer requests</p>
                <button onclick="loadPrayerRequests()" class="mt-4 text-blue-600 font-medium text-sm hover:underline">
                    Try Again
                </button>
            </div>
        `;
    }

    document.addEventListener('DOMContentLoaded', loadPrayerRequests);
</script>
@endpush
