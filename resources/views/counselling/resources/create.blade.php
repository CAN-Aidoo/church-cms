@extends('layouts.app')

@section('title', 'Add Resource')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Add New Resource') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <form method="POST" action="{{ route('counselling.resources.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Resource Type</label>
                        <select name="resource_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @foreach($resourceTypes ?? ['article' => 'Article', 'book' => 'Book', 'video' => 'Video'] as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                     <div>
                        <label class="block text-sm font-medium text-gray-700">Categories</label>
                        <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-2">
                            @foreach($categories ?? ['General'] as $cat)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="categories[]" value="{{ $cat }}" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                    <span class="ml-2">{{ $cat }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">External URL</label>
                        <input type="url" name="external_url" value="{{ old('external_url') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">File Upload</label>
                        <input type="file" name="file" class="mt-1 block w-full">
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('counselling.resources') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add Resource
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
