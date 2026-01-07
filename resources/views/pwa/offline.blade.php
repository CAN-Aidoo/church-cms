<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#1e40af">
    <title>Offline - Church CMS</title>

    <!-- PWA Meta Tags -->
    <link rel="manifest" href="/manifest.json">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .offline-container {
            text-align: center;
            max-width: 500px;
        }

        .offline-icon {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.7;
                transform: scale(0.95);
            }
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        p {
            font-size: 1.125rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .features {
            background: rgba(255,255,255,0.1);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
        }

        .features h2 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .feature-list {
            list-style: none;
            text-align: left;
        }

        .feature-list li {
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
        }

        .feature-list li:last-child {
            border-bottom: none;
        }

        .feature-list li::before {
            content: '✓';
            display: inline-block;
            width: 1.5rem;
            height: 1.5rem;
            background: #10b981;
            border-radius: 50%;
            margin-right: 1rem;
            text-align: center;
            line-height: 1.5rem;
            font-weight: bold;
        }

        .btn-retry {
            display: inline-block;
            background: #fff;
            color: #667eea;
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .btn-retry:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        .offline-stats {
            margin-top: 2rem;
            padding: 1rem;
            background: rgba(255,255,255,0.1);
            border-radius: 0.5rem;
            backdrop-filter: blur(10px);
        }

        .offline-stats h3 {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            opacity: 0.9;
        }

        .offline-stats .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #fbbf24;
        }

        .network-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(239, 68, 68, 0.2);
            border: 2px solid #ef4444;
            border-radius: 2rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .status-dot {
            width: 0.75rem;
            height: 0.75rem;
            background: #ef4444;
            border-radius: 50%;
            animation: blink 1.5s ease-in-out infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .network-status.online {
            background: rgba(16, 185, 129, 0.2);
            border-color: #10b981;
        }

        .network-status.online .status-dot {
            background: #10b981;
            animation: none;
        }
    </style>
</head>
<body>
    <div class="offline-container">
        <div class="offline-icon">📡</div>

        <div id="network-status" class="network-status">
            <div class="status-dot"></div>
            <span>No Internet Connection</span>
        </div>

        <h1>You're Offline</h1>

        <p>
            Don't worry! The Church CMS app works offline too.
            You can still scan QR codes and your data will sync automatically when you're back online.
        </p>

        <div class="features">
            <h2>Available Offline Features</h2>
            <ul class="feature-list">
                <li>Scan QR codes for attendance</li>
                <li>Scan QR codes for payments</li>
                <li>View cached content</li>
                <li>Queue scans for auto-sync</li>
                <li>Access offline pages</li>
            </ul>
        </div>

        <a href="/pwa/scanner" class="btn-retry" id="btn-retry">
            🔄 Try Scanner
        </a>

        <div class="offline-stats" id="offline-stats">
            <h3>Queued Scans</h3>
            <div class="stat-value" id="queued-count">0</div>
            <p style="font-size: 0.875rem; opacity: 0.8; margin-top: 0.5rem;">
                Will sync when connection is restored
            </p>
        </div>
    </div>

    <script>
        // Monitor network status
        function updateNetworkStatus() {
            const statusEl = document.getElementById('network-status');
            const retryBtn = document.getElementById('btn-retry');

            if (navigator.onLine) {
                statusEl.classList.add('online');
                statusEl.innerHTML = '<div class="status-dot"></div><span>Back Online!</span>';
                retryBtn.textContent = '✓ Go to App';
                retryBtn.href = '/mobile';
            } else {
                statusEl.classList.remove('online');
                statusEl.innerHTML = '<div class="status-dot"></div><span>No Internet Connection</span>';
                retryBtn.textContent = '🔄 Try Scanner';
                retryBtn.href = '/pwa/scanner';
            }
        }

        // Get offline scan count from IndexedDB
        async function getOfflineScanCount() {
            try {
                const db = await new Promise((resolve, reject) => {
                    const request = indexedDB.open('church-cms-offline', 1);
                    request.onsuccess = () => resolve(request.result);
                    request.onerror = () => reject(request.error);
                });

                const tx = db.transaction(['scans'], 'readonly');
                const store = tx.objectStore('scans');
                const countRequest = store.count();

                countRequest.onsuccess = () => {
                    const count = countRequest.result;
                    document.getElementById('queued-count').textContent = count;
                };
            } catch (error) {
                console.log('IndexedDB not available or no scans');
            }
        }

        // Event listeners
        window.addEventListener('online', updateNetworkStatus);
        window.addEventListener('offline', updateNetworkStatus);

        // Initial check
        updateNetworkStatus();
        getOfflineScanCount();

        // Update count every 5 seconds
        setInterval(getOfflineScanCount, 5000);
    </script>
</body>
</html>
