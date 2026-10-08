<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/Saas_base.php';

class Plans extends Saas_base {

    /** GET /saas/plans */
    public function index() {
        $this->require_auth();
        $plans = $this->Saas_model->get_all_plans();
        foreach ($plans as &$p) {
            $p['features'] = $this->_decode_features($p['features'] ?? null);
            $p['plan_id']  = (int)$p['plan_id'];
            $p['price']    = (float)$p['price'];
        }
        $this->_json($plans);
    }

    /** POST /saas/plans */
    public function create() {
        $this->require_auth();
        $body = $this->_body();
        if (empty($body['plan_name'])) $this->_abort(400, 'plan_name est requis.');

        $id   = $this->Saas_model->create_plan($body);
        $plan = $this->db->where('plan_id', $id)->get('saas_plans')->row_array();
        $plan['features'] = $this->_decode_features($plan['features'] ?? null);
        $this->_json($plan, 201);
    }

    /**
     * Decode the features JSON column into a proper JSON object (never an array).
     * PHP's json_decode with assoc=true returns [] for '{}', which json_encode
     * serialises back as '[]' instead of '{}', breaking the frontend.
     */
    private function _decode_features(?string $raw): object {
        $decoded = $raw ? json_decode($raw, true) : null;
        return (object)($decoded ?: []);
    }

    /** PUT /saas/plans/{id} */
    public function update($id) {
        $id = (int)$id;
        $this->require_auth();
        $this->Saas_model->update_plan($id, $this->_body());
        $plan = $this->db->where('plan_id', $id)->get('saas_plans')->row_array();
        if (!$plan) $this->_abort(404, 'Plan introuvable.');
        $plan['features'] = $this->_decode_features($plan['features'] ?? null);
        $plan['plan_id']  = (int)$plan['plan_id'];
        $plan['price']    = (float)$plan['price'];
        $this->_json($plan);
    }

    /** DELETE /saas/plans/{id} */
    public function delete($id) {
        $id = (int)$id;
        $this->require_auth();
        $this->Saas_model->delete_plan($id);
        $this->_json(['success' => true]);
    }

    // ── Module pricing ──────────────────────────────────────────

    /** GET /saas/plans/module_prices */
    public function module_prices() {
        $this->require_auth();
        $modules = $this->db->order_by('sort_order', 'asc')
            ->get('saas_module_prices')->result_array();
        foreach ($modules as &$m) {
            $m['price'] = (float)$m['price'];
            $m['is_active'] = (int)$m['is_active'];
            $m['sort_order'] = (int)$m['sort_order'];
        }
        $this->_json($modules);
    }

    /** PUT /saas/plans/module_prices */
    public function update_module_prices() {
        $this->require_auth();
        $body = $this->_body();
        $modules = $body['modules'] ?? [];

        if (empty($modules) || !is_array($modules)) {
            $this->_abort(400, 'modules array requis.');
        }

        $updated = 0;
        foreach ($modules as $m) {
            if (empty($m['module_id'])) continue;
            $data = [];
            if (isset($m['price'])) $data['price'] = (float)$m['price'];
            if (isset($m['is_active'])) $data['is_active'] = (int)$m['is_active'];
            if (isset($m['module_name'])) $data['module_name'] = $m['module_name'];
            if (isset($m['description'])) $data['description'] = $m['description'];
            if (isset($m['category'])) $data['category'] = $m['category'];
            if (!empty($data)) {
                $this->db->where('module_id', $m['module_id'])->update('saas_module_prices', $data);
                $updated++;
            }
        }

        $this->_json(['success' => true, 'updated' => $updated]);
    }

    /** POST /saas/plans/{id}/migrate */
    public function migrate($id) {
        $id   = (int)$id;
        $this->require_auth();
        $body = $this->_body();

        if (empty($body['to_plan_id'])) {
            $this->_abort(400, 'to_plan_id est requis.');
        }

        $to_plan_id = (int)$body['to_plan_id'];

        if ($to_plan_id === $id) {
            $this->_abort(400, 'Le plan de destination doit être différent.');
        }

        $migrated = $this->Saas_model->migrate_plan_clients($id, $to_plan_id);
        $this->Saas_model->delete_plan($id);

        $this->_json(['success' => true, 'migrated' => $migrated]);
    }
}
