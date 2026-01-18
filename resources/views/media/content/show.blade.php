@extends('layouts.app')

@section('title', $content->title)

@section('content')
<!-- Header -->
<div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6 mb-8">
    <div>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-2">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('media.index') }}" class="hover:text-primary-600 transition-colors">Media</a>
            <span>/</span>
            <a href="{{ route('media.content') }}" class="hover:text-primary-600 transition-colors">Content</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">{{ $content->title }}</span>
        </nav>

        <div class="flex items-center gap-3">
            <h1 class="text-3xl font-heading font-bold text-slate-900">{{ $content->title }}</h1>
            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $content->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                {{ $content->is_published ? 'Published' : 'Draft' }}
            </span>
            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-slate-100 text-slate-700 capitalize">
                {{ ucwords(str_replace('_', ' ', $content->content_type)) }}
            </span>
        </div>
    </div>

    <div class="flex flex-wrap gap-2">
        @if(!$content->is_published)
            <form action="{{ route('media.content.publish', $content) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn btn-success shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Publish
                </button>
            </form>
        @endif

        <a href="{{ route('media.content.edit', $content) }}" class="btn btn-outline-primary">
            Edit
        </a>

        <form action="{{ route('media.content.destroy', $content) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this content? All associated files will be removed.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                Delete
            </button>
        </form>
    </div>
</div>

<!-- Content Details -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Media Files -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Media Files</h2>
            </div>
            <div class="card-body">
                @if($content->file_paths && count($content->file_paths) > 0)
                    <div class="space-y-4">
                        @foreach($content->file_paths as $index => $filePath)
                            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                                        @if(str_contains($content->content_type, 'video'))
                                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                        @elseif(str_contains($content->content_type, 'audio'))
                                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                            </svg>
                                        @elseif(str_contains($content->content_type, 'photo'))
                                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-900">File {{ $index + 1 }}</p>
                                        <p class="text-sm text-slate-600">{{ basename($filePath) }}</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $filePath) }}" target="_blank" class="text-primary-600 hover:text-primary-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-slate-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <p>No media files available</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Description -->
        @if($content->description)
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Description</h2>
            </div>
            <div class="card-body">
                <div class="prose max-w-none text-slate-700">
                    {!! nl2br(e($content->description)) !!}
                </div>
            </div>
        </div>
        @endif

        <!-- Metadata -->
        @if($content->metadata)
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Additional Metadata</h2>
            </div>
            <div class="card-body">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($content->metadata as $key => $value)
                        <div>
                            <dt class="text-sm font-medium text-slate-500">{{ ucwords(str_replace('_', ' ', $key)) }}</dt>
                            <dd class="mt-1 text-sm text-slate-900">{{ is_array($value) ? json_encode($value) : $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Content Info -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Content Info</h2>
            </div>
            <div class="card-body space-y-4">
                <div>
                    <dt class="text-sm font-medium text-slate-500">Content Date</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ \Carbon\Carbon::parse($content->content_date)->format('M d, Y') }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-slate-500">Type</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ ucwords(str_replace('_', ' ', $content->content_type)) }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-slate-500">Status</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $content->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $content->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </dd>
                </div>

                @if($content->is_published && $content->published_at)
                <div>
                    <dt class="text-sm font-medium text-slate-500">Published At</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $content->published_at->format('M d, Y H:i') }}</dd>
                </div>
                @endif

                <div>
                    <dt class="text-sm font-medium text-slate-500">Uploaded By</dt>
                    <dd class="mt-1 text-sm text-slate-900">
                        @if($content->uploader)
                            {{ $content->uploader->name }}
                        @else
                            <span class="text-slate-400">Unknown</span>
                        @endif
                    </dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-slate-500">Upload Date</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $content->created_at->format('M d, Y H:i') }}</dd>
                </div>

                @if($content->file_size)
                <div>
                    <dt class="text-sm font-medium text-slate-500">File Size</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ number_format($content->file_size / 1048576, 2) }} MB</dd>
                </div>
                @endif
            </div>
        </div>

        <!-- Engagement Stats (if available) -->
        @if(isset($content->views_count) || isset($content->downloads_count))
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Engagement</h2>
            </div>
            <div class="card-body space-y-4">
                @if(isset($content->views_count))
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Views</span>
                    <span class="text-lg font-semibold text-slate-900">{{ number_format($content->views_count) }}</span>
                </div>
                @endif

                @if(isset($content->downloads_count))
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Downloads</span>
                    <span class="text-lg font-semibold text-slate-900">{{ number_format($content->downloads_count) }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
