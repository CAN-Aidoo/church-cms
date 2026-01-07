# Church CMS - Improved QR Code Implementation v2.0
## Complete Admin-to-User Workflow System

---

## 🎯 Executive Summary

This document presents an improved QR code implementation that creates a seamless flow from admin generation to user interaction, with emphasis on:

1. **Perfect Web App Experience** - Admin generates QR codes effortlessly
2. **Flexible Sharing** - Digital and printed QR code distribution
3. **Smart Mobile Scanner** - Camera-based QR scanning with offline support
4. **Dynamic Forms** - Context-aware forms appear after scanning
5. **Real-Time Updates** - Web app reflects all scan activities instantly

**Key Improvement**: The QR code now acts as a **trigger** that launches contextual workflows, not just a static identifier.

---

## 🏗 System Architecture Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                     IMPROVED QR WORKFLOW                         │
└─────────────────────────────────────────────────────────────────┘

ADMIN SIDE (Web App)                    USER SIDE (Mobile/PWA)
┌──────────────────────┐                ┌────────────────────────┐
│  1. GENERATE         │                │  4. SCAN               │
│     - Select purpose │                │     - Open camera      │
│     - Configure      │                │     - Point at QR      │
│     - Generate       │                │     - Auto-decode      │
└──────────┬───────────┘                └────────┬───────────────┘
           │                                      │
           v                                      v
┌──────────────────────┐                ┌────────────────────────┐
│  2. SHARE            │                │  5. DYNAMIC FORM       │
│     - Print poster   │                │     - Context-based    │
│     - Digital link   │                │     - Auto-prefill     │
│     - SMS broadcast  │                │     - Offline support  │
└──────────┬───────────┘                └────────┬───────────────┘
           │                                      │
           v                                      v
┌──────────────────────┐                ┌────────────────────────┐
│  3. MONITOR          │◄───────────────│  6. SUBMIT & UPDATE    │
│     - Real-time view │   WebSocket    │     - Validate         │
│     - See scans      │   Push         │     - Save data        │
│     - Analytics      │   Notification │     - Confirm success  │
└──────────────────────┘                └────────────────────────┘
```

---

## 📱 Part 1: Web App - Perfect QR Generation Experience

### 1.1 Admin Dashboard Integration

#### Enhanced QR Tools Menu

```yaml
Navigation Menu Addition:
  Main Menu:
    ├── Dashboard
    ├── Members
    ├── Finance
    ├── Events
    ├── 🆕 QR Tools           # Prominent position
    │   ├── Quick Generate    # One-click common QR codes
    │   ├── Custom QR         # Advanced configuration
    │   ├── Active Codes      # Live monitoring
    │   ├── Scan Activity     # Real-time feed
    │   └── Analytics         # Reports & insights
```

#### Quick Generate Interface (One-Click QR Creation)

```html
<!-- resources/views/qr-management/quick-generate.blade.php -->
<div class="qr-quick-generate">
    <h2>Quick QR Code Generation</h2>
    <p class="subtitle">Generate commonly used QR codes instantly</p>

    <div class="qr-templates">
        <!-- Service Attendance -->
        <div class="qr-template-card">
            <div class="icon">📋</div>
            <h3>Sunday Service</h3>
            <p>Attendance check-in for this Sunday</p>
            <button onclick="generateQuick('service', 'sunday')"
                    class="btn-primary">
                Generate Now
            </button>
            <div class="preview" id="preview-service-sunday"></div>
        </div>

        <!-- Offering/Payment -->
        <div class="qr-template-card">
            <div class="icon">💰</div>
            <h3>Offering</h3>
            <p>Digital offering collection</p>
            <button onclick="generateQuick('payment', 'offering')"
                    class="btn-primary">
                Generate Now
            </button>
            <div class="preview" id="preview-payment-offering"></div>
        </div>

        <!-- Visitor Registration -->
        <div class="qr-template-card">
            <div class="icon">👤</div>
            <h3>Visitor Form</h3>
            <p>First-time visitor registration</p>
            <button onclick="generateQuick('visitor', 'registration')"
                    class="btn-primary">
                Generate Now
            </button>
            <div class="preview" id="preview-visitor-registration"></div>
        </div>

        <!-- Event Registration -->
        <div class="qr-template-card">
            <div class="icon">📅</div>
            <h3>Event Registration</h3>
            <p>Register for upcoming event</p>
            <select id="event-selector" onchange="updateEventPreview()">
                <option value="">Select Event...</option>
                @foreach($upcomingEvents as $event)
                <option value="{{ $event->id }}">{{ $event->title }}</option>
                @endforeach
            </select>
            <button onclick="generateQuick('event', getSelectedEvent())"
                    class="btn-primary">
                Generate Now
            </button>
            <div class="preview" id="preview-event"></div>
        </div>

        <!-- Prayer Request -->
        <div class="qr-template-card">
            <div class="icon">🙏</div>
            <h3>Prayer Request</h3>
            <p>Submit prayer request</p>
            <button onclick="generateQuick('prayer', 'request')"
                    class="btn-primary">
                Generate Now
            </button>
            <div class="preview" id="preview-prayer"></div>
        </div>

        <!-- Membership Update -->
        <div class="qr-template-card">
            <div class="icon">✏️</div>
            <h3>Update Profile</h3>
            <p>Members update their information</p>
            <button onclick="generateQuick('member', 'update')"
                    class="btn-primary">
                Generate Now
            </button>
            <div class="preview" id="preview-member-update"></div>
        </div>
    </div>
