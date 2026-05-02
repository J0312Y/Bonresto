<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class License_check {

    const BYPASS = [
        'install', 'saas', 'dashboard/auth', 'dashboard/license',
        'login', 'logout', 'hungry', 'scanmenu', 'qrorder', 'qr-menu',
        'v1', 'v3', 'app', 'appv1', 'android',
        'sync_api', 'sync_cron',
    ];

    /**
     * Maps URI module segment → feature key in plan.
     * If a module is listed here, access is blocked unless the feature is enabled.
     */
    const MODULE_MAP = [
        'reservation'   => 'reservation',
        'qrapp'         => 'qrapp',
        'hrm'           => 'hrm',
        'purchase'      => 'purchase',
        'production'    => 'production',
        'wastemangment' => 'wastemangment',
        'accounts'      => 'accounts',
        'report'        => 'report',
        'whatsapp'      => 'whatsapp',
    ];

    public function check() {
        $CI  =& get_instance();
        $uri = trim($CI->uri->uri_string(), '/');

        foreach (self::BYPASS as $prefix) {
            if ($uri === $prefix || strpos($uri, $prefix . '/') === 0) return;
        }

        $CI->load->library('License_manager');

        // Detect plan changes pushed from the SaaS admin (rate-limited to every 5 min)
        $CI->license_manager->check_refresh();

        $payload = $CI->license_manager->load();
        $status  = $CI->license_manager->status($payload);

        // No license → activation page
        if ($status === 'none') { redirect('dashboard/license'); return; }

        // Expired → block
        if ($status === 'expired') {
            if ($this->_is_api()) {
                http_response_code(402);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Subscription expired.', 'code' => 'LICENSE_EXPIRED']);
                exit;
            }
            redirect('dashboard/license/expired');
            return;
        }

        // Grace → warning banner
        if ($status === 'grace') {
            $until = date('d/m/Y', strtotime($payload['grace_until'] ?? 'now'));
            $CI->session->set_flashdata('license_warning',
                "Abonnement expiré. Période de grâce jusqu'au {$until}. Renouvelez votre licence.");
        }

        // ── Module enforcement ────────────────────────────────────────────────
        $module = $CI->uri->segment(1); // first segment = module name
        if (isset(self::MODULE_MAP[$module])) {
            $feature_key = self::MODULE_MAP[$module];
            if (!$CI->license_manager->has_module($feature_key)) {
                if ($this->_is_api()) {
                    http_response_code(403);
                    header('Content-Type: application/json');
                    echo json_encode([
                        'error' => "Le module '{$module}' n'est pas inclus dans votre plan.",
                        'code'  => 'MODULE_NOT_LICENSED',
                    ]);
                    exit;
                }
                // Show friendly upgrade page
                $CI->session->set_flashdata('error',
                    "Le module <strong>" . htmlspecialchars($module) . "</strong> n'est pas inclus dans votre plan actuel. " .
                    "Contactez votre administrateur SaaS pour mettre à niveau votre abonnement.");
                redirect('dashboard/home');
                return;
            }
        }
    }

    private function _is_api(): bool {
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
        $ct     = $_SERVER['CONTENT_TYPE'] ?? '';
        return strpos($accept, 'application/json') !== false
            || strpos($ct, 'application/json') !== false
            || (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    }
}
