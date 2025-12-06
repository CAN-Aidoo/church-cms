@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Financial Transactions</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>Transactions</span>
        </nav>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('transactions.reports') }}" class="btn btn-outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Reports
        </a>
        <a href="{{ route('transactions.export', request()->query()) }}" class="btn btn-outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export CSV
        </a>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Record Transaction
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="stat-card bg-gradient-primary">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value">GHS {{ number_format($summary['total_income'] ?? 0, 2) }}</div>
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
            <div class="stat-value">GHS {{ number_format($summary['total_expenses'] ?? 0, 2) }}</div>
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
            <div class="stat-value">GHS {{ number_format($summary['net_balance'] ?? 0, 2) }}</div>
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
            <div class="stat-value">{{ $statistics['pending_count'] ?? 0 }}</div>
            <div class="stat-label">Pending Approval</div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6" x-data="{ showFilters: false }">
    <div class="card-header">
        <h3 class="card-title">Filters</h3>
        <button @click="showFilters = !showFilters" class="btn btn-sm btn-outline">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
        </button>
    </div>
    <div x-show="showFilters" x-transition class="card-body">
        <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="date_from" class="form-label">From Date</label>
                <input type="date" id="date_from" name="date_from"
                       value="{{ $filters['date_from'] ?? '' }}"
                       class="form-input">
            </div>

            <div>
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" id="date_to" name="date_to"
                       value="{{ $filters['date_to'] ?? '' }}"
                       class="form-input">
            </div>

            <div>
                <label for="transaction_type" class="form-label">Type</label>
                <select id="transaction_type" name="transaction_type" class="form-select">
                    <option value="">All Types</option>
                    <option value="income" {{ ($filters['transaction_type'] ?? '') === 'income' ? 'selected' : '' }}>Income</option>
                    <option value="expense" {{ ($filters['transaction_type'] ?? '') === 'expense' ? 'selected' : '' }}>Expense</option>
                </select>
            </div>

            <div>
                <label for="category" class="form-label">Category</label>
                <select id="category" name="category" class="form-select">
                    <option value="">All Categories</option>
                    <optgroup label="Income">
                        <option value="tithe" {{ ($filters['category'] ?? '') === 'tithe' ? 'selected' : '' }}>Tithe</option>
                        <option value="offering" {{ ($filters['category'] ?? '') === 'offering' ? 'selected' : '' }}>Offering</option>
                        <option value="donation" {{ ($filters['category'] ?? '') === 'donation' ? 'selected' : '' }}>Donation</option>
                        <option value="pledge" {{ ($filters['category'] ?? '') === 'pledge' ? 'selected' : '' }}>Pledge</option>
                        <option value="fundraising" {{ ($filters['category'] ?? '') === 'fundraising' ? 'selected' : '' }}>Fundraising</option>
                    </optgroup>
                    <optgroup label="Expense">
                        <option value="salary" {{ ($filters['category'] ?? '') === 'salary' ? 'selected' : '' }}>Salary</option>
                        <option value="utilities" {{ ($filters['category'] ?? '') === 'utilities' ? 'selected' : '' }}>Utilities</option>
                        <option value="maintenance" {{ ($filters['category'] ?? '') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="events" {{ ($filters['category'] ?? '') === 'events' ? 'selected' : '' }}>Events</option>
                        <option value="missions" {{ ($filters['category'] ?? '') === 'missions' ? 'selected' : '' }}>Missions</option>
                    </optgroup>
                </select>
            </div>

            <div>
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ ($filters['status'] ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div>
                <label for="payment_method" class="form-label">Payment Method</label>
                <select id="payment_method" name="payment_method" class="form-select">
                    <option value="">All Methods</option>
                    <option value="cash" {{ ($filters['payment_method'] ?? '') === 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="cheque" {{ ($filters['payment_method'] ?? '') === 'cheque' ? 'selected' : '' }}>Cheque</option>
                    <option value="bank_transfer" {{ ($filters['payment_method'] ?? '') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="mobile_money" {{ ($filters['payment_method'] ?? '') === 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                    <option value="card" {{ ($filters['payment_method'] ?? '') === 'card' ? 'selected' : '' }}>Card</option>
                </select>
            </div>

            <div>
                <label for="search" class="form-label">Search</label>
                <input type="text" id="search" name="search"
                       value="{{ $filters['search'] ?? '' }}"
                       placeholder="Description, reference..."
                       class="form-input">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="btn btn-primary flex-1">
                    Apply Filters
                </button>
                <a href="{{ route('transactions.index') }}" class="btn btn-outline">
                    Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Transactions Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Transaction List
            <span class="text-sm text-gray-500 font-normal ml-2">({{ $transactions->total() }} total)</span>
        </h3>
    </div>
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Member</th>
                        <th>Amount</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td class="whitespace-nowrap">
                            {{ $transaction->transaction_date->format('M d, Y') }}
                        </td>
                        <td>
                            @if($transaction->transaction_type === 'income')
                            <span class="badge badge-success">Income</span>
                            @else
                            <span class="badge badge-danger">Expense</span>
                            @endif
                        </td>
                        <td class="capitalize">{{ str_replace('_', ' ', $transaction->category) }}</td>
                        <td>
                            <div class="font-medium">{{ Str::limit($transaction->description, 40) }}</div>
                            @if($transaction->reference_number)
                            <div class="text-xs text-gray-500">Ref: {{ $transaction->reference_number }}</div>
                            @endif
                        </td>
                        <td>
                            @if($transaction->member)
                            <a href="{{ route('members.show', $transaction->member) }}" class="text-blue-600 hover:underline">
                                {{ $transaction->member->full_name }}
                            </a>
                            @else
                            <span class="text-gray-400">Anonymous</span>
                            @endif
                        </td>
                        <td class="font-semibold whitespace-nowrap">
                            GHS {{ number_format($transaction->amount, 2) }}
                        </td>
                        <td class="capitalize">{{ str_replace('_', ' ', $transaction->payment_method) }}</td>
                        <td>
                            @if($transaction->status === 'completed')
                            <span class="badge badge-success">Completed</span>
                            @elseif($transaction->status === 'pending')
                            <span class="badge badge-warning">Pending</span>
                            @else
                            <span class="badge badge-secondary">Cancelled</span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap">
                            <div class="flex gap-2">
                                <a href="{{ route('transactions.show', $transaction) }}"
                                   class="text-blue-600 hover:text-blue-800" title="View">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>

                                @if($transaction->status === 'pending')
                                <a href="{{ route('transactions.edit', $transaction) }}"
                                   class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            No transactions found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($transactions->hasPages())
    <div class="card-footer">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection
