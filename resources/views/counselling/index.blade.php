@extends('layouts.app')

@section('title', 'Counselling Dashboard')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Counselling Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2">Pending Sessions</h3>
            <p class="text-3xl font-bold text-orange-500">{{ $statistics['pending_sessions'] ?? 0 }}</p>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2">Active Cases</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $statistics['active_cases'] ?? 0 }}</p>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-2">Available Counsellors</h3>
            <p class="text-3xl font-bold text-green-600">{{ $statistics['available_counsellors'] ?? 0 }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Today's Sessions</h3>
                @if(isset($todaysSessions) && count($todaysSessions) > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach($todaysSessions as $session)
                            <li class="py-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium">{{ $session->member->full_name ?? 'Unknown' }}</p>
                                        <p class="text-sm text-gray-500">{{ $session->session_time->format('H:i') }} with {{ $session->counsellor->user->name ?? 'Counsellor' }}</p>
                                    </div>
                                    <a href="{{ route('counselling.sessions.show', $session) }}" class="text-blue-600 hover:text-blue-800 text-sm">View</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No sessions scheduled for today.</p>
                @endif
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Recent Active Cases</h3>
                @if(isset($activeCases) && count($activeCases) > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach($activeCases->take(5) as $case)
                            <li class="py-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium">{{ $case->case_title }}</p>
                                        <p class="text-sm text-gray-500">{{ $case->member->full_name ?? 'Unknown Member' }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">{{ $case->priority }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No active cases.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
