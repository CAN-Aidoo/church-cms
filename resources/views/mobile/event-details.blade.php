@extends('layouts.mobile')

@section('title', 'Event Details - Church App')
@section('header', 'Event Details')

@section('header-actions')
<button onclick="shareEvent()" class="p-2 rounded-full hover:bg-white/10">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
    </svg>
</button>
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    <!-- Event Banner -->
    <div id="bannerSection" class="relative h-64 bg-gradient-to-br from-blue-600 to-blue-700">
        <img id="bannerImage" class="hidden w-full h-full object-cover" alt="Event banner">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

        <!-- Featured Badge -->
        <div id="featuredBadge" class="hidden absolute top-4 right-4">
            <span class="bg-yellow-400 text-yellow-900 px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                ⭐ Featured Event
            </span>
        </div>

        <!-- Countdown Timer -->
        <div id="countdownSection" class="hidden absolute bottom-4 left-4 right-4">
            <div class="bg-white/95 backdrop-blur rounded-xl p-4 shadow-xl">
                <p class="text-xs text-gray-600 mb-2 text-center">Event starts in:</p>
                <div class="grid grid-cols-4 gap-2 text-center">
                    <div>
                        <p id="countdownDays" class="text-2xl font-bold text-blue-600">0</p>
                        <p class="text-xs text-gray-600">Days</p>
                    </div>
                    <div>
                        <p id="countdownHours" class="text-2xl font-bold text-blue-600">0</p>
                        <p class="text-xs text-gray-600">Hours</p>
                    </div>
                    <div>
                        <p id="countdownMinutes" class="text-2xl font-bold text-blue-600">0</p>
                        <p class="text-xs text-gray-600">Mins</p>
                    </div>
                    <div>
                        <p id="countdownSeconds" class="text-2xl font-bold text-blue-600">0</p>
                        <p class="text-xs text-gray-600">Secs</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Info -->
    <div class="px-4 -mt-4">
        <div class="bg-white rounded-xl shadow-xl p-6">
            <!-- Category & Status -->
            <div class="flex items-center justify-between mb-4">
                <span id="categoryBadge" class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                    Category
                </span>
                <span id="statusBadge" class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                    Upcoming
                </span>
            </div>

            <!-- Title -->
            <h1 id="eventTitle" class="text-2xl font-bold text-gray-900 mb-3">Event Title</h1>

            <!-- Description -->
            <p id="eventDescription" class="text-gray-700 mb-6 leading-relaxed">Event description...</p>

            <!-- Key Details Grid -->
            <div class="grid grid-cols-1 gap-4 mb-6">
                <!-- Date & Time -->
                <div class="flex items-start">
                    <div class="bg-blue-100 rounded-lg p-3 mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-600">Date & Time</p>
                        <p id="eventDateTime" class="font-semibold text-gray-900">Loading...</p>
                    </div>
                </div>

                <!-- Location -->
                <div id="locationSection" class="flex items-start">
                    <div class="bg-green-100 rounded-lg p-3 mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-600">Location</p>
                        <p id="eventLocation" class="font-semibold text-gray-900">Loading...</p>
                        <button id="getDirectionsBtn" class="hidden text-blue-600 text-sm mt-1 font-medium hover:underline">
                            Get Directions →
                        </button>
                    </div>
                </div>

                <!-- Capacity -->
                <div id="capacitySection" class="flex items-start">
                    <div class="bg-purple-100 rounded-lg p-3 mr-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-600">Capacity</p>
                        <div class="flex items-center">
                            <p id="eventCapacity" class="font-semibold text-gray-900">Loading...</p>
                            <span id="spotsLeftBadge" class="hidden ml-2 text-orange-600 text-sm font-semibold"></span>
                        </div>
                        <div id="capacityProgress" class="hidden mt-2 bg-gray-200 rounded-full h-2">
                            <div id="capacityBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                    </div>
                </div>

                <!-- Cost -->
                <div id="costSection" class="hidden flex items-start">
                    <div class="bg-yellow-100 rounded-lg p-3 mr-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-600">Registration Fee</p>
                        <p id="eventCost" class="font-semibold text-gray-900">Loading...</p>
                    </div>
                </div>

                <!-- Organizer -->
                <div id="organizerSection" class="flex items-start">
                    <div class="bg-pink-100 rounded-lg p-3 mr-4">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-600">Organizer</p>
                        <p id="eventOrganizer" class="font-semibold text-gray-900">Loading...</p>
                        <p id="organizerContact" class="text-sm text-gray-600 mt-1"></p>
                    </div>
                </div>
            </div>

            <!-- Requirements/Notes -->
            <div id="requirementsSection" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-semibold text-blue-900 mb-2">Important Information</p>
                        <p id="eventRequirements" class="text-sm text-blue-800"></p>
                    </div>
                </div>
            </div>

            <!-- Registration Button -->
            <div id="registrationSection">
                <!-- Will be populated dynamically -->
            </div>
        </div>
    </div>

    <!-- Agenda/Schedule -->
    <div id="agendaSection" class="hidden px-4 mt-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Event Schedule
            </h2>
            <div id="agendaList" class="space-y-3">
                <!-- Dynamic agenda items -->
            </div>
        </div>
    </div>

    <!-- Speakers/Facilitators -->
    <div id="speakersSection" class="hidden px-4 mt-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                </svg>
                Speakers & Facilitators
            </h2>
            <div id="speakersList" class="space-y-4">
                <!-- Dynamic speaker cards -->
            </div>
        </div>
    </div>

    <!-- Map -->
    <div id="mapSection" class="hidden px-4 mt-6 mb-6">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="h-64 bg-gray-200 relative">
                <iframe id="mapFrame" class="w-full h-full" frameborder="0" style="border:0"></iframe>
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent pointer-events-none"></div>
            </div>
            <div class="p-4">
                <button onclick="openInMaps()" class="w-full bg-green-600 text-white font-semibold py-3 rounded-lg hover:bg-green-700 transition flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    Open in Maps
                </button>
            </div>
        </div>
    </div>

    <!-- Fixed Bottom Action Bar -->
    <div id="bottomActionBar" class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-xl z-20">
        <div id="bottomActions">
            <!-- Will be populated dynamically -->
        </div>
    </div>
