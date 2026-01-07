@extends('layouts.app')

@section('title', 'Pending Approvals')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Pending Approvals</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('transactions.index') }}" class="hover:text-primary-600 transition-colors">Transactions</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Pending Approvals</span>
        </nav>
    </div>
    <div class="flex items-center gap-3 flex-wrap">
        <a href="{{ route('transactions.reports') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Reports
        </a>
        <a href="{{ route('transactions.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            All Transactions
        </a>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card p-6 border-l-4 border-l-amber-500 bg-gradient-to-br from-white to-amber-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pending Approval</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ count($pendingApprovals) }}</h3>
            </div>
            <div class="p-3 bg-amber-100/50 rounded-xl text-amber-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-orange-500 bg-gradient-to-br from-white to-orange-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Dual Approval Required</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ count($dualApprovals) }}</h3>
            </div>
            <div class="p-3 bg-orange-100/50 rounded-xl text-orange-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-emerald-500 bg-gradient-to-br from-white to-emerald-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pending Amount</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">GHS {{ number_format($pendingApprovals->sum('amount'), 2) }}</h3>
            </div>
            <div class="p-3 bg-emerald-100/50 rounded-xl text-emerald-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Dual Approval Required (>GHS 5,000) -->
@if(count($dualApprovals) > 0)
<div class="card border border-orange-200 shadow-sm mb-8 overflow-hidden">
    <div class="px-6 py-4 border-b border-orange-100 bg-orange-50 flex items-center justify-between">
        <h3 class="font-bold text-orange-800 text-base flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            High-Value Transactions (Dual Approval Required)
        </h3>
        <span class="inline-flex items-center rounded-md bg-white px-2.5 py-1 text-xs font-bold text-orange-700 shadow-sm ring-1 ring-inset ring-orange-300">
            {{ count($dualApprovals) }} transactions > GHS 5,000
        </span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-orange-50/50 text-orange-800 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold border-b border-orange-100">Date</th>
                    <th class="px-6 py-3 font-semibold border-b border-orange-100">Type</th>
                    <th class="px-6 py-3 font-semibold border-b border-orange-100">Category</th>
                    <th class="px-6 py-3 font-semibold border-b border-orange-100">Description</th>
                    <th class="px-6 py-3 font-semibold border-b border-orange-100">Member</th>
                    <th class="px-6 py-3 font-semibold border-b border-orange-100">Amount</th>
                    <th class="px-6 py-3 font-semibold border-b border-orange-100">Recorded By</th>
                    <th class="px-6 py-3 font-semibold border-b border-orange-100">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-orange-100 bg-white">
                @foreach($dualApprovals as $transaction)
                <tr class="hover:bg-orange-50/30 transition-colors">
                    <td class="px-6 py-4 text-sm text-slate-600 whitespace-nowrap">{{ $transaction->transaction_date->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        @if($transaction->transaction_type === 'income')
                        <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Income</span>
                        @else
                        <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Expense</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-700 capitalize">{{ str_replace('_', ' ', $transaction->category) }}</td>
                    <td>
                        <div class="text-sm font-medium text-slate-900">{{ Str::limit($transaction->description, 30) }}</div>
                        @if($transaction->reference_number)
                        <div class="text-xs text-slate-500 font-mono mt-0.5">Ref: {{ $transaction->reference_number }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if($transaction->member)
                        <a href="{{ route('members.show', $transaction->member) }}" class="text-primary-600 hover:text-primary-800 font-medium whitespace-nowrap">
                            {{ Str::limit($transaction->member->full_name, 20) }}
                        </a>
                        @else
                        <span class="text-slate-400 italic">Anonymous</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-orange-600 whitespace-nowrap">
                            GHS {{ number_format($transaction->amount, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <span class="block text-slate-900">{{ $transaction->recorder->full_name ?? 'System' }}</span>
                        <span class="text-xs text-slate-500">{{ $transaction->created_at->diffForHumans() }}</span>
                    </td>
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

<!-- Standard Pending Approvals -->
<div class="card border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-base">Standard Pending Transactions</h3>
        <span class="text-xs font-medium text-slate-500 bg-white px-2.5 py-1 rounded-full border border-slate-200 shadow-sm">{{ count($pendingApprovals) }} awaiting review</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Date</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Type</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Category</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Description</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Member</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Amount</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Recorded By</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 bg-white">
                @forelse($pendingApprovals as $transaction)
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
                            {{ Str::limit($transaction->member->full_name, 20) }}
                        </a>
                        @else
                        <span class="text-slate-400 italic">Anonymous</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="font-bold font-mono {{ $transaction->amount >= 5000 ? 'text-orange-600' : 'text-slate-700' }}">
                            GHS {{ number_format($transaction->amount, 2) }}
                        </div>
                        @if($transaction->amount >= 5000)
                        <div class="text-xs text-orange-500 font-medium mt-0.5 flex items-center justify-end gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Dual Approval
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <div class="font-medium text-slate-900">{{ $transaction->recorder->full_name ?? 'System' }}</div>
                        <div class="text-xs text-slate-500">{{ $transaction->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-primary py-1.5">
                                Review
                            </a>

                            <form action="{{ route('transactions.approve', $transaction) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-sm bg-white border border-emerald-200 text-emerald-600 hover:bg-emerald-50 hover:text-emerald-700 py-1.5"
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
                    <td colspan="8" class="text-center py-12">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-slate-900 mb-1">All Caught Up!</h3>
                            <p class="text-slate-500">No transactions pending approval at this time.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Quick Actions Guide -->
@if(count($pendingApprovals) > 0)
<div class="card mt-6 border-l-4 border-l-blue-500 bg-blue-50/50 border-y border-r border-blue-100">
    <div class="p-6">
        <div class="flex items-start gap-4">
            <div class="p-2 bg-blue-100 text-blue-600 rounded-lg flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-blue-900 text-lg mb-2">Approval Guidelines</h4>
                <ul class="text-sm text-blue-800 space-y-1.5 list-disc list-inside">
                    <li>Transactions <strong>under GHS 1,000</strong> are normally auto-approved but may appear here if flagged.</li>
                    <li>Transactions <strong>GHS 1,000 - 5,000</strong> require single approval (Pastor or Admin).</li>
                    <li>Transactions <strong>over GHS 5,000</strong> require dual approval (Both Pastor AND Admin).</li>
                    <li>Review transaction details, receipt, and member information before approving.</li>
                    <li>Provide clear rejection reasons when declining transactions.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
