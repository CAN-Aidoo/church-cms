@extends('layouts.app')

@section('title', 'Welfare Fund Transactions')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Fund Transactions</h1>
            <p class="text-slate-600">Track collections, disbursements, and fund adjustments.</p>
        </div>
        <button onclick="document.getElementById('newTransactionModal').classList.toggle('hidden')" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-all font-bold text-sm shadow-sm group">
            <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Record Transaction
        </button>
    </div>

    <!-- Balance Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card p-6 border border-emerald-100 shadow-sm bg-gradient-to-br from-emerald-600 to-emerald-700 text-white relative overflow-hidden group col-span-1 md:col-start-2">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
            <div class="relative z-10 text-center">
                <p class="text-emerald-100 text-sm font-bold uppercase tracking-wide mb-1">Current Fund Balance</p>
                <h3 class="text-4xl font-extrabold mb-2">GHS {{ number_format($balance ?? 0, 2) }}</h3>
                <p class="text-xs text-emerald-100/80">Available for disbursement</p>
            </div>
        </div>
    </div>

    <!-- Transactions List -->
    <div class="card border border-slate-100 shadow-sm">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
             <h3 class="font-bold text-slate-800 text-base">Transaction History</h3>
             
             <!-- Simple Filters -->
             <form action="{{ route('welfare.fund-transactions') }}" method="GET" class="flex gap-2">
                <select name="type" class="form-select rounded-lg border-slate-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="">All Types</option>
                    <option value="collection" {{ request('type') == 'collection' ? 'selected' : '' }}>Collections</option>
                    <option value="disbursement" {{ request('type') == 'disbursement' ? 'selected' : '' }}>Disbursements</option>
                </select>
                <button type="submit" class="px-3 py-2 bg-slate-800 text-white rounded-lg text-sm font-bold hover:bg-slate-700 transition">Filter</button>
             </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Transaction Details</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4 text-right">Amount</th>
                        <th class="px-6 py-4">Reference</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transactions as $txn)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-slate-600 font-medium">
                            {{ $txn->transaction_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-slate-800 mb-0.5">{{ $txn->category ?? 'General' }}</div>
                            <div class="text-xs text-slate-500">{{ $txn->description }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide
                                {{ $txn->type === 'collection' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 
                                  ($txn->type === 'disbursement' ? 'bg-rose-50 text-rose-700 border border-rose-100' : 'bg-slate-50 text-slate-600 border border-slate-100') }}">
                                {{ ucfirst($txn->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-sm font-bold {{ $txn->type === 'collection' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $txn->type === 'collection' ? '+' : '-' }} GHS {{ number_format($txn->amount, 2) }}
                            </span>
                        </td>
                         <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $txn->reference_number ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                         <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            No transactions recorded yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $transactions->links() }}
        </div>
    </div>
</div>

<!-- Simple Modal for New Transaction -->
<div id="newTransactionModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="font-bold text-lg text-slate-800">Record New Transaction</h3>
            <button onclick="document.getElementById('newTransactionModal').classList.toggle('hidden')" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form action="{{ route('welfare.transactions.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Transaction Type</label>
                    <select name="type" class="form-select w-full rounded-lg border-slate-200 text-sm">
                        <option value="collection">Collection (Income)</option>
                        <option value="disbursement">Disbursement (Expense)</option>
                        <option value="adjustment">Adjustment</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Amount (GHS)</label>
                        <input type="number" name="amount" step="0.01" class="form-input w-full rounded-lg border-slate-200 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Date</label>
                        <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" class="form-input w-full rounded-lg border-slate-200 text-sm" required>
                    </div>
                </div>

                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Category</label>
                    <input type="text" name="category" placeholder="e.g. Sunday Offering, Medical Aid" class="form-input w-full rounded-lg border-slate-200 text-sm" required>
                </div>

                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Description</label>
                    <textarea name="description" rows="2" class="form-textarea w-full rounded-lg border-slate-200 text-sm" required></textarea>
                </div>
                
                 <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Reference (Optional)</label>
                    <input type="text" name="reference_number" placeholder="Cheque No, Receipt No..." class="form-input w-full rounded-lg border-slate-200 text-sm">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('newTransactionModal').classList.toggle('hidden')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 font-bold text-sm">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-bold text-sm shadow-sm">Save Transaction</button>
            </div>
        </form>
    </div>
</div>
@endsection
