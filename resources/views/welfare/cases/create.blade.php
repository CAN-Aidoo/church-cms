@extends('layouts.app')

@section('title', 'Submit Welfare Case')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Header -->
    <div class="flex items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">New Welfare Case</h1>
            <p class="text-slate-600">Submit a new assistance request for a member or beneficiary.</p>
        </div>
        <a href="{{ route('welfare.cases') }}" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-all font-medium text-sm shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to List
        </a>
    </div>

    <form action="{{ route('welfare.cases.store') }}" method="POST">
        @csrf
        
        <!-- Beneficiary Information -->
        <div class="card border border-slate-100 shadow-sm mb-6 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Beneficiary Information
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">
                            Link to Member (Optional)
                            <span class="text-slate-400 font-normal normal-case ml-1 float-right">Enter Member ID to auto-fill</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </span>
                            <input type="number" name="beneficiary_id" class="form-input pl-10 w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500 placeholder-slate-400" placeholder="Search by Member ID..." value="{{ $member ? $member->id : '' }}">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Full Name</label>
                        <input type="text" name="beneficiary_name" class="form-input w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500" required value="{{ $member ? $member->full_name : '' }}" placeholder="Beneficiary's full name">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Phone Number</label>
                        <input type="tel" name="beneficiary_phone" class="form-input w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500" value="{{ $member ? $member->phone : '' }}" placeholder="e.g. +233...">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Email Address</label>
                        <input type="email" name="beneficiary_email" class="form-input w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500" value="{{ $member ? $member->email : '' }}" placeholder="email@example.com">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Residential Address</label>
                        <input type="text" name="address" class="form-input w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500" value="{{ $member ? $member->address : '' }}" placeholder="House No, Street Name...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Case Details -->
        <div class="card border border-slate-100 shadow-sm mb-6 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Case Details
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Case Title</label>
                        <input type="text" name="case_title" class="form-input w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500 font-medium" required placeholder="e.g. Emergency Surgery Assistance for Mrs. Mensah">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Category</label>
                        <select name="case_category" class="form-select w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500" required>
                            <option value="">Select Category</option>
                            @foreach($categories ?? [] as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                            <!-- Fallback options if variable not passed, though controller passed it -->
                            @if(empty($categories))
                                <option value="medical">Medical</option>
                                <option value="education">Education</option>
                                <option value="housing">Housing</option>
                                <option value="food">Food</option>
                                <option value="emergency">Emergency</option>
                                <option value="bereavement">Bereavement</option>
                                <option value="job_loss">Job Loss</option>
                                <option value="other">Other</option>
                            @endif
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Priority Level</label>
                        <select name="priority" class="form-select w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500" required>
                            <option value="low">Low - Routine assistance</option>
                            <option value="medium" selected>Medium - Standard urgency</option>
                            <option value="high">High - Urgent attention needed</option>
                            <option value="critical">Critical - Immediate action required</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Amount Requested (GHS)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500 font-bold">₵</span>
                            <input type="number" name="amount_requested" step="0.01" class="form-input pl-8 w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500 font-medium" placeholder="0.00">
                        </div>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Detailed Description</label>
                        <textarea name="case_description" rows="5" class="form-textarea w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500" required placeholder="Provide full details about the situation, need, and background context..."></textarea>
                        <p class="text-xs text-slate-400 mt-1 text-right">Please provide as much detail as possible to aid the review process.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('welfare.cases') }}" class="px-6 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-all font-bold text-sm">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all font-bold text-sm shadow-md hover:shadow-lg transform active:scale-95">
                Submit Case
            </button>
        </div>
    </form>
</div>
@endsection
