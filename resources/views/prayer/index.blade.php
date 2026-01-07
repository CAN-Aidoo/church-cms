@extends('layouts.app')

@section('title', 'Prayer Requests')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Prayer Requests</h1>
            <p class="text-slate-600">Manage and intercede for the spiritual needs of the church.</p>
        </div>
        <a href="{{ route('prayer.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-lg shadow-sm hover:shadow-md transition-all font-medium text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Submit Request
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Active Requests -->
        <div class="card p-6 border border-primary-100 shadow-sm bg-gradient-to-br from-primary-600 to-primary-700 text-white relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
            <div class="relative z-10">
                <p class="text-primary-100 text-sm font-medium mb-1">Active Requests</p>
                <h3 class="text-3xl font-bold mb-0">{{ number_format($statistics['total_active'] ?? 0) }}</h3>
            </div>
            <div class="absolute bottom-4 right-4 text-primary-200/50 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
        </div>

        <!-- Urgent -->
        <div class="card p-6 border border-rose-100 shadow-sm bg-gradient-to-br from-rose-500 to-rose-600 text-white relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
            <div class="relative z-10">
                <p class="text-rose-100 text-sm font-medium mb-1">Urgent Needs</p>
                <h3 class="text-3xl font-bold mb-0">{{ number_format($statistics['urgent'] ?? 0) }}</h3>
            </div>
            <div class="absolute bottom-4 right-4 text-rose-200/50 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </div>

        <!-- Pending -->
        <div class="card p-6 border border-amber-100 shadow-sm bg-gradient-to-br from-amber-500 to-amber-600 text-white relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
            <div class="relative z-10">
                <p class="text-amber-100 text-sm font-medium mb-1">Pending Review</p>
                <h3 class="text-3xl font-bold mb-0">{{ number_format($statistics['pending'] ?? 0) }}</h3>
            </div>
            <div class="absolute bottom-4 right-4 text-amber-200/50 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Answered -->
        <div class="card p-6 border border-emerald-100 shadow-sm bg-gradient-to-br from-emerald-500 to-emerald-600 text-white relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
            <div class="relative z-10">
                <p class="text-emerald-100 text-sm font-medium mb-1">Answered (Month)</p>
                <h3 class="text-3xl font-bold mb-0">{{ number_format($statistics['answered_this_month'] ?? 0) }}</h3>
            </div>
            <div class="absolute bottom-4 right-4 text-emerald-200/50 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Prayer Requests List -->
        <div class="lg:col-span-2">
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <h3 class="font-bold text-slate-800 text-base">Recent Requests</h3>
                    
                    <form action="{{ route('prayer.index') }}" method="GET" class="flex flex-wrap gap-2">
                         <div class="relative">
                            <select name="urgency" class="pl-3 pr-8 py-1.5 text-xs rounded-lg border-slate-200 bg-white focus:ring-primary-500 focus:border-primary-500 shadow-sm cursor-pointer" onchange="this.form.submit()">
                                <option value="">All Urgency</option>
                                <option value="critical" {{ request('urgency') == 'critical' ? 'selected' : '' }}>Critical</option>
                                <option value="high" {{ request('urgency') == 'high' ? 'selected' : '' }}>High</option>
                                <option value="normal" {{ request('urgency') == 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="low" {{ request('urgency') == 'low' ? 'selected' : '' }}>Low</option>
                            </select>
                        </div>
                        
                        <div class="relative">
                            <select name="status" class="pl-3 pr-8 py-1.5 text-xs rounded-lg border-slate-200 bg-white focus:ring-primary-500 focus:border-primary-500 shadow-sm cursor-pointer" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="answered" {{ request('status') == 'answered' ? 'selected' : '' }}>Answered</option>
                            </select>
                        </div>
                    </form>
                </div>
                
                <div class="divide-y divide-slate-100">
                    @forelse($prayerRequests as $request)
                        <div class="p-6 hover:bg-slate-50/50 transition-all group relative">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full border
                                        {{ $request->urgency === 'critical' ? 'bg-rose-50 text-rose-700 border-rose-100' : 
                                          ($request->urgency === 'high' ? 'bg-amber-50 text-amber-700 border-amber-100' : 
                                          'bg-blue-50 text-blue-700 border-blue-100') }}">
                                        {{ ucfirst($request->urgency) }}
                                    </span>
                                    <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                        {{ $request->category->name ?? 'General' }}
                                    </span>
                                </div>
                                <span class="text-xs text-slate-400 font-medium whitespace-nowrap ml-2">{{ $request->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <h4 class="font-bold text-slate-900 mb-2 group-hover:text-primary-600 transition-colors">
                                <a href="{{ route('prayer.show', $request) }}" class="focus:outline-none">
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    {{ $request->request_title }}
                                </a>
                            </h4>
                            
                            <div class="flex justify-between items-center mt-4">
                                <div class="flex items-center gap-3 text-xs text-slate-500">
                                    @if($request->is_anonymous)
                                        <div class="flex items-center gap-1.5 opacity-75">
                                            <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center">
                                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <span class="italic font-medium">Anonymous</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-6 h-6 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold">
                                                {{ substr($request->requester_name, 0, 1) }}
                                            </div>
                                            <span class="font-medium text-slate-700">{{ $request->requester_name }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($request->assignedIntercessor)
                                        <div class="flex items-center gap-1.5 bg-slate-50 px-2 py-1 rounded-full border border-slate-100">
                                            <span class="text-[10px] text-slate-400 uppercase tracking-wide">Assigned to:</span>
                                            <span class="font-medium text-slate-600">{{ $request->assignedIntercessor->full_name }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <span class="text-primary-600 text-xs font-bold uppercase tracking-wide group-hover:underline">View Details →</span>
                            </div>
                        </div>
                    @empty
                        <div class="py-16 text-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <h3 class="text-slate-900 font-bold text-base mb-1">No requests found</h3>
                            <p class="text-slate-500 text-sm">There are no prayer requests matching your criteria.</p>
                        </div>
                    @endforelse
                </div>
                
                @if($prayerRequests->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $prayerRequests->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Categories Card -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-5 py-3 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Categories</h3>
                </div>
                <div class="p-2">
                    @foreach($categories as $category)
                        <a href="{{ route('prayer.index', ['category_id' => $category->id]) }}" 
                           class="flex justify-between items-center px-4 py-2.5 hover:bg-slate-50 rounded-lg group transition-colors">
                            <span class="text-sm font-medium text-slate-700 group-hover:text-primary-700">{{ $category->name }}</span>
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full text-xs font-bold group-hover:bg-primary-50 group-hover:text-primary-600 transition-colors">
                                {{ $category->active_requests_count ?? 0 }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Prayer Wall Promo -->
            <div class="card p-6 border-0 shadow-md bg-gradient-to-br from-indigo-600 to-indigo-700 text-white text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Prayer Wall</h3>
                    <p class="text-indigo-100 text-sm mb-5 leading-relaxed">Join the community in praying for the shared needs of our church family.</p>
                    <a href="{{ route('prayer.wall') }}" class="inline-block w-full py-2.5 bg-white text-indigo-600 rounded-lg font-bold text-sm hover:bg-indigo-50 transition-colors shadow-sm">
                        Visit Prayer Wall
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection