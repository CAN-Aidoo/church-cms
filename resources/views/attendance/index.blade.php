@extends('layouts.app')

@section('title', 'Attendance Records')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Attendance Records</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Attendance</span>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('attendance.reports') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Reports
        </a>
        <a href="{{ route('attendance.mark') }}" class="btn btn-primary flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Mark Attendance
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border-l-4 border-l-primary-500 bg-gradient-to-br from-white to-primary-50/20">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Records</p>
                <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">{{ number_format($statistics['total_records']) }}</h3>
            </div>
            <div class="p-2 bg-primary-100/50 rounded-lg text-primary-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-emerald-500 bg-gradient-to-br from-white to-emerald-50/20">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Present</p>
                <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">{{ number_format($statistics['present_count']) }}</h3>
            </div>
            <div class="p-2 bg-emerald-100/50 rounded-lg text-emerald-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-amber-500 bg-gradient-to-br from-white to-amber-50/20">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Attendance Rate</p>
                <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">{{ $statistics['attendance_rate'] }}%</h3>
            </div>
            <div class="p-2 bg-amber-100/50 rounded-lg text-amber-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-red-500 bg-gradient-to-br from-white to-red-50/20">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Absent</p>
                <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">{{ number_format($statistics['absent_count']) }}</h3>
            </div>
            <div class="p-2 bg-red-100/50 rounded-lg text-red-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card border border-slate-100 mb-8" x-data="{ showFilters: false }">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-base">Search & Filters</h3>
        <button @click="showFilters = !showFilters" class="text-sm text-primary-600 hover:text-primary-700 font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
        </button>
    </div>
    <div class="p-6">
        <form method="GET" action="{{ route('attendance.index') }}" class="space-y-6">
            <!-- Search Bar -->
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                               placeholder="Search by member name or ID..."
                               class="form-input w-full pl-10 border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary px-6">
                        Search
                    </button>
                    @if(count(array_filter($filters ?? [])) > 0)
                    <a href="{{ route('attendance.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900">
                        Clear
                    </a>
                    @endif
                </div>
            </div>

            <!-- Advanced Filters -->
            <div x-show="showFilters" x-transition x-cloak class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pt-6 border-t border-slate-100">
                <div>
                    <label class="form-label mb-1.5">Date From</label>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}"
                           class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                </div>

                <div>
                    <label class="form-label mb-1.5">Date To</label>
                    <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}"
                           class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                </div>

                <div>
                    <label class="form-label mb-1.5">Service Type</label>
                    <select name="service_type" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                        <option value="">All Types</option>
                        <option value="sunday_first" {{ ($filters['service_type'] ?? '') === 'sunday_first' ? 'selected' : '' }}>Sunday First</option>
                        <option value="sunday_second" {{ ($filters['service_type'] ?? '') === 'sunday_second' ? 'selected' : '' }}>Sunday Second</option>
                        <option value="midweek" {{ ($filters['service_type'] ?? '') === 'midweek' ? 'selected' : '' }}>Midweek</option>
                        <option value="prayer_meeting" {{ ($filters['service_type'] ?? '') === 'prayer_meeting' ? 'selected' : '' }}>Prayer Meeting</option>
                        <option value="special" {{ ($filters['service_type'] ?? '') === 'special' ? 'selected' : '' }}>Special</option>
                    </select>
                </div>

                <div>
                    <label class="form-label mb-1.5">Status</label>
                    <select name="status" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
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
<div class="card border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-base">Attendance Records <span class="text-slate-500 font-normal ml-1">({{ $attendance->total() }})</span></h3>
        <div class="flex gap-2">
            <form method="GET" action="{{ route('attendance.export') }}" class="inline">
                @foreach($filters ?? [] as $key => $value)
                    @if($value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <button type="submit" class="text-xs font-bold text-primary-600 hover:text-primary-700 uppercase tracking-wider hover:underline flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export CSV
                </button>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        @if($attendance->count() > 0)
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Member</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Service Date</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Service Type</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Status</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Notes</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Recorded By</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 bg-white">
                @foreach($attendance as $record)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($record->member->photo_url)
                            <img src="{{ Storage::url($record->member->photo_url) }}"
                                 alt="{{ $record->member->full_name }}"
                                 class="w-8 h-8 rounded-full object-cover ring-2 ring-white shadow-sm">
                            @else
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500 ring-2 ring-white shadow-sm">
                                {{ strtoupper(substr($record->member->first_name, 0, 1) . substr($record->member->last_name, 0, 1)) }}
                            </div>
                            @endif
                            <div>
                                <a href="{{ route('members.show', $record->member) }}"
                                   class="text-sm font-semibold text-slate-900 hover:text-primary-600 transition-colors block">
                                    {{ $record->member->full_name }}
                                </a>
                                <div class="text-xs text-slate-500 font-mono">{{ $record->member->member_id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ $record->service_date->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600 capitalize">{{ str_replace('_', ' ', $record->service_type) }}</td>
                    <td class="px-6 py-4">
                        @php
                            $statusClasses = [
                                'present' => 'bg-emerald-100 text-emerald-700 ring-emerald-600/20',
                                'absent' => 'bg-red-100 text-red-700 ring-red-600/20',
                                'excused' => 'bg-amber-100 text-amber-700 ring-amber-600/20',
                                'late' => 'bg-amber-100 text-amber-700 ring-amber-600/20',
                            ];
                        @endphp
                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClasses[$record->status] ?? 'bg-slate-100 text-slate-700 ring-slate-600/20' }}">
                            {{ ucfirst($record->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate">{{ $record->notes ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="text-xs text-slate-900 font-medium">{{ $record->recorder?->full_name ?? 'System' }}</div>
                        <div class="text-xs text-slate-500">{{ $record->recorded_at->format('M d, H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('attendance.edit', $record) }}"
                               class="text-slate-400 hover:text-primary-600 transition-colors"
                               title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            @if(auth()->user()->hasAnyRole(['admin', 'pastor']))
                            <form action="{{ route('attendance.destroy', $record) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this attendance record?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors" title="Delete">
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

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $attendance->links() }}
        </div>
        @else
        <div class="p-12 text-center text-slate-400">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center text-slate-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-1">No attendance records found</h3>
            <p class="text-slate-500 mb-6">Try adjusting your filters, or mark attendance for a service.</p>
            <a href="{{ route('attendance.mark') }}" class="btn btn-primary">
                Mark Attendance
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
