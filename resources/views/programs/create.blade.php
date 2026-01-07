@extends('layouts.app')

@section('title', 'Create Program')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Create New Program</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('programs.index') }}" class="hover:text-primary-600 transition-colors">Programs</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Create</span>
        </nav>
    </div>
</div>

<form action="{{ route('programs.store') }}" method="POST" enctype="multipart/form-data" class="max-w-5xl mx-auto space-y-8">
    @csrf

    <!-- Basic Information -->
    <div class="card border border-slate-100 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Basic Information</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="name" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Program Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                       placeholder="e.g. Annual Leadership Conference">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="description" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Description</label>
                <textarea name="description" id="description" rows="4" required
                          class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                          placeholder="Provide a detailed description of the event...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="type" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Program Type</label>
                <select name="type" id="type" required
                        class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    <option value="">Select Type</option>
                    <option value="conference" {{ old('type') === 'conference' ? 'selected' : '' }}>Conference</option>
                    <option value="seminar" {{ old('type') === 'seminar' ? 'selected' : '' }}>Seminar</option>
                    <option value="crusade" {{ old('type') === 'crusade' ? 'selected' : '' }}>Crusade</option>
                    <option value="retreat" {{ old('type') === 'retreat' ? 'selected' : '' }}>Retreat</option>
                    <option value="workshop" {{ old('type') === 'workshop' ? 'selected' : '' }}>Workshop</option>
                    <option value="training" {{ old('type') === 'training' ? 'selected' : '' }}>Training</option>
                    <option value="other" {{ old('type') === 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Category</label>
                <select name="category" id="category" required
                        class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    <option value="">Select Category</option>
                    <option value="spiritual_development" {{ old('category') === 'spiritual_development' ? 'selected' : '' }}>Spiritual Development</option>
                    <option value="leadership_training" {{ old('category') === 'leadership_training' ? 'selected' : '' }}>Leadership Training</option>
                    <option value="youth_ministry" {{ old('category') === 'youth_ministry' ? 'selected' : '' }}>Youth Ministry</option>
                    <option value="womens_ministry" {{ old('category') === 'womens_ministry' ? 'selected' : '' }}>Women's Ministry</option>
                    <option value="mens_ministry" {{ old('category') === 'mens_ministry' ? 'selected' : '' }}>Men's Ministry</option>
                    <option value="childrens_ministry" {{ old('category') === 'childrens_ministry' ? 'selected' : '' }}>Children's Ministry</option>
                    <option value="evangelism" {{ old('category') === 'evangelism' ? 'selected' : '' }}>Evangelism</option>
                    <option value="community_outreach" {{ old('category') === 'community_outreach' ? 'selected' : '' }}>Community Outreach</option>
                    <option value="special_event" {{ old('category') === 'special_event' ? 'selected' : '' }}>Special Event</option>
                    <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Date & Time -->
    <div class="card border border-slate-100 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Date & Time</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="start_date" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                @error('start_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="end_date" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                @error('end_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="start_time" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Start Time</label>
                <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}"
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                @error('start_time')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="end_time" class="form-label mb-1.5 block font-medium text-sm text-slate-700">End Time</label>
                <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}"
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                @error('end_time')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Venue Information -->
    <div class="card border border-slate-100 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Venue Information</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="venue_name" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Venue Name</label>
                <input type="text" name="venue_name" id="venue_name" value="{{ old('venue_name') }}"
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                       placeholder="e.g. Main Auditorium">
                @error('venue_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="venue_gps" class="form-label mb-1.5 block font-medium text-sm text-slate-700">GPS Address</label>
                <input type="text" name="venue_gps" id="venue_gps" value="{{ old('venue_gps') }}" 
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                       placeholder="e.g. GA-123-4567">
                @error('venue_gps')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="venue_address" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Venue Address</label>
                <textarea name="venue_address" id="venue_address" rows="2"
                          class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                          placeholder="Complete physical address">{{ old('venue_address') }}</textarea>
                @error('venue_address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Registration Settings -->
    <div class="card border border-slate-100 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Registration Settings</h3>
        </div>
        <div class="p-6 space-y-6">
            <div class="flex items-center">
                <input type="checkbox" name="requires_registration" id="requires_registration" value="1"
                       {{ old('requires_registration') ? 'checked' : '' }}
                       class="form-checkbox w-5 h-5 text-primary-600 border-slate-300 rounded focus:ring-primary-500 transition-colors">
                <label for="requires_registration" class="ml-2 text-sm font-medium text-slate-700 select-none cursor-pointer">Requires Registration</label>
            </div>

            <div id="registration_fields" class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-slate-50 rounded-lg border border-slate-100" style="display: none;">
                <div>
                    <label for="max_participants" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Maximum Participants</label>
                    <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants') }}" min="1"
                           class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    @error('max_participants')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="registration_fee" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Registration Fee (GHS)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-slate-500 sm:text-sm">GHS</span>
                        </div>
                        <input type="number" name="registration_fee" id="registration_fee" value="{{ old('registration_fee', 0) }}" min="0" step="0.01"
                               class="form-input w-full pl-12 border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    </div>
                    @error('registration_fee')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="target_audience" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Target Audience</label>
                    <input type="text" name="target_audience" id="target_audience" value="{{ old('target_audience') }}"
                           class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                           placeholder="e.g. Youth, Adults, All Members">
                    @error('target_audience')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Program Flyer -->
    <div class="card border border-slate-100 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Program Flyer</h3>
        </div>
        <div class="p-6">
            <div class="w-full">
                <label for="flyer" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Upload Flyer (Optional)</label>
                <div class="flex items-center justify-center w-full">
                    <label for="flyer" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-lg cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-slate-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-slate-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-slate-500">SVG, PNG, JPG or GIF (MAX. 2MB)</p>
                        </div>
                        <input id="flyer" name="flyer" type="file" class="hidden" accept="image/*" />
                    </label>
                </div> 
                @error('flyer')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div id="flyer_preview" class="mt-4 hidden p-4 bg-slate-50 rounded-lg border border-slate-100">
                <p class="text-sm font-medium text-slate-700 mb-2">Preview:</p>
                <img id="preview_image" src="" alt="Flyer preview" class="max-w-xs rounded-lg shadow-md">
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end gap-3 sticky bottom-6 z-10">
        <a href="{{ route('programs.index') }}" class="btn btn-secondary px-6">
            Cancel
        </a>
        <button type="submit" class="btn btn-primary px-6 shadow-lg shadow-primary-500/30">
            Create Program
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle registration fields
    const requiresRegistration = document.getElementById('requires_registration');
    const registrationFields = document.getElementById('registration_fields');

    function toggleRegistrationFields() {
        if (requiresRegistration.checked) {
            registrationFields.style.display = 'grid';
            // Slight animation effect could be added here
        } else {
            registrationFields.style.display = 'none';
        }
    }

    requiresRegistration.addEventListener('change', toggleRegistrationFields);
    toggleRegistrationFields();

    // Flyer preview
    const flyerInput = document.getElementById('flyer');
    const flyerPreview = document.getElementById('flyer_preview');
    const previewImage = document.getElementById('preview_image');

    flyerInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                flyerPreview.classList.remove('hidden');
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            flyerPreview.classList.add('hidden');
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
