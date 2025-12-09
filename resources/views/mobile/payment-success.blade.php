@extends('layouts.mobile')

@section('title', 'Payment Successful - Church App')
@section('header', 'Payment Receipt')

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Success Animation -->
    <div class="bg-gradient-to-br from-green-500 to-green-700 text-white px-4 py-12">
        <div class="text-center">
            <div class="relative inline-flex items-center justify-center mb-6">
                <div class="absolute w-32 h-32 bg-white/20 rounded-full animate-ping"></div>
                <div class="relative bg-white rounded-full p-6 shadow-2xl">
                    <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl font-bold mb-2">Payment Successful!</h1>
            <p class="text-green-100 text-lg">Thank you for your generous giving</p>
        </div>
    </div>

    <!-- Receipt Card -->
    <div class="px-4 -mt-8">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <!-- Receipt Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-100">Receipt #</p>
                        <p class="text-lg font-bold" id="receiptNumber">Loading...</p>
                    </div>
                    <svg class="w-12 h-12 text-white/80" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>

            <!-- Receipt Details -->
            <div class="px-6 py-6 space-y-6">
                <!-- Amount -->
                <div class="text-center pb-6 border-b border-gray-200">
                    <p class="text-sm text-gray-600 mb-2">Amount Paid</p>
                    <p class="text-4xl font-bold text-gray-900">GHS <span id="amount">0.00</span></p>
                </div>

                <!-- Transaction Details -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Category</span>
                        <span class="font-semibold text-gray-900" id="category">-</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Payment Method</span>
                        <span class="font-semibold text-gray-900" id="paymentMethod">-</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Transaction ID</span>
                        <span class="font-mono text-sm text-gray-900" id="transactionId">-</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Date & Time</span>
                        <span class="font-semibold text-gray-900" id="dateTime">-</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Status</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Completed
                        </span>
                    </div>
                </div>

                <!-- Recurring Info (if applicable) -->
                <div id="recurringInfo" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-blue-900 mb-1">Recurring Payment Active</p>
                            <p class="text-sm text-blue-800">This payment will recur <span id="recurringFrequency">-</span></p>
                            <p class="text-sm text-blue-800">Next payment: <span id="nextPaymentDate">-</span></p>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div id="notesSection" class="hidden">
                    <p class="text-sm text-gray-600 mb-2">Notes</p>
                    <p class="text-gray-900" id="notes">-</p>
                </div>

                <!-- Church Info -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-gray-900" id="churchName">Church Name</p>
                            <p class="text-sm text-gray-600" id="churchContact">Contact info</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="px-6 pb-6 space-y-3">
                <button onclick="downloadReceipt()" class="w-full bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download Receipt
                </button>

                <button onclick="shareReceipt()" class="w-full bg-white border-2 border-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-lg hover:bg-gray-50 transition duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                    Share Receipt
                </button>

                <button onclick="window.location.href='/mobile'" class="w-full bg-gray-100 text-gray-700 font-semibold py-3 px-4 rounded-lg hover:bg-gray-200 transition duration-200">
                    Return to Home
                </button>
            </div>
        </div>
    </div>

    <!-- Encouragement Message -->
    <div class="px-4 mt-6">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-start">
                <svg class="w-8 h-8 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <div>
                    <p class="font-bold text-lg mb-2">Thank You for Your Generosity!</p>
                    <p class="text-blue-100 text-sm">
                        Your contribution helps support our mission to spread the gospel and serve our community.
                        God bless you abundantly!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Next Steps -->
    <div class="px-4 mt-6 mb-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">What's Next?</h3>

        <div class="grid grid-cols-2 gap-3">
            <a href="/mobile/giving-history" class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 hover:border-blue-600 transition">
                <div class="flex flex-col items-center text-center">
                    <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-sm font-semibold text-gray-900">View History</p>
                </div>
            </a>

            <a href="/mobile/give" class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 hover:border-blue-600 transition">
                <div class="flex flex-col items-center text-center">
                    <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <p class="text-sm font-semibold text-gray-900">Give Again</p>
                </div>
            </a>

            <a href="/mobile/events" class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 hover:border-blue-600 transition">
                <div class="flex flex-col items-center text-center">
                    <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm font-semibold text-gray-900">View Events</p>
                </div>
            </a>

            <a href="/mobile/profile" class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 hover:border-blue-600 transition">
                <div class="flex flex-col items-center text-center">
                    <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <p class="text-sm font-semibold text-gray-900">My Profile</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Get payment reference from URL
