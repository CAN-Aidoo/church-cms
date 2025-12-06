@extends('layouts.app')

@section('title', 'Members')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Members</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>Members</span>
        </nav>
    </div>
    <div class="page-actions">
        <a href="{{ route('members.statistics') }}" class="btn btn-outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Statistics
        </a>
        <a href="{{ route('members.create') }}" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Member
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="stat-card stat-card-gradient-blue">
        <div class="stat-value">{{ number_format($statistics['total']) }}</div>
        <div class="stat-label">Total Members</div>
    </div>
    <div class="stat-card stat-card-gradient-green">
        <div class="stat-value">{{ number_format($statistics['active']) }}</div>
        <div class="stat-label">Active Members</div>
    </div>
    <div class="stat-card stat-card-gradient-gold">
        <div class="stat-value">{{ number_format($statistics['recent_joins']) }}</div>
        <div class="stat-label">New This Month</div>
    </div>
    <div class="stat-card bg-white text-gray-900 border border-gray-200">
        <div class="stat-value">{{ number_format($statistics['inactive']) }}</div>
        <div class="stat-label">Inactive Members</div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6" x-data="{ showFilters: false }">
    <div class="card-header flex items-center justify-between">
        <h3 class="card-title">Search & Filters</h3>
        <button @click="showFilters = !showFilters" class="btn btn-sm btn-outline">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
        </button>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('members.index') }}" class="space-y-4">
            <!-- Search Bar (Always Visible) -->
            <div class="flex gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                           placeholder="Search by name, email, phone, or member ID..."
                           class="form-input w-full">
                </div>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </button>
                @if(count(array_filter($filters ?? [])) > 0)
                <a href="{{ route('members.index') }}" class="btn btn-secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Clear
                </a>
                @endif
            </div>

            <!-- Advanced Filters (Collapsible) -->
            <div x-show="showFilters" x-collapse class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pt-4 border-t">
                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="suspended" {{ ($filters['status'] ?? '') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">All Genders</option>
                        <option value="male" {{ ($filters['gender'] ?? '') === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ ($filters['gender'] ?? '') === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ ($filters['gender'] ?? '') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Marital Status</label>
                    <select name="marital_status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="single" {{ ($filters['marital_status'] ?? '') === 'single' ? 'selected' : '' }}>Single</option>
                        <option value="married" {{ ($filters['marital_status'] ?? '') === 'married' ? 'selected' : '' }}>Married</option>
                        <option value="divorced" {{ ($filters['marital_status'] ?? '') === 'divorced' ? 'selected' : '' }}>Divorced</option>
                        <option value="widowed" {{ ($filters['marital_status'] ?? '') === 'widowed' ? 'selected' : '' }}>Widowed</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Sort By</label>
                    <select name="sort_by" class="form-select">
                        <option value="first_name" {{ ($filters['sort_by'] ?? '') === 'first_name' ? 'selected' : '' }}>First Name</option>
                        <option value="last_name" {{ ($filters['sort_by'] ?? '') === 'last_name' ? 'selected' : '' }}>Last Name</option>
                        <option value="join_date" {{ ($filters['sort_by'] ?? '') === 'join_date' ? 'selected' : '' }}>Join Date</option>
                        <option value="created_at" {{ ($filters['sort_by'] ?? '') === 'created_at' ? 'selected' : '' }}>Registration Date</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Min Age</label>
                    <input type="number" name="age_min" value="{{ $filters['age_min'] ?? '' }}"
                           placeholder="Min age" class="form-input" min="0" max="120">
                </div>

                <div>
                    <label class="form-label">Max Age</label>
                    <input type="number" name="age_max" value="{{ $filters['age_max'] ?? '' }}"
                           placeholder="Max age" class="form-input" min="0" max="120">
                </div>

                <div>
                    <label class="form-label">Join Date From</label>
                    <input type="date" name="join_date_from" value="{{ $filters['join_date_from'] ?? '' }}"
                           class="form-input">
                </div>

                <div>
                    <label class="form-label">Join Date To</label>
                    <input type="date" name="join_date_to" value="{{ $filters['join_date_to'] ?? '' }}"
                           class="form-input">
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Members Table -->
<div class="card">
    <div class="card-header flex items-center justify-between">
        <h3 class="card-title">Member Directory ({{ $members->total() }})</h3>
        <div class="flex gap-2">
            <form method="GET" action="{{ route('members.export') }}" class="inline">
                @foreach($filters ?? [] as $key => $value)
                    @if($value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <button type="submit" class="btn btn-sm btn-outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export CSV
                </button>
            </form>
        </div>
    </div>

    <div class="card-body p-0">
        @if($members->count() > 0)
        <div class="overflow-x-auto">
            <form id="bulk-action-form" method="POST" action="{{ route('members.bulk-action') }}">
                @csrf
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-12">
                                <input type="checkbox" id="select-all" class="form-checkbox">
                            </th>
                            <th>Member ID</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Join Date</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr>
                            <td>
                                <input type="checkbox" name="member_ids[]" value="{{ $member->id }}"
                                       class="form-checkbox member-checkbox">
                            </td>
                            <td class="font-mono text-sm">{{ $member->member_id }}</td>
                            <td>
                                <div class="flex items-center space-x-3">
                                    @if($member->photo_url)
                                    <img src="{{ Storage::url($member->photo_url) }}"
                                         alt="{{ $member->full_name }}"
                                         class="w-10 h-10 rounded-full object-cover">
                                    @else
                                    <div class="w-10 h-10 rounded-full bg-gradient-primary flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1)) }}
                                    </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('members.show', $member) }}"
                                           class="font-semibold text-primary-600 hover:text-primary-700">
                                            {{ $member->full_name }}
                                        </a>
                                        @if($member->department)
                                        <div class="text-xs text-gray-500">{{ $member->department }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">
                                    <div class="text-gray-900">{{ $member->phone }}</div>
                                    <div class="text-gray-500">{{ $member->email }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="capitalize">{{ $member->gender }}</span>
                            </td>
                            <td>{{ $member->age ?? 'N/A' }}</td>
                            <td>{{ $member->join_date->format('M d, Y') }}</td>
                            <td>
                                @php
                                    $statusColors = [
                                        'active' => 'badge-success',
                                        'inactive' => 'badge-secondary',
                                        'pending' => 'badge-warning',
                                        'suspended' => 'badge-danger',
                                    ];
                                @endphp
                                <span class="badge {{ $statusColors[$member->member_status] ?? 'badge-secondary' }}">
                                    {{ ucfirst($member->member_status) }}
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('members.show', $member) }}"
                                       class="btn-icon btn-icon-sm" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('members.edit', $member) }}"
                                       class="btn-icon btn-icon-sm text-gold-600" title="Edit">
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
        <div class="p-4 bg-gray-50 border-t" x-data="{ selectedCount: 0 }" x-init="
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
                <div class="text-sm text-gray-600">
                    <span x-text="selectedCount"></span> member(s) selected
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="submitBulkAction('activate')" class="btn btn-sm btn-outline">
                        Activate
                    </button>
                    <button type="button" onclick="submitBulkAction('deactivate')" class="btn btn-sm btn-outline">
                        Deactivate
                    </button>
                    <button type="button" onclick="submitBulkAction('suspend')" class="btn btn-sm btn-outline text-orange-600">
                        Suspend
                    </button>
                    @if(auth()->user()->hasAnyRole(['admin', 'pastor']))
                    <button type="button" onclick="submitBulkAction('delete')" class="btn btn-sm btn-danger">
                        Delete
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t">
            {{ $members->links() }}
        </div>
        @else
        <div class="p-12 text-center text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No members found</h3>
            <p class="mb-4">Try adjusting your search or filters, or add a new member.</p>
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
