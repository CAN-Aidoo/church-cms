@extends('layouts.app')

@section('title', 'Duty Rosters - ' . $serviceUnit->name)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-3">
             <a href="{{ route('service-units.show', $serviceUnit) }}" class="p-2 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-slate-50 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Duty Rosters</h1>
                <p class="text-slate-600">Schedule and manage duty assignments for <span class="font-medium text-slate-900">{{ $serviceUnit->name }}</span></p>
            </div>
        </div>
        @can('update', $serviceUnit)
        <a href="{{ route('service-units.create-duty-roster', $serviceUnit) }}"
           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-lg shadow-sm hover:shadow-md transition-all font-medium text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Create Duty Roster
        </a>
        @endcan
    </div>

    <!-- Upcoming Duties -->
    @if($upcomingRosters->isNotEmpty())
    <div class="mb-8">
        <h2 class="text-lg font-bold text-slate-800 mb-4 px-1">Upcoming Duties</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($upcomingRosters as $roster)
            <div class="card border border-primary-200 bg-primary-50/30 p-5 relative group hover:border-primary-300 hover:shadow-md transition-all">
                <div class="absolute top-0 right-0 p-4">
                    <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border
                        @if($roster->status === 'published') bg-emerald-100 text-emerald-700 border-emerald-200
                        @elseif($roster->status === 'draft') bg-slate-100 text-slate-600 border-slate-200
                        @else bg-blue-100 text-blue-700 border-blue-200
                        @endif">
                        {{ ucfirst($roster->status) }}
                    </span>
                </div>
                
                <div class="mb-4">
                    <h3 class="font-bold text-slate-900 text-lg pr-16">{{ $roster->roster_name }}</h3>
                    <div class="flex items-center gap-2 mt-2 text-sm text-slate-600">
                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($roster->duty_date)->format('l, M d, Y') }}</span>
                    </div>
                     @if($roster->start_time)
                    <div class="flex items-center gap-2 mt-1 text-sm text-slate-600">
                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>
                            {{ \Carbon\Carbon::parse($roster->start_time)->format('g:i A') }}
                            @if($roster->end_time)
                            - {{ \Carbon\Carbon::parse($roster->end_time)->format('g:i A') }}
                            @endif
                        </span>
                    </div>
                    @endif
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-primary-100">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <div class="flex -space-x-2">
                            @foreach($roster->assignments->take(3) as $assignment)
                                @if($assignment->member->photo_url)
                                <img class="w-6 h-6 rounded-full border border-white" src="{{ $assignment->member->photo_url }}" alt="">
                                @else
                                <div class="w-6 h-6 rounded-full bg-primary-100 border border-white flex items-center justify-center text-[8px] font-bold text-primary-600">
                                    {{ substr($assignment->member->first_name, 0, 1) }}
                                </div>
                                @endif
                            @endforeach
                        </div>
                        <span class="text-xs font-medium pl-1">{{ $roster->assignments->count() }} Assigned</span>
                    </div>
                    
                    @if($roster->location)
                    <div class="flex items-center gap-1 text-xs font-medium text-slate-500 bg-white px-2 py-1 rounded border border-primary-100">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ Str::limit($roster->location, 15) }}
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- All Duty Rosters -->
    <div class="card border border-slate-100 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-base font-bold text-slate-800">All Duty Rosters</h2>
        </div>

        <div class="p-6">
            @if($rosters->isNotEmpty())
            <div class="space-y-4">
                @foreach($rosters as $roster)
                <div class="group border border-slate-200 rounded-xl p-4 hover:border-primary-200 hover:shadow-sm hover:bg-slate-50/50 transition-all">
                    <div class="flex flex-col md:flex-row md:items-start gap-4">
                        <!-- Date Badge -->
                        <div class="flex-shrink-0 bg-white border border-slate-200 rounded-lg p-3 text-center min-w-[70px] shadow-sm group-hover:border-primary-200 transition-colors">
                            <p class="text-2xl font-bold text-slate-800">{{ \Carbon\Carbon::parse($roster->duty_date)->format('d') }}</p>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">{{ \Carbon\Carbon::parse($roster->duty_date)->format('M') }}</p>
                        </div>

                        <!-- Roster Details -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-2">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary-700 transition-colors">{{ $roster->roster_name }}</h3>
                                    <div class="flex flex-wrap items-center gap-3 mt-1.5 text-sm text-slate-600">
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($roster->duty_date)->format('l, Y') }}
                                        </span>
                                        @if($roster->start_time)
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($roster->start_time)->format('g:i A') }}
                                            @if($roster->end_time)
                                            - {{ \Carbon\Carbon::parse($roster->end_time)->format('g:i A') }}
                                            @endif
                                        </span>
                                        @endif
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md text-xs font-medium border border-slate-200">
                                            {{ ucwords(str_replace('_', ' ', $roster->duty_type)) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 mt-2 md:mt-0">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider border
                                        @if($roster->status === 'published') bg-emerald-50 text-emerald-700 border-emerald-100
                                        @elseif($roster->status === 'draft') bg-slate-100 text-slate-600 border-slate-200
                                        @elseif($roster->status === 'completed') bg-blue-50 text-blue-700 border-blue-100
                                        @elseif($roster->status === 'cancelled') bg-rose-50 text-rose-700 border-rose-100
                                        @else bg-amber-50 text-amber-700 border-amber-100
                                        @endif">
                                        {{ ucfirst($roster->status) }}
                                    </span>
                                </div>
                            </div>

                            @if($roster->location)
                            <div class="flex items-center gap-1.5 text-sm text-slate-500 mt-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $roster->location }}</span>
                            </div>
                            @endif

                             @if($roster->instructions)
                            <div class="mt-3 bg-slate-50 p-3 rounded-lg border border-slate-100 text-sm text-slate-600 italic">
                                "{{ Str::limit($roster->instructions, 100) }}"
                            </div>
                            @endif

                            <!-- Assigned Members -->
                            <div class="mt-4 flex flex-wrap items-center gap-2">
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide mr-1">Assignments:</span>
                                @if($roster->assignments->isNotEmpty())
                                    @foreach($roster->assignments->take(6) as $assignment)
                                    <div class="flex items-center gap-1 px-2 py-1 bg-white border border-slate-200 rounded-full text-xs shadow-sm">
                                        <span class="font-medium text-slate-700">{{ $assignment->member->first_name }} {{ substr($assignment->member->last_name, 0, 1) }}.</span>
                                        @if($assignment->status === 'confirmed')
                                        <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        @endif
                                    </div>
                                    @endforeach
                                    @if($roster->assignments->count() > 6)
                                    <span class="px-2 py-1 bg-slate-100 text-slate-500 rounded-full text-xs font-medium">
                                        +{{ $roster->assignments->count() - 6 }}
                                    </span>
                                    @endif
                                @else
                                <span class="text-xs text-slate-400 italic">No members assigned yet</span>
                                @endif
                                
                                @can('update', $serviceUnit)
                                    <a href="#" class="ml-auto text-xs font-medium text-primary-600 hover:text-primary-700 hover:underline">Manage Assignments</a> <!-- Placeholder link, assuming manage route exists or handled elsewhere -->
                                @endcan
                            </div>
                            
                            @can('update', $serviceUnit)
                            @if($roster->status === 'draft')
                            <div class="mt-4 pt-4 border-t border-slate-100 flex justify-end">
                                <form action="{{ route('service-units.publish-duty-roster', $roster) }}" method="POST"
                                      onsubmit="return confirm('Publish this duty roster? Members will be notified.')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition shadow-sm text-xs font-bold uppercase tracking-wide">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                        Publish Roster
                                    </button>
                                </form>
                            </div>
                            @endif
                            @endcan
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($rosters->hasPages())
            <div class="mt-8">
                {{ $rosters->links() }}
            </div>
            @endif
            
            @else
            <div class="text-center py-16">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">No Duty Rosters Found</h3>
                <p class="text-slate-500 mb-6">Get started by creating your first duty roster for this unit.</p>
                @can('update', $serviceUnit)
                <a href="{{ route('service-units.create-duty-roster', $serviceUnit) }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition shadow-sm font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Create First Roster
                </a>
                @endcan
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
