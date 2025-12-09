@extends('layouts.mobile')

@section('title', 'Children\'s Ministry - Church App')
@section('header', 'Children\'s Ministry')

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- My Children List -->
    <div class="px-4 py-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900">My Children</h2>
            <button onclick="showAddChildModal()" class="text-blue-600 font-semibold text-sm">
                + Add Child
            </button>
        </div>

        <!-- Loading State -->
        <div id="loadingState" class="text-center py-12">
            <svg class="animate-spin h-10 w-10 text-blue-600 mx-auto mb-3" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-500">Loading children...</p>
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="hidden text-center py-12">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <h3 class="text-lg font-bold text-gray-900 mb-2">No Children Registered</h3>
            <p class="text-gray-600 mb-4">Add your children to use check-in</p>
            <button onclick="showAddChildModal()" class="bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-700 transition">
                Add First Child
            </button>
        </div>

        <!-- Children List -->
        <div id="childrenList" class="space-y-4">
            <!-- Dynamic content -->
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="fixed bottom-24 right-4 space-y-3">
        <!-- Check In Floating Button -->
        <button onclick="showCheckInModal()" class="bg-green-600 text-white rounded-full p-4 shadow-xl hover:bg-green-700 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
        </button>
    </div>
</div>

<!-- Check-In Modal -->
<div id="checkInModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 overflow-y-auto">
    <div class="min-h-screen flex items-end sm:items-center justify-center p-4">
        <div class="bg-white rounded-t-3xl sm:rounded-xl max-w-lg w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Check In Child</h3>
                <button onclick="closeCheckInModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="checkInForm" class="space-y-4">
                <!-- Select Child -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Select Child *</label>
                    <select id="checkInChildId" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Choose a child...</option>
                    </select>
                </div>

                <!-- Class (auto-assigned, display only) -->
                <div id="assignedClassSection" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <p class="text-sm text-blue-900">
                        <span class="font-semibold">Assigned Class:</span>
                        <span id="assignedClass"></span>
                    </p>
                </div>

                <!-- Allergies Alert -->
                <div id="allergiesAlert" class="hidden bg-red-50 border border-red-200 rounded-lg p-3">
                    <p class="text-sm text-red-900">
                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold">Allergies:</span>
                        <span id="allergiesList"></span>
                    </p>
                </div>

                <!-- Medical Notes Alert -->
                <div id="medicalNotesAlert" class="hidden bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                    <p class="text-sm text-yellow-900">
                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold">Medical Notes:</span>
                        <span id="medicalNotesList"></span>
                    </p>
                </div>

                <!-- Additional Notes -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                    <textarea id="checkInNotes" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Any special instructions for today..."></textarea>
                </div>

                <!-- Confirmation Checkbox -->
                <div>
                    <label class="flex items-start">
                        <input type="checkbox" id="confirmCheckIn" required class="rounded text-blue-600 focus:ring-blue-500 mt-1 mr-3">
                        <span class="text-sm text-gray-700">
                            I confirm I have reviewed the child's medical information and will inform the teacher of any special needs.
                        </span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-green-600 text-white font-bold py-4 rounded-lg hover:bg-green-700 transition flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Complete Check-In
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Check-Out Modal -->
<div id="checkOutModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 overflow-y-auto">
    <div class="min-h-screen flex items-end sm:items-center justify-center p-4">
        <div class="bg-white rounded-t-3xl sm:rounded-xl max-w-lg w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Check Out Child</h3>
                <button onclick="closeCheckOutModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div id="securityCodeSection" class="mb-6">
                <div class="bg-blue-600 rounded-xl p-8 text-center">
                    <p class="text-blue-100 text-sm mb-2">Your Security Code</p>
                    <p id="securityCodeDisplay" class="text-5xl font-bold text-white tracking-wider">----</p>
                    <p class="text-blue-100 text-xs mt-2">Show this code to the teacher</p>
                </div>
            </div>

            <form id="checkOutForm" class="space-y-4">
                <!-- Select Child -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Select Child *</label>
                    <select id="checkOutChildId" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Choose a child...</option>
                    </select>
                </div>

                <!-- Pickup Person Confirmation -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-700 mb-2">
                        <span class="font-semibold">Picked up by:</span> You (Parent/Guardian)
                    </p>
                    <p class="text-xs text-gray-600">The teacher will verify your identity and security code</p>
                </div>

                <!-- Refresh Code Button -->
                <button type="button" onclick="generateSecurityCode()" class="w-full bg-blue-100 text-blue-700 font-semibold py-3 rounded-lg hover:bg-blue-200 transition">
                    Refresh Security Code
                </button>

                <!-- Cancel Button -->
                <button type="button" onclick="closeCheckOutModal()" class="w-full bg-gray-100 text-gray-700 font-semibold py-3 rounded-lg hover:bg-gray-200 transition">
                    Cancel
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Security Code Success Modal -->
<div id="securityCodeSuccessModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-sm w-full p-6 text-center">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Check-In Successful!</h3>
        <p class="text-gray-600 mb-6" id="checkInSuccessMessage">Child checked in successfully</p>
        <button onclick="closeSecurityCodeSuccessModal()" class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition">
            Done
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
let myChildren = [];
let checkedInChildren = [];

