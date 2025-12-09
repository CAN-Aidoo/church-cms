@extends('layouts.mobile')

@section('title', 'Register - Church App')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 py-6 px-4">
    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl">
                <svg class="w-10 h-10 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white mb-2">Create Account</h1>
            <p class="text-blue-100">Join our church family today</p>
        </div>

        <!-- Multi-Step Form -->
        <div class="bg-white rounded-xl shadow-2xl p-6">
            <!-- Progress Steps -->
            <div class="flex justify-between mb-8">
                <div class="flex-1">
                    <div id="step1-indicator" class="w-full h-2 bg-blue-600 rounded-full transition-all duration-300"></div>
                    <p class="text-xs text-center mt-2 font-medium text-blue-600">Phone</p>
                </div>
                <div class="flex-1 mx-2">
                    <div id="step2-indicator" class="w-full h-2 bg-gray-200 rounded-full transition-all duration-300"></div>
                    <p class="text-xs text-center mt-2 text-gray-400">Verify</p>
                </div>
                <div class="flex-1">
                    <div id="step3-indicator" class="w-full h-2 bg-gray-200 rounded-full transition-all duration-300"></div>
                    <p class="text-xs text-center mt-2 text-gray-400">Details</p>
                </div>
            </div>

            <!-- Step 1: Phone Number -->
            <div id="step1" class="registration-step">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Enter Your Phone Number</h2>
                <p class="text-gray-600 mb-6">We'll send you a verification code</p>

                <form id="phoneForm" class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Phone Number</label>
                        <input type="tel" id="register_phone" name="phone"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="+233 XX XXX XXXX" required>
                        <p class="text-sm text-gray-500 mt-1">Include country code (e.g., +233)</p>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Email (Optional)</label>
                        <input type="email" id="register_email" name="email"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="your.email@example.com">
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                        Send Verification Code
                    </button>
                </form>
            </div>

            <!-- Step 2: OTP Verification -->
            <div id="step2" class="registration-step hidden">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Verify Your Phone</h2>
                <p class="text-gray-600 mb-6">Enter the 6-digit code sent to <span id="phone-display" class="font-semibold"></span></p>

                <form id="otpForm" class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Verification Code</label>
                        <div class="flex space-x-2">
                            <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>

                    <div class="text-center">
                        <p class="text-sm text-gray-600">Didn't receive the code?</p>
                        <button type="button" id="resendOtp" class="text-blue-600 font-semibold hover:underline">
                            Resend Code
                        </button>
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                        Verify & Continue
                    </button>
                </form>
            </div>

            <!-- Step 3: Personal Details -->
            <div id="step3" class="registration-step hidden">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Complete Your Profile</h2>

                <form id="detailsForm" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">First Name *</label>
                            <input type="text" id="first_name" name="first_name"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Last Name *</label>
                            <input type="text" id="last_name" name="last_name"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Gender</label>
                        <select id="gender" name="gender"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Address</label>
                        <textarea id="address" name="address" rows="2"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Your residential address"></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Password *</label>
                        <input type="password" id="password" name="password"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Minimum 8 characters" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Confirm Password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" id="terms" required
                               class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="terms" class="ml-2 text-sm text-gray-600">
                            I agree to the <a href="#" class="text-blue-600 hover:underline">Terms of Service</a> and
                            <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
                        </label>
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                        Create Account
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-6 text-center">
            <p class="text-blue-100 text-sm">
                Already have an account?
                <a href="/mobile/login" class="text-white font-semibold hover:underline">Sign in</a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentStep = 1;
let phoneNumber = '';
let emailAddress = '';
let otpValue = '';

// Auto-focus next OTP input
const otpInputs = document.querySelectorAll('.otp-input');
otpInputs.forEach((input, index) => {
    input.addEventListener('input', (e) => {
        if (e.target.value && index < otpInputs.length - 1) {
            otpInputs[index + 1].focus();
        }
    });
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !e.target.value && index > 0) {
            otpInputs[index - 1].focus();
        }
    });
});

// Step 1: Send OTP
document.getElementById('phoneForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    phoneNumber = document.getElementById('register_phone').value;
    emailAddress = document.getElementById('register_email').value;

    ChurchApp.showLoading(true);

    try {
        const result = await ChurchApp.register({ phone: phoneNumber, email: emailAddress });

        if (result.success) {
            ChurchApp.showToast('Verification code sent!', 'success');
            document.getElementById('phone-display').textContent = phoneNumber;
            goToStep(2);
        }
    } catch (error) {
        ChurchApp.showToast(error.message || 'Failed to send code', 'error');
    } finally {
        ChurchApp.showLoading(false);
    }
});

// Step 2: Verify OTP
document.getElementById('otpForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    otpValue = Array.from(otpInputs).map(input => input.value).join('');

    if (otpValue.length !== 6) {
        ChurchApp.showToast('Please enter all 6 digits', 'error');
        return;
    }

    ChurchApp.showToast('Code verified!', 'success');
    goToStep(3);
});

// Resend OTP
document.getElementById('resendOtp').addEventListener('click', async () => {
    ChurchApp.showLoading(true);

    try {
        const result = await ChurchApp.apiCall('/api/mobile/v1/resend-otp', 'POST', {
            phone: phoneNumber
        }, false);

        if (result.success) {
            ChurchApp.showToast('New code sent!', 'success');
        }
    } catch (error) {
        ChurchApp.showToast(error.message || 'Failed to resend code', 'error');
    } finally {
        ChurchApp.showLoading(false);
    }
});

// Step 3: Complete Registration
document.getElementById('detailsForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = {
        phone: phoneNumber,
        otp: otpValue,
        first_name: document.getElementById('first_name').value,
        last_name: document.getElementById('last_name').value,
        email: emailAddress,
        date_of_birth: document.getElementById('date_of_birth').value || null,
        gender: document.getElementById('gender').value || null,
        address: document.getElementById('address').value || null,
        password: document.getElementById('password').value,
        password_confirmation: document.getElementById('password_confirmation').value,
    };

    if (formData.password !== formData.password_confirmation) {
        ChurchApp.showToast('Passwords do not match', 'error');
        return;
    }

    ChurchApp.showLoading(true);

    try {
        const result = await ChurchApp.verifyOtp(phoneNumber, otpValue, formData);

        if (result.success) {
            ChurchApp.showToast('Registration successful!', 'success');
            setTimeout(() => {
                window.location.href = '/mobile';
            }, 1000);
        }
    } catch (error) {
        ChurchApp.showToast(error.message || 'Registration failed', 'error');
    } finally {
        ChurchApp.showLoading(false);
    }
});

function goToStep(step) {
    // Hide all steps
    document.querySelectorAll('.registration-step').forEach(s => s.classList.add('hidden'));

    // Show current step
    document.getElementById(`step${step}`).classList.remove('hidden');

    // Update indicators
    for (let i = 1; i <= 3; i++) {
        const indicator = document.getElementById(`step${i}-indicator`);
        const text = indicator.nextElementSibling;

        if (i <= step) {
            indicator.classList.remove('bg-gray-200');
            indicator.classList.add('bg-blue-600');
            text.classList.remove('text-gray-400');
            text.classList.add('text-blue-600', 'font-medium');
        } else {
            indicator.classList.add('bg-gray-200');
            indicator.classList.remove('bg-blue-600');
            text.classList.add('text-gray-400');
            text.classList.remove('text-blue-600', 'font-medium');
        }
    }

    currentStep = step;
}
</script>
@endpush
