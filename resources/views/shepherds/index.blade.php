@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Shepherd Management</h1>
            <p class="text-gray-600 mt-1">Manage shepherds and their flocks</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('shepherds.analytics') }}" class="btn btn-secondary">
                <i class="fas fa-chart-bar mr-2"></i>Analytics
            </a>
            <form method="POST" action="{{ route('shepherds.auto-assign') }}" class="inline">
                @csrf
                <button type="submit" class="btn btn-secondary" onclick="return confirm('Auto-assign members without shepherds?')">
                    <i class="fas fa-magic mr-2"></i>Auto-Assign
                </button>
            </form>
            @can('create', App\Models\Shepherd::class)
            <a href="{{ route('shepherds.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>Appoint Shepherd
            </a>
            @endcan
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-users text-blue-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</p>
                <p class="text-sm text-gray-600">Total Shepherds</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-check-circle text-green-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-green-600">{{ $stats['active'] }}</p>
                <p class="text-sm text-gray-600">Active Shepherds</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-user-friends text-gold-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-gold-600">{{ number_format($stats['average_flock_size'], 1) }}</p>
                <p class="text-sm text-gray-600">Avg. Flock Size</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-users-cog text-purple-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-purple-600">{{ $stats['total_flock_members'] }}</p>
                <p class="text-sm text-gray-600">Total Members in Flocks</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-6">
        <div class="card-body">
            <form method="GET" action="{{ route('shepherds.index') }}" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text"
                           name="search"
                           id="search"
                           value="{{ request('search') }}"
                           placeholder="Flock name or shepherd name..."
                           class="form-input w-full">
                </div>

                <div class="w-48">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="form-select w-full">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter mr-1"></i>Filter
                    </button>
                    <a href="{{ route('shepherds.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo mr-1"></i>Reset
                    </a>
                    <a href="{{ route('shepherds.export', request()->query()) }}" class="btn btn-secondary">
                        <i class="fas fa-download mr-1"></i>Export
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Shepherds List -->
    @if($shepherds->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($shepherds as $shepherd)
        <div class="card hover:shadow-lg transition-shadow">
            <div class="card-body">
                <!-- Status Badge -->
                <div class="flex justify-between items-start mb-3">
                    <span class="badge
                        @if($shepherd->status === 'active') badge-success
                        @elseif($shepherd->status === 'on_leave') badge-warning
                        @else badge-secondary
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $shepherd->status)) }}
                    </span>
                    @if($shepherd->capacity_percentage >= 100)
                    <span class="badge badge-danger">At Capacity</span>
                    @elseif($shepherd->capacity_percentage >= 80)
                    <span class="badge badge-warning">Near Capacity</span>
                    @endif
                </div>

                <!-- Flock Name -->
                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $shepherd->flock_name }}</h3>

                <!-- Shepherd Name -->
                <p class="text-sm text-gray-600 mb-3">
                    <i class="fas fa-user w-5"></i>
                    <span>{{ $shepherd->full_name }}</span>
                </p>

                <!-- Flock Size -->
                <div class="mb-3">
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>Flock Size</span>
                        <span>{{ $shepherd->current_flock_size }} / {{ $shepherd->max_flock_size }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="
                            @if($shepherd->capacity_percentage >= 100) bg-red-500
                            @elseif($shepherd->capacity_percentage >= 80) bg-yellow-500
                            @else bg-green-500
                            @endif
                            h-2 rounded-full transition-all"
                             style="width: {{ min($shepherd->capacity_percentage, 100) }}%"></div>
                    </div>
                </div>

                <!-- Service Duration -->
                <div class="text-sm text-gray-600 mb-3">
                    <i class="fas fa-calendar w-5"></i>
                    <span>{{ $shepherd->years_of_service }} {{ $shepherd->years_of_service == 1 ? 'year' : 'years' }} of service</span>
                </div>

                <!-- Recent Activity -->
                <div class="flex gap-4 text-xs text-gray-600 mb-4">
                    <div>
                        <i class="fas fa-home text-blue-500"></i>
                        <span>{{ $shepherd->recent_visitations }} visits</span>
                    </div>
                    <div>
                        <i class="fas fa-users text-green-500"></i>
                        <span>{{ $shepherd->recent_meetings }} meetings</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-2 pt-4 border-t border-gray-200">
                    <a href="{{ route('shepherds.show', $shepherd) }}" class="btn btn-sm btn-secondary flex-1">
                        <i class="fas fa-eye mr-1"></i>View
                    </a>
                    <a href="{{ route('shepherds.manage-flock', $shepherd) }}" class="btn btn-sm btn-primary flex-1">
                        <i class="fas fa-users mr-1"></i>Flock
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $shepherds->links() }}
    </div>
    @else
    <div class="card">
        <div class="card-body text-center py-12">
            <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-600 text-lg">No shepherds found</p>
            @can('create', App\Models\Shepherd::class)
            <a href="{{ route('shepherds.create') }}" class="btn btn-primary mt-4">
                <i class="fas fa-plus mr-2"></i>Appoint First Shepherd
            </a>
            @endcan
        </div>
    </div>
    @endif
</div>
@endsection
