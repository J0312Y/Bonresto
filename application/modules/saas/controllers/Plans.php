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
    public function update(int $id) {
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
    public function delete(int $id) {
        $this->require_auth();
        $this->Saas_model->delete_plan($id);
        $this->_json(['success' => true]);
    }
}
