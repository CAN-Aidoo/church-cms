@extends('layouts.app')

@section('title', 'Shepherd Reports')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Shepherd Reports</h1>
        <div class="flex items-center gap-2 mt-1 flex-wrap">
            <nav class="flex items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
                <span>/</span>
                <a href="{{ route('shepherds.index') }}" class="hover:text-primary-600 transition-colors">Shepherds</a>
                <span>/</span>
                <a href="{{ route('shepherds.show', $shepherd) }}" class="hover:text-primary-600 transition-colors">{{ $shepherd->flock_name }}</a>
                <span>/</span>
                <span class="text-slate-800 font-medium">Reports</span>
            </nav>
        </div>
    </div>
    <!-- <div class="flex items-center gap-3">
        <button class="btn btn-primary shadow-lg shadow-primary-500/30">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Submit Report
        </button>
    </div> -->
</div>

<div class="card border border-slate-100 shadow-sm">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
        <h2 class="text-base font-bold text-slate-800">Submitted Reports</h2>
        <span class="bg-slate-100 text-slate-600 text-xs font-bold px-2.5 py-0.5 rounded-full">{{ $reports->count() }} Reports</span>
    </div>
    <div class="p-0">
        @if($reports->count() > 0)
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-slate-50 border-b border-slate-100 text-xs uppercase text-slate-500 font-semibold">
                    <tr>
                        <th class="px-6 py-3 text-left">Period</th>
                        <th class="px-6 py-3 text-left">Submission Date</th>
                        <th class="px-6 py-3 text-left">Members</th>
                        <th class="px-6 py-3 text-left">Visits</th>
                        <th class="px-6 py-3 text-left">Meetings</th>
                        <th class="px-6 py-3 text-left">Engagement</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($reports as $report)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3 text-sm font-medium text-slate-900">{{ ucfirst($report->report_period) }}</td>
                        <td class="px-6 py-3 text-sm text-slate-600">{{ $report->report_date->format('M d, Y') }}</td>
                        <td class="px-6 py-3 text-sm text-slate-600">{{ $report->total_members }}</td>
                        <td class="px-6 py-3">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-blue-50 text-blue-700">
                                {{ $report->visits_conducted }}
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-emerald-50 text-emerald-700">
                                {{ $report->meetings_held }}
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-16 bg-slate-100 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full {{ $report->engagement_score >= 80 ? 'bg-emerald-500' : ($report->engagement_score >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                                         style="width: {{ $report->engagement_score }}%"></div>
                                </div>
                                <span class="text-xs text-slate-500">{{ number_format($report->engagement_score, 0) }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-3">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium 
                                {{ $report->status === 'reviewed' ? 'bg-emerald-50 text-emerald-700' : ($report->status === 'submitted' ? 'bg-blue-50 text-blue-700' : 'bg-slate-50 text-slate-700') }} capitalize">
                                {{ $report->status }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-right">
                            <button class="btn btn-sm btn-icon btn-ghost text-slate-400 hover:text-primary-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-lg font-medium text-slate-900">No reports submitted</h3>
            <p class="text-slate-500 mt-1">There are no reports available for this shepherd.</p>
        </div>
        @endif
    </div>
</div>
@endsection
