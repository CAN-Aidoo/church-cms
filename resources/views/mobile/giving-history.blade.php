@extends('layouts.mobile')

@section('title', 'Giving History - Church App')
@section('header', 'Giving History')

@section('header-actions')
<button onclick="showFilterModal()" class="p-2 rounded-full hover:bg-white/10">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
    </svg>
</button>
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Summary Cards -->
    <div class="bg-white shadow-sm">
        <div class="px-4 py-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Giving Summary</h2>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <!-- This Month -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl p-4 text-white shadow-md">
                    <p class="text-sm text-blue-100 mb-1">This Month</p>
                    <p class="text-2xl font-bold">GHS <span id="monthlyTotal">0.00</span></p>
                    <p class="text-xs text-blue-100 mt-2">
                        <span id="monthlyCount">0</span> contributions
                    </p>
                </div>

                <!-- This Year -->
                <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-xl p-4 text-white shadow-md">
                    <p class="text-sm text-green-100 mb-1">This Year</p>
                    <p class="text-2xl font-bold">GHS <span id="yearlyTotal">0.00</span></p>
                    <p class="text-xs text-green-100 mt-2">
                        <span id="yearlyCount">0</span> contributions
                    </p>
                </div>
            </div>

            <!-- Category Breakdown -->
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm font-semibold text-gray-700 mb-3">By Category</p>
                <div id="categoryBreakdown" class="space-y-2">
                    <!-- Will be populated by JavaScript -->
                    <p class="text-sm text-gray-500">Loading...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Chips -->
    <div id="activeFilters" class="hidden px-4 py-3 bg-white border-b border-gray-200">
        <div class="flex items-center space-x-2 overflow-x-auto hide-scrollbar">
            <span class="text-sm text-gray-600 flex-shrink-0">Filters:</span>
            <div id="filterChips" class="flex space-x-2">
                <!-- Filter chips will be added here -->
            </div>
            <button onclick="clearFilters()" class="text-sm text-blue-600 hover:underline flex-shrink-0">
                Clear all
            </button>
        </div>
    </div>

    <!-- Transaction List -->
    <div class="px-4 py-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">
                Transactions (<span id="transactionCount">0</span>)
            </h3>
            <button onclick="exportHistory()" class="text-blue-600 text-sm font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export
            </button>
        </div>

        <div id="transactionList" class="space-y-3">
            <!-- Will be populated by JavaScript -->
            <div class="text-center py-12 text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p>Loading transactions...</p>
            </div>
        </div>

        <!-- Load More Button -->
        <div id="loadMoreContainer" class="hidden mt-6 text-center">
            <button onclick="loadMoreTransactions()" id="loadMoreBtn" class="bg-white border-2 border-gray-300 text-gray-700 font-semibold py-3 px-6 rounded-lg hover:bg-gray-50 transition duration-200">
                Load More
            </button>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div id="filterModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl max-w-md w-full mx-4 max-h-[80vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900">Filter Transactions</h3>
            <button onclick="closeFilterModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="filterForm" class="p-6 space-y-6">
            <!-- Date Range -->
            <div>
                <label class="block text-gray-700 font-semibold mb-3">Date Range</label>
                <div class="space-y-2">
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="radio" name="date_range" value="this_month" checked class="text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">This Month</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="radio" name="date_range" value="last_month" class="text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">Last Month</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="radio" name="date_range" value="this_year" class="text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">This Year</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="radio" name="date_range" value="all_time" class="text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">All Time</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="radio" name="date_range" value="custom" class="text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">Custom Range</span>
                    </label>
                </div>

                <!-- Custom Date Range -->
                <div id="customDateRange" class="hidden mt-3 space-y-3 p-4 bg-gray-50 rounded-lg">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">From</label>
                        <input type="date" name="start_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">To</label>
                        <input type="date" name="end_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-gray-700 font-semibold mb-3">Category</label>
                <div class="space-y-2">
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" name="categories" value="tithe" class="rounded text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">Tithe</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" name="categories" value="offering" class="rounded text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">Offering</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" name="categories" value="special_offering" class="rounded text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">Special Offering</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" name="categories" value="donation" class="rounded text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">Donation</span>
                    </label>
                </div>
            </div>

            <!-- Payment Method -->
            <div>
                <label class="block text-gray-700 font-semibold mb-3">Payment Method</label>
                <div class="space-y-2">
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" name="payment_methods" value="mobile_money" class="rounded text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">Mobile Money</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" name="payment_methods" value="card" class="rounded text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">Debit/Credit Card</span>
                    </label>
                </div>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-gray-700 font-semibold mb-3">Status</label>
                <div class="space-y-2">
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" name="statuses" value="completed" checked class="rounded text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">Completed</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" name="statuses" value="pending" class="rounded text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">Pending</span>
                    </label>
                    <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" name="statuses" value="failed" class="rounded text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="font-medium text-gray-900">Failed</span>
                    </label>
                </div>
            </div>

            <!-- Apply Button -->
            <div class="sticky bottom-0 bg-white pt-4 border-t border-gray-200">
                <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Transaction Detail Modal -->
