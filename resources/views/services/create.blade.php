@extends('layouts.app')

@section('title', 'Schedule New Service')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Schedule New Service</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('services.index') }}" class="hover:text-primary-600 transition-colors">Services</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Create</span>
        </nav>
    </div>
</div>

<form method="POST" action="{{ route('services.store') }}" class="max-w-5xl mx-auto">
    @csrf

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
                               value="{{ old('name') }}"
                               required
                               class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('name') border-red-500 @enderror"
                               placeholder="e.g. Sunday Celebration Service">
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
                            <option value="regular" {{ old('service_type') == 'regular' ? 'selected' : '' }}>Regular Sunday Service</option>
                            <option value="midweek" {{ old('service_type') == 'midweek' ? 'selected' : '' }}>Midweek Service</option>
                            <option value="special" {{ old('service_type') == 'special' ? 'selected' : '' }}>Special Event</option>
                            <option value="youth" {{ old('service_type') == 'youth' ? 'selected' : '' }}>Youth Service</option>
                            <option value="children" {{ old('service_type') == 'children' ? 'selected' : '' }}>Children's Service</option>
                            <option value="prayer_meeting" {{ old('service_type') == 'prayer_meeting' ? 'selected' : '' }}>Prayer Meeting</option>
                            <option value="bible_study" {{ old('service_type') == 'bible_study' ? 'selected' : '' }}>Bible Study</option>
                            <option value="other" {{ old('service_type') == 'other' ? 'selected' : '' }}>Other</option>
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
                                   value="{{ old('service_date', date('Y-m-d')) }}"
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
                                   value="{{ old('venue', 'Main Sanctuary') }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('venue') border-red-500 @enderror"
                                   placeholder="e.g. Main Auditorium">
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
                                   value="{{ old('start_time', '09:00') }}"
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
                                   value="{{ old('end_time', '11:00') }}"
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
                               value="{{ old('theme') }}"
                               class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('theme') border-red-500 @enderror"
                               placeholder="e.g. The Power of Prayer">
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
                            <option value="{{ $preacher->id }}" {{ old('preacher_id') == $preacher->id ? 'selected' : '' }}>
                                {{ $preacher->full_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('preacher_id')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Expected Attendance -->
                    <div>
                        <label for="expected_attendance" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Expected Attendance</label>
                        <input type="number"
                               name="expected_attendance"
                               id="expected_attendance"
                               value="{{ old('expected_attendance') }}"
                               min="0"
                               class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('expected_attendance') border-red-500 @enderror"
                               placeholder="Estimated number of attendees">
                        @error('expected_attendance')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Additional Notes</label>
                        <textarea name="notes"
                                  id="notes"
                                  rows="3"
                                  class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl @error('notes') border-red-500 @enderror"
                                  placeholder="Any special instructions or notes...">{{ old('notes') }}</textarea>
                        @error('notes')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Planning Guide -->
            <div class="card p-6 border-l-4 border-l-blue-500 bg-blue-50/50 border-y border-r border-blue-100">
                <div class="flex items-start gap-4">
                    <div class="p-2 bg-blue-100 text-blue-600 rounded-lg flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-blue-900 text-lg mb-2">Planning Guide</h4>
                        <ul class="text-sm text-blue-800 space-y-2 list-none">
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Create draft schedule first</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Assign volunteers after saving</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Add worship items in Service View</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="p-6 space-y-3">
                    <button type="submit" class="btn btn-primary w-full shadow-lg shadow-primary-500/30">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Create Service
                    </button>
                    <a href="{{ route('services.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 w-full justify-center">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
