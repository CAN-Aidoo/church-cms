@extends('layouts.app')

@section('title', 'Transaction Details')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-heading font-bold text-slate-900">Transaction Details</h1>
            <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs font-bold font-mono">
                #{{ $transaction->id }}
            </span>
        </div>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('transactions.index') }}" class="hover:text-primary-600 transition-colors">Transactions</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Details</span>
        </nav>
    </div>
    <div class="flex items-center gap-3 flex-wrap">
        @if($transaction->status === 'pending')
            @if(auth()->user()->hasAnyRole(['admin', 'pastor']))
            <form action="{{ route('transactions.approve', $transaction) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn btn-primary shadow-lg shadow-primary-500/30">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Approve
                </button>
            </form>

            <button type="button" @click="$refs.rejectModal.showModal()" class="btn btn-danger">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                Reject
            </button>
            @endif

            <a href="{{ route('transactions.edit', $transaction) }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit
            </a>
        @endif

        <a href="{{ route('transactions.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to List
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Transaction Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Status Banner -->
        <div class="card border border-slate-100 p-6 bg-gradient-to-br from-white to-slate-50">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Transaction Status</div>
                    <div class="flex items-center gap-3">
                        @if($transaction->status === 'completed')
                        <span class="inline-flex items-center rounded-lg bg-emerald-50 px-3 py-1.5 text-sm font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Completed</span>
                        @elseif($transaction->status === 'pending')
                        <span class="inline-flex items-center rounded-lg bg-amber-50 px-3 py-1.5 text-sm font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Pending Approval</span>
                        @else
                        <span class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1.5 text-sm font-medium text-slate-700 ring-1 ring-inset ring-slate-600/20">Cancelled</span>
                        @endif

                        @if($transaction->transaction_type === 'income')
                        <span class="inline-flex items-center rounded-lg bg-emerald-50 px-3 py-1.5 text-sm font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Income</span>
                        @else
                        <span class="inline-flex items-center rounded-lg bg-red-50 px-3 py-1.5 text-sm font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Expense</span>
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Amount</div>
                    <div class="text-3xl font-heading font-bold {{ $transaction->transaction_type === 'income' ? 'text-emerald-600' : 'text-red-600' }}">
                        {{ $transaction->transaction_type === 'income' ? '+' : '-' }}GHS {{ number_format($transaction->amount, 2) }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Information -->
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Transaction Information</h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">
                    <div>
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Transaction Date</dt>
                        <dd class="text-base font-semibold text-slate-900">{{ $transaction->transaction_date->format('l, F d, Y') }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Category</dt>
                        <dd class="text-base font-semibold text-slate-900 capitalize">{{ str_replace('_', ' ', $transaction->category) }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Payment Method</dt>
                        <dd class="text-base font-semibold text-slate-900 capitalize">{{ str_replace('_', ' ', $transaction->payment_method) }}</dd>
                    </div>

                    @if($transaction->reference_number)
                    <div>
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Reference Number</dt>
                        <dd class="text-base font-semibold text-slate-900 font-mono">{{ $transaction->reference_number }}</dd>
                    </div>
                    @endif

                    <div class="md:col-span-2">
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Description</dt>
                        <dd class="text-base text-slate-700 leading-relaxed">{{ $transaction->description }}</dd>
                    </div>

                    @if($transaction->notes)
                    <div class="md:col-span-2">
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Additional Notes</dt>
                        <dd class="text-base text-slate-600 italic bg-slate-50 p-4 rounded-lg border border-slate-100">{{ $transaction->notes }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Receipt/Document -->
        @if($transaction->receipt_path)
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 text-base">Receipt/Document</h3>
                @if($transaction->status === 'pending')
                <form action="{{ route('transactions.deleteReceipt', $transaction) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium uppercase tracking-wide transition-colors"
                            onclick="return confirm('Are you sure you want to delete this receipt?')">
                        Delete Receipt
                    </button>
                </form>
                @endif
            </div>
            <div class="p-6">
                @php
                    $extension = pathinfo($transaction->receipt_path, PATHINFO_EXTENSION);
                @endphp

                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                <div class="rounded-lg border border-slate-100 overflow-hidden bg-slate-50">
                    <img src="{{ Storage::url($transaction->receipt_path) }}"
                         alt="Receipt"
                         class="max-w-full h-auto mx-auto">
                </div>
                @else
                <div class="p-4 bg-slate-50 rounded-lg border border-slate-100 text-center">
                    <p class="text-slate-600 mb-3 font-medium">Document Preview Not Available</p>
                    <a href="{{ Storage::url($transaction->receipt_path) }}"
                       target="_blank"
                       class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Download Receipt ({{ strtoupper($extension) }})
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar Information -->
    <div class="space-y-6">
        <!-- Member Information -->
        @if($transaction->member)
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Member</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    @if($transaction->member->photo_url)
                    <img src="{{ Storage::url($transaction->member->photo_url) }}"
                         alt="{{ $transaction->member->full_name }}"
                         class="w-14 h-14 rounded-full object-cover ring-2 ring-white shadow-sm">
                    @else
                    <div class="w-14 h-14 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 text-xl font-bold ring-2 ring-white shadow-sm">
                        {{ substr($transaction->member->first_name, 0, 1) }}{{ substr($transaction->member->last_name, 0, 1) }}
                    </div>
                    @endif
                    <div>
                        <div class="font-bold text-slate-900 text-lg">{{ $transaction->member->full_name }}</div>
                        <div class="text-sm text-slate-500 font-mono">{{ $transaction->member->member_id }}</div>
                    </div>
                </div>
                <a href="{{ route('members.show', $transaction->member) }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 w-full justify-center">
                    View Member Profile
                </a>
            </div>
        </div>
        @else
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Member</h3>
            </div>
            <div class="p-8 text-center text-slate-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <p class="font-medium">Anonymous Transaction</p>
            </div>
        </div>
        @endif

        <!-- Recorded By -->
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Record Information</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Recorded By</div>
                    <div class="font-medium text-slate-900">{{ $transaction->recorder->full_name ?? 'System' }}</div>
                    <div class="text-xs text-slate-500">{{ $transaction->created_at->format('M d, Y g:i A') }}</div>
                </div>

                @if($transaction->approved_by)
                <div class="pt-4 border-t border-slate-100">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Approved By</div>
                    <div class="font-medium text-slate-900">{{ $transaction->approver->full_name ?? 'Unknown' }}</div>
                    <div class="text-xs text-slate-500">{{ $transaction->approved_at?->format('M d, Y g:i A') }}</div>
                </div>
                @endif

                @if($transaction->updated_at != $transaction->created_at)
                <div class="pt-4 border-t border-slate-100">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Last Updated</div>
                    <div class="text-xs text-slate-500">{{ $transaction->updated_at->format('M d, Y g:i A') }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        @if(auth()->user()->hasRole('admin') && $transaction->status !== 'pending')
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Admin Actions</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this transaction? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Delete Transaction
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
@if($transaction->status === 'pending' && auth()->user()->hasAnyRole(['admin', 'pastor']))
<dialog x-ref="rejectModal" class="rounded-xl shadow-2xl w-full max-w-md p-0 backdrop:bg-slate-900/50">
    <div class="card border-0 m-0">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-lg">Reject Transaction</h3>
            <button type="button" @click="$refs.rejectModal.close()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('transactions.reject', $transaction) }}" method="POST">
            @csrf
            <div class="p-6">
                <div class="mb-4">
                    <label for="reason" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Reason for Rejection</label>
                    <textarea id="reason" name="reason" rows="4"
                              class="form-textarea w-full rounded-xl border-slate-200 focus:border-red-500 focus:ring-red-500"
                              required
                              placeholder="Please provide a clear reason for rejecting this transaction..."></textarea>
                </div>
                <p class="text-xs text-slate-500 flex items-start gap-2">
                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>This transaction will be marked as cancelled and the recorder will be notified.</span>
                </p>
            </div>
            <div class="px-6 py-4 bg-slate-50 flex justify-end gap-3 rounded-b-xl">
                <button type="button" @click="$refs.rejectModal.close()" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900">
                    Cancel
                </button>
                <button type="submit" class="btn btn-danger">
                    Reject Transaction
                </button>
            </div>
        </form>
    </div>
</dialog>
@endif
@endsection
