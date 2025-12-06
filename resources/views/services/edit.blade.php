@extends('layouts.app')

@section('title', 'Edit Service')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Service</h1>
        <a href="{{ route('services.show', $service) }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
    </div>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('services.update', $service) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Service Name</label>
                    <input type="text" name="name" value="{{ old('name', $service->name) }}" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
                    <select name="service_type" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required>
                        @foreach(['regular', 'midweek', 'special', 'youth', 'children', 'prayer_meeting', 'bible_study', 'other'] as $type)
                            <option value="{{ $type }}" {{ old('service_type', $service->service_type) == $type ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="service_date" value="{{ old('service_date', $service->service_date->format('Y-m-d')) }}" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                    <input type="time" name="start_time" value="{{ old('start_time', $service->start_time->format('H:i')) }}" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                    <input type="time" name="end_time" value="{{ old('end_time', $service->end_time ? $service->end_time->format('H:i') : '') }}" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Venue</label>
                    <input type="text" name="venue" value="{{ old('venue', $service->venue) }}" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Theme / Topic</label>
                    <input type="text" name="theme" value="{{ old('theme', $service->theme) }}" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Preacher</label>
                    <select name="preacher_id" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Select Preacher</option>
                        @foreach($preachers as $preacher)
                            <option value="{{ $preacher->id }}" {{ old('preacher_id', $service->preacher_id) == $preacher->id ? 'selected' : '' }}>
                                {{ $preacher->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expected Attendance</label>
                    <input type="number" name="expected_attendance" value="{{ old('expected_attendance', $service->expected_attendance) }}" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                </div>

                @if($service->status === 'completed')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Actual Attendance</label>
                    <input type="number" name="actual_attendance" value="{{ old('actual_attendance', $service->actual_attendance) }}" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                </div>
                @endif

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea name="notes" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">{{ old('notes', $service->notes) }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium shadow-sm">Update Service</button>
            </div>
        </form>
    </div>
@endsection
