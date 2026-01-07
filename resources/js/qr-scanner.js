/**
 * Church CMS - QR Scanner Module
 * Progressive Web App QR Code Scanner with Offline Support
 *
 * Features:
 * - Camera-based QR scanning using html5-qrcode
 * - Offline queue management with IndexedDB
 * - GPS location capture
 * - Background sync integration
 * - Haptic and audio feedback
 * - Real-time validation
 */

import { Html5Qrcode } from 'html5-qrcode';
import { openDB } from 'idb';

class QRScanner {
    constructor(options = {}) {
        this.scanner = null;
        this.isScanning = false;
        this.db = null;
        this.authToken = null;

        // Configuration
        this.config = {
            scannerElementId: options.scannerElementId || 'qr-scanner-viewport',
            resultDisplayId: options.resultDisplayId || 'scan-result',
            statusDisplayId: options.statusDisplayId || 'scan-status',
            qrboxSize: options.qrboxSize || 250,
            fps: options.fps || 10,
            apiEndpoint: options.apiEndpoint || '/api/qr-scan/process',
            batchSyncEndpoint: options.batchSyncEndpoint || '/api/qr-scan/batch-sync',
            enableSound: options.enableSound !== false,
            enableVibration: options.enableVibration !== false,
            enableGPS: options.enableGPS !== false,
            offlineMode: true,
        };

        // Audio feedback
        this.successSound = null;
        this.errorSound = null;

        // Network status
        this.isOnline = navigator.onLine;

        // Initialize
        this.init();
    }

    /**
     * Initialize scanner and database
     */
    async init() {
        try {
            // Initialize IndexedDB
            await this.initDatabase();

            // Load auth token
            await this.loadAuthToken();

            // Initialize audio
            if (this.config.enableSound) {
                this.initAudio();
            }

            // Setup network listeners
            this.setupNetworkListeners();

            // Setup service worker message listener
            this.setupServiceWorkerListener();

            console.log('[QR Scanner] Initialized successfully');
        } catch (error) {
            console.error('[QR Scanner] Initialization failed:', error);
            throw error;
        }
    }

    /**
     * Initialize IndexedDB for offline storage
     */
    async initDatabase() {
        this.db = await openDB('church-cms-offline', 1, {
            upgrade(db) {
                // Offline scans store
                if (!db.objectStoreNames.contains('scans')) {
                    const scanStore = db.createObjectStore('scans', {
                        keyPath: 'id',
                        autoIncrement: true
                    });
                    scanStore.createIndex('timestamp', 'timestamp');
                    scanStore.createIndex('synced', 'synced');
                }

                // Auth token store
                if (!db.objectStoreNames.contains('auth')) {
                    db.createObjectStore('auth');
                }

                // Scanner config store
                if (!db.objectStoreNames.contains('config')) {
                    db.createObjectStore('config');
                }
            },
        });
    }

    /**
     * Load authentication token from IndexedDB
     */
    async loadAuthToken() {
        try {
            const tokenData = await this.db.get('auth', 'token');
            this.authToken = tokenData?.value || null;

            if (!this.authToken) {
                console.warn('[QR Scanner] No auth token found in IndexedDB');
            }
        } catch (error) {
            console.error('[QR Scanner] Failed to load auth token:', error);
        }
    }

    /**
     * Save authentication token to IndexedDB
     */
    async saveAuthToken(token) {
        try {
            await this.db.put('auth', { value: token }, 'token');
            this.authToken = token;
        } catch (error) {
            console.error('[QR Scanner] Failed to save auth token:', error);
        }
    }

    /**
     * Initialize audio feedback
     */
    initAudio() {
        // Success beep (higher pitch)
        const successContext = new (window.AudioContext || window.webkitAudioContext)();
        const successOscillator = successContext.createOscillator();
        const successGain = successContext.createGain();
        successOscillator.connect(successGain);
        successGain.connect(successContext.destination);
        successOscillator.frequency.value = 800;
        successGain.gain.value = 0.3;
        this.successSound = { context: successContext, oscillator: successOscillator, gain: successGain };

        // Error beep (lower pitch)
        const errorContext = new (window.AudioContext || window.webkitAudioContext)();
        const errorOscillator = errorContext.createOscillator();
        const errorGain = errorContext.createGain();
        errorOscillator.connect(errorGain);
        errorGain.connect(errorContext.destination);
        errorOscillator.frequency.value = 200;
        errorGain.gain.value = 0.3;
        this.errorSound = { context: errorContext, oscillator: errorOscillator, gain: errorGain };
    }

