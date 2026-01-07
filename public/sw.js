// Service Worker for Church CMS PWA
const CACHE_NAME = 'church-cms-v1';
const OFFLINE_URL = '/mobile/offline';

// Assets to cache on install
const PRECACHE_ASSETS = [
  '/mobile',
  '/mobile/offline',
  '/pwa/scanner',
  '/pwa/offline',
  '/css/app.css',
  '/js/app.js',
  '/images/logo.png',
  '/manifest.json'
];

// Install event - cache essential assets
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        console.log('Opened cache');
        return cache.addAll(PRECACHE_ASSETS);
      })
      .then(() => self.skipWaiting())
  );
});

// Activate event - clean up old caches
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          if (cacheName !== CACHE_NAME) {
            console.log('Deleting old cache:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    }).then(() => self.clients.claim())
  );
});

// Fetch event - network first, then cache strategy
self.addEventListener('fetch', (event) => {
  if (!event.request.url.startsWith(self.location.origin)) {
    return;
  }

  // API requests - network first
  if (event.request.url.includes('/api/')) {
    event.respondWith(
      fetch(event.request)
        .then((response) => {
          if (response.ok) {
            const responseClone = response.clone();
            caches.open(CACHE_NAME).then((cache) => {
              cache.put(event.request, responseClone);
            });
          }
          return response;
        })
        .catch(() => {
          return caches.match(event.request)
            .then((cachedResponse) => {
              if (cachedResponse) {
                return cachedResponse;
              }
              if (event.request.mode === 'navigate') {
                return caches.match(OFFLINE_URL);
              }
            });
        })
    );
    return;
  }

  // Static assets - cache first
  event.respondWith(
    caches.match(event.request)
      .then((cachedResponse) => {
        if (cachedResponse) {
          return cachedResponse;
        }
        return fetch(event.request)
          .then((response) => {
            if (response.ok && event.request.method === 'GET') {
              const responseClone = response.clone();
              caches.open(CACHE_NAME).then((cache) => {
                cache.put(event.request, responseClone);
              });
            }
            return response;
          });
      })
  );
});

// Push notifications
self.addEventListener('push', (event) => {
  const data = event.data ? event.data.json() : {};
  const title = data.title || 'Church CMS';
  const options = {
    body: data.message || 'You have a new notification',
    icon: '/images/icon-192x192.png',
    badge: '/images/badge-72x72.png',
    vibrate: [200, 100, 200],
    tag: data.tag || 'notification',
    data: data
  };

  event.waitUntil(
    self.registration.showNotification(title, options)
  );
});

// Notification click
self.addEventListener('notificationclick', (event) => {
  event.notification.close();
  const urlToOpen = event.notification.data?.url || '/mobile';

  event.waitUntil(
    clients.matchAll({ type: 'window', includeUncontrolled: true })
      .then((windowClients) => {
        for (let client of windowClients) {
          if (client.url === urlToOpen && 'focus' in client) {
            return client.focus();
          }
        }
        if (clients.openWindow) {
          return clients.openWindow(urlToOpen);
        }
      })
  );
});

// Background Sync - Sync offline QR scans when online
self.addEventListener('sync', (event) => {
  console.log('[SW] Background sync event:', event.tag);

  if (event.tag === 'sync-offline-scans') {
    event.waitUntil(syncOfflineScans());
  }
});

// Sync offline QR scans to server
async function syncOfflineScans() {
  try {
    console.log('[SW] Syncing offline scans');

    // Open IndexedDB
    const db = await openDB();
    const scans = await getAllOfflineScans(db);

    if (scans.length === 0) {
      console.log('[SW] No offline scans to sync');
      return;
    }

    console.log(`[SW] Syncing ${scans.length} offline scans`);

    // Get auth token
    const token = await getAuthToken(db);

    // Send batch request
    const response = await fetch('/api/qr-scan/batch-sync', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify({ scans })
    });

    if (response.ok) {
      // Clear synced scans
      await clearOfflineScans(db);
      console.log('[SW] Offline scans synced successfully');

      // Notify all clients
      const allClients = await self.clients.matchAll();
      allClients.forEach(client => {
        client.postMessage({
          type: 'SYNC_COMPLETE',
          count: scans.length
        });
      });
    } else {
      console.error('[SW] Sync failed:', response.statusText);
    }
  } catch (error) {
    console.error('[SW] Sync error:', error);
    throw error;
  }
}

// IndexedDB helpers
function openDB() {
  return new Promise((resolve, reject) => {
    const request = indexedDB.open('church-cms-offline', 1);
    request.onerror = () => reject(request.error);
    request.onsuccess = () => resolve(request.result);
    request.onupgradeneeded = (event) => {
      const db = event.target.result;
      if (!db.objectStoreNames.contains('scans')) {
        db.createObjectStore('scans', { keyPath: 'id', autoIncrement: true });
      }
      if (!db.objectStoreNames.contains('auth')) {
        db.createObjectStore('auth');
      }
    };
  });
}

function getAllOfflineScans(db) {
  return new Promise((resolve, reject) => {
    const tx = db.transaction(['scans'], 'readonly');
    const store = tx.objectStore('scans');
    const request = store.getAll();
    request.onerror = () => reject(request.error);
    request.onsuccess = () => resolve(request.result);
  });
}

function clearOfflineScans(db) {
  return new Promise((resolve, reject) => {
    const tx = db.transaction(['scans'], 'readwrite');
    const store = tx.objectStore('scans');
    const request = store.clear();
    request.onerror = () => reject(request.error);
    request.onsuccess = () => resolve();
  });
}

function getAuthToken(db) {
  return new Promise((resolve, reject) => {
    const tx = db.transaction(['auth'], 'readonly');
    const store = tx.objectStore('auth');
    const request = store.get('token');
    request.onerror = () => reject(request.error);
    request.onsuccess = () => resolve(request.result?.value || '');
  });
}
