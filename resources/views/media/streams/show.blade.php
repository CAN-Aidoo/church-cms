@extends('layouts.app')

@section('title', $stream->stream_title)

@section('content')
<!-- Header -->
<div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6 mb-8">
    <div>
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-2">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('media.index') }}" class="hover:text-primary-600 transition-colors">Media</a>
            <span>/</span>
            <a href="{{ route('media.streams') }}" class="hover:text-primary-600 transition-colors">Live Streams</a>
            <span>/</span>
            <span class="text-slate-800 font-medium">{{ $stream->stream_title }}</span>
        </nav>

        <div class="flex items-center gap-3">
            <h1 class="text-3xl font-heading font-bold text-slate-900">{{ $stream->stream_title }}</h1>
            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                @if($stream->status === 'scheduled') bg-blue-100 text-blue-800
                @elseif($stream->status === 'live') bg-red-100 text-red-800
                @elseif($stream->status === 'completed') bg-green-100 text-green-800
                @elseif($stream->status === 'cancelled') bg-gray-100 text-gray-800
                @endif">
                {{ ucfirst($stream->status) }}
            </span>
        </div>
    </div>

    <div class="flex flex-wrap gap-2">
        @if($stream->status === 'scheduled')
            <a href="{{ route('media.streams.edit', $stream) }}" class="btn btn-outline-primary">
                Edit
            </a>
        @endif

        <form action="{{ route('media.streams.destroy', $stream) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this stream?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" {{ $stream->status === 'live' ? 'disabled' : '' }}>
                Delete
            </button>
        </form>
    </div>
</div>

<!-- Stream Details -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Stream Information -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Stream Information</h2>
            </div>
            <div class="card-body space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Scheduled Start</dt>
                        <dd class="mt-1 text-sm text-slate-900">
                            {{ \Carbon\Carbon::parse($stream->scheduled_start)->format('M d, Y h:i A') }}
                        </dd>
                    </div>

                    @if($stream->scheduled_end)
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Scheduled End</dt>
                        <dd class="mt-1 text-sm text-slate-900">
                            {{ \Carbon\Carbon::parse($stream->scheduled_end)->format('M d, Y h:i A') }}
                        </dd>
                    </div>
                    @endif

                    @if($stream->actual_start)
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Actual Start</dt>
                        <dd class="mt-1 text-sm text-slate-900">
                            {{ \Carbon\Carbon::parse($stream->actual_start)->format('M d, Y h:i A') }}
                        </dd>
                    </div>
                    @endif

                    @if($stream->actual_end)
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Actual End</dt>
                        <dd class="mt-1 text-sm text-slate-900">
                            {{ \Carbon\Carbon::parse($stream->actual_end)->format('M d, Y h:i A') }}
                        </dd>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Platforms -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Streaming Platforms</h2>
            </div>
            <div class="card-body">
                @if($stream->platforms && count($stream->platforms) > 0)
                    <div class="flex flex-wrap gap-3">
                        @foreach($stream->platforms as $platform)
                            <div class="flex items-center gap-2 px-4 py-2 bg-slate-100 rounded-lg">
                                @if($platform === 'youtube')
                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                @elseif($platform === 'facebook')
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                @elseif($platform === 'instagram')
                                    <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.440-1.440 1.440-.795 0-1.440-.646-1.440-1.440 0-.794.646-1.439 1.440-1.439.793-.001 1.440.645 1.440 1.439z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                @endif
                                <span class="font-medium text-slate-700">{{ ucfirst($platform) }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-500">No platforms specified</p>
                @endif
            </div>
        </div>

        <!-- Stream URLs -->
        @if($stream->stream_url || $stream->recording_url)
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Stream Links</h2>
            </div>
            <div class="card-body space-y-3">
                @if($stream->stream_url)
                <div>
                    <dt class="text-sm font-medium text-slate-500 mb-1">Live Stream URL</dt>
                    <dd>
                        <a href="{{ $stream->stream_url }}" target="_blank" class="text-primary-600 hover:text-primary-700 text-sm break-all">
                            {{ $stream->stream_url }}
                        </a>
                    </dd>
                </div>
                @endif

                @if($stream->recording_url)
                <div>
                    <dt class="text-sm font-medium text-slate-500 mb-1">Recording URL</dt>
                    <dd>
                        <a href="{{ $stream->recording_url }}" target="_blank" class="text-primary-600 hover:text-primary-700 text-sm break-all">
                            {{ $stream->recording_url }}
                        </a>
                    </dd>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Description -->
        @if($stream->description)
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Description</h2>
            </div>
            <div class="card-body">
                <div class="prose max-w-none text-slate-700">
                    {!! nl2br(e($stream->description)) !!}
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Technician Info -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Team</h2>
            </div>
            <div class="card-body space-y-4">
                <div>
                    <dt class="text-sm font-medium text-slate-500">Technician</dt>
                    <dd class="mt-1 text-sm text-slate-900">
                        @if($stream->technician)
                            {{ $stream->technician->user->name ?? 'N/A' }}
                        @else
                            <span class="text-slate-400">Not assigned</span>
                        @endif
                    </dd>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        @if($stream->status === 'completed' || $stream->status === 'live')
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Statistics</h2>
            </div>
            <div class="card-body space-y-4">
                @if($stream->peak_viewers)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Peak Viewers</span>
                    <span class="text-lg font-semibold text-slate-900">{{ number_format($stream->peak_viewers) }}</span>
                </div>
                @endif

                @if($stream->total_viewers)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Total Viewers</span>
                    <span class="text-lg font-semibold text-slate-900">{{ number_format($stream->total_viewers) }}</span>
                </div>
                @endif

                @if($stream->actual_start && $stream->actual_end)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Duration</span>
                    <span class="text-lg font-semibold text-slate-900">
                        {{ \Carbon\Carbon::parse($stream->actual_start)->diffForHumans(\Carbon\Carbon::parse($stream->actual_end), true) }}
                    </span>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Metadata -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-semibold">Information</h2>
            </div>
            <div class="card-body space-y-4">
                <div>
                    <dt class="text-sm font-medium text-slate-500">Status</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($stream->status === 'scheduled') bg-blue-100 text-blue-800
                            @elseif($stream->status === 'live') bg-red-100 text-red-800
                            @elseif($stream->status === 'completed') bg-green-100 text-green-800
                            @elseif($stream->status === 'cancelled') bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($stream->status) }}
                        </span>
                    </dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-slate-500">Created</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $stream->created_at->format('M d, Y H:i') }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-slate-500">Last Updated</dt>
                    <dd class="mt-1 text-sm text-slate-900">{{ $stream->updated_at->format('M d, Y H:i') }}</dd>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
