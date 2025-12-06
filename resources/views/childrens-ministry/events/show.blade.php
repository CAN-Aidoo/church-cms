@extends('layouts.app')

@section('title', $event->event_name)

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $event->event_name }}
        </h2>
        <div class="flex gap-2">
             @if($event->status == 'draft')
                <form action="{{ route('childrens-ministry.events.publish', $event) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Publish
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <span class="text-gray-500 text-sm">Date</span>
                            <p class="font-medium">{{ $event->start_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500 text-sm">Time</span>
                            <p class="font-medium">{{ $event->start_time->format('H:i') }} - {{ $event->end_time ? $event->end_time->format('H:i') : '...' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500 text-sm">Location</span>
                            <p class="font-medium">{{ $event->location ?? 'TBD' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500 text-sm">Cost</span>
                            <p class="font-medium">{{ $event->registration_fee > 0 ? '$'.number_format($event->registration_fee, 2) : 'Free' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500 text-sm">Coordinator</span>
                            <p class="font-medium">{{ $event->coordinator->name ?? 'Unknown' }}</p>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-2">Description</h3>
                    <div class="prose max-w-none mb-6">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>
            </div>

            <!-- Registrations -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Registrations ({{ $registrations->count() }})</h3>
                    
                    @if($registrations->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                        <th class="text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="text-left text-xs font-medium text-gray-500 uppercase">Paid</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($registrations as $reg)
                                        <tr>
                                            <td class="py-3">{{ $reg->child->full_name }}</td>
                                            <td class="py-3 capitalize">{{ $reg->status }}</td>
                                            <td class="py-3">{{ $reg->amount_paid > 0 ? 'Yes' : 'No' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No registrations yet.</p>
                    @endif

                    <!-- Simple Registration Form for Demo -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="font-medium mb-2">Register Child</h4>
                        <form action="{{ route('childrens-ministry.events.register', $event) }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="number" name="child_id" placeholder="Child ID" class="rounded-md border-gray-300 shadow-sm" required>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
             <!-- Stats/Target Audience -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Target Audience</h3>
                @if($event->age_groups)
                    <div class="flex flex-wrap gap-2">
                        @foreach($event->age_groups as $group)
                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded capitalize">{{ $group }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">All ages</p>
                @endif
            </div>
        </div>
    </div>
@endsection
