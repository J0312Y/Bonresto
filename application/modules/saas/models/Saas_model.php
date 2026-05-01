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
            ->select('t.*, s.sub_id, s.status as sub_status, s.end_date, s.grace_end_date, p.plan_name, p.plan_id')
            ->from('saas_tenants t')
            ->join('saas_subscriptions s', 's.tenant_id = t.tenant_id AND s.sub_id = (SELECT MAX(sub_id) FROM saas_subscriptions WHERE tenant_id = t.tenant_id)', 'left')
            ->join('saas_plans p', 'p.plan_id = s.plan_id', 'left')
            ->order_by('t.created_at', 'DESC')
            ->get()->result_array();

        return array_map([$this, '_format_tenant'], $tenants);
    }

    public function get_tenant(int $id): ?array {
        $row = $this->db
            ->select('t.*, s.sub_id, s.status as sub_status, s.start_date, s.end_date, s.grace_end_date, p.plan_name, p.plan_id, p.features, p.max_tables, p.max_users')
            ->from('saas_tenants t')
            ->join('saas_subscriptions s', 's.tenant_id = t.tenant_id AND s.sub_id = (SELECT MAX(sub_id) FROM saas_subscriptions WHERE tenant_id = t.tenant_id)', 'left')
            ->join('saas_plans p', 'p.plan_id = s.plan_id', 'left')
            ->where('t.tenant_id', $id)
            ->get()->row_array();

        return $row ? $this->_format_tenant($row) : null;
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
            'created_at'    => date('Y-m-d H:i:s'),
        ]);
        return $this->db->insert_id();
    }

    public function update_tenant(int $tenant_id, array $data): void {
        $allowed = ['business_name', 'email', 'phone', 'country', 'city', 'address', 'website', 'notes'];
        $update  = array_intersect_key($data, array_flip($allowed));
        if ($update) {
            $this->db->where('tenant_id', $tenant_id)->update('saas_tenants', $update);
        }
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
                 ->update('saas_tenants', ['is_active' => 0]);
    }

    public function reactivate_tenant(int $tenant_id): void {
        $this->db->where('tenant_id', $tenant_id)
                 ->where('status', 'suspended')
                 ->update('saas_subscriptions', ['status' => 'active']);
        $this->db->where('tenant_id', $tenant_id)
                 ->update('saas_tenants', ['is_active' => 1]);
    }

    public function update_admin_password(int $admin_id, string $hashed): void {
        $this->db->where('admin_id', $admin_id)->update('saas_admins', ['password' => $hashed]);
    }

    // ── Plans ─────────────────────────────────────────────────────────────

    public function get_all_plans(): array {
        return $this->db->where('is_active', 1)->get('saas_plans')->result_array();
    }

    public function create_plan(array $data): int {
        $this->db->insert('saas_plans', [
            'plan_name'  => $data['plan_name'],
            'price'      => $data['price'],
            'max_tables' => $data['max_tables'] ?? 0,
            'max_users'  => $data['max_users']  ?? 0,
            'features'   => json_encode($data['features'] ?? []),
        ]);
        return $this->db->insert_id();
    }

    public function update_plan(int $id, array $data): void {
        $allowed = ['plan_name', 'price', 'max_tables', 'max_users', 'features'];
        $update  = array_intersect_key($data, array_flip($allowed));
        if (isset($update['features']) && is_array($update['features'])) {
            $update['features'] = json_encode($update['features']);
        }
        if ($update) $this->db->where('plan_id', $id)->update('saas_plans', $update);
    }

    // ── Roles ─────────────────────────────────────────────────────────────

    public function get_all_roles(): array {
        return $this->db->order_by('is_system', 'DESC')
                        ->order_by('created_at', 'ASC')
                        ->get('saas_roles')->result();
    }

    public function get_role_by_name(string $name) {
        return $this->db->where('role_name', $name)->get('saas_roles')->row();
    }

    public function get_role_by_id(int $id) {
        return $this->db->where('role_id', $id)->get('saas_roles')->row();
    }

    public function role_name_exists(string $name, int $exclude_id = 0): bool {
        $q = $this->db->where('name', $name);
        if ($exclude_id > 0) $q = $q->where('role_id !=', $exclude_id);
        return $q->count_all_results('saas_roles') > 0;
    }

    public function create_role(array $data): int {
        $this->db->insert('saas_roles', [
            'name'        => $data['name'],
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
        return $this->db->select('admin_id, name, email, role, is_active, created_at')
                        ->get('saas_admins')->result_array();
    }

    public function create_admin(array $data): int {
        $this->db->insert('saas_admins', [
            'name'       => $data['name'],
            'email'      => $data['email'],
            'password'   => md5($data['password']),
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
            $update['password'] = md5($data['password']);
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

    // ── License Keys ─────────────────────────────────────────────────────

    public function get_all_licenses(): array {
        $sql = "
            SELECT
                k.*,
                t.business_name, t.email,
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
                        ->where('status', 'active')
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
            'protocol'    => $s['smtp_protocol']  ?? 'smtp',
            'smtp_host'   => $s['smtp_host']       ?? '',
            'smtp_port'   => (int)($s['smtp_port'] ?? 587),
            'smtp_crypto' => $s['smtp_crypto']     ?? 'tls',
            'smtp_user'   => $s['smtp_user']       ?? '',
            'smtp_pass'   => $s['smtp_pass']       ?? '',
            'from_email'  => $s['from_email']      ?? '',
            'from_name'   => $s['from_name']       ?? 'Bonresto SaaS',
            'charset'     => 'utf-8',
            'mailtype'    => 'html',
            'newline'     => "\r\n",
            'crlf'        => "\r\n",
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

    // ── Private helpers ───────────────────────────────────────────────────

    private function _format_tenant(array $row): array {
        $sub = null;
        if (!empty($row['sub_id'])) {
            $sub = [
                'sub_id'         => (int)$row['sub_id'],
                'plan_id'        => (int)($row['plan_id'] ?? 0),
                'plan_name'      => $row['plan_name'] ?? null,
                'status'         => $row['sub_status'] ?? null,
                'start_date'     => $row['start_date'] ?? null,
                'end_date'       => $row['end_date'] ?? null,
                'grace_end_date' => $row['grace_end_date'] ?? null,
                'features'       => isset($row['features']) ? json_decode($row['features'], true) : [],
                'max_tables'     => (int)($row['max_tables'] ?? 0),
                'max_users'      => (int)($row['max_users'] ?? 0),
            ];
        }
        return [
            'client_id'     => (int)$row['tenant_id'],
            'business_name' => $row['business_name'],
            'email'         => $row['email'],
            'phone'         => $row['phone'] ?? '',
            'country'       => $row['country'] ?? '',
            'city'          => $row['city'] ?? '',
            'address'       => $row['address'] ?? '',
            'website'       => $row['website'] ?? '',
            'notes'         => $row['notes'] ?? '',
            'logo_url'      => $row['logo_url'] ?? null,
            'is_active'     => (bool)($row['is_active'] ?? true),
            'created_at'    => $row['created_at'],
            'subscription'  => $sub,
        ];
    }
}
