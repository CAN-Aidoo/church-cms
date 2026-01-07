@extends('layouts.app')

@section('title', 'Service Calendar')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Service Calendar</h1>
         <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('services.index') }}" class="hover:text-primary-600 transition-colors">Services</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Calendar</span>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('services.create') }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Schedule New Service
        </a>
    </div>
</div>

<!-- Month/Year Selector -->
<div class="card border border-slate-100 shadow-sm mb-6">
    <div class="p-6">
        <form method="GET" action="{{ route('services.calendar') }}" class="flex flex-col md:flex-row items-end gap-4">
            <div class="w-full md:w-auto">
                <label for="month" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Month</label>
                <select name="month" id="month" class="form-select w-full md:w-48 border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="w-full md:w-auto">
                <label for="year" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Year</label>
                <select name="year" id="year" class="form-select w-full md:w-32 border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    @for($y = now()->year - 1; $y <= now()->year + 2; $y++)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-full md:w-auto">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                View
            </button>
        </form>
    </div>
</div>

<!-- Calendar View -->
<div class="card border border-slate-100 shadow-sm">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
        <h3 class="font-bold text-slate-800 text-base">{{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }} Services</h3>
        <a href="{{ route('services.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors">View List</a>
    </div>
    <div class="p-6">
        @if($services->count() > 0)
            <div class="space-y-6">
                @foreach($services->groupBy(function($service) { return \Carbon\Carbon::parse($service->service_date)->format('Y-m-d'); }) as $date => $dayServices)
                    <div class="border border-slate-200 rounded-xl p-0 overflow-hidden hover:border-primary-200 hover:shadow-sm transition-all">
                        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                            <h4 class="font-bold text-slate-900 flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}
                            </h4>
                            <span class="inline-flex items-center rounded-lg px-2 py-1 text-xs font-bold bg-white text-slate-600 border border-slate-200 shadow-sm">
                                {{ $dayServices->count() }} {{Str::plural('Service', $dayServices->count()) }}
                            </span>
                        </div>
                        <div class="divide-y divide-slate-100">
                            @foreach($dayServices as $service)
                                <div class="px-4 py-3 flex flex-col sm:flex-row sm:items-center justify-between hover:bg-slate-50 transition-colors gap-4">
                                    <div class="flex items-start gap-4">
                                        <div class="text-center min-w-[60px] pt-0.5">
                                            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ \Carbon\Carbon::parse($service->start_time)->format('h:i A') }}</div>
                                            <div class="text-[10px] text-slate-400 mt-0.5 font-medium">{{ \Carbon\Carbon::parse($service->service_date)->format('M d') }}</div>
                                        </div>
                                        
                                        <div class="border-l-2 border-primary-100 pl-4 py-0.5">
                                            <div class="flex items-center gap-2 mb-0.5">
                                                <h5 class="text-sm font-bold text-slate-900">{{ $service->name }}</h5>
                                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide bg-slate-100 text-slate-500">
                                                    {{ $service->service_type_label }}
                                                </span>
                                            </div>
                                            
                                            @if($service->preacher)
                                                <div class="text-xs text-slate-500 flex items-center gap-1">
                                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                    <span class="font-medium text-slate-600">{{ $service->preacher->full_name }}</span>
                                                </div>
                                            @endif
                                            
                                            @if($service->theme)
                                             <div class="text-xs text-slate-400 italic mt-0.5">"{{ $service->theme }}"</div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-3 self-end sm:self-center">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize {{ $service->getStatusBadgeClass() }}">
                                            {{ ucfirst(str_replace('_', ' ', $service->status)) }}
                                        </span>
                                        <a href="{{ route('services.show', $service) }}" class="btn btn-sm btn-icon btn-ghost text-slate-400 hover:text-primary-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
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
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">No Services Scheduled</h3>
                <p class="text-slate-500 mb-6 max-w-sm mx-auto">No services are scheduled for {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}.</p>
                <a href="{{ route('services.create') }}" class="btn btn-primary shadow-lg shadow-primary-500/30">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Schedule First Service
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
