@extends('layouts.app')

@section('title', 'Prayer Wall')

@section('content')
<div class="bg-slate-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-primary-700 to-indigo-800 text-white py-16">
        <div class="container mx-auto px-4 max-w-7xl text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4">Prayer Wall</h1>
            <p class="text-primary-100 text-lg md:text-xl max-w-2xl mx-auto mb-8">
                "For where two or three gather in my name, there am I with them." - Matthew 18:20
                <br>Join us in lifting up the needs of our community.
            </p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('prayer.create') }}" class="px-8 py-3 bg-white text-primary-700 rounded-full font-bold shadow-lg hover:shadow-xl hover:bg-slate-50 transition-all transform hover:-translate-y-1">
                    Submit a Request
                </a>
                <a href="#urgent-requests" class="px-8 py-3 bg-primary-600/50 text-white border border-white/20 rounded-full font-bold hover:bg-primary-600/70 transition-all backdrop-blur-sm">
                    View Urgent Needs
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12 max-w-7xl -mt-8">
        
        <!-- Urgent Requests Section -->
        @if($urgentRequests->isNotEmpty())
        <div id="urgent-requests" class="mb-12">
            <div class="flex items-center gap-3 mb-6">
                <span class="p-2 bg-rose-100 rounded-lg text-rose-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </span>
                <h2 class="text-2xl font-bold text-slate-800">Urgent Prayer Needs</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($urgentRequests as $request)
                <div class="card border-l-4 border-l-rose-500 shadow-sm hover:shadow-md transition-all group bg-white">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <span class="px-2 py-1 bg-rose-50 text-rose-700 text-xs font-bold uppercase tracking-wide rounded">Urgent</span>
                            <span class="text-xs text-slate-400 font-medium">{{ $request->created_at->diffForHumans() }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-rose-600 transition-colors">
                            {{ $request->request_title }}
                        </h3>
                        <p class="text-slate-600 text-sm mb-4 line-clamp-3">
                            {{ $request->request_details }}
                        </p>
                        <div class="flex justify-between items-center pt-4 border-t border-slate-50">
                            <span class="text-xs text-slate-500 font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $request->is_anonymous ? 'Anonymous' : $request->requester_name }}
                            </span>
                            <button class="text-sm font-bold text-rose-600 hover:text-rose-800 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                Pray
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Recent Requests -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-slate-800 mb-6 pl-1">Recent Requests</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($publicRequests as $request)
                <div class="card shadow-sm hover:shadow-lg transition-all group bg-white h-full flex flex-col">
                    <div class="p-6 flex-1">
                        <div class="flex justify-between items-start mb-3">
                            <span class="text-xs font-bold text-primary-600 bg-primary-50 px-2 py-1 rounded">
                                {{ $request->category->name ?? 'General' }}
                            </span>
                            <span class="text-xs text-slate-400">{{ $request->created_at->diffForHumans(null, true) }}</span>
                        </div>
                        
                        <h3 class="font-bold text-slate-900 mb-2 group-hover:text-primary-600 transition-colors text-lg">
                            {{ $request->request_title }}
                        </h3>
                        
                        <p class="text-slate-600 text-sm leading-relaxed mb-4 line-clamp-4">
                            {{ $request->request_details }}
                        </p>
                    </div>
                    
                    <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-between items-center rounded-b-xl">
                        <div class="flex items-center gap-2">
                             @if($request->is_anonymous)
                                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-600">Anonymous</span>
                            @else
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs ring-2 ring-white">
                                    {{ substr($request->requester_name, 0, 1) }}
                                </div>
                                <span class="text-xs font-semibold text-slate-600">{{ collect(explode(' ', $request->requester_name))->first() }}</span>
                            @endif
                        </div>
                        
                        <a href="{{ route('prayer.show', $request) }}" class="text-primary-600 hover:text-primary-700 text-xs font-bold uppercase tracking-wide">
                            View
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-16 bg-white rounded-xl border border-slate-100 shadow-sm">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">No prayer requests on the wall yet</h3>
                    <p class="text-slate-500 mb-6">Be the first to share a request or testimony.</p>
                    <a href="{{ route('prayer.create') }}" class="px-6 py-2 bg-primary-600 text-white rounded-lg font-medium hover:bg-primary-700 transition">
                        Share Request
                    </a>
                </div>
                @endforelse
            </div>
            
             <div class="mt-8 text-center">
                <a href="{{ route('prayer.index') }}" class="inline-flex items-center text-primary-600 font-semibold hover:text-primary-800 transition">
                    View All Requests <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
