@extends('layouts.app')

@section('title', 'Session Details')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Session Details') }}
    </h2>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Session Information</h3>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-500">Date & Time</p>
                            <p class="font-medium">{{ $session->session_date->format('M d, Y') }} @ {{ $session->session_time->format('H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="font-medium capitalize">{{ $session->status }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Type</p>
                            <p class="font-medium capitalize">{{ str_replace('_', ' ', $session->session_type) }}</p>
                        </div>
                         <div>
                            <p class="text-sm text-gray-500">Mode</p>
                            <p class="font-medium capitalize">{{ $session->mode }}</p>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-semibold mb-2">Notes</h3>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p>{{ $session->session_notes ?? 'No notes recorded.' }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions/Update Form -->
             <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Update Session</h3>
                    <form action="{{ route('counselling.sessions.update', $session) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Session Notes</label>
                                <textarea name="session_notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('session_notes', $session->session_notes) }}</textarea>
                            </div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save Notes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="space-y-6">
             <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Participants</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Counselee</p>
                        <p class="font-medium text-lg">{{ $session->member->full_name ?? 'Unknown' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Counsellor</p>
                        <p class="font-medium text-lg">{{ $session->counsellor->user->name ?? 'Unknown' }}</p>
                    </div>
                </div>
            </div>

             <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Actions</h3>
                <div class="space-y-2">
                    @if($session->status == 'scheduled')
                        <form action="{{ route('counselling.sessions.confirm', $session) }}" method="POST">
                            @csrf
                            <button class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Confirm</button>
                        </form>
                         <form action="{{ route('counselling.sessions.cancel', $session) }}" method="POST">
                            @csrf
                            <input type="hidden" name="cancellation_reason" value="Cancelled by user">
                            <button class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Cancel</button>
                        </form>
                    @endif
                     @if($session->status == 'confirmed')
                         <form action="{{ route('counselling.sessions.start', $session) }}" method="POST">
                            @csrf
                            <button class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Start Session</button>
                        </form>
                     @endif
                </div>
            </div>
        </div>
    </div>
@endsection
