# Church CMS - Improved QR Implementation v2.0 (Part 2)
## Dynamic Forms, Real-Time Updates & Implementation Guide

*Continuation of IMPROVED_QR_IMPLEMENTATION_v2.md*

---

## 📝 Part 4: Dynamic Form System

### 4.1 Form Configuration Storage

```php
// database/migrations/2024_01_01_000030_create_qr_form_configs_table.php
Schema::create('qr_form_configs', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->foreignUuid('qr_code_id')->constrained('qr_codes')->onDelete('cascade');
    $table->json('fields'); // Array of field configurations
    $table->json('validation_rules'); // Validation for each field
    $table->json('conditional_logic')->nullable(); // Show/hide based on answers
    $table->json('pre_fill_rules')->nullable(); // Auto-fill from member data
    $table->string('success_message')->nullable();
    $table->string('success_redirect')->nullable();
    $table->timestamps();
});

// Form field example structure
$field = [
    'id' => 'field_abc123',
    'type' => 'text|email|phone|select|checkbox|textarea|date|number',
    'label' => 'Your Name',
    'placeholder' => 'Enter your full name',
    'required' => true,
    'validation' => 'max:100|min:2',
    'order' => 1,
    'width' => 'full|half|third', // Layout width
    'options' => [], // For select/radio/checkbox
    'pre_fill' => 'member.first_name', // Auto-fill from logged-in member
    'conditional' => [
        'show_if' => 'field_xyz_equals_yes',
        'hide_if' => 'field_abc_not_empty'
    ]
];
```

### 4.2 Dynamic Form Renderer (Mobile)

