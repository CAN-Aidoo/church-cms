@extends('layouts.app')

@section('title', 'Book Session')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Book Counselling Session') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form method="POST" action="{{ route('counselling.sessions.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Member (ID)</label>
                        <input type="number" name="member_id" value="{{ $member ? $member->id : old('member_id') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Counsellor (ID)</label>
                        <input type="number" name="counsellor_id" value="{{ old('counsellor_id') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="session_date" value="{{ old('session_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>

                     <div>
                        <label class="block text-sm font-medium text-gray-700">Time</label>
                        <input type="time" name="session_time" value="{{ old('session_time') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Session Type</label>
                        <select name="session_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @foreach($sessionTypes ?? ['general' => 'General'] as $key => $label)
                                <option value="{{ $key }}" {{ old('session_type') == $key ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $key)) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                         <label class="block text-sm font-medium text-gray-700">Mode</label>
                        <select name="mode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="in_person">In Person</option>
                            <option value="video">Video</option>
                            <option value="phone">Phone</option>
                        </select>
                    </div>

                     <div>
                         <label class="block text-sm font-medium text-gray-700">Urgency</label>
                        <select name="urgency_level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Booking Notes</label>
                        <textarea name="booking_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('booking_notes') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('counselling.sessions.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Book Session
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
