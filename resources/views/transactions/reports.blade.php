@extends('layouts.app')

@section('title', 'Financial Reports')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Financial Reports</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('transactions.index') }}" class="hover:text-primary-600 transition-colors">Transactions</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Reports</span>
        </nav>
    </div>
    <div class="flex items-center gap-3 flex-wrap">
        <a href="{{ route('transactions.export', $filters) }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export Report
        </a>
        <a href="{{ route('transactions.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            View Transactions
        </a>
    </div>
</div>

<!-- Date Range Filter -->
<div class="card border border-slate-100 mb-8 p-6">
    <form method="GET" action="{{ route('transactions.reports') }}" class="flex flex-col md:flex-row gap-4 items-end">
        <div class="flex-1 min-w-[200px] w-full">
            <label for="date_from" class="form-label mb-1.5 block font-medium text-sm text-slate-700">From Date</label>
            <input type="date" id="date_from" name="date_from"
                   value="{{ $filters['date_from'] }}"
                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
        </div>
        <div class="flex-1 min-w-[200px] w-full">
            <label for="date_to" class="form-label mb-1.5 block font-medium text-sm text-slate-700">To Date</label>
            <input type="date" id="date_to" name="date_to"
                   value="{{ $filters['date_to'] }}"
                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
        </div>
        <button type="submit" class="btn btn-primary w-full md:w-auto">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            Apply Filters
        </button>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border-l-4 border-l-emerald-500 bg-gradient-to-br from-white to-emerald-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Income</p>
                <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">GHS {{ number_format($summary['total_income'], 2) }}</h3>
            </div>
            <div class="p-3 bg-emerald-100/50 rounded-xl text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-red-500 bg-gradient-to-br from-white to-red-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Expenses</p>
                <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">GHS {{ number_format($summary['total_expenses'], 2) }}</h3>
            </div>
            <div class="p-3 bg-red-100/50 rounded-xl text-red-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-amber-500 bg-gradient-to-br from-white to-amber-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Net Balance</p>
                <h3 class="text-2xl font-heading font-bold {{ $summary['net_balance'] >= 0 ? 'text-emerald-600' : 'text-red-600' }} mt-2">
                    GHS {{ number_format($summary['net_balance'], 2) }}
                </h3>
            </div>
            <div class="p-3 bg-amber-100/50 rounded-xl text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-indigo-500 bg-gradient-to-br from-white to-indigo-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pending Approval</p>
                <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">GHS {{ number_format($summary['pending_amount'], 2) }}</h3>
            </div>
            <div class="p-3 bg-indigo-100/50 rounded-xl text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Monthly Trends Chart -->
    <div class="card border border-slate-100">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Monthly Trends (Last 12 Months)</h3>
        </div>
        <div class="p-6">
            <div class="h-80 w-full">
                <canvas id="monthlyTrendsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Income vs Expense Pie Chart -->
    <div class="card border border-slate-100">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Income vs Expenses</h3>
        </div>
        <div class="p-6">
            <div class="h-80 w-full flex items-center justify-center">
                <canvas id="incomeExpensePieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Breakdown Tables Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Income Breakdown -->
    <div class="card border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Income Breakdown</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100">Category</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Amount</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Percentage</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 bg-white">
                    @php
                        $totalIncome = array_sum($incomeBreakdown);
                    @endphp
                    @forelse($incomeBreakdown as $category => $amount)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 capitalize font-medium text-slate-700">{{ str_replace('_', ' ', $category) }}</td>
                        <td class="px-6 py-4 text-right font-medium text-slate-900">GHS {{ number_format($amount, 2) }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <div class="w-24 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-emerald-500 h-1.5 rounded-full"
                                         style="width: {{ $totalIncome > 0 ? ($amount / $totalIncome * 100) : 0 }}%"></div>
                                </div>
                                <span class="text-xs font-medium text-slate-500 w-8 text-right">{{ $totalIncome > 0 ? number_format($amount / $totalIncome * 100, 1) : 0 }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-8 text-slate-500">No income recorded in this period</td>
                    </tr>
                    @endforelse
                    @if(count($incomeBreakdown) > 0)
                    <tr class="bg-slate-50/80 font-bold border-t border-slate-100">
                        <td class="px-6 py-4 text-slate-900">Total Income</td>
                        <td class="px-6 py-4 text-right text-emerald-600">GHS {{ number_format($totalIncome, 2) }}</td>
                        <td class="px-6 py-4 text-right text-slate-700">100%</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Expense Breakdown -->
    <div class="card border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Expense Breakdown</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100">Category</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Amount</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Percentage</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 bg-white">
                    @php
                        $totalExpenses = array_sum($expenseBreakdown);
                    @endphp
                    @forelse($expenseBreakdown as $category => $amount)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 capitalize font-medium text-slate-700">{{ str_replace('_', ' ', $category) }}</td>
                        <td class="px-6 py-4 text-right font-medium text-slate-900">GHS {{ number_format($amount, 2) }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <div class="w-24 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-red-500 h-1.5 rounded-full"
                                         style="width: {{ $totalExpenses > 0 ? ($amount / $totalExpenses * 100) : 0 }}%"></div>
                                </div>
                                <span class="text-xs font-medium text-slate-500 w-8 text-right">{{ $totalExpenses > 0 ? number_format($amount / $totalExpenses * 100, 1) : 0 }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-8 text-slate-500">No expenses recorded in this period</td>
                    </tr>
                    @endforelse
                    @if(count($expenseBreakdown) > 0)
                    <tr class="bg-slate-50/80 font-bold border-t border-slate-100">
                        <td class="px-6 py-4 text-slate-900">Total Expenses</td>
                        <td class="px-6 py-4 text-right text-red-600">GHS {{ number_format($totalExpenses, 2) }}</td>
                        <td class="px-6 py-4 text-right text-slate-700">100%</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Top Donors -->
<div class="card border border-slate-100 mb-8 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
        <h3 class="font-bold text-slate-800 text-base">Top Donors (Current Period)</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 w-16">Rank</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Member</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Member ID</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Total Given</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Transactions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 bg-white">
                @forelse($topDonors as $index => $donor)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 text-center">
                        @if($index === 0)
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 text-amber-600 font-bold text-sm">1</span>
                        @elseif($index === 1)
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-200 text-slate-600 font-bold text-sm">2</span>
                        @elseif($index === 2)
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-600 font-bold text-sm">3</span>
                        @else
                        <span class="text-slate-500 font-medium text-sm">#{{ $index + 1 }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('members.show', $donor['member']) }}" class="text-primary-600 hover:text-primary-800 font-bold hover:underline transition-colors">
                            {{ $donor['member']->full_name }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-sm font-mono text-slate-500">{{ $donor['member']->member_id }}</td>
                    <td class="px-6 py-4 text-right font-bold text-emerald-600">GHS {{ number_format($donor['total_given'], 2) }}</td>
                    <td class="px-6 py-4 text-right text-slate-600">{{ $donor['member']->transactions()->count() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-slate-500">
                        No donor data available for this period
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pending Approvals (Admin/Pastor Only) -->
@if(auth()->user()->hasAnyRole(['admin', 'pastor']) && count($pendingApprovals) > 0)
<div class="card border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-base">Pending Approvals</h3>
        <a href="{{ route('transactions.pending') }}" class="text-sm font-medium text-primary-600 hover:text-primary-700 hover:underline">
            View All
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Date</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Type</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Description</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Amount</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Recorded By</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 bg-white">
                @foreach($pendingApprovals->take(5) as $transaction)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 text-sm text-slate-600 whitespace-nowrap">{{ $transaction->transaction_date->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        @if($transaction->transaction_type === 'income')
                        <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Income</span>
                        @else
                        <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Expense</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-700">{{ Str::limit($transaction->description, 30) }}</td>
                    <td class="px-6 py-4 font-bold text-slate-800 whitespace-nowrap">GHS {{ number_format($transaction->amount, 2) }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $transaction->recorder->full_name ?? 'System' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-primary py-1.5 shadow-sm">
                            Review
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Monthly Trends Chart
const trendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
const trendsData = @json($trends);
const trendsLabels = Object.keys(trendsData);
const incomeData = trendsLabels.map(label => trendsData[label].income);
const expenseData = trendsLabels.map(label => trendsData[label].expenses);
const netData = trendsLabels.map(label => trendsData[label].net);

new Chart(trendsCtx, {
    type: 'line',
    data: {
        labels: trendsLabels,
        datasets: [{
            label: 'Income',
            data: incomeData,
            borderColor: 'rgb(16, 185, 129)', // emerald-500
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            tension: 0.4,
            borderWidth: 2,
            pointBackgroundColor: '#ffffff',
            pointBorderColor: 'rgb(16, 185, 129)',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6
        }, {
            label: 'Expenses',
            data: expenseData,
            borderColor: 'rgb(239, 68, 68)', // red-500
            backgroundColor: 'rgba(239, 68, 68, 0.1)',
            tension: 0.4,
            borderWidth: 2,
            pointBackgroundColor: '#ffffff',
            pointBorderColor: 'rgb(239, 68, 68)',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6
        }, {
            label: 'Net Balance',
            data: netData,
            borderColor: 'rgb(245, 158, 11)', // amber-500
            backgroundColor: 'rgba(245, 158, 11, 0.1)',
            tension: 0.4,
            borderWidth: 2,
            pointBackgroundColor: '#ffffff',
            pointBorderColor: 'rgb(245, 158, 11)',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    usePointStyle: true,
                    font: {
                        family: "'Inter', sans-serif",
                        size: 12
                    },
                    padding: 20
                }
            },
            tooltip: {
                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                titleFont: {
                    family: "'Inter', sans-serif",
                    size: 13
                },
                bodyFont: {
                    family: "'Inter', sans-serif",
                    size: 12
                },
                padding: 10,
                cornerRadius: 8,
                displayColors: true
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(226, 232, 240, 0.6)',
                    borderDash: [4, 4]
                },
                ticks: {
                    font: {
                        family: "'Inter', sans-serif",
                        size: 11
                    },
                    color: '#64748b',
                    callback: function(value) {
                        return 'GHS ' + value.toLocaleString();
                    }
                },
                border: {
                    display: false
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: {
                        family: "'Inter', sans-serif",
                        size: 11
                    },
                    color: '#64748b'
                },
                border: {
                    display: false
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index',
        },
    }
});

// Income vs Expense Pie Chart
const pieCtx = document.getElementById('incomeExpensePieChart').getContext('2d');
new Chart(pieCtx, {
    type: 'doughnut',
    data: {
        labels: ['Income', 'Expenses'],
        datasets: [{
            data: [{{ $summary['total_income'] }}, {{ $summary['total_expenses'] }}],
            backgroundColor: [
                'rgb(16, 185, 129)', // emerald-500
                'rgb(239, 68, 68)'   // red-500
            ],
            borderWidth: 0,
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    font: {
                        family: "'Inter', sans-serif",
                        size: 12
                    },
                    padding: 20
                }
            },
            tooltip: {
                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                titleFont: {
                    family: "'Inter', sans-serif",
                    size: 13
                },
                bodyFont: {
                    family: "'Inter', sans-serif",
                    size: 12
                },
                padding: 10,
                cornerRadius: 8,
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.parsed || 0;
                        return label + ': GHS ' + value.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    }
                }
            }
        },
        cutout: '70%'
    }
});
</script>
@endsection