const urlParams = new URLSearchParams(window.location.search);
const reference = urlParams.get('reference') || urlParams.get('ref');

// Load receipt data
async function loadReceipt() {
    if (!reference) {
        ChurchApp.showToast('Invalid payment reference', 'error');
        setTimeout(() => {
            window.location.href = '/mobile/give';
        }, 2000);
        return;
    }

    try {
        const result = await ChurchApp.verifyPayment(reference);

        if (result.success && result.data) {
            const payment = result.data;

            // Populate receipt details
            document.getElementById('receiptNumber').textContent = payment.receipt_number || payment.reference;
            document.getElementById('amount').textContent = parseFloat(payment.amount).toFixed(2);
            document.getElementById('category').textContent = payment.category_label || payment.category;
            document.getElementById('paymentMethod').textContent = payment.payment_method_label || payment.payment_method;
            document.getElementById('transactionId').textContent = payment.transaction_id || payment.reference;

            // Format date and time
            const date = new Date(payment.created_at || payment.payment_date);
            const formattedDate = date.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
            const formattedTime = date.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('dateTime').textContent = `${formattedDate} at ${formattedTime}`;

            // Show recurring info if applicable
            if (payment.is_recurring) {
                document.getElementById('recurringInfo').classList.remove('hidden');
                document.getElementById('recurringFrequency').textContent = payment.frequency || 'monthly';
                if (payment.next_payment_date) {
                    const nextDate = new Date(payment.next_payment_date);
                    document.getElementById('nextPaymentDate').textContent = nextDate.toLocaleDateString('en-US', {
                        month: 'long',
                        day: 'numeric',
                        year: 'numeric'
                    });
                }
            }

            // Show notes if present
            if (payment.notes) {
                document.getElementById('notesSection').classList.remove('hidden');
                document.getElementById('notes').textContent = payment.notes;
            }

            // Show church info
            if (payment.church) {
                document.getElementById('churchName').textContent = payment.church.name || 'Church Name';
                document.getElementById('churchContact').textContent = payment.church.contact || 'Contact info';
            }
        } else {
            throw new Error('Payment verification failed');
        }
    } catch (error) {
        console.error('Failed to load receipt:', error);
        ChurchApp.showToast('Failed to load receipt details', 'error');
    }
}

// Download receipt as PDF
async function downloadReceipt() {
    ChurchApp.showLoading(true);

    try {
        const response = await fetch(`/api/mobile/v1/payments/${reference}/receipt`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${ChurchApp.token}`,
                'Accept': 'application/pdf'
            }
        });

        if (response.ok) {
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `receipt-${reference}.pdf`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);

            ChurchApp.showToast('Receipt downloaded successfully', 'success');
        } else {
            throw new Error('Download failed');
        }
    } catch (error) {
        console.error('Download error:', error);
        ChurchApp.showToast('Failed to download receipt', 'error');
    } finally {
        ChurchApp.showLoading(false);
    }
}

// Share receipt
async function shareReceipt() {
    const shareData = {
        title: 'Church Giving Receipt',
        text: `Thank you for your generous contribution of GHS ${document.getElementById('amount').textContent}`,
        url: window.location.href
    };

    try {
        if (navigator.share) {
            await navigator.share(shareData);
            ChurchApp.showToast('Receipt shared successfully', 'success');
        } else {
            // Fallback: Copy link to clipboard
            await navigator.clipboard.writeText(window.location.href);
            ChurchApp.showToast('Receipt link copied to clipboard', 'success');
        }
    } catch (error) {
        if (error.name !== 'AbortError') {
            console.error('Share error:', error);
            ChurchApp.showToast('Failed to share receipt', 'error');
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    loadReceipt();
});
</script>
@endpush
