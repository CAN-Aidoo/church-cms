@extends('layouts.mobile')

@section('title', 'Settings - Church App')
@section('header', 'Settings')

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- User Info Card -->
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 px-4 py-6 mb-6">
        <div class="flex items-center">
            <div id="userPhotoContainer" class="w-16 h-16 bg-white rounded-full flex items-center justify-center overflow-hidden mr-4">
                <img id="userPhoto" class="hidden w-full h-full object-cover" alt="User">
                <div id="userInitials" class="text-xl font-bold text-blue-600">
                    <!-- Initials -->
                </div>
            </div>
            <div class="flex-1">
                <h3 id="userName" class="text-lg font-bold text-white">Loading...</h3>
                <p id="userEmail" class="text-sm text-blue-100">email@example.com</p>
            </div>
            <button onclick="window.location.href='{{ url('/mobile/profile-edit') }}'" class="text-white hover:bg-white/20 p-2 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Notification Settings -->
    <div class="px-4 mb-6">
        <h3 class="text-sm font-bold text-gray-600 uppercase mb-3 px-2">Notifications</h3>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden divide-y divide-gray-200">
            <!-- Push Notifications -->
            <div class="flex items-center justify-between p-4">
                <div class="flex items-center flex-1">
                    <div class="bg-blue-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Push Notifications</p>
                        <p class="text-xs text-gray-600">Receive app notifications</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="pushNotifications" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>

            <!-- Event Reminders -->
            <div class="flex items-center justify-between p-4">
                <div class="flex items-center flex-1">
                    <div class="bg-purple-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Event Reminders</p>
                        <p class="text-xs text-gray-600">Get reminders for upcoming events</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="eventReminders" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>

            <!-- SMS Notifications -->
            <div class="flex items-center justify-between p-4">
                <div class="flex items-center flex-1">
                    <div class="bg-green-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">SMS Notifications</p>
                        <p class="text-xs text-gray-600">Receive text messages</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsNotifications" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>

            <!-- Email Notifications -->
            <div class="flex items-center justify-between p-4">
                <div class="flex items-center flex-1">
                    <div class="bg-yellow-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Email Notifications</p>
                        <p class="text-xs text-gray-600">Receive email updates</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="emailNotifications" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>
        </div>
    </div>

    <!-- App Preferences -->
    <div class="px-4 mb-6">
        <h3 class="text-sm font-bold text-gray-600 uppercase mb-3 px-2">App Preferences</h3>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden divide-y divide-gray-200">
            <!-- Theme -->
            <button onclick="showThemeOptions()" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-indigo-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">App Theme</p>
                        <p class="text-xs text-gray-600" id="currentTheme">Light Mode</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Language -->
            <button onclick="showLanguageOptions()" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-pink-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Language</p>
                        <p class="text-xs text-gray-600" id="currentLanguage">English</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Account -->
    <div class="px-4 mb-6">
        <h3 class="text-sm font-bold text-gray-600 uppercase mb-3 px-2">Account</h3>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden divide-y divide-gray-200">
            <!-- Change Password -->
            <button onclick="window.location.href='{{ url('/mobile/change-password') }}'" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-orange-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Change Password</p>
                        <p class="text-xs text-gray-600">Update your password</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Privacy Settings -->
            <button onclick="window.location.href='{{ url('/mobile/privacy') }}'" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-red-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Privacy Settings</p>
                        <p class="text-xs text-gray-600">Manage your privacy</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Data Management -->
    <div class="px-4 mb-6">
        <h3 class="text-sm font-bold text-gray-600 uppercase mb-3 px-2">Data Management</h3>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden divide-y divide-gray-200">
            <!-- Clear Cache -->
            <button onclick="clearCache()" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-gray-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Clear Cache</p>
                        <p class="text-xs text-gray-600">Free up storage space</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Download My Data -->
            <button onclick="downloadData()" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-teal-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Download My Data</p>
                        <p class="text-xs text-gray-600">Export your personal data</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Help & Support -->
    <div class="px-4 mb-6">
        <h3 class="text-sm font-bold text-gray-600 uppercase mb-3 px-2">Help & Support</h3>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden divide-y divide-gray-200">
            <!-- Help Center -->
            <button onclick="window.location.href='{{ url('/mobile/help') }}'" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Help Center</p>
                        <p class="text-xs text-gray-600">FAQs and tutorials</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Contact Support -->
            <button onclick="window.location.href='{{ url('/mobile/contact-support') }}'" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Contact Support</p>
                        <p class="text-xs text-gray-600">Get help from our team</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Report a Problem -->
            <button onclick="reportProblem()" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-red-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Report a Problem</p>
                        <p class="text-xs text-gray-600">Let us know about issues</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- About -->
    <div class="px-4 mb-6">
        <h3 class="text-sm font-bold text-gray-600 uppercase mb-3 px-2">About</h3>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden divide-y divide-gray-200">
            <!-- App Version -->
            <div class="flex items-center justify-between p-4">
                <div class="flex items-center">
                    <div class="bg-purple-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">App Version</p>
                        <p class="text-xs text-gray-600">Version 1.0.0</p>
                    </div>
                </div>
            </div>

            <!-- Privacy Policy -->
            <button onclick="window.location.href='{{ url('/mobile/privacy-policy') }}'" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-indigo-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Privacy Policy</p>
                        <p class="text-xs text-gray-600">How we handle your data</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Terms of Service -->
            <button onclick="window.location.href='{{ url('/mobile/terms') }}'" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-yellow-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Terms of Service</p>
                        <p class="text-xs text-gray-600">App usage terms</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Logout Button -->
    <div class="px-4 mb-6">
        <button onclick="handleLogout()" class="w-full bg-red-50 hover:bg-red-100 border-2 border-red-200 text-red-700 font-bold py-4 rounded-xl transition flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Logout
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
let userProfile = null;

