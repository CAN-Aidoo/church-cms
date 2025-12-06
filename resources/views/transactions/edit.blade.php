@extends('layouts.app')

@section('title', 'Edit Transaction')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Transaction</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('transactions.index') }}">Transactions</a>
            <span>/</span>
            <a href="{{ route('transactions.show', $transaction) }}">#{{ $transaction->id }}</a>
            <span>/</span>
            <span>Edit</span>
        </nav>
    </div>
</div>

<form action="{{ route('transactions.update', $transaction) }}" method="POST" enctype="multipart/form-data" class="max-w-4xl">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Transaction Details -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transaction Details</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="transaction_date" class="form-label required">Transaction Date</label>
                            <input type="date" id="transaction_date" name="transaction_date"
                                   value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}"
                                   class="form-input @error('transaction_date') form-input-error @enderror"
                                   required>
                            @error('transaction_date')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="transaction_type" class="form-label required">Type</label>
                            <select id="transaction_type" name="transaction_type"
                                    class="form-select @error('transaction_type') form-input-error @enderror"
                                    required x-data x-on:change="updateCategories($event.target.value)">
                                <option value="">Select Type</option>
                                <option value="income" {{ old('transaction_type', $transaction->transaction_type) === 'income' ? 'selected' : '' }}>Income</option>
                                <option value="expense" {{ old('transaction_type', $transaction->transaction_type) === 'expense' ? 'selected' : '' }}>Expense</option>
                            </select>
                            @error('transaction_type')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category" class="form-label required">Category</label>
                            <select id="category" name="category"
                                    class="form-select @error('category') form-input-error @enderror"
                                    required>
                                <option value="">Select Category</option>
                                <optgroup label="Income Categories" id="income-categories" style="display:{{ old('transaction_type', $transaction->transaction_type) === 'income' ? 'block' : 'none' }};">
                                    <option value="tithe" {{ old('category', $transaction->category) === 'tithe' ? 'selected' : '' }}>Tithe</option>
                                    <option value="offering" {{ old('category', $transaction->category) === 'offering' ? 'selected' : '' }}>Offering</option>
                                    <option value="donation" {{ old('category', $transaction->category) === 'donation' ? 'selected' : '' }}>Donation</option>
                                    <option value="pledge" {{ old('category', $transaction->category) === 'pledge' ? 'selected' : '' }}>Pledge</option>
                                    <option value="fundraising" {{ old('category', $transaction->category) === 'fundraising' ? 'selected' : '' }}>Fundraising</option>
                                    <option value="partnership" {{ old('category', $transaction->category) === 'partnership' ? 'selected' : '' }}>Partnership</option>
                                    <option value="other_income" {{ old('category', $transaction->category) === 'other_income' ? 'selected' : '' }}>Other Income</option>
                                </optgroup>
                                <optgroup label="Expense Categories" id="expense-categories" style="display:{{ old('transaction_type', $transaction->transaction_type) === 'expense' ? 'block' : 'none' }};">
                                    <option value="salary" {{ old('category', $transaction->category) === 'salary' ? 'selected' : '' }}>Salary & Wages</option>
                                    <option value="utilities" {{ old('category', $transaction->category) === 'utilities' ? 'selected' : '' }}>Utilities</option>
                                    <option value="maintenance" {{ old('category', $transaction->category) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    <option value="events" {{ old('category', $transaction->category) === 'events' ? 'selected' : '' }}>Events & Programs</option>
                                    <option value="administration" {{ old('category', $transaction->category) === 'administration' ? 'selected' : '' }}>Administration</option>
                                    <option value="welfare" {{ old('category', $transaction->category) === 'welfare' ? 'selected' : '' }}>Welfare</option>
                                    <option value="missions" {{ old('category', $transaction->category) === 'missions' ? 'selected' : '' }}>Missions</option>
                                    <option value="equipment" {{ old('category', $transaction->category) === 'equipment' ? 'selected' : '' }}>Equipment</option>
                                    <option value="other_expense" {{ old('category', $transaction->category) === 'other_expense' ? 'selected' : '' }}>Other Expense</option>
                                </optgroup>
                            </select>
                            @error('category')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="amount" class="form-label required">Amount (GHS)</label>
                            <input type="number" id="amount" name="amount"
                                   value="{{ old('amount', $transaction->amount) }}"
                                   step="0.01" min="0.01"
                                   class="form-input @error('amount') form-input-error @enderror"
                                   required>
                            @error('amount')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="payment_method" class="form-label required">Payment Method</label>
                            <select id="payment_method" name="payment_method"
                                    class="form-select @error('payment_method') form-input-error @enderror"
                                    required>
                                <option value="">Select Method</option>
                                <option value="cash" {{ old('payment_method', $transaction->payment_method) === 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="cheque" {{ old('payment_method', $transaction->payment_method) === 'cheque' ? 'selected' : '' }}>Cheque</option>
                                <option value="bank_transfer" {{ old('payment_method', $transaction->payment_method) === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="mobile_money" {{ old('payment_method', $transaction->payment_method) === 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                                <option value="card" {{ old('payment_method', $transaction->payment_method) === 'card' ? 'selected' : '' }}>Card</option>
                                <option value="other" {{ old('payment_method', $transaction->payment_method) === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('payment_method')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="reference_number" class="form-label">Reference Number</label>
                            <input type="text" id="reference_number" name="reference_number"
                                   value="{{ old('reference_number', $transaction->reference_number) }}"
                                   placeholder="e.g., CHQ123456"
                                   class="form-input @error('reference_number') form-input-error @enderror">
                            @error('reference_number')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="form-label required">Description</label>
                            <textarea id="description" name="description" rows="3"
                                      class="form-textarea @error('description') form-input-error @enderror"
                                      required>{{ old('description', $transaction->description) }}</textarea>
                            @error('description')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="2"
                                      class="form-textarea @error('notes') form-input-error @enderror">{{ old('notes', $transaction->notes) }}</textarea>
                            @error('notes')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Member Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Member (Optional)</h3>
                </div>
                <div class="card-body">
                    <div>
                        <label for="member_id" class="form-label">Select Member</label>
                        <select id="member_id" name="member_id"
                                class="form-select @error('member_id') form-input-error @enderror">
                            <option value="">Anonymous/No Member</option>
                            @if($transaction->member)
                            <option value="{{ $transaction->member->id }}" selected>{{ $transaction->member->full_name }}</option>
                            @endif
                        </select>
                        @error('member_id')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Leave blank for anonymous donations or general expenses</p>
                    </div>
                </div>
            </div>

            <!-- Receipt Upload -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Receipt/Document</h3>
                </div>
                <div class="card-body" x-data="{ fileName: '{{ $transaction->receipt_path ? basename($transaction->receipt_path) : '' }}' }">
                    @if($transaction->receipt_path)
                    <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div>
                                    <div class="text-sm font-medium text-blue-900">Current Receipt</div>
                                    <div class="text-xs text-blue-700">{{ basename($transaction->receipt_path) }}</div>
                                </div>
                            </div>
                            <a href="{{ Storage::url($transaction->receipt_path) }}" target="_blank"
                               class="text-blue-600 hover:text-blue-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Upload a new file to replace the current receipt</p>
                    @endif

                    <input type="file" id="receipt" name="receipt"
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="hidden"
                           @change="fileName = $event.target.files[0]?.name || ''">
                    <label for="receipt" class="btn btn-outline w-full cursor-pointer justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <span x-text="fileName || 'Upload {{ $transaction->receipt_path ? 'New' : '' }} Receipt'"></span>
                    </label>
                    @error('receipt')
                    <p class="form-error mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-2">PDF, JPG, PNG up to 2MB</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-body space-y-3">
                    <button type="submit" class="btn btn-primary w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Transaction
                    </button>
                    <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-secondary w-full">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
function updateCategories(type) {
    const incomeCategories = document.getElementById('income-categories');
    const expenseCategories = document.getElementById('expense-categories');
    const categorySelect = document.getElementById('category');

    categorySelect.value = '';

    if (type === 'income') {
        incomeCategories.style.display = 'block';
        expenseCategories.style.display = 'none';
    } else if (type === 'expense') {
        incomeCategories.style.display = 'none';
        expenseCategories.style.display = 'block';
    } else {
        incomeCategories.style.display = 'none';
        expenseCategories.style.display = 'none';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const transactionType = document.getElementById('transaction_type').value;
    if (transactionType) {
        updateCategories(transactionType);
    }
});
</script>
@endsection
