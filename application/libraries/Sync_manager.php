<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sync_manager — Moteur de synchronisation Local ↔ VPS
 *
 * Tourne sur le serveur LOCAL du restaurant.
 * Déclenché par Sync_cron (cron système toutes les minutes).
 *
 * Responsabilités :
 *  - enqueue()          : mettre en file une modification locale
 *  - run()              : cycle complet push + pull
 *  - push()             : envoyer la queue locale vers le VPS
 *  - pull()             : récupérer les commandes en ligne du VPS
 *  - process_incoming() : importer les commandes VPS en local
 */
class Sync_manager {

    const HMAC_ALGO     = 'sha256';
    const BATCH_SIZE    = 200;   // rows par appel push
    const MAX_ATTEMPTS  = 5;     // tentatives avant abandon
    const PUSH_INTERVAL = 60;    // secondes entre deux push
    const PULL_INTERVAL = 60;    // secondes entre deux pull
    const CONNECT_TIMEOUT = 5;   // secondes pour le ping health
    const REQUEST_TIMEOUT = 15;  // secondes pour les appels de données

    /**
     * Tables trackées → clé primaire.
     * Les tables TRANSACTIONAL utilisent enqueue() PHP + sync_uuid.
     * Les tables REFERENCE utilisent des triggers MySQL (payload=NULL, refetch au push).
     */
    const TRACKED = [
        // ── Transactional (enqueue PHP) ─────────────────────────────
        'customer_order' => 'order_id',
        'order_menu'     => 'row_id',
        'bill'           => 'bill_id',

        // ── Menu & Items (triggers) ──────────────────────────────────
        'item_category'  => 'CategoryID',
        'item_foods'     => 'ProductsID',
        'variant'        => 'variantid',
        'foodvariable'   => 'availableID',
        'add_ons'        => 'add_on_id',
        'menu_add_on'    => 'row_id',
        'check_addones'  => 'id',
        'tbl_menutype'   => 'menutypeid',
        'tbl_groupitems' => 'groupid',

        // ── Config (triggers) ────────────────────────────────────────
        'setting'                 => 'id',
        'common_setting'          => 'id',
        'currency'                => 'currencyid',
        'language'                => 'id',
        'themes'                  => 'themeid',
        'top_menu'                => 'menuid',
        'tax_settings'            => 'id',
        'payment_method'          => 'payment_method_id',
        'paymentmethod'           => 'payment_method_id',
        'paymentsetup'            => 'setupid',
        'shipping_method'         => 'ship_id',
        'tbl_delivaritime'        => 'dtimeid',
        'tbl_notificationsetting' => 'notifid',
        'tbl_slider'              => 'slid',
        'tbl_slider_type'         => 'stype_id',
        'tbl_sociallink'          => 'sid',
        'tbl_widget'              => 'widgetid',

        // ── Localisation (triggers) ──────────────────────────────────
        'tbl_country' => 'countryid',
        'tbl_state'   => 'stateid',
        'tbl_city'    => 'cityid',

        // ── Clients (triggers) ───────────────────────────────────────
        'customer_info'           => 'customer_id',
        'customer_type'           => 'customer_type_id',
        'tbl_billingaddress'      => 'billaddressid',
        'tbl_delivaryaddress'     => 'delivaryid',
        'tbl_shippingaddress'     => 'shipaddressid',
        'membership'              => 'id',

        // ── Opérations (triggers) ────────────────────────────────────
        'tbl_kitchen'    => 'kitchenid',
        'tbl_tablefloor' => 'tbfloorid',
        'rest_table'     => 'tableid',
        'tablelist'      => 'tableid',
        'qr_tables'      => 'table_id',

        // ── Comptabilité (triggers) ──────────────────────────────────────
        'acc_account_name'        => 'account_id',
        'acn_account_transaction'  => 'account_tran_id',

        // ── RH / Paie (triggers) ────────────────────────────────────────
        'department'                   => 'dept_id',
        'position'                     => 'pos_id',
        'gender'                       => 'id',
        'marital_info'                 => 'id',
        'duty_type'                    => 'id',
        'shift_management'             => 'id',
        'shift_assign'                 => 'assignid',
        'emp_attendance'               => 'att_id',
        'employee_history'             => 'emp_his_id',
        'employee_benifit'             => 'id',
        'employee_performance'         => 'emp_per_id',
        'employee_salary_setup'        => 'e_s_s_id',
        'employee_salary_payment'      => 'emp_sal_pay_id',
        'salary_type'                  => 'salary_type_id',
        'salary_setup_header'          => 's_s_h_id',
        'salary_sheet_generate'        => 'ssg_id',
        'pay_frequency'                => 'id',
        'payroll_tax_setup'            => 'tax_setup_id',
        'payroll_holiday'              => 'payrl_holi_id',
        'payroll_commission_setting'   => 'id',
        'weekly_holiday'               => 'wk_id',
        'leave_type'                   => 'leave_type_id',
        'leave_apply'                  => 'leave_appl_id',
        'award'                        => 'award_id',
        'grand_loan'                   => 'loan_id',
        'loan_installment'             => 'loan_inst_id',
        'rate_type'                    => 'id',

        // ── Recrutement (triggers) ───────────────────────────────────────
        'candidate_basic_info'         => 'can_id',
        'candidate_education_info'     => 'can_edu_id',
        'candidate_interview'          => 'can_int_id',
        'candidate_selection'          => 'can_sel_id',
        'candidate_shortlist'          => 'can_short_id',
        'candidate_workexperience'     => 'can_workexp_id',

        // ── Permissions / Utilisateurs (triggers) ────────────────────────
        'user'                    => 'id',
        'sec_role_tbl'            => 'role_id',
        'sec_role_permission'     => 'id',
        'sec_user_access_tbl'     => 'role_acc_id',
        'sec_menu_item'           => 'menu_id',
        'role_permission'         => 'id',
        'module'                  => 'id',
        'module_permission'       => 'id',

        // ── Finance / Achats (triggers) ──────────────────────────────────
        'expense'                 => 'id',
        'expense_item'            => 'id',
        'supplier'                => 'supid',
        'supplier_ledger'         => 'id',
        'purchaseitem'            => 'purID',
        'purchase_details'        => 'detailsid',
        'purchase_return'         => 'preturn_id',
        'multipay_bill'           => 'multipay_id',
        'bill_card_payment'       => 'row_id',
        'payment_transactions'    => 'id',
        'sub_order'               => 'sub_id',
        'tbl_bank'                => 'bankid',

        // ── Production / Inventaire (triggers) ───────────────────────────
        'ingredients'             => 'id',
        'production'              => 'productionid',
        'production_details'      => 'pro_detailsid',
        'waste_tracking'          => 'id',
        'ingradient_food_waste'   => 'id',
        'items_food_waste'        => 'id',
        'packaging_food_waste'    => 'id',
        'unit_of_measurement'     => 'id',

        // ── Réservations (triggers) ──────────────────────────────────────
        'tblreservation'          => 'reserveid',
        'reservationofday'        => 'offdayid',
        'tblserver'               => 'serverid',

        // ── Commandes / Cuisine / POS (triggers) ─────────────────────────
        'qr_orders'               => 'id',
        'qr_payments'             => 'payment_id',
        'table_details'           => 'id',
        'table_setting'           => 'settingid',
        'tbl_assign_kitchen'      => 'assignid',
        'tbl_cancelitem'          => 'cancelid',
        'tbl_card_terminal'       => 'card_terminalid',
        'tbl_cashcounter'         => 'ccid',
        'tbl_cashregister'        => 'id',
        'tbl_itemaccepted'        => 'acid',
        'tbl_kitchen_order'       => 'ktid',
        'tbl_openclose'           => 'stid',
        'tbl_orderprepare'        => 'opid',
        'tbl_posetting'           => 'possettingid',
        'tbl_quickordersetting'   => 'quickordid',
        'tbl_rating'              => 'ratingid',
        'tbl_room'                => 'id',
        'tbl_updateitems'         => 'updateid',
        'usedcoupon'              => 'cusedid',

        // ── Config divers (triggers) ─────────────────────────────────────
        'email_config'            => 'email_config_id',
        'sms_template'            => 'id',
        'facebook_settings'       => 'id',
        'tbl_customerpoint'       => 'id',
        'customer_membership_map' => 'id',
        'subscribe_emaillist'     => 'emailid',
        'tbl_seoption'            => 'id',
        'tbl_soundsetting'        => 'soundid',
        // tbl_generatedreport : rapports locaux uniquement, pas syncé
        // tbl_module_purchasekey : licences propres à chaque instance, pas syncé
    ];