// Load user profile
async function loadUserProfile() {
    try {
        const result = await ChurchApp.getMyProfile();
        if (result.success && result.data) {
            userProfile = result.data;
            renderUserProfile(userProfile);
        }
    } catch (error) {
        console.error('Failed to load profile:', error);
    }
}

// Render user profile
function renderUserProfile(profile) {
    document.getElementById('userName').textContent = profile.full_name || 'User';
    document.getElementById('userEmail').textContent = profile.email || '';

    if (profile.photo_url) {
        document.getElementById('userPhoto').src = profile.photo_url;
        document.getElementById('userPhoto').classList.remove('hidden');
        document.getElementById('userInitials').classList.add('hidden');
    } else {
        const names = (profile.full_name || 'U N').split(' ');
        const initials = names.map(n => n.charAt(0).toUpperCase()).join('').substring(0, 2);
        document.getElementById('userInitials').textContent = initials;
    }
}

// Show theme options
function showThemeOptions() {
    const options = [
        { value: 'light', label: 'Light Mode' },
        { value: 'dark', label: 'Dark Mode' },
        { value: 'auto', label: 'Auto (System)' }
    ];

    const currentTheme = localStorage.getItem('app_theme') || 'light';

    let html = '<div class="bg-white rounded-xl p-6 space-y-3">';
    html += '<h3 class="text-lg font-bold text-gray-900 mb-4">Select Theme</h3>';

    options.forEach(option => {
        const checked = currentTheme === option.value ? 'checked' : '';
        html += `
            <label class="flex items-center p-3 border-2 ${checked ? 'border-blue-600 bg-blue-50' : 'border-gray-200'} rounded-lg cursor-pointer">
                <input type="radio" name="theme" value="${option.value}" ${checked} class="w-5 h-5 text-blue-600 mr-3">
                <span class="font-semibold text-gray-900">${option.label}</span>
            </label>
        `;
    });

    html += '<button onclick="closeThemeModal()" class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition mt-4">Done</button>';
    html += '</div>';

    ChurchApp.showModal('Theme Settings', html);

    // Add event listeners to radio buttons
    document.querySelectorAll('input[name="theme"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            localStorage.setItem('app_theme', e.target.value);
            document.getElementById('currentTheme').textContent = options.find(o => o.value === e.target.value).label;
        });
    });
}

function closeThemeModal() {
    ChurchApp.closeModal();
}

