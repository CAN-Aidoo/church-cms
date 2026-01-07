@extends('layouts.app')

@section('title', 'Register Visitor')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Register New Visitor</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('visitors.index') }}" class="hover:text-primary-600 transition-colors">Visitors</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Register</span>
        </nav>
    </div>
</div>

<form action="{{ route('visitors.store') }}" method="POST" class="max-w-5xl mx-auto">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="card border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Personal Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">First Name</label>
                            <input type="text" id="first_name" name="first_name"
                                   value="{{ old('first_name') }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('first_name') border-red-500 @enderror"
                                   required>
                            @error('first_name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="last_name" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Last Name</label>
                            <input type="text" id="last_name" name="last_name"
                                   value="{{ old('last_name') }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('last_name') border-red-500 @enderror"
                                   required>
                            @error('last_name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Email</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email') }}"
                                   placeholder="visitor@example.com"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('email') border-red-500 @enderror">
                            @error('email')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Phone</label>
                            <input type="tel" id="phone" name="phone"
                                   value="{{ old('phone') }}"
                                   placeholder="+233XXXXXXXXX"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('phone') border-red-500 @enderror"
                                   required>
                            @error('phone')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Address</label>
                            <input type="text" id="address" name="address"
                                   value="{{ old('address') }}"
                                   placeholder="Street address"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('address') border-red-500 @enderror">
                            @error('address')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="form-label mb-1.5 block font-medium text-sm text-slate-700">City</label>
                            <input type="text" id="city" name="city"
                                   value="{{ old('city') }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('city') border-red-500 @enderror">
                            @error('city')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="state" class="form-label mb-1.5 block font-medium text-sm text-slate-700">State/Region</label>
                            <input type="text" id="state" name="state"
                                   value="{{ old('state') }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('state') border-red-500 @enderror">
                            @error('state')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visit & Additional Information -->
            <div class="card border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Visit Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_visit_date" class="form-label mb-1.5 block font-medium text-sm text-slate-700">First Visit Date</label>
                            <input type="date" id="first_visit_date" name="first_visit_date"
                                   value="{{ old('first_visit_date', date('Y-m-d')) }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('first_visit_date') border-red-500 @enderror">
                            @error('first_visit_date')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-slate-500 mt-1">Defaults to today if not specified</p>
                        </div>

                        <div>
                            <label for="referral_source" class="form-label mb-1.5 block font-medium text-sm text-slate-700">How did you hear about us?</label>
                            <select id="referral_source" name="referral_source"
                                    class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('referral_source') border-red-500 @enderror">
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
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="interests" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Areas of Interest</label>
                            <textarea id="interests" name="interests" rows="2"
                                      class="form-textarea w-full rounded-xl border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('interests') border-red-500 @enderror"
                                      placeholder="e.g., Youth ministry, Music, Volunteering...">{{ old('interests') }}</textarea>
                            @error('interests')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="notes" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="form-textarea w-full rounded-xl border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('notes') border-red-500 @enderror"
                                      placeholder="Any additional information or prayer requests...">{{ old('notes') }}</textarea>
                            @error('notes')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="space-y-6">
            <!-- Quick Info -->
            <div class="card p-6 border-l-4 border-l-blue-500 bg-blue-50/50 border-y border-r border-blue-100">
                <div class="flex items-start gap-4">
                    <div class="p-2 bg-blue-100 text-blue-600 rounded-lg flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-blue-900 text-lg mb-2">Visitor Registration</h4>
                        <ul class="text-sm text-blue-800 space-y-1.5 list-disc list-inside">
                            <li>Collect basic contact information</li>
                            <li>Record how they found the church</li>
                            <li>Track visit count automatically</li>
                            <li>Eligible for conversion after 5 visits</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 5-Visit Conversion Rule -->
            <div class="card p-6 border-l-4 border-l-amber-500 bg-gradient-to-br from-amber-500 to-amber-600 text-white shadow-lg shadow-amber-500/20">
                <div class="flex items-center gap-3 mb-4">
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <div>
                        <div class="text-xl font-heading font-bold">5-Visit Rule</div>
                        <div class="text-sm font-medium opacity-90">Conversion to Membership</div>
                    </div>
                </div>
                <p class="text-sm leading-relaxed opacity-95">
                    After a visitor attends 5 services, they become eligible for membership conversion with full member privileges.
                </p>
            </div>

            <!-- Actions -->
            <div class="card border border-slate-100">
                <div class="p-6 space-y-3">
                    <button type="submit" class="btn btn-primary w-full shadow-lg shadow-primary-500/30">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Register Visitor
                    </button>
                    <a href="{{ route('visitors.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 w-full justify-center">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
