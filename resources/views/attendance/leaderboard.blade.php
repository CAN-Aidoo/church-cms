@extends('layouts.app')

@section('title', 'Attendance Leaderboard')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Attendance Leaderboard</h1>
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('attendance.index') }}">Attendance</a>
            <span>/</span>
            <span>Leaderboard</span>
        </nav>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('attendance.reports') }}" class="btn btn-secondary">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
            </svg>
            Full Reports
        </a>
        <a href="{{ route('attendance.index') }}" class="btn btn-outline">
            Back to Attendance
        </a>
    </div>
</div>

<!-- Date Filter Card -->
<div class="card mb-6">
    <div class="card-header bg-gradient-to-r from-primary-50 to-blue-50">
        <h3 class="text-lg font-semibold text-gray-900">Filter Period</h3>
        <p class="text-sm text-gray-600 mt-1">Select date range to view leaderboard statistics</p>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('attendance.leaderboard') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                <input type="date"
                       name="date_from"
                       id="date_from"
                       value="{{ $dateFrom }}"
                       class="form-input w-full">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                <input type="date"
                       name="date_to"
                       id="date_to"
                       value="{{ $dateTo }}"
                       class="form-input w-full">
            </div>
            <div>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                    </svg>
                    Apply Filter
                </button>
            </div>
            <div>
                <a href="{{ route('attendance.leaderboard') }}" class="btn btn-outline">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                    </svg>
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Top 3 Members (Podium) -->
@if(count($leaderboard) >= 3)
<div class="mb-8">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Top Performers</h2>
        <p class="text-gray-600">{{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}</p>
    </div>

    <div class="flex justify-center items-end gap-4 max-w-4xl mx-auto">
        <!-- 2nd Place -->
        @if(isset($leaderboard[1]))
        <div class="flex-1 max-w-[250px]">
            <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl p-6 text-center transform transition-all hover:scale-105">
                <div class="mb-3">
                    <div class="w-20 h-20 mx-auto rounded-full bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center text-white text-2xl font-bold border-4 border-gray-300 shadow-lg">
                        {{ strtoupper(substr($leaderboard[1]->first_name, 0, 1)) }}{{ strtoupper(substr($leaderboard[1]->last_name, 0, 1)) }}
                    </div>
                    <div class="mt-3 w-12 h-12 mx-auto rounded-full bg-gray-400 flex items-center justify-center text-white font-bold text-xl border-2 border-white shadow">
                        2
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $leaderboard[1]->first_name }} {{ $leaderboard[1]->last_name }}</h3>
                <p class="text-3xl font-extrabold text-gray-600 mb-1">{{ number_format($leaderboard[1]->attendance_percentage, 1) }}%</p>
                <p class="text-sm text-gray-600">{{ $leaderboard[1]->total_present }} / {{ $leaderboard[1]->total_services }} services</p>
            </div>
        </div>
        @endif

        <!-- 1st Place -->
        @if(isset($leaderboard[0]))
        <div class="flex-1 max-w-[280px]">
            <div class="bg-gradient-to-br from-yellow-100 to-yellow-300 rounded-xl p-6 text-center transform transition-all hover:scale-105 shadow-xl">
                <div class="mb-3">
                    <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center text-white text-3xl font-bold border-4 border-yellow-300 shadow-lg">
                        {{ strtoupper(substr($leaderboard[0]->first_name, 0, 1)) }}{{ strtoupper(substr($leaderboard[0]->last_name, 0, 1)) }}
                    </div>
                    <div class="mt-3 w-14 h-14 mx-auto rounded-full bg-yellow-500 flex items-center justify-center text-white font-bold text-2xl border-2 border-white shadow">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $leaderboard[0]->first_name }} {{ $leaderboard[0]->last_name }}</h3>
                <p class="text-4xl font-extrabold text-yellow-700 mb-1">{{ number_format($leaderboard[0]->attendance_percentage, 1) }}%</p>
                <p class="text-sm text-gray-700">{{ $leaderboard[0]->total_present }} / {{ $leaderboard[0]->total_services }} services</p>
            </div>
        </div>
        @endif

        <!-- 3rd Place -->
        @if(isset($leaderboard[2]))
        <div class="flex-1 max-w-[250px]">
            <div class="bg-gradient-to-br from-orange-100 to-orange-200 rounded-xl p-6 text-center transform transition-all hover:scale-105">
                <div class="mb-3">
                    <div class="w-20 h-20 mx-auto rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-2xl font-bold border-4 border-orange-300 shadow-lg">
                        {{ strtoupper(substr($leaderboard[2]->first_name, 0, 1)) }}{{ strtoupper(substr($leaderboard[2]->last_name, 0, 1)) }}
                    </div>
                    <div class="mt-3 w-12 h-12 mx-auto rounded-full bg-orange-400 flex items-center justify-center text-white font-bold text-xl border-2 border-white shadow">
                        3
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $leaderboard[2]->first_name }} {{ $leaderboard[2]->last_name }}</h3>
                <p class="text-3xl font-extrabold text-orange-600 mb-1">{{ number_format($leaderboard[2]->attendance_percentage, 1) }}%</p>
                <p class="text-sm text-gray-600">{{ $leaderboard[2]->total_present }} / {{ $leaderboard[2]->total_services }} services</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endif

