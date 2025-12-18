@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('sms.show', $broadcast) }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit SMS Broadcast</h1>
        </div>
        <p class="text-gray-600">Update broadcast details</p>
    </div>

    @if($broadcast->status !== 'draft' && $broadcast->status !== 'scheduled')
    <div class="alert-warning mb-6">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <span>This broadcast cannot be edited because it is {{ $broadcast->status }}. Only draft and scheduled broadcasts can be modified.</span>
    </div>
    @endif

    <div class="max-w-4xl">
        <form method="POST" action="{{ route('sms.update', $broadcast) }}" class="space-y-6" x-data="{
            message: '{{ old('message', $broadcast->message) }}',
            scheduleType: '{{ old('schedule_type', $broadcast->scheduled_at ? 'schedule' : 'send_now') }}',

            get messageLength() {
                return this.message.length;
            },

            get segments() {
                return this.messageLength <= 160 ? 1 : Math.ceil(this.messageLength / 153);
            }
        }">
            @csrf
            @method('PUT')

            <!-- Message Content -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Message Content</h2>
                </div>
                <div class="card-body space-y-4">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                            Broadcast Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title', $broadcast->title) }}"
                               required
                               {{ $broadcast->status !== 'draft' && $broadcast->status !== 'scheduled' ? 'readonly' : '' }}
                               class="form-input w-full @error('title') border-red-500 @enderror"
                               placeholder="e.g., Sunday Service Reminder, Birthday Wishes">
                        @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea name="message"
                                  id="message"
                                  rows="6"
                                  required
                                  x-model="message"
                                  maxlength="1600"
                                  {{ $broadcast->status !== 'draft' && $broadcast->status !== 'scheduled' ? 'readonly' : '' }}
                                  class="form-textarea w-full @error('message') border-red-500 @enderror"
                                  placeholder="Type your message here...">{{ old('message', $broadcast->message) }}</textarea>
                        @error('message')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Character Counter -->
                        <div class="flex justify-between text-xs mt-2">
                            <div>
                                <span x-text="messageLength"></span> / 1600 characters
                                <span class="ml-3">|</span>
                                <span class="ml-3" x-text="segments"></span> SMS segment<span x-show="segments > 1">s</span>
                            </div>
                            <div class="text-gray-600">
                                <span x-show="messageLength <= 160" class="text-green-600">Single SMS</span>
                                <span x-show="messageLength > 160" class="text-yellow-600">Multi-part SMS</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recipients (Read-only display) -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Recipients</h2>
                </div>
                <div class="card-body">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900">
                                    {{ ucwords(str_replace('_', ' ', $broadcast->recipient_type)) }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $broadcast->recipient_count }} recipient{{ $broadcast->recipient_count != 1 ? 's' : '' }}
                                </p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-3">
                            <i class="fas fa-info-circle mr-1"></i>
                            Recipients cannot be changed after broadcast creation. Create a new broadcast to send to different recipients.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Schedule -->
            @if($broadcast->status === 'draft' || $broadcast->status === 'scheduled')
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-semibold">Delivery Schedule</h2>
                </div>
                <div class="card-body space-y-4">
                    <div class="space-y-2">
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio"
                                   name="schedule_type"
                                   value="send_now"
                                   x-model="scheduleType"
                                   {{ old('schedule_type', $broadcast->scheduled_at ? 'schedule' : 'send_now') === 'send_now' ? 'checked' : '' }}
                                   class="form-radio">
                            <span class="ml-3">
                                <span class="font-medium">Send Immediately</span>
                                <p class="text-sm text-gray-600">Messages will be queued and sent right away</p>
                            </span>
                        </label>

                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio"
                                   name="schedule_type"
                                   value="schedule"
                                   x-model="scheduleType"
                                   {{ old('schedule_type', $broadcast->scheduled_at ? 'schedule' : 'send_now') === 'schedule' ? 'checked' : '' }}
                                   class="form-radio">
                            <span class="ml-3">
                                <span class="font-medium">Schedule for Later</span>
                                <p class="text-sm text-gray-600">Choose a specific date and time to send</p>
                            </span>
                        </label>
                    </div>

                    <!-- Schedule Date/Time -->
                    <div x-show="scheduleType === 'schedule'" x-cloak class="pl-6">
                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-1">
                            Schedule Date & Time <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local"
                               name="scheduled_at"
                               id="scheduled_at"
                               value="{{ old('scheduled_at', $broadcast->scheduled_at ? $broadcast->scheduled_at->format('Y-m-d\TH:i') : '') }}"
                               min="{{ now()->format('Y-m-d\TH:i') }}"
                               class="form-input w-full md:w-96 @error('scheduled_at') border-red-500 @enderror">
                        @error('scheduled_at')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            @endif

            <!-- Broadcast Info -->
            <div class="card bg-gradient-to-br from-gray-50 to-gray-100">
                <div class="card-body">
                    <h3 class="text-lg font-semibold mb-3">Broadcast Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="font-medium mt-1">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    @if($broadcast->status === 'draft') bg-gray-200 text-gray-800
                                    @elseif($broadcast->status === 'scheduled') bg-blue-100 text-blue-800
                                    @elseif($broadcast->status === 'sending') bg-yellow-100 text-yellow-800
                                    @elseif($broadcast->status === 'completed') bg-green-100 text-green-800
                                    @elseif($broadcast->status === 'failed') bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($broadcast->status) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Created</p>
                            <p class="font-medium mt-1">{{ $broadcast->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Estimated Cost</p>
                            <p class="font-medium mt-1">GHS {{ number_format($broadcast->estimated_cost, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('sms.show', $broadcast) }}" class="btn btn-secondary">
                    Cancel
                </a>
                @if($broadcast->status === 'draft' || $broadcast->status === 'scheduled')
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Update Broadcast
                </button>
                @endif
            </div>
        </form>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
</style>
@endsection
