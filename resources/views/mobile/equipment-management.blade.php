@extends('layouts.mobile')

@section('title', 'Equipment Management - Church App')
@section('header', 'Equipment Management')

@section('header-actions')
<button onclick="scanEquipmentQR()" class="p-2 rounded-full hover:bg-white/10">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
    </svg>
</button>
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Tab Navigation -->
    <div class="bg-white shadow-sm sticky top-0 z-10">
        <div class="flex">
            <button onclick="switchTab('checkouts')" class="tab-btn flex-1 px-4 py-4 font-semibold text-sm border-b-2 transition active border-blue-600 text-blue-600">
                My Checkouts
            </button>
            <button onclick="switchTab('scan')" class="tab-btn flex-1 px-4 py-4 font-semibold text-sm border-b-2 transition border-transparent text-gray-600 hover:text-blue-600">
                Scan Equipment
            </button>
        </div>
    </div>

    <!-- My Checkouts Tab -->
    <div id="checkoutsTab" class="px-4 py-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900">Active Checkouts</h2>
            <span id="checkoutsCount" class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">0</span>
        </div>

        <!-- Loading State -->
        <div id="loadingCheckouts" class="text-center py-12">
            <svg class="animate-spin h-10 w-10 text-blue-600 mx-auto mb-3" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-500">Loading checkouts...</p>
        </div>

        <!-- Empty State -->
        <div id="emptyCheckouts" class="hidden text-center py-12">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <h3 class="text-lg font-bold text-gray-900 mb-2">No Active Checkouts</h3>
            <p class="text-gray-600 mb-4">You don't have any equipment checked out</p>
            <button onclick="switchTab('scan')" class="bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-700 transition">
                Scan Equipment
            </button>
        </div>

        <!-- Checkouts List -->
        <div id="checkoutsList" class="space-y-4">
            <!-- Dynamic content -->
        </div>
    </div>

    <!-- Scan Equipment Tab -->
    <div id="scanTab" class="hidden px-4 py-6">
        <div class="text-center mb-6">
            <div class="bg-blue-100 rounded-full w-32 h-32 mx-auto mb-4 flex items-center justify-center">
                <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">Scan Equipment QR Code</h2>
            <p class="text-gray-600">Point your camera at the QR code on the equipment</p>
        </div>

        <!-- QR Scanner Container -->
        <div id="qrScanner" class="bg-gray-900 rounded-xl overflow-hidden mb-6 aspect-square">
            <div class="w-full h-full flex items-center justify-center">
                <p class="text-white text-sm">Camera will open here</p>
            </div>
        </div>

        <button onclick="startQRScanner()" class="w-full bg-blue-600 text-white font-bold py-4 rounded-lg hover:bg-blue-700 transition mb-4">
            Start QR Scanner
        </button>

        <!-- Manual Entry Option -->
        <div class="text-center">
            <button onclick="showManualEntry()" class="text-blue-600 font-semibold text-sm hover:underline">
                Enter Equipment Code Manually
            </button>
        </div>
    </div>
</div>

<!-- Equipment Details Modal -->
<div id="equipmentModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 overflow-y-auto">
    <div class="min-h-screen flex items-end sm:items-center justify-center p-4">
        <div class="bg-white rounded-t-3xl sm:rounded-xl max-w-lg w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Equipment Details</h3>
                <button onclick="closeEquipmentModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div id="equipmentInfo" class="space-y-4 mb-6">
                <!-- Equipment Name -->
                <div>
                    <h4 id="eqName" class="text-2xl font-bold text-gray-900"></h4>
                    <p id="eqCategory" class="text-gray-600"></p>
                </div>

                <!-- Status Badge -->
                <div>
                    <span id="eqStatusBadge" class="inline-block px-4 py-2 rounded-full text-sm font-semibold"></span>
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-2 gap-4 bg-gray-50 rounded-lg p-4">
                    <div>
                        <p class="text-xs text-gray-600 mb-1">Serial Number</p>
                        <p id="eqSerial" class="font-semibold text-gray-900"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 mb-1">Location</p>
                        <p id="eqLocation" class="font-semibold text-gray-900"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 mb-1">Condition</p>
                        <p id="eqCondition" class="font-semibold text-gray-900"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 mb-1">Purchase Date</p>
                        <p id="eqPurchaseDate" class="font-semibold text-gray-900"></p>
                    </div>
                </div>

                <!-- Currently Assigned (if applicable) -->
                <div id="eqAssignedSection" class="hidden bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-sm text-yellow-900">
                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold">Currently assigned to:</span>
                        <span id="eqAssignedTo"></span>
                    </p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div id="eqActions" class="space-y-3">
                <!-- Will be populated dynamically -->
            </div>
        </div>
    </div>
</div>

