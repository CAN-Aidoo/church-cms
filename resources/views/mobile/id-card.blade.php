@extends('layouts.mobile')

@section('title', 'My ID Card')

@section('content')
<div class="min-h-screen bg-slate-100">

    <!-- Blue Header -->
    <div class="bg-primary-600 relative overflow-hidden" style="padding-top: calc(env(safe-area-inset-top) + 1rem); padding-bottom: 4rem; padding-left: 1.5rem; padding-right: 1.5rem;">
        <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -mr-20 -mt-20 pointer-events-none"></div>

        <div class="flex items-center justify-center relative">
            <a href="{{ url('/mobile/dashboard') }}" class="absolute left-0 w-9 h-9 bg-white/20 rounded-full flex items-center justify-center active:scale-95 transition-transform">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="text-lg font-bold text-white">My ID Card</h1>
        </div>
    </div>

    <!-- Body with overlapping avatar -->
    <div class="bg-slate-100 relative z-10 -mt-6 px-4">

        <!-- Avatar (overlaps header) -->
        <div class="flex justify-center -mt-8 mb-5">
            <div class="w-20 h-20 rounded-full border-4 border-white shadow-xl overflow-hidden bg-primary-100 flex items-center justify-center">
                <img id="cardAvatar" class="hidden w-full h-full object-cover" alt="">
                <span class="text-2xl font-bold text-primary-600" id="cardInitials">--</span>
            </div>
        </div>

        <!-- QR Card -->
        <div class="bg-white rounded-3xl shadow-lg p-6 mb-5 mx-1">

            <!-- QR Code area -->
            <div class="bg-amber-50 rounded-2xl p-6 flex items-center justify-center mb-6 min-h-[220px]" id="qrCodeWrapper">
                <!-- QR image injected here, or placeholder -->
                <div id="qrPlaceholder" class="flex flex-col items-center gap-3 text-amber-300">
                    <svg class="w-24 h-24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                        <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="5" y="5" width="3" height="3" fill="currentColor" stroke="none"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/><rect x="16" y="5" width="3" height="3" fill="currentColor" stroke="none"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="5" y="16" width="3" height="3" fill="currentColor" stroke="none"/>
                        <path d="M14 14h2v2h-2zM18 14h3v2h-3zM14 18h2v3h-2zM18 18h1v1h-1zM20 20h1v1h-1zM16 16h2v2h-2z" fill="currentColor" stroke="none"/>
                    </svg>
                    <p class="text-xs text-amber-400 font-medium">Loading QR code...</p>
                </div>
                <img id="qrCodeImage" class="hidden w-48 h-48 object-contain" alt="Member QR Code">
            </div>

            <!-- Member Info -->
            <div class="text-center">
                <h2 class="text-2xl font-bold text-slate-900 mb-1" id="cardMemberName">Loading...</h2>
                <p class="text-slate-400 text-sm mb-4" id="cardMemberId">Membership ID: CH-000000</p>
                <span class="inline-block bg-blue-50 text-primary-600 text-xs font-bold uppercase tracking-widest px-6 py-2 rounded-full border border-blue-100">Active Member</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3 mb-5 mx-1">
            <button onclick="saveToGallery()"
                    class="w-full bg-primary-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-primary-600/30 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Save to Gallery
            </button>
            <button onclick="shareCard()"
                    class="w-full bg-white text-slate-800 font-bold py-4 rounded-2xl border-2 border-slate-200 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                Share ID Card
            </button>
        </div>

        <!-- Footnote -->
        <p class="text-center text-xs text-slate-400 px-6 pb-32 leading-relaxed">
            Scan this code at any kiosk or show it to a volunteer to check in for service.
        </p>
    </div>

    <!-- Custom 5-tab nav with ID Card center active -->
    <nav class="fixed bottom-0 left-0 right-0 glass border-t border-slate-200/50 pb-safe z-50">
        <div class="flex justify-around items-center h-16 px-1">
            <!-- Home -->
            <a href="{{ url('/mobile/dashboard') }}" class="flex flex-col items-center justify-center w-full h-full gap-0.5">
                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-[10px] font-medium text-slate-400">Home</span>
            </a>
            <!-- Give -->
            <a href="{{ url('/mobile/give') }}" class="flex flex-col items-center justify-center w-full h-full gap-0.5">
                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-[10px] font-medium text-slate-400">Giving</span>
            </a>
            <!-- ID Card (center active) -->
            <div class="relative flex flex-col items-center justify-center w-full h-full">
                <div class="absolute -top-6 w-14 h-14 bg-primary-600 rounded-full shadow-lg shadow-primary-900/20 flex items-center justify-center text-white border-4 border-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                </div>
                <span class="text-[10px] font-bold text-primary-600 mt-1">ID Card</span>
                <span class="absolute -bottom-[2px] w-1 h-1 rounded-full bg-primary-600"></span>
            </div>
            <!-- Events -->
            <a href="{{ url('/mobile/events') }}" class="flex flex-col items-center justify-center w-full h-full gap-0.5">
                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="text-[10px] font-medium text-slate-400">Events</span>
            </a>
            <!-- Profile -->
            <a href="{{ url('/mobile/profile') }}" class="flex flex-col items-center justify-center w-full h-full gap-0.5">
                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="text-[10px] font-medium text-slate-400">Profile</span>
            </a>
        </div>
    </nav>
