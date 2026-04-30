<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/Saas_base.php';

class Auth extends Saas_base {

    /** POST /saas/auth/login */
    public function login() {
        $body     = $this->_body();
        $email    = trim($body['email'] ?? '');
        $password = trim($body['password'] ?? '');

        if (!$email || !$password) {
            $this->_abort(400, 'Email et mot de passe requis.');
        }

        $admin = $this->Saas_model->get_admin_by_email($email);

        if (!$admin || $admin->password !== md5($password)) {
            $this->_abort(401, 'Email ou mot de passe incorrect.');
        }

        $token = $this->saas_jwt->generate([
            'admin_id' => $admin->admin_id,
            'email'    => $admin->email,
        ]);

        $this->_json([
            'token' => $token,
            'admin' => [
                'name'  => $admin->name,
                'email' => $admin->email,
                'role'  => $admin->role ?? 'admin',
            ],
        ]);
    }

    /** GET /saas/auth/me */
    public function me() {
        $this->require_auth();
        $admin = $this->saas_admin;
        unset($admin['password']);
        $this->_json(['admin' => $admin]);
    }

    /** POST /saas/auth/change-password */
    public function change_password() {
        $this->require_auth();
        $body = $this->_body();

        $current = trim($body['current_password'] ?? '');
        $new     = trim($body['new_password'] ?? '');
        $confirm = trim($body['confirm_password'] ?? '');

        if (!$current || !$new || !$confirm) {
            $this->_abort(400, 'Tous les champs sont requis.');
        }
        if (strlen($new) < 8) {
            $this->_abort(400, 'Le nouveau mot de passe doit contenir au moins 8 caractères.');
        }
        if ($new !== $confirm) {
            $this->_abort(400, 'Les mots de passe ne correspondent pas.');
        }

        $admin = $this->Saas_model->get_admin_by_id((int)$this->saas_admin['admin_id']);
        if (!$admin || $admin->password !== md5($current)) {
            $this->_abort(401, 'Mot de passe actuel incorrect.');
        }

        $this->Saas_model->update_admin_password((int)$this->saas_admin['admin_id'], md5($new));
        $this->_json(['success' => true]);
    }

    /** PUT /saas/auth/profile */
    public function update_profile() {
        $this->require_auth();
        $body = $this->_body();

        $name = trim($body['name'] ?? '');
        if (!$name) {
            $this->_abort(400, 'Le nom est requis.');
        }

        $this->db->update('saas_admins', ['name' => $name], ['admin_id' => (int)$this->saas_admin['admin_id']]);

        $this->_json(['success' => true, 'name' => $name]);
    }
}
