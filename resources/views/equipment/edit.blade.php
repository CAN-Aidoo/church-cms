@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('equipment.show', $equipment) }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit Equipment</h1>
        </div>
        <p class="text-gray-600">Update equipment information</p>
    </div>

    <div class="max-w-3xl">
        <form method="POST" action="{{ route('equipment.update', $equipment) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Basic Information</h2>
                </div>
                <div class="card-body space-y-4">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Equipment Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $equipment->name) }}"
                               required
                               class="form-input w-full @error('name') border-red-500 @enderror">
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category and Serial Number -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="category"
                                   id="category"
                                   list="category-suggestions"
                                   value="{{ old('category', $equipment->category) }}"
                                   required
                                   class="form-input w-full @error('category') border-red-500 @enderror">
                            <datalist id="category-suggestions">
                                @foreach($categories as $cat)
                                <option value="{{ $cat }}">
                                @endforeach
                            </datalist>
                            @error('category')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="serial_number" class="block text-sm font-medium text-gray-700 mb-1">
                                Serial Number
                            </label>
                            <input type="text"
                                   name="serial_number"
                                   id="serial_number"
                                   value="{{ old('serial_number', $equipment->serial_number) }}"
                                   class="form-input w-full @error('serial_number') border-red-500 @enderror">
                            @error('serial_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                            Description
                        </label>
                        <textarea name="description"
                                  id="description"
                                  rows="3"
                                  class="form-textarea w-full @error('description') border-red-500 @enderror">{{ old('description', $equipment->description) }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Purchase Information -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Purchase Information</h2>
                </div>
                <div class="card-body space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Purchase Date -->
                        <div>
                            <label for="purchase_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Purchase Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                   name="purchase_date"
                                   id="purchase_date"
                                   value="{{ old('purchase_date', $equipment->purchase_date->format('Y-m-d')) }}"
                                   required
                                   max="{{ date('Y-m-d') }}"
                                   class="form-input w-full @error('purchase_date') border-red-500 @enderror">
                            @error('purchase_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Purchase Price -->
                        <div>
                            <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-1">
                                Purchase Price (GHS) <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                   name="purchase_price"
                                   id="purchase_price"
                                   value="{{ old('purchase_price', $equipment->purchase_price) }}"
                                   required
                                   min="0"
                                   step="0.01"
                                   class="form-input w-full @error('purchase_price') border-red-500 @enderror">
                            @error('purchase_price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Warranty Expiry -->
                    <div>
                        <label for="warranty_expiry" class="block text-sm font-medium text-gray-700 mb-1">
                            Warranty Expiry Date
                        </label>
                        <input type="date"
                               name="warranty_expiry"
                               id="warranty_expiry"
                               value="{{ old('warranty_expiry', $equipment->warranty_expiry?->format('Y-m-d')) }}"
                               class="form-input w-full @error('warranty_expiry') border-red-500 @enderror">
                        @error('warranty_expiry')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Status & Location -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Status & Location</h2>
                </div>
                <div class="card-body space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Condition -->
                        <div>
                            <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">
                                Condition <span class="text-red-500">*</span>
                            </label>
                            <select name="condition"
                                    id="condition"
                                    required
                                    class="form-select w-full @error('condition') border-red-500 @enderror">
                                <option value="excellent" {{ old('condition', $equipment->condition) == 'excellent' ? 'selected' : '' }}>Excellent</option>
                                <option value="good" {{ old('condition', $equipment->condition) == 'good' ? 'selected' : '' }}>Good</option>
                                <option value="fair" {{ old('condition', $equipment->condition) == 'fair' ? 'selected' : '' }}>Fair</option>
                                <option value="poor" {{ old('condition', $equipment->condition) == 'poor' ? 'selected' : '' }}>Poor</option>
                            </select>
                            @error('condition')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
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
                                <option value="active" {{ old('status', $equipment->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $equipment->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="maintenance" {{ old('status', $equipment->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="retired" {{ old('status', $equipment->status) == 'retired' ? 'selected' : '' }}>Retired</option>
                            </select>
                            @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
                            Location <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="location"
                               id="location"
                               list="location-suggestions"
                               value="{{ old('location', $equipment->location) }}"
                               required
                               class="form-input w-full @error('location') border-red-500 @enderror">
                        <datalist id="location-suggestions">
                            @foreach($locations as $loc)
                            <option value="{{ $loc }}">
                            @endforeach
                        </datalist>
                        @error('location')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Assigned To -->
                    <div>
                        <label for="assigned_to" class="block text-sm font-medium text-gray-700 mb-1">
                            Assigned To
                        </label>
                        <input type="text"
                               name="assigned_to"
                               id="assigned_to"
                               value="{{ old('assigned_to', $equipment->assigned_to) }}"
                               class="form-input w-full @error('assigned_to') border-red-500 @enderror">
                        @error('assigned_to')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Maintenance -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Maintenance Schedule</h2>
                </div>
                <div class="card-body space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Last Service Date -->
                        <div>
                            <label for="last_service_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Last Service Date
                            </label>
                            <input type="date"
                                   name="last_service_date"
                                   id="last_service_date"
                                   value="{{ old('last_service_date', $equipment->last_service_date?->format('Y-m-d')) }}"
                                   max="{{ date('Y-m-d') }}"
                                   class="form-input w-full @error('last_service_date') border-red-500 @enderror">
                            @error('last_service_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Next Service Date -->
                        <div>
                            <label for="next_service_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Next Service Date
                            </label>
                            <input type="date"
                                   name="next_service_date"
                                   id="next_service_date"
                                   value="{{ old('next_service_date', $equipment->next_service_date?->format('Y-m-d')) }}"
                                   min="{{ date('Y-m-d') }}"
                                   class="form-input w-full @error('next_service_date') border-red-500 @enderror">
                            @error('next_service_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Maintenance Notes -->
                    <div>
                        <label for="maintenance_notes" class="block text-sm font-medium text-gray-700 mb-1">
                            Maintenance Notes
                        </label>
                        <textarea name="maintenance_notes"
                                  id="maintenance_notes"
                                  rows="4"
                                  class="form-textarea w-full @error('maintenance_notes') border-red-500 @enderror"
                                  placeholder="History of maintenance performed...">{{ old('maintenance_notes', $equipment->maintenance_notes) }}</textarea>
                        @error('maintenance_notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Note: Use the "Record Maintenance" feature to add new maintenance entries instead of editing this directly.</p>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('equipment.show', $equipment) }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Update Equipment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
