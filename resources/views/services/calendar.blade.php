@extends('layouts.app')

@section('title', 'Service Calendar')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Service Calendar</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('services.index') }}">Services</a>
            <span>/</span>
            <span>Calendar</span>
        </nav>
    </div>
    <div class="page-actions">
        <a href="{{ route('services.create') }}" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Schedule New Service
        </a>
    </div>
</div>

<!-- Month/Year Selector -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" action="{{ route('services.calendar') }}" class="flex items-center gap-4">
            <div>
                <label for="month" class="form-label">Month</label>
                <select name="month" id="month" class="form-select">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label for="year" class="form-label">Year</label>
                <select name="year" id="year" class="form-select">
                    @for($y = now()->year - 1; $y <= now()->year + 2; $y++)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    View
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Calendar View -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }} Services</h3>
        <a href="{{ route('services.index') }}" class="text-sm text-primary-600 hover:text-primary-700">View List</a>
    </div>
    <div class="card-body">
        @if($services->count() > 0)
            <div class="space-y-4">
                @foreach($services->groupBy(function($service) { return \Carbon\Carbon::parse($service->service_date)->format('Y-m-d'); }) as $date => $dayServices)
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-primary-300 transition-colors">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}
                            </h4>
                            <span class="badge badge-primary">{{ $dayServices->count() }} {{ $dayServices->count() == 1 ? 'Service' : 'Services' }}</span>
                        </div>
                        <div class="space-y-2">
                            @foreach($dayServices as $service)
                                <div class="flex items-center justify-between bg-gray-50 rounded p-3 hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <div class="text-center">
                                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($service->service_time)->format('H:i') }}</div>
                                            <div class="text-sm font-medium text-gray-700">{{ $service->service_type }}</div>
                                        </div>
                                        <div class="border-l border-gray-300 pl-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $service->title }}</div>
                                            @if($service->preacher)
                                                <div class="text-xs text-gray-500 mt-0.5">
                                                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                    Preacher: {{ $service->preacher->name }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="badge {{ $service->status === 'completed' ? 'badge-success' : ($service->status === 'cancelled' ? 'badge-danger' : 'badge-warning') }}">
                                            {{ ucfirst($service->status) }}
                                        </span>
                                        <a href="{{ route('services.show', $service) }}" class="btn btn-sm btn-outline">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Services Scheduled</h3>
                <p class="text-gray-500 mb-4">No services are scheduled for {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}.</p>
                <a href="{{ route('services.create') }}" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Schedule First Service
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
