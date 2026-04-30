<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/Saas_base.php';

/**
 * GET /saas/notifications
 * Returns real-time SaaS notifications for the admin dropdown.
 * Aggregates from activity log + computed alerts (expiring, failed updates).
 */
class Notifications extends Saas_base {

    public function index() {
        $this->require_auth();

        $notifications = [];

        // ── 1. Recent activity events (last 7 days) ───────────────────────
        $events = $this->db
            ->select('l.log_id, l.tenant_id, l.action, l.description, l.created_at, t.business_name, t.logo_url')
            ->from('saas_activity_log l')
            ->join('saas_tenants t', 't.tenant_id = l.tenant_id', 'left')
            ->where('l.created_at >=', date('Y-m-d H:i:s', strtotime('-7 days')))
            ->where_in('l.action', ['license_activated', 'tenant_created', 'subscription_updated', 'tenant_suspended'])
            ->order_by('l.created_at', 'DESC')
            ->limit(15)
            ->get()->result_array();

        foreach ($events as $e) {
            $icon = match($e['action']) {
                'license_activated'    => 'key',
                'tenant_created'       => 'user-plus',
                'subscription_updated' => 'refresh',
                'tenant_suspended'     => 'ban',
                default                => 'info',
            };
            $notifications[] = [
                'id'        => 'evt_' . $e['log_id'],
                'type'      => $e['action'],
                'icon'      => $icon,
                'color'     => $this->_color($e['action']),
                'title'     => $e['business_name'] ?? 'Client',
                'message'   => $e['description'],
                'link'      => '/clients/' . (int)$e['tenant_id'],
                'time'      => $e['created_at'],
                'logo_url'  => $e['logo_url'] ?: null,
                'read'      => false,
            ];
        }

        // ── 2. Subscriptions expiring in 7 days ──────────────────────────
        $expiring = $this->db
            ->select('s.tenant_id, s.end_date, t.business_name, t.logo_url')
            ->from('saas_subscriptions s')
            ->join('saas_tenants t', 't.tenant_id = s.tenant_id')
            ->where('s.status', 'active')
            ->where('s.end_date <=', date('Y-m-d', strtotime('+7 days')))
            ->where('s.end_date >=', date('Y-m-d'))
            ->get()->result_array();

        foreach ($expiring as $sub) {
            $days = (int)ceil((strtotime($sub['end_date']) - time()) / 86400);
            $notifications[] = [
                'id'       => 'exp_' . $sub['tenant_id'],
                'type'     => 'subscription_expiring',
                'icon'     => 'clock',
                'color'    => 'warning',
                'title'    => $sub['business_name'],
                'message'  => "Abonnement expire " . ($days <= 1 ? "demain" : "dans {$days} jours"),
                'link'     => '/clients/' . (int)$sub['tenant_id'],
                'time'     => $sub['end_date'] . ' 00:00:00',
                'logo_url' => $sub['logo_url'] ?: null,
                'read'     => false,
            ];
        }

        // ── 3. Subscriptions that genuinely expired in the last 3 days ──
        // end_date must be in the past (truly expired, not just replaced by a new plan)
        $expired = $this->db
            ->select('s.sub_id, s.tenant_id, s.end_date, t.business_name, t.logo_url')
            ->from('saas_subscriptions s')
            ->join('saas_tenants t', 't.tenant_id = s.tenant_id')
            ->where('s.status', 'expired')
            ->where('s.end_date <=', date('Y-m-d'))
            ->where('s.end_date >=', date('Y-m-d', strtotime('-3 days')))
            ->get()->result_array();

        // Deduplicate per tenant — keep only one notification per tenant
        $seen_expired = [];
        foreach ($expired as $sub) {
            $tid = (int)$sub['tenant_id'];
            if (isset($seen_expired[$tid])) continue;
            $seen_expired[$tid] = true;
            $notifications[] = [
                'id'       => 'expd_' . $tid,
                'type'     => 'subscription_expired',
                'icon'     => 'x-circle',
                'color'    => 'error',
                'title'    => $sub['business_name'],
                'message'  => 'Abonnement expiré',
                'link'     => '/clients/' . $tid,
                'time'     => $sub['end_date'] . ' 00:00:00',
                'logo_url' => $sub['logo_url'] ?: null,
                'read'     => false,
            ];
        }

        // ── 4. Failed update deliveries ───────────────────────────────────
        $failed = $this->db
            ->select('d.tenant_id, d.error_msg, d.applied_at, t.business_name, u.title as update_title')
            ->from('saas_update_deliveries d')
            ->join('saas_tenants t', 't.tenant_id = d.tenant_id')
            ->join('saas_updates u', 'u.update_id = d.update_id')
            ->where('d.status', 'failed')
            ->where('d.applied_at >=', date('Y-m-d H:i:s', strtotime('-7 days')))
            ->get()->result_array();

        foreach ($failed as $f) {
            $notifications[] = [
                'id'      => 'fail_' . $f['tenant_id'],
                'type'    => 'update_failed',
                'icon'    => 'alert-triangle',
                'color'   => 'error',
                'title'   => $f['business_name'],
                'message' => "Échec de l'update : " . ($f['update_title'] ?? ''),
                'link'    => '/clients/' . (int)$f['tenant_id'],
                'time'    => $f['applied_at'] ?? date('Y-m-d H:i:s'),
                'read'    => false,
            ];
        }

        // Sort all by time desc
        usort($notifications, fn($a, $b) => strtotime($b['time']) - strtotime($a['time']));

        $this->_json(array_values(array_slice($notifications, 0, 20)));
    }

    private function _color(string $action): string {
        return match($action) {
            'license_activated'    => 'success',
            'tenant_created'       => 'info',
            'subscription_updated' => 'brand',
            'tenant_suspended'     => 'error',
            default                => 'info',
        };
    }
}
