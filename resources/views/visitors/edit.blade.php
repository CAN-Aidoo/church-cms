@extends('layouts.app')

@section('title', 'Edit Visitor')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Edit Visitor</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('visitors.index') }}" class="hover:text-primary-600 transition-colors">Visitors</a>
            <span>/</span>
            <a href="{{ route('visitors.show', $visitor) }}" class="hover:text-primary-600 transition-colors">{{ $visitor->first_name }} {{ $visitor->last_name }}</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Edit</span>
        </nav>
    </div>
</div>

<form action="{{ route('visitors.update', $visitor) }}" method="POST" class="max-w-5xl mx-auto">
    @csrf
    @method('PUT')

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
                                   value="{{ old('first_name', $visitor->first_name) }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('first_name') border-red-500 @enderror"
                                   required>
                            @error('first_name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="last_name" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Last Name</label>
                            <input type="text" id="last_name" name="last_name"
                                   value="{{ old('last_name', $visitor->last_name) }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('last_name') border-red-500 @enderror"
                                   required>
                            @error('last_name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Email</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email', $visitor->email) }}"
                                   placeholder="visitor@example.com"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('email') border-red-500 @enderror">
                            @error('email')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Phone</label>
                            <input type="tel" id="phone" name="phone"
                                   value="{{ old('phone', $visitor->phone) }}"
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
                                   value="{{ old('address', $visitor->address) }}"
                                   placeholder="Street address"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('address') border-red-500 @enderror">
                            @error('address')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="form-label mb-1.5 block font-medium text-sm text-slate-700">City</label>
                            <input type="text" id="city" name="city"
                                   value="{{ old('city', $visitor->city) }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('city') border-red-500 @enderror">
                            @error('city')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="state" class="form-label mb-1.5 block font-medium text-sm text-slate-700">State/Region</label>
                            <input type="text" id="state" name="state"
                                   value="{{ old('state', $visitor->state) }}"
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
                    <h3 class="font-bold text-slate-800 text-base">Additional Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="referral_source" class="form-label mb-1.5 block font-medium text-sm text-slate-700">How did you hear about us?</label>
                            <select id="referral_source" name="referral_source"
                                    class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('referral_source') border-red-500 @enderror">
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
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Status</label>
                            <select id="status" name="status"
                                    class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('status') border-red-500 @enderror"
                                    required>
                                <option value="active" {{ old('status', $visitor->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $visitor->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="interests" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Areas of Interest</label>
                            <textarea id="interests" name="interests" rows="2"
                                      class="form-textarea w-full rounded-xl border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('interests') border-red-500 @enderror"
                                      placeholder="e.g., Youth ministry, Music, Volunteering...">{{ old('interests', $visitor->interests) }}</textarea>
                            @error('interests')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="notes" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="form-textarea w-full rounded-xl border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('notes') border-red-500 @enderror"
                                      placeholder="Any additional information or prayer requests...">{{ old('notes', $visitor->notes) }}</textarea>
                            @error('notes')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Visit Information -->
            <div class="card border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Visit Information</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div class="pb-4 border-b border-slate-50 last:border-0 last:pb-0">
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Visits</dt>
                            <dd class="text-3xl font-heading font-bold text-primary-600">{{ $visitor->visit_count }}</dd>
                        </div>
                        <div class="pb-4 border-b border-slate-50 last:border-0 last:pb-0">
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">First Visit</dt>
                            <dd class="text-sm font-medium text-slate-900">{{ $visitor->first_visit_date?->format('M d, Y') }}</dd>
                        </div>
                        <div class="pb-4 border-b border-slate-50 last:border-0 last:pb-0">
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Last Visit</dt>
                            <dd class="text-sm font-medium text-slate-900">{{ $visitor->last_visit_date?->format('M d, Y') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Actions -->
            <div class="card border border-slate-100">
                <div class="p-6 space-y-3">
                    <button type="submit" class="btn btn-primary w-full shadow-lg shadow-primary-500/30">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Update Visitor
                    </button>
                    <a href="{{ route('visitors.show', $visitor) }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 w-full justify-center">
                        Cancel
                    </a>
                </div>
            </div>

            <!-- Warning -->
            <div class="card p-6 border-l-4 border-l-amber-500 bg-amber-50/50 border-y border-r border-amber-100">
                <div class="flex items-start gap-3">
                    <div class="text-amber-500 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-amber-900 text-sm mb-1">Note</h4>
                        <p class="text-sm text-amber-800 leading-relaxed">
                            Visit count and dates are updated automatically when recording visits. They cannot be manually edited here.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
