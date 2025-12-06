/**
 * Real-time Updates using Laravel Echo
 *
 * This module handles all real-time WebSocket connections for the Church CMS
 */

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Initialize Laravel Echo
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY || 'local-key',
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER || 'mt1',
    wsHost: import.meta.env.VITE_PUSHER_HOST || window.location.hostname,
    wsPort: import.meta.env.VITE_PUSHER_PORT || 6001,
    wssPort: import.meta.env.VITE_PUSHER_PORT || 6001,
    forceTLS: import.meta.env.VITE_PUSHER_SCHEME === 'https',
    enabledTransports: ['ws', 'wss'],
    disableStats: true,
});

/**
 * Real-time Attendance Updates
 */
export const AttendanceRealtime = {
    /**
     * Listen for new attendance records
     */
    listen(callback) {
        window.Echo.channel('attendance')
            .listen('.attendance.recorded', (data) => {
                callback(data);
            });
    },

    /**
     * Listen for attendance on a specific date
     */
    listenForDate(date, callback) {
        window.Echo.channel(`attendance.${date}`)
            .listen('.attendance.recorded', (data) => {
                callback(data);
            });
    },

    /**
     * Stop listening
     */
    stopListening() {
        window.Echo.leave('attendance');
    },
};

/**
 * Real-time Member Updates
 */
export const MemberRealtime = {
    /**
     * Listen for new member registrations
     */
    listen(callback) {
        window.Echo.channel('members')
            .listen('.member.registered', (data) => {
                callback(data);
            });
    },

    /**
     * Stop listening
     */
    stopListening() {
        window.Echo.leave('members');
    },
};

/**
 * Real-time Transaction Updates
 */
export const TransactionRealtime = {
    /**
     * Listen for new transactions
     */
    listen(callback) {
        window.Echo.channel('transactions')
            .listen('.transaction.created', (data) => {
                callback(data);
            });
    },

    /**
     * Stop listening
     */
    stopListening() {
        window.Echo.leave('transactions');
    },
};

/**
 * Real-time Dashboard for Staff
 */
export const StaffDashboardRealtime = {
    /**
     * Join the staff presence channel
     */
    join() {
        window.Echo.join('staff-dashboard')
            .here((users) => {
                console.log('Staff online:', users);
            })
            .joining((user) => {
                console.log('Staff joined:', user.name);
            })
            .leaving((user) => {
                console.log('Staff left:', user.name);
            })
            .listen('.attendance.recorded', (data) => {
                this.onAttendance(data);
            });
    },

    /**
     * Leave the staff presence channel
     */
    leave() {
        window.Echo.leave('staff-dashboard');
    },

    /**
     * Handle attendance event
     */
    onAttendance(data) {
        // Update attendance count
        this.updateAttendanceCount();

        // Show notification
        this.showNotification('New Check-in', `${data.member_name} checked in`);

        // Update attendance list if visible
        this.updateAttendanceList(data);
    },

    /**
     * Update attendance count in UI
     */
    updateAttendanceCount() {
        const countElement = document.getElementById('attendanceCount');
        if (countElement) {
            const currentCount = parseInt(countElement.textContent);
            countElement.textContent = currentCount + 1;

            // Animate the update
            countElement.classList.add('pulse-animation');
            setTimeout(() => {
                countElement.classList.remove('pulse-animation');
            }, 1000);
        }
    },

    /**
     * Show browser notification
     */
    showNotification(title, body) {
        if ('Notification' in window && Notification.permission === 'granted') {
            new Notification(title, {
                body,
                icon: '/images/church-icon.png',
            });
        }
    },

    /**
     * Update attendance list
     */
    updateAttendanceList(data) {
        const list = document.getElementById('attendanceList');
        if (list) {
            const item = document.createElement('div');
            item.className = 'attendance-item new-item';
            item.innerHTML = `
                <div class="flex items-center justify-between p-3 bg-green-50 border-l-4 border-green-500 rounded">
                    <div>
                        <p class="font-semibold text-gray-800">${data.member_name}</p>
                        <p class="text-sm text-gray-600">${data.check_in_time}</p>
                    </div>
                    <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded">
                        ${data.check_in_method.replace('_', ' ')}
                    </span>
                </div>
            `;
            list.prepend(item);

            // Fade in animation
            setTimeout(() => {
                item.classList.remove('new-item');
            }, 100);
        }
    },
};

/**
 * Real-time Dashboard for Admin
 */
