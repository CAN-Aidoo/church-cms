@extends('layouts.mobile')

@section('title', 'Profile')

@section('header-actions')
<a href="{{ url('/mobile/settings') }}" class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
</a>
@endsection

@section('content')
<div class="pb-24">
    <!-- Digital ID Card Section -->
    <div class="px-6 pt-6 pb-2">
        <div class="perspective-1000 w-full aspect-[1.586/1] cursor-pointer group" onclick="toggleCardFlip(this)">
            <div id="idCardInner" class="relative w-full h-full transition-all duration-700 transform-style-3d shadow-2xl rounded-2xl">
                
                <!-- Front of Card (Digital ID) -->
                <div class="absolute inset-0 w-full h-full backface-hidden rounded-2xl overflow-hidden bg-gradient-to-br from-slate-900 to-indigo-900 border border-white/10">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary-500/20 rounded-full blur-3xl -mr-16 -mt-16"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-indigo-500/20 rounded-full blur-2xl -ml-12 -mb-12"></div>

                    <div class="relative h-full flex flex-col justify-between p-6">
                        <div class="flex justify-between items-start">
                             <!-- Church Logo / Name -->
                             <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <span class="text-white/90 font-bold tracking-wide text-sm">CHURCH APP</span>
                             </div>
                             <span class="px-2 py-0.5 rounded border border-white/20 bg-white/5 text-[10px] font-bold text-white/80 uppercase tracking-widest">Member</span>
                        </div>

                        <div class="flex items-end gap-4">
                            <!-- User Photo -->
                            <div class="w-16 h-16 rounded-xl bg-slate-800 border-2 border-white/20 flex-shrink-0 overflow-hidden shadow-inner relative">
                                <img id="cardProfilePhoto" class="hidden w-full h-full object-cover" alt="">
                                <div id="cardProfileInitials" class="w-full h-full flex items-center justify-center text-xl font-bold text-slate-500">--</div>
                            </div>
                            <!-- User Info -->
                            <div class="pb-1">
                                <h2 class="text-xl font-bold text-white tracking-tight leading-none mb-1" id="cardMemberName">Loading...</h2>
                                <p class="text-indigo-200 text-xs font-medium tracking-wider mb-2" id="cardMemberId">ID: ....</p>
                                <div class="h-1 w-12 bg-primary-500/50 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Back of Card (QR Code) -->
                <div class="absolute inset-0 w-full h-full backface-hidden rotate-y-180 rounded-2xl overflow-hidden bg-white border border-slate-200">
                    <div class="h-full flex flex-col items-center justify-center p-6 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
                         <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Scan for Check-in</h3>
                         <div id="cardQrCode" class="w-32 h-32 bg-white p-2 rounded-xl shadow-sm border border-slate-100 flex items-center justify-center">
                             <!-- QR Code will be injected here -->
                             <svg class="w-full h-full text-slate-900" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><rect x="7" y="7" width="3" height="3"></rect><rect x="14" y="7" width="3" height="3"></rect><rect x="7" y="14" width="3" height="3"></rect><rect x="14" y="14" width="3" height="3"></rect></svg>
                         </div>
                         <p class="mt-4 text-[10px] text-slate-400 font-mono" id="cardMemberIdBack">ID: ....</p>
                    </div>
                </div>

            </div>
        </div>
        <p class="text-center text-xs font-bold text-indigo-400 mt-4 animate-pulse flex items-center justify-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            Tap card to flip
        </p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 gap-4 px-6 mb-6">
        <div class="bg-indigo-50/50 rounded-2xl p-4 border border-indigo-100/50 flex items-center gap-3">
             <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0">
                 <span class="text-lg font-bold" id="statSummaryAttendance">--</span>
             </div>
             <div>
                 <p class="text-xs text-slate-500 font-medium">Attendance</p>
                 <p class="text-xs font-bold text-slate-700">This Year</p>
             </div>
        </div>
        <div class="bg-amber-50/50 rounded-2xl p-4 border border-amber-100/50 flex items-center gap-3">
             <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                 <span class="text-lg font-bold" id="statSummaryGiving">--</span>
             </div>
             <div>
                 <p class="text-xs text-slate-500 font-medium">Contributions</p>
                 <p class="text-xs font-bold text-slate-700">This Year</p>
             </div>
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
    function toggleCardFlip(el) {
        const inner = el.querySelector('#idCardInner');
        if(inner.classList.contains('rotate-y-180')) {
            inner.classList.remove('rotate-y-180');
        } else {
            inner.classList.add('rotate-y-180');
        }
    }

    async function initProfile() {
        try {
            ChurchApp.showLoading(true);
            const userRes = await ChurchApp.getMyProfile();
            
            if(userRes.success) {
                const u = userRes.member;
                
                // Update Card Data
                document.getElementById('cardMemberName').textContent = u.full_name;
                document.getElementById('cardMemberId').textContent = 'ID: ' + (u.member_id || '---');
                document.getElementById('cardMemberIdBack').textContent = 'ID: ' + (u.member_id || '---');

                if(u.photo_url) {
                    const img = document.getElementById('cardProfilePhoto');
                    img.src = u.photo_url;
                    img.classList.remove('hidden');
                    document.getElementById('cardProfileInitials').classList.add('hidden');
                } else {
                    const i = u.full_name.split(' ').map(n=>n[0]).join('').substring(0,2).toUpperCase();
                    document.getElementById('cardProfileInitials').textContent = i;
                }

                // Generate QR (Mock for now, using a placeholder image logic or a library if available. For now just text or simple svg was placed in HTML).
                // If we had a QR lib: new QRCode(document.getElementById("cardQrCode"), u.member_id);
                // Since we don't have the lib imported yet, we'll leave the placeholder HTML or fetch a QR image if the API provides one.
                if(u.qr_code_url) {
                     document.getElementById('cardQrCode').innerHTML = `<img src="${u.qr_code_url}" class="w-full h-full">`;
                }
            }

            // Load Stats
            const att = await ChurchApp.apiCall('/api/v1/my/attendance?summary=true', 'GET');
            if(att.success) document.getElementById('statSummaryAttendance').textContent = Math.round(att.data.attendance_percentage || 0) + '%';
            
            // Mock other stats
            document.getElementById('statSummaryGiving').textContent = 'GHS 240'; // Mock

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
