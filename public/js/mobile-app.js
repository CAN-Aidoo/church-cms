/**
 * Church CMS Mobile App - Core JavaScript
 * Progressive Web App functionality
 */

class ChurchMobileApp {
    constructor() {
        this.apiBase = window.API_BASE_URL || '/api/v1';
        this.mobileApiBase = window.MOBILE_API_BASE_URL || '/api/mobile/v1';
        this.user = JSON.parse(localStorage.getItem('user') || 'null');
        this.isOnline = navigator.onLine;

        // Prevent redirect loops
        this.isLoginPage = window.location.pathname.includes('/login') || window.location.pathname.includes('/register');

        this.init();
    }

    init() {
        // No need to check auth here - Laravel middleware handles it server-side
        // If user reaches protected pages, they're already authenticated
        // Just refresh user data from localStorage if available
        if (!this.isLoginPage) {
            this.refreshAuth();
        }

        // Hide Splash Screen
        window.addEventListener('load', () => {
            setTimeout(() => {
                const splash = document.getElementById('app-splash');
                if (splash) {
                    splash.style.opacity = '0';
                    setTimeout(() => splash.remove(), 500);
                }
            }, 800); // Short delay for branding
        });

        // Register service worker
        if ('serviceWorker' in navigator) {
            this.registerServiceWorker();
        }

        // Setup online/offline detection
        window.addEventListener('online', () => this.handleOnline());
        window.addEventListener('offline', () => this.handleOffline());

        // Setup CSRF token
        this.setupCsrf();

        // Setup notification permissions
        this.setupNotifications();
    }