    /**
     * Play success sound
     */
    playSuccessSound() {
        if (!this.config.enableSound || !this.successSound) return;

        try {
            const { context, oscillator, gain } = this.successSound;
            const newOscillator = context.createOscillator();
            newOscillator.connect(gain);
            newOscillator.frequency.value = 800;
            newOscillator.start();
            newOscillator.stop(context.currentTime + 0.1);
        } catch (error) {
            console.error('[QR Scanner] Audio error:', error);
        }
    }

    /**
     * Play error sound
     */
    playErrorSound() {
        if (!this.config.enableSound || !this.errorSound) return;

        try {
            const { context, oscillator, gain } = this.errorSound;
            const newOscillator = context.createOscillator();
            newOscillator.connect(gain);
            newOscillator.frequency.value = 200;
            newOscillator.start();
            newOscillator.stop(context.currentTime + 0.2);
        } catch (error) {
            console.error('[QR Scanner] Audio error:', error);
        }
    }

    /**
     * Vibrate device for feedback
     */
    vibrate(pattern = [100]) {
        if (!this.config.enableVibration) return;

        if ('vibrate' in navigator) {
            navigator.vibrate(pattern);
        }
    }

    /**
     * Get current GPS location
     */
    async getLocation() {
        if (!this.config.enableGPS) {
            return null;
        }

        return new Promise((resolve) => {
            if (!('geolocation' in navigator)) {
                console.warn('[QR Scanner] Geolocation not supported');
                resolve(null);
                return;
            }

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    resolve({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                        accuracy: position.coords.accuracy,
                        timestamp: position.timestamp,
                    });
                },
                (error) => {
                    console.warn('[QR Scanner] Geolocation error:', error.message);
                    resolve(null);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0,
                }
            );
        });
    }

    /**
     * Setup network status listeners
     */
    setupNetworkListeners() {
        window.addEventListener('online', () => {
            console.log('[QR Scanner] Network online');
            this.isOnline = true;
            this.updateStatus('Online - syncing queued scans...', 'success');
            this.triggerBackgroundSync();
        });

        window.addEventListener('offline', () => {
            console.log('[QR Scanner] Network offline');
            this.isOnline = false;
            this.updateStatus('Offline mode - scans will be queued', 'warning');
        });
    }

    /**
     * Setup service worker message listener
     */
    setupServiceWorkerListener() {
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.addEventListener('message', (event) => {
                if (event.data.type === 'SYNC_COMPLETE') {
                    console.log(`[QR Scanner] Synced ${event.data.count} offline scans`);
                    this.updateStatus(`Synced ${event.data.count} offline scans`, 'success');
                    this.playSuccessSound();
                }
            });
        }
    }

    /**
     * Start camera scanning
     */
    async startScanning() {
        if (this.isScanning) {
            console.warn('[QR Scanner] Already scanning');
            return;
        }

        try {
            this.scanner = new Html5Qrcode(this.config.scannerElementId);

            const config = {
                fps: this.config.fps,
                qrbox: { width: this.config.qrboxSize, height: this.config.qrboxSize },
                aspectRatio: 1.0,
            };

            await this.scanner.start(
                { facingMode: 'environment' }, // Use back camera
                config,
                (decodedText, decodedResult) => this.onScanSuccess(decodedText, decodedResult),
                (errorMessage) => this.onScanError(errorMessage)
            );

            this.isScanning = true;
            this.updateStatus('Scanner active - point camera at QR code', 'info');
            console.log('[QR Scanner] Camera scanning started');
        } catch (error) {
            console.error('[QR Scanner] Failed to start camera:', error);
            this.updateStatus('Camera access denied or unavailable', 'error');
            throw error;
        }
    }

    /**
     * Stop camera scanning
     */
    async stopScanning() {
        if (!this.isScanning || !this.scanner) {
            return;
        }

        try {
            await this.scanner.stop();
            this.scanner.clear();
            this.scanner = null;
            this.isScanning = false;
            this.updateStatus('Scanner stopped', 'info');
            console.log('[QR Scanner] Camera scanning stopped');
        } catch (error) {
            console.error('[QR Scanner] Failed to stop scanner:', error);
        }
    }

    /**
     * Handle successful QR scan
     */
    async onScanSuccess(decodedText, decodedResult) {
        console.log('[QR Scanner] Decoded:', decodedText);

        // Stop scanning temporarily to prevent multiple scans
        await this.stopScanning();

        // Haptic feedback
        this.vibrate([100]);

        // Get GPS location
        const location = await this.getLocation();

        // Build scan data
        const scanData = {
            qr_code: decodedText,
            scanned_at: new Date().toISOString(),
            location: location,
            device_info: {
                userAgent: navigator.userAgent,
                platform: navigator.platform,
                online: this.isOnline,
            },
        };

        // Process scan
        if (this.isOnline) {
            await this.processScanOnline(scanData);
        } else {
            await this.queueOfflineScan(scanData);
        }
    }

    /**
     * Handle scan errors (continuous, can be noisy)
     */
    onScanError(errorMessage) {
        // Silently ignore - this fires constantly when no QR is visible
        // Only log severe errors
        if (errorMessage.includes('NotFoundError') || errorMessage.includes('NotAllowedError')) {
            console.error('[QR Scanner] Camera error:', errorMessage);
        }
    }

    /**
     * Process scan when online
     */
    async processScanOnline(scanData) {
        try {
            this.updateStatus('Processing scan...', 'info');

            const response = await fetch(this.config.apiEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${this.authToken}`,
                },
                body: JSON.stringify(scanData),
            });

            const result = await response.json();

            if (response.ok) {
                this.playSuccessSound();
                this.vibrate([100, 50, 100]);
                this.displayResult(result, 'success');
                this.updateStatus('Scan processed successfully', 'success');
            } else {
                this.playErrorSound();
                this.vibrate([200]);
                this.displayResult(result, 'error');
                this.updateStatus(result.message || 'Scan failed', 'error');
            }
        } catch (error) {
            console.error('[QR Scanner] Network error:', error);

            // If network error, queue offline
            this.updateStatus('Network error - queuing scan...', 'warning');
            await this.queueOfflineScan(scanData);
        }

        // Resume scanning after 3 seconds
        setTimeout(() => this.startScanning(), 3000);
    }

    /**
     * Queue scan for later sync when offline
     */
    async queueOfflineScan(scanData) {
        try {
            const scan = {
                ...scanData,
                synced: false,
                queued_at: new Date().toISOString(),
            };

            await this.db.add('scans', scan);

            this.playSuccessSound();
            this.vibrate([100]);
            this.updateStatus('Scan queued for sync', 'warning');
            this.displayResult({ message: 'Scan saved offline - will sync when online' }, 'warning');

            console.log('[QR Scanner] Scan queued offline:', scan);

            // Trigger background sync if supported
            this.triggerBackgroundSync();
        } catch (error) {
            console.error('[QR Scanner] Failed to queue scan:', error);
            this.playErrorSound();
            this.vibrate([200]);
            this.updateStatus('Failed to save scan', 'error');
        }

        // Resume scanning after 3 seconds
        setTimeout(() => this.startScanning(), 3000);
    }

    /**
     * Trigger background sync for offline scans
     */
    async triggerBackgroundSync() {
        if ('serviceWorker' in navigator && 'sync' in navigator.serviceWorker) {
            try {
                const registration = await navigator.serviceWorker.ready;
                await registration.sync.register('sync-offline-scans');
                console.log('[QR Scanner] Background sync registered');
            } catch (error) {
                console.error('[QR Scanner] Background sync failed:', error);
                // Fallback to manual sync
                this.manualSync();
            }
        } else {
            // Browser doesn't support background sync - use manual sync
            this.manualSync();
        }
    }

    /**
     * Manual sync for browsers without background sync API
     */
    async manualSync() {
        if (!this.isOnline) {
            console.log('[QR Scanner] Offline - skipping manual sync');
            return;
        }

        try {
            const scans = await this.db.getAllFromIndex('scans', 'synced', 0);

            if (scans.length === 0) {
                console.log('[QR Scanner] No offline scans to sync');
                return;
            }

            console.log(`[QR Scanner] Manual sync: ${scans.length} scans`);

            const response = await fetch(this.config.batchSyncEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${this.authToken}`,
                },
                body: JSON.stringify({ scans }),
            });

            if (response.ok) {
                // Clear synced scans
                for (const scan of scans) {
                    await this.db.delete('scans', scan.id);
                }

                console.log('[QR Scanner] Manual sync complete');
                this.updateStatus(`Synced ${scans.length} offline scans`, 'success');
                this.playSuccessSound();
            } else {
                console.error('[QR Scanner] Manual sync failed:', response.statusText);
            }
        } catch (error) {
            console.error('[QR Scanner] Manual sync error:', error);
        }
    }

    /**
     * Get count of offline scans
     */
    async getOfflineScanCount() {
        try {
            const scans = await this.db.getAllFromIndex('scans', 'synced', 0);
            return scans.length;
        } catch (error) {
            console.error('[QR Scanner] Failed to get offline scan count:', error);
            return 0;
        }
    }

    /**
     * Update status display
     */
    updateStatus(message, type = 'info') {
        const statusEl = document.getElementById(this.config.statusDisplayId);
        if (!statusEl) return;

        statusEl.textContent = message;
        statusEl.className = `scan-status scan-status-${type}`;

        console.log(`[QR Scanner] Status: ${message}`);
    }

    /**
     * Display scan result
     */
    displayResult(result, type = 'success') {
        const resultEl = document.getElementById(this.config.resultDisplayId);
        if (!resultEl) return;

        const resultHTML = `
            <div class="scan-result scan-result-${type}">
                <h3>${type === 'success' ? 'Success' : type === 'error' ? 'Error' : 'Info'}</h3>
                <p>${result.message || JSON.stringify(result)}</p>
                ${result.data ? `<pre>${JSON.stringify(result.data, null, 2)}</pre>` : ''}
            </div>
        `;

        resultEl.innerHTML = resultHTML;

        // Auto-hide after 5 seconds
        setTimeout(() => {
            resultEl.innerHTML = '';
        }, 5000);
    }

    /**
     * Request camera permissions
     */
    async requestCameraPermission() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'environment' }
            });

            // Stop stream immediately - we just wanted permission
            stream.getTracks().forEach(track => track.stop());

            return true;
        } catch (error) {
            console.error('[QR Scanner] Camera permission denied:', error);
            return false;
        }
    }

    /**
     * Check if camera is available
     */
    async isCameraAvailable() {
        try {
            const devices = await navigator.mediaDevices.enumerateDevices();
            return devices.some(device => device.kind === 'videoinput');
        } catch (error) {
            console.error('[QR Scanner] Failed to check camera:', error);
            return false;
        }
    }

    /**
     * Get scanner statistics
     */
    async getStatistics() {
        try {
            const allScans = await this.db.getAll('scans');
            const offlineScans = await this.db.getAllFromIndex('scans', 'synced', 0);

            return {
                totalScans: allScans.length,
                offlineScans: offlineScans.length,
                syncedScans: allScans.length - offlineScans.length,
                isOnline: this.isOnline,
                isScanning: this.isScanning,
            };
        } catch (error) {
            console.error('[QR Scanner] Failed to get statistics:', error);
            return null;
        }
    }

    /**
     * Clear all offline scans
     */
    async clearOfflineScans() {
        try {
            await this.db.clear('scans');
            console.log('[QR Scanner] Offline scans cleared');
            this.updateStatus('Offline scans cleared', 'info');
        } catch (error) {
            console.error('[QR Scanner] Failed to clear offline scans:', error);
        }
    }

    /**
     * Destroy scanner and cleanup
     */
    async destroy() {
        await this.stopScanning();

        if (this.db) {
            this.db.close();
        }

        console.log('[QR Scanner] Destroyed');
    }
}

// Export for use in other modules
export default QRScanner;

// Also expose globally for traditional script tag usage
if (typeof window !== 'undefined') {
    window.QRScanner = QRScanner;
}
