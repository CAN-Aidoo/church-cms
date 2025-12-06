@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Shepherd Analytics</h1>
            <p class="text-gray-600 mt-1">Performance metrics and insights (Last 90 days)</p>
        </div>
        <a href="{{ route('shepherds.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to Shepherds
        </a>
    </div>

    <!-- Summary Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-users text-blue-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-blue-600">{{ $stats['active'] }}</p>
                <p class="text-sm text-gray-600">Active Shepherds</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-user-friends text-green-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-green-600">{{ $stats['total_flock_members'] }}</p>
                <p class="text-sm text-gray-600">Total in Flocks</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-chart-line text-gold-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-gold-600">{{ number_format($stats['average_flock_size'], 1) }}</p>
                <p class="text-sm text-gray-600">Avg. Flock Size</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-red-600">{{ $stats['shepherds_at_capacity'] }}</p>
                <p class="text-sm text-gray-600">At Capacity</p>
            </div>
        </div>
    </div>

    <!-- Shepherds Needing Attention -->
    @if($needingAttention->count() > 0)
    <div class="card border-yellow-200 bg-yellow-50 mb-6">
        <div class="card-header bg-yellow-100">
            <h2 class="text-xl font-semibold text-yellow-800">
                <i class="fas fa-exclamation-triangle mr-2"></i>Shepherds Needing Attention ({{ $needingAttention->count() }})
            </h2>
        </div>
        <div class="card-body">
            <div class="space-y-3">
                @foreach($needingAttention as $shepherd)
                <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-yellow-200">
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">{{ $shepherd->flock_name }}</p>
                        <p class="text-sm text-gray-600">Shepherd: {{ $shepherd->full_name }}</p>
                        <p class="text-xs text-yellow-700 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Low activity in the last 30 days
                        </p>
                    </div>
                    <a href="{{ route('shepherds.show', $shepherd) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-eye mr-1"></i>View
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Shepherd Performance Table -->
    <div class="card">
        <div class="card-header">
            <h2 class="text-xl font-semibold">Shepherd Performance (Last 90 Days)</h2>
        </div>
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Shepherd</th>
                            <th>Flock Size</th>
                            <th>Capacity</th>
                            <th>Visitations</th>
                            <th>Visits/Member</th>
                            <th>Meetings</th>
                            <th>Avg. Attendance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shepherds as $shepherd)
                        <tr>
                            <td>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $shepherd->flock_name }}</p>
                                    <p class="text-sm text-gray-600">{{ $shepherd->full_name }}</p>
                                </div>
                            </td>
                            <td>
                                <span class="font-semibold">{{ $shepherd->current_flock_size }}</span>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="w-16 bg-gray-200 rounded-full h-2">
                                        <div class="
                                            @if($shepherd->capacity_percentage >= 100) bg-red-500
                                            @elseif($shepherd->capacity_percentage >= 80) bg-yellow-500
                                            @else bg-green-500
                                            @endif
                                            h-2 rounded-full"
                                             style="width: {{ min($shepherd->capacity_percentage, 100) }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600">{{ number_format($shepherd->capacity_percentage, 0) }}%</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $shepherd->performance['visitations'] }}</span>
                            </td>
                            <td>
                                <span class="font-medium
                                    @if($shepherd->performance['visitations_per_member'] >= 1) text-green-600
                                    @elseif($shepherd->performance['visitations_per_member'] >= 0.5) text-yellow-600
                                    @else text-red-600
                                    @endif">
                                    {{ $shepherd->performance['visitations_per_member'] }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-success">{{ $shepherd->performance['meetings'] }}</span>
                            </td>
                            <td>
                                <span class="font-medium text-gray-700">
                                    {{ $shepherd->performance['average_meeting_attendance'] }}
                                </span>
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('shepherds.show', $shepherd) }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('shepherds.manage-flock', $shepherd) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-users"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Color code performance metrics
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const visitsPerMember = parseFloat(row.querySelector('td:nth-child(5) span').textContent);
            const cell = row.querySelector('td:nth-child(5) span');

            if (visitsPerMember >= 1) {
                cell.classList.add('text-green-600');
            } else if (visitsPerMember >= 0.5) {
                cell.classList.add('text-yellow-600');
            } else {
                cell.classList.add('text-red-600');
            }
        });
    });
</script>
@endpush
@endsection
