@extends('layouts.mobile')

@section('title', 'Give - Church App')
@section('header', 'Give')

@section('content')
<div class="pb-24">
    <!-- Header Banner -->
    <div class="bg-primary-600 text-white px-6 py-8 rounded-b-[2.5rem] shadow-lg shadow-primary-900/20 mb-6">
        <div class="text-center">
            <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/20">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold tracking-tight">Give Cheerfully</h2>
            <p class="text-blue-100 text-sm mt-1 opacity-90">"God loves a cheerful giver" - 2 Cor 9:7</p>
        </div>
    </div>

    <div class="px-4">
        <form id="givingForm" class="space-y-6">
            
            <!-- Amount Selection -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                <label class="block text-sm font-bold text-slate-700 mb-3 uppercase tracking-wide">Select Amount (GHS)</label>
                
                <div class="grid grid-cols-3 gap-3 mb-4">
                    @foreach([50, 100, 200, 500, 1000] as $amt)
                    <button type="button" onclick="selectAmount({{ $amt }}, this)" class="amount-btn h-12 rounded-xl border-2 border-slate-100 font-bold text-slate-600 hover:border-primary-500 hover:bg-primary-50 hover:text-primary-700 transition-all active:scale-95">
                        {{ $amt }}
                    </button>
                    @endforeach
                    <button type="button" onclick="toggleCustomAmount(this)" class="amount-btn h-12 rounded-xl border-2 border-slate-100 font-bold text-slate-600 hover:border-primary-500 hover:bg-primary-50 hover:text-primary-700 transition-all active:scale-95" id="btn-custom">
                        Other
                    </button>
                </div>

                <div id="customAmountWrapper" class="hidden mb-4">
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">GHS</span>
                        <input type="number" id="customAmount" class="w-full pl-14 pr-4 py-3 rounded-xl border-2 border-primary-500 focus:ring-0 focus:outline-none text-lg font-bold text-slate-800 bg-slate-50" placeholder="Enter amount">
                    </div>
                </div>

                <!-- Total Display -->
                <div class="bg-slate-50 rounded-xl p-4 flex items-center justify-between border border-slate-100">
                    <span class="text-sm font-medium text-slate-500">Total Contribution</span>
                    <span class="text-2xl font-bold text-primary-600">GHS <span id="displayAmount">0.00</span></span>
                </div>
            </div>

            <!-- Category -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                <label class="block text-sm font-bold text-slate-700 mb-3 uppercase tracking-wide">Category</label>
                <div class="space-y-3">
                    @foreach([
                        ['id' => 'tithe', 'label' => 'Tithe', 'desc' => '10% of income'],
                        ['id' => 'offering', 'label' => 'Offering', 'desc' => 'General offering'],
                        ['id' => 'project', 'label' => 'Projects', 'desc' => 'Building & Development'],
                    ] as $cat)
                    <label class="category-card relative flex items-center p-4 rounded-xl border-2 border-slate-100 cursor-pointer transition-all hover:bg-slate-50">
                        <input type="radio" name="category" value="{{ $cat['id'] }}" class="peer sr-only">
                        <div class="flex-1">
                            <h4 class="font-bold text-slate-800">{{ $cat['label'] }}</h4>
                            <p class="text-xs text-slate-500">{{ $cat['desc'] }}</p>
                        </div>
                        <div class="w-5 h-5 rounded-full border-2 border-slate-300 peer-checked:border-primary-600 peer-checked:bg-primary-600 transition-all flex items-center justify-center">
                            <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100"></div>
                        </div>
                        <!-- Active styling applied via JS or peer-checked CSS -->
                        <div class="absolute inset-0 rounded-xl border-2 border-primary-600 opacity-0 peer-checked:opacity-100 pointer-events-none"></div>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Recurring Toggle -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex items-center justify-between">
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Make this recurring?</h4>
                    <p class="text-xs text-slate-500">Schedule automatic monthly giving</p>
                </div>
                <!-- Toggle Switch -->
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="recurring" class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                </label>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full bg-primary-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-primary-600/30 active:scale-[0.98] transition-transform flex items-center justify-center gap-2 text-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Proceed to Pay
            </button>

        </form>

        <!-- Giving History Teaser -->
        <div class="mt-8 mb-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-slate-800">Recent Activity</h3>
                <a href="{{ url('/mobile/giving-history') }}" class="text-sm font-semibold text-primary-600">See All</a>
            </div>
            <div id="recentGiving" class="space-y-3">
                 <!-- Loading skeleton -->
                 <div class="h-16 bg-slate-100 rounded-xl animate-pulse"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentAmount = 0;

    function selectAmount(amount, btn) {
        currentAmount = amount;
        updateDisplay();
        
        // UI State
        document.querySelectorAll('.amount-btn').forEach(b => {
             b.classList.remove('border-primary-500', 'bg-primary-50', 'text-primary-700');
             b.classList.add('border-slate-100', 'text-slate-600');
        });
        btn.classList.remove('border-slate-100', 'text-slate-600');
        btn.classList.add('border-primary-500', 'bg-primary-50', 'text-primary-700');
        
        // Hide custom
        document.getElementById('customAmountWrapper').classList.add('hidden');
    }

    function toggleCustomAmount(btn) {
        currentAmount = 0;
        updateDisplay();
        
        document.querySelectorAll('.amount-btn').forEach(b => {
             b.classList.remove('border-primary-500', 'bg-primary-50', 'text-primary-700');
             b.classList.add('border-slate-100', 'text-slate-600');
        });
        btn.classList.remove('border-slate-100', 'text-slate-600');
        btn.classList.add('border-primary-500', 'bg-primary-50', 'text-primary-700');

        document.getElementById('customAmountWrapper').classList.remove('hidden');
        document.getElementById('customAmount').focus();
    }

    document.getElementById('customAmount').addEventListener('input', (e) => {
        currentAmount = parseFloat(e.target.value) || 0;
        updateDisplay();
    });

    function updateDisplay() {
        document.getElementById('displayAmount').textContent = currentAmount.toFixed(2);
    }

    // Giving History
    async function loadHistory() {
        try {
            const res = await ChurchApp.getPaymentHistory(3);
            const container = document.getElementById('recentGiving');
            
            if(res.success && res.data.length > 0) {
                container.innerHTML = res.data.map(p => `
                    <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="font-bold text-slate-800 text-sm">${p.category_label || 'Offering'}</p>
                            <p class="text-xs text-slate-400">${new Date(p.created_at).toLocaleDateString()}</p>
                        </div>
                        <div class="text-right">
                            <span class="block font-bold text-slate-800">GHS ${parseFloat(p.amount).toFixed(2)}</span>
                            <span class="text-[10px] uppercase font-bold text-emerald-600 tracking-wide">${p.status}</span>
                        </div>
                    </div>
                `).join('');
            } else {
                container.innerHTML = '<div class="text-center text-slate-400 text-sm py-4">No recent history</div>';
            }
        } catch(e) { console.error(e); }
    }

    document.addEventListener('DOMContentLoaded', loadHistory);

    // Form Submit
    document.getElementById('givingForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        if(currentAmount <= 0) {
            window.dispatchEvent(new CustomEvent('notify', { detail: { message: "Please enter a valid amount", type: 'error' } }));
            return;
        }

        const formData = new FormData(e.target);
        if(!formData.get('category')) {
             window.dispatchEvent(new CustomEvent('notify', { detail: { message: "Please select a category", type: 'error' } }));
             return;
        }

        // Mock payment flow
        ChurchApp.showLoading(true);
        setTimeout(() => {
            ChurchApp.showLoading(false);
            window.dispatchEvent(new CustomEvent('notify', { detail: { message: "Payment initiated successfully!", type: 'success' } }));
        }, 1500);
    });
</script>
@endpush
