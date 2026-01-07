@extends('layouts.app')

@section('title', 'Members')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Members</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Members</span>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('members.statistics') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 font-medium text-sm hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Statistics
        </a>
        <a href="{{ route('members.create') }}" class="btn btn-primary flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Member
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-5 border border-slate-100 relative overflow-hidden group hover:shadow-card-hover transition-all">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Members</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ number_format($statistics['total']) }}</h3>
            </div>
            <div class="p-3 bg-blue-50 rounded-xl group-hover:bg-blue-100 transition-colors">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>
    </div>

    <div class="card p-5 border border-slate-100 relative overflow-hidden group hover:shadow-card-hover transition-all">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Members</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ number_format($statistics['active']) }}</h3>
            </div>
            <div class="p-3 bg-emerald-50 rounded-xl group-hover:bg-emerald-100 transition-colors">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    <div class="card p-5 border border-slate-100 relative overflow-hidden group hover:shadow-card-hover transition-all">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">New This Month</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ number_format($statistics['recent_joins']) }}</h3>
            </div>
            <div class="p-3 bg-amber-50 rounded-xl group-hover:bg-amber-100 transition-colors">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            </div>
        </div>
    </div>

    <div class="card p-5 border border-slate-100 relative overflow-hidden group hover:shadow-card-hover transition-all">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Inactive Members</p>
                <h3 class="text-3xl font-heading font-bold text-slate-900 mt-2">{{ number_format($statistics['inactive']) }}</h3>
            </div>
            <div class="p-3 bg-slate-100 rounded-xl group-hover:bg-slate-200 transition-colors">
                <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-8 border border-slate-100" x-data="{ showFilters: false }">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <h3 class="font-bold text-slate-800 text-sm">Search & Filters</h3>
        <button @click="showFilters = !showFilters" class="text-xs text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1.5 px-2 py-1 rounded-md hover:bg-slate-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
        </button>
    </div>
    <div class="p-6">
        <form method="GET" action="{{ route('members.index') }}">
            <!-- Search Bar (Always Visible) -->
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                           placeholder="Search by name, email, phone, or member ID..."
                           class="form-input w-full pl-10">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>
                    @if(count(array_filter($filters ?? [])) > 0)
                    <a href="{{ route('members.index') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 font-medium text-sm hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear
                    </a>
                    @endif
                </div>
            </div>

            <!-- Advanced Filters (Collapsible) -->
            <div x-show="showFilters" x-collapse style="display: none;" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pt-6 mt-6 border-t border-slate-100">
                <div>
                    <label class="form-label mb-1.5">Status</label>
                    <div class="relative">
                        <select name="status" class="form-select w-full">
                            <option value="">All Statuses</option>
                            <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="suspended" {{ ($filters['status'] ?? '') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="form-label mb-1.5">Gender</label>
                    <select name="gender" class="form-select w-full">
                        <option value="">All Genders</option>
                        <option value="male" {{ ($filters['gender'] ?? '') === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ ($filters['gender'] ?? '') === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ ($filters['gender'] ?? '') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div>
                    <label class="form-label mb-1.5">Marital Status</label>
                    <select name="marital_status" class="form-select w-full">
                        <option value="">All Statuses</option>
                        <option value="single" {{ ($filters['marital_status'] ?? '') === 'single' ? 'selected' : '' }}>Single</option>
                        <option value="married" {{ ($filters['marital_status'] ?? '') === 'married' ? 'selected' : '' }}>Married</option>
                        <option value="divorced" {{ ($filters['marital_status'] ?? '') === 'divorced' ? 'selected' : '' }}>Divorced</option>
                        <option value="widowed" {{ ($filters['marital_status'] ?? '') === 'widowed' ? 'selected' : '' }}>Widowed</option>
                    </select>
                </div>

                <div>
                    <label class="form-label mb-1.5">Sort By</label>
                    <select name="sort_by" class="form-select w-full">
                        <option value="first_name" {{ ($filters['sort_by'] ?? '') === 'first_name' ? 'selected' : '' }}>First Name</option>
                        <option value="last_name" {{ ($filters['sort_by'] ?? '') === 'last_name' ? 'selected' : '' }}>Last Name</option>
                        <option value="join_date" {{ ($filters['sort_by'] ?? '') === 'join_date' ? 'selected' : '' }}>Join Date</option>
                        <option value="created_at" {{ ($filters['sort_by'] ?? '') === 'created_at' ? 'selected' : '' }}>Registration Date</option>
                    </select>
                </div>

                <div>
                    <label class="form-label mb-1.5">Min Age</label>
                    <input type="number" name="age_min" value="{{ $filters['age_min'] ?? '' }}"
                           placeholder="Min age" class="form-input w-full" min="0" max="120">
                </div>

                <div>
                    <label class="form-label mb-1.5">Max Age</label>
                    <input type="number" name="age_max" value="{{ $filters['age_max'] ?? '' }}"
                           placeholder="Max age" class="form-input w-full" min="0" max="120">
                </div>

                <div>
                    <label class="form-label mb-1.5">Join Date From</label>
                    <input type="date" name="join_date_from" value="{{ $filters['join_date_from'] ?? '' }}"
                           class="form-input w-full">
                </div>

                <div>
                    <label class="form-label mb-1.5">Join Date To</label>
                    <input type="date" name="join_date_to" value="{{ $filters['join_date_to'] ?? '' }}"
                           class="form-input w-full">
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Members Table -->
<!-- Members Table -->
<div class="card overflow-hidden border border-slate-100">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <h3 class="font-bold text-slate-800 text-sm">Member Directory ({{ $members->total() }})</h3>
        <div class="flex gap-2">
            <form method="GET" action="{{ route('members.export') }}" class="inline">
                @foreach($filters ?? [] as $key => $value)
                    @if($value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <button type="submit" class="text-xs text-slate-600 hover:text-primary-600 font-medium flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-all shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export CSV
                </button>
            </form>
        </div>
    </div>

    <div class="p-0">
        @if($members->count() > 0)
        <div class="overflow-x-auto">
            <form id="bulk-action-form" method="POST" action="{{ route('members.bulk-action') }}">
                @csrf
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="w-12 px-6 py-3 text-left">
                                <input type="checkbox" id="select-all" class="rounded border-slate-300 text-primary-600 focus:ring-primary-500 w-4 h-4">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Member ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Gender</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Age</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Join Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 bg-white">
                        @foreach($members as $member)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4">
                                <input type="checkbox" name="member_ids[]" value="{{ $member->id }}"
                                       class="rounded border-slate-300 text-primary-600 focus:ring-primary-500 w-4 h-4 member-checkbox">
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $member->member_id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    @if($member->photo_url)
                                    <img src="{{ Storage::url($member->photo_url) }}"
                                         alt="{{ $member->full_name }}"
                                         class="w-9 h-9 rounded-full object-cover ring-2 ring-white shadow-sm">
                                    @else
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center text-primary-700 font-bold text-xs ring-2 ring-white shadow-sm">
                                        {{ strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1)) }}
                                    </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('members.show', $member) }}"
                                           class="font-semibold text-slate-900 hover:text-primary-600 transition-colors block">
                                            {{ $member->full_name }}
                                        </a>
                                        @if($member->department)
                                        <div class="text-xs text-slate-500 mt-0.5">{{ $member->department }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <div class="text-slate-900 font-medium">{{ $member->phone }}</div>
                                    <div class="text-xs text-slate-500">{{ $member->email }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 capitalize">
                                {{ $member->gender }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $member->age ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $member->join_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'active' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                        'inactive' => 'bg-slate-100 text-slate-600 border-slate-200',
                                        'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                        'suspended' => 'bg-red-100 text-red-800 border-red-200',
                                    ];
                                    $statusClass = $statusClasses[$member->member_status] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                                @endphp
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full border {{ $statusClass }}">
                                    {{ ucfirst($member->member_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('members.show', $member) }}"
                                       class="p-1.5 text-slate-500 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('members.edit', $member) }}"
                                       class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>

        <!-- Bulk Actions -->
        <div class="p-4 bg-slate-50 border-t border-slate-100" x-data="{ selectedCount: 0 }" x-init="
            $watch('selectedCount', value => {
                document.getElementById('bulk-actions').classList.toggle('hidden', value === 0);
            });
            document.querySelectorAll('.member-checkbox').forEach(cb => {
                cb.addEventListener('change', () => {
                    selectedCount = document.querySelectorAll('.member-checkbox:checked').length;
                });
            });
            document.getElementById('select-all').addEventListener('change', function() {
                document.querySelectorAll('.member-checkbox').forEach(cb => cb.checked = this.checked);
                selectedCount = this.checked ? document.querySelectorAll('.member-checkbox').length : 0;
            });
        ">
            <div id="bulk-actions" class="hidden flex items-center justify-between">
                <div class="text-sm text-slate-600">
                    <span x-text="selectedCount" class="font-medium text-slate-900"></span> member(s) selected
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="submitBulkAction('activate')" class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 font-medium text-xs hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 transition-colors shadow-sm">
                        Activate
                    </button>
                    <button type="button" onclick="submitBulkAction('deactivate')" class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 font-medium text-xs hover:bg-slate-50 hover:border-slate-300 transition-colors shadow-sm">
                        Deactivate
                    </button>
                    <button type="button" onclick="submitBulkAction('suspend')" class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 font-medium text-xs hover:bg-amber-50 hover:text-amber-700 hover:border-amber-200 transition-colors shadow-sm">
                        Suspend
                    </button>
                    @if(auth()->user()->hasAnyRole(['admin', 'pastor']))
                    <button type="button" onclick="submitBulkAction('delete')" class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-red-600 font-medium text-xs hover:bg-red-50 hover:border-red-200 transition-colors shadow-sm">
                        Delete
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $members->links() }}
        </div>
        @else
        <div class="p-12 text-center">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-2">No members found</h3>
            <p class="text-slate-500 mb-6">Try adjusting your search or filters, or add a new member.</p>
            <a href="{{ route('members.create') }}" class="btn btn-primary">
                Add Your First Member
            </a>
        </div>
        @endif
    </div>
</div>

<script>
function submitBulkAction(action) {
    const form = document.getElementById('bulk-action-form');
    const actionInput = document.createElement('input');
    actionInput.type = 'hidden';
    actionInput.name = 'action';
    actionInput.value = action;
    form.appendChild(actionInput);

    if (action === 'delete') {
        if (!confirm('Are you sure you want to delete the selected members? This action cannot be undone.')) {
            return;
        }
    }

    form.submit();
}
</script>
@endsection
