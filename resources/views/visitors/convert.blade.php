@extends('layouts.app')

@section('title', 'Convert to Member')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Convert Visitor to Member</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('visitors.index') }}" class="hover:text-primary-600 transition-colors">Visitors</a>
            <span>/</span>
            <a href="{{ route('visitors.show', $visitor) }}" class="hover:text-primary-600 transition-colors">{{ $visitor->first_name }} {{ $visitor->last_name }}</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Convert</span>
        </nav>
    </div>
</div>

<!-- Conversion Confirmation Banner -->
<div class="card p-6 bg-gradient-to-br from-amber-500 to-amber-600 text-white shadow-lg shadow-amber-500/20 mb-8">
    <div class="flex items-start gap-5">
        <div class="p-3 bg-white/20 rounded-xl">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="flex-1">
            <h2 class="text-2xl font-heading font-bold mb-2">Visitor Eligible for Membership!</h2>
            <p class="text-base opacity-95 mb-6">
                <strong>{{ $visitor->first_name }} {{ $visitor->last_name }}</strong> has attended {{ $visitor->visit_count }} services and is ready to become a member.
            </p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                <div class="bg-white/20 rounded-xl p-4 backdrop-blur-sm">
                    <div class="text-3xl font-bold font-heading mb-1">{{ $visitor->visit_count }}</div>
                    <div class="text-xs font-bold uppercase tracking-wider opacity-80">Visits</div>
                </div>
                <div class="bg-white/20 rounded-xl p-4 backdrop-blur-sm">
                    <div class="text-3xl font-bold font-heading mb-1">{{ $visitor->first_visit_date?->diffInDays() }}</div>
                    <div class="text-xs font-bold uppercase tracking-wider opacity-80">Days Active</div>
                </div>
                <div class="bg-white/20 rounded-xl p-4 backdrop-blur-sm">
                    <div class="text-lg font-bold mb-1">{{ $visitor->first_visit_date?->format('M d, Y') }}</div>
                    <div class="text-xs font-bold uppercase tracking-wider opacity-80">First Visit</div>
                </div>
                <div class="bg-white/20 rounded-xl p-4 backdrop-blur-sm">
                    <div class="text-lg font-bold capitalize mb-1">{{ str_replace('_', ' ', $visitor->referral_source ?? 'Direct') }}</div>
                    <div class="text-xs font-bold uppercase tracking-wider opacity-80">Referral</div>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('visitors.convert', $visitor) }}" method="POST" class="max-w-5xl mx-auto">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Pre-filled Visitor Information -->
            <div class="card border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Visitor Information (Pre-filled)</h3>
                </div>
                <div class="p-6 bg-slate-50/30">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Name</dt>
                            <dd class="text-base font-semibold text-slate-900">{{ $visitor->first_name }} {{ $visitor->last_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Phone</dt>
                            <dd class="text-base font-mono text-slate-700">{{ $visitor->phone }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Address</dt>
                            <dd class="text-base text-slate-700">
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
            <div class="card border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Create Member Account</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="email" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Email Address</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email', $visitor->email) }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('email') border-red-500 @enderror"
                                   required>
                            @error('email')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-slate-500 mt-1">This will be used for login credentials</p>
                        </div>

                        <div>
                            <label for="password" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Password</label>
                            <input type="password" id="password" name="password"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('password') border-red-500 @enderror"
                                   required minlength="8">
                            @error('password')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-slate-500 mt-1">Minimum 8 characters</p>
                        </div>

                        <div>
                            <label for="password_confirmation" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500"
                                   required minlength="8">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Member Details -->
            <div class="card border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Additional Member Details</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="date_of_birth" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Date of Birth</label>
                            <input type="date" id="date_of_birth" name="date_of_birth"
                                   value="{{ old('date_of_birth') }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('date_of_birth') border-red-500 @enderror">
                            @error('date_of_birth')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="gender" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Gender</label>
                            <select id="gender" name="gender"
                                    class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('gender') border-red-500 @enderror"
                                    required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="marital_status" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Marital Status</label>
                            <select id="marital_status" name="marital_status"
                                    class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('marital_status') border-red-500 @enderror">
                                <option value="">Select Status</option>
                                <option value="single" {{ old('marital_status') === 'single' ? 'selected' : '' }}>Single</option>
                                <option value="married" {{ old('marital_status') === 'married' ? 'selected' : '' }}>Married</option>
                                <option value="divorced" {{ old('marital_status') === 'divorced' ? 'selected' : '' }}>Divorced</option>
                                <option value="widowed" {{ old('marital_status') === 'widowed' ? 'selected' : '' }}>Widowed</option>
                            </select>
                            @error('marital_status')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="occupation" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Occupation</label>
                            <input type="text" id="occupation" name="occupation"
                                   value="{{ old('occupation') }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('occupation') border-red-500 @enderror">
                            @error('occupation')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="join_date" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Membership Join Date</label>
                            <input type="date" id="join_date" name="join_date"
                                   value="{{ old('join_date', date('Y-m-d')) }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 @error('join_date') border-red-500 @enderror"
                                   required>
                            @error('join_date')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Conversion Process -->
            <div class="card p-6 border-l-4 border-l-blue-500 bg-blue-50/50 border-y border-r border-blue-100">
                <div class="flex items-start gap-4">
                    <div class="p-2 bg-blue-100 text-blue-600 rounded-lg flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-blue-900 text-lg mb-2">Conversion Process</h4>
                        <ul class="text-sm text-blue-800 space-y-1.5 list-none">
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Visitor data transferred</li>
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> User account created</li>
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Member record generated</li>
                            <li class="flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Unique member ID assigned</li>
                            <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-500 ml-1.5 mr-0.5"></div> Status: Pending (onboarding)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="card border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Next Steps After Conversion</h3>
                </div>
                <div class="p-6">
                    <ol class="list-decimal list-inside space-y-2 text-sm text-slate-700">
                        <li class="pl-2">Complete member profile</li>
                        <li class="pl-2">Upload member photo</li>
                        <li class="pl-2">Assign to shepherd</li>
                        <li class="pl-2">Enroll in foundations class</li>
                        <li class="pl-2">Update to "Active" status</li>
                    </ol>
                </div>
            </div>

            <!-- Actions -->
            <div class="card border border-slate-100">
                <div class="p-6 space-y-3">
                    <button type="submit" class="btn btn-primary w-full shadow-lg shadow-primary-500/30">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Convert to Member
                    </button>
                    <a href="{{ route('visitors.show', $visitor) }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 w-full justify-center">
                        Cancel
                    </a>
                </div>
            </div>

            <!-- Warning -->
            <div class="card p-6 border-l-4 border-l-amber-500 bg-amber-50/50 border-y border-r border-amber-100">
                <div class="flex items-start gap-4">
                    <div class="p-2 bg-amber-100 text-amber-600 rounded-lg flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-amber-900 text-lg mb-2">Important</h4>
                        <p class="text-sm text-amber-800 leading-relaxed">
                            Once converted, the visitor record will be linked to the member profile. This action cannot be undone.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
