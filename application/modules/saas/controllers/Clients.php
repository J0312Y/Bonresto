<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/Saas_base.php';

class Clients extends Saas_base {

    /** GET /saas/clients */
    public function index() {
        $this->require_auth();
        $this->_json($this->Saas_model->get_all_tenants());
    }

    /** GET /saas/clients/{id} */
    public function show(int $id) {
        $this->require_auth();
        $tenant = $this->Saas_model->get_tenant($id);
        if (!$tenant) $this->_abort(404, 'Client introuvable.');

        // Attach live activity stats from the restaurant's own tables
        $tenant['live_stats'] = $this->Saas_model->tenant_live_stats($id);

        // Attach recent activity log
        $tenant['recent_activity'] = $this->Saas_model->get_activity($id, 20);

        $this->_json($tenant);
    }

    /** POST /saas/clients */
    public function create() {
        $this->require_auth();
        $body = $this->_body();

        if (empty($body['business_name']) || empty($body['email'])) {
            $this->_abort(400, 'Nom et email sont requis.');
        }

        if ($this->Saas_model->email_exists($body['email'])) {
            $this->_abort(409, 'Un client avec cet email existe déjà.');
        }

        $id     = $this->Saas_model->create_tenant($body);
        $tenant = $this->Saas_model->get_tenant($id);

        // Auto-log
        $this->Saas_model->log_activity($id, 'tenant_created', 'Nouveau client créé', [
            'by_admin' => $this->saas_admin['email'],
        ]);

        // Send welcome email with license key (if provided in body)
        $client_key = $body['license_key'] ?? '';
        if (!empty($tenant['email']) && $client_key !== '') {
            try {
                $this->load->library('saas_mailer');
                $this->saas_mailer->send_welcome((array)$tenant, $client_key);
            } catch (Throwable $e) {
                log_message('error', 'Welcome email failed: ' . $e->getMessage());
            }
        }

        $this->_json($tenant, 201);
    }

    /** PUT /saas/clients/{id} — update basic info */
    public function update(int $id) {
        $this->require_auth();
        $tenant = $this->Saas_model->get_tenant($id);
        if (!$tenant) $this->_abort(404, 'Client introuvable.');

        $body = $this->_body();
        if (empty($body['business_name']) || empty($body['email'])) {
            $this->_abort(400, 'Nom et email sont requis.');
        }

        if ($this->Saas_model->email_exists($body['email'], $id)) {
            $this->_abort(409, 'Un autre client utilise déjà cet email.');
        }

        $this->Saas_model->update_tenant($id, $body);

        $this->Saas_model->log_activity($id, 'tenant_updated', 'Informations mises à jour', [
            'by_admin' => $this->saas_admin['email'],
        ]);

        $this->_json($this->Saas_model->get_tenant($id));
    }

    /** PUT /saas/clients/{id}/subscription */
    public function subscription(int $id) {
        $this->require_auth();
        $body = $this->_body();

        if (empty($body['plan_id']) || empty($body['end_date'])) {
            $this->_abort(400, 'plan_id et end_date sont requis.');
        }

        $this->Saas_model->update_tenant_subscription($id, (int)$body['plan_id'], $body['end_date']);

        $this->Saas_model->log_activity($id, 'subscription_updated', 'Abonnement mis à jour', [
            'plan_id'  => $body['plan_id'],
            'end_date' => $body['end_date'],
            'by_admin' => $this->saas_admin['email'],
        ]);

        $this->_json(['success' => true]);
    }

    /** GET /saas/clients/{id}/live */
    public function live(int $id) {
        $this->require_auth();
        $this->_json($this->Saas_model->tenant_live_stats($id));
    }

