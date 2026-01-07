@extends('layouts.app')

@section('title', 'Edit Prayer Request')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <!-- Header -->
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('prayer.show', $prayerRequest) }}" class="p-2 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-slate-50 transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Edit Prayer Request</h1>
            <p class="text-slate-600">Update the details of this prayer request.</p>
        </div>
    </div>

    <!-- Status Badge -->
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                @if($prayerRequest->status === 'pending') bg-amber-50 text-amber-700 border border-amber-100
                @elseif($prayerRequest->status === 'praying') bg-blue-50 text-blue-700 border border-blue-100
                @elseif($prayerRequest->status === 'answered') bg-emerald-50 text-emerald-700 border border-emerald-100
                @elseif($prayerRequest->status === 'closed') bg-slate-100 text-slate-600 border border-slate-200
                @endif">
                {{ ucfirst($prayerRequest->status) }}
            </span>
            <span class="text-sm text-slate-500 font-medium">
                Submitted {{ $prayerRequest->created_at->diffForHumans() }}
            </span>
        </div>
        
        <form action="{{ route('prayer.destroy', $prayerRequest) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this prayer request?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-sm text-rose-600 hover:text-rose-800 font-medium hover:underline flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete Request
            </button>
        </form>
    </div>

    <div class="card border border-slate-100 shadow-sm overflow-hidden">
        <form action="{{ route('prayer.update', $prayerRequest) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="p-6 md:p-8 space-y-8">
                
                <!-- Request Information -->
                <div>
                     <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">
                        <span class="w-8 h-8 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center text-sm">1</span>
                        Request Information
                    </h3>

                    <div class="space-y-6 pl-0 md:pl-10">
                        <div>
                            <label for="request_title" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">
                                Title / Subject
                            </label>
                            <input type="text"
                                   id="request_title"
                                   name="request_title"
                                   value="{{ old('request_title', $prayerRequest->request_title) }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                                   required
                                   placeholder="Briefly describe your request">
                            @error('request_title')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Category</label>
                            <select name="category_id" id="category_id" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $prayerRequest->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="urgency" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">
                                    Urgency
                                </label>
                                <select name="urgency" id="urgency" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" required>
                                    <option value="low" {{ old('urgency', $prayerRequest->urgency) === 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="normal" {{ old('urgency', $prayerRequest->urgency) === 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="high" {{ old('urgency', $prayerRequest->urgency) === 'high' ? 'selected' : '' }}>High</option>
                                    <option value="critical" {{ old('urgency', $prayerRequest->urgency) === 'critical' ? 'selected' : '' }}>Critical</option>
                                </select>
                                @error('urgency')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="privacy_level" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">
                                    Privacy
                                </label>
                                <select name="privacy_level" id="privacy_level" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" required>
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
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="request_details" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">
                                Details
                            </label>
                            <textarea name="request_details"
                                    id="request_details"  
                                      rows="5"
                                      class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                                      required
                                      placeholder="Please share more details about how we can pray for you...">{{ old('request_details', $prayerRequest->request_details) }}</textarea>
                            @error('request_details')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tags_string" class="form-label mb-1.5 block font-medium text-sm text-slate-700">
                                Tags <span class="text-slate-400 text-xs font-normal ml-1">(Optional, comma-separated)</span>
                            </label>
                            <input type="text"
                                   name="tags_string"
                                   id="tags_string"
                                   value="{{ old('tags_string', is_array($prayerRequest->tags) ? implode(', ', $prayerRequest->tags) : '') }}"
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg"
                                   placeholder="e.g., healing, family, job">
                        </div>
                    </div>
                </div>

                <!-- Requester Information (Read-only) -->
                <div>
                     <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">
                        <span class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-sm">2</span>
                        Requester Information
                    </h3>
                    
                    <div class="pl-0 md:pl-10">
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900">
                                        {{ $prayerRequest->is_anonymous ? 'Anonymous' : $prayerRequest->requester_name }}
                                    </p>
                                    @if(!$prayerRequest->is_anonymous && $prayerRequest->requester_phone)
                                    <p class="text-xs text-slate-500">{{ $prayerRequest->requester_phone }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-500 mt-3 pt-3 border-t border-slate-200">
                                <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span>Requester details cannot be changed after submission.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('prayer.show', $prayerRequest) }}" class="px-5 py-2.5 bg-white text-slate-700 border border-slate-300 rounded-lg hover:bg-slate-50 hover:border-slate-400 transition font-medium text-sm shadow-sm">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-lg hover:from-primary-700 hover:to-primary-800 transition font-medium text-sm shadow-md hover:shadow-lg flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Update Request
                </button>
            </div>
        </form>
    </div>

    <!-- Assignments & Updates -->
    @if($prayerRequest->assigned_to)
    <div class="mt-8">
        <div class="p-4 bg-blue-50 border border-blue-100 rounded-xl flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-blue-900 text-sm mb-0.5">Assigned Intercessor</h4>
                <p class="text-sm text-blue-800">
                    This request is currently being covered by <span class="font-semibold">{{ $prayerRequest->assignedIntercessor->first_name ?? 'Prayer Team' }}</span>.
                </p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
