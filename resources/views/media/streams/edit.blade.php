@extends('layouts.app')

@section('title', 'Edit Live Stream')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('media.streams.show', $stream) }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit Live Stream</h1>
        </div>
        <p class="text-gray-600">Update stream details and schedule</p>
    </div>

    <div class="max-w-4xl">
        <form method="POST" action="{{ route('media.streams.update', $stream) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Stream Details -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Stream Details</h2>
                </div>
                <div class="card-body space-y-4">
                    <!-- Stream Title -->
                    <div>
                        <label for="stream_title" class="block text-sm font-medium text-gray-700 mb-1">
                            Stream Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="stream_title"
                               id="stream_title"
                               value="{{ old('stream_title', $stream->stream_title) }}"
                               required
                               class="form-input w-full @error('stream_title') border-red-500 @enderror"
                               placeholder="e.g., Sunday Morning Worship Service">
                        @error('stream_title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                            Description
                        </label>
                        <textarea name="description"
                                  id="description"
                                  rows="3"
                                  class="form-textarea w-full @error('description') border-red-500 @enderror"
                                  placeholder="Provide details about this stream...">{{ old('description', $stream->description) }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Schedule -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Schedule</h2>
                </div>
                <div class="card-body space-y-4">
                    <!-- Scheduled Start -->
                    <div>
                        <label for="scheduled_start" class="block text-sm font-medium text-gray-700 mb-1">
                            Scheduled Start <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local"
                               name="scheduled_start"
                               id="scheduled_start"
                               value="{{ old('scheduled_start', \Carbon\Carbon::parse($stream->scheduled_start)->format('Y-m-d\TH:i')) }}"
                               required
                               class="form-input w-full md:w-96 @error('scheduled_start') border-red-500 @enderror">
                        @error('scheduled_start')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Scheduled End -->
                    <div>
                        <label for="scheduled_end" class="block text-sm font-medium text-gray-700 mb-1">
                            Scheduled End
                        </label>
                        <input type="datetime-local"
                               name="scheduled_end"
                               id="scheduled_end"
                               value="{{ old('scheduled_end', $stream->scheduled_end ? \Carbon\Carbon::parse($stream->scheduled_end)->format('Y-m-d\TH:i') : '') }}"
                               class="form-input w-full md:w-96 @error('scheduled_end') border-red-500 @enderror">
                        @error('scheduled_end')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Optional - estimated duration of the stream</p>
                    </div>
                </div>
            </div>

            <!-- Platforms -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Streaming Platforms</h2>
                </div>
                <div class="card-body">
                    <p class="text-sm text-gray-600 mb-3">Select the platforms where this stream will be broadcast <span class="text-red-500">*</span></p>
                    <div class="space-y-2">
                        @php
                            $platformOptions = ['youtube', 'facebook', 'instagram', 'custom'];
                            $selectedPlatforms = old('platforms', $stream->platforms ?? []);
                        @endphp

                        @foreach($platformOptions as $platform)
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="checkbox"
                                   name="platforms[]"
                                   value="{{ $platform }}"
                                   {{ in_array($platform, $selectedPlatforms) ? 'checked' : '' }}
                                   class="form-checkbox">
                            <span class="ml-3 flex items-center gap-2">
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
                                <span class="font-medium">{{ ucfirst($platform) }}</span>
                            </span>
                        </label>
                        @endforeach
                    </div>
                    @error('platforms')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status Info -->
            <div class="card bg-blue-50 border border-blue-200">
                <div class="card-body">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                        <div>
                            <h3 class="font-semibold text-blue-900 mb-1">Current Status: {{ ucfirst($stream->status) }}</h3>
                            <p class="text-sm text-blue-800">
                                @if($stream->status === 'scheduled')
                                    This stream is scheduled. You can edit all details.
                                @elseif($stream->status === 'live')
                                    This stream is currently live. Only limited edits are allowed.
                                @elseif($stream->status === 'completed')
                                    This stream has been completed and cannot be edited.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('media.streams.show', $stream) }}" class="btn btn-secondary">
                    Cancel
                </a>
                @if($stream->status !== 'completed')
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Save Changes
                </button>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
