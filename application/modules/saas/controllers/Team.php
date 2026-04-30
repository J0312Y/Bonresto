<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/Saas_base.php';

/**
 * Team — manage collaborator admin accounts
 * All write actions restricted to super_admin.
 */
class Team extends Saas_base {

    /** GET /saas/team */
    public function index() {
        $this->require_auth();
        $admins = $this->Saas_model->get_all_admins();
        // Never expose passwords
        foreach ($admins as &$a) unset($a['password']);
        $this->_json($admins);
    }

    /** POST /saas/team */
    public function create() {
        $this->require_super_admin();
        $body = $this->_body();

        if (empty($body['name']) || empty($body['email']) || empty($body['password'])) {
            $this->_abort(400, 'Nom, email et mot de passe sont requis.');
        }
        if (strlen($body['password']) < 8) {
            $this->_abort(400, 'Le mot de passe doit contenir au moins 8 caractères.');
        }
        if ($this->Saas_model->admin_email_exists($body['email'])) {
            $this->_abort(409, 'Un compte avec cet email existe déjà.');
        }

        $id    = $this->Saas_model->create_admin($body);
        $admin = $this->Saas_model->get_admin_by_id($id);
        $out   = (array)$admin;
        unset($out['password']);
        $this->_json($out, 201);
    }

    /** PUT /saas/team/{id} */
    public function update(int $id) {
        $this->require_super_admin();
        $body = $this->_body();

        if (!empty($body['email']) && $this->Saas_model->admin_email_exists($body['email'], $id)) {
            $this->_abort(409, 'Un autre compte utilise déjà cet email.');
        }
        if (!empty($body['password']) && strlen($body['password']) < 8) {
            $this->_abort(400, 'Le mot de passe doit contenir au moins 8 caractères.');
        }
        // Cannot demote the only super_admin
        if (!empty($body['role']) && $body['role'] !== 'super_admin') {
            $super_count = (int)$this->db->where('role', 'super_admin')
                                         ->where('admin_id !=', $id)
                                         ->count_all_results('saas_admins');
            $current_role = $this->db->where('admin_id', $id)
                                     ->get('saas_admins')->row()->role ?? '';
            if ($current_role === 'super_admin' && $super_count === 0) {
                $this->_abort(400, 'Impossible de rétrograder le seul super administrateur.');
            }
        }

        $this->Saas_model->update_admin($id, $body);
        $admin = $this->Saas_model->get_admin_by_id($id);
        $out   = (array)$admin;
        unset($out['password']);
        $this->_json($out);
    }

    /** DELETE /saas/team/{id} */
    public function remove(int $id) {
        $this->require_super_admin();

        // Cannot delete yourself
        if ($id === (int)$this->saas_admin['admin_id']) {
            $this->_abort(400, 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $this->Saas_model->delete_admin($id);
        $this->_json(['success' => true]);
    }
}
