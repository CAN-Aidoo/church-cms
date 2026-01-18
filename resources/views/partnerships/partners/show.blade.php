@extends('layouts.app')

@section('title', $partner->name)

@section('content')
<!-- Header -->
<div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6 mb-8">
    <div>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-2">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('partnerships.index') }}" class="hover:text-primary-600 transition-colors">Partnerships</a>
            <span>/</span>
            <a href="{{ route('partnerships.partners') }}" class="hover:text-primary-600 transition-colors">Partners</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">{{ $partner->name }}</span>
        </nav>

        <div class="flex items-center gap-3">
            <h1 class="text-3xl font-heading font-bold text-slate-900">{{ $partner->name }}</h1>
            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $partner->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                {{ ucfirst($partner->status) }}
            </span>
            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-slate-100 text-slate-700 capitalize">
                {{ ucwords(str_replace('_', ' ', $partner->category)) }}
            </span>
        </div>
    </div>

    <div class="flex flex-wrap gap-2">
        <a href="{{ route('partnerships.partners.edit', $partner) }}" class="btn btn-outline-primary">
            Edit
        </a>

        <form action="{{ route('partnerships.partners.destroy', $partner) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this partner? This action cannot be undone.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                Delete
            </button>
        </form>
    </div>
</div>

<!-- Partner Details -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Contact Information -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Contact Information</h2>
            </div>
            <div class="card-body">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($partner->contact_person)
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Contact Person</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $partner->contact_person }}</dd>
                    </div>
                    @endif

                    @if($partner->email)
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Email</dt>
                        <dd class="mt-1 text-sm text-slate-900">
                            <a href="mailto:{{ $partner->email }}" class="text-primary-600 hover:text-primary-700">
                                {{ $partner->email }}
                            </a>
                        </dd>
                    </div>
                    @endif

                    @if($partner->phone)
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Phone</dt>
                        <dd class="mt-1 text-sm text-slate-900">
                            <a href="tel:{{ $partner->phone }}" class="text-primary-600 hover:text-primary-700">
                                {{ $partner->phone }}
                            </a>
                        </dd>
                    </div>
                    @endif

                    @if($partner->website)
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Website</dt>
                        <dd class="mt-1 text-sm text-slate-900">
                            <a href="{{ $partner->website }}" target="_blank" class="text-primary-600 hover:text-primary-700">
                                {{ $partner->website }}
                            </a>
                        </dd>
                    </div>
                    @endif

                    @if($partner->address)
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-slate-500">Address</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $partner->address }}</dd>
                    </div>
                    @endif
                </dl>

                @if(!$partner->contact_person && !$partner->email && !$partner->phone && !$partner->website && !$partner->address)
                <p class="text-center py-4 text-slate-500">No contact information available</p>
                @endif
            </div>
        </div>

        <!-- Description -->
        @if($partner->description)
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Description</h2>
            </div>
            <div class="card-body">
                <div class="prose max-w-none text-slate-700">
                    {!! nl2br(e($partner->description)) !!}
                </div>
            </div>
        </div>
        @endif

        <!-- Agreements -->
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h2 class="text-xl font-semibold">Partnership Agreements</h2>
                <a href="{{ route('partnerships.agreements') }}?partner_id={{ $partner->id }}" class="text-sm text-primary-600 hover:text-primary-700">
                    View All
                </a>
            </div>
            <div class="card-body">
                @if($partner->agreements && $partner->agreements->count() > 0)
                    <div class="space-y-3">
                        @foreach($partner->agreements as $agreement)
                            <div class="p-4 border border-slate-200 rounded-lg hover:border-primary-300 transition-colors">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-slate-900">
                                            <a href="{{ route('partnerships.agreements.show', $agreement) }}" class="hover:text-primary-600">
                                                {{ $agreement->agreement_title }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-slate-600 mt-1">
                                            {{ \Carbon\Carbon::parse($agreement->start_date)->format('M d, Y') }}
                                            @if($agreement->end_date)
                                                - {{ \Carbon\Carbon::parse($agreement->end_date)->format('M d, Y') }}
                                            @endif
                                        </p>
                                        @if($agreement->financial_commitment)
                                        <p class="text-sm text-slate-600 mt-1">
                                            <span class="font-medium">Commitment:</span> GHS {{ number_format($agreement->financial_commitment, 2) }}
                                        </p>
                                        @endif
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($agreement->status === 'active') bg-green-100 text-green-800
                                        @elseif($agreement->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($agreement->status === 'expired') bg-gray-100 text-gray-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($agreement->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-slate-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p>No agreements with this partner yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Partner Info -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Partner Info</h2>
            </div>
            <div class="card-body space-y-4">
                <div>
                    <dt class="text-sm font-medium text-slate-500">Category</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ ucwords(str_replace('_', ' ', $partner->category)) }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-slate-500">Status</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $partner->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($partner->status) }}
                        </span>
                    </dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-slate-500">Added</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $partner->created_at->format('M d, Y') }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-slate-500">Last Updated</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $partner->updated_at->format('M d, Y') }}</dd>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Statistics</h2>
            </div>
            <div class="card-body space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Total Agreements</span>
                    <span class="text-lg font-semibold text-slate-900">{{ $partner->agreements->count() }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Active Agreements</span>
                    <span class="text-lg font-semibold text-slate-900">{{ $partner->agreements->where('status', 'active')->count() }}</span>
                </div>

                @php
                    $totalCommitment = $partner->agreements->sum('financial_commitment');
                @endphp
                @if($totalCommitment > 0)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Total Commitment</span>
                    <span class="text-lg font-semibold text-slate-900">GHS {{ number_format($totalCommitment, 2) }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
