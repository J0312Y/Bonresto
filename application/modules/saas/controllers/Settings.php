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

        $to  = $this->saas_admin['email'];
        $cfg = $this->Saas_model->get_email_config();

        // Disable SSL peer verification (common issue with shared hosting certs)
        $cfg['smtp_timeout']      = 15;
        $cfg['smtp_keepalive']    = false;

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
            // Extract the last meaningful error line from CI debug output
            preg_match_all('/\d{3}[- ].*/', strip_tags($debug), $m);
            $last_error = !empty($m[0]) ? end($m[0]) : 'Connexion ou authentification échouée.';
            log_message('error', 'SMTP test failed. Debug: ' . $debug);
            $this->_abort(500, 'Échec SMTP : ' . $last_error);
        }

        $this->_json(['success' => true, 'sent_to' => $to]);
    }
}