</div>

<script>
async function generateQuick(type, subtype) {
    const button = event.target;
    const preview = button.parentElement.querySelector('.preview');

    // Show loading
    button.disabled = true;
    button.textContent = 'Generating...';
    preview.innerHTML = '<div class="spinner"></div>';

    try {
        const response = await fetch('/api/v1/qr-management/quick-generate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                type: type,
                subtype: subtype,
                auto_config: true  // Use smart defaults
            })
        });

        const result = await response.json();

        if (result.success) {
            // Show QR code immediately
            preview.innerHTML = `
                <img src="${result.data.image_url}" alt="QR Code" class="qr-preview-img">
                <div class="qr-actions">
                    <button onclick="downloadQR('${result.data.id}')">
                        📥 Download
                    </button>
                    <button onclick="printQR('${result.data.id}')">
                        🖨️ Print
                    </button>
                    <button onclick="shareQR('${result.data.id}')">
                        📤 Share
                    </button>
                </div>
            `;

            // Show success notification
            showNotification('QR Code generated successfully!', 'success');

            // Update real-time dashboard
            updateDashboardStats();
        }
    } catch (error) {
        preview.innerHTML = '<p class="error">Generation failed</p>';
        showNotification('Failed to generate QR code', 'error');
    } finally {
        button.disabled = false;
        button.textContent = 'Generate Now';
    }
}
</script>
```

### 1.2 Advanced Custom QR Generator

```html
<!-- resources/views/qr-management/custom-generate.blade.php -->
<div class="qr-custom-generator">
    <h2>Custom QR Code Generator</h2>

    <form id="custom-qr-form">
        <!-- Step 1: Purpose Selection -->
        <div class="form-section">
            <h3>Step 1: Select Purpose</h3>
            <div class="purpose-selector">
                <label class="purpose-option">
                    <input type="radio" name="purpose" value="attendance" checked>
                    <div class="option-card">
                        <span class="icon">📋</span>
                        <span class="label">Attendance</span>
                    </div>
                </label>

                <label class="purpose-option">
                    <input type="radio" name="purpose" value="payment">
                    <div class="option-card">
                        <span class="icon">💰</span>
                        <span class="label">Payment/Offering</span>
                    </div>
                </label>

                <label class="purpose-option">
                    <input type="radio" name="purpose" value="registration">
                    <div class="option-card">
                        <span class="icon">📝</span>
                        <span class="label">Registration</span>
                    </div>
                </label>

                <label class="purpose-option">
                    <input type="radio" name="purpose" value="data_collection">
                    <div class="option-card">
                        <span class="icon">📊</span>
                        <span class="label">Data Collection</span>
                    </div>
                </label>
            </div>
        </div>

        <!-- Step 2: Dynamic Configuration (changes based on purpose) -->
        <div class="form-section" id="dynamic-config">
            <!-- Populated by JavaScript based on selected purpose -->
        </div>

        <!-- Step 3: Form Fields Configuration -->
        <div class="form-section">
            <h3>Step 3: Configure Form Fields (shown after scan)</h3>
            <p class="help-text">Users will see these fields after scanning the QR code</p>

            <div id="form-fields-builder">
                <!-- Drag-and-drop form builder -->
                <div class="available-fields">
                    <h4>Available Fields</h4>
                    <div class="field-palette">
                        <div class="field-item" draggable="true" data-field-type="text">
                            📝 Text Input
                        </div>
                        <div class="field-item" draggable="true" data-field-type="email">
                            📧 Email
                        </div>
                        <div class="field-item" draggable="true" data-field-type="phone">
                            📱 Phone Number
                        </div>
                        <div class="field-item" draggable="true" data-field-type="select">
                            📋 Dropdown
                        </div>
                        <div class="field-item" draggable="true" data-field-type="checkbox">
                            ☑️ Checkbox
                        </div>
                        <div class="field-item" draggable="true" data-field-type="date">
                            📅 Date
                        </div>
                        <div class="field-item" draggable="true" data-field-type="textarea">
                            📄 Text Area
                        </div>
                        <div class="field-item" draggable="true" data-field-type="number">
                            🔢 Number
                        </div>
                    </div>
                </div>

                <div class="form-preview">
                    <h4>Form Preview (What users will see)</h4>
                    <div id="form-canvas" class="drop-zone">
                        <p class="placeholder">Drag fields here to build your form</p>
                    </div>
                </div>
            </div>

            <!-- Pre-built templates -->
            <div class="form-templates">
                <h4>Or use a template:</h4>
                <button type="button" onclick="loadFormTemplate('visitor')">
                    Visitor Information
                </button>
                <button type="button" onclick="loadFormTemplate('member-update')">
                    Member Profile Update
                </button>
                <button type="button" onclick="loadFormTemplate('event-registration')">
                    Event Registration
                </button>
                <button type="button" onclick="loadFormTemplate('prayer-request')">
                    Prayer Request
                </button>
            </div>
        </div>

        <!-- Step 4: QR Code Settings -->
        <div class="form-section">
            <h3>Step 4: QR Code Settings</h3>

            <div class="settings-grid">
                <div class="setting-item">
                    <label>
                        <input type="checkbox" name="location_required" checked>
                        Require GPS Location
                    </label>
                    <p class="help-text">Ensures users are physically present</p>
                </div>

                <div class="setting-item">
                    <label>Location Radius (meters)</label>
                    <input type="number" name="location_radius" value="100" min="10" max="1000">
                    <p class="help-text">Maximum distance from church</p>
                </div>

                <div class="setting-item">
                    <label>
                        <input type="checkbox" name="allow_offline">
                        Allow Offline Scanning
                    </label>
                    <p class="help-text">Data syncs when online</p>
                </div>

                <div class="setting-item">
                    <label>Expiration</label>
                    <select name="expiration">
                        <option value="4">4 hours</option>
                        <option value="24" selected>24 hours</option>
                        <option value="168">1 week</option>
                        <option value="never">Never</option>
                    </select>
                </div>

                <div class="setting-item">
                    <label>
                        <input type="checkbox" name="limit_one_per_user">
                        One scan per user
                    </label>
                    <p class="help-text">Prevents duplicate submissions</p>
                </div>

                <div class="setting-item">
                    <label>
                        <input type="checkbox" name="require_authentication">
                        Authentication Required
                    </label>
                    <p class="help-text">Only logged-in members can scan</p>
                </div>
            </div>
        </div>

        <!-- Generate Button -->
        <div class="form-actions">
            <button type="button" onclick="previewQR()" class="btn-secondary">
                👁️ Preview
            </button>
            <button type="submit" class="btn-primary">
                ✨ Generate QR Code
            </button>
        </div>
    </form>
