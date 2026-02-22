@extends('layouts.mobile')

@section('title', 'Edit Profile - Church App')
@section('header', 'Edit Profile')

@section('header-actions')
<button onclick="history.back()" class="p-2 rounded-full hover:bg-white/10">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
    </svg>
</button>
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <form id="profileForm" class="px-4 py-6 space-y-6">
        <!-- Profile Photo Section -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Profile Photo</h3>

            <div class="flex flex-col items-center">
                <div class="relative mb-4">
                    <div id="photoPreviewContainer" class="w-32 h-32 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full flex items-center justify-center overflow-hidden">
                        <img id="photoPreview" class="hidden w-full h-full object-cover" alt="Profile">
                        <div id="photoInitials" class="text-4xl font-bold text-white">
                            <!-- Initials -->
                        </div>
                    </div>
                    <input type="file" id="photoInput" accept="image/*" class="hidden">
                </div>

                <div class="flex space-x-3">
                    <button type="button" onclick="document.getElementById('photoInput').click()" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Change Photo
                    </button>
                    <button type="button" id="removePhotoBtn" class="hidden bg-red-50 text-red-600 px-6 py-2 rounded-lg font-semibold hover:bg-red-100 transition" onclick="removePhoto()">
                        Remove
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-2">JPG, PNG or GIF. Max 2MB</p>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Personal Information</h3>

            <div class="space-y-4">
                <!-- First Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">First Name *</label>
                    <input type="text" id="firstName" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="John">
                </div>

                <!-- Last Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Last Name *</label>
                    <input type="text" id="lastName" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Doe">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                    <input type="email" id="email" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="john.doe@example.com">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                    <input type="tel" id="phone" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="+233 XX XXX XXXX">
                </div>

                <!-- Date of Birth -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Date of Birth</label>
                    <input type="date" id="dateOfBirth"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Gender</label>
                    <select id="gender"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <!-- Marital Status -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Marital Status</label>
                    <select id="maritalStatus"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Status</option>
                        <option value="single">Single</option>
                        <option value="married">Married</option>
                        <option value="divorced">Divorced</option>
                        <option value="widowed">Widowed</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Address Information -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Address</h3>

            <div class="space-y-4">
                <!-- Street Address -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Street Address</label>
                    <input type="text" id="address"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="123 Main Street">
                </div>

                <!-- City -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">City</label>
                    <input type="text" id="city"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Accra">
                </div>

                <!-- Region -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Region</label>
                    <select id="region"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Region</option>
                        <option value="Greater Accra">Greater Accra</option>
                        <option value="Ashanti">Ashanti</option>
                        <option value="Central">Central</option>
                        <option value="Eastern">Eastern</option>
                        <option value="Northern">Northern</option>
                        <option value="Western">Western</option>
                        <option value="Volta">Volta</option>
                        <option value="Upper East">Upper East</option>
                        <option value="Upper West">Upper West</option>
                        <option value="Brong Ahafo">Brong Ahafo</option>
                    </select>
                </div>

                <!-- Digital Address -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ghana Post GPS Address</label>
                    <input type="text" id="digitalAddress"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="GA-123-4567">
                    <p class="text-xs text-gray-500 mt-1">Ghana Post Digital Address (optional)</p>
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Emergency Contact</h3>

            <div class="space-y-4">
                <!-- Emergency Contact Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Contact Name</label>
                    <input type="text" id="emergencyName"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Jane Doe">
                </div>

                <!-- Emergency Contact Relationship -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Relationship</label>
                    <input type="text" id="emergencyRelationship"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Spouse, Parent, Sibling, etc.">
                </div>

                <!-- Emergency Contact Phone -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Contact Phone</label>
                    <input type="tel" id="emergencyPhone"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="+233 XX XXX XXXX">
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Additional Information</h3>

            <div class="space-y-4">
                <!-- Occupation -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Occupation</label>
                    <input type="text" id="occupation"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Software Developer">
                </div>

                <!-- Skills/Talents -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Skills & Talents</label>
                    <textarea id="skills" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="E.g., Music, Teaching, Technical Support, etc."></textarea>
                    <p class="text-xs text-gray-500 mt-1">This helps us match you with suitable ministry opportunities</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="sticky bottom-20 bg-white border-t border-gray-200 p-4 -mx-4 shadow-xl space-y-3">
            <button type="submit" id="saveBtn"
                    class="w-full bg-blue-600 text-white font-bold py-4 rounded-lg hover:bg-blue-700 transition shadow-lg flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Changes
            </button>
            <button type="button" onclick="history.back()"
                    class="w-full bg-gray-100 text-gray-700 font-semibold py-3 rounded-lg hover:bg-gray-200 transition">
                Cancel
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let currentProfile = null;
let newPhotoFile = null;
let removePhotoFlag = false;

// Load profile data
async function loadProfile() {
    try {
        ChurchApp.showLoading(true);

        const result = await ChurchApp.getMyProfile();
        if (result.success && result.data) {
            currentProfile = result.data;
            populateForm(currentProfile);
        } else {
            throw new Error('Failed to load profile');
        }

        ChurchApp.showLoading(false);
    } catch (error) {
        console.error('Failed to load profile:', error);
        ChurchApp.showToast('Failed to load profile data', 'error');
        ChurchApp.showLoading(false);
    }
}

