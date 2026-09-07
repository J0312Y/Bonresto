<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class License_check {

    const BYPASS = [
        'install', 'saas', 'dashboard/auth', 'dashboard/license',
        'login', 'logout', 'hungry', 'scanmenu', 'qrorder', 'qr-menu',
        'call-waiter', 'request-bill', 'order-tracking', 'order-status-api',
        'apporedrlist', 'qr-app-cart', 'addtocartqr', 'paymentsqr',
        'payment-processqr', 'app-details', 'app-details-update', 'update-summery',
        'v1', 'v3', 'app', 'appv1', 'android',
        'sync_api', 'sync_cron', 'stock_alert_cron',
        // Audit F-08 : rappels des operateurs de paiement. Les bloquer sur
        // l'etat de la licence fait perdre un paiement deja confirme cote
        // operateur, qui cesse de reessayer apres une reponse 3xx.
        'mobilepayment',
    ];

    /**
     * Maps URI module segment → feature key in plan.
     * If a module is listed here, access is blocked unless the feature is enabled.
     */
    // feature key (in license.json) => module folder name
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
        'loyalty'       => 'loyalty',
        'shiftmangment' => 'shiftmangment',
        'tax'           => 'tax',
        // Agent conversationnel WhatsApp. A ne pas confondre avec 'whatsapp'
        // ci-dessus, qui est la pastille click-to-chat du site : ce sont deux
        // produits distincts, vendus separement.
        //
        // Gate ici = la licence s'applique aussi a l'API de l'agent
        // (agentapi/v1/*). Un client dont le plan n'inclut pas le module voit
        // son agent recevoir un 403 JSON — a condition qu'il envoie bien
        // l'en-tete Accept: application/json, ce que fait agent/bonresto.py.
        // Sans cet en-tete, _is_api() ne le reconnait pas et repond par une
        // redirection HTML que l'agent ne saurait pas interpreter.
        'agentapi'      => 'agentapi',
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
                // Show dedicated "module locked" page
                redirect('dashboard/license/module_locked?module=' . urlencode($module));
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
