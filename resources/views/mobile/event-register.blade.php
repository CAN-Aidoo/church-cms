@extends('layouts.mobile')

@section('title', 'Register for Event - Church App')
@section('header', 'Event Registration')

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Event Summary Card -->
    <div class="bg-white shadow-sm px-4 py-6">
        <div class="flex">
            <div id="eventThumbnail" class="w-20 h-20 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex-shrink-0 mr-4">
                <img id="eventImage" class="hidden w-full h-full object-cover rounded-lg" alt="Event">
            </div>
            <div class="flex-1">
                <h3 id="eventTitle" class="font-bold text-gray-900 mb-1">Event Title</h3>
                <p id="eventDate" class="text-sm text-gray-600 mb-1">Date</p>
                <p id="eventLocation" class="text-sm text-gray-500">Location</p>
            </div>
        </div>
    </div>

    <!-- Registration Form -->
    <form id="registrationForm" class="px-4 py-6">
        <!-- Personal Information -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-4">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Personal Information</h3>

            <div class="space-y-4">
                <!-- Full Name (Pre-filled) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                    <input type="text" id="fullName" readonly
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 font-medium">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                    <input type="email" id="email" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="your.email@example.com">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                    <input type="tel" id="phone" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="+233 XX XXX XXXX">
                </div>
            </div>
        </div>

        <!-- Number of Attendees -->
        <div id="attendeesSection" class="bg-white rounded-xl shadow-sm p-6 mb-4">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Number of Attendees</h3>

            <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4">
                <div>
                    <p class="font-semibold text-gray-900">How many people?</p>
                    <p class="text-sm text-gray-600">Including yourself</p>
                </div>
                <div class="flex items-center space-x-3">
                    <button type="button" onclick="decrementAttendees()" class="w-10 h-10 bg-white border-2 border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-100 transition">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                        </svg>
                    </button>
                    <span id="attendeeCount" class="text-2xl font-bold text-blue-600 w-12 text-center">1</span>
                    <button type="button" onclick="incrementAttendees()" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>
                </div>
            </div>

            <p id="spotsWarning" class="hidden text-sm text-orange-600 mt-2 font-medium">
                ⚠️ Limited spots remaining
            </p>
        </div>

        <!-- Additional Attendees Details -->
        <div id="additionalAttendeesSection" class="hidden bg-white rounded-xl shadow-sm p-6 mb-4">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Additional Attendees</h3>
            <div id="additionalAttendeesList" class="space-y-4">
                <!-- Dynamic attendee fields -->
            </div>
        </div>

        <!-- Special Requirements -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-4">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Special Requirements</h3>

            <!-- Dietary Restrictions -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Dietary Restrictions</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="dietary[]" value="vegetarian" class="rounded text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="text-gray-700">Vegetarian</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="dietary[]" value="vegan" class="rounded text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="text-gray-700">Vegan</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="dietary[]" value="gluten_free" class="rounded text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="text-gray-700">Gluten-Free</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="dietary[]" value="halal" class="rounded text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="text-gray-700">Halal</span>
                    </label>
                </div>
            </div>

            <!-- Accessibility Needs -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Accessibility Needs</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="accessibility[]" value="wheelchair" class="rounded text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="text-gray-700">Wheelchair Access</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="accessibility[]" value="sign_language" class="rounded text-blue-600 focus:ring-blue-500 mr-3">
                        <span class="text-gray-700">Sign Language Interpreter</span>
                    </label>
                </div>
            </div>

            <!-- Additional Notes -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Additional Notes</label>
                <textarea id="notes" rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Any special requests or information we should know..."></textarea>
            </div>
        </div>

        <!-- Payment Section (if paid event) -->
        <div id="paymentSection" class="hidden bg-white rounded-xl shadow-sm p-6 mb-4">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Payment</h3>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-700">Registration Fee</span>
                    <span id="feePerPerson" class="font-semibold text-gray-900">GHS 0.00</span>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-700">Number of Attendees</span>
                    <span id="paymentAttendeeCount" class="font-semibold text-gray-900">1</span>
                </div>
                <div class="flex items-center justify-between pt-2 border-t border-blue-200">
                    <span class="font-bold text-gray-900">Total Amount</span>
                    <span id="totalAmount" class="text-2xl font-bold text-blue-600">GHS 0.00</span>
                </div>
            </div>

            <div class="space-y-3">
                <label class="block">
                    <input type="radio" name="payment_method" value="mobile_money" checked class="mr-3">
                    <span class="font-medium text-gray-700">Mobile Money</span>
                </label>
                <label class="block">
                    <input type="radio" name="payment_method" value="card" class="mr-3">
                    <span class="font-medium text-gray-700">Debit/Credit Card</span>
                </label>
                <label class="block">
                    <input type="radio" name="payment_method" value="pay_later" class="mr-3">
                    <span class="font-medium text-gray-700">Pay at Venue</span>
                </label>
            </div>
        </div>

        <!-- Terms & Conditions -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-4">
            <label class="flex items-start">
                <input type="checkbox" id="agreeTerms" required class="rounded text-blue-600 focus:ring-blue-500 mt-1 mr-3">
                <span class="text-sm text-gray-700">
                    I agree to the <button type="button" onclick="showTerms()" class="text-blue-600 font-medium hover:underline">terms and conditions</button> and confirm that all information provided is accurate.
                </span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="sticky bottom-20 bg-white border-t border-gray-200 p-4 -mx-4 shadow-xl">
            <button type="submit" id="submitBtn"
                    class="w-full bg-blue-600 text-white font-bold py-4 rounded-lg hover:bg-blue-700 transition shadow-lg flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Complete Registration
            </button>
        </div>
    </form>
