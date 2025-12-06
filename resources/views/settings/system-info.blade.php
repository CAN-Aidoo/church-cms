@extends('layouts.app')

@section('title', 'System Information')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">System Information</h1>
            <p class="mt-2 text-sm text-gray-600">View detailed system configuration and server information</p>
        </div>
        <a href="{{ route('settings.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
            Back to Settings
        </a>
    </div>

    <!-- System Information Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Application Information -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center mb-4">
                <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h2 class="text-lg font-semibold text-gray-900">Application</h2>
            </div>
            <dl class="space-y-3">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">Application Name</dt>
                    <dd class="text-sm text-gray-900">{{ config('app.name', 'Church CMS') }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">Environment</dt>
                    <dd>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ config('app.env') === 'production' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst(config('app.env')) }}
                        </span>
                    </dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">Debug Mode</dt>
                    <dd>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ config('app.debug') ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
                        </span>
                    </dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">Laravel Version</dt>
                    <dd class="text-sm text-gray-900">{{ $info['laravel_version'] }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">Timezone</dt>
                    <dd class="text-sm text-gray-900">{{ $info['timezone'] }}</dd>
                </div>
                <div class="flex justify-between py-2">
                    <dt class="text-sm font-medium text-gray-600">URL</dt>
                    <dd class="text-sm text-gray-900 truncate">{{ config('app.url') }}</dd>
                </div>
            </dl>
        </div>

        <!-- Server Information -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center mb-4">
                <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                </svg>
                <h2 class="text-lg font-semibold text-gray-900">Server</h2>
            </div>
            <dl class="space-y-3">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">PHP Version</dt>
                    <dd class="text-sm text-gray-900">{{ $info['php_version'] }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">Server Software</dt>
                    <dd class="text-sm text-gray-900 truncate">{{ $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">Server OS</dt>
                    <dd class="text-sm text-gray-900">{{ PHP_OS }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">Max Execution Time</dt>
                    <dd class="text-sm text-gray-900">{{ ini_get('max_execution_time') }} seconds</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">Memory Limit</dt>
                    <dd class="text-sm text-gray-900">{{ ini_get('memory_limit') }}</dd>
                </div>
                <div class="flex justify-between py-2">
                    <dt class="text-sm font-medium text-gray-600">Upload Max Filesize</dt>
                    <dd class="text-sm text-gray-900">{{ ini_get('upload_max_filesize') }}</dd>
                </div>
            </dl>
        </div>

        <!-- Database Information -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center mb-4">
                <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                </svg>
                <h2 class="text-lg font-semibold text-gray-900">Database</h2>
            </div>
            <dl class="space-y-3">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">Connection</dt>
                    <dd class="text-sm text-gray-900">{{ $info['database'] }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">Database Name</dt>
                    <dd class="text-sm text-gray-900">{{ config('database.connections.' . $info['database'] . '.database') }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">Host</dt>
                    <dd class="text-sm text-gray-900">{{ config('database.connections.' . $info['database'] . '.host') }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">Port</dt>
                    <dd class="text-sm text-gray-900">{{ config('database.connections.' . $info['database'] . '.port') }}</dd>
                </div>
                <div class="flex justify-between py-2">
                    <dt class="text-sm font-medium text-gray-600">Prefix</dt>
                    <dd class="text-sm text-gray-900">{{ config('database.connections.' . $info['database'] . '.prefix') ?: 'None' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Cache & Queue Information -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center mb-4">
                <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <h2 class="text-lg font-semibold text-gray-900">Cache & Queue</h2>
            </div>
            <dl class="space-y-3">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">Cache Driver</dt>
                    <dd class="text-sm text-gray-900">{{ ucfirst($info['cache_driver']) }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">Queue Driver</dt>
                    <dd class="text-sm text-gray-900">{{ ucfirst($info['queue_driver']) }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">Session Driver</dt>
                    <dd class="text-sm text-gray-900">{{ ucfirst(config('session.driver')) }}</dd>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <dt class="text-sm font-medium text-gray-600">Broadcast Driver</dt>
                    <dd class="text-sm text-gray-900">{{ ucfirst(config('broadcasting.default')) }}</dd>
                </div>
                <div class="flex justify-between py-2">
                    <dt class="text-sm font-medium text-gray-600">Mail Driver</dt>
                    <dd class="text-sm text-gray-900">{{ ucfirst(config('mail.default')) }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- PHP Extensions -->
    <div class="mt-6 bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center mb-4">
            <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <h2 class="text-lg font-semibold text-gray-900">PHP Extensions</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @php
                $requiredExtensions = [
                    'openssl', 'pdo', 'mbstring', 'tokenizer', 'xml', 'ctype',
                    'json', 'bcmath', 'curl', 'fileinfo', 'gd', 'zip'
                ];
            @endphp
            @foreach($requiredExtensions as $extension)
                <div class="flex items-center p-3 rounded-lg {{ extension_loaded($extension) ? 'bg-green-50' : 'bg-red-50' }}">
                    @if(extension_loaded($extension))
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium text-green-800">{{ $extension }}</span>
                    @else
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium text-red-800">{{ $extension }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Disk Space (if available) -->
    <div class="mt-6 bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center mb-4">
            <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            <h2 class="text-lg font-semibold text-gray-900">Storage Information</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @php
                $totalSpace = disk_total_space('/');
                $freeSpace = disk_free_space('/');
                $usedSpace = $totalSpace - $freeSpace;
                $usedPercentage = ($usedSpace / $totalSpace) * 100;
            @endphp
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600">Disk Usage</span>
                    <span class="text-sm font-medium text-gray-900">{{ number_format($usedPercentage, 1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $usedPercentage }}%"></div>
                </div>
                <div class="flex justify-between mt-2 text-xs text-gray-500">
                    <span>{{ number_format($usedSpace / 1024 / 1024 / 1024, 2) }} GB used</span>
                    <span>{{ number_format($totalSpace / 1024 / 1024 / 1024, 2) }} GB total</span>
                </div>
            </div>
            <div>
                <dl class="space-y-2">
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-600">Free Space</dt>
                        <dd class="text-sm text-gray-900">{{ number_format($freeSpace / 1024 / 1024 / 1024, 2) }} GB</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-600">Storage Path</dt>
                        <dd class="text-sm text-gray-900 truncate">{{ storage_path() }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Warning Messages -->
    @if(config('app.debug'))
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-yellow-800">Warning: Debug Mode Enabled</h4>
                    <p class="text-sm text-yellow-700 mt-1">Debug mode is currently enabled. This should be disabled in production environments for security reasons. Set APP_DEBUG=false in your .env file.</p>
                </div>
            </div>
        </div>
    @endif

    @if(config('app.env') !== 'production')
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-blue-800">Environment: {{ ucfirst(config('app.env')) }}</h4>
                    <p class="text-sm text-blue-700 mt-1">This application is running in {{ config('app.env') }} mode. Make sure to set APP_ENV=production when deploying to production.</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
