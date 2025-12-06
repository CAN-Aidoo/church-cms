@extends('layouts.app')

@section('title', 'Curriculum Lessons')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Curriculum') }}
        </h2>
        <a href="{{ route('childrens-ministry.curriculum.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Create Lesson
        </a>
    </div>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 border-b border-gray-200">
            <form method="GET" action="{{ route('childrens-ministry.curriculum') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Title, topic..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Age Group</label>
                    <select name="age_group" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">All Groups</option>
                        <option value="nursery">Nursery</option>
                        <option value="primary">Primary</option>
                        {{-- Add other options --}}
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                        Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($lessons as $lesson)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col h-full">
                <div class="p-6 border-b border-gray-200 flex-1">
                    <div class="flex justify-between items-start mb-2">
                        <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800 capitalize">{{ $lesson->age_group }}</span>
                        @if($lesson->is_published)
                            <span class="text-green-600 text-xs font-semibold">Published</span>
                        @else
                            <span class="text-gray-500 text-xs font-semibold">Draft</span>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold mb-2">{{ $lesson->title }}</h3>
                    <p class="text-sm text-gray-600 mb-2">Series: {{ $lesson->series ?? 'Standalone' }}</p>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-3">{{ $lesson->lesson_objective }}</p>
                    
                    <div class="flex items-center text-xs text-gray-500 gap-4">
                        <span>{{ $lesson->duration_minutes }} mins</span>
                        <span>Ref: {{ $lesson->bible_reference }}</span>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-2">
                    <a href="{{ route('childrens-ministry.curriculum.show', $lesson) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">View</a>
                    <a href="{{ route('childrens-ministry.curriculum.edit', $lesson) }}" class="text-gray-600 hover:text-gray-800 font-medium text-sm">Edit</a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-lg border border-dashed border-gray-300">
                <p class="text-gray-500">No curriculum lessons found.</p>
            </div>
        @endforelse
    </div>
    
    @if($lessons instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-6">
            {{ $lessons->links() }}
        </div>
    @endif
@endsection
