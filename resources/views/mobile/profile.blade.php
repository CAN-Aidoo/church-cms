@extends('layouts.mobile')

@section('title', 'My Profile - Church App')
@section('header', 'My Profile')

@section('header-actions')
<button onclick="window.location.href='/mobile/settings'" class="p-2 rounded-full hover:bg-white/10">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
    </svg>
</button>
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Profile Header Card -->
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 px-4 pt-6 pb-20">
        <div class="flex flex-col items-center">
            <!-- Profile Photo -->
            <div class="relative mb-4">
                <div id="profilePhotoContainer" class="w-28 h-28 bg-white rounded-full flex items-center justify-center overflow-hidden shadow-xl">
                    <img id="profilePhoto" class="hidden w-full h-full object-cover" alt="Profile">
                    <div id="profileInitials" class="text-4xl font-bold text-blue-600">
                        <!-- Initials will be set via JS -->
                    </div>
                </div>
                <button onclick="window.location.href='/mobile/profile/edit'" class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-lg">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                </button>
            </div>

            <!-- Name & Member ID -->
            <h2 id="memberName" class="text-2xl font-bold text-white mb-1">Loading...</h2>
            <p id="memberEmail" class="text-blue-100 mb-2">email@example.com</p>
            <div class="flex items-center bg-white/20 backdrop-blur rounded-full px-4 py-2">
                <svg class="w-4 h-4 text-white mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
                <span id="memberId" class="text-sm font-semibold text-white">ID: ------</span>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="px-4 -mt-12 mb-6">
        <div class="bg-white rounded-xl shadow-xl p-6">
            <h3 class="text-sm font-semibold text-gray-600 mb-4 uppercase">Quick Stats</h3>
            <div class="grid grid-cols-3 gap-4">
                <!-- Attendance -->
                <div class="text-center">
                    <div class="bg-blue-100 rounded-lg p-3 mb-2">
                        <svg class="w-6 h-6 text-blue-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <p id="attendancePercentage" class="text-2xl font-bold text-gray-900">--</p>
                    <p class="text-xs text-gray-600">Attendance</p>
                </div>

                <!-- Contributions -->
                <div class="text-center">
                    <div class="bg-green-100 rounded-lg p-3 mb-2">
                        <svg class="w-6 h-6 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p id="totalContributions" class="text-2xl font-bold text-gray-900">--</p>
                    <p class="text-xs text-gray-600">Contributions</p>
                </div>

                <!-- Programs -->
                <div class="text-center">
                    <div class="bg-purple-100 rounded-lg p-3 mb-2">
                        <svg class="w-6 h-6 text-purple-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p id="totalPrograms" class="text-2xl font-bold text-gray-900">--</p>
                    <p class="text-xs text-gray-600">Programs</p>
                </div>
            </div>

            <!-- Member Since -->
            <div class="mt-4 pt-4 border-t border-gray-200 text-center">
                <p class="text-sm text-gray-600">Member since <span id="memberSince" class="font-semibold text-gray-900">---</span></p>
            </div>
        </div>
    </div>

    <!-- Profile Sections -->
    <div class="px-4 space-y-3">
        <!-- Personal Information -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <button onclick="window.location.href='/mobile/profile/edit'" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-lg p-3 mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Personal Information</p>
                        <p class="text-sm text-gray-600">Edit your profile details</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- Attendance History -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <button onclick="window.location.href='/mobile/profile/attendance'" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-lg p-3 mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">My Attendance</p>
                        <p class="text-sm text-gray-600">View your attendance history</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- My Contributions -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <button onclick="window.location.href='/mobile/profile/contributions'" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-yellow-100 rounded-lg p-3 mr-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">My Contributions</p>
                        <p class="text-sm text-gray-600">View giving history & receipts</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- My Programs -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <button onclick="window.location.href='/mobile/profile/programs'" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-purple-100 rounded-lg p-3 mr-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">My Programs</p>
                        <p class="text-sm text-gray-600">Registered events & programs</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- Ministry Involvement -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <button onclick="window.location.href='/mobile/profile/ministry'" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-pink-100 rounded-lg p-3 mr-4">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">Ministry Involvement</p>
                        <p class="text-sm text-gray-600">Service units & volunteer work</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- My Shepherd -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <button onclick="window.location.href='/mobile/profile/shepherd'" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-indigo-100 rounded-lg p-3 mr-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">My Shepherd</p>
                        <p class="text-sm text-gray-600">Flock leader & contact info</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- My Family -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <button onclick="window.location.href='/mobile/profile/family'" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-red-100 rounded-lg p-3 mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">My Family</p>
                        <p class="text-sm text-gray-600">Family members & children</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- My Documents -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <button onclick="window.location.href='/mobile/profile/documents'" class="w-full flex items-center justify-between p-4 hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <div class="bg-orange-100 rounded-lg p-3 mr-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">My Documents</p>
                        <p class="text-sm text-gray-600">Certificates & downloads</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Logout Button -->
    <div class="px-4 mt-6 mb-6">
        <button onclick="handleLogout()" class="w-full bg-red-50 hover:bg-red-100 border-2 border-red-200 text-red-700 font-semibold py-4 rounded-xl transition flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Logout
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
let profileData = null;

