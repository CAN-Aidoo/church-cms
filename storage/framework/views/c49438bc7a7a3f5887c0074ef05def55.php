<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Member Registration - <?php echo e(config('app.name')); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-green-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-white rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center shadow-lg">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Join Our Family</h1>
            <p class="text-gray-600">Register as a new member</p>
        </div>

        <!-- Progress Steps -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <div class="flex-1">
                    <div class="flex items-center">
                        <div id="step1Circle" class="w-10 h-10 rounded-full bg-green-600 text-white flex items-center justify-center font-bold">1</div>
                        <div class="flex-1 h-1 bg-green-600 mx-2"></div>
                    </div>
                    <p class="text-xs mt-1 text-green-600 font-semibold">Personal Info</p>
                </div>
                <div class="flex-1">
                    <div class="flex items-center">
                        <div id="step2Circle" class="w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">2</div>
                        <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                    </div>
                    <p class="text-xs mt-1 text-gray-500">Contact</p>
                </div>
                <div class="flex-1">
                    <div class="flex items-center">
                        <div id="step3Circle" class="w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">3</div>
                    </div>
                    <p class="text-xs mt-1 text-gray-500">Additional</p>
                </div>
            </div>
        </div>

        <!-- Step 1: Personal Information -->
        <div class="bg-white rounded-lg shadow-xl p-6" id="step1">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Personal Information</h3>
            <form id="step1Form">
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">First Name *</label>
                    <input type="text" name="first_name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Middle Name</label>
                    <input type="text" name="middle_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Last Name *</label>
                    <input type="text" name="last_name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Date of Birth *</label>
                    <input type="date" name="date_of_birth" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Gender *</label>
                    <select name="gender" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white font-bold py-4 rounded-lg shadow-lg hover:from-green-700 hover:to-green-800 transition-all duration-200">
                    Next: Contact Information →
                </button>
            </form>
        </div>

        <!-- Step 2: Contact Information -->
        <div class="bg-white rounded-lg shadow-xl p-6 hidden" id="step2">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Contact Information</h3>
            <form id="step2Form">
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Phone Number *</label>
                    <input type="tel" name="phone" required placeholder="+233XXXXXXXXX" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Email Address *</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Home Address *</label>
                    <textarea name="address" required rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">City *</label>
                    <input type="text" name="city" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <div class="flex gap-2">
                    <button type="button" onclick="goToStep(1)" class="flex-1 bg-gray-300 text-gray-700 font-bold py-4 rounded-lg hover:bg-gray-400 transition-all duration-200">
                        ← Back
                    </button>
                    <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white font-bold py-4 rounded-lg shadow-lg hover:from-green-700 hover:to-green-800 transition-all duration-200">
                        Next: Additional Info →
                    </button>
                </div>
            </form>
        </div>

        <!-- Step 3: Additional Information -->
        <div class="bg-white rounded-lg shadow-xl p-6 hidden" id="step3">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Additional Information</h3>
            <form id="step3Form">
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Marital Status *</label>
                    <select name="marital_status" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Select status</option>
                        <option value="single">Single</option>
                        <option value="married">Married</option>
                        <option value="divorced">Divorced</option>
                        <option value="widowed">Widowed</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Occupation</label>
                    <input type="text" name="occupation" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">How did you hear about us?</label>
                    <select name="referral_source" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Select an option</option>
                        <option value="friend">Friend or Family</option>
                        <option value="social_media">Social Media</option>
                        <option value="website">Church Website</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="mb-6 bg-blue-50 rounded-lg p-4">
                    <p class="text-sm text-blue-900 mb-2">By submitting this form:</p>
                    <ul class="text-xs text-blue-800 space-y-1">
                        <li>• You agree to become a member of our church</li>
                        <li>• Your information will be reviewed by admin</li>
                        <li>• You'll receive login credentials once approved</li>
                        <li>• You may be contacted for orientation</li>
                    </ul>
                </div>

                <div class="flex gap-2">
                    <button type="button" onclick="goToStep(2)" class="flex-1 bg-gray-300 text-gray-700 font-bold py-4 rounded-lg hover:bg-gray-400 transition-all duration-200">
                        ← Back
                    </button>
                    <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white font-bold py-4 rounded-lg shadow-lg hover:from-green-700 hover:to-green-800 transition-all duration-200">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Submit Registration
                    </button>
                </div>
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
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Registration Submitted!</h2>
                <p class="text-gray-600 mb-4">Welcome to the family!</p>
                <div class="bg-green-50 rounded-lg p-4 text-left">
                    <p class="text-sm text-green-900 font-semibold mb-2">What Happens Next?</p>
                    <ul class="text-sm text-green-800 space-y-1">
                        <li>• Admin will review your registration</li>
                        <li>• You'll be contacted within 24-48 hours</li>
                        <li>• Login credentials will be sent via email/SMS</li>
                        <li>• You may be invited to orientation</li>
                    </ul>
                </div>
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
        let formData = {};
        let currentStep = 1;

        // Step 1 submission
        document.getElementById('step1Form').addEventListener('submit', (e) => {
            e.preventDefault();
            const data = new FormData(e.target);
            formData = { ...formData, ...Object.fromEntries(data) };
            goToStep(2);
        });

        // Step 2 submission
        document.getElementById('step2Form').addEventListener('submit', (e) => {
            e.preventDefault();
            const data = new FormData(e.target);
            formData = { ...formData, ...Object.fromEntries(data) };
            goToStep(3);
        });

        // Step 3 submission (final)
        document.getElementById('step3Form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const data = new FormData(e.target);
            formData = { ...formData, ...Object.fromEntries(data) };

            // Add additional fields
            formData.status = 'pending';
            formData.membership_type = 'regular';

            await submitRegistration();
        });

        function goToStep(step) {
            // Hide all steps
            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step3').classList.add('hidden');

            // Update progress circles
            updateProgressCircles(step);

            // Show target step
            document.getElementById(`step${step}`).classList.remove('hidden');
            currentStep = step;
        }

        function updateProgressCircles(step) {
            for (let i = 1; i <= 3; i++) {
                const circle = document.getElementById(`step${i}Circle`);
                if (i <= step) {
                    circle.classList.remove('bg-gray-300', 'text-gray-600');
                    circle.classList.add('bg-green-600', 'text-white');
                } else {
                    circle.classList.remove('bg-green-600', 'text-white');
                    circle.classList.add('bg-gray-300', 'text-gray-600');
                }
            }
        }

        async function submitRegistration() {
            try {
                const response = await fetch('/api/v1/members', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();

                if (response.ok) {
                    document.getElementById('step3').classList.add('hidden');
                    document.getElementById('successMessage').classList.remove('hidden');
                } else {
                    showError(result.message || 'Registration failed. Please check your information and try again.');
                }
            } catch (error) {
                showError('An error occurred. Please try again.');
            }
        }

        function showError(message) {
            document.getElementById('errorText').textContent = message;
            document.getElementById('errorMessage').classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/mobile/member-register.blade.php ENDPATH**/ ?>