    async registerServiceWorker() {
        try {
            const swPath = window.SW_PATH || '/sw.js';
            const registration = await navigator.serviceWorker.register(swPath);
            console.log('Service Worker registered:', registration);

            // Check for updates
            registration.addEventListener('updatefound', () => {
                const newWorker = registration.installing;
                newWorker.addEventListener('statechange', () => {
                    if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                        this.showUpdateNotification();
                    }
                });
            });
        } catch (error) {
            console.error('Service Worker registration failed:', error);
        }
    }

    setupCsrf() {
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        if (token) {
            this.csrfToken = token;
        }
    }

    async setupNotifications() {
        if ('Notification' in window && Notification.permission === 'default') {
            // Don't auto-request, let user trigger it
            console.log('Notifications available but not requested');
        }
    }

    async requestNotificationPermission() {
        if ('Notification' in window) {
            const permission = await Notification.requestPermission();
            if (permission === 'granted') {
                this.showNotification('Notifications Enabled', 'You will now receive important updates');
            }
            return permission;
        }
        return 'denied';
    }

    showNotification(title, message, options = {}) {
        if ('Notification' in window && Notification.permission === 'granted') {
            new Notification(title, {
                body: message,
                icon: '/images/icon-192x192.png',
                badge: '/images/badge-72x72.png',
                ...options
            });
        }
    }

    showUpdateNotification() {
        const updateBanner = document.createElement('div');
        updateBanner.className = 'fixed top-0 left-0 right-0 bg-blue-600 text-white p-4 z-50 shadow-lg';
        updateBanner.innerHTML = `
            <div class="container mx-auto flex justify-between items-center">
                <span>A new version is available!</span>
                <button onclick="window.location.reload()" class="bg-white text-blue-600 px-4 py-2 rounded">
                    Update Now
                </button>
            </div>
        `;
        document.body.prepend(updateBanner);
    }

    handleOnline() {
        this.isOnline = true;
        this.showToast('You are back online', 'success');
        this.syncOfflineData();
    }

    handleOffline() {
        this.isOnline = false;
        this.showToast('You are offline. Some features may be limited.', 'warning');
    }

    async syncOfflineData() {
        // Sync any pending offline data
        console.log('Syncing offline data...');
        // This would sync attendance, payments, etc.
    }

    // API Methods
    async apiCall(endpoint, method = 'GET', data = null, useAuth = true) {
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest', // Important for SPA mode
        };

        // CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (csrfToken) {
            headers['X-CSRF-TOKEN'] = csrfToken;
        }

        // Use session cookies instead of Bearer token
        const options = {
            method,
            headers,
            credentials: 'same-origin', // Important! Include cookies
        };

        if (data && (method === 'POST' || method === 'PUT' || method === 'PATCH')) {
            options.body = JSON.stringify(data);
        }

        try {
            const response = await fetch(endpoint, options);
            const result = await response.json();

            if (!response.ok) {
                if (response.status === 401) {
                    // Don't loop if already on login
                    if (!this.isLoginPage) {
                        this.handleUnauthorized();
                    }
                    // If on login page, just throw error so form handles it (invalid creds)
                }
                throw new Error(result.message || 'Request failed');
            }

            return result;
        } catch (error) {
            if (!this.isOnline) {
                this.showToast('No internet connection', 'error');
            }
            throw error;
        }
    }

    // Authentication
    async login(email, password) {
        try {
            // First, get CSRF cookie
            await fetch('/sanctum/csrf-cookie', { credentials: 'same-origin' });

            // Then login (session-based)
            const result = await this.apiCall(`${this.apiBase}/login-mobile`, 'POST', {
                email,
                password
            }, false);

            if (result.success) {
                this.user = result.data.user;
                localStorage.setItem('user', JSON.stringify(this.user));

                return result;
            }
            throw new Error(result.message);
        } catch (error) {
            throw error;
        }
    }

    async register(data) {
        try {
            const result = await this.apiCall(`${this.mobileApiBase}/register/member`, 'POST', data, false);
            return result;
        } catch (error) {
            throw error;
        }
    }

    async verifyOtp(phone, otp, memberData) {
        try {
            // Get CSRF cookie first
            await fetch('/sanctum/csrf-cookie', { credentials: 'same-origin' });

            const result = await this.apiCall(`${this.mobileApiBase}/verify-otp`, 'POST', {
                phone,
                otp,
                ...memberData
            }, false);

            if (result.success) {
                // Session created server-side, just store user info
                this.user = result.data.user;
                localStorage.setItem('user', JSON.stringify(this.user));
            }

            return result;
        } catch (error) {
            throw error;
        }
    }

    async logout() {
        try {
            // Call server logout
            await this.apiCall(`${this.apiBase}/logout`, 'POST');
        } catch (error) {
            // Ignore errors
        }

        // Clear local data
        this.user = null;
        localStorage.removeItem('user');
        window.location.href = '/mobile/login';
    }

    handleUnauthorized() {
        // DO NOT auto-redirect - Laravel middleware handles this
        // If we get a 401, it means an API call failed, not that we need to redirect the whole page
        // The page itself is already protected by Laravel middleware
        console.log('API call returned 401 - session may have expired');
    }

    isAuthenticated() {
        return !!this.user;
    }

    refreshAuth() {
        this.user = JSON.parse(localStorage.getItem('user') || 'null');
    }

    async checkAuth() {
        // Simple check - Laravel middleware handles actual auth on server
        // This is just for checking if we have user data cached
        return this.isAuthenticated();
    }

    // Check-in methods
    async checkIn(token, type = 'member', additionalData = {}) {
        const endpoint = type === 'family'
            ? `${this.mobileApiBase}/check-in/family`
            : type === 'service'
                ? `${this.mobileApiBase}/check-in/service`
                : `${this.mobileApiBase}/check-in/member`;

        return await this.apiCall(endpoint, 'POST', {
            token,
            ...additionalData
        }, type !== 'member');
    }

    async generatePersonalQr() {
        return await this.apiCall(`${this.mobileApiBase}/qr-code/personal`, 'GET');
    }

    async getMyQRCode() {
        return await this.generatePersonalQr();
    }

    async getFamilyMembers() {
        return await this.apiCall(`${this.apiBase}/my/family`, 'GET');
    }

    async checkInFamily(serviceType, familyMemberIds) {
        return await this.apiCall(`${this.mobileApiBase}/check-in/family`, 'POST', {
            service_type: serviceType,
            member_ids: familyMemberIds
        });
    }

    async getCheckInHistory(limit = 10) {
        return await this.apiCall(`${this.mobileApiBase}/check-in/history?limit=${limit}`, 'GET');
    }

    async getAttendanceStats() {
        return await this.apiCall(`${this.apiBase}/my/attendance`, 'GET');
    }

    // Payment methods
    async initiatePayment(paymentData) {
        return await this.apiCall(`${this.mobileApiBase}/payment/initiate`, 'POST', paymentData);
    }

    async verifyPayment(transactionCode) {
        return await this.apiCall(`${this.mobileApiBase}/payment/verify`, 'POST', {
            transaction_code: transactionCode
        });
    }

    async getPaymentHistory() {
        return await this.apiCall(`${this.mobileApiBase}/payment/history`, 'GET');
    }

    // Content methods
    async getAnnouncements(category = null) {
        const url = category
            ? `${this.mobileApiBase}/announcements?category=${category}`
            : `${this.mobileApiBase}/announcements`;
        return await this.apiCall(url, 'GET', null, false);
    }

    async getServiceTimes(period = 'week') {
        return await this.apiCall(`${this.mobileApiBase}/service-times?period=${period}`, 'GET', null, false);
    }

    async getUpcomingEvents() {
        return await this.apiCall(`${this.mobileApiBase}/events/upcoming`, 'GET', null, false);
    }

    async getChurchInfo() {
        return await this.apiCall(`${this.mobileApiBase}/church-info`, 'GET', null, false);
    }

    // Member portal methods
    async getMyProfile() {
        return await this.apiCall(`${this.apiBase}/my/profile`, 'GET');
    }

    async updateMyProfile(data) {
        return await this.apiCall(`${this.apiBase}/my/profile`, 'PUT', data);
    }

    async getMyAttendance() {
        return await this.apiCall(`${this.apiBase}/my/attendance`, 'GET');
    }

    async getMyContributions() {
        return await this.apiCall(`${this.apiBase}/my/contributions`, 'GET');
    }

    async getGivingStats() {
        return await this.apiCall(`${this.mobileApiBase}/payment/stats`, 'GET');
    }

    // Utility methods
    showToast(message, type = 'info') {
        const toast = document.createElement('div');
        const bgColor = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            warning: 'bg-yellow-500',
            info: 'bg-blue-500'
        }[type] || 'bg-gray-500';

        toast.className = `fixed bottom-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-up`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    showLoading(show = true) {
        let loader = document.getElementById('global-loader');

        if (show) {
            if (!loader) {
                loader = document.createElement('div');
                loader.id = 'global-loader';
                loader.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                loader.innerHTML = `
                    <div class="bg-white rounded-lg p-6">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                        <p class="mt-4 text-gray-700">Loading...</p>
                    </div>
                `;
                document.body.appendChild(loader);
            }
        } else {
            if (loader) {
                loader.remove();
            }
        }
    }

    formatCurrency(amount) {
        return new Intl.NumberFormat('en-GH', {
            style: 'currency',
            currency: 'GHS'
        }).format(amount);
    }

    formatDate(date) {
        return new Intl.DateTimeFormat('en-GH', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        }).format(new Date(date));
    }

    formatDateTime(date) {
        return new Intl.DateTimeFormat('en-GH', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }).format(new Date(date));
    }

    // QR Code Scanner
    async startQRScanner(callback) {
        // This would integrate with a QR scanner library like html5-qrcode
        console.log('QR Scanner would start here');
        // For now, return a mock
        if (callback) {
            callback('mock-qr-token-123456');
        }
    }

    // Get current location
    async getCurrentLocation() {
        return new Promise((resolve, reject) => {
            if ('geolocation' in navigator) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        resolve({
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude
                        });
                    },
                    (error) => {
                        reject(error);
                    }
                );
            } else {
                reject(new Error('Geolocation not supported'));
            }
        });
    }
}

// Initialize app
const app = new ChurchMobileApp();

// Make app globally available
window.ChurchApp = app;

// Add custom CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slide-up {
        from {
            transform: translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    .animate-slide-up {
        animation: slide-up 0.3s ease-out;
    }
`;
document.head.appendChild(style);
