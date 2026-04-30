<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard / License
 *
 * Handles license activation, status display, manual refresh, and the
 * "subscription expired" blocking page.
 */
class License extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('License_manager');
    }

    /**
     * GET  dashboard/license
     * Show current license status + activation form.
     */
    public function index() {
        // Trigger a refresh check even though this page is in the hook bypass list
        $this->license_manager->check_refresh();

        $payload = $this->license_manager->load();
        $status  = $this->license_manager->status($payload);
        $raw     = $this->license_manager->raw();

        $data = [
            'title'      => 'Licence',
            'module'     => 'dashboard',
            'page'       => 'license/index',
            'status'     => $status,
            'payload'    => $payload,
            'cached_at'  => $raw['cached_at'] ?? null,
            'client_key' => $raw['client_key'] ?? '',
            'error'      => $this->session->flashdata('license_error'),
            'success'    => $this->session->flashdata('license_success'),
        ];

        // Standalone wrapper when not logged in (no dashboard layout needed)
        if ($this->session->userdata('isLogIn')) {
            echo Modules::run('template/layout', $data);
        } else {
            $this->_standalone($data, 'license/index');
        }
    }

    /**
     * POST dashboard/license/activate
     * Receive the key from the form and call the SaaS activation endpoint.
     */
    public function activate() {
        $key = strtoupper(trim($this->input->post('client_key', true) ?? ''));

        if (!$key) {
            $this->session->set_flashdata('license_error', 'Veuillez saisir une clé de licence.');
            redirect('dashboard/license');
            return;
        }

        $payload = $this->license_manager->activate($key, base_url());

        if (!$payload) {
            $this->session->set_flashdata('license_error',
                'Clé invalide ou serveur SaaS inaccessible. Vérifiez la clé et réessayez.');
            redirect('dashboard/license');
            return;
        }

        $this->session->set_flashdata('license_success',
            'Licence activée avec succès ! Plan : ' . ($payload['plan'] ?? '—'));
        redirect('dashboard/license');
    }

    /**
     * GET dashboard/license/refresh
     * Manually trigger a refresh from the SaaS server.
     */
    public function refresh() {
        $payload = $this->license_manager->refresh();

        if ($payload) {
            $this->session->set_flashdata('license_success', 'Licence mise à jour depuis le serveur cloud.');
        } else {
            $this->session->set_flashdata('license_error',
                'Impossible de contacter le serveur cloud. La licence en cache reste active.');
        }

        redirect('dashboard/license');
    }

    /**
     * GET dashboard/license/expired
     * Blocking page shown when the subscription is fully expired.
     */
    public function expired() {
        $raw    = $this->license_manager->raw();
        $data   = [
            'title'   => 'Abonnement expiré',
            'payload' => $raw['payload'] ?? null,
        ];
        $data['module'] = 'dashboard';
        $data['page']   = 'license/expired';
        $this->_standalone($data, 'license/expired');
    }

    /** Render a standalone page (no dashboard layout required) */
    private function _standalone(array $data, string $view): void {
        // Render inner view to string first so the module context is preserved
        $content = $this->load->view($view, $data, true);
        $this->load->view('license/standalone_wrap', ['title' => $data['title'], 'content' => $content]);
    }
}
