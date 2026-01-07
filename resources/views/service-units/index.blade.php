@extends('layouts.app')

@section('title', 'Service Units')

@section('content')
<!-- Header -->
<div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6 mb-8">
    <div>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-2">
            <span class="text-slate-800 font-medium">Service Units</span>
        </nav>
        <h1 class="text-3xl font-heading font-bold text-slate-900">Service Units</h1>
        <p class="text-slate-500 mt-1">Manage ministry service units and duty rosters</p>
    </div>
    
    <div class="flex gap-3">
        <a href="{{ route('service-units.export', request()->all()) }}" class="btn btn-outline-secondary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export CSV
        </a>
        <a href="{{ route('service-units.create') }}" class="btn btn-primary shadow-lg shadow-primary-500/20">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Create Service Unit
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 border border-slate-100 shadow-sm bg-gradient-to-br from-blue-500 to-blue-600 text-white relative overflow-hidden group">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
        <div class="relative z-10">
            <p class="text-blue-100 text-sm font-medium mb-1">Total Units</p>
            <h3 class="text-4xl font-bold mb-2">{{ $stats['total'] }}</h3>
        </div>
        <div class="absolute bottom-4 right-4 text-blue-200">
             <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
    </div>

    <div class="card p-6 border border-slate-100 shadow-sm bg-gradient-to-br from-emerald-500 to-emerald-600 text-white relative overflow-hidden group">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
        <div class="relative z-10">
            <p class="text-emerald-100 text-sm font-medium mb-1">Active Units</p>
            <h3 class="text-4xl font-bold mb-2">{{ $stats['active'] ?? 0 }}</h3>
        </div>
        <div class="absolute bottom-4 right-4 text-emerald-200">
             <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <div class="card p-6 border border-slate-100 shadow-sm bg-gradient-to-br from-amber-500 to-amber-600 text-white relative overflow-hidden group">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
        <div class="relative z-10">
            <p class="text-amber-100 text-sm font-medium mb-1">Total Members</p>
            <h3 class="text-4xl font-bold mb-2">{{ $stats['total_members'] }}</h3>
        </div>
        <div class="absolute bottom-4 right-4 text-amber-200">
             <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
    </div>

    <div class="card p-6 border border-slate-100 shadow-sm bg-gradient-to-br from-purple-500 to-purple-600 text-white relative overflow-hidden group">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all duration-500"></div>
        <div class="relative z-10">
            <p class="text-purple-100 text-sm font-medium mb-1">Avg Members/Unit</p>
            <h3 class="text-4xl font-bold mb-2">{{ number_format($stats['average_members_per_unit'], 1) }}</h3>
        </div>
        <div class="absolute bottom-4 right-4 text-purple-200">
             <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        </div>
    </div>
</div>