```javascript
// public/js/dynamic-form-renderer.js
class DynamicFormRenderer {
    constructor(formConfig) {
        this.config = formConfig;
        this.formData = {};
        this.validationErrors = {};
    }

    /**
     * Render complete form
     */
    render() {
        const container = document.getElementById('dynamic-form-container');

        const formHTML = `
            <div class="dynamic-form">
                <div class="form-header">
                    <h2>${this.config.title || 'Please Fill Out This Form'}</h2>
                    <p class="description">${this.config.description || ''}</p>
                </div>

                <form id="qr-dynamic-form" class="form-body">
                    ${this.renderFields()}

                    <div class="form-actions">
                        <button type="submit" class="btn-primary btn-large">
                            ${this.config.submit_text || 'Submit'}
                        </button>
                    </div>
                </form>

                <div class="form-footer">
                    <p class="privacy-note">
                        Your information is secure and will only be used for church purposes.
                    </p>
                </div>
            </div>
        `;

        container.innerHTML = formHTML;

        // Attach event listeners
        this.attachEventListeners();

        // Pre-fill data if user is logged in
        this.preFillForm();
    }

    /**
     * Render all fields
     */
    renderFields() {
        return this.config.fields
            .sort((a, b) => a.order - b.order)
            .map(field => this.renderField(field))
            .join('');
    }

    /**
     * Render individual field
     */
    renderField(field) {
        const widthClass = {
            'full': 'field-full',
            'half': 'field-half',
            'third': 'field-third'
        }[field.width] || 'field-full';

        const requiredMark = field.required ? '<span class="required">*</span>' : '';

        let inputHTML = '';

        switch (field.type) {
            case 'text':
            case 'email':
            case 'tel':
            case 'number':
                inputHTML = `
                    <input type="${field.type}"
                           id="${field.id}"
                           name="${field.id}"
                           placeholder="${field.placeholder || ''}"
                           ${field.required ? 'required' : ''}
                           class="form-control">
                `;
                break;

            case 'textarea':
                inputHTML = `
                    <textarea id="${field.id}"
                              name="${field.id}"
                              placeholder="${field.placeholder || ''}"
                              rows="${field.rows || 4}"
                              ${field.required ? 'required' : ''}
                              class="form-control"></textarea>
                `;
                break;

            case 'select':
                const options = field.options.map(opt =>
                    `<option value="${opt.value}">${opt.label}</option>`
                ).join('');
                inputHTML = `
                    <select id="${field.id}"
                            name="${field.id}"
                            ${field.required ? 'required' : ''}
                            class="form-control">
                        <option value="">Select...</option>
                        ${options}
                    </select>
                `;
                break;

            case 'radio':
                inputHTML = field.options.map((opt, idx) => `
                    <label class="radio-option">
                        <input type="radio"
                               name="${field.id}"
                               value="${opt.value}"
                               ${field.required && idx === 0 ? 'required' : ''}>
                        <span>${opt.label}</span>
                    </label>
                `).join('');
                break;

            case 'checkbox':
                if (field.options) {
                    // Multiple checkboxes
                    inputHTML = field.options.map(opt => `
                        <label class="checkbox-option">
                            <input type="checkbox"
                                   name="${field.id}[]"
                                   value="${opt.value}">
                            <span>${opt.label}</span>
                        </label>
                    `).join('');
                } else {
                    // Single checkbox
                    inputHTML = `
                        <label class="checkbox-option">
                            <input type="checkbox"
                                   id="${field.id}"
                                   name="${field.id}"
                                   ${field.required ? 'required' : ''}>
                            <span>${field.label}</span>
                        </label>
                    `;
                }
                break;

            case 'date':
                inputHTML = `
                    <input type="date"
                           id="${field.id}"
                           name="${field.id}"
                           ${field.required ? 'required' : ''}
                           class="form-control">
                `;
                break;

            case 'phone':
                inputHTML = `
                    <input type="tel"
                           id="${field.id}"
                           name="${field.id}"
                           placeholder="${field.placeholder || '+233 XX XXX XXXX'}"
                           pattern="${field.pattern || '[0-9\\+\\-\\s\\(\\)]*'}"
                           ${field.required ? 'required' : ''}
                           class="form-control">
                `;
                break;
        }

        return `
            <div class="form-field ${widthClass}"
                 data-field-id="${field.id}"
                 data-conditional="${field.conditional ? JSON.stringify(field.conditional) : ''}">

                ${field.type !== 'checkbox' || field.options ? `
                    <label for="${field.id}">
                        ${field.label} ${requiredMark}
                    </label>
                ` : ''}

                ${inputHTML}

                ${field.help_text ? `<p class="help-text">${field.help_text}</p>` : ''}

                <div class="field-error" id="${field.id}-error"></div>
            </div>
        `;
    }

    /**
     * Attach event listeners
     */
    attachEventListeners() {
        const form = document.getElementById('qr-dynamic-form');

        // Form submission
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleSubmit();
        });

        // Field change events for conditional logic
        form.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('change', () => {
                this.handleFieldChange(field);
                this.updateConditionalFields();
            });
        });

        // Real-time validation
        form.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('blur', () => {
                this.validateField(field);
            });
        });
    }

    /**
     * Pre-fill form with user data
     */
    async preFillForm() {
        const user = await this.getCurrentUser();
        if (!user) return;

        this.config.fields.forEach(field => {
            if (field.pre_fill) {
                const value = this.getNestedValue(user, field.pre_fill);
                if (value) {
                    const input = document.getElementById(field.id);
                    if (input) input.value = value;
                }
            }
        });
    }

    /**
     * Handle field change
     */
    handleFieldChange(field) {
        const fieldId = field.name.replace('[]', '');
        const fieldConfig = this.config.fields.find(f => f.id === fieldId);

        if (fieldConfig && fieldConfig.onChange) {
            // Execute custom onChange logic
            this.executeFieldCallback(fieldConfig.onChange, field.value);
        }
    }

    /**
     * Update conditional field visibility
     */
    updateConditionalFields() {
        this.config.fields.forEach(field => {
            if (field.conditional) {
                const fieldElement = document.querySelector(`[data-field-id="${field.id}"]`);
                const shouldShow = this.evaluateCondition(field.conditional);

                if (shouldShow) {
                    fieldElement.style.display = '';
                    fieldElement.classList.remove('hidden');
                } else {
                    fieldElement.style.display = 'none';
                    fieldElement.classList.add('hidden');
                    // Clear value when hidden
                    const input = document.getElementById(field.id);
                    if (input) input.value = '';
                }
            }
        });
    }

    /**
     * Evaluate conditional logic
     */
    evaluateCondition(condition) {
        if (condition.show_if) {
            return this.evaluateRule(condition.show_if);
        }
        if (condition.hide_if) {
            return !this.evaluateRule(condition.hide_if);
        }
        return true;
    }

    /**
     * Evaluate single rule
     */
    evaluateRule(rule) {
        // Format: "field_id_operator_value"
        // Example: "field_abc_equals_yes"
        const parts = rule.split('_');
        const operator = parts[parts.length - 2];
        const expectedValue = parts[parts.length - 1];
        const fieldId = parts.slice(0, parts.length - 2).join('_');

        const field = document.getElementById(fieldId);
        if (!field) return false;

        const actualValue = field.value;

        switch (operator) {
            case 'equals': return actualValue === expectedValue;
            case 'not': return actualValue !== expectedValue;
            case 'contains': return actualValue.includes(expectedValue);
            case 'empty': return !actualValue;
            case 'notempty': return !!actualValue;
            default: return false;
        }
    }

    /**
     * Validate field
     */
    validateField(field) {
        const fieldId = field.name.replace('[]', '');
        const fieldConfig = this.config.fields.find(f => f.id === fieldId);
        if (!fieldConfig) return true;

        const errors = [];

        // Required validation
        if (fieldConfig.required && !field.value) {
            errors.push(`${fieldConfig.label} is required`);
        }

        // Type-specific validation
        if (field.value) {
            switch (fieldConfig.type) {
                case 'email':
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value)) {
                        errors.push('Invalid email address');
                    }
                    break;

                case 'phone':
                    if (!/^\+?[0-9\s\-()]{10,}$/.test(field.value)) {
                        errors.push('Invalid phone number');
                    }
                    break;

                case 'number':
                    if (isNaN(field.value)) {
                        errors.push('Must be a number');
                    }
                    if (fieldConfig.min && Number(field.value) < fieldConfig.min) {
                        errors.push(`Minimum value is ${fieldConfig.min}`);
                    }
                    if (fieldConfig.max && Number(field.value) > fieldConfig.max) {
                        errors.push(`Maximum value is ${fieldConfig.max}`);
                    }
                    break;
            }

            // Custom validation
            if (fieldConfig.validation) {
                const rules = fieldConfig.validation.split('|');
                rules.forEach(rule => {
                    if (rule.startsWith('max:')) {
                        const max = parseInt(rule.split(':')[1]);
                        if (field.value.length > max) {
                            errors.push(`Maximum ${max} characters`);
                        }
                    }
                    if (rule.startsWith('min:')) {
                        const min = parseInt(rule.split(':')[1]);
                        if (field.value.length < min) {
                            errors.push(`Minimum ${min} characters`);
                        }
                    }
                });
            }
        }

        // Display errors
        const errorDiv = document.getElementById(`${fieldId}-error`);
        if (errors.length > 0) {
            errorDiv.textContent = errors[0];
            errorDiv.style.display = 'block';
            field.classList.add('error');
            this.validationErrors[fieldId] = errors;
            return false;
        } else {
            errorDiv.textContent = '';
            errorDiv.style.display = 'none';
            field.classList.remove('error');
            delete this.validationErrors[fieldId];
            return true;
        }
    }

    /**
     * Handle form submission
     */
    async handleSubmit() {
        const form = document.getElementById('qr-dynamic-form');

        // Validate all fields
        let isValid = true;
        form.querySelectorAll('input, select, textarea').forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        if (!isValid) {
            this.showError('Please fix the errors before submitting');
            return;
        }

        // Collect form data
        const formData = new FormData(form);
        const data = {};

        for (let [key, value] of formData.entries()) {
            if (key.endsWith('[]')) {
                // Multiple values (checkboxes)
                const cleanKey = key.replace('[]', '');
                if (!data[cleanKey]) data[cleanKey] = [];
                data[cleanKey].push(value);
            } else {
                data[key] = value;
            }
        }

        // Show loading
        this.showLoading();

        try {
            // Submit to backend
            const response = await fetch('/api/v1/qr-scan/submit-form', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${this.getAuthToken()}`
                },
                body: JSON.stringify({
                    qr_code_id: this.config.qr_code_id,
                    form_data: data
                })
            });

            const result = await response.json();

            this.hideLoading();

            if (result.success) {
                this.showSuccess(result.message || this.config.success_message);

                // Redirect if configured
                if (this.config.success_redirect) {
                    setTimeout(() => {
                        window.location.href = this.config.success_redirect;
                    }, 2000);
                }
            } else {
                this.showError(result.error);
            }
        } catch (error) {
            this.hideLoading();
            this.showError('Submission failed. Please try again.');
            console.error('Form submission error:', error);
        }
    }

    /**
     * Helper methods
     */
    getNestedValue(obj, path) {
        return path.split('.').reduce((acc, part) => acc && acc[part], obj);
    }

    async getCurrentUser() {
        try {
            const response = await fetch('/api/v1/user/current');
            return await response.json();
        } catch {
            return null;
        }
    }

    getAuthToken() {
        return localStorage.getItem('auth_token') || '';
    }

    showLoading() {
        document.getElementById('qr-dynamic-form').classList.add('loading');
    }

    hideLoading() {
        document.getElementById('qr-dynamic-form').classList.remove('loading');
    }

    showSuccess(message) {
        this.showNotification(message, 'success');
    }

    showError(message) {
        this.showNotification(message, 'error');
    }

    showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => notification.classList.add('show'), 100);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
}

