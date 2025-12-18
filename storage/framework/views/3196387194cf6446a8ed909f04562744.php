<?php $__env->startSection('title', 'Visit History - Church App'); ?>
<?php $__env->startSection('header', 'Visit History'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 pb-20">
    <!-- Header with Back Button -->
    <div class="bg-white p-4 -mx-4 -mt-4 shadow-sm border-b border-gray-100 sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <a href="<?php echo e(url('/mobile/shepherd')); ?>" class="p-2 -ml-2 text-gray-600 hover:bg-gray-100 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-gray-900">Visit History</h1>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <h3 class="text-sm font-semibold text-gray-700 mb-3">Filters</h3>
        <div class="grid grid-cols-2 gap-3">
            <!-- Time Period Filter -->
            <div>
                <label class="block text-xs text-gray-600 mb-1">Period</label>
                <select id="periodFilter" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 bg-gray-50">
                    <option value="all">All Time</option>
                    <option value="week" selected>This Week</option>
                    <option value="month">This Month</option>
                    <option value="quarter">This Quarter</option>
                </select>
            </div>

            <!-- Visit Type Filter -->
            <div>
                <label class="block text-xs text-gray-600 mb-1">Type</label>
                <select id="typeFilter" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 bg-gray-50">
                    <option value="all">All Types</option>
                    <option value="home">Home Visit</option>
                    <option value="hospital">Hospital</option>
                    <option value="office">Office</option>
                    <option value="call">Phone Call</option>
                </select>
            </div>
        </div>

        <!-- Member Filter -->
        <div class="mt-3">
            <label class="block text-xs text-gray-600 mb-1">Member</label>
            <select id="memberFilter" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 bg-gray-50">
                <option value="all">All Members</option>
                <!-- Populated via JS -->
            </select>
        </div>

        <!-- Apply Filters Button -->
        <button id="applyFilters" class="w-full mt-3 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium text-sm rounded-lg hover:from-blue-700 hover:to-blue-800 active:scale-95 transition">
            Apply Filters
        </button>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-3 gap-3">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 text-center border border-blue-200">
            <span class="block text-2xl font-bold text-blue-700" id="totalVisits">-</span>
            <span class="text-xs text-blue-600">Total Visits</span>
        </div>
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 text-center border border-green-200">
            <span class="block text-2xl font-bold text-green-700" id="uniqueMembers">-</span>
            <span class="text-xs text-green-600">Members</span>
        </div>
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 text-center border border-purple-200">
            <span class="block text-2xl font-bold text-purple-700" id="followUps">-</span>
            <span class="text-xs text-purple-600">Follow-ups</span>
        </div>
    </div>

    <!-- Visit List -->
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800">Visits</h2>
            <span id="visitCount" class="text-sm text-gray-500">0 visits</span>
        </div>

        <!-- Loading State -->
        <div id="loadingState" class="space-y-3">
            <?php for($i = 0; $i < 3; $i++): ?>
            <div class="animate-pulse bg-white p-4 rounded-xl border border-gray-100">
                <div class="h-4 bg-gray-200 rounded w-1/3 mb-2"></div>
                <div class="h-3 bg-gray-200 rounded w-1/2 mb-2"></div>
                <div class="h-3 bg-gray-200 rounded w-2/3"></div>
            </div>
            <?php endfor; ?>
        </div>

        <!-- Visit List Container -->
        <div id="visitList" class="hidden space-y-3"></div>

        <!-- Empty State -->
        <div id="emptyState" class="hidden text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">No Visits Found</h3>
            <p class="text-gray-500 mb-4">No visits match your current filters.</p>
            <button onclick="clearFilters()" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                Clear Filters
            </button>
        </div>
    </div>
</div>

<!-- Visit Detail Modal -->
<div id="visitDetailModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900">Visit Details</h3>
            <button onclick="closeVisitDetail()" class="p-2 hover:bg-gray-100 rounded-full">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="visitDetailContent" class="p-6">
            <!-- Populated via JS -->
        </div>
    </div>
</div>

<!-- Bottom Navigation -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 pb-safe z-50">
    <div class="flex justify-around items-center h-16">
        <a href="<?php echo e(url('/mobile/dashboard')); ?>" class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-xs mt-1">Home</span>
        </a>
        <a href="<?php echo e(url('/mobile/shepherd')); ?>" class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="text-xs mt-1">Flock</span>
        </a>
        <a href="<?php echo e(url('/mobile/shepherd/visits')); ?>" class="flex flex-col items-center justify-center w-full h-full text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span class="text-xs mt-1">History</span>
        </a>
    </div>
</nav>

<?php $__env->startPush('scripts'); ?>
<script>
    let allVisits = [];
    let filteredVisits = [];
    let flockMembers = [];

    document.addEventListener('DOMContentLoaded', async () => {
        await loadFlockMembers();
        await loadVisitHistory();

        // Apply Filters Button
        document.getElementById('applyFilters').addEventListener('click', applyFilters);

        // Filter change listeners
        document.getElementById('periodFilter').addEventListener('change', applyFilters);
        document.getElementById('typeFilter').addEventListener('change', applyFilters);
        document.getElementById('memberFilter').addEventListener('change', applyFilters);
    });

    async function loadFlockMembers() {
        try {
            const result = await ChurchApp.apiCall('/api/mobile/v1/shepherd/flock', 'GET');
            if (result.success && result.data) {
                flockMembers = result.data.data;

                // Populate member filter dropdown
                const memberFilter = document.getElementById('memberFilter');
                flockMembers.forEach(member => {
                    const option = document.createElement('option');
                    option.value = member.id;
                    option.textContent = `${member.first_name} ${member.last_name}`;
                    memberFilter.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Failed to load flock members:', error);
        }
    }

    async function loadVisitHistory() {
        ChurchApp.showLoading(true);
        document.getElementById('loadingState').classList.remove('hidden');
        document.getElementById('visitList').classList.add('hidden');

        try {
            const result = await ChurchApp.apiCall('/api/mobile/v1/shepherd/visit/history', 'GET');

            if (result.success && result.data) {
                allVisits = result.data.data || [];
                filteredVisits = allVisits;

                updateSummaryStats();
                renderVisitList(filteredVisits);
            }
        } catch (error) {
            console.error('Failed to load visit history:', error);
            ChurchApp.showToast('Failed to load visit history', 'error');
        } finally {
            ChurchApp.showLoading(false);
            document.getElementById('loadingState').classList.add('hidden');
        }
    }

    function applyFilters() {
        const period = document.getElementById('periodFilter').value;
        const type = document.getElementById('typeFilter').value;
        const memberId = document.getElementById('memberFilter').value;

        filteredVisits = allVisits.filter(visit => {
            // Period filter
            if (period !== 'all') {
                const visitDate = new Date(visit.visit_date);
                const now = new Date();
                const diff = now - visitDate;

                if (period === 'week' && diff > 7 * 24 * 60 * 60 * 1000) return false;
                if (period === 'month' && diff > 30 * 24 * 60 * 60 * 1000) return false;
                if (period === 'quarter' && diff > 90 * 24 * 60 * 60 * 1000) return false;
            }

            // Type filter
            if (type !== 'all' && visit.visit_type !== type) return false;

            // Member filter
            if (memberId !== 'all' && visit.member_id != memberId) return false;

            return true;
        });

        updateSummaryStats();
        renderVisitList(filteredVisits);
    }

    function clearFilters() {
        document.getElementById('periodFilter').value = 'all';
        document.getElementById('typeFilter').value = 'all';
        document.getElementById('memberFilter').value = 'all';
        applyFilters();
    }

    function updateSummaryStats() {
        const totalVisits = filteredVisits.length;
        const uniqueMembers = new Set(filteredVisits.map(v => v.member_id)).size;
        const followUps = filteredVisits.filter(v => v.follow_up_required).length;

        document.getElementById('totalVisits').textContent = totalVisits;
        document.getElementById('uniqueMembers').textContent = uniqueMembers;
        document.getElementById('followUps').textContent = followUps;
    }

    function renderVisitList(visits) {
        const visitList = document.getElementById('visitList');
        const emptyState = document.getElementById('emptyState');
        const visitCount = document.getElementById('visitCount');

        visitCount.textContent = `${visits.length} visit${visits.length !== 1 ? 's' : ''}`;

        if (visits.length === 0) {
            visitList.classList.add('hidden');
            emptyState.classList.remove('hidden');
            return;
        }

        emptyState.classList.add('hidden');
        visitList.classList.remove('hidden');

        visitList.innerHTML = visits.map(visit => {
            const visitDate = new Date(visit.visit_date);
            const member = visit.member || {};

            return `
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md transition cursor-pointer" onclick="showVisitDetail(${visit.id})">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-bold text-gray-900">${member.first_name || ''} ${member.last_name || ''}</h3>
                            <p class="text-sm text-gray-500">${formatDate(visit.visit_date)}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full ${getVisitTypeColor(visit.visit_type)}">
                            ${getVisitTypeLabel(visit.visit_type)}
                        </span>
                    </div>

                    ${visit.notes ? `
                        <p class="text-sm text-gray-600 line-clamp-2 mb-2">${visit.notes}</p>
                    ` : ''}

                    <div class="flex items-center gap-3 text-xs text-gray-400">
                        ${visit.follow_up_required ? `
                            <span class="flex items-center gap-1 text-orange-600">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Follow-up needed
                            </span>
                        ` : ''}
                        ${visit.location_lat ? `
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                GPS verified
                            </span>
                        ` : ''}
                    </div>
                </div>
            `;
        }).join('');
    }

    function showVisitDetail(visitId) {
        const visit = allVisits.find(v => v.id === visitId);
        if (!visit) return;

        const member = visit.member || {};
        const content = `
            <div class="space-y-4">
                <div>
                    <label class="text-xs text-gray-500 uppercase tracking-wide">Member</label>
                    <p class="font-bold text-gray-900">${member.first_name || ''} ${member.last_name || ''}</p>
                    ${member.phone ? `<p class="text-sm text-gray-600">${member.phone}</p>` : ''}
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Date</label>
                        <p class="font-medium text-gray-900">${formatDate(visit.visit_date)}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Type</label>
                        <p class="font-medium text-gray-900">${getVisitTypeLabel(visit.visit_type)}</p>
                    </div>
                </div>

                ${visit.notes ? `
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Notes</label>
                        <p class="text-gray-700 bg-gray-50 p-3 rounded-lg mt-1">${visit.notes}</p>
                    </div>
                ` : ''}

                ${visit.follow_up_required ? `
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                        <div class="flex items-center gap-2 text-orange-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">Follow-up Required</span>
                        </div>
                    </div>
                ` : ''}

                ${visit.location_lat ? `
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide mb-1 block">Location</label>
                        <div class="bg-gray-100 rounded-lg p-3 text-sm text-gray-600">
                            <p>Lat: ${visit.location_lat}</p>
                            <p>Lng: ${visit.location_lng}</p>
                            <a href="https://maps.google.com/?q=${visit.location_lat},${visit.location_lng}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1 mt-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                View on Map
                            </a>
                        </div>
                    </div>
                ` : ''}
            </div>
        `;

        document.getElementById('visitDetailContent').innerHTML = content;
        document.getElementById('visitDetailModal').classList.remove('hidden');
    }

    function closeVisitDetail() {
        document.getElementById('visitDetailModal').classList.add('hidden');
    }

    function getVisitTypeLabel(type) {
        const labels = {
            'home': 'Home Visit',
            'hospital': 'Hospital',
            'office': 'Office',
            'call': 'Phone Call'
        };
        return labels[type] || type;
    }

    function getVisitTypeColor(type) {
        const colors = {
            'home': 'bg-blue-100 text-blue-700',
            'hospital': 'bg-red-100 text-red-700',
            'office': 'bg-green-100 text-green-700',
            'call': 'bg-purple-100 text-purple-700'
        };
        return colors[type] || 'bg-gray-100 text-gray-700';
    }

    function formatDate(dateStr) {
        if (!dateStr) return 'N/A';
        const date = new Date(dateStr);
        return date.toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mobile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/mobile/shepherd/visit-history.blade.php ENDPATH**/ ?>