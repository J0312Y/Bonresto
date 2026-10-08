<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/Saas_base.php';

class Settings extends Saas_base {

    private array $allowed_keys = [
        'smtp_protocol', 'smtp_host', 'smtp_port', 'smtp_crypto',
        'smtp_user', 'smtp_pass', 'from_email', 'from_name',
        'company_name', 'company_address', 'company_email',
        'company_phone', 'company_website', 'saas_cron_key',
        'cron_hour', 'cron_minute',
        'alert_new_client', 'alert_payment_failed', 'alert_licence_expired',
        'alert_ticket_urgent', 'alert_weekly_report',
    ];

    /** GET /saas/settings */
    public function index() {
        $this->require_auth();
        $settings = $this->Saas_model->get_all_settings();
        // Mask password in response
        if (!empty($settings['smtp_pass'])) {
            $settings['smtp_pass'] = '••••••••';
        }
        $this->_json($settings);
    }

    /** POST /saas/settings */
    public function save() {
        $this->require_auth();
        $body = $this->_body();

        $to_save = [];
        foreach ($this->allowed_keys as $key) {
            if (!array_key_exists($key, $body)) continue;
            // Never overwrite password with the masked placeholder
            if ($key === 'smtp_pass' && $body[$key] === '••••••••') continue;
            $to_save[$key] = trim((string)$body[$key]);
        }

        if (empty($to_save)) $this->_abort(400, 'Aucune donnée valide à enregistrer.');

        $this->Saas_model->save_settings($to_save);
        $this->_json(['success' => true]);
    }

    /** POST /saas/settings/test-smtp — sends a test email to the logged-in admin */
    public function test_smtp() {
        $this->require_auth();

        // Envoyer à smtp_user (adresse garantie d'exister sur le serveur)
        // ou à l'admin si différent
        $cfg_check = $this->Saas_model->get_all_settings();
        $to = !empty($cfg_check['smtp_user']) ? $cfg_check['smtp_user'] : $this->saas_admin['email'];
        $cfg = $this->Saas_model->get_email_config();

        // Disable SSL peer verification (common issue with shared hosting certs)
        $cfg['smtp_timeout']      = 15;
        $cfg['smtp_keepalive']    = false;
        $cfg['newline']           = "\r\n";
        $cfg['crlf']              = "\r\n";
        // Bypass SSL verification pour serveurs dédiés (certificats auto-signés)
        $cfg['smtp_conn_options'] = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
            ],
        ];

        $this->load->library('email');
        $this->email->initialize($cfg);
        $this->email->from($cfg['from_email'], $cfg['from_name']);
        $this->email->to($to);
        $this->email->subject('✅ Test SMTP — Bonresto SaaS');
        $this->email->message('<p style="font-family:Arial,sans-serif;">Configuration SMTP opérationnelle.</p>');

        $ok = $this->email->send(false);
        $debug = $this->email->print_debugger(['headers', 'subject', 'body']);
        $this->email->clear(true);

        if (!$ok) {
            $clean = strip_tags($debug);
            log_message('error', 'SMTP test failed. Debug: ' . $clean);
            // Cherche un vrai code SMTP 4xx/5xx
            preg_match_all('/(?:^|\n)([45]\d{2}[- ][^\n]+)/m', $clean, $m);
            if (!empty($m[1])) {
                $last_error = trim(end($m[1]));
            } else {
                // Cherche la ligne "ERROR"
                preg_match('/Unable to send[^\n]*/i', $clean, $me);
                $last_error = !empty($me[0]) ? trim($me[0]) : 'Échec envoi — vérifiez les logs SMTP.';
            }
            $this->_json(['error' => $last_error, 'debug' => substr($clean, 0, 800)], 500);
        }

        $this->_json(['success' => true, 'sent_to' => $to]);
    }
}