</div>

<!-- Terms Modal -->
<div id="termsModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 overflow-y-auto">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-lg w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Terms & Conditions</h3>
                <button onclick="closeTerms()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="text-sm text-gray-700 space-y-3 max-h-96 overflow-y-auto">
                <p>By registering for this event, you agree to the following terms:</p>
                <ul class="list-disc list-inside space-y-2">
                    <li>Registration is subject to availability</li>
                    <li>Cancellations must be made at least 24 hours before the event</li>
                    <li>Payment refunds are processed within 7-14 business days</li>
                    <li>The church reserves the right to cancel or reschedule events</li>
                    <li>Your information will be used solely for event management purposes</li>
                    <li>Photos/videos may be taken during the event for church media</li>
                </ul>
            </div>

            <button onclick="closeTerms()" class="w-full mt-6 bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition">
                I Understand
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const eventId = window.location.pathname.split('/').pop().replace('/register', '');
let eventData = null;
let attendeeCount = 1;
let maxAttendees = 10;

// Load event data and user profile
async function loadEventData() {
    try {
        // Load event details
        const eventResult = await ChurchApp.apiCall(`/api/mobile/v1/events/${eventId}`, 'GET');
        if (eventResult.success && eventResult.data) {
            eventData = eventResult.data;
            populateEventSummary(eventData);

            // Calculate max attendees based on spots left
            if (eventData.max_participants) {
                const spotsLeft = eventData.max_participants - (eventData.registered_count || 0);
                maxAttendees = Math.min(10, spotsLeft);
            }
        }

        // Load user profile
        const profileResult = await ChurchApp.getMyProfile();
        if (profileResult.success && profileResult.data) {
            const profile = profileResult.data;
            document.getElementById('fullName').value = profile.full_name || '';
            document.getElementById('email').value = profile.email || '';
            document.getElementById('phone').value = profile.phone || '';
        }
    } catch (error) {
        console.error('Failed to load data:', error);
        ChurchApp.showToast('Failed to load event details', 'error');
    }
}

// Populate event summary
function populateEventSummary(event) {
    document.getElementById('eventTitle').textContent = event.title;

    const date = new Date(event.start_date);
    document.getElementById('eventDate').textContent = date.toLocaleDateString('en-US', {
        weekday: 'short',
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });

    if (event.location) {
        document.getElementById('eventLocation').textContent = event.location;
    }

    if (event.banner_url) {
        document.getElementById('eventImage').src = event.banner_url;
        document.getElementById('eventImage').classList.remove('hidden');
    }

    // Show payment section if paid event
    if (event.registration_fee && parseFloat(event.registration_fee) > 0) {
        document.getElementById('paymentSection').classList.remove('hidden');
        document.getElementById('feePerPerson').textContent = `GHS ${parseFloat(event.registration_fee).toFixed(2)}`;
        updateTotalAmount();
    }
}

