@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">My Profile</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>Profile</span>
        </nav>
    </div>
    <!-- Edit profile button will be added later -->
    @if(false)
    <div class="page-actions">
        <button class="btn btn-primary" disabled>
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Profile
        </button>
    </div>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column - Profile Card -->
    <div class="lg:col-span-1">
        <div class="card">
            <div class="card-body text-center">
                <!-- Avatar -->
                <div class="mb-4">
                    @if($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->full_name }}" class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-primary-100">
                    @else
                        <div class="w-32 h-32 rounded-full mx-auto bg-gradient-primary flex items-center justify-center text-white text-4xl font-bold border-4 border-primary-100">
                            {{ substr($user->full_name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <!-- Name & Role -->
                <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $user->full_name }}</h2>
                <span class="badge badge-primary mb-4">{{ ucfirst($user->role) }}</span>

                <!-- Contact Info -->
                <div class="space-y-2 text-left mt-6">
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $user->email }}</span>
                    </div>
                    @if($user->phone)
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>{{ $user->phone }}</span>
                        </div>
                    @endif
                </div>

                <!-- Account Status -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Account Status</span>
                        @if($user->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </div>
                    @if($user->email_verified_at)
                        <div class="flex items-center justify-between text-sm mt-2">
                            <span class="text-gray-500">Email Verified</span>
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @endif
                    @if($user->last_login_at)
                        <div class="flex items-center justify-between text-sm mt-2">
                            <span class="text-gray-500">Last Login</span>
                            <span class="text-gray-700">{{ $user->last_login_at->diffForHumans() }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Member Information -->
        @if($member)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Member Information</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Member ID</label>
                            <p class="text-gray-900 mt-1">{{ $member->member_id }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Date of Birth</label>
                            <p class="text-gray-900 mt-1">{{ $member->date_of_birth ? \Carbon\Carbon::parse($member->date_of_birth)->format('F j, Y') : 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Membership Status</label>
                            <p class="mt-1">
                                <span class="badge {{ $member->member_status === 'active' ? 'badge-success' : 'badge-warning' }}">
                                    {{ ucfirst($member->member_status ?? 'unknown') }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Member Since</label>
                            <p class="text-gray-900 mt-1">{{ $member->created_at->format('F j, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Stats -->
            @if(isset($attendance_stats))
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Attendance Statistics</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <p class="text-3xl font-bold text-primary-600">{{ $attendance_stats['attendance_percentage'] ?? 0 }}%</p>
                                <p class="text-sm text-gray-500 mt-1">Attendance Rate</p>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-green-600">{{ $attendance_stats['present_count'] ?? 0 }}</p>
                                <p class="text-sm text-gray-500 mt-1">Services Attended</p>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-gray-600">{{ $attendance_stats['total_services'] ?? 0 }}</p>
                                <p class="text-sm text-gray-500 mt-1">Total Services</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Financial Summary -->
            @if(isset($financial_summary))
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Financial Summary</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Tithes</label>
                                <p class="text-2xl font-bold text-gray-900 mt-1">GHS {{ number_format($financial_summary['tithes'] ?? 0, 2) }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Offerings</label>
                                <p class="text-2xl font-bold text-gray-900 mt-1">GHS {{ number_format($financial_summary['offerings'] ?? 0, 2) }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Donations</label>
                                <p class="text-2xl font-bold text-gray-900 mt-1">GHS {{ number_format($financial_summary['donations'] ?? 0, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <!-- Account Security -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Account Security</h3>
            </div>
            <div class="card-body">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Password</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Secure your account with a strong password</p>
                        </div>
                        <button class="btn btn-sm btn-outline" disabled>Change</button>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Two-Factor Authentication</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Add an extra layer of security to your account</p>
                        </div>
                        @if($user->two_factor_enabled)
                            <span class="badge badge-success">Enabled</span>
                        @else
                            <span class="badge badge-warning">Disabled</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
