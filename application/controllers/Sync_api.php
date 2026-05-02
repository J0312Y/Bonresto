<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sync_api — API de synchronisation Local ↔ VPS
 *
 * Ce contrôleur tourne sur le VPS.
 * Le serveur local l'appelle pour :
 *   - Envoyer ses données opérationnelles (commandes, menu, etc.)
 *   - Récupérer les commandes en ligne passées sur le VPS
 *   - Confirmer la réception des commandes en ligne
 *   - Remonter les statuts cuisine vers le VPS
 *
 * Auth : chaque requête doit inclure :
 *   X-Sync-Key: <client_key>        — identifie le tenant
 *   X-Sync-Sig: <hmac-sha256>       — signature HMAC du body JSON (sauf health)
 *
 * Routes :
 *   GET  /sync_api/health
 *   POST /sync_api/receive
 *   GET  /sync_api/online_orders
 *   POST /sync_api/ack_orders
 *   POST /sync_api/order_status
 */
class Sync_api extends CI_Controller {

    const HMAC_ALGO  = 'sha256';
    const BATCH_MAX  = 200;   // max items acceptés par appel receive()
    const ORDERS_MAX = 50;    // max commandes retournées par appel online_orders()

    /**
     * Tables de référence et leurs clés primaires (côté VPS).
     * Le VPS conserve le même PK que le local — pas d'auto_increment indépendant.
     */
    const TABLE_PKS = [
        'item_category'           => 'CategoryID',
        'item_foods'              => 'ProductsID',
        'variant'                 => 'variantid',
        'foodvariable'            => 'availableID',
        'add_ons'                 => 'add_on_id',
        'menu_add_on'             => 'row_id',
        'check_addones'           => 'id',
        'tbl_menutype'            => 'menutypeid',
        'tbl_groupitems'          => 'groupid',
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
        'tbl_country'             => 'countryid',
        'tbl_state'               => 'stateid',
        'tbl_city'                => 'cityid',
        'customer_info'           => 'customer_id',
        'customer_type'           => 'customer_type_id',
        'tbl_billingaddress'      => 'billaddressid',
        'tbl_delivaryaddress'     => 'delivaryid',
        'tbl_shippingaddress'     => 'shipaddressid',
        'membership'              => 'id',
        'tbl_kitchen'             => 'kitchenid',
        'tbl_tablefloor'          => 'tbfloorid',
        'rest_table'              => 'tableid',
        'tablelist'               => 'tableid',
        'qr_tables'               => 'table_id',
        'bill'                    => 'bill_id',
    ];

    /** Config sync du tenant courant (ligne sync_config) */
    private ?object $sync_cfg = null;

    public function __construct() {
        parent::__construct();
    }

    // ── Endpoints publics ─────────────────────────────────────────────────────

    /**
     * GET /sync_api/health
     * Ping non authentifié — le local vérifie la connectivité VPS.
     */
    public function health(): void {
        $this->_json([
            'status'      => 'ok',
            'server_time' => date('Y-m-d H:i:s'),
            'version'     => '1.0',
        ]);
    }

    /**
     * POST /sync_api/receive
     * Le local envoie un batch de données opérationnelles au VPS.
     *
     * Body: {
     *   "batch": [
     *     {
     *       "entity_type": "customer_order",
     *       "entity_id":   42,
     *       "operation":   "insert|update|delete",
     *       "sync_uuid":   "uuid-v4",
     *       "payload":     { ...données de la ligne... },
     *       "related":     { "items": [...order_menu rows...] }  // pour customer_order seulement
     *     }, ...
     *   ]
     * }
     */
    public function receive(): void {
        $this->_require_sync_auth();

        $body  = $this->_body();
        $batch = $body['batch'] ?? [];

        if (empty($batch) || !is_array($batch)) {
            $this->_abort(400, 'Batch vide ou invalide.');
        }
        if (count($batch) > self::BATCH_MAX) {
            $this->_abort(400, 'Batch trop grand (max ' . self::BATCH_MAX . ').');
        }

        $sig = $_SERVER['HTTP_X_SYNC_SIG'] ?? '';
        if (!$this->_verify_sig($batch, $sig)) {
            $this->_abort(403, 'Signature invalide.');
        }

        $accepted = 0;
        $skipped  = 0;
        $errors   = [];

        foreach ($batch as $item) {
            $entity_type = $item['entity_type'] ?? '';
            $entity_id   = (int)($item['entity_id'] ?? 0);
            $operation   = $item['operation']   ?? 'insert';
            $sync_uuid   = $item['sync_uuid']   ?? '';
            $payload     = $item['payload']      ?? [];

            // entity_type et entity_id sont toujours requis
            if (empty($entity_type) || !$entity_id) {
                $skipped++;
                continue;
            }
            // Les tables transactionnelles (customer_order, order_menu) requièrent sync_uuid
            $transactional = ['customer_order', 'order_menu'];
            if (in_array($entity_type, $transactional) && empty($sync_uuid)) {
                $skipped++;
                continue;
            }
            // Pour les opérations non-delete, le payload doit être présent
            if ($operation !== 'delete' && empty($payload)) {
                $skipped++;
                continue;
            }
            // Ne jamais ré-importer des données originaires du VPS (évite les boucles)
            if (($payload['sync_origin'] ?? 'local') === 'vps') {
                $skipped++;
                continue;
            }

            try {
                $done = $this->_upsert_entity($entity_type, $operation, $sync_uuid, $entity_id, $payload, $item['related'] ?? []);
                $done ? $accepted++ : $skipped++;
            } catch (Throwable $e) {
                $errors[] = ['entity_type' => $entity_type, 'entity_id' => $entity_id, 'error' => $e->getMessage()];
                log_message('error', "[Sync_api::receive] {$entity_type}#{$entity_id}: " . $e->getMessage());
            }
        }

        $this->_json([
            'accepted' => $accepted,
            'skipped'  => $skipped,
            'errors'   => $errors,
        ]);
    }

