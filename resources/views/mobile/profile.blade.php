@extends('layouts.mobile')

@section('title', 'Profile')

@section('header-actions')
<a href="{{ url('/mobile/settings') }}" class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
</a>
@endsection

@section('content')
<div class="pb-24">
    <!-- Profile Header -->
    <div class="px-6 pt-2 pb-8 text-center">
        <div class="relative w-28 h-28 mx-auto mb-4">
             <div class="w-full h-full rounded-full overflow-hidden bg-slate-100 shadow-xl border-4 border-white" id="avatarContainer">
                <img id="profilePhoto" class="hidden w-full h-full object-cover" alt="Profile">
                <div id="profileInitials" class="w-full h-full flex items-center justify-center text-3xl font-bold text-slate-400">--</div>
            </div>
             <a href="{{ url('/mobile/profile-edit') }}" class="absolute bottom-0 right-0 bg-primary-600 text-white p-2 rounded-full shadow-lg hover:bg-primary-700 transition-colors">
                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            </a>
        </div>
        
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight" id="memberName">Loading...</h2>
        <p class="text-sm text-slate-500 mb-2 truncate" id="memberEmail">--</p>
        <div class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold">
            ID: <span id="memberId" class="ml-1">--</span>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-3 gap-4 px-6 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 text-center">
             <span class="block text-xl font-bold text-slate-800" id="statAttendance">--%</span>
             <span class="text-[10px] uppercase font-bold text-slate-400">Attendance</span>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 text-center">
             <span class="block text-xl font-bold text-slate-800" id="statPrograms">--</span>
             <span class="text-[10px] uppercase font-bold text-slate-400">Programs</span>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 text-center">
             <span class="block text-xl font-bold text-slate-800" id="statGroups">--</span>
             <span class="text-[10px] uppercase font-bold text-slate-400">Groups</span>
        </div>
    </div>

    <!-- Menu List -->
    <div class="px-4 space-y-3">
        <!-- Personal -->
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 divide-y divide-slate-50">
            <a href="{{ url('/mobile/profile-edit') }}" class="flex items-center gap-4 p-4 hover:bg-slate-50 transition-colors">
                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-slate-700 text-sm">Personal Info</h4>
                    <p class="text-xs text-slate-400">Edit details & contact</p>
                </div>
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>

            <a href="{{ url('/mobile/profile/attendance') }}" class="flex items-center gap-4 p-4 hover:bg-slate-50 transition-colors">
                <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-slate-700 text-sm">My Attendance</h4>
                    <p class="text-xs text-slate-400">View history</p>
                </div>
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <!-- Church Life -->
        <h3 class="px-2 text-xs font-bold text-slate-400 uppercase tracking-widest mt-6 mb-2">My Church Life</h3>
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 divide-y divide-slate-50">
             <a href="{{ url('/mobile/profile/contributions') }}" class="flex items-center gap-4 p-4 hover:bg-slate-50 transition-colors">
                <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-slate-700 text-sm">My Giving</h4>
                    <p class="text-xs text-slate-400">History & Statements</p>
                </div>
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>

            <a href="{{ url('/mobile/profile/ministry') }}" class="flex items-center gap-4 p-4 hover:bg-slate-50 transition-colors">
                <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-slate-700 text-sm">Ministry Units</h4>
                    <p class="text-xs text-slate-400">Volunteer & Serve</p>
                </div>
                 <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>

             <a href="{{ url('/mobile/profile/shepherd') }}" class="flex items-center gap-4 p-4 hover:bg-slate-50 transition-colors">
                <div class="w-10 h-10 rounded-full bg-pink-50 text-pink-600 flex items-center justify-center">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-slate-700 text-sm">My Shepherd</h4>
                    <p class="text-xs text-slate-400">Contact your leader</p>
                </div>
                 <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <!-- Logout -->
        <button onclick="handleLogout()" class="w-full mt-8 bg-slate-100 text-slate-600 font-bold py-3 rounded-xl border border-slate-200 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-colors">
            Log Out
        </button>
        <p class="text-center text-[10px] text-slate-300 mt-4 pb-4">Version 1.2.0 • Build 2024</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    async function initProfile() {
        try {
            ChurchApp.showLoading(true);
            const userRes = await ChurchApp.getMyProfile();
            
            if(userRes.success) {
                const u = userRes.member;
                document.getElementById('memberName').textContent = u.full_name;
                document.getElementById('memberEmail').textContent = u.email;
                document.getElementById('memberId').textContent = u.member_id || '---';

                if(u.photo_url) {
                    const img = document.getElementById('profilePhoto');
                    img.src = u.photo_url;
                    img.classList.remove('hidden');
                    document.getElementById('profileInitials').classList.add('hidden');
                } else {
                    const i = u.full_name.split(' ').map(n=>n[0]).join('').substring(0,2).toUpperCase();
                    document.getElementById('profileInitials').textContent = i;
                }
            }

            // Load Stats
            const att = await ChurchApp.apiCall('/api/v1/my/attendance?summary=true', 'GET');
            if(att.success) document.getElementById('statAttendance').textContent = Math.round(att.data.attendance_percentage || 0) + '%';
            
            // Mock other stats
            document.getElementById('statPrograms').textContent = '3';
            document.getElementById('statGroups').textContent = '1';

        } catch(e) {
            console.error('Profile load error', e);
        } finally {
            ChurchApp.showLoading(false);
        }
    }

    function handleLogout() {
        if(confirm('Are you sure you want to logout?')) {
            ChurchApp.showLoading(true);
            // Mock logout
            setTimeout(() => {
                localStorage.removeItem('auth_token');
                window.location.href = '{{ url('/mobile/login') }}';
            }, 800);
        }
    }

    document.addEventListener('DOMContentLoaded', initProfile);
</script>
@endpush
