@extends('layouts.app')

@section('title', 'Welfare Reports')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Welfare Reports</h1>
            <p class="text-slate-600">Analyze welfare activities, spending, and impact.</p>
        </div>
        
        <form action="{{ route('welfare.reports') }}" method="GET" class="flex gap-2 bg-white p-1.5 rounded-lg border border-slate-200 shadow-sm">
            <input type="date" name="start_date" value="{{ $startDate ?? '' }}" class="form-input text-xs border-transparent focus:border-primary-500 rounded bg-slate-50 text-slate-600">
            <span class="text-slate-300 flex items-center">→</span>
            <input type="date" name="end_date" value="{{ $endDate ?? '' }}" class="form-input text-xs border-transparent focus:border-primary-500 rounded bg-slate-50 text-slate-600">
            <button type="submit" class="px-3 py-1 bg-slate-800 text-white rounded text-xs font-bold hover:bg-slate-700 transition">Update</button>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="card p-4 border border-blue-100 bg-blue-50/50">
            <p class="text-xs font-bold text-blue-500 uppercase tracking-wide">Total Income</p>
            <h3 class="text-xl font-bold text-blue-900 mt-1">GHS {{ number_format($report['total_income'] ?? 0, 2) }}</h3>
        </div>
        <div class="card p-4 border border-rose-100 bg-rose-50/50">
            <p class="text-xs font-bold text-rose-500 uppercase tracking-wide">Total Disbursed</p>
            <h3 class="text-xl font-bold text-rose-900 mt-1">GHS {{ number_format($report['total_disbursed'] ?? 0, 2) }}</h3>
        </div>
        <div class="card p-4 border border-emerald-100 bg-emerald-50/50">
            <p class="text-xs font-bold text-emerald-500 uppercase tracking-wide">Cases Resolved</p>
            <h3 class="text-xl font-bold text-emerald-900 mt-1">{{ number_format($report['cases_resolved'] ?? 0) }}</h3>
        </div>
        <div class="card p-4 border border-indigo-100 bg-indigo-50/50">
            <p class="text-xs font-bold text-indigo-500 uppercase tracking-wide">Beneficiaries Served</p>
            <h3 class="text-xl font-bold text-indigo-900 mt-1">{{ number_format($report['beneficiaries_served'] ?? 0) }}</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Spending by Category -->
        <div class="card border border-slate-100 shadow-sm">
            <div class="px-5 py-3 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-sm">Disbursement by Category</h3>
            </div>
            <div class="p-5">
                @if(!empty($report['spending_by_category']))
                    <div class="space-y-4">
                        @foreach($report['spending_by_category'] as $category => $amount)
                        <div>
                             <div class="flex justify-between text-xs font-medium text-slate-600 mb-1">
                                <span class="capitalize">{{ str_replace('_', ' ', $category) }}</span>
                                <span class="font-bold text-slate-800">GHS {{ number_format($amount, 2) }}</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                <div class="h-full bg-blue-500 rounded-full" style="width: {{ ($amount / max(1, $report['total_disbursed'])) * 100 }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-slate-500 text-sm py-8">No spending data for this period.</p>
                @endif
            </div>
        </div>

        <!-- Case Status Breakdown -->
         <div class="card border border-slate-100 shadow-sm">
            <div class="px-5 py-3 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-sm">Case Status Breakdown</h3>
            </div>
            <div class="p-5">
                 @if(!empty($report['cases_by_status']))
                    <div class="space-y-4">
                        @foreach($report['cases_by_status'] as $status => $count)
                        <div class="flex items-center justify-between p-3 rounded-lg border border-slate-100 hover:bg-slate-50 transition">
                             <div class="flex items-center gap-3">
                                 <span class="w-2 h-2 rounded-full 
                                    {{ $status === 'approved' ? 'bg-emerald-500' : 
                                      ($status === 'rejected' ? 'bg-rose-500' : 
                                      ($status === 'closed' ? 'bg-gray-500' : 'bg-amber-500')) }}"></span>
                                <span class="text-sm font-medium text-slate-700 capitalize">{{ str_replace('_', ' ', $status) }}</span>
                             </div>
                            <span class="text-sm font-bold text-slate-900">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-slate-500 text-sm py-8">No case data for this period.</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Printable Footer -->
    <div class="mt-8 text-center border-t border-slate-200 pt-8 hidden print:block">
        <p class="text-slate-500 text-sm">Report generated on {{ now()->format('M d, Y H:i A') }}</p>
    </div>
</div>
@endsection
