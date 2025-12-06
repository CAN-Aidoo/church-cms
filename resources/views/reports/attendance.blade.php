@extends('layouts.app')

@section('title', 'Attendance Reports')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Attendance Reports</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('reports.index') }}">Reports</a>
            <span>/</span>
            <span>Attendance Reports</span>
        </nav>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.attendance.summary') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="date_from" class="form-label">From Date</label>
                <input type="date" id="date_from" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="form-input">
            </div>
            <div>
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" id="date_to" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="form-input">
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="card">
        <div class="card-body text-center">
            <p class="text-sm text-gray-600 mb-2">Total Attendance</p>
            <p class="text-3xl font-bold text-blue-600">{{ $data['total_attendance'] ?? 0 }}</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body text-center">
            <p class="text-sm text-gray-600 mb-2">Unique Attendees</p>
            <p class="text-3xl font-bold text-green-600">{{ $data['unique_attendees'] ?? 0 }}</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body text-center">
            <p class="text-sm text-gray-600 mb-2">Attendance Rate</p>
            <p class="text-3xl font-bold text-purple-600">{{ number_format($data['attendance_rate'] ?? 0, 1) }}%</p>
        </div>
    </div>
</div>

<!-- By Service Type -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">By Service Type</h3>
    </div>
    <div class="card-body">
        @if(!empty($data['by_service_type']))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($data['by_service_type'] as $serviceType => $count)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $serviceType) }}</p>
                        <p class="text-2xl font-bold">{{ $count }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No service type data available.</p>
        @endif
    </div>
</div>

<!-- Attendance Trend by Date -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">Attendance Trend</h3>
    </div>
    <div class="card-body">
        @if(!empty($data['by_date']))
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th class="text-right">Attendance Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['by_date'] as $date => $count)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}</td>
                                <td class="text-right font-semibold">{{ $count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No attendance trend data available.</p>
        @endif
    </div>
</div>

<!-- Attendance Records -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Attendance Records ({{ count($data['attendance_records'] ?? []) }})</h3>
    </div>
    <div class="card-body p-0">
        @if(!empty($data['attendance_records']) && count($data['attendance_records']) > 0)
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Service Date</th>
                            <th>Service Type</th>
                            <th>Status</th>
                            <th>Check-in Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['attendance_records'] as $record)
                            <tr>
                                <td>
                                    @if($record->member)
                                        <a href="{{ route('members.show', $record->member->id) }}" class="text-blue-600 hover:underline">
                                            {{ $record->member->first_name }} {{ $record->member->last_name }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($record->service_date)->format('M d, Y') }}</td>
                                <td class="capitalize">{{ str_replace('_', ' ', $record->service_type) }}</td>
                                <td>
                                    <span class="badge
                                        @if($record->status === 'present') badge-success
                                        @elseif($record->status === 'late') badge-warning
                                        @elseif($record->status === 'excused') badge-info
                                        @else badge-secondary
                                        @endif">
                                        {{ ucfirst($record->status) }}
                                    </span>
                                </td>
                                <td>{{ $record->check_in_time ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No attendance records found for the selected period.</p>
        @endif
    </div>
</div>
@endsection
