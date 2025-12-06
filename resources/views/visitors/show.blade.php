@extends('layouts.app')

@section('title', 'Visitor Details')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Visitor Details</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('visitors.index') }}">Visitors</a>
            <span>/</span>
            <span>{{ $visitor->first_name }} {{ $visitor->last_name }}</span>
        </nav>
    </div>
    <div class="flex gap-3">
        @if($visitor->converted_member_id)
            <a href="{{ route('members.show', $visitor->convertedMember) }}" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                View Member Profile
            </a>
        @elseif($eligibleForConversion)
            <a href="{{ route('visitors.convert.form', $visitor) }}" class="btn btn-gold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Convert to Member
            </a>
        @else
            <form action="{{ route('visitors.recordVisit', $visitor) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Record Visit
                </button>
            </form>
        @endif

        @if(!$visitor->converted_member_id)
            <a href="{{ route('visitors.edit', $visitor) }}" class="btn btn-outline">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
        @endif

        <a href="{{ route('visitors.index') }}" class="btn btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Conversion Eligibility Banner -->
        @if($eligibleForConversion)
        <div class="card bg-gradient-gold">
            <div class="card-body text-white">
                <div class="flex items-center gap-4">
                    <svg class="w-12 h-12 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold mb-1">Eligible for Membership!</h3>
                        <p class="text-sm opacity-90">This visitor has attended {{ $visitor->visit_count }} services and is ready to become a member.</p>
                    </div>
                    <a href="{{ route('visitors.convert.form', $visitor) }}" class="btn bg-white text-gold-600 hover:bg-gray-100">
                        Convert Now
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Conversion Status Banner -->
        @if($visitor->converted_member_id)
        <div class="card bg-gradient-primary">
            <div class="card-body text-white">
                <div class="flex items-center gap-4">
                    <svg class="w-12 h-12 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold mb-1">Converted to Member</h3>
                        <p class="text-sm opacity-90">Member ID: {{ $visitor->convertedMember->member_id }}</p>
                    </div>
                    <a href="{{ route('members.show', $visitor->convertedMember) }}" class="btn bg-white text-blue-600 hover:bg-gray-100">
                        View Profile
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Personal Information -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Personal Information</h3>
            </div>
            <div class="card-body">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 mb-1">Full Name</dt>
                        <dd class="text-lg font-semibold">{{ $visitor->first_name }} {{ $visitor->last_name }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 mb-1">Email</dt>
                        <dd class="text-base">{{ $visitor->email ?? 'Not provided' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 mb-1">Phone</dt>
                        <dd class="text-base">{{ $visitor->phone }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 mb-1">Status</dt>
                        <dd>
                            @if($visitor->status === 'active')
                            <span class="badge badge-success">Active</span>
                            @elseif($visitor->status === 'converted')
                            <span class="badge badge-primary">Converted</span>
                            @else
                            <span class="badge badge-secondary">Inactive</span>
                            @endif
                        </dd>
                    </div>

                    @if($visitor->address)
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500 mb-1">Address</dt>
                        <dd class="text-base">
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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Visit History</h3>
            </div>
            <div class="card-body">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 mb-1">First Visit</dt>
                        <dd class="text-base font-semibold">{{ $visitor->first_visit_date?->format('l, F d, Y') }}</dd>
                        <dd class="text-xs text-gray-500">{{ $visitor->first_visit_date?->diffForHumans() }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 mb-1">Last Visit</dt>
                        <dd class="text-base font-semibold">{{ $visitor->last_visit_date?->format('l, F d, Y') }}</dd>
                        <dd class="text-xs text-gray-500">{{ $visitor->last_visit_date?->diffForHumans() }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 mb-1">Total Visits</dt>
                        <dd class="text-3xl font-bold text-blue-600">{{ $visitor->visit_count }}</dd>
                        @if($visitor->visit_count < 5)
                        <dd class="text-xs text-gray-500">{{ 5 - $visitor->visit_count }} more {{ Str::plural('visit', 5 - $visitor->visit_count) }} until eligible for membership</dd>
                        @endif
                    </div>

                    @if($visitor->referral_source)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 mb-1">How They Found Us</dt>
                        <dd class="text-base capitalize">{{ str_replace('_', ' ', $visitor->referral_source) }}</dd>
                    </div>
                    @endif
                </dl>

                <!-- Visit Progress Bar -->
                <div class="mt-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Progress to Membership</span>
                        <span class="text-sm font-medium text-gray-700">{{ min($visitor->visit_count, 5) }}/5 visits</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-gradient-gold h-3 rounded-full transition-all"
                             style="width: {{ min(($visitor->visit_count / 5) * 100, 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        @if($visitor->interests || $visitor->notes)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Additional Information</h3>
            </div>
            <div class="card-body space-y-4">
                @if($visitor->interests)
                <div>
                    <dt class="text-sm font-medium text-gray-500 mb-2">Areas of Interest</dt>
                    <dd class="text-base">{{ $visitor->interests }}</dd>
                </div>
                @endif

                @if($visitor->notes)
                <div class="pt-4 border-t">
                    <dt class="text-sm font-medium text-gray-500 mb-2">Notes</dt>
                    <dd class="text-base text-gray-700 whitespace-pre-line">{{ $visitor->notes }}</dd>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Visit Count Card -->
        <div class="card bg-gradient-primary text-white">
            <div class="card-body text-center">
                <svg class="w-16 h-16 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <div class="text-5xl font-bold mb-2">{{ $visitor->visit_count }}</div>
                <div class="text-sm opacity-90">Total {{ Str::plural('Visit', $visitor->visit_count) }}</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Quick Actions</h3>
            </div>
            <div class="card-body space-y-3">
                @if(!$visitor->converted_member_id)
                <form action="{{ route('visitors.recordVisit', $visitor) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Record New Visit
                    </button>
                </form>

                @if($eligibleForConversion)
                <a href="{{ route('visitors.convert.form', $visitor) }}" class="btn btn-gold w-full">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Convert to Member
                </a>
                @endif

                @if($visitor->status === 'active')
                <button type="button" @click="$refs.inactiveModal.showModal()" class="btn btn-outline w-full">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                    Mark as Inactive
                </button>
                @endif
                @endif
            </div>
        </div>

        <!-- Timeline -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Timeline</h3>
            </div>
            <div class="card-body">
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-medium">Registered as Visitor</div>
                            <div class="text-xs text-gray-500">{{ $visitor->created_at->format('M d, Y g:i A') }}</div>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-medium">Last Visit</div>
                            <div class="text-xs text-gray-500">{{ $visitor->last_visit_date?->format('M d, Y') }}</div>
                        </div>
                    </div>

                    @if($visitor->converted_member_id)
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gold-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-medium">Converted to Member</div>
                            <div class="text-xs text-gray-500">{{ $visitor->updated_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Admin Actions -->
        @if(auth()->user()->hasRole('admin') && !$visitor->converted_member_id)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Admin Actions</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('visitors.destroy', $visitor) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this visitor? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
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
<dialog x-ref="inactiveModal" class="rounded-lg shadow-xl w-full max-w-md p-0">
    <div class="card m-0">
        <div class="card-header">
            <h3 class="card-title">Mark as Inactive</h3>
            <button type="button" @click="$refs.inactiveModal.close()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form action="{{ route('visitors.markInactive', $visitor) }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-4">
                    <label for="reason" class="form-label required">Reason for marking inactive</label>
                    <textarea id="reason" name="reason" rows="4"
                              class="form-textarea"
                              required
                              placeholder="e.g., Relocated, Joined another church, Lost interest..."></textarea>
                </div>
                <p class="text-sm text-gray-600">
                    This visitor will be marked as inactive and removed from active follow-up lists.
                </p>
            </div>
            <div class="card-footer flex justify-end gap-3">
                <button type="button" @click="$refs.inactiveModal.close()" class="btn btn-secondary">
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
