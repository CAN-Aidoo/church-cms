@extends('layouts.mobile')

@section('title', 'Check In - Church App')
@section('header', 'Check In')

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Check-in Methods -->
    <div class="bg-white shadow-sm">
        <div class="px-4 py-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">How would you like to check in?</h2>

            <div class="space-y-3">
                <!-- Scan Service QR -->
                <button onclick="openQRScanner()" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 rounded-xl shadow-md flex items-center justify-between hover:from-blue-700 hover:to-blue-800 transition">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-semibold">Scan Service QR Code</p>
                            <p class="text-sm text-blue-100">Scan QR at church entrance</p>
                        </div>
                    </div>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <!-- Show My QR -->
                <button onclick="showMyQR()" class="w-full bg-white border-2 border-blue-600 text-blue-600 p-4 rounded-xl shadow-sm flex items-center justify-between hover:bg-blue-50 transition">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-semibold">Show My QR Code</p>
                            <p class="text-sm text-gray-500">For usher to scan</p>
                        </div>
                    </div>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <!-- Family Check-in -->
                <button onclick="showFamilyCheckIn()" class="w-full bg-white border-2 border-gray-300 text-gray-700 p-4 rounded-xl shadow-sm flex items-center justify-between hover:bg-gray-50 transition">
                    <div class="flex items-center">
                        <div class="bg-gray-100 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-semibold">Family Check-in</p>
                            <p class="text-sm text-gray-500">Check in entire family</p>
                        </div>
                    </div>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Recent Check-ins -->
    <div class="px-4 py-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">Recent Check-ins</h3>
            <button onclick="loadCheckInHistory()" class="text-blue-600 text-sm font-medium">
                View All
            </button>
        </div>

        <div id="recentCheckIns" class="space-y-3">
            <!-- Will be populated by JavaScript -->
            <div class="text-center py-8 text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p>Loading check-in history...</p>
            </div>
        </div>
    </div>

    <!-- Attendance Stats -->
    <div class="px-4 pb-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">My Attendance</h3>

        <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl p-6 text-white shadow-lg">
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center">
                    <p class="text-3xl font-bold" id="monthlyAttendance">--</p>
                    <p class="text-sm text-blue-100 mt-1">This Month</p>
                </div>
                <div class="text-center border-l border-blue-400 pl-4">
                    <p class="text-3xl font-bold" id="yearlyAttendance">--</p>
                    <p class="text-sm text-blue-100 mt-1">This Year</p>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-blue-400">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-blue-100">Attendance Rate</span>
                    <span class="font-bold" id="attendanceRate">--%</span>
                </div>
                <div class="w-full bg-blue-900/30 rounded-full h-2 mt-2">
                    <div id="attendanceBar" class="bg-white rounded-full h-2 transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Scanner Modal -->
<div id="qrScannerModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Scan QR Code</h3>
                <button onclick="closeQRScanner()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- QR Scanner Container -->
            <div id="qrScanner" class="bg-gray-100 rounded-lg overflow-hidden aspect-square mb-4">
                <div class="flex items-center justify-center h-full">
                    <p class="text-gray-500">Camera loading...</p>
                </div>
            </div>

            <p class="text-sm text-gray-600 text-center">
                Position the QR code within the frame to scan
            </p>
        </div>
    </div>
</div>

<!-- My QR Code Modal -->
<div id="myQRModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">My QR Code</h3>
                <button onclick="closeMyQR()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Member Name -->
            <div class="text-center mb-4">
                <p class="text-lg font-semibold text-gray-900" id="qrMemberName">Loading...</p>
                <p class="text-sm text-gray-500" id="qrMemberPhone"></p>
            </div>

            <!-- QR Code Display -->
            <div id="myQRCode" class="bg-white p-6 rounded-lg border-2 border-gray-200 mb-4">
                <!-- QR code will be inserted here -->
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-blue-800">
                    <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    Show this QR code to an usher to check in
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Family Check-in Modal -->
<div id="familyCheckInModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center overflow-y-auto">
    <div class="bg-white rounded-xl max-w-md w-full mx-4 my-8">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Family Check-in</h3>
                <button onclick="closeFamilyCheckIn()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="familyCheckInForm" class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Service Type</label>
                    <select name="service_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select service type</option>
                        <option value="sunday_first">Sunday First Service</option>
                        <option value="sunday_second">Sunday Second Service</option>
                        <option value="midweek">Midweek Service</option>
                        <option value="prayer_meeting">Prayer Meeting</option>
                        <option value="special">Special Service</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Select Family Members</label>
                    <div id="familyMembersList" class="space-y-2 max-h-64 overflow-y-auto">
                        <!-- Will be populated by JavaScript -->
                        <p class="text-gray-500 text-center py-4">Loading family members...</p>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                    Check In Family
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// QR Scanner Functions
function openQRScanner() {
    document.getElementById('qrScannerModal').classList.remove('hidden');
    // TODO: Initialize QR scanner library (html5-qrcode)
    // For now, show placeholder
    ChurchApp.showToast('QR Scanner will be available soon. Please use "Show My QR Code" option.', 'info');
}

