@extends('layouts.app')

@section('title', 'Media Content Library')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Media Content Library</h1>
        <div class="flex gap-2">
            {{-- Upload Modal Trigger would go here in a real app --}}
            <button class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors text-sm font-medium shadow-sm">
                Upload Content
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Filters --}}
        <div class="p-4 border-b border-gray-100 bg-gray-50">
            <form action="{{ route('media.content') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="search" placeholder="Search content..." class="rounded-lg border-gray-300 text-sm focus:ring-primary-500 focus:border-primary-500" value="{{ request('search') }}">
                
                <select name="content_type" class="rounded-lg border-gray-300 text-sm focus:ring-primary-500 focus:border-primary-500">
                    <option value="">All Types</option>
                    <option value="sermon_video" {{ request('content_type') == 'sermon_video' ? 'selected' : '' }}>Sermon Video</option>
                    <option value="sermon_audio" {{ request('content_type') == 'sermon_audio' ? 'selected' : '' }}>Sermon Audio</option>
                    <option value="worship_session" {{ request('content_type') == 'worship_session' ? 'selected' : '' }}>Worship Session</option>
                    <option value="photo_gallery" {{ request('content_type') == 'photo_gallery' ? 'selected' : '' }}>Photo Gallery</option>
                </select>

                <select name="is_published" class="rounded-lg border-gray-300 text-sm focus:ring-primary-500 focus:border-primary-500">
                    <option value="">All Status</option>
                    <option value="1" {{ request('is_published') == '1' ? 'selected' : '' }}>Published</option>
                    <option value="0" {{ request('is_published') == '0' ? 'selected' : '' }}>Draft</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors text-sm font-medium">
                    Filter
                </button>
            </form>
        </div>

        {{-- Content Grid --}}
        <div class="p-6">
            @if(count($content) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($content as $item)
                        <div class="group relative bg-white rounded-lg border border-gray-200 hover:shadow-md transition-all overflow-hidden">
                            {{-- Thumbnail Placeholder --}}
                            <div class="aspect-video bg-gray-100 w-full flex items-center justify-center">
                                @if($item->thumbnail_path)
                                    <img src="{{ asset('storage/' . $item->thumbnail_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @endif
                            </div>
                            
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600 capitalize">
                                        {{ str_replace('_', ' ', $item->content_type) }}
                                    </span>
                                    <span class="text-xs text-gray-400">{{ $item->content_date->format('M d') }}</span>
                                </div>
                                <h3 class="font-semibold text-gray-900 truncate" title="{{ $item->title }}">{{ $item->title }}</h3>
                                <p class="text-xs text-gray-500 mt-1">{{ number_format($item->views_count ?? 0) }} views</p>
                                
                                <div class="mt-4 flex justify-end gap-2">
                                    <a href="#" class="text-xs text-gray-500 hover:text-primary-600 font-medium">Edit</a>
                                    @if(!$item->is_published)
                                        <form action="{{ route('media.content.publish', $item) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-xs text-primary-600 hover:text-primary-800 font-medium">Publish</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6">
                    {{ $content->links() }}
                </div>
            @else
                <div class="text-center py-12 text-gray-500">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
                    <p class="text-lg font-medium">No media content found.</p>
                    <p class="text-sm mt-1">Try adjusting filters or upload new content.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
