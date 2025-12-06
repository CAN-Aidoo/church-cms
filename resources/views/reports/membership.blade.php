@extends('layouts.app')

@section('title', 'Membership Reports')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Membership Reports</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('reports.index') }}">Reports</a>
            <span>/</span>
            <span>Membership Reports</span>
        </nav>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.membership.roster') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="suspended" {{ ($filters['status'] ?? '') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
            <div>
                <label for="date_from" class="form-label">Joined From</label>
                <input type="date" id="date_from" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="form-input">
            </div>
            <div>
                <label for="date_to" class="form-label">Joined To</label>
                <input type="date" id="date_to" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="form-input">
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Card -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">Summary</h3>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-2">Total Members</p>
                <p class="text-3xl font-bold text-blue-600">{{ $data['total_members'] ?? 0 }}</p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-2">Male</p>
                <p class="text-2xl font-semibold">{{ $data['by_gender']['male'] ?? 0 }}</p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-2">Female</p>
                <p class="text-2xl font-semibold">{{ $data['by_gender']['female'] ?? 0 }}</p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-2">Other</p>
                <p class="text-2xl font-semibold">{{ $data['by_gender']['other'] ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<!-- By Status -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">By Status</h3>
    </div>
    <div class="card-body">
        @if(!empty($data['by_status']))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($data['by_status'] as $status => $count)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 capitalize">{{ $status }}</p>
                        <p class="text-2xl font-bold">{{ $count }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No status data available.</p>
        @endif
    </div>
</div>

<!-- By Marital Status -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">By Marital Status</h3>
    </div>
    <div class="card-body">
        @if(!empty($data['by_marital_status']))
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach($data['by_marital_status'] as $status => $count)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $status) }}</p>
                        <p class="text-2xl font-bold">{{ $count }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No marital status data available.</p>
        @endif
    </div>
</div>

<!-- Members List -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Members List ({{ count($data['members'] ?? []) }})</h3>
    </div>
    <div class="card-body p-0">
        @if(!empty($data['members']) && count($data['members']) > 0)
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Marital Status</th>
                            <th>Joined Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['members'] as $member)
                            <tr>
                                <td>
                                    <a href="{{ route('members.show', $member->id) }}" class="text-blue-600 hover:underline">
                                        {{ $member->first_name }} {{ $member->last_name }}
                                    </a>
                                </td>
                                <td>{{ $member->email ?? 'N/A' }}</td>
                                <td>{{ $member->phone ?? 'N/A' }}</td>
                                <td class="capitalize">{{ $member->gender ?? 'N/A' }}</td>
                                <td class="capitalize">{{ str_replace('_', ' ', $member->marital_status ?? 'N/A') }}</td>
                                <td>{{ $member->join_date ? \Carbon\Carbon::parse($member->join_date)->format('M d, Y') : 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $member->member_status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                        {{ ucfirst($member->member_status ?? 'unknown') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No members found matching the selected filters.</p>
        @endif
    </div>
</div>
@endsection