function closeQRScanner() {
    document.getElementById('qrScannerModal').classList.add('hidden');
    // TODO: Stop QR scanner camera
}

// My QR Code Functions
async function showMyQR() {
    document.getElementById('myQRModal').classList.remove('hidden');

    try {
        const result = await ChurchApp.getMyQRCode();

        if (result.success) {
            document.getElementById('qrMemberName').textContent = result.data.member.full_name;
            document.getElementById('qrMemberPhone').textContent = result.data.member.phone;

            // Display QR code (assuming QR code comes as data URL or SVG)
            document.getElementById('myQRCode').innerHTML = result.data.qr_code;
        }
    } catch (error) {
        ChurchApp.showToast('Failed to load QR code', 'error');
        closeMyQR();
    }
}

function closeMyQR() {
    document.getElementById('myQRModal').classList.add('hidden');
}

// Family Check-in Functions
async function showFamilyCheckIn() {
    document.getElementById('familyCheckInModal').classList.remove('hidden');

    try {
        const result = await ChurchApp.getFamilyMembers();

        if (result.success && result.data.length > 0) {
            const listHTML = result.data.map(member => `
                <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                    <input type="checkbox" name="family_members[]" value="${member.id}"
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3" checked>
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">${member.full_name}</p>
                        <p class="text-sm text-gray-500">${member.relationship || 'Family Member'}</p>
                    </div>
                </label>
            `).join('');

            document.getElementById('familyMembersList').innerHTML = listHTML;
        } else {
            document.getElementById('familyMembersList').innerHTML = `
                <p class="text-gray-500 text-center py-4">No family members found</p>
            `;
        }
    } catch (error) {
        ChurchApp.showToast('Failed to load family members', 'error');
    }
}

function closeFamilyCheckIn() {
    document.getElementById('familyCheckInModal').classList.add('hidden');
}

// Family Check-in Form Submission
document.getElementById('familyCheckInForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const serviceType = formData.get('service_type');
    const familyMembers = formData.getAll('family_members[]');

    if (familyMembers.length === 0) {
        ChurchApp.showToast('Please select at least one family member', 'error');
        return;
    }

    ChurchApp.showLoading(true);

    try {
        const result = await ChurchApp.checkInFamily(serviceType, familyMembers);

        if (result.success) {
            ChurchApp.showToast(`Checked in ${result.data.count} family member(s)!`, 'success');
            closeFamilyCheckIn();
            loadCheckInHistory();
        }
    } catch (error) {
        ChurchApp.showToast(error.message || 'Family check-in failed', 'error');
    } finally {
        ChurchApp.showLoading(false);
    }
});

// Load Recent Check-ins
async function loadCheckInHistory() {
    try {
        const result = await ChurchApp.getCheckInHistory(5); // Last 5 check-ins

        if (result.success && result.data.length > 0) {
            const historyHTML = result.data.map(checkIn => {
                const date = new Date(checkIn.check_in_time);
                const formattedDate = date.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                });
                const formattedTime = date.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                return `
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">${checkIn.service_type_label || checkIn.service_type}</p>
                                    <p class="text-sm text-gray-500">${formattedDate} at ${formattedTime}</p>
                                </div>
                            </div>
                            ${checkIn.location ? `<span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">${checkIn.location}</span>` : ''}
                        </div>
                    </div>
                `;
            }).join('');

            document.getElementById('recentCheckIns').innerHTML = historyHTML;
        } else {
            document.getElementById('recentCheckIns').innerHTML = `
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p>No check-in history yet</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Failed to load check-in history:', error);
    }
}

// Load Attendance Stats
async function loadAttendanceStats() {
    try {
        const result = await ChurchApp.getAttendanceStats();

        if (result.success) {
            const stats = result.data;

            document.getElementById('monthlyAttendance').textContent = stats.monthly_count || 0;
            document.getElementById('yearlyAttendance').textContent = stats.yearly_count || 0;

            const rate = stats.attendance_rate || 0;
            document.getElementById('attendanceRate').textContent = `${rate}%`;
            document.getElementById('attendanceBar').style.width = `${rate}%`;
        }
    } catch (error) {
        console.error('Failed to load attendance stats:', error);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    loadCheckInHistory();
    loadAttendanceStats();
});
</script>
@endpush