</div>

<script>
// Dynamic configuration based on purpose
document.querySelectorAll('input[name="purpose"]').forEach(radio => {
    radio.addEventListener('change', function() {
        loadPurposeConfig(this.value);
    });
});

function loadPurposeConfig(purpose) {
    const configDiv = document.getElementById('dynamic-config');

    const configs = {
        attendance: `
            <h3>Step 2: Attendance Configuration</h3>
            <label>Service Date</label>
            <input type="date" name="service_date" required>

            <label>Service Type</label>
            <select name="service_type">
                <option value="sunday_first">Sunday First Service</option>
                <option value="sunday_second">Sunday Second Service</option>
                <option value="wednesday">Wednesday Service</option>
                <option value="friday">Friday Service</option>
            </select>

            <label>Service Time</label>
            <input type="time" name="service_time" value="07:00">
        `,

        payment: `
            <h3>Step 2: Payment Configuration</h3>
            <label>Payment Type</label>
            <select name="payment_type">
                <option value="offering">Regular Offering</option>
                <option value="tithe">Tithe</option>
                <option value="campaign">Special Campaign</option>
                <option value="donation">General Donation</option>
            </select>

            <label>Suggested Amount</label>
            <input type="number" name="suggested_amount" placeholder="Optional">

            <label>Campaign Name (if applicable)</label>
            <input type="text" name="campaign_name">

            <label>Payment Methods</label>
            <div>
                <label><input type="checkbox" name="methods[]" value="card" checked> Card</label>
                <label><input type="checkbox" name="methods[]" value="mobile_money" checked> Mobile Money</label>
                <label><input type="checkbox" name="methods[]" value="bank_transfer"> Bank Transfer</label>
            </div>
        `,

        registration: `
            <h3>Step 2: Registration Configuration</h3>
            <label>Registration For</label>
            <select name="registration_type" onchange="loadRegistrationSubConfig(this.value)">
                <option value="event">Event</option>
                <option value="program">Program/Ministry</option>
                <option value="visitor">First-Time Visitor</option>
                <option value="membership">New Membership</option>
            </select>

            <div id="registration-sub-config"></div>

            <label>Registration Capacity</label>
            <input type="number" name="capacity" placeholder="Leave empty for unlimited">

            <label>Registration Deadline</label>
            <input type="datetime-local" name="deadline">
        `,

        data_collection: `
            <h3>Step 2: Data Collection Configuration</h3>
            <label>Collection Purpose</label>
            <input type="text" name="collection_purpose"
                   placeholder="e.g., Member Directory Update, Survey">

            <label>Description</label>
            <textarea name="collection_description" rows="3"
                      placeholder="Explain what information you're collecting and why"></textarea>

            <label>Data Storage</label>
            <select name="storage_module">
                <option value="members">Members Module</option>
                <option value="custom">Custom Database</option>
                <option value="export">Export Only (CSV)</option>
            </select>
        `
    };

    configDiv.innerHTML = configs[purpose] || '';
}