</div>

<!-- Registration Success Modal -->
<div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-sm w-full p-6 text-center">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Registration Successful!</h3>
        <p class="text-gray-600 mb-6">You've been registered for this event. Check your email for confirmation.</p>
        <button onclick="closeSuccessModal()" class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition">
            Done
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
const eventId = window.location.pathname.split('/').pop();
let eventData = null;
let countdownInterval = null;

// Load event details
async function loadEventDetails() {
    try {
        const result = await ChurchApp.apiCall(`/api/mobile/v1/events/${eventId}`, 'GET');

        if (result.success && result.data) {
            eventData = result.data;
            renderEventDetails(eventData);

            // Start countdown if upcoming
            if (eventData.status === 'upcoming' || eventData.status === 'published') {
                startCountdown(new Date(eventData.start_date));
            }
        } else {
            ChurchApp.showToast('Event not found', 'error');
            setTimeout(() => {
                window.location.href = '{{ url('/mobile/events') }}';
            }, 2000);
        }
    } catch (error) {
        console.error('Failed to load event:', error);
        ChurchApp.showToast('Failed to load event details', 'error');
    }
}

// Render event details
function renderEventDetails(event) {
    // Banner
    if (event.banner_url) {
        document.getElementById('bannerImage').src = event.banner_url;
        document.getElementById('bannerImage').classList.remove('hidden');
    }

    // Featured badge
    if (event.is_featured) {
        document.getElementById('featuredBadge').classList.remove('hidden');
    }

    // Category badge
    const categoryColors = {
        service: 'bg-blue-100 text-blue-800 border-blue-200',
        conference: 'bg-purple-100 text-purple-800 border-purple-200',
        seminar: 'bg-green-100 text-green-800 border-green-200',
        fellowship: 'bg-yellow-100 text-yellow-800 border-yellow-200',
        outreach: 'bg-pink-100 text-pink-800 border-pink-200'
    };
    const categoryBadge = document.getElementById('categoryBadge');
    categoryBadge.textContent = event.category_label || event.category;
    categoryBadge.className = `px-3 py-1 rounded-full text-sm font-semibold border ${categoryColors[event.category] || 'bg-gray-100 text-gray-800 border-gray-200'}`;

    // Status badge
    const statusColors = {
        upcoming: 'bg-green-100 text-green-800',
        ongoing: 'bg-blue-100 text-blue-800',
        completed: 'bg-gray-100 text-gray-800',
        cancelled: 'bg-red-100 text-red-800'
    };
    const statusBadge = document.getElementById('statusBadge');
    statusBadge.textContent = event.status_label || event.status;
    statusBadge.className = `px-3 py-1 rounded-full text-xs font-semibold ${statusColors[event.status] || 'bg-gray-100 text-gray-800'}`;

    // Title & Description
    document.getElementById('eventTitle').textContent = event.title;
    document.getElementById('eventDescription').textContent = event.description || 'No description available.';

    // Date & Time
    const startDate = new Date(event.start_date);
    const endDate = event.end_date ? new Date(event.end_date) : null;
    const dateStr = startDate.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });
    const timeStr = startDate.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
    const endTimeStr = endDate ? ' - ' + endDate.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }) : '';
    document.getElementById('eventDateTime').textContent = `${dateStr} at ${timeStr}${endTimeStr}`;

    // Location
    if (event.location) {
        document.getElementById('eventLocation').textContent = event.location;
        if (event.location_lat && event.location_lng) {
            document.getElementById('getDirectionsBtn').classList.remove('hidden');
            document.getElementById('mapSection').classList.remove('hidden');
            loadMap(event.location_lat, event.location_lng, event.location);
        }
    }

    // Capacity
    if (event.max_participants) {
        const registered = event.registered_count || 0;
        const max = event.max_participants;
        const spotsLeft = max - registered;
        const percentage = (registered / max) * 100;

        document.getElementById('eventCapacity').textContent = `${registered} / ${max} registered`;
        document.getElementById('capacityProgress').classList.remove('hidden');
        document.getElementById('capacityBar').style.width = `${percentage}%`;

        if (spotsLeft <= 10 && spotsLeft > 0) {
            const spotsLeftBadge = document.getElementById('spotsLeftBadge');
            spotsLeftBadge.textContent = `(${spotsLeft} spots left!)`;
            spotsLeftBadge.classList.remove('hidden');
        }
    } else {
        document.getElementById('eventCapacity').textContent = `${event.registered_count || 0} registered`;
    }

    // Cost
    if (event.registration_fee && parseFloat(event.registration_fee) > 0) {
        document.getElementById('costSection').classList.remove('hidden');
        document.getElementById('eventCost').textContent = `GHS ${parseFloat(event.registration_fee).toFixed(2)}`;
    }

    // Organizer
    document.getElementById('eventOrganizer').textContent = event.organizer_name || 'Church Admin';
    if (event.organizer_contact) {
        document.getElementById('organizerContact').textContent = event.organizer_contact;
    }

    // Requirements
    if (event.requirements) {
        document.getElementById('requirementsSection').classList.remove('hidden');
        document.getElementById('eventRequirements').textContent = event.requirements;
    }

    // Agenda
    if (event.agenda && event.agenda.length > 0) {
        document.getElementById('agendaSection').classList.remove('hidden');
        const agendaHTML = event.agenda.map((item, index) => `
            <div class="flex">
                <div class="flex-shrink-0 w-16 text-sm font-semibold text-gray-600">${item.time}</div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-900">${item.title}</p>
                    ${item.description ? `<p class="text-sm text-gray-600 mt-1">${item.description}</p>` : ''}
                </div>
            </div>
        `).join('');
        document.getElementById('agendaList').innerHTML = agendaHTML;
    }

    // Speakers
    if (event.speakers && event.speakers.length > 0) {
        document.getElementById('speakersSection').classList.remove('hidden');
        const speakersHTML = event.speakers.map(speaker => `
            <div class="flex items-start">
                <img src="${speaker.photo_url || '/images/default-avatar.png'}" alt="${speaker.name}" class="w-16 h-16 rounded-full object-cover mr-4">
                <div class="flex-1">
                    <p class="font-bold text-gray-900">${speaker.name}</p>
                    <p class="text-sm text-gray-600">${speaker.title || ''}</p>
                    ${speaker.bio ? `<p class="text-sm text-gray-700 mt-2">${speaker.bio}</p>` : ''}
                </div>
            </div>
        `).join('');
        document.getElementById('speakersList').innerHTML = speakersHTML;
    }

    // Registration button
    renderRegistrationButton(event);
}

