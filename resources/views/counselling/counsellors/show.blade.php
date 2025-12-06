@extends('layouts.app')

@section('title', 'Counsellor Profile')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $counsellor->user->name ?? 'Counsellor Profile' }}
    </h2>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Profile Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">License Number</p>
                            <p class="font-medium">{{ $counsellor->license_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Availability</p>
                            <p class="font-medium capitalize">{{ $counsellor->availability_status }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Specializations</p>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @foreach($counsellor->specializations ?? [] as $spec)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm">{{ $spec }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Bio</p>
                            <p class="mt-1">{{ $counsellor->bio }}</p>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Active Cases -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Active Cases ({{ $activeCases->count() }})</h3>
                    @if($activeCases->count() > 0)
                        <ul class="divide-y divide-gray-200">
                            @foreach($activeCases as $case)
                                <li class="py-3">
                                    <div class="flex justify-between">
                                        <span>{{ $case->case_title }}</span>
                                        <a href="{{ route('counselling.cases.show', $case) }}" class="text-sm text-blue-600">View</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">No active cases assigned.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Performance Stats</h3>
                <dl class="space-y-2">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Total Sessions</dt>
                        <dd class="font-bold">{{ $statistics['total_sessions'] ?? 0 }}</dd>
                    </div>
                     <div class="flex justify-between">
                        <dt class="text-gray-500">This Month</dt>
                        <dd class="font-bold">{{ $statistics['month_sessions'] ?? 0 }}</dd>
                    </div>
                </dl>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Actions</h3>
                @if($counsellor->is_active)
                    <form action="{{ route('counselling.counsellors.deactivate', $counsellor) }}" method="POST">
                        @csrf
                        <button class="w-full bg-red-100 hover:bg-red-200 text-red-800 font-bold py-2 px-4 rounded mb-2">
                            Deactivate
                        </button>
                    </form>
                @else
                    <form action="{{ route('counselling.counsellors.activate', $counsellor) }}" method="POST">
                        @csrf
                        <button class="w-full bg-green-100 hover:bg-green-200 text-green-800 font-bold py-2 px-4 rounded mb-2">
                            Activate
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
