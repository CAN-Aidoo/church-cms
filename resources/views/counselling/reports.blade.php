@extends('layouts.app')

@section('title', 'Counselling Reports')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Counselling Reports') }}
    </h2>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 border-b border-gray-200">
            <form method="GET" action="{{ route('counselling.reports') }}" class="flex gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Generate Report
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Sessions Overview</h3>
            <dl class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded">
                    <dt class="text-sm text-gray-500">Total Sessions</dt>
                    <dd class="text-2xl font-bold">{{ $report['total_sessions'] ?? 0 }}</dd>
                </div>
                <div class="bg-gray-50 p-4 rounded">
                    <dt class="text-sm text-gray-500">Completed</dt>
                    <dd class="text-2xl font-bold text-green-600">{{ $report['completed_sessions'] ?? 0 }}</dd>
                </div>
                 <div class="bg-gray-50 p-4 rounded">
                    <dt class="text-sm text-gray-500">Cancelled</dt>
                    <dd class="text-2xl font-bold text-red-600">{{ $report['cancelled_sessions'] ?? 0 }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Top Issues</h3>
            <ul class="space-y-2">
                @forelse($report['top_issues'] ?? [] as $issue => $count)
                    <li class="flex justify-between items-center">
                        <span>{{ $issue }}</span>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold">{{ $count }}</span>
                    </li>
                @empty
                    <li class="text-gray-500">No data available.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
