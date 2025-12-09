@extends('layouts.mobile')

@section('title', 'Church Info - Church App')
@section('header', 'Church Information')

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Church Header -->
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 px-4 py-8">
        <div class="flex flex-col items-center text-center">
            <!-- Church Logo -->
            <div id="churchLogoContainer" class="w-24 h-24 bg-white rounded-full flex items-center justify-center mb-4 shadow-xl overflow-hidden">
                <img id="churchLogo" class="hidden w-full h-full object-contain p-2" alt="Church Logo">
                <svg id="defaultLogo" class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>

            <!-- Church Name -->
            <h1 id="churchName" class="text-3xl font-bold text-white mb-2">Church Name</h1>
            <p id="churchTagline" class="text-blue-100 text-sm">A place of worship and fellowship</p>
        </div>
    </div>

    <!-- Quick Contact Actions -->
    <div class="px-4 -mt-6 mb-6">
        <div class="bg-white rounded-xl shadow-xl p-4">
            <div class="grid grid-cols-3 gap-3">
                <!-- Call -->
                <button id="callBtn" onclick="callChurch()" class="flex flex-col items-center p-3 rounded-lg hover:bg-gray-50 transition">
                    <div class="bg-green-100 rounded-full p-3 mb-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-700">Call</span>
                </button>

                <!-- Email -->
                <button id="emailBtn" onclick="emailChurch()" class="flex flex-col items-center p-3 rounded-lg hover:bg-gray-50 transition">
                    <div class="bg-blue-100 rounded-full p-3 mb-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-700">Email</span>
                </button>

                <!-- Directions -->
                <button onclick="getDirections()" class="flex flex-col items-center p-3 rounded-lg hover:bg-gray-50 transition">
                    <div class="bg-purple-100 rounded-full p-3 mb-2">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-700">Directions</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Service Times -->
    <div class="px-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Service Times
            </h2>
            <div id="serviceTimesList" class="space-y-3">
                <!-- Loading state -->
                <div class="text-center py-4 text-gray-500">
                    <div class="animate-pulse">Loading service times...</div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div id="aboutSection" class="px-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                About Us
            </h2>
            <p id="aboutText" class="text-gray-700 leading-relaxed">Loading...</p>
        </div>
    </div>

    <!-- Vision & Mission -->
    <div id="visionMissionSection" class="hidden px-4 mb-6 space-y-4">
        <!-- Vision -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
            <h3 class="text-md font-bold text-blue-900 mb-2 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                </svg>
                Our Vision
            </h3>
            <p id="visionText" class="text-blue-800">Loading...</p>
        </div>

        <!-- Mission -->
        <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
            <h3 class="text-md font-bold text-purple-900 mb-2 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                </svg>
                Our Mission
            </h3>
            <p id="missionText" class="text-purple-800">Loading...</p>
        </div>
    </div>

    <!-- Leadership -->
    <div id="leadershipSection" class="hidden px-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Leadership
            </h2>
            <div id="leadershipList" class="space-y-4">
                <!-- Dynamic leadership cards -->
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="px-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Contact Information
            </h2>

            <div class="space-y-4">
                <!-- Phone -->
                <div id="phoneSection" class="flex items-start">
                    <div class="bg-green-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Phone</p>
                        <a id="churchPhone" href="#" class="font-semibold text-gray-900 hover:text-blue-600">Loading...</a>
                    </div>
                </div>

                <!-- Email -->
                <div id="emailSection" class="flex items-start">
                    <div class="bg-blue-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <a id="churchEmail" href="#" class="font-semibold text-gray-900 hover:text-blue-600">Loading...</a>
                    </div>
                </div>

                <!-- Address -->
                <div id="addressSection" class="flex items-start">
                    <div class="bg-purple-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Address</p>
                        <p id="churchAddress" class="font-semibold text-gray-900">Loading...</p>
                    </div>
                </div>

                <!-- Website -->
                <div id="websiteSection" class="hidden flex items-start">
                    <div class="bg-orange-100 rounded-lg p-2 mr-3">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Website</p>
                        <a id="churchWebsite" href="#" target="_blank" class="font-semibold text-blue-600 hover:underline">Loading...</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Social Media -->
    <div id="socialMediaSection" class="hidden px-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Connect With Us</h2>
            <div id="socialMediaList" class="grid grid-cols-4 gap-3">
                <!-- Dynamic social media buttons -->
            </div>
        </div>
    </div>

    <!-- Map -->
    <div id="mapSection" class="hidden px-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="h-64 bg-gray-200 relative">
                <iframe id="mapFrame" class="w-full h-full" frameborder="0" style="border:0"></iframe>
            </div>
            <div class="p-4">
                <button onclick="getDirections()" class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    Get Directions
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let churchInfo = null;