    /** Tables gérées par enqueue() PHP (ont un sync_uuid). */
    const TRANSACTIONAL = ['customer_order', 'order_menu'];

    private ?object $cfg    = null;  // ligne sync_config
    private bool    $online = false;

    public function __construct() {
        $CI =& get_instance();
        $CI->load->database(); // assure que $CI->db est chargé
    }

    // ── Point d'entrée principal ──────────────────────────────────────────────

    /**
     * Cycle complet : connectivity → push → pull → process.
     * Retourne un rapport pour Sync_cron.
     */
    public function run(): array {
        if (!$this->_load_config()) {
            return ['error' => 'sync_config introuvable ou désactivé.'];
        }

        $this->online = $this->check_connectivity();

        if (!$this->online) {
            $this->_log('VPS inaccessible — sync reportée.');
            return ['online' => false, 'message' => 'VPS inaccessible, données en queue.'];
        }

        $report = ['online' => true];

        // Push : local → VPS
        $CI =& get_instance();
        $last_push = strtotime($this->cfg->last_push ?? '1970-01-01');
        if ((time() - $last_push) >= self::PUSH_INTERVAL) {
            $report['push'] = $this->push();
            $this->_save_timestamp('last_push');
        }

        // Pull : VPS → local
        $last_pull = strtotime($this->cfg->last_pull ?? '1970-01-01');
        if ((time() - $last_pull) >= self::PULL_INTERVAL) {
            $pulled = $this->pull();
            $report['pull']    = $pulled;
            $report['import']  = $this->process_incoming();
            $this->_save_timestamp('last_pull');
        }

        return $report;
    }

