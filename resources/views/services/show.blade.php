@extends('layouts.app')

@section('title', 'Service Details')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">{{ $service->name }}</h1>
        <div class="flex items-center gap-2 mt-1 flex-wrap">
            <nav class="flex items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
                <span>/</span>
                <a href="{{ route('services.index') }}" class="hover:text-primary-600 transition-colors">Services</a>
                <span>/</span>
                <span class="text-slate-800 font-medium whitespace-nowrap overflow-hidden text-ellipsis max-w-[200px]">{{ $service->name }}</span>
            </nav>
            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize {{ $service->getStatusBadgeClass() }}">
                {{ ucfirst(str_replace('_', ' ', $service->status)) }}
            </span>
        </div>
    </div>
    <div class="flex items-center gap-3">
        @can('update', $service)
        <a href="{{ route('services.edit', $service) }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            Edit Service
        </a>

        <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this service? All worship plan items and volunteer assignments will be removed.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Delete
            </button>
        </form>
        @endcan
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Service Details Card -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-base">Overview</h3>
                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-slate-100 text-slate-600">
                    {{ $service->service_type_label }}
                </span>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start gap-4">
                        <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Date</p>
                            <p class="font-medium text-slate-900">{{ $service->service_date->format('l, M d, Y') }}</p>
                            @if($service->service_date->isToday())
                                <span class="text-xs text-emerald-600 font-medium">Today</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Time</p>
                            <p class="font-medium text-slate-900">
                                {{ $service->start_time->format('h:i A') }}
                                @if($service->end_time)
                                    - {{ $service->end_time->format('h:i A') }}
                                @endif
                            </p>
                            @if($service->duration)
                                <span class="text-xs text-slate-500">{{ $service->duration }} mins</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-2.5 bg-purple-50 text-purple-600 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Preacher</p>
                            @if($service->preacher)
                                <p class="font-medium text-slate-900">{{ $service->preacher->full_name }}</p>
                            @else
                                <p class="text-sm italic text-slate-500">Not assigned</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-2.5 bg-amber-50 text-amber-600 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Venue</p>
                            <p class="font-medium text-slate-900">{{ $service->venue ?: 'Main Sanctuary' }}</p>
                        </div>
                    </div>

                    @if($service->theme)
                    <div class="col-span-1 md:col-span-2 flex items-start gap-4 pt-4 border-t border-slate-50">
                         <div class="p-2.5 bg-slate-100 text-slate-600 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Theme / Topic</p>
                            <p class="font-medium text-slate-900">{{ $service->theme }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                @if($service->notes)
                <div class="mt-6 p-4 bg-yellow-50 rounded-lg border border-yellow-100">
                    <h4 class="font-bold text-yellow-800 text-xs uppercase tracking-wide mb-1">Notes</h4>
                    <p class="text-sm text-yellow-800 whitespace-pre-line">{{ $service->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Worship Plan -->
        <div class="card border border-slate-100 shadow-sm">
             <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-base">Order of Service</h3>
                <a href="{{ route('services.worship-plan', $service) }}" class="text-sm font-medium text-primary-600 hover:text-primary-700 hover:underline">Manage Plan</a>
            </div>
            <div class="p-0">
                @if($service->worshipPlans->count() > 0)
                <div class="divide-y divide-slate-100">
                    @foreach($service->worshipPlans->sortBy('order_number') as $item)
                        <div class="p-4 flex items-center gap-4 hover:bg-slate-50 transition-colors">
                            <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 font-bold text-sm flex items-center justify-center flex-shrink-0">
                                {{ $item->order_number }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-slate-900 truncate">{{ $item->title }}</h4>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-xs font-medium text-slate-500 uppercase">{{ str_replace('_', ' ', $item->item_type) }}</span>
                                    <span class="text-xs text-slate-300">•</span>
                                    <span class="text-xs text-slate-500">{{ $item->duration_minutes }} mins</span>
                                </div>
                            </div>
                            @if($item->assignedTo)
                            <div class="flex items-center gap-2" title="{{ $item->assignedTo->full_name }}">
                                <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 font-bold text-xs flex items-center justify-center border-2 border-white shadow-sm">
                                    {{ substr($item->assignedTo->first_name, 0, 1) }}{{ substr($item->assignedTo->last_name, 0, 1) }}
                                </div>
                            </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @else
                <div class="py-8 text-center">
                    <div class="w-12 h-12 bg-slate-100 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <p class="text-slate-500 text-sm">No items in the worship plan yet.</p>
                    <a href="{{ route('services.worship-plan', $service) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium mt-1 inline-block">Create Plan</a>
                </div>
                @endif
            </div>
            @if($service->worshipPlans->count() > 0)
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                <div class="flex justify-between items-center text-sm font-medium">
                    <span class="text-slate-500">Total Duration</span>
                    <span class="text-slate-900">{{ $service->worshipPlans->sum('duration_minutes') }} mins</span>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Status Actions -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Actions</h3>
            </div>
            <div class="p-6 space-y-3">
                @if($service->status === 'draft')
                <form action="{{ route('services.publish', $service) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Publish Service
                    </button>
                    <p class="text-xs text-slate-500 mt-2 text-center">Makes visible to volunteers</p>
                </form>
                @endif

                @if($service->status === 'scheduled')
                    @if($service->service_date->isToday())
                    <form action="{{ route('services.start', $service) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary w-full justify-center">
                            Start Service
                        </button>
                    </form>
                    @endif
                @endif

                <form action="{{ route('services.duplicate', $service) }}" method="POST" class="pt-3 border-t border-slate-100">
                    @csrf
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Duplicate Service</label>
                    <div class="flex gap-2">
                        <input type="date" name="new_date" class="form-input text-sm w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" required min="{{ date('Y-m-d') }}">
                        <button type="submit" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-3">
                            Copy
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Volunteers Summary -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Volunteers</h3>
                <a href="{{ route('services.volunteers', $service) }}" class="text-xs font-medium text-primary-600 hover:text-primary-700">Manage</a>
            </div>
            <div class="p-6">
                @if($service->volunteers->count() > 0)
                    <div class="space-y-3">
                        @foreach($service->getVolunteersByRole() as $role => $count)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600 capitalize">{{ str_replace('_', ' ', $role) }}</span>
                            <span class="badge bg-slate-100 text-slate-600">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold text-slate-800">Total Assigned</span>
                            <span class="font-bold text-primary-600">{{ $service->volunteers->count() }}</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-2">
                        <p class="text-slate-500 text-sm mb-2">No volunteers assigned.</p>
                        <a href="{{ route('services.volunteers', $service) }}" class="btn btn-sm btn-outline-primary">
                            Assign Volunteers
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Attendance Stats (if applicable) -->
        @if($service->status === 'completed' || $service->status === 'in_progress')
        <div class="card border border-slate-100 shadow-sm">
             <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Attendance</h3>
            </div>
            <div class="p-6">
                 <div class="flex items-end gap-2 mb-1">
                    <span class="text-2xl font-bold text-slate-900">{{ $service->actual_attendance ?? 0 }}</span>
                    <span class="text-sm text-slate-500 mb-1">present</span>
                </div>
                @if($service->expected_attendance)
                <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2 mb-1">
                    <div class="bg-primary-500 h-1.5 rounded-full" style="width: {{ min(100, ($service->actual_attendance / $service->expected_attendance) * 100) }}%"></div>
                </div>
                <p class="text-xs text-slate-400">Target: {{ $service->expected_attendance }}</p>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
