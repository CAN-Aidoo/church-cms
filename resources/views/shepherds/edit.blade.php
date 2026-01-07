@extends('layouts.app')

@section('title', 'Edit Shepherd')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Edit Shepherd</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('shepherds.index') }}" class="hover:text-primary-600 transition-colors">Shepherds</a>
            <span>/</span>
            <a href="{{ route('shepherds.show', $shepherd) }}" class="hover:text-primary-600 transition-colors">{{ $shepherd->full_name }}</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Edit</span>
        </nav>
    </div>
</div>

<form method="POST" action="{{ route('shepherds.update', $shepherd) }}" class="max-w-5xl mx-auto">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Flock Details -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Flock Details</h3>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Flock Name -->
                    <div>
                        <label for="flock_name" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Flock Name</label>
                        <input type="text"
                               name="flock_name"
                               id="flock_name"
                               value="{{ old('flock_name', $shepherd->flock_name) }}"
                               required
                               class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('flock_name') border-red-500 @enderror">
                        @error('flock_name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Description</label>
                        <textarea name="description"
                                  id="description"
                                  rows="3"
                                  class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl @error('description') border-red-500 @enderror">{{ old('description', $shepherd->description) }}</textarea>
                        @error('description')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Max Flock Size -->
                        <div>
                            <label for="max_flock_size" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Maximum Flock Size</label>
                            <input type="number"
                                   name="max_flock_size"
                                   id="max_flock_size"
                                   value="{{ old('max_flock_size', $shepherd->max_flock_size) }}"
                                   required
                                   min="1"
                                   max="20"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('max_flock_size') border-red-500 @enderror">
                            @error('max_flock_size')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-slate-500 mt-1">Current Size: {{ $shepherd->current_flock_size }} members</p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Status</label>
                            <select name="status"
                                    id="status"
                                    required
                                    class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('status') border-red-500 @enderror">
                                <option value="active" {{ old('status', $shepherd->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="on_leave" {{ old('status', $shepherd->status) == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                <option value="inactive" {{ old('status', $shepherd->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Appointed Date -->
                    <div>
                        <label for="appointed_date" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Appointment Date</label>
                        <input type="date"
                               name="appointed_date"
                               id="appointed_date"
                               value="{{ old('appointed_date', $shepherd->appointed_date->format('Y-m-d')) }}"
                               required
                               max="{{ date('Y-m-d') }}"
                               class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('appointed_date') border-red-500 @enderror">
                        @error('appointed_date')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Date (Optional) -->
                    <div>
                        <label for="end_date" class="form-label mb-1.5 block font-medium text-sm text-slate-700">End Date (Optional)</label>
                        <input type="date"
                               name="end_date"
                               id="end_date"
                               value="{{ old('end_date', $shepherd->end_date?->format('Y-m-d')) }}"
                               class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg @error('end_date') border-red-500 @enderror">
                        @error('end_date')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-slate-500 mt-1">Leave blank if still serving</p>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Notes</label>
                        <textarea name="notes"
                                  id="notes"
                                  rows="3"
                                  class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl @error('notes') border-red-500 @enderror">{{ old('notes', $shepherd->notes) }}</textarea>
                        @error('notes')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Shepherd Information (Read-only) -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Shepherd Info</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-lg">
                            {{ substr($shepherd->full_name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900">{{ $shepherd->full_name }}</h4>
                            <p class="text-sm text-slate-500">Appointed Shepherd</p>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                        <p class="text-xs text-blue-800 flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            The shepherd assignment cannot be changed. To appoint a new shepherd, please start a new appointment process.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="p-6 space-y-3">
                    <button type="submit" class="btn btn-primary w-full shadow-lg shadow-primary-500/30">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Update Shepherd
                    </button>
                    <a href="{{ route('shepherds.show', $shepherd) }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 w-full justify-center">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
