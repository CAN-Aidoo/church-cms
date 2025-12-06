@extends('layouts.app')

@section('title', 'Financial Reports')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Financial Reports</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('transactions.index') }}">Transactions</a>
            <span>/</span>
            <span>Reports</span>
        </nav>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('transactions.export', $filters) }}" class="btn btn-outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export Report
        </a>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            View Transactions
        </a>
    </div>
</div>

<!-- Date Range Filter -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" action="{{ route('transactions.reports') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label for="date_from" class="form-label">From Date</label>
                <input type="date" id="date_from" name="date_from"
                       value="{{ $filters['date_from'] }}"
                       class="form-input">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" id="date_to" name="date_to"
                       value="{{ $filters['date_to'] }}"
                       class="form-input">
            </div>
            <button type="submit" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Apply
            </button>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="stat-card bg-gradient-primary">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value">GHS {{ number_format($summary['total_income'], 2) }}</div>
            <div class="stat-label">Total Income</div>
        </div>
    </div>

    <div class="stat-card bg-gradient-to-br from-red-500 to-red-600">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value">GHS {{ number_format($summary['total_expenses'], 2) }}</div>
            <div class="stat-label">Total Expenses</div>
        </div>
    </div>

    <div class="stat-card bg-gradient-gold">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value {{ $summary['net_balance'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                GHS {{ number_format($summary['net_balance'], 2) }}
            </div>
            <div class="stat-label">Net Balance</div>
        </div>
    </div>

    <div class="stat-card bg-gradient-to-br from-purple-500 to-purple-600">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value">GHS {{ number_format($summary['pending_amount'], 2) }}</div>
            <div class="stat-label">Pending Approval</div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Monthly Trends Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Monthly Trends (Last 12 Months)</h3>
        </div>
        <div class="card-body">
            <canvas id="monthlyTrendsChart" height="300"></canvas>
        </div>
    </div>

    <!-- Income vs Expense Pie Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Income vs Expenses</h3>
        </div>
        <div class="card-body">
            <canvas id="incomeExpensePieChart" height="300"></canvas>
        </div>
    </div>
</div>

<!-- Breakdown Tables Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Income Breakdown -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Income Breakdown</h3>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th class="text-right">Amount</th>
                            <th class="text-right">Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalIncome = array_sum($incomeBreakdown);
                        @endphp
                        @forelse($incomeBreakdown as $category => $amount)
                        <tr>
                            <td class="capitalize font-medium">{{ str_replace('_', ' ', $category) }}</td>
                            <td class="text-right">GHS {{ number_format($amount, 2) }}</td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <div class="flex-1 max-w-[100px] bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full"
                                             style="width: {{ $totalIncome > 0 ? ($amount / $totalIncome * 100) : 0 }}%"></div>
                                    </div>
                                    <span class="text-sm">{{ $totalIncome > 0 ? number_format($amount / $totalIncome * 100, 1) : 0 }}%</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-8 text-gray-500">No income recorded in this period</td>
                        </tr>
                        @endforelse
                        @if(count($incomeBreakdown) > 0)
                        <tr class="font-bold bg-gray-50">
                            <td>Total Income</td>
                            <td class="text-right">GHS {{ number_format($totalIncome, 2) }}</td>
                            <td class="text-right">100%</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Expense Breakdown -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Expense Breakdown</h3>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th class="text-right">Amount</th>
                            <th class="text-right">Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalExpenses = array_sum($expenseBreakdown);
                        @endphp
                        @forelse($expenseBreakdown as $category => $amount)
                        <tr>
                            <td class="capitalize font-medium">{{ str_replace('_', ' ', $category) }}</td>
                            <td class="text-right">GHS {{ number_format($amount, 2) }}</td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <div class="flex-1 max-w-[100px] bg-gray-200 rounded-full h-2">
                                        <div class="bg-red-500 h-2 rounded-full"
                                             style="width: {{ $totalExpenses > 0 ? ($amount / $totalExpenses * 100) : 0 }}%"></div>
                                    </div>
                                    <span class="text-sm">{{ $totalExpenses > 0 ? number_format($amount / $totalExpenses * 100, 1) : 0 }}%</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-8 text-gray-500">No expenses recorded in this period</td>
                        </tr>
                        @endforelse
                        @if(count($expenseBreakdown) > 0)
                        <tr class="font-bold bg-gray-50">
                            <td>Total Expenses</td>
                            <td class="text-right">GHS {{ number_format($totalExpenses, 2) }}</td>
                            <td class="text-right">100%</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Top Donors -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">Top Donors (Current Period)</h3>
    </div>
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Member</th>
                        <th>Member ID</th>
                        <th class="text-right">Total Given</th>
                        <th class="text-right">Transactions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topDonors as $index => $donor)
                    <tr>
                        <td>
                            @if($index === 0)
                            <span class="text-2xl">🥇</span>
                            @elseif($index === 1)
                            <span class="text-2xl">🥈</span>
                            @elseif($index === 2)
                            <span class="text-2xl">🥉</span>
                            @else
                            <span class="text-gray-500">#{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('members.show', $donor['member']) }}" class="text-blue-600 hover:underline font-medium">
                                {{ $donor['member']->full_name }}
                            </a>
                        </td>
                        <td class="text-gray-600">{{ $donor['member']->member_id }}</td>
                        <td class="text-right font-semibold">GHS {{ number_format($donor['total_given'], 2) }}</td>
                        <td class="text-right text-gray-600">{{ $donor['member']->transactions()->count() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-gray-500">
                            No donor data available for this period
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pending Approvals (Admin/Pastor Only) -->
@if(auth()->user()->hasAnyRole(['admin', 'pastor']) && count($pendingApprovals) > 0)
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pending Approvals</h3>
        <a href="{{ route('transactions.pending') }}" class="text-blue-600 hover:underline text-sm">
            View All
        </a>
    </div>
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Recorded By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingApprovals->take(5) as $transaction)
                    <tr>
                        <td class="whitespace-nowrap">{{ $transaction->transaction_date->format('M d, Y') }}</td>
                        <td>
                            @if($transaction->transaction_type === 'income')
                            <span class="badge badge-success">Income</span>
                            @else
                            <span class="badge badge-danger">Expense</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($transaction->description, 40) }}</td>
                        <td class="font-semibold whitespace-nowrap">GHS {{ number_format($transaction->amount, 2) }}</td>
                        <td>{{ $transaction->recorder->full_name ?? 'System' }}</td>
                        <td class="whitespace-nowrap">
                            <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-primary">
                                Review
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
            borderColor: 'rgb(34, 197, 94)',
            backgroundColor: 'rgba(34, 197, 94, 0.1)',
            tension: 0.4
        }, {
            label: 'Expenses',
            data: expenseData,
            borderColor: 'rgb(239, 68, 68)',
            backgroundColor: 'rgba(239, 68, 68, 0.1)',
            tension: 0.4
        }, {
            label: 'Net Balance',
            data: netData,
            borderColor: 'rgb(234, 179, 8)',
            backgroundColor: 'rgba(234, 179, 8, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'GHS ' + value.toLocaleString();
                    }
                }
            }
        }
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
                'rgb(34, 197, 94)',
                'rgb(239, 68, 68)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.parsed || 0;
                        return label + ': GHS ' + value.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    }
                }
            }
        }
    }
});
</script>
@endsection
