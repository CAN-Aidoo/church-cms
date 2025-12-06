@extends('layouts.app')

@section('title', 'Create Lesson')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Create Curriculum Lesson') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form method="POST" action="{{ route('childrens-ministry.curriculum.store') }}">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Series</label>
                        <input type="text" name="series" value="{{ old('series') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Age Group</label>
                        <select name="age_group" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            @foreach($ageGroups as $key => $label)
                                <option value="{{ $key }}" {{ old('age_group') == $key ? 'selected' : '' }}>{{ ucfirst($key) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bible Reference</label>
                        <input type="text" name="bible_reference" value="{{ old('bible_reference') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Memory Verse</label>
                        <input type="text" name="memory_verse" value="{{ old('memory_verse') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>
                    
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Lesson Objective</label>
                        <textarea name="lesson_objective" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('lesson_objective') }}</textarea>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Bible Story</label>
                        <textarea name="bible_story" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>{{ old('bible_story') }}</textarea>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Full Content</label>
                        <textarea name="lesson_content" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('lesson_content') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('childrens-ministry.curriculum') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Create Lesson
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
