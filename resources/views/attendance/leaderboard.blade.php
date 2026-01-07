@extends('layouts.app')

@section('title', 'Attendance Leaderboard')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-heading font-bold text-slate-900">Attendance Leaderboard</h1>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mt-1">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('attendance.index') }}" class="hover:text-primary-600 transition-colors">Attendance</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">Leaderboard</span>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('attendance.reports') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Full Reports
        </a>
        <a href="{{ route('attendance.index') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            Back to Attendance
        </a>
    </div>
</div>

<!-- Date Filter Card -->
<div class="card border border-slate-100 mb-8">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
        <h3 class="font-bold text-slate-800 text-base">Filter Period</h3>
        <p class="text-sm text-slate-500 mt-0.5">Select date range to view leaderboard statistics</p>
    </div>
    <div class="p-6">
        <form method="GET" action="{{ route('attendance.leaderboard') }}" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-1/3">
                <label for="date_from" class="form-label mb-1.5 block font-medium text-sm text-slate-700">From Date</label>
                <input type="date"
                       name="date_from"
                       id="date_from"
                       value="{{ $dateFrom }}"
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
            </div>
            <div class="w-full md:w-1/3">
                <label for="date_to" class="form-label mb-1.5 block font-medium text-sm text-slate-700">To Date</label>
                <input type="date"
                       name="date_to"
                       id="date_to"
                       value="{{ $dateTo }}"
                       class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500">
            </div>
            <div class="w-full md:w-auto flex gap-2">
                <button type="submit" class="btn btn-primary flex-1 md:flex-none">
                    Apply Filter
                </button>
                <a href="{{ route('attendance.leaderboard') }}" class="btn bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors flex-1 md:flex-none">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Top 3 Members (Podium) -->
