/**
 * Bonresto — POS Offline Manager v2
 *
 * 1. Enregistre le Service Worker
 * 2. Détecte online/offline → pill flottante
 * 3. Intercepte jQuery AJAX (posaddtocart, posupdatecart, removecart)
 *    → gère le panier 100% en JS quand offline
 * 4. Intercepte la soumission de commande → IndexedDB
 * 5. Sync automatique au retour en ligne
 */

(function () {
    'use strict';

    const BASE_URL = window.BONRESTO_BASE_URL || '/';
    const SW_URL   = BASE_URL + 'sw.js';
    const DATA_URL = BASE_URL + 'ordermanage/order/pos_offline_data';
    const SYNC_URL = BASE_URL + 'ordermanage/order/sync_offline_orders';

    let isOnline = navigator.onLine;

    // Cache des items menu pour lookup offline (pid → item)
    let _menuIndex = {};

    // ── Service Worker ────────────────────────────────────────────────────────

    function registerSW() {
        if (!('serviceWorker' in navigator)) return;
        navigator.serviceWorker.register(SW_URL, { scope: BASE_URL })
            .then(reg => {
                reg.addEventListener('updatefound', () => {
                    var newSW = reg.installing;
                    newSW.addEventListener('statechange', () => {
                        if (newSW.state === 'installed' && navigator.serviceWorker.controller) {
                            navigator.serviceWorker.controller.postMessage('SKIP_WAITING');
                        }
                    });
                });
            })
            .catch(e => console.error('[Offline] SW:', e));
    }

    // ── UI offline ────────────────────────────────────────────────────────────

    function injectOfflineUI() {
        var banner = document.createElement('div');
        banner.id  = 'offline-banner';
        banner.innerHTML =
            '<i class="fa fa-wifi" style="margin-right:6px;"></i>' +
            '<strong>Hors-ligne</strong>' +
            '<span id="offline-queue-count"></span>';
        Object.assign(banner.style, {
            display: 'none', position: 'fixed', bottom: '16px', left: '16px',
            zIndex: '99999', background: '#e74c3c', color: '#fff',
            padding: '8px 16px', borderRadius: '20px', fontSize: '13px',
            fontWeight: '500', boxShadow: '0 3px 12px rgba(0,0,0,.35)',
            pointerEvents: 'none', whiteSpace: 'nowrap',
        });
        document.body.appendChild(banner);

        var badge = document.createElement('div');
        badge.id  = 'offline-badge';
        Object.assign(badge.style, {
            display: 'none', position: 'fixed', bottom: '16px', right: '16px',
            background: '#e67e22', color: '#fff', borderRadius: '50%',
            width: '42px', height: '42px', lineHeight: '42px', textAlign: 'center',
            fontWeight: 'bold', fontSize: '14px', zIndex: '99999',
            boxShadow: '0 3px 12px rgba(0,0,0,.35)', cursor: 'default',
        });
        document.body.appendChild(badge);
    }

    function setOnlineState(online) {
        isOnline = online;
        var banner = document.getElementById('offline-banner');
        if (banner) banner.style.display = online ? 'none' : 'block';
        updateQueueBadge();
    }

    function updateQueueBadge() {
        if (typeof BonrestoDB === 'undefined') return;
        BonrestoDB.countPendingOrders().then(function(count) {
            var badge   = document.getElementById('offline-badge');
            var counter = document.getElementById('offline-queue-count');
            if (count > 0) {
                if (badge)   { badge.textContent = count; badge.style.display = 'block'; }
                if (counter) counter.textContent = ' — ' + count + ' en attente';
            } else {
                if (badge)   badge.style.display = 'none';
                if (counter) counter.textContent = '';
            }
        });
    }

    // ── Offline Cart ──────────────────────────────────────────────────────────

    var OfflineCart = {
        items: [],  // [{rowid, pid, name, price, qty, sizeid, size}]

        _rowid: function(pid, sizeid) {
            return 'off_' + pid + '_' + (sizeid || 0) + '_' + Date.now();
        },

        add: function(pid, price, sizeid, catid) {
            pid    = parseInt(pid)   || 0;
            sizeid = parseInt(sizeid)|| 0;
            price  = parseFloat(price) || 0;

            // Lookup name depuis le cache menu
            var meta = _menuIndex[pid] || {};
            var name = meta.ProductsName || meta.name || ('Item #' + pid);
            var size = '';
            if (meta.variant && sizeid) {
                var v = (meta.variant || []).find(function(vv){ return parseInt(vv.variantid) === sizeid; });
                if (v) { size = v.variantname || ''; price = parseFloat(v.price) || price; }
            }

            var existing = this.items.find(function(i){ return i.pid === pid && i.sizeid === sizeid; });
            if (existing) {
                existing.qty++;
            } else {
                this.items.push({
                    rowid: this._rowid(pid, sizeid),
                    pid: pid, name: name, price: price,
                    qty: 1, sizeid: sizeid, size: size
                });
            }
            this.render();
        },

        update: function(rowid, action) {
            var item = this.items.find(function(i){ return i.rowid === rowid; });
            if (!item) return;
            if (action === 'add') {
                item.qty++;
            } else {
                item.qty--;
                if (item.qty <= 0) {
                    this.items = this.items.filter(function(i){ return i.rowid !== rowid; });
                }
            }
            this.render();
        },

        remove: function(rowid) {
            this.items = this.items.filter(function(i){ return i.rowid !== rowid; });
            this.render();
        },

        total: function() {
            return this.items.reduce(function(s, i){ return s + i.price * i.qty; }, 0);
        },

        render: function() {
            var rows = '';
            var i = 0;
            var total = this.total();

            this.items.forEach(function(item) {
                i++;
                var lineTotal = (item.price * item.qty).toFixed(0);
                rows +=
                    '<tr id="' + i + '">' +
                    '<th>' + item.name + ' <i class="fa fa-sticky-note pl-15" aria-hidden="true"></i></th>' +
                    '<td>' + item.size + '</td>' +
                    '<td>' + item.price + '</td>' +
                    '<td>' +
                        '<a class="btn btn-info btn-sm btn-incriment btnleftalign" ' +
                            'onclick="OfflineCart.update(\'' + item.rowid + '\',\'add\')">' +
                            '<i class="fa fa-plus" aria-hidden="true"></i></a>' +
                        ' <span id="productionsetting-' + item.pid + '-' + item.sizeid + '">' + item.qty + '</span> ' +
                        '<a class="btn btn-danger btn-sm btn-dicriment btnrightalign" ' +
                            'onclick="OfflineCart.update(\'' + item.rowid + '\',\'del\')">' +
                            '<i class="fa fa-minus" aria-hidden="true"></i></a>' +
                    '</td>' +
                    '<td>' + lineTotal + '</td>' +
                    '<td>' +
                        '<a href="javascript:void(0);" class="btnrightalign" ' +
                            'onclick="OfflineCart.remove(\'' + item.rowid + '\')">' +
                            '<svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                            '<path fill-rule="evenodd" clip-rule="evenodd" d="M0 3.9975C0 3.65763 0.27552 3.38212 0.615385 3.38212H15.3846C15.7245 3.38212 16 3.65763 16 3.9975C16 4.33737 15.7245 4.61289 15.3846 4.61289H0.615385C0.27552 4.61289 0 4.33737 0 3.9975Z" fill="#D43407"/>' +
                            '<path fill-rule="evenodd" clip-rule="evenodd" d="M13.8323 11.8018C13.5918 13.9802 13.4715 15.0694 12.8566 15.8213C12.6415 16.0842 12.3871 16.3121 12.1021 16.497C11.2873 17.0256 10.1915 17.0256 7.9998 17.0256C5.80824 17.0256 4.71244 17.0256 3.89755 16.497C3.61262 16.3121 3.35811 16.0842 3.14311 15.8213C2.5282 15.0694 2.4079 13.9801 2.16731 11.8018L1.24268 3.43009H14.757L13.8323 11.8018Z" fill="#D43407"/>' +
                            '</svg>' +
                        '</a>' +
                    '</td>' +
                    '</tr>';
            });

            // Hidden inputs nécessaires pour la soumission du formulaire
            var hiddens =
                '<input name="subtotal" id="subtotal" type="hidden" value="' + total.toFixed(0) + '">' +
                '<input name="totalitem" id="totalitem" type="hidden" value="' + i + '">' +
                '<input name="multiplletaxvalue" id="multiplletaxvalue" type="hidden" value="">' +
                '<input name="tvat" type="hidden" value="0" id="tvat">' +
                '<input name="sc" type="hidden" value="0" id="sc">' +
                '<input name="tdiscount" type="hidden" value="0" id="tdiscount">' +
                '<input name="tgtotal" type="hidden" value="' + total.toFixed(0) + '" id="tgtotal">' +
                '<input name="grandtotal" id="grtotal" type="hidden" value="' + total.toFixed(0) + '">';

            // Table
            var tableHtml = i > 0
                ? '<table class="table item-table border-none wpr_100 mb-0" border="1" id="addinvoice">' +
                  '<thead><tr>' +
                  '<th>Item</th><th>Variant</th><th>Price</th><th class="text-center">Qnt.</th><th>Total</th><th>Action</th>' +
                  '</tr></thead><tbody class="itemNumber">' + rows + hiddens + '</tbody></table>'
                : hiddens;

            $('#addfoodlist').html(tableHtml);

            // Mettre à jour les totaux affichés
            $('#item-number').text(i);
            $('#getitemp').val(i);
            $('#calvat').text(0);
            $('#vat').val(0);
            $('#invoice_discount').val(0);
            $('#service_charge').val(0);
            $('#caltotal').text(total.toFixed(0));
            $('#grandtotal').val(total.toFixed(0));
            $('#orggrandTotal').val(total.toFixed(0));
            $('#orginattotal').val(total.toFixed(0));
        },

        // Sérialiser pour la sauvegarde offline
        toOrderData: function() {
            return {
                offline_cart: JSON.stringify(this.items),
                offline_total: this.total().toFixed(0),
                offline_items_count: this.items.length,
            };
        }
    };

    // Exposer globalement pour les onclick inline
    window.OfflineCart = OfflineCart;

    // ── Interception jQuery AJAX ──────────────────────────────────────────────

    function interceptAjax() {
        if (typeof $ === 'undefined') return;

        var _origAjax = $.ajax;
        $.ajax = function(settings) {
            if (!isOnline && settings && settings.url) {
                var url = settings.url;

                // Ajout au panier
                if (url.indexOf('posaddtocart') !== -1) {
                    var params = parseQueryString(settings.data || '');
                    OfflineCart.add(params.pid, params.price, params.sizeid, params.catid);
                    return $.Deferred().resolve('').promise();
                }

                // Mise à jour quantité (posupdatecart ou poscartupdate)
                if (url.indexOf('posupdatecart') !== -1 || url.indexOf('poscartupdate') !== -1) {
                    var params = parseQueryString(settings.data || '');
                    // rowid peut être dans params.cartid ou params.rowid
                    var rowid  = params.cartid || params.rowid || '';
                    var action = params.action || params.type || 'add';
                    // Trouver le rowid offline correspondant au pid+sizeid
                    var item = OfflineCart.items.find(function(i){
                        return String(i.pid) === String(params.pid || params.product_id || '');
                    });
                    if (item) OfflineCart.update(item.rowid, action);
                    return $.Deferred().resolve('').promise();
                }

                // Suppression du panier
                if (url.indexOf('removecart') !== -1 || url.indexOf('posclear') !== -1) {
                    var params = parseQueryString(settings.data || '');
                    var rowid  = params.cartid || params.rowid || '';
                    // Chercher par rowid ou par pid
                    var item = OfflineCart.items.find(function(i){
                        return i.rowid === rowid || String(i.pid) === String(params.pid || '');
                    });
                    if (item) OfflineCart.remove(item.rowid);
                    return $.Deferred().resolve('').promise();
                }
            }
            return _origAjax.apply(this, arguments);
        };
        $.ajax.ajaxSetup = _origAjax.ajaxSetup;
    }

    function parseQueryString(qs) {
        if (typeof qs === 'object') return qs;
        var params = {};
        String(qs).split('&').forEach(function(pair) {
            var kv = pair.split('=');
            if (kv[0]) params[decodeURIComponent(kv[0])] = decodeURIComponent(kv[1] || '');
        });
        return params;
    }

    // ── Interception soumission commande ──────────────────────────────────────

    function interceptOrderForms() {
        document.addEventListener('submit', function(e) {
            if (!isOnline) {
                var form = e.target;
                if (form && form.action && form.action.indexOf('pos_order') !== -1) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    saveOrderOffline(form);
                }
            }
        }, true);
    }

    function saveOrderOffline(form) {
        var formData = new FormData(form);
        var order    = {};
        formData.forEach(function(v, k) { order[k] = v; });
        order._form_action = form.action;
        // Ajouter le panier offline
        var cartData = OfflineCart.toOrderData();
        Object.assign(order, cartData);

        BonrestoDB.saveOfflineOrder(order).then(function(localId) {
            updateQueueBadge();
            if (window.toastr) {
                toastr.warning('Commande #' + localId + ' sauvegardée hors-ligne. Envoi automatique à la reconnexion.', 'Hors-ligne', { timeOut: 7000 });
            }
            // Vider le panier offline local
            OfflineCart.items = [];
            OfflineCart.render();
        });
    }

    // ── Sync au retour en ligne ───────────────────────────────────────────────

    function syncPendingOrders() {
        if (typeof BonrestoDB === 'undefined') return;
        BonrestoDB.getPendingOrders().then(function(orders) {
            if (!orders.length) return;
            orders.forEach(function(order) {
                var formData = new FormData();
                Object.keys(order).forEach(function(k) {
                    if (['local_id','status','created_at','attempts','last_error','_form_action'].indexOf(k) === -1) {
                        formData.append(k, order[k]);
                    }
                });
                formData.append('offline_local_id', order.local_id);
                formData.append('offline_created_at', order.created_at);

                fetch(order._form_action || SYNC_URL, {
                    method: 'POST', body: formData, credentials: 'same-origin'
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data.success || data.order_id) {
                        BonrestoDB.markOrderSynced(order.local_id, data.order_id || null);
                        updateQueueBadge();
                        if (window.toastr) toastr.success('Commande #' + order.local_id + ' synchronisée.', 'Sync');
                    } else {
                        BonrestoDB.markOrderFailed(order.local_id, data.message || 'Erreur');
                    }
                })
                .catch(function(e) { BonrestoDB.markOrderFailed(order.local_id, e.message); });
            });
        });
    }

    // ── Cache données menu ────────────────────────────────────────────────────

    function cacheMenuData() {
        fetch(DATA_URL, { credentials: 'same-origin' })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (typeof BonrestoDB !== 'undefined') BonrestoDB.saveMenuData(data);
                // Indexer les items par pid pour lookup rapide offline
                _menuIndex = {};
                (data.items || []).forEach(function(item) {
                    _menuIndex[parseInt(item.ProductsID || item.id || 0)] = item;
                });
            })
            .catch(function() {
                // Offline — charger depuis IndexedDB
                if (typeof BonrestoDB !== 'undefined') {
                    BonrestoDB.getMenuData('items').then(function(items) {
                        (items || []).forEach(function(item) {
                            _menuIndex[parseInt(item.ProductsID || item.id || 0)] = item;
                        });
                    });
                }
            });
    }

    // ── Init ──────────────────────────────────────────────────────────────────

    function init() {
        registerSW();
        injectOfflineUI();

        // Attendre jQuery avant d'intercepter
        if (typeof $ !== 'undefined') {
            interceptAjax();
            interceptOrderForms();
        } else {
            document.addEventListener('DOMContentLoaded', function() {
                interceptAjax();
                interceptOrderForms();
            });
        }

        setOnlineState(navigator.onLine);

        window.addEventListener('online', function() {
            setOnlineState(true);
            syncPendingOrders();
            cacheMenuData();
            if (window.toastr) toastr.success('Connexion rétablie. Synchronisation en cours...', 'Online');
        });

        window.addEventListener('offline', function() {
            setOnlineState(false);
            // Charger le menu depuis IndexedDB pour les lookups offline
            cacheMenuData();
            if (window.toastr) toastr.warning('Mode hors-ligne activé. Le panier fonctionne localement.', 'Offline');
        });

        if (navigator.onLine) {
            cacheMenuData();
            setTimeout(syncPendingOrders, 2000);
        }

        setInterval(updateQueueBadge, 30000);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
