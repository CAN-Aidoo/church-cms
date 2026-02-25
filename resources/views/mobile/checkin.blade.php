@extends('layouts.mobile')

@section('title', 'Service Check In')

@section('content')
<div class="min-h-screen bg-slate-100">

    <!-- Blue Header with Current Event -->
    <div class="bg-primary-600 relative overflow-hidden" style="padding-top: calc(env(safe-area-inset-top) + 1rem); padding-bottom: 3.5rem; padding-left: 1.5rem; padding-right: 1.5rem;">
        <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -mr-20 -mt-20 pointer-events-none"></div>

        <!-- Top bar -->
        <div class="flex items-center justify-center mb-5 relative">
            <a href="{{ url('/mobile/dashboard') }}" class="absolute left-0 w-9 h-9 bg-white/20 rounded-full flex items-center justify-center active:scale-95 transition-transform">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="text-lg font-bold text-white">Service Check In</h1>
        </div>

        <!-- Current Event -->
        <div class="text-center relative">
            <p class="text-blue-200 text-xs font-bold uppercase tracking-widest mb-1">Current Event</p>
            <h2 class="text-xl font-bold text-white" id="currentEventName">Sunday Morning Worship</h2>
            <p class="text-blue-200 text-sm mt-1" id="currentEventMeta">10:30 AM &bull; Main Sanctuary</p>
        </div>
    </div>

    <!-- White Body -->
    <div class="bg-white rounded-t-[2rem] -mt-6 relative z-10 px-4 pt-6 pb-8">

        <!-- QR Scanner Card -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-6">
            <!-- Camera viewport -->
            <div class="relative bg-slate-900 aspect-square w-full overflow-hidden" id="scannerWrapper">
                <!-- Camera feed mounts here -->
                <div id="qrScanner" class="w-full h-full"></div>

                <!-- Blue corner brackets overlay -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="relative w-56 h-56">
                        <!-- Top-left -->
                        <span class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-primary-500 rounded-tl-lg"></span>
                        <!-- Top-right -->
                        <span class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-primary-500 rounded-tr-lg"></span>
                        <!-- Bottom-left -->
                        <span class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-primary-500 rounded-bl-lg"></span>
                        <!-- Bottom-right -->
                        <span class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-primary-500 rounded-br-lg"></span>
                        <!-- Center QR icon (shown until camera starts) -->
                        <div id="scannerPlaceholder" class="absolute inset-0 flex items-center justify-center">
                            <svg class="w-16 h-16 text-primary-400 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Scanning status bar at bottom of camera -->
                <div class="absolute bottom-0 left-0 right-0 py-2 bg-gradient-to-t from-black/60 to-transparent">
                    <p class="text-center text-xs text-white/80 font-medium" id="scanStatusBar">Starting camera...</p>
                </div>
            </div>

            <div class="px-4 py-4 text-center">
                <p class="text-primary-600 font-bold text-base" id="scanningLabel">Scanning...</p>
                <p class="text-slate-400 text-xs mt-1">Point at the service QR code shown on the screen or in your program.</p>
            </div>
        </div>

        <!-- Or Enter Manually -->
        <div class="flex items-center gap-3 mb-4">
            <div class="flex-1 h-px bg-slate-200"></div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Or Enter Manually</span>
            <div class="flex-1 h-px bg-slate-200"></div>
        </div>

        <div class="flex gap-2">
            <input type="text"
                   id="manualCodeInput"
                   placeholder="Enter Check-in Code"
                   class="flex-1 bg-white border-2 border-slate-200 rounded-2xl py-4 px-5 text-sm font-semibold text-slate-700 placeholder-slate-300 focus:ring-0 focus:border-primary-500 transition-colors">
            <button onclick="submitManualCode()"
                    class="bg-primary-600 text-white font-bold px-6 py-4 rounded-2xl shadow-sm shadow-primary-600/30 active:scale-95 transition-transform">
                Join
            </button>
        </div>

        <!-- Quick alternatives -->
        <div class="mt-5 grid grid-cols-2 gap-3">
            <button onclick="showMyQRModal()" class="flex items-center gap-2 p-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 active:scale-95 transition-transform">
                <svg class="w-5 h-5 text-primary-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/></svg>
                <span>My QR Code</span>
            </button>
            <button onclick="showFamilyCheckIn()" class="flex items-center gap-2 p-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-700 active:scale-95 transition-transform">
                <svg class="w-5 h-5 text-primary-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Family Check-in</span>
            </button>
        </div>
    </div>

    <!-- Custom bottom nav for scanner page (4 tabs, no FAB) -->
    <nav class="fixed bottom-0 left-0 right-0 glass border-t border-slate-200/50 pb-safe z-50">
        <div class="flex justify-around items-center h-16 px-2">
            <a href="{{ url('/mobile/dashboard') }}" class="flex flex-col items-center justify-center w-full h-full gap-1">
                <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                <span class="text-[10px] font-bold text-primary-600">Home</span>
            </a>
            <a href="{{ url('/mobile/give') }}" class="flex flex-col items-center justify-center w-full h-full gap-1">
                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-[10px] font-medium text-slate-400">Give</span>
            </a>
            <a href="{{ url('/mobile/events') }}" class="flex flex-col items-center justify-center w-full h-full gap-1">
                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="text-[10px] font-medium text-slate-400">Events</span>
            </a>
            <a href="{{ url('/mobile/profile') }}" class="flex flex-col items-center justify-center w-full h-full gap-1">
                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="text-[10px] font-medium text-slate-400">Profile</span>
            </a>
        </div>
    </nav>
