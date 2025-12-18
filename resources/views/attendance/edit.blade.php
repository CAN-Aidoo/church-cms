@extends('layouts.app')

@section('title', 'Edit Attendance Record')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Attendance Record</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('attendance.index') }}">Attendance</a>
            <span>/</span>
            <span>Edit</span>
        </nav>
    </div>
</div>

<div class="max-w-2xl mx-auto">
    <div class="card">
        <div class="card-header">
            <h2 class="text-xl font-semibold">Edit Attendance Record</h2>
        </div>

        <form action="{{ route('attendance.update', $attendance) }}" method="POST" class="card-body space-y-6">
            @csrf
            @method('PUT')

            <!-- Member Information (Read-only) -->
            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-lg font-bold">
                        {{ strtoupper(substr($attendance->member->first_name, 0, 1)) }}{{ strtoupper(substr($attendance->member->last_name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">{{ $attendance->member->first_name }} {{ $attendance->member->last_name }}</p>
                        <p class="text-sm text-gray-600">{{ $attendance->member->email ?? $attendance->member->phone }}</p>
                    </div>
                </div>
            </div>

            <!-- Service Date -->
            <div>
                <label for="service_date" class="block text-sm font-medium text-gray-700 mb-1">
                    Service Date <span class="text-red-500">*</span>
                </label>
                <input type="date"
                       name="service_date"
                       id="service_date"
                       value="{{ old('service_date', $attendance->service_date) }}"
                       required
                       class="form-input w-full @error('service_date') border-red-500 @enderror">
                @error('service_date')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Service Type -->
            <div>
                <label for="service_type" class="block text-sm font-medium text-gray-700 mb-1">
                    Service Type <span class="text-red-500">*</span>
                </label>
                <select name="service_type"
                        id="service_type"
                        required
                        class="form-select w-full @error('service_type') border-red-500 @enderror">
                    <option value="">Select Service Type</option>
                    <option value="sunday_first" {{ old('service_type', $attendance->service_type) === 'sunday_first' ? 'selected' : '' }}>
                        Sunday - First Service
                    </option>
                    <option value="sunday_second" {{ old('service_type', $attendance->service_type) === 'sunday_second' ? 'selected' : '' }}>
                        Sunday - Second Service
                    </option>
                    <option value="midweek" {{ old('service_type', $attendance->service_type) === 'midweek' ? 'selected' : '' }}>
                        Midweek Service
                    </option>
                    <option value="prayer_meeting" {{ old('service_type', $attendance->service_type) === 'prayer_meeting' ? 'selected' : '' }}>
                        Prayer Meeting
                    </option>
                    <option value="special" {{ old('service_type', $attendance->service_type) === 'special' ? 'selected' : '' }}>
                        Special Service
                    </option>
                </select>
                @error('service_type')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Attendance Status <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all {{ old('status', $attendance->status) === 'present' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="radio"
                               name="status"
                               value="present"
                               {{ old('status', $attendance->status) === 'present' ? 'checked' : '' }}
                               required
                               class="form-radio text-green-600">
                        <span class="ml-3">
                            <span class="block font-medium text-gray-900">Present</span>
                            <span class="text-xs text-gray-500">Member attended service</span>
                        </span>
                    </label>

                    <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all {{ old('status', $attendance->status) === 'absent' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="radio"
                               name="status"
                               value="absent"
                               {{ old('status', $attendance->status) === 'absent' ? 'checked' : '' }}
                               class="form-radio text-red-600">
                        <span class="ml-3">
                            <span class="block font-medium text-gray-900">Absent</span>
                            <span class="text-xs text-gray-500">Member was absent</span>
                        </span>
                    </label>

                    <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all {{ old('status', $attendance->status) === 'excused' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="radio"
                               name="status"
                               value="excused"
                               {{ old('status', $attendance->status) === 'excused' ? 'checked' : '' }}
                               class="form-radio text-blue-600">
                        <span class="ml-3">
                            <span class="block font-medium text-gray-900">Excused</span>
                            <span class="text-xs text-gray-500">Pre-notified absence</span>
                        </span>
                    </label>

                    <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all {{ old('status', $attendance->status) === 'late' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="radio"
                               name="status"
                               value="late"
                               {{ old('status', $attendance->status) === 'late' ? 'checked' : '' }}
                               class="form-radio text-yellow-600">
                        <span class="ml-3">
                            <span class="block font-medium text-gray-900">Late</span>
                            <span class="text-xs text-gray-500">Arrived after service started</span>
                        </span>
                    </label>
                </div>
                @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                    Notes <span class="text-gray-500 text-xs">(Optional)</span>
                </label>
                <textarea name="notes"
                          id="notes"
                          rows="3"
                          class="form-textarea w-full"
                          placeholder="Additional notes about this attendance record...">{{ old('notes', $attendance->notes) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Add any relevant information about this attendance record</p>
            </div>

            <!-- Record Information -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="text-sm font-semibold text-gray-900 mb-2">Record Information</h4>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600">Recorded By</p>
                        <p class="font-medium text-gray-900">{{ $attendance->recordedBy->name ?? 'System' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Recorded At</p>
                        <p class="font-medium text-gray-900">{{ $attendance->recorded_at ? $attendance->recorded_at->format('M d, Y H:i') : 'N/A' }}</p>
                    </div>
                    @if($attendance->check_in_time)
                    <div>
                        <p class="text-gray-600">Check-in Time</p>
                        <p class="font-medium text-gray-900">{{ $attendance->check_in_time }}</p>
                    </div>
                    @endif
                    @if($attendance->check_in_method)
                    <div>
                        <p class="text-gray-600">Check-in Method</p>
                        <p class="font-medium text-gray-900">{{ ucwords(str_replace('_', ' ', $attendance->check_in_method)) }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('attendance.index') }}" class="text-sm text-gray-600 hover:text-gray-800">
                    Cancel
                </a>
                <div class="flex gap-3">
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z"/>
                        </svg>
                        Update Record
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
