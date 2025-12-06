@extends('layouts.app')

@section('title', $resource->title)

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $resource->title }}
    </h2>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                <span class="capitalize bg-gray-100 px-2 py-1 rounded">{{ $resource->resource_type }}</span>
                <span>Added {{ $resource->created_at->format('M d, Y') }}</span>
                <span>By {{ $resource->creator->name ?? 'Unknown' }}</span>
            </div>

            <div class="prose max-w-none mb-8">
                <h3 class="text-lg font-semibold">Description</h3>
                <p>{{ $resource->description }}</p>
                
                @if($resource->content)
                    <hr class="my-4">
                    <h3 class="text-lg font-semibold">Content</h3>
                    {!! nl2br(e($resource->content)) !!}
                @endif
            </div>

            <div class="flex flex-col gap-4">
                @if($resource->external_url)
                    <a href="{{ $resource->external_url }}" target="_blank" class="inline-flex items-center text-blue-600 hover:underline">
                        Visit External Resource
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                @endif

                @if($resource->file_path)
                    <a href="{{ route('counselling.resources.download', $resource) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Download File
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