// Load my children
async function loadMyChildren() {
    try {
        ChurchApp.showLoading(true);

        const result = await ChurchApp.apiCall('/api/mobile/v1/children/my-children', 'GET');

        if (result.success && result.data) {
            myChildren = result.data;
            renderChildrenList(myChildren);
        }

        // Load checked-in children
        await loadCheckedInChildren();

        ChurchApp.showLoading(false);
    } catch (error) {
        console.error('Failed to load children:', error);
        ChurchApp.showToast('Failed to load children list', 'error');
        ChurchApp.showLoading(false);
    }
}

// Load checked-in children (those currently at ministry)
async function loadCheckedInChildren() {
    try {
        const result = await ChurchApp.apiCall('/api/mobile/v1/children/attendance-history?status=checked_in', 'GET');
        if (result.success && result.data) {
            checkedInChildren = result.data;
        }
    } catch (error) {
        console.error('Failed to load checked-in children:', error);
    }
}

// Render children list
function renderChildrenList(children) {
    const loadingState = document.getElementById('loadingState');
    const emptyState = document.getElementById('emptyState');
    const childrenList = document.getElementById('childrenList');

    loadingState.classList.add('hidden');

    if (!children || children.length === 0) {
        emptyState.classList.remove('hidden');
        childrenList.innerHTML = '';
        return;
    }

    emptyState.classList.add('hidden');

    const html = children.map(child => {
        const isCheckedIn = checkedInChildren.some(c => c.child_id === child.id);
        const ageYears = child.age_years || 0;

        return `
            <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 ${isCheckedIn ? 'border-green-500' : 'border-gray-300'}">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900 text-lg">${child.full_name}</h4>
                        <p class="text-sm text-gray-600">Age: ${ageYears} years • ${child.assigned_class || 'Not assigned'}</p>
                        ${child.allergies ? `
                            <div class="mt-2 flex items-center text-xs text-red-600">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92z" clip-rule="evenodd"/>
                                </svg>
                                Allergies: ${child.allergies}
                            </div>
                        ` : ''}
                    </div>
                    ${isCheckedIn ? `
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                            Checked In
                        </span>
                    ` : ''}
                </div>

                <div class="grid grid-cols-2 gap-2">
                    ${!isCheckedIn ? `
                        <button onclick="quickCheckIn(${child.id})" class="bg-green-600 text-white font-semibold py-2 rounded-lg hover:bg-green-700 transition text-sm">
                            Check In
                        </button>
                        <button onclick="viewAttendanceHistory(${child.id})" class="bg-gray-100 text-gray-700 font-semibold py-2 rounded-lg hover:bg-gray-200 transition text-sm">
                            History
                        </button>
                    ` : `
                        <button onclick="quickCheckOut(${child.id})" class="bg-orange-600 text-white font-semibold py-2 rounded-lg hover:bg-orange-700 transition text-sm">
                            Check Out
                        </button>
                        <button onclick="reportIncident(${child.id})" class="bg-red-100 text-red-700 font-semibold py-2 rounded-lg hover:bg-red-200 transition text-sm">
                            Report Issue
                        </button>
                    `}
                </div>
            </div>
        `;
    }).join('');

    childrenList.innerHTML = html;
}

// Show check-in modal
function showCheckInModal() {
    // Populate child select
    const select = document.getElementById('checkInChildId');
    select.innerHTML = '<option value="">Choose a child...</option>';
    myChildren.filter(c => !checkedInChildren.some(cc => cc.child_id === c.id)).forEach(child => {
        select.innerHTML += `<option value="${child.id}">${child.full_name}</option>`;
    });

    document.getElementById('checkInModal').classList.remove('hidden');
}

function closeCheckInModal() {
    document.getElementById('checkInModal').classList.add('hidden');
    document.getElementById('checkInForm').reset();
    document.getElementById('assignedClassSection').classList.add('hidden');
    document.getElementById('allergiesAlert').classList.add('hidden');
    document.getElementById('medicalNotesAlert').classList.add('hidden');
}

