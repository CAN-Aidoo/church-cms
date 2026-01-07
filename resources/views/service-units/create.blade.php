@extends('layouts.app')

@section('title', 'Create Service Unit')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-2">
            <a href="{{ route('service-units.index') }}" class="hover:text-primary-600 transition-colors">Service Units</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Create</span>
        </nav>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Create Service Unit</h1>
        <p class="text-slate-500 mt-1">Set up a new ministry service unit or department</p>
    </div>
</div>

<form action="{{ route('service-units.store') }}" method="POST" class="max-w-5xl mx-auto space-y-8">
    @csrf

    <!-- Basic Information -->
    <div class="card border border-slate-100 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Basic Information</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="name" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Unit Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                       placeholder="e.g. Ushering Unit, Technical Team, Choir">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="code" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Unit Code</label>
                <div class="relative">
                    <input type="text" name="code" id="code" value="{{ old('code') }}" required
                           class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg uppercase"
                           placeholder="e.g. USH-01">
                </div>
                <p class="mt-1 text-xs text-slate-500">Unique identifier for this unit</p>
                @error('code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Category</label>
                <select name="category" id="category" required
                        class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    <option value="">Select Category</option>
                    @foreach(['music', 'technical', 'hospitality', 'security', 'admin', 'children', 'media', 'other'] as $cat)
                        <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="description" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                          placeholder="Brief description of the unit's purpose and activities">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Leadership -->
    <div class="card border border-slate-100 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Leadership Structure</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="leader_id" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Unit Leader</label>
                <select name="leader_id" id="leader_id"
                        class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
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

            <div>
                <label for="assistant_leader_id" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Assistant Leader</label>
                <select name="assistant_leader_id" id="assistant_leader_id"
                        class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    <option value="">Select Assistant</option>
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

    <!-- Capacity & Schedule -->
    <div class="card border border-slate-100 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Operational Details</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="min_members" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Minimum Capacity</label>
                <input type="number" name="min_members" id="min_members" value="{{ old('min_members', 5) }}" min="1" max="50" required
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                <p class="mt-1 text-xs text-slate-500">Minimum members for unit viability</p>
                @error('min_members')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="max_members" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Maximum Capacity</label>
                <input type="number" name="max_members" id="max_members" value="{{ old('max_members', 20) }}" min="1" max="100" required
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                <p class="mt-1 text-xs text-slate-500">Maximum member allowance</p>
                @error('max_members')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="meeting_schedule" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Meeting Schedule</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </span>
                    <input type="text" name="meeting_schedule" id="meeting_schedule" value="{{ old('meeting_schedule') }}"
                           class="form-input pl-10 w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                           placeholder="e.g. Every Saturday at 4:00 PM">
                </div>
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
            <div>
                <label for="requirements" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Requirements</label>
                <textarea name="requirements" id="requirements" rows="4"
                          class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                          placeholder="List requirements or qualifications for members (one per line)">{{ old('requirements') }}</textarea>
                @error('requirements')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="responsibilities" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Responsibilities</label>
                <textarea name="responsibilities" id="responsibilities" rows="4"
                          class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                          placeholder="List key responsibilities for unit members (one per line)">{{ old('responsibilities') }}</textarea>
                @error('responsibilities')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end gap-4 pt-4">
        <a href="{{ route('service-units.index') }}" class="btn btn-outline-secondary px-6">Cancel</a>
        <button type="submit" class="btn btn-primary px-8 shadow-lg shadow-primary-500/20">Create Service Unit</button>
    </div>
</form>

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
