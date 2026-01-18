@extends('layouts.app')

@section('title', 'Visitor Details')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Visitor Details</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('visitors.index') }}" class="hover:text-primary-600 transition-colors">Visitors</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">{{ $visitor->first_name }} {{ $visitor->last_name }}</span>
        </nav>
    </div>
    <div class="flex items-center gap-3 flex-wrap">
        @if($visitor->converted_member_id)
            <a href="{{ route('members.show', $visitor->convertedMember) }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                View Member Profile
            </a>
        @elseif($eligibleForConversion)
            <a href="{{ route('visitors.convert.form', $visitor) }}" class="btn bg-amber-500 border-amber-600 text-white hover:bg-amber-600 hover:border-amber-700 shadow-lg shadow-amber-500/20">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Convert to Member
            </a>
        @else
            <form action="{{ route('visitors.recordVisit', $visitor) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn btn-primary shadow-lg shadow-primary-500/30">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Record Visit
                </button>
            </form>
        @endif

        @if(!$visitor->converted_member_id)
            <a href="{{ route('visitors.edit', $visitor) }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit
            </a>

            <form action="{{ route('visitors.destroy', $visitor) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this visitor record?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Delete
                </button>
            </form>
        @endif

        <a href="{{ route('visitors.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Conversion Eligibility Banner -->
        @if($eligibleForConversion)
        <div class="card p-6 bg-gradient-to-br from-amber-500 to-amber-600 text-white shadow-lg shadow-amber-500/20">
            <div class="flex items-center gap-5">
                <div class="p-3 bg-white/20 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-heading font-bold mb-1">Eligible for Membership!</h3>
                    <p class="text-sm opacity-90">This visitor has attended {{ $visitor->visit_count }} services and is ready to become a member.</p>
                </div>
                <a href="{{ route('visitors.convert.form', $visitor) }}" class="btn bg-white text-amber-600 hover:bg-amber-50 border-0 shadow-sm font-bold">
                    Convert Now
                </a>
            </div>
        </div>
        @endif

        <!-- Conversion Status Banner -->
        @if($visitor->converted_member_id)
        <div class="card p-6 bg-gradient-to-br from-primary-600 to-primary-700 text-white shadow-lg shadow-primary-500/20">
            <div class="flex items-center gap-5">
                <div class="p-3 bg-white/20 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-heading font-bold mb-1">Converted to Member</h3>
                    <p class="text-sm opacity-90">Member ID: {{ $visitor->convertedMember->member_id }}</p>
                </div>
                <a href="{{ route('members.show', $visitor->convertedMember) }}" class="btn bg-white text-primary-600 hover:bg-primary-50 border-0 shadow-sm font-bold">
                    View Profile
                </a>
            </div>
        </div>
        @endif

        <!-- Personal Information -->
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Personal Information</h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">
                    <div>
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Full Name</dt>
                        <dd class="text-base font-semibold text-slate-900">{{ $visitor->first_name }} {{ $visitor->last_name }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Email</dt>
                        <dd class="text-base text-slate-700">{{ $visitor->email ?? 'Not provided' }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Phone</dt>
                        <dd class="text-base font-mono text-slate-700">{{ $visitor->phone }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Status</dt>
                        <dd>
                            @if($visitor->status === 'active')
                            <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Active</span>
                            @elseif($visitor->status === 'converted')
                            <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-600/20">Converted</span>
                            @else
                            <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">Inactive</span>
                            @endif
                        </dd>
                    </div>

                    @if($visitor->address)
                    <div class="md:col-span-2">
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Address</dt>
                        <dd class="text-base text-slate-700 leading-relaxed">
                            {{ $visitor->address }}
                            @if($visitor->city || $visitor->state)
                            <br>{{ $visitor->city }}{{ $visitor->city && $visitor->state ? ', ' : '' }}{{ $visitor->state }}
                            @endif
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Visit Information -->
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Visit History</h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">
                    <div>
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">First Visit</dt>
                        <dd class="text-base font-semibold text-slate-900">{{ $visitor->first_visit_date?->format('l, F d, Y') }}</dd>
                        <dd class="text-xs text-slate-500 mt-0.5">{{ $visitor->first_visit_date?->diffForHumans() }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Last Visit</dt>
                        <dd class="text-base font-semibold text-slate-900">{{ $visitor->last_visit_date?->format('l, F d, Y') }}</dd>
                        <dd class="text-xs text-slate-500 mt-0.5">{{ $visitor->last_visit_date?->diffForHumans() }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Visits</dt>
                        <dd class="text-3xl font-heading font-bold text-primary-600">{{ $visitor->visit_count }}</dd>
                        @if($visitor->visit_count < 5)
                        <dd class="text-xs text-slate-500 mt-1">{{ 5 - $visitor->visit_count }} more {{ Str::plural('visit', 5 - $visitor->visit_count) }} until eligible for membership</dd>
                        @endif
                    </div>

                    @if($visitor->referral_source)
                    <div>
                        <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">How They Found Us</dt>
                        <dd class="text-base capitalize text-slate-700">{{ str_replace('_', ' ', $visitor->referral_source) }}</dd>
                    </div>
                    @endif
                </dl>

                <!-- Visit Progress Bar -->
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-bold text-slate-700">Progress to Membership</span>
                        <span class="text-sm font-medium text-slate-500">{{ min($visitor->visit_count, 5) }}/5 visits</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                        <div class="bg-gradient-to-r from-amber-400 to-amber-500 h-3 rounded-full transition-all duration-500 ease-out shadow-sm"
                             style="width: {{ min(($visitor->visit_count / 5) * 100, 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        @if($visitor->interests || $visitor->notes)
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Additional Information</h3>
            </div>
            <div class="p-6 space-y-6">
                @if($visitor->interests)
                <div>
                    <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Areas of Interest</dt>
                    <dd class="text-base text-slate-700 bg-slate-50 p-3 rounded-lg border border-slate-100">{{ $visitor->interests }}</dd>
                </div>
                @endif

                @if($visitor->notes)
                <div class="{{ $visitor->interests ? 'pt-6 border-t border-slate-100' : '' }}">
                    <dt class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Notes</dt>
                    <dd class="text-base text-slate-700 whitespace-pre-line bg-slate-50 p-3 rounded-lg border border-slate-100">{{ $visitor->notes }}</dd>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Visit Count Card -->
        <div class="card p-6 bg-gradient-to-br from-primary-600 to-purple-600 text-white shadow-md">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div class="text-5xl font-heading font-bold mb-2">{{ $visitor->visit_count }}</div>
                <div class="text-sm font-medium opacity-90 uppercase tracking-widest">Total {{ Str::plural('Visit', $visitor->visit_count) }}</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Quick Actions</h3>
            </div>
            <div class="p-6 space-y-3">
                @if(!$visitor->converted_member_id)
                <form action="{{ route('visitors.recordVisit', $visitor) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary w-full shadow-lg shadow-primary-500/30">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Record New Visit
                    </button>
                </form>

                @if($eligibleForConversion)
                <a href="{{ route('visitors.convert.form', $visitor) }}" class="btn bg-amber-500 border-amber-600 text-white hover:bg-amber-600 hover:border-amber-700 w-full justify-center shadow-lg shadow-amber-500/20">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Convert to Member
                </a>
                @endif

                @if($visitor->status === 'active')
                <button type="button" @click="$refs.inactiveModal.showModal()" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 w-full justify-center transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                    Mark as Inactive
                </button>
                @endif
                @endif
            </div>
        </div>

        <!-- Timeline -->
        <div class="card border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Timeline</h3>
            </div>
            <div class="p-6">
                <div class="space-y-6 relative before:absolute before:inset-y-0 before:left-4 before:w-0.5 before:bg-slate-200">
                    <div class="relative pl-10">
                        <div class="absolute left-0 top-0 w-8 h-8 rounded-full bg-blue-100 border-2 border-white ring-2 ring-slate-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-900">Registered as Visitor</div>
                            <div class="text-xs text-slate-500 mt-0.5">{{ $visitor->created_at->format('M d, Y g:i A') }}</div>
                        </div>
                    </div>

                    <div class="relative pl-10">
                        <div class="absolute left-0 top-0 w-8 h-8 rounded-full bg-emerald-100 border-2 border-white ring-2 ring-slate-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-900">Last Visit</div>
                            <div class="text-xs text-slate-500 mt-0.5">{{ $visitor->last_visit_date?->format('M d, Y') }}</div>
                        </div>
                    </div>

                    @if($visitor->converted_member_id)
                    <div class="relative pl-10">
                        <div class="absolute left-0 top-0 w-8 h-8 rounded-full bg-amber-100 border-2 border-white ring-2 ring-slate-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-900">Converted to Member</div>
                            <div class="text-xs text-slate-500 mt-0.5">{{ $visitor->updated_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Admin Actions -->
        @if(auth()->user()->hasRole('admin') && !$visitor->converted_member_id)
        <div class="card border border-red-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-red-100 bg-red-50/30">
                <h3 class="font-bold text-red-900 text-base">Admin Actions</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('visitors.destroy', $visitor) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this visitor? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Delete Visitor
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Mark Inactive Modal -->
@if($visitor->status === 'active' && !$visitor->converted_member_id)
<dialog x-ref="inactiveModal" class="rounded-xl shadow-2xl w-full max-w-md p-0 backdrop:bg-slate-900/50 backdrop:backdrop-blur-sm">
    <div class="card border-0 shadow-none m-0">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="font-bold text-slate-900">Mark as Inactive</h3>
            <button type="button" @click="$refs.inactiveModal.close()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('visitors.markInactive', $visitor) }}" method="POST">
            @csrf
            <div class="p-6">
                <div class="mb-4">
                    <label for="reason" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Reason for marking inactive</label>
                    <textarea id="reason" name="reason" rows="4"
                              class="form-textarea w-full rounded-xl border-slate-200 focus:border-primary-500 focus:ring-primary-500"
                              required
                              placeholder="e.g., Relocated, Joined another church, Lost interest..."></textarea>
                </div>
                <p class="text-sm text-slate-500">
                    This visitor will be marked as inactive and removed from active follow-up lists.
                </p>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <button type="button" @click="$refs.inactiveModal.close()" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="btn btn-danger">
                    Mark as Inactive
                </button>
            </div>
        </form>
    </div>
</dialog>
@endif
@endsection
