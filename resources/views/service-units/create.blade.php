@extends('layouts.app')

@section('title', 'Create Service Unit')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('service-units.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Create Service Unit</h1>
        </div>
        <p class="text-gray-600">Set up a new ministry service unit</p>
    </div>

    <!-- Form -->
    <form action="{{ route('service-units.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Basic Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Unit Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Unit Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="e.g., Ushering Unit, Choir, Technical Team" required>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Unit Code -->
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                        Unit Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('code') border-red-500 @enderror"
                           placeholder="e.g., USH-001, CHR-001" required>
                    @error('code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Unique identifier for this unit</p>
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select name="category" id="category"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category') border-red-500 @enderror"
                            required>
                        <option value="">Select Category</option>
                        <option value="music" {{ old('category') === 'music' ? 'selected' : '' }}>Music</option>
                        <option value="technical" {{ old('category') === 'technical' ? 'selected' : '' }}>Technical</option>
                        <option value="hospitality" {{ old('category') === 'hospitality' ? 'selected' : '' }}>Hospitality</option>
                        <option value="security" {{ old('category') === 'security' ? 'selected' : '' }}>Security</option>
                        <option value="admin" {{ old('category') === 'admin' ? 'selected' : '' }}>Administrative</option>
                        <option value="children" {{ old('category') === 'children' ? 'selected' : '' }}>Children's Ministry</option>
                        <option value="media" {{ old('category') === 'media' ? 'selected' : '' }}>Media</option>
                        <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="Brief description of the unit's purpose and activities">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Leadership -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Leadership</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Leader -->
                <div>
                    <label for="leader_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Unit Leader
                    </label>
                    <select name="leader_id" id="leader_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('leader_id') border-red-500 @enderror">
                        <option value="">Select Leader</option>
                        @foreach($availableMembers as $member)
                        <option value="{{ $member->id }}" {{ old('leader_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->full_name }}
                        </option>
                        @endforeach
                    </select>
                    @error('leader_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Assistant Leader -->
                <div>
                    <label for="assistant_leader_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Assistant Leader
                    </label>
                    <select name="assistant_leader_id" id="assistant_leader_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('assistant_leader_id') border-red-500 @enderror">
                        <option value="">Select Assistant Leader</option>
                        @foreach($availableMembers as $member)
                        <option value="{{ $member->id }}" {{ old('assistant_leader_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->full_name }}
                        </option>
                        @endforeach
                    </select>
                    @error('assistant_leader_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Capacity Settings -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Capacity Settings</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Minimum Members -->
                <div>
                    <label for="min_members" class="block text-sm font-medium text-gray-700 mb-2">
                        Minimum Members <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="min_members" id="min_members" value="{{ old('min_members', 5) }}"
                           min="1" max="50"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('min_members') border-red-500 @enderror"
                           required>
                    @error('min_members')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Minimum members needed for unit to function</p>
                </div>

                <!-- Maximum Members -->
                <div>
                    <label for="max_members" class="block text-sm font-medium text-gray-700 mb-2">
                        Maximum Members <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="max_members" id="max_members" value="{{ old('max_members', 20) }}"
                           min="1" max="100"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('max_members') border-red-500 @enderror"
                           required>
                    @error('max_members')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Maximum capacity for this unit</p>
                </div>

                <!-- Meeting Schedule -->
                <div class="md:col-span-2">
                    <label for="meeting_schedule" class="block text-sm font-medium text-gray-700 mb-2">
                        Meeting Schedule
                    </label>
                    <input type="text" name="meeting_schedule" id="meeting_schedule" value="{{ old('meeting_schedule') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('meeting_schedule') border-red-500 @enderror"
                           placeholder="e.g., Every Saturday at 4:00 PM">
                    @error('meeting_schedule')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Requirements & Responsibilities -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Requirements & Responsibilities</h2>

            <div class="space-y-6">
                <!-- Requirements -->
                <div>
                    <label for="requirements" class="block text-sm font-medium text-gray-700 mb-2">
                        Requirements
                    </label>
                    <textarea name="requirements" id="requirements" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('requirements') border-red-500 @enderror"
                              placeholder="List requirements or qualifications for members (one per line)">{{ old('requirements') }}</textarea>
                    @error('requirements')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Skills, qualifications, or commitments needed</p>
                </div>

                <!-- Responsibilities -->
                <div>
                    <label for="responsibilities" class="block text-sm font-medium text-gray-700 mb-2">
                        Responsibilities
                    </label>
                    <textarea name="responsibilities" id="responsibilities" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('responsibilities') border-red-500 @enderror"
                              placeholder="List key responsibilities for unit members (one per line)">{{ old('responsibilities') }}</textarea>
                    @error('responsibilities')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Main duties and expectations for members</p>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('service-units.index') }}"
               class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition">
                Create Service Unit
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const minInput = document.getElementById('min_members');
    const maxInput = document.getElementById('max_members');

    // Validate that max >= min
    function validateCapacity() {
        const min = parseInt(minInput.value) || 0;
        const max = parseInt(maxInput.value) || 0;

        if (max < min) {
            maxInput.setCustomValidity('Maximum members must be greater than or equal to minimum members');
        } else {
            maxInput.setCustomValidity('');
        }
    }

    minInput.addEventListener('change', validateCapacity);
    maxInput.addEventListener('change', validateCapacity);
});
</script>
@endsection