// Increment attendees
function incrementAttendees() {
    if (attendeeCount < maxAttendees) {
        attendeeCount++;
        updateAttendeeCount();
    } else {
        ChurchApp.showToast(`Maximum ${maxAttendees} attendees allowed`, 'warning');
    }
}

// Decrement attendees
function decrementAttendees() {
    if (attendeeCount > 1) {
        attendeeCount--;
        updateAttendeeCount();
    }
}

// Update attendee count display
function updateAttendeeCount() {
    document.getElementById('attendeeCount').textContent = attendeeCount;

    // Show/hide additional attendees section
    if (attendeeCount > 1) {
        document.getElementById('additionalAttendeesSection').classList.remove('hidden');
        renderAdditionalAttendees();
    } else {
        document.getElementById('additionalAttendeesSection').classList.add('hidden');
    }

    // Update payment
    if (eventData && eventData.registration_fee) {
        document.getElementById('paymentAttendeeCount').textContent = attendeeCount;
        updateTotalAmount();
    }

    // Show spots warning if near capacity
    if (maxAttendees - attendeeCount <= 5) {
        const warning = document.getElementById('spotsWarning');
        warning.classList.remove('hidden');
        warning.textContent = `⚠️ Only ${maxAttendees - attendeeCount} spots remaining`;
    }
}

// Render additional attendee fields
function renderAdditionalAttendees() {
    const container = document.getElementById('additionalAttendeesList');
    let html = '';

    for (let i = 2; i <= attendeeCount; i++) {
        html += `
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="font-semibold text-gray-900 mb-3">Attendee ${i}</h4>
                <div class="space-y-3">
                    <input type="text" name="attendee_name_${i}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Full Name">
                    <input type="email" name="attendee_email_${i}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Email (optional)">
                    <input type="tel" name="attendee_phone_${i}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Phone (optional)">
                </div>
            </div>
        `;
    }

    container.innerHTML = html;
}

// Update total amount
function updateTotalAmount() {
    if (eventData && eventData.registration_fee) {
        const fee = parseFloat(eventData.registration_fee);
        const total = fee * attendeeCount;
        document.getElementById('totalAmount').textContent = `GHS ${total.toFixed(2)}`;
    }
}

// Show terms modal
function showTerms() {
    document.getElementById('termsModal').classList.remove('hidden');
}

// Close terms modal
function closeTerms() {
    document.getElementById('termsModal').classList.add('hidden');
}

// Handle form submission
document.getElementById('registrationForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    if (!document.getElementById('agreeTerms').checked) {
        ChurchApp.showToast('Please agree to the terms and conditions', 'warning');
        return;
    }

    ChurchApp.showLoading(true);

    try {
        const formData = new FormData(e.target);
        const data = {
            event_id: eventId,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            attendee_count: attendeeCount,
            dietary_restrictions: formData.getAll('dietary[]'),
            accessibility_needs: formData.getAll('accessibility[]'),
            notes: document.getElementById('notes').value,
            payment_method: eventData && eventData.registration_fee ? formData.get('payment_method') : null
        };

        // Add additional attendees
        if (attendeeCount > 1) {
            data.additional_attendees = [];
            for (let i = 2; i <= attendeeCount; i++) {
                data.additional_attendees.push({
                    name: formData.get(`attendee_name_${i}`),
                    email: formData.get(`attendee_email_${i}`),
                    phone: formData.get(`attendee_phone_${i}`)
                });
            }
        }

        const result = await ChurchApp.apiCall(`/api/mobile/v1/events/${eventId}/register`, 'POST', data);

        if (result.success) {
            // If paid event and payment required
            if (result.data.payment_required && result.data.payment_url) {
                window.location.href = result.data.payment_url;
            } else {
                // Show success and redirect
                ChurchApp.showToast('Registration successful!', 'success');
                setTimeout(() => {
                    window.location.href = `/mobile/events/${eventId}`;
                }, 1500);
            }
        } else {
            throw new Error(result.message || 'Registration failed');
        }
    } catch (error) {
        console.error('Registration error:', error);
        ChurchApp.showToast(error.message || 'Failed to register. Please try again.', 'error');
    } finally {
        ChurchApp.showLoading(false);
    }
});

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    loadEventData();
});
</script>
@endpush
