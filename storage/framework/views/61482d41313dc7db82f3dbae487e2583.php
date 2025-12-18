<?php $__env->startSection('title', 'Give - Church App'); ?>
<?php $__env->startSection('header', 'Give'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-4 py-8">
        <div class="text-center">
            <svg class="w-16 h-16 mx-auto mb-3 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h2 class="text-2xl font-bold mb-2">Give Cheerfully</h2>
            <p class="text-blue-100 text-sm">God loves a cheerful giver - 2 Cor 9:7</p>
        </div>
    </div>

    <!-- Giving Form -->
    <div class="px-4 py-6">
        <form id="givingForm" class="bg-white rounded-xl shadow-lg p-6 space-y-6">
            <!-- Amount Selection -->
            <div>
                <label class="block text-gray-700 font-semibold mb-3">Amount (GHS)</label>

                <!-- Quick Amount Buttons -->
                <div class="grid grid-cols-3 gap-3 mb-3">
                    <button type="button" onclick="selectAmount(50)" class="amount-btn px-4 py-3 border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:border-blue-600 hover:text-blue-600 transition">
                        50
                    </button>
                    <button type="button" onclick="selectAmount(100)" class="amount-btn px-4 py-3 border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:border-blue-600 hover:text-blue-600 transition">
                        100
                    </button>
                    <button type="button" onclick="selectAmount(200)" class="amount-btn px-4 py-3 border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:border-blue-600 hover:text-blue-600 transition">
                        200
                    </button>
                    <button type="button" onclick="selectAmount(500)" class="amount-btn px-4 py-3 border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:border-blue-600 hover:text-blue-600 transition">
                        500
                    </button>
                    <button type="button" onclick="selectAmount(1000)" class="amount-btn px-4 py-3 border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:border-blue-600 hover:text-blue-600 transition">
                        1000
                    </button>
                    <button type="button" onclick="toggleCustomAmount()" class="amount-btn px-4 py-3 border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:border-blue-600 hover:text-blue-600 transition">
                        Other
                    </button>
                </div>

                <!-- Custom Amount Input -->
                <div id="customAmountDiv" class="hidden">
                    <input type="number" id="customAmount" name="custom_amount"
                           class="w-full px-4 py-3 border-2 border-blue-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Enter custom amount" min="1" step="0.01">
                </div>

                <!-- Selected Amount Display -->
                <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Selected Amount</p>
                    <p class="text-3xl font-bold text-blue-600">GHS <span id="selectedAmount">0.00</span></p>
                </div>
            </div>

            <!-- Category Selection -->
            <div>
                <label class="block text-gray-700 font-semibold mb-3">Category</label>
                <div class="space-y-2">
                    <label class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer border-2 border-transparent category-option">
                        <input type="radio" name="category" value="tithe" required class="text-blue-600 focus:ring-blue-500 mr-3">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Tithe</p>
                            <p class="text-sm text-gray-500">10% of your income</p>
                        </div>
                    </label>

                    <label class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer border-2 border-transparent category-option">
                        <input type="radio" name="category" value="offering" required class="text-blue-600 focus:ring-blue-500 mr-3">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Offering</p>
                            <p class="text-sm text-gray-500">General church offering</p>
                        </div>
                    </label>

                    <label class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer border-2 border-transparent category-option">
                        <input type="radio" name="category" value="special_offering" required class="text-blue-600 focus:ring-blue-500 mr-3">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Special Offering</p>
                            <p class="text-sm text-gray-500">For special purposes</p>
                        </div>
                    </label>

                    <label class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer border-2 border-transparent category-option">
                        <input type="radio" name="category" value="donation" required class="text-blue-600 focus:ring-blue-500 mr-3">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Donation</p>
                            <p class="text-sm text-gray-500">One-time donation</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Payment Method -->
            <div>
                <label class="block text-gray-700 font-semibold mb-3">Payment Method</label>
                <div class="space-y-2">
                    <label class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer border-2 border-transparent payment-option">
                        <input type="radio" name="payment_method" value="mobile_money" required class="text-blue-600 focus:ring-blue-500 mr-3">
                        <div class="flex items-center flex-1">
                            <svg class="w-8 h-8 mr-3 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Mobile Money</p>
                                <p class="text-sm text-gray-500">MTN, Vodafone, AirtelTigo</p>
                            </div>
                        </div>
                    </label>

                    <label class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer border-2 border-transparent payment-option">
                        <input type="radio" name="payment_method" value="card" required class="text-blue-600 focus:ring-blue-500 mr-3">
                        <div class="flex items-center flex-1">
                            <svg class="w-8 h-8 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Debit/Credit Card</p>
                                <p class="text-sm text-gray-500">Visa, Mastercard</p>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Notes (Optional) -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Notes (Optional)</label>
                <textarea name="notes" rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Add a note to your giving..."></textarea>
            </div>

            <!-- Recurring Option -->
            <div>
                <label class="flex items-start p-4 bg-blue-50 border border-blue-200 rounded-lg cursor-pointer">
                    <input type="checkbox" id="makeRecurring" name="recurring"
                           class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <div class="ml-3">
                        <p class="font-semibold text-gray-900">Make this recurring</p>
                        <p class="text-sm text-gray-600">Set up automatic giving on a schedule</p>
                    </div>
                </label>

                <!-- Recurring Options (shown when checkbox is checked) -->
                <div id="recurringOptions" class="hidden mt-3 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <label class="block text-gray-700 font-medium mb-2">Frequency</label>
                    <select name="frequency" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="weekly">Weekly</option>
                        <option value="monthly" selected>Monthly</option>
                        <option value="quarterly">Quarterly</option>
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-4 px-6 rounded-lg hover:from-blue-700 hover:to-blue-800 transition duration-200 shadow-lg">
                <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Proceed to Payment
            </button>
        </form>
    </div>

    <!-- Recent Giving History -->
    <div class="px-4 pb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">Recent Giving</h3>
            <a href="/mobile/giving-history" class="text-blue-600 text-sm font-medium">
                View All
            </a>
        </div>

        <div id="recentGiving" class="space-y-3">
            <!-- Will be populated by JavaScript -->
            <div class="text-center py-8 text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p>Loading giving history...</p>
            </div>
        </div>
    </div>

    <!-- Giving Stats -->
    <div class="px-4 pb-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">My Giving Summary</h3>

        <div class="bg-white rounded-xl shadow-lg p-6 space-y-4">
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <div>
                    <p class="text-sm text-gray-600">This Month</p>
                    <p class="text-2xl font-bold text-gray-900">GHS <span id="monthlyGiving">0.00</span></p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">This Year</p>
                    <p class="text-2xl font-bold text-gray-900">GHS <span id="yearlyGiving">0.00</span></p>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Total Contributions</span>
                    <span class="text-sm font-semibold text-gray-900" id="totalContributions">0</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Last Contribution</span>
                    <span class="text-sm font-semibold text-gray-900" id="lastContribution">Never</span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let selectedAmountValue = 0;

// Amount Selection Functions
function selectAmount(amount) {
    selectedAmountValue = amount;
    updateSelectedAmount();

    // Hide custom amount input
    document.getElementById('customAmountDiv').classList.add('hidden');
    document.getElementById('customAmount').value = '';

    // Update button states
    document.querySelectorAll('.amount-btn').forEach(btn => {
        btn.classList.remove('border-blue-600', 'text-blue-600', 'bg-blue-50');
        btn.classList.add('border-gray-300', 'text-gray-700');
    });
    event.target.classList.remove('border-gray-300', 'text-gray-700');
    event.target.classList.add('border-blue-600', 'text-blue-600', 'bg-blue-50');
}

function toggleCustomAmount() {
    const customDiv = document.getElementById('customAmountDiv');
    const isHidden = customDiv.classList.contains('hidden');

    if (isHidden) {
        customDiv.classList.remove('hidden');
        document.getElementById('customAmount').focus();
    } else {
        customDiv.classList.add('hidden');
        document.getElementById('customAmount').value = '';
        selectedAmountValue = 0;
        updateSelectedAmount();
    }

    // Update button states
    document.querySelectorAll('.amount-btn').forEach(btn => {
        btn.classList.remove('border-blue-600', 'text-blue-600', 'bg-blue-50');
        btn.classList.add('border-gray-300', 'text-gray-700');
    });
    if (isHidden) {
        event.target.classList.remove('border-gray-300', 'text-gray-700');
        event.target.classList.add('border-blue-600', 'text-blue-600', 'bg-blue-50');
    }
}

// Custom amount input handler
document.addEventListener('DOMContentLoaded', () => {
    const customAmountInput = document.getElementById('customAmount');
    if (customAmountInput) {
        customAmountInput.addEventListener('input', (e) => {
            selectedAmountValue = parseFloat(e.target.value) || 0;
            updateSelectedAmount();
        });
    }
});

function updateSelectedAmount() {
    document.getElementById('selectedAmount').textContent = selectedAmountValue.toFixed(2);
}

// Category selection highlighting
document.querySelectorAll('.category-option input').forEach(radio => {
    radio.addEventListener('change', (e) => {
        document.querySelectorAll('.category-option').forEach(opt => {
            opt.classList.remove('border-blue-600', 'bg-blue-50');
        });
        e.target.closest('.category-option').classList.add('border-blue-600', 'bg-blue-50');
    });
});

// Payment method selection highlighting
document.querySelectorAll('.payment-option input').forEach(radio => {
    radio.addEventListener('change', (e) => {
        document.querySelectorAll('.payment-option').forEach(opt => {
            opt.classList.remove('border-blue-600', 'bg-blue-50');
        });
        e.target.closest('.payment-option').classList.add('border-blue-600', 'bg-blue-50');
    });
});

// Recurring checkbox handler
document.getElementById('makeRecurring').addEventListener('change', (e) => {
    const recurringOptions = document.getElementById('recurringOptions');
    if (e.target.checked) {
        recurringOptions.classList.remove('hidden');
    } else {
        recurringOptions.classList.add('hidden');
    }
});

// Form submission
document.getElementById('givingForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    if (selectedAmountValue <= 0) {
        ChurchApp.showToast('Please select or enter an amount', 'error');
        return;
    }

    const formData = new FormData(e.target);
    const category = formData.get('category');
    const paymentMethod = formData.get('payment_method');
    const notes = formData.get('notes');
    const isRecurring = formData.get('recurring') === 'on';
    const frequency = formData.get('frequency');

    if (!category) {
        ChurchApp.showToast('Please select a category', 'error');
        return;
    }

    if (!paymentMethod) {
        ChurchApp.showToast('Please select a payment method', 'error');
        return;
    }

    const paymentData = {
        amount: selectedAmountValue,
        category: category,
        payment_method: paymentMethod,
        notes: notes,
        is_recurring: isRecurring,
        frequency: isRecurring ? frequency : null
    };

    ChurchApp.showLoading(true);

    try {
        const result = await ChurchApp.initiatePayment(paymentData);

        if (result.success) {
            // Redirect to payment gateway or show success
            if (result.data.payment_url) {
                window.location.href = result.data.payment_url;
            } else if (result.data.authorization_url) {
                window.location.href = result.data.authorization_url;
            } else {
                ChurchApp.showToast('Payment initiated successfully!', 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        }
    } catch (error) {
        ChurchApp.showToast(error.message || 'Payment failed', 'error');
    } finally {
        ChurchApp.showLoading(false);
    }
});

// Load Recent Giving History
async function loadGivingHistory() {
    try {
        const result = await ChurchApp.getPaymentHistory(5); // Last 5 payments

        if (result.success && result.data.length > 0) {
            const historyHTML = result.data.map(payment => {
                const date = new Date(payment.created_at);
                const formattedDate = date.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                });

                const statusColors = {
                    'completed': 'bg-green-100 text-green-800',
                    'pending': 'bg-yellow-100 text-yellow-800',
                    'failed': 'bg-red-100 text-red-800'
                };

                const statusColor = statusColors[payment.status] || 'bg-gray-100 text-gray-800';

                return `
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <p class="font-semibold text-gray-900">${payment.category_label || payment.category}</p>
                                <p class="text-sm text-gray-500">${formattedDate}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-900">GHS ${parseFloat(payment.amount).toFixed(2)}</p>
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded ${statusColor}">
                                    ${payment.status}
                                </span>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            document.getElementById('recentGiving').innerHTML = historyHTML;
        } else {
            document.getElementById('recentGiving').innerHTML = `
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p>No giving history yet</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Failed to load giving history:', error);
    }
}

// Load Giving Stats
async function loadGivingStats() {
    try {
        const result = await ChurchApp.getGivingStats();

        if (result.success) {
            const stats = result.data;

            document.getElementById('monthlyGiving').textContent = parseFloat(stats.monthly_total || 0).toFixed(2);
            document.getElementById('yearlyGiving').textContent = parseFloat(stats.yearly_total || 0).toFixed(2);
            document.getElementById('totalContributions').textContent = stats.total_count || 0;

            if (stats.last_contribution_date) {
                const lastDate = new Date(stats.last_contribution_date);
                document.getElementById('lastContribution').textContent = lastDate.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                });
            }
        }
    } catch (error) {
        console.error('Failed to load giving stats:', error);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    loadGivingHistory();
    loadGivingStats();
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.mobile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/mobile/give.blade.php ENDPATH**/ ?>