// Load profile data
async function loadProfile() {
    try {
        ChurchApp.showLoading(true);

        // Load profile
        const profileResult = await ChurchApp.getMyProfile();
        if (profileResult.success && profileResult.data) {
            profileData = profileResult.data;
            renderProfile(profileData);
        }

        // Load quick stats
        await loadQuickStats();

        ChurchApp.showLoading(false);
    } catch (error) {
        console.error('Failed to load profile:', error);
        ChurchApp.showToast('Failed to load profile', 'error');
        ChurchApp.showLoading(false);
    }
}

// Render profile information
function renderProfile(profile) {
    // Name and email
    document.getElementById('memberName').textContent = profile.full_name || 'Member';
    document.getElementById('memberEmail').textContent = profile.email || '';
    document.getElementById('memberId').textContent = `ID: ${profile.member_id || '------'}`;

    // Profile photo or initials
    if (profile.photo_url) {
        document.getElementById('profilePhoto').src = profile.photo_url;
        document.getElementById('profilePhoto').classList.remove('hidden');
        document.getElementById('profileInitials').classList.add('hidden');
    } else {
        // Generate initials
        const names = (profile.full_name || 'M M').split(' ');
        const initials = names.map(n => n.charAt(0).toUpperCase()).join('').substring(0, 2);
        document.getElementById('profileInitials').textContent = initials;
    }

    // Member since
    if (profile.join_date) {
        const joinDate = new Date(profile.join_date);
        const options = { month: 'long', year: 'numeric' };
        document.getElementById('memberSince').textContent = joinDate.toLocaleDateString('en-US', options);
    }
}

// Load quick stats
async function loadQuickStats() {
    try {
        // Attendance percentage
        const attendanceResult = await ChurchApp.apiCall('/api/v1/my/attendance?summary=true', 'GET');
        if (attendanceResult.success && attendanceResult.data) {
            const percentage = attendanceResult.data.attendance_percentage || 0;
            document.getElementById('attendancePercentage').textContent = `${Math.round(percentage)}%`;
        }

        // Total contributions
        const contributionsResult = await ChurchApp.apiCall('/api/v1/my/contributions?summary=true', 'GET');
        if (contributionsResult.success && contributionsResult.data) {
            const total = contributionsResult.data.total_contributions || 0;
            document.getElementById('totalContributions').textContent = `GHS ${parseFloat(total).toFixed(0)}`;
        }

        // Total programs
        const programsResult = await ChurchApp.apiCall('/api/v1/my/programs', 'GET');
        if (programsResult.success && programsResult.data) {
            const count = Array.isArray(programsResult.data) ? programsResult.data.length : 0;
            document.getElementById('totalPrograms').textContent = count;
        }
    } catch (error) {
        console.error('Failed to load stats:', error);
        // Keep showing -- on error
    }
}

// Handle logout
async function handleLogout() {
    if (!confirm('Are you sure you want to logout?')) {
        return;
    }

    try {
        ChurchApp.showLoading(true);

        const result = await ChurchApp.apiCall('/api/v1/logout', 'POST');

        if (result.success) {
            // Clear local storage
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user_data');

            ChurchApp.showToast('Logged out successfully', 'success');

            // Redirect to login
            setTimeout(() => {
                window.location.href = '/mobile/login';
            }, 1000);
        } else {
            throw new Error(result.message || 'Logout failed');
        }
    } catch (error) {
        console.error('Logout error:', error);
        ChurchApp.showToast('Failed to logout. Please try again.', 'error');
        ChurchApp.showLoading(false);
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    loadProfile();
});
</script>
@endpush
