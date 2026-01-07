@extends('layouts.app')

@section('title', 'Mark Attendance')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Mark Single Attendance</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('attendance.index') }}" class="hover:text-primary-600 transition-colors">Attendance</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Create</span>
        </nav>
    </div>
</div>

<form action="{{ route('attendance.store') }}" method="POST" class="max-w-3xl mx-auto">
    @csrf

    <div class="card border border-slate-100">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Attendance Details</h3>
        </div>
        <div class="p-6 space-y-6">
            <div>
                <label for="member_id" class="form-label required mb-1.5 block font-medium text-sm text-slate-700">Member</label>
                @if($member)
                    <input type="hidden" name="member_id" value="{{ $member->id }}">
                    <input type="text" value="{{ $member->full_name }} ({{ $member->member_id }})" 
                           class="form-input w-full bg-slate-50 text-slate-500 cursor-not-allowed" readonly>
                @else
                    <select id="member_id" name="member_id" 
                            class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('member_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" 
                            required>
                        <option value="">Select Member</option>
                        @foreach(\App\Models\Member::active()->orderBy('first_name')->get() as $m)
                            <option value="{{ $m->id }}" {{ old('member_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->full_name }} - {{ $m->member_id }}
                            </option>
                        @endforeach
                    </select>
                @endif
                @error('member_id')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="service_date" class="form-label required mb-1.5 block font-medium text-sm text-slate-700">Service Date</label>
                    <input type="date" id="service_date" name="service_date"
                           value="{{ old('service_date', now()->format('Y-m-d')) }}"
                           class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('service_date') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                           required>
                    @error('service_date')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="service_type" class="form-label required mb-1.5 block font-medium text-sm text-slate-700">Service Type</label>
                    <select id="service_type" name="service_type"
                            class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('service_type') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                            required>
                        <option value="sunday_first" {{ old('service_type') == 'sunday_first' ? 'selected' : '' }}>Sunday First Service</option>
                        <option value="sunday_second" {{ old('service_type') == 'sunday_second' ? 'selected' : '' }}>Sunday Second Service</option>
                        <option value="midweek" {{ old('service_type') == 'midweek' ? 'selected' : '' }}>Midweek Service</option>
                        <option value="prayer_meeting" {{ old('service_type') == 'prayer_meeting' ? 'selected' : '' }}>Prayer Meeting</option>
                        <option value="special" {{ old('service_type') == 'special' ? 'selected' : '' }}>Special Service</option>
                    </select>
                    @error('service_type')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="status" class="form-label required mb-1.5 block font-medium text-sm text-slate-700">Status</label>
                <select id="status" name="status"
                        class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('status') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        required>
                    <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>Present</option>
                    <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                    <option value="excused" {{ old('status') == 'excused' ? 'selected' : '' }}>Excused</option>
                    <option value="late" {{ old('status') == 'late' ? 'selected' : '' }}>Late</option>
                </select>
                @error('status')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="notes" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Notes</label>
                <textarea id="notes" name="notes" rows="3"
                          class="form-textarea w-full rounded-xl border-slate-200 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('notes') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                          placeholder="Optional notes about this attendance record...">{{ old('notes') }}</textarea>
                @error('notes')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('attendance.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Mark Attendance
            </button>
        </div>
    </div>
</form>
@endsection
