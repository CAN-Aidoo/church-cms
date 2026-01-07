@extends('layouts.app')

@section('title', 'Edit Service Unit')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('service-units.show', $serviceUnit) }}" class="text-slate-500 hover:text-primary-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-slate-800">Edit Service Unit</h1>
            </div>
            <p class="text-slate-600">Update details for <span class="font-medium text-slate-900">{{ $serviceUnit->name }}</span></p>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('service-units.show', $serviceUnit) }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 hover:border-slate-400 transition-all shadow-sm font-medium text-sm">
                Cancel
            </a>
            <button type="submit" form="edit-form"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-lg shadow-sm hover:shadow-md transition-all font-medium text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Save Changes
            </button>
        </div>
    </div>

    <!-- Form -->
    <form id="edit-form" action="{{ route('service-units.update', $serviceUnit) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Basic Information</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Unit Name -->
                <div class="md:col-span-2">
                    <label for="name" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">
                        Unit Name
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $serviceUnit->name) }}"
                           class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                           placeholder="e.g. Ushering Unit, Choir, Technical Team" required>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Unit Code -->
                <div>
                    <label for="code" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">
                        Unit Code
                    </label>
                    <input type="text" name="code" id="code" value="{{ old('code', $serviceUnit->code) }}"
                           class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg uppercase"
                           placeholder="e.g. USH-001" required>
                    <p class="mt-1 text-xs text-slate-500">Unique identifier for this unit</p>
                    @error('code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">
                        Category
                    </label>
                    <select name="category" id="category"
                            class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
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
                    <label for="status" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">
                        Status
                    </label>
                    <select name="status" id="status"
                            class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
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
                    <label for="description" class="form-label mb-1.5 block font-medium text-sm text-slate-700">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                              placeholder="Brief description of the unit's purpose and activities">{{ old('description', $serviceUnit->description) }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Leadership -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Leadership</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Leader -->
                <div>
                    <label for="leader_id" class="form-label mb-1.5 block font-medium text-sm text-slate-700">
                        Unit Leader
                    </label>
                    <select name="leader_id" id="leader_id"
                            class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
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
                    <label for="assistant_leader_id" class="form-label mb-1.5 block font-medium text-sm text-slate-700">
                        Assistant Leader
                    </label>
                    <select name="assistant_leader_id" id="assistant_leader_id"
                            class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
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

        <!-- Capacity & Schedule -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Capacity & Schedule</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Minimum Members -->
                <div>
                    <label for="min_members" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">
                        Minimum Members
                    </label>
                    <input type="number" name="min_members" id="min_members" value="{{ old('min_members', $serviceUnit->min_members) }}"
                           min="1" max="50"
                           class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                           required>
                    <p class="mt-1 text-xs text-slate-500">Minimum needed for unit to function</p>
                    @error('min_members')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Maximum Members -->
                <div>
                    <label for="max_members" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">
                        Maximum Members
                    </label>
                    <input type="number" name="max_members" id="max_members" value="{{ old('max_members', $serviceUnit->max_members) }}"
                           min="1" max="100"
                           class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                           required>
                    <p class="mt-1 text-xs text-slate-500">Maximum capacity for this unit</p>
                    @error('max_members')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Members (Read-only) -->
                <div class="md:col-span-2">
                    <label class="form-label mb-1.5 block font-medium text-sm text-slate-700">
                        Current Members
                    </label>
                    <div class="bg-slate-50 px-4 py-2 border border-slate-200 rounded-lg text-slate-600 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>{{ $serviceUnit->current_members }} active members</span>
                    </div>
                </div>

                <!-- Meeting Schedule -->
                <div class="md:col-span-2">
                    <label for="meeting_schedule" class="form-label mb-1.5 block font-medium text-sm text-slate-700">
                        Meeting Schedule
                    </label>
                    <input type="text" name="meeting_schedule" id="meeting_schedule" value="{{ old('meeting_schedule', $serviceUnit->meeting_schedule) }}"
                           class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                           placeholder="e.g. Every Saturday at 4:00 PM">
                    @error('meeting_schedule')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Requirements & Responsibilities -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Requirements & Responsibilities</h3>
            </div>
            <div class="p-6 space-y-6">
                <!-- Requirements -->
                <div>
                    <label for="requirements" class="form-label mb-1.5 block font-medium text-sm text-slate-700">
                        Requirements
                    </label>
                    <textarea name="requirements" id="requirements" rows="4"
                              class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                              placeholder="List requirements or qualifications for members (one per line)">{{ old('requirements', $serviceUnit->requirements) }}</textarea>
                    <p class="mt-1 text-xs text-slate-500">Skills, qualifications, or commitments needed</p>
                    @error('requirements')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Responsibilities -->
                <div>
                    <label for="responsibilities" class="form-label mb-1.5 block font-medium text-sm text-slate-700">
                        Responsibilities
                    </label>
                    <textarea name="responsibilities" id="responsibilities" rows="4"
                              class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                              placeholder="List key responsibilities for unit members (one per line)">{{ old('responsibilities', $serviceUnit->responsibilities) }}</textarea>
                    <p class="mt-1 text-xs text-slate-500">Main duties and expectations for members</p>
                    @error('responsibilities')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        @can('delete', $serviceUnit)
        <div class="border border-red-200 rounded-xl bg-red-50/50 p-6">
            <h3 class="font-bold text-red-900 text-base mb-2">Danger Zone</h3>
            <p class="text-red-700 text-sm mb-4">
                Deleting this service unit will remove all associated data, including member assignments, duty rosters, and meetings.
                This action cannot be undone.
            </p>
            <div class="flex items-center gap-4">
                <button type="button" onclick="confirmDelete()"
                        class="px-4 py-2 bg-red-100 text-red-700 border border-red-200 rounded-lg hover:bg-red-200 hover:border-red-300 transition-colors font-medium text-sm">
                    Delete Service Unit
                </button>
            </div>
        </div>
        @endcan
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
