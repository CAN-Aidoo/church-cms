@extends('layouts.app')

@section('title', 'Children\'s Ministry Reports')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Ministry Reports</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('childrens-ministry.index') }}" class="hover:text-primary-600 transition-colors">Children's Ministry</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Reports</span>
        </nav>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Filter Sidebar -->
    <div class="lg:col-span-1">
        <div class="card border border-slate-100 shadow-sm sticky top-6">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Report Settings</h3>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('childrens-ministry.reports') }}" class="space-y-4">
                    <div>
                        <label for="start_date" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    </div>
                    <div>
                        <label for="end_date" class="form-label mb-1.5 block font-medium text-sm text-slate-700">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                    </div>
                    
                    <div class="pt-2">
                        <button type="submit" class="btn btn-primary w-full justify-center shadow-md shadow-primary-500/20">
                            Generate Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Report Content -->
    <div class="lg:col-span-3 space-y-6">
        <!-- Attendance Chart Card (Placeholder for now) -->
        <div class="card border border-slate-100 shadow-sm">
             <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-base">Weekly Attendance Overview</h3>
                <span class="text-xs font-medium text-slate-500">Last 30 Days</span>
            </div>
            <div class="p-6 h-64 flex items-center justify-center bg-slate-50/30">
                <p class="text-slate-400 text-sm">Chart visualization would appear here.</p>
            </div>
        </div>

        <!-- Attendance Data Table -->
        <div class="card border border-slate-100 shadow-sm">
             <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-base">Detailed Attendance Data</h3>
                 <button class="text-sm font-medium text-primary-600 hover:text-primary-700 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export CSV
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead class="bg-slate-50 border-b border-slate-100 text-xs uppercase text-slate-500 font-semibold">
                        <tr>
                            <th class="px-6 py-3 text-left">Date</th>
                            <th class="px-6 py-3 text-left">Total Children</th>
                            <th class="px-6 py-3 text-left">First Time</th>
                            <th class="px-6 py-3 text-left">Volunteers</th>
                            <th class="px-6 py-3 text-right">Ratio</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($attendanceReport ?? [] as $date => $data)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-700">{{ $date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $data['total'] ?? 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(($data['first_time'] ?? 0) > 0)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-700">
                                            +{{ $data['first_time'] }} New
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-600">{{ $data['volunteers'] ?? 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-xs text-slate-500">
                                    @if(($data['volunteers'] ?? 0) > 0)
                                        1 : {{ round(($data['total'] ?? 0) / $data['volunteers'], 1) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                    <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    No attendance data found for the selected period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
