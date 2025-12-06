@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('shepherds.show', $shepherd) }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit Shepherd</h1>
        </div>
        <p class="text-gray-600">Update shepherd information</p>
    </div>

    <div class="max-w-3xl">
        <form method="POST" action="{{ route('shepherds.update', $shepherd) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Shepherd Info (Read-only) -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Shepherd Information</h2>
                </div>
                <div class="card-body">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Shepherd Name</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $shepherd->full_name }}</p>
                        <p class="text-xs text-gray-500 mt-1">Shepherd cannot be changed after appointment</p>
                    </div>
                </div>
            </div>

            <!-- Flock Details -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Flock Details</h2>
                </div>
                <div class="card-body space-y-4">
                    <!-- Flock Name -->
                    <div>
                        <label for="flock_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Flock Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="flock_name"
                               id="flock_name"
                               value="{{ old('flock_name', $shepherd->flock_name) }}"
                               required
                               class="form-input w-full @error('flock_name') border-red-500 @enderror">
                        @error('flock_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                            Description
                        </label>
                        <textarea name="description"
                                  id="description"
                                  rows="3"
                                  class="form-textarea w-full @error('description') border-red-500 @enderror">{{ old('description', $shepherd->description) }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Max Flock Size -->
                    <div>
                        <label for="max_flock_size" class="block text-sm font-medium text-gray-700 mb-1">
                            Maximum Flock Size <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                               name="max_flock_size"
                               id="max_flock_size"
                               value="{{ old('max_flock_size', $shepherd->max_flock_size) }}"
                               required
                               min="1"
                               max="20"
                               class="form-input w-full @error('max_flock_size') border-red-500 @enderror">
                        @error('max_flock_size')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">
                            Current flock size: {{ $shepherd->current_flock_size }} members
                        </p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status"
                                id="status"
                                required
                                class="form-select w-full @error('status') border-red-500 @enderror">
                            <option value="active" {{ old('status', $shepherd->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="on_leave" {{ old('status', $shepherd->status) == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                            <option value="inactive" {{ old('status', $shepherd->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Appointed Date -->
                    <div>
                        <label for="appointed_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Appointment Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date"
                               name="appointed_date"
                               id="appointed_date"
                               value="{{ old('appointed_date', $shepherd->appointed_date->format('Y-m-d')) }}"
                               required
                               max="{{ date('Y-m-d') }}"
                               class="form-input w-full @error('appointed_date') border-red-500 @enderror">
                        @error('appointed_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Date (Optional) -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                            End Date (Optional)
                        </label>
                        <input type="date"
                               name="end_date"
                               id="end_date"
                               value="{{ old('end_date', $shepherd->end_date?->format('Y-m-d')) }}"
                               class="form-input w-full @error('end_date') border-red-500 @enderror">
                        @error('end_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Leave blank if still serving</p>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                            Notes
                        </label>
                        <textarea name="notes"
                                  id="notes"
                                  rows="3"
                                  class="form-textarea w-full @error('notes') border-red-500 @enderror">{{ old('notes', $shepherd->notes) }}</textarea>
                        @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('shepherds.show', $shepherd) }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Update Shepherd
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
