/**
 * Bonresto — IndexedDB wrapper pour le POS offline
 *
 * Stores :
 *  - pos_menu      : snapshot des items du menu (categories, items, tables, etc.)
 *  - offline_orders: commandes créées hors ligne en attente de sync
 */

const BonrestoDB = (() => {

    const DB_NAME    = 'bonresto_pos';
    const DB_VERSION = 1;
    let   _db        = null;

    function open() {
        if (_db) return Promise.resolve(_db);
        return new Promise((resolve, reject) => {
            const req = indexedDB.open(DB_NAME, DB_VERSION);

            req.onupgradeneeded = e => {
                const db = e.target.result;

                // Snapshot des données menu
                if (!db.objectStoreNames.contains('pos_menu')) {
                    db.createObjectStore('pos_menu', { keyPath: 'key' });
                }

                // Commandes offline en attente
                if (!db.objectStoreNames.contains('offline_orders')) {
                    const store = db.createObjectStore('offline_orders', {
                        keyPath: 'local_id', autoIncrement: true
                    });
                    store.createIndex('status', 'status', { unique: false });
                    store.createIndex('created_at', 'created_at', { unique: false });
                }
            };

            req.onsuccess = e => { _db = e.target.result; resolve(_db); };
            req.onerror   = e => reject(e.target.error);
        });
    }

    // ── Menu data ─────────────────────────────────────────────────────────────

    function saveMenuData(data) {
        return open().then(db => new Promise((resolve, reject) => {
            const tx    = db.transaction('pos_menu', 'readwrite');
            const store = tx.objectStore('pos_menu');
            Object.keys(data).forEach(key => store.put({ key, value: data[key] }));
            tx.oncomplete = resolve;
            tx.onerror    = e => reject(e.target.error);
        }));
    }

    function getMenuData(key) {
        return open().then(db => new Promise((resolve, reject) => {
            const req = db.transaction('pos_menu', 'readonly')
                          .objectStore('pos_menu').get(key);
            req.onsuccess = e => resolve(e.target.result ? e.target.result.value : null);
            req.onerror   = e => reject(e.target.error);
        }));
    }

    function getAllMenuData() {
        return open().then(db => new Promise((resolve, reject) => {
            const result = {};
            const req    = db.transaction('pos_menu', 'readonly')
                             .objectStore('pos_menu').openCursor();
            req.onsuccess = e => {
                const cursor = e.target.result;
                if (cursor) {
                    result[cursor.value.key] = cursor.value.value;
                    cursor.continue();
                } else {
                    resolve(result);
                }
            };
            req.onerror = e => reject(e.target.error);
        }));
    }

    // ── Offline orders ────────────────────────────────────────────────────────

    function saveOfflineOrder(orderData) {
        return open().then(db => new Promise((resolve, reject) => {
            const record = Object.assign({}, orderData, {
                status:     'pending',
                created_at: new Date().toISOString(),
                attempts:   0
            });
            const req = db.transaction('offline_orders', 'readwrite')
                          .objectStore('offline_orders').add(record);
            req.onsuccess = e => resolve(e.target.result); // retourne local_id
            req.onerror   = e => reject(e.target.error);
        }));
    }

    function getPendingOrders() {
        return open().then(db => new Promise((resolve, reject) => {
            const results = [];
            const store   = db.transaction('offline_orders', 'readonly')
                              .objectStore('offline_orders');
            const idx = store.index('status');
            const req = idx.openCursor(IDBKeyRange.only('pending'));
            req.onsuccess = e => {
                const cursor = e.target.result;
                if (cursor) { results.push(cursor.value); cursor.continue(); }
                else resolve(results);
            };
            req.onerror = e => reject(e.target.error);
        }));
    }

    function countPendingOrders() {
        return open().then(db => new Promise((resolve, reject) => {
            const store = db.transaction('offline_orders', 'readonly')
                            .objectStore('offline_orders');
            const req = store.index('status').count(IDBKeyRange.only('pending'));
            req.onsuccess = e => resolve(e.target.result);
            req.onerror   = e => reject(e.target.error);
        }));
    }

    function markOrderSynced(localId, serverId) {
        return open().then(db => new Promise((resolve, reject) => {
            const tx    = db.transaction('offline_orders', 'readwrite');
            const store = tx.objectStore('offline_orders');
            const get   = store.get(localId);
            get.onsuccess = e => {
                const rec = e.target.result;
                if (rec) {
                    rec.status    = 'synced';
                    rec.server_id = serverId;
                    rec.synced_at = new Date().toISOString();
                    store.put(rec);
                }
            };
            tx.oncomplete = resolve;
            tx.onerror    = e => reject(e.target.error);
        }));
    }

    function markOrderFailed(localId, error) {
        return open().then(db => new Promise((resolve, reject) => {
            const tx    = db.transaction('offline_orders', 'readwrite');
            const store = tx.objectStore('offline_orders');
            const get   = store.get(localId);
            get.onsuccess = e => {
                const rec = e.target.result;
                if (rec) {
                    rec.attempts++;
                    rec.last_error = error;
                    if (rec.attempts >= 5) rec.status = 'failed';
                    store.put(rec);
                }
            };
            tx.oncomplete = resolve;
            tx.onerror    = e => reject(e.target.error);
        }));
    }

    return {
        saveMenuData,
        getMenuData,
        getAllMenuData,
        saveOfflineOrder,
        getPendingOrders,
        countPendingOrders,
        markOrderSynced,
        markOrderFailed
    };

})();
