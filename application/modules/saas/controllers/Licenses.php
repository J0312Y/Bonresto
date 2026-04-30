<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/Saas_base.php';

class Licenses extends Saas_base {

    /** GET /saas/licenses */
    public function index() {
        $this->require_auth();
        $keys = $this->Saas_model->get_all_licenses();
        foreach ($keys as &$k) {
            $k['key_id']       = (int)$k['key_id'];
            $k['tenant_id']    = (int)$k['tenant_id'];
            $k['is_activated'] = (bool)$k['is_activated'];
            $k['price']        = $k['price'] !== null ? (float)$k['price'] : null;
        }
        $this->_json($keys);
    }

    /** POST /saas/licenses/generate */
    public function generate() {
        $this->require_auth();
        $body      = $this->_body();
        $tenant_id = (int)($body['client_id'] ?? 0);
        if (!$tenant_id) $this->_abort(400, 'client_id requis.');

        $key = $this->Saas_model->generate_license($tenant_id);
        $this->Saas_model->log_activity($tenant_id, 'license_generated', 'Clé d\'activation générée', [
            'key' => $key['client_key'],
        ]);
        $this->_json($key, 201);
    }

    /** POST /saas/licenses/{id}/revoke */
    public function revoke(int $id) {
        $this->require_auth();
        $this->Saas_model->revoke_license($id);
        $this->_json(['success' => true]);
    }

    /**
     * POST /saas/licenses/activate
     * Called by the local bonresto server when a customer enters their key.
     * This endpoint is PUBLIC (no JWT required).
     */
    public function activate() {
        $body       = $this->_body();
        $client_key = strtoupper(trim($body['client_key'] ?? ''));
        $server_url = trim($body['server_url'] ?? '');

        if (!$client_key) $this->_abort(400, 'client_key requis.');

        $tenant = $this->Saas_model->activate_license($client_key, $server_url);
        if (!$tenant) $this->_abort(404, 'Clé invalide.');

        $this->Saas_model->log_activity(
            $tenant['client_id'],
            'license_activated',
            'Serveur local activé',
            ['server_url' => $server_url, 'key' => $client_key]
        );

        // Return a signed license payload (same format as before)
        $sub = $tenant['subscription'] ?? null;
        $payload = [
            'client_id'   => $tenant['client_id'],
            'plan'        => $sub['plan_name'] ?? 'none',
            'features'    => $sub['features'] ?? [],
            'max_tables'  => $sub['max_tables'] ?? 0,
            'max_users'   => $sub['max_users'] ?? 0,
            'status'      => $sub['status'] ?? 'none',
            'valid_until' => ($sub['end_date'] ?? date('Y-m-d')) . ' 23:59:59',
            'grace_until' => ($sub['grace_end_date'] ?? date('Y-m-d')) . ' 23:59:59',
            'issued_at'   => date('Y-m-d H:i:s'),
        ];
        $payloadJson = json_encode($payload);
        $signature   = hash_hmac('sha256', $payloadJson, getenv('LICENSE_HMAC_SECRET') ?: 'BonrestoLicenseSecret2024');

        $this->_json(['payload' => $payload, 'signature' => $signature]);
    }

    /**
     * GET /saas/licenses/updates-info
     * Returns published updates for this tenant with their delivery status.
     * Used by the client's autoupdate page to show changelog & status.
     * Authenticated with X-Api-Key header.
     */
    public function updates_info() {
        $client_key = strtoupper(trim($_SERVER['HTTP_X_API_KEY'] ?? ''));
        if (!$client_key) $this->_abort(401, 'X-Api-Key requis.');

        $key_row = $this->db
            ->where('client_key', $client_key)
            ->where('is_activated', 1)
            ->get('saas_license_keys')->row();

        if (!$key_row) $this->_abort(401, 'Clé invalide.');

        $tenant_id = (int)$key_row->tenant_id;

        $rows = $this->db
            ->select('u.update_id, u.title, u.version, u.module, u.type, u.changelog, u.published_at, d.status as delivery_status, d.applied_at, d.error_msg')
            ->from('saas_updates u')
            ->join('saas_update_deliveries d', 'd.update_id = u.update_id AND d.tenant_id = ' . $tenant_id, 'left')
            ->where('u.status', 'published')
            ->order_by('u.published_at', 'DESC')
            ->limit(30)
            ->get()->result_array();

        foreach ($rows as &$r) {
            $r['update_id']  = (int)$r['update_id'];
            $r['delivery_status'] = $r['delivery_status'] ?? 'pending';
            unset($r['error_msg']); // don't expose internal errors to client
        }

        $this->_json($rows);
    }

