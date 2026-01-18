@extends('layouts.app')

@section('title', $serviceUnit->name)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('service-units.index') }}" class="text-slate-500 hover:text-primary-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-slate-800">{{ $serviceUnit->name }}</h1>
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                    @if($serviceUnit->status === 'active') bg-emerald-100 text-emerald-700
                    @elseif($serviceUnit->status === 'inactive') bg-slate-100 text-slate-700
                    @else bg-rose-100 text-rose-700
                    @endif">
                    {{ ucfirst($serviceUnit->status) }}
                </span>
            </div>
            <div class="flex items-center gap-2 text-slate-600">
                <span class="font-mono text-xs bg-slate-100 px-2 py-0.5 rounded text-slate-500">{{ $serviceUnit->code }}</span>
                <span>•</span>
                <span>{{ ucfirst($serviceUnit->category) }}</span>
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('service-units.duty-rosters', $serviceUnit) }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 hover:border-slate-400 transition-all shadow-sm font-medium text-sm">
                <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Duty Rosters
            </a>
            @can('update', $serviceUnit)
            <a href="{{ route('service-units.manage-members', $serviceUnit) }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 hover:border-slate-400 transition-all shadow-sm font-medium text-sm">
                <svg class="w-4 h-4 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Manage Members
            </a>
            <a href="{{ route('service-units.edit', $serviceUnit) }}"
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-lg shadow-sm hover:shadow-md transition-all font-medium text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Unit
            </a>

            <form action="{{ route('service-units.destroy', $serviceUnit) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this service unit? All member assignments will be removed.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-sm hover:shadow-md transition-all font-medium text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete
                </button>
            </form>
            @endcan
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Current Members -->
        <div class="card p-6 border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-slate-500 text-sm font-medium mb-1">Current Members</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $serviceUnit->current_members }}</h3>
                    <p class="text-xs text-slate-400 mt-1">of {{ $serviceUnit->max_members }} max capacity</p>
                </div>
                <div class="bg-primary-50 p-3 rounded-xl group-hover:bg-primary-100 transition-colors">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Capacity -->
        <div class="card p-6 border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-slate-500 text-sm font-medium mb-1">Capacity Filled</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ number_format($serviceUnit->capacity_percentage, 0) }}%</h3>
                    <p class="text-xs text-slate-400 mt-1">{{ $serviceUnit->max_members - $serviceUnit->current_members }} spots remaining</p>
                </div>
                <div class="bg-emerald-50 p-3 rounded-xl group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Upcoming Duties -->
        <div class="card p-6 border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-slate-500 text-sm font-medium mb-1">Upcoming Duties</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $upcomingRosters->count() }}</h3>
                    <p class="text-xs text-slate-400 mt-1">Next 30 days</p>
                </div>
                <div class="bg-amber-50 p-3 rounded-xl group-hover:bg-amber-100 transition-colors">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Completion Rate -->
        <div class="card p-6 border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-slate-500 text-sm font-medium mb-1">Completion Rate</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ number_format($performance['completion_rate'], 0) }}%</h3>
                    <p class="text-xs text-slate-400 mt-1">Last 90 days performance</p>
                </div>
                <div class="bg-violet-50 p-3 rounded-xl group-hover:bg-violet-100 transition-colors">
                    <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- About Section -->
            @if($serviceUnit->description || $serviceUnit->responsibilities || $serviceUnit->requirements)
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">About the Unit</h3>
                </div>
                <div class="p-6 space-y-6">
                    @if($serviceUnit->description)
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 mb-2 uppercase tracking-wide">Description</h4>
                        <p class="text-slate-600 leading-relaxed">{{ $serviceUnit->description }}</p>
                    </div>
                    @endif

                    @if($serviceUnit->responsibilities)
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 mb-2 uppercase tracking-wide">Responsibilities</h4>
                        <div class="prose prose-sm prose-slate max-w-none text-slate-600">
                            {!! nl2br(e($serviceUnit->responsibilities)) !!}
                        </div>
                    </div>
                    @endif

                    @if($serviceUnit->requirements)
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 mb-2 uppercase tracking-wide">Requirements</h4>
                        <div class="prose prose-sm prose-slate max-w-none text-slate-600">
                            {!! nl2br(e($serviceUnit->requirements)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Unit Members -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 text-base">Unit Members <span class="text-slate-400 font-normal ml-1">({{ $unitMembers->count() }})</span></h3>
                    @can('update', $serviceUnit)
                    <a href="{{ route('service-units.manage-members', $serviceUnit) }}"
                       class="text-primary-600 hover:text-primary-700 text-sm font-medium transition-colors">
                        Manage Members →
                    </a>
                    @endcan
                </div>

                @if($unitMembers->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                                <th class="px-6 py-3">Member</th>
                                <th class="px-6 py-3">Role</th>
                                <th class="px-6 py-3">Skills</th>
                                <th class="px-6 py-3">Proficiency</th>
                                <th class="px-6 py-3">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($unitMembers as $unitMember)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($unitMember->member->photo_url)
                                        <img src="{{ $unitMember->member->photo_url }}" alt="{{ $unitMember->member->full_name }}"
                                             class="w-8 h-8 rounded-full object-cover border border-slate-200">
                                        @else
                                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs border border-slate-200">
                                            {{ strtoupper(substr($unitMember->member->first_name, 0, 1) . substr($unitMember->member->last_name, 0, 1)) }}
                                        </div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-slate-900 text-sm">{{ $unitMember->member->full_name }}</p>
                                            <p class="text-xs text-slate-500">{{ $unitMember->member->phone }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full border
                                        @if($unitMember->role === 'leader') bg-purple-50 text-purple-700 border-purple-100
                                        @elseif($unitMember->role === 'assistant_leader') bg-blue-50 text-blue-700 border-blue-100
                                        @elseif($unitMember->role === 'trainee') bg-amber-50 text-amber-700 border-amber-100
                                        @else bg-slate-50 text-slate-600 border-slate-200
                                        @endif">
                                        {{ ucwords(str_replace('_', ' ', $unitMember->role)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($unitMember->skills && is_array($unitMember->skills))
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(array_slice($unitMember->skills, 0, 2) as $skill)
                                        <span class="px-1.5 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-medium border border-slate-200">{{ $skill }}</span>
                                        @endforeach
                                        @if(count($unitMember->skills) > 2)
                                        <span class="px-1.5 py-0.5 bg-slate-50 text-slate-500 rounded text-[10px] border border-slate-200">+{{ count($unitMember->skills) - 2 }}</span>
                                        @endif
                                    </div>
                                    @else
                                    <span class="text-slate-400 text-xs italic">None</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($unitMember->proficiency_level)
                                    <div class="flex items-center gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3.5 h-3.5 {{ $i <= $unitMember->proficiency_level ? 'text-amber-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        @endfor
                                    </div>
                                    @else
                                    <span class="text-slate-400 text-xs">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500">
                                    {{ \Carbon\Carbon::parse($unitMember->joined_date)->format('M Y') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <p class="text-slate-500 font-medium">No members in this unit yet.</p>
                    <p class="text-slate-400 text-sm mt-1">Start by adding members to this unit.</p>
                </div>
                @endif
            </div>

            <!-- Upcoming Duty Rosters -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 text-base">Upcoming Duties</h3>
                    <a href="{{ route('service-units.duty-rosters', $serviceUnit) }}"
                       class="text-primary-600 hover:text-primary-700 text-sm font-medium transition-colors">
                        View Scheduler →
                    </a>
                </div>

                <div class="p-6">
                    @if($upcomingRosters->isNotEmpty())
                    <div class="space-y-4">
                        @foreach($upcomingRosters as $roster)
                        <div class="group border border-slate-200 rounded-xl p-4 hover:border-primary-200 hover:shadow-sm hover:bg-slate-50/50 transition-all">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-slate-900 group-hover:text-primary-700 transition-colors">{{ $roster->roster_name }}</h3>
                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 mt-2 text-sm text-slate-600">
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($roster->duty_date)->format('M d, Y') }}
                                        </span>
                                        @if($roster->start_time)
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($roster->start_time)->format('g:i A') }}
                                        </span>
                                        @endif
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md text-xs font-medium border border-slate-200">
                                            {{ ucwords(str_replace('_', ' ', $roster->duty_type)) }}
                                        </span>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold border
                                    @if($roster->status === 'published') bg-emerald-50 text-emerald-700 border-emerald-100
                                    @elseif($roster->status === 'draft') bg-slate-100 text-slate-600 border-slate-200
                                    @else bg-blue-50 text-blue-700 border-blue-100
                                    @endif">
                                    {{ ucfirst($roster->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8">
                        <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-slate-500 text-sm">No upcoming duties scheduled.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-8">
            <!-- Leadership -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Leadership Team</h3>
                </div>
                <div class="p-6 space-y-4">
                    @if($serviceUnit->leader)
                    <div class="flex items-center gap-4 p-4 bg-purple-50/50 border border-purple-100 rounded-xl">
                        @if($serviceUnit->leader->photo_url)
                        <img src="{{ $serviceUnit->leader->photo_url }}" alt="{{ $serviceUnit->leader->full_name }}"
                             class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                        @else
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-sm">
                            {{ strtoupper(substr($serviceUnit->leader->first_name, 0, 1) . substr($serviceUnit->leader->last_name, 0, 1)) }}
                        </div>
                        @endif
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-purple-600 font-bold mb-0.5">Unit Leader</p>
                            <a href="#" class="font-bold text-slate-900 hover:text-purple-700 transition-colors">{{ $serviceUnit->leader->full_name }}</a>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $serviceUnit->leader->phone }}</p>
                        </div>
                    </div>
                    @endif

                    @if($serviceUnit->assistantLeader)
                    <div class="flex items-center gap-4 p-4 bg-blue-50/50 border border-blue-100 rounded-xl">
                        @if($serviceUnit->assistantLeader->photo_url)
                        <img src="{{ $serviceUnit->assistantLeader->photo_url }}" alt="{{ $serviceUnit->assistantLeader->full_name }}"
                             class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                        @else
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold shadow-sm">
                            {{ strtoupper(substr($serviceUnit->assistantLeader->first_name, 0, 1) . substr($serviceUnit->assistantLeader->last_name, 0, 1)) }}
                        </div>
                        @endif
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-blue-600 font-bold mb-0.5">Assistant Leader</p>
                            <a href="#" class="font-bold text-slate-900 hover:text-blue-700 transition-colors">{{ $serviceUnit->assistantLeader->full_name }}</a>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $serviceUnit->assistantLeader->phone }}</p>
                        </div>
                    </div>
                    @endif

                    @if(!$serviceUnit->leader && !$serviceUnit->assistantLeader)
                    <div class="text-center py-6 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                        <p class="text-slate-500 text-sm">No leadership assigned yet.</p>
                        @can('update', $serviceUnit)
                        <a href="{{ route('service-units.edit', $serviceUnit) }}" class="text-primary-600 text-xs font-semibold hover:underline mt-1 inline-block">Assign Leaders</a>
                        @endcan
                    </div>
                    @endif
                </div>
            </div>

            <!-- Meeting Schedule -->
            @if($serviceUnit->meeting_schedule)
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Meeting Schedule</h3>
                </div>
                <div class="p-6">
                    <div class="flex gap-4 p-4 bg-amber-50/50 border border-amber-100 rounded-xl">
                        <div class="flex-shrink-0 w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center text-amber-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Regular Meetings</p>
                            <p class="text-sm text-slate-600 mt-1">{{ $serviceUnit->meeting_schedule }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Performance Metrics -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Performance Metrics</h3>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-slate-600">Duty Completion</span>
                            <span class="text-sm font-bold text-slate-900">{{ number_format($performance['completion_rate'], 1) }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-gradient-to-r from-emerald-500 to-emerald-400 h-2 rounded-full" style="width: {{ $performance['completion_rate'] }}%"></div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium text-slate-600">Completed Rosters</span>
                            <span class="text-lg font-bold text-slate-900">{{ $performance['completed_rosters'] }}</span>
                        </div>
                        <p class="text-xs text-slate-400">Total rosters completed in period</p>
                    </div>

                    <div class="pt-6 border-t border-slate-100">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium text-slate-600">Meeting Attendance</span>
                            <span class="text-lg font-bold text-slate-900">{{ $performance['average_meeting_attendance'] }}%</span>
                        </div>
                        <p class="text-xs text-slate-400">Average member attendance</p>
                    </div>
                </div>
            </div>

            <!-- Capacity Status -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Capacity Status</h3>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-slate-600">Current Load</span>
                            <span class="text-sm font-bold text-slate-900">{{ $serviceUnit->current_members }} / {{ $serviceUnit->max_members }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-3">
                            <div class="
                                @if($serviceUnit->capacity_percentage >= 100) bg-rose-500
                                @elseif($serviceUnit->capacity_percentage >= 80) bg-amber-500
                                @else bg-emerald-500
                                @endif
                                h-3 rounded-full transition-all shadow-sm"
                                 style="width: {{ min($serviceUnit->capacity_percentage, 100) }}%"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                        <div class="bg-slate-50 rounded-lg p-3 text-center border border-slate-100">
                            <p class="text-xs text-slate-500 font-medium uppercase">Minimum</p>
                            <p class="text-xl font-bold text-slate-800 mt-1">{{ $serviceUnit->min_members }}</p>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-3 text-center border border-slate-100">
                            <p class="text-xs text-slate-500 font-medium uppercase">Available</p>
                            <p class="text-xl font-bold text-slate-800 mt-1">{{ max(0, $serviceUnit->max_members - $serviceUnit->current_members) }}</p>
                        </div>
                    </div>

                    @if($serviceUnit->current_members < $serviceUnit->min_members)
                    <div class="bg-rose-50 border border-rose-100 rounded-lg p-3 flex gap-3 items-start">
                        <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-sm text-rose-800 font-medium">
                            Below Minimum Requirement<br>
                            <span class="text-xs font-normal opacity-80">Need {{ $serviceUnit->min_members - $serviceUnit->current_members }} more member(s) to function effectively.</span>
                        </p>
                    </div>
                    @elseif($serviceUnit->capacity_percentage >= 100)
                    <div class="bg-amber-50 border border-amber-100 rounded-lg p-3 flex gap-3 items-start">
                        <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-amber-800 font-medium">
                            Unit at Full Capacity<br>
                            <span class="text-xs font-normal opacity-80">Consider increasing the maximum limit if more members wish to join.</span>
                        </p>
                    </div>
                    @else
                    <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-3 flex gap-3 items-start">
                         <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-emerald-800 font-medium">
                            Healthy Capacity Level<br>
                            <span class="text-xs font-normal opacity-80">{{ $serviceUnit->max_members - $serviceUnit->current_members }} spot(s) available for new members.</span>
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