    /**
     * GET /sync_api/online_orders?since=2026-05-01+10:00:00&limit=50
     * Le local récupère les nouvelles commandes en ligne passées sur le VPS.
     * Retourne les commandes avec sync_origin='vps' non encore acquittées.
     */
    public function online_orders(): void {
        $this->_require_sync_auth();

        $since = $this->input->get('since') ?: '1970-01-01 00:00:00';
        $limit = min((int)($this->input->get('limit') ?: self::ORDERS_MAX), self::ORDERS_MAX);

        // Commandes VPS non acquittées par le local, créées après $since
        $orders = $this->db
            ->select('co.*, co.order_id AS vps_order_id')
            ->from('customer_order co')
            ->where('co.sync_origin', 'vps')
            ->where('co.ack_by_local_at IS NULL')
            ->where('co.order_date >=', date('Y-m-d', strtotime($since)))
            ->order_by('co.order_id', 'ASC')
            ->limit($limit)
            ->get()->result_array();

        // Enrichir chaque commande avec ses articles et l'adresse de livraison
        foreach ($orders as &$order) {
            $oid = (int)$order['order_id'];

            $order['items'] = $this->db
                ->where('order_id', $oid)
                ->get('order_menu')->result_array();

            $order['billing'] = $this->db
                ->where('order_id', $oid)
                ->get('tbl_billingaddress')->row_array() ?: [];

            $order['customer'] = $this->db
                ->where('customer_id', (int)$order['customer_id'])
                ->get('customer_info')->row_array() ?: [];
        }
        unset($order);

        $this->_json([
            'orders'      => $orders,
            'count'       => count($orders),
            'server_time' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * POST /sync_api/ack_orders
     * Le local confirme qu'il a bien reçu et importé des commandes VPS.
     * Le VPS marque ces commandes ack_by_local_at = NOW().
     *
     * Body: { "vps_order_ids": [12, 15, 19] }
     */
    public function ack_orders(): void {
        $this->_require_sync_auth();

        $body = $this->_body();
        $ids  = array_filter(array_map('intval', $body['vps_order_ids'] ?? []));

        if (empty($ids)) {
            $this->_abort(400, 'vps_order_ids vide ou invalide.');
        }

        $sig = $_SERVER['HTTP_X_SYNC_SIG'] ?? '';
        if (!$this->_verify_sig($body, $sig)) {
            $this->_abort(403, 'Signature invalide.');
        }

        $this->db
            ->where_in('order_id', $ids)
            ->where('sync_origin', 'vps')
            ->update('customer_order', ['ack_by_local_at' => date('Y-m-d H:i:s')]);

        $this->_json(['acknowledged' => $this->db->affected_rows()]);
    }

    /**
     * POST /sync_api/order_status
     * Le local remonte les mises à jour de statut cuisine vers le VPS.
     * Règle : last-write-wins basé sur updated_at.
     *
     * Body: {
     *   "updates": [
     *     { "sync_uuid": "...", "order_status": 3, "updated_at": "2026-05-02 10:07:00" }
     *   ]
     * }
     */
    public function order_status(): void {
        $this->_require_sync_auth();

        $body    = $this->_body();
        $updates = $body['updates'] ?? [];

        if (empty($updates) || !is_array($updates)) {
            $this->_abort(400, 'updates vide ou invalide.');
        }

        $sig = $_SERVER['HTTP_X_SYNC_SIG'] ?? '';
        if (!$this->_verify_sig($updates, $sig)) {
            $this->_abort(403, 'Signature invalide.');
        }

        $applied = 0;
        $skipped = 0;

        foreach ($updates as $upd) {
            $sync_uuid    = $upd['sync_uuid']    ?? '';
            $order_status = (int)($upd['order_status'] ?? 0);
            $updated_at   = $upd['updated_at']   ?? '';

            if (empty($sync_uuid) || !$order_status || empty($updated_at)) {
                $skipped++;
                continue;
            }

            // Récupère la commande sur le VPS
            $row = $this->db
                ->where('sync_uuid', $sync_uuid)
                ->get('customer_order')->row();

            if (!$row) { $skipped++; continue; }

            // Last-write-wins : on met à jour seulement si le timestamp est plus récent
            $vps_updated = strtotime($row->synced_at ?? '1970-01-01');
            if (strtotime($updated_at) <= $vps_updated) {
                $skipped++;
                continue;
            }

            $this->db
                ->where('sync_uuid', $sync_uuid)
                ->update('customer_order', [
                    'order_status' => $order_status,
                    'synced_at'    => $updated_at,
                ]);

            $applied++;
        }

        $this->_json(['applied' => $applied, 'skipped' => $skipped]);
    }

    // ── Auth ──────────────────────────────────────────────────────────────────

    /**
     * Valide X-Sync-Key et charge la config sync correspondante.
     * Termine avec 401/403 si invalide.
     */
    private function _require_sync_auth(): void {
        $client_key = $_SERVER['HTTP_X_SYNC_KEY'] ?? '';

        if (empty($client_key)) {
            $this->_abort(401, 'X-Sync-Key manquant.');
        }

        $cfg = $this->db
            ->where('client_key', $client_key)
            ->where('enabled', 1)
            ->get('sync_config')->row();

        if (!$cfg) {
            $this->_abort(403, 'Client non autorisé.');
        }

        $this->sync_cfg = $cfg;
    }

    /**
     * Vérifie la signature HMAC-SHA256 du payload.
     * La signature est calculée sur json_encode($data).
     */
    private function _verify_sig($data, string $sig): bool {
        if (empty($sig) || !$this->sync_cfg) return false;
        $expected = hash_hmac(self::HMAC_ALGO, json_encode($data), $this->sync_cfg->sync_secret);
        return hash_equals($expected, $sig);
    }

    // ── Upsert ────────────────────────────────────────────────────────────────

    /**
     * Insère ou met à jour une entité reçue du local.
     * Retourne true si traité, false si ignoré.
     */
    private function _upsert_entity(string $type, string $op, string $uuid, int $entity_id, array $payload, array $related): bool {
        switch ($type) {
            case 'customer_order':
                return $this->_upsert_order($op, $uuid, $payload, $related['items'] ?? []);
            case 'order_menu':
                return $this->_upsert_order_menu($op, $uuid, $payload);
            default:
                $pk = self::TABLE_PKS[$type] ?? null;
                if (!$pk) {
                    log_message('error', "[Sync_api] entity_type inconnu : {$type}");
                    return false;
                }
                return $this->_upsert_generic($type, $pk, $op, $entity_id, $payload);
        }
    }

    /** Upsert d'une commande + ses articles. */
    private function _upsert_order(string $op, string $uuid, array $payload, array $items): bool {
        $existing = $this->db->where('sync_uuid', $uuid)->get('customer_order')->row();

        // Prépare les données (retire order_id local — le VPS a son propre auto_increment)
        $data = $this->_sanitize_order($payload);
        $data['sync_uuid']     = $uuid;
        $data['sync_origin']   = $payload['sync_origin'] ?? 'local';
        $data['synced_to_vps'] = 1;
        $data['synced_at']     = date('Y-m-d H:i:s');

        if ($op === 'delete') {
            if ($existing) {
                $this->db->where('sync_uuid', $uuid)->delete('customer_order');
            }
            return true;
        }

        if ($existing) {
            // Mise à jour — ne pas écraser si VPS est plus récent
            $this->db->where('sync_uuid', $uuid)->update('customer_order', $data);
            $vps_order_id = (int)$existing->order_id;
        } else {
            // Insertion — nouveau order_id généré par VPS
            unset($data['order_id']); // retire le local order_id
            $this->db->insert('customer_order', $data);
            $vps_order_id = $this->db->insert_id();
        }

        // Upsert des articles liés
        if (!empty($items) && $vps_order_id) {
            $this->_upsert_order_items($vps_order_id, $uuid, $items);
        }

        return true;
    }

    /** Upsert des articles d'une commande. */
    private function _upsert_order_items(int $vps_order_id, string $order_uuid, array $items): void {
        foreach ($items as $item) {
            $item_uuid = $item['sync_uuid'] ?? null;

            $data = $this->_sanitize_order_menu($item);
            $data['order_id']      = $vps_order_id;
            $data['synced_to_vps'] = 1;
            $data['synced_at']     = date('Y-m-d H:i:s');

            if ($item_uuid) {
                $data['sync_uuid'] = $item_uuid;
                $existing = $this->db->where('sync_uuid', $item_uuid)->get('order_menu')->row();
                if ($existing) {
                    $this->db->where('sync_uuid', $item_uuid)->update('order_menu', $data);
                } else {
                    unset($data['row_id']);
                    $this->db->insert('order_menu', $data);
                }
            } else {
                unset($data['row_id']);
                $this->db->insert('order_menu', $data);
            }
        }
    }

    /** Upsert d'un article order_menu individuel (envoyé seul). */
    private function _upsert_order_menu(string $op, string $uuid, array $payload): bool {
        $existing = $this->db->where('sync_uuid', $uuid)->get('order_menu')->row();

        if ($op === 'delete') {
            if ($existing) $this->db->where('sync_uuid', $uuid)->delete('order_menu');
            return true;
        }

        $data = $this->_sanitize_order_menu($payload);
        $data['sync_uuid']     = $uuid;
        $data['synced_to_vps'] = 1;
        $data['synced_at']     = date('Y-m-d H:i:s');

        if ($existing) {
            $this->db->where('sync_uuid', $uuid)->update('order_menu', $data);
        } else {
            unset($data['row_id']);
            $this->db->insert('order_menu', $data);
        }
        return true;
    }

    /**
     * Upsert générique pour toutes les tables de référence.
     * Le VPS conserve le même PK que le local (pas d'auto_increment indépendant).
     * Pas de sync_uuid sur ces tables — déduplication par PK local.
     */
    private function _upsert_generic(string $table, string $pk_col, string $op, int $entity_id, array $payload): bool {
        if (!$this->db->table_exists($table)) {
            log_message('error', "[Sync_api::_upsert_generic] Table inexistante : {$table}");
            return false;
        }

        if ($op === 'delete') {
            $this->db->where($pk_col, $entity_id)->delete($table);
            return true;
        }

        if (empty($payload)) return false;

        // Nettoyer les métadonnées de sync absentes des tables de référence
        $clean = $payload;
        unset($clean['sync_uuid'], $clean['sync_origin'], $clean['synced_to_vps'], $clean['synced_at'], $clean['_related']);

        $existing = $this->db->where($pk_col, $entity_id)->get($table)->row();

        if ($existing) {
            $update = $clean;
            unset($update[$pk_col]); // ne jamais écraser le PK
            if (!empty($update)) {
                $this->db->where($pk_col, $entity_id)->update($table, $update);
            }
        } else {
            // Insertion avec le même PK qu'en local
            $this->db->insert($table, $clean);
        }
        return true;
    }

    // ── Sanitize ──────────────────────────────────────────────────────────────

    /** Colonnes autorisées pour customer_order (évite l'injection de colonnes inconnues). */
    private function _sanitize_order(array $row): array {
        $allowed = [
            'saleinvoice', 'customer_id', 'order_date', 'order_time',
            'table_no', 'totalamount', 'order_status', 'nofification',
            'orderacceptreject', 'anyreason', 'cutomertype', 'isupdate',
            'shipping_date', 'shipping_time', 'deliverycharge',
            'sync_origin', 'vps_order_id',
        ];
        return array_intersect_key($row, array_flip($allowed));
    }

    /** Colonnes autorisées pour order_menu. */
    private function _sanitize_order_menu(array $row): array {
        $allowed = [
            'order_id', 'menu_id', 'varientid', 'price',
            'menuqty', 'food_status', 'isupdate',
        ];
        return array_intersect_key($row, array_flip($allowed));
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function _json($data, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    private function _abort(int $code, string $msg): void {
        $this->_json(['error' => $msg, 'code' => $code], $code);
    }

    private function _body(): array {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }
}
