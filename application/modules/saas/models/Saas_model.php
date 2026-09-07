<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saas_model extends CI_Model {

    /** @var \CI_DB_driver Connexion dédiée SaaS */
    protected $db;

    public function __construct() {
        parent::__construct();
        // Toujours utiliser la DB SaaS dédiée, peu importe le tenant courant
        $this->db = $this->load->database('saas', TRUE);
    }

    // ── Admin Auth ─────────────────────────────────────────────────────────

    public function get_admin_by_email(string $email) {
        return $this->db->where('email', $email)->get('saas_admins')->row();
    }

    public function get_admin_by_id(int $id) {
        return $this->db->where('admin_id', $id)->get('saas_admins')->row();
    }

    // ── Dashboard Stats ────────────────────────────────────────────────────

    public function dashboard_stats(): array {
        $total_clients = $this->db->count_all('saas_tenants');

        $active_subs = $this->db
            ->where('status', 'active')
            ->count_all_results('saas_subscriptions');

        $expiring = $this->db
            ->where('status', 'active')
            ->where('end_date <=', date('Y-m-d', strtotime('+7 days')))
            ->where('end_date >=', date('Y-m-d'))
            ->count_all_results('saas_subscriptions');

        $mrr = (float)($this->db
            ->select('SUM(p.price) as mrr')
            ->from('saas_subscriptions s')
            ->join('saas_plans p', 'p.plan_id = s.plan_id')
            ->where('s.status', 'active')
            ->get()->row()->mrr ?? 0);

        $month_start = date('Y-m-01');
        $revenue_month = (float)($this->db
            ->select('SUM(amount) as rev')
            ->from('saas_payments')
            ->where('status', 'paid')
            ->where('created_at >=', $month_start)
            ->get()->row()->rev ?? 0);

        $new_this_month = $this->db
            ->where('created_at >=', $month_start)
            ->count_all_results('saas_tenants');

        // Revenue last 12 months
        $revenue_by_month = [];
        for ($i = 11; $i >= 0; $i--) {
            $start = date('Y-m-01', strtotime("-$i months"));
            $end   = date('Y-m-t', strtotime("-$i months"));
            $label = date('M Y', strtotime("-$i months"));
            $rev   = (float)($this->db
                ->select('SUM(amount) as rev')
                ->from('saas_payments')
                ->where('status', 'paid')
                ->where('created_at >=', $start)
                ->where('created_at <=', $end . ' 23:59:59')
                ->get()->row()->rev ?? 0);
            $revenue_by_month[] = ['month' => $label, 'revenue' => $rev];
        }

        // Subscriptions by plan
        $subs_by_plan = $this->db
            ->select('p.plan_name as plan, COUNT(s.sub_id) as count')
            ->from('saas_subscriptions s')
            ->join('saas_plans p', 'p.plan_id = s.plan_id')
            ->where('s.status', 'active')
            ->group_by('s.plan_id')
            ->get()->result_array();

        // MRR last month (for trend comparison)
        $last_month_start = date('Y-m-01', strtotime('-1 month'));
        $last_month_end   = date('Y-m-t',  strtotime('-1 month'));
        $mrr_last_month = (float)($this->db
            ->select('SUM(p.price) as mrr')
            ->from('saas_subscriptions s')
            ->join('saas_plans p', 'p.plan_id = s.plan_id')
            ->where_in('s.status', ['active', 'expired', 'suspended'])
            ->where('s.start_date <=', $last_month_end)
            ->where('s.end_date >=', $last_month_start)
            ->get()->row()->mrr ?? 0);

        // Churn rate: subscriptions expired/suspended in last 30 days / active last month
        $thirty_days_ago = date('Y-m-d', strtotime('-30 days'));
        $churned = $this->db
            ->where_in('status', ['expired', 'suspended'])
            ->where('end_date >=', $thirty_days_ago)
            ->count_all_results('saas_subscriptions');
        $active_last_month = max(1, $active_subs + $churned);
        $churn_rate = round(($churned / $active_last_month) * 100, 1);

        // Invoice recovery rate: paid / (total non-cancelled)
        $total_inv = (int)($this->db
            ->where('status !=', 'cancelled')
            ->count_all_results('saas_invoices'));
        $paid_inv = (int)($this->db
            ->where('status', 'paid')
            ->count_all_results('saas_invoices'));
        $invoice_recovery = $total_inv > 0 ? round(($paid_inv / $total_inv) * 100, 1) : 0;

        return [
            'total_clients'          => (int)$total_clients,
            'active_subscriptions'   => (int)$active_subs,
            'mrr'                    => $mrr,
            'mrr_last_month'         => $mrr_last_month,
            'mrr_trend'              => $mrr_last_month > 0 ? round((($mrr - $mrr_last_month) / $mrr_last_month) * 100, 1) : 0,
            'churn_rate'             => $churn_rate,
            'invoice_recovery_rate'  => $invoice_recovery,
            'expiring_soon'          => (int)$expiring,
            'revenue_this_month'     => $revenue_month,
            'new_clients_this_month' => (int)$new_this_month,
            'revenue_by_month'       => $revenue_by_month,
            'subscriptions_by_plan'  => $subs_by_plan,
        ];
    }

    // ── Tenants (Clients) ─────────────────────────────────────────────────

    public function get_all_tenants(): array {
        $tenants = $this->db
            ->select('t.*, g.group_name, s.sub_id, s.status as sub_status, s.end_date, s.grace_end_date, p.plan_name, p.plan_id, p.price, (SELECT COUNT(*) FROM saas_terminals tm WHERE tm.tenant_id = t.tenant_id) as terminal_count')
            ->from('saas_tenants t')
            ->join('saas_groups g', 'g.group_id = t.group_id', 'left')
            ->join('saas_subscriptions s', 's.tenant_id = t.tenant_id AND s.sub_id = (SELECT MAX(sub_id) FROM saas_subscriptions WHERE tenant_id = t.tenant_id)', 'left')
            ->join('saas_plans p', 'p.plan_id = s.plan_id', 'left')
            ->order_by('t.created_at', 'DESC')
            ->get()->result_array();

        // Nettoyage AVANT formatage : cette liste renvoyait le mot de passe en
        // clair de tous les restaurants d'un seul appel — la fuite la plus
        // large de toute la console.
        return array_map(
            fn($t) => $this->_format_tenant($this->nettoyer_tenant($t)),
            $tenants
        );
    }

    /**
     * Champs de saas_tenants qui ne doivent JAMAIS sortir de la base.
     *
     * `select('t.*')` est commode et dangereux : toute colonne ajoutee plus
     * tard part automatiquement dans la reponse de l'API. C'est ainsi que le
     * mot de passe en clair des restaurateurs se retrouvait dans le
     * navigateur de n'importe quel administrateur SaaS.
     *
     * On garde le `t.*` — le reecrire colonne par colonne casserait a chaque
     * evolution du schema — mais on retire explicitement ce qui est sensible
     * avant de rendre la ligne.
     */
    private const CHAMPS_SENSIBLES_TENANT = ['admin_pass_raw', 'db_pass'];

    private function nettoyer_tenant(?array $row): ?array {
        if (!$row) return $row;
        foreach (self::CHAMPS_SENSIBLES_TENANT as $champ) {
            unset($row[$champ]);
        }
        return $row;
    }

    public function get_tenant(int $id): ?array {
        $row = $this->db
            ->select('t.*, g.group_name, s.sub_id, s.status as sub_status, s.start_date, s.end_date, s.grace_end_date, p.plan_name, p.plan_id, p.price, p.features, p.max_tables, p.max_users, (SELECT COUNT(*) FROM saas_terminals tm WHERE tm.tenant_id = t.tenant_id) as terminal_count')
            ->from('saas_tenants t')
            ->join('saas_groups g', 'g.group_id = t.group_id', 'left')
            ->join('saas_subscriptions s', 's.tenant_id = t.tenant_id AND s.sub_id = (SELECT MAX(sub_id) FROM saas_subscriptions WHERE tenant_id = t.tenant_id)', 'left')
            ->join('saas_plans p', 'p.plan_id = s.plan_id', 'left')
            ->where('t.tenant_id', $id)
            ->get()->row_array();

        return $row ? $this->_format_tenant($this->nettoyer_tenant($row)) : null;
    }

    public function email_exists(string $email, int $exclude_id = 0): bool {
        $q = $this->db->where('email', $email);
        if ($exclude_id > 0) $q = $q->where('tenant_id !=', $exclude_id);
        return $q->count_all_results('saas_tenants') > 0;
    }

    public function create_tenant(array $data): int {
        $this->db->insert('saas_tenants', [
            'business_name' => $data['business_name'],
            'email'         => $data['email'],
            'phone'         => $data['phone'] ?? '',
            'country'       => $data['country'] ?? '',
            'city'          => $data['city'] ?? '',
            'address'       => $data['address'] ?? '',
            'website'       => $data['website'] ?? '',
            'notes'         => $data['notes'] ?? '',
            'custom_domain' => $data['custom_domain'] ?? null,
            'created_at'    => date('Y-m-d H:i:s'),
        ]);
        return $this->db->insert_id();
    }

    public function update_tenant(int $tenant_id, array $data): void {
        $allowed = ['business_name', 'email', 'phone', 'country', 'city', 'address', 'website', 'notes', 'custom_domain'];
        $update  = array_intersect_key($data, array_flip($allowed));
        if ($update) {
            $this->db->where('tenant_id', $tenant_id)->update('saas_tenants', $update);
        }
    }

    // ── Features (plan + overrides par tenant) ────────────────────────────

    /**
     * Retourne les features effectives du tenant :
     * plan de base + overrides de saas_tenant_features.
     * Format : [ 'feature' => ['enabled'=>bool, 'overridden'=>bool, 'plan_default'=>bool], ... ]
     */
    public function get_tenant_features(int $tenant_id): array {
        // 1. Plan actif du tenant
        $sub = $this->db
            ->select('plan_id')
            ->where('tenant_id', $tenant_id)
            ->where('status', 'active')
            ->get('saas_subscriptions')->row();

        $plan_features = [];
        if ($sub) {
            $rows = $this->db
                ->where('plan_id', $sub->plan_id)
                ->get('saas_plan_features')->result();
            foreach ($rows as $r) {
                $plan_features[$r->feature] = (bool)$r->enabled;
            }
        }

        // 2. Overrides tenant
        $overrides = [];
        $ovr_rows = $this->db
            ->where('tenant_id', $tenant_id)
            ->get('saas_tenant_features')->result();
        foreach ($ovr_rows as $r) {
            $overrides[$r->feature] = (bool)$r->enabled;
        }

        // 3. Merge : toutes les features connues
        $all_features = ['orders','items','purchase','report','reservation',
                         'qrapp','wastemangment','production','accounts','hrm',
                         'whatsapp','loyalty','shiftmangment','tax',
                         'facebooklogin','membership','sms'];

        $result = [];
        foreach ($all_features as $f) {
            $plan_val = $plan_features[$f] ?? false;
            $has_override = isset($overrides[$f]);
            $result[$f] = [
                'enabled'      => $has_override ? $overrides[$f] : $plan_val,
                'plan_default' => $plan_val,
                'overridden'   => $has_override,
            ];
        }
        return $result;
    }

    /**
     * Sauvegarde les overrides tenant.
     * $features = ['orders' => true, 'hrm' => false, ...]
     * null = supprimer l'override (revenir au plan)
     */
    public function save_tenant_features(int $tenant_id, array $features): void {
        foreach ($features as $feature => $value) {
            if ($value === null) {
                // Supprimer l'override → revenir au plan
                $this->db->where('tenant_id', $tenant_id)
                         ->where('feature', $feature)
                         ->delete('saas_tenant_features');
            } else {
                $this->db->replace('saas_tenant_features', [
                    'tenant_id' => $tenant_id,
                    'feature'   => $feature,
                    'enabled'   => (int)(bool)$value,
                ]);
            }
        }
        // Invalider le cache du tenant pour que le changement soit immédiat
        $this->db->where('tenant_id', $tenant_id)
                 ->update('saas_tenants', ['license_invalidated_at' => date('Y-m-d H:i:s')]);
    }

    public function update_tenant_subscription(int $tenant_id, int $plan_id, string $end_date): void {
        $grace = date('Y-m-d', strtotime($end_date . ' +7 days'));

        // Expire old active subscriptions
        $this->db->where('tenant_id', $tenant_id)
                 ->where('status', 'active')
                 ->update('saas_subscriptions', ['status' => 'expired']);

        $this->db->insert('saas_subscriptions', [
            'tenant_id'      => $tenant_id,
            'plan_id'        => $plan_id,
            'status'         => 'active',
            'start_date'     => date('Y-m-d'),
            'end_date'       => $end_date,
            'grace_end_date' => $grace,
        ]);

        // Signal the local installation to refresh its license on next request
        $this->db->where('tenant_id', $tenant_id)
                 ->update('saas_tenants', ['license_invalidated_at' => date('Y-m-d H:i:s')]);
    }

    public function suspend_tenant(int $tenant_id): void {
        $this->db->where('tenant_id', $tenant_id)
                 ->where('status', 'active')
                 ->update('saas_subscriptions', ['status' => 'suspended']);
        $this->db->where('tenant_id', $tenant_id)
                 ->update('saas_tenants', [
                     'is_active'              => 0,
                     'license_invalidated_at' => date('Y-m-d H:i:s'),
                 ]);
    }

    public function reactivate_tenant(int $tenant_id): void {
        $this->db->where('tenant_id', $tenant_id)
                 ->where('status', 'suspended')
                 ->update('saas_subscriptions', ['status' => 'active']);
        $this->db->where('tenant_id', $tenant_id)
                 ->update('saas_tenants', [
                     'is_active'              => 1,
                     'license_invalidated_at' => date('Y-m-d H:i:s'),
                 ]);
    }

    public function update_admin_password(int $admin_id, string $hashed): void {
        $this->db->where('admin_id', $admin_id)->update('saas_admins', ['password' => $hashed]);
    }

    public function set_reset_token(int $admin_id, string $token, string $expires): void {
        $this->db->where('admin_id', $admin_id)->update('saas_admins', [
            'reset_token'   => $token,
            'reset_expires' => $expires,
        ]);
    }

    public function get_admin_by_reset_token(string $token) {
        return $this->db
            ->where('reset_token', $token)
            ->where('reset_expires >=', date('Y-m-d H:i:s'))
            ->get('saas_admins')
            ->row();
    }

    public function clear_reset_token(int $admin_id): void {
        $this->db->where('admin_id', $admin_id)->update('saas_admins', [
            'reset_token'   => null,
            'reset_expires' => null,
        ]);
    }

    // ── Plans ─────────────────────────────────────────────────────────────

    public function get_all_plans(): array {
        return $this->db
            ->select('p.*, COUNT(s.sub_id) as client_count')
            ->from('saas_plans p')
            ->join('saas_subscriptions s', 's.plan_id = p.plan_id AND s.status IN (\'active\', \'grace\')', 'left')
            ->where('p.is_active', 1)
            ->group_by('p.plan_id')
            ->get()->result_array();
    }

    public function create_plan(array $data): int {
        $insert = [
            'plan_name'   => $data['plan_name'],
            'price'       => $data['price'] ?? 0,
            'max_tables'  => $data['max_tables'] ?? $data['max_terminals'] ?? 0,
            'max_users'   => $data['max_users']  ?? 0,
            'features'    => json_encode($data['features'] ?? []),
            'is_active'   => 1,
        ];
        if (isset($data['modules'])) {
            $insert['modules'] = is_array($data['modules']) ? json_encode($data['modules']) : $data['modules'];
        }
        if (isset($data['description'])) {
            $insert['description'] = $data['description'];
        }
        if (isset($data['show_on_website'])) {
            $insert['show_on_website'] = $data['show_on_website'] ? 1 : 0;
        }
        $this->db->insert('saas_plans', $insert);
        return $this->db->insert_id();
    }

    public function update_plan(int $id, array $data): void {
        $allowed = ['plan_name', 'price', 'max_tables', 'max_users', 'features', 'modules', 'description', 'show_on_website'];
        $update  = array_intersect_key($data, array_flip($allowed));
        if (isset($data['max_terminals']) && !isset($update['max_tables'])) {
            $update['max_tables'] = $data['max_terminals'];
        }
        if (isset($update['features']) && is_array($update['features'])) {
            $update['features'] = json_encode($update['features']);
        }
        if (isset($update['modules']) && is_array($update['modules'])) {
            $update['modules'] = json_encode($update['modules']);
        }
        if ($update) $this->db->where('plan_id', $id)->update('saas_plans', $update);
    }

    // ── Roles ─────────────────────────────────────────────────────────────

    public function get_all_roles(): array {
        return $this->db
            ->select('r.*, COUNT(a.admin_id) as member_count')
            ->from('saas_roles r')
            ->join('saas_admins a', 'a.role = r.role_name AND a.is_active = 1', 'left')
            ->group_by('r.role_id')
            ->order_by('r.is_system', 'DESC')
            ->order_by('r.created_at', 'ASC')
            ->get()->result();
    }

    public function get_role_by_name(string $name) {
        return $this->db->where('role_name', $name)->get('saas_roles')->row();
    }

    public function get_role_by_id(int $id) {
        return $this->db->where('role_id', $id)->get('saas_roles')->row();
    }

    public function role_name_exists(string $name, int $exclude_id = 0): bool {
        $q = $this->db->where('role_name', $name);
        if ($exclude_id > 0) $q = $q->where('role_id !=', $exclude_id);
        return $q->count_all_results('saas_roles') > 0;
    }

    public function create_role(array $data): int {
        $this->db->insert('saas_roles', [
            'role_name'   => $data['name'],
            'label'       => $data['label'],
            'color'       => $data['color'] ?? 'bg-gray-100 text-gray-600',
            'permissions' => json_encode($data['permissions'] ?? []),
            'is_system'   => 0,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
        return $this->db->insert_id();
    }

    public function update_role(int $id, array $data): void {
        $update = ['label' => $data['label'], 'color' => $data['color']];
        // Only update permissions for non-system roles
        $role = $this->get_role_by_id($id);
        if ($role && !$role->is_system) {
            $update['permissions'] = json_encode($data['permissions'] ?? []);
        }
        $this->db->where('role_id', $id)->update('saas_roles', $update);
    }

    public function delete_role(int $id): void {
        $this->db->where('role_id', $id)->where('is_system', 0)->delete('saas_roles');
    }

    // ── Team (Admin accounts) ─────────────────────────────────────────────

    public function get_all_admins(): array {
        return $this->db->select('a.admin_id, a.name, a.email, a.role, COALESCE(r.label, a.role) as role_label, a.is_active, a.last_login, a.created_at')
                        ->from('saas_admins a')
                        ->join('saas_roles r', 'r.role_name = a.role', 'left')
                        ->get()->result_array();
    }

    public function create_admin(array $data): int {
        $this->load->library('Saas_password');
        $this->db->insert('saas_admins', [
            'name'       => $data['name'],
            'email'      => $data['email'],
            'password'   => Saas_password::hacher($data['password']),
            'role'       => $data['role'] ?? 'admin',
            'is_active'  => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        return $this->db->insert_id();
    }

    public function update_admin(int $id, array $data): void {
        $allowed = ['name', 'email', 'role', 'is_active'];
        $update  = array_intersect_key($data, array_flip($allowed));
        if (!empty($data['password'])) {
            $this->load->library('Saas_password');
            $update['password'] = Saas_password::hacher($data['password']);
        }
        if ($update) $this->db->where('admin_id', $id)->update('saas_admins', $update);
    }

    public function delete_admin(int $id): void {
        $this->db->where('admin_id', $id)->delete('saas_admins');
    }

    public function admin_email_exists(string $email, int $exclude_id = 0): bool {
        $q = $this->db->where('email', $email);
        if ($exclude_id > 0) $q = $q->where('admin_id !=', $exclude_id);
        return $q->count_all_results('saas_admins') > 0;
    }

    public function delete_plan(int $id): void {
        $this->db->where('plan_id', $id)->update('saas_plans', ['is_active' => 0]);
    }

    public function migrate_plan_clients(int $from_plan_id, int $to_plan_id): int {
        // Get all tenants with an active subscription on the old plan
        $subs = $this->db
            ->select('s.tenant_id, s.end_date')
            ->from('saas_subscriptions s')
            ->where('s.plan_id', $from_plan_id)
            ->where('s.status', 'active')
            ->get()->result_array();

        foreach ($subs as $sub) {
            $this->update_tenant_subscription(
                (int)$sub['tenant_id'],
                $to_plan_id,
                $sub['end_date']
            );
        }

        return count($subs);
    }

    // ── License Keys ─────────────────────────────────────────────────────

    public function get_all_licenses(): array {
        $sql = "
            SELECT
                k.*,
                t.business_name, t.email,
                s.plan_id     AS plan_id,
                s.status      AS sub_status,
                s.end_date    AS sub_end_date,
                p.plan_name,
                p.price
            FROM saas_license_keys k
            LEFT JOIN saas_tenants t ON t.tenant_id = k.tenant_id
            LEFT JOIN saas_subscriptions s ON s.sub_id = (
                SELECT sub_id FROM saas_subscriptions
                WHERE tenant_id = k.tenant_id
                ORDER BY sub_id DESC LIMIT 1
            )
            LEFT JOIN saas_plans p ON p.plan_id = s.plan_id
            ORDER BY k.created_at DESC
        ";
        return $this->db->query($sql)->result_array();
    }

    public function generate_license(int $tenant_id): array {
        $key = strtoupper(implode('-', str_split(bin2hex(random_bytes(8)), 4)));
        $this->db->insert('saas_license_keys', [
            'tenant_id'  => $tenant_id,
            'client_key' => $key,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $id = $this->db->insert_id();
        return $this->db->where('key_id', $id)->get('saas_license_keys')->row_array();
    }

    public function revoke_license(int $key_id): void {
        $this->db->where('key_id', $key_id)->update('saas_license_keys', [
            'status'     => 'revoked',
            'revoked_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function activate_license(string $client_key, string $server_url = ''): ?array {
        $key = $this->db->where('client_key', $client_key)
                        ->get('saas_license_keys')->row();
        if (!$key) return null;

        $this->db->where('key_id', $key->key_id)->update('saas_license_keys', [
            'is_activated' => 1,
            'activated_at' => date('Y-m-d H:i:s'),
            'server_url'   => $server_url,
        ]);

        return $this->get_tenant((int)$key->tenant_id);
    }

    // ── Payments ─────────────────────────────────────────────────────────

    public function get_all_payments(): array {
        $rows = $this->db
            ->select('pay.*, t.business_name as client_name, t.email as client_email, p.plan_name')
            ->from('saas_payments pay')
            ->join('saas_tenants t', 't.tenant_id = pay.tenant_id', 'left')
            ->join('saas_plans p', 'p.plan_id = pay.plan_id', 'left')
            ->order_by('pay.created_at', 'DESC')
            ->get()->result_array();
        foreach ($rows as &$r) {
            $r['payment_id'] = (int)$r['payment_id'];
            $r['amount']     = (float)$r['amount'];
        }
        return $rows;
    }

    public function record_payment(array $data): int {
        $this->db->insert('saas_payments', $data);
        return $this->db->insert_id();
    }

    // ── Activity Log ──────────────────────────────────────────────────────

    public function get_activity(int $tenant_id = 0, int $limit = 100): array {
        $this->db->select('a.*, t.business_name')
                 ->from('saas_activity_log a')
                 ->join('saas_tenants t', 't.tenant_id = a.tenant_id', 'left')
                 ->order_by('a.created_at', 'DESC')
                 ->limit($limit);

        if ($tenant_id > 0) {
            $this->db->where('a.tenant_id', $tenant_id);
        }
        $rows = $this->db->get()->result_array();
        foreach ($rows as &$r) {
            $r['meta'] = $r['meta'] ? json_decode($r['meta'], true) : null;
        }
        return $rows;
    }

    public function log_activity(int $tenant_id, string $action, string $desc = '', array $meta = []): void {
        $this->db->insert('saas_activity_log', [
            'tenant_id'   => $tenant_id,
            'action'      => $action,
            'description' => $desc,
            'meta'        => $meta ? json_encode($meta) : null,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
    }

    // ── Live Stats per tenant (saas DB only — no client DB connection) ──────

    public function tenant_live_stats(int $tenant_id): array {
        // Subscription info
        $sub = $this->db
            ->select('s.status, s.end_date, s.grace_end_date, p.plan_name, p.max_tables, p.max_users')
            ->from('saas_subscriptions s')
            ->join('saas_plans p', 'p.plan_id = s.plan_id')
            ->where('s.tenant_id', $tenant_id)
            ->order_by('s.sub_id', 'DESC')
            ->limit(1)
            ->get()->row_array();

        // Total paid by this tenant
        $total_paid = (float)($this->db
            ->select('SUM(amount) as total')
            ->from('saas_payments')
            ->where('tenant_id', $tenant_id)
            ->where('status', 'paid')
            ->get()->row()->total ?? 0);

        // Payment count
        $payment_count = (int)$this->db
            ->where('tenant_id', $tenant_id)
            ->where('status', 'paid')
            ->count_all_results('saas_payments');

        // Days remaining on subscription
        $days_remaining = 0;
        if (!empty($sub['end_date'])) {
            $days_remaining = max(0, (int)ceil((strtotime($sub['end_date']) - time()) / 86400));
        }

        return [
            'subscription_status' => $sub['status']     ?? 'none',
            'plan_name'           => $sub['plan_name']   ?? '—',
            'days_remaining'      => $days_remaining,
            'total_paid'          => $total_paid,
            'payment_count'       => $payment_count,
            'max_tables'          => (int)($sub['max_tables'] ?? 0),
            'max_users'           => (int)($sub['max_users']  ?? 0),
        ];
    }

    // ── Updates system ────────────────────────────────────────────────────

    public function get_all_updates(): array {
        $rows = $this->db
            ->select('u.*, t.business_name as target_name, p.plan_name as target_plan')
            ->from('saas_updates u')
            ->join('saas_tenants t', 't.tenant_id = u.target_id AND u.target_type = "tenant"', 'left')
            ->join('saas_plans p',   'p.plan_id   = u.target_id AND u.target_type = "plan"',   'left')
            ->order_by('u.created_at', 'DESC')
            ->get()->result_array();
        foreach ($rows as &$r) {
            $r['payload'] = $r['payload'] ? json_decode($r['payload'], true) : null;
        }
        return $rows;
    }

    public function get_update(int $id): ?array {
        $row = $this->db->where('update_id', $id)->get('saas_updates')->row_array();
        if (!$row) return null;
        $row['payload'] = $row['payload'] ? json_decode($row['payload'], true) : null;
        return $row;
    }

    public function create_update(array $data): int {
        $this->db->insert('saas_updates', [
            'title'       => $data['title'],
            'version'     => $data['version'],
            'module'      => $data['module'],
            'type'        => $data['type'],
            'target_type' => $data['target_type'],
            'target_id'   => $data['target_id'] ?? null,
            'changelog'   => $data['changelog'] ?? null,
            'payload'     => isset($data['payload']) ? json_encode($data['payload']) : null,
            'status'      => 'draft',
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
        return $this->db->insert_id();
    }

    public function publish_update(int $id): bool {
        $update = $this->get_update($id);
        if (!$update || $update['status'] !== 'draft') return false;

        $this->db->where('update_id', $id)->update('saas_updates', [
            'status'       => 'published',
            'published_at' => date('Y-m-d H:i:s'),
        ]);

        // Create pending delivery records for targeted tenants
        $tenants = $this->_resolve_targets($update);
        foreach ($tenants as $tid) {
            $this->db->insert_ignore = true;
            $this->db->replace('saas_update_deliveries', [
                'update_id' => $id,
                'tenant_id' => $tid,
                'status'    => 'pending',
            ]);
        }
        return true;
    }

    public function archive_update(int $id): void {
        $this->db->where('update_id', $id)->update('saas_updates', ['status' => 'archived']);
    }

    public function get_delivery_stats(int $update_id): array {
        $rows = $this->db
            ->select('status, COUNT(*) as cnt')
            ->from('saas_update_deliveries')
            ->where('update_id', $update_id)
            ->group_by('status')
            ->get()->result_array();
        $stats = ['pending' => 0, 'applied' => 0, 'failed' => 0];
        foreach ($rows as $r) $stats[$r['status']] = (int)$r['cnt'];
        return $stats;
    }

    /** Get pending updates for a specific tenant (called during license refresh) */
    public function get_pending_updates_for_tenant(int $tenant_id): array {
        return $this->db
            ->select('u.update_id, u.title, u.version, u.module, u.type, u.changelog, u.payload')
            ->from('saas_update_deliveries d')
            ->join('saas_updates u', 'u.update_id = d.update_id')
            ->where('d.tenant_id', $tenant_id)
            ->where('d.status', 'pending')
            ->where('u.status', 'published')
            ->get()->result_array();
    }

    /** Mark updates as applied for a tenant */
    public function mark_updates_applied(int $tenant_id, array $update_ids): void {
        if (empty($update_ids)) return;
        $this->db
            ->where('tenant_id', $tenant_id)
            ->where_in('update_id', $update_ids)
            ->update('saas_update_deliveries', [
                'status'     => 'applied',
                'applied_at' => date('Y-m-d H:i:s'),
            ]);
    }

    /** Mark updates as failed for a tenant */
    public function mark_updates_failed(int $tenant_id, int $update_id, string $error): void {
        $this->db
            ->where('tenant_id', $tenant_id)
            ->where('update_id', $update_id)
            ->update('saas_update_deliveries', [
                'status'    => 'failed',
                'error_msg' => $error,
            ]);
    }

    private function _resolve_targets(array $update): array {
        switch ($update['target_type']) {
            case 'all':
                return array_column($this->db->select('tenant_id')->get('saas_tenants')->result_array(), 'tenant_id');
            case 'plan':
                return array_column(
                    $this->db->select('tenant_id')->from('saas_subscriptions')
                        ->where('plan_id', $update['target_id'])->where('status', 'active')
                        ->get()->result_array(),
                    'tenant_id'
                );
            case 'tenant':
                return [$update['target_id']];
            default:
                return [];
        }
    }

    // ── Invoices ──────────────────────────────────────────────────────────

    public function get_all_invoices(int $tenant_id = 0): array {
        $this->db
            ->select('i.*, t.business_name, t.email as client_email, p.plan_name')
            ->from('saas_invoices i')
            ->join('saas_tenants t', 't.tenant_id = i.tenant_id', 'left')
            ->join('saas_plans p', 'p.plan_id = i.plan_id', 'left')
            ->order_by('i.created_at', 'DESC');

        if ($tenant_id > 0) {
            $this->db->where('i.tenant_id', $tenant_id);
        }

        $rows = $this->db->get()->result_array();
        foreach ($rows as &$r) {
            $r['invoice_id'] = (int)$r['invoice_id'];
            $r['amount']     = (float)$r['amount'];
        }
        return $rows;
    }

    public function get_invoice(int $id): ?array {
        $row = $this->db
            ->select('i.*, t.business_name, t.email as client_email, p.plan_name')
            ->from('saas_invoices i')
            ->join('saas_tenants t', 't.tenant_id = i.tenant_id', 'left')
            ->join('saas_plans p', 'p.plan_id = i.plan_id', 'left')
            ->where('i.invoice_id', $id)
            ->get()->row_array();

        return $row ?: null;
    }

    public function create_invoice(array $data): int {
        // Generate invoice number: INV-YYYYMM-XXXX
        $prefix = 'INV-' . date('Ym') . '-';
        $last   = $this->db
            ->like('invoice_number', $prefix, 'after')
            ->order_by('invoice_id', 'DESC')
            ->limit(1)
            ->get('saas_invoices')->row();

        $seq = $last ? ((int)substr($last->invoice_number, -4) + 1) : 1;

        $this->db->insert('saas_invoices', [
            'invoice_number' => $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT),
            'tenant_id'      => $data['tenant_id'],
            'plan_id'        => $data['plan_id'] ?? null,
            'amount'         => $data['amount'],
            'currency'       => $data['currency'] ?? 'FCFA',
            'period_start'   => $data['period_start'] ?? null,
            'period_end'     => $data['period_end'] ?? null,
            'status'         => 'draft',
            'notes'          => $data['notes'] ?? null,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        return $this->db->insert_id();
    }

    public function confirm_payment(int $invoice_id, string $method): bool {
        $invoice = $this->get_invoice($invoice_id);
        if (!$invoice || $invoice['status'] === 'paid') return false;

        $this->db->where('invoice_id', $invoice_id)->update('saas_invoices', [
            'status'         => 'paid',
            'payment_method' => $method,
            'paid_at'        => date('Y-m-d H:i:s'),
        ]);

        // Also record in saas_payments for dashboard stats
        $this->record_payment([
            'tenant_id'  => $invoice['tenant_id'],
            'plan_id'    => $invoice['plan_id'],
            'amount'     => $invoice['amount'],
            'currency'   => $invoice['currency'],
            'status'     => 'paid',
            'reference'  => $invoice['invoice_number'],
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return true;
    }

    public function update_invoice_status(int $invoice_id, string $status): void {
        $this->db->where('invoice_id', $invoice_id)->update('saas_invoices', ['status' => $status]);
    }

    // ── Recent payments (replaces cross-tenant restaurant orders) ────────────

    public function get_recent_orders(int $limit = 15): array {
        $rows = $this->db
            ->select('p.payment_id, p.tenant_id, p.amount, p.currency, p.status, p.reference, p.created_at, t.business_name, pl.plan_name')
            ->from('saas_payments p')
            ->join('saas_tenants t',  't.tenant_id = p.tenant_id', 'left')
            ->join('saas_plans pl',   'pl.plan_id  = p.plan_id',   'left')
            ->order_by('p.created_at', 'DESC')
            ->limit($limit)
            ->get()->result_array();

        foreach ($rows as &$r) {
            $r['payment_id'] = (int)$r['payment_id'];
            $r['amount']     = (float)$r['amount'];
        }
        return $rows;
    }

    public function get_all_clients_stats(): array {
        $tenants = $this->db->select('tenant_id, business_name')->get('saas_tenants')->result_array();
        $result  = [];
        foreach ($tenants as $tenant) {
            $tid = (int)$tenant['tenant_id'];

            // Subscription
            $sub = $this->db
                ->select('s.status, s.end_date, p.plan_name')
                ->from('saas_subscriptions s')
                ->join('saas_plans p', 'p.plan_id = s.plan_id')
                ->where('s.tenant_id', $tid)
                ->order_by('s.sub_id', 'DESC')
                ->limit(1)
                ->get()->row_array();

            // Payments
            $pay = $this->db
                ->select('SUM(amount) as total_revenue, COUNT(*) as payment_count')
                ->from('saas_payments')
                ->where('tenant_id', $tid)
                ->where('status', 'paid')
                ->get()->row_array();

            $result[] = [
                'tenant_id'          => $tid,
                'business_name'      => $tenant['business_name'],
                'subscription_status'=> $sub['status']    ?? 'none',
                'plan_name'          => $sub['plan_name']  ?? '—',
                'end_date'           => $sub['end_date']   ?? null,
                'total_revenue'      => (float)($pay['total_revenue'] ?? 0),
                'payment_count'      => (int)($pay['payment_count']   ?? 0),
            ];
        }
        return $result;
    }

    public function get_revenue_by_month_per_client(): array {
        $since = date('Y-m-01', strtotime('-5 months'));
        $sql = "
            SELECT
                p.tenant_id,
                t.business_name,
                DATE_FORMAT(p.created_at, '%b %Y')  AS month,
                DATE_FORMAT(p.created_at, '%Y-%m')  AS month_key,
                SUM(p.amount)                        AS revenue,
                COUNT(*)                             AS payment_count
            FROM saas_payments p
            LEFT JOIN saas_tenants t ON t.tenant_id = p.tenant_id
            WHERE p.status = 'paid'
              AND p.created_at >= ?
            GROUP BY p.tenant_id, t.business_name, DATE_FORMAT(p.created_at, '%Y-%m'), DATE_FORMAT(p.created_at, '%b %Y')
            ORDER BY month_key ASC
        ";
        return $this->db->query($sql, [$since])->result_array();
    }

    // ── Settings ──────────────────────────────────────────────────────────

    public function get_all_settings(): array {
        $rows = $this->db->get('saas_settings')->result_array();
        $out  = [];
        foreach ($rows as $r) {
            $out[$r['setting_key']] = $r['setting_value'];
        }
        return $out;
    }

    public function save_settings(array $kv): void {
        foreach ($kv as $key => $value) {
            $this->db->replace('saas_settings', [
                'setting_key'   => $key,
                'setting_value' => $value,
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
        }
    }

    /** Build the CI email config array from saas_settings rows */
    public function get_email_config(): array {
        $s = $this->get_all_settings();
        return [
            'protocol'         => $s['smtp_protocol']  ?? 'smtp',
            'smtp_host'        => $s['smtp_host']       ?? '',
            'smtp_port'        => (int)($s['smtp_port'] ?? 587),
            'smtp_crypto'      => $s['smtp_crypto']     ?? 'tls',
            'smtp_user'        => $s['smtp_user']       ?? '',
            'smtp_pass'        => $s['smtp_pass']       ?? '',
            'from_email'       => $s['from_email']      ?? '',
            'from_name'        => $s['from_name']       ?? 'Bonresto SaaS',
            'charset'          => 'utf-8',
            'mailtype'         => 'html',
            'newline'          => "\r\n",
            'crlf'             => "\r\n",
            'smtp_timeout'     => 15,
            // Bypass SSL verification pour serveurs dédiés
            'smtp_conn_options' => [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ],
        ];
    }

    /** Build company info array from saas_settings rows */
    public function get_company_info(): array {
        $s = $this->get_all_settings();
        return [
            'name'    => $s['company_name']    ?? 'Bonresto',
            'address' => $s['company_address'] ?? '',
            'email'   => $s['company_email']   ?? '',
            'phone'   => $s['company_phone']   ?? '',
            'website' => $s['company_website'] ?? '',
        ];
    }

    // ── Support Tickets ──────────────────────────────────────────────────

    public function get_all_tickets(?string $status = null, int $tenant_id = 0, ?int $assigned_to = null): array {
        $this->db->select('t.*, ten.business_name, a.name as assigned_name, (SELECT COUNT(*) FROM saas_support_messages WHERE ticket_id = t.ticket_id) as message_count')
                 ->from('saas_support_tickets t')
                 ->join('saas_tenants ten', 'ten.tenant_id = t.tenant_id', 'left')
                 ->join('saas_admins a', 'a.admin_id = t.assigned_to', 'left')
                 ->order_by('t.created_at', 'DESC');

        if ($status) $this->db->where('t.status', $status);
        if ($tenant_id > 0) $this->db->where('t.tenant_id', $tenant_id);
        if ($assigned_to) $this->db->where('t.assigned_to', $assigned_to);

        $rows = $this->db->get()->result_array();
        foreach ($rows as &$r) {
            $r['ticket_id'] = (int)$r['ticket_id'];
            $r['tenant_id'] = (int)$r['tenant_id'];
        }
        return $rows;
    }

    public function get_ticket(int $id): ?array {
        $row = $this->db->select('t.*, ten.business_name, a.name as assigned_name')
                        ->from('saas_support_tickets t')
                        ->join('saas_tenants ten', 'ten.tenant_id = t.tenant_id', 'left')
                        ->join('saas_admins a', 'a.admin_id = t.assigned_to', 'left')
                        ->where('t.ticket_id', $id)
                        ->get()->row_array();
        return $row ?: null;
    }

    public function create_ticket(array $data): int {
        $this->db->insert('saas_support_tickets', [
            'tenant_id'  => $data['tenant_id'],
            'subject'    => $data['subject'],
            'priority'   => $data['priority'] ?? 'normal',
            'status'     => 'open',
            'assigned_to'=> $data['assigned_to'] ?? null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $ticket_id = $this->db->insert_id();

        // Add initial message if provided
        if (!empty($data['message'])) {
            $this->add_ticket_message($ticket_id, [
                'sender_type' => 'admin',
                'sender_id'   => $data['created_by'] ?? null,
                'body'        => $data['message'],
            ]);
        }

        return $ticket_id;
    }

    public function update_ticket(int $id, array $data): void {
        $allowed = ['subject', 'priority', 'status', 'assigned_to'];
        $update  = array_intersect_key($data, array_flip($allowed));
        if ($update) {
            $update['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where('ticket_id', $id)->update('saas_support_tickets', $update);
        }
    }

    public function get_ticket_messages(int $ticket_id): array {
        return $this->db->select('m.*, a.name as sender_name')
                        ->from('saas_support_messages m')
                        ->join('saas_admins a', "a.admin_id = m.sender_id AND m.sender_type = 'admin'", 'left')
                        ->where('m.ticket_id', $ticket_id)
                        ->order_by('m.created_at', 'ASC')
                        ->get()->result_array();
    }

    public function add_ticket_message(int $ticket_id, array $data): int {
        $this->db->insert('saas_support_messages', [
            'ticket_id'   => $ticket_id,
            'sender_type' => $data['sender_type'] ?? 'admin',
            'sender_id'   => $data['sender_id'] ?? null,
            'body'        => $data['body'],
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
        return $this->db->insert_id();
    }

    public function get_support_stats(): array {
        $open = $this->db->where('status', 'open')->count_all_results('saas_support_tickets');
        $in_progress = $this->db->where('status', 'waiting_customer')->count_all_results('saas_support_tickets');
        $closed_month = $this->db->where('status', 'closed')
                                 ->where('closed_at >=', date('Y-m-01'))
                                 ->count_all_results('saas_support_tickets');
        $total = $this->db->count_all('saas_support_tickets');

        return [
            'open'          => (int)$open,
            'in_progress'   => (int)$in_progress,
            'closed_month'  => (int)$closed_month,
            'total'         => (int)$total,
        ];
    }

    // ── Terminals / Monitoring ───────────────────────────────────────────

    public function get_all_terminals(int $tenant_id = 0, ?string $type = null, ?string $status = null): array {
        $this->db->select('t.*, ten.business_name')
                 ->from('saas_terminals t')
                 ->join('saas_tenants ten', 'ten.tenant_id = t.tenant_id', 'left')
                 ->order_by('t.last_seen_at', 'DESC');

        if ($tenant_id > 0) $this->db->where('t.tenant_id', $tenant_id);
        if ($type) $this->db->where('t.type', $type);
        if ($status) $this->db->where('t.status', $status);

        return $this->db->get()->result_array();
    }

    public function get_terminal(int $id): ?array {
        $row = $this->db->select('t.*, ten.business_name')
                        ->from('saas_terminals t')
                        ->join('saas_tenants ten', 'ten.tenant_id = t.tenant_id', 'left')
                        ->where('t.terminal_id', $id)
                        ->get()->row_array();
        return $row ?: null;
    }

    public function get_terminal_by_uid(string $uid): ?array {
        $row = $this->db->where('terminal_uid', $uid)->get('saas_terminals')->row_array();
        return $row ?: null;
    }

    public function register_terminal(array $data): int {
        $this->db->insert('saas_terminals', [
            'tenant_id'    => $data['tenant_id'],
            'terminal_uid' => $data['terminal_uid'],
            'type'         => $data['type'] ?? 'caisse',
            'label'        => $data['label'] ?? '',
            'os'           => $data['os'] ?? '',
            'app_version'  => $data['app_version'] ?? '',
            'ip_address'   => $data['ip_address'] ?? '',
            'status'       => 'online',
            'last_seen_at' => date('Y-m-d H:i:s'),
            'created_at'   => date('Y-m-d H:i:s'),
        ]);
        return $this->db->insert_id();
    }

    public function touch_terminal(int $id, array $data): void {
        $update = ['last_seen_at' => date('Y-m-d H:i:s'), 'status' => 'online'];
        if (!empty($data['app_version'])) $update['app_version'] = $data['app_version'];
        if (!empty($data['ip_address'])) $update['ip_address'] = $data['ip_address'];
        $this->db->where('terminal_id', $id)->update('saas_terminals', $update);
    }

    public function record_heartbeat(int $terminal_id, array $data): void {
        $this->db->insert('saas_terminal_heartbeats', [
            'terminal_id'  => $terminal_id,
            'cpu_usage'    => $data['cpu_usage'],
            'memory_usage' => $data['memory_usage'],
            'disk_usage'   => $data['disk_usage'],
            'app_version'  => $data['app_version'],
            'ip_address'   => $data['ip_address'],
            'created_at'   => date('Y-m-d H:i:s'),
        ]);
    }

    public function get_terminal_heartbeats(int $terminal_id, int $limit = 50): array {
        return $this->db->where('terminal_id', $terminal_id)
                        ->order_by('created_at', 'DESC')
                        ->limit($limit)
                        ->get('saas_terminal_heartbeats')->result_array();
    }

    public function get_terminal_commands(int $terminal_id, ?string $status = null): array {
        $this->db->where('terminal_id', $terminal_id)->order_by('created_at', 'DESC');
        if ($status) $this->db->where('status', $status);
        return $this->db->get('saas_terminal_commands')->result_array();
    }

    public function create_terminal_command(int $terminal_id, array $data): int {
        $this->db->insert('saas_terminal_commands', [
            'terminal_id' => $terminal_id,
            'command'     => $data['command'],
            'payload'     => isset($data['payload']) ? json_encode($data['payload']) : null,
            'issued_by'   => $data['issued_by'] ?? null,
            'status'      => 'pending',
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
        return $this->db->insert_id();
    }

    public function ack_terminal_command(int $command_id, array $data): void {
        $this->db->where('command_id', $command_id)->update('saas_terminal_commands', [
            'status'      => $data['status'] ?? 'done',
            'result'      => $data['result'] ?? null,
            'executed_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function get_monitoring_stats(): array {
        $total = $this->db->count_all('saas_terminals');
        $online = $this->db->where('status', 'online')
                           ->where('last_seen_at >=', date('Y-m-d H:i:s', strtotime('-5 minutes')))
                           ->count_all_results('saas_terminals');
        $caisses = $this->db->where('type', 'caisse')->count_all_results('saas_terminals');
        $serveurs = $this->db->where('type', 'serveur')->count_all_results('saas_terminals');

        return [
            'total'    => (int)$total,
            'online'   => (int)$online,
            'offline'  => (int)$total - (int)$online,
            'caisses'  => (int)$caisses,
            'serveurs' => (int)$serveurs,
        ];
    }

    // ── Onboarding ───────────────────────────────────────────────────────

    public function get_all_onboardings(?string $status = null): array {
        $this->db->select('o.onboarding_id, o.tenant_id, o.assigned_to, o.current_step,
                           o.progress, o.status, o.started_at, o.completed_at, o.notes,
                           ten.business_name, ten.city,
                           p.plan_name,
                           a.name as assigned_name')
                 ->from('saas_onboarding o')
                 ->join('saas_tenants ten', 'ten.tenant_id = o.tenant_id', 'left')
                 ->join('saas_subscriptions sub', 'sub.tenant_id = o.tenant_id AND sub.status = "active"', 'left')
                 ->join('saas_plans p', 'p.plan_id = sub.plan_id', 'left')
                 ->join('saas_admins a', 'a.admin_id = o.assigned_to', 'left')
                 ->order_by('o.started_at', 'DESC');

        if ($status) $this->db->where('o.status', $status);

        return $this->db->get()->result_array();
    }

    public function get_onboarding(int $id): ?array {
        $row = $this->db->select('o.onboarding_id, o.tenant_id, o.assigned_to, o.current_step,
                                  o.progress, o.status, o.started_at, o.completed_at, o.notes,
                                  ten.business_name, ten.city,
                                  p.plan_name,
                                  a.name as assigned_name')
                        ->from('saas_onboarding o')
                        ->join('saas_tenants ten', 'ten.tenant_id = o.tenant_id', 'left')
                        ->join('saas_subscriptions sub', 'sub.tenant_id = o.tenant_id AND sub.status = "active"', 'left')
                        ->join('saas_plans p', 'p.plan_id = sub.plan_id', 'left')
                        ->join('saas_admins a', 'a.admin_id = o.assigned_to', 'left')
                        ->where('o.onboarding_id', $id)
                        ->get()->row_array();
        return $row ?: null;
    }

    public function create_onboarding(array $data): int {
        $this->db->insert('saas_onboarding', [
            'tenant_id'    => $data['tenant_id'],
            'assigned_to'  => $data['assigned_to'] ?? null,
            'current_step' => 1,
            'progress'     => 0,
            'status'       => 'in_progress',
        ]);
        return $this->db->insert_id();
    }

    public function update_onboarding(int $id, array $data): void {
        $allowed = ['assigned_to', 'status', 'current_step', 'progress', 'completed_at', 'notes'];
        $update  = array_intersect_key($data, array_flip($allowed));
        if ($update) {
            $update['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where('onboarding_id', $id)->update('saas_onboarding', $update);
        }
    }

    public function get_onboarding_steps(int $onboarding_id): array {
        return $this->db->where('onboarding_id', $onboarding_id)
                        ->order_by('step_number', 'ASC')
                        ->get('saas_onboarding_steps')->result_array();
    }

    public function get_onboarding_step(int $step_id): ?array {
        $row = $this->db->where('step_id', $step_id)->get('saas_onboarding_steps')->row_array();
        return $row ?: null;
    }

    public function create_onboarding_step(array $data): int {
        $this->db->insert('saas_onboarding_steps', [
            'onboarding_id' => $data['onboarding_id'],
            'step_number'   => $data['position'] ?? $data['step_number'] ?? 1,
            'step_name'     => $data['label'] ?? $data['step_name'] ?? '',
            'status'        => 'pending',
        ]);
        return $this->db->insert_id();
    }

    public function update_onboarding_step(int $step_id, array $data): void {
        $allowed = ['status', 'notes', 'completed_at', 'completed_by'];
        $update  = array_intersect_key($data, array_flip($allowed));
        if (isset($update['status']) && $update['status'] === 'completed' && empty($update['completed_at'])) {
            $update['completed_at'] = date('Y-m-d H:i:s');
        }
        if ($update) {
            $this->db->where('step_id', $step_id)->update('saas_onboarding_steps', $update);
        }
    }

    public function recalculate_onboarding_progress(int $onboarding_id): void {
        $total = $this->db->where('onboarding_id', $onboarding_id)->count_all_results('saas_onboarding_steps');
        $done  = $this->db->where('onboarding_id', $onboarding_id)->where('status', 'completed')->count_all_results('saas_onboarding_steps');

        $progress = $total > 0 ? (int)round(($done / $total) * 100) : 0;

        // current_step = next pending step number, or total if all done
        $next_pending = $this->db->select('step_number')
                                 ->where('onboarding_id', $onboarding_id)
                                 ->where('status !=', 'completed')
                                 ->order_by('step_number', 'ASC')
                                 ->limit(1)
                                 ->get('saas_onboarding_steps')->row_array();
        $current_step = $next_pending ? (int)$next_pending['step_number'] : $total;

        $update = [
            'progress'     => $progress,
            'current_step' => $current_step,
            'updated_at'   => date('Y-m-d H:i:s'),
        ];

        if ($progress === 100) {
            $update['status']       = 'completed';
            $update['completed_at'] = date('Y-m-d H:i:s');
        }

        $this->db->where('onboarding_id', $onboarding_id)->update('saas_onboarding', $update);
    }

    // ── Coupons ──────────────────────────────────────────────────────────

    public function get_all_coupons(): array {
        $rows = $this->db->order_by('created_at', 'DESC')->get('saas_coupons')->result_array();
        foreach ($rows as &$r) {
            $r['eligible_plans'] = !empty($r['eligible_plans']) ? json_decode($r['eligible_plans'], true) : null;
            $r['current_uses'] = (int)$this->db->where('coupon_id', $r['coupon_id'])->count_all_results('saas_coupon_usage');
        }
        return $rows;
    }

    public function get_coupon(int $id): ?array {
        $row = $this->db->where('coupon_id', $id)->get('saas_coupons')->row_array();
        if (!$row) return null;
        $row['eligible_plans'] = !empty($row['eligible_plans']) ? json_decode($row['eligible_plans'], true) : null;
        $row['current_uses'] = (int)$this->db->where('coupon_id', $id)->count_all_results('saas_coupon_usage');
        return $row;
    }

    public function coupon_code_exists(string $code, int $exclude_id = 0): bool {
        $q = $this->db->where('code', strtoupper($code));
        if ($exclude_id > 0) $q = $q->where('coupon_id !=', $exclude_id);
        return $q->count_all_results('saas_coupons') > 0;
    }

    public function create_coupon(array $data): int {
        $type  = $data['type']  ?? $data['discount_type']  ?? 'percent';
        $value = $data['value'] ?? $data['discount_value'] ?? 0;
        $plans = $data['eligible_plans'] ?? $data['applicable_plans'] ?? null;
        $this->db->insert('saas_coupons', [
            'code'           => strtoupper(trim($data['code'])),
            'description'    => $data['description'] ?? '',
            'type'           => $type,
            'value'          => (float)$value,
            'eligible_plans' => is_array($plans) ? json_encode($plans) : ($plans ?: null),
            'max_uses'       => $data['max_uses'] ?? null,
            'expires_at'     => $data['expires_at'] ?? null,
            'status'         => 'active',
            'created_at'     => date('Y-m-d H:i:s'),
        ]);
        return $this->db->insert_id();
    }

    public function update_coupon(int $id, array $data): void {
        if (isset($data['discount_type']))    $data['type']           = $data['discount_type'];
        if (isset($data['discount_value']))   $data['value']          = $data['discount_value'];
        if (isset($data['applicable_plans'])) $data['eligible_plans'] = $data['applicable_plans'];
        $allowed = ['code', 'description', 'type', 'value', 'eligible_plans', 'max_uses', 'expires_at', 'status'];
        $update  = array_intersect_key($data, array_flip($allowed));
        if (isset($update['code'])) $update['code'] = strtoupper($update['code']);
        if (isset($update['eligible_plans']) && is_array($update['eligible_plans'])) {
            $update['eligible_plans'] = json_encode($update['eligible_plans']);
        }
        if ($update) {
            $this->db->where('coupon_id', $id)->update('saas_coupons', $update);
        }
    }

    public function deactivate_coupon(int $id): void {
        $this->db->where('coupon_id', $id)->update('saas_coupons', ['status' => 'disabled']);
    }

    public function validate_coupon(string $code, ?int $plan_id = null): array {
        $coupon = $this->db->where('code', strtoupper($code))->get('saas_coupons')->row_array();

        if (!$coupon) return ['valid' => false, 'reason' => 'Code promo introuvable.'];
        if ($coupon['status'] !== 'active') return ['valid' => false, 'reason' => 'Code promo désactivé ou expiré.'];
        if ($coupon['expires_at'] && strtotime($coupon['expires_at']) < time()) {
            return ['valid' => false, 'reason' => 'Code promo expiré.'];
        }
        if ($coupon['max_uses']) {
            $uses = $this->db->where('coupon_id', $coupon['coupon_id'])->count_all_results('saas_coupon_usage');
            if ($uses >= (int)$coupon['max_uses']) {
                return ['valid' => false, 'reason' => 'Limite d\'utilisation atteinte.'];
            }
        }
        if ($plan_id && !empty($coupon['eligible_plans'])) {
            $plans = is_array($coupon['eligible_plans']) ? $coupon['eligible_plans'] : json_decode($coupon['eligible_plans'], true);
            if (!in_array($plan_id, $plans)) {
                return ['valid' => false, 'reason' => 'Code non applicable à ce plan.'];
            }
        }

        return [
            'valid'    => true,
            'discount' => [
                'type'  => $coupon['type'],
                'value' => (float)$coupon['value'],
            ],
        ];
    }

    public function get_coupon_usage(int $coupon_id): array {
        return $this->db->select('u.*, t.business_name')
                        ->from('saas_coupon_usage u')
                        ->join('saas_tenants t', 't.tenant_id = u.tenant_id', 'left')
                        ->where('u.coupon_id', $coupon_id)
                        ->order_by('u.applied_at', 'DESC')
                        ->get()->result_array();
    }

    public function record_coupon_usage(int $coupon_id, int $tenant_id, ?int $subscription_id = null): void {
        $this->db->insert('saas_coupon_usage', [
            'coupon_id'       => $coupon_id,
            'tenant_id'       => $tenant_id,
            'discount_amount' => 0,
        ]);
        // Increment used_count
        $this->db->set('used_count', 'used_count + 1', false)
                 ->where('coupon_id', $coupon_id)
                 ->update('saas_coupons');
    }

    // ── Email Templates ──────────────────────────────────────────────────

    public function get_all_email_templates(): array {
        return $this->db->order_by('slug', 'ASC')->get('saas_email_templates')->result_array();
    }

    public function get_email_template(int $id): ?array {
        $row = $this->db->where('template_id', $id)->get('saas_email_templates')->row_array();
        return $row ?: null;
    }

    public function get_email_template_by_slug(string $slug): ?array {
        $row = $this->db->where('slug', $slug)->get('saas_email_templates')->row_array();
        return $row ?: null;
    }

    public function update_email_template(int $id, array $data): void {
        $allowed = ['subject', 'body_html', 'variables', 'is_active'];
        $update  = array_intersect_key($data, array_flip($allowed));
        if ($update) {
            $update['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where('template_id', $id)->update('saas_email_templates', $update);
        }
    }

    // ── API Logs ─────────────────────────────────────────────────────────

    public function log_api_call(array $data): void {
        $this->db->insert('saas_api_logs', [
            'tenant_id'   => $data['tenant_id'] ?? null,
            'method'      => $data['method'] ?? 'GET',
            'endpoint'    => $data['endpoint'] ?? '',
            'status_code' => $data['status_code'] ?? 200,
            'latency_ms'  => $data['latency_ms'] ?? $data['response_time'] ?? null,
            'ip_address'  => $data['ip_address'] ?? '',
            'user_agent'  => $data['user_agent'] ?? '',
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
    }

    public function get_api_logs(int $tenant_id = 0, ?string $method = null, ?string $status = null, int $limit = 100, int $offset = 0): array {
        $this->db->select('l.*, t.business_name')
                 ->from('saas_api_logs l')
                 ->join('saas_tenants t', 't.tenant_id = l.tenant_id', 'left')
                 ->order_by('l.created_at', 'DESC')
                 ->limit($limit, $offset);

        if ($tenant_id > 0) $this->db->where('l.tenant_id', $tenant_id);
        if ($method) $this->db->where('l.method', $method);
        if ($status === 'success') $this->db->where('l.status_code <', 400);
        if ($status === 'error') $this->db->where('l.status_code >=', 400);

        $rows = $this->db->get()->result_array();

        // Get total count for pagination
        $this->db->from('saas_api_logs');
        if ($tenant_id > 0) $this->db->where('tenant_id', $tenant_id);
        if ($method) $this->db->where('method', $method);
        if ($status === 'success') $this->db->where('status_code <', 400);
        if ($status === 'error') $this->db->where('status_code >=', 400);
        $total = $this->db->count_all_results();

        return ['data' => $rows, 'total' => $total, 'limit' => $limit, 'offset' => $offset];
    }

    public function get_api_logs_stats(string $period = '24h'): array {
        $since = match ($period) {
            '1h'  => date('Y-m-d H:i:s', strtotime('-1 hour')),
            '24h' => date('Y-m-d H:i:s', strtotime('-24 hours')),
            '7d'  => date('Y-m-d H:i:s', strtotime('-7 days')),
            '30d' => date('Y-m-d H:i:s', strtotime('-30 days')),
            default => date('Y-m-d H:i:s', strtotime('-24 hours')),
        };

        $total = $this->db->where('created_at >=', $since)->count_all_results('saas_api_logs');
        $errors = $this->db->where('created_at >=', $since)->where('status_code >=', 400)->count_all_results('saas_api_logs');
        $avg_time = (float)($this->db->select_avg('latency_ms')->where('created_at >=', $since)->get('saas_api_logs')->row()->latency_ms ?? 0);

        // Requests by method
        $by_method = $this->db->select('method, COUNT(*) as count')
                              ->from('saas_api_logs')
                              ->where('created_at >=', $since)
                              ->group_by('method')
                              ->get()->result_array();

        // Top endpoints
        $top_endpoints = $this->db->select('endpoint, COUNT(*) as count, AVG(latency_ms) as avg_time')
                                  ->from('saas_api_logs')
                                  ->where('created_at >=', $since)
                                  ->group_by('endpoint')
                                  ->order_by('count', 'DESC')
                                  ->limit(10)
                                  ->get()->result_array();

        return [
            'total_requests'    => (int)$total,
            'error_count'       => (int)$errors,
            'error_rate'        => $total > 0 ? round(($errors / $total) * 100, 2) : 0,
            'avg_response_time' => round($avg_time, 2),
            'by_method'         => $by_method,
            'top_endpoints'     => $top_endpoints,
        ];
    }

    public function purge_api_logs(int $older_than_days): int {
        $cutoff = date('Y-m-d H:i:s', strtotime("-{$older_than_days} days"));
        $this->db->where('created_at <', $cutoff)->delete('saas_api_logs');
        return $this->db->affected_rows();
    }

    // ── Scheduled Exports ────────────────────────────────────────────────

    public function get_all_scheduled_exports(): array {
        return $this->db->select('e.*, a.name as created_by_name')
                        ->from('saas_scheduled_exports e')
                        ->join('saas_admins a', 'a.admin_id = e.created_by', 'left')
                        ->order_by('e.created_at', 'DESC')
                        ->get()->result_array();
    }

    public function get_scheduled_export(int $id): ?array {
        $row = $this->db->select('e.*, a.name as created_by_name')
                        ->from('saas_scheduled_exports e')
                        ->join('saas_admins a', 'a.admin_id = e.created_by', 'left')
                        ->where('e.export_id', $id)
                        ->get()->row_array();
        return $row ?: null;
    }

    public function create_scheduled_export(array $data): int {
        $this->db->insert('saas_scheduled_exports', [
            'name'        => $data['name'],
            'export_type' => $data['export_type'],
            'format'      => $data['format'] ?? 'csv',
            'frequency'   => $data['frequency'],
            'recipients'  => $data['recipients'] ?? '',
            'filters'     => isset($data['filters']) ? json_encode($data['filters']) : null,
            'is_active'   => 1,
            'created_by'  => $data['created_by'] ?? null,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
        return $this->db->insert_id();
    }

    public function update_scheduled_export(int $id, array $data): void {
        $allowed = ['name', 'export_type', 'format', 'frequency', 'recipients', 'filters', 'is_active', 'last_run_at'];
        $update  = array_intersect_key($data, array_flip($allowed));
        if (isset($update['filters']) && is_array($update['filters'])) {
            $update['filters'] = json_encode($update['filters']);
        }
        if ($update) {
            $this->db->where('export_id', $id)->update('saas_scheduled_exports', $update);
        }
    }

    public function delete_scheduled_export(int $id): void {
        $this->db->where('export_id', $id)->delete('saas_scheduled_exports');
    }

    // ── Notifications ────────────────────────────────────────────────────

    public function get_notifications(int $admin_id, int $limit = 50): array {
        return $this->db->where('admin_id', $admin_id)
                        ->order_by('created_at', 'DESC')
                        ->limit($limit)
                        ->get('saas_notifications')->result_array();
    }

    public function get_unread_count(int $admin_id): int {
        return $this->db->where('admin_id', $admin_id)
                        ->where('is_read', 0)
                        ->count_all_results('saas_notifications');
    }

    public function create_notification(array $data): int {
        $this->db->insert('saas_notifications', [
            'admin_id'  => $data['admin_id'],
            'type'      => $data['type'] ?? 'info',
            'title'     => $data['title'],
            'body'      => $data['body'] ?? '',
            'link'      => $data['link'] ?? null,
            'is_read'   => 0,
            'created_at'=> date('Y-m-d H:i:s'),
        ]);
        return $this->db->insert_id();
    }

    public function mark_notification_read(int $notification_id): void {
        $this->db->where('notification_id', $notification_id)->update('saas_notifications', [
            'is_read' => 1,
            'read_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function mark_all_notifications_read(int $admin_id): void {
        $this->db->where('admin_id', $admin_id)->where('is_read', 0)->update('saas_notifications', [
            'is_read' => 1,
            'read_at' => date('Y-m-d H:i:s'),
        ]);
    }

    // ── Admin Sessions ───────────────────────────────────────────────────

    public function record_session(int $admin_id, array $data): int {
        $this->db->insert('saas_admin_sessions', [
            'admin_id'   => $admin_id,
            'ip_address' => $data['ip_address'] ?? '',
            'user_agent' => $data['user_agent'] ?? '',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Update last_login on admin
        $this->db->where('admin_id', $admin_id)->update('saas_admins', [
            'last_login' => date('Y-m-d H:i:s'),
        ]);

        return $this->db->insert_id();
    }

    public function get_admin_sessions(int $admin_id, int $limit = 20): array {
        return $this->db->where('admin_id', $admin_id)
                        ->order_by('created_at', 'DESC')
                        ->limit($limit)
                        ->get('saas_admin_sessions')->result_array();
    }

    public function invalidate_session(int $session_id): void {
        $this->db->where('session_id', $session_id)->update('saas_admin_sessions', [
            'revoked_at' => date('Y-m-d H:i:s'),
        ]);
    }

    // ── Private helpers ───────────────────────────────────────────────────

    private function _format_tenant(array $row): array {
        $sub = null;
        if (!empty($row['sub_id'])) {
            $plan_id   = (int)($row['plan_id'] ?? 0);
            $tenant_id = (int)$row['tenant_id'];

            // Build features from saas_plan_features (source de vérité)
            $features = [];
            if ($plan_id > 0) {
                $pf_rows = $this->db->where('plan_id', $plan_id)->get('saas_plan_features')->result();
                foreach ($pf_rows as $pf) {
                    $features[$pf->feature] = (bool)$pf->enabled;
                }
            }
            // Fallback: si pas de plan_features, utiliser le vieux JSON column
            if (empty($features) && isset($row['features'])) {
                $features = json_decode($row['features'], true) ?: [];
            }
            // Per-tenant overrides (priorité)
            $tf_rows = $this->db->where('tenant_id', $tenant_id)->get('saas_tenant_features')->result();
            foreach ($tf_rows as $tf) {
                $features[$tf->feature] = (bool)$tf->enabled;
            }

            $sub = [
                'sub_id'         => (int)$row['sub_id'],
                'plan_id'        => $plan_id,
                'plan_name'      => $row['plan_name'] ?? null,
                'price'          => (float)($row['price'] ?? 0),
                'status'         => $row['sub_status'] ?? null,
                'start_date'     => $row['start_date'] ?? null,
                'end_date'       => $row['end_date'] ?? null,
                'grace_end_date' => $row['grace_end_date'] ?? null,
                'features'       => $features,
                'max_tables'     => (int)($row['max_tables'] ?? 0),
                'max_users'      => (int)($row['max_users'] ?? 0),
            ];
        }
        return [
            'client_id'      => (int)$row['tenant_id'],
            'business_name'  => $row['business_name'],
            'email'          => $row['email'],
            'phone'          => $row['phone'] ?? '',
            'country'        => $row['country'] ?? '',
            'city'           => $row['city'] ?? '',
            'address'        => $row['address'] ?? '',
            'website'        => $row['website'] ?? '',
            'notes'          => $row['notes'] ?? '',
            'logo_url'       => $row['logo_url'] ?? null,
            'is_active'      => (bool)($row['is_active'] ?? true),
            'created_at'     => $row['created_at'],
            'terminal_count' => (int)($row['terminal_count'] ?? 0),
            'subscription'   => $sub,
            // Multi-tenant
            'slug'           => $row['slug'] ?? null,
            'db_name'        => $row['db_name'] ?? null,
            'custom_domain'  => $row['custom_domain'] ?? null,
            'tenant_status'  => $row['status'] ?? 'pending',
            'provisioned_at' => $row['provisioned_at'] ?? null,
            // Multi-site group
            'group_id'       => isset($row['group_id']) ? (int)$row['group_id'] : null,
            'is_primary'     => (bool)($row['is_primary'] ?? false),
            'group_name'     => $row['group_name'] ?? null,
        ];
    }

    // ── Ghost Login ───────────────────────────────────────────────────────

    /**
     * Génère un token ghost login valable 5 minutes pour un tenant.
     * Retourne le token généré.
     */
    public function create_ghost_token(int $tenant_id, int $admin_id): string {
        // Nettoyer les anciens tokens expirés ou utilisés
        $this->db->where('tenant_id', $tenant_id)
                 ->group_start()
                     ->where('expires_at <', date('Y-m-d H:i:s'))
                     ->or_where('used', 1)
                 ->group_end()
                 ->delete('saas_ghost_tokens');

        $token = bin2hex(random_bytes(32)); // 64 chars hex, cryptographiquement sûr
        $this->db->insert('saas_ghost_tokens', [
            'tenant_id'  => $tenant_id,
            'token'      => $token,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+5 minutes')),
            'created_by' => $admin_id,
        ]);
        return $token;
    }

    /**
     * Valide et consomme un token ghost login.
     * Retourne le tenant_id si valide, null sinon.
     */
    public function consume_ghost_token(string $token): ?int {
        $row = $this->db
            ->where('token', $token)
            ->where('used', 0)
            ->where('expires_at >', date('Y-m-d H:i:s'))
            ->get('saas_ghost_tokens')->row();

        if (!$row) return null;

        $this->db->where('id', $row->id)->update('saas_ghost_tokens', [
            'used'    => 1,
            'used_at' => date('Y-m-d H:i:s'),
        ]);

        return (int)$row->tenant_id;
    }

    // ── Usage Statistics ──────────────────────────────────────────────────

    public function get_usage_stats(): array {
        // Terminal counts by status
        $by_status = $this->db->select('status, COUNT(*) as count')->group_by('status')->get('saas_terminals')->result_array();
        $status_map = array_column($by_status, 'count', 'status');

        // Terminal counts by type
        $by_type = $this->db->select('type, COUNT(*) as count')->group_by('type')->get('saas_terminals')->result_array();

        // Total and online
        $total_terminals = (int)$this->db->count_all('saas_terminals');
        $online = (int)($status_map['online'] ?? 0);
        $degraded = (int)($status_map['degraded'] ?? 0);
        $offline = (int)($status_map['offline'] ?? 0);

        // Revenue by month (last 6 months) from saas_payments
        $revenue_by_month = [];
        for ($i = 5; $i >= 0; $i--) {
            $start = date('Y-m-01', strtotime("-$i months"));
            $end   = date('Y-m-t',  strtotime("-$i months"));
            $month = date('M Y',    strtotime("-$i months"));
            $rev = (float)($this->db->select('SUM(amount) as rev')->from('saas_payments')
                ->where('status', 'paid')->where('created_at >=', $start)->where('created_at <=', $end . ' 23:59:59')
                ->get()->row()->rev ?? 0);
            $revenue_by_month[] = ['month' => $month, 'revenue' => $rev];
        }

        // Total revenue all time
        $total_revenue = (float)($this->db->select('SUM(amount) as rev')->from('saas_payments')->where('status', 'paid')->get()->row()->rev ?? 0);

        // Revenue this month
        $month_start = date('Y-m-01');
        $revenue_month = (float)($this->db->select('SUM(amount) as rev')->from('saas_payments')
            ->where('status', 'paid')->where('created_at >=', $month_start)->get()->row()->rev ?? 0);

        // Revenue last month
        $lm_start = date('Y-m-01', strtotime('-1 month'));
        $lm_end   = date('Y-m-t',  strtotime('-1 month'));
        $revenue_prev = (float)($this->db->select('SUM(amount) as rev')->from('saas_payments')
            ->where('status', 'paid')->where('created_at >=', $lm_start)->where('created_at <=', $lm_end . ' 23:59:59')
            ->get()->row()->rev ?? 0);

        // Avg uptime_pct across active terminals
        $avg_uptime = (float)($this->db->select('AVG(uptime_pct) as avg_up')->where('is_active', 1)->get('saas_terminals')->row()->avg_up ?? 0);

        return [
            'total_terminals'  => $total_terminals,
            'online_terminals' => $online,
            'degraded'         => $degraded,
            'offline'          => $offline,
            'by_type'          => $by_type,
            'avg_uptime'       => round($avg_uptime, 1),
            'revenue_month'    => $revenue_month,
            'revenue_prev'     => $revenue_prev,
            'total_revenue'    => $total_revenue,
            'revenue_by_month' => $revenue_by_month,
        ];
    }

    public function get_top_restaurants(int $days = 30): array {
        $since = date('Y-m-d', strtotime("-{$days} days"));
        $rows = $this->db
            ->select('t.tenant_id, t.business_name, t.country,
                      COUNT(DISTINCT p.payment_id) as transactions,
                      COALESCE(SUM(p.amount), 0) as revenue,
                      (SELECT COUNT(*) FROM saas_terminals tm WHERE tm.tenant_id = t.tenant_id) as terminal_count')
            ->from('saas_tenants t')
            ->join('saas_invoices i', 'i.tenant_id = t.tenant_id', 'left')
            ->join('saas_payments p', 'p.invoice_id = i.invoice_id AND p.status = "paid" AND p.created_at >= "' . $since . '"', 'left')
            ->group_by('t.tenant_id')
            ->order_by('revenue', 'DESC')
            ->limit(10)
            ->get()->result_array();

        return array_map(function($r) {
            $words = explode(' ', $r['business_name']);
            $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
            return [
                'tenant_id'      => (int)$r['tenant_id'],
                'name'           => $r['business_name'],
                'city'           => $r['country'] ?: '',
                'initials'       => $initials,
                'transactions'   => (int)$r['transactions'],
                'revenue'        => (float)$r['revenue'],
                'terminal_count' => (int)($r['terminal_count'] ?? 0),
            ];
        }, $rows);
    }

    public function get_device_breakdown(): array {
        $rows = $this->db
            ->select('type, COUNT(*) as count')
            ->from('saas_terminals')
            ->group_by('type')
            ->get()->result_array();

        $total = array_sum(array_column($rows, 'count'));
        return array_map(function($r) use ($total) {
            return [
                'type'  => $r['type'],
                'count' => (int)$r['count'],
                'pct'   => $total > 0 ? round(((int)$r['count'] / $total) * 100) : 0,
            ];
        }, $rows);
    }

    public function get_terminals_list(): array {
        return $this->db
            ->select('tm.*, t.business_name')
            ->from('saas_terminals tm')
            ->join('saas_tenants t', 't.tenant_id = tm.tenant_id', 'left')
            ->order_by('FIELD(tm.status, "online", "degraded", "offline")', 'ASC', FALSE)
            ->order_by('tm.last_ping_at', 'DESC')
            ->get()->result_array();
    }

    // ── Forecasts / Prévisions ────────────────────────────────────────────

    public function get_forecasts(): array {
        // Current MRR
        $mrr = (float)($this->db
            ->select('SUM(p.price) as mrr')
            ->from('saas_subscriptions s')
            ->join('saas_plans p', 'p.plan_id = s.plan_id')
            ->where('s.status', 'active')
            ->get()->row()->mrr ?? 0);

        // Churn rate (last 30 days)
        $thirty_ago = date('Y-m-d', strtotime('-30 days'));
        $active_subs = (int)$this->db->where('status', 'active')->count_all_results('saas_subscriptions');
        $churned = (int)$this->db
            ->where_in('status', ['expired', 'suspended'])
            ->where('end_date >=', $thirty_ago)
            ->count_all_results('saas_subscriptions');
        $churn_rate = ($active_subs + $churned) > 0
            ? round(($churned / ($active_subs + $churned)) * 100, 1) : 0;

        // New clients per month (avg over last 3 months)
        $three_months_ago = date('Y-m-d', strtotime('-3 months'));
        $new_clients_3m = (int)$this->db
            ->where('created_at >=', $three_months_ago)
            ->count_all_results('saas_tenants');
        $new_per_month = round($new_clients_3m / 3);

        // MRR by month (last 6 months actual)
        $mrr_history = [];
        for ($i = 5; $i >= 0; $i--) {
            $m_start = date('Y-m-01', strtotime("-$i months"));
            $m_end   = date('Y-m-t',  strtotime("-$i months"));
            $m_label = date('M', strtotime("-$i months"));
            $m_mrr   = (float)($this->db
                ->select('SUM(p.price) as mrr')
                ->from('saas_subscriptions s')
                ->join('saas_plans p', 'p.plan_id = s.plan_id')
                ->where_in('s.status', ['active', 'expired', 'suspended'])
                ->where('s.start_date <=', $m_end)
                ->where('s.end_date >=', $m_start)
                ->get()->row()->mrr ?? 0);
            $mrr_history[] = ['month' => $m_label, 'mrr' => $m_mrr];
        }

        // Simple linear projection: avg monthly growth from history
        $growth_rates = [];
        for ($i = 1; $i < count($mrr_history); $i++) {
            $prev = $mrr_history[$i - 1]['mrr'];
            if ($prev > 0) {
                $growth_rates[] = ($mrr_history[$i]['mrr'] - $prev) / $prev;
            }
        }
        $avg_growth = count($growth_rates) > 0 ? array_sum($growth_rates) / count($growth_rates) : 0.05;

        // Project next 12 months
        $projected = [];
        $current = $mrr;
        for ($i = 1; $i <= 12; $i++) {
            $m_label = date('M', strtotime("+$i months"));
            $optimistic  = $current * pow(1 + $avg_growth * 1.5, $i);
            $realistic   = $current * pow(1 + $avg_growth, $i);
            $pessimistic = $current * pow(1 + max($avg_growth * 0.3, -0.02), $i);
            $projected[] = [
                'month'       => $m_label,
                'optimistic'  => round($optimistic),
                'realistic'   => round($realistic),
                'pessimistic' => round($pessimistic),
            ];
        }

        // Expiring within 30 days
        $expiring_30 = (int)$this->db
            ->where('status', 'active')
            ->where('end_date <=', date('Y-m-d', strtotime('+30 days')))
            ->where('end_date >=', date('Y-m-d'))
            ->count_all_results('saas_subscriptions');

        $expiring_value = (float)($this->db
            ->select('SUM(p.price) as val')
            ->from('saas_subscriptions s')
            ->join('saas_plans p', 'p.plan_id = s.plan_id')
            ->where('s.status', 'active')
            ->where('s.end_date <=', date('Y-m-d', strtotime('+30 days')))
            ->where('s.end_date >=', date('Y-m-d'))
            ->get()->row()->val ?? 0);

        // Failed payments unresolved
        $failed_payments = (int)$this->db
            ->where('status', 'failed')
            ->count_all_results('saas_payments');

        $failed_value = (float)($this->db
            ->select('SUM(amount) as val')
            ->from('saas_payments')
            ->where('status', 'failed')
            ->get()->row()->val ?? 0);

        // Inactive clients (no payment in 30 days with active sub)
        $inactive_clients = (int)$this->db
            ->select('COUNT(DISTINCT t.tenant_id) as cnt')
            ->from('saas_tenants t')
            ->join('saas_subscriptions s', 's.tenant_id = t.tenant_id AND s.status = "active"')
            ->where('t.tenant_id NOT IN (SELECT DISTINCT py.tenant_id FROM saas_payments py WHERE py.status = "paid" AND py.created_at >= "' . $thirty_ago . '")', NULL, FALSE)
            ->get()->row()->cnt;

        return [
            'mrr'              => $mrr,
            'churn_rate'       => $churn_rate,
            'new_per_month'    => $new_per_month,
            'avg_growth'       => round($avg_growth * 100, 1),
            'mrr_history'      => $mrr_history,
            'projected'        => $projected,
            'scenarios'        => [
                'optimistic'  => round($mrr * pow(1 + $avg_growth * 1.5, 12)),
                'realistic'   => round($mrr * pow(1 + $avg_growth, 12)),
                'pessimistic' => round($mrr * pow(1 + max($avg_growth * 0.3, -0.02), 12)),
            ],
        ];
    }

    public function get_forecast_risks(): array {
        $thirty_ago = date('Y-m-d', strtotime('-30 days'));

        $expiring_30 = (int)$this->db
            ->where('status', 'active')
            ->where('end_date <=', date('Y-m-d', strtotime('+30 days')))
            ->where('end_date >=', date('Y-m-d'))
            ->count_all_results('saas_subscriptions');

        $expiring_value = (float)($this->db
            ->select('SUM(p.price) as val')
            ->from('saas_subscriptions s')
            ->join('saas_plans p', 'p.plan_id = s.plan_id')
            ->where('s.status', 'active')
            ->where('s.end_date <=', date('Y-m-d', strtotime('+30 days')))
            ->where('s.end_date >=', date('Y-m-d'))
            ->get()->row()->val ?? 0);

        $failed_payments = (int)$this->db
            ->where('status', 'failed')
            ->count_all_results('saas_payments');

        $failed_value = (float)($this->db
            ->select('SUM(amount) as val')
            ->from('saas_payments')
            ->where('status', 'failed')
            ->get()->row()->val ?? 0);

        $inactive = (int)$this->db
            ->select('COUNT(DISTINCT t.tenant_id) as cnt')
            ->from('saas_tenants t')
            ->join('saas_subscriptions s', 's.tenant_id = t.tenant_id AND s.status = "active"')
            ->where('t.tenant_id NOT IN (SELECT DISTINCT py.tenant_id FROM saas_payments py WHERE py.status = "paid" AND py.created_at >= "' . $thirty_ago . '")', NULL, FALSE)
            ->get()->row()->cnt;

        return [
            'expiring_30_count' => $expiring_30,
            'expiring_30_value' => $expiring_value,
            'failed_payments'   => $failed_payments,
            'failed_value'      => $failed_value,
            'inactive_clients'  => $inactive,
        ];
    }

    // ── White-Label ───────────────────────────────────────────────────────

    public function get_white_label_clients(): array {
        // Get all Enterprise plan tenants
        $rows = $this->db
            ->select('t.tenant_id, t.business_name, t.logo_url, p.plan_name,
                      wl.primary_color, wl.secondary_color, wl.display_name,
                      wl.receipt_text, wl.hide_bonresto_logo, wl.logo_url as wl_logo')
            ->from('saas_tenants t')
            ->join('saas_subscriptions s', 's.tenant_id = t.tenant_id AND s.status = "active"')
            ->join('saas_plans p', 'p.plan_id = s.plan_id')
            ->join('saas_white_label wl', 'wl.tenant_id = t.tenant_id', 'left')
            ->where('p.plan_name', 'Enterprise')
            ->group_by('t.tenant_id')
            ->order_by('t.business_name', 'ASC')
            ->get()->result_array();

        return array_map(function($r) {
            $words = explode(' ', $r['business_name']);
            $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
            $custom = !empty($r['primary_color']) || !empty($r['display_name']);
            return [
                'id'                => (int)$r['tenant_id'],
                'name'              => $r['business_name'],
                'initials'          => $initials,
                'plan'              => $r['plan_name'],
                'custom'            => $custom,
                'primary_color'     => $r['primary_color'] ?: '#dc2626',
                'secondary_color'   => $r['secondary_color'] ?: '#fecaca',
                'display_name'      => $r['display_name'] ?: '',
                'receipt_text'      => $r['receipt_text'] ?: '',
                'hide_bonresto_logo'=> (bool)($r['hide_bonresto_logo'] ?? false),
                'logo_url'          => $r['wl_logo'] ?: $r['logo_url'],
            ];
        }, $rows);
    }

    public function get_white_label_client(int $tenant_id): ?array {
        $row = $this->db
            ->select('t.tenant_id, t.business_name, t.logo_url, p.plan_name,
                      wl.primary_color, wl.secondary_color, wl.display_name,
                      wl.receipt_text, wl.hide_bonresto_logo, wl.logo_url as wl_logo')
            ->from('saas_tenants t')
            ->join('saas_subscriptions s', 's.tenant_id = t.tenant_id AND s.status = "active"', 'left')
            ->join('saas_plans p', 'p.plan_id = s.plan_id', 'left')
            ->join('saas_white_label wl', 'wl.tenant_id = t.tenant_id', 'left')
            ->where('t.tenant_id', $tenant_id)
            ->get()->row_array();

        if (!$row) return null;

        $words = explode(' ', $row['business_name']);
        $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
        $custom = !empty($row['primary_color']) || !empty($row['display_name']);
        return [
            'id'                => (int)$row['tenant_id'],
            'name'              => $row['business_name'],
            'initials'          => $initials,
            'plan'              => $row['plan_name'] ?? 'N/A',
            'custom'            => $custom,
            'primary_color'     => $row['primary_color'] ?: '#dc2626',
            'secondary_color'   => $row['secondary_color'] ?: '#fecaca',
            'display_name'      => $row['display_name'] ?: '',
            'receipt_text'      => $row['receipt_text'] ?: '',
            'hide_bonresto_logo'=> (bool)($row['hide_bonresto_logo'] ?? false),
            'logo_url'          => $row['wl_logo'] ?: $row['logo_url'],
        ];
    }

    // ── Multi-tenant Provisioning ──────────────────────────────────────────

    /**
     * Génère un slug unique à partir du nom du restaurant.
     * ex: "Le Petit Bistro" → "lepetitbistro"
     */
    public function generate_slug(string $name): string {
        $slug = strtolower($name);
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $slug);
        $slug = preg_replace('/[^a-z0-9]+/', '', $slug);
        $slug = trim($slug, '-');
        $slug = substr($slug, 0, 30);

        // Garantir l'unicité
        $base  = $slug;
        $i     = 1;
        while ($this->db->where('slug', $slug)->count_all_results('saas_tenants') > 0) {
            $slug = $base . $i++;
        }
        return $slug;
    }

    /**
     * Provisionne une nouvelle DB pour un tenant.
     * Crée la base, joue install.sql, crée le compte admin POS.
     *
     * @param  int    $tenant_id
     * @param  string $admin_email    Email du propriétaire du restaurant
     * @param  string $admin_password Mot de passe en clair (envoyé par email puis hashé)
     * @return array  ['success'=>bool, 'message'=>string, 'db_name'=>string, 'slug'=>string]
     */
    public function provision_new_tenant(int $tenant_id, string $admin_email, string $admin_password): array {
        // Récupérer le tenant
        $tenant = $this->db->where('tenant_id', $tenant_id)->get('saas_tenants')->row_array();
        if (!$tenant) return ['success' => false, 'message' => 'Tenant introuvable.'];

        // Bloquer le re-provisioning
        if (in_array($tenant['status'], ['active', 'provisioning']) && !empty($tenant['db_name'])) {
            return ['success' => false, 'message' => 'Ce restaurant est déjà provisionné (DB: ' . $tenant['db_name'] . ').'];
        }

        $slug    = $this->generate_slug($tenant['business_name']);
        $db_name = 'resto_' . $tenant_id;
        $db_host = $this->db->hostname ?? 'localhost';
        $db_user = env_required('DB_USER');      // Audit F-01 : plus d'identifiants en dur
        $db_pass = env_required('DB_PASSWORD');

        // Marquer en cours
        $this->db->where('tenant_id', $tenant_id)->update('saas_tenants', [
            'status' => 'provisioning', 'slug' => $slug, 'db_name' => $db_name,
        ]);

        try {
            // 1. Connexion MySQL sans DB sélectionnée
            $conn = new mysqli($db_host, $db_user, $db_pass);
            if ($conn->connect_error) throw new Exception('MySQL connexion: ' . $conn->connect_error);

            // 2. Créer la base
            $conn->query("CREATE DATABASE IF NOT EXISTS `{$db_name}` CHARACTER SET utf8 COLLATE utf8_general_ci");
            $conn->select_db($db_name);

            // 3. Jouer install.sql
            $sql_file = FCPATH . 'install/sql/install.sql';
            if (!file_exists($sql_file)) throw new Exception('install.sql introuvable: ' . $sql_file);

            $sql = file_get_contents($sql_file);
            // Supprimer les commentaires de tête et les instructions SET problématiques
            $sql = preg_replace('/^--.*$/m', '', $sql);
            $sql = str_replace('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";', '', $sql);

            $conn->multi_query($sql);
            // Vider tous les result sets
            do { $conn->use_result(); } while ($conn->more_results() && $conn->next_result());

            // Audit F-11 : install/sql/install.sql declare user.password en
            // varchar(32) — la taille d'un MD5. Chaque base de tenant naissait
            // donc trop etroite pour bcrypt (60 caracteres), et l'ecriture y
            // aurait ete tronquee en silence (mode strict desactive, F-13).
            // On elargit ici plutot que dans install.sql, hors perimetre.
            $conn->query("ALTER TABLE `user` MODIFY `password` VARCHAR(255) NOT NULL");

            // 4. Creer le compte admin POS.
            //
            // Ce compte etait volontairement laisse en MD5 tant que tout
            // l'applicatif restaurant verifiait en MD5 : le passer a bcrypt
            // seul aurait empeche le restaurateur d'entrer dans sa caisse.
            // Ce n'est plus le cas — tous les points de verification
            // (Auth_model, Home_model, Api_*, App_*, Hungry_model, Setting)
            // acceptent desormais les deux formats.
            $hashed = Saas_password::hacher($admin_password);
            $name   = $conn->real_escape_string($tenant['business_name']);
            $email  = $conn->real_escape_string($admin_email);

            // Vérifier si user existe déjà (seed data)
            $res = $conn->query("SELECT id FROM user WHERE is_admin=1 LIMIT 1");
            if ($res && $res->num_rows > 0) {
                $row = $res->fetch_assoc();
                $conn->query("UPDATE user SET email='{$email}', password='{$hashed}', status=1 WHERE id={$row['id']}");
            } else {
                $conn->query("INSERT INTO user (email, password, status, is_admin) VALUES ('{$email}', '{$hashed}', 1, 1)");
            }

            // 5. Configurer le nom du restaurant dans setting
            $conn->query("UPDATE setting SET storename='{$name}', title='{$name}' WHERE id=(SELECT MIN(id) FROM (SELECT id FROM setting) t)");

            $conn->close();

            // 6. Mettre à jour saas_tenants
            $this->db->where('tenant_id', $tenant_id)->update('saas_tenants', [
                'status'        => 'active',
                'slug'          => $slug,
                'db_name'       => $db_name,
                'db_user'       => $db_user,
                'admin_email'   => $admin_email,
                // `admin_pass_raw` n'est PLUS enregistre.
                //
                // Il conservait en clair le mot de passe d'administration de
                // chaque restaurant, et `get_tenant()` faisant `SELECT t.*`,
                // il repartait dans la reponse de GET /saas/clients/{id} :
                // sur le reseau, dans le navigateur, et lisible par tout
                // administrateur SaaS, y compris les roles finance et support
                // qui n'en ont aucun usage. Une fuite de la base SaaS donnait
                // la caisse de tous les clients d'un coup.
                //
                // Le mot de passe est desormais renvoye UNE SEULE FOIS, dans
                // la reponse de ce provisionnement, pour que l'integrateur le
                // transmette au restaurateur. Perdu, il se reinitialise ; il
                // ne se retrouve pas.
                'admin_pass_raw'=> null,
                'provisioned_at'=> date('Y-m-d H:i:s'),
                'is_active'     => 1,
            ]);

            return [
                'success'        => true,
                'db_name'        => $db_name,
                'slug'           => $slug,
                'admin_email'    => $admin_email,
                'admin_password' => $admin_password,
                'avertissement'  => 'Ce mot de passe n\'est pas conserve. '
                                  . 'Transmettez-le au restaurateur maintenant : '
                                  . 'il ne sera plus jamais affiche.',
                'message'        => 'Provisioning réussi.',
            ];

        } catch (Exception $e) {
            log_message('error', 'Provisioning failed for tenant ' . $tenant_id . ': ' . $e->getMessage());
            $this->db->where('tenant_id', $tenant_id)->update('saas_tenants', ['status' => 'failed']);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Retourne les infos de connexion DB d'un tenant via son slug.
     */
    public function get_tenant_by_slug(string $slug): ?array {
        $row = $this->db->where('slug', $slug)
                        ->where('status', 'active')
                        ->get('saas_tenants')->row_array();
        return $row ?: null;
    }

    // ── Multi-Site Groups ─────────────────────────────────────────────────

    public function get_all_groups(): array {
        $groups = $this->db
            ->select('g.*, (SELECT COUNT(*) FROM saas_tenants t WHERE t.group_id = g.group_id) as outlet_count')
            ->from('saas_groups g')
            ->order_by('g.created_at', 'DESC')
            ->get()->result_array();

        foreach ($groups as &$g) {
            $g['group_id']     = (int)$g['group_id'];
            $g['max_outlets']  = (int)$g['max_outlets'];
            $g['outlet_count'] = (int)$g['outlet_count'];
            $g['is_active']    = (bool)$g['is_active'];
            $g['subscription'] = $this->get_group_subscription($g['group_id']);
        }
        return $groups;
    }

    public function get_group(int $group_id): ?array {
        $g = $this->db
            ->select('g.*, (SELECT COUNT(*) FROM saas_tenants t WHERE t.group_id = g.group_id) as outlet_count')
            ->from('saas_groups g')
            ->where('g.group_id', $group_id)
            ->get()->row_array();

        if (!$g) return null;

        $g['group_id']     = (int)$g['group_id'];
        $g['max_outlets']  = (int)$g['max_outlets'];
        $g['outlet_count'] = (int)$g['outlet_count'];
        $g['is_active']    = (bool)$g['is_active'];
        $g['subscription'] = $this->get_group_subscription($group_id);
        $g['outlets']      = $this->get_tenants_by_group($group_id);
        return $g;
    }

    public function get_tenants_by_group(int $group_id): array {
        $tenants = $this->db
            ->select('t.*, g.group_name, s.sub_id, s.status as sub_status, s.end_date, s.grace_end_date, p.plan_name, p.plan_id, p.price, (SELECT COUNT(*) FROM saas_terminals tm WHERE tm.tenant_id = t.tenant_id) as terminal_count')
            ->from('saas_tenants t')
            ->join('saas_groups g', 'g.group_id = t.group_id', 'left')
            ->join('saas_subscriptions s', 's.tenant_id = t.tenant_id AND s.sub_id = (SELECT MAX(sub_id) FROM saas_subscriptions WHERE tenant_id = t.tenant_id)', 'left')
            ->join('saas_plans p', 'p.plan_id = s.plan_id', 'left')
            ->where('t.group_id', $group_id)
            ->order_by('t.is_primary', 'DESC')
            ->order_by('t.business_name', 'ASC')
            ->get()->result_array();

        return array_map([$this, '_format_tenant'], $tenants);
    }

    public function create_group(array $data): int {
        $this->db->insert('saas_groups', [
            'group_name'    => $data['group_name'],
            'owner_email'   => $data['owner_email'],
            'owner_phone'   => $data['owner_phone'] ?? null,
            'contact_name'  => $data['contact_name'] ?? null,
            'country'       => $data['country'] ?? null,
            'city'          => $data['city'] ?? null,
            'address'       => $data['address'] ?? null,
            'billing_model' => $data['billing_model'] ?? 'per_outlet',
            'max_outlets'   => (int)($data['max_outlets'] ?? 0),
            'created_at'    => date('Y-m-d H:i:s'),
        ]);
        return $this->db->insert_id();
    }

    public function update_group(int $group_id, array $data): void {
        $allowed = ['group_name', 'owner_email', 'owner_phone', 'contact_name',
                     'country', 'city', 'address', 'billing_model', 'max_outlets', 'notes', 'logo_url'];
        $update  = array_intersect_key($data, array_flip($allowed));
        if ($update) {
            $this->db->where('group_id', $group_id)->update('saas_groups', $update);
        }
    }

    public function delete_group(int $group_id): void {
        // Détacher tous les tenants du groupe
        $this->db->where('group_id', $group_id)
                 ->update('saas_tenants', ['group_id' => null, 'is_primary' => 0]);
        // Expirer les abonnements groupe
        $this->db->where('group_id', $group_id)
                 ->where('status', 'active')
                 ->update('saas_group_subscriptions', ['status' => 'expired']);
        // Supprimer le groupe
        $this->db->where('group_id', $group_id)->delete('saas_groups');
    }

    public function assign_tenant_to_group(int $tenant_id, int $group_id, bool $is_primary = false): bool {
        $group = $this->db->where('group_id', $group_id)->get('saas_groups')->row();
        if (!$group) return false;

        // Vérifier la limite d'outlets
        if ($group->max_outlets > 0) {
            $current = $this->db->where('group_id', $group_id)->count_all_results('saas_tenants');
            if ($current >= $group->max_outlets) return false;
        }

        // Si is_primary, retirer le flag des autres
        if ($is_primary) {
            $this->db->where('group_id', $group_id)
                     ->update('saas_tenants', ['is_primary' => 0]);
        }

        $this->db->where('tenant_id', $tenant_id)
                 ->update('saas_tenants', [
                     'group_id'   => $group_id,
                     'is_primary' => (int)$is_primary,
                 ]);

        // Si billing_model = 'group', invalider la licence du tenant
        if ($group->billing_model === 'group') {
            $this->db->where('tenant_id', $tenant_id)
                     ->update('saas_tenants', ['license_invalidated_at' => date('Y-m-d H:i:s')]);
        }

        return true;
    }

    public function remove_tenant_from_group(int $tenant_id): void {
        $this->db->where('tenant_id', $tenant_id)
                 ->update('saas_tenants', [
                     'group_id'               => null,
                     'is_primary'             => 0,
                     'license_invalidated_at' => date('Y-m-d H:i:s'),
                 ]);
    }

    // ── Group Subscriptions ───────────────────────────────────────────────

    public function get_group_subscription(int $group_id): ?array {
        $row = $this->db
            ->select('gs.*, p.plan_name, p.price, p.max_tables, p.max_users')
            ->from('saas_group_subscriptions gs')
            ->join('saas_plans p', 'p.plan_id = gs.plan_id')
            ->where('gs.group_id', $group_id)
            ->where_in('gs.status', ['active', 'grace'])
            ->order_by('gs.gsub_id', 'DESC')
            ->limit(1)
            ->get()->row_array();

        if (!$row) return null;
        return [
            'gsub_id'        => (int)$row['gsub_id'],
            'plan_id'        => (int)$row['plan_id'],
            'plan_name'      => $row['plan_name'],
            'price'          => (float)$row['price'],
            'status'         => $row['status'],
            'max_outlets'    => (int)$row['max_outlets'],
            'start_date'     => $row['start_date'],
            'end_date'       => $row['end_date'],
            'grace_end_date' => $row['grace_end_date'],
            'max_tables'     => (int)$row['max_tables'],
            'max_users'      => (int)$row['max_users'],
        ];
    }

    public function create_group_subscription(int $group_id, int $plan_id, string $end_date, int $max_outlets = 0): void {
        $grace = date('Y-m-d', strtotime($end_date . ' +7 days'));

        // Expirer les anciens abonnements actifs du groupe
        $this->db->where('group_id', $group_id)
                 ->where('status', 'active')
                 ->update('saas_group_subscriptions', ['status' => 'expired']);

        $this->db->insert('saas_group_subscriptions', [
            'group_id'       => $group_id,
            'plan_id'        => $plan_id,
            'status'         => 'active',
            'max_outlets'    => $max_outlets,
            'start_date'     => date('Y-m-d'),
            'end_date'       => $end_date,
            'grace_end_date' => $grace,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        // Invalider la licence de tous les tenants du groupe
        $this->db->where('group_id', $group_id)
                 ->update('saas_tenants', ['license_invalidated_at' => date('Y-m-d H:i:s')]);
    }

    /**
     * Retourne l'abonnement effectif d'un tenant :
     * - Si le tenant est dans un groupe avec billing_model='group' → abonnement du groupe
     * - Sinon → abonnement individuel du tenant
     */
    public function get_effective_subscription(int $tenant_id): ?array {
        $tenant = $this->db
            ->select('t.group_id, g.billing_model')
            ->from('saas_tenants t')
            ->join('saas_groups g', 'g.group_id = t.group_id', 'left')
            ->where('t.tenant_id', $tenant_id)
            ->get()->row();

        // Groupe avec facturation groupe → utiliser l'abonnement du groupe
        if ($tenant && $tenant->group_id && $tenant->billing_model === 'group') {
            $gsub = $this->get_group_subscription((int)$tenant->group_id);
            if ($gsub) {
                return [
                    'plan_id'        => $gsub['plan_id'],
                    'plan_name'      => $gsub['plan_name'],
                    'status'         => $gsub['status'],
                    'end_date'       => $gsub['end_date'],
                    'grace_end_date' => $gsub['grace_end_date'],
                    'max_tables'     => $gsub['max_tables'],
                    'max_users'      => $gsub['max_users'],
                    'source'         => 'group',
                ];
            }
        }

        // Abonnement individuel (comportement par défaut)
        $sub = $this->db
            ->select('s.*, p.plan_name, p.max_tables, p.max_users')
            ->from('saas_subscriptions s')
            ->join('saas_plans p', 'p.plan_id = s.plan_id')
            ->where('s.tenant_id', $tenant_id)
            ->order_by('s.sub_id', 'DESC')
            ->limit(1)
            ->get()->row_array();

        if (!$sub) return null;
        return [
            'plan_id'        => (int)$sub['plan_id'],
            'plan_name'      => $sub['plan_name'],
            'status'         => $sub['status'],
            'end_date'       => $sub['end_date'],
            'grace_end_date' => $sub['grace_end_date'],
            'max_tables'     => (int)$sub['max_tables'],
            'max_users'      => (int)$sub['max_users'],
            'source'         => 'individual',
        ];
    }

    // ── Group Invoices & Stats ────────────────────────────────────────────

    public function get_group_invoices(int $group_id): array {
        return $this->db
            ->select('i.*, t.business_name')
            ->from('saas_invoices i')
            ->join('saas_tenants t', 't.tenant_id = i.tenant_id', 'left')
            ->group_start()
                ->where('i.group_id', $group_id)
                ->or_where_in('i.tenant_id',
                    "(SELECT tenant_id FROM saas_tenants WHERE group_id = {$group_id})", false)
            ->group_end()
            ->order_by('i.created_at', 'DESC')
            ->get()->result_array();
    }

    public function group_stats(int $group_id): array {
        $outlets = $this->get_tenants_by_group($group_id);
        $total_terminals = 0;
        foreach ($outlets as $o) {
            $total_terminals += $o['terminal_count'];
        }

        $total_revenue = (float)($this->db
            ->select('SUM(amount) as rev')
            ->from('saas_payments')
            ->where('status', 'paid')
            ->where_in('tenant_id',
                "(SELECT tenant_id FROM saas_tenants WHERE group_id = {$group_id})", false)
            ->get()->row()->rev ?? 0);

        return [
            'outlet_count'    => count($outlets),
            'total_terminals' => $total_terminals,
            'total_revenue'   => $total_revenue,
        ];
    }

    /* ═══════════════ LEADS ═══════════════ */

    public function get_website_plans(): array {
        $rows = $this->db
            ->select('plan_id, plan_name, price, period, description, features')
            ->from('saas_plans')
            ->where('is_active', 1)
            ->where('show_on_website', 1)
            ->order_by('price', 'ASC')
            ->get()->result_array();

        foreach ($rows as &$r) {
            $r['plan_id'] = (int)$r['plan_id'];
            $r['price']   = (float)$r['price'];
            $r['features'] = json_decode($r['features'], true) ?: [];
        }
        return $rows;
    }

    public function create_lead(array $data): int {
        $this->db->insert('saas_leads', $data);
        return $this->db->insert_id();
    }

    public function get_leads(): array {
        return $this->db->order_by('created_at', 'DESC')->get('saas_leads')->result_array();
    }

    public function update_lead(int $lead_id, array $data): void {
        $this->db->where('lead_id', $lead_id)->update('saas_leads', $data);
    }

    // ── Website Visits / Analytics ─────────────────────────────────────────

    public function create_visit(array $data): int {
        $this->db->insert('saas_website_visits', $data);
        return $this->db->insert_id();
    }

    public function get_analytics(): array {
        $now   = date('Y-m-d H:i:s');
        $today = date('Y-m-d 00:00:00');
        $week  = date('Y-m-d 00:00:00', strtotime('-7 days'));
        $month = date('Y-m-d 00:00:00', strtotime('-30 days'));

        // Total views
        $total = (int) $this->db->count_all('saas_website_visits');

        // Today
        $views_today = (int) $this->db
            ->where('created_at >=', $today)
            ->count_all_results('saas_website_visits');

        // Unique today
        $unique_today = (int) $this->db
            ->select('COUNT(DISTINCT visitor_id) as cnt')
            ->where('created_at >=', $today)
            ->get('saas_website_visits')->row()->cnt;

        // This week
        $views_week = (int) $this->db
            ->where('created_at >=', $week)
            ->count_all_results('saas_website_visits');

        // This month
        $views_month = (int) $this->db
            ->where('created_at >=', $month)
            ->count_all_results('saas_website_visits');

        // Unique total
        $unique_total = (int) $this->db
            ->select('COUNT(DISTINCT visitor_id) as cnt')
            ->get('saas_website_visits')->row()->cnt;

        // Daily views (last 30 days)
        $daily = $this->db
            ->select("DATE(created_at) as day, COUNT(*) as views, COUNT(DISTINCT visitor_id) as visitors")
            ->where('created_at >=', $month)
            ->group_by('DATE(created_at)')
            ->order_by('day', 'ASC')
            ->get('saas_website_visits')
            ->result_array();

        // Top referrers (last 30 days)
        $referrers = $this->db
            ->select("referrer, COUNT(*) as views")
            ->where('created_at >=', $month)
            ->group_by('referrer')
            ->order_by('views', 'DESC')
            ->limit(10)
            ->get('saas_website_visits')
            ->result_array();

        // Top pages (last 30 days)
        $pages = $this->db
            ->select("page, COUNT(*) as views")
            ->where('created_at >=', $month)
            ->group_by('page')
            ->order_by('views', 'DESC')
            ->limit(10)
            ->get('saas_website_visits')
            ->result_array();

        return [
            'total'        => $total,
            'views_today'  => $views_today,
            'unique_today' => $unique_today,
            'views_week'   => $views_week,
            'views_month'  => $views_month,
            'unique_total' => $unique_total,
            'daily'        => $daily,
            'referrers'    => $referrers,
            'pages'        => $pages,
        ];
    }
}
