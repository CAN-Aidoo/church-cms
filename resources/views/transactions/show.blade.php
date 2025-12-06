@extends('layouts.app')

@section('title', 'Transaction Details')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Transaction Details</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('transactions.index') }}">Transactions</a>
            <span>/</span>
            <span>#{{ $transaction->id }}</span>
        </nav>
    </div>
    <div class="flex gap-3">
        @if($transaction->status === 'pending')
            @if(auth()->user()->hasAnyRole(['admin', 'pastor']))
            <form action="{{ route('transactions.approve', $transaction) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Approve
                </button>
            </form>

            <button type="button" @click="$refs.rejectModal.showModal()" class="btn btn-danger">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Reject
            </button>
            @endif

            <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-outline">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
        @endif

        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Transaction Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Status Banner -->
        <div class="card">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Transaction Status</div>
                        <div class="flex items-center gap-3">
                            @if($transaction->status === 'completed')
                            <span class="badge badge-success text-lg px-4 py-2">Completed</span>
                            @elseif($transaction->status === 'pending')
                            <span class="badge badge-warning text-lg px-4 py-2">Pending Approval</span>
                            @else
                            <span class="badge badge-secondary text-lg px-4 py-2">Cancelled</span>
                            @endif

                            @if($transaction->transaction_type === 'income')
                            <span class="badge badge-success">Income</span>
                            @else
                            <span class="badge badge-danger">Expense</span>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500 mb-1">Amount</div>
                        <div class="text-3xl font-bold {{ $transaction->transaction_type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->transaction_type === 'income' ? '+' : '-' }}GHS {{ number_format($transaction->amount, 2) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Information -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transaction Information</h3>
            </div>
            <div class="card-body">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 mb-1">Transaction Date</dt>
                        <dd class="text-base font-semibold">{{ $transaction->transaction_date->format('l, F d, Y') }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 mb-1">Category</dt>
                        <dd class="text-base font-semibold capitalize">{{ str_replace('_', ' ', $transaction->category) }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 mb-1">Payment Method</dt>
                        <dd class="text-base font-semibold capitalize">{{ str_replace('_', ' ', $transaction->payment_method) }}</dd>
                    </div>

                    @if($transaction->reference_number)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 mb-1">Reference Number</dt>
                        <dd class="text-base font-semibold">{{ $transaction->reference_number }}</dd>
                    </div>
                    @endif

                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500 mb-1">Description</dt>
                        <dd class="text-base">{{ $transaction->description }}</dd>
                    </div>

                    @if($transaction->notes)
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500 mb-1">Additional Notes</dt>
                        <dd class="text-base text-gray-700">{{ $transaction->notes }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Receipt/Document -->
        @if($transaction->receipt_path)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Receipt/Document</h3>
                @if($transaction->status === 'pending')
                <form action="{{ route('transactions.deleteReceipt', $transaction) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm"
                            onclick="return confirm('Are you sure you want to delete this receipt?')">
                        Delete Receipt
                    </button>
                </form>
                @endif
            </div>
            <div class="card-body">
                @php
                    $extension = pathinfo($transaction->receipt_path, PATHINFO_EXTENSION);
                @endphp

                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                <img src="{{ Storage::url($transaction->receipt_path) }}"
                     alt="Receipt"
                     class="max-w-full h-auto rounded-lg border">
                @else
                <a href="{{ Storage::url($transaction->receipt_path) }}"
                   target="_blank"
                   class="btn btn-outline">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download Receipt ({{ strtoupper($extension) }})
                </a>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar Information -->
    <div class="space-y-6">
        <!-- Member Information -->
        @if($transaction->member)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Member</h3>
            </div>
            <div class="card-body">
                <div class="flex items-center gap-3 mb-4">
                    @if($transaction->member->photo_url)
                    <img src="{{ Storage::url($transaction->member->photo_url) }}"
                         alt="{{ $transaction->member->full_name }}"
                         class="w-16 h-16 rounded-full object-cover">
                    @else
                    <div class="w-16 h-16 rounded-full bg-gradient-primary flex items-center justify-center text-white text-xl font-bold">
                        {{ substr($transaction->member->first_name, 0, 1) }}{{ substr($transaction->member->last_name, 0, 1) }}
                    </div>
                    @endif
                    <div>
                        <div class="font-semibold text-lg">{{ $transaction->member->full_name }}</div>
                        <div class="text-sm text-gray-500">{{ $transaction->member->member_id }}</div>
                    </div>
                </div>
                <a href="{{ route('members.show', $transaction->member) }}" class="btn btn-outline w-full">
                    View Member Profile
                </a>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Member</h3>
            </div>
            <div class="card-body text-center py-8">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <p class="text-gray-500">Anonymous Transaction</p>
            </div>
        </div>
        @endif

        <!-- Recorded By -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Record Information</h3>
            </div>
            <div class="card-body space-y-4">
                <div>
                    <div class="text-sm text-gray-500 mb-1">Recorded By</div>
                    <div class="font-medium">{{ $transaction->recorder->full_name ?? 'System' }}</div>
                    <div class="text-xs text-gray-500">{{ $transaction->created_at->format('M d, Y g:i A') }}</div>
                </div>

                @if($transaction->approved_by)
                <div class="pt-4 border-t">
                    <div class="text-sm text-gray-500 mb-1">Approved By</div>
                    <div class="font-medium">{{ $transaction->approver->full_name ?? 'Unknown' }}</div>
                    <div class="text-xs text-gray-500">{{ $transaction->approved_at?->format('M d, Y g:i A') }}</div>
                </div>
                @endif

                @if($transaction->updated_at != $transaction->created_at)
                <div class="pt-4 border-t">
                    <div class="text-sm text-gray-500 mb-1">Last Updated</div>
                    <div class="text-xs text-gray-500">{{ $transaction->updated_at->format('M d, Y g:i A') }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        @if(auth()->user()->hasRole('admin') && $transaction->status !== 'pending')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Admin Actions</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this transaction? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
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
<dialog x-ref="rejectModal" class="rounded-lg shadow-xl w-full max-w-md p-0">
    <div class="card m-0">
        <div class="card-header">
            <h3 class="card-title">Reject Transaction</h3>
            <button type="button" @click="$refs.rejectModal.close()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form action="{{ route('transactions.reject', $transaction) }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-4">
                    <label for="reason" class="form-label required">Reason for Rejection</label>
                    <textarea id="reason" name="reason" rows="4"
                              class="form-textarea"
                              required
                              placeholder="Please provide a clear reason for rejecting this transaction..."></textarea>
                </div>
                <p class="text-sm text-gray-600">
                    This transaction will be marked as cancelled and the recorder will be notified.
                </p>
            </div>
            <div class="card-footer flex justify-end gap-3">
                <button type="button" @click="$refs.rejectModal.close()" class="btn btn-secondary">
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
