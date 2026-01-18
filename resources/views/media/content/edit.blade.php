@extends('layouts.app')

@section('title', 'Edit Media Content')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('media.content.show', $content) }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit Media Content</h1>
        </div>
        <p class="text-gray-600">Update content details and metadata</p>
    </div>

    <div class="max-w-4xl">
        <form method="POST" action="{{ route('media.content.update', $content) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Basic Information</h2>
                </div>
                <div class="card-body space-y-4">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                            Content Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title', $content->title) }}"
                               required
                               class="form-input w-full @error('title') border-red-500 @enderror"
                               placeholder="e.g., Sunday Service - January 15, 2024">
                        @error('title')
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
                                  rows="4"
                                  class="form-textarea w-full @error('description') border-red-500 @enderror"
                                  placeholder="Provide details about this content...">{{ old('description', $content->description) }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Content Type -->
                        <div>
                            <label for="content_type" class="block text-sm font-medium text-gray-700 mb-1">
                                Content Type <span class="text-red-500">*</span>
                            </label>
                            <select name="content_type"
                                    id="content_type"
                                    required
                                    class="form-select w-full @error('content_type') border-red-500 @enderror">
                                <option value="">Select Type</option>
                                <option value="sermon_video" {{ old('content_type', $content->content_type) == 'sermon_video' ? 'selected' : '' }}>Sermon Video</option>
                                <option value="sermon_audio" {{ old('content_type', $content->content_type) == 'sermon_audio' ? 'selected' : '' }}>Sermon Audio</option>
                                <option value="event_video" {{ old('content_type', $content->content_type) == 'event_video' ? 'selected' : '' }}>Event Video</option>
                                <option value="testimony" {{ old('content_type', $content->content_type) == 'testimony' ? 'selected' : '' }}>Testimony</option>
                                <option value="worship_session" {{ old('content_type', $content->content_type) == 'worship_session' ? 'selected' : '' }}>Worship Session</option>
                                <option value="photo_gallery" {{ old('content_type', $content->content_type) == 'photo_gallery' ? 'selected' : '' }}>Photo Gallery</option>
                                <option value="other" {{ old('content_type', $content->content_type) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('content_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content Date -->
                        <div>
                            <label for="content_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Content Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                   name="content_date"
                                   id="content_date"
                                   value="{{ old('content_date', \Carbon\Carbon::parse($content->content_date)->format('Y-m-d')) }}"
                                   required
                                   class="form-input w-full @error('content_date') border-red-500 @enderror">
                            @error('content_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">The date this content was created or recorded</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Files Info -->
            <div class="card bg-blue-50 border border-blue-200">
                <div class="card-body">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                        <div class="flex-1">
                            <h3 class="font-semibold text-blue-900 mb-1">Current Files</h3>
                            @if($content->file_paths && count($content->file_paths) > 0)
                                <p class="text-sm text-blue-800 mb-2">This content has {{ count($content->file_paths) }} file(s) attached:</p>
                                <ul class="list-disc list-inside text-sm text-blue-800 space-y-1">
                                    @foreach($content->file_paths as $filePath)
                                        <li>{{ basename($filePath) }}</li>
                                    @endforeach
                                </ul>
                                <p class="text-xs text-blue-700 mt-3">
                                    Note: Files cannot be changed through this form. To update files, you'll need to upload new content or contact an administrator.
                                </p>
                            @else
                                <p class="text-sm text-blue-800">No files currently attached to this content.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Info -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Status Information</h2>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Current Status</p>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $content->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $content->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Uploaded</p>
                            <p class="font-medium mt-1">{{ $content->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Last Modified</p>
                            <p class="font-medium mt-1">{{ $content->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('media.content.show', $content) }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
