@extends('layouts.app')

@section('title', $lesson->title)

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $lesson->title }}
        </h2>
        <div class="flex gap-2">
            @if(!$lesson->is_published)
                <form action="{{ route('childrens-ministry.curriculum.publish', $lesson) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Publish
                    </button>
                </form>
            @endif
            <a href="{{ route('childrens-ministry.curriculum.edit', $lesson) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Main Content -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <span class="text-gray-500 text-sm">Bible Reference</span>
                            <p class="font-medium">{{ $lesson->bible_reference }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500 text-sm">Memory Verse</span>
                            <p class="font-medium">{{ $lesson->memory_verse }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500 text-sm">Age Group</span>
                            <p class="font-medium capitalize">{{ $lesson->age_group }}</p>
                        </div>
                         <div>
                            <span class="text-gray-500 text-sm">Duration</span>
                            <p class="font-medium">{{ $lesson->duration_minutes }} minutes</p>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-semibold mb-2">Lesson Content</h3>
                    <div class="prose max-w-none mb-6">
                        {!! nl2br(e($lesson->lesson_content)) !!}
                    </div>

                    <h3 class="text-lg font-semibold mb-2">Bible Story</h3>
                    <div class="prose max-w-none">
                        {!! nl2br(e($lesson->bible_story)) !!}
                    </div>
                </div>
            </div>

            <!-- Activities -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Activities & Crafts</h3>
                    @if($lesson->activities)
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-700 mb-2">Activities</h4>
                            <ul class="list-disc list-inside text-gray-600">
                                @foreach($lesson->activities as $activity)
                                    <li>{{ $activity }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if($lesson->craft_projects)
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Craft Projects</h4>
                            <ul class="list-disc list-inside text-gray-600">
                                @foreach($lesson->craft_projects as $craft)
                                    <li>{{ $craft }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Lesson Info</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Status</dt>
                        <dd class="font-medium {{ $lesson->is_published ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ $lesson->is_published ? 'Published' : 'Draft' }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Created By</dt>
                        <dd class="font-medium">{{ $lesson->creator->name ?? 'Unknown' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Last Updated</dt>
                        <dd class="font-medium">{{ $lesson->updated_at->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Resources</h3>
                @if($lesson->resources)
                    <ul class="space-y-2">
                        @foreach($lesson->resources as $resource)
                            <li class="flex items-center text-sm text-blue-600 hover:underline cursor-pointer">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                                {{ $resource }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500">No resources attached.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
