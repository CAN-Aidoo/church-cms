@extends('layouts.app')

@section('title', 'Anniversary Milestones')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('birthdays.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Anniversary Milestones</h1>
        </div>
        <p class="text-gray-600">Track and celebrate special anniversaries</p>
    </div>

    <!-- Special Milestones Alert -->
    @if($specialMilestones->isNotEmpty())
    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-start gap-4">
            <div class="text-5xl">⭐</div>
            <div class="flex-1 text-yellow-900">
                <h2 class="text-2xl font-bold mb-2">Special Milestones Approaching!</h2>
                <p class="text-yellow-800">{{ $specialMilestones->count() }} special milestone(s) need recognition (25th, 50th anniversaries, etc.)</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Special Milestones -->
    @if($specialMilestones->isNotEmpty())
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
            </svg>
            Special Milestones Needing Recognition
        </h2>

        <div class="space-y-4">
            @foreach($specialMilestones as $milestone)
            <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-2 border-yellow-400 rounded-lg p-4">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="text-4xl">⭐</div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $milestone->member->full_name }}</h3>
                            <p class="text-md text-purple-700 font-semibold mt-1">{{ $milestone->description }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $milestone->milestone_date->format('F d, Y') }}</p>
                            @if($milestone->isThisWeek())
                            <span class="inline-block px-3 py-1 bg-red-500 text-white rounded-full text-xs font-bold mt-2">
                                THIS WEEK!
                            </span>
                            @endif
                        </div>
                    </div>
                    <form action="{{ route('birthdays.recognize-milestone', $milestone) }}" method="POST">
                        @csrf
                        <button type="submit"
                                onclick="return confirm('Mark this milestone as recognized?')"
                                class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                            Mark Recognized
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Upcoming Milestones -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Upcoming Milestones (Next 90 Days)</h2>

        @if($upcomingMilestones->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Milestone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($upcomingMilestones as $milestone)
                    <tr class="hover:bg-gray-50 {{ $milestone->is_special ? 'bg-yellow-50' : '' }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($milestone->member->photo_url)
                                <img src="{{ $milestone->member->photo_url }}" alt="{{ $milestone->member->full_name }}"
                                     class="w-10 h-10 rounded-full object-cover">
                                @else
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($milestone->member->first_name, 0, 1) . substr($milestone->member->last_name, 0, 1)) }}
                                </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-900">{{ $milestone->member->full_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $milestone->member->phone }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $milestone->years_completed }} Years</p>
                            @if($milestone->is_special)
                            <span class="text-yellow-600">⭐ Special</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $milestone->milestone_date->format('M d, Y') }}
                            @if($milestone->isThisWeek())
                            <span class="block text-xs text-red-600 font-semibold">This week!</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded text-xs font-medium">
                                {{ ucwords(str_replace('_', ' ', $milestone->milestone_type)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('birthdays.recognize-milestone', $milestone) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Mark as recognized?')"
                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    Mark Recognized
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">🎯</div>
            <p class="text-gray-600">No upcoming milestones in the next 90 days</p>
        </div>
        @endif
    </div>

    <!-- Recently Recognized -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Recently Recognized Milestones</h2>

        @if($recognizedMilestones->isNotEmpty())
        <div class="space-y-3">
            @foreach($recognizedMilestones as $milestone)
            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="text-2xl">✅</div>
                    <div>
                        <p class="font-semibold text-gray-900">{{ $milestone->member->full_name }}</p>
                        <p class="text-sm text-gray-600">{{ $milestone->description }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Recognized on</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $milestone->recognized_on->format('M d, Y') }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8">
            <p class="text-gray-600">No milestones recognized yet</p>
        </div>
        @endif
    </div>
</div>
@endsection
