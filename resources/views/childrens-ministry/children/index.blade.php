@extends('layouts.app')

@section('title', 'Children Directory')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Children Directory</h1>
         <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('childrens-ministry.index') }}" class="hover:text-primary-600 transition-colors">Children's Ministry</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Registry</span>
        </nav>
    </div>
    <div class="flex items-center gap-3">
         {{-- Add Child button would go here if functionality existed directly --}}
    </div>
</div>

<!-- Filters -->
<div class="card border border-slate-100 shadow-sm mb-6">
    <div class="p-6">
        <form method="GET" action="{{ route('childrens-ministry.children') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label for="search" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search by name..." class="form-input w-full pl-10 border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                </div>
            </div>
            <div>
                <label for="age_group" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Age Group</label>
                <select name="age_group" id="age_group" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    <option value="">All Groups</option>
                    <option value="nursery" {{ request('age_group') == 'nursery' ? 'selected' : '' }}>Nursery (0-2)</option>
                    <option value="toddlers" {{ request('age_group') == 'toddlers' ? 'selected' : '' }}>Toddlers (3-5)</option>
                    <option value="primary" {{ request('age_group') == 'primary' ? 'selected' : '' }}>Primary (6-9)</option>
                    <option value="juniors" {{ request('age_group') == 'juniors' ? 'selected' : '' }}>Juniors (10-12)</option>
                    <option value="teens" {{ request('age_group') == 'teens' ? 'selected' : '' }}>Teens (13+)</option>
                </select>
            </div>
            <div>
                <label for="birthday_month" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Birthday Month</label>
                <select name="birthday_month" id="birthday_month" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    <option value="">All Months</option>
                    @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}" {{ request('birthday_month') == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 10)) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary w-full justify-center shadow-lg shadow-primary-500/30">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Apply Filters
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Directory Table -->
<div class="card border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
        <h3 class="font-bold text-slate-800 text-base">Registered Children</h3>
        <span class="bg-slate-100 text-slate-600 text-xs font-bold px-2.5 py-0.5 rounded-full">{{ $children instanceof \Illuminate\Pagination\LengthAwarePaginator ? $children->total() : $children->count() }} Records</span>
    </div>
    <div class="overflow-x-auto">
        <table class="table w-full">
            <thead class="bg-slate-50 border-b border-slate-100 text-xs uppercase text-slate-500 font-semibold">
                <tr>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Age / Birthday</th>
                    <th class="px-6 py-3 text-left">Grade</th>
                    <th class="px-6 py-3 text-left">Parent/Guardian</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($children as $child)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                             <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs border border-indigo-200">
                                    {{ substr($child->first_name, 0, 1) }}{{ substr($child->last_name, 0, 1) }}
                                </div>
                                <div class="font-medium text-slate-900">{{ $child->full_name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-slate-900">{{ $child->age }} yrs</div>
                            <div class="text-xs text-slate-500">{{ $child->date_of_birth ? $child->date_of_birth->format('M d, Y') : 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 whitespace-nowrap">
                            {{ $child->grade_level ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $child->family->family_name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                             <a href="{{ route('childrens-ministry.children.show', $child) }}" class="btn btn-sm btn-outline-primary">
                                View Profile
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <p class="text-slate-500 font-medium">No children found matching criteria</p>
                            <p class="text-slate-400 text-sm">Try adjusting filters or search term</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($children instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $children->links() }}
        </div>
    @endif
</div>
@endsection
