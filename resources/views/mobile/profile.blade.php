@extends('layouts.mobile')

@section('title', 'Profile')

@section('content')
<div class="min-h-screen bg-slate-100 pb-28">

    <!-- Blue Header -->
    <div class="bg-primary-600 relative overflow-hidden" style="padding-top: calc(env(safe-area-inset-top) + 1.5rem); padding-bottom: 5rem; padding-left: 1.5rem; padding-right: 1.5rem;">
        <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -mr-20 -mt-20 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-12 -mb-12 pointer-events-none"></div>

        <!-- Avatar + Name -->
        <div class="flex items-center gap-4 mb-6 relative">
            <div class="relative">
                <div class="w-20 h-20 rounded-full border-4 border-white/30 overflow-hidden bg-primary-500 flex items-center justify-center shadow-xl flex-shrink-0">
                    <img id="profilePhoto" class="hidden w-full h-full object-cover" alt="">
                    <span class="text-2xl font-bold text-white" id="profileInitials">--</span>
                </div>
                <span class="absolute bottom-1 right-1 w-4 h-4 bg-emerald-400 border-2 border-white rounded-full shadow"></span>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight" id="profileName">User</h2>
                <div class="inline-flex items-center gap-1.5 mt-1 bg-white/20 border border-white/20 rounded-full px-3 py-1">
                    <svg class="w-3 h-3 text-white/80" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                    <span class="text-white text-xs font-semibold" id="profileStatus">Active Member</span>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-2 relative">
            <div class="bg-white/15 rounded-2xl p-3 text-center border border-white/10">
                <p class="text-xl font-bold text-white" id="statAttended">0</p>
                <p class="text-[10px] text-blue-100/80 uppercase tracking-wide font-semibold mt-0.5">Attended</p>
            </div>
            <div class="bg-white/15 rounded-2xl p-3 text-center border border-white/10">
                <p class="text-xl font-bold text-white" id="statGiven">₵0</p>
                <p class="text-[10px] text-blue-100/80 uppercase tracking-wide font-semibold mt-0.5">Given</p>
            </div>
            <div class="bg-white/15 rounded-2xl p-3 text-center border border-white/10">
                <p class="text-xl font-bold text-white" id="statGroups">0</p>
                <p class="text-[10px] text-blue-100/80 uppercase tracking-wide font-semibold mt-0.5">Groups</p>
            </div>
        </div>
    </div>

    <!-- White Body Card -->
    <div class="bg-slate-100 -mt-6 relative z-10 px-4 pt-4 space-y-4">

        <!-- Account Section -->
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Account</p>
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 divide-y divide-slate-50">
                <a href="{{ url('/mobile/profile-edit') }}" class="flex items-center gap-4 p-4 active:bg-slate-50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <span class="flex-1 font-semibold text-slate-800 text-sm">Personal Information</span>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ url('/mobile/giving-history') }}" class="flex items-center gap-4 p-4 active:bg-slate-50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="flex-1 font-semibold text-slate-800 text-sm">Giving History</span>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ url('/mobile/ministry') }}" class="flex items-center gap-4 p-4 active:bg-slate-50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <span class="flex-1 font-semibold text-slate-800 text-sm">My Groups</span>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <!-- Preferences Section -->
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Preferences</p>
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 divide-y divide-slate-50">
                <a href="{{ url('/mobile/settings') }}" class="flex items-center gap-4 p-4 active:bg-slate-50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <span class="flex-1 font-semibold text-slate-800 text-sm">Notifications</span>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ url('/mobile/settings') }}" class="flex items-center gap-4 p-4 active:bg-slate-50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span class="flex-1 font-semibold text-slate-800 text-sm">Settings</span>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <!-- Log Out -->
        <button onclick="handleLogout()" class="w-full bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex items-center justify-center gap-2 active:bg-rose-50 transition-colors">
            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            <span class="font-bold text-rose-500 text-sm">Log Out</span>
        </button>

        <p class="text-center text-[11px] text-slate-400 pb-2">Version 2.4.1 (Build 890)</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    async function initProfile() {
        try {
            const userRes = await ChurchApp.getMyProfile();
            if (userRes.success) {
                const u = userRes.member;
                document.getElementById('profileName').textContent = u.full_name || 'User';
                if (u.photo_url) {
                    const img = document.getElementById('profilePhoto');
                    img.src = u.photo_url;
                    img.classList.remove('hidden');
                    document.getElementById('profileInitials').classList.add('hidden');
                } else {
                    const i = (u.full_name || 'U').split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                    document.getElementById('profileInitials').textContent = i;
                }
                if (u.status) document.getElementById('profileStatus').textContent = u.status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            }

            const [att, giving, ministry] = await Promise.allSettled([
                ChurchApp.getMyAttendance(),
                ChurchApp.getMyContributions(),
                ChurchApp.apiCall('/api/v1/my/ministry-involvement', 'GET')
            ]);

            if (att.status === 'fulfilled' && att.value.success) {
                document.getElementById('statAttended').textContent = att.value.data.attendance_this_year || att.value.data.attendance_this_month || 0;
            }
            if (giving.status === 'fulfilled' && giving.value.success) {
                const total = giving.value.data.total_this_year || 0;
                document.getElementById('statGiven').textContent = ChurchApp.formatCurrency(total).replace('GH₵', '₵');
            }
            if (ministry.status === 'fulfilled' && ministry.value.success) {
                document.getElementById('statGroups').textContent = ministry.value.data?.units?.length || 0;
            }
        } catch (e) {
            console.error('Profile load error', e);
        }
    }

    function handleLogout() {
        if (confirm('Are you sure you want to log out?')) {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');
            window.location.href = '{{ url('/mobile/login') }}';
        }
    }

    document.addEventListener('DOMContentLoaded', initProfile);
</script>
@endpush
