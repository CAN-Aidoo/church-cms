@extends('layouts.app')

@section('title', 'Service Details')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $service->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('services.worship-plan', $service) }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-sm font-medium">
                Worship Plan
            </a>
            <a href="{{ route('services.volunteers', $service) }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-sm font-medium">
                Volunteers
            </a>
            <a href="{{ route('services.edit', $service) }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm">
                Edit Service
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Info --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Service Details</h3>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Date</label>
                        <p class="font-medium text-gray-900 mt-1">{{ $service->service_date->format('l, M d, Y') }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Time</label>
                        <p class="font-medium text-gray-900 mt-1">
                            {{ $service->start_time->format('h:i A') }} - 
                            {{ $service->end_time ? $service->end_time->format('h:i A') : 'TBD' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Type</label>
                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full bg-blue-50 text-blue-700 capitalize">
                            {{ str_replace('_', ' ', $service->service_type) }}
                        </span>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Status</label>
                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full 
                            {{ $service->status === 'completed' ? 'bg-green-50 text-green-700' : 
                              ($service->status === 'published' ? 'bg-purple-50 text-purple-700' : 'bg-yellow-50 text-yellow-700') }}">
                            {{ ucfirst($service->status) }}
                        </span>
                    </div>
                    <div class="col-span-2">
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Theme</label>
                        <p class="font-medium text-gray-900 mt-1">{{ $service->theme ?? 'No theme set' }}</p>
                    </div>
                    <div class="col-span-2">
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Preacher</label>
                        <p class="font-medium text-gray-900 mt-1">{{ $service->preacher->full_name ?? 'TBD' }}</p>
                    </div>
                </div>
            </div>

            {{-- Worship Plan Preview --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Order of Service</h3>
                    <a href="{{ route('services.worship-plan', $service) }}" class="text-sm text-primary-600 hover:text-primary-700">Manage</a>
                </div>
                @if($service->worshipPlans->count() > 0)
                    <div class="space-y-3">
                        @foreach($service->worshipPlans->sortBy('order_number') as $item)
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-400 font-medium w-6">{{ $item->order_number }}</span>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $item->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->duration_minutes }} mins • {{ ucfirst(str_replace('_', ' ', $item->item_type)) }}</p>
                                </div>
                                @if($item->assignedTo)
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-gray-200 text-xs flex items-center justify-center text-gray-600">
                                            {{ substr($item->assignedTo->first_name, 0, 1) }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm text-center py-4">No items in worship plan.</p>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Actions --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Actions</h3>
                <div class="space-y-2">
                    @if($service->status === 'draft')
                        <form action="{{ route('services.publish', $service) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                                Publish Service
                            </button>
                        </form>
                    @endif
                    
                    <form action="{{ route('services.duplicate', $service) }}" method="POST">
                        @csrf
                        <div class="flex gap-2">
                            <input type="date" name="new_date" class="flex-1 rounded-lg border-gray-300 text-sm" required>
                            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                                Duplicate
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Volunteers Summary --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Volunteers</h3>
                <div class="space-y-3">
                    @php
                        $volunteersByRole = $service->volunteers->groupBy('role');
                    @endphp
                    @foreach($volunteersByRole as $role => $volunteers)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $role) }}</span>
                            <span class="px-2 py-0.5 bg-gray-100 rounded-full text-xs font-medium">{{ $volunteers->count() }}</span>
                        </div>
                    @endforeach
                    @if($service->volunteers->isEmpty())
                        <p class="text-sm text-gray-500">No volunteers assigned.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