    // ── Enqueue ───────────────────────────────────────────────────────────────

    /**
     * Ajoute une modification en file d'attente.
     * Appelé depuis les contrôleurs après chaque INSERT/UPDATE sur les tables trackées.
     *
     * @param string $entity_type  Nom de la table (ex: 'customer_order')
     * @param int    $entity_id    PK de la ligne
     * @param string $operation    'insert'|'update'|'delete'
     * @param array  $payload      Snapshot de la ligne à ce moment
     * @param array  $related      Données liées (ex: ['items' => [...order_menu rows]])
     */
    public function enqueue(string $entity_type, int $entity_id, string $operation, array $payload, array $related = []): void {
        if (!isset(self::TRACKED[$entity_type])) return;
        // Les tables de référence sont capturées automatiquement par triggers MySQL.
        if (!in_array($entity_type, self::TRANSACTIONAL)) return;

        // Assure qu'un sync_uuid existe
        if (empty($payload['sync_uuid'])) {
            $uuid = self::generate_uuid();
            $payload['sync_uuid'] = $uuid;
            // Persiste le UUID sur la ligne source
            $CI =& get_instance();
            $CI->db->where(self::TRACKED[$entity_type], $entity_id)
                   ->update($entity_type, ['sync_uuid' => $uuid]);
        }

        $CI =& get_instance();
        $CI->db->insert('sync_queue', [
            'entity_type' => $entity_type,
            'entity_id'   => $entity_id,
            'operation'   => $operation,
            'payload'     => json_encode(array_merge($payload, ['_related' => $related])),
            'status'      => 'pending',
            'attempts'    => 0,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
    }

    // ── Push : Local → VPS ───────────────────────────────────────────────────

    /**
     * Traite la queue sortante et envoie les batches au VPS.
     */
    public function push(): array {
        $CI =& get_instance();

        $rows = $CI->db
            ->where('status', 'pending')
            ->where('attempts <', self::MAX_ATTEMPTS)
            ->order_by('queue_id', 'ASC')
            ->limit(self::BATCH_SIZE)
            ->get('sync_queue')->result_array();

        if (empty($rows)) return ['sent' => 0, 'failed' => 0];

        $batch     = [];
        $queue_ids = [];

        foreach ($rows as $row) {
            $entity_type = $row['entity_type'];
            $entity_id   = (int)$row['entity_id'];
            $operation   = $row['operation'];

            if ($row['payload'] === null) {
                // Trigger-sourced : on relit la ligne courante depuis la table source.
                if ($operation === 'delete') {
                    $data    = [];   // delete : pas besoin du payload
                    $related = [];
                } else {
                    $data = $this->_fetch_payload($entity_type, $entity_id);
                    if ($data === null) {
                        // Ligne disparue avant le push (ex: insert+delete rapide) — on skip.
                        $CI->db->where('queue_id', $row['queue_id'])
                               ->update('sync_queue', ['status' => 'skipped']);
                        continue;
                    }
                    $related = [];
                }
            } else {
                $data    = json_decode($row['payload'], true) ?? [];
                $related = $data['_related'] ?? [];
                unset($data['_related']);
            }

            $batch[]     = [
                'entity_type' => $entity_type,
                'entity_id'   => $entity_id,
                'operation'   => $operation,
                'sync_uuid'   => $data['sync_uuid'] ?? '',
                'payload'     => $data,
                'related'     => $related,
            ];
            $queue_ids[] = (int)$row['queue_id'];
        }

        $body = ['batch' => $batch];
        $sig  = $this->_sign($batch);

        $response = $this->_post('/sync_api/receive', $body, $sig);

        if ($response && isset($response['accepted'])) {
            // Succès : marquer comme envoyés
            $CI->db->where_in('queue_id', $queue_ids)
                   ->update('sync_queue', [
                       'status'  => 'sent',
                       'sent_at' => date('Y-m-d H:i:s'),
                   ]);

            $this->_log_entry('push', 'batch', $response['accepted'], 'ok',
                "sent={$response['accepted']} skipped={$response['skipped']} errors=" . count($response['errors'] ?? []));

            return ['sent' => $response['accepted'], 'failed' => 0];
        }

        // Échec : incrémenter attempts
        foreach ($queue_ids as $qid) {
            $CI->db->where('queue_id', $qid)->set('attempts', 'attempts+1', false)->update('sync_queue');
        }
        // Marquer 'failed' les lignes qui ont atteint MAX_ATTEMPTS
        $CI->db->where('status', 'pending')
               ->where('attempts >=', self::MAX_ATTEMPTS)
               ->where_in('queue_id', $queue_ids)
               ->update('sync_queue', ['status' => 'failed', 'last_error' => 'Max attempts reached']);

        $this->_log_entry('push', 'batch', 0, 'failed', 'Aucune réponse du VPS');
        return ['sent' => 0, 'failed' => count($queue_ids)];
    }

    // ── Pull : VPS → Local ───────────────────────────────────────────────────

    /**
     * Interroge le VPS pour récupérer les nouvelles commandes en ligne.
     * Insère les entrées dans sync_online_orders (status='pending').
     */
    public function pull(): int {
        $CI    =& get_instance();
        $since = $this->cfg->last_pull ?? '1970-01-01 00:00:00';

        $response = $this->_get('/sync_api/online_orders', [
            'since' => $since,
            'limit' => self::BATCH_SIZE,
        ]);

        if (!$response || empty($response['orders'])) return 0;

        $new = 0;
        foreach ($response['orders'] as $order) {
            $vps_order_id = (int)($order['vps_order_id'] ?? $order['order_id'] ?? 0);
            $vps_uuid     = $order['sync_uuid'] ?? '';

            if (!$vps_order_id || !$vps_uuid) continue;

            // Dédup : ignorer si déjà connu
            $exists = $CI->db->where('vps_order_id', $vps_order_id)->count_all_results('sync_online_orders');
            if ($exists) continue;

            $CI->db->insert('sync_online_orders', [
                'vps_order_id'  => $vps_order_id,
                'vps_sync_uuid' => $vps_uuid,
                'status'        => 'pending',
                'pulled_at'     => date('Y-m-d H:i:s'),
                // Stocke le payload complet pour l'import
                'last_error'    => json_encode($order),
            ]);
            $new++;
        }

        if ($new) {
            $this->_log_entry('pull', 'online_orders', $new, 'ok', "Nouvelles commandes VPS : {$new}");
        }

        return $new;
    }

    /**
     * Importe les commandes VPS en attente dans la DB locale.
     */
    public function process_incoming(): array {
        $CI =& get_instance();

        $pending = $CI->db
            ->where('status', 'pending')
            ->get('sync_online_orders')->result_array();

        $imported = 0;
        $failed   = 0;

        foreach ($pending as $row) {
            $payload = json_decode($row['last_error'], true); // last_error stocke temporairement le payload
            if (!$payload) { $failed++; continue; }

            try {
                $local_order_id = $this->_import_online_order($payload);

                if ($local_order_id) {
                    $CI->db->where('id', $row['id'])->update('sync_online_orders', [
                        'status'         => 'imported',
                        'local_order_id' => $local_order_id,
                        'imported_at'    => date('Y-m-d H:i:s'),
                        'last_error'     => null,
                    ]);

                    // Acquitter auprès du VPS
                    $this->_ack_vps_order((int)$row['vps_order_id']);
                    $imported++;
                } else {
                    $this->_mark_import_failed($row['id'], 'Import retourné 0');
                    $failed++;
                }
            } catch (Throwable $e) {
                $this->_mark_import_failed($row['id'], $e->getMessage());
                $this->_log("Import échoué vps_order_id={$row['vps_order_id']}: " . $e->getMessage());
                $failed++;
            }
        }

        if ($imported || $failed) {
            $this->_log_entry('pull', 'import', $imported, $failed ? 'partial' : 'ok',
                "imported={$imported} failed={$failed}");
        }

        return ['imported' => $imported, 'failed' => $failed];
    }

    // ── Import d'une commande VPS ─────────────────────────────────────────────

    /**
     * Insère une commande en ligne VPS dans la DB locale.
     * Retourne le local order_id créé, ou 0 en cas d'échec.
     */
    private function _import_online_order(array $order): int {
        $CI =& get_instance();

        $vps_uuid = $order['sync_uuid'] ?? '';

        // Dédup : si le UUID existe déjà localement, ne pas re-importer
        if ($vps_uuid) {
            $existing = $CI->db->where('sync_uuid', $vps_uuid)->get('customer_order')->row();
            if ($existing) return (int)$existing->order_id;
        }

        // ── Upsert client ──────────────────────────────────────────────────────
        $customer_id = $this->_upsert_customer($order['customer'] ?? []);

        // ── Insertion commande ─────────────────────────────────────────────────
        $order_data = [
            'customer_id'    => $customer_id,
            'saleinvoice'    => $order['saleinvoice']  ?? '',
            'order_date'     => $order['order_date']   ?? date('Y-m-d'),
            'order_time'     => $order['order_time']   ?? date('H:i:s'),
            'totalamount'    => $order['totalamount']  ?? 0,
            'order_status'   => 1, // Pending — la cuisine traitera
            'cutomertype'    => 2, // Commande en ligne
            'sync_uuid'      => $vps_uuid,
            'sync_origin'    => 'vps',
            'synced_to_vps'  => 1,
            'synced_at'      => date('Y-m-d H:i:s'),
            'vps_order_id'   => (int)($order['vps_order_id'] ?? $order['order_id'] ?? 0),
        ];

        // Champs optionnels
        foreach (['table_no', 'deliverycharge', 'customer_note', 'shipping_date', 'shipping_time'] as $f) {
            if (isset($order[$f])) $order_data[$f] = $order[$f];
        }

        $CI->db->insert('customer_order', $order_data);
        $local_order_id = (int)$CI->db->insert_id();

        if (!$local_order_id) return 0;

        // ── Articles ───────────────────────────────────────────────────────────
        foreach ($order['items'] ?? [] as $item) {
            $CI->db->insert('order_menu', [
                'order_id'   => $local_order_id,
                'menu_id'    => $item['menu_id']   ?? 0,
                'varientid'  => $item['varientid'] ?? 0,
                'price'      => $item['price']     ?? 0,
                'menuqty'    => $item['menuqty']   ?? 1,
                'food_status'=> 0,
                'sync_uuid'  => $item['sync_uuid'] ?? self::generate_uuid(),
                'synced_to_vps' => 1,
                'synced_at'  => date('Y-m-d H:i:s'),
            ]);
        }

        // ── Adresse de livraison (si présente) ────────────────────────────────
        if (!empty($order['billing'])) {
            $billing = $order['billing'];
            $billing['order_id'] = $local_order_id;
            unset($billing['id']); // retire le PK distant

            // Insert seulement si la table existe
            if ($CI->db->table_exists('tbl_billingaddress')) {
                $CI->db->insert('tbl_billingaddress', $billing);
            }
        }

        $this->_log("Commande VPS importée : vps_order_id={$order_data['vps_order_id']} → local_order_id={$local_order_id}");
        return $local_order_id;
    }

    /**
     * Trouve ou crée le client localement.
     * Retourne le customer_id local.
     */
    private function _upsert_customer(array $customer): int {
        if (empty($customer)) return 0;
        $CI =& get_instance();

        $email = $customer['customer_email'] ?? $customer['email'] ?? '';
        if ($email) {
            $existing = $CI->db->where('customer_email', $email)->get('customer_info')->row();
            if ($existing) return (int)$existing->customer_id;
        }

        $data = [];
        foreach (['customer_name', 'customer_email', 'customer_phone', 'customer_address'] as $f) {
            if (isset($customer[$f])) $data[$f] = $customer[$f];
        }
        if (empty($data)) return 0;

        $data['is_active'] = 1;
        $CI->db->insert('customer_info', $data);
        return (int)$CI->db->insert_id();
    }

    // ── ACK VPS ───────────────────────────────────────────────────────────────

    private function _ack_vps_order(int $vps_order_id): void {
        $body = ['vps_order_ids' => [$vps_order_id]];
        $this->_post('/sync_api/ack_orders', $body, $this->_sign($body));
    }

    // ── Helpers sync_online_orders ────────────────────────────────────────────

    private function _mark_import_failed(int $id, string $error): void {
        $CI =& get_instance();
        $CI->db->where('id', $id)->update('sync_online_orders', [
            'status'     => 'failed',
            'last_error' => $error,
        ]);
    }

    // ── Connectivité ─────────────────────────────────────────────────────────

    public function check_connectivity(): bool {
        if (!$this->cfg) return false;
        $ctx = stream_context_create(['http' => [
            'method'        => 'GET',
            'timeout'       => self::CONNECT_TIMEOUT,
            'ignore_errors' => true,
        ]]);
        $raw = @file_get_contents($this->cfg->vps_url . '/sync_api/health', false, $ctx);
        if (!$raw) return false;
        $res = json_decode($raw, true);
        return ($res['status'] ?? '') === 'ok';
    }

    // ── UUID ──────────────────────────────────────────────────────────────────

    public static function generate_uuid(): string {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    // ── Config ────────────────────────────────────────────────────────────────

    private function _load_config(): bool {
        $CI =& get_instance();
        $row = $CI->db->where('enabled', 1)->limit(1)->get('sync_config')->row();
        if (!$row) return false;
        $this->cfg = $row;
        return true;
    }

    private function _save_timestamp(string $field): void {
        if (!$this->cfg) return;
        $CI =& get_instance();
        $CI->db->where('id', $this->cfg->id)->update('sync_config', [$field => date('Y-m-d H:i:s')]);
    }

    // ── HTTP ──────────────────────────────────────────────────────────────────

    private function _post(string $path, array $body, string $sig = ''): ?array {
        $headers = "Content-Type: application/json\r\n"
                 . "X-Sync-Key: {$this->cfg->client_key}\r\n";
        if ($sig) $headers .= "X-Sync-Sig: {$sig}\r\n";

        $ctx = stream_context_create(['http' => [
            'method'        => 'POST',
            'header'        => $headers,
            'content'       => json_encode($body),
            'timeout'       => self::REQUEST_TIMEOUT,
            'ignore_errors' => true,
        ]]);
        $raw = @file_get_contents($this->cfg->vps_url . $path, false, $ctx);
        return $raw !== false ? (json_decode($raw, true) ?: null) : null;
    }

    private function _get(string $path, array $params = []): ?array {
        $url = $this->cfg->vps_url . $path;
        if ($params) $url .= '?' . http_build_query($params);

        $ctx = stream_context_create(['http' => [
            'method'        => 'GET',
            'header'        => "X-Sync-Key: {$this->cfg->client_key}\r\n",
            'timeout'       => self::REQUEST_TIMEOUT,
            'ignore_errors' => true,
        ]]);
        $raw = @file_get_contents($url, false, $ctx);
        return $raw !== false ? (json_decode($raw, true) ?: null) : null;
    }

    private function _sign($data): string {
        return hash_hmac(self::HMAC_ALGO, json_encode($data), $this->cfg->sync_secret);
    }

    // ── Fetch payload (trigger-sourced) ──────────────────────────────────────

    /**
     * Relit la ligne courante depuis la table source pour les entrées
     * insérées par trigger (payload=NULL dans sync_queue).
     * Retourne null si la ligne n'existe plus.
     */
    private function _fetch_payload(string $entity_type, int $entity_id): ?array {
        $pk = self::TRACKED[$entity_type] ?? null;
        if (!$pk) return null;
        $CI =& get_instance();
        $row = $CI->db->where($pk, $entity_id)->get($entity_type)->row_array();
        if (!$row) return null;

        // Pour customer_order, attacher les articles (order_menu) comme related
        if ($entity_type === 'customer_order') {
            $items = $CI->db->where('order_id', $entity_id)->get('order_menu')->result_array();
            $row['_related'] = ['items' => $items];
        }

        return $row;
    }

    // ── Log ───────────────────────────────────────────────────────────────────

    private function _log(string $msg): void {
        $log_file = APPPATH . 'logs/sync.log';
        @file_put_contents($log_file, '[' . date('Y-m-d H:i:s') . '] ' . $msg . PHP_EOL, FILE_APPEND);
    }

    private function _log_entry(string $direction, string $entity, int $count, string $status, string $message = ''): void {
        $CI =& get_instance();
        $CI->db->insert('sync_log', [
            'direction' => $direction,
            'entity'    => $entity,
            'count'     => $count,
            'status'    => $status,
            'message'   => $message,
            'ran_at'    => date('Y-m-d H:i:s'),
        ]);
        $this->_log("[{$direction}] {$entity} — {$status} — {$message}");
    }
}
