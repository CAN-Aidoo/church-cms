/**
 * Church CMS Mobile App - Core JavaScript
 * Progressive Web App functionality
 */

class ChurchMobileApp {
    constructor() {
        this.apiBase = window.API_BASE_URL || '/api/v1';
        this.mobileApiBase = window.MOBILE_API_BASE_URL || '/api/mobile/v1';
        this.token = localStorage.getItem('auth_token');
        this.user = JSON.parse(localStorage.getItem('user') || 'null');
        this.isOnline = navigator.onLine;

        this.init();
    }

    init() {
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
        };

        if (this.csrfToken) {
            headers['X-CSRF-TOKEN'] = this.csrfToken;
        }

        if (useAuth && this.token) {
            headers['Authorization'] = `Bearer ${this.token}`;
        }

        const options = {
            method,
            headers,
        };

        if (data && (method === 'POST' || method === 'PUT' || method === 'PATCH')) {
            options.body = JSON.stringify(data);
        }

        try {
            const response = await fetch(endpoint, options);
            const result = await response.json();

            if (!response.ok) {
                if (response.status === 401) {
                    this.handleUnauthorized();
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
            const result = await this.apiCall(`${this.apiBase}/login`, 'POST', {
                email,
                password
            }, false);

            if (result.success) {
                this.token = result.data.access_token;
                this.user = result.data.user;

                localStorage.setItem('auth_token', this.token);
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
            const result = await this.apiCall(`${this.mobileApiBase}/verify-otp`, 'POST', {
                phone,
                otp,
                ...memberData
            }, false);

            if (result.success) {
                this.token = result.data.access_token;
                this.user = result.data.user;

                localStorage.setItem('auth_token', this.token);
                localStorage.setItem('user', JSON.stringify(this.user));
            }

            return result;
        } catch (error) {
            throw error;
        }
    }

    logout() {
        this.token = null;
        this.user = null;
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user');
        window.location.href = '/mobile/login';
    }

    handleUnauthorized() {
        this.logout();
    }

    isAuthenticated() {
        return !!this.token && !!this.user;
    }

    refreshAuth() {
        this.token = localStorage.getItem('auth_token');
        this.user = JSON.parse(localStorage.getItem('user') || 'null');
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
