@extends('layouts.app')

@section('title', 'Notification Preferences')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('notifications.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Notification Preferences</h1>
        </div>
        <p class="text-gray-600">Customize how you receive notifications</p>
    </div>

    <form action="{{ route('notifications.update-preferences') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- In-App Notifications -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 rounded-full p-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">In-App Notifications</h2>
                        <p class="text-sm text-gray-600">Notifications shown within the application</p>
                    </div>
                </div>
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="in_app_enabled" value="1"
                           {{ $preferences->in_app_enabled ? 'checked' : '' }}
                           class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                </label>
            </div>

            <div class="space-y-2 ml-11">
                @foreach($availableTypes as $typeKey => $typeLabel)
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="in_app_types[]" value="{{ $typeKey }}"
                           {{ in_array($typeKey, $preferences->in_app_types ?? []) || empty($preferences->in_app_types) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                    <span class="text-gray-700">{{ $typeLabel }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Email Notifications -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="bg-green-100 rounded-full p-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Email Notifications</h2>
                        <p class="text-sm text-gray-600">Notifications sent to your email</p>
                    </div>
                </div>
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="email_enabled" value="1"
                           {{ $preferences->email_enabled ? 'checked' : '' }}
                           class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                </label>
            </div>

            <div class="space-y-4 ml-11">
                <!-- Email Types -->
                <div class="space-y-2">
                    @foreach($availableTypes as $typeKey => $typeLabel)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="email_types[]" value="{{ $typeKey }}"
                               {{ in_array($typeKey, $preferences->email_types ?? []) || empty($preferences->email_types) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <span class="text-gray-700">{{ $typeLabel }}</span>
                    </label>
                    @endforeach
                </div>

                <!-- Email Digest -->
                <div class="pt-4 border-t border-gray-200">
                    <label class="flex items-center gap-2 cursor-pointer mb-3">
                        <input type="checkbox" name="email_digest_enabled" value="1"
                               {{ $preferences->email_digest_enabled ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <span class="text-gray-700 font-medium">Enable Daily Digest</span>
                    </label>

                    <div class="ml-6">
                        <label class="block text-sm text-gray-700 mb-2">Digest Time</label>
                        <input type="time" name="email_digest_time" value="{{ $preferences->email_digest_time }}"
                               class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Receive a daily summary at this time</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- SMS Notifications -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="bg-yellow-100 rounded-full p-2">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">SMS Notifications</h2>
                        <p class="text-sm text-gray-600">Urgent notifications via text message</p>
                    </div>
                </div>
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="sms_enabled" value="1"
                           {{ $preferences->sms_enabled ? 'checked' : '' }}
                           class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                </label>
            </div>

            <div class="space-y-2 ml-11">
                @foreach($availableTypes as $typeKey => $typeLabel)
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="sms_types[]" value="{{ $typeKey }}"
                           {{ in_array($typeKey, $preferences->sms_types ?? []) || empty($preferences->sms_types) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                    <span class="text-gray-700">{{ $typeLabel }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Push Notifications -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="bg-purple-100 rounded-full p-2">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Push Notifications</h2>
                        <p class="text-sm text-gray-600">Mobile app notifications (coming soon)</p>
                    </div>
                </div>
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="push_enabled" value="1"
                           {{ $preferences->push_enabled ? 'checked' : '' }}
                           class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                </label>
            </div>

            <div class="space-y-2 ml-11">
                @foreach($availableTypes as $typeKey => $typeLabel)
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="push_types[]" value="{{ $typeKey }}"
                           {{ in_array($typeKey, $preferences->push_types ?? []) || empty($preferences->push_types) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                    <span class="text-gray-700">{{ $typeLabel }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Quiet Hours -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-100 rounded-full p-2">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Quiet Hours</h2>
                        <p class="text-sm text-gray-600">Pause non-urgent notifications during specific hours</p>
                    </div>
                </div>
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="quiet_hours_enabled" value="1"
                           {{ $preferences->quiet_hours_enabled ? 'checked' : '' }}
                           class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                </label>
            </div>

            <div class="grid grid-cols-2 gap-4 ml-11">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                    <input type="time" name="quiet_hours_start" value="{{ $preferences->quiet_hours_start }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                    <input type="time" name="quiet_hours_end" value="{{ $preferences->quiet_hours_end }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2 ml-11">Urgent notifications will still be delivered during quiet hours</p>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition">
                Save Preferences
            </button>
        </div>
    </form>
</div>
@endsection
