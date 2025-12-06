@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Equipment Maintenance</h1>
            <p class="text-gray-600 mt-1">Track and schedule equipment maintenance</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('equipment.reports') }}" class="btn btn-secondary">
                <i class="fas fa-chart-bar mr-2"></i>Reports
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
                <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-red-600">{{ $equipment->where(function($q) {
                    $q->whereNotNull('next_service_date')->where('next_service_date', '<', now());
                })->count() }}</p>
                <p class="text-sm text-gray-600">Overdue</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-clock text-yellow-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-yellow-600">{{ $equipment->where(function($q) {
                    $q->whereNotNull('next_service_date')
                      ->where('next_service_date', '>=', now())
                      ->where('next_service_date', '<=', now()->addDays(7));
                })->count() }}</p>
                <p class="text-sm text-gray-600">Due This Week</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-wrench text-blue-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-blue-600">{{ $equipment->where('status', 'maintenance')->count() }}</p>
                <p class="text-sm text-gray-600">In Maintenance</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-check-circle text-green-500 text-3xl mb-2"></i>
                <p class="text-3xl font-bold text-green-600">{{ $equipment->filter(function($item) {
                    return $item->status === 'active' &&
                           ($item->next_service_date === null || $item->next_service_date > now()->addDays(7));
                })->count() }}</p>
                <p class="text-sm text-gray-600">Up to Date</p>
            </div>
        </div>
    </div>

    <!-- Equipment Requiring Maintenance -->
    @if($equipment->count() > 0)
    <div class="card">
        <div class="card-header">
            <h2 class="text-xl font-semibold">Equipment Requiring Maintenance</h2>
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
                        @foreach($equipment as $item)
                        <tr class="
                            @if($item->next_service_date && $item->next_service_date->isPast())
                            bg-red-50
                            @elseif($item->next_service_date && $item->next_service_date->diffInDays(now()) <= 7)
                            bg-yellow-50
                            @endif">
                            <td>
                                <div class="flex items-center gap-3">
                                    @if($item->next_service_date && $item->next_service_date->isPast())
                                    <i class="fas fa-exclamation-circle text-red-500"></i>
                                    @elseif($item->next_service_date && $item->next_service_date->diffInDays(now()) <= 7)
                                    <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                                    @else
                                    <i class="fas fa-info-circle text-blue-500"></i>
                                    @endif
                                    <div>
                                        <a href="{{ route('equipment.show', $item) }}" class="font-medium text-blue-600 hover:underline">
                                            {{ $item->name }}
                                        </a>
                                        @if($item->serial_number)
                                        <p class="text-xs text-gray-500">SN: {{ $item->serial_number }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-light">{{ $item->category }}</span>
                            </td>
                            <td>{{ $item->location }}</td>
                            <td>
                                @if($item->last_service_date)
                                <span class="text-sm">{{ $item->last_service_date->format('M d, Y') }}</span>
                                <p class="text-xs text-gray-500">{{ $item->last_service_date->diffForHumans() }}</p>
                                @else
                                <span class="text-gray-400 text-sm">Never serviced</span>
                                @endif
                            </td>
                            <td>
                                @if($item->next_service_date)
                                <span class="text-sm
                                    @if($item->next_service_date->isPast()) text-red-600 font-semibold
                                    @elseif($item->next_service_date->diffInDays(now()) <= 7) text-yellow-600 font-semibold
                                    @endif">
                                    {{ $item->next_service_date->format('M d, Y') }}
                                </span>
                                <p class="text-xs text-gray-500">
                                    @if($item->next_service_date->isPast())
                                    Overdue by {{ $item->next_service_date->diffForHumans(null, true) }}
                                    @else
                                    {{ $item->next_service_date->diffForHumans() }}
                                    @endif
                                </p>
                                @else
                                <span class="text-gray-400 text-sm">Not scheduled</span>
                                @endif
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
                                <div class="flex gap-2">
                                    <a href="{{ route('equipment.maintenance.form', $item) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-wrench mr-1"></i>Record
                                    </a>
                                    <a href="{{ route('equipment.show', $item) }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-eye mr-1"></i>View
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
    @else
    <div class="card">
        <div class="card-body text-center py-12">
            <i class="fas fa-check-circle text-green-400 text-6xl mb-4"></i>
            <p class="text-gray-600 text-lg font-medium">All equipment is up to date!</p>
            <p class="text-gray-500 text-sm mt-2">No maintenance required at this time</p>
            <a href="{{ route('equipment.index') }}" class="btn btn-primary mt-4">
                <i class="fas fa-arrow-left mr-2"></i>Back to Equipment
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
