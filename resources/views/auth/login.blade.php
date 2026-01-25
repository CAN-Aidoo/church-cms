<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen flex items-center justify-center bg-gradient-premium p-4">
    <div class="w-full max-w-md animate-fade-in">
        <!-- Card -->
        <div class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl overflow-hidden border border-white/20 p-8 md:p-10 relative">
            <!-- Decorative Elements -->
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-gold"></div>
            
            <!-- Logo Section -->
            <div class="flex justify-center mb-8">
                <div class="w-20 h-20 bg-white rounded-2xl shadow-lg flex items-center justify-center">
                    <img src="{{ asset('images/sonlife-logo.png') }}"
                         alt="Sonlife City Church"
                         class="h-16 w-auto">
                </div>
            </div>

            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-2xl font-heading font-bold text-slate-800 tracking-tight">Welcome Back</h2>
                <p class="text-slate-500 mt-2 text-sm">Sign in to access your dashboard</p>
            </div>

            <!-- Alerts -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex items-start gap-3 animate-slide-up">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm text-red-600 font-medium">{{ $errors->first() }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 flex items-start gap-3 animate-slide-up">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm text-green-600 font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="form-label">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="form-input pl-10" placeholder="admin@churchcms.com">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="form-label">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <input type="password" id="password" name="password" required class="form-input pl-10" placeholder="••••••••">
                    </div>
                </div>

                <!-- Remember Me & Forgot -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="remember" name="remember" class="form-checkbox">
                        <span class="text-sm text-slate-600 font-medium select-none">Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors">Forgot password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full btn btn-primary py-3 text-lg shadow-blue-500/20">
                    Sign In
                </button>
            </form>

            <!-- Register Link -->
            <div class="mt-8 text-center text-sm text-slate-500">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-semibold text-primary-600 hover:text-primary-700 transition-colors ml-1">Register here</a>
            </div>
        </div>
        
        <!-- Footer -->
        <p class="text-center text-white/60 text-xs mt-8">
            &copy; {{ date('Y') }} {{ config('church.name', config('app.name')) }}. All rights reserved.
        </p>
    </div>
</body>
</html>
