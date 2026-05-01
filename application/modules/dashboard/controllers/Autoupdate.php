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
        $raw_updates = $this->license_manager->get_updates_info();
        $payload     = $this->license_manager->load();

        // get_updates_info() may return an error dict instead of an array of update rows
        $updates = (is_array($raw_updates) && !empty($raw_updates) && isset(array_values($raw_updates)[0]['update_id']))
            ? $raw_updates
            : [];

        $pending_count = count(array_filter($updates, fn($u) => ($u['delivery_status'] ?? '') === 'pending'));

        $raw = $this->license_manager->raw();
        $has_license = !empty($raw['client_key']);

        $data = [
            'title'           => 'Mises à jour',
            'module'          => 'dashboard',
            'page'            => 'autoupdate/autoupdate',
            'updates'         => $updates,
            'pending_count'   => $pending_count,
            'plan'            => $payload['plan'] ?? '—',
            'current_version' => $this->_read_version(),
            'has_license'     => $has_license,
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

        // No license configured — nothing to refresh
        $raw = $this->license_manager->raw();
        if (empty($raw['client_key'])) {
            $this->session->set_flashdata('update_error',
                'Aucune licence activée. Activez votre licence dans Paramètres avant de vérifier les mises à jour.');
            redirect('dashboard/autoupdate');
            return;
        }

        // Count pending updates BEFORE refresh so we can give an accurate message
        $before     = $this->license_manager->get_updates_info();
        $before     = (is_array($before) && isset(array_values($before)[0]['update_id'])) ? $before : [];
        $pending_before = count(array_filter($before, fn($u) => ($u['delivery_status'] ?? '') === 'pending'));

        $result = $this->license_manager->refresh();

        $this->session->unset_userdata('update_success');
        $this->session->unset_userdata('update_error');

        if ($result) {
            if ($pending_before > 0) {
                $n = $pending_before;
                $msg = $n === 1
                    ? '1 mise à jour a été appliquée avec succès.'
                    : "{$n} mises à jour ont été appliquées avec succès.";
            } else {
                $msg = 'Vérification effectuée — aucune nouvelle mise à jour disponible.';
            }
            $this->session->set_flashdata('update_success', $msg);
        } else {
            $payload = $this->license_manager->load();
            $status  = $this->license_manager->status($payload);
            if (in_array($status, ['active', 'grace'])) {
                $this->session->set_flashdata('update_success',
                    'Licence active. Le serveur SaaS est temporairement inaccessible — réessayez plus tard.');
            } else {
                $this->session->set_flashdata('update_error',
                    'Impossible de contacter le serveur SaaS. Vérifiez votre connexion.');
            }
        }

        redirect('dashboard/autoupdate');
    }

}
