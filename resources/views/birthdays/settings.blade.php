@extends('layouts.app')

@section('title', 'Birthday Automation Settings')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-6xl">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('birthdays.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Birthday Automation Settings</h1>
        </div>
        <p class="text-gray-600">Configure automated birthday and anniversary wishes</p>
    </div>

    <!-- Settings Tabs -->
    <div class="space-y-6">
        @foreach(['birthday', 'wedding_anniversary', 'membership_anniversary', 'ministry_anniversary'] as $eventType)
        @php
            $setting = $settings[$eventType];
            $titles = [
                'birthday' => '🎂 Birthday Wishes',
                'wedding_anniversary' => '💑 Wedding Anniversaries',
                'membership_anniversary' => '⛪ Membership Anniversaries',
                'ministry_anniversary' => '🙏 Ministry Anniversaries',
            ];
        @endphp

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('birthdays.update-settings', $eventType) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">{{ $titles[$eventType] }}</h2>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="enabled" value="1"
                               {{ $setting->enabled ? 'checked' : '' }}
                               class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <span class="font-medium text-gray-700">Enabled</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Delivery Options -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-900">Delivery Options</h3>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="sms_enabled" value="1"
                                   {{ $setting->sms_enabled ? 'checked' : '' }}
                                   class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="text-gray-700">Send via SMS</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="email_enabled" value="1"
                                   {{ $setting->email_enabled ? 'checked' : '' }}
                                   class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="text-gray-700">Send via Email</span>
                        </label>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Send Time</label>
                            <input type="time" name="send_time" value="{{ $setting->send_time }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Time to send automated wishes</p>
                        </div>
                    </div>

                    <!-- Notification Options -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-gray-900">Additional Options</h3>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="notify_pastor" value="1"
                                   {{ $setting->notify_pastor ? 'checked' : '' }}
                                   class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="text-gray-700">Notify Pastor</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="announce_in_service" value="1"
                                   {{ $setting->announce_in_service ? 'checked' : '' }}
                                   class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="text-gray-700">Announce in Service</span>
                        </label>
                    </div>

                    <!-- SMS Template -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            SMS Message Template
                        </label>
                        <textarea name="sms_template" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 font-mono text-sm"
                                  placeholder="Use {first_name}, {full_name}, {age}, {years}, {church_name}">{{ $setting->sms_template }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            Available placeholders: {first_name}, {full_name}, {title}, {church_name}
                            @if($eventType !== 'birthday'), {years}, {ordinal}@endif
                        </p>
                    </div>

                    <!-- Email Template (if enabled) -->
                    @if($setting->email_enabled)
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Email Subject
                        </label>
                        <input type="text" name="email_subject" value="{{ $setting->email_subject }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                               placeholder="Subject line for email">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Email Template
                        </label>
                        <textarea name="email_template" rows="6"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 font-mono text-sm">{{ $setting->email_template }}</textarea>
                    </div>
                    @endif

                    <!-- Special Milestones -->
                    @if($eventType !== 'birthday')
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Special Milestone Years (comma-separated)
                        </label>
                        <input type="text" name="special_milestones_input"
                               value="{{ implode(', ', $setting->special_milestones ?? [1, 5, 10, 25, 50]) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., 1, 5, 10, 25, 50">
                        <p class="text-xs text-gray-500 mt-1">These years will receive special recognition</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Special Milestone Message
                        </label>
                        <textarea name="special_milestone_message" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 font-mono text-sm"
                                  placeholder="Special message for milestone years">{{ $setting->special_milestone_message }}</textarea>
                    </div>
                    @endif
                </div>

                <!-- Save Button -->
                <div class="flex justify-end mt-6">
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Convert special milestones input to array before submission
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const input = form.querySelector('input[name="special_milestones_input"]');
            if (input) {
                const values = input.value.split(',').map(v => parseInt(v.trim())).filter(v => !isNaN(v));
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'special_milestones';
                hiddenInput.value = JSON.stringify(values);
                form.appendChild(hiddenInput);
            }
        });
    });
});
</script>
@endsection