// Usage after QR scan
function showFormAfterScan(formConfig) {
    const renderer = new DynamicFormRenderer(formConfig);
    renderer.render();
}
```

### 4.3 Form Styles (Mobile-First)

```css
/* public/css/dynamic-form.css */
.dynamic-form {
    max-width: 100%;
    padding: 20px;
    background: white;
    min-height: 100vh;
}

.form-header {
    margin-bottom: 30px;
    text-align: center;
}

.form-header h2 {
    font-size: 24px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 10px;
}

.form-header .description {
    font-size: 14px;
    color: #7f8c8d;
    line-height: 1.6;
}

.form-body {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.form-field {
    margin-bottom: 0;
}

.form-field.field-full {
    width: 100%;
}

.form-field.field-half {
    width: calc(50% - 10px);
}

.form-field.field-third {
    width: calc(33.333% - 14px);
}

@media (max-width: 768px) {
    .form-field.field-half,
    .form-field.field-third {
        width: 100%;
    }
}

.form-field label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: #34495e;
    margin-bottom: 8px;
}

.form-field label .required {
    color: #e74c3c;
    margin-left: 2px;
}

.form-control {
    width: 100%;
    padding: 12px 16px;
    font-size: 16px;
    border: 2px solid #dfe6e9;
    border-radius: 8px;
    transition: all 0.3s;
    font-family: inherit;
}

