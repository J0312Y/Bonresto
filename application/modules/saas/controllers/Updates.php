<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/Saas_base.php';

class Updates extends Saas_base {

    /** GET /saas/updates */
    public function index() {
        $this->require_auth();
        $updates = $this->Saas_model->get_all_updates();
        // Add delivery stats to each
        foreach ($updates as &$u) {
            $u['delivery'] = $this->Saas_model->get_delivery_stats($u['update_id']);
        }
        $this->_json($updates);
    }

    /** GET /saas/updates/:id */
    public function show(int $id) {
        $this->require_auth();
        $update = $this->Saas_model->get_update($id);
        if (!$update) { $this->_error('Update not found', 404); return; }
        $update['delivery'] = $this->Saas_model->get_delivery_stats($id);
        $this->_json($update);
    }

    /** POST /saas/updates */
    public function create() {
        $this->require_auth();
        $body = $this->_json_body();

        if (empty($body['title']) || empty($body['version']) || empty($body['module']) || empty($body['type'])) {
            $this->_error('title, version, module, type sont requis', 400);
            return;
        }

        $id = $this->Saas_model->create_update($body);
        $this->_json($this->Saas_model->get_update($id), 201);
    }

    /** POST /saas/updates/:id/publish */
    public function publish(int $id) {
        $this->require_auth();
        if (!$this->Saas_model->publish_update($id)) {
            $this->_error('Impossible de publier (déjà publié ou inexistant)', 400);
            return;
        }
        $this->_json(['success' => true]);
    }

    /** POST /saas/updates/:id/archive */
    public function archive_update(int $id) {
        $this->require_auth();
        $this->Saas_model->archive_update($id);
        $this->_json(['success' => true]);
    }

    /**
     * POST /saas/updates/applied
     * Called by a Bonresto instance after it has successfully applied updates.
     * Body: { client_key, applied: [1,2,3], failed: [{id:4, error:"..."}] }
     */
    public function applied() {
        $body = $this->_json_body();
        if (empty($body['client_key'])) { $this->_error('client_key required', 400); return; }

        // Resolve tenant from license key
        $this->load->model('saas/Saas_model');
        $key = $this->db->where('client_key', strtoupper($body['client_key']))->get('saas_license_keys')->row();
        if (!$key) { $this->_error('Invalid key', 403); return; }

        $tid = (int)$key->tenant_id;
        if (!empty($body['applied'])) {
            $this->Saas_model->mark_updates_applied($tid, $body['applied']);
        }
        if (!empty($body['failed'])) {
            foreach ($body['failed'] as $f) {
                $this->Saas_model->mark_updates_failed($tid, (int)$f['id'], $f['error'] ?? 'unknown');
            }
        }
        $this->_json(['success' => true]);
    }
}
