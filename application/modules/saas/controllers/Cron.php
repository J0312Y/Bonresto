<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/Saas_base.php';

/**
 * Cron — Automated SaaS maintenance tasks
 *
 * Protected by a secret key (SAAS_CRON_KEY env var or config).
 * Intended to be called via server cron job or a scheduled task:
 *
 *   curl -s "https://yourdomain.com/saas/cron/run?key=YOUR_SECRET"
 *
 * Or run daily via cPanel / Linux cron:
 *   0 8 * * * curl -s "http://localhost/bonresto/saas/cron/run?key=YOUR_SECRET"
 */
class Cron extends Saas_base {

    private string $secret;

    public function __construct() {
        parent::__construct();
        $this->config->load('saas_email');
        // Secret key: define SAAS_CRON_KEY as environment variable, or fall back to config
        $this->secret = getenv('SAAS_CRON_KEY') ?: ($this->config->item('saas_cron_key') ?: 'changeme-cron-secret');
    }

    /** GET /saas/cron/run?key=... */
    public function run() {
        $key = $this->input->get('key');
        if ($key !== $this->secret) {
            $this->output->set_status_header(403);
            exit('Forbidden');
        }

        $results = [
            'reminders_7d' => $this->_send_reminders(7),
            'reminders_1d' => $this->_send_reminders(1),
            'auto_suspend' => $this->_auto_suspend(),
            'ran_at'       => date('Y-m-d H:i:s'),
        ];

        log_message('info', 'SaaS cron ran: ' . json_encode($results));
        $this->_json($results);
    }

    // ── Private helpers ───────────────────────────────────────────────────

    /**
     * Send expiry reminder emails to tenants whose subscription expires
     * in exactly $days days (i.e., end_date = today + $days).
     */
    private function _send_reminders(int $days): array {
        $target_date = date('Y-m-d', strtotime("+{$days} days"));

        $subs = $this->db
            ->select('s.*, t.business_name, t.email, t.tenant_id, p.plan_name')
            ->from('saas_subscriptions s')
            ->join('saas_tenants t', 't.tenant_id = s.tenant_id')
            ->join('saas_plans p', 'p.plan_id = s.plan_id', 'left')
            ->where('s.status', 'active')
            ->where('s.end_date', $target_date)
            ->get()->result_array();

        $sent  = 0;
        $failed = 0;

        $this->load->library('saas_mailer');

        $today = date('Y-m-d');

        foreach ($subs as $row) {
            $tid = (int)$row['tenant_id'];

            // Deduplication: skip if a reminder was already sent today for this tenant+days
            $already_sent = $this->db
                ->where('tenant_id', $tid)
                ->where('action', 'reminder_sent')
                ->like('description', "({$days}j)", 'both')
                ->where('created_at >=', $today . ' 00:00:00')
                ->count_all_results('saas_activity_log') > 0;

            if ($already_sent) {
                log_message('info', "Reminder ({$days}d) already sent today for tenant {$tid}, skipping.");
                continue;
            }

            $tenant = [
                'tenant_id'     => $tid,
                'business_name' => $row['business_name'],
                'email'         => $row['email'],
            ];
            $subscription = [
                'plan_name' => $row['plan_name'] ?? '—',
                'end_date'  => $row['end_date'],
            ];

            try {
                if ($this->saas_mailer->send_expiry_reminder($tenant, $subscription, $days)) {
                    $sent++;
                    $this->Saas_model->log_activity(
                        $tid,
                        'reminder_sent',
                        "Rappel d'expiration envoyé ({$days}j)",
                        ['expires' => $target_date]
                    );
                } else {
                    $failed++;
                }
            } catch (Throwable $e) {
                $failed++;
                log_message('error', "Reminder ({$days}d) failed for tenant {$tid}: " . $e->getMessage());
            }
        }

        return ['target_date' => $target_date, 'sent' => $sent, 'failed' => $failed];
    }

    /**
     * Auto-suspend tenants whose subscriptions expired yesterday or earlier
     * and are still marked active.
     */
    private function _auto_suspend(): array {
        $today = date('Y-m-d');

        $expired = $this->db
            ->select('s.sub_id, s.tenant_id, t.business_name, t.email')
            ->from('saas_subscriptions s')
            ->join('saas_tenants t', 't.tenant_id = s.tenant_id')
            ->where('s.status', 'active')
            ->where('s.end_date <', $today)
            ->where('t.is_active', 1) // already suspended tenants are skipped
            ->get()->result_array();

        $suspended = 0;

        $this->load->library('saas_mailer');

        foreach ($expired as $row) {
            // Mark subscription expired
            $this->db->where('sub_id', $row['sub_id'])
                     ->update('saas_subscriptions', ['status' => 'expired']);

            // Suspend tenant
            $this->Saas_model->suspend_tenant((int)$row['tenant_id']);

            // Send suspension notice
            try {
                $this->saas_mailer->send_suspension_notice([
                    'tenant_id'     => $row['tenant_id'],
                    'business_name' => $row['business_name'],
                    'email'         => $row['email'],
                ]);
            } catch (Throwable $e) {
                log_message('error', "Suspension email failed for tenant {$row['tenant_id']}: " . $e->getMessage());
            }

            $this->Saas_model->log_activity(
                (int)$row['tenant_id'],
                'tenant_suspended',
                'Compte suspendu automatiquement (abonnement expiré)',
                ['by' => 'cron']
            );

            $suspended++;
        }

        return ['suspended' => $suspended];
    }
}
