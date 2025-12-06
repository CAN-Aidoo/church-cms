@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('shepherds.visitations', $shepherd) }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Record Visitation</h1>
        </div>
        <p class="text-gray-600">{{ $shepherd->flock_name }} - {{ $shepherd->full_name }}</p>
    </div>

    <div class="max-w-3xl">
        <form method="POST" action="{{ route('shepherds.store-visitation', $shepherd) }}" class="space-y-6">
            @csrf

            <!-- Member Selection -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Member Information</h2>
                </div>
                <div class="card-body space-y-4">
                    <div>
                        <label for="member_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Member Visited <span class="text-red-500">*</span>
                        </label>
                        <select name="member_id"
                                id="member_id"
                                required
                                class="form-select w-full @error('member_id') border-red-500 @enderror">
                            <option value="">Select a member...</option>
                            @foreach($flockMembers as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->full_name }} - {{ $member->phone }}
                            </option>
                            @endforeach
                        </select>
                        @error('member_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Visit Details -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Visit Details</h2>
                </div>
                <div class="card-body space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Visit Date -->
                        <div>
                            <label for="visit_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Visit Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                   name="visit_date"
                                   id="visit_date"
                                   value="{{ old('visit_date', date('Y-m-d')) }}"
                                   required
                                   max="{{ date('Y-m-d') }}"
                                   class="form-input w-full @error('visit_date') border-red-500 @enderror">
                            @error('visit_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Visit Time -->
                        <div>
                            <label for="visit_time" class="block text-sm font-medium text-gray-700 mb-1">
                                Visit Time (Optional)
                            </label>
                            <input type="time"
                                   name="visit_time"
                                   id="visit_time"
                                   value="{{ old('visit_time') }}"
                                   class="form-input w-full @error('visit_time') border-red-500 @enderror">
                            @error('visit_time')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Visit Type -->
                        <div>
                            <label for="visit_type" class="block text-sm font-medium text-gray-700 mb-1">
                                Visit Type <span class="text-red-500">*</span>
                            </label>
                            <select name="visit_type"
                                    id="visit_type"
                                    required
                                    class="form-select w-full @error('visit_type') border-red-500 @enderror">
                                <option value="">Select type...</option>
                                <option value="home_visit" {{ old('visit_type') == 'home_visit' ? 'selected' : '' }}>Home Visit</option>
                                <option value="hospital_visit" {{ old('visit_type') == 'hospital_visit' ? 'selected' : '' }}>Hospital Visit</option>
                                <option value="phone_call" {{ old('visit_type') == 'phone_call' ? 'selected' : '' }}>Phone Call</option>
                                <option value="counseling" {{ old('visit_type') == 'counseling' ? 'selected' : '' }}>Counseling</option>
                                <option value="follow_up" {{ old('visit_type') == 'follow_up' ? 'selected' : '' }}>Follow Up</option>
                                <option value="other" {{ old('visit_type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('visit_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Visit Reason -->
                        <div>
                            <label for="visit_reason" class="block text-sm font-medium text-gray-700 mb-1">
                                Visit Reason <span class="text-red-500">*</span>
                            </label>
                            <select name="visit_reason"
                                    id="visit_reason"
                                    required
                                    class="form-select w-full @error('visit_reason') border-red-500 @enderror">
                                <option value="">Select reason...</option>
                                <option value="routine" {{ old('visit_reason') == 'routine' ? 'selected' : '' }}>Routine Visit</option>
                                <option value="pastoral_care" {{ old('visit_reason') == 'pastoral_care' ? 'selected' : '' }}>Pastoral Care</option>
                                <option value="crisis" {{ old('visit_reason') == 'crisis' ? 'selected' : '' }}>Crisis</option>
                                <option value="new_member" {{ old('visit_reason') == 'new_member' ? 'selected' : '' }}>New Member</option>
                                <option value="inactive_member" {{ old('visit_reason') == 'inactive_member' ? 'selected' : '' }}>Inactive Member</option>
                                <option value="other" {{ old('visit_reason') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('visit_reason')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Visit Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                            Visit Notes <span class="text-red-500">*</span>
                        </label>
                        <textarea name="notes"
                                  id="notes"
                                  rows="4"
                                  required
                                  class="form-textarea w-full @error('notes') border-red-500 @enderror"
                                  placeholder="Describe what was discussed, member's wellbeing, any concerns...">{{ old('notes') }}</textarea>
                        @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prayer Requests -->
                    <div>
                        <label for="prayer_requests" class="block text-sm font-medium text-gray-700 mb-1">
                            Prayer Requests
                        </label>
                        <textarea name="prayer_requests"
                                  id="prayer_requests"
                                  rows="3"
                                  class="form-textarea w-full @error('prayer_requests') border-red-500 @enderror"
                                  placeholder="Any prayer requests from the member...">{{ old('prayer_requests') }}</textarea>
                        @error('prayer_requests')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Items -->
                    <div>
                        <label for="action_items" class="block text-sm font-medium text-gray-700 mb-1">
                            Action Items
                        </label>
                        <textarea name="action_items"
                                  id="action_items"
                                  rows="3"
                                  class="form-textarea w-full @error('action_items') border-red-500 @enderror"
                                  placeholder="Follow-up actions, referrals, or next steps...">{{ old('action_items') }}</textarea>
                        @error('action_items')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Follow-up Date -->
                    <div>
                        <label for="follow_up_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Follow-up Date (Optional)
                        </label>
                        <input type="date"
                               name="follow_up_date"
                               id="follow_up_date"
                               value="{{ old('follow_up_date') }}"
                               min="{{ date('Y-m-d') }}"
                               class="form-input w-full @error('follow_up_date') border-red-500 @enderror">
                        @error('follow_up_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Set a date if this visit requires follow-up</p>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('shepherds.visitations', $shepherd) }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Record Visitation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
