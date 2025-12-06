<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Program Registration - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-md">
        <!-- Loading State -->
        <div id="loadingState" class="text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-indigo-600 mx-auto mb-4"></div>
            <p class="text-gray-600">Loading program details...</p>
        </div>

        <!-- Program Details -->
        <div id="programDetails" class="hidden">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="bg-white rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center shadow-lg">
                    <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2" id="programName">Program Name</h1>
                <span id="programStatus" class="inline-block px-4 py-1 rounded-full text-sm font-semibold">Status</span>
            </div>

            <!-- Program Info Card -->
            <div class="bg-white rounded-lg shadow-xl p-6 mb-4">
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Date & Time</p>
                        <p class="font-semibold text-gray-800" id="programDateTime">-</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Location</p>
                        <p class="font-semibold text-gray-800" id="programLocation">-</p>
                    </div>
                    <div id="capacitySection">
                        <p class="text-sm text-gray-600">Capacity</p>
                        <div class="flex items-center mt-1">
                            <div class="flex-1 bg-gray-200 rounded-full h-2 mr-3">
                                <div id="capacityBar" class="bg-indigo-600 h-2 rounded-full" style="width: 0%"></div>
                            </div>
                            <span class="text-sm font-semibold text-gray-700" id="capacityText">0/0</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Description</p>
                        <p class="text-gray-800" id="programDescription">-</p>
                    </div>
                    <div id="feeSection" class="hidden">
                        <p class="text-sm text-gray-600">Registration Fee</p>
                        <p class="text-2xl font-bold text-indigo-600" id="programFee">GHS 0.00</p>
                    </div>
                </div>
            </div>

            <!-- Registration Form -->
            <div class="bg-white rounded-lg shadow-xl p-6 mb-4" id="registrationFormSection">
                <h3 class="font-bold text-gray-800 mb-4">Register for this Program</h3>
                <form id="registrationForm">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Full Name *</label>
                        <input type="text" name="full_name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Phone Number *</label>
                        <input type="tel" name="phone" required placeholder="+233XXXXXXXXX" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Email *</label>
                        <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Are you a member?</label>
                        <select name="is_member" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="yes">Yes, I'm a member</option>
                            <option value="no">No, I'm a visitor/guest</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Special Requirements/Notes</label>
                        <textarea name="notes" rows="2" placeholder="Dietary restrictions, accessibility needs, etc." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="flex items-start">
                            <input type="checkbox" name="terms" required class="mt-1 mr-2">
                            <span class="text-sm text-gray-600">I agree to the program terms and conditions and understand the cancellation policy</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-bold py-4 rounded-lg shadow-lg hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Complete Registration
                    </button>
                </form>
            </div>

            <!-- Program Full Message -->
            <div id="programFullMessage" class="hidden bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                <svg class="w-16 h-16 text-yellow-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <h3 class="text-xl font-bold text-yellow-900 mb-2">Program is Full</h3>
                <p class="text-yellow-800">This program has reached maximum capacity. Registration is closed.</p>
            </div>
        </div>

        <!-- Success Message -->
        <div id="successMessage" class="hidden bg-white rounded-lg shadow-xl p-6">
            <div class="text-center">
                <div class="bg-green-100 rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Registration Successful!</h2>
                <p class="text-gray-600 mb-4">You're all set for this program</p>
                <div class="bg-indigo-50 rounded-lg p-4 text-left">
                    <p class="text-sm text-indigo-900 font-semibold mb-2">What's Next?</p>
                    <ul class="text-sm text-indigo-800 space-y-1">
                        <li>• Check your email for confirmation</li>
                        <li>• You'll receive program updates via SMS</li>
                        <li>• Arrive 15 minutes early on the day</li>
                        <li id="paymentReminder" class="hidden">• Complete payment if required</li>
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
        // Get program ID from URL
        const pathParts = window.location.pathname.split('/');
        const programId = pathParts[pathParts.length - 1];
        let programData = null;

        // Load program details
        async function loadProgram() {
            try {
                const response = await fetch(`/api/v1/programs/${programId}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Program not found');
                }

                programData = await response.json();
                displayProgram(programData);
            } catch (error) {
                showError('Failed to load program details');
                document.getElementById('loadingState').classList.add('hidden');
            }
        }

        function displayProgram(program) {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('programDetails').classList.remove('hidden');

            document.getElementById('programName').textContent = program.name;
            document.getElementById('programDescription').textContent = program.description || 'No description available';
            document.getElementById('programLocation').textContent = program.location || 'TBA';

            // Date and time
            const startDate = new Date(program.start_date).toLocaleDateString();
            const endDate = new Date(program.end_date).toLocaleDateString();
            document.getElementById('programDateTime').textContent = `${startDate} - ${endDate}`;

            // Status
            const statusBadge = document.getElementById('programStatus');
            statusBadge.textContent = program.status.replace('_', ' ').toUpperCase();
            if (program.status === 'published') {
                statusBadge.className = 'inline-block px-4 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800';
            } else if (program.status === 'ongoing') {
                statusBadge.className = 'inline-block px-4 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800';
            } else {
                statusBadge.className = 'inline-block px-4 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800';
            }

            // Capacity
            const registered = program.registered_count || 0;
            const maxParticipants = program.max_participants || 0;
            if (maxParticipants > 0) {
                const percentage = (registered / maxParticipants) * 100;
                document.getElementById('capacityBar').style.width = `${percentage}%`;
                document.getElementById('capacityText').textContent = `${registered}/${maxParticipants}`;

                // Check if full
                if (registered >= maxParticipants) {
                    document.getElementById('registrationFormSection').classList.add('hidden');
                    document.getElementById('programFullMessage').classList.remove('hidden');
                }
            }

            // Registration fee
            if (program.registration_fee && program.registration_fee > 0) {
                document.getElementById('feeSection').classList.remove('hidden');
                document.getElementById('programFee').textContent = `GHS ${parseFloat(program.registration_fee).toFixed(2)}`;
            }
        }

        // Registration form submission
        document.getElementById('registrationForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = {
                program_id: programId,
                full_name: formData.get('full_name'),
                phone: formData.get('phone'),
                email: formData.get('email'),
                is_member: formData.get('is_member') === 'yes',
                notes: formData.get('notes'),
                status: 'pending',
                registered_date: new Date().toISOString().split('T')[0]
            };

            try {
                const response = await fetch(`/api/v1/programs/${programId}/register`, {
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
                    document.getElementById('programDetails').classList.add('hidden');
                    if (programData.registration_fee > 0) {
                        document.getElementById('paymentReminder').classList.remove('hidden');
                    }
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

        // Initialize
        loadProgram();
    </script>
</body>
</html>
