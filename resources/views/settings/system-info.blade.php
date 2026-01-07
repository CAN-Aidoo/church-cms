@extends('layouts.app')

@section('title', 'System Information')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">System Information</h1>
            <p class="text-slate-500 mt-1">Technical specifications and environmental health.</p>
        </div>
        <a href="{{ route('settings.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-all font-bold text-sm shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Settings
        </a>
    </div>

    @if(config('app.debug'))
        <div class="mb-8 card bg-amber-50 border-amber-100 p-5 flex items-start gap-4">
             <div class="p-2 bg-amber-100 rounded-lg text-amber-600 flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <div>
                <h4 class="font-bold text-amber-900">Debug Mode Enabled</h4>
                <p class="text-sm text-amber-800 mt-1">Your application is currently running with <code>APP_DEBUG=true</code>. Ensure this is disabled in production environments to prevent sensitive data exposure.</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Application  -->
        <div class="card border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                 <div class="p-2 bg-white border border-slate-200 rounded-lg text-indigo-600 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                </div>
                <h2 class="font-bold text-slate-800">Application Parameters</h2>
            </div>
            <div class="p-6">
                 <dl class="divide-y divide-slate-100">
                    <div class="py-3 flex justify-between items-center first:pt-0">
                        <dt class="text-sm font-medium text-slate-500">App Name</dt>
                        <dd class="text-sm font-bold text-slate-800">{{ config('app.name', 'Church CMS') }}</dd>
                    </div>
                    <div class="py-3 flex justify-between items-center">
                        <dt class="text-sm font-medium text-slate-500">Environment</dt>
                        <dd class="text-sm font-bold">
                            <span class="px-2 py-0.5 rounded-full text-xs uppercase tracking-wide
                                {{ config('app.env') === 'production' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ config('app.env') }}
                            </span>
                        </dd>
                    </div>
                     <div class="py-3 flex justify-between items-center">
                        <dt class="text-sm font-medium text-slate-500">Laravel Version</dt>
                        <dd class="text-sm font-bold text-slate-800">{{ $info['laravel_version'] ?? app()->version() }}</dd>
                    </div>
                    <div class="py-3 flex justify-between items-center">
                        <dt class="text-sm font-medium text-slate-500">PHP Version</dt>
                        <dd class="text-sm font-bold text-slate-800 font-mono bg-slate-100 px-2 py-0.5 rounded">{{ phpversion() }}</dd>
                    </div>
                    <div class="py-3 flex justify-between items-center last:pb-0">
                        <dt class="text-sm font-medium text-slate-500">Timezone</dt>
                        <dd class="text-sm font-bold text-slate-800">{{ config('app.timezone') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Server Stats -->
        <div class="card border-slate-200 shadow-sm overflow-hidden">
             <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                 <div class="p-2 bg-white border border-slate-200 rounded-lg text-emerald-600 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" /></svg>
                </div>
                <h2 class="font-bold text-slate-800">Server Configuration</h2>
            </div>
            <div class="p-6">
                <dl class="divide-y divide-slate-100">
                    <div class="py-3 flex justify-between items-center first:pt-0">
                        <dt class="text-sm font-medium text-slate-500">Operating System</dt>
                        <dd class="text-sm font-bold text-slate-800">{{ PHP_OS }}</dd>
                    </div>
                     <div class="py-3 flex justify-between items-center">
                        <dt class="text-sm font-medium text-slate-500">Server Software</dt>
                        <dd class="text-sm font-bold text-slate-800 truncate max-w-[200px]" title="{{ $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' }}">{{ $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' }}</dd>
                    </div>
                    <div class="py-3 flex justify-between items-center">
                        <dt class="text-sm font-medium text-slate-500">Max Upload Size</dt>
                        <dd class="text-sm font-bold text-slate-800 font-mono">{{ ini_get('upload_max_filesize') }}</dd>
                    </div>
                     <div class="py-3 flex justify-between items-center">
                        <dt class="text-sm font-medium text-slate-500">Memory Limit</dt>
                        <dd class="text-sm font-bold text-slate-800 font-mono">{{ ini_get('memory_limit') }}</dd>
                    </div>
                    <div class="py-3 flex justify-between items-center last:pb-0">
                        <dt class="text-sm font-medium text-slate-500">Max Execution Time</dt>
                        <dd class="text-sm font-bold text-slate-800 font-mono">{{ ini_get('max_execution_time') }}s</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Database -->
        <div class="card border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                 <div class="p-2 bg-white border border-slate-200 rounded-lg text-blue-600 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" /></svg>
                </div>
                <h2 class="font-bold text-slate-800">Database Connection</h2>
            </div>
            <div class="p-6">
                <dl class="divide-y divide-slate-100">
                    <div class="py-3 flex justify-between items-center first:pt-0">
                        <dt class="text-sm font-medium text-slate-500">Connection Type</dt>
                        <dd class="text-sm font-bold text-slate-800 capitalize">{{ config('database.default') }}</dd>
                    </div>
                    <div class="py-3 flex justify-between items-center">
                        <dt class="text-sm font-medium text-slate-500">Database Name</dt>
                        <dd class="text-sm font-bold text-slate-800">{{ config('database.connections.'.config('database.default').'.database') }}</dd>
                    </div>
                     <div class="py-3 flex justify-between items-center last:pb-0">
                        <dt class="text-sm font-medium text-slate-500">Host</dt>
                        <dd class="text-sm font-bold text-slate-800 font-mono">{{ config('database.connections.'.config('database.default').'.host') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- PHP Extensions -->
        <div class="card border-slate-200 shadow-sm overflow-hidden">
             <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                 <div class="p-2 bg-white border border-slate-200 rounded-lg text-purple-600 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
                <h2 class="font-bold text-slate-800">Required Extensions</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-3">
                    @foreach(['openssl', 'pdo', 'mbstring', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath', 'curl', 'gd'] as $ext)
                        <div class="flex items-center justify-between p-2 rounded bg-slate-50">
                            <span class="text-xs font-bold text-slate-600 uppercase">{{ $ext }}</span>
                            @if(extension_loaded($ext))
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            @else
                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
