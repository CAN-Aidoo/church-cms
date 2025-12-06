@extends('layouts.app')

@section('title', 'Submit Prayer Request')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Submit Prayer Request</h1>
        <a href="{{ route('prayer.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
    </div>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('prayer.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="requester_name" value="{{ auth()->user()->name ?? '' }}" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone (Optional)</label>
                        <input type="text" name="requester_phone" value="{{ auth()->user()->phone ?? '' }}" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div class="col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_anonymous" value="1" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <span class="ml-2 text-sm text-gray-600">Submit anonymously (details hidden from public)</span>
                        </label>
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Request Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title / Subject</label>
                        <input type="text" name="request_title" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required placeholder="Briefly describe your request">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category_id" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Urgency</label>
                            <select name="urgency" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required>
                                <option value="normal">Normal</option>
                                <option value="low">Low</option>
                                <option value="high">High</option>
                                <option value="critical">Critical</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Privacy</label>
                            <select name="privacy_level" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required>
                                <option value="pastors_only">Pastors & Prayer Team Only</option>
                                <option value="public">Share on Prayer Wall</option>
                                <option value="private">Private (Pastors Only)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Details</label>
                        <textarea name="request_details" rows="5" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500" required placeholder="Please share more details about how we can pray for you..."></textarea>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-medium shadow-sm">
                    Submit Request
                </button>
            </div>
        </form>
    </div>
@endsection
