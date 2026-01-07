@extends('layouts.app')

@section('title', 'My Prayer Requests')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <div class="flex items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-3">
             <a href="{{ route('prayer.index') }}" class="p-2 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-slate-50 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">My Prayer Requests</h1>
                <p class="text-slate-600">Track the status and updates of your prayer needs.</p>
            </div>
        </div>
        <a href="{{ route('prayer.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition font-medium text-sm shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            New Request
        </a>
    </div>

    <div class="card border border-slate-100 shadow-sm overflow-hidden">
        @if($myRequests->isNotEmpty())
        <div class="divide-y divide-slate-100">
            @foreach($myRequests as $request)
            <div class="p-6 hover:bg-slate-50 transition-all group">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide
                                @if($request->status === 'pending') bg-amber-50 text-amber-700 border border-amber-100
                                @elseif($request->status === 'active') bg-blue-50 text-blue-700 border border-blue-100
                                @elseif($request->status === 'answered') bg-emerald-50 text-emerald-700 border border-emerald-100
                                @else bg-slate-100 text-slate-600 border border-slate-200
                                @endif">
                                {{ ucfirst($request->status) }}
                            </span>
                             <span class="text-xs text-slate-400 font-medium">{{ $request->created_at->format('M d, Y') }}</span>
                        </div>
                        
                        <h3 class="font-bold text-slate-900 text-lg mb-2">
                            <a href="{{ route('prayer.show', $request) }}" class="hover:text-primary-600 transition-colors">
                                {{ $request->request_title }}
                            </a>
                        </h3>
                        
                        <p class="text-slate-600 text-sm line-clamp-2 mb-3">
                            {{ $request->request_details }}
                        </p>
                        
                        <div class="flex items-center gap-4 text-xs">
                             <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-500 border border-slate-200 font-medium">
                                {{ $request->category->name ?? 'General' }}
                            </span>
                            @if($request->updates_count > 0)
                                <span class="flex items-center gap-1 text-blue-600 font-medium">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    {{ $request->updates_count }} Update{{ $request->updates_count != 1 ? 's' : '' }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex flex-row md:flex-col gap-2 items-center md:items-end">
                        <a href="{{ route('prayer.show', $request) }}" class="px-4 py-2 bg-white text-slate-700 border border-slate-300 rounded-lg hover:bg-slate-50 hover:border-slate-400 transition font-medium text-sm w-full md:w-auto text-center">
                            View Details
                        </a>
                        <a href="{{ route('prayer.edit', $request) }}" class="px-4 py-2 bg-slate-50 text-slate-600 hover:text-slate-800 rounded-lg hover:bg-slate-100 transition text-sm font-medium w-full md:w-auto text-center">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $myRequests->links() }}
        </div>
        @else
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.013 8.013 0 01-5.45-2.125L3 19l.75-3.354A7.998 7.998 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z" />
                </svg>
            </div>
            <h3 class="text-slate-900 font-bold text-lg mb-2">No Requests Yet</h3>
            <p class="text-slate-500 mb-6 max-w-sm mx-auto">You haven't submitted any prayer requests. We are here to pray with you.</p>
            <a href="{{ route('prayer.create') }}" class="px-6 py-2.5 bg-primary-600 text-white rounded-lg font-bold hover:bg-primary-700 transition shadow-sm">
                Submit Your First Request
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
