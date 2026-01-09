@extends('layouts.mobile')

@section('title', 'Give - Church App')
@section('header', 'Give')

@section('content')
<div class="pb-24 pt-6">
    <!-- Header -->
    <div class="px-6 mb-8 text-center">
        <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary-600 to-indigo-600 tracking-tight">Give</h1>
        <p class="text-slate-500 font-medium">Support the vision with your generosity</p>
    </div>

    <div class="px-4">
        <form id="givingForm" class="space-y-6">
            
            <!-- Amount Input -->
            <div class="glass rounded-[2rem] p-6 shadow-xl shadow-indigo-100/50 border border-white/50 relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-400 to-indigo-400"></div>
                
                <label class="block text-center text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Enter Amount (GHS)</label>
                
                <div class="relative flex justify-center items-end gap-1 mb-8">
                    <span class="text-3xl text-slate-400 font-medium mb-2">₵</span>
                    <input type="number" name="amount" id="customAmount" class="w-48 bg-transparent border-0 border-b-2 border-slate-200 focus:border-primary-500 focus:ring-0 text-center text-5xl font-bold text-slate-800 placeholder-slate-200 transition-all p-0" placeholder="0" autofocus>
                </div>

                <!-- Quick Amounts -->
                <div class="flex justify-between gap-2">
                    @foreach([50, 100, 200, 500] as $amt)
                    <button type="button" onclick="setAmount({{ $amt }})" class="flex-1 py-2 rounded-xl border border-slate-200 text-slate-600 font-bold text-sm hover:border-primary-500 hover:text-primary-600 hover:bg-primary-50 transition-all active:scale-95">
                        {{ $amt }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Configuration Card -->
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                <!-- Category -->
                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Giving Type</label>
                    <div class="flex gap-3 overflow-x-auto hide-scrollbar pb-2">
                        @foreach([
                            ['id' => 'tithe', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1', 'label' => 'Tithe'],
                            ['id' => 'offering', 'icon' => 'M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7', 'label' => 'Offering'],
                            ['id' => 'donation', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'label' => 'Donation'],
                            ['id' => 'welfare', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'label' => 'Welfare'],
                        ] as $cat)
                        <label class="relative flex-none">
                            <input type="radio" name="category" value="{{ $cat['id'] }}" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}>
                            <div class="w-24 h-24 rounded-2xl border-2 border-slate-100 flex flex-col items-center justify-center gap-2 text-slate-400 transition-all peer-checked:border-primary-500 peer-checked:bg-primary-50 peer-checked:text-primary-600 hover:bg-slate-50 cursor-pointer">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $cat['icon'] }}"/></svg>
                                <span class="text-xs font-bold">{{ $cat['label'] }}</span>
                            </div>
                            <div class="absolute top-2 right-2 w-2 h-2 rounded-full bg-primary-600 opacity-0 peer-checked:opacity-100"></div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Payment Method</label>
                    <div class="space-y-3">
                        <label class="flex items-center gap-4 p-4 border-2 border-slate-100 rounded-xl cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50">
                            <input type="radio" name="payment_method" value="mobile_money" class="text-primary-600" checked>
                            <div class="flex-1">
                                <span class="block text-sm font-bold text-slate-700">Mobile Money</span>
                                <span class="text-xs text-slate-400">MTN, Vodafone, AirtelTigo</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-4 p-4 border-2 border-slate-100 rounded-xl cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50">
                            <input type="radio" name="payment_method" value="card" class="text-primary-600">
                            <div class="flex-1">
                                <span class="block text-sm font-bold text-slate-700">Debit/Credit Card</span>
                                <span class="text-xs text-slate-400">Visa, Mastercard</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Mobile Money Details (shown when mobile_money selected) -->
                <div id="mobileMoneyDetails" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Mobile Money Provider</label>
                        <select name="mobile_money_provider" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="mtn">MTN Mobile Money</option>
                            <option value="vodafone">Vodafone Cash</option>
                            <option value="airteltigo">AirtelTigo Money</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Mobile Money Number</label>
                        <input type="tel" name="mobile_money_number" placeholder="0XX XXX XXXX" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <!-- Frequency -->
                <div class="flex items-center justify-between py-4 mt-6 border-t border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-700">Monthly Recurring</span>
                            <span class="text-xs text-slate-400">Auto-deduct every month</span>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="recurring" id="recurringToggle" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                    </label>
                </div>
            </div>

            <!-- Submit Action -->
            <button type="submit" class="w-full bg-slate-900 text-white font-bold py-5 rounded-2xl shadow-xl shadow-slate-900/20 active:scale-[0.98] transition-all flex items-center justify-center gap-3 text-lg border border-slate-800">
                <span>Give Now</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </button>

        </form>

        <!-- Footer Link -->
        <div class="mt-8 text-center">
            <a href="{{ url('/mobile/giving-history') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-400 hover:text-primary-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                View Giving History
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function setAmount(amount) {
        document.getElementById('customAmount').value = amount;
    }

    // Toggle payment method details
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            const mobileMoneyDetails = document.getElementById('mobileMoneyDetails');
            if (e.target.value === 'mobile_money') {
                mobileMoneyDetails.style.display = 'block';
            } else {
                mobileMoneyDetails.style.display = 'none';
            }
        });
    });

    // Form Submit
    document.getElementById('givingForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const amount = document.getElementById('customAmount').value;
        if(!amount || amount <= 0) {
            ChurchApp.showToast("Please enter a valid amount", 'error');
            return;
        }

        const formData = new FormData(e.target);
        const category = formData.get('category');
        if(!category) {
            ChurchApp.showToast("Please select a giving type", 'error');
            return;
        }

        const paymentMethod = formData.get('payment_method');

        // Validate mobile money fields
        if (paymentMethod === 'mobile_money') {
            const mobileNumber = formData.get('mobile_money_number');
            if (!mobileNumber || mobileNumber.length < 10) {
                ChurchApp.showToast("Please enter a valid mobile money number", 'error');
                return;
            }
        }

        // Build payment request
        const paymentData = {
            amount: parseFloat(amount),
            category: category,
            payment_method: paymentMethod,
            recurring: formData.get('recurring') === 'on'
        };

        // Add mobile money specific fields
        if (paymentMethod === 'mobile_money') {
            paymentData.mobile_money_provider = formData.get('mobile_money_provider');
            paymentData.mobile_money_number = formData.get('mobile_money_number');
        }

        ChurchApp.showLoading(true);

        try {
            // Initiate payment
            const result = await ChurchApp.apiCall('/api/mobile/v1/payment/initiate', 'POST', paymentData);

            ChurchApp.showLoading(false);

            if (result.success) {
                const paymentRef = result.data.reference;

                if (paymentMethod === 'mobile_money') {
                    // Show mobile money instructions
                    showMobileMoneyInstructions(result.data);

                    // Start polling for payment status
                    pollPaymentStatus(paymentRef);
                } else {
                    // Redirect to Paystack for card payment
                    if (result.data.authorization_url) {
                        window.location.href = result.data.authorization_url;
                    }
                }
            } else {
                ChurchApp.showToast(result.message || "Payment initialization failed", 'error');
            }
        } catch(err) {
            ChurchApp.showLoading(false);
            ChurchApp.showToast(err.message || "Payment initialization failed", 'error');
            console.error('Payment error:', err);
        }
    });

    // Show mobile money payment instructions
    function showMobileMoneyInstructions(data) {
        const provider = data.provider || 'your mobile money provider';
        const amount = data.amount || '0';

        ChurchApp.showToast(`Please check your phone and approve the payment prompt from ${provider}`, 'info', 8000);

        // Create instruction overlay
        const overlay = document.createElement('div');
        overlay.id = 'paymentInstructions';
        overlay.className = 'fixed inset-0 bg-slate-900/90 backdrop-blur-sm z-50 flex items-center justify-center p-6';
        overlay.innerHTML = `
            <div class="bg-white rounded-3xl p-6 max-w-sm w-full text-center shadow-2xl">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Approve Payment</h3>
                <p class="text-slate-600 mb-4">Check your phone for a payment prompt to approve ₵${amount}</p>
                <div class="flex items-center justify-center gap-2 text-sm text-slate-500 mb-6">
                    <div class="w-2 h-2 bg-primary-600 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-primary-600 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                    <div class="w-2 h-2 bg-primary-600 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    <span class="ml-2">Waiting for confirmation...</span>
                </div>
                <button onclick="cancelPayment()" class="text-sm text-slate-400 hover:text-slate-600">Cancel</button>
            </div>
        `;
        document.body.appendChild(overlay);
    }

    // Poll payment status
    let pollInterval;
    let pollAttempts = 0;
    const MAX_POLL_ATTEMPTS = 60; // 2 minutes (2 second intervals)

    async function pollPaymentStatus(reference) {
        pollAttempts = 0;

        pollInterval = setInterval(async () => {
            pollAttempts++;

            if (pollAttempts >= MAX_POLL_ATTEMPTS) {
                clearInterval(pollInterval);
                removeInstructionsOverlay();
                ChurchApp.showToast("Payment verification timeout. Please check your giving history.", 'warning');
                return;
            }

            try {
                const result = await ChurchApp.apiCall('/api/mobile/v1/payment/verify', 'POST', { reference });

                if (result.success && result.data.status === 'success') {
                    clearInterval(pollInterval);
                    removeInstructionsOverlay();

                    // Show success message
                    ChurchApp.showToast("Payment successful! Thank you for your generosity.", 'success');

                    // Reset form
                    document.getElementById('givingForm').reset();
                    document.getElementById('customAmount').value = '';

                    // Redirect to giving history after 2 seconds
                    setTimeout(() => {
                        window.location.href = '{{ url("/mobile/giving-history") }}';
                    }, 2000);
                } else if (result.success && result.data.status === 'failed') {
                    clearInterval(pollInterval);
                    removeInstructionsOverlay();
                    ChurchApp.showToast("Payment failed. Please try again.", 'error');
                }
                // If pending, continue polling
            } catch (err) {
                console.error('Payment verification error:', err);
            }
        }, 2000); // Poll every 2 seconds
    }

    function removeInstructionsOverlay() {
        const overlay = document.getElementById('paymentInstructions');
        if (overlay) {
            overlay.remove();
        }
    }

    function cancelPayment() {
        if (pollInterval) {
            clearInterval(pollInterval);
        }
        removeInstructionsOverlay();
        ChurchApp.showToast("Payment cancelled", 'info');
    }
</script>
@endpush
