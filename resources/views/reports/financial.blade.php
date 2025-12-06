@extends('layouts.app')

@section('title', 'Financial Reports')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Financial Reports</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('reports.index') }}">Reports</a>
            <span>/</span>
            <span>Financial Reports</span>
        </nav>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.financial.income') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="date_from" class="form-label">From Date</label>
                <input type="date" id="date_from" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="form-input">
            </div>
            <div>
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" id="date_to" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="form-input">
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="card">
        <div class="card-body text-center">
            <p class="text-sm text-gray-600 mb-2">Total Income</p>
            <p class="text-3xl font-bold text-green-600">GHS {{ number_format($data['total_income'] ?? 0, 2) }}</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body text-center">
            <p class="text-sm text-gray-600 mb-2">Total Expenses</p>
            <p class="text-3xl font-bold text-red-600">GHS {{ number_format($data['total_expenses'] ?? 0, 2) }}</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body text-center">
            <p class="text-sm text-gray-600 mb-2">Net Balance</p>
            <p class="text-3xl font-bold {{ ($data['net_balance'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                GHS {{ number_format($data['net_balance'] ?? 0, 2) }}
            </p>
        </div>
    </div>
</div>

<!-- By Category -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">By Category</h3>
    </div>
    <div class="card-body">
        @if(!empty($data['by_category']))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($data['by_category'] as $type => $categories)
                    <div>
                        <h4 class="font-semibold mb-3 capitalize">{{ $type }}</h4>
                        <div class="space-y-2">
                            @foreach($categories as $item)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm">{{ $item['category'] ?? 'Uncategorized' }}</span>
                                    <span class="font-semibold">GHS {{ number_format($item['total'] ?? 0, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No financial data available for the selected period.</p>
        @endif
    </div>
</div>

<!-- Monthly Trend -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Monthly Trend</h3>
    </div>
    <div class="card-body">
        @if(!empty($data['by_month']))
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th class="text-right">Income</th>
                            <th class="text-right">Expenses</th>
                            <th class="text-right">Net</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['by_month'] as $month => $types)
                            @php
                                $income = collect($types)->where('transaction_type', 'income')->sum('total');
                                $expenses = collect($types)->where('transaction_type', 'expense')->sum('total');
                                $net = $income - $expenses;
                            @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}</td>
                                <td class="text-right text-green-600">GHS {{ number_format($income, 2) }}</td>
                                <td class="text-right text-red-600">GHS {{ number_format($expenses, 2) }}</td>
                                <td class="text-right font-semibold {{ $net >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    GHS {{ number_format($net, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No monthly data available.</p>
        @endif
    </div>
</div>
@endsection
