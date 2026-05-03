/**
 * Bonresto — POS Offline Manager
 *
 * Responsabilités :
 *  1. Enregistrer le Service Worker
 *  2. Détecter online/offline et afficher le bandeau
 *  3. Intercepter la soumission de commande quand offline → IndexedDB
 *  4. Syncer automatiquement les commandes en attente au retour en ligne
 *  5. Mettre à jour le badge de commandes en attente
 */

(function () {
    'use strict';

    // ── Config ────────────────────────────────────────────────────────────────

    // BASE_URL est injecté par PHP dans la page POS (voir posorder.php)
    const BASE_URL   = window.BONRESTO_BASE_URL || '/';
    const SW_URL     = BASE_URL + 'sw.js';
    const DATA_URL   = BASE_URL + 'ordermanage/order/pos_offline_data';
    const SYNC_URL   = BASE_URL + 'ordermanage/order/sync_offline_orders';

    // Formulaire de commande POS (méthode POST principal)
    const ORDER_FORM_SELECTOR = '#posorderform, form[action*="pos_order"]';

    // ── State ─────────────────────────────────────────────────────────────────

    let isOnline = navigator.onLine;

    // ── Service Worker ────────────────────────────────────────────────────────

    function registerSW() {
        if (!('serviceWorker' in navigator)) {
            console.warn('[Offline] Service Worker non supporté.');
            return;
        }
        navigator.serviceWorker.register(SW_URL, { scope: BASE_URL })
            .then(reg => {
                console.log('[Offline] SW enregistré, scope:', reg.scope);
                // Quand un nouveau SW est prêt, on l'active immédiatement
                reg.addEventListener('updatefound', () => {
                    const newSW = reg.installing;
                    newSW.addEventListener('statechange', () => {
                        if (newSW.state === 'installed' && navigator.serviceWorker.controller) {
                            navigator.serviceWorker.controller.postMessage('SKIP_WAITING');
                        }
                    });
                });
            })
            .catch(e => console.error('[Offline] SW registration failed:', e));
    }

    // ── Bandeau offline ───────────────────────────────────────────────────────

    function injectOfflineUI() {
        // Pill flottante en bas à gauche — ne bloque aucun menu
        const banner = document.createElement('div');
        banner.id    = 'offline-banner';
        banner.innerHTML =
            '<i class="fa fa-wifi" style="margin-right:6px;"></i>' +
            '<strong>Hors-ligne</strong>' +
            '<span id="offline-queue-count"></span>';
        Object.assign(banner.style, {
            display:        'none',
            position:       'fixed',
            bottom:         '16px',
            left:           '16px',
            zIndex:         '99999',
            background:     '#e74c3c',
            color:          '#fff',
            padding:        '8px 16px',
            borderRadius:   '20px',
            fontSize:       '13px',
            fontWeight:     '500',
            boxShadow:      '0 3px 12px rgba(0,0,0,.35)',
            pointerEvents:  'none',
            whiteSpace:     'nowrap',
        });
        document.body.appendChild(banner);

        // Badge commandes en attente — en bas à droite
        const badge = document.createElement('div');
        badge.id    = 'offline-badge';
        badge.title = 'Commandes en attente de sync';
        Object.assign(badge.style, {
            display:      'none',
            position:     'fixed',
            bottom:       '16px',
            right:        '16px',
            background:   '#e67e22',
            color:        '#fff',
            borderRadius: '50%',
            width:        '42px',
            height:       '42px',
            lineHeight:   '42px',
            textAlign:    'center',
            fontWeight:   'bold',
            fontSize:     '14px',
            zIndex:       '99999',
            boxShadow:    '0 3px 12px rgba(0,0,0,.35)',
            cursor:       'default',
        });
        document.body.appendChild(badge);
    }

    function setOnlineState(online) {
        isOnline = online;
        const banner = document.getElementById('offline-banner');
        const badge  = document.getElementById('offline-badge');
        if (!banner) return;

        if (!online) {
            banner.style.display = 'block';
        } else {
            banner.style.display = 'none';
        }
        updateQueueBadge();
    }

    function updateQueueBadge() {
        BonrestoDB.countPendingOrders().then(count => {
            const badge   = document.getElementById('offline-badge');
            const counter = document.getElementById('offline-queue-count');

            if (count > 0) {
                if (badge) {
                    badge.textContent    = count;
                    badge.style.display  = 'block';
                }
                if (counter) counter.textContent = ' — ' + count + ' commande(s) en attente';
            } else {
                if (badge)   badge.style.display = 'none';
                if (counter) counter.textContent  = '';
            }
        });
    }

    // ── Interception des commandes ────────────────────────────────────────────

    function interceptOrderForms() {
        // On écoute sur le document pour attraper les formulaires chargés dynamiquement
        document.addEventListener('submit', function (e) {
            if (!isOnline) {
                const form = e.target.closest(ORDER_FORM_SELECTOR) || e.target;
                if (form && (
                    form.action.includes('pos_order') ||
                    form.id === 'posorderform'
                )) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    saveOrderOffline(form);
                }
            }
        }, true); // capture phase pour avoir la priorité

        // Intercepter aussi les appels jQuery AJAX vers pos_order
        if (window.$ && $.ajaxSetup) {
            $(document).ajaxError(function (event, xhr, settings) {
                if (xhr.status === 0 && settings.url && settings.url.includes('pos_order') && !isOnline) {
                    // La requête a échoué à cause du réseau — sauvegarder les données
                    const data = typeof settings.data === 'string'
                        ? settings.data
                        : $.param(settings.data || {});
                    const params = new URLSearchParams(data);
                    const order  = {};
                    params.forEach((v, k) => { order[k] = v; });
                    saveOrderOfflineRaw(order, settings.url);
                }
            });
        }
    }

    function saveOrderOffline(form) {
        const formData = new FormData(form);
        const order    = {};
        formData.forEach((v, k) => { order[k] = v; });
        order._form_action = form.action;

        BonrestoDB.saveOfflineOrder(order).then(localId => {
            showOfflineConfirm(localId);
            updateQueueBadge();
        }).catch(e => {
            alert('Erreur: impossible de sauvegarder la commande localement. ' + e.message);
        });
    }

    function saveOrderOfflineRaw(orderData, url) {
        orderData._form_action = url;
        BonrestoDB.saveOfflineOrder(orderData).then(() => {
            updateQueueBadge();
        });
    }

    function showOfflineConfirm(localId) {
        // Utiliser toastr si disponible, sinon alert
        const msg = 'Commande #' + localId + ' sauvegardée hors-ligne. Elle sera envoyée automatiquement à la reconnexion.';
        if (window.toastr) {
            toastr.warning(msg, 'Mode hors-ligne', { timeOut: 6000 });
        } else {
            alert(msg);
        }
    }

    // ── Sync automatique ──────────────────────────────────────────────────────

    function syncPendingOrders() {
        BonrestoDB.getPendingOrders().then(orders => {
            if (!orders.length) return;
            console.log('[Offline] Syncing', orders.length, 'pending order(s)...');

            orders.forEach(order => {
                const formData = new FormData();
                // Reconstruire les données du formulaire
                Object.keys(order).forEach(k => {
                    if (!['local_id', 'status', 'created_at', 'attempts', 'last_error', '_form_action'].includes(k)) {
                        formData.append(k, order[k]);
                    }
                });
                // Marquer comme commande offline pour le serveur
                formData.append('offline_local_id', order.local_id);
                formData.append('offline_created_at', order.created_at);

                const url = order._form_action || SYNC_URL;

                fetch(url, {
                    method:      'POST',
                    body:        formData,
                    credentials: 'same-origin',
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success || data.order_id) {
                        BonrestoDB.markOrderSynced(order.local_id, data.order_id || null);
                        updateQueueBadge();
                        if (window.toastr) {
                            toastr.success('Commande #' + order.local_id + ' synchronisée.', 'Sync');
                        }
                    } else {
                        BonrestoDB.markOrderFailed(order.local_id, data.message || 'Erreur serveur');
                    }
                })
                .catch(e => {
                    BonrestoDB.markOrderFailed(order.local_id, e.message);
                });
            });
        });
    }

    // ── Cache des données menu ────────────────────────────────────────────────

    function cacheMenuData() {
        fetch(DATA_URL, { credentials: 'same-origin' })
            .then(res => res.json())
            .then(data => {
                BonrestoDB.saveMenuData(data);
                console.log('[Offline] Menu data cached:', Object.keys(data));
            })
            .catch(() => {
                console.warn('[Offline] Could not cache menu data (offline?)');
            });
    }

    // ── Init ──────────────────────────────────────────────────────────────────

    function init() {
        registerSW();
        injectOfflineUI();
        interceptOrderForms();

        // État initial
        setOnlineState(navigator.onLine);

        // Écouter les changements de connectivité
        window.addEventListener('online', () => {
            setOnlineState(true);
            syncPendingOrders();
            cacheMenuData();
            if (window.toastr) toastr.success('Connexion rétablie. Synchronisation en cours...', 'Online');
        });

        window.addEventListener('offline', () => {
            setOnlineState(false);
            if (window.toastr) toastr.warning('Connexion perdue. Mode hors-ligne activé.', 'Offline');
        });

        // Mettre à jour le cache menu au chargement (si online)
        if (navigator.onLine) {
            cacheMenuData();
            // Syncer les éventuelles commandes restées en attente
            setTimeout(syncPendingOrders, 2000);
        }

        // Rafraîchir le badge toutes les 30s
        setInterval(updateQueueBadge, 30000);
    }

    // Démarrer quand le DOM est prêt
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
