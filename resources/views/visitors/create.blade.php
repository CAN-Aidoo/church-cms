@extends('layouts.app')

@section('title', 'Register Visitor')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Register New Visitor</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('visitors.index') }}">Visitors</a>
            <span>/</span>
            <span>Register</span>
        </nav>
    </div>
</div>

<form action="{{ route('visitors.store') }}" method="POST" class="max-w-4xl">
    @csrf

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
                                   value="{{ old('first_name') }}"
                                   class="form-input @error('first_name') form-input-error @enderror"
                                   required>
                            @error('first_name')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="last_name" class="form-label required">Last Name</label>
                            <input type="text" id="last_name" name="last_name"
                                   value="{{ old('last_name') }}"
                                   class="form-input @error('last_name') form-input-error @enderror"
                                   required>
                            @error('last_name')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email') }}"
                                   placeholder="visitor@example.com"
                                   class="form-input @error('email') form-input-error @enderror">
                            @error('email')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="form-label required">Phone</label>
                            <input type="tel" id="phone" name="phone"
                                   value="{{ old('phone') }}"
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
                                   value="{{ old('address') }}"
                                   placeholder="Street address"
                                   class="form-input @error('address') form-input-error @enderror">
                            @error('address')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="form-label">City</label>
                            <input type="text" id="city" name="city"
                                   value="{{ old('city') }}"
                                   class="form-input @error('city') form-input-error @enderror">
                            @error('city')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="state" class="form-label">State/Region</label>
                            <input type="text" id="state" name="state"
                                   value="{{ old('state') }}"
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
                    <h3 class="card-title">Visit Information</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_visit_date" class="form-label">First Visit Date</label>
                            <input type="date" id="first_visit_date" name="first_visit_date"
                                   value="{{ old('first_visit_date', date('Y-m-d')) }}"
                                   class="form-input @error('first_visit_date') form-input-error @enderror">
                            @error('first_visit_date')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Defaults to today if not specified</p>
                        </div>

                        <div>
                            <label for="referral_source" class="form-label">How did you hear about us?</label>
                            <select id="referral_source" name="referral_source"
                                    class="form-select @error('referral_source') form-input-error @enderror">
                                <option value="">Select source</option>
                                <option value="member_invite" {{ old('referral_source') === 'member_invite' ? 'selected' : '' }}>Member Invitation</option>
                                <option value="social_media" {{ old('referral_source') === 'social_media' ? 'selected' : '' }}>Social Media</option>
                                <option value="website" {{ old('referral_source') === 'website' ? 'selected' : '' }}>Website</option>
                                <option value="walk_in" {{ old('referral_source') === 'walk_in' ? 'selected' : '' }}>Walk-in</option>
                                <option value="event" {{ old('referral_source') === 'event' ? 'selected' : '' }}>Church Event</option>
                                <option value="friend_family" {{ old('referral_source') === 'friend_family' ? 'selected' : '' }}>Friend/Family</option>
                                <option value="other" {{ old('referral_source') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('referral_source')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="interests" class="form-label">Areas of Interest</label>
                            <textarea id="interests" name="interests" rows="2"
                                      class="form-textarea @error('interests') form-input-error @enderror"
                                      placeholder="e.g., Youth ministry, Music, Volunteering...">{{ old('interests') }}</textarea>
                            @error('interests')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="form-textarea @error('notes') form-input-error @enderror"
                                      placeholder="Any additional information or prayer requests...">{{ old('notes') }}</textarea>
                            @error('notes')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="space-y-6">
            <!-- Quick Info -->
            <div class="card bg-blue-50 border-blue-200">
                <div class="card-body">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-blue-900 mb-2">Visitor Registration</h4>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• Collect basic contact information</li>
                                <li>• Record how they found the church</li>
                                <li>• Track visit count automatically</li>
                                <li>• Eligible for conversion after 5 visits</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5-Visit Conversion Rule -->
            <div class="card bg-gradient-gold">
                <div class="card-body text-white">
                    <div class="flex items-center gap-3 mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <div>
                            <div class="text-2xl font-bold">5-Visit Rule</div>
                            <div class="text-sm opacity-90">Conversion to Membership</div>
                        </div>
                    </div>
                    <p class="text-sm opacity-90">
                        After a visitor attends 5 services, they become eligible for membership conversion with full member privileges.
                    </p>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-body space-y-3">
                    <button type="submit" class="btn btn-primary w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Register Visitor
                    </button>
                    <a href="{{ route('visitors.index') }}" class="btn btn-secondary w-full">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
