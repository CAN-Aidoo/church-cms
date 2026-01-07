@extends('layouts.app')

@section('title', 'Manage Testimonies')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <div class="flex items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Testimonies</h1>
            <p class="text-slate-600">Review and manage answered prayer testimonies.</p>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('prayer.testimonies-wall') }}" class="px-4 py-2 bg-white text-slate-700 border border-slate-300 rounded-lg hover:bg-slate-50 transition font-medium text-sm shadow-sm">
                View Public Wall
            </a>
            <a href="{{ route('prayer.index') }}" class="px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-900 transition font-medium text-sm shadow-sm">
                Prayer Requests
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border border-slate-100 shadow-sm mb-6">
        <div class="p-4">
            <form action="{{ route('prayer.testimonies') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1 w-full">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search details or name..." class="form-input w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
                
                <div class="w-full md:w-48">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Status</label>
                    <select name="is_approved" class="form-select w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="">All Statuses</option>
                        <option value="1" {{ request('is_approved') === '1' ? 'selected' : '' }}>Approved</option>
                        <option value="0" {{ request('is_approved') === '0' ? 'selected' : '' }}>Pending Approval</option>
                    </select>
                </div>

                <div class="w-full md:w-48">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Privacy</label>
                    <select name="share_publicly" class="form-select w-full rounded-lg border-slate-200 text-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="">All Privacy</option>
                        <option value="1" {{ request('share_publicly') === '1' ? 'selected' : '' }}>Public</option>
                        <option value="0" {{ request('share_publicly') === '0' ? 'selected' : '' }}>Private</option>
                    </select>
                </div>

                <button type="submit" class="px-5 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition font-medium text-sm shadow-sm">
                    Filter
                </button>
            </form>
        </div>
    </div>

    <div class="card border border-slate-100 shadow-sm overflow-hidden">
        @if($testimonies->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                        <th class="px-6 py-4">Testimony Details</th>
                        <th class="px-6 py-4">Request</th>
                        <th class="px-6 py-4">Member</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($testimonies as $testimony)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <h4 class="font-bold text-slate-900 text-sm mb-1">{{ Str::limit($testimony->title, 40) }}</h4>
                            <p class="text-xs text-slate-500 line-clamp-2 max-w-xs">{{ $testimony->testimony }}</p>
                        </td>
                        <td class="px-6 py-4">
                             @if($testimony->prayerRequest)
                                <a href="{{ route('prayer.show', $testimony->prayerRequest) }}" class="text-xs font-medium text-primary-600 hover:text-primary-700 hover:underline">
                                    View Request
                                </a>
                            @else
                                <span class="text-xs text-slate-400 italic">No linked request</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-slate-700">{{ $testimony->member->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wide w-fit
                                    {{ $testimony->is_approved ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $testimony->is_approved ? 'Approved' : 'Pending' }}
                                </span>
                                <span class="text-[10px] text-slate-500">
                                    {{ $testimony->share_publicly ? 'Public' : 'Private' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if(!$testimony->is_approved)
                            <form action="{{ route('prayer.approve-testimony', $testimony) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded hover:bg-emerald-100 transition text-xs font-bold">
                                    Approve
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $testimonies->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <p class="text-slate-500 font-medium">No testimonies found.</p>
        </div>
        @endif
    </div>
</div>
@endsection
