@extends('layouts.app')

@section('title', 'My Prayer Assignments')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <div class="flex items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Prayer Assignments</h1>
            <p class="text-slate-600">Requests assigned to you for intercession.</p>
        </div>
        <a href="{{ route('prayer.index') }}" class="px-4 py-2 bg-white text-slate-700 border border-slate-300 rounded-lg hover:bg-slate-50 transition font-medium text-sm shadow-sm">
            Browse All Requests
        </a>
    </div>

    <!-- Intercessor Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card p-6 border border-blue-100 shadow-sm bg-gradient-to-br from-blue-50 to-white">
            <p class="text-blue-600 text-sm font-bold uppercase tracking-wide mb-1">Active Assignments</p>
            <h3 class="text-3xl font-bold text-blue-900">{{ $statistics['active_assignments'] ?? 0 }}</h3>
        </div>
        <div class="card p-6 border border-emerald-100 shadow-sm bg-gradient-to-br from-emerald-50 to-white">
            <p class="text-emerald-600 text-sm font-bold uppercase tracking-wide mb-1">Prayed For (Month)</p>
            <h3 class="text-3xl font-bold text-emerald-900">{{ $statistics['prayed_this_month'] ?? 0 }}</h3>
        </div>
        <div class="card p-6 border border-slate-100 shadow-sm bg-white">
            <p class="text-slate-500 text-sm font-bold uppercase tracking-wide mb-1">Total Completed</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $statistics['total_completed'] ?? 0 }}</h3>
        </div>
    </div>

    <div class="card border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Your Active Assignments</h3>
        </div>
        
        @if($myAssignments->isNotEmpty())
        <div class="divide-y divide-slate-100">
            @foreach($myAssignments as $request)
            <div class="p-6 hover:bg-slate-50 transition-all group">
                <div class="flex flex-col md:flex-row md:items-start gap-6">
                    <!-- Urgency Indicator -->
                    <div class="hidden md:flex flex-col items-center justify-center w-16 text-center">
                         <div class="w-2 h-2 rounded-full mb-1
                            {{ $request->urgency === 'critical' ? 'bg-rose-500' : 
                              ($request->urgency === 'high' ? 'bg-amber-500' : 'bg-blue-400') }}"></div>
                        <span class="text-[10px] font-bold uppercase tracking-wide text-slate-400">{{ $request->urgency }}</span>
                    </div>

                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 mb-1">
                                    <a href="{{ route('prayer.show', $request) }}" class="hover:text-primary-600 transition-colors">
                                        {{ $request->request_title }}
                                    </a>
                                </h3>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">
                                        {{ $request->category->name ?? 'General' }}
                                    </span>
                                    <span class="text-xs text-slate-400">
                                        Assigned {{ $request->pivot->created_at->diffForHumans() }}
                                    </span>
                                    <span class="md:hidden px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide
                                        {{ $request->urgency === 'critical' ? 'bg-rose-100 text-rose-700' : 
                                          ($request->urgency === 'high' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700') }}">
                                        {{ $request->urgency }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-amber-50 rounded-lg p-4 border border-amber-100 mb-4">
                            <p class="text-slate-700 text-sm leading-relaxed">
                                {{ Str::limit($request->request_details, 200) }}
                            </p>
                        </div>
                        
                        <!-- Quick Actions for Intercessor -->
                        <div class="flex items-center gap-3">
                             <a href="{{ route('prayer.show', $request) }}" class="inline-flex items-center text-sm font-bold text-primary-600 hover:text-primary-700">
                                View Details & Updates 
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            </a>
                            
                            @if(auth()->user()->hasAnyRole(['admin', 'pastor', 'staff']) || (auth()->user()->member && $request->assigned_to === auth()->user()->member->id))
                            <form action="{{ route('prayer.add-update', $request) }}" method="POST" class="ml-auto flex items-center gap-2">
                                @csrf
                                <input type="hidden" name="update_type" value="progress">
                                <input type="hidden" name="update_text" value="Prayed for this request.">
                                <button type="submit" class="text-xs bg-white border border-slate-200 text-slate-600 px-3 py-1.5 rounded-lg hover:bg-slate-50 hover:border-slate-300 transition shadow-sm font-medium">
                                    Mark as Prayed
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $myAssignments->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-slate-900 font-bold text-lg mb-1">All Caught Up!</h3>
            <p class="text-slate-500">You have no active prayer assignments at the moment.</p>
        </div>
        @endif
    </div>
</div>
@endsection