@if(count($leaderboard) >= 3)
<div class="mb-10">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-heading font-bold text-slate-900">Top Performers</h2>
        <p class="text-slate-500 mt-1">{{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}</p>
    </div>

    <div class="flex flex-col md:flex-row justify-center items-end gap-6 max-w-4xl mx-auto px-4">
        <!-- 2nd Place -->
        @if(isset($leaderboard[1]))
        <div class="w-full md:flex-1 max-w-[280px] order-2 md:order-1">
            <div class="bg-white rounded-2xl p-6 text-center border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-slate-300"></div>
                <div class="mb-4 relative">
                    <div class="w-20 h-20 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-500 text-2xl font-bold border-4 border-white shadow-lg ring-1 ring-slate-100">
                        {{ strtoupper(substr($leaderboard[1]->first_name, 0, 1)) }}{{ strtoupper(substr($leaderboard[1]->last_name, 0, 1)) }}
                    </div>
                    <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-sm border-2 border-white shadow-sm">
                        2
                    </div>
                </div>
                <h3 class="font-bold text-slate-900 mb-1 truncate">{{ $leaderboard[1]->first_name }} {{ $leaderboard[1]->last_name }}</h3>
                <p class="text-2xl font-black text-slate-700 mb-1">{{ number_format($leaderboard[1]->attendance_percentage, 1) }}%</p>
                <p class="text-xs text-slate-500 font-medium">{{ $leaderboard[1]->total_present }} / {{ $leaderboard[1]->total_services }} services</p>
            </div>
        </div>
        @endif

        <!-- 1st Place -->
        @if(isset($leaderboard[0]))
        <div class="w-full md:flex-1 max-w-[320px] order-1 md:order-2 z-10 -mt-8 md:mt-0">
            <div class="bg-white rounded-2xl p-8 text-center border border-amber-200 shadow-xl relative overflow-hidden transform md:-translate-y-4">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-amber-300 via-amber-500 to-amber-300"></div>
                <div class="mb-5 relative">
                    <div class="w-24 h-24 mx-auto rounded-full bg-amber-50 flex items-center justify-center text-amber-600 text-3xl font-bold border-4 border-white shadow-lg ring-1 ring-amber-100">
                        {{ strtoupper(substr($leaderboard[0]->first_name, 0, 1)) }}{{ strtoupper(substr($leaderboard[0]->last_name, 0, 1)) }}
                    </div>
                    <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-10 h-10 rounded-full bg-amber-500 text-white flex items-center justify-center font-bold text-lg border-4 border-white shadow-md">
                        1
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1 truncate">{{ $leaderboard[0]->first_name }} {{ $leaderboard[0]->last_name }}</h3>
                <p class="text-4xl font-black text-amber-500 mb-1">{{ number_format($leaderboard[0]->attendance_percentage, 1) }}%</p>
                <p class="text-sm text-slate-500 font-medium">{{ $leaderboard[0]->total_present }} / {{ $leaderboard[0]->total_services }} services</p>
                <div class="mt-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                        Top Attender
                    </span>
                </div>
            </div>
        </div>
        @endif

        <!-- 3rd Place -->
        @if(isset($leaderboard[2]))
        <div class="w-full md:flex-1 max-w-[280px] order-3">
            <div class="bg-white rounded-2xl p-6 text-center border border-orange-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-orange-300"></div>
                <div class="mb-4 relative">
                    <div class="w-20 h-20 mx-auto rounded-full bg-orange-50 flex items-center justify-center text-orange-600 text-2xl font-bold border-4 border-white shadow-lg ring-1 ring-orange-100">
                        {{ strtoupper(substr($leaderboard[2]->first_name, 0, 1)) }}{{ strtoupper(substr($leaderboard[2]->last_name, 0, 1)) }}
                    </div>
                    <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-orange-400 text-white flex items-center justify-center font-bold text-sm border-2 border-white shadow-sm">
                        3
                    </div>
                </div>
                <h3 class="font-bold text-slate-900 mb-1 truncate">{{ $leaderboard[2]->first_name }} {{ $leaderboard[2]->last_name }}</h3>
                <p class="text-2xl font-black text-orange-600 mb-1">{{ number_format($leaderboard[2]->attendance_percentage, 1) }}%</p>
                <p class="text-xs text-slate-500 font-medium">{{ $leaderboard[2]->total_present }} / {{ $leaderboard[2]->total_services }} services</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endif

<!-- Full Leaderboard Table -->
<div class="card border border-slate-100 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
        <h3 class="font-bold text-slate-800 text-base">Complete Ranking</h3>
        <p class="text-sm text-slate-500 mt-0.5">All members ranked by attendance percentage</p>
    </div>

    <div class="overflow-x-auto">
        @if(count($leaderboard) > 0)
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 w-20 text-center">Rank</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100">Member</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 text-center">Services Attended</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 text-center">Total Services</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 text-center">Attendance %</th>
                    <th class="px-6 py-3 font-semibold border-b border-slate-100 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 bg-white">
                @foreach($leaderboard as $index => $member)
                <tr class="hover:bg-slate-50/50 transition-colors {{ $index < 3 ? 'bg-amber-50/30' : '' }}">
                    <td class="px-6 py-4 text-center">
                        @if($index === 0)
                            <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-sm mx-auto ring-1 ring-amber-200">1</div>
                        @elseif($index === 1)
                            <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm mx-auto ring-1 ring-slate-200">2</div>
                        @elseif($index === 2)
                            <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-700 flex items-center justify-center font-bold text-sm mx-auto ring-1 ring-orange-200">3</div>
                        @else
                            <span class="text-slate-500 font-medium">{{ $index + 1 }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500">
                                {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                            </div>
                            <div>
                                <a href="{{ route('members.show', $member->id) }}" class="font-medium text-slate-900 hover:text-primary-600 transition-colors">
                                    {{ $member->first_name }} {{ $member->last_name }}
                                </a>
                                <div class="text-xs text-slate-500 font-mono">{{ $member->member_id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="font-bold text-slate-700">{{ $member->total_present }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-slate-500">{{ $member->total_services }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col items-center gap-1">
                            <span class="font-bold cursor-default
                                @if($member->attendance_percentage >= 90) text-emerald-600
                                @elseif($member->attendance_percentage >= 70) text-blue-600
                                @elseif($member->attendance_percentage >= 50) text-amber-600
                                @else text-red-600
                                @endif">
                                {{ number_format($member->attendance_percentage, 1) }}%
                            </span>
                            <div class="w-24 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                <div class="h-1.5 rounded-full transition-all duration-500
                                    @if($member->attendance_percentage >= 90) bg-emerald-500
                                    @elseif($member->attendance_percentage >= 70) bg-blue-500
                                    @elseif($member->attendance_percentage >= 50) bg-amber-500
                                    @else bg-red-500
                                    @endif"
                                    style="width: {{ min($member->attendance_percentage, 100) }}%">
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($member->attendance_percentage >= 80)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                Committed
                            </span>
                        @elseif($member->attendance_percentage >= 50)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 ring-1 ring-inset ring-blue-600/20">
                                Regular
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 ring-1 ring-inset ring-red-600/20">
                                At Risk
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="p-12 text-center text-slate-400">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center text-slate-300">
                 <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-1">No Data Available</h3>
            <p class="text-slate-500">No attendance records found for the selected period.</p>
        </div>
        @endif
    </div>

    @if(count($leaderboard) > 0)
    <div class="bg-slate-50 border-t border-slate-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center divide-y md:divide-y-0 md:divide-x divide-slate-200">
            <div class="pb-4 md:pb-0 md:px-4">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Members</p>
                <p class="text-3xl font-heading font-bold text-slate-900 mt-1">{{ count($leaderboard) }}</p>
            </div>
            <div class="py-4 md:py-0 md:px-4">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Average Attendance</p>
                <p class="text-3xl font-heading font-bold text-primary-600 mt-1">{{ number_format(collect($leaderboard)->avg('attendance_percentage'), 1) }}%</p>
            </div>
            <div class="pt-4 md:pt-0 md:px-4">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Committed Members</p>
                <p class="text-3xl font-heading font-bold text-emerald-600 mt-1">{{ collect($leaderboard)->filter(fn($m) => $m->attendance_percentage >= 80)->count() }}</p>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Legend -->
<div class="card border border-slate-100 p-4">
    <h4 class="text-sm font-bold text-slate-800 mb-3">Status Legend</h4>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
        <div class="flex items-center p-3 rounded-lg bg-emerald-50/50 border border-emerald-100">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-800 mr-2">
                Committed
            </span>
            <span class="text-slate-600">80% or higher attendance</span>
        </div>
        <div class="flex items-center p-3 rounded-lg bg-blue-50/50 border border-blue-100">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-blue-100 text-blue-800 mr-2">
                Regular
            </span>
            <span class="text-slate-600">50-79% attendance</span>
        </div>
        <div class="flex items-center p-3 rounded-lg bg-red-50/50 border border-red-100">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-800 mr-2">
                At Risk
            </span>
            <span class="text-slate-600">Below 50% attendance</span>
        </div>
    </div>
</div>
@endsection
