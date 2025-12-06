<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Check In - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-white rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center shadow-lg">
                <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome!</h1>
            <p class="text-gray-600">Check in to today's service</p>
        </div>

        <!-- Check-in Form -->
        <div class="bg-white rounded-lg shadow-xl p-6" id="checkInForm">
            <form id="memberCheckInForm">
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Service Type</label>
                    <select name="service_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="sunday_first">Sunday First Service</option>
                        <option value="sunday_second">Sunday Second Service</option>
                        <option value="midweek">Midweek Service</option>
                        <option value="prayer_meeting">Prayer Meeting</option>
                        <option value="special">Special Service</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Location (Optional)</label>
                    <input type="text" name="location" placeholder="e.g., Main Auditorium" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-4 rounded-lg shadow-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Check In Now
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
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Check-in Successful!</h2>
                <p class="text-gray-600 mb-4" id="memberName"></p>
                <p class="text-sm text-gray-500" id="checkInTime"></p>
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
        // Get token from URL
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get('token');

        if (!token) {
            showError('Invalid QR code. Please scan a valid check-in code.');
        }

        // Get user's location
        let userLocation = null;
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    userLocation = {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    };
                },
                (error) => {
                    console.log('Location access denied');
                }
            );
        }

        // Handle form submission
        document.getElementById('memberCheckInForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = {
                token: token,
                service_type: formData.get('service_type'),
                location: formData.get('location')
            };

            // Add location if available
            if (userLocation) {
                data.latitude = userLocation.latitude;
                data.longitude = userLocation.longitude;
            }

            try {
                const response = await fetch('/api/mobile/v1/check-in/member', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    document.getElementById('checkInForm').classList.add('hidden');
                    document.getElementById('successMessage').classList.remove('hidden');
                    document.getElementById('memberName').textContent = result.data.member_name;
                    document.getElementById('checkInTime').textContent = `Checked in at ${result.data.check_in_time}`;
                } else {
                    showError(result.message);
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