// Populate form with current data
function populateForm(profile) {
    // Personal information
    const names = (profile.full_name || '').split(' ');
    document.getElementById('firstName').value = names[0] || '';
    document.getElementById('lastName').value = names.slice(1).join(' ') || '';
    document.getElementById('email').value = profile.email || '';
    document.getElementById('phone').value = profile.phone || '';
    document.getElementById('dateOfBirth').value = profile.date_of_birth || '';
    document.getElementById('gender').value = profile.gender || '';
    document.getElementById('maritalStatus').value = profile.marital_status || '';

    // Address
    document.getElementById('address').value = profile.address || '';
    document.getElementById('city').value = profile.city || '';
    document.getElementById('region').value = profile.region || '';
    document.getElementById('digitalAddress').value = profile.digital_address || '';

    // Emergency contact
    document.getElementById('emergencyName').value = profile.emergency_contact_name || '';
    document.getElementById('emergencyRelationship').value = profile.emergency_contact_relationship || '';
    document.getElementById('emergencyPhone').value = profile.emergency_contact_phone || '';

    // Additional info
    document.getElementById('occupation').value = profile.occupation || '';
    document.getElementById('skills').value = profile.skills || '';

    // Profile photo
    if (profile.photo_url) {
        document.getElementById('photoPreview').src = profile.photo_url;
        document.getElementById('photoPreview').classList.remove('hidden');
        document.getElementById('photoInitials').classList.add('hidden');
        document.getElementById('removePhotoBtn').classList.remove('hidden');
    } else {
        // Generate initials
        const initials = names.map(n => n.charAt(0).toUpperCase()).join('').substring(0, 2);
        document.getElementById('photoInitials').textContent = initials;
    }
}

// Handle photo input change
document.getElementById('photoInput').addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (!file) return;

    // Validate file type
    if (!file.type.startsWith('image/')) {
        ChurchApp.showToast('Please select an image file', 'error');
        return;
    }

    // Validate file size (2MB)
    if (file.size > 2 * 1024 * 1024) {
        ChurchApp.showToast('Image size must be less than 2MB', 'error');
        return;
    }

    newPhotoFile = file;
    removePhotoFlag = false;

    // Preview image
    const reader = new FileReader();
    reader.onload = (e) => {
        document.getElementById('photoPreview').src = e.target.result;
        document.getElementById('photoPreview').classList.remove('hidden');
        document.getElementById('photoInitials').classList.add('hidden');
        document.getElementById('removePhotoBtn').classList.remove('hidden');
    };
    reader.readAsDataURL(file);
});

// Remove photo
function removePhoto() {
    if (!confirm('Remove your profile photo?')) return;

    newPhotoFile = null;
    removePhotoFlag = true;

    // Show initials
    const firstName = document.getElementById('firstName').value;
    const lastName = document.getElementById('lastName').value;
    const initials = (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();

    document.getElementById('photoPreview').classList.add('hidden');
    document.getElementById('photoInitials').classList.remove('hidden');
    document.getElementById('photoInitials').textContent = initials;
    document.getElementById('removePhotoBtn').classList.add('hidden');
}

// Handle form submission
document.getElementById('profileForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    ChurchApp.showLoading(true);

    try {
        // Submit profile text fields as JSON
        const profilePayload = {
            first_name: document.getElementById('firstName').value,
            last_name: document.getElementById('lastName').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            date_of_birth: document.getElementById('dateOfBirth').value,
            gender: document.getElementById('gender').value,
            marital_status: document.getElementById('maritalStatus').value,
            address: document.getElementById('address').value,
            city: document.getElementById('city').value,
            region: document.getElementById('region').value,
            digital_address: document.getElementById('digitalAddress').value,
            emergency_contact_name: document.getElementById('emergencyName').value,
            emergency_contact_relationship: document.getElementById('emergencyRelationship').value,
            emergency_contact_phone: document.getElementById('emergencyPhone').value,
            occupation: document.getElementById('occupation').value,
            skills: document.getElementById('skills').value,
        };

        const result = await fetch('/api/v1/my/profile', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
            body: JSON.stringify(profilePayload),
        });

        const data = await result.json();

        if (!data.success && !result.ok) {
            throw new Error(data.message || 'Update failed');
        }

        // Upload photo separately if changed
        if (newPhotoFile) {
            const photoForm = new FormData();
            photoForm.append('photo', newPhotoFile);
            await fetch('/api/mobile/v1/my/photo', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
                body: photoForm,
            });
        }

        ChurchApp.showToast('Profile updated successfully', 'success');
        setTimeout(() => {
            window.location.href = '{{ url('/mobile/profile') }}';
        }, 1500);
    } catch (error) {
        console.error('Update error:', error);
        ChurchApp.showToast(error.message || 'Failed to update profile', 'error');
    } finally {
        ChurchApp.showLoading(false);
    }
});

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    loadProfile();
});
</script>
@endpush