export const AdminDashboardRealtime = {
    /**
     * Join the admin presence channel
     */
    join() {
        window.Echo.join('admin-dashboard')
            .here((users) => {
                console.log('Admins online:', users);
                this.updateOnlineAdmins(users);
            })
            .joining((user) => {
                console.log('Admin joined:', user.name);
                this.addOnlineAdmin(user);
            })
            .leaving((user) => {
                console.log('Admin left:', user.name);
                this.removeOnlineAdmin(user);
            })
            .listen('.member.registered', (data) => {
                this.onMemberRegistered(data);
            });
    },

    /**
     * Leave the admin presence channel
     */
    leave() {
        window.Echo.leave('admin-dashboard');
    },

    /**
     * Handle member registration event
     */
    onMemberRegistered(data) {
        // Update pending members count
        const pendingElement = document.getElementById('pendingMembersCount');
        if (pendingElement && data.status === 'pending') {
            const currentCount = parseInt(pendingElement.textContent);
            pendingElement.textContent = currentCount + 1;
        }

        // Show notification
        this.showNotification('New Member Registration', `${data.name} has registered and is awaiting approval`);
    },

    /**
     * Update online admins list
     */
    updateOnlineAdmins(users) {
        const list = document.getElementById('onlineAdminsList');
        if (list) {
            list.innerHTML = users.map(user => `
                <div class="flex items-center gap-2 p-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-sm text-gray-700">${user.name}</span>
                </div>
            `).join('');
        }
    },

    /**
     * Add online admin to list
     */
    addOnlineAdmin(user) {
        const list = document.getElementById('onlineAdminsList');
        if (list) {
            const item = document.createElement('div');
            item.className = 'flex items-center gap-2 p-2';
            item.innerHTML = `
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <span class="text-sm text-gray-700">${user.name}</span>
            `;
            list.appendChild(item);
        }
    },

    /**
     * Remove online admin from list
     */
    removeOnlineAdmin(user) {
        const list = document.getElementById('onlineAdminsList');
        if (list) {
            const items = list.querySelectorAll('.flex');
            items.forEach(item => {
                if (item.textContent.trim() === user.name) {
                    item.remove();
                }
            });
        }
    },

    /**
     * Show notification
     */
    showNotification(title, body) {
        if ('Notification' in window && Notification.permission === 'granted') {
            new Notification(title, {
                body,
                icon: '/images/church-icon.png',
            });
        }
    },
};

/**
 * Real-time Finance Dashboard
 */
export const FinanceDashboardRealtime = {
    /**
     * Join the finance presence channel
     */
    join() {
        window.Echo.join('finance-dashboard')
            .listen('.transaction.created', (data) => {
                this.onTransactionCreated(data);
            });
    },

    /**
     * Leave the finance presence channel
     */
    leave() {
        window.Echo.leave('finance-dashboard');
    },

    /**
     * Handle transaction created event
     */
    onTransactionCreated(data) {
        // Update total based on transaction type
        this.updateFinancialTotals(data);

        // Show notification for large transactions
        if (data.amount >= 1000) {
            this.showNotification(
                'Large Transaction Recorded',
                `${data.transaction_type === 'income' ? 'Income' : 'Expense'}: GHS ${data.amount.toFixed(2)}`
            );
        }

        // Add to recent transactions list
        this.addToRecentTransactions(data);
    },

    /**
     * Update financial totals
     */
    updateFinancialTotals(data) {
        const elementId = data.transaction_type === 'income' ? 'totalIncome' : 'totalExpenses';
        const element = document.getElementById(elementId);

        if (element) {
            const currentTotal = parseFloat(element.textContent.replace(/[^0-9.]/g, ''));
            const newTotal = currentTotal + parseFloat(data.amount);
            element.textContent = `GHS ${newTotal.toFixed(2)}`;

            // Animate
            element.classList.add('highlight-animation');
            setTimeout(() => {
                element.classList.remove('highlight-animation');
            }, 2000);
        }
    },

    /**
     * Add transaction to recent list
     */
    addToRecentTransactions(data) {
        const list = document.getElementById('recentTransactionsList');
        if (list) {
            const item = document.createElement('div');
            const color = data.transaction_type === 'income' ? 'green' : 'red';
            item.className = `p-3 border-l-4 border-${color}-500 bg-${color}-50 rounded mb-2 new-item`;
            item.innerHTML = `
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">${data.category}</p>
                        <p class="text-sm text-gray-600">${data.member_name || 'Anonymous'}</p>
                    </div>
                    <span class="text-lg font-bold text-${color}-600">
                        ${data.transaction_type === 'income' ? '+' : '-'}GHS ${data.amount.toFixed(2)}
                    </span>
                </div>
            `;
            list.prepend(item);

            // Remove oldest if more than 10
            if (list.children.length > 10) {
                list.removeChild(list.lastChild);
            }

            // Animation
            setTimeout(() => {
                item.classList.remove('new-item');
            }, 100);
        }
    },

    /**
     * Show notification
     */
    showNotification(title, body) {
        if ('Notification' in window && Notification.permission === 'granted') {
            new Notification(title, {
                body,
                icon: '/images/church-icon.png',
            });
        }
    },
};

/**
 * Request notification permission
 */
export function requestNotificationPermission() {
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission();
    }
}

/**
 * Initialize real-time features based on current page
 */
export function initializeRealtime() {
    // Request notification permission
    requestNotificationPermission();

    // Check current page and initialize appropriate real-time features
    const path = window.location.pathname;

    if (path.includes('/dashboard') || path === '/') {
        // Check user role and initialize appropriate dashboard
        const userRole = document.querySelector('meta[name="user-role"]')?.content;

        if (userRole === 'admin') {
            AdminDashboardRealtime.join();
        } else if (userRole === 'staff' || userRole === 'pastor') {
            StaffDashboardRealtime.join();
        }
    }

    if (path.includes('/attendance')) {
        const serviceDate = document.querySelector('meta[name="service-date"]')?.content;
        if (serviceDate) {
            AttendanceRealtime.listenForDate(serviceDate, (data) => {
                console.log('Attendance update:', data);
            });
        } else {
            AttendanceRealtime.listen((data) => {
                console.log('Attendance update:', data);
            });
        }
    }

    if (path.includes('/transactions') || path.includes('/finance')) {
        FinanceDashboardRealtime.join();
    }

    if (path.includes('/members')) {
        MemberRealtime.listen((data) => {
            console.log('Member update:', data);
        });
    }
}

// Auto-initialize on page load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeRealtime);
} else {
    initializeRealtime();
}