<!-- Checkout Modal -->
<div id="checkoutModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 overflow-y-auto">
    <div class="min-h-screen flex items-end sm:items-center justify-center p-4">
        <div class="bg-white rounded-t-3xl sm:rounded-xl max-w-lg w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Checkout Equipment</h3>
                <button onclick="closeCheckoutModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="checkoutForm" class="space-y-4">
                <input type="hidden" id="checkoutEquipmentId">

                <!-- Equipment Name (Read-only) -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Equipment</p>
                    <p id="checkoutEquipmentName" class="font-bold text-gray-900"></p>
                </div>

                <!-- Expected Return Date -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Expected Return Date *</label>
                    <input type="date" id="returnDate" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Purpose -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Purpose *</label>
                    <select id="checkoutPurpose" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select purpose...</option>
                        <option value="service">Sunday Service</option>
                        <option value="event">Event/Program</option>
                        <option value="practice">Practice/Rehearsal</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                    <textarea id="checkoutNotes" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Any additional information..."></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-lg hover:bg-blue-700 transition">
                    Complete Checkout
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Return Equipment Modal -->
<div id="returnModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 overflow-y-auto">
    <div class="min-h-screen flex items-end sm:items-center justify-center p-4">
        <div class="bg-white rounded-t-3xl sm:rounded-xl max-w-lg w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Return Equipment</h3>
                <button onclick="closeReturnModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="returnForm" class="space-y-4">
                <input type="hidden" id="returnCheckoutId">

                <!-- Equipment Name (Read-only) -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-600 mb-1">Equipment</p>
                    <p id="returnEquipmentName" class="font-bold text-gray-900"></p>
                </div>

                <!-- Condition Assessment -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Condition Upon Return *</label>
                    <select id="returnCondition" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Rate condition...</option>
                        <option value="excellent">Excellent - Like new</option>
                        <option value="good">Good - Working properly</option>
                        <option value="fair">Fair - Minor issues</option>
                        <option value="poor">Poor - Needs repair</option>
                        <option value="damaged">Damaged - Not working</option>
                    </select>
                </div>

                <!-- Issues/Damages -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Issues or Damages</label>
                    <textarea id="returnIssues" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Describe any issues, damages, or concerns..."></textarea>
                </div>

                <!-- Return Notes -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Additional Notes</label>
                    <textarea id="returnNotes" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Any feedback or comments..."></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-green-600 text-white font-bold py-4 rounded-lg hover:bg-green-700 transition">
                    Complete Return
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Manual Entry Modal -->
<div id="manualEntryModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 overflow-y-auto">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Enter Equipment Code</h3>
                <button onclick="closeManualEntry()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="manualEntryForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Equipment Code *</label>
                    <input type="text" id="manualCode" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter code from QR label">
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition">
                    Look Up Equipment
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let myCheckouts = [];
let currentEquipment = null;
let activeTab = 'checkouts';

// Load my checkouts
async function loadMyCheckouts() {
    try {
        const result = await ChurchApp.apiCall('/api/mobile/v1/equipment/my-checkouts', 'GET');

        if (result.success && result.data) {
            myCheckouts = result.data;
            renderCheckoutsList(myCheckouts);
            document.getElementById('checkoutsCount').textContent = myCheckouts.length;
        }
    } catch (error) {
        console.error('Failed to load checkouts:', error);
        ChurchApp.showToast('Failed to load checkouts', 'error');
    }
}

// Render checkouts list
function renderCheckoutsList(checkouts) {
    const loading = document.getElementById('loadingCheckouts');
    const empty = document.getElementById('emptyCheckouts');
    const list = document.getElementById('checkoutsList');

    loading.classList.add('hidden');

    if (!checkouts || checkouts.length === 0) {
        empty.classList.remove('hidden');
        list.innerHTML = '';
        return;
    }

    empty.classList.add('hidden');

    const html = checkouts.map(checkout => {
        const returnDate = new Date(checkout.expected_return_date);
        const today = new Date();
        const isOverdue = returnDate < today;
        const daysUntil = Math.ceil((returnDate - today) / (1000 * 60 * 60 * 24));

        return `
            <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 ${isOverdue ? 'border-red-500' : 'border-blue-500'}">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900">${checkout.equipment.name}</h4>
                        <p class="text-sm text-gray-600">${checkout.equipment.category} • ${checkout.equipment.serial_number}</p>
                    </div>
                    ${isOverdue ? `
                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-3 py-1 rounded-full">
                            Overdue
                        </span>
                    ` : `
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                            ${daysUntil} day${daysUntil !== 1 ? 's' : ''} left
                        </span>
                    `}
                </div>

                <div class="bg-gray-50 rounded-lg p-3 mb-3 text-sm">
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Checked out:</span>
                        <span class="font-semibold">${new Date(checkout.checkout_date).toLocaleDateString()}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Expected return:</span>
                        <span class="font-semibold ${isOverdue ? 'text-red-600' : ''}">${returnDate.toLocaleDateString()}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <button onclick="initiateReturn(${checkout.id}, '${checkout.equipment.name}')" class="bg-green-600 text-white font-semibold py-2 rounded-lg hover:bg-green-700 transition text-sm">
                        Return Equipment
                    </button>
                    <button onclick="reportEquipmentIssue(${checkout.equipment_id}, '${checkout.equipment.name}')" class="bg-red-100 text-red-700 font-semibold py-2 rounded-lg hover:bg-red-200 transition text-sm">
                        Report Issue
                    </button>
                </div>
            </div>
        `;
    }).join('');

    list.innerHTML = html;
}

