/**
 * Bonresto — Service Worker (POS Offline)
 *
 * Stratégie :
 *  - Assets statiques (CSS/JS/fonts) → Cache-first
 *  - Page POS                        → Network-first avec fallback cache
 *  - Données menu (pos_offline_data) → Cache en arrière-plan
 *  - Soumission commande offline     → Queue dans IndexedDB (géré par offline-pos.js)
 */

const CACHE_NAME    = 'bonresto-pos-v1';
const DATA_CACHE    = 'bonresto-data-v1';

// Assets statiques à mettre en cache immédiatement
const STATIC_ASSETS = [
    // CSS
    'assets/css/bootstrap.min.css',
    'assets/css/font-awesome.min.css',
    'assets/css/custom.min.css',
    'assets/css/extra.css',
    'application/modules/ordermanage/assets/css/posordernew.css',
    // JS
    'assets/js/jquery-1.12.4.min.js',
    'assets/js/jquery.validate.min.js',
    'assets/js/bootstrap.min.js',
    'application/modules/ordermanage/assets/js/postop.js',
    'application/modules/ordermanage/assets/js/possetting.js',
    'application/modules/ordermanage/assets/js/offline-db.js',
    'application/modules/ordermanage/assets/js/offline-pos.js',
];

// ── Install ──────────────────────────────────────────────────────────────────

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            // On essaie de mettre en cache — on ignore les erreurs individuelles
            return Promise.allSettled(
                STATIC_ASSETS.map(url =>
                    cache.add(url).catch(e => console.warn('[SW] cache miss:', url, e.message))
                )
            );
        }).then(() => self.skipWaiting())
    );
});

// ── Activate ─────────────────────────────────────────────────────────────────

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys.filter(k => k !== CACHE_NAME && k !== DATA_CACHE)
                    .map(k => caches.delete(k))
            )
        ).then(() => self.clients.claim())
    );
});

// ── Fetch ─────────────────────────────────────────────────────────────────────

self.addEventListener('fetch', event => {
    const req = event.request;
    const url = new URL(req.url);

    // Ne pas intercepter les requêtes non-GET (POST orders, etc.)
    // Celles-ci sont gérées par offline-pos.js via IndexedDB
    if (req.method !== 'GET') return;

    // Données menu → Network-first, mise à jour cache en arrière-plan
    if (url.pathname.includes('pos_offline_data')) {
        event.respondWith(networkFirstData(req));
        return;
    }

    // Page POS → Network-first avec fallback cache
    if (url.pathname.includes('pos_invoice') && !url.pathname.includes('print')) {
        event.respondWith(networkFirstPage(req));
        return;
    }

    // Assets statiques → Cache-first
    if (isStaticAsset(url)) {
        event.respondWith(cacheFirst(req));
        return;
    }
});

// ── Stratégies ───────────────────────────────────────────────────────────────

async function networkFirstPage(req) {
    try {
        const res = await fetchWithTimeout(req, 8000);
        const cache = await caches.open(CACHE_NAME);
        cache.put(req, res.clone());
        return res;
    } catch (e) {
        const cached = await caches.match(req);
        if (cached) return cached;
        // Fallback minimaliste si la page n'est pas en cache
        return new Response(offlineFallbackHtml(), {
            headers: { 'Content-Type': 'text/html; charset=utf-8' }
        });
    }
}

async function networkFirstData(req) {
    try {
        const res = await fetchWithTimeout(req, 6000);
        const cache = await caches.open(DATA_CACHE);
        cache.put(req, res.clone());
        return res;
    } catch (e) {
        const cached = await caches.match(req, { cacheName: DATA_CACHE });
        return cached || new Response('{}', { headers: { 'Content-Type': 'application/json' } });
    }
}

async function cacheFirst(req) {
    const cached = await caches.match(req);
    if (cached) return cached;
    try {
        const res = await fetch(req);
        const cache = await caches.open(CACHE_NAME);
        cache.put(req, res.clone());
        return res;
    } catch (e) {
        return new Response('', { status: 503 });
    }
}

function fetchWithTimeout(req, ms) {
    return new Promise((resolve, reject) => {
        const timer = setTimeout(() => reject(new Error('timeout')), ms);
        fetch(req).then(res => { clearTimeout(timer); resolve(res); }, reject);
    });
}

function isStaticAsset(url) {
    return /\.(css|js|woff2?|ttf|eot|svg|png|jpg|jpeg|gif|ico)(\?.*)?$/.test(url.pathname);
}

function offlineFallbackHtml() {
    return `<!DOCTYPE html><html lang="fr"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Bonresto — Hors ligne</title>
<style>
  body{font-family:sans-serif;display:flex;align-items:center;justify-content:center;
       height:100vh;margin:0;background:#f4f4f4;flex-direction:column;}
  .box{background:#fff;padding:40px;border-radius:12px;text-align:center;
       box-shadow:0 4px 20px rgba(0,0,0,.1);max-width:400px;}
  h2{color:#e74c3c;margin-bottom:10px;}
  p{color:#666;line-height:1.6;}
  .btn{display:inline-block;margin-top:20px;padding:12px 28px;background:#e74c3c;
       color:#fff;border-radius:6px;text-decoration:none;cursor:pointer;border:none;
       font-size:14px;}
</style></head><body>
<div class="box">
  <h2>&#128683; Mode hors-ligne</h2>
  <p>La page POS n'est pas encore en cache.<br>
     Reconnectez-vous au réseau, rechargez la page, puis elle sera disponible offline.</p>
  <button class="btn" onclick="location.reload()">Réessayer</button>
</div></body></html>`;
}

// ── Message depuis la page (force refresh cache) ──────────────────────────────

self.addEventListener('message', event => {
    if (event.data === 'SKIP_WAITING') self.skipWaiting();
    if (event.data === 'CACHE_POS_DATA') {
        // La page demande de re-fetcher les données menu
        event.waitUntil(
            fetch('ordermanage/order/pos_offline_data')
                .then(res => caches.open(DATA_CACHE).then(c => c.put('ordermanage/order/pos_offline_data', res)))
                .catch(() => {})
        );
    }
});