// Initialize with default
loadPurposeConfig('attendance');
</script>
```

---

## 📤 Part 2: Sharing System (Print & Digital)

### 2.1 Multi-Channel Distribution

```javascript
// app/Services/QRDistributionService.php
class QRDistributionService {
    /**
     * Generate shareable assets for QR code
     */
    public function createShareableAssets($qrCodeId) {
        $qr = QRCode::findOrFail($qrCodeId);

        return [
            // Digital sharing
            'digital' => [
                'short_url' => $this->generateShortURL($qr),
                'deep_link' => $this->generateDeepLink($qr),
                'qr_image_url' => route('qr.image', $qr->id),
                'share_page_url' => route('qr.share', $qr->id),
            ],

            // Print assets
            'print' => [
                'poster_a4' => $this->generatePoster($qr, 'A4'),
                'poster_a3' => $this->generatePoster($qr, 'A3'),
                'banner' => $this->generateBanner($qr),
                'table_tent' => $this->generateTableTent($qr),
                'business_card' => $this->generateBusinessCard($qr),
            ],

            // Broadcast channels
            'broadcast' => [
                'sms_message' => $this->generateSMSMessage($qr),
                'email_template' => $this->generateEmailTemplate($qr),
                'whatsapp_message' => $this->generateWhatsAppMessage($qr),
                'announcement_slide' => $this->generateSlide($qr),
            ]
        ];
    }

    /**
     * Generate short URL for easy sharing
     */
    private function generateShortURL($qr) {
        $shortCode = Str::random(6);

        ShortURL::create([
            'code' => $shortCode,
            'qr_code_id' => $qr->id,
            'expires_at' => $qr->expires_at
        ]);

        return url("/q/{$shortCode}");
    }