// Switch tabs
function switchTab(tab) {
    activeTab = tab;

    // Update tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active', 'border-blue-600', 'text-blue-600');
        btn.classList.add('border-transparent', 'text-gray-600');
    });

    if (tab === 'checkouts') {
        document.querySelectorAll('.tab-btn')[0].classList.add('active', 'border-blue-600', 'text-blue-600');
        document.getElementById('checkoutsTab').classList.remove('hidden');
        document.getElementById('scanTab').classList.add('hidden');
    } else {
        document.querySelectorAll('.tab-btn')[1].classList.add('active', 'border-blue-600', 'text-blue-600');
        document.getElementById('checkoutsTab').classList.add('hidden');
        document.getElementById('scanTab').classList.remove('hidden');
    }
}

// Scan equipment QR code
function scanEquipmentQR() {
    switchTab('scan');
    startQRScanner();
}

// Start QR Scanner (placeholder - requires HTML5-QRCode library)
function startQRScanner() {
    ChurchApp.showToast('QR Scanner would open here. Please enter code manually for now.', 'info');
    setTimeout(() => {
        showManualEntry();
    }, 1500);
}

// Show manual entry
function showManualEntry() {
    document.getElementById('manualEntryModal').classList.remove('hidden');
}

function closeManualEntry() {
    document.getElementById('manualEntryModal').classList.add('hidden');
    document.getElementById('manualEntryForm').reset();
}

// Handle manual entry form
document.getElementById('manualEntryForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const code = document.getElementById('manualCode').value.trim();
    await lookupEquipment(code);
});

// Lookup equipment by QR code
async function lookupEquipment(qrCode) {
    try {
        ChurchApp.showLoading(true);

        const result = await ChurchApp.apiCall(`/api/mobile/v1/equipment/scan/${qrCode}`, 'GET');

        if (result.success && result.data) {
            closeManualEntry();
            currentEquipment = result.data;
            showEquipmentDetails(currentEquipment);
        } else {
            throw new Error(result.message || 'Equipment not found');
        }
    } catch (error) {
        console.error('Lookup error:', error);
        ChurchApp.showToast(error.message || 'Equipment not found', 'error');
    } finally {
        ChurchApp.showLoading(false);
    }
}

// Show equipment details modal
function showEquipmentDetails(equipment) {
    document.getElementById('eqName').textContent = equipment.name;
    document.getElementById('eqCategory').textContent = equipment.category;
    document.getElementById('eqSerial').textContent = equipment.serial_number || 'N/A';
    document.getElementById('eqLocation').textContent = equipment.location || 'N/A';
    document.getElementById('eqCondition').textContent = equipment.condition || 'N/A';
    document.getElementById('eqPurchaseDate').textContent = equipment.purchase_date ? new Date(equipment.purchase_date).toLocaleDateString() : 'N/A';

    // Status badge
    const statusColors = {
        available: 'bg-green-100 text-green-800',
        in_use: 'bg-blue-100 text-blue-800',
        maintenance: 'bg-yellow-100 text-yellow-800',
        damaged: 'bg-red-100 text-red-800'
    };
    const statusBadge = document.getElementById('eqStatusBadge');
    statusBadge.textContent = equipment.status_label || equipment.status;
    statusBadge.className = `inline-block px-4 py-2 rounded-full text-sm font-semibold ${statusColors[equipment.status] || 'bg-gray-100 text-gray-800'}`;

    // Assigned section
    if (equipment.current_checkout) {
        document.getElementById('eqAssignedTo').textContent = equipment.current_checkout.member_name;
        document.getElementById('eqAssignedSection').classList.remove('hidden');
    } else {
        document.getElementById('eqAssignedSection').classList.add('hidden');
    }

    // Action buttons
    const actionsHtml = equipment.status === 'available' ? `
        <button onclick="initiateCheckout(${equipment.id}, '${equipment.name}')" class="w-full bg-blue-600 text-white font-bold py-4 rounded-lg hover:bg-blue-700 transition">
            Checkout Equipment
        </button>
        <button onclick="reportEquipmentIssue(${equipment.id}, '${equipment.name}')" class="w-full bg-red-100 text-red-700 font-semibold py-3 rounded-lg hover:bg-red-200 transition">
            Report Issue
        </button>
    ` : `
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
            <p class="text-yellow-900 font-semibold">Equipment not available for checkout</p>
            <p class="text-yellow-700 text-sm mt-1">Status: ${equipment.status_label}</p>
        </div>
    `;

    document.getElementById('eqActions').innerHTML = actionsHtml;
    document.getElementById('equipmentModal').classList.remove('hidden');
}

