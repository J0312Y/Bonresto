<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/Saas_base.php';

class Activity extends Saas_base {

    /** GET /saas/activity                 → all tenants latest 100 entries
     *  GET /saas/activity/tenant/{id}     → specific tenant
     */
    public function index() {
        $this->require_auth();
        $this->_json($this->Saas_model->get_activity(0, 100));
    }

    public function tenant(int $id) {
        $this->require_auth();
        $this->_json($this->Saas_model->get_activity($id, 50));
    }

    /** GET /saas/activity/export → CSV */
    public function export() {
        $this->require_auth();
        $logs = $this->Saas_model->get_activity(0, 2000);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="activite-' . date('Y-m-d') . '.csv"');
        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM for Excel
        fputcsv($out, ['Date', 'Client', 'Action', 'Description'], ';');
        foreach ($logs as $l) {
            fputcsv($out, [
                $l['created_at'],
                $l['business_name'] ?? "Tenant #{$l['tenant_id']}",
                $l['action'],
                $l['description'],
            ], ';');
        }
        fclose($out);
        exit;
    }

    /**
     * POST /saas/activity/report
     * Called by the local bonresto server to push activity back to SaaS admin.
     * Auth: X-Api-Key (client_key)
     */
    public function report() {
        $client_key = $_SERVER['HTTP_X_API_KEY'] ?? '';
        if (!$client_key) $this->_abort(401, 'X-Api-Key requis.');

        $key_row = $this->db
            ->where('client_key', strtoupper($client_key))
            ->where('is_activated', 1)
            ->get('saas_license_keys')->row();

        if (!$key_row) $this->_abort(401, 'Clé invalide.');

        $body = $this->_body();
        $this->Saas_model->log_activity(
            (int)$key_row->tenant_id,
            $body['action'] ?? 'event',
            $body['description'] ?? '',
            $body['meta'] ?? []
        );

        $this->_json(['success' => true]);
    }
}
