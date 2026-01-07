@extends('layouts.app')

@section('title', 'System Settings')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-8">
        <div class="p-3 bg-slate-900 rounded-xl shadow-lg">
             <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">System Settings</h1>
            <p class="text-slate-500 mt-1">Configure your church management system.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-lg flex items-center gap-2 shadow-sm">
             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Navigation -->
        <div class="w-full lg:w-64 flex-shrink-0 space-y-1">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden sticky top-24">
                <nav class="flex flex-col p-2 space-y-1">
                    <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-primary-50 text-primary-700 font-bold text-sm transition-colors border-l-4 border-primary-600">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        General Settings
                    </a>
                    
                    <a href="{{ route('settings.email-templates') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium text-sm transition-colors border-l-4 border-transparent">
                         <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        Email Templates
                    </a>

                    <a href="{{ route('settings.audit-logs') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium text-sm transition-colors border-l-4 border-transparent">
                         <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                        Audit Logs
                    </a>

                    <a href="{{ route('settings.backups') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium text-sm transition-colors border-l-4 border-transparent">
                         <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" /></svg>
                        Backups & Restoration
                    </a>

                    <a href="{{ route('settings.system-info') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium text-sm transition-colors border-l-4 border-transparent">
                         <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        System Info
                    </a>
                </nav>
            </div>

            <!-- Danger Zone: Cache -->
            <div class="mt-6 bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                 <div class="p-4 bg-orange-50 border-b border-orange-100">
                    <h3 class="font-bold text-orange-800 text-sm">System Maintenance</h3>
                 </div>
                 <div class="p-4">
                     <p class="text-xs text-slate-500 mb-4">Clear application cache if you notice any data inconsistencies.</p>
                     <form action="{{ route('settings.clear-cache') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all cache? This may temporarily slow down the application.')">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 hover:text-slate-900 transition-colors font-bold text-xs shadow-sm flex items-center justify-center gap-2">
                            <svg class="w-3 h-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            Clear App Cache
                        </button>
                    </form>
                 </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
             <div class="card border-slate-100 shadow-sm" x-data="{ activeTab: 'general' }">
                <!-- Inner Tabs -->
                <div class="border-b border-slate-100 px-6 pt-2">
                    <nav class="flex space-x-8">
                        <button @click="activeTab = 'general'"
                                :class="activeTab === 'general' ? 'border-primary-500 text-primary-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                                class="py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                            Church Details
                        </button>
                        <button @click="activeTab = 'email'"
                                :class="activeTab === 'email' ? 'border-primary-500 text-primary-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                                class="py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                            Email Server
                        </button>
                        <button @click="activeTab = 'sms'"
                                :class="activeTab === 'sms' ? 'border-primary-500 text-primary-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                                class="py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                            SMS Gateway
                        </button>
                    </nav>
                </div>

                <!-- General Tab -->
                <div x-show="activeTab === 'general'" class="p-8">
                    <form action="{{ route('settings.update-general') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-8">
                            <!-- Church Info Section -->
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                    Church Information
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2">
                                         <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Church Name <span class="text-rose-500">*</span></label>
                                         <input type="text" name="church_name" value="{{ old('church_name', $generalSettings['church_name'] ?? '') }}" class="form-input w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500 font-semibold text-slate-800" required>
                                    </div>
                                    <div>
                                         <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Phone Number</label>
                                         <input type="text" name="church_phone" value="{{ old('church_phone', $generalSettings['church_phone'] ?? '') }}" class="form-input w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                                    </div>
                                    <div>
                                         <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Official Email</label>
                                         <input type="email" name="church_email" value="{{ old('church_email', $generalSettings['church_email'] ?? '') }}" class="form-input w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                                    </div>
                                    <div class="md:col-span-2">
                                         <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Physical Address</label>
                                         <textarea name="church_address" rows="3" class="form-textarea w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">{{ old('church_address', $generalSettings['church_address'] ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-100">

                            <!-- Regional Section -->
                            <div>
                                 <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Regional Preferences
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                         <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Timezone</label>
                                         <select name="timezone" class="form-select w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                                            @foreach(['Africa/Accra' => 'Africa/Accra (GMT)', 'Africa/Lagos' => 'Africa/Lagos (WAT)', 'Africa/Nairobi' => 'Africa/Nairobi (EAT)', 'America/New_York' => 'Eastern Time (US)', 'Europe/London' => 'London (GMT)'] as $val => $label)
                                                <option value="{{ $val }}" {{ old('timezone', $generalSettings['timezone'] ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                         </select>
                                    </div>
                                    <div>
                                         <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Date Format</label>
                                         <select name="date_format" class="form-select w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                                            @foreach(['Y-m-d' => 'YYYY-MM-DD', 'd/m/Y' => 'DD/MM/YYYY', 'm/d/Y' => 'MM/DD/YYYY', 'd-M-Y' => 'DD-MMM-YYYY'] as $val => $label)
                                                <option value="{{ $val }}" {{ old('date_format', $generalSettings['date_format'] ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                         </select>
                                    </div>
                                    <div>
                                         <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Time Format</label>
                                         <select name="time_format" class="form-select w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                                             <option value="H:i" {{ old('time_format', $generalSettings['time_format'] ?? '') == 'H:i' ? 'selected' : '' }}>24-Hour (14:30)</option>
                                             <option value="h:i A" {{ old('time_format', $generalSettings['time_format'] ?? '') == 'h:i A' ? 'selected' : '' }}>12-Hour (02:30 PM)</option>
                                         </select>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all font-bold text-sm shadow-md">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Email Tab -->
                <div x-show="activeTab === 'email'" class="p-8">
                     <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-6 mb-8 flex items-start gap-4">
                        <div class="p-3 bg-indigo-100 rounded-lg text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <h4 class="text-indigo-900 font-bold mb-1">Environment Configuration</h4>
                            <p class="text-indigo-700 text-sm leading-relaxed">SMTP settings are sensitive and managed via your server's <code class="bg-indigo-100 px-1 py-0.5 rounded text-xs font-mono">.env</code> file for security. Changes here require a server restart.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">SMTP Host</label>
                            <div class="relative">
                                <input type="text" value="{{ $emailSettings['smtp_host'] ?? '' }}" class="form-input w-full rounded-lg border-slate-200 bg-slate-50 text-slate-500" readonly>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">SMTP Port</label>
                            <input type="text" value="{{ $emailSettings['smtp_port'] ?? '' }}" class="form-input w-full rounded-lg border-slate-200 bg-slate-50 text-slate-500" readonly>
                        </div>
                         <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">From Address</label>
                            <input type="text" value="{{ $emailSettings['from_email'] ?? '' }}" class="form-input w-full rounded-lg border-slate-200 bg-slate-50 text-slate-500" readonly>
                        </div>
                         <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">From Name</label>
                            <input type="text" value="{{ $emailSettings['from_name'] ?? '' }}" class="form-input w-full rounded-lg border-slate-200 bg-slate-50 text-slate-500" readonly>
                        </div>
                    </div>
                </div>

                <!-- SMS Tab -->
                <div x-show="activeTab === 'sms'" class="p-8">
                     <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-6 mb-8 flex items-start gap-4">
                        <div class="p-3 bg-indigo-100 rounded-lg text-indigo-600">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                        </div>
                        <div>
                            <h4 class="text-indigo-900 font-bold mb-1">SMS Gateway</h4>
                            <p class="text-indigo-700 text-sm leading-relaxed">Integration settings for Twilio or other SMS providers are managed via the <code class="bg-indigo-100 px-1 py-0.5 rounded text-xs font-mono">.env</code> file.</p>
                        </div>
                    </div>

                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Provider</label>
                             <input type="text" value="{{ $smsSettings['provider'] ?? 'Twilio' }}" class="form-input w-full rounded-lg border-slate-200 bg-slate-50 text-slate-500" readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Sender ID / Phone Number</label>
                             <input type="text" value="{{ $smsSettings['sender_id'] ?? '' }}" class="form-input w-full rounded-lg border-slate-200 bg-slate-50 text-slate-500" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
