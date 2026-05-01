<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saas_base extends MX_Controller {

    /** @var \CI_DB_driver Connexion dédiée SaaS (surcharge le $db CI par défaut) */
    protected $db;

    protected ?array $saas_admin       = null;
    protected array  $saas_permissions = [];

    public function __construct() {
        parent::__construct();
        // Connexion dédiée SaaS — indépendante de la DB restaurant
        $this->db = $this->load->database('saas', TRUE);
        $this->load->library('Saas_jwt');
        $this->load->model('saas/Saas_model');
    }

    /** Require valid JWT. Sets $this->saas_admin + $this->saas_permissions or exits 401. */
    protected function require_auth(): void {
        $token = $this->saas_jwt->fromHeader();
        if (!$token) $this->_abort(401, 'Token manquant.');

        $payload = $this->saas_jwt->verify($token);
        if (!$payload) $this->_abort(401, 'Token invalide ou expiré.');

        $admin = $this->Saas_model->get_admin_by_id((int)($payload['admin_id'] ?? 0));
        if (!$admin) $this->_abort(401, 'Administrateur introuvable.');

        $this->saas_admin = (array)$admin;

        if (empty($this->saas_admin['is_active'])) {
            $this->_abort(403, 'Compte désactivé.');
        }

        // Load permissions from the role table
        $role = $this->Saas_model->get_role_by_name($this->saas_admin['role'] ?? 'viewer');
        if ($role) {
            $this->saas_permissions = json_decode($role->permissions, true) ?? [];
        }
    }

    /** Check if admin has a given permission key (or wildcard *). */
    protected function has_permission(string $perm): bool {
        if (in_array('*', $this->saas_permissions, true)) return true;
        return in_array($perm, $this->saas_permissions, true);
    }

    /** Abort 403 if admin lacks the given permission. */
    protected function require_permission(string $perm): void {
        if (!$this->has_permission($perm)) {
            $this->_abort(403, 'Permission insuffisante.');
        }
    }

    /** Require super_admin role. */
    protected function require_super_admin(): void {
        $this->require_auth();
        if (($this->saas_admin['role'] ?? '') !== 'super_admin') {
            $this->_abort(403, 'Accès réservé au super administrateur.');
        }
    }

    /** Check if current admin is read-only (no write permissions at all). */
    protected function is_viewer(): bool {
        if (in_array('*', $this->saas_permissions, true)) return false;
        $write = array_filter($this->saas_permissions, fn($p) => !str_ends_with($p, '.view'));
        return empty($write);
    }

    protected function deny_if_viewer(): void {
        if ($this->is_viewer()) {
            $this->_abort(403, 'Accès en lecture seule.');
        }
    }

    /** Send JSON response */
    protected function _json($data, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function _abort(int $code, string $msg): void {
        $this->_json(['error' => $msg], $code);
    }

    /** Read JSON body */
    protected function _body(): array {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }
}
