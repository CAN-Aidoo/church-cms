@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('equipment.index') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $equipment->name }}</h1>
                    <p class="text-gray-600">{{ $equipment->category }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                @can('update', $equipment)
                <a href="{{ route('equipment.edit', $equipment) }}" class="btn btn-secondary">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                @endcan
                @if($equipment->status !== 'retired')
                <a href="{{ route('equipment.maintenance.form', $equipment) }}" class="btn btn-primary">
                    <i class="fas fa-wrench mr-2"></i>Record Maintenance
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Status Card -->
            <div class="card">
                <div class="card-body">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Status</p>
                            <span class="badge badge-lg
                                @if($equipment->status === 'active') badge-success
                                @elseif($equipment->status === 'maintenance') badge-warning
                                @elseif($equipment->status === 'retired') badge-danger
                                @else badge-secondary
                                @endif">
                                {{ ucfirst($equipment->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Condition</p>
                            <span class="badge badge-lg
                                @if($equipment->condition === 'excellent') badge-success
                                @elseif($equipment->condition === 'good') badge-info
                                @elseif($equipment->condition === 'fair') badge-warning
                                @else badge-danger
                                @endif">
                                {{ ucfirst($equipment->condition) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Location</p>
                            <p class="font-semibold text-gray-800">{{ $equipment->location }}</p>
                        </div>
                        @if($equipment->assigned_to)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Assigned To</p>
                            <p class="font-semibold text-gray-800">{{ $equipment->assigned_to }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            @if($maintenanceDue)
            <div class="card bg-red-50 border-red-200">
                <div class="card-body">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-red-600 text-2xl mt-1"></i>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-red-800 mb-1">Maintenance Overdue</h3>
                            <p class="text-red-700 text-sm">
                                This equipment was scheduled for maintenance on {{ $equipment->next_service_date->format('M d, Y') }}.
                                Please schedule maintenance as soon as possible.
                            </p>
                            <a href="{{ route('equipment.maintenance.form', $equipment) }}" class="btn btn-danger btn-sm mt-3">
                                <i class="fas fa-wrench mr-2"></i>Record Maintenance Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($warrantyStatus === 'Active' && $warrantyDaysRemaining <= 90)
            <div class="card bg-yellow-50 border-yellow-200">
                <div class="card-body">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-shield-alt text-yellow-600 text-2xl mt-1"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-800 mb-1">Warranty Expiring Soon</h3>
                            <p class="text-yellow-700 text-sm">
                                Warranty expires in {{ $warrantyDaysRemaining }} days on {{ $equipment->warranty_expiry->format('M d, Y') }}.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Details Card -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Equipment Details</h2>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($equipment->serial_number)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Serial Number</p>
                            <p class="font-medium text-gray-800">{{ $equipment->serial_number }}</p>
                        </div>
                        @endif

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Purchase Date</p>
                            <p class="font-medium text-gray-800">{{ $equipment->purchase_date->format('M d, Y') }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Age</p>
                            <p class="font-medium text-gray-800">{{ $equipment->purchase_date->diffForHumans(null, true) }}</p>
                        </div>

                        @if($equipment->warranty_expiry)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Warranty Status</p>
                            <p class="font-medium
                                @if($warrantyStatus === 'Active') text-green-600
                                @else text-red-600
                                @endif">
                                {{ $warrantyStatus }}
                                @if($warrantyStatus === 'Active')
                                ({{ $warrantyDaysRemaining }} days remaining)
                                @endif
                            </p>
                        </div>
                        @endif

                        @if($equipment->addedBy)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Added By</p>
                            <p class="font-medium text-gray-800">{{ $equipment->addedBy->full_name }}</p>
                        </div>
                        @endif

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Added On</p>
                            <p class="font-medium text-gray-800">{{ $equipment->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    @if($equipment->description)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-2">Description</p>
                        <p class="text-gray-800">{{ $equipment->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Maintenance History -->
            @if($equipment->maintenance_notes)
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Maintenance History</h2>
                </div>
                <div class="card-body">
                    <div class="space-y-3">
                        @foreach(array_reverse(explode("\n", $equipment->maintenance_notes)) as $note)
                        @if(trim($note))
                        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-wrench text-blue-600 mt-1"></i>
                            <p class="text-sm text-gray-700">{{ $note }}</p>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar Column -->
        <div class="space-y-6">
            <!-- Financial Info Card -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Financial Information</h2>
                </div>
                <div class="card-body space-y-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Purchase Price</p>
                        <p class="text-2xl font-bold text-gray-800">
                            GHS {{ number_format($equipment->purchase_price, 2) }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-1">Estimated Current Value</p>
                        <p class="text-xl font-semibold text-blue-600">
                            GHS {{ number_format($currentValue, 2) }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Based on 15% annual depreciation</p>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-1">Total Depreciation</p>
                        <p class="text-lg font-medium text-red-600">
                            GHS {{ number_format($totalDepreciation, 2) }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ number_format(($totalDepreciation / $equipment->purchase_price) * 100, 1) }}% of original value
                        </p>
                    </div>
                </div>
            </div>

            <!-- Maintenance Schedule Card -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Maintenance Schedule</h2>
                </div>
                <div class="card-body space-y-4">
                    @if($equipment->last_service_date)
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Last Service</p>
                        <p class="font-medium text-gray-800">
                            {{ $equipment->last_service_date->format('M d, Y') }}
                        </p>
                        <p class="text-xs text-gray-500">{{ $equipment->last_service_date->diffForHumans() }}</p>
                    </div>
                    @else
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Last Service</p>
                        <p class="font-medium text-gray-500">No service recorded</p>
                    </div>
                    @endif

                    @if($equipment->next_service_date)
                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-1">Next Service Due</p>
                        <p class="font-medium
                            @if($equipment->next_service_date->isPast()) text-red-600
                            @elseif($equipment->next_service_date->diffInDays(now()) <= 7) text-yellow-600
                            @else text-gray-800
                            @endif">
                            {{ $equipment->next_service_date->format('M d, Y') }}
                        </p>
                        <p class="text-xs text-gray-500">
                            @if($equipment->next_service_date->isPast())
                            Overdue by {{ $equipment->next_service_date->diffForHumans(null, true) }}
                            @else
                            {{ $equipment->next_service_date->diffForHumans() }}
                            @endif
                        </p>
                    </div>
                    @else
                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-1">Next Service Due</p>
                        <p class="font-medium text-gray-500">Not scheduled</p>
                    </div>
                    @endif

                    @if($equipment->status !== 'retired')
                    <div class="pt-4 border-t border-gray-200">
                        <a href="{{ route('equipment.maintenance.form', $equipment) }}" class="btn btn-primary w-full">
                            <i class="fas fa-wrench mr-2"></i>Record Maintenance
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            @can('delete', $equipment)
            <div class="card border-red-200">
                <div class="card-header bg-red-50">
                    <h2 class="text-xl font-semibold text-red-800">Danger Zone</h2>
                </div>
                <div class="card-body">
                    <p class="text-sm text-gray-600 mb-4">
                        Permanently delete this equipment record. This action cannot be undone.
                    </p>
                    <form method="POST" action="{{ route('equipment.destroy', $equipment) }}" onsubmit="return confirm('Are you sure you want to delete this equipment? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-full">
                            <i class="fas fa-trash mr-2"></i>Delete Equipment
                        </button>
                    </form>
                </div>
            </div>
            @endcan
        </div>
    </div>
</div>
@endsection
