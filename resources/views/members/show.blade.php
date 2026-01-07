@extends('layouts.app')

@section('title', $member->full_name)

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">{{ $member->full_name }}</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('members.index') }}" class="hover:text-primary-600 transition-colors">Members</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">{{ $member->full_name }}</span>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('members.edit', $member) }}" class="btn btn-primary flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Member
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Attendance Rate -->
            <div class="card p-6 border-l-4 border-l-primary-500 bg-gradient-to-br from-white to-primary-50/20">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Attendance Rate</p>
                        <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">{{ $attendanceStats['attendance_percentage'] }}%</h3>
                    </div>
                    <div class="p-2 bg-primary-100/50 rounded-lg text-primary-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Contributions -->
            <div class="card p-6 border-l-4 border-l-amber-500 bg-gradient-to-br from-white to-amber-50/20">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Given</p>
                        <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">GHS {{ number_format($financialSummary['total_given'], 2) }}</h3>
                    </div>
                    <div class="p-2 bg-amber-100/50 rounded-lg text-amber-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Engagement -->
            <div class="card p-6 border-l-4 border-l-emerald-500 bg-gradient-to-br from-white to-emerald-50/20">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Engagement</p>
                        <h3 class="text-lg font-heading font-bold mt-2">
                            @if($engagement['score'] >= 80)
                            <span class="text-emerald-600">Excellent</span>
                            @elseif($engagement['score'] >= 60)
                            <span class="text-primary-600">Good</span>
                            @elseif($engagement['score'] >= 40)
                            <span class="text-amber-600">Fair</span>
                            @else
                            <span class="text-red-600">Needs Attention</span>
                            @endif
                        </h3>
                    </div>
                    <div class="p-2 bg-slate-100 rounded-lg text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Personal Information</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Full Name</label>
                        <p class="mt-1 text-slate-900 font-medium">{{ $member->full_name }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Member ID</label>
                        <p class="mt-1 text-slate-700 font-mono bg-slate-100 inline-block px-2 py-0.5 rounded text-sm">{{ $member->member_id }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Date of Birth</label>
                        <p class="mt-1 text-slate-900">
                            {{ $member->date_of_birth?->format('F d, Y') ?? 'N/A' }}
                            @if($member->age)
                            <span class="text-slate-500 text-sm">({{ $member->age }} years old)</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Gender</label>
                        <p class="mt-1 text-slate-900 capitalize">{{ $member->gender }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Marital Status</label>
                        <p class="mt-1 text-slate-900 capitalize">{{ $member->marital_status }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Occupation</label>
                        <p class="mt-1 text-slate-900">{{ $member->occupation ?? 'N/A' }}</p>
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
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Email</label>
                        <p class="mt-1">
                            <a href="mailto:{{ $member->email }}" class="text-primary-600 hover:text-primary-700 font-medium hover:underline flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                {{ $member->email }}
                            </a>
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Phone</label>
                        <p class="mt-1">
                            <a href="tel:{{ $member->phone }}" class="text-primary-600 hover:text-primary-700 font-medium hover:underline flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $member->phone }}
                            </a>
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Address</label>
                        <p class="mt-1 text-slate-900 flex items-start gap-2">
                            <svg class="w-4 h-4 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>
                                {{ $member->address }}
                                @if($member->city || $member->state)
                                <br>{{ $member->city }}@if($member->city && $member->state),@endif {{ $member->state }}
                                @endif
                                @if($member->postal_code)
                                <br>{{ $member->postal_code }}
                                @endif
                                <br>{{ $member->country }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
        @if($member->emergency_contact_name || $member->emergency_contact_phone)
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Emergency Contact</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Contact Name</label>
                        <p class="mt-1 text-slate-900 font-medium">{{ $member->emergency_contact_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Contact Phone</label>
                        <p class="mt-1">
                            @if($member->emergency_contact_phone)
                            <a href="tel:{{ $member->emergency_contact_phone }}" class="text-primary-600 hover:text-primary-700 font-medium hover:underline flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $member->emergency_contact_phone }}
                            </a>
                            @else
                            <span class="text-slate-500">N/A</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Attendance -->
        <div class="card border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 text-base">Recent Attendance</h3>
                <a href="{{ route('attendance.index', ['member_id' => $member->id]) }}" class="text-xs font-bold text-primary-600 hover:text-primary-700 uppercase tracking-wider hover:underline">
                    View All
                </a>
            </div>
            <div class="overflow-x-auto">
                @if($recentAttendance->count() > 0)
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 font-semibold border-b border-slate-100">Date</th>
                            <th class="px-6 py-3 font-semibold border-b border-slate-100">Service Type</th>
                            <th class="px-6 py-3 font-semibold border-b border-slate-100">Status</th>
                            <th class="px-6 py-3 font-semibold border-b border-slate-100">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 bg-white">
                        @foreach($recentAttendance as $attendance)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ $attendance->service_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 capitalize">{{ str_replace('_', ' ', $attendance->service_type) }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'present' => 'bg-emerald-100 text-emerald-700 ring-emerald-600/20',
                                        'absent' => 'bg-red-100 text-red-700 ring-red-600/20',
                                        'excused' => 'bg-amber-100 text-amber-700 ring-amber-600/20',
                                        'late' => 'bg-amber-100 text-amber-700 ring-amber-600/20',
                                    ];
                                @endphp
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClasses[$attendance->status] ?? 'bg-slate-100 text-slate-700 ring-slate-600/20' }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $attendance->notes ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="p-10 text-center text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p>No attendance records found</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="card border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 text-base">Recent Contributions</h3>
                <a href="{{ route('transactions.index', ['member_id' => $member->id]) }}" class="text-xs font-bold text-primary-600 hover:text-primary-700 uppercase tracking-wider hover:underline">
                    View All
                </a>
            </div>
            <div class="overflow-x-auto">
                @if($recentTransactions->count() > 0)
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 font-semibold border-b border-slate-100">Date</th>
                            <th class="px-6 py-3 font-semibold border-b border-slate-100">Type</th>
                            <th class="px-6 py-3 font-semibold border-b border-slate-100">Amount</th>
                            <th class="px-6 py-3 font-semibold border-b border-slate-100">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 bg-white">
                        @foreach($recentTransactions as $transaction)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ $transaction->transaction_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 capitalize">{{ str_replace('_', ' ', $transaction->transaction_type) }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-slate-800">GHS {{ number_format($transaction->amount, 2) }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'completed' => 'bg-emerald-100 text-emerald-700 ring-emerald-600/20',
                                        'pending' => 'bg-amber-100 text-amber-700 ring-amber-600/20',
                                        'cancelled' => 'bg-red-100 text-red-700 ring-red-600/20',
                                    ];
                                @endphp
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClasses[$transaction->status] ?? 'bg-slate-100 text-slate-700 ring-slate-600/20' }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="p-10 text-center text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p>No transaction records found</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Notes -->
        @if($member->notes)
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Additional Notes</h3>
            </div>
            <div class="p-6">
                <p class="text-slate-700 whitespace-pre-line leading-relaxed text-sm">{{ $member->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-8">
        <!-- Member Photo and Status -->
        <div class="card border border-slate-100">
            <div class="p-8 text-center bg-gradient-to-b from-white to-slate-50">
                <div class="relative inline-block mx-auto mb-4">
                    @if($member->photo_url)
                    <img src="{{ Storage::url($member->photo_url) }}"
                         alt="{{ $member->full_name }}"
                         class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                    @else
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white text-3xl font-bold border-4 border-white shadow-lg">
                        {{ strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1)) }}
                    </div>
                    @endif
                    <div class="absolute bottom-1 right-1">
                        @php
                            $statusColors = [
                                'active' => 'bg-emerald-500 border-emerald-100',
                                'inactive' => 'bg-slate-400 border-slate-100',
                                'pending' => 'bg-amber-400 border-amber-100',
                                'suspended' => 'bg-red-500 border-red-100',
                            ];
                        @endphp
                        <span class="block w-6 h-6 rounded-full border-4 text-white {{ $statusColors[$member->member_status] ?? 'bg-slate-400' }}"></span>
                    </div>
                </div>

                <h3 class="text-xl font-heading font-bold text-slate-900 mb-1">{{ $member->full_name }}</h3>
                <p class="text-sm text-slate-500 mb-4 font-mono">{{ $member->member_id }}</p>

                <div class="flex items-center justify-center gap-2">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium ring-1 ring-inset {{ $statusClasses[$member->member_status] ?? 'bg-slate-100 text-slate-700 ring-slate-600/20' }}">
                        {{ ucfirst($member->member_status) }}
                    </span>
                    @if($member->department)
                    <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-sm font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                        {{ $member->department }}
                    </span>
                    @endif
                </div>
            </div>
            
            <div class="border-t border-slate-100 divide-y divide-slate-100">
                <div class="p-4 flex justify-between items-center text-sm">
                    <span class="text-slate-500">Joined</span>
                    <span class="font-medium text-slate-900">{{ $member->join_date->format('M d, Y') }}</span>
                </div>
                <div class="p-4 flex justify-between items-center text-sm">
                    <span class="text-slate-500">Registered</span>
                    <span class="font-medium text-slate-900">{{ $member->created_at->format('M d, Y') }}</span>
                </div>
                @if($member->user_id)
                <div class="p-4 text-center bg-emerald-50/50">
                    <span class="inline-flex items-center text-sm font-medium text-emerald-700">
                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Linked User Account
                    </span>
                </div>
                @endif
            </div>
        </div>

        <!-- Attendance Summary -->
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Attendance Summary</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-600">Total Services</span>
                    <span class="font-bold text-slate-900">{{ $attendanceStats['total_services'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-600">Present</span>
                    <span class="font-bold text-emerald-600">{{ $attendanceStats['present_count'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-600">Absent</span>
                    <span class="font-bold text-red-600">{{ $attendanceStats['absent_count'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-600">Excused</span>
                    <span class="font-bold text-amber-600">{{ $attendanceStats['excused_count'] ?? 0 }}</span>
                </div>
                
                <div class="pt-4 border-t border-slate-100">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Attendance Rate</span>
                        <span class="text-sm font-bold text-slate-900">{{ $attendanceStats['attendance_percentage'] }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-primary-600 h-2 rounded-full transition-all duration-500" style="width: {{ $attendanceStats['attendance_percentage'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Summary -->
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Financial Summary</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-600">Total Given</span>
                    <span class="font-bold text-slate-900">GHS {{ number_format($financialSummary['total_given'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-600">Tithes</span>
                    <span class="font-bold text-slate-700">GHS {{ number_format($financialSummary['tithes'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-600">Offerings</span>
                    <span class="font-bold text-slate-700">GHS {{ number_format($financialSummary['offerings'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-600">Donations</span>
                    <span class="font-bold text-slate-700">GHS {{ number_format($financialSummary['donations'], 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Engagement Score -->
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Engagement Score</h3>
            </div>
            <div class="p-6">
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary-50 text-2xl font-bold text-primary-600 border-4 border-primary-100 mb-2">
                        {{ $engagement['score'] }}
                    </div>
                    <p class="text-sm font-medium text-slate-600">
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
                <div class="space-y-3">
                    @foreach($engagement['factors'] as $factor => $value)
                    <div class="flex justify-between items-center p-3 rounded-lg {{ $value ? 'bg-emerald-50 text-emerald-800' : 'bg-slate-50 text-slate-500' }}">
                        <span class="text-sm font-medium capitalize">{{ str_replace('_', ' ', $factor) }}</span>
                        @if($value)
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @else
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Member QR Code -->
        <div class="card border border-slate-100" x-data="{ hasQR: {{ $member->member_qr_code ? 'true' : 'false' }} }">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Member QR Code</h3>
            </div>
            <div class="p-6">
                <div x-show="hasQR" class="text-center">
                    <div class="mb-6 p-4 bg-white border border-slate-100 rounded-xl shadow-sm inline-block">
                        <img src="{{ route('members.qr-image', $member->id) }}"
                             alt="Member QR Code"
                             class="w-48 h-48"
                             id="member-qr-image">
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                        <div class="p-3 bg-slate-50 rounded-lg">
                            <span class="block text-slate-500 text-xs uppercase font-bold tracking-wider mb-1">Scans</span>
                            <span class="block font-bold text-slate-900 text-lg" id="qr-scan-count">{{ $member->qr_scan_count ?? 0 }}</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-lg">
                            <span class="block text-slate-500 text-xs uppercase font-bold tracking-wider mb-1">Last Scan</span>
                            <span class="block font-bold text-slate-900 text-xs" id="qr-last-scan">
                                {{ $member->last_qr_scan ? $member->last_qr_scan->format('M d') : 'Never' }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <button onclick="regenerateMemberQR({{ $member->id }})"
                                class="btn w-full justify-center bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors flex items-center gap-2 text-sm font-medium h-10">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Regenerate
                        </button>
                        <a href="{{ route('members.download-qr', $member->id) }}"
                           class="btn w-full justify-center bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors flex items-center gap-2 text-sm font-medium h-10">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download
                        </a>
                        <a href="{{ route('members.show-print-cards', ['member_ids' => [$member->id], 'card_size' => 'standard']) }}"
                           target="_blank"
                           class="btn btn-primary w-full justify-center flex items-center gap-2 h-10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Print ID Card
                        </a>
                    </div>
                </div>

                <div x-show="!hasQR" class="text-center py-6">
                    <div class="mb-4">
                        <div class="w-20 h-20 mx-auto rounded-full bg-slate-50 flex items-center justify-center">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-slate-500 mb-6 text-sm">No QR code generated yet</p>
                    <button onclick="generateMemberQR({{ $member->id }})"
                            class="btn btn-primary w-full justify-center flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Generate QR Code
                    </button>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Quick Actions</h3>
            </div>
            <div class="p-6 space-y-3">
                <a href="{{ route('attendance.create', ['member_id' => $member->id]) }}" class="btn w-full justify-start bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-primary-600 hover:border-primary-200 transition-all flex items-center gap-3 px-4 h-12">
                    <div class="w-8 h-8 rounded-full bg-primary-50 flex items-center justify-center text-primary-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <span class="font-medium">Mark Attendance</span>
                </a>
                <a href="{{ route('transactions.create', ['member_id' => $member->id]) }}" class="btn w-full justify-start bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-amber-600 hover:border-amber-200 transition-all flex items-center gap-3 px-4 h-12">
                    <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center text-amber-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="font-medium">Record Contribution</span>
                </a>
                <a href="mailto:{{ $member->email }}" class="btn w-full justify-start bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-blue-600 hover:border-blue-200 transition-all flex items-center gap-3 px-4 h-12">
                    <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="font-medium">Send Email</span>
                </a>
                <a href="tel:{{ $member->phone }}" class="btn w-full justify-start bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-emerald-600 hover:border-emerald-200 transition-all flex items-center gap-3 px-4 h-12">
                    <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <span class="font-medium">Call Member</span>
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function generateMemberQR(memberId) {
    if (!confirm('Generate QR code for this member?')) {
        return;
    }

    fetch(`/members/${memberId}/generate-qr`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert('Error generating QR code: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error generating QR code. Please try again.');
    });
}

function regenerateMemberQR(memberId) {
    if (!confirm('Regenerate QR code? This will invalidate the old QR code and reset scan statistics.')) {
        return;
    }

    fetch(`/members/${memberId}/regenerate-qr`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const qrImage = document.getElementById('member-qr-image');
            if (qrImage) {
                qrImage.src = `/members/${memberId}/qr-image?t=${Date.now()}`;
            }

            const scanCount = document.getElementById('qr-scan-count');
            if (scanCount) {
                scanCount.textContent = '0';
            }

            const lastScan = document.getElementById('qr-last-scan');
            if (lastScan) {
                lastScan.textContent = 'Never';
            }

            alert('QR code regenerated successfully!');
        } else {
            alert('Error regenerating QR code: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error regenerating QR code. Please try again.');
    });
}
</script>
@endpush

@endsection