</div>
@endsection

@push('scripts')
<script>
    let memberData = null;

    async function initIdCard() {
        try {
            const res = await ChurchApp.getMyProfile();
            if (res.success) {
                const u = res.member;
                memberData = u;

                document.getElementById('cardMemberName').textContent = u.full_name || 'Member';
                document.getElementById('cardMemberId').textContent = 'Membership ID: ' + (u.member_id || 'CH-000000');

                // Avatar
                if (u.photo_url) {
                    const img = document.getElementById('cardAvatar');
                    img.src = u.photo_url;
                    img.classList.remove('hidden');
                    document.getElementById('cardInitials').classList.add('hidden');
                } else {
                    const initials = (u.full_name || 'M').split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                    document.getElementById('cardInitials').textContent = initials;
                }

                // QR Code
                if (u.qr_code_url) {
                    const img = document.getElementById('qrCodeImage');
                    img.src = u.qr_code_url;
                    img.classList.remove('hidden');
                    document.getElementById('qrPlaceholder').classList.add('hidden');
                } else {
                    // Request QR generation
                    const qrRes = await ChurchApp.apiCall('/api/v1/qr-code/personal', 'GET');
                    if (qrRes.success && qrRes.data.qr_code_url) {
                        const img = document.getElementById('qrCodeImage');
                        img.src = qrRes.data.qr_code_url;
                        img.classList.remove('hidden');
                        document.getElementById('qrPlaceholder').classList.add('hidden');
                    }
                }
            }
        } catch (e) {
            console.error('ID card load error', e);
        }
    }

    async function saveToGallery() {
        const qrImg = document.getElementById('qrCodeImage');
        if (!qrImg || qrImg.classList.contains('hidden')) {
            ChurchApp.showToast('QR code not loaded yet', 'error');
            return;
        }
        try {
            // Create canvas and draw card content
            const canvas = document.createElement('canvas');
            canvas.width = 400;
            canvas.height = 500;
            const ctx = canvas.getContext('2d');

            // Background
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, 400, 500);

            // Header bar
            ctx.fillStyle = '#2563eb';
            ctx.fillRect(0, 0, 400, 80);
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 20px sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText('SONLIFE CITY CHURCH', 200, 50);

            // QR Code
            const qr = new Image();
            qr.crossOrigin = 'anonymous';
            qr.onload = () => {
                ctx.drawImage(qr, 100, 100, 200, 200);
                // Name
                ctx.fillStyle = '#1e293b';
                ctx.font = 'bold 24px sans-serif';
                ctx.fillText(memberData?.full_name || 'Member', 200, 340);
                ctx.font = '14px sans-serif';
                ctx.fillStyle = '#64748b';
                ctx.fillText('Membership ID: ' + (memberData?.member_id || ''), 200, 365);
                // Active badge
                ctx.fillStyle = '#eff6ff';
                ctx.beginPath();
                ctx.roundRect(130, 385, 140, 32, 16);
                ctx.fill();
                ctx.fillStyle = '#2563eb';
                ctx.font = 'bold 12px sans-serif';
                ctx.fillText('ACTIVE MEMBER', 200, 406);

                // Download
                const a = document.createElement('a');
                a.download = 'sonlife-id-card.png';
                a.href = canvas.toDataURL('image/png');
                a.click();
                ChurchApp.showToast('ID Card saved!', 'success');
            };
            qr.src = qrImg.src;
        } catch (e) {
            // Fallback: share/save the QR image directly
            ChurchApp.showToast('Saving...', 'info');
            const a = document.createElement('a');
            a.download = 'my-qr-code.png';
            a.href = qrImg.src;
            a.click();
        }
    }

    async function shareCard() {
        const qrImg = document.getElementById('qrCodeImage');
        if (navigator.share) {
            try {
                await navigator.share({
                    title: 'My Church ID Card',
                    text: `${memberData?.full_name || 'Church Member'} — Membership ID: ${memberData?.member_id || ''}`,
                    url: window.location.href,
                });
            } catch (e) {
                if (e.name !== 'AbortError') ChurchApp.showToast('Could not share', 'error');
            }
        } else {
            // Copy member ID to clipboard as fallback
            try {
                await navigator.clipboard.writeText(memberData?.member_id || '');
                ChurchApp.showToast('Member ID copied to clipboard', 'success');
            } catch (e) {
                ChurchApp.showToast('Sharing not supported on this device', 'info');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', initIdCard);
</script>
@endpush
