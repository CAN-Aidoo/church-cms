<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo and Header -->
            <div class="text-center">
                <div class="mx-auto h-20 w-20 rounded-2xl bg-white shadow-lg flex items-center justify-center">
                    <img src="{{ asset('images/sonlife-logo.png') }}"
                         alt="Sonlife City Church"
                         class="h-16 w-auto">
                </div>
                <h2 class="mt-6 text-3xl font-bold text-gradient-blue-gold">
                    Sonlife City Church
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Create your account
                </p>
            </div>

            <!-- Registration Form -->
            <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="form-label">Full Name</label>
                        <input id="full_name"
                               name="full_name"
                               type="text"
                               required
                               value="{{ old('full_name') }}"
                               class="form-input @error('full_name') border-red-500 @enderror"
                               placeholder="Enter your full name">
                        @error('full_name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email"
                               name="email"
                               type="email"
                               required
                               value="{{ old('email') }}"
                               class="form-input @error('email') border-red-500 @enderror"
                               placeholder="Enter your email">
                        @error('email')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="form-label">Phone Number (Optional)</label>
                        <input id="phone"
                               name="phone"
                               type="tel"
                               value="{{ old('phone') }}"
                               class="form-input @error('phone') border-red-500 @enderror"
                               placeholder="+233XXXXXXXXX">
                        @error('phone')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="form-label">Password</label>
                        <input id="password"
                               name="password"
                               type="password"
                               required
                               class="form-input @error('password') border-red-500 @enderror"
                               placeholder="Create a strong password">
                        @error('password')
                            <p class="form-error">{{ $message }}</p>
                        @else
                            <p class="form-help">Must be at least 8 characters with uppercase, number, and special character</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input id="password_confirmation"
                               name="password_confirmation"
                               type="password"
                               required
                               class="form-input"
                               placeholder="Confirm your password">
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="btn-primary w-full py-3 text-base">
                        Create Account
                    </button>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                            Sign in here
                        </a>
                    </p>
                </div>
            </form>

            <!-- Footer -->
            <div class="text-center text-xs text-gray-500 mt-8">
                <p>&copy; {{ date('Y') }} {{ config('church.name', config('app.name')) }}</p>
                <p class="mt-1">All rights reserved</p>
            </div>
        </div>
    </div>
</body>
</html>
