@extends('layouts.app')

@section('title', 'Submit Prayer Request')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <!-- Header -->
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('prayer.index') }}" class="p-2 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-slate-50 transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Submit Prayer Request</h1>
            <p class="text-slate-600">Share your prayer needs with us.</p>
        </div>
    </div>

    <div class="card border border-slate-100 shadow-sm overflow-hidden">
        <form action="{{ route('prayer.store') }}" method="POST">
            @csrf
            
            <div class="p-6 md:p-8 space-y-8">
                <!-- Personal Details Section -->
                <div>
                    <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">
                        <span class="w-8 h-8 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center text-sm">1</span>
                        Your Details
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-0 md:pl-10">
                        <div>
                            <label for="requester_name" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Name</label>
                            <input type="text" name="requester_name" id="requester_name" value="{{ auth()->user()->name ?? '' }}" 
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" required>
                            @error('requester_name')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="requester_phone" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Phone (Optional)</label>
                            <input type="text" name="requester_phone" id="requester_phone" value="{{ auth()->user()->phone ?? '' }}" 
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                             @error('requester_phone')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                             <label class="flex items-center p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors">
                                <input type="checkbox" name="is_anonymous" value="1" class="w-4 h-4 text-primary-600 border-slate-300 rounded focus:ring-primary-500">
                                <div class="ml-3">
                                    <span class="block text-sm font-medium text-slate-700">Submit anonymously</span>
                                    <span class="block text-xs text-slate-500">Your name will be hidden from the public prayer wall.</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Request Information Section -->
                 <div>
                    <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">
                        <span class="w-8 h-8 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center text-sm">2</span>
                        Request Information
                    </h3>
                    
                    <div class="space-y-6 pl-0 md:pl-10">
                        <div>
                            <label for="request_title" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Title / Subject</label>
                            <input type="text" name="request_title" id="request_title" 
                                   class="form-input w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" 
                                   required placeholder="e.g., Healing for my mother, Guidance for new job">
                            @error('request_title')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="form-label mb-1.5 block font-medium text-sm text-slate-700">Category</label>
                            <select name="category_id" id="category_id" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                             @error('category_id')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="urgency" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Urgency</label>
                                <div class="relative">
                                    <select name="urgency" id="urgency" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" required>
                                        <option value="normal">Normal</option>
                                        <option value="low">Low</option>
                                        <option value="high">High</option>
                                        <option value="critical">Critical</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="privacy_level" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Privacy</label>
                                <div class="relative">
                                    <select name="privacy_level" id="privacy_level" class="form-select w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" required>
                                        <option value="pastors_only">Pastors & Prayer Team Only</option>
                                        <option value="public">Share on Prayer Wall</option>
                                        <option value="private">Private (Pastors Only)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="request_details" class="form-label mb-1.5 block font-medium text-sm text-slate-700 required">Details</label>
                            <textarea name="request_details" id="request_details" rows="5" 
                                      class="form-textarea w-full border-slate-200 focus:border-primary-500 focus:ring-primary-500 rounded-lg" 
                                      required placeholder="Please share more details about your request so we can pray effectively..."></textarea>
                            @error('request_details')
                                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('prayer.index') }}" class="px-5 py-2.5 bg-white text-slate-700 border border-slate-300 rounded-lg hover:bg-slate-50 hover:border-slate-400 transition font-medium text-sm shadow-sm">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-lg hover:from-primary-700 hover:to-primary-800 transition font-medium text-sm shadow-md hover:shadow-lg">
                    Submit Prayer Request
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
