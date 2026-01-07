@extends('layouts.mobile')

@section('title', 'Login - Church App')

@section('content')
<div class="min-h-screen bg-primary-600 flex flex-col relative overflow-hidden">
    <!-- Abstract Background Shapes -->
    <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[50%] pt-[50%] rounded-full bg-white opacity-10 blur-3xl animate-pulse"></div>
        <div class="absolute top-[20%] -right-[10%] w-[40%] pt-[40%] rounded-full bg-indigo-400 opacity-20 blur-3xl"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[60%] pt-[60%] rounded-full bg-blue-400 opacity-10 blur-3xl"></div>
    </div>

    <!-- Logo Section -->
    <div class="relative z-10 flex-1 flex flex-col items-center justify-center px-6 py-12">
        <div class="w-24 h-24 bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl flex items-center justify-center mb-8 shadow-2xl shadow-primary-900/20 transform rotate-12 transition-transform duration-500 hover:rotate-0">
             <div class="transform -rotate-12 hover:rotate-0 transition-transform duration-500">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
             </div>
        </div>

        <h1 class="text-3xl font-bold text-white mb-2 tracking-tight">Welcome Back</h1>
        <p class="text-blue-100 text-center mb-8 font-medium">Sign in to continue to Church App</p>

        <!-- Login Form -->
        <div class="w-full max-w-sm">
            <form id="loginForm" class="space-y-4">
                <div>
                    <label class="block text-blue-100 text-xs font-bold uppercase tracking-wider mb-2">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-blue-300 group-focus-within:text-white transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                        </div>
                        <input type="email" id="email" name="email"
                               class="pl-10 w-full px-4 py-3.5 rounded-xl bg-white/10 border border-white/10 text-white placeholder-blue-200/50 focus:outline-none focus:ring-2 focus:ring-white/40 focus:bg-white/20 transition-all font-medium"
                               placeholder="your@email.com" required>
                    </div>
                </div>

                <div>
                    <label class="block text-blue-100 text-xs font-bold uppercase tracking-wider mb-2">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-blue-300 group-focus-within:text-white transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <input type="password" id="password" name="password"
                               class="pl-10 w-full px-4 py-3.5 rounded-xl bg-white/10 border border-white/10 text-white placeholder-blue-200/50 focus:outline-none focus:ring-2 focus:ring-white/40 focus:bg-white/20 transition-all font-medium"
                               placeholder="Enter your password" required>
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm py-1">
                    <label class="flex items-center text-blue-100 hover:text-white transition-colors cursor-pointer">
                        <input type="checkbox" class="rounded border-white/30 bg-white/10 text-blue-500 focus:ring-offset-0 focus:ring-white/50 mr-2">
                        <span>Remember me</span>
                    </label>
                    <a href="{{ url('/mobile/forgot-password') }}" class="text-blue-100 hover:text-white transition-colors hover:underline">Forgot password?</a>
                </div>

                <button type="submit"
                        class="w-full bg-white text-primary-600 font-bold py-4 px-4 rounded-xl shadow-lg shadow-black/5 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white/50 active:scale-[0.98] transition-all duration-200 mt-2">
                    Sign In
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-blue-200 text-sm">
                    Don't have an account?
                    <a href="{{ url('/mobile/register') }}" class="text-white font-bold hover:underline ml-1">Sign up</a>
                </p>
            </div>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/10"></div>
                    </div>
                    <div class="relative flex justify-center text-xs uppercase tracking-wide">
                        <span class="px-2 bg-primary-600 text-blue-300">Or continue as</span>
                    </div>
                </div>

                <a href="{{ url('/mobile/visitor-register') }}"
                   class="mt-6 w-full flex items-center justify-center bg-white/5 border border-white/10   backdrop-blur-sm text-white font-semibold py-3.5 px-4 rounded-xl hover:bg-white/10 active:scale-[0.98] transition-all duration-200">
                    <svg class="w-5 h-5 mr-2 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                    </svg>
                    Visitor Check-in
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="relative z-10 px-6 py-6 text-center text-blue-200/60 text-[10px] uppercase tracking-wider">
        <p>&copy; {{ date('Y') }} Church CMS. All rights reserved.</p>
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
                window.location.href = '{{ url('/mobile') }}';
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
