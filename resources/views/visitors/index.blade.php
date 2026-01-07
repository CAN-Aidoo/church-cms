@extends('layouts.app')

@section('title', 'Visitors')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Visitor Management</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Visitors</span>
        </nav>
    </div>
    <div class="flex items-center gap-3 flex-wrap">
        <a href="{{ route('visitors.reports') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Reports
        </a>
        <a href="{{ route('visitors.eligible') }}" class="btn bg-amber-500 border-amber-600 text-white hover:bg-amber-600 hover:border-amber-700 shadow-md shadow-amber-500/20">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Eligible ({{ $statistics['eligible_for_conversion'] ?? 0 }})
        </a>
        <a href="{{ route('visitors.create') }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Register Visitor
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border-l-4 border-l-primary-500 bg-gradient-to-br from-white to-primary-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Visitors</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $statistics['total_visitors'] }}</h3>
            </div>
            <div class="p-3 bg-primary-100/50 rounded-xl text-primary-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-emerald-500 bg-gradient-to-br from-white to-emerald-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Visitors</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $statistics['active_visitors'] }}</h3>
            </div>
            <div class="p-3 bg-emerald-100/50 rounded-xl text-emerald-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-amber-500 bg-gradient-to-br from-white to-amber-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Eligible for Conversion</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $statistics['eligible_for_conversion'] }}</h3>
            </div>
            <div class="p-3 bg-amber-100/50 rounded-xl text-amber-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="card p-6 border-l-4 border-l-purple-500 bg-gradient-to-br from-white to-purple-50/20 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Conversion Rate</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ $statistics['conversion_rate'] }}%</h3>
            </div>
            <div class="p-3 bg-purple-100/50 rounded-xl text-purple-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card border border-slate-100 mb-8" x-data="{ showFilters: false }">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-base">Filters</h3>
        <button @click="showFilters = !showFilters" class="text-sm font-medium text-primary-600 hover:text-primary-700 flex items-center gap-1 transition-colors">
            <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': showFilters}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
        </button>
    </div>
    <div x-show="showFilters" x-transition.opacity.duration.200ms class="p-6 border-t border-slate-100 bg-white">
        <form method="GET" action="{{ route('visitors.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div>
                <label for="date_from" class="form-label mb-1.5 block font-medium text-sm text-slate-700">From Date</label>
                <input type="date" id="date_from" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
            </div>
            <div>
                <label for="date_to" class="form-label mb-1.5 block font-medium text-sm text-slate-700">To Date</label>
                <input type="date" id="date_to" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
            </div>
            <div>
                <label for="status" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Status</label>
                <select id="status" name="status" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">All Statuses</option>
                    <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="converted" {{ ($filters['status'] ?? '') === 'converted' ? 'selected' : '' }}>Converted</option>
                </select>
            </div>
            <div>
                <label for="converted" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Converted</label>
                <select id="converted" name="converted" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">All</option>
                    <option value="yes" {{ ($filters['converted'] ?? '') === 'yes' ? 'selected' : '' }}>Yes</option>
                    <option value="no" {{ ($filters['converted'] ?? '') === 'no' ? 'selected' : '' }}>No</option>
                </select>
            </div>
            <div class="md:col-span-2 lg:col-span-4 flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-grow">
                    <label for="search" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Name, email, phone..." class="form-input w-full pl-10 border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('visitors.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">Clear</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Visitors Table -->
<div class="card border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-base">Visitor List</h3>
        <span class="text-xs font-medium text-slate-500 bg-white px-2.5 py-1 rounded-full border border-slate-200 shadow-sm">{{ $visitors->total() }} total visitors</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Name</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Contact</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">First Visit</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Last Visit</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Visits</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Referral Source</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Status</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 bg-white">
                @forelse($visitors as $visitor)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-900">{{ $visitor->first_name }} {{ $visitor->last_name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-slate-600 mb-0.5">{{ $visitor->email ?? '-' }}</div>
                        <div class="text-xs text-slate-500 font-mono">{{ $visitor->phone }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $visitor->first_visit_date?->format('M d, Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $visitor->last_visit_date?->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $visitor->visit_count >= 5 ? 'bg-indigo-50 text-indigo-700 ring-indigo-600/20' : 'bg-slate-100 text-slate-700 ring-slate-600/20' }}">
                            {{ $visitor->visit_count }} {{ Str::plural('visit', $visitor->visit_count) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-700 capitalize">{{ str_replace('_', ' ', $visitor->referral_source ?? '-') }}</td>
                    <td class="px-6 py-4">
                        @if($visitor->status === 'active')
                        <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Active</span>
                        @elseif($visitor->status === 'converted')
                        <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-600/20">Converted</span>
                        @else
                        <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('visitors.show', $visitor) }}" class="text-slate-400 hover:text-primary-600 transition-colors" title="View Details">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            @if($visitor->visit_count >= 5 && !$visitor->converted_member_id)
                            <a href="{{ route('visitors.convert.form', $visitor) }}" class="text-amber-500 hover:text-amber-700 transition-colors" title="Convert to Member">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-12">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-slate-900 mb-1">No Visitors Found</h3>
                            <p class="text-slate-500">Get started by registering a new visitor.</p>
                            <a href="{{ route('visitors.create') }}" class="btn btn-primary mt-4">Register Visitor</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($visitors->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
        {{ $visitors->links() }}
    </div>
    @endif
</div>
@endsection
