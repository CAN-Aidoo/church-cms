@extends('layouts.app')

@section('title', 'Record Visitation')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Record Visitation</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('shepherds.index') }}" class="hover:text-primary-600 transition-colors">Shepherds</a>
            <span>/</span>
            <a href="{{ route('shepherds.show', $shepherd) }}" class="hover:text-primary-600 transition-colors">{{ $shepherd->flock_name }}</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Record Visitation</span>
        </nav>
    </div>
</div>

<form method="POST" action="{{ route('shepherds.store-visitation', $shepherd) }}" class="max-w-5xl mx-auto">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Member Selection -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Member Information</h3>
                </div>
                <div class="p-6">
                    <label for="member_id" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Member Visited</label>
                    <select name="member_id"
                            id="member_id"
                            required
                            class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('member_id') border-red-500 @enderror">
                        <option value="">Select a member...</option>
                        @foreach($flockMembers as $member)
                        <option value="{{ $member->id }}" {{ old('member_id', request('member_id')) == $member->id ? 'selected' : '' }}>
                            {{ $member->full_name }} - {{ $member->phone }}
                        </option>
                        @endforeach
                    </select>
                    @error('member_id')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Visit Details -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Visit Details</h3>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Visit Date -->
                        <div>
                            <label for="visit_date" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Visit Date</label>
                            <input type="date"
                                   name="visit_date"
                                   id="visit_date"
                                   value="{{ old('visit_date', date('Y-m-d')) }}"
                                   required
                                   max="{{ date('Y-m-d') }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('visit_date') border-red-500 @enderror">
                            @error('visit_date')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Visit Time -->
                        <div>
                            <label for="visit_time" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Visit Time (Optional)</label>
                            <input type="time"
                                   name="visit_time"
                                   id="visit_time"
                                   value="{{ old('visit_time') }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('visit_time') border-red-500 @enderror">
                            @error('visit_time')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Visit Type -->
                        <div>
                            <label for="visit_type" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Visit Type</label>
                            <select name="visit_type"
                                    id="visit_type"
                                    required
                                    class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('visit_type') border-red-500 @enderror">
                                <option value="">Select type...</option>
                                <option value="home_visit" {{ old('visit_type') == 'home_visit' ? 'selected' : '' }}>Home Visit</option>
                                <option value="hospital_visit" {{ old('visit_type') == 'hospital_visit' ? 'selected' : '' }}>Hospital Visit</option>
                                <option value="phone_call" {{ old('visit_type') == 'phone_call' ? 'selected' : '' }}>Phone Call</option>
                                <option value="counseling" {{ old('visit_type') == 'counseling' ? 'selected' : '' }}>Counseling</option>
                                <option value="follow_up" {{ old('visit_type') == 'follow_up' ? 'selected' : '' }}>Follow Up</option>
                                <option value="other" {{ old('visit_type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('visit_type')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Visit Reason -->
                        <div>
                            <label for="visit_reason" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Visit Reason</label>
                            <select name="visit_reason"
                                    id="visit_reason"
                                    required
                                    class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('visit_reason') border-red-500 @enderror">
                                <option value="">Select reason...</option>
                                <option value="routine" {{ old('visit_reason') == 'routine' ? 'selected' : '' }}>Routine Visit</option>
                                <option value="pastoral_care" {{ old('visit_reason') == 'pastoral_care' ? 'selected' : '' }}>Pastoral Care</option>
                                <option value="crisis" {{ old('visit_reason') == 'crisis' ? 'selected' : '' }}>Crisis</option>
                                <option value="new_member" {{ old('visit_reason') == 'new_member' ? 'selected' : '' }}>New Member</option>
                                <option value="inactive_member" {{ old('visit_reason') == 'inactive_member' ? 'selected' : '' }}>Inactive Member</option>
                                <option value="other" {{ old('visit_reason') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('visit_reason')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Visit Notes -->
                    <div>
                        <label for="notes" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Visit Notes</label>
                        <textarea name="notes"
                                  id="notes"
                                  rows="4"
                                  required
                                  class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl @error('notes') border-red-500 @enderror"
                                  placeholder="Describe what was discussed, member's wellbeing, any concerns...">{{ old('notes') }}</textarea>
                        @error('notes')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prayer Requests -->
                    <div>
                        <label for="prayer_requests" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Prayer Requests</label>
                        <textarea name="prayer_requests"
                                  id="prayer_requests"
                                  rows="3"
                                  class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl @error('prayer_requests') border-red-500 @enderror"
                                  placeholder="Any prayer requests from the member...">{{ old('prayer_requests') }}</textarea>
                        @error('prayer_requests')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Items -->
                    <div>
                        <label for="action_items" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Action Items</label>
                        <textarea name="action_items"
                                  id="action_items"
                                  rows="3"
                                  class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl @error('action_items') border-red-500 @enderror"
                                  placeholder="Follow-up actions, referrals, or next steps...">{{ old('action_items') }}</textarea>
                        @error('action_items')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Follow-up Date -->
                    <div>
                        <label for="follow_up_date" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Follow-up Date (Optional)</label>
                        <input type="date"
                               name="follow_up_date"
                               id="follow_up_date"
                               value="{{ old('follow_up_date') }}"
                               min="{{ date('Y-m-d') }}"
                               class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('follow_up_date') border-red-500 @enderror">
                        @error('follow_up_date')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-slate-500 mt-1">Set a date if this visit requires follow-up</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Guidelines Card -->
            <div class="card p-6 border-l-4 border-l-blue-500 bg-blue-50/50 border-y border-r border-blue-100">
                <div class="flex items-start gap-4">
                    <div class="p-2 bg-blue-100 text-blue-600 rounded-lg flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-blue-900 text-lg mb-2">Visitation Guide</h4>
                        <ul class="text-sm text-blue-800 space-y-2 list-none">
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Be punctual and respectful of time</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Listen actively and show empathy</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Offer prayer at the end of the visit</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Keep confidences shared during the visit</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="p-6 space-y-3">
                    <button type="submit" class="btn btn-primary w-full shadow-lg shadow-primary-500/30">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 1m0-1l1-3m-1 3l-1-3m1 3l1 3m1-3l2 1"></path></svg>
                        Record Visitation
                    </button>
                    <a href="{{ route('shepherds.visitations', $shepherd) }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 w-full justify-center">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
