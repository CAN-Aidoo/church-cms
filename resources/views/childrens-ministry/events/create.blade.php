@extends('layouts.app')

@section('title', 'Create Event')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Create Event') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form method="POST" action="{{ route('childrens-ministry.events.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Event Name</label>
                        <input type="text" name="event_name" value="{{ old('event_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Event Type</label>
                        <select name="event_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            @foreach($eventTypes as $type => $label)
                                <option value="{{ $type }}" {{ old('event_type') == $type ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $type)) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Coordinator (User ID)</label>
                        {{-- Demo input, normally a select of users --}}
                        <input type="number" name="coordinator_id" value="{{ old('coordinator_id', auth()->id()) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>

                     <div>
                        <label class="block text-sm font-medium text-gray-700">Start Time</label>
                        <input type="time" name="start_time" value="{{ old('start_time') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('childrens-ministry.events') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Create Event
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