<!-- Filters and Category Tabs -->
<div class="card border border-slate-100 shadow-sm mb-8">
    <div class="border-b border-slate-100 p-4">
        <div class="flex items-center gap-2 mb-4">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            <h3 class="font-semibold text-slate-800">Filter by Category</h3>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('service-units.index') }}"
                class="px-4 py-1.5 rounded-full text-sm font-medium transition-all {{ !request('category') ? 'bg-primary-50 text-primary-700 ring-1 ring-primary-600/20' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                All Units <span class="ml-1 text-xs opacity-75">({{ $stats['total'] }})</span>
            </a>
            @foreach(['music', 'technical', 'hospitality', 'security', 'admin', 'children', 'media', 'other'] as $category)
            <a href="{{ route('service-units.index', ['category' => $category]) }}"
                class="px-4 py-1.5 rounded-full text-sm font-medium transition-all {{ request('category') === $category ? 'bg-primary-50 text-primary-700 ring-1 ring-primary-600/20' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                {{ ucfirst($category) }} <span class="ml-1 text-xs opacity-75">({{ $categoryStats[$category] }})</span>
            </a>
            @endforeach
        </div>
    </div>

    <div class="p-4 bg-slate-50/50">
        <form method="GET" action="{{ route('service-units.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search service units..."
                           class="form-input pl-10 w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                </div>
            </div>
            <select name="status" class="form-select border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg md:w-48">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary px-6">
                    Search
                </button>
                @if(request()->anyFilled(['search', 'status', 'category']))
                <a href="{{ route('service-units.index') }}" class="btn btn-outline-secondary">
                    Clear
                </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Service Units Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($units as $unit)
    <div class="card group hover:shadow-lg transition-all duration-300 border border-slate-200 hover:border-primary-200 bg-white overflow-hidden">
        <!-- Header with colored bar -->
        <div class="h-2 w-full bg-gradient-to-r from-primary-500 to-indigo-600"></div>
        
        <div class="p-5">
            <div class="flex justify-between items-start mb-3">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 uppercase tracking-wide">
                    {{ ucfirst($unit->category) }}
                </span>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                    {{ $unit->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 
                       ($unit->status === 'inactive' ? 'bg-slate-100 text-slate-600' : 'bg-red-100 text-red-800') }}">
                    {{ ucfirst($unit->status) }}
                </span>
            </div>

            <div class="mb-4">
                <h3 class="text-xl font-bold text-slate-900 group-hover:text-primary-600 transition-colors mb-1 truncate">{{ $unit->name }}</h3>
                <p class="text-xs font-mono text-slate-400">{{ $unit->code }}</p>
            </div>

            @if($unit->description)
            <p class="text-slate-600 text-sm mb-5 line-clamp-2 h-10">{{ $unit->description }}</p>
            @else
            <div class="h-10 mb-5"></div>
            @endif

            <!-- Leadership Mini-List -->
            <div class="space-y-3 mb-5 pt-4 border-t border-slate-100">
                <div class="flex items-center text-sm">
                    <div class="w-8 h-8 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center text-xs font-bold mr-3 flex-shrink-0">
                        L
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Leader</p>
                        <p class="text-slate-800 font-medium truncate">{{ $unit->leader?->full_name ?? 'Not assigned' }}</p>
                    </div>
                </div>
                @if($unit->assistantLeader)
                <div class="flex items-center text-sm">
                    <div class="w-8 h-8 rounded-full bg-slate-50 text-slate-500 flex items-center justify-center text-xs font-bold mr-3 flex-shrink-0">
                        A
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Assistant</p>
                        <p class="text-slate-700 truncate">{{ $unit->assistantLeader->full_name }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Capacity Bar -->
            <div class="mb-5">
                <div class="flex justify-between items-end mb-1">
                    <span class="text-xs font-medium text-slate-500">Capacity Utilization</span>
                    <span class="text-xs font-bold text-slate-900">{{ number_format($unit->capacity_percentage, 0) }}%</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="h-2 rounded-full transition-all duration-500 {{ $unit->capacity_percentage >= 100 ? 'bg-red-500' : ($unit->capacity_percentage >= 80 ? 'bg-amber-500' : 'bg-emerald-500') }}"
                         style="width: {{ min($unit->capacity_percentage, 100) }}%"></div>
                </div>
                <div class="flex justify-between mt-1 text-xs text-slate-400">
                    <span>{{ $unit->current_members }} members</span>
                    <span>Max: {{ $unit->max_members }}</span>
                </div>
            </div>

            <!-- Meeting Info -->
            @if($unit->meeting_schedule)
            <div class="flex items-center gap-2 text-xs text-slate-500 bg-slate-50 p-2 rounded mb-5">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="truncate">{{ $unit->meeting_schedule }}</span>
            </div>
            @endif

            <div class="flex gap-3 mt-auto">
                <a href="{{ route('service-units.show', $unit) }}" class="flex-1 btn btn-outline-primary justify-center">View</a>
                <a href="{{ route('service-units.edit', $unit) }}" class="btn btn-outline-secondary px-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full">
        <div class="flex flex-col items-center justify-center p-12 bg-white rounded-lg border border-slate-200 border-dashed text-center">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">No Service Units Found</h3>
            <p class="text-slate-500 max-w-md mb-6">There are no service units matching your criteria. Get started by creating your first ministry service unit.</p>
            <a href="{{ route('service-units.create') }}" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Create Service Unit
            </a>
        </div>
    </div>
    @endforelse
</div>

@if($units->hasPages())
<div class="mt-8">
    {{ $units->links() }}
</div>
@endif
@endsection