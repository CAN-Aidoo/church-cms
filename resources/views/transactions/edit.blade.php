@extends('layouts.app')

@section('title', 'Edit Transaction')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-heading font-bold text-slate-900">Edit Transaction</h1>
            <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs font-bold font-mono">
                #{{ $transaction->id }}
            </span>
        </div>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('transactions.index') }}" class="hover:text-primary-600 transition-colors">Transactions</a>
            <span>/</span>
            <a href="{{ route('transactions.show', $transaction) }}" class="hover:text-primary-600 transition-colors">Details</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Edit</span>
        </nav>
    </div>
</div>

<form action="{{ route('transactions.update', $transaction) }}" method="POST" enctype="multipart/form-data" class="max-w-5xl mx-auto"
      x-data="{ 
          type: '{{ old('transaction_type', $transaction->transaction_type) }}',
          init() {
              // We do NOT want to reset category like the create page might
              // Just ensure visibility is correct
              this.updateVisibility();
          },
          updateVisibility() {
              const income = document.getElementById('income-categories');
              const expense = document.getElementById('expense-categories');
              if (this.type === 'income') {
                  income.style.display = '';
                  expense.style.display = 'none';
              } else if (this.type === 'expense') {
                  income.style.display = 'none';
                  expense.style.display = '';
              } else {
                  income.style.display = 'none';
                  expense.style.display = 'none';
              }
          },
          onChangeType() {
             this.updateVisibility();
             // Optionally clear category if type changes, but careful not to wipe it on init
             // Since this is edit, user probably knows what they are doing.
             // Let's reset the select to empty if they change type manually
             document.getElementById('category').value = '';
          }
      }">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Transaction Details -->
            <div class="card border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Transaction Details</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="transaction_date" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Transaction Date</label>
                            <input type="date" id="transaction_date" name="transaction_date"
                                   value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('transaction_date') border-red-500 @enderror"
                                   required>
                            @error('transaction_date')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="transaction_type" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Type</label>
                            <select id="transaction_type" name="transaction_type"
                                    class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('transaction_type') border-red-500 @enderror"
                                    required x-model="type" @change="onChangeType">
                                <option value="">Select Type</option>
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>
                            @error('transaction_type')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Category</label>
                            <select id="category" name="category"
                                    class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('category') border-red-500 @enderror"
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
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="amount" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Amount (GHS)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 font-medium">GHS</span>
                                <input type="number" id="amount" name="amount"
                                       value="{{ old('amount', $transaction->amount) }}"
                                       step="0.01" min="0.01"
                                       class="form-input w-full pl-12 border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('amount') border-red-500 @enderror"
                                       required>
                            </div>
                            @error('amount')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="payment_method" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Payment Method</label>
                            <select id="payment_method" name="payment_method"
                                    class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('payment_method') border-red-500 @enderror"
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
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="reference_number" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Reference Number</label>
                            <input type="text" id="reference_number" name="reference_number"
                                   value="{{ old('reference_number', $transaction->reference_number) }}"
                                   placeholder="e.g., CHQ123456"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 h-[42px] @error('reference_number') border-red-500 @enderror">
                            @error('reference_number')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Description</label>
                            <textarea id="description" name="description" rows="3"
                                      class="form-textarea w-full rounded-xl border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('description') border-red-500 @enderror"
                                      required>{{ old('description', $transaction->description) }}</textarea>
                            @error('description')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="notes" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="2"
                                      class="form-textarea w-full rounded-xl border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('notes') border-red-500 @enderror">{{ old('notes', $transaction->notes) }}</textarea>
                            @error('notes')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Member Information -->
            <div class="card border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Member (Optional)</h3>
                </div>
                <div class="p-6">
                    <div>
                        <label for="member_id" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Select Member</label>
                        <select id="member_id" name="member_id"
                                class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('member_id') border-red-500 @enderror">
                            <option value="">Anonymous/No Member</option>
                            @if($transaction->member)
                            <option value="{{ $transaction->member->id }}" selected>{{ $transaction->member->full_name }}</option>
                            @endif
                        </select>
                        @error('member_id')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-slate-500 mt-1.5">Leave blank for anonymous donations or general expenses</p>
                    </div>
                </div>
            </div>

            <!-- Receipt Upload -->
            <div class="card border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Receipt/Document</h3>
                </div>
                <div class="p-6" x-data="{ fileName: '{{ $transaction->receipt_path ? basename($transaction->receipt_path) : '' }}' }">
                    @if($transaction->receipt_path)
                    <div class="mb-4 p-3 bg-secondary-50 border border-secondary-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 overflow-hidden">
                                <svg class="w-5 h-5 text-secondary-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div class="truncate">
                                    <div class="text-xs font-semibold text-secondary-900 uppercase">Current Receipt</div>
                                    <div class="text-xs text-secondary-700 truncate" title="{{ basename($transaction->receipt_path) }}">{{ basename($transaction->receipt_path) }}</div>
                                </div>
                            </div>
                            <a href="{{ Storage::url($transaction->receipt_path) }}" target="_blank"
                               class="text-secondary-600 hover:text-secondary-800 p-1 rounded hover:bg-secondary-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 mb-3 font-medium">Upload a new file to replace the current receipt</p>
                    @endif

                    <div class="flex items-center justify-center w-full">
                        <label for="receipt" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-lg cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-slate-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm text-slate-500" x-show="!fileName"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="mb-2 text-sm text-slate-700 font-medium truncate px-4 w-full text-center" x-show="fileName" x-text="fileName"></p>
                                <p class="text-xs text-slate-500">PDF, JPG, PNG (MAX. 2MB)</p>
                            </div>
                            <input id="receipt" name="receipt" type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png" @change="fileName = $event.target.files[0]?.name || ''" />
                        </label>
                    </div> 
                    @error('receipt')
                    <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="card border border-slate-100">
                <div class="p-6 space-y-3">
                    <button type="submit" class="btn btn-primary w-full shadow-lg shadow-primary-500/30">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Update Transaction
                    </button>
                    <a href="{{ route('transactions.show', $transaction) }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 w-full justify-center">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