// Render registration button
function renderRegistrationButton(event) {
    const section = document.getElementById('registrationSection');
    const bottomActions = document.getElementById('bottomActions');

    const isRegistered = event.is_registered || false;
    const isFull = event.is_full || false;
    const isPast = event.status === 'completed';
    const isCancelled = event.status === 'cancelled';

    let html = '';
    let bottomHtml = '';

    if (isCancelled) {
        html = '<div class="bg-red-50 text-red-700 px-4 py-3 rounded-lg text-center font-semibold">Event Cancelled</div>';
    } else if (isPast) {
        html = '<div class="bg-gray-100 text-gray-700 px-4 py-3 rounded-lg text-center font-semibold">Event Ended</div>';
    } else if (isRegistered) {
        html = `
            <div class="bg-green-50 border-2 border-green-200 rounded-lg p-4">
                <div class="flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-green-800 font-bold text-lg">You're Registered!</span>
                </div>
                <button onclick="viewRegistration()" class="w-full bg-green-600 text-white font-semibold py-3 rounded-lg hover:bg-green-700 transition">
                    View My Registration
                </button>
            </div>
        `;
        bottomHtml = `
            <button onclick="viewRegistration()" class="w-full bg-green-600 text-white font-semibold py-3 rounded-lg hover:bg-green-700 transition">
                View Registration
            </button>
        `;
    } else if (isFull) {
        html = '<div class="bg-orange-50 border-2 border-orange-200 text-orange-700 px-4 py-3 rounded-lg text-center font-semibold">Event Full - Join Waitlist</div>';
        bottomHtml = `
            <button onclick="joinWaitlist()" class="w-full bg-orange-600 text-white font-semibold py-3 rounded-lg hover:bg-orange-700 transition">
                Join Waitlist
            </button>
        `;
    } else {
        html = `
            <button onclick="registerForEvent()" class="w-full bg-blue-600 text-white font-semibold py-4 rounded-lg hover:bg-blue-700 transition shadow-lg">
                Register for Event
            </button>
        `;
        bottomHtml = html;
    }

    section.innerHTML = html;
    bottomActions.innerHTML = bottomHtml;
}