<!-- Full Leaderboard Table -->
<div class="card">
    <div class="card-header bg-gradient-to-r from-primary-50 to-blue-50">
        <h3 class="text-lg font-semibold text-gray-900">Complete Ranking</h3>
        <p class="text-sm text-gray-600 mt-1">All members ranked by attendance percentage</p>
    </div>

    <div class="card-body p-0">
        @if(count($leaderboard) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Rank</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Services Attended</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total Services</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Attendance %</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($leaderboard as $index => $member)
                    <tr class="hover:bg-gray-50 {{ $index < 3 ? 'bg-yellow-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($index === 0)
                                <div class="flex items-center justify-center">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-500 text-white font-bold shadow">
                                        1
                                    </span>
                                </div>
                            @elseif($index === 1)
                                <div class="flex items-center justify-center">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-400 text-white font-bold shadow">
                                        2
                                    </span>
                                </div>
                            @elseif($index === 2)
                                <div class="flex items-center justify-center">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-400 text-white font-bold shadow">
                                        3
                                    </span>
                                </div>
                            @else
                                <span class="text-gray-600 font-semibold">{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                                </div>
                                <div class="ml-3">
                                    <a href="{{ route('members.show', $member->id) }}" class="text-sm font-medium text-primary-600 hover:text-primary-800">
                                        {{ $member->first_name }} {{ $member->last_name }}
                                    </a>
                                    <div class="text-xs text-gray-500">{{ $member->member_id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="text-lg font-semibold text-green-600">{{ $member->total_present }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="text-sm text-gray-700">{{ $member->total_services }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-xl font-bold
                                    @if($member->attendance_percentage >= 90) text-green-600
                                    @elseif($member->attendance_percentage >= 70) text-blue-600
                                    @elseif($member->attendance_percentage >= 50) text-yellow-600
                                    @else text-red-600
                                    @endif">
                                    {{ number_format($member->attendance_percentage, 1) }}%
                                </span>
                                <!-- Progress Bar -->
                                <div class="w-full max-w-[100px] bg-gray-200 rounded-full h-2 mt-1">
                                    <div class="h-2 rounded-full
                                        @if($member->attendance_percentage >= 90) bg-green-600
                                        @elseif($member->attendance_percentage >= 70) bg-blue-600
                                        @elseif($member->attendance_percentage >= 50) bg-yellow-600
                                        @else bg-red-600
                                        @endif"
                                        style="width: {{ min($member->attendance_percentage, 100) }}%">
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($member->attendance_percentage >= 80)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Committed
                                </span>
                            @elseif($member->attendance_percentage >= 50)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Regular
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    At Risk
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-12 text-center text-gray-500">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Data Available</h3>
            <p class="text-gray-600">No attendance records found for the selected period. Try adjusting the date range.</p>
        </div>
        @endif
    </div>

    @if(count($leaderboard) > 0)
    <div class="card-footer bg-gray-50">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
            <div>
                <p class="text-sm text-gray-600">Total Members</p>
                <p class="text-2xl font-bold text-gray-900">{{ count($leaderboard) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Average Attendance</p>
                <p class="text-2xl font-bold text-primary-600">{{ number_format(collect($leaderboard)->avg('attendance_percentage'), 1) }}%</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Committed Members (80%+)</p>
                <p class="text-2xl font-bold text-green-600">{{ collect($leaderboard)->filter(fn($m) => $m->attendance_percentage >= 80)->count() }}</p>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Legend -->
<div class="mt-6 p-4 bg-white rounded-lg shadow-sm border border-gray-200">
    <h4 class="text-sm font-semibold text-gray-700 mb-3">Status Legend</h4>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
        <div class="flex items-center">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-2">
                Committed
            </span>
            <span class="text-gray-600">80% or higher attendance</span>
        </div>
        <div class="flex items-center">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                Regular
            </span>
            <span class="text-gray-600">50-79% attendance</span>
        </div>
        <div class="flex items-center">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 mr-2">
                At Risk
            </span>
            <span class="text-gray-600">Below 50% attendance</span>
        </div>
    </div>
</div>
@endsection