    /**
     * GET /saas/licenses/check
     * Lightweight endpoint: returns {"refresh_needed": bool}.
     * The local server calls this every 5 min to detect plan changes.
     * Authenticated with X-Api-Key header.
     * Accepts X-Cached-At header (datetime) to compare against invalidation timestamp.
     */
    public function check() {
        $client_key = strtoupper(trim($_SERVER['HTTP_X_API_KEY'] ?? ''));
        $cached_at  = $_SERVER['HTTP_X_CACHED_AT'] ?? '';

        if (!$client_key) $this->_abort(401, 'X-Api-Key requis.');

        $key_row = $this->db
            ->where('client_key', $client_key)
            ->where('is_activated', 1)
            ->get('saas_license_keys')->row();

        if (!$key_row) $this->_abort(401, 'Clé invalide.');

        $tenant = $this->db
            ->select('license_invalidated_at')
            ->where('tenant_id', (int)$key_row->tenant_id)
            ->get('saas_tenants')->row();

        $refresh_needed = false;
        if ($tenant && !empty($tenant->license_invalidated_at) && !empty($cached_at)) {
            $refresh_needed = strtotime($tenant->license_invalidated_at) > strtotime($cached_at);
        }

        $this->_json(['refresh_needed' => $refresh_needed]);
    }

    /**
     * GET /saas/licenses/refresh
     * Called every 24h by the local server for background sync.
     * Authenticated with the client_key in X-Api-Key header.
     */
    public function refresh() {
        $client_key = $_SERVER['HTTP_X_API_KEY'] ?? '';
        if (!$client_key) $this->_abort(401, 'X-Api-Key requis.');

        $key_row = $this->db
            ->where('client_key', strtoupper($client_key))
            ->where('is_activated', 1)
            ->get('saas_license_keys')->row();

        if (!$key_row) $this->_abort(401, 'Clé invalide ou non activée.');

        $tenant = $this->Saas_model->get_tenant((int)$key_row->tenant_id);
        if (!$tenant) $this->_abort(404, 'Tenant introuvable.');

        $sub     = $tenant['subscription'] ?? null;
        $tid     = (int)$tenant['client_id'];

        // Fetch pending updates for this tenant
        $raw_updates = $this->Saas_model->get_pending_updates_for_tenant($tid);
        $pending = array_map(function($u) {
            $u['payload'] = $u['payload'] ? json_decode($u['payload'], true) : null;
            return $u;
        }, $raw_updates);

        $payload = [
            'client_id'       => $tid,
            'plan'            => $sub['plan_name'] ?? 'none',
            'features'        => $sub['features'] ?? [],
            'max_tables'      => $sub['max_tables'] ?? 0,
            'max_users'       => $sub['max_users'] ?? 0,
            'status'          => $sub['status'] ?? 'none',
            'valid_until'     => ($sub['end_date'] ?? date('Y-m-d')) . ' 23:59:59',
            'grace_until'     => ($sub['grace_end_date'] ?? date('Y-m-d')) . ' 23:59:59',
            'issued_at'       => date('Y-m-d H:i:s'),
            'pending_updates' => $pending,
        ];
        $payloadJson = json_encode($payload);
        $signature   = hash_hmac('sha256', $payloadJson, getenv('LICENSE_HMAC_SECRET') ?: 'BonrestoLicenseSecret2024');

        $this->_json(['payload' => $payload, 'signature' => $signature]);
    }
}
