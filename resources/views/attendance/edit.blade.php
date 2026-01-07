@extends('layouts.app')

@section('title', 'Edit Attendance Record')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Edit Attendance Record</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('attendance.index') }}" class="hover:text-primary-600 transition-colors">Attendance</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Edit</span>
        </nav>
    </div>
</div>

<div class="max-w-3xl mx-auto">
    <div class="card border border-slate-100">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Edit Attendance Record</h3>
        </div>

        <form action="{{ route('attendance.update', $attendance) }}" method="POST" class="p-6 space-y-8">
            @csrf
            @method('PUT')

            <!-- Member Information (Read-only) -->
            <div class="p-4 bg-primary-50 rounded-xl border border-primary-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-primary-600 font-bold text-lg border-2 border-primary-100 shadow-sm">
                    {{ strtoupper(substr($attendance->member->first_name, 0, 1)) }}{{ strtoupper(substr($attendance->member->last_name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-bold text-slate-900 text-lg">{{ $attendance->member->full_name }}</p>
                    <p class="text-sm text-slate-500 font-mono">{{ $attendance->member->member_id }} • {{ $attendance->member->email ?? $attendance->member->phone }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Service Date -->
                <div>
                    <label for="service_date" class="form-label required mb-1.5 block font-medium text-sm text-slate-700">Service Date</label>
                    <input type="date"
                           name="service_date"
                           id="service_date"
                           value="{{ old('service_date', $attendance->service_date->format('Y-m-d')) }}"
                           required
                           class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('service_date') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                    @error('service_date')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Service Type -->
                <div>
                    <label for="service_type" class="form-label required mb-1.5 block font-medium text-sm text-slate-700">Service Type</label>
                    <select name="service_type"
                            id="service_type"
                            required
                            class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('service_type') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                        <option value="">Select Service Type</option>
                        <option value="sunday_first" {{ old('service_type', $attendance->service_type) === 'sunday_first' ? 'selected' : '' }}>Sunday - First Service</option>
                        <option value="sunday_second" {{ old('service_type', $attendance->service_type) === 'sunday_second' ? 'selected' : '' }}>Sunday - Second Service</option>
                        <option value="midweek" {{ old('service_type', $attendance->service_type) === 'midweek' ? 'selected' : '' }}>Midweek Service</option>
                        <option value="prayer_meeting" {{ old('service_type', $attendance->service_type) === 'prayer_meeting' ? 'selected' : '' }}>Prayer Meeting</option>
                        <option value="special" {{ old('service_type', $attendance->service_type) === 'special' ? 'selected' : '' }}>Special Service</option>
                    </select>
                    @error('service_type')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="form-label required mb-3 block font-medium text-sm text-slate-700">Attendance Status</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="relative flex items-start p-4 cursor-pointer rounded-xl border transition-all {{ old('status', $attendance->status) === 'present' ? 'bg-emerald-50 border-emerald-500 shadow-sm' : 'bg-white border-slate-200 hover:border-emerald-300' }}">
                        <div class="flex items-center h-5">
                            <input type="radio" name="status" value="present" {{ old('status', $attendance->status) === 'present' ? 'checked' : '' }} class="form-radio text-emerald-600 border-slate-300 focus:ring-emerald-500">
                        </div>
                        <div class="ml-3">
                            <span class="block text-sm font-bold text-slate-900">Present</span>
                            <span class="block text-xs text-slate-500 mt-0.5">Member attended service</span>
                        </div>
                    </label>

                    <label class="relative flex items-start p-4 cursor-pointer rounded-xl border transition-all {{ old('status', $attendance->status) === 'absent' ? 'bg-red-50 border-red-500 shadow-sm' : 'bg-white border-slate-200 hover:border-red-300' }}">
                        <div class="flex items-center h-5">
                            <input type="radio" name="status" value="absent" {{ old('status', $attendance->status) === 'absent' ? 'checked' : '' }} class="form-radio text-red-600 border-slate-300 focus:ring-red-500">
                        </div>
                        <div class="ml-3">
                            <span class="block text-sm font-bold text-slate-900">Absent</span>
                            <span class="block text-xs text-slate-500 mt-0.5">Member was absent</span>
                        </div>
                    </label>

                    <label class="relative flex items-start p-4 cursor-pointer rounded-xl border transition-all {{ old('status', $attendance->status) === 'excused' ? 'bg-amber-50 border-amber-500 shadow-sm' : 'bg-white border-slate-200 hover:border-amber-300' }}">
                        <div class="flex items-center h-5">
                            <input type="radio" name="status" value="excused" {{ old('status', $attendance->status) === 'excused' ? 'checked' : '' }} class="form-radio text-amber-600 border-slate-300 focus:ring-amber-500">
                        </div>
                        <div class="ml-3">
                            <span class="block text-sm font-bold text-slate-900">Excused</span>
                            <span class="block text-xs text-slate-500 mt-0.5">Pre-notified absence</span>
                        </div>
                    </label>

                    <label class="relative flex items-start p-4 cursor-pointer rounded-xl border transition-all {{ old('status', $attendance->status) === 'late' ? 'bg-amber-50 border-amber-500 shadow-sm' : 'bg-white border-slate-200 hover:border-amber-300' }}">
                        <div class="flex items-center h-5">
                            <input type="radio" name="status" value="late" {{ old('status', $attendance->status) === 'late' ? 'checked' : '' }} class="form-radio text-amber-600 border-slate-300 focus:ring-amber-500">
                        </div>
                        <div class="ml-3">
                            <span class="block text-sm font-bold text-slate-900">Late</span>
                            <span class="block text-xs text-slate-500 mt-0.5">Arrived after service started</span>
                        </div>
                    </label>
                </div>
                @error('status')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Notes</label>
                <textarea name="notes"
                          id="notes"
                          rows="3"
                          class="form-textarea w-full rounded-xl border-slate-200 focus:border-primary-500 focus:ring-primary-500 transition-colors"
                          placeholder="Additional notes about this attendance record...">{{ old('notes', $attendance->notes) }}</textarea>
                <p class="text-xs text-slate-500 mt-1">Add any relevant information about this attendance record</p>
            </div>

            <!-- Record Information -->
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Record Information
                </h4>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-slate-500 text-xs uppercase tracking-wider font-bold mb-0.5">Recorded By</p>
                        <p class="font-medium text-slate-900">{{ $attendance->recorder->full_name ?? 'System' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs uppercase tracking-wider font-bold mb-0.5">Recorded At</p>
                        <p class="font-medium text-slate-900">{{ $attendance->recorded_at ? $attendance->recorded_at->format('M d, Y H:i') : 'N/A' }}</p>
                    </div>
                    @if($attendance->check_in_time)
                    <div>
                        <p class="text-slate-500 text-xs uppercase tracking-wider font-bold mb-0.5">Check-in Time</p>
                        <p class="font-medium text-slate-900">{{ \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') }}</p>
                    </div>
                    @endif
                    @if($attendance->check_in_method)
                    <div>
                        <p class="text-slate-500 text-xs uppercase tracking-wider font-bold mb-0.5">Check-in Method</p>
                        <p class="font-medium text-slate-900">{{ ucwords(str_replace('_', ' ', $attendance->check_in_method)) }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('attendance.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Record
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
