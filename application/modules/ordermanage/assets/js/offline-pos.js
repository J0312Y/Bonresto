/**
 * Bonresto — POS Offline Manager v4
 *
 * 1. Service Worker registration
 * 2. Détection online/offline → pill flottante
 * 3. Capture-phase click interceptor : quand offline, intercepte le clic sur
 *    .select_product AVANT que possetting.js ne déclenche son AJAX, et gère
 *    le panier 100% en JS
 * 4. Soumission commande offline → IndexedDB
 * 5. Sync automatique au retour en ligne
 */

(function () {
    'use strict';

    var BASE_URL = window.BONRESTO_BASE_URL || '/';
    var SW_URL   = BASE_URL + 'sw.js';
    var DATA_URL = BASE_URL + 'ordermanage/order/pos_offline_data';
    var SYNC_URL = BASE_URL + 'ordermanage/order/sync_offline_orders';

    var isOnline = navigator.onLine;

    // ── Service Worker ────────────────────────────────────────────────────────

    function registerSW() {
        if (!('serviceWorker' in navigator)) return;
        navigator.serviceWorker.register(SW_URL, { scope: BASE_URL })
            .then(function(reg) {
                reg.addEventListener('updatefound', function() {
                    var newSW = reg.installing;
                    newSW.addEventListener('statechange', function() {
                        if (newSW.state === 'installed' && navigator.serviceWorker.controller) {
                            navigator.serviceWorker.controller.postMessage('SKIP_WAITING');
                        }
                    });
                });
            })
            .catch(function(e) { console.warn('[Offline] SW:', e); });
    }

    // ── UI ────────────────────────────────────────────────────────────────────

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
            boxShadow: '0 3px 12px rgba(0,0,0,.35)',
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

        add: function(pid, itemname, varientname, price, sizeid) {
            pid    = parseInt(pid)     || 0;
            sizeid = parseInt(sizeid)  || 0;
            price  = parseFloat(price) || 0;
            // Raw strings from DOM — no URL-decoding needed
            var name = String(itemname   || '').trim() || ('Item #' + pid);
            var size = String(varientname || '').trim();

            var existing = this.items.find(function(i) {
                return i.pid === pid && i.sizeid === sizeid;
            });
            if (existing) {
                existing.qty++;
            } else {
                this.items.push({
                    rowid: 'off_' + pid + '_' + sizeid + '_' + Date.now(),
                    pid: pid, name: name, price: price,
                    qty: 1, sizeid: sizeid, size: size
                });
            }
        },

        update: function(rowid, action) {
            var idx = this.items.findIndex(function(i) { return i.rowid === rowid; });
            if (idx === -1) return;
            if (action === 'add') {
                this.items[idx].qty++;
            } else {
                this.items[idx].qty--;
                if (this.items[idx].qty <= 0) this.items.splice(idx, 1);
            }
        },

        remove: function(rowid) {
            this.items = this.items.filter(function(i) { return i.rowid !== rowid; });
        },

        total: function() {
            return this.items.reduce(function(s, i) { return s + i.price * i.qty; }, 0);
        },

        /**
         * Génère le HTML identique à poscartlist.php.
         * possetting.js lit les hidden inputs pour mettre à jour les totaux.
         */
        buildHtml: function() {
            var rows  = '';
            var count = 0;
            var total = this.total();

            this.items.forEach(function(item) {
                count++;
                var lineTotal = (item.price * item.qty).toFixed(0);
                var SVG_DELETE =
                    '<svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                    '<path fill-rule="evenodd" clip-rule="evenodd" d="M0 3.9975C0 3.65763 0.27552 3.38212 0.615385 3.38212H15.3846C15.7245 3.38212 16 3.65763 16 3.9975C16 4.33737 15.7245 4.61289 15.3846 4.61289H0.615385C0.27552 4.61289 0 4.33737 0 3.9975Z" fill="#D43407"/>' +
                    '<path fill-rule="evenodd" clip-rule="evenodd" d="M13.8323 11.8018C13.5918 13.9802 13.4715 15.0694 12.8566 15.8213C12.6415 16.0842 12.3871 16.3121 12.1021 16.497C11.2873 17.0256 10.1915 17.0256 7.9998 17.0256C5.80824 17.0256 4.71244 17.0256 3.89755 16.497C3.61262 16.3121 3.35811 16.0842 3.14311 15.8213C2.5282 15.0694 2.4079 13.9801 2.16731 11.8018L1.24268 3.43009H14.757L13.8323 11.8018Z" fill="#D43407"/>' +
                    '</svg>';

                rows +=
                    '<tr id="' + count + '">' +
                    '<th id="product_name_MFU4E">' + item.name +
                        '<a class="serach pl-15" title="Note"><i class="fa fa-sticky-note" aria-hidden="true"></i></a>' +
                    '</th>' +
                    '<td>' + item.size + '</td>' +
                    '<td>' + item.price + '</td>' +
                    '<td scope="row">' +
                        '<a class="btn btn-info btn-sm btn-incriment btnleftalign" ' +
                            'onclick="OfflineCart.updateAndRefresh(\'' + item.rowid + '\',\'add\')">' +
                            '<i class="fa fa-plus" aria-hidden="true"></i></a>' +
                        ' <span id="productionsetting-' + item.pid + '-' + item.sizeid + '">' + item.qty + '</span> ' +
                        '<a class="btn btn-danger btn-sm btn-dicriment btnrightalign" ' +
                            'onclick="OfflineCart.updateAndRefresh(\'' + item.rowid + '\',\'del\')">' +
                            '<i class="fa fa-minus" aria-hidden="true"></i></a>' +
                    '</td>' +
                    '<td>' + lineTotal + '</td>' +
                    '<td><a href="javascript:void(0);" class="btnrightalign" ' +
                        'onclick="OfflineCart.removeAndRefresh(\'' + item.rowid + '\')">' +
                        SVG_DELETE + '</a></td>' +
                    '</tr>';
            });

            // Hidden inputs identiques à poscartlist.php
            var hiddens =
                '<input name="grandtotal" id="grtotal" type="hidden" value="' + total.toFixed(0) + '">' +
                '<input name="subtotal" id="subtotal" type="hidden" value="' + total.toFixed(0) + '">' +
                '<input name="totalitem" id="totalitem" type="hidden" value="' + count + '">' +
                '<input name="multiplletaxvalue" id="multiplletaxvalue" type="hidden" value="">' +
                '<input name="tvat" type="hidden" value="0" id="tvat">' +
                '<input name="sc" type="hidden" value="0" id="sc">' +
                '<input name="tdiscount" type="hidden" value="0" id="tdiscount">' +
                '<input name="tgtotal" type="hidden" value="' + total.toFixed(0) + '" id="tgtotal">';

            if (count === 0) return hiddens;

            return '<table class="table item-table border-none wpr_100 mb-0" border="1" id="addinvoice">' +
                   '<thead><tr>' +
                   '<th>Item</th><th>Variant</th><th>Price</th>' +
                   '<th class="text-center">Qnt.</th><th>Total</th><th>Action</th>' +
                   '</tr></thead>' +
                   '<tbody class="itemNumber">' + rows + hiddens + '</tbody>' +
                   '</table>';
        },

        // Appelés depuis les onclick inline du HTML généré
        updateAndRefresh: function(rowid, action) {
            this.update(rowid, action);
            $('#addfoodlist').html(this.buildHtml());
            this._refreshTotals();
        },

        removeAndRefresh: function(rowid) {
            this.remove(rowid);
            $('#addfoodlist').html(this.buildHtml());
            this._refreshTotals();
        },

        _refreshTotals: function() {
            var total     = parseFloat($('#tgtotal').val())  || 0;
            var totalitem = parseInt($('#totalitem').val())  || 0;
            $('#item-number').text(totalitem);
            $('#getitemp').val(totalitem);
            $('#caltotal').text(total.toFixed(0));
            $('#grandtotal').val(total.toFixed(0));
            $('#orggrandTotal').val(total.toFixed(0));
            $('#orginattotal').val(total.toFixed(0));
        },

        toOrderData: function() {
            return {
                offline_cart:        JSON.stringify(this.items),
                offline_total:       this.total().toFixed(0),
                offline_items_count: this.items.length,
            };
        }
    };

    window.OfflineCart = OfflineCart;

    // ── Capture-phase click interceptor ───────────────────────────────────────
    //
    // possetting.js uses: $("body").on("click", ".select_product", fn)
    // That handler is in the BUBBLE phase.
    // We use the CAPTURE phase (3rd arg = true) so our handler fires FIRST.
    // When offline, we stopPropagation() so possetting.js never sees the click.

    function setupOfflineClickHandler() {
        document.addEventListener('click', function(e) {
            if (isOnline) return; // Let possetting.js handle normally when online

            // Walk up the DOM to find the .select_product ancestor
            var panel = e.target;
            while (panel && panel !== document) {
                if (panel.classList && panel.classList.contains('select_product')) break;
                panel = panel.parentNode;
            }
            if (!panel || panel === document) return;

            // Block the click from reaching possetting.js
            e.stopPropagation();
            e.preventDefault();

            // Extract item data directly from the hidden inputs in the panel
            var pid        = (panel.querySelector('input[name=select_product_id]')    || {}).value || 0;
            var sizeid     = (panel.querySelector('input[name=select_product_size]')   || {}).value || 0;
            var itemname   = (panel.querySelector('input[name=select_product_name]')   || {}).value || '';
            var varientname = (panel.querySelector('input[name=select_varient_name]')  || {}).value || '';
            var price      = (panel.querySelector('input[name=select_product_price]')  || {}).value || 0;

            OfflineCart.add(pid, itemname, varientname, price, sizeid);

            var html = OfflineCart.buildHtml();
            document.getElementById('addfoodlist').innerHTML = html;
            OfflineCart._refreshTotals();

        }, true); // ← capture phase
    }

    // ── Interception soumission commande (wrapper placeorder) ────────────────
    //
    // possetting.js appelle placeorder() qui tire $.ajax() directement —
    // pas de form submit. On wrappe la fonction globale après le chargement
    // de possetting.js pour intercepter quand offline.

    function wrapPlaceorder() {
        if (typeof window.placeorder !== 'function') return;
        var _orig = window.placeorder;

        window.placeorder = function() {
            if (!isOnline) {
                // Vérification minimale : panier non vide
                if (OfflineCart.items.length === 0) {
                    alert('Please add Some Food!!!');
                    return false;
                }

                // Collecter les données du formulaire POS
                var order = {
                    customer_name:    ($('#customer_name').val()      || ''),
                    ctypeid:          ($('#ctypeid').val()             || ''),
                    waiter:           ($('#waiter').val()              || ''),
                    tableid:          ($('#tableid').val()             || ''),
                    grandtotal:       ($('#grandtotal').val()          || OfflineCart.total().toFixed(0)),
                    subtotal:         ($('#subtotal').val()            || OfflineCart.total().toFixed(0)),
                    totalitem:        ($('#totalitem').val()           || OfflineCart.items.length),
                    order_date:       ($('#order_date').val()          || ''),
                    invoice_discount: ($('#invoice_discount').val()    || '0'),
                    service_charge:   ($('#service_charge').val()      || '0'),
                    vat:              ($('#vat').val()                  || '0'),
                    cookedtime:       ($('#cookedtime').val()           || ''),
                    multiplletaxvalue:($('#multiplletaxvalue').val()   || ''),
                    isonline:         ($('#isonline').val()             || '0'),
                    _form_action:     (typeof basicinfo !== 'undefined' ? basicinfo.baseurl : BASE_URL) + 'ordermanage/order/pos_order',
                };
                Object.assign(order, OfflineCart.toOrderData());

                if (typeof BonrestoDB === 'undefined') {
                    if (window.toastr) toastr.error('IndexedDB non disponible.', 'Erreur offline');
                    return false;
                }

                BonrestoDB.saveOfflineOrder(order).then(function(localId) {
                    updateQueueBadge();

                    // Vider le panier offline
                    OfflineCart.items = [];
                    document.getElementById('addfoodlist').innerHTML = OfflineCart.buildHtml();
                    OfflineCart._refreshTotals();

                    // Remettre à zéro les champs POS comme le ferait possetting.js
                    $('#getitemp').val('0');
                    $('#calvat').text('0');
                    $('#vat').val('0');
                    $('#invoice_discount').val('0');
                    $('#caltotal').text('');
                    $('#grandtotal').val('');
                    $('#waiter').val('');
                    $('#tableid').val('');

                    if (window.toastr) {
                        toastr.success(
                            'Commande #' + localId + ' sauvegardée hors-ligne. Envoi automatique à la reconnexion.',
                            'Hors-ligne',
                            { timeOut: 7000 }
                        );
                    }
                });

                return false; // bloquer l'appel original (pas d'AJAX vers le serveur)
            }

            // En ligne → comportement normal
            return _orig.apply(this, arguments);
        };
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
                .catch(function(e) {
                    BonrestoDB.markOrderFailed(order.local_id, e.message);
                });
            });
        });
    }

    // ── Cache données menu ────────────────────────────────────────────────────

    function cacheMenuData() {
        fetch(DATA_URL, { credentials: 'same-origin' })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (typeof BonrestoDB !== 'undefined') BonrestoDB.saveMenuData(data);
            })
            .catch(function() {});
    }

    // ── Init ──────────────────────────────────────────────────────────────────

    function init() {
        registerSW();
        injectOfflineUI();
        setupOfflineClickHandler();
        wrapPlaceorder();
        setOnlineState(navigator.onLine);

        window.addEventListener('online', function() {
            setOnlineState(true);
            syncPendingOrders();
            cacheMenuData();
            if (window.toastr) toastr.success('Connexion rétablie. Synchronisation en cours...', 'Online');
        });

        window.addEventListener('offline', function() {
            setOnlineState(false);
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
