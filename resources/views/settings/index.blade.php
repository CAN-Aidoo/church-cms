@extends('layouts.app')

@section('title', 'System Settings')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">System Settings</h1>
        <p class="mt-2 text-sm text-gray-600">Manage system configuration, email templates, backups, and more</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Settings Tabs -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px" x-data="{ activeTab: 'general' }">
                <button @click="activeTab = 'general'"
                        :class="activeTab === 'general' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm transition-colors">
                    General Settings
                </button>
                <button @click="activeTab = 'email'"
                        :class="activeTab === 'email' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm transition-colors">
                    Email Settings
                </button>
                <button @click="activeTab = 'sms'"
                        :class="activeTab === 'sms' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="px-6 py-4 border-b-2 font-medium text-sm transition-colors">
                    SMS Settings
                </button>
            </nav>
        </div>

        <!-- General Settings Tab -->
        <div x-show="activeTab === 'general'" class="p-6">
            <form action="{{ route('settings.update-general') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Church Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="church_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Church Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="church_name"
                                       name="church_name"
                                       value="{{ old('church_name', $generalSettings['church_name'] ?? '') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('church_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="church_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Church Phone
                                </label>
                                <input type="text"
                                       id="church_phone"
                                       name="church_phone"
                                       value="{{ old('church_phone', $generalSettings['church_phone'] ?? '') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('church_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="church_email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Church Email
                                </label>
                                <input type="email"
                                       id="church_email"
                                       name="church_email"
                                       value="{{ old('church_email', $generalSettings['church_email'] ?? '') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('church_email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="church_address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Church Address
                                </label>
                                <textarea id="church_address"
                                          name="church_address"
                                          rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('church_address', $generalSettings['church_address'] ?? '') }}</textarea>
                                @error('church_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Regional Settings</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Timezone <span class="text-red-500">*</span>
                                </label>
                                <select id="timezone"
                                        name="timezone"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required>
                                    <option value="Africa/Accra" {{ old('timezone', $generalSettings['timezone'] ?? '') == 'Africa/Accra' ? 'selected' : '' }}>Africa/Accra (GMT)</option>
                                    <option value="Africa/Lagos" {{ old('timezone', $generalSettings['timezone'] ?? '') == 'Africa/Lagos' ? 'selected' : '' }}>Africa/Lagos (WAT)</option>
                                    <option value="Africa/Nairobi" {{ old('timezone', $generalSettings['timezone'] ?? '') == 'Africa/Nairobi' ? 'selected' : '' }}>Africa/Nairobi (EAT)</option>
                                    <option value="America/New_York" {{ old('timezone', $generalSettings['timezone'] ?? '') == 'America/New_York' ? 'selected' : '' }}>America/New York (EST)</option>
                                    <option value="Europe/London" {{ old('timezone', $generalSettings['timezone'] ?? '') == 'Europe/London' ? 'selected' : '' }}>Europe/London (GMT)</option>
                                </select>
                                @error('timezone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="date_format" class="block text-sm font-medium text-gray-700 mb-2">
                                    Date Format <span class="text-red-500">*</span>
                                </label>
                                <select id="date_format"
                                        name="date_format"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required>
                                    <option value="Y-m-d" {{ old('date_format', $generalSettings['date_format'] ?? '') == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                    <option value="d/m/Y" {{ old('date_format', $generalSettings['date_format'] ?? '') == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                    <option value="m/d/Y" {{ old('date_format', $generalSettings['date_format'] ?? '') == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                                    <option value="d-M-Y" {{ old('date_format', $generalSettings['date_format'] ?? '') == 'd-M-Y' ? 'selected' : '' }}>DD-MMM-YYYY</option>
                                </select>
                                @error('date_format')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="time_format" class="block text-sm font-medium text-gray-700 mb-2">
                                    Time Format <span class="text-red-500">*</span>
                                </label>
                                <select id="time_format"
                                        name="time_format"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required>
                                    <option value="H:i" {{ old('time_format', $generalSettings['time_format'] ?? '') == 'H:i' ? 'selected' : '' }}>24-hour (14:30)</option>
                                    <option value="h:i A" {{ old('time_format', $generalSettings['time_format'] ?? '') == 'h:i A' ? 'selected' : '' }}>12-hour (02:30 PM)</option>
                                </select>
                                @error('time_format')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Save General Settings
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Email Settings Tab -->
        <div x-show="activeTab === 'email'" class="p-6">
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Email Configuration</h3>
                        <p class="text-sm text-gray-600 mt-1">Configure SMTP settings and email templates</p>
                    </div>
                    <a href="{{ route('settings.email-templates') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Manage Templates
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Host</label>
                        <input type="text"
                               value="{{ $emailSettings['smtp_host'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                               readonly>
                        <p class="mt-1 text-xs text-gray-500">Set in .env file: MAIL_HOST</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Port</label>
                        <input type="text"
                               value="{{ $emailSettings['smtp_port'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                               readonly>
                        <p class="mt-1 text-xs text-gray-500">Set in .env file: MAIL_PORT</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Email</label>
                        <input type="text"
                               value="{{ $emailSettings['from_email'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                               readonly>
                        <p class="mt-1 text-xs text-gray-500">Set in .env file: MAIL_FROM_ADDRESS</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Name</label>
                        <input type="text"
                               value="{{ $emailSettings['from_name'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                               readonly>
                        <p class="mt-1 text-xs text-gray-500">Set in .env file: MAIL_FROM_NAME</p>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-blue-800">Email Configuration</h4>
                            <p class="text-sm text-blue-700 mt-1">Email settings are managed through environment variables. Update your .env file and restart the application to apply changes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SMS Settings Tab -->
        <div x-show="activeTab === 'sms'" class="p-6">
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">SMS Configuration</h3>
                    <p class="text-sm text-gray-600 mt-1">Configure SMS gateway settings</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">SMS Provider</label>
                        <input type="text"
                               value="{{ $smsSettings['provider'] ?? 'Twilio' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                               readonly>
                        <p class="mt-1 text-xs text-gray-500">Current provider: Twilio</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sender ID</label>
                        <input type="text"
                               value="{{ $smsSettings['sender_id'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                               readonly>
                        <p class="mt-1 text-xs text-gray-500">Set in .env file: TWILIO_PHONE</p>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-blue-800">SMS Configuration</h4>
                            <p class="text-sm text-blue-700 mt-1">SMS settings are managed through environment variables. Update your .env file with Twilio credentials and restart the application to apply changes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="{{ route('settings.email-templates') }}" class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Email Templates</h3>
                    <p class="text-sm text-gray-600">Manage email templates</p>
                </div>
            </div>
        </a>

        <a href="{{ route('settings.audit-logs') }}" class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Audit Logs</h3>
                    <p class="text-sm text-gray-600">View system activity logs</p>
                </div>
            </div>
        </a>

        <a href="{{ route('settings.backups') }}" class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Backups</h3>
                    <p class="text-sm text-gray-600">Manage system backups</p>
                </div>
            </div>
        </a>

        <a href="{{ route('settings.system-info') }}" class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">System Info</h3>
                    <p class="text-sm text-gray-600">View system information</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Cache Management -->
    <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Cache Management</h3>
                <p class="text-sm text-gray-600 mt-1">Clear application cache to resolve issues or apply new settings</p>
            </div>
            <form action="{{ route('settings.clear-cache') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all cache? This may temporarily slow down the application.')">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Clear Cache
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('settingsTabs', () => ({
        activeTab: 'general'
    }))
})
</script>
@endsection
