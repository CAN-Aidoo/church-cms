@extends('layouts.mobile')

@section('title', 'Prayer Wall - Church App')
@section('header', 'Prayer Wall')

@section('header-actions')
<a href="{{ route('mobile.prayer.my-requests') }}" class="p-2 rounded-full hover:bg/10" title="My Requests">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    </svg>
</a>
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Search and Filter -->
    <div class="px-4 py-4 bg-white border-b border-gray-200">
        <div class="flex gap-2">
            <input type="text" id="searchInput" placeholder="Search prayer requests..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select id="categoryFilter" onchange="loadPrayerWall()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Categories</option>
                <option value="Health">Health</option>
                <option value="Family">Family</option>
                <option value="Finances">Finances</option>
                <option value="Guidance">Guidance</option>
                <option value="Thanksgiving">Thanksgiving</option>
                <option value="Other">Other</option>
            </select>
        </div>
    </div>

    <!-- Prayer Wall List -->
    <div class="px-4 py-6">
        <div id="prayerWall" class="space-y-4">
            <div class="text-center py-12 text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p>Loading prayer wall...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let prayerWall = [];

    async function loadPrayerWall() {
        try {
            const category = document.getElementById('categoryFilter').value;
            const url = `${window.API_BASE_URL}/prayer/wall${category ? '?category=' + category : ''}`;

            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Failed to fetch prayer wall');

            const data = await response.json();
            prayerWall = data.requests || [];
            renderPrayerWall();

        } catch (error) {
            console.error('Error loading prayer wall:', error);
            showError();
        }
    }

    function renderPrayerWall() {
        const container = document.getElementById('prayerWall');

        if (prayerWall.length === 0) {
            container.innerHTML = `
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-gray-500 font-medium">No prayer requests on the wall yet</p>
                </div>
            `;
            return;
        }

        container.innerHTML = prayerWall.map(request => {
            const date = new Date(request.created_at);
            const formattedDate = date.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric'
            });

            return `
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-start gap-3 mb-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                            ${request.member_name ? request.member_name.charAt(0).toUpperCase() : 'A'}
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">${request.title}</h4>
                            <p class="text-xs text-gray-500">${request.member_name || 'Anonymous'} • ${formattedDate}</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-700 mb-3">${request.request}</p>
                    ${request.category ? `<span class="inline-block px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-full">${request.category}</span>` : ''}
                    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-gray-100">
                        <button onclick="prayForThis(${request.id})" class="flex items-center gap-1 text-blue-600 text-sm font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <span>Pray</span>
                            ${request.prayer_count > 0 ? `<span class="text-gray-500">(${request.prayer_count})</span>` : ''}
                        </button>
                    </div>
                </div>
            `;
        }).join('');
    }

    async function prayForThis(id) {
        try {
            const response = await fetch(`${window.API_BASE_URL}/prayer/${id}/pray`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Failed to record prayer');

            window.dispatchEvent(new CustomEvent('notify', {
                detail: { message: 'Prayer recorded', type: 'success' }
            }));

            await loadPrayerWall();

        } catch (error) {
            console.error('Error recording prayer:', error);
        }
    }

    function showError() {
        document.getElementById('prayerWall').innerHTML = `
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-gray-700 font-medium">Failed to load prayer wall</p>
                <button onclick="loadPrayerWall()" class="mt-4 text-blue-600 font-medium text-sm hover:underline">
                    Try Again
                </button>
            </div>
        `;
    }

    // Search functionality
    let searchTimeout;
    document.getElementById('searchInput').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const searchTerm = this.value.toLowerCase();
            const filtered = prayerWall.filter(r =>
                r.title.toLowerCase().includes(searchTerm) ||
                r.request.toLowerCase().includes(searchTerm)
            );
            prayerWall = filtered;
            renderPrayerWall();
        }, 300);
    });

    document.addEventListener('DOMContentLoaded', loadPrayerWall);
</script>
@endpush
