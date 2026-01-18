@extends('layouts.app')

@section('title', 'Edit Agreement')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('partnerships.agreements.show', $agreement) }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit Agreement</h1>
        </div>
        <p class="text-gray-600">Update partnership agreement details</p>
    </div>

    <div class="max-w-4xl">
        <form method="POST" action="{{ route('partnerships.agreements.update', $agreement) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Agreement Information</h2>
                </div>
                <div class="card-body space-y-4">
                    <div>
                        <label for="agreement_title" class="block text-sm font-medium text-gray-700 mb-1">
                            Agreement Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="agreement_title" id="agreement_title" value="{{ old('agreement_title', $agreement->agreement_title) }}" required class="form-input w-full @error('agreement_title') border-red-500 @enderror">
                        @error('agreement_title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="4" class="form-textarea w-full @error('description') border-red-500 @enderror">{{ old('description', $agreement->description) }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Start Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($agreement->start_date)->format('Y-m-d')) }}" required class="form-input w-full @error('start_date') border-red-500 @enderror">
                            @error('start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $agreement->end_date ? \Carbon\Carbon::parse($agreement->end_date)->format('Y-m-d') : '') }}" class="form-input w-full @error('end_date') border-red-500 @enderror">
                            @error('end_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="financial_commitment" class="block text-sm font-medium text-gray-700 mb-1">Financial Commitment (GHS)</label>
                        <input type="number" name="financial_commitment" id="financial_commitment" step="0.01" min="0" value="{{ old('financial_commitment', $agreement->financial_commitment) }}" class="form-input w-full @error('financial_commitment') border-red-500 @enderror">
                        @error('financial_commitment')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('partnerships.agreements.show', $agreement) }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
