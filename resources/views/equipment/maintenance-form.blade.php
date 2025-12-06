@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('equipment.show', $equipment) }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Record Maintenance</h1>
        </div>
        <p class="text-gray-600">{{ $equipment->name }}</p>
    </div>

    <div class="max-w-2xl">
        <!-- Equipment Info Card -->
        <div class="card mb-6">
            <div class="card-body">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600 mb-1">Category</p>
                        <p class="font-medium">{{ $equipment->category }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Location</p>
                        <p class="font-medium">{{ $equipment->location }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Last Service</p>
                        <p class="font-medium">
                            @if($equipment->last_service_date)
                            {{ $equipment->last_service_date->format('M d, Y') }}
                            @else
                            Never
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Status</p>
                        <span class="badge
                            @if($equipment->status === 'active') badge-success
                            @elseif($equipment->status === 'maintenance') badge-warning
                            @else badge-secondary
                            @endif">
                            {{ ucfirst($equipment->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Maintenance Form -->
        <form method="POST" action="{{ route('equipment.maintenance.record', $equipment) }}" class="space-y-6">
            @csrf

            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Maintenance Details</h2>
                </div>
                <div class="card-body space-y-4">
                    <!-- Service Date -->
                    <div>
                        <label for="service_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Service Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date"
                               name="service_date"
                               id="service_date"
                               value="{{ old('service_date', date('Y-m-d')) }}"
                               required
                               max="{{ date('Y-m-d') }}"
                               class="form-input w-full @error('service_date') border-red-500 @enderror">
                        @error('service_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                            Maintenance Notes <span class="text-red-500">*</span>
                        </label>
                        <textarea name="notes"
                                  id="notes"
                                  rows="4"
                                  required
                                  class="form-textarea w-full @error('notes') border-red-500 @enderror"
                                  placeholder="Describe the maintenance performed, parts replaced, issues found, etc.">{{ old('notes') }}</textarea>
                        @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Be detailed to maintain a complete maintenance history</p>
                    </div>

                    <!-- Cost -->
                    <div>
                        <label for="cost" class="block text-sm font-medium text-gray-700 mb-1">
                            Maintenance Cost (GHS)
                        </label>
                        <input type="number"
                               name="cost"
                               id="cost"
                               value="{{ old('cost') }}"
                               min="0"
                               step="0.01"
                               class="form-input w-full @error('cost') border-red-500 @enderror"
                               placeholder="0.00">
                        @error('cost')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Leave blank if no cost incurred</p>
                    </div>

                    <!-- Next Service Schedule -->
                    <div class="pt-4 border-t border-gray-200">
                        <label for="next_service_months" class="block text-sm font-medium text-gray-700 mb-1">
                            Schedule Next Service
                        </label>
                        <select name="next_service_months"
                                id="next_service_months"
                                class="form-select w-full @error('next_service_months') border-red-500 @enderror">
                            <option value="1">1 month</option>
                            <option value="2">2 months</option>
                            <option value="3">3 months</option>
                            <option value="6" selected>6 months</option>
                            <option value="12">12 months</option>
                            <option value="24">24 months</option>
                        </select>
                        @error('next_service_months')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Next service will be automatically scheduled</p>
                    </div>
                </div>
            </div>

            <!-- Previous Maintenance History -->
            @if($equipment->maintenance_notes)
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Previous Maintenance History</h2>
                </div>
                <div class="card-body">
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        @foreach(array_reverse(explode("\n", $equipment->maintenance_notes)) as $note)
                        @if(trim($note))
                        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-wrench text-blue-600 mt-1"></i>
                            <p class="text-sm text-gray-700">{{ $note }}</p>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('equipment.show', $equipment) }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Record Maintenance
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
