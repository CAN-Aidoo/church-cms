<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, viewport-fit=cover">
    <meta name="theme-color" content="#2563eb">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Church App'))</title>

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192x192.png') }}">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            -webkit-tap-highlight-color: transparent;
            overscroll-behavior-y: none;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        .pb-safe { padding-bottom: env(safe-area-inset-bottom); }
        .pt-safe { padding-top: env(safe-area-inset-top); }
        
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Minimalist Utilities */
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-top: 1px solid #f1f5f9;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex flex-col h-full selection:bg-blue-100 selection:text-blue-700">
    
    <!-- Header (Optional per page) -->
    @hasSection('header')
    <header class="sticky top-0 z-40 glass border-b border-slate-200/50 pt-safe transition-all duration-200" id="main-header">
        <div class="px-4 h-14 flex items-center justify-between">
            <h1 class="font-bold text-lg text-slate-800 tracking-tight">@yield('header')</h1>
            <div class="flex items-center gap-2">
                @yield('header-actions')
            </div>
        </div>
    </header>
    @endif

    <!-- Main Content -->
    <main class="flex-1 w-full max-w-md mx-auto relative @unless(View::hasSection('header')) pt-safe @endunless">
        @yield('content')
    </main>

    <!-- Toast Notification -->
    <div x-data="{ 
        show: false, 
        message: '', 
        type: 'success',
        showToast(msg, type = 'success') {
            this.message = msg;
            this.type = type;
            this.show = true;
            setTimeout(() => this.show = false, 3000);
        }
    }" 
    @notify.window="showToast($event.detail.message, $event.detail.type)"
    class="fixed top-4 left-4 right-4 z-50 pointer-events-none flex justify-center pt-safe">
        <div x-show="show" 
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="pointer-events-auto rounded-xl shadow-lg p-3 px-4 flex items-center gap-3 min-w-[200px] max-w-sm"
             :class="{
                 'bg-emerald-600 text-white': type === 'success',
                 'bg-rose-600 text-white': type === 'error',
                 'bg-slate-800 text-white': type === 'info'
             }">
            <span x-text="message" class="text-sm font-medium"></span>
        </div>
    </div>

    <!-- Initialization Scripts -->
    <script>
        window.API_BASE_URL = '{{ url('/api/v1') }}';
        window.MOBILE_API_BASE_URL = '{{ url('/api/mobile/v1') }}';

        // XSS protection helper - escapes HTML entities to prevent injection
        window.escapeHtml = function(text) {
            if (text === null || text === undefined) return '';
            const div = document.createElement('div');
            div.textContent = String(text);
            return div.innerHTML;
        };
    </script>
    <script src="{{ asset('js/mobile-app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize global app instance if needed
            if(window.ChurchMobileApp) {
                window.app = new ChurchMobileApp();
            }

            // Session Flash Messages
            @if(session('success'))
                window.dispatchEvent(new CustomEvent('notify', { detail: { message: "{{ session('success') }}", type: 'success' } }));
            @endif
            @if(session('error'))
                window.dispatchEvent(new CustomEvent('notify', { detail: { message: "{{ session('error') }}", type: 'error' } }));
            @endif
        });
    </script>
    <!-- Splash Screen -->
    <div id="app-splash" class="fixed inset-0 bg-primary-600 z-[100] flex flex-col items-center justify-center transition-opacity duration-500">
        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mb-6 shadow-2xl animate-pulse">
            <svg class="w-12 h-12 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-white tracking-tight">Church App</h1>
    </div>

    @stack('scripts')

    <!-- Bottom Navigation -->
    @auth
        @unless(View::hasSection('hide_nav'))
            @include('layouts.partials.mobile-nav')
        @endunless
    @endauth
</body>
</html>