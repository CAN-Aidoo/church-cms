@extends('layouts.app')

@section('title', 'Case Details')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Header -->
    <div class="flex items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-3">
             <a href="{{ route('welfare.cases') }}" class="p-2 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-slate-50 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                    Case #{{ $case->case_number ?? $case->id }}
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide border
                        {{ $case->status === 'approved' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 
                          ($case->status === 'rejected' ? 'bg-rose-50 text-rose-700 border-rose-100' : 
                          ($case->status === 'closed' ? 'bg-slate-100 text-slate-600 border-slate-200' : 
                          ($case->status === 'under_review' ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-slate-50 text-slate-600 border-slate-200'))) }}">
                        {{ ucfirst(str_replace('_', ' ', $case->status)) }}
                    </span>
                </h1>
                <p class="text-slate-600 text-sm">Submitted on {{ $case->created_at->format('M d, Y') }}</p>
            </div>
        </div>
        
        <div class="flex gap-2">
            @if(auth()->user()->hasAnyRole(['admin', 'pastor']) && !in_array($case->status, ['rejected', 'closed']))
                 <form action="{{ route('welfare.cases.close', $case) }}" method="POST" onsubmit="return confirm('Are you sure you want to close this case?');">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-all font-bold text-sm shadow-sm">
                        Close Case
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Case Information -->
            <div class="card border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-xl font-bold text-slate-800">{{ $case->case_title }}</h2>
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wide border
                            {{ $case->priority === 'critical' ? 'bg-rose-50 text-rose-700 border-rose-100' : 
                              ($case->priority === 'high' ? 'bg-orange-50 text-orange-700 border-orange-100' : 
                              ($case->priority === 'medium' ? 'bg-blue-50 text-blue-700 border-blue-100' : 'bg-slate-100 text-slate-600 border-slate-200')) }}">
                            {{ ucfirst($case->priority) }} Priority
                        </span>
                    </div>

                    <div class="prose max-w-none text-slate-600 mb-8 leading-relaxed">
                        {!! nl2br(e($case->case_description)) !!}
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 pt-6 border-t border-slate-100">
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Category</span>
                            <span class="block text-sm font-semibold text-slate-700 bg-slate-50 px-2 py-1 rounded w-fit border border-slate-100 capitalize">
                                {{ str_replace('_', ' ', $case->case_category) }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Requested Amount</span>
                            <span class="block text-sm font-bold text-slate-800">GHS {{ number_format($case->amount_requested, 2) }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Approved Amount</span>
                            <span class="block text-sm font-bold {{ $case->amount_approved ? 'text-emerald-600' : 'text-slate-400 italic' }}">
                                {{ $case->amount_approved ? 'GHS ' . number_format($case->amount_approved, 2) : 'Pending Approval' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Administrative Actions -->
            @if(auth()->user()->hasAnyRole(['admin', 'pastor']))
            <div class="card border border-primary-100 shadow-sm bg-gradient-to-b from-white to-primary-50/20 overflow-hidden">
                <div class="px-6 py-4 border-b border-primary-100/50 bg-primary-50/30">
                    <h3 class="font-bold text-slate-800 text-base">Administrative Actions</h3>
                </div>
                <div class="p-6">
                    @if($case->status === 'submitted')
                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-blue-800 text-sm">Initial Review</h4>
                                <p class="text-xs text-blue-600 mt-1">Move this case to "Under Review" to start processing.</p>
                            </div>
                            <form action="{{ route('welfare.cases.under-review', $case) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-bold shadow-sm">
                                    Start Review
                                </button>
                            </form>
                        </div>
                    @endif

                    @if($case->status === 'under_review')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Approve -->
                            <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-5">
                                <h4 class="font-bold text-emerald-800 text-sm mb-3">Approve Assistance</h4>
                                <form action="{{ route('welfare.cases.approve', $case) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wide mb-1">Approved Amount (GHS)</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-emerald-600 font-bold">₵</span>
                                            <input type="number" name="amount_approved" value="{{ $case->amount_requested }}" step="0.01" class="form-input pl-7 w-full rounded-lg border-emerald-200 text-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wide mb-1">Notes (Optional)</label>
                                        <textarea name="approval_notes" rows="2" class="form-textarea w-full rounded-lg border-emerald-200 text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Approval comments..."></textarea>
                                    </div>
                                    <button type="submit" class="w-full px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors text-sm font-bold shadow-sm">
                                        Approve Case
                                    </button>
                                </form>
                            </div>

                            <!-- Reject -->
                            <div class="bg-rose-50 border border-rose-100 rounded-xl p-5">
                                <h4 class="font-bold text-rose-800 text-sm mb-3">Reject Request</h4>
                                <form action="{{ route('welfare.cases.reject', $case) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="block text-xs font-bold text-rose-700 uppercase tracking-wide mb-1">Reason for Rejection</label>
                                        <textarea name="rejection_reason" rows="3" class="form-textarea w-full rounded-lg border-rose-200 text-sm focus:border-rose-500 focus:ring-rose-500" required placeholder="Reason is required..."></textarea>
                                    </div>
                                     <button type="submit" class="w-full px-4 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition-colors text-sm font-bold shadow-sm">
                                        Reject Case
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                    
                    @if(in_array($case->status, ['approved', 'rejected', 'closed']))
                        <div class="text-center p-4 bg-slate-50 border border-slate-100 rounded-lg">
                            <p class="text-slate-500 text-sm">Review process completed for this case.</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Beneficiary Card -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-5 py-3 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wide">Beneficiary Details</h3>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 font-bold text-lg">
                            {{ substr($case->beneficiary_name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">{{ $case->beneficiary_name }}</p>
                            <p class="text-xs text-slate-500">Beneficiary</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-start gap-3 text-sm">
                            <svg class="w-4 h-4 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                             <span class="text-slate-600">{{ $case->beneficiary_phone ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-start gap-3 text-sm">
                            <svg class="w-4 h-4 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            <span class="text-slate-600 break-all">{{ $case->beneficiary_email ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-start gap-3 text-sm">
                            <svg class="w-4 h-4 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <span class="text-slate-600">{{ $case->address ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-5 py-3 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wide">Activity Timeline</h3>
                </div>
                <div class="p-5">
                    <div class="relative space-y-6 before:absolute before:inset-0 before:ml-2 before:h-full before:w-0.5 before:bg-slate-100">
                        <div class="relative flex gap-4">
                            <div class="absolute -left-1 rounded-full border-2 border-white bg-blue-500 w-3 h-3 mt-1.5 shadow-sm"></div>
                            <div>
                                <p class="text-xs font-bold text-slate-500 uppercase">Submitted</p>
                                <p class="text-sm font-medium text-slate-800">Case Created</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $case->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>

                         @if($case->verified_at)
                        <div class="relative flex gap-4">
                            <div class="absolute -left-1 rounded-full border-2 border-white bg-amber-500 w-3 h-3 mt-1.5 shadow-sm"></div>
                            <div>
                                <p class="text-xs font-bold text-slate-500 uppercase">Verification</p>
                                <p class="text-sm font-medium text-slate-800">Verified by {{ $case->verifiedBy->name ?? 'Staff' }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $case->verified_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($case->approved_at)
                         <div class="relative flex gap-4">
                            <div class="absolute -left-1 rounded-full border-2 border-white bg-emerald-500 w-3 h-3 mt-1.5 shadow-sm"></div>
                            <div>
                                <p class="text-xs font-bold text-slate-500 uppercase">Approval</p>
                                <p class="text-sm font-medium text-slate-800">Approved by {{ $case->approvedBy->name ?? 'Admin' }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $case->approved_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($case->status === 'rejected')
                         <div class="relative flex gap-4">
                            <div class="absolute -left-1 rounded-full border-2 border-white bg-rose-500 w-3 h-3 mt-1.5 shadow-sm"></div>
                            <div>
                                <p class="text-xs font-bold text-slate-500 uppercase">Rejection</p>
                                <p class="text-sm font-medium text-slate-800">Rejected</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $case->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