// Show language options
function showLanguageOptions() {
    const options = [
        { value: 'en', label: 'English' },
        { value: 'tw', label: 'Twi' },
        { value: 'ga', label: 'Ga' }
    ];

    const currentLang = localStorage.getItem('app_language') || 'en';

    let html = '<div class="bg-white rounded-xl p-6 space-y-3">';
    html += '<h3 class="text-lg font-bold text-gray-900 mb-4">Select Language</h3>';

    options.forEach(option => {
        const checked = currentLang === option.value ? 'checked' : '';
        html += `
            <label class="flex items-center p-3 border-2 ${checked ? 'border-blue-600 bg-blue-50' : 'border-gray-200'} rounded-lg cursor-pointer">
                <input type="radio" name="language" value="${option.value}" ${checked} class="w-5 h-5 text-blue-600 mr-3">
                <span class="font-semibold text-gray-900">${option.label}</span>
            </label>
        `;
    });

    html += '<button onclick="closeLanguageModal()" class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition mt-4">Done</button>';
    html += '</div>';

    ChurchApp.showModal('Language Settings', html);

    // Add event listeners
    document.querySelectorAll('input[name="language"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            localStorage.setItem('app_language', e.target.value);
            document.getElementById('currentLanguage').textContent = options.find(o => o.value === e.target.value).label;
            ChurchApp.showToast('Language changed. Please restart the app.', 'success');
        });
    });
}

function closeLanguageModal() {
    ChurchApp.closeModal();
}

// Clear cache
async function clearCache() {
    if (!confirm('Clear all cached data? This will free up storage but may slow down the app temporarily.')) {
        return;
    }

    try {
        ChurchApp.showLoading(true);

        // Clear service worker cache
        if ('caches' in window) {
            const cacheNames = await caches.keys();
            await Promise.all(cacheNames.map(name => caches.delete(name)));
        }

        ChurchApp.showToast('Cache cleared successfully', 'success');
        ChurchApp.showLoading(false);
    } catch (error) {
        console.error('Failed to clear cache:', error);
        ChurchApp.showToast('Failed to clear cache', 'error');
        ChurchApp.showLoading(false);
    }
}

// Download data
async function downloadData() {
    if (!confirm('Request a download of all your personal data? You will receive an email with a download link within 24 hours.')) {
        return;
    }

    try {
        ChurchApp.showLoading(true);

        const result = await ChurchApp.apiCall('/api/v1/my/data-export', 'POST');

        if (result.success) {
            ChurchApp.showToast('Data export requested. Check your email within 24 hours.', 'success');
        } else {
            throw new Error(result.message || 'Request failed');
        }

        ChurchApp.showLoading(false);
    } catch (error) {
        console.error('Data export error:', error);
        ChurchApp.showToast('Failed to request data export', 'error');
        ChurchApp.showLoading(false);
    }
}

// Report problem
function reportProblem() {
    window.location.href = '{{ url('/mobile/report-problem') }}';
}

// Handle logout
async function handleLogout() {
    if (!confirm('Are you sure you want to logout?')) {
        return;
    }

    try {
        ChurchApp.showLoading(true);

        const result = await ChurchApp.apiCall('/api/v1/logout', 'POST');

        if (result.success) {
            // Clear local storage
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');

            ChurchApp.showToast('Logged out successfully', 'success');

            // Redirect to login
            setTimeout(() => {
                window.location.href = '{{ url('/mobile/login') }}';
            }, 1000);
        } else {
            throw new Error(result.message || 'Logout failed');
        }
    } catch (error) {
        console.error('Logout error:', error);
        ChurchApp.showToast('Failed to logout. Please try again.', 'error');
        ChurchApp.showLoading(false);
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    loadUserProfile();

    // Load saved preferences
    const theme = localStorage.getItem('app_theme') || 'light';
    const language = localStorage.getItem('app_language') || 'en';

    const themeLabels = { light: 'Light Mode', dark: 'Dark Mode', auto: 'Auto (System)' };
    const langLabels = { en: 'English', tw: 'Twi', ga: 'Ga' };

    document.getElementById('currentTheme').textContent = themeLabels[theme];
    document.getElementById('currentLanguage').textContent = langLabels[language];
});
</script>
@endpush