.form-control:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
}

.form-control.error {
    border-color: #e74c3c;
}

.field-error {
    display: none;
    margin-top: 6px;
    font-size: 13px;
    color: #e74c3c;
}

.help-text {
    margin-top: 6px;
    font-size: 13px;
    color: #95a5a6;
    font-style: italic;
}

/* Radio and Checkbox Styles */
.radio-option,
.checkbox-option {
    display: flex;
    align-items: center;
    padding: 12px;
    margin-bottom: 8px;
    border: 2px solid #dfe6e9;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
}

.radio-option:hover,
.checkbox-option:hover {
    background: #f8f9fa;
    border-color: #3498db;
}

.radio-option input,
.checkbox-option input {
    margin-right: 12px;
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.radio-option input:checked + span,
.checkbox-option input:checked + span {
    font-weight: 600;
    color: #3498db;
}

/* Form Actions */
.form-actions {
    width: 100%;
    margin-top: 30px;
}

.btn-primary {
    width: 100%;
    padding: 16px;
    font-size: 16px;
    font-weight: 600;
    color: white;
    background: linear-gradient(135deg, #3498db, #2980b9);
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
}

.btn-primary:active {
    transform: translateY(0);
}

.form-body.loading .btn-primary {
    opacity: 0.6;
    pointer-events: none;
    position: relative;
}

.form-body.loading .btn-primary::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    border: 3px solid white;
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
}

@keyframes spin {
    to { transform: translateY(-50%) rotate(360deg); }
}

/* Form Footer */
.form-footer {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #ecf0f1;
    text-align: center;
}

.privacy-note {
    font-size: 12px;
    color: #95a5a6;
    line-height: 1.5;
}

/* Notifications */
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 16px 24px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transform: translateX(400px);
    transition: transform 0.3s;
    z-index: 10000;
}

