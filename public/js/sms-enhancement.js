/**
 * SMS Enhancement Module
 *
 * Provides template management, message preview, character counting,
 * phone validation, and delivery statistics for SMS broadcasts.
 */

class SmsEnhancement {
    constructor(options = {}) {
        this.templatesEndpoint = options.templatesEndpoint || '/api/v1/sms/templates/list';
        this.previewEndpoint = options.previewEndpoint || '/api/v1/sms/preview';
        this.statsEndpoint = options.statsEndpoint || '/api/v1/sms/stats/delivery';
        this.validateEndpoint = options.validateEndpoint || '/api/v1/sms/validate/phones';
        this.infoEndpoint = options.infoEndpoint || '/api/v1/sms/message/info';

        this.templates = {};
        this.debounceTimer = null;

        // CSRF token
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Headers
        this.headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        };

        if (this.csrfToken) {
            this.headers['X-CSRF-TOKEN'] = this.csrfToken;
        }

        this.init();
    }

    /**
     * Initialize SMS enhancement features
     */
    async init() {
        await this.loadTemplates();
        this.setupEventListeners();
        this.setupCharacterCounter();
    }

    /**
     * Load SMS templates
     */
    async loadTemplates() {
        try {
            const response = await fetch(this.templatesEndpoint, {
                method: 'GET',
                headers: this.headers
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            this.templates = data.templates;
            this.renderTemplates();
        } catch (error) {
            console.error('Error loading templates:', error);
        }
    }

    /**
     * Setup event listeners
     */
    setupEventListeners() {
        // Template selection
        const templateSelect = document.getElementById('message-template');
        if (templateSelect) {
            templateSelect.addEventListener('change', (e) => {
                this.applyTemplate(e.target.value);
            });
        }

        // Message textarea
        const messageTextarea = document.getElementById('message');
        if (messageTextarea) {
            messageTextarea.addEventListener('input', () => {
                this.updateCharacterCount();
                this.debouncedPreview();
            });
        }

        // Preview button
        const previewBtn = document.getElementById('preview-message');
        if (previewBtn) {
            previewBtn.addEventListener('click', () => {
                this.previewMessage();
            });
        }

        // Insert variable buttons
        document.querySelectorAll('[data-variable]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.insertVariable(e.currentTarget.dataset.variable);
            });
        });
    }

    /**
     * Setup character counter
     */
    setupCharacterCounter() {
        const messageTextarea = document.getElementById('message');
        if (messageTextarea) {
            this.updateCharacterCount();
        }
    }

    /**
     * Render templates dropdown
     */
    renderTemplates() {
        const templateSelect = document.getElementById('message-template');
        if (!templateSelect) return;

        const options = ['<option value="">Select a template...</option>'];

        Object.entries(this.templates).forEach(([key, template]) => {
            options.push(`<option value="${key}">${template.name}</option>`);
        });

        templateSelect.innerHTML = options.join('');
    }

    /**
     * Apply template to message
     */
    applyTemplate(templateKey) {
        if (!templateKey || !this.templates[templateKey]) return;

        const messageTextarea = document.getElementById('message');
        if (!messageTextarea) return;

        const template = this.templates[templateKey];
        messageTextarea.value = template.message;
        this.updateCharacterCount();
        this.showVariableHints(template.variables);
    }

    /**
     * Show variable hints
     */
    showVariableHints(variables) {
        const hintsContainer = document.getElementById('variable-hints');
        if (!hintsContainer) return;

        if (variables && variables.length > 0) {
            const hints = variables.map(v => `<span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full mr-2 mb-2">{${v}}</span>`).join('');
            hintsContainer.innerHTML = `
                <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm font-medium text-blue-900 mb-2">Available variables:</p>
                    <div>${hints}</div>
                </div>
            `;
            hintsContainer.classList.remove('hidden');
        } else {
            hintsContainer.classList.add('hidden');
        }
    }

    /**
     * Insert variable at cursor position
     */
    insertVariable(variable) {
        const messageTextarea = document.getElementById('message');
        if (!messageTextarea) return;

        const start = messageTextarea.selectionStart;
        const end = messageTextarea.selectionEnd;
        const text = messageTextarea.value;
        const before = text.substring(0, start);
        const after = text.substring(end, text.length);

        messageTextarea.value = before + variable + after;
        messageTextarea.selectionStart = messageTextarea.selectionEnd = start + variable.length;
        messageTextarea.focus();

        this.updateCharacterCount();
    }

    /**
     * Update character count and segment info
     */
    async updateCharacterCount() {
        const messageTextarea = document.getElementById('message');
        if (!messageTextarea) return;

        const message = messageTextarea.value;

        try {
            const response = await fetch(this.infoEndpoint, {
                method: 'POST',
                headers: this.headers,
                body: JSON.stringify({ message })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            this.renderCharacterInfo(data);
        } catch (error) {
            console.error('Error getting message info:', error);
            // Fallback to simple character count
            this.renderSimpleCharacterCount(message.length);
        }
    }

    /**
     * Render character count information
     */
    renderCharacterInfo(data) {
        const container = document.getElementById('character-info');
        if (!container) return;

        const segmentColor = data.segments > 3 ? 'text-red-600' : 'text-green-600';
        const warningHtml = data.warning ? `<p class="text-xs text-red-600 mt-1">${data.warning}</p>` : '';

        container.innerHTML = `
            <div class="flex items-center justify-between text-sm">
                <div>
                    <span class="text-gray-600">Characters: </span>
                    <span class="font-medium">${data.length}/${data.max_length}</span>
                </div>
                <div>
                    <span class="text-gray-600">Segments: </span>
                    <span class="font-medium ${segmentColor}">${data.segments}</span>
                </div>
                <div>
                    <span class="text-gray-600">Remaining: </span>
                    <span class="font-medium">${data.remaining}</span>
                </div>
            </div>
            ${warningHtml}
        `;
    }

    /**
     * Render simple character count (fallback)
     */
    renderSimpleCharacterCount(length) {
        const container = document.getElementById('character-info');
        if (!container) return;

        const segments = length <= 160 ? 1 : Math.ceil(length / 153);

        container.innerHTML = `
            <div class="text-sm text-gray-600">
                Characters: <span class="font-medium">${length}/1600</span> |
                Segments: <span class="font-medium">${segments}</span>
            </div>
        `;
    }

    /**
     * Debounced preview
     */
    debouncedPreview() {
        clearTimeout(this.debounceTimer);
        this.debounceTimer = setTimeout(() => {
            this.previewMessage();
        }, 1000);
    }

    /**
     * Preview message with variable substitution
     */
    async previewMessage() {
        const messageTextarea = document.getElementById('message');
        if (!messageTextarea) return;

        const message = messageTextarea.value;
        if (!message) return;

        try {
            const response = await fetch(this.previewEndpoint, {
                method: 'POST',
                headers: this.headers,
                body: JSON.stringify({ message })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            this.renderPreview(data);
        } catch (error) {
            console.error('Error previewing message:', error);
        }
    }

    /**
     * Render message preview
     */
    renderPreview(data) {
        const container = document.getElementById('message-preview');
        if (!container) return;

        container.innerHTML = `
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-medium text-gray-500 uppercase">Preview</span>
                    ${data.sample_member ? `<span class="text-xs text-gray-500">Sample: ${data.sample_member}</span>` : ''}
                </div>
                <div class="bg-white p-3 rounded-lg border border-gray-300 text-sm text-gray-900">
                    ${data.preview}
                </div>
                <div class="mt-2 text-xs text-gray-500">
                    ${data.length} characters | ${data.segments} segment(s)
                </div>
            </div>
        `;
    }

    /**
     * Load delivery statistics
     */
    async loadDeliveryStats(days = 30) {
        try {
            const response = await fetch(`${this.statsEndpoint}?days=${days}`, {
                method: 'GET',
                headers: this.headers
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            this.renderDeliveryStats(data.stats);
            this.renderDailyBreakdown(data.daily_breakdown);
        } catch (error) {
            console.error('Error loading delivery stats:', error);
        }
    }

    /**
     * Render delivery statistics
     */
    renderDeliveryStats(stats) {
        const container = document.getElementById('delivery-stats');
        if (!container) return;

        container.innerHTML = `
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-lg border border-gray-200">
                    <p class="text-xs text-gray-500 uppercase">Total Sent</p>
                    <p class="text-2xl font-bold text-gray-900">${stats.total_sent.toLocaleString()}</p>
                </div>
                <div class="bg-white p-4 rounded-lg border border-gray-200">
                    <p class="text-xs text-gray-500 uppercase">Success Rate</p>
                    <p class="text-2xl font-bold text-green-600">${stats.success_rate}%</p>
                </div>
                <div class="bg-white p-4 rounded-lg border border-gray-200">
                    <p class="text-xs text-gray-500 uppercase">Total Cost</p>
                    <p class="text-2xl font-bold text-gray-900">GHS ${stats.total_cost.toFixed(2)}</p>
                </div>
                <div class="bg-white p-4 rounded-lg border border-gray-200">
                    <p class="text-xs text-gray-500 uppercase">Broadcasts</p>
                    <p class="text-2xl font-bold text-gray-900">${stats.broadcasts_sent}</p>
                </div>
            </div>
        `;
    }

    /**
     * Render daily breakdown chart
     */
    renderDailyBreakdown(dailyStats) {
        // This would integrate with Chart.js or similar library
        console.log('Daily breakdown:', dailyStats);
    }

    /**
     * Validate phone numbers
     */
    async validatePhoneNumbers(phoneNumbers) {
        try {
            const response = await fetch(this.validateEndpoint, {
                method: 'POST',
                headers: this.headers,
                body: JSON.stringify({ phone_numbers: phoneNumbers })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error validating phone numbers:', error);
            return null;
        }
    }
}

// Auto-initialize
document.addEventListener('DOMContentLoaded', function() {
    const smsEnhancementElement = document.getElementById('sms-enhancement');
    if (smsEnhancementElement) {
        window.smsEnhancement = new SmsEnhancement();

        // Load delivery stats if container exists
        const deliveryStatsContainer = document.getElementById('delivery-stats');
        if (deliveryStatsContainer) {
            window.smsEnhancement.loadDeliveryStats(30);
        }
    }
});
