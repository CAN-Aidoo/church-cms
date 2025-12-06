@extends('layouts.app')

@section('title', 'Edit Program')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="{{ route('programs.index') }}" class="hover:text-blue-600">Programs</a>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
            <a href="{{ route('programs.show', $program) }}" class="hover:text-blue-600">{{ $program->name }}</a>
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
            <span>Edit</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900">Edit Program</h1>
        <p class="text-gray-600 mt-1">Update program details</p>
    </div>

    {{-- Form --}}
    <form action="{{ route('programs.update', $program) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Basic Information --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Basic Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Program Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $program->name) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                    <textarea name="description" id="description" rows="4" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $program->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Program Type *</label>
                    <select name="type" id="type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('type') border-red-500 @enderror">
                        <option value="">Select Type</option>
                        <option value="conference" {{ old('type', $program->type) === 'conference' ? 'selected' : '' }}>Conference</option>
                        <option value="seminar" {{ old('type', $program->type) === 'seminar' ? 'selected' : '' }}>Seminar</option>
                        <option value="crusade" {{ old('type', $program->type) === 'crusade' ? 'selected' : '' }}>Crusade</option>
                        <option value="retreat" {{ old('type', $program->type) === 'retreat' ? 'selected' : '' }}>Retreat</option>
                        <option value="workshop" {{ old('type', $program->type) === 'workshop' ? 'selected' : '' }}>Workshop</option>
                        <option value="training" {{ old('type', $program->type) === 'training' ? 'selected' : '' }}>Training</option>
                        <option value="other" {{ old('type', $program->type) === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select name="category" id="category" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category') border-red-500 @enderror">
                        <option value="">Select Category</option>
                        <option value="spiritual_development" {{ old('category', $program->category) === 'spiritual_development' ? 'selected' : '' }}>Spiritual Development</option>
                        <option value="leadership_training" {{ old('category', $program->category) === 'leadership_training' ? 'selected' : '' }}>Leadership Training</option>
                        <option value="youth_ministry" {{ old('category', $program->category) === 'youth_ministry' ? 'selected' : '' }}>Youth Ministry</option>
                        <option value="womens_ministry" {{ old('category', $program->category) === 'womens_ministry' ? 'selected' : '' }}>Women's Ministry</option>
                        <option value="mens_ministry" {{ old('category', $program->category) === 'mens_ministry' ? 'selected' : '' }}>Men's Ministry</option>
                        <option value="childrens_ministry" {{ old('category', $program->category) === 'childrens_ministry' ? 'selected' : '' }}>Children's Ministry</option>
                        <option value="evangelism" {{ old('category', $program->category) === 'evangelism' ? 'selected' : '' }}>Evangelism</option>
                        <option value="community_outreach" {{ old('category', $program->category) === 'community_outreach' ? 'selected' : '' }}>Community Outreach</option>
                        <option value="special_event" {{ old('category', $program->category) === 'special_event' ? 'selected' : '' }}>Special Event</option>
                        <option value="other" {{ old('category', $program->category) === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Date & Time --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Date & Time</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $program->start_date->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('start_date') border-red-500 @enderror">
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">End Date *</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $program->end_date->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('end_date') border-red-500 @enderror">
                    @error('end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $program->start_time) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('start_time') border-red-500 @enderror">
                    @error('start_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $program->end_time) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('end_time') border-red-500 @enderror">
                    @error('end_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Venue Information --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Venue Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="venue_name" class="block text-sm font-medium text-gray-700 mb-2">Venue Name</label>
                    <input type="text" name="venue_name" id="venue_name" value="{{ old('venue_name', $program->venue_name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('venue_name') border-red-500 @enderror">
                    @error('venue_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="venue_gps" class="block text-sm font-medium text-gray-700 mb-2">GPS Address</label>
                    <input type="text" name="venue_gps" id="venue_gps" value="{{ old('venue_gps', $program->venue_gps) }}" placeholder="e.g., GA-123-4567"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('venue_gps') border-red-500 @enderror">
                    @error('venue_gps')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="venue_address" class="block text-sm font-medium text-gray-700 mb-2">Venue Address</label>
                    <textarea name="venue_address" id="venue_address" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('venue_address') border-red-500 @enderror">{{ old('venue_address', $program->venue_address) }}</textarea>
                    @error('venue_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Registration Settings --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Registration Settings</h2>

            <div class="space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" name="requires_registration" id="requires_registration" value="1"
                           {{ old('requires_registration', $program->requires_registration) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="requires_registration" class="ml-2 text-sm font-medium text-gray-700">Requires Registration</label>
                </div>

                <div id="registration_fields" class="grid grid-cols-1 md:grid-cols-2 gap-6" style="display: {{ old('requires_registration', $program->requires_registration) ? 'grid' : 'none' }};">
                    <div>
                        <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-2">Maximum Participants</label>
                        <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants', $program->max_participants) }}" min="1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('max_participants') border-red-500 @enderror">
                        @error('max_participants')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="registration_fee" class="block text-sm font-medium text-gray-700 mb-2">Registration Fee (GHS)</label>
                        <input type="number" name="registration_fee" id="registration_fee" value="{{ old('registration_fee', $program->registration_fee) }}" min="0" step="0.01"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('registration_fee') border-red-500 @enderror">
                        @error('registration_fee')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="target_audience" class="block text-sm font-medium text-gray-700 mb-2">Target Audience</label>
                        <input type="text" name="target_audience" id="target_audience" value="{{ old('target_audience', $program->target_audience) }}"
                               placeholder="e.g., Youth, Adults, All Members"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('target_audience') border-red-500 @enderror">
                        @error('target_audience')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Program Flyer --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Program Flyer</h2>

            @if($program->flyer_path)
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-2">Current Flyer:</p>
                <img src="{{ Storage::url($program->flyer_path) }}" alt="Current flyer" class="max-w-xs rounded-lg shadow-md">
            </div>
            @endif

            <div>
                <label for="flyer" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $program->flyer_path ? 'Replace Flyer (Optional)' : 'Upload Flyer (Optional)' }}
                </label>
                <input type="file" name="flyer" id="flyer" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('flyer') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Maximum file size: 2MB. Formats: JPG, PNG, GIF</p>
                @error('flyer')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div id="flyer_preview" class="mt-4" style="display: none;">
                <p class="text-sm text-gray-600 mb-2">New Flyer Preview:</p>
                <img id="preview_image" src="" alt="Flyer preview" class="max-w-xs rounded-lg shadow-md">
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex justify-between">
            <div>
                @can('delete', $program)
                <button type="button" onclick="if(confirm('Are you sure you want to delete this program? This action cannot be undone.')) { document.getElementById('delete-form').submit(); }"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Delete Program
                </button>
                @endcan
            </div>
            <div class="flex gap-4">
                <a href="{{ route('programs.show', $program) }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition">
                    Update Program
                </button>
            </div>
        </div>
    </form>

    {{-- Delete Form --}}
    @can('delete', $program)
    <form id="delete-form" action="{{ route('programs.destroy', $program) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    @endcan
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle registration fields
    const requiresRegistration = document.getElementById('requires_registration');
    const registrationFields = document.getElementById('registration_fields');

    function toggleRegistrationFields() {
        registrationFields.style.display = requiresRegistration.checked ? 'grid' : 'none';
    }

    requiresRegistration.addEventListener('change', toggleRegistrationFields);

    // Flyer preview
    const flyerInput = document.getElementById('flyer');
    const flyerPreview = document.getElementById('flyer_preview');
    const previewImage = document.getElementById('preview_image');

    flyerInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                flyerPreview.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            flyerPreview.style.display = 'none';
        }
    });

    // Date validation
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    startDate.addEventListener('change', function() {
        endDate.min = this.value;
        if (endDate.value && endDate.value < this.value) {
            endDate.value = this.value;
        }
    });
});
</script>
@endsection
