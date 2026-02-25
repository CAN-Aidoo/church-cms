@extends('layouts.mobile')

@section('title', 'Give')

@section('content')
<div class="min-h-screen bg-slate-100 pb-28">

    <!-- Blue Header with Goal Progress -->
    <div class="bg-primary-600 relative overflow-hidden" style="padding-top: calc(env(safe-area-inset-top) + 1.5rem); padding-bottom: 3.5rem; padding-left: 1.5rem; padding-right: 1.5rem;">
        <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -mr-20 -mt-20 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-12 -mb-12 pointer-events-none"></div>

        <h1 class="text-3xl font-bold text-white mb-5 relative">Giving</h1>

        <!-- Monthly Goal Progress Card -->
        <div class="bg-white/15 border border-white/15 rounded-2xl p-4 relative">
            <p class="text-blue-100 text-sm font-medium mb-1">Monthly Goal Progress</p>
            <div class="flex items-end justify-between mb-3">
                <p class="text-white text-2xl font-bold" id="goalCurrent">₵12,450</p>
                <div class="flex items-center gap-2">
                    <span class="text-blue-200 text-sm" id="goalTarget">/ ₵15,000</span>
                    <span class="bg-white/20 text-white text-xs font-bold px-2.5 py-1 rounded-full" id="goalPercent">83%</span>
                </div>
            </div>
            <div class="w-full bg-white/20 rounded-full h-2">
                <div class="bg-white rounded-full h-2 transition-all duration-700" id="goalBar" style="width: 83%"></div>
            </div>
        </div>
    </div>

    <!-- White Body -->
    <div class="bg-white rounded-t-[2rem] -mt-6 relative z-10 px-5 pt-6 pb-6">

        <p class="text-center text-slate-400 text-sm font-medium mb-2">Enter Amount</p>

        <!-- Amount Display -->
        <div class="flex items-center justify-center gap-2 mb-6">
            <span class="text-3xl font-light text-slate-400 mb-1">₵</span>
            <input type="number"
                   id="amountInput"
                   class="w-36 bg-transparent border-none text-6xl font-bold text-slate-900 text-center focus:ring-0 focus:outline-none p-0 placeholder-slate-200"
                   placeholder="0"
                   min="1"
                   inputmode="decimal">
        </div>

        <!-- One-time / Recurring Toggle -->
        <div class="flex bg-slate-100 rounded-full p-1 mb-5 gap-1">
            <button id="btnOnetime" onclick="setFrequency('onetime', this)"
                    class="flex-1 py-2.5 rounded-full text-sm font-semibold transition-all bg-white shadow text-slate-800">
                One-time
            </button>
            <button id="btnRecurring" onclick="setFrequency('recurring', this)"
                    class="flex-1 py-2.5 rounded-full text-sm font-semibold transition-all text-slate-500">
                Recurring
            </button>
        </div>

        <!-- Quick Amounts -->
        <div class="grid grid-cols-3 gap-3 mb-6">
            @foreach([10, 50, 100] as $amt)
            <button onclick="setAmount({{ $amt }})"
                    data-amount="{{ $amt }}"
                    class="quick-amt-btn py-3 rounded-full border-2 border-slate-200 text-slate-600 font-bold text-sm transition-all active:scale-95">
                ₵{{ $amt }}
            </button>
            @endforeach
        </div>

        <!-- Proceed to Give CTA -->
        <button onclick="proceedToGive()"
                class="w-full bg-primary-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-primary-600/30 active:scale-[0.98] transition-all text-base mb-2">
            Proceed to Give
        </button>
    </div>

    <!-- Recent Donations -->
    <div class="px-5 pt-5">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-base font-bold text-slate-800">Recent Donations</h3>
            <a href="{{ url('/mobile/giving-history') }}" class="text-xs font-semibold text-primary-600">View All</a>
        </div>
        <div id="recentDonationsList" class="space-y-3">
            <!-- Loading state -->
            <div class="bg-white rounded-2xl p-4 flex items-center gap-3 animate-pulse shadow-sm border border-slate-100">
                <div class="w-12 h-12 bg-slate-100 rounded-xl flex-shrink-0"></div>
                <div class="flex-1 space-y-2">
                    <div class="h-3 bg-slate-100 rounded w-2/3"></div>
                    <div class="h-3 bg-slate-100 rounded w-1/3"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal (Mobile Money instructions) -->
    <div id="paymentModal" class="hidden fixed inset-0 bg-slate-900/70 backdrop-blur-sm z-50 flex items-end">
        <div class="bg-white w-full rounded-t-3xl p-6 pb-safe">
            <div class="w-10 h-1 bg-slate-200 rounded-full mx-auto mb-6"></div>
            <h3 class="text-xl font-bold text-slate-800 mb-1 text-center" id="payModalTitle">Confirm Payment</h3>
            <p class="text-slate-500 text-sm text-center mb-6" id="payModalSubtitle">Complete your giving securely</p>

            <!-- Giving Type Selection -->
            <div class="mb-4">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Giving Type</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach(['Tithe', 'Offering', 'Donation', 'Welfare'] as $type)
                    <label class="relative">
                        <input type="radio" name="giving_type" value="{{ strtolower($type) }}" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}>
                        <div class="py-2.5 px-4 rounded-xl border-2 border-slate-100 text-sm font-semibold text-slate-500 text-center cursor-pointer transition-all peer-checked:border-primary-500 peer-checked:bg-primary-50 peer-checked:text-primary-700">
                            {{ $type }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Mobile Money Number -->
            <div class="mb-5">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Mobile Money Number</label>
                <div class="flex gap-2">
                    <select id="momoProvider" class="px-3 py-3 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 w-32">
                        <option value="mtn">MTN</option>
                        <option value="vodafone">Vodafone</option>
                        <option value="airteltigo">AirtelTigo</option>
                    </select>
                    <input type="tel" id="momoNumber" placeholder="0XX XXX XXXX"
                           class="flex-1 px-4 py-3 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>

            <div class="flex gap-3">
                <button onclick="closePaymentModal()" class="flex-1 py-3.5 rounded-2xl border-2 border-slate-200 text-slate-600 font-bold text-sm">Cancel</button>
                <button onclick="submitPayment()" class="flex-2 flex-grow py-3.5 rounded-2xl bg-primary-600 text-white font-bold text-sm shadow-lg shadow-primary-600/30">Give Now</button>
            </div>
        </div>
    </div>

    <!-- Pending/Waiting Modal -->
    <div id="pendingModal" class="hidden fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-50 flex items-center justify-center p-6">
        <div class="bg-white rounded-3xl p-6 max-w-xs w-full text-center">
            <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-primary-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Approve Payment</h3>
            <p class="text-slate-500 text-sm mb-5" id="pendingAmountText">Check your phone for a prompt to approve your payment.</p>
            <div class="flex items-center justify-center gap-1.5 mb-5">
                <div class="w-2 h-2 bg-primary-600 rounded-full animate-bounce" style="animation-delay:0s"></div>
                <div class="w-2 h-2 bg-primary-600 rounded-full animate-bounce" style="animation-delay:0.15s"></div>
                <div class="w-2 h-2 bg-primary-600 rounded-full animate-bounce" style="animation-delay:0.3s"></div>
            </div>
            <button onclick="cancelPendingPayment()" class="text-sm text-slate-400 hover:text-slate-600 font-medium">Cancel</button>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    let currentFrequency = 'onetime';
    let selectedAmount = 0;
    let pollInterval = null;

    function setFrequency(type, btn) {
        currentFrequency = type;
        const oneBtn = document.getElementById('btnOnetime');
        const recBtn = document.getElementById('btnRecurring');
        if (type === 'onetime') {
            oneBtn.classList.add('bg-white', 'shadow', 'text-slate-800');
            oneBtn.classList.remove('text-slate-500');
            recBtn.classList.remove('bg-white', 'shadow', 'text-slate-800');
            recBtn.classList.add('text-slate-500');
        } else {
            recBtn.classList.add('bg-white', 'shadow', 'text-slate-800');
            recBtn.classList.remove('text-slate-500');
            oneBtn.classList.remove('bg-white', 'shadow', 'text-slate-800');
            oneBtn.classList.add('text-slate-500');
        }
    }

    function setAmount(amount) {
        selectedAmount = amount;
        document.getElementById('amountInput').value = amount;
        document.querySelectorAll('.quick-amt-btn').forEach(btn => {
            const isSelected = parseInt(btn.dataset.amount) === amount;
            btn.classList.toggle('border-primary-600', isSelected);
            btn.classList.toggle('text-primary-600', isSelected);
            btn.classList.toggle('bg-primary-50', isSelected);
            btn.classList.toggle('border-slate-200', !isSelected);
            btn.classList.toggle('text-slate-600', !isSelected);
        });
    }

    document.getElementById('amountInput').addEventListener('input', function () {
        const val = parseFloat(this.value);
        selectedAmount = isNaN(val) ? 0 : val;
        document.querySelectorAll('.quick-amt-btn').forEach(btn => {
            const isSelected = parseInt(btn.dataset.amount) === selectedAmount;
            btn.classList.toggle('border-primary-600', isSelected);
            btn.classList.toggle('text-primary-600', isSelected);
            btn.classList.toggle('bg-primary-50', isSelected);
            btn.classList.toggle('border-slate-200', !isSelected);
            btn.classList.toggle('text-slate-600', !isSelected);
        });
    });

    function proceedToGive() {
        const amount = parseFloat(document.getElementById('amountInput').value);
        if (!amount || amount <= 0) {
            ChurchApp.showToast('Please enter a valid amount', 'error');
            return;
        }
        selectedAmount = amount;
        document.getElementById('payModalTitle').textContent = `Give ₵${amount.toLocaleString('en-GH', {minimumFractionDigits: 2})}`;
        document.getElementById('payModalSubtitle').textContent = currentFrequency === 'recurring' ? 'Monthly recurring gift' : 'One-time gift';
        document.getElementById('paymentModal').classList.remove('hidden');
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
    }

    async function submitPayment() {
        const momoNumber = document.getElementById('momoNumber').value.trim();
        if (!momoNumber || momoNumber.length < 10) {
            ChurchApp.showToast('Please enter a valid mobile money number', 'error');
            return;
        }
        const category = document.querySelector('input[name="giving_type"]:checked')?.value || 'offering';
        const paymentData = {
            amount: selectedAmount,
            category,
            payment_method: 'mobile_money',
            mobile_money_provider: document.getElementById('momoProvider').value,
            mobile_money_number: momoNumber,
            recurring: currentFrequency === 'recurring'
        };
        closePaymentModal();
        ChurchApp.showLoading(true);
        try {
            const result = await ChurchApp.apiCall('/api/mobile/v1/payment/initiate', 'POST', paymentData);
            ChurchApp.showLoading(false);
            if (result.success) {
                document.getElementById('pendingAmountText').textContent = `Check your phone and approve the ₵${selectedAmount} prompt.`;
                document.getElementById('pendingModal').classList.remove('hidden');
                pollPaymentStatus(result.data.reference);
            } else {
                ChurchApp.showToast(result.message || 'Payment initiation failed', 'error');
            }
        } catch (err) {
            ChurchApp.showLoading(false);
            ChurchApp.showToast('Payment failed. Please try again.', 'error');
        }
    }

    let pollAttempts = 0;
    function pollPaymentStatus(reference) {
        pollAttempts = 0;
        pollInterval = setInterval(async () => {
            pollAttempts++;
            if (pollAttempts >= 60) {
                clearInterval(pollInterval);
                document.getElementById('pendingModal').classList.add('hidden');
                ChurchApp.showToast('Verification timeout. Check your giving history.', 'warning');
                return;
            }
            try {
                const result = await ChurchApp.apiCall('/api/mobile/v1/payment/verify', 'POST', { reference });
                if (result.success && result.data.status === 'success') {
                    clearInterval(pollInterval);
                    document.getElementById('pendingModal').classList.add('hidden');
                    ChurchApp.showToast('Payment successful! Thank you for your generosity.', 'success');
                    document.getElementById('amountInput').value = '';
                    setAmount(0);
                    loadRecentDonations();
                    setTimeout(() => { window.location.href = '{{ url("/mobile/giving-history") }}'; }, 2000);
                } else if (result.success && result.data.status === 'failed') {
                    clearInterval(pollInterval);
                    document.getElementById('pendingModal').classList.add('hidden');
                    ChurchApp.showToast('Payment failed. Please try again.', 'error');
                }
            } catch (e) { console.error('Poll error', e); }
        }, 2000);
    }

    function cancelPendingPayment() {
        if (pollInterval) clearInterval(pollInterval);
        document.getElementById('pendingModal').classList.add('hidden');
        ChurchApp.showToast('Payment cancelled', 'info');
    }

    async function loadGoalProgress() {
        try {
            const res = await ChurchApp.getMyContributions();
            if (res.success) {
                const total = res.data.total_this_month || 0;
                const goal = 15000;
                const pct = Math.min(Math.round((total / goal) * 100), 100);
                document.getElementById('goalCurrent').textContent = ChurchApp.formatCurrency(total).replace('GH₵', '₵');
                document.getElementById('goalPercent').textContent = pct + '%';
                document.getElementById('goalBar').style.width = pct + '%';
            }
        } catch (e) { /* use static fallback */ }
    }

    async function loadRecentDonations() {
        const container = document.getElementById('recentDonationsList');
        try {
            const res = await ChurchApp.apiCall('/api/mobile/v1/payment/history', 'GET');
            if (res.success && res.data.payments && res.data.payments.length > 0) {
                container.innerHTML = res.data.payments.slice(0, 3).map(p => `
                    <div class="bg-white rounded-2xl p-4 flex items-center gap-3 shadow-sm border border-slate-100">
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-slate-800 text-sm capitalize">${window.escapeHtml(p.category || 'General Fund')}</p>
                            <p class="text-xs text-slate-400">${new Date(p.created_at || p.date).toLocaleDateString('en-GH', { day: 'numeric', month: 'short', year: 'numeric' })}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-slate-800 text-sm">${ChurchApp.formatCurrency(p.amount).replace('GH₵', '₵')}</p>
                            <span class="text-[10px] font-bold ${p.status === 'success' ? 'text-emerald-600' : 'text-amber-600'} uppercase">${p.status || 'SUCCESS'}</span>
                        </div>
                    </div>
                `).join('');
            } else {
                container.innerHTML = `
                    <div class="bg-white rounded-2xl p-4 flex items-center gap-3 shadow-sm border border-slate-100">
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-slate-800 text-sm">General Fund</p>
                            <p class="text-xs text-slate-400">No recent donations</p>
                        </div>
                    </div>`;
            }
        } catch (e) { container.innerHTML = ''; }
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadGoalProgress();
        loadRecentDonations();
    });
</script>
@endpush
