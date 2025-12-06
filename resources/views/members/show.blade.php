@extends('layouts.app')

@section('title', $member->full_name)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $member->full_name }}</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('members.index') }}">Members</a>
            <span>/</span>
            <span>{{ $member->full_name }}</span>
        </nav>
    </div>
    <div class="page-actions">
        <a href="{{ route('members.edit', $member) }}" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Member
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="stat-card stat-card-gradient-blue">
                <div class="stat-value">{{ $attendanceStats['attendance_percentage'] }}%</div>
                <div class="stat-label">Attendance Rate</div>
            </div>
            <div class="stat-card stat-card-gradient-gold">
                <div class="stat-value">GHS {{ number_format($financialSummary['total_given'], 2) }}</div>
                <div class="stat-label">Total Contributions</div>
            </div>
            <div class="stat-card bg-white text-gray-900 border border-gray-200">
                <div class="stat-value">
                    @if($engagement['score'] >= 80)
                    <span class="text-green-600">Excellent</span>
                    @elseif($engagement['score'] >= 60)
                    <span class="text-blue-600">Good</span>
                    @elseif($engagement['score'] >= 40)
                    <span class="text-yellow-600">Fair</span>
                    @else
                    <span class="text-red-600">Needs Attention</span>
                    @endif
                </div>
                <div class="stat-label">Engagement Level</div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Personal Information</h3>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Full Name</label>
                        <p class="mt-1 text-gray-900">{{ $member->full_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Member ID</label>
                        <p class="mt-1 text-gray-900 font-mono">{{ $member->member_id }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Date of Birth</label>
                        <p class="mt-1 text-gray-900">
                            {{ $member->date_of_birth?->format('F d, Y') ?? 'N/A' }}
                            @if($member->age)
                            <span class="text-gray-500">({{ $member->age }} years old)</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Gender</label>
                        <p class="mt-1 text-gray-900 capitalize">{{ $member->gender }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Marital Status</label>
                        <p class="mt-1 text-gray-900 capitalize">{{ $member->marital_status }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Occupation</label>
                        <p class="mt-1 text-gray-900">{{ $member->occupation ?? 'N/A' }}</p>
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
                        <label class="text-sm font-medium text-gray-500">Email</label>
                        <p class="mt-1 text-gray-900">
                            <a href="mailto:{{ $member->email }}" class="text-primary-600 hover:text-primary-700">
                                {{ $member->email }}
                            </a>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Phone</label>
                        <p class="mt-1 text-gray-900">
                            <a href="tel:{{ $member->phone }}" class="text-primary-600 hover:text-primary-700">
                                {{ $member->phone }}
                            </a>
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-500">Address</label>
                        <p class="mt-1 text-gray-900">
                            {{ $member->address }}
                            @if($member->city || $member->state)
                            <br>{{ $member->city }}@if($member->city && $member->state),@endif {{ $member->state }}
                            @endif
                            @if($member->postal_code)
                            <br>{{ $member->postal_code }}
                            @endif
                            <br>{{ $member->country }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
        @if($member->emergency_contact_name || $member->emergency_contact_phone)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Emergency Contact</h3>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Contact Name</label>
                        <p class="mt-1 text-gray-900">{{ $member->emergency_contact_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Contact Phone</label>
                        <p class="mt-1 text-gray-900">
                            @if($member->emergency_contact_phone)
                            <a href="tel:{{ $member->emergency_contact_phone }}" class="text-primary-600 hover:text-primary-700">
                                {{ $member->emergency_contact_phone }}
                            </a>
                            @else
                            N/A
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Attendance -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h3 class="card-title">Recent Attendance</h3>
                <a href="{{ route('attendance.index', ['member_id' => $member->id]) }}" class="text-sm text-primary-600 hover:text-primary-700">
                    View All
                </a>
            </div>
            <div class="card-body p-0">
                @if($recentAttendance->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Service Type</th>
                                <th>Status</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentAttendance as $attendance)
                            <tr>
                                <td>{{ $attendance->service_date->format('M d, Y') }}</td>
                                <td class="capitalize">{{ str_replace('_', ' ', $attendance->service_type) }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'present' => 'badge-success',
                                            'absent' => 'badge-danger',
                                            'excused' => 'badge-warning',
                                            'late' => 'badge-warning',
                                        ];
                                    @endphp
                                    <span class="badge {{ $statusColors[$attendance->status] ?? 'badge-secondary' }}">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                                <td class="text-sm text-gray-600">{{ $attendance->notes ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="p-8 text-center text-gray-500">
                    <p>No attendance records found</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h3 class="card-title">Recent Contributions</h3>
                <a href="{{ route('transactions.index', ['member_id' => $member->id]) }}" class="text-sm text-primary-600 hover:text-primary-700">
                    View All
                </a>
            </div>
            <div class="card-body p-0">
                @if($recentTransactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $transaction)
                            <tr>
                                <td>{{ $transaction->transaction_date->format('M d, Y') }}</td>
                                <td class="capitalize">{{ str_replace('_', ' ', $transaction->transaction_type) }}</td>
                                <td class="font-semibold">GHS {{ number_format($transaction->amount, 2) }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'completed' => 'badge-success',
                                            'pending' => 'badge-warning',
                                            'cancelled' => 'badge-danger',
                                        ];
                                    @endphp
                                    <span class="badge {{ $statusColors[$transaction->status] ?? 'badge-secondary' }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="p-8 text-center text-gray-500">
                    <p>No transaction records found</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Notes -->
        @if($member->notes)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Additional Notes</h3>
            </div>
            <div class="card-body">
                <p class="text-gray-700 whitespace-pre-line">{{ $member->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Member Photo and Status -->
        <div class="card">
            <div class="card-body text-center">
                @if($member->photo_url)
                <img src="{{ Storage::url($member->photo_url) }}"
                     alt="{{ $member->full_name }}"
                     class="w-32 h-32 rounded-full object-cover mx-auto mb-4">
                @else
                <div class="w-32 h-32 rounded-full bg-gradient-primary flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4">
                    {{ strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1)) }}
                </div>
                @endif

                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $member->full_name }}</h3>
                <p class="text-sm text-gray-500 mb-4">Member ID: {{ $member->member_id }}</p>

                @php
                    $statusColors = [
                        'active' => 'badge-success',
                        'inactive' => 'badge-secondary',
                        'pending' => 'badge-warning',
                        'suspended' => 'badge-danger',
                    ];
                @endphp
                <span class="badge {{ $statusColors[$member->member_status] ?? 'badge-secondary' }} text-lg">
                    {{ ucfirst($member->member_status) }}
                </span>
            </div>
        </div>

        <!-- Membership Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Membership Info</h3>
            </div>
            <div class="card-body space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">Join Date</label>
                    <p class="mt-1 text-gray-900">{{ $member->join_date->format('F d, Y') }}</p>
                    <p class="text-xs text-gray-500">{{ $member->join_date->diffForHumans() }}</p>
                </div>

                @if($member->department)
                <div>
                    <label class="text-sm font-medium text-gray-500">Department</label>
                    <p class="mt-1 text-gray-900">{{ $member->department }}</p>
                </div>
                @endif

                <div>
                    <label class="text-sm font-medium text-gray-500">Registered</label>
                    <p class="mt-1 text-gray-900">{{ $member->created_at->format('M d, Y') }}</p>
                </div>

                @if($member->user_id)
                <div class="pt-4 border-t">
                    <span class="inline-flex items-center text-sm text-green-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Has User Account
                    </span>
                </div>
                @endif
            </div>
        </div>

        <!-- Attendance Summary -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Attendance Summary</h3>
            </div>
            <div class="card-body space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total Services</span>
                    <span class="font-semibold text-gray-900">{{ $attendanceStats['total_services'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Present</span>
                    <span class="font-semibold text-green-600">{{ $attendanceStats['present_count'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Absent</span>
                    <span class="font-semibold text-red-600">{{ $attendanceStats['absent_count'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Excused</span>
                    <span class="font-semibold text-yellow-600">{{ $attendanceStats['excused_count'] ?? 0 }}</span>
                </div>
                <div class="pt-3 border-t">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">Attendance Rate</span>
                        <span class="text-lg font-bold text-primary-600">{{ $attendanceStats['attendance_percentage'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-gradient-primary h-2 rounded-full" style="width: {{ $attendanceStats['attendance_percentage'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Summary -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Financial Summary</h3>
            </div>
            <div class="card-body space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total Given</span>
                    <span class="font-semibold text-gray-900">GHS {{ number_format($financialSummary['total_given'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Tithes</span>
                    <span class="font-semibold text-gray-900">GHS {{ number_format($financialSummary['tithes'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Offerings</span>
                    <span class="font-semibold text-gray-900">GHS {{ number_format($financialSummary['offerings'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Donations</span>
                    <span class="font-semibold text-gray-900">GHS {{ number_format($financialSummary['donations'], 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Engagement Score -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Engagement Score</h3>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="text-4xl font-bold text-primary-600 mb-2">{{ $engagement['score'] }}/100</div>
                    <p class="text-sm text-gray-600">
                        @if($engagement['score'] >= 80)
                        Excellent Engagement
                        @elseif($engagement['score'] >= 60)
                        Good Engagement
                        @elseif($engagement['score'] >= 40)
                        Fair Engagement
                        @else
                        Needs Attention
                        @endif
                    </p>
                </div>
                <div class="space-y-2 text-sm">
                    @foreach($engagement['factors'] as $factor => $value)
                    <div class="flex justify-between">
                        <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $factor) }}</span>
                        <span class="font-medium {{ $value ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $value ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Quick Actions</h3>
            </div>
            <div class="card-body space-y-2">
                <a href="{{ route('attendance.create', ['member_id' => $member->id]) }}" class="btn btn-outline w-full justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    Mark Attendance
                </a>
                <a href="{{ route('transactions.create', ['member_id' => $member->id]) }}" class="btn btn-outline w-full justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Record Contribution
                </a>
                <a href="mailto:{{ $member->email }}" class="btn btn-outline w-full justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Send Email
                </a>
                <a href="tel:{{ $member->phone }}" class="btn btn-outline w-full justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Call Member
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
