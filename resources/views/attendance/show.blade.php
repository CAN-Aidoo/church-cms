@extends('layouts.app')

@section('title', 'Attendance Record Details')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Attendance Record Details</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('attendance.index') }}">Attendance</a>
            <span>/</span>
            <span>Details</span>
        </nav>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('attendance.edit', $attendance) }}" class="btn btn-secondary">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/>
                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"/>
            </svg>
            Edit Record
        </a>
        <a href="{{ route('attendance.index') }}" class="btn btn-outline">
            Back to List
        </a>
    </div>
</div>

<div class="max-w-4xl mx-auto">
    <!-- Member & Service Information Card -->
    <div class="card mb-6">
        <div class="card-header bg-gradient-to-r from-primary-50 to-blue-50">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900">Attendance Information</h2>
                <span class="px-4 py-2 rounded-full text-sm font-semibold
                    @if($attendance->status === 'present') bg-green-100 text-green-800
                    @elseif($attendance->status === 'absent') bg-red-100 text-red-800
                    @elseif($attendance->status === 'excused') bg-blue-100 text-blue-800
                    @elseif($attendance->status === 'late') bg-yellow-100 text-yellow-800
                    @endif">
                    {{ ucfirst($attendance->status) }}
                </span>
            </div>
        </div>

        <div class="card-body">
            <!-- Member Information -->
            <div class="mb-6 p-4 bg-gradient-to-r from-primary-50 to-blue-50 rounded-lg border border-primary-100">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($attendance->member->first_name, 0, 1)) }}{{ strtoupper(substr($attendance->member->last_name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $attendance->member->first_name }} {{ $attendance->member->last_name }}
                        </h3>
                        <p class="text-sm text-gray-600">{{ $attendance->member->member_id }}</p>
                        <div class="flex gap-4 mt-1 text-sm text-gray-500">
                            @if($attendance->member->email)
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                    </svg>
                                    {{ $attendance->member->email }}
                                </span>
                            @endif
                            @if($attendance->member->phone)
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                    </svg>
                                    {{ $attendance->member->phone }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('members.show', $attendance->member) }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">
                        View Profile →
                    </a>
                </div>
            </div>

            <!-- Service Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-gray-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        <h4 class="text-sm font-semibold text-gray-700">Service Date</h4>
                    </div>
                    <p class="text-lg font-medium text-gray-900">{{ $attendance->service_date->format('l, F d, Y') }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $attendance->service_date->diffForHumans() }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-gray-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        <h4 class="text-sm font-semibold text-gray-700">Service Type</h4>
                    </div>
                    <p class="text-lg font-medium text-gray-900">{{ ucwords(str_replace('_', ' ', $attendance->service_type)) }}</p>
                </div>
            </div>

            <!-- Check-in Details (if available) -->
            @if($attendance->check_in_time || $attendance->check_in_method)
            <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Check-in Details
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($attendance->check_in_time)
                    <div>
                        <p class="text-xs text-gray-600">Check-in Time</p>
                        <p class="text-sm font-medium text-gray-900">{{ $attendance->check_in_time }}</p>
                    </div>
                    @endif
                    @if($attendance->check_in_method)
                    <div>
                        <p class="text-xs text-gray-600">Check-in Method</p>
                        <p class="text-sm font-medium text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($attendance->check_in_method === 'qr_code' || $attendance->check_in_method === 'qr_code_service' || $attendance->check_in_method === 'qr_code_family')
                                    bg-purple-100 text-purple-800
                                @elseif($attendance->check_in_method === 'mobile')
                                    bg-green-100 text-green-800
                                @else
                                    bg-gray-100 text-gray-800
                                @endif">
                                {{ ucwords(str_replace('_', ' ', $attendance->check_in_method)) }}
                            </span>
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Notes Section -->
            @if($attendance->notes)
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                    </svg>
                    Notes
                </h4>
                <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $attendance->notes }}</p>
            </div>
            @endif

            <!-- Record Metadata -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Record Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600">Recorded By</p>
                        <p class="font-medium text-gray-900">{{ $attendance->recordedBy->name ?? 'System' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Recorded At</p>
                        <p class="font-medium text-gray-900">{{ $attendance->recorded_at ? $attendance->recorded_at->format('M d, Y H:i:s') : 'N/A' }}</p>
                    </div>
                    @if($attendance->updated_at && $attendance->updated_at != $attendance->created_at)
                    <div>
                        <p class="text-gray-600">Last Updated</p>
                        <p class="font-medium text-gray-900">{{ $attendance->updated_at->format('M d, Y H:i:s') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Time Since Update</p>
                        <p class="font-medium text-gray-900">{{ $attendance->updated_at->diffForHumans() }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card Footer with Actions -->
        <div class="card-footer bg-gray-50 flex justify-between items-center">
            <a href="{{ route('attendance.index') }}" class="text-sm text-gray-600 hover:text-gray-800">
                ← Back to Attendance List
            </a>
            <div class="flex gap-3">
                <a href="{{ route('attendance.edit', $attendance) }}" class="btn btn-sm btn-secondary">
                    Edit Record
                </a>
                @can('delete', $attendance)
                <form action="{{ route('attendance.destroy', $attendance) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this attendance record?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Delete
                    </button>
                </form>
                @endcan
            </div>
        </div>
    </div>

    <!-- Related Member Attendance History -->
    <div class="card">
        <div class="card-header bg-gradient-to-r from-primary-50 to-blue-50">
            <h3 class="text-lg font-semibold text-gray-900">Recent Attendance History</h3>
            <p class="text-sm text-gray-600 mt-1">Last 10 attendance records for this member</p>
        </div>
        <div class="card-body p-0">
            @php
                $recentAttendance = $attendance->member->attendances()
                    ->orderBy('service_date', 'desc')
                    ->take(10)
                    ->get();
            @endphp

            @if($recentAttendance->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check-in</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentAttendance as $record)
                        <tr class="hover:bg-gray-50 {{ $record->id === $attendance->id ? 'bg-primary-50' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $record->service_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ ucwords(str_replace('_', ' ', $record->service_type)) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                    @if($record->status === 'present') bg-green-100 text-green-800
                                    @elseif($record->status === 'absent') bg-red-100 text-red-800
                                    @elseif($record->status === 'excused') bg-blue-100 text-blue-800
                                    @elseif($record->status === 'late') bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucfirst($record->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $record->check_in_time ?? 'N/A' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-8 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p>No attendance history found</p>
            </div>
            @endif
        </div>
        <div class="card-footer bg-gray-50">
            <a href="{{ route('members.show', $attendance->member) }}" class="text-sm text-primary-600 hover:text-primary-800 font-medium">
                View Full Member Profile →
            </a>
        </div>
    </div>
</div>
@endsection