<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center overflow-y-auto">
    <div class="bg-white rounded-xl max-w-md w-full mx-4 my-8">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Transaction Details</h3>
                <button onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div id="detailContent" class="space-y-4">
                <!-- Content will be populated by JavaScript -->
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200 space-y-3">
                <button onclick="viewReceipt()" class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition">
                    View Receipt
                </button>
                <button onclick="closeDetailModal()" class="w-full bg-gray-100 text-gray-700 font-semibold py-3 rounded-lg hover:bg-gray-200 transition">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentPage = 1;
let currentFilters = {};
let selectedTransaction = null;

// Load transactions with filters
async function loadTransactions(page = 1, append = false) {
    try {
        const params = new URLSearchParams({
            page: page,
            per_page: 20,
            ...currentFilters
        });

        const result = await ChurchApp.apiCall(`/api/mobile/v1/payment/history?${params}`, 'GET');

        if (result.success) {
            const transactions = result.data.data || result.data;
            const pagination = result.data.pagination;

            if (transactions.length === 0 && !append) {
                document.getElementById('transactionList').innerHTML = `
                    <div class="text-center py-12 text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="font-semibold mb-2">No transactions found</p>
                        <p class="text-sm">Try adjusting your filters</p>
                    </div>
                `;
                return;
            }

            const transactionHTML = transactions.map(transaction => {
                const statusColors = {
                    'completed': 'bg-emerald-50 text-emerald-600 border-emerald-100',
                    'pending': 'bg-amber-50 text-amber-600 border-amber-100',
                    'failed': 'bg-rose-50 text-rose-600 border-rose-100'
                };

                const date = new Date(transaction.created_at);
                const day = date.getDate();
                const month = date.toLocaleDateString('en-US', { month: 'short' });

                return `
                    <div onclick="showTransactionDetail('${transaction.id}')" class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 cursor-pointer active:scale-[0.98] transition-transform flex items-center justify-between">
                        <div class="flex items-center gap-4">
                             <div class="w-12 h-12 rounded-xl bg-slate-50 flex flex-col items-center justify-center text-slate-500 border border-slate-100 font-bold leading-none">
                                <span class="text-xs uppercase">${month}</span>
                                <span class="text-lg text-slate-800">${day}</span>
                             </div>
                             <div>
                                <p class="font-bold text-slate-800 text-base">${transaction.category_label || transaction.category}</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide border ${statusColors[transaction.status] || 'bg-slate-50 text-slate-500'}">
                                    ${transaction.status}
                                </span>
                             </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-slate-900 tracking-tight">GHS ${parseFloat(transaction.amount).toFixed(2)}</p>
                             ${transaction.is_recurring ? `<div class="text-[10px] text-indigo-500 font-bold uppercase tracking-wider flex items-center justify-end gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Auto</div>` : ''}
                        </div>
                    </div>
                `;
            }).join('');

            if (append) {
                document.getElementById('transactionList').insertAdjacentHTML('beforeend', transactionHTML);
            } else {
                document.getElementById('transactionList').innerHTML = transactionHTML;
            }

            // Show/hide load more button
            if (pagination && pagination.has_more) {
                document.getElementById('loadMoreContainer').classList.remove('hidden');
            } else {
                document.getElementById('loadMoreContainer').classList.add('hidden');
            }

            // Update transaction count
            document.getElementById('transactionCount').textContent = pagination?.total || transactions.length;

            // Store current page
            currentPage = page;
        }
    } catch (error) {
        console.error('Failed to load transactions:', error);
        ChurchApp.showToast('Failed to load transactions', 'error');
    }
}

// Load summary stats
async function loadSummary() {
    try {
        const result = await ChurchApp.getGivingStats();

        if (result.success) {
            const stats = result.data;

            document.getElementById('monthlyTotal').textContent = parseFloat(stats.monthly_total || 0).toFixed(2);
            document.getElementById('monthlyCount').textContent = stats.monthly_count || 0;
            document.getElementById('yearlyTotal').textContent = parseFloat(stats.yearly_total || 0).toFixed(2);
            document.getElementById('yearlyCount').textContent = stats.yearly_count || 0;

            // Category breakdown
            if (stats.by_category) {
                const breakdownHTML = Object.entries(stats.by_category).map(([category, data]) => `
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700">${data.label || category}</span>
                        <span class="text-sm font-semibold text-gray-900">GHS ${parseFloat(data.total).toFixed(2)}</span>
                    </div>
                `).join('');
                document.getElementById('categoryBreakdown').innerHTML = breakdownHTML;
            }
        }
    } catch (error) {
        console.error('Failed to load summary:', error);
    }
}

// Filter modal functions
function showFilterModal() {
    document.getElementById('filterModal').classList.remove('hidden');
}

function closeFilterModal() {
    document.getElementById('filterModal').classList.add('hidden');
}

// Custom date range toggle
document.querySelectorAll('input[name="date_range"]').forEach(radio => {
    radio.addEventListener('change', (e) => {
        const customDiv = document.getElementById('customDateRange');
        if (e.target.value === 'custom') {
            customDiv.classList.remove('hidden');
        } else {
            customDiv.classList.add('hidden');
        }
    });
});

// Apply filters
document.getElementById('filterForm').addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    currentFilters = {};

    // Date range
    const dateRange = formData.get('date_range');
    if (dateRange === 'custom') {
        currentFilters.start_date = formData.get('start_date');
        currentFilters.end_date = formData.get('end_date');
    } else {
        currentFilters.date_range = dateRange;
    }

    // Categories
    const categories = formData.getAll('categories');
    if (categories.length > 0) {
        currentFilters.categories = categories.join(',');
    }

    // Payment methods
    const paymentMethods = formData.getAll('payment_methods');
    if (paymentMethods.length > 0) {
        currentFilters.payment_methods = paymentMethods.join(',');
    }

    // Statuses
    const statuses = formData.getAll('statuses');
    if (statuses.length > 0) {
        currentFilters.statuses = statuses.join(',');
    }

    loadTransactions(1, false);
    updateFilterChips();
    closeFilterModal();
});

// Update filter chips
function updateFilterChips() {
    const hasFilters = Object.keys(currentFilters).length > 0;

    if (hasFilters) {
        document.getElementById('activeFilters').classList.remove('hidden');
        // Could add individual chips here for each filter
    } else {
        document.getElementById('activeFilters').classList.add('hidden');
    }
}

// Clear filters
function clearFilters() {
    currentFilters = {};
    document.getElementById('filterForm').reset();
    document.getElementById('activeFilters').classList.add('hidden');
    loadTransactions(1, false);
}

// Load more transactions
function loadMoreTransactions() {
    loadTransactions(currentPage + 1, true);
}

// Show transaction detail
async function showTransactionDetail(id) {
    selectedTransaction = id;
    document.getElementById('detailModal').classList.remove('hidden');

    try {
        const result = await ChurchApp.apiCall(`/api/mobile/v1/payment/${id}`, 'GET');

        if (result.success) {
            const payment = result.data;
            const date = new Date(payment.created_at);

            const detailHTML = `
                <div class="text-center pb-4 border-b border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Amount</p>
                    <p class="text-3xl font-bold text-gray-900">GHS ${parseFloat(payment.amount).toFixed(2)}</p>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Category</span>
                        <span class="font-semibold text-gray-900">${payment.category_label || payment.category}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Payment Method</span>
                        <span class="font-semibold text-gray-900">${payment.payment_method_label || payment.payment_method}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Date</span>
                        <span class="font-semibold text-gray-900">${date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Transaction ID</span>
                        <span class="font-mono text-sm text-gray-900">${payment.reference || payment.id}</span>
                    </div>
                    ${payment.notes ? `
                        <div>
                            <p class="text-gray-600 mb-1">Notes</p>
                            <p class="text-gray-900">${payment.notes}</p>
                        </div>
                    ` : ''}
                </div>
            `;

            document.getElementById('detailContent').innerHTML = detailHTML;
        }
    } catch (error) {
        console.error('Failed to load transaction details:', error);
    }
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
    selectedTransaction = null;
}

function viewReceipt() {
    if (selectedTransaction) {
        window.location.href = `/mobile/payment-success?reference=${selectedTransaction}`;
    }
}

// Export history
async function exportHistory() {
    ChurchApp.showLoading(true);

    try {
        const params = new URLSearchParams(currentFilters);
        const response = await fetch(`/api/mobile/v1/payment/export?${params}`, {
            method: 'GET',
            credentials: 'same-origin',
            headers: {
                'Accept': 'text/csv'
            }
        });

        if (response.ok) {
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `giving-history-${new Date().toISOString().split('T')[0]}.csv`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);

            ChurchApp.showToast('History exported successfully', 'success');
        }
    } catch (error) {
        console.error('Export error:', error);
        ChurchApp.showToast('Failed to export history', 'error');
    } finally {
        ChurchApp.showLoading(false);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    loadSummary();
    loadTransactions();
});
</script>
@endpush
