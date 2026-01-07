@extends('layouts.app')

@section('title', 'Edit Service')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Edit Service</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('services.index') }}" class="hover:text-primary-600 transition-colors">Services</a>
            <span>/</span>
            <a href="{{ route('services.show', $service) }}" class="hover:text-primary-600 transition-colors">{{ $service->name }}</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Edit</span>
        </nav>
    </div>
</div>

<form method="POST" action="{{ route('services.update', $service) }}" class="max-w-5xl mx-auto">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Service Details</h3>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Service Name -->
                    <div>
                        <label for="name" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Service Name</label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $service->name) }}"
                               required
                               class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('name') border-red-500 @enderror">
                        @error('name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Service Type -->
                    <div>
                        <label for="service_type" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Service Type</label>
                        <select name="service_type"
                                id="service_type"
                                required
                                class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('service_type') border-red-500 @enderror">
                            @foreach(['regular', 'midweek', 'special', 'youth', 'children', 'prayer_meeting', 'bible_study', 'other'] as $type)
                            <option value="{{ $type }}" {{ old('service_type', $service->service_type) == $type ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                            </option>
                            @endforeach
                        </select>
                        @error('service_type')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Date -->
                        <div>
                            <label for="service_date" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Date</label>
                            <input type="date"
                                   name="service_date"
                                   id="service_date"
                                   value="{{ old('service_date', $service->service_date->format('Y-m-d')) }}"
                                   required
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('service_date') border-red-500 @enderror">
                            @error('service_date')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Venue -->
                        <div>
                            <label for="venue" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Venue</label>
                            <input type="text"
                                   name="venue"
                                   id="venue"
                                   value="{{ old('venue', $service->venue) }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('venue') border-red-500 @enderror">
                            @error('venue')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Start Time -->
                        <div>
                            <label for="start_time" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Start Time</label>
                            <input type="time"
                                   name="start_time"
                                   id="start_time"
                                   value="{{ old('start_time', $service->start_time->format('H:i')) }}"
                                   required
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('start_time') border-red-500 @enderror">
                            @error('start_time')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Time -->
                        <div>
                            <label for="end_time" class="form-label mb-1.5 block font-medium text-sm text-slate-700">End Time (Optional)</label>
                            <input type="time"
                                   name="end_time"
                                   id="end_time"
                                   value="{{ old('end_time', $service->end_time ? $service->end_time->format('H:i') : '') }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('end_time') border-red-500 @enderror">
                            @error('end_time')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content & Planning -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Content & Planning</h3>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Theme/Topic -->
                    <div>
                        <label for="theme" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Theme / Topic</label>
                        <input type="text"
                               name="theme"
                               id="theme"
                               value="{{ old('theme', $service->theme) }}"
                               class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('theme') border-red-500 @enderror">
                        @error('theme')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Preacher -->
                    <div>
                        <label for="preacher_id" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Preacher / Speaker</label>
                        <select name="preacher_id"
                                id="preacher_id"
                                class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('preacher_id') border-red-500 @enderror">
                            <option value="">Select Preacher...</option>
                            @foreach($preachers as $preacher)
                            <option value="{{ $preacher->id }}" {{ old('preacher_id', $service->preacher_id) == $preacher->id ? 'selected' : '' }}>
                                {{ $preacher->full_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('preacher_id')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Expected Attendance -->
                        <div>
                            <label for="expected_attendance" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Expected Attendance</label>
                            <input type="number"
                                   name="expected_attendance"
                                   id="expected_attendance"
                                   value="{{ old('expected_attendance', $service->expected_attendance) }}"
                                   min="0"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('expected_attendance') border-red-500 @enderror">
                            @error('expected_attendance')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actual Attendance -->
                        @if($service->status === 'completed' || $service->status === 'in_progress')
                        <div>
                            <label for="actual_attendance" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Actual Attendance</label>
                            <input type="number"
                                   name="actual_attendance"
                                   id="actual_attendance"
                                   value="{{ old('actual_attendance', $service->actual_attendance) }}"
                                   min="0"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('actual_attendance') border-red-500 @enderror">
                            @error('actual_attendance')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Additional Notes</label>
                        <textarea name="notes"
                                  id="notes"
                                  rows="3"
                                  class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl @error('notes') border-red-500 @enderror">{{ old('notes', $service->notes) }}</textarea>
                        @error('notes')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="card p-6 bg-slate-50 border border-slate-200">
                <h4 class="font-bold text-slate-800 mb-2">Service Status</h4>
                <div class="flex items-center gap-2 mb-4">
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize {{ $service->getStatusBadgeClass() }}">
                        {{ ucfirst(str_replace('_', ' ', $service->status)) }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mb-0">Status updates are managed through the service dashboard.</p>
            </div>

            <!-- Actions -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="p-6 space-y-3">
                    <button type="submit" class="btn btn-primary w-full shadow-lg shadow-primary-500/30">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 1m0-1l1-3m-1 3l-1-3m1 3l1 3m1-3l2 1"></path></svg>
                        Update Service
                    </button>
                    <a href="{{ route('services.show', $service) }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 w-full justify-center">
                        Cancel
                    </a>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card border border-red-100 shadow-sm">
                <div class="px-6 py-4 border-b border-red-100 bg-red-50/50">
                    <h3 class="font-bold text-red-800 text-sm">Danger Zone</h3>
                </div>
                <div class="p-6">
                    <p class="text-xs text-slate-500 mb-3">Deleting this service will remove all associated data including volunteer assignments and worship plans.</p>
                    <button type="button" 
                            onclick="if(confirm('Are you sure you want to delete this service? This action cannot be undone.')) document.getElementById('delete-form').submit();"
                            class="btn border border-red-200 text-red-600 hover:bg-red-50 w-full justify-center">
                        Delete Service
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="delete-form" action="{{ route('services.destroy', $service) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection
