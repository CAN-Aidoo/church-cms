@extends('layouts.app')

@section('title', 'Edit Partner')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('partnerships.partners.show', $partner) }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit Partner</h1>
        </div>
        <p class="text-gray-600">Update partner information</p>
    </div>

    <div class="max-w-4xl">
        <form method="POST" action="{{ route('partnerships.partners.update', $partner) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Partner Information</h2>
                </div>
                <div class="card-body space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Partner Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $partner->name) }}" required class="form-input w-full @error('name') border-red-500 @enderror">
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category" id="category" required class="form-select w-full @error('category') border-red-500 @enderror">
                                <option value="">Select Category</option>
                                <option value="ministry" {{ old('category', $partner->category) == 'ministry' ? 'selected' : '' }}>Ministry</option>
                                <option value="mission" {{ old('category', $partner->category) == 'mission' ? 'selected' : '' }}>Mission</option>
                                <option value="corporate_sponsor" {{ old('category', $partner->category) == 'corporate_sponsor' ? 'selected' : '' }}>Corporate Sponsor</option>
                                <option value="sister_church" {{ old('category', $partner->category) == 'sister_church' ? 'selected' : '' }}>Sister Church</option>
                                <option value="international" {{ old('category', $partner->category) == 'international' ? 'selected' : '' }}>International</option>
                                <option value="media" {{ old('category', $partner->category) == 'media' ? 'selected' : '' }}>Media</option>
                                <option value="other" {{ old('category', $partner->category) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_person" class="block text-sm font-medium text-gray-700 mb-1">Contact Person</label>
                            <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $partner->contact_person) }}" class="form-input w-full @error('contact_person') border-red-500 @enderror">
                            @error('contact_person')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $partner->email) }}" class="form-input w-full @error('email') border-red-500 @enderror">
                            @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $partner->phone) }}" class="form-input w-full @error('phone') border-red-500 @enderror">
                            @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea name="address" id="address" rows="2" class="form-textarea w-full @error('address') border-red-500 @enderror">{{ old('address', $partner->address) }}</textarea>
                        @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="4" class="form-textarea w-full @error('description') border-red-500 @enderror">{{ old('description', $partner->description) }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('partnerships.partners.show', $partner) }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
