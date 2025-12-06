@extends('layouts.app')

@section('title', $serviceUnit->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('service-units.index') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">{{ $serviceUnit->name }}</h1>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    @if($serviceUnit->status === 'active') bg-green-400 text-green-900
                    @elseif($serviceUnit->status === 'inactive') bg-gray-400 text-gray-900
                    @else bg-red-400 text-red-900
                    @endif">
                    {{ ucfirst($serviceUnit->status) }}
                </span>
            </div>
            <p class="text-gray-600">{{ $serviceUnit->code }} • {{ ucfirst($serviceUnit->category) }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('service-units.duty-rosters', $serviceUnit) }}"
               class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Duty Rosters
            </a>
            @can('update', $serviceUnit)
            <a href="{{ route('service-units.manage-members', $serviceUnit) }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Manage Members
            </a>
            <a href="{{ route('service-units.edit', $serviceUnit) }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Unit
            </a>
            @endcan
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Current Members</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $serviceUnit->current_members }}</p>
                    <p class="text-xs text-gray-500 mt-1">of {{ $serviceUnit->max_members }} max</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Capacity</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($serviceUnit->capacity_percentage, 0) }}%</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $serviceUnit->max_members - $serviceUnit->current_members }} spots left</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Upcoming Duties</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $upcomingRosters->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Next 30 days</p>
                </div>
                <div class="bg-yellow-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Completion Rate</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($performance['completion_rate'], 0) }}%</p>
                    <p class="text-xs text-gray-500 mt-1">Last 90 days</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Description -->
            @if($serviceUnit->description)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">About</h2>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $serviceUnit->description }}</p>
            </div>
            @endif

            <!-- Responsibilities -->
            @if($serviceUnit->responsibilities)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Responsibilities</h2>
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($serviceUnit->responsibilities)) !!}
                </div>
            </div>
            @endif

            <!-- Requirements -->
            @if($serviceUnit->requirements)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Requirements</h2>
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($serviceUnit->requirements)) !!}
                </div>
            </div>
            @endif

            <!-- Unit Members -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Unit Members ({{ $unitMembers->count() }})</h2>
                    @can('update', $serviceUnit)
                    <a href="{{ route('service-units.manage-members', $serviceUnit) }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                        Add Members
                    </a>
                    @endcan
                </div>

                @if($unitMembers->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skills</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proficiency</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($unitMembers as $unitMember)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        @if($unitMember->member->photo_url)
                                        <img src="{{ $unitMember->member->photo_url }}" alt="{{ $unitMember->member->full_name }}"
                                             class="w-10 h-10 rounded-full object-cover">
                                        @else
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($unitMember->member->first_name, 0, 1) . substr($unitMember->member->last_name, 0, 1)) }}
                                        </div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $unitMember->member->full_name }}</p>
                                            <p class="text-sm text-gray-500">{{ $unitMember->member->phone }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($unitMember->role === 'leader') bg-purple-100 text-purple-800
                                        @elseif($unitMember->role === 'assistant_leader') bg-blue-100 text-blue-800
                                        @elseif($unitMember->role === 'trainee') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucwords(str_replace('_', ' ', $unitMember->role)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($unitMember->skills && is_array($unitMember->skills))
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(array_slice($unitMember->skills, 0, 3) as $skill)
                                        <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs">{{ $skill }}</span>
                                        @endforeach
                                        @if(count($unitMember->skills) > 3)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">+{{ count($unitMember->skills) - 3 }}</span>
                                        @endif
                                    </div>
                                    @else
                                    <span class="text-gray-400 text-sm">No skills listed</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($unitMember->proficiency_level)
                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $unitMember->proficiency_level ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        @endfor
                                    </div>
                                    @else
                                    <span class="text-gray-400 text-sm">Not rated</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($unitMember->joined_date)->format('M d, Y') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="text-gray-600">No members in this unit yet.</p>
                </div>
                @endif
            </div>

            <!-- Upcoming Duty Rosters -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Upcoming Duties</h2>
                    <a href="{{ route('service-units.duty-rosters', $serviceUnit) }}"
                       class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        View All →
                    </a>
                </div>

                @if($upcomingRosters->isNotEmpty())
                <div class="space-y-3">
                    @foreach($upcomingRosters as $roster)
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $roster->roster_name }}</h3>
                                <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($roster->duty_date)->format('M d, Y') }}
                                    </span>
                                    @if($roster->start_time)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($roster->start_time)->format('g:i A') }}
                                    </span>
                                    @endif
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                        {{ ucwords(str_replace('_', ' ', $roster->duty_type)) }}
                                    </span>
                                </div>
                            </div>
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                @if($roster->status === 'published') bg-green-100 text-green-800
                                @elseif($roster->status === 'draft') bg-gray-100 text-gray-800
                                @else bg-blue-100 text-blue-800
                                @endif">
                                {{ ucfirst($roster->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-600">No upcoming duties scheduled.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Leadership -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Leadership</h2>
                <div class="space-y-4">
                    @if($serviceUnit->leader)
                    <div class="flex items-center gap-3 p-3 bg-purple-50 rounded-lg">
                        @if($serviceUnit->leader->photo_url)
                        <img src="{{ $serviceUnit->leader->photo_url }}" alt="{{ $serviceUnit->leader->full_name }}"
                             class="w-12 h-12 rounded-full object-cover">
                        @else
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr($serviceUnit->leader->first_name, 0, 1) . substr($serviceUnit->leader->last_name, 0, 1)) }}
                        </div>
                        @endif
                        <div>
                            <p class="text-xs text-purple-600 font-medium">LEADER</p>
                            <p class="font-semibold text-gray-900">{{ $serviceUnit->leader->full_name }}</p>
                            <p class="text-sm text-gray-600">{{ $serviceUnit->leader->phone }}</p>
                        </div>
                    </div>
                    @endif

                    @if($serviceUnit->assistantLeader)
                    <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg">
                        @if($serviceUnit->assistantLeader->photo_url)
                        <img src="{{ $serviceUnit->assistantLeader->photo_url }}" alt="{{ $serviceUnit->assistantLeader->full_name }}"
                             class="w-12 h-12 rounded-full object-cover">
                        @else
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr($serviceUnit->assistantLeader->first_name, 0, 1) . substr($serviceUnit->assistantLeader->last_name, 0, 1)) }}
                        </div>
                        @endif
                        <div>
                            <p class="text-xs text-blue-600 font-medium">ASSISTANT LEADER</p>
                            <p class="font-semibold text-gray-900">{{ $serviceUnit->assistantLeader->full_name }}</p>
                            <p class="text-sm text-gray-600">{{ $serviceUnit->assistantLeader->phone }}</p>
                        </div>
                    </div>
                    @endif

                    @if(!$serviceUnit->leader && !$serviceUnit->assistantLeader)
                    <p class="text-gray-500 text-center py-4">No leadership assigned</p>
                    @endif
                </div>
            </div>

            <!-- Meeting Schedule -->
            @if($serviceUnit->meeting_schedule)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Meeting Schedule</h2>
                <div class="flex items-center gap-3 p-4 bg-yellow-50 rounded-lg">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-700">{{ $serviceUnit->meeting_schedule }}</p>
                </div>
            </div>
            @endif

            <!-- Performance Metrics -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Performance (90 days)</h2>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm text-gray-600">Duty Completion</span>
                            <span class="text-sm font-semibold text-gray-900">{{ number_format($performance['completion_rate'], 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $performance['completion_rate'] }}%"></div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Completed Rosters</span>
                            <span class="text-lg font-bold text-gray-900">{{ $performance['completed_rosters'] }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Avg Meeting Attendance</span>
                        <span class="text-lg font-bold text-gray-900">{{ $performance['average_meeting_attendance'] }}%</span>
                    </div>
                </div>
            </div>

            <!-- Capacity Status -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Capacity Status</h2>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600">Current Capacity</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $serviceUnit->current_members }}/{{ $serviceUnit->max_members }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="
                                @if($serviceUnit->capacity_percentage >= 100) bg-red-500
                                @elseif($serviceUnit->capacity_percentage >= 80) bg-yellow-500
                                @else bg-green-500
                                @endif
                                h-4 rounded-full transition-all"
                                 style="width: {{ min($serviceUnit->capacity_percentage, 100) }}%"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                        <div>
                            <p class="text-xs text-gray-600">Minimum Required</p>
                            <p class="text-lg font-bold text-gray-900">{{ $serviceUnit->min_members }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Spots Available</p>
                            <p class="text-lg font-bold text-gray-900">{{ max(0, $serviceUnit->max_members - $serviceUnit->current_members) }}</p>
                        </div>
                    </div>

                    @if($serviceUnit->current_members < $serviceUnit->min_members)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                        <p class="text-sm text-red-800">
                            <span class="font-semibold">⚠️ Below Minimum:</span>
                            Need {{ $serviceUnit->min_members - $serviceUnit->current_members }} more member(s)
                        </p>
                    </div>
                    @elseif($serviceUnit->capacity_percentage >= 100)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                        <p class="text-sm text-red-800">
                            <span class="font-semibold">⚠️ At Capacity:</span>
                            No spots available
                        </p>
                    </div>
                    @elseif($serviceUnit->capacity_percentage >= 80)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                        <p class="text-sm text-yellow-800">
                            <span class="font-semibold">⚠️ Nearly Full:</span>
                            {{ $serviceUnit->max_members - $serviceUnit->current_members }} spot(s) remaining
                        </p>
                    </div>
                    @else
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                        <p class="text-sm text-green-800">
                            <span class="font-semibold">✓ Good Capacity:</span>
                            {{ $serviceUnit->max_members - $serviceUnit->current_members }} spot(s) available
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
