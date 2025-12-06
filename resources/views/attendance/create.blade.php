@extends('layouts.app')

@section('title', 'Mark Attendance')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Mark Single Attendance</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('attendance.index') }}">Attendance</a>
            <span>/</span>
            <span>Create</span>
        </nav>
    </div>
</div>

<form action="{{ route('attendance.store') }}" method="POST" class="max-w-2xl">
    @csrf

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Attendance Details</h3>
        </div>
        <div class="card-body space-y-4">
            <div>
                <label for="member_id" class="form-label required">Member</label>
                @if($member)
                    <input type="hidden" name="member_id" value="{{ $member->id }}">
                    <input type="text" value="{{ $member->full_name }} ({{ $member->member_id }})" 
                           class="form-input" readonly>
                @else
                    <select id="member_id" name="member_id" 
                            class="form-select @error('member_id') form-input-error @enderror" 
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
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="service_date" class="form-label required">Service Date</label>
                    <input type="date" id="service_date" name="service_date"
                           value="{{ old('service_date', now()->format('Y-m-d')) }}"
                           class="form-input @error('service_date') form-input-error @enderror"
                           required>
                    @error('service_date')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="service_type" class="form-label required">Service Type</label>
                    <select id="service_type" name="service_type"
                            class="form-select @error('service_type') form-input-error @enderror"
                            required>
                        <option value="sunday_first" {{ old('service_type') == 'sunday_first' ? 'selected' : '' }}>Sunday First Service</option>
                        <option value="sunday_second" {{ old('service_type') == 'sunday_second' ? 'selected' : '' }}>Sunday Second Service</option>
                        <option value="midweek" {{ old('service_type') == 'midweek' ? 'selected' : '' }}>Midweek Service</option>
                        <option value="prayer_meeting" {{ old('service_type') == 'prayer_meeting' ? 'selected' : '' }}>Prayer Meeting</option>
                        <option value="special" {{ old('service_type') == 'special' ? 'selected' : '' }}>Special Service</option>
                    </select>
                    @error('service_type')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="status" class="form-label required">Status</label>
                <select id="status" name="status"
                        class="form-select @error('status') form-input-error @enderror"
                        required>
                    <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>Present</option>
                    <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                    <option value="excused" {{ old('status') == 'excused' ? 'selected' : '' }}>Excused</option>
                    <option value="late" {{ old('status') == 'late' ? 'selected' : '' }}>Late</option>
                </select>
                @error('status')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="notes" class="form-label">Notes</label>
                <textarea id="notes" name="notes" rows="3"
                          class="form-textarea @error('notes') form-input-error @enderror"
                          placeholder="Optional notes about this attendance record...">{{ old('notes') }}</textarea>
                @error('notes')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="flex gap-3 mt-6">
        <button type="submit" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Mark Attendance
        </button>
        <a href="{{ route('attendance.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </div>
</form>
@endsection

