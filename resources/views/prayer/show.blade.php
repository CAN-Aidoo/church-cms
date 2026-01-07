@extends('layouts.app')

@section('title', $prayerRequest->request_title)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-3">
             <a href="{{ route('prayer.index') }}" class="p-2 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-slate-50 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Prayer Request Details</h1>
                <p class="text-slate-600">View details and updates for this prayer request.</p>
            </div>
        </div>
        
        @can('update', $prayerRequest)
        <a href="{{ route('prayer.edit', $prayerRequest) }}" 
           class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 hover:border-slate-400 transition-all shadow-sm font-medium text-sm">
            <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Request
        </a>
        @endcan
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content (Details & Updates) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Details Card -->
            <div class="card border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-6">
                        <h2 class="text-xl font-bold text-slate-900 leading-snug">{{ $prayerRequest->request_title }}</h2>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide flex-shrink-0
                            @if($prayerRequest->status === 'pending') bg-amber-50 text-amber-700 border border-amber-100
                            @elseif($prayerRequest->status === 'praying') bg-blue-50 text-blue-700 border border-blue-100
                            @elseif($prayerRequest->status === 'answered') bg-emerald-50 text-emerald-700 border border-emerald-100
                            @elseif($prayerRequest->status === 'closed') bg-slate-100 text-slate-600 border border-slate-200
                            @endif">
                            {{ ucfirst($prayerRequest->status) }}
                        </span>
                    </div>

                    <div class="prose max-w-none text-slate-600 mb-8 leading-relaxed">
                        {!! nl2br(e($prayerRequest->request_details)) !!}
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-6 border-t border-slate-100">
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Category</span>
                            <span class="block text-sm font-semibold text-slate-700 bg-slate-50 px-2 py-1 rounded w-fit">{{ $prayerRequest->category->name ?? 'General' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Urgency</span>
                            <span class="block text-sm font-semibold 
                                {{ $prayerRequest->urgency === 'critical' ? 'text-rose-600' : 
                                   ($prayerRequest->urgency === 'high' ? 'text-amber-600' : 'text-slate-700') }}">
                                {{ ucfirst($prayerRequest->urgency) }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Requester</span>
                            <span class="block text-sm font-semibold text-slate-700">{{ $prayerRequest->is_anonymous ? 'Anonymous' : $prayerRequest->requester_name }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Submitted</span>
                            <span class="block text-sm font-semibold text-slate-700">{{ $prayerRequest->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    
                    @if($prayerRequest->tags && count($prayerRequest->tags) > 0)
                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-2">Tags</span>
                        <div class="flex flex-wrap gap-2">
                             @foreach($prayerRequest->tags as $tag)
                                <span class="px-2 py-1 bg-slate-50 text-slate-500 rounded text-xs font-medium border border-slate-100">#{{ trim($tag) }}</span>
                             @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Updates Timeline -->
            <div class="card border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 text-base">Prayer Updates</h3>
                    <span class="text-xs font-medium text-slate-500">{{ count($prayerRequest->updates ?? []) }} updates</span>
                </div>
                
                <div class="p-6 md:p-8">
                    @if(count($prayerRequest->updates ?? []) > 0)
                        <div class="relative space-y-8 before:absolute before:inset-0 before:ml-5 before:h-full before:w-0.5 before:-translate-x-px before:bg-gradient-to-b before:from-slate-200 before:via-slate-200 before:to-transparent">
                            @foreach($prayerRequest->updates->sortByDesc('created_at') as $update)
                                <div class="relative flex gap-6 group">
                                    <div class="absolute left-0 mt-1.5 ml-2.5 -translate-x-1/2 rounded-full border-4 border-white">
                                        <div class="h-5 w-5 rounded-full flex items-center justify-center
                                            @if($update->update_type === 'answered') bg-emerald-500
                                            @elseif($update->update_type === 'progress') bg-blue-500
                                            @elseif($update->update_type === 'status_change') bg-amber-500
                                            @else bg-slate-400
                                            @endif">
                                            @if($update->update_type === 'answered')
                                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            @elseif($update->update_type === 'progress')
                                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                            @elseif($update->update_type === 'status_change')
                                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                            @else
                                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" /></svg>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex-1 bg-slate-50 border border-slate-100 rounded-xl p-4 shadow-sm group-hover:bg-white group-hover:border-primary-100 group-hover:shadow-md transition-all">
                                        <div class="flex justify-between items-start mb-2">
                                            <span class="text-xs font-bold uppercase tracking-wide
                                                @if($update->update_type === 'answered') text-emerald-600
                                                @elseif($update->update_type === 'progress') text-blue-600
                                                @elseif($update->update_type === 'status_change') text-amber-600
                                                @else text-slate-500
                                                @endif">
                                                {{ str_replace('_', ' ', $update->update_type) }}
                                            </span>
                                            <span class="text-xs text-slate-400">{{ $update->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-slate-700">{{ $update->update_text }}</p>
                                        @if($update->updated_by_user)
                                        <div class="mt-3 flex items-center gap-2 pt-3 border-t border-slate-200/50">
                                            <div class="w-5 h-5 rounded-full bg-slate-200 flex items-center justify-center text-[10px] text-slate-500 font-bold">
                                                {{ substr($update->updated_by_user->name, 0, 1) }}
                                            </div>
                                            <span class="text-xs text-slate-500">{{ $update->updated_by_user->name }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 border border-slate-100">
                                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-slate-500 font-medium">No updates posted yet.</p>
                        </div>
                    @endif

                    <!-- Add Update Form -->
                    @if(auth()->user()->hasAnyRole(['admin', 'pastor', 'staff']) || (auth()->user()->member && $prayerRequest->assigned_to === auth()->user()->member->id))
                        <div class="mt-8 pt-6 border-t border-slate-100">
                            <h4 class="font-bold text-slate-800 text-sm mb-4">Post an Update</h4>
                            <form action="{{ route('prayer.add-update', $prayerRequest) }}" method="POST">
                                @csrf
                                <input type="hidden" name="update_type" value="note">
                                <div class="flex gap-3">
                                    <div class="flex-grow">
                                        <textarea name="update_text" rows="2" placeholder="Add a prayer note or update..." class="form-textarea w-full border-slate-200 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500" required></textarea>
                                    </div>
                                </div>
                                <div class="mt-3 flex justify-between items-center">
                                    <label class="inline-flex items-center text-xs text-slate-600 cursor-pointer">
                                        <input type="checkbox" name="notify_requester" value="1" class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                                        <span class="ml-2">Notify requester via email</span>
                                    </label>
                                    <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-900 transition-colors text-sm font-bold shadow-sm">
                                        Post Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            @if(auth()->user()->hasAnyRole(['admin', 'pastor', 'staff']))
                <div class="card border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-3 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Admin Actions</h3>
                    </div>
                    <div class="p-5 space-y-5">
                        <!-- Assign Intercessor -->
                        <form action="{{ route('prayer.assign', $prayerRequest) }}" method="POST">
                            @csrf
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Assign Intercessor</label>
                            <div class="flex gap-2">
                                <input type="text" name="intercessor_id" placeholder="Member ID" class="form-input w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500" required>
                                <button type="submit" class="px-3 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-xs font-bold shadow-sm">Assign</button>
                            </div>
                        </form>

                        <hr class="border-slate-100">

                        <!-- Mark Answered -->
                        @if($prayerRequest->status !== 'answered')
                            <div>
                                <button type="button" onclick="document.getElementById('mark-answered-form').classList.toggle('hidden')" 
                                        class="w-full px-4 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-all text-sm font-bold shadow-sm mb-2 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Mark as Answered
                                </button>
                                
                                <form id="mark-answered-form" action="{{ route('prayer.mark-answered', $prayerRequest) }}" method="POST" class="hidden space-y-3 bg-emerald-50 p-3 rounded-lg border border-emerald-100">
                                    @csrf
                                    <textarea name="testimony" rows="3" class="form-textarea w-full rounded-lg border-emerald-200 text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Enter testimony details (optional)"></textarea>
                                    <label class="flex items-center text-xs text-emerald-800 cursor-pointer">
                                        <input type="checkbox" name="share_testimony" value="1" class="rounded border-emerald-300 text-emerald-600 focus:ring-emerald-500">
                                        <span class="ml-2 font-medium">Share testimony publicly</span>
                                    </label>
                                    <button type="submit" class="w-full px-4 py-2 bg-emerald-700 text-white rounded-lg text-xs font-bold hover:bg-emerald-800 transition">Confirm Answered</button>
                                </form>
                            </div>
                        @endif
                        
                        <!-- Delete -->
                        <form action="{{ route('prayer.destroy', $prayerRequest) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this request? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2.5 bg-white border border-rose-200 text-rose-600 rounded-lg hover:bg-rose-50 hover:border-rose-300 transition-all text-sm font-bold shadow-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Request
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Assigned Intercessor Display -->
            @if($prayerRequest->assignedIntercessor)
                <div class="card border border-primary-100 shadow-sm bg-gradient-to-br from-primary-50 to-white">
                    <div class="p-5">
                        <h3 class="text-xs font-bold text-primary-800 uppercase tracking-wide mb-3">Assigned Intercessor</h3>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white border border-primary-100 flex items-center justify-center text-primary-600 font-bold shadow-sm">
                                {{ substr($prayerRequest->assignedIntercessor->first_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-900">{{ $prayerRequest->assignedIntercessor->full_name }}</p>
                                <p class="text-xs text-primary-600 font-medium">Prayer Warrior</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
