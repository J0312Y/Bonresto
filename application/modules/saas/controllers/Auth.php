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

        $this->load->library('Saas_password');

        if (!$admin || !Saas_password::verifier($password, $admin->password)) {
            $this->_abort(401, 'Email ou mot de passe incorrect.');
        }

        // Migration transparente : c'est le seul moment ou le mot de passe en
        // clair est disponible, donc le seul ou une ancienne empreinte MD5
        // peut etre remplacee par du bcrypt. Aucune action pour l'utilisateur.
        if (Saas_password::a_rehacher($admin->password)) {
            $this->Saas_model->update_admin_password(
                (int) $admin->admin_id,
                Saas_password::hacher($password)
            );
        }

        $token = $this->saas_jwt->generate([
            'admin_id' => $admin->admin_id,
            'email'    => $admin->email,
        ]);

        // Record login session
        $this->Saas_model->record_session((int)$admin->admin_id, [
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
        ]);

        $this->_json([
            'token' => $token,
            'admin' => [
                'admin_id'   => (int)$admin->admin_id,
                'name'       => $admin->name,
                'email'      => $admin->email,
                'role'       => $admin->role ?? 'admin',
                'phone'      => $admin->phone ?? '',
                'avatar_url' => $admin->avatar_url ?? '',
                'created_at' => $admin->created_at ?? null,
                'last_login' => $admin->last_login ?? null,
            ],
        ]);
    }

    /** GET /saas/auth/me */
    public function me() {
        $this->require_auth();
        $a = $this->saas_admin;
        $this->_json(['admin' => [
            'admin_id'   => (int)$a['admin_id'],
            'name'       => $a['name'],
            'email'      => $a['email'],
            'role'       => $a['role'] ?? 'admin',
            'phone'      => $a['phone'] ?? '',
            'avatar_url' => $a['avatar_url'] ?? '',
            'created_at' => $a['created_at'] ?? null,
            'last_login' => $a['last_login'] ?? null,
        ]]);
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

        $this->load->library('Saas_password');

        $admin = $this->Saas_model->get_admin_by_id((int)$this->saas_admin['admin_id']);
        if (!$admin || !Saas_password::verifier($current, $admin->password)) {
            $this->_abort(401, 'Mot de passe actuel incorrect.');
        }

        $this->Saas_model->update_admin_password(
            (int)$this->saas_admin['admin_id'],
            Saas_password::hacher($new)
        );
        $this->_json(['success' => true]);
    }

    /** POST /saas/auth/forgot-password */
    public function forgot_password() {
        set_time_limit(30);
        $body  = $this->_body();
        $email = trim($body['email'] ?? '');

        if (!$email) {
            $this->_abort(400, 'L\'email est requis.');
        }

        $admin = $this->Saas_model->get_admin_by_email($email);

        if (!$admin) {
            $this->_abort(404, 'Aucun compte administrateur associé à cet email.');
        }

        // Generate a secure random token
        $token   = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $this->Saas_model->set_reset_token((int)$admin->admin_id, $token, $expires);

        // Build the reset link — use saas_admin_url from DB settings (fallback to request origin)
        $settings  = $this->Saas_model->get_all_settings();
        $admin_url = rtrim($settings['saas_admin_url'] ?? $body['base_url'] ?? 'http://localhost:3000', '/');
        $reset_url = $admin_url . '/reset-password?token=' . $token;

        // Log the link for debugging (useful if SMTP fails)
        log_message('info', 'Password reset link for ' . $email . ': ' . $reset_url);

        $html = $this->_build_reset_email($admin->name, $reset_url);
        $cfg  = $this->Saas_model->get_email_config();
        $cfg['smtp_timeout'] = 10;

        // Flush response to browser immediately, then send email in background
        $response = json_encode(['success' => true, 'message' => 'Un lien de réinitialisation a été envoyé à ' . $email]);
        http_response_code(200);
        header('Content-Type: application/json');
        header('Connection: close');
        header('Content-Length: ' . strlen($response));
        echo $response;

        // Close connection with browser
        if (ob_get_level()) ob_end_flush();
        flush();
        if (function_exists('fastcgi_finish_request')) fastcgi_finish_request();

        // Continue in background — browser already received response
        ignore_user_abort(true);
        try {
            $this->load->library('email');
            $this->email->initialize($cfg);
            $this->email->from($cfg['from_email'] ?: 'noreply@bonresto.com', $cfg['from_name'] ?: 'Bonresto SaaS');
            $this->email->to($email);
            $this->email->subject('Réinitialisation de votre mot de passe — Bonresto');
            $this->email->message($html);
            $this->email->send(false);
            $this->email->clear(true);
        } catch (\Exception $e) {
            log_message('error', 'Password reset email failed for ' . $email . ': ' . $e->getMessage());
        }
        exit;
    }

    /** POST /saas/auth/reset-password */
    public function reset_password() {
        $body = $this->_body();

        $token    = trim($body['token'] ?? '');
        $password = trim($body['password'] ?? '');
        $confirm  = trim($body['confirm_password'] ?? '');

        if (!$token) {
            $this->_abort(400, 'Token manquant.');
        }
        if (!$password || !$confirm) {
            $this->_abort(400, 'Le mot de passe et la confirmation sont requis.');
        }
        if (strlen($password) < 8) {
            $this->_abort(400, 'Le mot de passe doit contenir au moins 8 caractères.');
        }
        if ($password !== $confirm) {
            $this->_abort(400, 'Les mots de passe ne correspondent pas.');
        }

        $admin = $this->Saas_model->get_admin_by_reset_token($token);
        if (!$admin) {
            $this->_abort(400, 'Lien de réinitialisation invalide ou expiré.');
        }

        $this->load->library('Saas_password');
        $this->Saas_model->update_admin_password(
            (int)$admin->admin_id,
            Saas_password::hacher($password)
        );
        $this->Saas_model->clear_reset_token((int)$admin->admin_id);

        $this->_json(['success' => true, 'message' => 'Mot de passe réinitialisé avec succès.']);
    }

    /** Build HTML email for password reset */
    private function _build_reset_email(string $name, string $url): string {
        $year      = date('Y');
        $safe_name = htmlspecialchars($name);
        $safe_url  = htmlspecialchars($url);
        return <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#f5f5f4;font-family:Arial,Helvetica,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f5f4;padding:40px 16px;">
  <tr><td align="center">
    <table width="520" cellpadding="0" cellspacing="0" style="max-width:520px;width:100%;">

      <!-- Header -->
      <tr><td align="center" style="padding-bottom:28px;">
        <table cellpadding="0" cellspacing="0">
          <tr>
            <td style="vertical-align:middle;">
              <img src="' . base_url('uploads/saas_logos/logo-bonresto.png') . '" alt="Bon Resto" width="42" height="42" style="border-radius:11px;display:block;" onerror="this.style.display=\'none\'" />
            </td>
            <td style="padding-left:10px;vertical-align:middle;">
              <div style="font-weight:bold;font-size:17px;color:#1c1917;line-height:1.2;">Bon Resto</div>
              <div style="font-size:11px;color:#a8a29e;">Admin Console</div>
            </td>
          </tr>
        </table>
      </td></tr>

      <!-- Card -->
      <tr><td style="background:#ffffff;border:1px solid #e7e5e4;border-radius:16px;padding:36px;">

        <!-- Icon -->
        <table cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
          <tr>
            <td style="background:#fef2f2;width:48px;height:48px;border-radius:12px;text-align:center;vertical-align:middle;">
              <span style="font-size:22px;">🔐</span>
            </td>
          </tr>
        </table>

        <h2 style="margin:0 0 6px;font-size:20px;font-weight:700;color:#1c1917;">Réinitialisation du mot de passe</h2>
        <p style="margin:0 0 20px;color:#78716c;font-size:14px;line-height:1.6;">Bonjour <strong style="color:#1c1917;">$safe_name</strong>,</p>
        <p style="margin:0 0 28px;color:#78716c;font-size:14px;line-height:1.6;">
          Vous avez demandé la réinitialisation de votre mot de passe administrateur. Cliquez sur le bouton ci-dessous pour créer un nouveau mot de passe.
        </p>

        <!-- CTA Button -->
        <table cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
          <tr>
            <td style="background:#dc2626;border-radius:10px;">
              <a href="$safe_url" style="display:inline-block;background:#dc2626;color:#ffffff;padding:14px 36px;border-radius:10px;font-size:14px;font-weight:700;text-decoration:none;letter-spacing:0.2px;">
                Réinitialiser mon mot de passe →
              </a>
            </td>
          </tr>
        </table>

        <!-- Warning box -->
        <table cellpadding="0" cellspacing="0" style="width:100%;margin-bottom:24px;">
          <tr>
            <td style="background:#fafaf9;border:1px solid #e7e5e4;border-radius:10px;padding:14px 16px;">
              <p style="margin:0;color:#78716c;font-size:12.5px;line-height:1.6;">
                ⏱ &nbsp;Ce lien expire dans <strong>1 heure</strong>.<br>
                🚫 &nbsp;Si vous n'avez pas fait cette demande, ignorez cet email — votre mot de passe reste inchangé.
              </p>
            </td>
          </tr>
        </table>

        <hr style="border:none;border-top:1px solid #f5f5f4;margin:0 0 16px;" />
        <p style="margin:0;color:#a8a29e;font-size:11.5px;line-height:1.6;">
          Si le bouton ne fonctionne pas, copiez ce lien dans votre navigateur :<br>
          <a href="$safe_url" style="color:#dc2626;word-break:break-all;font-size:11px;">$safe_url</a>
        </p>

      </td></tr>

      <!-- Footer -->
      <tr><td align="center" style="padding-top:24px;">
        <p style="margin:0;color:#a8a29e;font-size:11px;">© $year Bon Resto · Tous droits réservés</p>
      </td></tr>

    </table>
  </td></tr>
</table>
</body>
</html>
HTML;
    }

    /** PUT /saas/auth/profile */
    public function update_profile() {
        $this->require_auth();
        $body = $this->_body();

        $name = trim($body['name'] ?? '');
        if (!$name) {
            $this->_abort(400, 'Le nom est requis.');
        }

        $update = ['name' => $name];
        if (!empty($body['email']))  $update['email'] = trim($body['email']);
        if (isset($body['phone']))   $update['phone'] = trim($body['phone']);

        $this->db->update('saas_admins', $update, ['admin_id' => (int)$this->saas_admin['admin_id']]);

        $this->_json(['success' => true, 'name' => $name]);
    }

    /** POST /saas/auth/upload-avatar — multipart/form-data, field: avatar */
    public function upload_avatar() {
        $this->require_auth();
        $admin_id = (int)$this->saas_admin['admin_id'];

        $this->load->library('upload', [
            'upload_path'   => FCPATH . 'uploads/avatars/',
            'allowed_types' => 'jpg|jpeg|png|gif|webp',
            'max_size'      => 2048, // 2 MB
            'file_name'     => 'avatar_' . $admin_id . '_' . time(),
            'overwrite'     => false,
        ]);

        if (!$this->upload->do_upload('avatar')) {
            $this->_abort(400, $this->upload->display_errors('', ''));
        }

        $file = $this->upload->data();
        $url  = base_url('uploads/avatars/' . $file['file_name']);

        $this->db->update('saas_admins', ['avatar_url' => $url], ['admin_id' => $admin_id]);

        $this->_json(['success' => true, 'avatar_url' => $url]);
    }

    /** GET /saas/auth/sessions */
    public function sessions() {
        $this->require_auth();
        $admin_id = (int)$this->saas_admin['admin_id'];
        $rows = $this->Saas_model->get_admin_sessions($admin_id, 10);

        $current_token = hash('sha256', $this->saas_jwt->fromHeader());

        $sessions = array_map(function($s) use ($current_token) {
            $ua = $s['user_agent'] ?? '';
            // Detect device type from user agent
            if (stripos($ua, 'iPhone') !== false || stripos($ua, 'Android') !== false || stripos($ua, 'Mobile') !== false) {
                $device = 'Mobile';
            } elseif (stripos($ua, 'curl') !== false) {
                $device = 'API';
            } else {
                $device = 'Ordinateur';
            }
            // Extract browser
            $browser = 'Navigateur';
            if (stripos($ua, 'Chrome') !== false && stripos($ua, 'Edg') === false) $browser = 'Chrome';
            elseif (stripos($ua, 'Firefox') !== false) $browser = 'Firefox';
            elseif (stripos($ua, 'Safari') !== false && stripos($ua, 'Chrome') === false) $browser = 'Safari';
            elseif (stripos($ua, 'Edg') !== false) $browser = 'Edge';
            elseif (stripos($ua, 'curl') !== false) $browser = 'cURL';

            return [
                'session_id' => (int)$s['session_id'],
                'ip'         => $s['ip_address'] ?? '—',
                'device'     => $device,
                'browser'    => $browser,
                'created_at' => $s['created_at'],
                'last_used'  => $s['last_used_at'],
                'is_current' => ($s['token_hash'] === $current_token),
            ];
        }, $rows);

        $this->_json(['sessions' => $sessions]);
    }

    /** DELETE /saas/auth/sessions — revoke all sessions except current */
    public function revoke_sessions() {
        $this->require_auth();
        $admin_id = (int)$this->saas_admin['admin_id'];
        $current_hash = hash('sha256', $this->saas_jwt->fromHeader());

        $this->db->where('admin_id', $admin_id)
                 ->where('token_hash !=', $current_hash)
                 ->delete('saas_admin_sessions');

        $this->_json(['success' => true]);
    }
}
