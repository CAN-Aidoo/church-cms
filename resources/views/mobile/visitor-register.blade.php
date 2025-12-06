<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Visitor Registration - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-yellow-50 to-yellow-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-white rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center shadow-lg">
                <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome!</h1>
            <p class="text-gray-600">We're glad you're here today</p>
        </div>

        <!-- Registration Form -->
        <div class="bg-white rounded-lg shadow-xl p-6" id="registrationForm">
            <form id="visitorForm">
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">First Name *</label>
                    <input type="text" name="first_name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Last Name *</label>
                    <input type="text" name="last_name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Phone Number *</label>
                    <input type="tel" name="phone" required placeholder="+233XXXXXXXXX" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Email (Optional)</label>
                    <input type="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Address (Optional)</label>
                    <textarea name="address" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">How did you hear about us? *</label>
                    <select name="referral_source" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="">Select an option</option>
                        <option value="friend">Friend or Family</option>
                        <option value="social_media">Social Media</option>
                        <option value="website">Church Website</option>
                        <option value="google">Google Search</option>
                        <option value="flyer">Flyer/Poster</option>
                        <option value="drove_by">Drove/Walked By</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Prayer Request (Optional)</label>
                    <textarea name="prayer_request" rows="3" placeholder="We'd love to pray for you..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"></textarea>
                </div>

                <div class="mb-6">
                    <label class="flex items-start">
                        <input type="checkbox" name="follow_up_consent" class="mt-1 mr-2">
                        <span class="text-sm text-gray-600">I'd like someone from the church to contact me</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-bold py-4 rounded-lg shadow-lg hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Complete Registration
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
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Thank You!</h2>
                <p class="text-gray-600 mb-4">Your registration has been submitted successfully.</p>
                <div class="bg-blue-50 rounded-lg p-4 text-left">
                    <p class="text-sm text-blue-900 font-semibold mb-2">What's Next?</p>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• We'll send you a welcome message</li>
                        <li>• A follow-up team member may contact you</li>
                        <li>• After 5 visits, you can become a member</li>
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
        document.getElementById('visitorForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = {
                first_name: formData.get('first_name'),
                last_name: formData.get('last_name'),
                phone: formData.get('phone'),
                email: formData.get('email'),
                address: formData.get('address'),
                referral_source: formData.get('referral_source'),
                prayer_request: formData.get('prayer_request'),
                follow_up_consent: formData.get('follow_up_consent') ? true : false,
                first_visit_date: new Date().toISOString().split('T')[0],
                visit_count: 1,
                status: 'active'
            };

            try {
                const response = await fetch('/api/v1/visitors', {
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
                    document.getElementById('registrationForm').classList.add('hidden');
                    document.getElementById('successMessage').classList.remove('hidden');
                } else {
                    showError(result.message || 'Registration failed. Please try again.');
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
