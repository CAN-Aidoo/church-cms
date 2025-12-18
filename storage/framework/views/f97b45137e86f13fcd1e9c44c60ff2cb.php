<?php $__env->startSection('title', 'Home - Church App'); ?>
<?php $__env->startSection('header', 'Welcome'); ?>

<?php $__env->startSection('header-actions'); ?>
<button onclick="requestNotifications()" class="p-2 rounded-full hover:bg-white/10">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
    </svg>
</button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="pb-20">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-4 py-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-semibold" id="greeting">Good morning</h2>
                <p class="text-blue-100" id="userName">Loading...</p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                <span class="text-2xl font-bold" id="userInitials">--</span>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-3 gap-3 mt-4">
            <div class="bg-white/10 rounded-lg p-3 text-center backdrop-blur-sm">
                <p class="text-2xl font-bold" id="attendanceCount">--</p>
                <p class="text-xs text-blue-100">Attendance</p>
            </div>
            <div class="bg-white/10 rounded-lg p-3 text-center backdrop-blur-sm">
                <p class="text-2xl font-bold" id="givingTotal">--</p>
                <p class="text-xs text-blue-100">Given</p>
            </div>
            <div class="bg-white/10 rounded-lg p-3 text-center backdrop-blur-sm">
                <p class="text-2xl font-bold" id="eventCount">--</p>
                <p class="text-xs text-blue-100">Events</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="px-4 py-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 gap-4">
            <a href="/mobile/check-in" class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-900">Check In</h4>
                <p class="text-sm text-gray-500 mt-1">Mark attendance</p>
            </a>

            <a href="/mobile/give" class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-900">Give</h4>
                <p class="text-sm text-gray-500 mt-1">Make donation</p>
            </a>

            <a href="/mobile/qr-code" class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-900">My QR Code</h4>
                <p class="text-sm text-gray-500 mt-1">Personal QR</p>
            </a>

            <a href="/mobile/events" class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-gray-900">Events</h4>
                <p class="text-sm text-gray-500 mt-1">Upcoming programs</p>
            </a>
        </div>
    </div>

    <!-- Announcements -->
    <div class="px-4 py-6 bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Announcements</h3>
            <a href="/mobile/announcements" class="text-blue-600 text-sm font-medium">View All</a>
        </div>
        <div id="announcementsList" class="space-y-3">
            <!-- Loading state -->
            <div class="bg-white rounded-lg shadow p-4 animate-pulse">
                <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                <div class="h-3 bg-gray-200 rounded w-full"></div>
            </div>
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="px-4 py-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Upcoming Events</h3>
            <a href="/mobile/events" class="text-blue-600 text-sm font-medium">View All</a>
        </div>
        <div id="eventsList" class="space-y-3">
            <!-- Loading state -->
            <div class="bg-white rounded-lg shadow p-4 animate-pulse">
                <div class="h-4 bg-gray-200 rounded w-2/3 mb-2"></div>
                <div class="h-3 bg-gray-200 rounded w-1/2"></div>
            </div>
        </div>
    </div>

    <!-- Service Times -->
    <div class="px-4 py-6 bg-gradient-to-br from-blue-50 to-purple-50">
        <h3 class="text-lg font-bold text-gray-900 mb-4">This Week's Services</h3>
        <div id="servicesList" class="space-y-3">
            <!-- Will be populated by JS -->
        </div>
    </div>

    <!-- Install PWA Banner -->
    <div id="installBanner" class="hidden fixed bottom-20 left-4 right-4 bg-blue-600 text-white p-4 rounded-lg shadow-xl z-40">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <h4 class="font-semibold mb-1">Install Church App</h4>
                <p class="text-sm text-blue-100">Add to your home screen for quick access</p>
            </div>
            <button onclick="installPWA()" class="ml-4 bg-white text-blue-600 px-4 py-2 rounded-lg text-sm font-semibold">
                Install
            </button>
        </div>
        <button onclick="dismissInstallBanner()" class="absolute top-2 right-2 text-white/60 hover:text-white">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Set greeting based on time
const hour = new Date().getHours();
let greeting = 'Good evening';
if (hour < 12) greeting = 'Good morning';
else if (hour < 18) greeting = 'Good afternoon';
document.getElementById('greeting').textContent = greeting;

// Load user profile
async function loadProfile() {
    if (!ChurchApp.isAuthenticated()) {
        window.location.href = '/mobile/login';
        return;
    }

    try {
        const result = await ChurchApp.getMyProfile();
        if (result.success) {
            const user = result.member;
            document.getElementById('userName').textContent = user.full_name;

            // Set initials
            const names = user.full_name.split(' ');
            const initials = names.map(n => n[0]).join('').substring(0, 2).toUpperCase();
            document.getElementById('userInitials').textContent = initials;
        }
    } catch (error) {
        console.error('Failed to load profile:', error);
    }
}

// Load quick stats
async function loadStats() {
    try {
        // Attendance count this month
        const attendanceResult = await ChurchApp.getMyAttendance();
        if (attendanceResult.success) {
            document.getElementById('attendanceCount').textContent =
                attendanceResult.data.attendance_this_month || 0;
        }

        // Giving total this year
        const givingResult = await ChurchApp.getMyContributions();
        if (givingResult.success) {
            const total = givingResult.data.total_this_year || 0;
            document.getElementById('givingTotal').textContent =
                ChurchApp.formatCurrency(total).replace('GH₵', 'GHS ');
        }

        // Events count
        const eventsResult = await ChurchApp.getUpcomingEvents();
        if (eventsResult.success) {
            document.getElementById('eventCount').textContent =
                eventsResult.data.summary.this_month || 0;
        }
    } catch (error) {
        console.error('Failed to load stats:', error);
        document.getElementById('attendanceCount').textContent = '--';
        document.getElementById('givingTotal').textContent = '--';
        document.getElementById('eventCount').textContent = '--';
    }
}

