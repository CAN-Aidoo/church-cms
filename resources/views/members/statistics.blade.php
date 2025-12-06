@extends('layouts.app')

@section('title', 'Member Statistics')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Member Statistics</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('members.index') }}">Members</a>
            <span>/</span>
            <span>Statistics</span>
        </nav>
    </div>
    <div class="page-actions">
        <a href="{{ route('members.index') }}" class="btn btn-outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Members
        </a>
    </div>
</div>

<!-- Overview Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="stat-card stat-card-gradient-blue">
        <div class="stat-value">{{ number_format($statistics['total_members']) }}</div>
        <div class="stat-label">Total Members</div>
    </div>
    <div class="stat-card stat-card-gradient-green">
        <div class="stat-value">{{ number_format($statistics['active_members']) }}</div>
        <div class="stat-label">Active Members</div>
    </div>
    <div class="stat-card stat-card-gradient-gold">
        <div class="stat-value">{{ number_format($statistics['new_members_month']) }}</div>
        <div class="stat-label">New This Month</div>
    </div>
    <div class="stat-card bg-white text-gray-900 border border-gray-200">
        <div class="stat-value">{{ number_format($statistics['average_age']) }}</div>
        <div class="stat-label">Average Age</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Demographics -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Demographics</h3>
        </div>
        <div class="card-body">
            <!-- Gender Distribution -->
            <div class="mb-6">
                <h4 class="font-semibold text-gray-900 mb-3">Gender Distribution</h4>
                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Male</span>
                            <span class="font-semibold text-gray-900">
                                {{ $demographics['gender']['male'] }} ({{ $demographics['gender']['male_percentage'] }}%)
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-primary h-2 rounded-full" style="width: {{ $demographics['gender']['male_percentage'] }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Female</span>
                            <span class="font-semibold text-gray-900">
                                {{ $demographics['gender']['female'] }} ({{ $demographics['gender']['female_percentage'] }}%)
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-gold h-2 rounded-full" style="width: {{ $demographics['gender']['female_percentage'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Age Distribution -->
            <div class="mb-6">
                <h4 class="font-semibold text-gray-900 mb-3">Age Distribution</h4>
                <div class="space-y-3">
                    @foreach($demographics['age_groups'] as $group => $count)
                    @php
                        $percentage = $statistics['total_members'] > 0
                            ? round(($count / $statistics['total_members']) * 100, 1)
                            : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">{{ $group }}</span>
                            <span class="font-semibold text-gray-900">{{ $count }} ({{ $percentage }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-blue-gold h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Marital Status -->
            <div>
                <h4 class="font-semibold text-gray-900 mb-3">Marital Status</h4>
                <div class="space-y-3">
                    @foreach($demographics['marital_status'] as $status => $count)
                    @php
                        $percentage = $statistics['total_members'] > 0
                            ? round(($count / $statistics['total_members']) * 100, 1)
                            : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600 capitalize">{{ $status }}</span>
                            <span class="font-semibold text-gray-900">{{ $count }} ({{ $percentage }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-primary h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Member Growth Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Member Growth (Last 12 Months)</h3>
        </div>
        <div class="card-body">
            <canvas id="memberGrowthChart" height="300"></canvas>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Upcoming Birthdays -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Upcoming Birthdays (Next 30 Days)</h3>
        </div>
        <div class="card-body p-0">
            @if($upcomingBirthdays->count() > 0)
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Date</th>
                            <th>Age</th>
                            <th>Days Until</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($upcomingBirthdays as $member)
                        @php
                            $birthday = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y') . '-' . $member->date_of_birth->format('m-d'));
                            if ($birthday->isPast()) {
                                $birthday->addYear();
                            }
                            $daysUntil = now()->diffInDays($birthday, false);
                        @endphp
                        <tr>
                            <td>
                                <a href="{{ route('members.show', $member) }}" class="text-primary-600 hover:text-primary-700">
                                    {{ $member->full_name }}
                                </a>
                            </td>
                            <td>{{ $member->date_of_birth->format('F d') }}</td>
                            <td>{{ $member->age }} years</td>
                            <td>
                                @if($daysUntil == 0)
                                <span class="badge badge-success">Today!</span>
                                @elseif($daysUntil == 1)
                                <span class="badge badge-warning">Tomorrow</span>
                                @else
                                <span class="text-gray-600">{{ $daysUntil }} days</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-8 text-center text-gray-500">
                <p>No upcoming birthdays in the next 30 days</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Incomplete Profiles -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Incomplete Profiles ({{ $incompleteProfiles->count() }})</h3>
        </div>
        <div class="card-body p-0">
            @if($incompleteProfiles->count() > 0)
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Missing Information</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($incompleteProfiles->take(10) as $member)
                        <tr>
                            <td>
                                <a href="{{ route('members.show', $member) }}" class="text-primary-600 hover:text-primary-700">
                                    {{ $member->full_name }}
                                </a>
                            </td>
                            <td>
                                <div class="flex flex-wrap gap-1">
                                    @if(!$member->photo_url)
                                    <span class="badge badge-secondary text-xs">Photo</span>
                                    @endif
                                    @if(!$member->date_of_birth)
                                    <span class="badge badge-secondary text-xs">DOB</span>
                                    @endif
                                    @if(!$member->phone)
                                    <span class="badge badge-secondary text-xs">Phone</span>
                                    @endif
                                    @if(!$member->address)
                                    <span class="badge badge-secondary text-xs">Address</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('members.edit', $member) }}" class="btn-icon btn-icon-sm text-gold-600" title="Complete Profile">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($incompleteProfiles->count() > 10)
            <div class="p-4 bg-gray-50 border-t text-center">
                <p class="text-sm text-gray-600">
                    Showing 10 of {{ $incompleteProfiles->count() }} incomplete profiles
                </p>
            </div>
            @endif
            @else
            <div class="p-8 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-green-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="font-semibold text-green-600">All profiles are complete!</p>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Member Growth Chart
    const growthCtx = document.getElementById('memberGrowthChart');
    if (growthCtx) {
        const growthData = @json($statistics['growth_trend'] ?? []);

        new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: Object.keys(growthData),
                datasets: [{
                    label: 'New Members',
                    data: Object.values(growthData),
                    borderColor: 'rgb(37, 99, 235)',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }
</script>
@endsection
