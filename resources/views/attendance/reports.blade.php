@extends('layouts.app')

@section('title', 'Attendance Reports')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Attendance Reports & Analytics</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('attendance.index') }}">Attendance</a>
            <span>/</span>
            <span>Reports</span>
        </nav>
    </div>
    <div class="page-actions">
        <a href="{{ route('attendance.index') }}" class="btn btn-outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Attendance
        </a>
    </div>
</div>

<!-- Date Range Filter -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">Report Period</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('attendance.reports') }}" class="flex gap-4">
            <div>
                <label class="form-label">From Date</label>
                <input type="date" name="date_from" value="{{ $filters['date_from'] }}"
                       class="form-input">
            </div>
            <div>
                <label class="form-label">To Date</label>
                <input type="date" name="date_to" value="{{ $filters['date_to'] }}"
                       class="form-input">
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn btn-primary">
                    Generate Report
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Overview Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="stat-card stat-card-gradient-blue">
        <div class="stat-value">{{ number_format($statistics['total_records']) }}</div>
        <div class="stat-label">Total Records</div>
    </div>
    <div class="stat-card stat-card-gradient-green">
        <div class="stat-value">{{ number_format($statistics['present_count']) }}</div>
        <div class="stat-label">Present Count</div>
    </div>
    <div class="stat-card stat-card-gradient-gold">
        <div class="stat-value">{{ $statistics['attendance_rate'] }}%</div>
        <div class="stat-label">Attendance Rate</div>
    </div>
    <div class="stat-card bg-white text-gray-900 border border-gray-200">
        <div class="stat-value">{{ number_format($statistics['unique_attenders']) }}</div>
        <div class="stat-label">Unique Attenders</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Attendance Trend Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Attendance Trend (Last 12 Weeks)</h3>
        </div>
        <div class="card-body">
            <canvas id="attendanceTrendChart" height="250"></canvas>
        </div>
    </div>

    <!-- Service Type Analysis -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Attendance by Service Type</h3>
        </div>
        <div class="card-body">
            @if(count($serviceTypeAnalysis) > 0)
            <div class="space-y-4">
                @foreach($serviceTypeAnalysis as $type => $data)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700 capitalize font-medium">{{ str_replace('_', ' ', $type) }}</span>
                        <span class="text-gray-900 font-semibold">{{ $data['rate'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-gradient-primary h-3 rounded-full" style="width: {{ $data['rate'] }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>Present: {{ $data['present'] }}</span>
                        <span>Total: {{ $data['total'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center text-gray-500 py-8">No service data available for the selected period.</p>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Top Attenders -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Top Attenders</h3>
        </div>
        <div class="card-body p-0">
            @if(count($topAttenders) > 0)
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-12">#</th>
                            <th>Member</th>
                            <th class="text-center">Attendance</th>
                            <th class="text-right">Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topAttenders as $index => $attender)
                        <tr>
                            <td>
                                @if($index < 3)
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full
                                    {{ $index === 0 ? 'bg-yellow-400 text-yellow-900' : '' }}
                                    {{ $index === 1 ? 'bg-gray-300 text-gray-900' : '' }}
                                    {{ $index === 2 ? 'bg-orange-400 text-orange-900' : '' }}
                                    font-bold text-xs">
                                    {{ $index + 1 }}
                                </span>
                                @else
                                {{ $index + 1 }}
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('members.show', $attender['member']) }}"
                                   class="text-primary-600 hover:text-primary-700">
                                    {{ $attender['member']->full_name }}
                                </a>
                            </td>
                            <td class="text-center font-semibold">{{ $attender['attendance_count'] }}</td>
                            <td class="text-right">
                                <span class="text-green-600 font-semibold">{{ $attender['attendance_percentage'] ?? 100 }}%</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-center text-gray-500 py-8">No attendance data available.</p>
            @endif
        </div>
    </div>

    <!-- Members Needing Follow-Up -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Members Needing Follow-Up</h3>
            <span class="badge badge-danger">{{ count($membersNeedingFollowUp) }}</span>
        </div>
        <div class="card-body p-0">
            @if(count($membersNeedingFollowUp) > 0)
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Consecutive Absences</th>
                            <th>Last Absence</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($membersNeedingFollowUp as $item)
                        <tr>
                            <td>
                                <a href="{{ route('members.show', $item['member']) }}"
                                   class="text-primary-600 hover:text-primary-700">
                                    {{ $item['member']->full_name }}
                                </a>
                                <div class="text-xs text-gray-500">{{ $item['member']->phone }}</div>
                            </td>
                            <td>
                                <span class="badge badge-danger">{{ $item['consecutive_absences'] }}</span>
                            </td>
                            <td class="text-sm">{{ $item['last_present'] ? \Carbon\Carbon::parse($item['last_present'])->format('M d, Y') : 'N/A' }}</td>
                            <td class="text-right">
                                <a href="tel:{{ $item['member']->phone }}" class="btn-icon btn-icon-sm" title="Call">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-8 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-green-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="font-semibold text-green-600">All members are attending regularly!</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Inactive Members -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Inactive Members (30+ Days)</h3>
        <span class="badge badge-warning">{{ count($inactiveMembers) }}</span>
    </div>
    <div class="card-body p-0">
        @if(count($inactiveMembers) > 0)
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Contact</th>
                        <th>Last Attendance</th>
                        <th>Days Absent</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inactiveMembers as $item)
                    <tr>
                        <td>
                            <div class="flex items-center space-x-3">
                                @if($item['member']->photo_url)
                                <img src="{{ Storage::url($item['member']->photo_url) }}"
                                     alt="{{ $item['member']->full_name }}"
                                     class="w-10 h-10 rounded-full object-cover">
                                @else
                                <div class="w-10 h-10 rounded-full bg-gradient-primary flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($item['member']->first_name, 0, 1) . substr($item['member']->last_name, 0, 1)) }}
                                </div>
                                @endif
                                <div>
                                    <a href="{{ route('members.show', $item['member']) }}"
                                       class="font-semibold text-primary-600 hover:text-primary-700">
                                        {{ $item['member']->full_name }}
                                    </a>
                                    <div class="text-xs text-gray-500">{{ $item['member']->member_id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-sm">
                            <div>{{ $item['member']->phone }}</div>
                            <div class="text-gray-500">{{ $item['member']->email }}</div>
                        </td>
                        <td class="text-sm">
                            {{ $item['last_attendance'] ? \Carbon\Carbon::parse($item['last_attendance'])->format('M d, Y') : 'Never attended' }}
                        </td>
                        <td>
                            <span class="badge
                                {{ ($item['days_absent'] ?? 0) > 90 ? 'badge-danger' : '' }}
                                {{ ($item['days_absent'] ?? 0) <= 90 && ($item['days_absent'] ?? 0) > 60 ? 'badge-warning' : '' }}
                                {{ ($item['days_absent'] ?? 0) <= 60 ? 'badge-secondary' : '' }}">
                                {{ $item['days_absent'] ?? 'N/A' }} days
                            </span>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="tel:{{ $item['member']->phone }}" class="btn-icon btn-icon-sm" title="Call">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </a>
                                <a href="mailto:{{ $item['member']->email }}" class="btn-icon btn-icon-sm" title="Email">
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
        </div>
        @else
        <div class="p-8 text-center text-gray-500">
            <svg class="mx-auto h-12 w-12 text-green-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="font-semibold text-green-600">No inactive members!</p>
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
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        yAxisID: 'y',
                        tension: 0.4
                    },
                    {
                        label: 'Attendance Rate (%)',
                        data: rateData,
                        borderColor: 'rgb(37, 99, 235)',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        yAxisID: 'y1',
                        tension: 0.4
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
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Present Count'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Rate (%)'
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