// Load announcements
async function loadAnnouncements() {
    try {
        const result = await ChurchApp.getAnnouncements();
        const container = document.getElementById('announcementsList');

        if (result.success && result.data.announcements.length > 0) {
            container.innerHTML = result.data.announcements.slice(0, 3).map(announcement => `
                <div class="bg-white rounded-lg shadow p-4 ${announcement.is_urgent ? 'border-l-4 border-red-500' : ''}">
                    <div class="flex items-start justify-between mb-2">
                        <h4 class="font-semibold text-gray-900 flex-1">${announcement.title}</h4>
                        ${announcement.is_urgent ? '<span class="ml-2 px-2 py-1 bg-red-100 text-red-600 text-xs font-semibold rounded">Urgent</span>' : ''}
                    </div>
                    <p class="text-gray-600 text-sm line-clamp-2">${announcement.content}</p>
                    <p class="text-gray-400 text-xs mt-2">${new Date(announcement.published_at).toLocaleDateString()}</p>
                </div>
            `).join('');
        } else {
            container.innerHTML = '<p class="text-gray-500 text-center py-8">No announcements at this time</p>';
        }
    } catch (error) {
        console.error('Failed to load announcements:', error);
    }
}

// Load upcoming events
async function loadEvents() {
    try {
        const result = await ChurchApp.getUpcomingEvents();
        const container = document.getElementById('eventsList');

        if (result.success && result.data.events.length > 0) {
            container.innerHTML = result.data.events.slice(0, 3).map(event => `
                <a href="/mobile/events/${event.id}" class="block bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-blue-600 font-bold text-sm">${new Date(event.start_date).getDate()}</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">${event.name}</h4>
                            <p class="text-sm text-gray-500 mt-1">
                                ${new Date(event.start_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                            </p>
                            ${event.location ? `<p class="text-xs text-gray-400 mt-1">${event.location}</p>` : ''}
                        </div>
                        ${event.registration.is_open ? '<span class="ml-2 px-2 py-1 bg-green-100 text-green-600 text-xs font-semibold rounded">Open</span>' : ''}
                    </div>
                </a>
            `).join('');
        } else {
            container.innerHTML = '<p class="text-gray-500 text-center py-8">No upcoming events</p>';
        }
    } catch (error) {
        console.error('Failed to load events:', error);
    }
}

// Load service times
async function loadServices() {
    try {
        const result = await ChurchApp.getServiceTimes('week');
        const container = document.getElementById('servicesList');

        if (result.success && result.data.services.length > 0) {
            container.innerHTML = result.data.services.map(service => {
                const isToday = new Date(service.date).toDateString() === new Date().toDateString();
                return `
                    <div class="bg-white rounded-lg shadow p-4 ${isToday ? 'border-l-4 border-blue-600' : ''}">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-gray-900">${service.title}</h4>
                                <p class="text-sm text-gray-500 mt-1">
                                    ${new Date(service.date).toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric' })}
                                </p>
                                <p class="text-sm text-gray-500">${service.time}</p>
                            </div>
                            ${isToday ? '<span class="px-3 py-1 bg-blue-100 text-blue-600 text-xs font-semibold rounded-full">Today</span>' : ''}
                        </div>
                    </div>
                `;
            }).join('');
        } else {
            // Show regular schedule
            container.innerHTML = `
                <div class="bg-white rounded-lg shadow p-4">
                    <h4 class="font-semibold text-gray-900 mb-3">Regular Schedule</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sunday (1st Service)</span>
                            <span class="font-medium">7:00 AM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sunday (2nd Service)</span>
                            <span class="font-medium">9:30 AM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sunday (Evening)</span>
                            <span class="font-medium">5:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Wednesday</span>
                            <span class="font-medium">6:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Friday</span>
                            <span class="font-medium">6:00 PM</span>
                        </div>
                    </div>
                </div>
            `;
        }
    } catch (error) {
        console.error('Failed to load services:', error);
    }
}

// Request notification permission
async function requestNotifications() {
    const permission = await ChurchApp.requestNotificationPermission();
    if (permission === 'granted') {
        ChurchApp.showToast('Notifications enabled!', 'success');
    }
}

// Show install banner if PWA not installed
function showInstallBanner() {
    if (!window.matchMedia('(display-mode: standalone)').matches) {
        const banner = document.getElementById('installBanner');
        const dismissed = localStorage.getItem('install_banner_dismissed');
        if (!dismissed && banner) {
            banner.classList.remove('hidden');
        }
    }
}

function dismissInstallBanner() {
    document.getElementById('installBanner').classList.add('hidden');
    localStorage.setItem('install_banner_dismissed', 'true');
}

// Initialize dashboard
document.addEventListener('DOMContentLoaded', () => {
    loadProfile();
    loadStats();
    loadAnnouncements();
    loadEvents();
    loadServices();

    // Show install banner after 5 seconds
    setTimeout(showInstallBanner, 5000);
});

// Pull to refresh
let startY = 0;
let pullDistance = 0;

document.addEventListener('touchstart', (e) => {
    if (window.scrollY === 0) {
        startY = e.touches[0].pageY;
    }
});

document.addEventListener('touchmove', (e) => {
    if (window.scrollY === 0 && startY > 0) {
        pullDistance = e.touches[0].pageY - startY;
        if (pullDistance > 0) {
            e.preventDefault();
        }
    }
});

document.addEventListener('touchend', () => {
    if (pullDistance > 80) {
        window.location.reload();
    }
    startY = 0;
    pullDistance = 0;
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.mobile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\church-cms-docs\resources\views/mobile/dashboard.blade.php ENDPATH**/ ?>