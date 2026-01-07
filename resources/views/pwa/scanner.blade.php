<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#1e40af">
    <title>QR Scanner - Church CMS</title>

    <!-- PWA Meta Tags -->
    <link rel="manifest" href="/manifest.json">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Church QR Scanner">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #0f172a;
            color: #fff;
            overflow: hidden;
        }

        .scanner-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .scanner-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            z-index: 10;
        }

        .scanner-header h1 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .scanner-header .user-info {
            font-size: 0.875rem;
            opacity: 0.9;
            margin-top: 0.25rem;
        }

        .scanner-viewport-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
            position: relative;
        }

        #qr-scanner-viewport {
            width: 100%;
            height: 100%;
            max-width: 640px;
            max-height: 640px;
        }

        .scanner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 5;
        }

        .scanner-instructions {
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.7);
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            text-align: center;
            max-width: 80%;
        }

        .scanner-controls {
            background: #1e293b;
            padding: 1rem;
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            z-index: 10;
        }

        .scanner-controls button {
            flex: 1;
            max-width: 150px;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-secondary {
            background: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background: #475569;
        }

        .scanner-footer {
            background: #1e293b;
            padding: 0.75rem 1rem;
            text-align: center;
            border-top: 1px solid #334155;
        }

        #scan-status {
            font-size: 0.875rem;
            padding: 0.5rem;
            border-radius: 0.25rem;
            margin-bottom: 0.5rem;
        }

        .scan-status-info { background: #3b82f6; }
        .scan-status-success { background: #10b981; }
        .scan-status-warning { background: #f59e0b; }
        .scan-status-error { background: #ef4444; }

        #scan-result {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 100;
            max-width: 90%;
            width: 400px;
        }

        .scan-result {
            background: white;
            color: #1f2937;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        }

        .scan-result h3 {
            margin: 0 0 0.5rem 0;
            font-size: 1.25rem;
        }

        .scan-result p {
            margin: 0.5rem 0;
        }

        .scan-result pre {
            background: #f3f4f6;
            padding: 0.75rem;
            border-radius: 0.25rem;
            overflow-x: auto;
            font-size: 0.75rem;
            margin-top: 0.5rem;
        }

        .scan-result-success {
            border-left: 4px solid #10b981;
        }

        .scan-result-error {
            border-left: 4px solid #ef4444;
        }

        .scan-result-warning {
            border-left: 4px solid #f59e0b;
        }

        .offline-badge {
            position: fixed;
            top: 4rem;
            right: 1rem;
            background: #f59e0b;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            z-index: 50;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .stats-display {
            display: flex;
            justify-content: space-around;
            font-size: 0.75rem;
            opacity: 0.8;
            margin-top: 0.5rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-weight: 700;
            font-size: 1rem;
            color: #3b82f6;
        }

        /* Loading spinner */
        .spinner {
            border: 3px solid rgba(255,255,255,0.3);
            border-top-color: #3b82f6;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 2rem auto;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Hide when scanner is active */
        .scanner-viewport-container.active .scanner-instructions {
            display: none;
        }
    </style>
</head>
<body>
    <div class="scanner-container">
        <!-- Header -->
        <div class="scanner-header">
            <h1>🔍 QR Code Scanner</h1>
            <div class="user-info">
                {{ $user->name }} ({{ ucfirst($user->role) }})
            </div>
        </div>

        <!-- Offline Badge (hidden when online) -->
        <div id="offline-badge" class="offline-badge" style="display: none;">
            ⚠️ Offline Mode
        </div>

        <!-- Scanner Viewport -->
        <div id="scanner-viewport-container" class="scanner-viewport-container">
            <div id="qr-scanner-viewport"></div>
            <div class="scanner-overlay">
                <div class="scanner-instructions">
                    <p>Point your camera at a QR code</p>
                    <div class="spinner"></div>
                </div>
            </div>
        </div>

        <!-- Scan Result Display -->
        <div id="scan-result"></div>

        <!-- Controls -->
        <div class="scanner-controls">
            <button id="btn-start" class="btn-primary">
                📷 Start Scanner
            </button>
            <button id="btn-stop" class="btn-danger" style="display: none;">
                ⏹️ Stop Scanner
            </button>
            <button id="btn-sync" class="btn-secondary">
                🔄 Sync (<span id="offline-count">0</span>)
            </button>
        </div>

        <!-- Footer Status -->
        <div class="scanner-footer">
            <div id="scan-status" class="scan-status-info">
                Ready to scan
            </div>
            <div class="stats-display">
                <div class="stat-item">
                    <div class="stat-value" id="stat-offline">0</div>
                    <div>Offline Scans</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" id="stat-status">
                        <span id="network-status">Online</span>
                    </div>
                    <div>Network</div>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        import QRScanner from '/resources/js/qr-scanner.js';

        let scanner = null;

        // Initialize scanner on page load
        async function initScanner() {
            try {
                // Fetch scanner config from backend
                const configResponse = await fetch('/pwa/scanner/config');
                const configData = await configResponse.json();

                if (!configData.success) {
                    throw new Error('Failed to load scanner configuration');
                }

                const config = configData.config;

                // Create scanner instance
                scanner = new QRScanner({
                    scannerElementId: 'qr-scanner-viewport',
                    resultDisplayId: 'scan-result',
                    statusDisplayId: 'scan-status',
                    apiEndpoint: config.apiEndpoint,
                    batchSyncEndpoint: config.batchSyncEndpoint,
                    enableGPS: config.enableGPS,
                    enableSound: config.enableSound,
                    enableVibration: config.enableVibration,
                    fps: config.fps,
                    qrboxSize: config.qrboxSize,
                });

                // Save auth token to scanner
                if (config.token) {
                    await scanner.saveAuthToken(config.token);
                }

                // Update UI with offline scan count
                updateStats();

                console.log('Scanner initialized successfully');
            } catch (error) {
                console.error('Failed to initialize scanner:', error);
                document.getElementById('scan-status').textContent = 'Failed to initialize scanner';
                document.getElementById('scan-status').className = 'scan-status-error';
            }
        }

        // Update statistics display
        async function updateStats() {
            if (!scanner) return;

            const stats = await scanner.getStatistics();
            if (stats) {
                document.getElementById('stat-offline').textContent = stats.offlineScans;
                document.getElementById('offline-count').textContent = stats.offlineScans;
                document.getElementById('network-status').textContent = stats.isOnline ? 'Online' : 'Offline';

                // Show/hide offline badge
                document.getElementById('offline-badge').style.display =
                    stats.isOnline ? 'none' : 'block';
            }
        }

        // Event Listeners
        document.getElementById('btn-start').addEventListener('click', async () => {
            if (!scanner) {
                alert('Scanner not initialized');
                return;
            }

            try {
                await scanner.startScanning();
                document.getElementById('btn-start').style.display = 'none';
                document.getElementById('btn-stop').style.display = 'block';
                document.getElementById('scanner-viewport-container').classList.add('active');
            } catch (error) {
                alert('Failed to start scanner: ' + error.message);
            }
        });

        document.getElementById('btn-stop').addEventListener('click', async () => {
            if (!scanner) return;

            await scanner.stopScanning();
            document.getElementById('btn-start').style.display = 'block';
            document.getElementById('btn-stop').style.display = 'none';
            document.getElementById('scanner-viewport-container').classList.remove('active');
        });

        document.getElementById('btn-sync').addEventListener('click', async () => {
            if (!scanner) return;

            await scanner.triggerBackgroundSync();
            updateStats();
        });

        // Network status monitoring
        window.addEventListener('online', () => {
            updateStats();
        });

        window.addEventListener('offline', () => {
            updateStats();
        });

        // Update stats every 5 seconds
        setInterval(updateStats, 5000);

        // Initialize on page load
        initScanner();

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (scanner) {
                scanner.stopScanning();
            }
        });
    </script>
</body>
</html>
