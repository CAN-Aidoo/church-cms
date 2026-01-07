@extends('layouts.app')

@section('title', 'QR Scan History')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">QR Scan History</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('reports.index') }}">Reports</a>
            <span>/</span>
            <span>QR Scan History</span>
        </nav>
    </div>
    <div class="page-actions">
        <form action="{{ route('reports.qr-scans.export') }}" method="POST" class="inline">
            @csrf
            @foreach($filters as $key => $value)
                @if($value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
            <button type="submit" name="format" value="excel" class="btn btn-outline mr-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Excel
            </button>
            <button type="submit" name="format" value="csv" class="btn btn-outline">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export CSV
            </button>
        </form>
    </div>
</div>

<!-- Filter Form -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">Filter Scans</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('reports.qr-scans') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Date From -->
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                    <input type="date"
                           id="date_from"
                           name="date_from"
                           value="{{ $filters['date_from'] ?? '' }}"
                           class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                </div>

                <!-- Date To -->
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                    <input type="date"
                           id="date_to"
                           name="date_to"
                           value="{{ $filters['date_to'] ?? '' }}"
                           class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                </div>

                <!-- Member -->
                <div>
                    <label for="member_id" class="block text-sm font-medium text-gray-700 mb-1">Member</label>
                    <select id="member_id"
                            name="member_id"
                            class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                        <option value="">All Members</option>
                        @foreach(\App\Models\Member::orderBy('first_name')->get() as $member)
                        <option value="{{ $member->id }}" {{ ($filters['member_id'] ?? '') == $member->id ? 'selected' : '' }}>
                            {{ $member->full_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Service Type -->
                <div>
                    <label for="service_type" class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
                    <select id="service_type"
                            name="service_type"
                            class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                        <option value="">All Types</option>
                        <option value="sunday_service" {{ ($filters['service_type'] ?? '') == 'sunday_service' ? 'selected' : '' }}>Sunday Service</option>
                        <option value="mid_week_service" {{ ($filters['service_type'] ?? '') == 'mid_week_service' ? 'selected' : '' }}>Mid-Week Service</option>
                        <option value="prayer_meeting" {{ ($filters['service_type'] ?? '') == 'prayer_meeting' ? 'selected' : '' }}>Prayer Meeting</option>
                        <option value="special_service" {{ ($filters['service_type'] ?? '') == 'special_service' ? 'selected' : '' }}>Special Service</option>
                        <option value="program" {{ ($filters['service_type'] ?? '') == 'program' ? 'selected' : '' }}>Program</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Apply
                    </button>
                    <a href="{{ route('reports.qr-scans') }}" class="btn btn-outline">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="stat-card stat-card-gradient-blue">
        <div class="stat-value">{{ number_format($statistics['total_scans']) }}</div>
        <div class="stat-label">Total Scans</div>
        @if($statistics['date_range'][0] || $statistics['date_range'][1])
        <div class="stat-subtext">
            {{ $statistics['date_range'][0] ?? 'Start' }} to {{ $statistics['date_range'][1] ?? 'Now' }}
        </div>
        @else
        <div class="stat-subtext">All Time</div>
        @endif
    </div>

    <div class="stat-card stat-card-gradient-purple">
        <div class="stat-value">{{ number_format($statistics['unique_members']) }}</div>
        <div class="stat-label">Unique Members</div>
        <div class="stat-subtext">Different scanners</div>
    </div>

    <div class="stat-card bg-white text-gray-900 border border-gray-200">
        <div class="stat-label text-sm mb-2">By Service Type</div>
        <div class="space-y-1">
            @forelse($statistics['by_service_type'] as $type)
            <div class="flex justify-between items-center text-xs">
                <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $type->service_type) }}</span>
                <span class="font-semibold">{{ number_format($type->count) }}</span>
            </div>
            @empty
            <div class="text-xs text-gray-500">No data</div>
            @endforelse
        </div>
    </div>

    <div class="stat-card bg-white text-gray-900 border border-gray-200">
        <div class="stat-label text-sm mb-2">By Day of Week</div>
        <div class="space-y-1">
            @forelse($statistics['by_day_of_week']->take(3) as $day)
            <div class="flex justify-between items-center text-xs">
                <span class="text-gray-600">{{ $day->day }}</span>
                <span class="font-semibold">{{ number_format($day->count) }}</span>
            </div>
            @empty
            <div class="text-xs text-gray-500">No data</div>
            @endforelse
        </div>
    </div>
</div>

<!-- Scan History Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Scan Records</h3>
        <div class="text-sm text-gray-600">
            Showing {{ $scans->firstItem() ?? 0 }} to {{ $scans->lastItem() ?? 0 }} of {{ $scans->total() }} scans
        </div>
    </div>
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Timestamp</th>
                        <th>Member</th>
                        <th>Service Type</th>
                        <th>Service/Program</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($scans as $scan)
                    <tr>
                        <td class="text-sm">
                            <div class="font-medium">{{ $scan->created_at->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $scan->created_at->format('g:i A') }}</div>
                        </td>
                        <td>
                            @if($scan->member)
                            <div class="flex items-center">
                                @if($scan->member->photo_url)
                                <img src="{{ Storage::url($scan->member->photo_url) }}"
                                     alt="{{ $scan->member->full_name }}"
                                     class="w-8 h-8 rounded-full object-cover mr-2">
                                @else
                                <div class="w-8 h-8 rounded-full bg-gradient-primary flex items-center justify-center text-white text-xs font-bold mr-2">
                                    {{ strtoupper(substr($scan->member->first_name, 0, 1) . substr($scan->member->last_name, 0, 1)) }}
                                </div>
                                @endif
                                <div>
                                    <a href="{{ route('members.show', $scan->member) }}" class="text-primary-600 hover:text-primary-700 font-medium text-sm">
                                        {{ $scan->member->full_name }}
                                    </a>
                                    <div class="text-xs text-gray-500">{{ $scan->member->member_id }}</div>
                                </div>
                            </div>
                            @else
                            <span class="text-gray-500">N/A</span>
                            @endif
                        </td>
                        <td>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800 capitalize">
                                {{ str_replace('_', ' ', $scan->service_type) }}
                            </span>
                        </td>
                        <td class="text-sm">
                            @if($scan->service)
                            <a href="{{ route('services.show', $scan->service) }}" class="text-primary-600 hover:text-primary-700">
                                {{ $scan->service->name ?? 'Service #' . $scan->service_id }}
                            </a>
                            @else
                            <span class="text-gray-500">-</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $statusColors = [
                                    'present' => 'badge-success',
                                    'late' => 'badge-warning',
                                    'excused' => 'badge-info',
                                    'absent' => 'badge-danger',
                                ];
                            @endphp
                            <span class="badge {{ $statusColors[$scan->status] ?? 'badge-secondary' }}">
                                {{ ucfirst($scan->status) }}
                            </span>
                        </td>
                        <td>
                            @if($scan->member)
                            <a href="{{ route('members.show', $scan->member) }}" class="text-primary-600 hover:text-primary-700 text-sm">
                                View Details
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p>No QR scans found matching your criteria</p>
                            <p class="text-sm mt-2">Try adjusting your filters</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($scans->hasPages())
    <div class="card-footer">
        {{ $scans->links() }}
    </div>
    @endif
</div>

@endsection
