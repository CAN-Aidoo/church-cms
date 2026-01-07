@extends('layouts.app')

@section('title', 'Children\'s Events')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Events</h1>
         <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('childrens-ministry.index') }}" class="hover:text-primary-600 transition-colors">Children's Ministry</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Events</span>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('childrens-ministry.events.create') }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Create Event
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($events as $event)
        <div class="card border border-slate-100 shadow-sm flex flex-col h-full group hover:border-primary-200 hover:shadow-md transition-all">
             <div class="p-6 flex-1">
                <div class="flex justify-between items-start mb-3">
                    <span class="inline-flex items-center rounded-lg px-2.5 py-0.5 text-xs font-bold bg-purple-50 text-purple-700 border border-purple-100 capitalize">
                        {{ str_replace('_', ' ', $event->event_type) }}
                    </span>
                    <span class="inline-flex items-center rounded-lg px-2.5 py-0.5 text-xs font-bold capitalize 
                        {{ $event->status === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 
                          ($event->status === 'completed' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-slate-100 text-slate-600 border border-slate-200') }}">
                        {{ $event->status }}
                    </span>
                </div>
                
                <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-primary-600 transition-colors">
                    <a href="{{ route('childrens-ministry.events.show', $event) }}">
                        {{ $event->event_name }}
                    </a>
                </h3>
                
                <div class="flex items-start gap-3 mb-4">
                     <div class="p-2 bg-slate-50 rounded-lg text-center min-w-[50px] border border-slate-100">
                        <span class="block text-xs font-bold text-slate-400 uppercase leading-none mb-1">{{ $event->start_date->format('M') }}</span>
                        <span class="block text-xl font-bold text-slate-800 leading-none">{{ $event->start_date->format('d') }}</span>
                    </div>
                    <div class="text-sm text-slate-500 pt-1">
                        <p class="flex items-center gap-1.5">
                             <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $event->start_time->format('h:i A') }}
                        </p>
                         @if($event->location)
                        <p class="flex items-center gap-1.5 mt-1">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $event->location }}
                        </p>
                        @endif
                    </div>
                </div>

                <p class="text-sm text-slate-600 line-clamp-2 mb-4">{{ $event->description }}</p>
            </div>
            
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex justify-end">
                <a href="{{ route('childrens-ministry.events.show', $event) }}" class="text-sm font-medium text-primary-600 hover:text-primary-700 flex items-center gap-1 transition-colors group-hover:gap-2">
                    Manage Event
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full py-12 text-center bg-slate-50 rounded-xl border border-dashed border-slate-300">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-200">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-2">No Events Found</h3>
            <p class="text-slate-500 mb-6">Get started by creating your first children's ministry event.</p>
            <a href="{{ route('childrens-ministry.events.create') }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
                Create Event
            </a>
        </div>
    @endforelse
</div>
@endsection
