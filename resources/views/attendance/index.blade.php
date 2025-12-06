@extends('layouts.app')

@section('title', 'Attendance Records')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Attendance Records</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>Attendance</span>
        </nav>
    </div>
    <div class="page-actions">
        <a href="{{ route('attendance.reports') }}" class="btn btn-outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Reports
        </a>
        <a href="{{ route('attendance.mark') }}" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
            Mark Attendance
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="stat-card stat-card-gradient-blue">
        <div class="stat-value">{{ number_format($statistics['total_records']) }}</div>
        <div class="stat-label">Total Records</div>
    </div>
    <div class="stat-card stat-card-gradient-green">
        <div class="stat-value">{{ number_format($statistics['present_count']) }}</div>
        <div class="stat-label">Present</div>
    </div>
    <div class="stat-card stat-card-gradient-gold">
        <div class="stat-value">{{ $statistics['attendance_rate'] }}%</div>
        <div class="stat-label">Attendance Rate</div>
    </div>
    <div class="stat-card bg-white text-gray-900 border border-gray-200">
        <div class="stat-value">{{ number_format($statistics['absent_count']) }}</div>
        <div class="stat-label">Absent</div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6" x-data="{ showFilters: false }">
    <div class="card-header flex items-center justify-between">
        <h3 class="card-title">Search & Filters</h3>
        <button @click="showFilters = !showFilters" class="btn btn-sm btn-outline">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
        </button>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('attendance.index') }}" class="space-y-4">
            <!-- Search Bar -->
            <div class="flex gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                           placeholder="Search by member name or ID..."
                           class="form-input w-full">
                </div>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </button>
                @if(count(array_filter($filters ?? [])) > 0)
                <a href="{{ route('attendance.index') }}" class="btn btn-secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Clear
                </a>
                @endif
            </div>

            <!-- Advanced Filters -->
            <div x-show="showFilters" x-collapse class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pt-4 border-t">
                <div>
                    <label class="form-label">Date From</label>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}"
                           class="form-input">
                </div>

                <div>
                    <label class="form-label">Date To</label>
                    <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}"
                           class="form-input">
                </div>

                <div>
                    <label class="form-label">Service Type</label>
                    <select name="service_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="sunday_first" {{ ($filters['service_type'] ?? '') === 'sunday_first' ? 'selected' : '' }}>Sunday First</option>
                        <option value="sunday_second" {{ ($filters['service_type'] ?? '') === 'sunday_second' ? 'selected' : '' }}>Sunday Second</option>
                        <option value="midweek" {{ ($filters['service_type'] ?? '') === 'midweek' ? 'selected' : '' }}>Midweek</option>
                        <option value="prayer_meeting" {{ ($filters['service_type'] ?? '') === 'prayer_meeting' ? 'selected' : '' }}>Prayer Meeting</option>
                        <option value="special" {{ ($filters['service_type'] ?? '') === 'special' ? 'selected' : '' }}>Special</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="present" {{ ($filters['status'] ?? '') === 'present' ? 'selected' : '' }}>Present</option>
                        <option value="absent" {{ ($filters['status'] ?? '') === 'absent' ? 'selected' : '' }}>Absent</option>
                        <option value="excused" {{ ($filters['status'] ?? '') === 'excused' ? 'selected' : '' }}>Excused</option>
                        <option value="late" {{ ($filters['status'] ?? '') === 'late' ? 'selected' : '' }}>Late</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Attendance Table -->
<div class="card">
    <div class="card-header flex items-center justify-between">
        <h3 class="card-title">Attendance Records ({{ $attendance->total() }})</h3>
        <div class="flex gap-2">
            <form method="GET" action="{{ route('attendance.export') }}" class="inline">
                @foreach($filters ?? [] as $key => $value)
                    @if($value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <button type="submit" class="btn btn-sm btn-outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export CSV
                </button>
            </form>
        </div>
    </div>

    <div class="card-body p-0">
        @if($attendance->count() > 0)
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Service Date</th>
                        <th>Service Type</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Recorded By</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendance as $record)
                    <tr>
                        <td>
                            <div class="flex items-center space-x-3">
                                @if($record->member->photo_url)
                                <img src="{{ Storage::url($record->member->photo_url) }}"
                                     alt="{{ $record->member->full_name }}"
                                     class="w-10 h-10 rounded-full object-cover">
                                @else
                                <div class="w-10 h-10 rounded-full bg-gradient-primary flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($record->member->first_name, 0, 1) . substr($record->member->last_name, 0, 1)) }}
                                </div>
                                @endif
                                <div>
                                    <a href="{{ route('members.show', $record->member) }}"
                                       class="font-semibold text-primary-600 hover:text-primary-700">
                                        {{ $record->member->full_name }}
                                    </a>
                                    <div class="text-xs text-gray-500">{{ $record->member->member_id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $record->service_date->format('M d, Y') }}</td>
                        <td class="capitalize">{{ str_replace('_', ' ', $record->service_type) }}</td>
                        <td>
                            @php
                                $statusColors = [
                                    'present' => 'badge-success',
                                    'absent' => 'badge-danger',
                                    'excused' => 'badge-warning',
                                    'late' => 'badge-warning',
                                ];
                            @endphp
                            <span class="badge {{ $statusColors[$record->status] ?? 'badge-secondary' }}">
                                {{ ucfirst($record->status) }}
                            </span>
                        </td>
                        <td class="text-sm text-gray-600">{{ $record->notes ?? '-' }}</td>
                        <td class="text-sm">
                            {{ $record->recorder?->full_name ?? 'System' }}
                            <div class="text-xs text-gray-500">{{ $record->recorded_at->format('M d, H:i') }}</div>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('attendance.edit', $record) }}"
                                   class="btn-icon btn-icon-sm text-gold-600" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                @if(auth()->user()->hasAnyRole(['admin', 'pastor']))
                                <form action="{{ route('attendance.destroy', $record) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this attendance record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon btn-icon-sm text-red-600" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t">
            {{ $attendance->links() }}
        </div>
        @else
        <div class="p-12 text-center text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No attendance records found</h3>
            <p class="mb-4">Try adjusting your filters, or mark attendance for a service.</p>
            <a href="{{ route('attendance.mark') }}" class="btn btn-primary">
                Mark Attendance
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
