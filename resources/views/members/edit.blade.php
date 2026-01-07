@extends('layouts.app')

@section('title', 'Edit Member')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Edit Member</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('members.index') }}" class="hover:text-primary-600 transition-colors">Members</a>
            <span>/</span>
            <a href="{{ route('members.show', $member) }}" class="hover:text-primary-600 transition-colors">{{ $member->full_name }}</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Edit</span>
        </nav>
    </div>
</div>

<form action="{{ route('members.update', $member) }}" method="POST" enctype="multipart/form-data" class="max-w-6xl mx-auto">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Personal Information -->
            <div class="card border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Personal Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="form-label required">First Name</label>
                            <input type="text" id="first_name" name="first_name"
                                   value="{{ old('first_name', $member->first_name) }}"
                                   class="form-input w-full @error('first_name') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                   required>
                            @error('first_name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="last_name" class="form-label required">Last Name</label>
                            <input type="text" id="last_name" name="last_name"
                                   value="{{ old('last_name', $member->last_name) }}"
                                   class="form-input w-full @error('last_name') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                   required>
                            @error('last_name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="date_of_birth" class="form-label required">Date of Birth</label>
                            <input type="date" id="date_of_birth" name="date_of_birth"
                                   value="{{ old('date_of_birth', $member->date_of_birth?->format('Y-m-d')) }}"
                                   max="{{ date('Y-m-d') }}"
                                   class="form-input w-full @error('date_of_birth') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                   required>
                            @error('date_of_birth')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="gender" class="form-label required">Gender</label>
                            <div class="relative">
                                <select id="gender" name="gender"
                                        class="form-select w-full @error('gender') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                        required>
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $member->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $member->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $member->gender) === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            @error('gender')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="marital_status" class="form-label required">Marital Status</label>
                            <div class="relative">
                                <select id="marital_status" name="marital_status"
                                        class="form-select w-full @error('marital_status') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                        required>
                                    <option value="">Select Status</option>
                                    <option value="single" {{ old('marital_status', $member->marital_status) === 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="married" {{ old('marital_status', $member->marital_status) === 'married' ? 'selected' : '' }}>Married</option>
                                    <option value="divorced" {{ old('marital_status', $member->marital_status) === 'divorced' ? 'selected' : '' }}>Divorced</option>
                                    <option value="widowed" {{ old('marital_status', $member->marital_status) === 'widowed' ? 'selected' : '' }}>Widowed</option>
                                </select>
                            </div>
                            @error('marital_status')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="occupation" class="form-label">Occupation</label>
                            <input type="text" id="occupation" name="occupation"
                                   value="{{ old('occupation', $member->occupation) }}"
                                   class="form-input w-full @error('occupation') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                            @error('occupation')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Contact Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="form-label required">Email Address</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email', $member->email) }}"
                                   class="form-input w-full @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                   required>
                            @error('email')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="form-label required">Phone Number</label>
                            <input type="tel" id="phone" name="phone"
                                   value="{{ old('phone', $member->phone) }}"
                                   class="form-input w-full @error('phone') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                   required>
                            @error('phone')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="form-label required">Street Address</label>
                            <input type="text" id="address" name="address"
                                   value="{{ old('address', $member->address) }}"
                                   class="form-input w-full @error('address') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                   required>
                            @error('address')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="form-label">City</label>
                            <input type="text" id="city" name="city"
                                   value="{{ old('city', $member->city) }}"
                                   class="form-input w-full @error('city') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                            @error('city')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="state" class="form-label">State/Region</label>
                            <input type="text" id="state" name="state"
                                   value="{{ old('state', $member->state) }}"
                                   class="form-input w-full @error('state') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                            @error('state')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="country" class="form-label required">Country</label>
                            <input type="text" id="country" name="country"
                                   value="{{ old('country', $member->country) }}"
                                   class="form-input w-full @error('country') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                   required>
                            @error('country')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="postal_code" class="form-label">Postal Code</label>
                            <input type="text" id="postal_code" name="postal_code"
                                   value="{{ old('postal_code', $member->postal_code) }}"
                                   class="form-input w-full @error('postal_code') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                            @error('postal_code')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="card border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Emergency Contact</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="emergency_contact_name" class="form-label">Contact Name</label>
                            <input type="text" id="emergency_contact_name" name="emergency_contact_name"
                                   value="{{ old('emergency_contact_name', $member->emergency_contact_name) }}"
                                   class="form-input w-full @error('emergency_contact_name') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                            @error('emergency_contact_name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="emergency_contact_phone" class="form-label">Contact Phone</label>
                            <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone"
                                   value="{{ old('emergency_contact_phone', $member->emergency_contact_phone) }}"
                                   class="form-input w-full @error('emergency_contact_phone') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                            @error('emergency_contact_phone')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Notes -->
            <div class="card border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Additional Notes</h3>
                </div>
                <div class="p-6">
                    <div>
                        <label for="notes" class="form-label">Notes</label>
                        <textarea id="notes" name="notes" rows="4"
                                  class="form-textarea w-full rounded-xl border-slate-200 focus:border-primary-500 focus:ring-primary-500 transition-colors @error('notes') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('notes', $member->notes) }}</textarea>
                        @error('notes')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-slate-500 mt-1">Any additional information about this member</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Membership Details -->
            <div class="card border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Membership Details</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="form-label text-xs uppercase tracking-wider text-slate-500 font-bold mb-1">Member ID</label>
                        <input type="text" value="{{ $member->member_id }}"
                               class="form-input w-full bg-slate-50 text-slate-500 font-mono text-sm" readonly>
                    </div>

                    <div>
                        <label for="join_date" class="form-label required">Join Date</label>
                        <input type="date" id="join_date" name="join_date"
                               value="{{ old('join_date', $member->join_date->format('Y-m-d')) }}"
                               class="form-input w-full @error('join_date') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                               required>
                        @error('join_date')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="member_status" class="form-label">Member Status</label>
                        <div class="relative">
                            <select id="member_status" name="member_status"
                                    class="form-select w-full @error('member_status') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                                <option value="active" {{ old('member_status', $member->member_status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="pending" {{ old('member_status', $member->member_status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="inactive" {{ old('member_status', $member->member_status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="suspended" {{ old('member_status', $member->member_status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                        </div>
                        @error('member_status')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="department" class="form-label">Department</label>
                        <input type="text" id="department" name="department"
                               value="{{ old('department', $member->department) }}"
                               class="form-input w-full @error('department') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                               placeholder="e.g., Choir, Ushering">
                        @error('department')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Photo Upload -->
            <div class="card border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Member Photo</h3>
                </div>
                <div class="p-6" x-data="{ photoPreview: '{{ $member->photo_url ? Storage::url($member->photo_url) : '' }}' }">
                    <div class="text-center">
                        <div class="mb-4">
                            <div x-show="!photoPreview" class="mx-auto w-32 h-32 rounded-full bg-slate-100 flex items-center justify-center border-4 border-white shadow-lg">
                                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <img x-show="photoPreview" :src="photoPreview"
                                 class="mx-auto w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg"
                                 style="display: none;">
                        </div>

                        <input type="file" id="photo" name="photo" accept="image/*"
                               class="hidden"
                               @change="
                                   const file = $event.target.files[0];
                                   if (file) {
                                       const reader = new FileReader();
                                       reader.onload = e => photoPreview = e.target.result;
                                       reader.readAsDataURL(file);
                                   }
                               ">

                        <label for="photo" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 shadow-sm cursor-pointer w-full flex items-center justify-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Change Photo
                        </label>

                        @if($member->photo_url)
                        <form action="{{ route('members.delete-photo', $member) }}" method="POST" class="inline-block w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm w-full bg-red-50 text-red-600 hover:bg-red-100 border border-transparent"
                                    onclick="return confirm('Are you sure you want to delete this photo?')">
                                Remove Photo
                            </button>
                        </form>
                        @endif

                        @error('photo')
                        <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                        @enderror

                        <p class="text-xs text-slate-400 mt-2">
                            JPG, PNG up to 2MB
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="card border border-slate-100">
                <div class="p-6 space-y-3">
                    <button type="submit" class="btn btn-primary w-full flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Member
                    </button>
                    <a href="{{ route('members.show', $member) }}" class="btn block text-center w-full bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300">
                        Cancel
                    </a>
                    
                    @if(auth()->user()->hasAnyRole(['admin', 'pastor']))
                    <div class="pt-4 mt-4 border-t border-slate-100">
                        <button type="button"
                                onclick="if(confirm('Are you sure you want to delete this member? This action cannot be undone.')) { document.getElementById('delete-form').submit(); }"
                                class="btn w-full bg-red-50 text-red-600 hover:bg-red-100 border border-transparent flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Member
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>

@if(auth()->user()->hasAnyRole(['admin', 'pastor']))
<form id="delete-form" action="{{ route('members.destroy', $member) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif
@endsection
