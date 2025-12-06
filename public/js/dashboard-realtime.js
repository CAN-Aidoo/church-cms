/**
 * Real-time Dashboard Updates
 *
 * This module handles real-time polling of dashboard data
 * and updates the UI with live statistics, charts, and activity feeds.
 */

class DashboardRealtime {
    constructor(options = {}) {
        this.updateInterval = options.updateInterval || 10000; // 10 seconds default
        this.statsEndpoint = options.statsEndpoint || '/api/v1/dashboard/stats';
        this.chartsEndpoint = options.chartsEndpoint || '/api/v1/dashboard/charts';
        this.activityEndpoint = options.activityEndpoint || '/api/v1/dashboard/recent-activity';
        this.isPolling = false;
        this.intervalId = null;
        this.charts = {};
        this.lastUpdate = null;

        // CSRF token
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // API request headers
        this.headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        };

        if (this.csrfToken) {
            this.headers['X-CSRF-TOKEN'] = this.csrfToken;
        }
    }

    /**
     * Start real-time polling
     */
    start() {
        if (this.isPolling) {
            console.warn('Dashboard polling is already running');
            return;
        }

        console.log('Starting dashboard real-time updates...');
        this.isPolling = true;

        // Initial load
        this.updateStats();
        this.updateActivity();

        // Start interval
        this.intervalId = setInterval(() => {
            this.updateStats();
            this.updateActivity();
        }, this.updateInterval);

        // Update charts every minute (less frequent)
        setInterval(() => {
            this.updateCharts();
        }, 60000);
    }

    /**
     * Stop polling
     */
    stop() {
        if (this.intervalId) {
            clearInterval(this.intervalId);
            this.intervalId = null;
            this.isPolling = false;
            console.log('Dashboard real-time updates stopped');
        }
    }

    /**
     * Update dashboard statistics
     */
    async updateStats() {
        try {
            const response = await fetch(this.statsEndpoint, {
                method: 'GET',
                headers: this.headers
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            this.renderStats(data);
            this.lastUpdate = new Date(data.timestamp);
            this.updateLastRefreshIndicator();
        } catch (error) {
            console.error('Error updating stats:', error);
        }
    }

    /**
     * Update charts data
     */
    async updateCharts(chartType = 'all') {
        try {
            const url = `${this.chartsEndpoint}?type=${chartType}`;
            const response = await fetch(url, {
                method: 'GET',
                headers: this.headers
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            this.renderCharts(data);
        } catch (error) {
            console.error('Error updating charts:', error);
        }
    }

    /**
     * Update activity feed
     */
    async updateActivity(limit = 20) {
        try {
            const url = `${this.activityEndpoint}?limit=${limit}`;
            const response = await fetch(url, {
                method: 'GET',
                headers: this.headers
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const activities = await response.json();
            this.renderActivityFeed(activities);
        } catch (error) {
            console.error('Error updating activity:', error);
        }
    }

    /**
     * Render statistics with smooth animations
     */
    renderStats(stats) {
        // Total Members
        this.animateNumber('total-members', stats.total_members);

        // Today's Attendance
        this.animateNumber('todays-attendance', stats.todays_attendance);

        // Today's Income
        this.animateNumber('todays-income', stats.todays_income, true);

        // Today's Visitors
        this.animateNumber('todays-visitors', stats.todays_visitors);

        // Pending Approvals
        this.animateNumber('pending-approvals', stats.pending_approvals);

        // Active Programs
        this.animateNumber('active-programs', stats.active_programs);

        // Add pulse animation to updated elements
        this.addPulseEffect();
    }

    /**
     * Animate number changes
     */
    animateNumber(elementId, targetValue, isCurrency = false) {
        const element = document.getElementById(elementId);
        if (!element) return;

        const currentValue = parseFloat(element.textContent.replace(/[^0-9.-]+/g, '')) || 0;
        const difference = targetValue - currentValue;

        if (difference === 0) return;

        const steps = 20;
        const stepValue = difference / steps;
        let currentStep = 0;

        const interval = setInterval(() => {
            currentStep++;
            const newValue = currentValue + (stepValue * currentStep);

            if (isCurrency) {
                element.textContent = `GHS ${this.formatNumber(newValue, 2)}`;
            } else {
                element.textContent = this.formatNumber(Math.round(newValue));
            }

            if (currentStep >= steps) {
                clearInterval(interval);
                if (isCurrency) {
                    element.textContent = `GHS ${this.formatNumber(targetValue, 2)}`;
                } else {
                    element.textContent = this.formatNumber(Math.round(targetValue));
                }
            }
        }, 20);
    }

    /**
     * Format number with commas
     */
    formatNumber(number, decimals = 0) {
        return new Intl.NumberFormat('en-US', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        }).format(number);
    }

    /**
     * Render charts dynamically
     */
    renderCharts(chartsData) {
        // Update existing charts instead of recreating them
        Object.keys(chartsData).forEach(chartKey => {
            const chartElement = document.getElementById(`${chartKey}-chart`);
            if (chartElement && this.charts[chartKey]) {
                const chart = this.charts[chartKey];
                const newData = chartsData[chartKey];

                // Update chart data
                chart.data.labels = Object.keys(newData);
                chart.data.datasets.forEach((dataset, i) => {
                    dataset.data = Object.values(newData);
                });

                chart.update('none'); // Update without animation for smooth transition
            }
        });
    }

    /**
     * Render activity feed
     */
    renderActivityFeed(activities) {
        const feedContainer = document.getElementById('activity-feed');
        if (!feedContainer) return;

        if (activities.length === 0) {
            feedContainer.innerHTML = `
                <div class="p-6 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm">No recent activity</p>
                </div>
            `;
            return;
        }

        const activityHTML = activities.map(activity => {
            const iconClass = this.getIconClass(activity.icon);
            const colorClass = this.getColorClass(activity.color);
            const timestamp = this.formatTimestamp(activity.timestamp);

            return `
                <div class="flex items-start gap-3 p-3 hover:bg-gray-50 rounded-lg transition-colors border-l-2 ${colorClass.border}">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full ${colorClass.bg} ${colorClass.text} flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${iconClass}
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">${activity.title}</p>
                        <p class="text-xs text-gray-500">${activity.description}</p>
                        <p class="text-xs text-gray-400 mt-1">${timestamp}</p>
                    </div>
                </div>
            `;
        }).join('');

        feedContainer.innerHTML = activityHTML;
    }

    /**
     * Get icon SVG path based on icon name
     */
    getIconClass(iconName) {
        const icons = {
            'check-circle': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'arrow-down': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>',
            'arrow-up': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>',
            'user-plus': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>',
        };
        return icons[iconName] || icons['check-circle'];
    }

    /**
     * Get color classes based on color name
     */
    getColorClass(colorName) {
        const colors = {
            'green': { bg: 'bg-green-100', text: 'text-green-600', border: 'border-green-500' },
            'blue': { bg: 'bg-blue-100', text: 'text-blue-600', border: 'border-blue-500' },
            'red': { bg: 'bg-red-100', text: 'text-red-600', border: 'border-red-500' },
            'yellow': { bg: 'bg-yellow-100', text: 'text-yellow-600', border: 'border-yellow-500' },
        };
        return colors[colorName] || colors['blue'];
    }

    /**
     * Format timestamp
     */
    formatTimestamp(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const diffMs = now - date;
        const diffMins = Math.floor(diffMs / 60000);

        if (diffMins < 1) return 'Just now';
        if (diffMins < 60) return `${diffMins}m ago`;

        const diffHours = Math.floor(diffMins / 60);
        if (diffHours < 24) return `${diffHours}h ago`;

        const diffDays = Math.floor(diffHours / 24);
        if (diffDays < 7) return `${diffDays}d ago`;

        return date.toLocaleDateString();
    }

    /**
     * Add pulse effect to updated elements
     */
    addPulseEffect() {
        const elements = document.querySelectorAll('[data-realtime]');
        elements.forEach(el => {
            el.classList.add('pulse-once');
            setTimeout(() => {
                el.classList.remove('pulse-once');
            }, 1000);
        });
    }

    /**
     * Update last refresh indicator
     */
    updateLastRefreshIndicator() {
        const indicator = document.getElementById('last-refresh');
        if (!indicator) return;

        const now = new Date();
        const timeStr = now.toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        indicator.textContent = `Last updated: ${timeStr}`;
        indicator.classList.add('text-green-600');

        setTimeout(() => {
            indicator.classList.remove('text-green-600');
        }, 2000);
    }

    /**
     * Register chart instance for updates
     */
    registerChart(key, chartInstance) {
        this.charts[key] = chartInstance;
    }
}

// Auto-initialize if enabled
document.addEventListener('DOMContentLoaded', function() {
    const dashboardElement = document.getElementById('dashboard-realtime');
    if (dashboardElement) {
        const autoStart = dashboardElement.dataset.autostart === 'true';
        const updateInterval = parseInt(dashboardElement.dataset.interval) || 10000;

        window.dashboardRealtime = new DashboardRealtime({
            updateInterval: updateInterval
        });

        if (autoStart) {
            window.dashboardRealtime.start();
        }

        // Add control buttons
        const startBtn = document.getElementById('start-realtime');
        const stopBtn = document.getElementById('stop-realtime');

        if (startBtn) {
            startBtn.addEventListener('click', () => {
                window.dashboardRealtime.start();
                startBtn.classList.add('hidden');
                if (stopBtn) stopBtn.classList.remove('hidden');
            });
        }

        if (stopBtn) {
            stopBtn.addEventListener('click', () => {
                window.dashboardRealtime.stop();
                stopBtn.classList.add('hidden');
                if (startBtn) startBtn.classList.remove('hidden');
            });
        }
    }
});
