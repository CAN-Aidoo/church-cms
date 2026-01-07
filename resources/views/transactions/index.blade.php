@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Financial Transactions</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Transactions</span>
        </nav>
    </div>
    <div class="flex items-center gap-3 flex-wrap">
        <a href="{{ route('transactions.reports') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Reports
        </a>
        <a href="{{ route('transactions.export', request()->query()) }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export CSV
        </a>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Record Transaction
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border-l-4 border-l-emerald-500 bg-gradient-to-br from-white to-emerald-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Income</p>
                <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">GHS {{ number_format($summary['total_income'] ?? 0, 2) }}</h3>
            </div>
            <div class="p-2 bg-emerald-100/50 rounded-lg text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-red-500 bg-gradient-to-br from-white to-red-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Expenses</p>
                <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">GHS {{ number_format($summary['total_expenses'] ?? 0, 2) }}</h3>
            </div>
            <div class="p-2 bg-red-100/50 rounded-lg text-red-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-amber-500 bg-gradient-to-br from-white to-amber-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Net Balance</p>
                <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">GHS {{ number_format($summary['net_balance'] ?? 0, 2) }}</h3>
            </div>
            <div class="p-2 bg-amber-100/50 rounded-lg text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-indigo-500 bg-gradient-to-br from-white to-indigo-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pending Approval</p>
                <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">{{ $statistics['pending_count'] ?? 0 }}</h3>
            </div>
            <div class="p-2 bg-indigo-100/50 rounded-lg text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card border border-slate-100 mb-8" x-data="{ showFilters: false }">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-base">Filters</h3>
        <button @click="showFilters = !showFilters" class="text-sm font-medium text-primary-600 hover:text-primary-700 flex items-center">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
        </button>
    </div>
    <div x-show="showFilters" x-transition class="p-6">
        <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div>
                <label for="date_from" class="form-label mb-1.5 block font-medium text-sm text-slate-700">From Date</label>
                <input type="date" id="date_from" name="date_from"
                       value="{{ $filters['date_from'] ?? '' }}"
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
            </div>

            <div>
                <label for="date_to" class="form-label mb-1.5 block font-medium text-sm text-slate-700">To Date</label>
                <input type="date" id="date_to" name="date_to"
                       value="{{ $filters['date_to'] ?? '' }}"
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
            </div>

            <div>
                <label for="transaction_type" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Type</label>
                <select id="transaction_type" name="transaction_type" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">All Types</option>
                    <option value="income" {{ ($filters['transaction_type'] ?? '') === 'income' ? 'selected' : '' }}>Income</option>
                    <option value="expense" {{ ($filters['transaction_type'] ?? '') === 'expense' ? 'selected' : '' }}>Expense</option>
                </select>
            </div>

            <div>
                <label for="category" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Category</label>
                <select id="category" name="category" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
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
                <label for="status" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Status</label>
                <select id="status" name="status" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ ($filters['status'] ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div>
                <label for="payment_method" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Payment Method</label>
                <select id="payment_method" name="payment_method" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">All Methods</option>
                    <option value="cash" {{ ($filters['payment_method'] ?? '') === 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="cheque" {{ ($filters['payment_method'] ?? '') === 'cheque' ? 'selected' : '' }}>Cheque</option>
                    <option value="bank_transfer" {{ ($filters['payment_method'] ?? '') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="mobile_money" {{ ($filters['payment_method'] ?? '') === 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                    <option value="card" {{ ($filters['payment_method'] ?? '') === 'card' ? 'selected' : '' }}>Card</option>
                </select>
            </div>

            <div>
                <label for="search" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Search</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" id="search" name="search"
                           value="{{ $filters['search'] ?? '' }}"
                           placeholder="Description, reference..."
                           class="form-input w-full pl-9 border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                </div>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="btn btn-primary flex-1">
                    Apply Filters
                </button>
                <a href="{{ route('transactions.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                    Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Transactions Table -->
<div class="card border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-base">
            Transaction List
            <span class="text-sm text-slate-500 font-normal ml-1">({{ $transactions->total() }} total)</span>
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 w-32">Date</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Type</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Category</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Description</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Member</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 w-32 text-right">Amount</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Payment</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Status</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 bg-white">
                @forelse($transactions as $transaction)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 text-sm text-slate-600 whitespace-nowrap">
                        {{ $transaction->transaction_date->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($transaction->transaction_type === 'income')
                        <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Income</span>
                        @else
                        <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Expense</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-700 capitalize">
                        {{ str_replace('_', ' ', $transaction->category) }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-slate-900">{{ Str::limit($transaction->description, 30) }}</div>
                        @if($transaction->reference_number)
                        <div class="text-xs text-slate-500 font-mono mt-0.5">Ref: {{ $transaction->reference_number }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if($transaction->member)
                        <a href="{{ route('members.show', $transaction->member) }}" class="text-primary-600 hover:text-primary-800 font-medium transition-colors">
                            {{ $transaction->member->full_name }}
                        </a>
                        @else
                        <span class="text-slate-400 italic">Anonymous</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="text-sm font-bold font-mono {{ $transaction->transaction_type === 'income' ? 'text-emerald-600' : 'text-slate-700' }}">
                            GHS {{ number_format($transaction->amount, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 capitalize">
                        {{ str_replace('_', ' ', $transaction->payment_method) }}
                    </td>
                    <td class="px-6 py-4">
                        @if($transaction->status === 'completed')
                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Completed</span>
                        @elseif($transaction->status === 'pending')
                        <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">Pending</span>
                        @else
                        <span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-medium text-slate-700 ring-1 ring-inset ring-slate-600/20">Cancelled</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('transactions.show', $transaction) }}"
                               class="text-slate-400 hover:text-primary-600 transition-colors" title="View Details">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>

                            @if($transaction->status === 'pending')
                            <a href="{{ route('transactions.edit', $transaction) }}"
                               class="text-slate-400 hover:text-amber-600 transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-12 text-slate-500">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <p>No transactions found matching criteria.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transactions->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection
