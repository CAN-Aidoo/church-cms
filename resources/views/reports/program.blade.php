@extends('layouts.app')

@section('title', 'Program Reports')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Program Reports</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('reports.index') }}">Reports</a>
            <span>/</span>
            <span>Program Reports</span>
        </nav>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.program.performance') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="draft" {{ ($filters['status'] ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ ($filters['status'] ?? '') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="ongoing" {{ ($filters['status'] ?? '') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ ($filters['status'] ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div>
                <label for="category" class="form-label">Category</label>
                <select id="category" name="category" class="form-select">
                    <option value="">All Categories</option>
                    <option value="worship" {{ ($filters['category'] ?? '') === 'worship' ? 'selected' : '' }}>Worship</option>
                    <option value="outreach" {{ ($filters['category'] ?? '') === 'outreach' ? 'selected' : '' }}>Outreach</option>
                    <option value="training" {{ ($filters['category'] ?? '') === 'training' ? 'selected' : '' }}>Training</option>
                    <option value="social" {{ ($filters['category'] ?? '') === 'social' ? 'selected' : '' }}>Social</option>
                    <option value="youth" {{ ($filters['category'] ?? '') === 'youth' ? 'selected' : '' }}>Youth</option>
                    <option value="children" {{ ($filters['category'] ?? '') === 'children' ? 'selected' : '' }}>Children</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <div class="card-body text-center">
            <p class="text-sm text-gray-600 mb-2">Total Programs</p>
            <p class="text-3xl font-bold text-blue-600">{{ $data['total_programs'] ?? 0 }}</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body text-center">
            <p class="text-sm text-gray-600 mb-2">Total Participants</p>
            <p class="text-3xl font-bold text-green-600">{{ $data['total_participants'] ?? 0 }}</p>
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
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @foreach($data['by_status'] as $status => $count)
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
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

<!-- By Category -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">By Category</h3>
    </div>
    <div class="card-body">
        @if(!empty($data['by_category']))
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($data['by_category'] as $category => $count)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 capitalize">{{ $category }}</p>
                        <p class="text-2xl font-bold">{{ $count }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No category data available.</p>
        @endif
    </div>
</div>

<!-- Programs List -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Programs ({{ count($data['programs'] ?? []) }})</h3>
    </div>
    <div class="card-body p-0">
        @if(!empty($data['programs']) && count($data['programs']) > 0)
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Program Name</th>
                            <th>Category</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th class="text-right">Participants</th>
                            <th class="text-right">Sessions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['programs'] as $program)
                            <tr>
                                <td>
                                    <a href="{{ route('programs.show', $program->id) }}" class="text-blue-600 hover:underline">
                                        {{ $program->name }}
                                    </a>
                                </td>
                                <td class="capitalize">{{ $program->category ?? 'N/A' }}</td>
                                <td>{{ $program->start_date ? \Carbon\Carbon::parse($program->start_date)->format('M d, Y') : 'N/A' }}</td>
                                <td>{{ $program->end_date ? \Carbon\Carbon::parse($program->end_date)->format('M d, Y') : 'N/A' }}</td>
                                <td>
                                    <span class="badge
                                        @if($program->status === 'ongoing') badge-primary
                                        @elseif($program->status === 'completed') badge-success
                                        @elseif($program->status === 'cancelled') badge-danger
                                        @else badge-secondary
                                        @endif">
                                        {{ ucfirst($program->status) }}
                                    </span>
                                </td>
                                <td class="text-right">{{ $program->registrations->count() ?? 0 }}</td>
                                <td class="text-right">{{ $program->sessions->count() ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No programs found matching the selected filters.</p>
        @endif
    </div>
</div>
@endsection