    /**
     * Generate printable poster
     */
    private function generatePoster($qr, $size = 'A4') {
        $pdf = PDF::loadView('qr-management.print.poster', [
            'qr' => $qr,
            'size' => $size,
            'instructions' => $this->getInstructions($qr->type)
        ]);

        return $pdf->output();
    }
}
```

### 2.2 Print-Ready Templates

```html
<!-- resources/views/qr-management/print/poster.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>QR Code Poster</title>
    <style>
        @page { size: {{ $size }}; margin: 0; }
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 40px;
            margin: 0;
        }
        .header {
            margin-bottom: 30px;
        }
        .church-logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .title {
            font-size: 36px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 20px;
            color: #7f8c8d;
        }
        .qr-container {
            margin: 40px 0;
        }
        .qr-image {
            width: 400px;
            height: 400px;
            margin: 0 auto;
            border: 10px solid #3498db;
            padding: 20px;
            background: white;
        }
        .instructions {
            font-size: 18px;
            margin-top: 30px;
            padding: 0 20px;
        }
        .instructions ol {
            text-align: left;
            max-width: 600px;
            margin: 20px auto;
        }
        .instructions li {
            margin-bottom: 10px;
            line-height: 1.6;
        }
        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: #95a5a6;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('images/church-logo.png') }}" class="church-logo" alt="Church Logo">
        <div class="title">{{ $qr->title ?? 'Scan to Participate' }}</div>
        <div class="subtitle">{{ $qr->description ?? 'Use your phone camera' }}</div>
    </div>

    <div class="qr-container">
        <img src="{{ $qr->image_url }}" class="qr-image" alt="QR Code">
    </div>

    <div class="instructions">
        <h3>How to Scan:</h3>
        <ol>
            <li><strong>Open your phone camera</strong> (iPhone or Android)</li>
            <li><strong>Point at the QR code</strong> above</li>
            <li><strong>Tap the notification</strong> that appears</li>
            <li><strong>Fill out the form</strong> on your phone</li>
        </ol>

        @if($instructions)
        <div class="specific-instructions">
            <h3>Purpose:</h3>
            <p>{!! $instructions !!}</p>
        </div>
        @endif
    </div>

    <div class="footer">
        <p>Valid until: {{ $qr->expires_at->format('F j, Y g:i A') }}</p>
        <p>Generated: {{ now()->format('F j, Y') }}</p>
    </div>
</body>
</html>
```

### 2.3 Digital Sharing Interface

```html
<!-- QR Share Dialog -->
<div id="share-modal" class="modal">
    <div class="modal-content">
        <h2>Share QR Code</h2>

        <!-- Quick Share Options -->
        <div class="quick-share">
            <button onclick="shareVia('whatsapp')" class="share-btn whatsapp">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </button>
            <button onclick="shareVia('sms')" class="share-btn sms">
                <i class="fas fa-sms"></i> SMS
            </button>
            <button onclick="shareVia('email')" class="share-btn email">
                <i class="fas fa-envelope"></i> Email
            </button>
            <button onclick="copyLink()" class="share-btn link">
                <i class="fas fa-link"></i> Copy Link
            </button>
        </div>

        <!-- Short URL Display -->
        <div class="short-url-container">
            <label>Short Link:</label>
            <div class="url-display">
                <input type="text" value="{{ $shortUrl }}" readonly id="short-url">
                <button onclick="copyShortUrl()">Copy</button>
            </div>
        </div>

        <!-- QR Code Preview -->
        <div class="qr-preview">
            <img src="{{ $qrImageUrl }}" alt="QR Code">
        </div>

        <!-- Download Options -->
        <div class="download-options">
            <h3>Download for Print:</h3>
            <button onclick="download('poster-a4')">
                📄 Poster (A4)
            </button>
            <button onclick="download('poster-a3')">
                📄 Poster (A3)
            </button>
            <button onclick="download('banner')">
                🎌 Banner
            </button>
            <button onclick="download('table-tent')">
                🏷️ Table Tent
            </button>
        </div>

        <!-- Broadcast Options (Admin only) -->
        <div class="broadcast-options">
            <h3>Send to Members:</h3>
            <button onclick="openBroadcast('sms')">
                📱 SMS Broadcast
            </button>
            <button onclick="openBroadcast('email')">
                ✉️ Email Blast
            </button>
            <button onclick="openBroadcast('push')">
                🔔 Push Notification
            </button>
        </div>
    </div>
</div>

