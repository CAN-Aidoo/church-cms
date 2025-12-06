<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Make Payment - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-50 to-purple-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-white rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center shadow-lg">
                <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Make a Payment</h1>
            <p class="text-gray-600" id="paymentPurpose">Loading payment details...</p>
        </div>

        <!-- Payment Form -->
        <div class="bg-white rounded-lg shadow-xl p-6" id="paymentForm">
            <form id="transactionForm">
                <!-- Amount (if not preset) -->
                <div id="amountSection" class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Amount (GHS) *</label>
                    <input type="number" name="amount" step="0.01" min="1" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-2xl font-bold">
                </div>

                <!-- Preset Amount Display -->
                <div id="presetAmount" class="hidden mb-4 text-center">
                    <p class="text-gray-600 mb-2">Amount</p>
                    <p class="text-4xl font-bold text-purple-600" id="displayAmount">GHS 0.00</p>
                </div>

                <!-- Member Information -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Your Name *</label>
                    <input type="text" name="member_name" required placeholder="First and Last Name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Phone Number *</label>
                    <input type="tel" name="phone" required placeholder="+233XXXXXXXXX" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Email (Optional)</label>
                    <input type="email" name="email" placeholder="your@email.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <!-- Payment Method -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Payment Method *</label>
                    <select name="payment_method" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Select payment method</option>
                        <option value="mtn_momo">MTN Mobile Money</option>
                        <option value="airteltigo_money">AirtelTigo Money</option>
                        <option value="vodafone_cash">Vodafone Cash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="cash">Cash</option>
                    </select>
                </div>

                <!-- Reference Number (for electronic payments) -->
                <div class="mb-4 hidden" id="referenceSection">
                    <label class="block text-gray-700 font-semibold mb-2">Transaction Reference</label>
                    <input type="text" name="reference_number" placeholder="Transaction ID from your payment" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>

                <!-- Notes -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Notes (Optional)</label>
                    <textarea name="notes" rows="2" placeholder="Any special instructions or dedication" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                </div>

                <!-- Payment Summary -->
                <div class="bg-purple-50 rounded-lg p-4 mb-6">
                    <p class="text-sm text-purple-900 font-semibold mb-2">Payment Summary</p>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-purple-700">Category:</span>
                        <span class="font-semibold text-purple-900" id="summaryCategory">-</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-purple-700">Amount:</span>
                        <span class="font-semibold text-purple-900" id="summaryAmount">GHS 0.00</span>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white font-bold py-4 rounded-lg shadow-lg hover:from-purple-700 hover:to-purple-800 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Submit Payment
                </button>
            </form>
        </div>

        <!-- Success Message -->
        <div id="successMessage" class="hidden bg-white rounded-lg shadow-xl p-6">
            <div class="text-center">
                <div class="bg-green-100 rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Payment Recorded!</h2>
                <p class="text-gray-600 mb-4">Thank you for your generous contribution</p>
                <div class="bg-blue-50 rounded-lg p-4 text-left">
                    <p class="text-sm text-blue-900 font-semibold mb-2">Transaction Details:</p>
                    <div class="text-sm text-blue-800 space-y-1">
                        <div class="flex justify-between">
                            <span>Amount:</span>
                            <span class="font-semibold" id="confirmedAmount"></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Category:</span>
                            <span class="font-semibold" id="confirmedCategory"></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Date:</span>
                            <span class="font-semibold" id="confirmedDate"></span>
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-4">You will receive a confirmation via SMS/Email</p>
            </div>
        </div>

        <!-- Error Message -->
        <div id="errorMessage" class="hidden mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-red-800 font-semibold" id="errorText"></span>
            </div>
        </div>
    </div>

    <script>
        // Get payment details from URL
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get('token');
        let paymentData = null;

        // Initialize
        async function init() {
            if (token) {
                // Validate token and get payment details (simulated)
                document.getElementById('paymentPurpose').textContent = 'Offering & Tithes';
                document.getElementById('summaryCategory').textContent = 'Offering';
            }
        }

        init();

        // Payment method change handler
        document.querySelector('select[name="payment_method"]').addEventListener('change', (e) => {
            const referenceSection = document.getElementById('referenceSection');
            if (['mtn_momo', 'airteltigo_money', 'vodafone_cash', 'bank_transfer'].includes(e.target.value)) {
                referenceSection.classList.remove('hidden');
            } else {
                referenceSection.classList.add('hidden');
            }
        });

        // Amount input handler
        document.querySelector('input[name="amount"]')?.addEventListener('input', (e) => {
            const amount = parseFloat(e.target.value) || 0;
            document.getElementById('summaryAmount').textContent = `GHS ${amount.toFixed(2)}`;
        });

        // Form submission
        document.getElementById('transactionForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = {
                transaction_type: 'income',
                category: 'offering', // This would come from the QR code data
                amount: parseFloat(formData.get('amount')),
                transaction_date: new Date().toISOString().split('T')[0],
                payment_method: formData.get('payment_method'),
                reference_number: formData.get('reference_number'),
                notes: formData.get('notes'),
                status: 'pending',
                // Temporary: Store payer info in notes since we don't have member_id
                payer_name: formData.get('member_name'),
                payer_phone: formData.get('phone'),
                payer_email: formData.get('email')
            };

            try {
                const response = await fetch('/api/v1/transactions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    document.getElementById('paymentForm').classList.add('hidden');
                    document.getElementById('confirmedAmount').textContent = `GHS ${data.amount.toFixed(2)}`;
                    document.getElementById('confirmedCategory').textContent = data.category.charAt(0).toUpperCase() + data.category.slice(1);
                    document.getElementById('confirmedDate').textContent = new Date().toLocaleDateString();
                    document.getElementById('successMessage').classList.remove('hidden');
                } else {
                    showError(result.message || 'Payment submission failed. Please try again.');
                }
            } catch (error) {
                showError('An error occurred. Please try again.');
            }
        });

        function showError(message) {
            document.getElementById('errorText').textContent = message;
            document.getElementById('errorMessage').classList.remove('hidden');
        }
    </script>
</body>
</html>
