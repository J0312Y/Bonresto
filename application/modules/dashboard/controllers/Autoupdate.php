<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard / Autoupdate
 *
 * Replaced the original bdtask vendor update system with the
 * Bonresto SaaS update system. Shows published updates from the SaaS
 * admin with their delivery status, and allows manual refresh/apply.
 */
class Autoupdate extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('License_manager');

        if (!$this->session->userdata('isLogIn')) {
            redirect('login');
        }
    }

    /** GET dashboard/autoupdate */
    public function index() {
        $updates  = $this->license_manager->get_updates_info();
        $payload  = $this->license_manager->load();

        $pending_count = count(array_filter($updates, fn($u) => $u['delivery_status'] === 'pending'));

        $data = [
            'title'           => 'Mises à jour',
            'module'          => 'dashboard',
            'page'            => 'autoupdate/autoupdate',
            'updates'         => $updates,
            'pending_count'   => $pending_count,
            'plan'            => $payload['plan'] ?? '—',
            'current_version' => $this->_read_version(),
            'success'         => $this->session->flashdata('update_success'),
            'error'           => $this->session->flashdata('update_error'),
        ];

        echo Modules::run('template/layout', $data);
    }

    /** Read the installed Bonresto version from lic.php */
    private function _read_version(): string {
        $path = FCPATH . 'system/core/compat/lic.php';
        if (!file_exists($path)) return '—';
        $content = file_get_contents($path);
        if (preg_match('/product_version\s*=\s*[\'"]([^\'"]+)[\'"]/', $content, $m)) {
            return $m[1];
        }
        return '—';
    }

    /** POST dashboard/autoupdate/apply — manual refresh & apply */
    public function apply() {
        if (!$this->session->userdata('isAdmin')) {
            redirect('dashboard/autoupdate');
        }

        $result = $this->license_manager->refresh();

        if ($result) {
            $this->session->set_flashdata('update_success',
                'Vérification effectuée. Les mises à jour disponibles ont été appliquées.');
        } else {
            $this->session->set_flashdata('update_error',
                'Impossible de contacter le serveur SaaS. Réessayez dans quelques instants.');
        }

        redirect('dashboard/autoupdate');
    }

}