<script>
function shareVia(platform) {
    const qrData = {
        url: document.getElementById('short-url').value,
        title: '{{ $qr->title }}',
        message: 'Scan this QR code: {{ $qr->description }}'
    };

    switch(platform) {
        case 'whatsapp':
            window.open(`https://wa.me/?text=${encodeURIComponent(qrData.message + ' ' + qrData.url)}`);
            break;
        case 'sms':
            window.location.href = `sms:?body=${encodeURIComponent(qrData.message + ' ' + qrData.url)}`;
            break;
        case 'email':
            window.location.href = `mailto:?subject=${encodeURIComponent(qrData.title)}&body=${encodeURIComponent(qrData.message + ' ' + qrData.url)}`;
            break;
    }
}

function copyLink() {
    const url = document.getElementById('short-url');
    url.select();
    document.execCommand('copy');
    showNotification('Link copied to clipboard!', 'success');
}
</script>
```

---

## 📱 Part 3: Mobile Scanner Implementation

### 3.1 Progressive Web App (PWA) Scanner

```javascript
// public/js/qr-scanner.js
class MobileQRScanner {
    constructor() {
        this.video = null;
        this.canvas = null;
        this.stream = null;
        this.scanning = false;
        this.lastScan = null;
    }

    /**
     * Initialize camera and scanner
     */
    async initialize() {
        try {
            // Request camera permission
            this.stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'environment', // Back camera
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                }
            });

            // Setup video element
            this.video = document.getElementById('scanner-video');
            this.video.srcObject = this.stream;
            this.video.play();

            // Setup canvas for processing
            this.canvas = document.getElementById('scanner-canvas');
            this.context = this.canvas.getContext('2d');

            // Start scanning loop
            this.startScanning();

            return true;
        } catch (error) {
            console.error('Camera initialization failed:', error);
            this.showCameraError(error);
            return false;
        }
    }

    /**
     * Continuous scanning loop
     */
    startScanning() {
        this.scanning = true;
        this.scanFrame();
    }

    async scanFrame() {
        if (!this.scanning) return;

        // Draw current video frame to canvas
        this.canvas.width = this.video.videoWidth;
        this.canvas.height = this.video.videoHeight;
        this.context.drawImage(this.video, 0, 0, this.canvas.width, this.canvas.height);

        // Get image data
        const imageData = this.context.getImageData(0, 0, this.canvas.width, this.canvas.height);

        // Attempt to decode QR code
        try {
            const code = await this.decodeQRCode(imageData);

            if (code && code !== this.lastScan) {
                this.lastScan = code;
                this.onQRDetected(code);
                this.vibrate(); // Haptic feedback
                this.playBeep(); // Audio feedback
            }
        } catch (error) {
            // No QR code found in this frame, continue scanning
        }

        // Continue scanning
        requestAnimationFrame(() => this.scanFrame());
    }

    /**
     * Decode QR code from image data
     */
    async decodeQRCode(imageData) {
        // Using jsQR library
        const code = jsQR(imageData.data, imageData.width, imageData.height, {
            inversionAttempts: 'dontInvert'
        });

        return code ? code.data : null;
    }

    /**
     * Handle detected QR code
     */
    async onQRDetected(qrData) {
        // Stop scanning temporarily
        this.scanning = false;

        // Show detected visual
        this.showDetectionAnimation();

        // Validate and process QR code
        try {
            const result = await this.processQRCode(qrData);
            this.handleScanResult(result);
        } catch (error) {
            this.showError('Invalid QR code');
            // Resume scanning after 2 seconds
            setTimeout(() => this.startScanning(), 2000);
        }
    }

    /**
     * Process scanned QR code
     */
    async processQRCode(qrData) {
        // Get user location if required
        const location = await this.getCurrentLocation();

        // Send to backend for validation and processing
        const response = await fetch('/api/v1/qr-scan/process', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${this.getAuthToken()}`
            },
            body: JSON.stringify({
                qr_data: qrData,
                location: location,
                timestamp: new Date().toISOString(),
                device_info: this.getDeviceInfo()
            })
        });

        return await response.json();
    }

    /**
     * Handle scan result
     */
    handleScanResult(result) {
        if (result.success) {
            switch (result.action) {
                case 'show_form':
                    this.showDynamicForm(result.form_config);
                    break;
                case 'confirm':
                    this.showConfirmation(result.message);
                    break;
                case 'redirect':
                    window.location.href = result.url;
                    break;
            }
        } else {
            this.showError(result.error);
        }
    }

    /**
     * Get current GPS location
     */
    async getCurrentLocation() {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) {
                resolve(null);
                return;
            }

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    resolve({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                        accuracy: position.coords.accuracy
                    });
                },
                (error) => {
                    console.warn('Location error:', error);
                    resolve(null); // Allow scan without location if it fails
                },
                {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                }
            );
        });
    }

    /**
     * Haptic feedback
     */
    vibrate() {
        if (navigator.vibrate) {
            navigator.vibrate(200);
        }
    }

    /**
     * Audio feedback
     */
    playBeep() {
        const audio = new Audio('/sounds/beep.mp3');
        audio.play().catch(() => {});
    }

    /**
     * Show detection animation
     */
    showDetectionAnimation() {
        const overlay = document.getElementById('scan-overlay');
        overlay.classList.add('detected');
        setTimeout(() => overlay.classList.remove('detected'), 500);
    }

    /**
     * Stop scanner and release camera
     */
    stop() {
        this.scanning = false;
        if (this.stream) {
            this.stream.getTracks().forEach(track => track.stop());
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    const scanner = new MobileQRScanner();
    scanner.initialize();
});
</script>
```

### 3.2 Scanner UI

```html
<!-- resources/views/mobile/scanner.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>QR Scanner</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #000;
            overflow: hidden;
        }

        #scanner-container {
            position: relative;
            width: 100vw;
            height: 100vh;
        }

        #scanner-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #scanner-canvas {
            display: none;
        }

        #scan-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .scan-region {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 280px;
            height: 280px;
            border: 3px solid rgba(255, 255, 255, 0.5);
            border-radius: 20px;
        }

        .scan-region::before,
        .scan-region::after,
        .scan-region .corner-tl,
        .scan-region .corner-tr,
        .scan-region .corner-bl,
        .scan-region .corner-br {
            content: '';
            position: absolute;
            width: 30px;
            height: 30px;
            border: 4px solid #00ff00;
        }

        .scan-region::before {
            top: -2px;
            left: -2px;
            border-right: none;
            border-bottom: none;
        }

        .scan-region::after {
            top: -2px;
            right: -2px;
            border-left: none;
            border-bottom: none;
        }

        .scan-region .corner-bl {
            bottom: -2px;
            left: -2px;
            border-right: none;
            border-top: none;
        }

        .scan-region .corner-br {
            bottom: -2px;
            right: -2px;
            border-left: none;
            border-top: none;
        }

        /* Scanning animation */
        .scan-line {
            position: absolute;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #00ff00, transparent);
            animation: scan 2s infinite;
        }

        @keyframes scan {
            0%, 100% { top: 0; }
            50% { top: calc(100% - 2px); }
        }

        /* Detection animation */
        #scan-overlay.detected {
            background: rgba(0, 255, 0, 0.2);
            animation: flash 0.5s;
        }

        @keyframes flash {
            0%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }

        .instructions {
            position: absolute;
            bottom: 80px;
            left: 0;
            right: 0;
            text-align: center;
            color: white;
            padding: 20px;
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
        }

        .instructions h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .instructions p {
            font-size: 14px;
            opacity: 0.8;
        }

        .controls {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .control-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .control-btn:active {
            background: rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body>
    <div id="scanner-container">
        <video id="scanner-video" autoplay playsinline></video>
        <canvas id="scanner-canvas"></canvas>

        <div id="scan-overlay">
            <div class="scan-region">
                <span class="corner-tl"></span>
                <span class="corner-tr"></span>
                <span class="corner-bl"></span>
                <span class="corner-br"></span>
                <div class="scan-line"></div>
            </div>
        </div>

        <div class="instructions">
            <h2>Point at QR Code</h2>
            <p>Position the QR code within the frame</p>
        </div>

        <div class="controls">
            <button class="control-btn" onclick="toggleFlash()">
                💡
            </button>
            <button class="control-btn" onclick="switchCamera()">
                🔄
            </button>
            <button class="control-btn" onclick="close()">
                ✕
            </button>
        </div>
    </div>

    <script src="/js/jsQR.js"></script>
    <script src="/js/qr-scanner.js"></script>
</body>
</html>
```

---

*Continued in next message due to length...*
