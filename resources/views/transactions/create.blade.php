@extends('layouts.app')

@section('title', 'Record Transaction')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Record Transaction</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('transactions.index') }}">Transactions</a>
            <span>/</span>
            <span>Record Transaction</span>
        </nav>
    </div>
</div>

<form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl">
    @csrf

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
                                   value="{{ old('transaction_date', date('Y-m-d')) }}"
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
                                <option value="income" {{ old('transaction_type') === 'income' ? 'selected' : '' }}>Income</option>
                                <option value="expense" {{ old('transaction_type') === 'expense' ? 'selected' : '' }}>Expense</option>
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
                                <optgroup label="Income Categories" id="income-categories" style="display:none;">
                                    <option value="tithe">Tithe</option>
                                    <option value="offering">Offering</option>
                                    <option value="donation">Donation</option>
                                    <option value="pledge">Pledge</option>
                                    <option value="fundraising">Fundraising</option>
                                    <option value="partnership">Partnership</option>
                                    <option value="other_income">Other Income</option>
                                </optgroup>
                                <optgroup label="Expense Categories" id="expense-categories" style="display:none;">
                                    <option value="salary">Salary & Wages</option>
                                    <option value="utilities">Utilities</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="events">Events & Programs</option>
                                    <option value="administration">Administration</option>
                                    <option value="welfare">Welfare</option>
                                    <option value="missions">Missions</option>
                                    <option value="equipment">Equipment</option>
                                    <option value="other_expense">Other Expense</option>
                                </optgroup>
                            </select>
                            @error('category')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="amount" class="form-label required">Amount (GHS)</label>
                            <input type="number" id="amount" name="amount"
                                   value="{{ old('amount') }}"
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
                                <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="cheque" {{ old('payment_method') === 'cheque' ? 'selected' : '' }}>Cheque</option>
                                <option value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="mobile_money" {{ old('payment_method') === 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                                <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>Card</option>
                                <option value="other" {{ old('payment_method') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('payment_method')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="reference_number" class="form-label">Reference Number</label>
                            <input type="text" id="reference_number" name="reference_number"
                                   value="{{ old('reference_number') }}"
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
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="2"
                                      class="form-textarea @error('notes') form-input-error @enderror">{{ old('notes') }}</textarea>
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
                            @if($member ?? false)
                            <option value="{{ $member->id }}" selected>{{ $member->full_name }}</option>
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
                <div class="card-body" x-data="{ fileName: '' }">
                    <input type="file" id="receipt" name="receipt"
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="hidden"
                           @change="fileName = $event.target.files[0]?.name || ''">
                    <label for="receipt" class="btn btn-outline w-full cursor-pointer justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <span x-text="fileName || 'Upload Receipt'"></span>
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
                        Record Transaction
                    </button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary w-full">
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
</script>
@endsection
