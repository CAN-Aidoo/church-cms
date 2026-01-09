@extends('layouts.mobile')

@section('title', 'Login - Church App')
@section('hide_nav', true)

@section('content')
<div class="min-h-screen bg-primary-600 flex flex-col relative overflow-hidden">
    <!-- Abstract Background Shapes -->
    <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[50%] pt-[50%] rounded-full bg-white opacity-10 blur-3xl animate-pulse"></div>
        <div class="absolute top-[20%] -right-[10%] w-[40%] pt-[40%] rounded-full bg-indigo-400 opacity-20 blur-3xl"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[60%] pt-[60%] rounded-full bg-blue-400 opacity-10 blur-3xl"></div>
    </div>

    <div class="flex-1 flex flex-col items-center justify-center px-6 py-8 relative z-10">
        
        <!-- Minimal Brand Header -->
        <div class="mb-10 text-center">
            <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/20 shadow-sm backdrop-blur-sm">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Welcome Back</h1>
            <p class="text-blue-100 text-sm mt-2">Sign in to your account</p>
        </div>

        <!-- Minimal Form -->
        <div class="w-full max-w-sm bg-white rounded-3xl p-6 shadow-xl shadow-blue-900/10">
            <form id="loginForm" class="space-y-5">
                <div>
                     <label class="block text-slate-600 text-xs font-bold uppercase tracking-wider mb-2">Email Address</label>
                     <input type="email" id="email" name="email"
                           class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:bg-white transition-all font-medium"
                           placeholder="name@example.com" required>
                </div>

                <div>
                    <label class="block text-slate-600 text-xs font-bold uppercase tracking-wider mb-2">Password</label>
                    <input type="password" id="password" name="password"
                           class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:bg-white transition-all font-medium"
                           placeholder="••••••••" required>
                </div>

                <div class="flex items-center justify-between text-sm pt-1">
                    <label class="flex items-center text-slate-500 hover:text-slate-700 cursor-pointer">
                        <input type="checkbox" class="rounded border-slate-300 text-primary-600 focus:ring-primary-500 mr-2">
                        <span>Remember</span>
                    </label>
                    <a href="{{ url('/mobile/forgot-password') }}" class="text-primary-600 font-semibold hover:underline">Forgot?</a>
                </div>

                <button type="submit"
                        class="w-full bg-primary-600 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-primary-600/30 hover:bg-primary-700 active:scale-[0.98] transition-all">
                    Sign In
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-slate-500 text-sm">
                    Don't have an account?
                    <a href="{{ url('/mobile/register') }}" class="text-primary-600 font-bold hover:underline">Sign up</a>
                </p>
            </div>
        </div>

        <!-- Visitor Action -->
        <a href="{{ url('/mobile/visitor-register') }}" class="mt-6 flex items-center justify-center text-white/80 hover:text-white text-sm font-medium transition-colors">
            I'm a Visitor
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>

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
            // Redirect immediately to dashboard - no delays
            window.location.href = '{{ url('/mobile/dashboard') }}';
        }
    } catch (error) {
        ChurchApp.showToast(error.message || 'Login failed', 'error');
        ChurchApp.showLoading(false);
    }
});
</script>
@endpush
