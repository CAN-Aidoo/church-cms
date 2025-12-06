@extends('layouts.app')

@section('title', 'Pending Approvals')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Pending Approvals</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('transactions.index') }}">Transactions</a>
            <span>/</span>
            <span>Pending Approvals</span>
        </nav>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('transactions.reports') }}" class="btn btn-outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Reports
        </a>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            All Transactions
        </a>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="stat-card bg-gradient-to-br from-yellow-500 to-yellow-600">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ count($pendingApprovals) }}</div>
            <div class="stat-label">Pending Approval</div>
        </div>
    </div>

    <div class="stat-card bg-gradient-to-br from-orange-500 to-orange-600">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value">{{ count($dualApprovals) }}</div>
            <div class="stat-label">Requiring Dual Approval</div>
        </div>
    </div>

    <div class="stat-card bg-gradient-gold">
        <div class="stat-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value">GHS {{ number_format($pendingApprovals->sum('amount'), 2) }}</div>
            <div class="stat-label">Total Pending Amount</div>
        </div>
    </div>
</div>

<!-- Dual Approval Required (>GHS 5,000) -->
@if(count($dualApprovals) > 0)
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title flex items-center gap-2">
            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            High-Value Transactions (Dual Approval Required)
        </h3>
        <span class="badge badge-warning">{{ count($dualApprovals) }} transactions &gt; GHS 5,000</span>
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
                        <th>Recorded By</th>
                        <th>Days Pending</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dualApprovals as $transaction)
                    <tr class="bg-orange-50">
                        <td class="whitespace-nowrap">{{ $transaction->transaction_date->format('M d, Y') }}</td>
                        <td>
                            @if($transaction->transaction_type === 'income')
                            <span class="badge badge-success">Income</span>
                            @else
                            <span class="badge badge-danger">Expense</span>
                            @endif
                        </td>
                        <td class="capitalize">{{ str_replace('_', ' ', $transaction->category) }}</td>
                        <td>
                            <div class="font-medium">{{ Str::limit($transaction->description, 30) }}</div>
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
                        <td class="font-bold text-orange-600 whitespace-nowrap">
                            GHS {{ number_format($transaction->amount, 2) }}
                        </td>
                        <td>{{ $transaction->recorder->full_name ?? 'System' }}</td>
                        <td>
                            <span class="badge {{ $transaction->created_at->diffInDays() > 7 ? 'badge-danger' : 'badge-warning' }}">
                                {{ $transaction->created_at->diffForHumans(null, true) }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap">
                            <div class="flex gap-2">
                                <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-primary">
                                    Review
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<!-- Standard Pending Approvals -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Standard Pending Transactions</h3>
        <span class="text-sm text-gray-500">{{ count($pendingApprovals) }} transactions awaiting review</span>
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
                        <th>Recorded By</th>
                        <th>Days Pending</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingApprovals as $transaction)
                    <tr>
                        <td class="whitespace-nowrap">{{ $transaction->transaction_date->format('M d, Y') }}</td>
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
                                {{ Str::limit($transaction->member->full_name, 20) }}
                            </a>
                            @else
                            <span class="text-gray-400">Anonymous</span>
                            @endif
                        </td>
                        <td class="font-semibold whitespace-nowrap {{ $transaction->amount >= 5000 ? 'text-orange-600' : '' }}">
                            GHS {{ number_format($transaction->amount, 2) }}
                            @if($transaction->amount >= 5000)
                            <span class="text-xs text-orange-500 block">Dual Approval</span>
                            @endif
                        </td>
                        <td class="capitalize">{{ str_replace('_', ' ', $transaction->payment_method) }}</td>
                        <td>
                            <div class="font-medium">{{ $transaction->recorder->full_name ?? 'System' }}</div>
                            <div class="text-xs text-gray-500">{{ $transaction->created_at->format('M d, g:i A') }}</div>
                        </td>
                        <td>
                            <span class="badge {{ $transaction->created_at->diffInDays() > 7 ? 'badge-danger' : ($transaction->created_at->diffInDays() > 3 ? 'badge-warning' : 'badge-secondary') }}">
                                {{ $transaction->created_at->diffForHumans(null, true) }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap">
                            <div class="flex gap-2">
                                <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-primary">
                                    Review
                                </a>

                                <form action="{{ route('transactions.approve', $transaction) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline text-green-600 hover:bg-green-50"
                                            onclick="return confirm('Are you sure you want to approve this transaction?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-xl font-medium text-gray-600 mb-2">All Caught Up!</p>
                            <p class="text-gray-500">No transactions pending approval at this time.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Quick Actions Guide -->
@if(count($pendingApprovals) > 0)
<div class="card mt-6 bg-blue-50 border-blue-200">
    <div class="card-body">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="font-semibold text-blue-900 mb-2">Approval Guidelines</h4>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• Transactions <strong>under GHS 1,000</strong> are auto-approved</li>
                    <li>• Transactions <strong>GHS 1,000 - 5,000</strong> require single approval (Pastor or Admin)</li>
                    <li>• Transactions <strong>over GHS 5,000</strong> require dual approval (Both Pastor AND Admin)</li>
                    <li>• Review transaction details, receipt, and member information before approving</li>
                    <li>• Provide clear rejection reasons when declining transactions</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
