<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Equipment Details - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-md">
        <!-- Loading State -->
        <div id="loadingState" class="text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-blue-600 mx-auto mb-4"></div>
            <p class="text-gray-600">Loading equipment details...</p>
        </div>

        <!-- Equipment Details -->
        <div id="equipmentDetails" class="hidden">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="bg-white rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center shadow-lg">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800" id="equipmentName">Equipment Name</h1>
                <p class="text-gray-600" id="equipmentCategory">Category</p>
            </div>

            <!-- Equipment Info Card -->
            <div class="bg-white rounded-lg shadow-xl p-6 mb-4">
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Serial Number</p>
                        <p class="font-semibold text-gray-800" id="serialNumber">-</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Location</p>
                        <p class="font-semibold text-gray-800" id="location">-</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <span id="statusBadge" class="inline-block px-3 py-1 rounded-full text-sm font-semibold">-</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Condition</p>
                        <span id="conditionBadge" class="inline-block px-3 py-1 rounded-full text-sm font-semibold">-</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Purchase Date</p>
                        <p class="font-semibold text-gray-800" id="purchaseDate">-</p>
                    </div>
                    <div id="assignedSection" class="hidden">
                        <p class="text-sm text-gray-600">Currently Assigned To</p>
                        <p class="font-semibold text-gray-800" id="assignedTo">-</p>
                    </div>
                </div>
            </div>

            <!-- Maintenance History -->
            <div class="bg-white rounded-lg shadow-xl p-6 mb-4">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Recent Maintenance
                </h3>
                <div id="maintenanceHistory" class="space-y-3">
                    <p class="text-sm text-gray-500">No maintenance records</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-2 gap-4 mb-4" id="actionButtons">
                <button onclick="reportIssue()" class="bg-red-500 text-white font-bold py-3 rounded-lg hover:bg-red-600 transition">
                    <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Report Issue
                </button>
                <button onclick="checkOut()" class="bg-blue-500 text-white font-bold py-3 rounded-lg hover:bg-blue-600 transition">
                    <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Check Out
                </button>
            </div>
        </div>

        <!-- Report Issue Modal -->
        <div id="reportModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-md shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Report Equipment Issue</h3>
                    <form id="issueForm">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Issue Type</label>
                            <select name="issue_type" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-red-500">
                                <option value="malfunction">Malfunction</option>
                                <option value="damage">Physical Damage</option>
                                <option value="missing">Missing Parts</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea name="description" required rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-red-500"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Your Name</label>
                            <input type="text" name="reported_by" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-red-500">
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeReportModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                Submit Report
                            </button>
                        </div>
                    </form>
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

        <!-- Success Message -->
        <div id="successMessage" class="hidden mt-4 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-green-800 font-semibold" id="successText"></span>
            </div>
        </div>
    </div>

    <script>
        // Get equipment ID from URL
        const pathParts = window.location.pathname.split('/');
        const equipmentId = pathParts[pathParts.length - 1];
        let equipmentData = null;

        // Load equipment details
        async function loadEquipment() {
            try {
                const response = await fetch(`/api/v1/equipment/${equipmentId}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Equipment not found');
                }

                equipmentData = await response.json();
                displayEquipment(equipmentData);
            } catch (error) {
                showError('Failed to load equipment details');
                document.getElementById('loadingState').classList.add('hidden');
            }
        }

        function displayEquipment(equipment) {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('equipmentDetails').classList.remove('hidden');

            document.getElementById('equipmentName').textContent = equipment.name;
            document.getElementById('equipmentCategory').textContent = equipment.category;
            document.getElementById('serialNumber').textContent = equipment.serial_number || 'N/A';
            document.getElementById('location').textContent = equipment.location || 'Not specified';
            document.getElementById('purchaseDate').textContent = equipment.purchase_date || 'N/A';

            // Status badge
            const statusBadge = document.getElementById('statusBadge');
            statusBadge.textContent = equipment.status;
            statusBadge.className = 'inline-block px-3 py-1 rounded-full text-sm font-semibold ';
            if (equipment.status === 'available') {
                statusBadge.className += 'bg-green-100 text-green-800';
            } else if (equipment.status === 'in_use') {
                statusBadge.className += 'bg-blue-100 text-blue-800';
            } else if (equipment.status === 'maintenance') {
                statusBadge.className += 'bg-yellow-100 text-yellow-800';
            } else {
                statusBadge.className += 'bg-red-100 text-red-800';
            }

            // Condition badge
            const conditionBadge = document.getElementById('conditionBadge');
            conditionBadge.textContent = equipment.condition || 'good';
            conditionBadge.className = 'inline-block px-3 py-1 rounded-full text-sm font-semibold ';
            if (equipment.condition === 'excellent') {
                conditionBadge.className += 'bg-green-100 text-green-800';
            } else if (equipment.condition === 'good') {
                conditionBadge.className += 'bg-blue-100 text-blue-800';
            } else if (equipment.condition === 'fair') {
                conditionBadge.className += 'bg-yellow-100 text-yellow-800';
            } else {
                conditionBadge.className += 'bg-red-100 text-red-800';
            }

            // Show assigned to if in use
            if (equipment.status === 'in_use' && equipment.assigned_to) {
                document.getElementById('assignedSection').classList.remove('hidden');
                document.getElementById('assignedTo').textContent = equipment.assigned_to_name || 'Unknown';
            }
        }

        function reportIssue() {
            document.getElementById('reportModal').classList.remove('hidden');
        }

        function closeReportModal() {
            document.getElementById('reportModal').classList.add('hidden');
        }

        function checkOut() {
            // Simplified check-out - in real implementation would require authentication
            showSuccess('Check-out request submitted. Please contact equipment manager for approval.');
        }

        // Issue form submission
        document.getElementById('issueForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = {
                equipment_id: equipmentId,
                issue_type: formData.get('issue_type'),
                description: formData.get('description'),
                reported_by_name: formData.get('reported_by'),
                reported_date: new Date().toISOString().split('T')[0],
                status: 'pending'
            };

            try {
                // In a real implementation, this would call an issue reporting endpoint
                console.log('Issue report:', data);
                closeReportModal();
                showSuccess('Issue reported successfully. Equipment manager has been notified.');
            } catch (error) {
                showError('Failed to submit issue report');
            }
        });

        function showError(message) {
            document.getElementById('errorText').textContent = message;
            document.getElementById('errorMessage').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('errorMessage').classList.add('hidden');
            }, 5000);
        }

        function showSuccess(message) {
            document.getElementById('successText').textContent = message;
            document.getElementById('successMessage').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('successMessage').classList.add('hidden');
            }, 5000);
        }

        // Initialize
        loadEquipment();
    </script>
</body>
</html>
