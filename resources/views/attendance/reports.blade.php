@extends('layouts.app')

@section('title', 'Attendance Reports')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Attendance Reports & Analytics</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('attendance.index') }}" class="hover:text-primary-600 transition-colors">Attendance</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Reports</span>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('attendance.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            Back to Attendance
        </a>
    </div>
</div>

<!-- Date Range Filter -->
<div class="card border border-slate-100 mb-8">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
        <h3 class="font-bold text-slate-800 text-base">Report Period</h3>
    </div>
    <div class="p-6">
        <form method="GET" action="{{ route('attendance.reports') }}" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-1/3">
                <label class="form-label mb-1.5 block font-medium text-sm text-slate-700">From Date</label>
                <input type="date" name="date_from" value="{{ $filters['date_from'] }}"
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
            </div>
            <div class="w-full md:w-1/3">
                <label class="form-label mb-1.5 block font-medium text-sm text-slate-700">To Date</label>
                <input type="date" name="date_to" value="{{ $filters['date_to'] }}"
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
            </div>
            <div class="w-full md:w-auto">
                <button type="submit" class="btn btn-primary w-full md:w-auto">
                    Generate Report
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Overview Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border-l-4 border-l-primary-500 bg-gradient-to-br from-white to-primary-50/20 shadow-sm hover:shadow-md transition-shadow">
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
    
    <div class="card p-6 border-l-4 border-l-emerald-500 bg-gradient-to-br from-white to-emerald-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Present Count</p>
                <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">{{ number_format($statistics['present_count']) }}</h3>
            </div>
            <div class="p-2 bg-emerald-100/50 rounded-lg text-emerald-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </div>
    </div>
    
    <div class="card p-6 border-l-4 border-l-amber-500 bg-gradient-to-br from-white to-amber-50/20 shadow-sm hover:shadow-md transition-shadow">
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
    
    <div class="card p-6 border-l-4 border-l-indigo-500 bg-gradient-to-br from-white to-indigo-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Unique Attenders</p>
                <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">{{ number_format($statistics['unique_attenders']) }}</h3>
            </div>
            <div class="p-2 bg-indigo-100/50 rounded-lg text-indigo-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Attendance Trend Chart -->
    <div class="card border border-slate-100">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Attendance Trend (Last 12 Weeks)</h3>
        </div>
        <div class="p-6">
            <canvas id="attendanceTrendChart" height="250"></canvas>
        </div>
    </div>

    <!-- Service Type Analysis -->
    <div class="card border border-slate-100">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Attendance by Service Type</h3>
        </div>
        <div class="p-6">
            @if(count($serviceTypeAnalysis) > 0)
            <div class="space-y-6">
                @foreach($serviceTypeAnalysis as $type => $data)
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-slate-700 capitalize font-bold">{{ str_replace('_', ' ', $type) }}</span>
                        <span class="text-slate-900 font-bold">{{ $data['rate'] }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                        <div class="bg-gradient-to-r from-primary-400 to-primary-600 h-3 rounded-full shadow-sm" style="width: {{ $data['rate'] }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-slate-500 mt-1.5 font-medium">
                        <span>Present: {{ $data['present'] }}</span>
                        <span>Total: {{ $data['total'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <p>No service data available for the selected period.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Top Attenders -->
    <div class="card border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Top Attenders</h3>
        </div>
        <div class="overflow-x-auto">
            @if(count($topAttenders) > 0)
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100 w-16">#</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100">Member</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100 text-center">Attendance</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Percentage</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 bg-white">
                    @foreach($topAttenders as $index => $attender)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-slate-500">
                            @if($index < 3)
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full
                                {{ $index === 0 ? 'bg-amber-100 text-amber-700 ring-1 ring-amber-200' : '' }}
                                {{ $index === 1 ? 'bg-slate-100 text-slate-600 ring-1 ring-slate-200' : '' }}
                                {{ $index === 2 ? 'bg-orange-100 text-orange-700 ring-1 ring-orange-200' : '' }}
                                font-bold text-xs shadow-sm">
                                {{ $index + 1 }}
                            </span>
                            @else
                            {{ $index + 1 }}
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <a href="{{ route('members.show', $attender['member']) }}"
                               class="text-slate-900 hover:text-primary-600 transition-colors">
                                {{ $attender['member']->full_name }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center px-2 py-0.5 rounded text-xs font-bold bg-slate-100 text-slate-700">
                                {{ $attender['attendance_count'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-emerald-600 font-bold text-sm">{{ $attender['attendance_percentage'] ?? 100 }}%</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="p-8 text-center text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <p>No attendance data available.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Members Needing Follow-Up -->
    <div class="card border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-base">Members Needing Follow-Up</h3>
            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">{{ count($membersNeedingFollowUp) }}</span>
        </div>
        <div class="overflow-x-auto">
            @if(count($membersNeedingFollowUp) > 0)
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100">Member</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100">Cons. Absences</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100">Last Present</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 bg-white">
                    @foreach($membersNeedingFollowUp as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <a href="{{ route('members.show', $item['member']) }}"
                               class="text-sm font-bold text-slate-900 hover:text-primary-600 block transition-colors">
                                {{ $item['member']->full_name }}
                            </a>
                            <div class="text-xs text-slate-500 font-mono mt-0.5">{{ $item['member']->phone }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-md bg-red-100 px-2 py-1 text-xs font-bold text-red-700 ring-1 ring-inset ring-red-600/20">
                                {{ $item['consecutive_absences'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ $item['last_present'] ? \Carbon\Carbon::parse($item['last_present'])->format('M d, Y') : 'N/A' }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="tel:{{ $item['member']->phone }}" class="p-2 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-colors inline-block" title="Call">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="p-8 text-center text-emerald-500">
                <svg class="mx-auto h-12 w-12 mb-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="font-bold text-emerald-700">All members are attending regularly!</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Inactive Members -->
<div class="card border border-slate-100 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-base">Inactive Members (30+ Days)</h3>
        <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-800">{{ count($inactiveMembers) }}</span>
    </div>
    <div class="overflow-x-auto">
        @if(count($inactiveMembers) > 0)
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Member</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Contact</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Last Attendance</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Days Absent</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 bg-white">
                @foreach($inactiveMembers as $item)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($item['member']->photo_url)
                            <img src="{{ Storage::url($item['member']->photo_url) }}"
                                 alt="{{ $item['member']->full_name }}"
                                 class="w-8 h-8 rounded-full object-cover ring-2 ring-white shadow-sm">
                            @else
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500 ring-2 ring-white shadow-sm">
                                {{ strtoupper(substr($item['member']->first_name, 0, 1) . substr($item['member']->last_name, 0, 1)) }}
                            </div>
                            @endif
                            <div>
                                <a href="{{ route('members.show', $item['member']) }}"
                                   class="text-sm font-semibold text-slate-900 hover:text-primary-600 transition-colors block">
                                    {{ $item['member']->full_name }}
                                </a>
                                <div class="text-xs text-slate-500 font-mono">{{ $item['member']->member_id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <div class="font-medium text-slate-700">{{ $item['member']->phone }}</div>
                        <div class="text-slate-500 text-xs">{{ $item['member']->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ $item['last_attendance'] ? \Carbon\Carbon::parse($item['last_attendance'])->format('M d, Y') : 'Never attended' }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset 
                            {{ ($item['days_absent'] ?? 0) > 90 ? 'bg-red-100 text-red-700 ring-red-600/20' : '' }}
                            {{ ($item['days_absent'] ?? 0) <= 90 && ($item['days_absent'] ?? 0) > 60 ? 'bg-amber-100 text-amber-700 ring-amber-600/20' : '' }}
                            {{ ($item['days_absent'] ?? 0) <= 60 ? 'bg-slate-100 text-slate-700 ring-slate-600/20' : '' }}">
                            {{ $item['days_absent'] ?? 'N/A' }} days
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="tel:{{ $item['member']->phone }}" class="p-1.5 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-colors" title="Call">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </a>
                            <a href="mailto:{{ $item['member']->email }}" class="p-1.5 rounded-lg bg-primary-50 text-primary-600 hover:bg-primary-100 transition-colors" title="Email">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="p-8 text-center text-emerald-500">
            <svg class="mx-auto h-12 w-12 mb-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="font-bold text-emerald-700">No inactive members!</p>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Attendance Trend Chart
    const trendCtx = document.getElementById('attendanceTrendChart');
    if (trendCtx) {
        const trendData = @json($trends);
        const labels = Object.keys(trendData);
        const presentData = labels.map(label => trendData[label].present);
        const rateData = labels.map(label => trendData[label].rate);

        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Present Count',
                        data: presentData,
                        borderColor: 'rgb(16, 185, 129)', // Emerald 500
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        yAxisID: 'y',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Attendance Rate (%)',
                        data: rateData,
                        borderColor: 'rgb(59, 130, 246)', // Blue 500
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        yAxisID: 'y1',
                        tension: 0.4,
                        fill: false,
                        borderDash: [5, 5]
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            font: {
                                family: "'Inter', sans-serif",
                                size: 12
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: "'Inter', sans-serif"
                            }
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Present Count',
                            font: {
                                family: "'Inter', sans-serif"
                            }
                        },
                        grid: {
                            color: '#f1f5f9'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Rate (%)',
                            font: {
                                family: "'Inter', sans-serif"
                            }
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                    },
                }
            }
        });
    }
</script>
@endsection
