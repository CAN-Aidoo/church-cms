@extends('layouts.app')

@section('title', 'Partnership Agreements')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Agreements</h1>
            <p class="text-slate-500 mt-1">Contracts, MOUs, and formal commitments.</p>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('partnerships.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-all font-bold text-sm shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Dashboard
            </a>
            <button onclick="document.getElementById('createAgreementModal').classList.remove('hidden')" class="px-5 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all font-bold text-sm shadow-md hover:shadow-lg flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                New Agreement
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Content -->
    <div class="card border border-slate-100 shadow-sm overflow-hidden">
        <!-- Filter Toolbar -->
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex items-center gap-2 w-full md:w-auto">
                 <div class="relative w-full md:w-64">
                    <input type="text" placeholder="Search agreements..." class="form-input w-full pl-10 rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500 text-sm">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
            </div>
             <form method="GET" class="flex items-center gap-2 w-full md:w-auto">
                <select name="status" class="form-select rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                     <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                         <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Agreement Title</th>
                         <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Partner</th>
                         <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Duration</th>
                         <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                         <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 bg-white">
                    @forelse($agreements as $agreement)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-800">{{ $agreement->agreement_title }}</div>
                                        <div class="text-xs text-slate-400">Ref: #{{ $agreement->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-slate-700">{{ $agreement->partner->name }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-600">
                                    {{ $agreement->start_date->format('M Y') }} 
                                    <span class="text-slate-400 mx-1">→</span> 
                                    {{ $agreement->end_date ? $agreement->end_date->format('M Y') : 'Indefinite' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                 <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold capitalize
                                    {{ $agreement->status === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : '' }}
                                    {{ $agreement->status === 'expired' ? 'bg-rose-50 text-rose-700 border border-rose-100' : '' }}
                                    {{ $agreement->status === 'pending' ? 'bg-amber-50 text-amber-700 border border-amber-100' : '' }}">
                                    @if($agreement->status === 'active') <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> @endif
                                    {{ $agreement->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($agreement->status === 'pending')
                                        <form action="{{ route('partnerships.activate-agreement', $agreement) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-xs font-bold text-emerald-600 hover:text-emerald-800 hover:underline px-2 py-1">Activate</button>
                                        </form>
                                    @endif
                                    <!-- View -->
                                    <a href="{{ route('partnerships.agreements.show', $agreement) }}" class="text-slate-400 hover:text-primary-600 transition-colors" title="View">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <!-- Edit -->
                                    @if(in_array($agreement->status, ['draft', 'pending']))
                                    <a href="{{ route('partnerships.agreements.edit', $agreement) }}" class="text-slate-400 hover:text-primary-600 transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    @endif
                                    <!-- Delete -->
                                    @if(in_array($agreement->status, ['expired', 'completed']))
                                    <form action="{{ route('partnerships.agreements.destroy', $agreement) }}" method="POST" class="inline" onsubmit="return confirm('Delete this agreement? This action cannot be undone.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                </div>
                                <p class="text-sm font-medium text-slate-500">No agreements found.</p>
                                <p class="text-xs text-slate-400 mt-1">Start a new partnership agreement.</p>
                                <button onclick="document.getElementById('createAgreementModal').classList.remove('hidden')" class="mt-4 px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 font-medium text-sm transition-colors">
                                    Create Agreement
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($agreements->hasPages())
        <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/30">
            {{ $agreements->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Create Agreement Modal -->
<div id="createAgreementModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
            <h3 class="font-bold text-lg text-slate-800">New Agreement</h3>
             <button onclick="document.getElementById('createAgreementModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        
        <form action="{{ route('partnerships.store-agreement') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Partner <span class="text-rose-500">*</span></label>
                     <select name="partner_id" required class="form-select w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                        <option value="">Select Partner</option>
                        @foreach(\App\Models\Partner::all() as $partner)
                            <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                        @endforeach
                     </select>
                </div>
                 <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Agreement Title <span class="text-rose-500">*</span></label>
                     <input type="text" name="agreement_title" placeholder="e.g. Joint Mission Project 2025" required class="form-input w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500 font-semibold text-slate-800">
                </div>
                 <div class="grid grid-cols-2 gap-4">
                    <div>
                         <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Start Date <span class="text-rose-500">*</span></label>
                         <input type="date" name="start_date" required class="form-input w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                         <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">End Date</label>
                         <input type="date" name="end_date" class="form-input w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>
                 <div>
                     <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Financial Commitment (Optional)</label>
                     <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" name="financial_commitment" step="0.01" class="form-input w-full pl-7 rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                     </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                 <button type="button" onclick="document.getElementById('createAgreementModal').classList.add('hidden')" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 font-bold text-sm hover:bg-slate-50">Cancel</button>
                 <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 font-bold text-sm shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Create Agreement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
