@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('shepherds.index') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Appoint New Shepherd</h1>
        </div>
        <p class="text-gray-600">Select a member to appoint as shepherd</p>
    </div>

    <div class="max-w-3xl">
        <form method="POST" action="{{ route('shepherds.store') }}" class="space-y-6">
            @csrf

            <!-- Member Selection -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Select Member</h2>
                </div>
                <div class="card-body space-y-4">
                    <div>
                        <label for="member_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Member <span class="text-red-500">*</span>
                        </label>
                        <select name="member_id"
                                id="member_id"
                                required
                                class="form-select w-full @error('member_id') border-red-500 @enderror">
                            <option value="">Select a member...</option>
                            @foreach($availableMembers as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->full_name }} - {{ $member->phone }}
                            </option>
                            @endforeach
                        </select>
                        @error('member_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Select an active member who is not already a shepherd</p>
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
                               value="{{ old('flock_name') }}"
                               required
                               class="form-input w-full @error('flock_name') border-red-500 @enderror"
                               placeholder="e.g., Covenant Flock, Faith Family, Grace Group">
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
                                  class="form-textarea w-full @error('description') border-red-500 @enderror"
                                  placeholder="Brief description of the flock (geographical area, focus, etc.)">{{ old('description') }}</textarea>
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
                               value="{{ old('max_flock_size', 15) }}"
                               required
                               min="1"
                               max="20"
                               class="form-input w-full @error('max_flock_size') border-red-500 @enderror">
                        @error('max_flock_size')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Recommended: 12-15 members per shepherd</p>
                    </div>

                    <!-- Appointed Date -->
                    <div>
                        <label for="appointed_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Appointment Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date"
                               name="appointed_date"
                               id="appointed_date"
                               value="{{ old('appointed_date', date('Y-m-d')) }}"
                               required
                               max="{{ date('Y-m-d') }}"
                               class="form-input w-full @error('appointed_date') border-red-500 @enderror">
                        @error('appointed_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                            Notes
                        </label>
                        <textarea name="notes"
                                  id="notes"
                                  rows="3"
                                  class="form-textarea w-full @error('notes') border-red-500 @enderror"
                                  placeholder="Any additional notes or instructions...">{{ old('notes') }}</textarea>
                        @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Guidelines Card -->
            <div class="card bg-blue-50 border-blue-200">
                <div class="card-body">
                    <h3 class="font-semibold text-blue-800 mb-2">
                        <i class="fas fa-info-circle mr-2"></i>Shepherd Guidelines
                    </h3>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li><i class="fas fa-check mr-2"></i>Shepherds should have 12-15 members in their flock</li>
                        <li><i class="fas fa-check mr-2"></i>Conduct at least one flock meeting per month</li>
                        <li><i class="fas fa-check mr-2"></i>Visit each member at least once per quarter</li>
                        <li><i class="fas fa-check mr-2"></i>Submit weekly or monthly reports on flock activities</li>
                        <li><i class="fas fa-check mr-2"></i>Follow up on absent members within 2 weeks</li>
                    </ul>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('shepherds.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check mr-2"></i>Appoint Shepherd
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
