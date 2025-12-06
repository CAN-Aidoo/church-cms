@extends('layouts.app')

@section('title', 'Duty Rosters - ' . $serviceUnit->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('service-units.show', $serviceUnit) }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Duty Rosters</h1>
            </div>
            <p class="text-gray-600">{{ $serviceUnit->name }} - Schedule and manage duty assignments</p>
        </div>
        @can('update', $serviceUnit)
        <a href="{{ route('service-units.create-duty-roster', $serviceUnit) }}"
           class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Create Duty Roster
        </a>
        @endcan
    </div>

    <!-- Upcoming Duties -->
    @if($upcomingRosters->isNotEmpty())
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Upcoming Duties</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($upcomingRosters as $roster)
            <div class="border-2 border-blue-300 bg-blue-50 rounded-lg p-4">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900">{{ $roster->roster_name }}</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ \Carbon\Carbon::parse($roster->duty_date)->format('l, M d, Y') }}
                        </p>
                        @if($roster->start_time)
                        <p class="text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($roster->start_time)->format('g:i A') }}
                            @if($roster->end_time)
                            - {{ \Carbon\Carbon::parse($roster->end_time)->format('g:i A') }}
                            @endif
                        </p>
                        @endif
                    </div>
                    <span class="px-2 py-1 rounded text-xs font-semibold
                        @if($roster->status === 'published') bg-green-100 text-green-800
                        @elseif($roster->status === 'draft') bg-gray-100 text-gray-800
                        @else bg-blue-100 text-blue-800
                        @endif">
                        {{ ucfirst($roster->status) }}
                    </span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>{{ $roster->assignments->count() }} members assigned</span>
                </div>
                @if($roster->location)
                <div class="flex items-center gap-2 text-sm text-gray-600 mt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>{{ $roster->location }}</span>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- All Duty Rosters -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">All Duty Rosters</h2>

        @if($rosters->isNotEmpty())
        <div class="space-y-4">
            @foreach($rosters as $roster)
            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-start gap-3">
                            <!-- Date Badge -->
                            <div class="bg-blue-100 rounded-lg p-3 text-center min-w-[60px]">
                                <p class="text-2xl font-bold text-blue-900">{{ \Carbon\Carbon::parse($roster->duty_date)->format('d') }}</p>
                                <p class="text-xs text-blue-700">{{ \Carbon\Carbon::parse($roster->duty_date)->format('M Y') }}</p>
                            </div>

                            <!-- Roster Details -->
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $roster->roster_name }}</h3>
                                <div class="flex flex-wrap items-center gap-3 mt-2 text-sm text-gray-600">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($roster->duty_date)->format('l, M d, Y') }}
                                    </span>
                                    @if($roster->start_time)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($roster->start_time)->format('g:i A') }}
                                        @if($roster->end_time)
                                        - {{ \Carbon\Carbon::parse($roster->end_time)->format('g:i A') }}
                                        @endif
                                    </span>
                                    @endif
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                        {{ ucwords(str_replace('_', ' ', $roster->duty_type)) }}
                                    </span>
                                </div>

                                @if($roster->location)
                                <div class="flex items-center gap-2 text-sm text-gray-600 mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $roster->location }}</span>
                                </div>
                                @endif

                                @if($roster->instructions)
                                <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $roster->instructions }}</p>
                                @endif

                                <!-- Assigned Members -->
                                <div class="mt-3">
                                    <p class="text-sm font-medium text-gray-700 mb-2">
                                        Assigned Members ({{ $roster->assignments->count() }}):
                                    </p>
                                    @if($roster->assignments->isNotEmpty())
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($roster->assignments->take(5) as $assignment)
                                        <span class="px-2 py-1 bg-green-50 text-green-700 rounded-full text-xs flex items-center gap-1">
                                            {{ $assignment->member->full_name }}
                                            @if($assignment->status === 'confirmed')
                                            <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            @endif
                                        </span>
                                        @endforeach
                                        @if($roster->assignments->count() > 5)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">
                                            +{{ $roster->assignments->count() - 5 }} more
                                        </span>
                                        @endif
                                    </div>
                                    @else
                                    <p class="text-sm text-gray-500">No members assigned yet</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions and Status -->
                    <div class="ml-4 flex flex-col items-end gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($roster->status === 'published') bg-green-100 text-green-800
                            @elseif($roster->status === 'draft') bg-gray-100 text-gray-800
                            @elseif($roster->status === 'completed') bg-blue-100 text-blue-800
                            @elseif($roster->status === 'cancelled') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($roster->status) }}
                        </span>

                        @can('update', $serviceUnit)
                        @if($roster->status === 'draft')
                        <form action="{{ route('service-units.publish-duty-roster', $roster) }}" method="POST"
                              onsubmit="return confirm('Publish this duty roster? Members will be notified.')">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                    class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition text-sm">
                                Publish
                            </button>
                        </form>
                        @endif
                        @endcan
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($rosters->hasPages())
        <div class="mt-6">
            {{ $rosters->links() }}
        </div>
        @endif
        @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Duty Rosters</h3>
            <p class="text-gray-600 mb-4">Get started by creating your first duty roster.</p>
            @can('update', $serviceUnit)
            <a href="{{ route('service-units.create-duty-roster', $serviceUnit) }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Create Duty Roster
            </a>
            @endcan
        </div>
        @endif
    </div>
</div>
@endsection
