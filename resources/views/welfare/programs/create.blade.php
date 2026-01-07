@extends('layouts.app')

@section('title', 'Create Welfare Program')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <!-- Header -->
    <div class="flex items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Create New Program</h1>
            <p class="text-slate-600">Establish a new welfare service or initiative.</p>
        </div>
        <a href="{{ route('welfare.programs') }}" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-all font-medium text-sm shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to List
        </a>
    </div>

    <form action="{{ route('welfare.programs.store') }}" method="POST">
        @csrf
        <div class="card border border-slate-100 shadow-sm overflow-hidden">
             <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Program Details</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Program Name</label>
                        <input type="text" name="program_name" class="form-input w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500 font-medium" required placeholder="e.g. Annual Widows Support">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Program Type</label>
                        <select name="program_type" class="form-select w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500" required>
                             <option value="">Select Type</option>
                            @foreach($programTypes ?? [] as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                            @if(empty($programTypes))
                                <option value="widows_orphans">Widows & Orphans</option>
                                <option value="elderly_care">Elderly Care</option>
                                <option value="scholarships">Scholarships</option>
                                <option value="medical_assistance">Medical Assistance</option>
                                <option value="food_bank">Food Bank</option>
                                <option value="disaster_relief">Disaster Relief</option>
                                <option value="other">Other</option>
                            @endif
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Budget Allocated (GHS)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500 font-bold">₵</span>
                            <input type="number" name="budget_allocated" step="0.01" class="form-input pl-8 w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500" placeholder="0.00">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Start Date</label>
                        <input type="date" name="start_date" class="form-input w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">End Date</label>
                        <input type="date" name="end_date" class="form-input w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Coordinator (User ID)</label>
                        <input type="number" name="coordinator_id" class="form-input w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500" required placeholder="User ID of the program lead">
                        <!-- Ideally this would be a select dropdown of users, but sticking to ID as per previous code unless I fetch users -->
                    </div>

                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Description</label>
                        <textarea name="description" rows="4" class="form-textarea w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Objectives and details of the program..."></textarea>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex justify-end gap-3">
                <a href="{{ route('welfare.programs') }}" class="px-6 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-all font-bold text-sm">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all font-bold text-sm shadow-md hover:shadow-lg transform active:scale-95">
                    Create Program
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
