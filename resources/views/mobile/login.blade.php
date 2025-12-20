@extends('layouts.mobile')

@section('title', 'Login - Church App')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 flex flex-col">
    <!-- Logo Section -->
    <div class="flex-1 flex flex-col items-center justify-center px-6 py-12">
        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mb-6 shadow-2xl">
            <svg class="w-12 h-12 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-white mb-2">Welcome Back</h1>
        <p class="text-blue-100 text-center mb-8">Sign in to continue to Church App</p>

        <!-- Login Form -->
        <div class="w-full max-w-sm">
            <form id="loginForm" class="space-y-4">
                <div>
                    <label class="block text-white text-sm font-medium mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                        </div>
                        <input type="email" id="email" name="email"
                               class="pl-10 w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50"
                               placeholder="your@email.com" required>
                    </div>
                </div>

                <div>
                    <label class="block text-white text-sm font-medium mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <input type="password" id="password" name="password"
                               class="pl-10 w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50"
                               placeholder="Enter your password" required>
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center text-white">
                        <input type="checkbox" class="rounded border-white/20 text-blue-600 focus:ring-white/50 mr-2">
                        <span>Remember me</span>
                    </label>
                    <a href="/mobile/forgot-password" class="text-white hover:underline">Forgot password?</a>
                </div>

                <button type="submit"
                        class="w-full bg-white text-blue-600 font-semibold py-3 px-4 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white/50 transition duration-200">
                    Sign In
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-blue-100 text-sm">
                    Don't have an account?
                    <a href="/mobile/register" class="text-white font-semibold hover:underline">Sign up</a>
                </p>
            </div>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/20"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-blue-700 text-blue-100">Or continue as</span>
                    </div>
                </div>

                <a href="/mobile/visitor-register"
                   class="mt-4 w-full flex items-center justify-center bg-white/10 border border-white/20 text-white font-medium py-3 px-4 rounded-lg hover:bg-white/20 transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                    </svg>
                    Visitor
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="px-6 py-4 text-center text-blue-100 text-xs">
        <p>&copy; {{ date('Y') }} Church CMS. All rights reserved.</p>
        <p class="mt-1">Version 1.0.0</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    ChurchApp.showLoading(true);

    try {
        const result = await ChurchApp.login(email, password);

        if (result.success) {
            ChurchApp.showToast('Login successful!', 'success');
            setTimeout(() => {
                window.location.href = '/mobile';
            }, 500);
        }
    } catch (error) {
        ChurchApp.showToast(error.message || 'Login failed', 'error');
    } finally {
        ChurchApp.showLoading(false);
    }
});
</script>
@endpush
