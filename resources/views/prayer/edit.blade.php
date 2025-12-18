@extends('layouts.app')

@section('title', 'Edit Prayer Request')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Prayer Request</h1>
        <a href="{{ route('prayer.show', $prayerRequest) }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
    </div>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('prayer.update', $prayerRequest) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Status Badge -->
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    @if($prayerRequest->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($prayerRequest->status === 'praying') bg-blue-100 text-blue-800
                    @elseif($prayerRequest->status === 'answered') bg-green-100 text-green-800
                    @elseif($prayerRequest->status === 'closed') bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($prayerRequest->status) }}
                </span>
                <span class="text-sm text-gray-500">
                    Submitted {{ $prayerRequest->created_at->diffForHumans() }}
                </span>
            </div>

            <hr class="border-gray-100">

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Request Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Title / Subject <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="request_title"
                               value="{{ old('request_title', $prayerRequest->request_title) }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 @error('request_title') border-red-500 @enderror"
                               required
                               placeholder="Briefly describe your request">
                        @error('request_title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category_id" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $prayerRequest->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Urgency <span class="text-red-500">*</span>
                            </label>
                            <select name="urgency"
                                    class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 @error('urgency') border-red-500 @enderror"
                                    required>
                                <option value="low" {{ old('urgency', $prayerRequest->urgency) === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="normal" {{ old('urgency', $prayerRequest->urgency) === 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="high" {{ old('urgency', $prayerRequest->urgency) === 'high' ? 'selected' : '' }}>High</option>
                                <option value="critical" {{ old('urgency', $prayerRequest->urgency) === 'critical' ? 'selected' : '' }}>Critical</option>
                            </select>
                            @error('urgency')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Privacy <span class="text-red-500">*</span>
                            </label>
                            <select name="privacy_level"
                                    class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 @error('privacy_level') border-red-500 @enderror"
                                    required>
                                <option value="pastors_only" {{ old('privacy_level', $prayerRequest->privacy_level) === 'pastors_only' ? 'selected' : '' }}>
                                    Pastors & Prayer Team Only
                                </option>
                                <option value="public" {{ old('privacy_level', $prayerRequest->privacy_level) === 'public' ? 'selected' : '' }}>
                                    Share on Prayer Wall
                                </option>
                                <option value="private" {{ old('privacy_level', $prayerRequest->privacy_level) === 'private' ? 'selected' : '' }}>
                                    Private (Pastors Only)
                                </option>
                            </select>
                            @error('privacy_level')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Details <span class="text-red-500">*</span>
                        </label>
                        <textarea name="request_details"
                                  rows="5"
                                  class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 @error('request_details') border-red-500 @enderror"
                                  required
                                  placeholder="Please share more details about how we can pray for you...">{{ old('request_details', $prayerRequest->request_details) }}</textarea>
                        @error('request_details')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tags (Optional) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Tags <span class="text-gray-500 text-xs">(Optional, comma-separated)</span>
                        </label>
                        <input type="text"
                               name="tags_string"
                               value="{{ old('tags_string', is_array($prayerRequest->tags) ? implode(', ', $prayerRequest->tags) : '') }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                               placeholder="e.g., healing, family, job">
                        <p class="text-xs text-gray-500 mt-1">Separate multiple tags with commas</p>
                    </div>
                </div>
            </div>

            <!-- Requester Information (Read-only display) -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Requester Information</h3>
                <div class="p-4 bg-gray-50 rounded-lg space-y-2">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-gray-700">
                            <span class="font-medium">Name:</span>
                            {{ $prayerRequest->is_anonymous ? 'Anonymous' : $prayerRequest->requester_name }}
                        </span>
                    </div>
                    @if(!$prayerRequest->is_anonymous && $prayerRequest->requester_phone)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        <span class="text-sm text-gray-700">
                            <span class="font-medium">Phone:</span> {{ $prayerRequest->requester_phone }}
                        </span>
                    </div>
                    @endif
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Requester details cannot be changed after submission
                    </p>
                </div>
            </div>

            <!-- Assignment Info (if assigned) -->
            @if($prayerRequest->assigned_to)
            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                    <span class="text-sm font-medium text-blue-900">Assigned for Prayer</span>
                </div>
                <p class="text-sm text-blue-800">
                    This request is being covered by
                    <span class="font-semibold">{{ $prayerRequest->assignedIntercessor->first_name ?? 'Prayer Team' }}</span>
                </p>
            </div>
            @endif

            <div class="pt-4 flex justify-between items-center">
                <a href="{{ route('prayer.show', $prayerRequest) }}" class="text-sm text-gray-600 hover:text-gray-800">
                    Cancel
                </a>
                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium shadow-sm">
                        <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z"/>
                        </svg>
                        Update Request
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Prayer Updates Section (Below form) -->
    @if($prayerRequest->updates && count($prayerRequest->updates) > 0)
    <div class="max-w-2xl mx-auto mt-6 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                Prayer Updates
            </h3>
            <div class="space-y-4">
                @foreach($prayerRequest->updates->sortByDesc('created_at') as $update)
                <div class="p-4 bg-gray-50 rounded-lg border-l-4
                    @if($update->update_type === 'answered') border-green-500
                    @elseif($update->update_type === 'progress') border-blue-500
                    @elseif($update->update_type === 'status_change') border-yellow-500
                    @else border-gray-300
                    @endif">
                    <div class="flex items-start justify-between mb-2">
                        <span class="text-xs font-semibold uppercase tracking-wide
                            @if($update->update_type === 'answered') text-green-700
                            @elseif($update->update_type === 'progress') text-blue-700
                            @elseif($update->update_type === 'status_change') text-yellow-700
                            @else text-gray-600
                            @endif">
                            {{ str_replace('_', ' ', $update->update_type) }}
                        </span>
                        <span class="text-xs text-gray-500">{{ $update->created_at->format('M d, Y') }}</span>
                    </div>
                    <p class="text-sm text-gray-700">{{ $update->update_text }}</p>
                    @if($update->updated_by_user)
                    <p class="text-xs text-gray-500 mt-2">
                        — {{ $update->updated_by_user->name }}
                    </p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
@endsection
