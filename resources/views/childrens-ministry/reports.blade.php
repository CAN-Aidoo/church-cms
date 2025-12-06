@extends('layouts.app')

@section('title', 'Children\'s Ministry Reports')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Ministry Reports') }}
    </h2>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 border-b border-gray-200">
            <form method="GET" action="{{ route('childrens-ministry.reports') }}" class="flex gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Generate Report
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold mb-4">Attendance Report</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Children</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Volunteers</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($attendanceReport ?? [] as $date => $data)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $data['total'] ?? 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $data['first_time'] ?? 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $data['volunteers'] ?? 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No data found for the selected period.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
