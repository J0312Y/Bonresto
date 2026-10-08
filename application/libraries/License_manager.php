<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * License_manager
 *
 * Manages the local license lifecycle:
 *   - Stores the signed payload returned by the SaaS server
 *   - Verifies the HMAC signature locally (works offline)
 *   - Checks subscription validity (active / grace / expired)
 *   - Reads features/modules allowed for this installation
 *   - Refreshes from SaaS every 24h and applies pending updates
 */
class License_manager {

    const FILE             = APPPATH . 'config/license.json';
    // Audit F-05 : la cle de signature etait une constante presente dans le
    // code livre a chaque client. Elle vit desormais dans LICENSE_HMAC_SECRET,
    // et doit porter la MEME valeur cote serveur SaaS (qui signe) et cote
    // installation cliente (qui verifie).
    const REFRESH_INTERVAL = 86400; // 24h
    const CHECK_INTERVAL   = 300;   // 5 min — lightweight plan-change check

    /** Root path of the Bonresto application (for code updates) */
    const APP_ROOT = FCPATH; // CodeIgniter's FCPATH = document root of index.php

    /** Allowed base paths for code updates (security: never allow outside these) */
    // Audit F-05 : 'application/libraries/' et 'application/config/' ont ete
    // retires. CodeIgniter charge et execute leur contenu — une mise a jour
    // forgee y deposait du PHP, donc du code arbitraire. Les modules et les
    // assets suffisent aux mises a jour legitimes.
    const ALLOWED_UPDATE_PATHS = [
        'application/modules/',
        'assets/',
    ];

    private string $saas_url;

    /** Niveau de la derniere signature examinee : forte | heritee | invalide. */
    private string $dernier_niveau = 'invalide';

    public function __construct() {
        $url = rtrim(env_required('SAAS_URL'), '/');

        // Audit F-05 : ce canal peut ecrire des fichiers sur le disque. En
        // clair, quiconque se trouve sur le chemin reseau peut donc livrer
        // ce contenu. L'URL par defaut etait en http://.
        $host = parse_url($url, PHP_URL_HOST) ?: '';
        $loopback = in_array($host, ['localhost', '127.0.0.1', '::1'], true);

        if (!$loopback && stripos($url, 'https://') !== 0) {
            throw new RuntimeException(
                'SAAS_URL doit utiliser HTTPS en production : le canal de licence ecrit des fichiers.'
            );
        }

        $this->saas_url = $url;
    }

    // ── Public API ────────────────────────────────────────────────────────────

    public function activate(string $client_key, string $server_url = ''): ?array {
        $client_key = strtoupper(trim($client_key));
        $server_url = $server_url ?: base_url();

        // Try direct DB first (avoids HTTP self-call issues on same-server setups)
        $payload = $this->_activate_from_db($client_key, $server_url);
        if ($payload) return $payload;

        // Fallback: HTTP call to SaaS API
        $response = $this->_post('/licenses/activate', [
            'client_key' => $client_key,
            'server_url' => $server_url,
        ]);

        if (!$response || empty($response['payload']) || empty($response['signature'])) {
            return null;
        }
        if (!$this->_verify_signature($response['payload'], $response['signature'])) {
            return null;
        }
        $this->_save($response['payload'], $response['signature'], $client_key);
        return $response['payload'];
    }

    public function load(): ?array {
        if (!file_exists(self::FILE)) return null;

        $data = json_decode(file_get_contents(self::FILE), true);
        if (!$data || empty($data['payload']) || empty($data['signature'])) return null;
        if (!$this->_verify_signature($data['payload'], $data['signature'])) return null;

        // Auto-refresh if stale
        if (!empty($data['client_key'])) {
            $cached_at = strtotime($data['cached_at'] ?? '1970-01-01');
            if ((time() - $cached_at) > self::REFRESH_INTERVAL) {
                $fresh = $this->refresh($data['client_key']);
                if ($fresh) return $fresh;
                // Offline — update timestamp only
                $data['cached_at'] = date('Y-m-d H:i:s');
                file_put_contents(self::FILE, json_encode($data, JSON_PRETTY_PRINT));
            }
        }
        return $data['payload'];
    }

