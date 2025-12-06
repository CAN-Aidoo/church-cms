@extends('layouts.app')

@section('title', 'Add Counsellor')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Add New Counsellor') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form method="POST" action="{{ route('counselling.counsellors.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Select User</label>
                        {{-- Ideally a user search/select --}}
                        <input type="number" name="user_id" placeholder="User ID" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">License Number</label>
                        <input type="text" name="license_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Specializations</label>
                        <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-2">
                            @foreach($specializations ?? ['Marriage', 'Youth', 'Grief', 'Addiction', 'General'] as $spec)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="specializations[]" value="{{ $spec }}" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                    <span class="ml-2">{{ $spec }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Max Sessions/Week</label>
                        <input type="number" name="max_sessions_per_week" value="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Session Duration (Minutes)</label>
                        <input type="number" name="session_duration_minutes" value="60" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Bio</label>
                        <textarea name="bio" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('counselling.counsellors') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add Counsellor
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