// Handle child selection for check-in
document.getElementById('checkInChildId').addEventListener('change', (e) => {
    const childId = parseInt(e.target.value);
    if (!childId) return;

    const child = myChildren.find(c => c.id === childId);
    if (!child) return;

    // Show assigned class
    document.getElementById('assignedClass').textContent = child.assigned_class || 'Will be assigned';
    document.getElementById('assignedClassSection').classList.remove('hidden');

    // Show allergies if present
    if (child.allergies) {
        document.getElementById('allergiesList').textContent = child.allergies;
        document.getElementById('allergiesAlert').classList.remove('hidden');
    } else {
        document.getElementById('allergiesAlert').classList.add('hidden');
    }

    // Show medical notes if present
    if (child.medical_notes) {
        document.getElementById('medicalNotesList').textContent = child.medical_notes;
        document.getElementById('medicalNotesAlert').classList.remove('hidden');
    } else {
        document.getElementById('medicalNotesAlert').classList.add('hidden');
    }
});

// Handle check-in form submission
document.getElementById('checkInForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const childId = document.getElementById('checkInChildId').value;
    const notes = document.getElementById('checkInNotes').value;

    try {
        ChurchApp.showLoading(true);

        const result = await ChurchApp.apiCall('/api/mobile/v1/children/check-in', 'POST', {
            child_id: childId,
            notes: notes
        });

        if (result.success) {
            closeCheckInModal();

            const child = myChildren.find(c => c.id == childId);
            document.getElementById('checkInSuccessMessage').textContent = `${child.full_name} has been checked in successfully!`;
            document.getElementById('securityCodeSuccessModal').classList.remove('hidden');

            // Reload children list
            await loadMyChildren();
        } else {
            throw new Error(result.message || 'Check-in failed');
        }
    } catch (error) {
        console.error('Check-in error:', error);
        ChurchApp.showToast(error.message || 'Failed to check in', 'error');
    } finally {
        ChurchApp.showLoading(false);
    }
});

// Quick check-in
function quickCheckIn(childId) {
    document.getElementById('checkInChildId').value = childId;
    document.getElementById('checkInChildId').dispatchEvent(new Event('change'));
    showCheckInModal();
}

// Show check-out modal
function showCheckOutModal(childId = null) {
    // Populate child select with only checked-in children
    const select = document.getElementById('checkOutChildId');
    select.innerHTML = '<option value="">Choose a child...</option>';
    checkedInChildren.forEach(attendance => {
        const child = myChildren.find(c => c.id === attendance.child_id);
        if (child) {
            select.innerHTML += `<option value="${child.id}">${child.full_name}</option>`;
        }
    });

    if (childId) {
        select.value = childId;
        generateSecurityCode();
    }

    document.getElementById('checkOutModal').classList.remove('hidden');
}

function closeCheckOutModal() {
    document.getElementById('checkOutModal').classList.add('hidden');
    document.getElementById('checkOutForm').reset();
    document.getElementById('securityCodeDisplay').textContent = '----';
}

// Quick check-out
function quickCheckOut(childId) {
    showCheckOutModal(childId);
}

// Generate security code
async function generateSecurityCode() {
    const childId = document.getElementById('checkOutChildId').value;
    if (!childId) {
        ChurchApp.showToast('Please select a child first', 'warning');
        return;
    }

    try {
        const result = await ChurchApp.apiCall('/api/mobile/v1/children/security-code/generate', 'POST', {
            child_id: childId
        });

        if (result.success && result.data) {
            document.getElementById('securityCodeDisplay').textContent = result.data.security_code;
        } else {
            throw new Error(result.message || 'Failed to generate code');
        }
    } catch (error) {
        console.error('Security code error:', error);
        ChurchApp.showToast('Failed to generate security code', 'error');
    }
}

// Close success modal
function closeSecurityCodeSuccessModal() {
    document.getElementById('securityCodeSuccessModal').classList.add('hidden');
}

// View attendance history
function viewAttendanceHistory(childId) {
    const child = myChildren.find(c => c.id === childId);
    window.location.href = `/mobile/children/${childId}/history`;
}

// Report incident
function reportIncident(childId) {
    const child = myChildren.find(c => c.id === childId);
    window.location.href = `/mobile/children/${childId}/report-incident`;
}

// Show add child modal
function showAddChildModal() {
    ChurchApp.showToast('Please contact church admin to register children', 'info');
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    loadMyChildren();
});
</script>
@endpush