// Start countdown timer
function startCountdown(targetDate) {
    document.getElementById('countdownSection').classList.remove('hidden');

    countdownInterval = setInterval(() => {
        const now = new Date().getTime();
        const distance = targetDate.getTime() - now;

        if (distance < 0) {
            clearInterval(countdownInterval);
            document.getElementById('countdownSection').classList.add('hidden');
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('countdownDays').textContent = days;
        document.getElementById('countdownHours').textContent = hours;
        document.getElementById('countdownMinutes').textContent = minutes;
        document.getElementById('countdownSeconds').textContent = seconds;
    }, 1000);
}

// Load map
function loadMap(lat, lng, location) {
    const mapFrame = document.getElementById('mapFrame');
    mapFrame.src = `https://maps.google.com/maps?q=${lat},${lng}&t=&z=15&ie=UTF8&iwloc=&output=embed`;
}

// Open in maps app
function openInMaps() {
    if (!eventData || !eventData.location_lat || !eventData.location_lng) return;

    const url = `https://www.google.com/maps/dir/?api=1&destination=${eventData.location_lat},${eventData.location_lng}`;
    window.open(url, '_blank');
}

// Register for event
async function registerForEvent() {
    window.location.href = `/mobile/events/${eventId}/register`;
}

// View registration
function viewRegistration() {
    window.location.href = `/mobile/my-registrations`;
}

// Join waitlist
async function joinWaitlist() {
    if (!confirm('Join the waitlist for this event? You\'ll be notified if spots become available.')) {
        return;
    }

    ChurchApp.showLoading(true);

    try {
        const result = await ChurchApp.apiCall(`/api/mobile/v1/events/${eventId}/waitlist`, 'POST');

        if (result.success) {
            ChurchApp.showToast('Added to waitlist successfully', 'success');
            loadEventDetails(); // Reload to update UI
        } else {
            throw new Error(result.message || 'Failed to join waitlist');
        }
    } catch (error) {
        console.error('Waitlist error:', error);
        ChurchApp.showToast(error.message || 'Failed to join waitlist', 'error');
    } finally {
        ChurchApp.showLoading(false);
    }
}

// Share event
async function shareEvent() {
    if (!eventData) return;

    const shareData = {
        title: eventData.title,
        text: `${eventData.title}\n${eventData.description || ''}\n\nDate: ${new Date(eventData.start_date).toLocaleDateString()}`,
        url: window.location.href
    };

    try {
        if (navigator.share) {
            await navigator.share(shareData);
        } else {
            await navigator.clipboard.writeText(window.location.href);
            ChurchApp.showToast('Event link copied to clipboard', 'success');
        }
    } catch (error) {
        if (error.name !== 'AbortError') {
            console.error('Share error:', error);
        }
    }
}

// Close success modal
function closeSuccessModal() {
    document.getElementById('successModal').classList.add('hidden');
    loadEventDetails(); // Reload to show registered state
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    loadEventDetails();
});

// Cleanup on page unload
window.addEventListener('beforeunload', () => {
    if (countdownInterval) {
        clearInterval(countdownInterval);
    }
});
</script>
@endpush
