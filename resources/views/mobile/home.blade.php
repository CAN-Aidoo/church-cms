@extends('layouts.mobile')

@section('title', 'Church App')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 flex items-center justify-center">
    <div class="text-center">
        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl animate-pulse">
            <svg class="w-12 h-12 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
            </svg>
        </div>
        <p class="text-white text-lg">Loading...</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Check authentication and redirect
window.addEventListener('DOMContentLoaded', () => {
    const token = localStorage.getItem('auth_token');
    const user = JSON.parse(localStorage.getItem('user') || 'null');

    if (token && user) {
        // User is authenticated, go to dashboard
        window.location.href = '{{ url('/mobile/dashboard') }}';
    } else {
        // Not authenticated, go to login
        window.location.href = '{{ url('/mobile/login') }}';
    }
});
</script>
@endpush