// Load church information
async function loadChurchInfo() {
    try {
        ChurchApp.showLoading(true);

        const result = await ChurchApp.apiCall('/api/mobile/v1/church-info', 'GET');

        if (result.success && result.data) {
            churchInfo = result.data;
            renderChurchInfo(churchInfo);
        }

        // Load service times
        await loadServiceTimes();

        ChurchApp.showLoading(false);
    } catch (error) {
        console.error('Failed to load church info:', error);
        ChurchApp.showToast('Failed to load church information', 'error');
        ChurchApp.showLoading(false);
    }
}

// Render church information
function renderChurchInfo(info) {
    // Church header
    document.getElementById('churchName').textContent = info.name || 'Church Name';
    document.getElementById('churchTagline').textContent = info.tagline || '';

    if (info.logo_url) {
        document.getElementById('churchLogo').src = info.logo_url;
        document.getElementById('churchLogo').classList.remove('hidden');
        document.getElementById('defaultLogo').classList.add('hidden');
    }

    // About section
    if (info.about) {
        document.getElementById('aboutText').textContent = info.about;
    }

    // Vision & Mission
    if (info.vision || info.mission) {
        document.getElementById('visionMissionSection').classList.remove('hidden');
        if (info.vision) {
            document.getElementById('visionText').textContent = info.vision;
        }
        if (info.mission) {
            document.getElementById('missionText').textContent = info.mission;
        }
    }

    // Contact information
    if (info.phone) {
        document.getElementById('churchPhone').textContent = info.phone;
        document.getElementById('churchPhone').href = `tel:${info.phone}`;
    }

    if (info.email) {
        document.getElementById('churchEmail').textContent = info.email;
        document.getElementById('churchEmail').href = `mailto:${info.email}`;
    }

    if (info.address) {
        document.getElementById('churchAddress').textContent = info.address;
    }

    if (info.website) {
        document.getElementById('websiteSection').classList.remove('hidden');
        document.getElementById('churchWebsite').textContent = info.website;
        document.getElementById('churchWebsite').href = info.website;
    }

    // Leadership
    if (info.leadership && info.leadership.length > 0) {
        document.getElementById('leadershipSection').classList.remove('hidden');
        renderLeadership(info.leadership);
    }

    // Social media
    if (info.social_media && Object.keys(info.social_media).length > 0) {
        document.getElementById('socialMediaSection').classList.remove('hidden');
        renderSocialMedia(info.social_media);
    }

    // Map
    if (info.latitude && info.longitude) {
        document.getElementById('mapSection').classList.remove('hidden');
        loadMap(info.latitude, info.longitude);
    }
}

// Load service times
async function loadServiceTimes() {
    try {
        const result = await ChurchApp.apiCall('/api/mobile/v1/service-times', 'GET');

        if (result.success && result.data && result.data.length > 0) {
            renderServiceTimes(result.data);
        } else {
            document.getElementById('serviceTimesList').innerHTML = '<p class="text-center text-gray-500 py-4">No service times available</p>';
        }
    } catch (error) {
        console.error('Failed to load service times:', error);
        document.getElementById('serviceTimesList').innerHTML = '<p class="text-center text-gray-500 py-4">Failed to load service times</p>';
    }
}

