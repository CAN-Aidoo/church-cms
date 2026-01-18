@extends('layouts.app')

@section('title', $agreement->agreement_title)

@section('content')
<div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6 mb-8">
    <div>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-2">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('partnerships.index') }}" class="hover:text-primary-600 transition-colors">Partnerships</a>
            <span>/</span>
            <a href="{{ route('partnerships.agreements') }}" class="hover:text-primary-600 transition-colors">Agreements</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">{{ $agreement->agreement_title }}</span>
        </nav>

        <div class="flex items-center gap-3">
            <h1 class="text-3xl font-heading font-bold text-slate-900">{{ $agreement->agreement_title }}</h1>
            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                @if($agreement->status === 'active') bg-green-100 text-green-800
                @elseif($agreement->status === 'pending') bg-yellow-100 text-yellow-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ ucfirst($agreement->status) }}
            </span>
        </div>
    </div>

    <div class="flex flex-wrap gap-2">
        @if(in_array($agreement->status, ['draft', 'pending']))
        <a href="{{ route('partnerships.agreements.edit', $agreement) }}" class="btn btn-outline-primary">Edit</a>
        @endif

        <form action="{{ route('partnerships.agreements.destroy', $agreement) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this agreement?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Agreement Details</h2>
            </div>
            <div class="card-body">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Partner</dt>
                        <dd class="mt-1 text-sm text-slate-900">
                            <a href="{{ route('partnerships.partners.show', $agreement->partner) }}" class="text-primary-600 hover:text-primary-700">
                                {{ $agreement->partner->name }}
                            </a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Financial Commitment</dt>
                        <dd class="mt-1 text-sm text-slate-900">
                            GHS {{ number_format($agreement->financial_commitment ?? 0, 2) }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Start Date</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ \Carbon\Carbon::parse($agreement->start_date)->format('M d, Y') }}</dd>
                    </div>
                    @if($agreement->end_date)
                    <div>
                        <dt class="text-sm font-medium text-slate-500">End Date</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ \Carbon\Carbon::parse($agreement->end_date)->format('M d, Y') }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        @if($agreement->description)
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Description</h2>
            </div>
            <div class="card-body">
                <div class="prose max-w-none text-slate-700">
                    {!! nl2br(e($agreement->description)) !!}
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="space-y-6">
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Information</h2>
            </div>
            <div class="card-body space-y-4">
                <div>
                    <dt class="text-sm font-medium text-slate-500">Status</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($agreement->status === 'active') bg-green-100 text-green-800
                            @elseif($agreement->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($agreement->status) }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Created By</dt>
                    <dd class="mt-1 text-sm text-slate-900">
                        @if($agreement->createdBy)
                            {{ $agreement->createdBy->name }}
                        @else
                            <span class="text-slate-400">Unknown</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Created</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $agreement->created_at->format('M d, Y') }}</dd>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
