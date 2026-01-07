@extends('layouts.app')

@section('title', $event->event_name)

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">{{ $event->event_name }}</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('childrens-ministry.events') }}" class="hover:text-primary-600 transition-colors">Events</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Details</span>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        @if($event->status == 'draft')
            <form action="{{ route('childrens-ministry.events.publish', $event) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success shadow-lg shadow-green-500/30">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Publish Event
                </button>
            </form>
        @endif
        <a href="{{ route('childrens-ministry.events.edit', $event) }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Edit Event
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Event Info Card -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-base">Event Information</h3>
                 <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-bold capitalize 
                        {{ $event->status === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 
                          ($event->status === 'completed' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-slate-100 text-slate-600 border border-slate-200') }}">
                        {{ $event->status }}
                    </span>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                     <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1 block">Date & Time</span>
                        <div class="font-bold text-slate-900">{{ $event->start_date->format('M d, Y') }}</div>
                        <div class="text-sm text-slate-500">{{ $event->start_time->format('h:i A') }} - {{ $event->end_time ? $event->end_time->format('h:i A') : 'TBD' }}</div>
                    </div>
                    
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1 block">Location</span>
                        <div class="font-bold text-slate-900">{{ $event->location ?? 'To Be Decided' }}</div>
                        <div class="text-sm text-slate-500">On Campus</div>
                    </div>

                     <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1 block">Coordinator</span>
                        <div class="font-bold text-slate-900">{{ $event->coordinator->name ?? 'Unknown' }}</div>
                        <div class="text-sm text-slate-500">Event Lead</div>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold text-slate-800 mb-2 text-sm uppercase tracking-wider">Description</h4>
                    <div class="prose prose-slate prose-sm max-w-none text-slate-600">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Registrations -->
        <div class="card border border-slate-100 shadow-sm">
             <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-base">Registrations</h3>
                <span class="bg-blue-100 text-blue-700 font-bold px-2 py-1 rounded text-xs">{{ $registrations->count() }} Registered</span>
            </div>
            <div class="p-0">
                @if($registrations->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead class="bg-slate-50 border-b border-slate-100 text-xs uppercase text-slate-500 font-semibold">
                                <tr>
                                    <th class="px-6 py-3 text-left">Child Name</th>
                                    <th class="px-6 py-3 text-left">Status</th>
                                    <th class="px-6 py-3 text-left">Payment</th>
                                    <th class="px-6 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($registrations as $reg)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-3 font-medium text-slate-700">{{ $reg->child->full_name }}</td>
                                        <td class="px-6 py-3">
                                            <span class="px-2 py-0.5 rounded text-xs font-bold bg-slate-100 text-slate-600 capitalize">
                                                {{ $reg->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-3 text-sm text-slate-600">
                                            @if($reg->amount_paid > 0)
                                                <span class="text-emerald-600 font-medium">Paid</span>
                                            @else
                                                <span class="text-slate-400">Free / Unpaid</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-3 text-right">
                                            <button class="text-slate-400 hover:text-red-500 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center text-slate-500 text-sm">
                        No registrations yet.
                    </div>
                @endif
            </div>
            
            <!-- Quick Register -->
            <div class="p-6 bg-slate-50 border-t border-slate-100">
                <h4 class="font-bold text-slate-800 text-sm mb-3">Quick Register Child</h4>
                <form action="{{ route('childrens-ministry.events.register', $event) }}" method="POST" class="flex gap-3">
                    @csrf
                    <div class="flex-1">
                        <input type="number" name="child_id" class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg text-sm" placeholder="Enter Child ID" required>
                    </div>
                    <button type="submit" class="btn btn-primary px-4 shadow-md shadow-primary-500/20">Register</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Stats -->
        <div class="card p-6 border border-slate-100 shadow-sm bg-gradient-to-br from-indigo-500 to-indigo-600 text-white">
            <h3 class="text-indigo-100 font-medium text-sm uppercase tracking-wider mb-1">Registration Fee</h3>
             <p class="text-4xl font-bold">{{ $event->registration_fee > 0 ? '$'.number_format($event->registration_fee, 2) : 'Free' }}</p>
        </div>

        <!-- Target Audience -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Target Audience</h3>
            </div>
            <div class="p-6">
                @if($event->age_groups)
                    <div class="flex flex-wrap gap-2">
                        @foreach($event->age_groups as $group)
                            <span class="px-3 py-1.5 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-lg text-sm font-medium capitalize">{{ str_replace('_', ' ', $group) }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500 italic text-sm">Open to all ages.</p>
                @endif
            </div>
        </div>
        
        <!-- Metadata -->
        <div class="card border border-slate-100 shadow-sm p-6 text-xs text-slate-400 space-y-2">
            <div class="flex justify-between">
                <span>Created</span>
                <span>{{ $event->created_at->format('M d, Y') }}</span>
            </div>
             <div class="flex justify-between">
                <span>Last Updated</span>
                <span>{{ $event->updated_at->format('M d, Y') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