// Render service times
function renderServiceTimes(services) {
    const html = services.map(service => {
        const dayColors = {
            'Sunday': 'bg-blue-100 text-blue-800',
            'Monday': 'bg-green-100 text-green-800',
            'Tuesday': 'bg-purple-100 text-purple-800',
            'Wednesday': 'bg-yellow-100 text-yellow-800',
            'Thursday': 'bg-pink-100 text-pink-800',
            'Friday': 'bg-indigo-100 text-indigo-800',
            'Saturday': 'bg-red-100 text-red-800'
        };

        return `
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-900">${service.name}</h4>
                    <p class="text-sm text-gray-600">${service.description || ''}</p>
                </div>
                <div class="text-right ml-4">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold ${dayColors[service.day] || 'bg-gray-100 text-gray-800'} mb-1">
                        ${service.day}
                    </span>
                    <p class="text-sm font-bold text-gray-900">${service.time}</p>
                </div>
            </div>
        `;
    }).join('');

    document.getElementById('serviceTimesList').innerHTML = html;
}

// Render leadership
function renderLeadership(leaders) {
    const html = leaders.map(leader => `
        <div class="flex items-start">
            <img src="${leader.photo_url || '/images/default-avatar.png'}" alt="${leader.name}" class="w-16 h-16 rounded-full object-cover mr-4">
            <div class="flex-1">
                <h4 class="font-bold text-gray-900">${leader.name}</h4>
                <p class="text-sm text-blue-600 font-semibold">${leader.position}</p>
                ${leader.bio ? `<p class="text-sm text-gray-600 mt-1">${leader.bio}</p>` : ''}
            </div>
        </div>
    `).join('');

    document.getElementById('leadershipList').innerHTML = html;
}

// Render social media
function renderSocialMedia(social) {
    const icons = {
        facebook: { icon: 'M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z', color: 'bg-blue-600' },
        twitter: { icon: 'M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z', color: 'bg-blue-400' },
        instagram: { icon: 'M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01', color: 'bg-pink-600' },
        youtube: { icon: 'M22.54 6.42a2.78 2.78 0 00-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 00-1.94 2A29 29 0 001 11.75a29 29 0 00.46 5.33A2.78 2.78 0 003.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 001.94-2 29 29 0 00.46-5.25 29 29 0 00-.46-5.33z', color: 'bg-red-600' },
        whatsapp: { icon: 'M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z', color: 'bg-green-600' }
    };

    const html = Object.keys(social).map(platform => {
        if (!social[platform]) return '';
        const iconData = icons[platform] || icons.facebook;

        return `
            <a href="${social[platform]}" target="_blank" class="${iconData.color} text-white rounded-lg p-4 flex items-center justify-center hover:opacity-90 transition">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="${iconData.icon}"/>
                </svg>
            </a>
        `;
    }).join('');

    document.getElementById('socialMediaList').innerHTML = html;
}

// Load map
function loadMap(lat, lng) {
    const mapFrame = document.getElementById('mapFrame');
    mapFrame.src = `https://maps.google.com/maps?q=${lat},${lng}&t=&z=15&ie=UTF8&iwloc=&output=embed`;
}

// Call church
function callChurch() {
    if (churchInfo && churchInfo.phone) {
        window.location.href = `tel:${churchInfo.phone}`;
    }
}

// Email church
function emailChurch() {
    if (churchInfo && churchInfo.email) {
        window.location.href = `mailto:${churchInfo.email}`;
    }
}

// Get directions
function getDirections() {
    if (churchInfo && churchInfo.latitude && churchInfo.longitude) {
        const url = `https://www.google.com/maps/dir/?api=1&destination=${churchInfo.latitude},${churchInfo.longitude}`;
        window.open(url, '_blank');
    } else if (churchInfo && churchInfo.address) {
        const url = `https://www.google.com/maps/dir/?api=1&destination=${encodeURIComponent(churchInfo.address)}`;
        window.open(url, '_blank');
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    loadChurchInfo();
});
</script>
@endpush