function closeEquipmentModal() {
    document.getElementById('equipmentModal').classList.add('hidden');
    currentEquipment = null;
}

// Initiate checkout
function initiateCheckout(equipmentId, equipmentName) {
    closeEquipmentModal();

    document.getElementById('checkoutEquipmentId').value = equipmentId;
    document.getElementById('checkoutEquipmentName').textContent = equipmentName;

    // Set minimum return date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('returnDate').setAttribute('min', today);

    document.getElementById('checkoutModal').classList.remove('hidden');
}

function closeCheckoutModal() {
    document.getElementById('checkoutModal').classList.add('hidden');
    document.getElementById('checkoutForm').reset();
}

// Handle checkout form submission
document.getElementById('checkoutForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const equipmentId = document.getElementById('checkoutEquipmentId').value;
    const returnDate = document.getElementById('returnDate').value;
    const purpose = document.getElementById('checkoutPurpose').value;
    const notes = document.getElementById('checkoutNotes').value;

    try {
        ChurchApp.showLoading(true);

        const result = await ChurchApp.apiCall('/api/mobile/v1/equipment/checkout', 'POST', {
            equipment_id: equipmentId,
            expected_return_date: returnDate,
            purpose: purpose,
            notes: notes
        });

        if (result.success) {
            closeCheckoutModal();
            ChurchApp.showToast('Equipment checked out successfully!', 'success');
            switchTab('checkouts');
            await loadMyCheckouts();
        } else {
            throw new Error(result.message || 'Checkout failed');
        }
    } catch (error) {
        console.error('Checkout error:', error);
        ChurchApp.showToast(error.message || 'Failed to checkout equipment', 'error');
    } finally {
        ChurchApp.showLoading(false);
    }
});

// Initiate return
function initiateReturn(checkoutId, equipmentName) {
    document.getElementById('returnCheckoutId').value = checkoutId;
    document.getElementById('returnEquipmentName').textContent = equipmentName;
    document.getElementById('returnModal').classList.remove('hidden');
}

function closeReturnModal() {
    document.getElementById('returnModal').classList.add('hidden');
    document.getElementById('returnForm').reset();
}

// Handle return form submission
document.getElementById('returnForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const checkoutId = document.getElementById('returnCheckoutId').value;
    const condition = document.getElementById('returnCondition').value;
    const issues = document.getElementById('returnIssues').value;
    const notes = document.getElementById('returnNotes').value;

    try {
        ChurchApp.showLoading(true);

        const result = await ChurchApp.apiCall('/api/mobile/v1/equipment/return', 'POST', {
            checkout_id: checkoutId,
            return_condition: condition,
            issues: issues,
            notes: notes
        });

        if (result.success) {
            closeReturnModal();
            ChurchApp.showToast('Equipment returned successfully!', 'success');
            await loadMyCheckouts();
        } else {
            throw new Error(result.message || 'Return failed');
        }
    } catch (error) {
        console.error('Return error:', error);
        ChurchApp.showToast(error.message || 'Failed to return equipment', 'error');
    } finally {
        ChurchApp.showLoading(false);
    }
});

// Report equipment issue
async function reportEquipmentIssue(equipmentId, equipmentName) {
    const issueDescription = prompt(`Report issue with ${equipmentName}:\n\nDescribe the problem:`);

    if (!issueDescription || issueDescription.trim() === '') {
        return;
    }

    try {
        ChurchApp.showLoading(true);

        const result = await ChurchApp.apiCall('/api/mobile/v1/equipment/report-issue', 'POST', {
            equipment_id: equipmentId,
            issue_type: 'malfunction',
            description: issueDescription
        });

        if (result.success) {
            ChurchApp.showToast('Issue reported successfully', 'success');
        } else {
            throw new Error(result.message || 'Failed to report issue');
        }
    } catch (error) {
        console.error('Report issue error:', error);
        ChurchApp.showToast('Failed to report issue', 'error');
    } finally {
        ChurchApp.showLoading(false);
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    loadMyCheckouts();
});
</script>
@endpush
