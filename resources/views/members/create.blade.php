@extends('layouts.app')

@section('title', 'Add New Member')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Add New Member</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('members.index') }}">Members</a>
            <span>/</span>
            <span>Add New</span>
        </nav>
    </div>
</div>

<form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data" class="max-w-5xl">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
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
                            <label for="date_of_birth" class="form-label required">Date of Birth</label>
                            <input type="date" id="date_of_birth" name="date_of_birth"
                                   value="{{ old('date_of_birth') }}"
                                   max="{{ date('Y-m-d') }}"
                                   class="form-input @error('date_of_birth') form-input-error @enderror"
                                   required>
                            @error('date_of_birth')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="gender" class="form-label required">Gender</label>
                            <select id="gender" name="gender"
                                    class="form-select @error('gender') form-input-error @enderror"
                                    required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="marital_status" class="form-label required">Marital Status</label>
                            <select id="marital_status" name="marital_status"
                                    class="form-select @error('marital_status') form-input-error @enderror"
                                    required>
                                <option value="">Select Status</option>
                                <option value="single" {{ old('marital_status') === 'single' ? 'selected' : '' }}>Single</option>
                                <option value="married" {{ old('marital_status') === 'married' ? 'selected' : '' }}>Married</option>
                                <option value="divorced" {{ old('marital_status') === 'divorced' ? 'selected' : '' }}>Divorced</option>
                                <option value="widowed" {{ old('marital_status') === 'widowed' ? 'selected' : '' }}>Widowed</option>
                            </select>
                            @error('marital_status')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="occupation" class="form-label">Occupation</label>
                            <input type="text" id="occupation" name="occupation"
                                   value="{{ old('occupation') }}"
                                   class="form-input @error('occupation') form-input-error @enderror">
                            @error('occupation')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contact Information</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="form-label required">Email Address</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email') }}"
                                   class="form-input @error('email') form-input-error @enderror"
                                   required>
                            @error('email')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="form-label required">Phone Number</label>
                            <input type="tel" id="phone" name="phone"
                                   value="{{ old('phone') }}"
                                   class="form-input @error('phone') form-input-error @enderror"
                                   required>
                            @error('phone')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="form-label required">Street Address</label>
                            <input type="text" id="address" name="address"
                                   value="{{ old('address') }}"
                                   class="form-input @error('address') form-input-error @enderror"
                                   required>
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

                        <div>
                            <label for="country" class="form-label required">Country</label>
                            <input type="text" id="country" name="country"
                                   value="{{ old('country', 'Ghana') }}"
                                   class="form-input @error('country') form-input-error @enderror"
                                   required>
                            @error('country')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="postal_code" class="form-label">Postal Code</label>
                            <input type="text" id="postal_code" name="postal_code"
                                   value="{{ old('postal_code') }}"
                                   class="form-input @error('postal_code') form-input-error @enderror">
                            @error('postal_code')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Emergency Contact</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="emergency_contact_name" class="form-label">Contact Name</label>
                            <input type="text" id="emergency_contact_name" name="emergency_contact_name"
                                   value="{{ old('emergency_contact_name') }}"
                                   class="form-input @error('emergency_contact_name') form-input-error @enderror">
                            @error('emergency_contact_name')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="emergency_contact_phone" class="form-label">Contact Phone</label>
                            <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone"
                                   value="{{ old('emergency_contact_phone') }}"
                                   class="form-input @error('emergency_contact_phone') form-input-error @enderror">
                            @error('emergency_contact_phone')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Notes -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Additional Notes</h3>
                </div>
                <div class="card-body">
                    <div>
                        <label for="notes" class="form-label">Notes</label>
                        <textarea id="notes" name="notes" rows="4"
                                  class="form-textarea @error('notes') form-input-error @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-1">Any additional information about this member</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Membership Details -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Membership Details</h3>
                </div>
                <div class="card-body space-y-4">
                    <div>
                        <label for="join_date" class="form-label required">Join Date</label>
                        <input type="date" id="join_date" name="join_date"
                               value="{{ old('join_date', date('Y-m-d')) }}"
                               class="form-input @error('join_date') form-input-error @enderror"
                               required>
                        @error('join_date')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="member_status" class="form-label">Member Status</label>
                        <select id="member_status" name="member_status"
                                class="form-select @error('member_status') form-input-error @enderror">
                            <option value="active" {{ old('member_status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="pending" {{ old('member_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="inactive" {{ old('member_status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ old('member_status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                        @error('member_status')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="department" class="form-label">Department</label>
                        <input type="text" id="department" name="department"
                               value="{{ old('department') }}"
                               class="form-input @error('department') form-input-error @enderror"
                               placeholder="e.g., Choir, Ushering">
                        @error('department')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Photo Upload -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Member Photo</h3>
                </div>
                <div class="card-body" x-data="{ photoPreview: null }">
                    <div class="text-center">
                        <div class="mb-4">
                            <div x-show="!photoPreview" class="mx-auto w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <img x-show="photoPreview" :src="photoPreview"
                                 class="mx-auto w-32 h-32 rounded-full object-cover"
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

                        <label for="photo" class="btn btn-outline cursor-pointer">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Choose Photo
                        </label>

                        @error('photo')
                        <p class="form-error mt-2">{{ $message }}</p>
                        @enderror

                        <p class="text-xs text-gray-500 mt-2">
                            JPG, PNG up to 2MB
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="card">
                <div class="card-body space-y-3">
                    <button type="submit" class="btn btn-primary w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Member
                    </button>
                    <a href="{{ route('members.index') }}" class="btn btn-secondary w-full">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
