@extends('layouts.app')

@section('title', 'Member Statistics')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Member Statistics</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('members.index') }}" class="hover:text-primary-600 transition-colors">Members</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Statistics</span>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('members.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Members
        </a>
    </div>
</div>

<!-- Overview Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border-l-4 border-l-primary-500 bg-gradient-to-br from-white to-primary-50/20">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Members</p>
                <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">{{ number_format($statistics['total_members']) }}</h3>
            </div>
            <div class="p-2 bg-primary-100/50 rounded-lg text-primary-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-emerald-500 bg-gradient-to-br from-white to-emerald-50/20">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Members</p>
                <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">{{ number_format($statistics['active_members']) }}</h3>
            </div>
            <div class="p-2 bg-emerald-100/50 rounded-lg text-emerald-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-amber-500 bg-gradient-to-br from-white to-amber-50/20">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">New This Month</p>
                <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">{{ number_format($statistics['new_members_month']) }}</h3>
            </div>
            <div class="p-2 bg-amber-100/50 rounded-lg text-amber-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-indigo-500 bg-gradient-to-br from-white to-indigo-50/20">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Average Age</p>
                <h3 class="text-2xl font-heading font-bold text-slate-900 mt-2">{{ number_format($statistics['average_age']) }}</h3>
            </div>
            <div class="p-2 bg-indigo-100/50 rounded-lg text-indigo-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Demographics -->
    <div class="card border border-slate-100">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Demographics</h3>
        </div>
        <div class="p-6">
            <!-- Gender Distribution -->
            <div class="mb-8">
                <h4 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary-600"></span>
                    Gender Distribution
                </h4>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-1.5">
                            <span class="text-slate-600 font-medium">Male</span>
                            <span class="font-bold text-slate-900">
                                {{ $demographics['gender']['male'] }} <span class="text-slate-400 font-normal">({{ $demographics['gender']['male_percentage'] }}%)</span>
                            </span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-primary-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $demographics['gender']['male_percentage'] }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1.5">
                            <span class="text-slate-600 font-medium">Female</span>
                            <span class="font-bold text-slate-900">
                                {{ $demographics['gender']['female'] }} <span class="text-slate-400 font-normal">({{ $demographics['gender']['female_percentage'] }}%)</span>
                            </span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-indigo-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $demographics['gender']['female_percentage'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Age Distribution -->
            <div class="mb-8">
                <h4 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    Age Distribution
                </h4>
                <div class="space-y-4">
                    @foreach($demographics['age_groups'] as $group => $count)
                    @php
                        $percentage = $statistics['total_members'] > 0
                            ? round(($count / $statistics['total_members']) * 100, 1)
                            : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1.5">
                            <span class="text-slate-600 font-medium">{{ $group }}</span>
                            <span class="font-bold text-slate-900">{{ $count }} <span class="text-slate-400 font-normal">({{ $percentage }}%)</span></span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-amber-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Marital Status -->
            <div>
                <h4 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Marital Status
                </h4>
                <div class="space-y-4">
                    @foreach($demographics['marital_status'] as $status => $count)
                    @php
                        $percentage = $statistics['total_members'] > 0
                            ? round(($count / $statistics['total_members']) * 100, 1)
                            : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1.5">
                            <span class="text-slate-600 font-medium capitalize">{{ $status }}</span>
                            <span class="font-bold text-slate-900">{{ $count }} <span class="text-slate-400 font-normal">({{ $percentage }}%)</span></span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Member Growth Chart -->
    <div class="card border border-slate-100 flex flex-col">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Member Growth (Last 12 Months)</h3>
        </div>
        <div class="p-6 flex-1 min-h-[300px]">
            <canvas id="memberGrowthChart" class="w-full h-full"></canvas>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Upcoming Birthdays -->
    <div class="card border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Upcoming Birthdays (Next 30 Days)</h3>
        </div>
        <div class="overflow-x-auto">
            @if($upcomingBirthdays->count() > 0)
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100">Member</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100">Date</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100">Age</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100">Days Until</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 bg-white">
                    @foreach($upcomingBirthdays as $member)
                    @php
                        $birthday = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y') . '-' . $member->date_of_birth->format('m-d'));
                        if ($birthday->isPast()) {
                            $birthday->addYear();
                        }
                        $daysUntil = now()->diffInDays($birthday, false);
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <a href="{{ route('members.show', $member) }}" class="text-primary-600 hover:text-primary-700 font-medium hover:underline">
                                {{ $member->full_name }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ $member->date_of_birth->format('F d') }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $member->age }} years</td>
                        <td class="px-6 py-4">
                            @if($daysUntil == 0)
                            <span class="inline-flex items-center rounded-md bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Today!</span>
                            @elseif($daysUntil == 1)
                            <span class="inline-flex items-center rounded-md bg-amber-100 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Tomorrow</span>
                            @else
                            <span class="text-sm text-slate-500 font-medium">{{ $daysUntil }} days</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="p-10 text-center text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"/>
                </svg>
                <p>No upcoming birthdays in the next 30 days</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Incomplete Profiles -->
    <div class="card border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 text-base">Incomplete Profiles</h3>
            <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">{{ $incompleteProfiles->count() }} Found</span>
        </div>
        <div class="overflow-x-auto">
            @if($incompleteProfiles->count() > 0)
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100">Member</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100">Missing Information</th>
                        <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 bg-white">
                    @foreach($incompleteProfiles->take(10) as $member)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <a href="{{ route('members.show', $member) }}" class="text-primary-600 hover:text-primary-700 font-medium hover:underline">
                                {{ $member->full_name }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @if(!$member->photo_url)
                                <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Photo</span>
                                @endif
                                @if(!$member->date_of_birth)
                                <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/10">DOB</span>
                                @endif
                                @if(!$member->phone)
                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/10">Phone</span>
                                @endif
                                @if(!$member->address)
                                <span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-medium text-slate-700 ring-1 ring-inset ring-slate-600/10">Address</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('members.edit', $member) }}" class="btn p-1 text-amber-600 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition-colors inline-flex" title="Complete Profile">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($incompleteProfiles->count() > 10)
            <div class="p-4 bg-slate-50 border-t border-slate-100 text-center">
                <p class="text-sm text-slate-500">
                    Showing 10 of {{ $incompleteProfiles->count() }} incomplete profiles
                </p>
            </div>
            @endif
            @else
            <div class="p-10 text-center text-slate-400">
                <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <p class="font-medium text-emerald-600">All profiles are complete!</p>
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
        // Parse the PHP data gracefully
        const growthData = {!! json_encode($statistics['growth_trend'] ?? []) !!};

        new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: Object.keys(growthData),
                datasets: [{
                    label: 'New Members',
                    data: Object.values(growthData),
                    borderColor: '#2563eb', // primary-600
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#2563eb',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
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
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#f8fafc',
                        bodyColor: '#f8fafc',
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                family: "'Inter', sans-serif",
                                size: 11
                            },
                            color: '#64748b'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: "'Inter', sans-serif",
                                size: 11
                            },
                            color: '#64748b'
                        }
                    }
                }
            }
        });
    }
</script>
@endsection