.notification.show {
    transform: translateX(0);
}

.notification-success {
    background: #2ecc71;
    color: white;
}

.notification-error {
    background: #e74c3c;
    color: white;
}
```

---

## 🔄 Part 5: Real-Time Web App Updates

### 5.1 WebSocket Integration (Laravel Reverb/Pusher)

```php
// app/Events/QRCodeScanned.php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QRCodeScanned implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $qrCode;
    public $scanData;
    public $user;

    public function __construct($qrCode, $scanData, $user)
    {
        $this->qrCode = $qrCode;
        $this->scanData = $scanData;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn()
    {
        return [
            new Channel('qr-activity'),
            new Channel('qr-code.' . $this->qrCode->id)
        ];
    }

    /**
     * Data to broadcast
     */
    public function broadcastWith()
    {
        return [
            'qr_code_id' => $this->qrCode->id,
            'scan_type' => $this->qrCode->type,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'avatar' => $this->user->avatar_url
            ],
            'timestamp' => now()->toIso8601String(),
            'location' => $this->scanData['location'] ?? null,
            'action' => $this->scanData['action'] ?? null
        ];
    }
}
```

### 5.2 Real-Time Dashboard (Admin View)

```javascript
// public/js/qr-realtime-dashboard.js
class QRRealTimeDashboard {
    constructor() {
        this.stats = {
            activeQRCodes: 0,
            todayScans: 0,
            successRate: 0
        };
        this.recentScans = [];
        this.initializeWebSocket();
        this.initializeCharts();
    }

    /**
     * Initialize WebSocket connection
     */
    initializeWebSocket() {
        // Using Laravel Echo with Pusher or Reverb
        window.Echo.channel('qr-activity')
            .listen('QRCodeScanned', (data) => {
                this.handleNewScan(data);
            });

        // Subscribe to all active QR code channels
        this.subscribeToActiveQRs();
    }

    /**
     * Handle new scan event
     */
    handleNewScan(scanData) {
        // Update stats
        this.stats.todayScans++;
        this.updateStatsDisplay();

        // Add to recent scans list
        this.addToRecentScans(scanData);

        // Update charts
        this.updateCharts(scanData);

        // Show notification
        this.showScanNotification(scanData);

        // Play sound
        this.playNotificationSound();

        // Update specific QR card if visible
        this.updateQRCard(scanData.qr_code_id);
    }

    /**
     * Add scan to recent activity feed
     */
    addToRecentScans(scanData) {
        this.recentScans.unshift(scanData);
        if (this.recentScans.length > 50) {
            this.recentScans.pop();
        }

        this.renderRecentScans();
    }

    /**
     * Render recent scans list
     */
    renderRecentScans() {
        const container = document.getElementById('recent-scans-list');

        const html = this.recentScans.map(scan => `
            <div class="scan-item">
                <img src="${scan.user.avatar}" class="user-avatar" alt="${scan.user.name}">
                <div class="scan-info">
                    <div class="user-name">${scan.user.name}</div>
                    <div class="scan-type">${this.formatScanType(scan.scan_type)}</div>
                </div>
                <div class="scan-time">${this.formatTime(scan.timestamp)}</div>
            </div>
        `).join('');

        container.innerHTML = html;
    }

    /**
     * Update stats display
     */
    updateStatsDisplay() {
        document.getElementById('stat-active-qrs').textContent = this.stats.activeQRCodes;
        document.getElementById('stat-today-scans').textContent = this.stats.todayScans;
        document.getElementById('stat-success-rate').textContent = this.stats.successRate + '%';

        // Animate stat change
        this.animateStatChange('stat-today-scans');
    }

