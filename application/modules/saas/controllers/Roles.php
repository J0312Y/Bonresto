<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/Saas_base.php';

/**
 * Roles — dynamic role & permission management
 * Read:  any authenticated admin
 * Write: super_admin only
 */
class Roles extends Saas_base {

    /** GET /saas/roles */
    public function index() {
        $this->require_auth();
        $roles = $this->Saas_model->get_all_roles();
        foreach ($roles as &$r) {
            $r->role_id   = (int)$r->role_id;
            $r->is_system = (int)$r->is_system;
            $r->permissions = json_decode($r->permissions, true) ?? [];
        }
        $this->_json($roles);
    }

    /** POST /saas/roles */
    public function create() {
        $this->require_super_admin();
        $body = $this->_body();

        $name  = trim(preg_replace('/[^a-z0-9_]/', '', strtolower($body['name'] ?? '')));
        $label = trim($body['label'] ?? '');

        if (!$name || !$label) {
            $this->_abort(400, 'Nom (slug) et libellé sont requis.');
        }
        if ($this->Saas_model->role_name_exists($name)) {
            $this->_abort(409, 'Un rôle avec ce nom existe déjà.');
        }

        $id   = $this->Saas_model->create_role([
            'name'        => $name,
            'label'       => $label,
            'color'       => $body['color'] ?? 'bg-gray-100 text-gray-600',
            'permissions' => $body['permissions'] ?? [],
        ]);
        $role = $this->Saas_model->get_role_by_id($id);
        $role->role_id    = (int)$role->role_id;
        $role->is_system  = (int)$role->is_system;
        $role->permissions = json_decode($role->permissions, true) ?? [];
        $this->_json($role, 201);
    }

    /** PUT /saas/roles/:id */
    public function update(int $id) {
        $this->require_super_admin();
        $body = $this->_body();

        $role = $this->Saas_model->get_role_by_id($id);
        if (!$role) $this->_abort(404, 'Rôle introuvable.');

        $label = trim($body['label'] ?? $role->label);
        if (!$label) $this->_abort(400, 'Le libellé est requis.');

        $this->Saas_model->update_role($id, [
            'label'       => $label,
            'color'       => $body['color'] ?? $role->color,
            'permissions' => $body['permissions'] ?? json_decode($role->permissions, true),
        ]);

        $updated = $this->Saas_model->get_role_by_id($id);
        $updated->role_id    = (int)$updated->role_id;
        $updated->is_system  = (int)$updated->is_system;
        $updated->permissions = json_decode($updated->permissions, true) ?? [];
        $this->_json($updated);
    }

    /** DELETE /saas/roles/:id */
    public function remove(int $id) {
        $this->require_super_admin();

        $role = $this->Saas_model->get_role_by_id($id);
        if (!$role) $this->_abort(404, 'Rôle introuvable.');
        if ($role->is_system) $this->_abort(400, 'Impossible de supprimer un rôle système.');

        // Reassign any admins using this role to 'viewer'
        $this->db->where('role', $role->name)
                 ->update('saas_admins', ['role' => 'viewer']);

        $this->Saas_model->delete_role($id);
        $this->_json(['success' => true]);
    }
}