    /** POST /saas/clients/{id}/logo — multipart upload */
    public function upload_logo(int $id) {
        $this->require_auth();

        if (!$this->Saas_model->get_tenant($id)) {
            $this->_abort(404, 'Client introuvable.');
        }

        if (empty($_FILES['logo']) || $_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
            $code = $_FILES['logo']['error'] ?? -1;
            $this->_abort(400, 'Aucun fichier reçu ou erreur upload (code ' . $code . ').');
        }

        $file    = $_FILES['logo'];
        $allowed_exts  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $allowed_mimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $mime = $file['type']; // browser-supplied, good enough for admin upload

        // Also try finfo if available for server-side MIME check
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = finfo_file($finfo, $file['tmp_name']) ?: $mime;
            finfo_close($finfo);
        }

        if (!in_array($ext, $allowed_exts) || !in_array($mime, $allowed_mimes)) {
            $this->_abort(400, 'Type de fichier non autorisé (ext: ' . $ext . ', mime: ' . $mime . ')');
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            $this->_abort(400, 'Fichier trop lourd (max 2 Mo).');
        }

        $upload_dir = FCPATH . 'uploads/saas_logos/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION) ?: 'jpg';
        $filename = md5(uniqid((string)$id, true)) . '.' . strtolower($ext);
        $dest     = $upload_dir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            $this->_abort(500, 'Impossible de déplacer le fichier uploadé.');
        }

        $logo_url = base_url('uploads/saas_logos/' . $filename);
        $this->db->where('tenant_id', $id)->update('saas_tenants', ['logo_url' => $logo_url]);

        $this->_json(['logo_url' => $logo_url]);
    }

    /** DELETE /saas/clients/{id}/logo */
    public function delete_logo(int $id) {
        $this->require_auth();
        $tenant = $this->Saas_model->get_tenant($id);
        if (!$tenant) $this->_abort(404, 'Client introuvable.');

        // Remove file if local
        if (!empty($tenant['logo_url'])) {
            $filename = basename($tenant['logo_url']);
            $path = FCPATH . 'uploads/saas_logos/' . $filename;
            if (file_exists($path)) @unlink($path);
        }

        $this->db->where('tenant_id', $id)->update('saas_tenants', ['logo_url' => null]);
        $this->_json(['success' => true]);
    }

    /** POST /saas/clients/{id}/suspend */
    public function suspend(int $id) {
        $this->require_auth();
        $this->Saas_model->suspend_tenant($id);
        $this->Saas_model->log_activity($id, 'tenant_suspended', 'Accès suspendu', [
            'by_admin' => $this->saas_admin['email'],
        ]);
        $this->_json(['success' => true]);
    }

    /** POST /saas/clients/{id}/reactivate */
    public function reactivate(int $id) {
        $this->require_auth();
        $tenant = $this->Saas_model->get_tenant($id);
        if (!$tenant) $this->_abort(404, 'Client introuvable.');

        $this->Saas_model->reactivate_tenant($id);
        $this->Saas_model->log_activity($id, 'tenant_reactivated', 'Accès réactivé', [
            'by_admin' => $this->saas_admin['email'],
        ]);
        $this->_json($this->Saas_model->get_tenant($id));
    }

    /** GET /saas/clients/export — CSV download */
    public function export() {
        $this->require_auth();
        $clients = $this->Saas_model->get_all_tenants();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="clients-' . date('Y-m-d') . '.csv"');

        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM for Excel
        fputcsv($out, ['ID', 'Nom', 'Email', 'Téléphone', 'Pays', 'Ville', 'Statut abonnement', 'Plan', 'Expiration', 'Créé le'], ';');

        foreach ($clients as $c) {
            $sub = $c['subscription'] ?? null;
            fputcsv($out, [
                $c['client_id'],
                $c['business_name'],
                $c['email'],
                $c['phone'] ?? '',
                $c['country'] ?? '',
                $c['city'] ?? '',
                $sub['status'] ?? 'Aucun',
                $sub['plan_name'] ?? '—',
                $sub['end_date'] ?? '—',
                $c['created_at'],
            ], ';');
        }
        fclose($out);
        exit;
    }
}