</div>

<!-- My QR Modal -->
<div id="myQRModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-end">
    <div class="bg-white w-full rounded-t-3xl p-6 pb-safe">
        <div class="w-10 h-1 bg-slate-200 rounded-full mx-auto mb-5"></div>
        <h3 class="text-lg font-bold text-slate-800 text-center mb-4">My QR Code</h3>
        <div class="text-center mb-4">
            <p class="font-bold text-slate-800" id="qrMemberName">Loading...</p>
            <p class="text-sm text-slate-500" id="qrMemberPhone"></p>
        </div>
        <div id="myQRCode" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-4 flex items-center justify-center min-h-[200px]">
            <div class="animate-pulse text-slate-300">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
            </div>
        </div>
        <p class="text-xs text-center text-slate-400 mb-5">Show this to an usher or volunteer to check in</p>
        <button onclick="closeMyQRModal()" class="w-full py-3.5 rounded-2xl border-2 border-slate-200 text-slate-600 font-bold text-sm">Close</button>
    </div>
</div>

<!-- Family Check-in Modal -->
<div id="familyModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-end">
    <div class="bg-white w-full rounded-t-3xl p-6 pb-safe max-h-[85vh] overflow-y-auto">
        <div class="w-10 h-1 bg-slate-200 rounded-full mx-auto mb-5"></div>
        <h3 class="text-lg font-bold text-slate-800 mb-4">Family Check-in</h3>
        <form id="familyCheckInForm">
            <div class="mb-4">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Service</label>
                <select name="service_type" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                    <option value="">Select service...</option>
                    <option value="sunday_first">Sunday 1st Service</option>
                    <option value="sunday_second">Sunday 2nd Service</option>
                    <option value="midweek">Midweek Service</option>
                    <option value="prayer_meeting">Prayer Meeting</option>
                </select>
            </div>
            <div class="mb-5">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Family Members</label>
                <div id="familyMembersList" class="space-y-2">
                    <p class="text-slate-400 text-sm text-center py-4">Loading family members...</p>
                </div>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeFamilyModal()" class="flex-1 py-3.5 rounded-2xl border-2 border-slate-200 text-slate-600 font-bold text-sm">Cancel</button>
                <button type="submit" class="flex-1 py-3.5 rounded-2xl bg-primary-600 text-white font-bold text-sm">Check In</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrCode = null;
    let scannerStarted = false;

    // ── Current Event ──────────────────────────────────────────
    async function loadCurrentEvent() {
        try {
            const res = await ChurchApp.getUpcomingEvents();
            if (res.success && res.data.events && res.data.events.length > 0) {
                const ev = res.data.events[0];
                document.getElementById('currentEventName').textContent = ev.name || 'Sunday Morning Worship';
                const date = new Date(ev.start_date);
                const time = date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
                document.getElementById('currentEventMeta').textContent = `${time} \u2022 ${ev.location || 'Main Sanctuary'}`;
            }
        } catch (e) { /* keep default */ }
    }

    // ── QR Scanner ────────────────────────────────────────────
    async function startScanner() {
        if (scannerStarted) return;
        try {
            if (!html5QrCode) {
                html5QrCode = new Html5Qrcode('qrScanner');
            }
            await html5QrCode.start(
                { facingMode: 'environment' },
                { fps: 10, qrbox: { width: 220, height: 220 }, aspectRatio: 1.0 },
                onScanSuccess,
                () => {}
            );
            scannerStarted = true;
            document.getElementById('scannerPlaceholder').style.display = 'none';
            document.getElementById('scanStatusBar').textContent = 'Camera active — align QR code';
            document.getElementById('scanningLabel').textContent = 'Scanning...';
        } catch (err) {
            console.warn('Camera error:', err);
            document.getElementById('scanStatusBar').textContent = 'Camera unavailable';
            document.getElementById('scanningLabel').textContent = 'Use manual entry below';
            document.getElementById('scanningLabel').classList.replace('text-primary-600', 'text-slate-400');
        }
    }

    async function onScanSuccess(decodedText) {
        if (html5QrCode && scannerStarted) {
            await html5QrCode.stop();
            scannerStarted = false;
        }
        document.getElementById('scanningLabel').textContent = 'Processing...';
        handleCheckIn(decodedText);
    }

    async function handleCheckIn(qrData) {
        ChurchApp.showLoading(true);
        try {
            let token = qrData;
            let endpoint = '/api/mobile/v1/check-in/service';
            try {
                const data = JSON.parse(qrData);
                if (data.token) token = data.token;
                if (data.type === 'member_checkin') endpoint = '/api/mobile/v1/check-in/member';
            } catch (e) { /* raw token */ }

            const res = await ChurchApp.apiCall(endpoint, 'POST', { token });
            if (res.success) {
                ChurchApp.showToast(res.message || 'Check-in Successful!', 'success');
                document.getElementById('scanningLabel').textContent = 'Check-in complete!';
                setTimeout(() => {
                    document.getElementById('scanningLabel').textContent = 'Scanning...';
                    startScanner();
                }, 3000);
            } else {
                throw new Error(res.message || 'Check-in failed');
            }
        } catch (e) {
            ChurchApp.showToast(e.message || 'Invalid QR Code', 'error');
            document.getElementById('scanningLabel').textContent = 'Scanning...';
            startScanner();
        } finally {
            ChurchApp.showLoading(false);
        }
    }

    // ── Manual Code ───────────────────────────────────────────
    async function submitManualCode() {
        const code = document.getElementById('manualCodeInput').value.trim();
        if (!code) {
            ChurchApp.showToast('Please enter a check-in code', 'error');
            return;
        }
        document.getElementById('manualCodeInput').value = '';
        handleCheckIn(code);
    }

    document.getElementById('manualCodeInput').addEventListener('keydown', e => {
        if (e.key === 'Enter') submitManualCode();
    });

    // ── My QR Modal ───────────────────────────────────────────
    async function showMyQRModal() {
        document.getElementById('myQRModal').classList.remove('hidden');
        try {
            const result = await ChurchApp.getMyQRCode();
            if (result.success) {
                document.getElementById('qrMemberName').textContent = result.data.member.full_name;
                document.getElementById('qrMemberPhone').textContent = result.data.member.phone || '';
                document.getElementById('myQRCode').innerHTML = result.data.qr_code;
            }
        } catch (err) {
            ChurchApp.showToast('Failed to load QR code', 'error');
            closeMyQRModal();
        }
    }

    function closeMyQRModal() {
        document.getElementById('myQRModal').classList.add('hidden');
    }

    // ── Family Check-in ───────────────────────────────────────
    async function showFamilyCheckIn() {
        document.getElementById('familyModal').classList.remove('hidden');
        try {
            const result = await ChurchApp.getFamilyMembers();
            if (result.success && result.data.length > 0) {
                document.getElementById('familyMembersList').innerHTML = result.data.map(m => `
                    <label class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl cursor-pointer active:bg-slate-100 transition-colors">
                        <input type="checkbox" name="family_members[]" value="${m.id}" checked
                               class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">${window.escapeHtml(m.full_name)}</p>
                            <p class="text-xs text-slate-400">${window.escapeHtml(m.relationship || 'Family Member')}</p>
                        </div>
                    </label>
                `).join('');
            } else {
                document.getElementById('familyMembersList').innerHTML = '<p class="text-slate-400 text-sm text-center py-4">No family members found</p>';
            }
        } catch (e) {
            ChurchApp.showToast('Failed to load family members', 'error');
        }
    }

    function closeFamilyModal() {
        document.getElementById('familyModal').classList.add('hidden');
    }

    document.getElementById('familyCheckInForm').addEventListener('submit', async e => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const serviceType = formData.get('service_type');
        const familyMembers = formData.getAll('family_members[]');
        if (!serviceType) { ChurchApp.showToast('Please select a service', 'error'); return; }
        if (familyMembers.length === 0) { ChurchApp.showToast('Select at least one family member', 'error'); return; }
        ChurchApp.showLoading(true);
        try {
            const result = await ChurchApp.checkInFamily(serviceType, familyMembers);
            if (result.success) {
                ChurchApp.showToast(`Checked in ${result.data.count} family member(s)!`, 'success');
                closeFamilyModal();
            }
        } catch (err) {
            ChurchApp.showToast(err.message || 'Family check-in failed', 'error');
        } finally {
            ChurchApp.showLoading(false);
        }
    });

    // ── Init ──────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        loadCurrentEvent();
        // Small delay so layout settles before camera starts
        setTimeout(startScanner, 400);
    });
</script>
@endpush
