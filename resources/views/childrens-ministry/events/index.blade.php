@extends('layouts.app')

@section('title', 'Children\'s Events')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
        </h2>
        <a href="{{ route('childrens-ministry.events.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Create Event
        </a>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col h-full">
                <div class="p-6 border-b border-gray-200 flex-1">
                    <div class="flex justify-between items-start mb-2">
                        <span class="px-2 py-1 text-xs rounded bg-purple-100 text-purple-800 capitalize">{{ str_replace('_', ' ', $event->event_type) }}</span>
                        <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-800 capitalize">{{ $event->status }}</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">{{ $event->event_name }}</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        {{ $event->start_date->format('M d, Y') }} at {{ $event->start_time->format('H:i') }}
                    </p>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-3">{{ $event->description }}</p>
                </div>
                <div class="p-4 bg-gray-50 border-t border-gray-200 text-center">
                    <a href="{{ route('childrens-ministry.events.show', $event) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">View Details</a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-lg border border-dashed border-gray-300">
                <p class="text-gray-500">No events found.</p>
            </div>
        @endforelse
    </div>
@endsection
