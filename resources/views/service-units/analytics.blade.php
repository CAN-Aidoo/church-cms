@extends('layouts.app')

@section('title', 'Service Units Analytics')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Service Units Analytics</h1>
            <p class="text-gray-600 mt-1">Performance metrics and insights across all service units</p>
        </div>
        <a href="{{ route('service-units.index') }}"
           class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
            Back to Units
        </a>
    </div>

    <!-- Overall Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Units</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_units'] }}</p>
                    <p class="text-sm text-blue-100 mt-1">{{ $stats['active_units'] }} active</p>
                </div>
                <div class="bg-blue-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Members</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_members'] }}</p>
                    <p class="text-sm text-green-100 mt-1">{{ number_format($stats['average_members_per_unit'], 1) }} avg per unit</p>
                </div>
                <div class="bg-green-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Upcoming Duties</p>
                    <p class="text-3xl font-bold mt-2">{{ $upcomingDuties->count() }}</p>
                    <p class="text-sm text-yellow-100 mt-1">Next 30 days</p>
                </div>
                <div class="bg-yellow-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Needs Attention</p>
                    <p class="text-3xl font-bold mt-2">{{ $needingAttention->count() }}</p>
                    <p class="text-sm text-red-100 mt-1">Below minimum</p>
                </div>
                <div class="bg-red-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Units Needing Attention -->
    @if($needingAttention->isNotEmpty())
    <div class="bg-red-50 border-2 border-red-200 rounded-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-red-900 mb-4 flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Units Needing Attention
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($needingAttention as $unit)
            <div class="bg-white border border-red-300 rounded-lg p-4">
                <h3 class="font-semibold text-gray-900">{{ $unit->name }}</h3>
                <p class="text-sm text-gray-600 mt-1">{{ $unit->code }} • {{ ucfirst($unit->category) }}</p>
                <div class="mt-3">
                    <div class="flex justify-between items-center text-sm mb-1">
                        <span class="text-red-700 font-medium">Below Minimum</span>
                        <span class="text-gray-900">{{ $unit->current_members }}/{{ $unit->min_members }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: {{ min(($unit->current_members / $unit->min_members) * 100, 100) }}%"></div>
                    </div>
                    <p class="text-xs text-red-700 mt-2">Need {{ $unit->min_members - $unit->current_members }} more member(s)</p>
                </div>
                <a href="{{ route('service-units.manage-members', $unit) }}"
                   class="mt-3 block text-center px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition text-sm">
                    Add Members
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Upcoming Duties Overview -->
    @if($upcomingDuties->isNotEmpty())
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Upcoming Duties (Next 30 Days)</h2>
        <div class="space-y-3">
            @foreach($upcomingDuties->take(10) as $duty)
            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:border-blue-300 transition">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 rounded-lg p-2 text-center min-w-[50px]">
                        <p class="text-lg font-bold text-blue-900">{{ \Carbon\Carbon::parse($duty->duty_date)->format('d') }}</p>
                        <p class="text-xs text-blue-700">{{ \Carbon\Carbon::parse($duty->duty_date)->format('M') }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">{{ $duty->serviceUnit->name }}</p>
                        <p class="text-sm text-gray-600">{{ $duty->roster_name }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                {{ ucwords(str_replace('_', ' ', $duty->duty_type)) }}
                            </span>
                            @if($duty->start_time)
                            <span class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($duty->start_time)->format('g:i A') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">{{ $duty->assignments->count() }} assigned</p>
                    <span class="px-2 py-1 rounded text-xs font-semibold
                        @if($duty->status === 'published') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($duty->status) }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Unit Performance Breakdown -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Unit Performance (Last 90 Days)</h2>

        @if($units->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Members</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capacity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completion Rate</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rosters</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($units as $unit)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-medium text-gray-900">{{ $unit->name }}</p>
                                <p class="text-sm text-gray-500">{{ $unit->code }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                {{ ucfirst($unit->category) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $unit->current_members }}/{{ $unit->max_members }}
                            @if($unit->current_members < $unit->min_members)
                            <span class="text-red-600 ml-1">⚠️</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="w-24">
                                <div class="flex justify-between items-center text-xs mb-1">
                                    <span class="text-gray-600">{{ number_format($unit->capacity_percentage, 0) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="
                                        @if($unit->capacity_percentage >= 100) bg-red-500
                                        @elseif($unit->capacity_percentage >= 80) bg-yellow-500
                                        @else bg-green-500
                                        @endif
                                        h-2 rounded-full"
                                         style="width: {{ min($unit->capacity_percentage, 100) }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-20">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="
                                            @if($unit->performance['completion_rate'] >= 80) bg-green-500
                                            @elseif($unit->performance['completion_rate'] >= 60) bg-yellow-500
                                            @else bg-red-500
                                            @endif
                                            h-2 rounded-full"
                                             style="width: {{ $unit->performance['completion_rate'] }}%"></div>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-900">{{ number_format($unit->performance['completion_rate'], 0) }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $unit->performance['completed_rosters'] }} completed
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('service-units.show', $unit) }}"
                               class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                View Details →
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <p class="text-gray-600">No service units found.</p>
        </div>
        @endif
    </div>
</div>
@endsection
