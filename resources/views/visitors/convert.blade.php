@extends('layouts.app')

@section('title', 'Convert to Member')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Convert Visitor to Member</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('visitors.index') }}">Visitors</a>
            <span>/</span>
            <a href="{{ route('visitors.show', $visitor) }}">{{ $visitor->first_name }} {{ $visitor->last_name }}</a>
            <span>/</span>
            <span>Convert</span>
        </nav>
    </div>
</div>

<!-- Conversion Confirmation Banner -->
<div class="card bg-gradient-gold mb-6">
    <div class="card-body text-white">
        <div class="flex items-start gap-4">
            <svg class="w-12 h-12 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="flex-1">
                <h2 class="text-2xl font-bold mb-2">Visitor Eligible for Membership!</h2>
                <p class="text-sm opacity-90 mb-3">
                    <strong>{{ $visitor->first_name }} {{ $visitor->last_name }}</strong> has attended {{ $visitor->visit_count }} services and is ready to become a member.
                </p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div class="bg-white/20 rounded-lg p-3">
                        <div class="text-2xl font-bold">{{ $visitor->visit_count }}</div>
                        <div class="text-xs opacity-90">Visits</div>
                    </div>
                    <div class="bg-white/20 rounded-lg p-3">
                        <div class="text-2xl font-bold">{{ $visitor->first_visit_date?->diffInDays() }}</div>
                        <div class="text-xs opacity-90">Days Active</div>
                    </div>
                    <div class="bg-white/20 rounded-lg p-3">
                        <div class="text-sm font-bold">{{ $visitor->first_visit_date?->format('M d, Y') }}</div>
                        <div class="text-xs opacity-90">First Visit</div>
                    </div>
                    <div class="bg-white/20 rounded-lg p-3">
                        <div class="text-sm font-bold capitalize">{{ str_replace('_', ' ', $visitor->referral_source ?? 'Direct') }}</div>
                        <div class="text-xs opacity-90">Referral</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('visitors.convert', $visitor) }}" method="POST" class="max-w-4xl">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Pre-filled Visitor Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Visitor Information (Pre-filled)</h3>
                </div>
                <div class="card-body bg-gray-50">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 mb-1">Name</dt>
                            <dd class="text-base font-semibold">{{ $visitor->first_name }} {{ $visitor->last_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 mb-1">Phone</dt>
                            <dd class="text-base">{{ $visitor->phone }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 mb-1">Address</dt>
                            <dd class="text-base">
                                {{ $visitor->address ?? 'Not provided' }}
                                @if($visitor->city || $visitor->state)
                                <br>{{ $visitor->city }}{{ $visitor->city && $visitor->state ? ', ' : '' }}{{ $visitor->state }}
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Account Creation -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Member Account</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="email" class="form-label required">Email Address</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email', $visitor->email) }}"
                                   class="form-input @error('email') form-input-error @enderror"
                                   required>
                            @error('email')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">This will be used for login credentials</p>
                        </div>

                        <div>
                            <label for="password" class="form-label required">Password</label>
                            <input type="password" id="password" name="password"
                                   class="form-input @error('password') form-input-error @enderror"
                                   required minlength="8">
                            @error('password')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                        </div>

                        <div>
                            <label for="password_confirmation" class="form-label required">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-input"
                                   required minlength="8">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Member Details -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Additional Member Details</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" id="date_of_birth" name="date_of_birth"
                                   value="{{ old('date_of_birth') }}"
                                   class="form-input @error('date_of_birth') form-input-error @enderror">
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
                            </select>
                            @error('gender')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="marital_status" class="form-label">Marital Status</label>
                            <select id="marital_status" name="marital_status"
                                    class="form-select @error('marital_status') form-input-error @enderror">
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

                        <div class="md:col-span-2">
                            <label for="join_date" class="form-label required">Membership Join Date</label>
                            <input type="date" id="join_date" name="join_date"
                                   value="{{ old('join_date', date('Y-m-d')) }}"
                                   class="form-input @error('join_date') form-input-error @enderror"
                                   required>
                            @error('join_date')
                            <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Conversion Process -->
            <div class="card bg-blue-50 border-blue-200">
                <div class="card-body">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-blue-900 mb-2">Conversion Process</h4>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>✓ Visitor data transferred</li>
                                <li>✓ User account created</li>
                                <li>✓ Member record generated</li>
                                <li>✓ Unique member ID assigned</li>
                                <li>• Status: Pending (onboarding)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Next Steps After Conversion</h3>
                </div>
                <div class="card-body">
                    <ol class="list-decimal list-inside space-y-2 text-sm">
                        <li>Complete member profile</li>
                        <li>Upload member photo</li>
                        <li>Assign to shepherd</li>
                        <li>Enroll in foundations class</li>
                        <li>Update to "Active" status</li>
                    </ol>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-body space-y-3">
                    <button type="submit" class="btn btn-primary w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Convert to Member
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-yellow-900 mb-1">Important</h4>
                            <p class="text-sm text-yellow-800">
                                Once converted, the visitor record will be linked to the member profile. This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