    public function refresh(string $client_key = ''): ?array {
        if (!$client_key && file_exists(self::FILE)) {
            $data = json_decode(file_get_contents(self::FILE), true);
            $client_key = $data['client_key'] ?? '';
        }
        if (!$client_key) return null;

        // Try direct DB first (same server — avoids HTTP self-call issues)
        $payload = $this->_refresh_from_db($client_key);
        if ($payload) return $payload;

        // Fallback: HTTP call to SaaS API
        $response = $this->_get('/licenses/refresh', $client_key);
        if (!$response || empty($response['payload']) || empty($response['signature'])) return null;
        if (!$this->_verify_signature($response['payload'], $response['signature'])) return null;

        $payload = $response['payload'];

        if (!empty($payload['pending_updates'])) {
            $this->apply_updates($payload['pending_updates'], $client_key);
            unset($payload['pending_updates']);
        }

        $this->_save($payload, $response['signature'], $client_key);
        return $payload;
    }

    /**
     * Check directly in the saas DB whether license_invalidated_at > cached_at.
     * Returns true if a refresh is needed. Falls back to false on any error.
     */
    private function _check_invalidated_from_db(string $client_key, string $cached_at): bool {
        try {
            $CI      =& get_instance();
            $saas_db = $CI->load->database('saas', TRUE);

            $key_row = $saas_db
                ->where('client_key', strtoupper($client_key))
                ->where('is_activated', 1)
                ->get('saas_license_keys')->row();

            if (!$key_row) return false;

            $tenant = $saas_db
                ->select('license_invalidated_at')
                ->where('tenant_id', (int)$key_row->tenant_id)
                ->get('saas_tenants')->row();

            if (!$tenant || empty($tenant->license_invalidated_at)) return false;

            return strtotime($tenant->license_invalidated_at) > strtotime($cached_at);

        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Build and save a fresh payload directly from the saas DB.
     * Avoids HTTP self-calls which fail silently on same-server setups.
     */
    private function _refresh_from_db(string $client_key): ?array {
        try {
            $CI      =& get_instance();
            $saas_db = $CI->load->database('saas', TRUE);

            $key_row = $saas_db
                ->where('client_key', strtoupper($client_key))
                ->where('is_activated', 1)
                ->get('saas_license_keys')->row();

            if (!$key_row) return null;

            $tid = (int)$key_row->tenant_id;

            // Get subscription + plan (individual first)
            $sub = $saas_db
                ->select('s.plan_id, s.status, s.end_date, s.grace_end_date, p.plan_name, p.max_tables, p.max_users')
                ->from('saas_subscriptions s')
                ->join('saas_plans p', 'p.plan_id = s.plan_id')
                ->where('s.tenant_id', $tid)
                ->where_in('s.status', ['active', 'grace'])
                ->order_by('s.sub_id', 'DESC')
                ->limit(1)
                ->get()->row();

            // Fallback: group subscription if no individual sub
            if (!$sub) {
                $sub = $this->_get_group_sub($saas_db, $tid);
            }

            // Get pending updates
            $raw_updates = $saas_db
                ->select('u.update_id, u.title, u.version, u.module, u.type, u.changelog, u.payload')
                ->from('saas_update_deliveries d')
                ->join('saas_updates u', 'u.update_id = d.update_id')
                ->where('d.tenant_id', $tid)
                ->where('d.status', 'pending')
                ->where('u.status', 'published')
                ->get()->result_array();

            // Build features from saas_plan_features table (not the legacy JSON column)
            $features = $this->_build_features($saas_db, $sub ? (int)$sub->plan_id : 0, $tid);

            $payload = [
                'client_id'   => $tid,
                'plan'        => $sub->plan_name ?? 'none',
                'features'    => $features,
                'max_tables'  => (int)($sub->max_tables ?? 0),
                'max_users'   => (int)($sub->max_users  ?? 0),
                'status'      => $sub->status ?? 'none',
                'valid_until' => ($sub->end_date ?? date('Y-m-d')) . ' 23:59:59',
                'grace_until' => ($sub->grace_end_date ?? date('Y-m-d')) . ' 23:59:59',
                'issued_at'   => date('Y-m-d H:i:s'),
                'pending_updates' => $raw_updates,
            ];

            $signature = $this->_signer($payload);

            if (!empty($payload['pending_updates'])) {
                $this->apply_updates($payload['pending_updates'], $client_key);
                unset($payload['pending_updates']);
            }

            $this->_save($payload, $signature, $client_key);
            $this->_log("License refreshed via DB for {$client_key} — status: {$payload['status']}");
            return $payload;

        } catch (Throwable $e) {
            $this->_log("DB refresh failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Activate a license key directly from the saas DB.
     * Avoids HTTP self-calls which fail on same-server setups (session lock, port mismatch).
     */
    private function _activate_from_db(string $client_key, string $server_url): ?array {
        try {
            $CI      =& get_instance();
            $saas_db = $CI->load->database('saas', TRUE);

            $key_row = $saas_db
                ->where('client_key', $client_key)
                ->get('saas_license_keys')->row();

            if (!$key_row) return null;

            // Mark key as activated
            $saas_db->where('key_id', (int)$key_row->key_id)->update('saas_license_keys', [
                'is_activated' => 1,
                'activated_at' => date('Y-m-d H:i:s'),
                'server_url'   => $server_url,
            ]);

            $tid = (int)$key_row->tenant_id;

            // Get subscription + plan (individual first)
            $sub = $saas_db
                ->select('s.plan_id, s.status, s.end_date, s.grace_end_date, p.plan_name, p.max_tables, p.max_users')
                ->from('saas_subscriptions s')
                ->join('saas_plans p', 'p.plan_id = s.plan_id')
                ->where('s.tenant_id', $tid)
                ->where_in('s.status', ['active', 'grace'])
                ->order_by('s.sub_id', 'DESC')
                ->limit(1)
                ->get()->row();

            // Fallback: group subscription if no individual sub
            if (!$sub) {
                $sub = $this->_get_group_sub($saas_db, $tid);
            }

            // Build features from saas_plan_features table (not the legacy JSON column)
            $features = $this->_build_features($saas_db, $sub ? (int)$sub->plan_id : 0, $tid);

            $payload = [
                'client_id'   => $tid,
                'plan'        => $sub->plan_name ?? 'none',
                'features'    => $features,
                'max_tables'  => (int)($sub->max_tables ?? 0),
                'max_users'   => (int)($sub->max_users  ?? 0),
                'status'      => $sub->status ?? 'none',
                'valid_until' => ($sub->end_date ?? date('Y-m-d')) . ' 23:59:59',
                'grace_until' => ($sub->grace_end_date ?? date('Y-m-d')) . ' 23:59:59',
                'issued_at'   => date('Y-m-d H:i:s'),
            ];

            $signature = $this->_signer($payload);

            $this->_save($payload, $signature, $client_key);
            $this->_log("License activated via DB for {$client_key} — plan: {$payload['plan']}");
            return $payload;

        } catch (Throwable $e) {
            $this->_log("DB activation failed: " . $e->getMessage());
            return null;
        }
    }

    public function status(?array $payload = null): string {
        if (!$payload) $payload = $this->load();
        if (!$payload) return 'none';

        $now         = time();
        $valid_until = strtotime($payload['valid_until'] ?? '1970-01-01');
        $grace_until = strtotime($payload['grace_until'] ?? '1970-01-01');

        if (($payload['status'] ?? '') === 'suspended') return 'expired';
        if ($now <= $valid_until) return 'active';
        if ($now <= $grace_until) return 'grace';
        return 'expired';
    }

    public function is_allowed(): bool {
        return in_array($this->status(), ['active', 'grace']);
    }

    /**
     * Check if a specific module is enabled in the current plan.
     * Core modules (ordermanage, itemmanage, dashboard) are always allowed.
     */
    public function has_module(string $module): bool {
        // Infrastructure modules — always available (not sellable separately)
        static $core = ['ordermanage', 'itemmanage', 'dashboard', 'template', 'install', 'saas'];

        if (in_array($module, $core)) return true;

        // Aliases: HMVC module name → feature key in license.json
        static $aliases = [
            'report'        => 'reports',
        ];

        $payload = $this->load();
        if (!$payload) return false;
        if (!$this->is_allowed()) return false;

        $features = $payload['features'] ?? [];
        $key = $aliases[$module] ?? $module;
        return !empty($features[$key]);
    }

    /**
     * Fetch published updates for this installation from the SaaS server.
     * Returns array of updates with delivery_status (pending/applied/failed).
     */
    public function get_updates_info(): array {
        if (!file_exists(self::FILE)) return [];
        $data = json_decode(file_get_contents(self::FILE), true);
        if (empty($data['client_key'])) return [];

        $ctx = stream_context_create(['http' => [
            'method'        => 'GET',
            'header'        => "X-Api-Key: {$data['client_key']}\r\n",
            'timeout'       => 8,
            'ignore_errors' => true,
        ]]);
        $raw = @file_get_contents($this->saas_url . '/licenses/updates-info', false, $ctx);
        if (!$raw) return [];
        return json_decode($raw, true) ?: [];
    }

    public function raw(): ?array {
        if (!file_exists(self::FILE)) return null;
        return json_decode(file_get_contents(self::FILE), true) ?: null;
    }

    /**
     * Lightweight plan-change detector.
     * Called on every page load (rate-limited to once every CHECK_INTERVAL seconds).
     * If the SaaS server signals a plan change, triggers a full refresh immediately.
     * This makes plan upgrades/downgrades take effect within CHECK_INTERVAL seconds
     * without any action required from the client.
     */
    public function check_refresh(): void {
        if (!file_exists(self::FILE)) return;

        $data = json_decode(file_get_contents(self::FILE), true);
        if (!$data || empty($data['client_key'])) return;

        // Rate-limit: only call the SaaS server once every CHECK_INTERVAL seconds
        $last_check = strtotime($data['last_check'] ?? '1970-01-01');
        if ((time() - $last_check) < self::CHECK_INTERVAL) return;

        // Stamp last_check immediately to avoid concurrent requests hammering the server
        $data['last_check'] = date('Y-m-d H:i:s');
        file_put_contents(self::FILE, json_encode($data, JSON_PRETTY_PRINT));

        // Try direct DB check first (avoids HTTP self-call failures on same-server setups)
        $cached_at = $data['cached_at'] ?? '1970-01-01 00:00:00';
        if ($this->_check_invalidated_from_db($data['client_key'], $cached_at)) {
            $this->_log("Plan change detected via DB — refreshing license for {$data['client_key']}");
            $this->refresh($data['client_key']);
            return;
        }

        // Fallback: HTTP call to SaaS (for remote/multi-server setups)
        $ctx = stream_context_create(['http' => [
            'method'        => 'GET',
            'header'        => "X-Api-Key: {$data['client_key']}\r\nX-Cached-At: {$cached_at}\r\n",
            'timeout'       => 5,
            'ignore_errors' => true,
        ]]);
        $raw = @file_get_contents($this->saas_url . '/licenses/check', false, $ctx);
        if (!$raw) return;

        $result = json_decode($raw, true);
        if (!empty($result['refresh_needed'])) {
            $this->_log("Plan change detected via HTTP — refreshing license for {$data['client_key']}");
            $this->refresh($data['client_key']);
        }
    }

    // ── Update application ────────────────────────────────────────────────────

    /**
     * Apply a list of pending updates received from the SaaS server.
     * Calls back /saas/updates/applied to report results.
     */
    public function apply_updates(array $updates, string $client_key): void {
        $applied = [];
        $failed  = [];

        foreach ($updates as $update) {
            $id   = (int)($update['update_id'] ?? 0);
            $type = $update['type'] ?? 'config';

            try {
                if ($type === 'config') {
                    $this->_apply_config_update($update);
                } elseif ($type === 'code') {
                    $this->_apply_code_update($update);
                }
                $applied[] = $id;
                $this->_log("Update #{$id} ({$type}) applied: {$update['module']} v{$update['version']}");
            } catch (Exception $e) {
                $failed[] = ['id' => $id, 'error' => $e->getMessage()];
                $this->_log("Update #{$id} FAILED: " . $e->getMessage());
            }
        }

        // Report back to SaaS
        if (!empty($applied) || !empty($failed)) {
            $this->_post('/updates/applied', [
                'client_key' => $client_key,
                'applied'    => $applied,
                'failed'     => $failed,
            ]);
        }
    }

    // ── Private: update handlers ──────────────────────────────────────────────

    /**
     * Config update: the payload is a key-value object.
     * Writes/merges into application/config/saas_config.php
     * or merges directly into license features if module-based.
     */
    private function _apply_config_update(array $update): void {
        $config = $update['payload'] ?? [];
        if (empty($config) || !is_array($config)) return;

        $config_file = APPPATH . 'config/saas_config.php';

        $existing = [];
        if (file_exists($config_file)) {
            include $config_file; // expects $saas_config = [...]
        }

        $merged = array_merge($existing['saas_config'] ?? [], $config);

        $content = "<?php\ndefined('BASEPATH') OR exit('No direct script access allowed');\n\n";
        $content .= "// Auto-generated by License_manager — do not edit manually\n";
        $content .= "// Last update: " . date('Y-m-d H:i:s') . "\n\n";
        $content .= "\$saas_config = " . var_export($merged, true) . ";\n";

        if (file_put_contents($config_file, $content) === false) {
            throw new Exception("Cannot write to {$config_file}");
        }
    }

    /**
     * Code update: the payload is an array of {path, content_b64} objects.
     * Writes PHP files to disk under strictly allowed paths only.
     */
    private function _apply_code_update(array $update): void {
        // Audit F-05 : ce chemin ecrit des fichiers que CodeIgniter executera.
        // Une signature HMAC ne suffit plus : la cle etant partagee, elle est
        // detenue par le client lui-meme, donc forgeable. Seule une signature
        // Ed25519, verifiee avec la cle publique, est acceptee ici.
        if ($this->dernier_niveau !== 'forte') {
            throw new Exception(
                'Mise a jour de code refusee : signature non asymetrique ('
                . $this->dernier_niveau . ').'
            );
        }

        $files = $update['payload'] ?? [];
        if (empty($files) || !is_array($files)) {
            throw new Exception('No files in code update payload');
        }

        foreach ($files as $file) {
            $rel_path = $file['path'] ?? '';
            $content  = isset($file['content_b64']) ? base64_decode($file['content_b64']) : null;

            if (empty($rel_path) || $content === false || $content === null) {
                throw new Exception("Invalid file entry in update");
            }

            // Security: only allow writes inside ALLOWED_UPDATE_PATHS
            $allowed = false;
            foreach (self::ALLOWED_UPDATE_PATHS as $allowed_prefix) {
                if (strpos($rel_path, $allowed_prefix) === 0) {
                    $allowed = true;
                    break;
                }
            }
            if (!$allowed) {
                throw new Exception("Forbidden path: {$rel_path}");
            }

            // Prevent directory traversal
            if (strpos($rel_path, '..') !== false) {
                throw new Exception("Path traversal detected: {$rel_path}");
            }

            $abs_path = self::APP_ROOT . $rel_path;
            $dir      = dirname($abs_path);

            if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
                throw new Exception("Cannot create directory: {$dir}");
            }

            // Backup existing file
            if (file_exists($abs_path)) {
                $backup = $abs_path . '.bak.' . date('YmdHis');
                copy($abs_path, $backup);
            }

            if (file_put_contents($abs_path, $content) === false) {
                throw new Exception("Cannot write file: {$abs_path}");
            }
        }
    }

    private function _log(string $msg): void {
        $log_file = APPPATH . 'logs/saas_updates.log';
        @file_put_contents($log_file, '[' . date('Y-m-d H:i:s') . '] ' . $msg . PHP_EOL, FILE_APPEND);
    }

    // ── Private: HTTP + signature ─────────────────────────────────────────────

    /**
     * Build features map from saas_plan_features + saas_tenant_features (overrides).
     * Same logic as TenantHook::detect() — single source of truth.
     */
    /**
     * Check if a tenant belongs to a group with billing_model='group'
     * and return the group's active subscription as if it were the tenant's own.
     */
    private function _get_group_sub($saas_db, int $tenant_id) {
        $tenant = $saas_db
            ->select('t.group_id, g.billing_model')
            ->from('saas_tenants t')
            ->join('saas_groups g', 'g.group_id = t.group_id', 'inner')
            ->where('t.tenant_id', $tenant_id)
            ->where('g.billing_model', 'group')
            ->get()->row();

        if (!$tenant || !$tenant->group_id) return null;

        return $saas_db
            ->select('gs.plan_id, gs.status, gs.end_date, gs.grace_end_date, p.plan_name, p.max_tables, p.max_users')
            ->from('saas_group_subscriptions gs')
            ->join('saas_plans p', 'p.plan_id = gs.plan_id')
            ->where('gs.group_id', (int)$tenant->group_id)
            ->where_in('gs.status', ['active', 'grace'])
            ->order_by('gs.gsub_id', 'DESC')
            ->limit(1)
            ->get()->row();
    }

    private function _build_features($saas_db, int $plan_id, int $tenant_id): array {
        $features = [];

        // 1. Plan-level features
        if ($plan_id > 0) {
            $rows = $saas_db
                ->where('plan_id', $plan_id)
                ->get('saas_plan_features')->result_array();
            foreach ($rows as $row) {
                $features[$row['feature']] = (bool)$row['enabled'];
            }
        }

        // 2. Per-tenant overrides (priority over plan)
        $overrides = $saas_db
            ->where('tenant_id', $tenant_id)
            ->get('saas_tenant_features')->result_array();
        foreach ($overrides as $row) {
            $features[$row['feature']] = (bool)$row['enabled'];
        }

        return $features;
    }

    /**
     * Niveau de confiance d'une signature.
     *
     * Audit F-05. La signature etait un HMAC-SHA256, donc symetrique : la cle
     * qui verifie est celle qui signe. Chaque installation cliente detenait
     * donc de quoi fabriquer une licence — et, ce canal ecrivant des fichiers
     * sur le disque, de quoi executer du code.
     *
     * Ed25519 separe les deux : le serveur SaaS garde la cle privee, le client
     * ne recoit que la cle publique. Il peut verifier, il ne peut plus forger.
     *
     * Les licences deja emises restent signees en HMAC. Elles continuent d'etre
     * acceptees pour lire un abonnement — sinon toutes les installations en
     * place tomberaient d'un coup — mais elles ne suffisent PLUS a declencher
     * une mise a jour de code : voir apply_updates().
     *
     * @return string 'forte' (Ed25519), 'heritee' (HMAC), ou 'invalide'.
     */
    private function _niveau_signature(array $payload, string $signature): string {
        $corps = json_encode($payload);

        $publique = getenv('LICENSE_PUBLIC_KEY');
        if (!empty($publique) && function_exists('sodium_crypto_sign_verify_detached')) {
            $brut = base64_decode((string) $publique, true);
            $sig  = base64_decode($signature, true);

            if ($brut !== false && $sig !== false
                && strlen($brut) === SODIUM_CRYPTO_SIGN_PUBLICKEYBYTES
                && strlen($sig)  === SODIUM_CRYPTO_SIGN_BYTES) {
                try {
                    if (sodium_crypto_sign_verify_detached($sig, $corps, $brut)) {
                        return 'forte';
                    }
                } catch (Throwable $e) {
                    // signature malformee : on retombe sur l'examen du format herite
                }
            }
        }

        $herite = getenv('LICENSE_HMAC_SECRET');
        if (!empty($herite) && hash_equals(hash_hmac('sha256', $corps, $herite), $signature)) {
            log_message('info', 'License_manager : licence encore signee en HMAC. '
                . 'Elle sera reemise en Ed25519 au prochain rafraichissement.');
            return 'heritee';
        }

        return 'invalide';
    }

    private function _verify_signature(array $payload, string $signature): bool {
        $this->dernier_niveau = $this->_niveau_signature($payload, $signature);
        return $this->dernier_niveau !== 'invalide';
    }

    /**
     * Signe un payload. Ed25519 des que la cle privee est configuree ; sinon
     * HMAC, avec une trace, pour ne pas interrompre un serveur pas encore migre.
     */
    private function _signer(array $payload): string {
        $corps = json_encode($payload);
        $privee = getenv('LICENSE_SIGNING_KEY');

        if (!empty($privee) && function_exists('sodium_crypto_sign_detached')) {
            $brut = base64_decode((string) $privee, true);
            if ($brut !== false && strlen($brut) === SODIUM_CRYPTO_SIGN_SECRETKEYBYTES) {
                $this->dernier_niveau = 'forte';
                return base64_encode(sodium_crypto_sign_detached($corps, $brut));
            }
        }

        log_message('error', 'License_manager : LICENSE_SIGNING_KEY absente ou invalide, '
            . 'repli sur HMAC. Les mises a jour de code seront refusees.');
        $this->dernier_niveau = 'heritee';
        return hash_hmac('sha256', $corps, env_required('LICENSE_HMAC_SECRET'));
    }

    private function _save(array $payload, string $signature, string $client_key): void {
        file_put_contents(self::FILE, json_encode([
            'payload'    => $payload,
            'signature'  => $signature,
            'client_key' => $client_key,
            'cached_at'  => date('Y-m-d H:i:s'),
        ], JSON_PRETTY_PRINT));
    }

    private function _post(string $path, array $body): ?array {
        $ctx = stream_context_create(['http' => [
            'method'        => 'POST',
            'header'        => "Content-Type: application/json\r\n",
            'content'       => json_encode($body),
            'timeout'       => 15,
            'ignore_errors' => true,
        ]]);
        $raw = @file_get_contents($this->saas_url . $path, false, $ctx);
        return $raw !== false ? (json_decode($raw, true) ?: null) : null;
    }

    private function _get(string $path, string $client_key): ?array {
        $ctx = stream_context_create(['http' => [
            'method'        => 'GET',
            'header'        => "X-Api-Key: {$client_key}\r\n",
            'timeout'       => 15,
            'ignore_errors' => true,
        ]]);
        $raw = @file_get_contents($this->saas_url . $path, false, $ctx);
        return $raw !== false ? (json_decode($raw, true) ?: null) : null;
    }
}
