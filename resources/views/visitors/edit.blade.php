@extends('layouts.app')

@section('title', 'Edit Visitor')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Visitor</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('visitors.index') }}">Visitors</a>
            <span>/</span>
            <a href="{{ route('visitors.show', $visitor) }}">{{ $visitor->first_name }} {{ $visitor->last_name }}</a>
            <span>/</span>
            <span>Edit</span>
        </nav>
    </div>
</div>

<form action="{{ route('visitors.update', $visitor) }}" method="POST" class="max-w-4xl">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Personal Information</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="form-label required">First Name</label>
                            <input type="text" id="first_name" name="first_name"
                                   value="{{ old('first_name', $visitor->first_name) }}"
                                   class="form-input @error('first_name') form-input-error @enderror"
                                   required>
                            @error('first_name')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="last_name" class="form-label required">Last Name</label>
                            <input type="text" id="last_name" name="last_name"
                                   value="{{ old('last_name', $visitor->last_name) }}"
                                   class="form-input @error('last_name') form-input-error @enderror"
                                   required>
                            @error('last_name')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email', $visitor->email) }}"
                                   placeholder="visitor@example.com"
                                   class="form-input @error('email') form-input-error @enderror">
                            @error('email')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="form-label required">Phone</label>
                            <input type="tel" id="phone" name="phone"
                                   value="{{ old('phone', $visitor->phone) }}"
                                   placeholder="+233XXXXXXXXX"
                                   class="form-input @error('phone') form-input-error @enderror"
                                   required>
                            @error('phone')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" id="address" name="address"
                                   value="{{ old('address', $visitor->address) }}"
                                   placeholder="Street address"
                                   class="form-input @error('address') form-input-error @enderror">
                            @error('address')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="form-label">City</label>
                            <input type="text" id="city" name="city"
                                   value="{{ old('city', $visitor->city) }}"
                                   class="form-input @error('city') form-input-error @enderror">
                            @error('city')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="state" class="form-label">State/Region</label>
                            <input type="text" id="state" name="state"
                                   value="{{ old('state', $visitor->state) }}"
                                   class="form-input @error('state') form-input-error @enderror">
                            @error('state')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visit & Additional Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Additional Information</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="referral_source" class="form-label">How did you hear about us?</label>
                            <select id="referral_source" name="referral_source"
                                    class="form-select @error('referral_source') form-input-error @enderror">
                                <option value="">Select source</option>
                                <option value="member_invite" {{ old('referral_source', $visitor->referral_source) === 'member_invite' ? 'selected' : '' }}>Member Invitation</option>
                                <option value="social_media" {{ old('referral_source', $visitor->referral_source) === 'social_media' ? 'selected' : '' }}>Social Media</option>
                                <option value="website" {{ old('referral_source', $visitor->referral_source) === 'website' ? 'selected' : '' }}>Website</option>
                                <option value="walk_in" {{ old('referral_source', $visitor->referral_source) === 'walk_in' ? 'selected' : '' }}>Walk-in</option>
                                <option value="event" {{ old('referral_source', $visitor->referral_source) === 'event' ? 'selected' : '' }}>Church Event</option>
                                <option value="friend_family" {{ old('referral_source', $visitor->referral_source) === 'friend_family' ? 'selected' : '' }}>Friend/Family</option>
                                <option value="other" {{ old('referral_source', $visitor->referral_source) === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('referral_source')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="form-label required">Status</label>
                            <select id="status" name="status"
                                    class="form-select @error('status') form-input-error @enderror"
                                    required>
                                <option value="active" {{ old('status', $visitor->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $visitor->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="interests" class="form-label">Areas of Interest</label>
                            <textarea id="interests" name="interests" rows="2"
                                      class="form-textarea @error('interests') form-input-error @enderror"
                                      placeholder="e.g., Youth ministry, Music, Volunteering...">{{ old('interests', $visitor->interests) }}</textarea>
                            @error('interests')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="form-textarea @error('notes') form-input-error @enderror"
                                      placeholder="Any additional information or prayer requests...">{{ old('notes', $visitor->notes) }}</textarea>
                            @error('notes')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Visit Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Visit Information</h3>
                </div>
                <div class="card-body">
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm text-gray-500">Total Visits</dt>
                            <dd class="text-2xl font-bold text-blue-600">{{ $visitor->visit_count }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">First Visit</dt>
                            <dd class="text-sm font-medium">{{ $visitor->first_visit_date?->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Last Visit</dt>
                            <dd class="text-sm font-medium">{{ $visitor->last_visit_date?->format('M d, Y') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-body space-y-3">
                    <button type="submit" class="btn btn-primary w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Visitor
                    </button>
                    <a href="{{ route('visitors.show', $visitor) }}" class="btn btn-secondary w-full">
                        Cancel
                    </a>
                </div>
            </div>

            <!-- Warning -->
            <div class="card bg-yellow-50 border-yellow-200">
                <div class="card-body">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-yellow-900 mb-1">Note</h4>
                            <p class="text-sm text-yellow-800">
                                Visit count and dates are updated automatically when recording visits. They cannot be manually edited.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
