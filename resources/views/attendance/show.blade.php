@extends('layouts.app')

@section('title', 'Attendance Record Details')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Attendance Record Details</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('attendance.index') }}" class="hover:text-primary-600 transition-colors">Attendance</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Details</span>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('attendance.edit', $attendance) }}" class="btn btn-primary flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Record
        </a>
        <a href="{{ route('attendance.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            Back to List
        </a>
    </div>
</div>

<div class="max-w-4xl mx-auto space-y-8">
    <!-- Main Card -->
    <div class="card border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-base">Attendance Information</h3>
            @php
                $statusClasses = [
                    'present' => 'bg-emerald-100 text-emerald-700 ring-emerald-600/20',
                    'absent' => 'bg-red-100 text-red-700 ring-red-600/20',
                    'excused' => 'bg-amber-100 text-amber-700 ring-amber-600/20',
                    'late' => 'bg-amber-100 text-amber-700 ring-amber-600/20',
                ];
            @endphp
            <span class="inline-flex items-center rounded-md px-2.5 py-1 text-sm font-medium ring-1 ring-inset {{ $statusClasses[$attendance->status] ?? 'bg-slate-100 text-slate-700 ring-slate-600/20' }}">
                {{ ucfirst($attendance->status) }}
            </span>
        </div>

        <div class="p-6 space-y-8">
            <!-- Member Information -->
            <div class="p-4 bg-primary-50 rounded-xl border border-primary-100 flex flex-col md:flex-row items-start md:items-center gap-6">
                <div class="flex items-center gap-4 flex-1">
                    @if($attendance->member->photo_url)
                    <img src="{{ Storage::url($attendance->member->photo_url) }}"
                         alt="{{ $attendance->member->full_name }}"
                         class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-sm">
                    @else
                    <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center text-primary-600 text-xl font-bold border-2 border-white shadow-sm">
                        {{ strtoupper(substr($attendance->member->first_name, 0, 1)) }}{{ strtoupper(substr($attendance->member->last_name, 0, 1)) }}
                    </div>
                    @endif
                    <div>
                        <h3 class="font-heading font-bold text-slate-900 text-lg">
                            {{ $attendance->member->full_name }}
                        </h3>
                        <p class="text-sm text-slate-500 font-mono mb-1">{{ $attendance->member->member_id }}</p>
                        <div class="flex flex-wrap gap-4 text-xs font-medium text-slate-600">
                            @if($attendance->member->email)
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                {{ $attendance->member->email }}
                            </span>
                            @endif
                            @if($attendance->member->phone)
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $attendance->member->phone }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <a href="{{ route('members.show', $attendance->member) }}" class="btn bg-white border border-primary-100 text-primary-600 hover:bg-primary-50 hover:border-primary-200 shadow-sm text-sm">
                    View Profile
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Service Details -->
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Service Information
                    </h4>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-0.5">Service Date</p>
                            <p class="text-slate-900 font-medium">{{ $attendance->service_date->format('l, F d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-0.5">Service Type</p>
                            <p class="text-slate-900 font-medium capitalize">{{ str_replace('_', ' ', $attendance->service_type) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Record Metadata -->
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Record Metadata
                    </h4>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-0.5">Recorded By</p>
                                <p class="text-slate-900 font-medium">{{ $attendance->recorder->full_name ?? 'System' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-0.5">Recorded At</p>
                                <p class="text-slate-900 font-medium">{{ $attendance->recorded_at ? $attendance->recorded_at->format('M d, H:i') : 'N/A' }}</p>
                            </div>
                        </div>
                        @if($attendance->updated_at > $attendance->created_at)
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-0.5">Last Updated</p>
                            <p class="text-slate-900 font-medium text-sm">{{ $attendance->updated_at->format('M d, Y H:i') }} <span class="text-slate-400 font-normal">({{ $attendance->updated_at->diffForHumans() }})</span></p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Check-in Details (if available) -->
            @if($attendance->check_in_time || $attendance->check_in_method)
            <div class="p-4 bg-indigo-50 rounded-xl border border-indigo-100">
                <h4 class="text-sm font-bold text-indigo-900 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    Check-in Details
                </h4>
                <div class="flex gap-8">
                    @if($attendance->check_in_time)
                    <div>
                        <p class="text-xs text-indigo-600/70 uppercase tracking-wider font-bold mb-0.5">Check-in Time</p>
                        <p class="text-indigo-900 font-medium">{{ \Carbon\Carbon::parse($attendance->check_in_time)->format('h:i A') }}</p>
                    </div>
                    @endif
                    @if($attendance->check_in_method)
                    <div>
                        <p class="text-xs text-indigo-600/70 uppercase tracking-wider font-bold mb-0.5">Method</p>
                        <span class="inline-flex items-center rounded-md bg-indigo-100 px-2 py-1 text-xs font-medium text-indigo-800 ring-1 ring-inset ring-indigo-600/20">
                            {{ ucwords(str_replace('_', ' ', $attendance->check_in_method)) }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Notes Section -->
            @if($attendance->notes)
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                <h4 class="text-sm font-bold text-slate-900 mb-2">Notes</h4>
                <p class="text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $attendance->notes }}</p>
            </div>
            @endif
        </div>
        
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
            @if(auth()->user()->hasAnyRole(['admin', 'pastor']))
            <form action="{{ route('attendance.destroy', $attendance) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this attendance record?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Delete Record
                </button>
            </form>
            @else
            <div></div> <!-- Spacer -->
            @endif
        </div>
    </div>

    <!-- Attendance History Table -->
    <div class="card border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Recent Attendance History</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100">Date</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100">Service Type</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100">Status</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100">Check-in</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 bg-white">
                    @php
                        $recentAttendance = $attendance->member->attendances()
                            ->orderBy('service_date', 'desc')
                            ->where('id', '!=', $attendance->id)
                            ->take(5)
                            ->get();
                    @endphp
                    @forelse($recentAttendance as $record)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-slate-600 font-medium">
                            <a href="{{ route('attendance.show', $record) }}" class="hover:text-primary-600 hover:underline">
                                {{ $record->service_date->format('M d, Y') }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 capitalize">{{ str_replace('_', ' ', $record->service_type) }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClasses[$record->status] ?? 'bg-slate-100 text-slate-700 ring-slate-600/20' }}">
                                {{ ucfirst($record->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 font-mono text-xs">
                            {{ $record->check_in_time ? \Carbon\Carbon::parse($record->check_in_time)->format('H:i') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                            No other recent attendance records found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
