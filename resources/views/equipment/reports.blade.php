@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Equipment Reports</h1>
            <p class="text-gray-600 mt-1">Comprehensive analytics and insights</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('equipment.maintenance') }}" class="btn btn-secondary">
                <i class="fas fa-wrench mr-2"></i>Maintenance
            </a>
            <a href="{{ route('equipment.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Back to Equipment
            </a>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-boxes text-blue-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-blue-600">{{ $totalEquipment }}</p>
                <p class="text-sm text-gray-600">Total Equipment</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-check-circle text-green-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-green-600">{{ $activeEquipment }}</p>
                <p class="text-sm text-gray-600">Active</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-wrench text-yellow-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-yellow-600">{{ $maintenanceEquipment }}</p>
                <p class="text-sm text-gray-600">In Maintenance</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-archive text-gray-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-gray-600">{{ $retiredEquipment }}</p>
                <p class="text-sm text-gray-600">Retired</p>
            </div>
        </div>
    </div>

    <!-- Financial Overview -->
    <div class="card mb-6">
        <div class="card-header">
            <h2 class="text-xl font-semibold">Financial Overview</h2>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-2">Total Original Value</p>
                    <p class="text-2xl font-bold text-blue-600">
                        GHS {{ number_format($depreciationReport['total_original_value'], 2) }}
                    </p>
                </div>

                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-2">Current Estimated Value</p>
                    <p class="text-2xl font-bold text-green-600">
                        GHS {{ number_format($depreciationReport['total_current_value'], 2) }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Based on 15% annual depreciation</p>
                </div>

                <div class="text-center p-4 bg-red-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-2">Total Depreciation</p>
                    <p class="text-2xl font-bold text-red-600">
                        GHS {{ number_format($depreciationReport['total_depreciation'], 2) }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ number_format(($depreciationReport['total_depreciation'] / max($depreciationReport['total_original_value'], 1)) * 100, 1) }}% of original value
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Equipment by Category -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Equipment Value by Category</h2>
            </div>
            <div class="card-body">
                <canvas id="categoryChart" height="300"></canvas>
            </div>
        </div>

        <!-- Condition Breakdown -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Equipment Condition</h2>
            </div>
            <div class="card-body">
                <canvas id="conditionChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Warranty Expiring Soon -->
    @if($warrantyExpiring->count() > 0)
    <div class="card mb-6">
        <div class="card-header flex justify-between items-center">
            <h2 class="text-xl font-semibold">Warranty Expiring Soon (Next 3 Months)</h2>
            <span class="badge badge-warning">{{ $warrantyExpiring->count() }} items</span>
        </div>
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Equipment</th>
                            <th>Category</th>
                            <th>Purchase Date</th>
                            <th>Warranty Expiry</th>
                            <th>Days Remaining</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($warrantyExpiring as $item)
                        <tr>
                            <td>
                                <a href="{{ route('equipment.show', $item) }}" class="text-blue-600 hover:underline font-medium">
                                    {{ $item->name }}
                                </a>
                            </td>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->purchase_date->format('M d, Y') }}</td>
                            <td>{{ $item->warranty_expiry->format('M d, Y') }}</td>
                            <td>
                                <span class="badge
                                    @if($item->warranty_expiry->diffInDays(now()) <= 30) badge-danger
                                    @else badge-warning
                                    @endif">
                                    {{ $item->warranty_expiry->diffInDays(now()) }} days
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('equipment.show', $item) }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Maintenance Schedule (Upcoming) -->
    @if($maintenanceSchedule->count() > 0)
    <div class="card mb-6">
        <div class="card-header flex justify-between items-center">
            <h2 class="text-xl font-semibold">Upcoming Maintenance Schedule</h2>
            <span class="badge badge-info">{{ $maintenanceSchedule->count() }} scheduled</span>
        </div>
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Equipment</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Last Service</th>
                            <th>Next Service</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($maintenanceSchedule->take(10) as $item)
                        <tr>
                            <td>
                                <a href="{{ route('equipment.show', $item) }}" class="text-blue-600 hover:underline font-medium">
                                    {{ $item->name }}
                                </a>
                            </td>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->location }}</td>
                            <td>
                                @if($item->last_service_date)
                                {{ $item->last_service_date->format('M d, Y') }}
                                @else
                                <span class="text-gray-400">Never</span>
                                @endif
                            </td>
                            <td>
                                <span class="
                                    @if($item->next_service_date->diffInDays(now()) <= 7) text-yellow-600 font-semibold
                                    @endif">
                                    {{ $item->next_service_date->format('M d, Y') }}
                                </span>
                                <p class="text-xs text-gray-500">{{ $item->next_service_date->diffForHumans() }}</p>
                            </td>
                            <td>
                                <span class="badge
                                    @if($item->status === 'active') badge-success
                                    @elseif($item->status === 'maintenance') badge-warning
                                    @else badge-secondary
                                    @endif">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('equipment.maintenance.form', $item) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-wrench mr-1"></i>Record
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($maintenanceSchedule->count() > 10)
            <div class="mt-4 text-center">
                <a href="{{ route('equipment.maintenance') }}" class="btn btn-secondary">
                    View All Maintenance Items ({{ $maintenanceSchedule->count() }})
                </a>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Equipment Requiring Immediate Attention -->
    @if($requireMaintenance->count() > 0)
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h2 class="text-xl font-semibold">Requires Immediate Attention</h2>
            <span class="badge badge-danger">{{ $requireMaintenance->count() }} items</span>
        </div>
        <div class="card-body">
            <div class="space-y-3">
                @foreach($requireMaintenance as $item)
                <div class="flex items-center justify-between p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                        <div>
                            <a href="{{ route('equipment.show', $item) }}" class="font-medium text-gray-800 hover:text-blue-600">
                                {{ $item->name }}
                            </a>
                            <p class="text-sm text-gray-600">
                                {{ $item->category }} • {{ $item->location }}
                            </p>
                            @if($item->next_service_date && $item->next_service_date->isPast())
                            <p class="text-xs text-red-600 mt-1">
                                Maintenance overdue by {{ $item->next_service_date->diffForHumans(null, true) }}
                            </p>
                            @elseif(!$item->last_service_date && $item->purchase_date->diffInYears(now()) >= 1)
                            <p class="text-xs text-red-600 mt-1">
                                Never serviced ({{ $item->purchase_date->diffForHumans(null, true) }} old)
                            </p>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('equipment.maintenance.form', $item) }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-wrench mr-1"></i>Record Maintenance
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Equipment by Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryData = @json($equipmentByCategory);

    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(categoryData),
            datasets: [{
                label: 'Total Value (GHS)',
                data: Object.values(categoryData),
                backgroundColor: 'rgba(37, 99, 235, 0.8)',
                borderColor: 'rgb(37, 99, 235)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'GHS ' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'GHS ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Condition Breakdown Chart
    const conditionCtx = document.getElementById('conditionChart').getContext('2d');
    const conditionData = @json($conditionBreakdown);

    const conditionColors = {
        'excellent': 'rgb(34, 197, 94)',
        'good': 'rgb(59, 130, 246)',
        'fair': 'rgb(234, 179, 8)',
        'poor': 'rgb(239, 68, 68)'
    };

    new Chart(conditionCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(conditionData).map(k => k.charAt(0).toUpperCase() + k.slice(1)),
            datasets: [{
                data: Object.values(conditionData),
                backgroundColor: Object.keys(conditionData).map(k => conditionColors[k]),
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection
