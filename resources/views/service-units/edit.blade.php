@extends('layouts.app')

@section('title', 'Edit Service Unit')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('service-units.show', $serviceUnit) }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit Service Unit</h1>
        </div>
        <p class="text-gray-600">Update {{ $serviceUnit->name }} details</p>
    </div>

    <!-- Form -->
    <form action="{{ route('service-units.update', $serviceUnit) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Basic Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Unit Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Unit Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $serviceUnit->name) }}"
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
                    <input type="text" name="code" id="code" value="{{ old('code', $serviceUnit->code) }}"
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
                        <option value="music" {{ old('category', $serviceUnit->category) === 'music' ? 'selected' : '' }}>Music</option>
                        <option value="technical" {{ old('category', $serviceUnit->category) === 'technical' ? 'selected' : '' }}>Technical</option>
                        <option value="hospitality" {{ old('category', $serviceUnit->category) === 'hospitality' ? 'selected' : '' }}>Hospitality</option>
                        <option value="security" {{ old('category', $serviceUnit->category) === 'security' ? 'selected' : '' }}>Security</option>
                        <option value="admin" {{ old('category', $serviceUnit->category) === 'admin' ? 'selected' : '' }}>Administrative</option>
                        <option value="children" {{ old('category', $serviceUnit->category) === 'children' ? 'selected' : '' }}>Children's Ministry</option>
                        <option value="media" {{ old('category', $serviceUnit->category) === 'media' ? 'selected' : '' }}>Media</option>
                        <option value="other" {{ old('category', $serviceUnit->category) === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="md:col-span-2">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror"
                            required>
                        <option value="active" {{ old('status', $serviceUnit->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $serviceUnit->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ old('status', $serviceUnit->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                    @error('status')
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
                              placeholder="Brief description of the unit's purpose and activities">{{ old('description', $serviceUnit->description) }}</textarea>
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
                        <option value="{{ $member->id }}" {{ old('leader_id', $serviceUnit->leader_id) == $member->id ? 'selected' : '' }}>
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
                        <option value="{{ $member->id }}" {{ old('assistant_leader_id', $serviceUnit->assistant_leader_id) == $member->id ? 'selected' : '' }}>
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
                    <input type="number" name="min_members" id="min_members" value="{{ old('min_members', $serviceUnit->min_members) }}"
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
                    <input type="number" name="max_members" id="max_members" value="{{ old('max_members', $serviceUnit->max_members) }}"
                           min="1" max="100"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('max_members') border-red-500 @enderror"
                           required>
                    @error('max_members')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Maximum capacity for this unit</p>
                </div>

                <!-- Current Members (Read-only) -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Current Members
                    </label>
                    <div class="bg-gray-50 px-4 py-2 border border-gray-300 rounded-lg">
                        <p class="text-gray-900">{{ $serviceUnit->current_members }} members</p>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Use "Manage Members" to add or remove members</p>
                </div>

                <!-- Meeting Schedule -->
                <div class="md:col-span-2">
                    <label for="meeting_schedule" class="block text-sm font-medium text-gray-700 mb-2">
                        Meeting Schedule
                    </label>
                    <input type="text" name="meeting_schedule" id="meeting_schedule" value="{{ old('meeting_schedule', $serviceUnit->meeting_schedule) }}"
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
                              placeholder="List requirements or qualifications for members (one per line)">{{ old('requirements', $serviceUnit->requirements) }}</textarea>
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
                              placeholder="List key responsibilities for unit members (one per line)">{{ old('responsibilities', $serviceUnit->responsibilities) }}</textarea>
                    @error('responsibilities')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Main duties and expectations for members</p>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        @can('delete', $serviceUnit)
        <div class="bg-red-50 border-2 border-red-200 rounded-lg p-6">
            <h2 class="text-xl font-bold text-red-900 mb-4">Danger Zone</h2>
            <p class="text-red-700 mb-4">
                Deleting this service unit will remove all associated data, including member assignments, duty rosters, and meetings.
                This action cannot be undone.
            </p>
            <button type="button" onclick="confirmDelete()"
                    class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                Delete Service Unit
            </button>
        </div>
        @endcan

        <!-- Form Actions -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('service-units.show', $serviceUnit) }}"
               class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition">
                Update Service Unit
            </button>
        </div>
    </form>

    <!-- Delete Form (Hidden) -->
    <form id="delete-form" action="{{ route('service-units.destroy', $serviceUnit) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
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

function confirmDelete() {
    if (confirm('Are you sure you want to delete this service unit? This action cannot be undone and will remove all associated data including member assignments, duty rosters, and meetings.')) {
        if (confirm('This is your final confirmation. Delete {{ $serviceUnit->name }}?')) {
            document.getElementById('delete-form').submit();
        }
    }
}
</script>
@endsection
