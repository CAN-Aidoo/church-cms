@extends('layouts.app')

@section('title', 'Record Transaction')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Record Transaction</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('transactions.index') }}" class="hover:text-primary-600 transition-colors">Transactions</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Record</span>
        </nav>
    </div>
</div>

<form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data" class="max-w-5xl mx-auto"
      x-data="{ 
          type: '{{ old('transaction_type', '') }}',
          init() {
              if (this.type) this.$nextTick(() => this.updateCategories());
          },
          updateCategories() {
              // Logic handled by x-show/x-if in view or CSS, but for select optgroups, we need JS to toggle visibility
              // Since optgroup visibility isn't standardized across browsers, disabling them or cloning options is better.
              // However, simpler approach: Hide/Show groups via style if supported, or just let user see all.
              // The original script toggled display:none.
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
          }
      }">
    @csrf

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
                                   value="{{ old('transaction_date', date('Y-m-d')) }}"
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
                                    required x-model="type" @change="updateCategories">
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
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="amount" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Amount (GHS)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 font-medium">GHS</span>
                                <input type="number" id="amount" name="amount"
                                       value="{{ old('amount') }}"
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
                                <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="cheque" {{ old('payment_method') === 'cheque' ? 'selected' : '' }}>Cheque</option>
                                <option value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="mobile_money" {{ old('payment_method') === 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                                <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>Card</option>
                                <option value="other" {{ old('payment_method') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('payment_method')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="reference_number" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Reference Number</label>
                            <input type="text" id="reference_number" name="reference_number"
                                   value="{{ old('reference_number') }}"
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
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="notes" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="2"
                                      class="form-textarea w-full rounded-xl border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
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
                            @if($member ?? false)
                            <option value="{{ $member->id }}" selected>{{ $member->full_name }}</option>
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
                <div class="p-6" x-data="{ fileName: '' }">
                    <div class="flex items-center justify-center w-full">
                        <label for="receipt" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-lg cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-slate-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm text-slate-500" x-show="!fileName"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="mb-2 text-sm text-slate-700 font-medium" x-show="fileName" x-text="fileName"></p>
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
                        Record Transaction
                    </button>
                    <a href="{{ route('transactions.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 w-full justify-center">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