    /**
     * Initialize charts
     */
    initializeCharts() {
        // Scans per hour chart
        this.scansChart = new Chart(document.getElementById('scans-chart'), {
            type: 'line',
            data: {
                labels: this.generateHourLabels(),
                datasets: [{
                    label: 'Scans',
                    data: Array(24).fill(0),
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                animation: {
                    duration: 750
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // QR Type Distribution
        this.typeChart = new Chart(document.getElementById('type-chart'), {
            type: 'doughnut',
            data: {
                labels: ['Attendance', 'Payment', 'Registration', 'Other'],
                datasets: [{
                    data: [0, 0, 0, 0],
                    backgroundColor: ['#3498db', '#2ecc71', '#e74c3c', '#f39c12']
                }]
            }
        });
    }

    /**
     * Update charts with new scan
     */
    updateCharts(scanData) {
        // Update hourly chart
        const hour = new Date(scanData.timestamp).getHours();
        this.scansChart.data.datasets[0].data[hour]++;
        this.scansChart.update();

        // Update type distribution
        const typeIndex = this.getScanTypeIndex(scanData.scan_type);
        this.typeChart.data.datasets[0].data[typeIndex]++;
        this.typeChart.update();
    }

    /**
     * Show scan notification
     */
    showScanNotification(scanData) {
        const notification = document.createElement('div');
        notification.className = 'live-notification';
        notification.innerHTML = `
            <div class="notification-content">
                <img src="${scanData.user.avatar}" alt="${scanData.user.name}">
                <div>
                    <strong>${scanData.user.name}</strong>
                    <div>${this.formatScanType(scanData.scan_type)}</div>
                </div>
            </div>
        `;

        document.getElementById('notifications-container').appendChild(notification);

        setTimeout(() => notification.classList.add('show'), 100);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }

    /**
     * Update individual QR card
     */
    async updateQRCard(qrCodeId) {
        const card = document.querySelector(`[data-qr-id="${qrCodeId}"]`);
        if (!card) return;

        // Fetch latest QR data
        const response = await fetch(`/api/v1/qr-management/${qrCodeId}`);
        const data = await response.json();

        // Update scan count
        const scanCount = card.querySelector('.scan-count');
        if (scanCount) {
            scanCount.textContent = data.scan_count;
            scanCount.classList.add('updated');
            setTimeout(() => scanCount.classList.remove('updated'), 1000);
        }

        // Update last scan time
        const lastScan = card.querySelector('.last-scan');
        if (lastScan) {
            lastScan.textContent = this.formatTime(data.last_scanned);
        }
    }

    /**
     * Helper methods
     */
    formatTime(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const diff = now - date;

        if (diff < 60000) return 'Just now';
        if (diff < 3600000) return Math.floor(diff / 60000) + 'm ago';
        if (diff < 86400000) return Math.floor(diff / 3600000) + 'h ago';
        return date.toLocaleDateString();
    }

    formatScanType(type) {
        const types = {
            'SERVICE_ATTENDANCE': 'Service Check-in',
            'PAYMENT': 'Payment',
            'EVENT_REGISTRATION': 'Event Registration',
            'VISITOR_REGISTRATION': 'Visitor Form'
        };
        return types[type] || type;
    }

    getScanTypeIndex(type) {
        const types = ['SERVICE_ATTENDANCE', 'PAYMENT', 'EVENT_REGISTRATION'];
        const index = types.indexOf(type);
        return index >= 0 ? index : 3; // 3 = Other
    }

    generateHourLabels() {
        return Array.from({ length: 24 }, (_, i) =>
            `${i.toString().padStart(2, '0')}:00`
        );
    }

    animateStatChange(elementId) {
        const el = document.getElementById(elementId);
        el.classList.add('stat-change');
        setTimeout(() => el.classList.remove('stat-change'), 500);
    }

    playNotificationSound() {
        const audio = new Audio('/sounds/scan-notification.mp3');
        audio.volume = 0.3;
        audio.play().catch(() => {});
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('qr-dashboard')) {
        new QRRealTimeDashboard();
    }
});
```

---

## 📊 Part 6: Complete Implementation Guide

### 6.1 Backend Implementation Steps

```bash
# Step 1: Database Setup
php artisan migrate

# Step 2: Install Dependencies
composer require simplesoftwareio/simple-qrcode
composer require pusher/pusher-php-server  # For real-time

npm install --save laravel-echo pusher-js
npm install --save jsqr  # QR decoder for mobile

# Step 3: Configure Broadcasting
php artisan vendor:publish --provider="Illuminate\Broadcasting\BroadcastServiceProvider"

# Update .env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_key
PUSHER_APP_SECRET=your_secret
PUSHER_APP_CLUSTER=your_cluster

# Step 4: Generate Encryption Keys
php artisan key:generate
php artisan config:cache
```

### 6.2 Frontend Implementation Steps

```bash
# Step 1: Compile Assets
npm install
npm run build

# Step 2: Create PWA Manifest
# public/manifest.json
{
    "name": "Church CMS Scanner",
    "short_name": "CMS Scanner",
    "start_url": "/mobile/scanner",
    "display": "standalone",
    "background_color": "#ffffff",
    "theme_color": "#3498db",
    "icons": [
        {
            "src": "/images/icon-192.png",
            "sizes": "192x192",
            "type": "image/png"
        },
        {
            "src": "/images/icon-512.png",
            "sizes": "512x512",
            "type": "image/png"
        }
    ]
}

# Step 3: Register Service Worker
# resources/views/layouts/app.blade.php
<script>
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js');
}
</script>
```

### 6.3 Testing Checklist

```yaml
Web App Testing:
  Admin Dashboard:
    - [ ] Quick Generate creates QR codes
    - [ ] Custom generator shows all field types
    - [ ] Form builder drag-and-drop works
    - [ ] QR code preview displays correctly
    - [ ] Download QR image (PNG) works
    - [ ] Print template formats correctly
    - [ ] Share dialog generates short URLs

  Real-Time Features:
    - [ ] Dashboard updates on new scan
    - [ ] Recent scans feed appears
    - [ ] Charts update dynamically
    - [ ] Notifications show
    - [ ] Sound plays on scan

Mobile/PWA Testing:
  Scanner:
    - [ ] Camera initializes
    - [ ] QR detection works
    - [ ] Vibration feedback triggers
    - [ ] Audio beep plays
    - [ ] Detection animation shows

  Dynamic Forms:
    - [ ] Forms render correctly
    - [ ] Pre-fill works for logged-in users
    - [ ] Conditional fields show/hide
    - [ ] Validation works
    - [ ] Submission succeeds
    - [ ] Success message appears

Integration Testing:
  End-to-End Flow:
    - [ ] Admin generates QR
    - [ ] QR is shared (print/digital)
    - [ ] User scans QR
    - [ ] Form appears
    - [ ] User submits form
    - [ ] Data saves to database
    - [ ] Admin dashboard updates
    - [ ] Notification sent to admin

Performance:
    - [ ] QR generation < 500ms
    - [ ] Scanner detects in < 1s
    - [ ] Form submission < 2s
    - [ ] Real-time update latency < 500ms
```

---

## 🚀 Deployment Guide

### Production Deployment

```bash
# 1. Optimize application
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 2. Build production assets
npm run build

# 3. Set up Queue Worker (for real-time)
php artisan queue:work --daemon

# 4. Set up Supervisor (Linux)
# /etc/supervisor/conf.d/laravel-worker.conf
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/artisan queue:work
autostart=true
autorestart=true
user=www-data
numprocs=3
redirect_stderr=true
stdout_logfile=/path/to/worker.log

# 5. Configure SSL (for camera access)
# Camera API requires HTTPS in production

# 6. Set up CDN for QR images (optional)
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket
```

---

## 📋 Summary: What Makes This Implementation Better

### Key Improvements Over Previous Version:

1. **Perfect Web App Experience**
   - One-click QR generation for common uses
   - Visual form builder
   - Instant preview
   - Multiple sharing options

2. **Smart Mobile Scanner**
   - Auto-detection with feedback
   - Offline support
   - GPS verification
   - Smooth animations

3. **Dynamic Forms**
   - Context-aware fields
   - Conditional logic
   - Auto-fill for members
   - Real-time validation
   - Mobile-first design

4. **Real-Time Updates**
   - WebSocket integration
   - Live dashboard
   - Instant notifications
   - Animated charts
   - Activity feed

5. **Complete Workflow**
   - Admin generates → User scans → Form fills → Data updates → Admin notified
   - Works offline
   - Syncs when online
   - No manual data entry

---

## 📞 Next Steps

1. **Review** this implementation plan
2. **Install** dependencies
3. **Implement** backend (models, controllers, events)
4. **Build** frontend (scanner, forms, dashboard)
5. **Test** complete workflow
6. **Deploy** to production
7. **Train** staff and users

**Estimated Implementation Time**: 2-3 weeks for complete system

---

**Document Version**: 2.0
**Status**: Production-Ready Design
**Last Updated**: January 2026
