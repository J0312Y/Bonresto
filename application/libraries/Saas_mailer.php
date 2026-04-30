<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Saas_mailer — Bonresto SaaS email service
 * Handles all transactional emails with branded HTML templates.
 */
class Saas_mailer {

    private CI_Controller $CI;
    private array $cfg;
    private array $company;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('saas/Saas_model');
        // Load config from DB (saas_settings table); fall back to file config
        $this->cfg     = $this->CI->Saas_model->get_email_config();
        $this->company = $this->CI->Saas_model->get_company_info();
    }

    // ── Public methods ─────────────────────────────────────────────────────

    /** Email de bienvenue envoyé à la création d'un client */
    public function send_welcome(array $tenant, string $client_key): bool {
        $subject = '🎉 Bienvenue sur Bonresto — Votre accès est prêt';
        $body    = $this->_wrap($this->_tpl_welcome($tenant, $client_key));
        return $this->_send($tenant['email'], $subject, $body);
    }

    /** Envoi d'une facture par email (avec PDF en pièce jointe optionnel) */
    public function send_invoice(array $invoice, string $pdf_path = ''): bool {
        $subject = "Facture {$invoice['invoice_number']} — Bonresto SaaS";
        $body    = $this->_wrap($this->_tpl_invoice($invoice));

        $this->_boot_email();
        $this->CI->email->to($invoice['client_email']);
        $this->CI->email->subject($subject);
        $this->CI->email->message($body);

        if ($pdf_path && file_exists($pdf_path)) {
            $this->CI->email->attach($pdf_path);
        }

        $result = $this->CI->email->send(false);
        $this->CI->email->clear(true);
        return $result;
    }

    /** Confirmation de paiement reçu */
    public function send_payment_confirmation(array $invoice): bool {
        $subject = "✅ Paiement confirmé — {$invoice['invoice_number']}";
        $body    = $this->_wrap($this->_tpl_payment_confirmed($invoice));
        return $this->_send($invoice['client_email'], $subject, $body);
    }

    /** Rappel d'expiration (days_left = 7 ou 1) */
    public function send_expiry_reminder(array $tenant, array $subscription, int $days_left): bool {
        $urgency = $days_left <= 1 ? '🚨 URGENT' : '⚠️';
        $subject = "{$urgency} Votre abonnement Bonresto expire " . ($days_left <= 1 ? 'demain' : "dans {$days_left} jours");
        $body    = $this->_wrap($this->_tpl_expiry_reminder($tenant, $subscription, $days_left));
        return $this->_send($tenant['email'], $subject, $body);
    }

    /** Email de suspension */
    public function send_suspension_notice(array $tenant): bool {
        $subject = '⛔ Votre abonnement Bonresto a été suspendu';
        $body    = $this->_wrap($this->_tpl_suspended($tenant));
        return $this->_send($tenant['email'], $subject, $body);
    }

    // ── Private helpers ────────────────────────────────────────────────────

    private function _boot_email(): void {
        $cfg = $this->cfg;
        $cfg['smtp_timeout']   = 15;
        $cfg['smtp_keepalive'] = false;
        $this->CI->load->library('email');
        $this->CI->email->initialize($cfg);
        $this->CI->email->from($cfg['from_email'], $cfg['from_name']);
    }

    private function _send(string $to, string $subject, string $body): bool {
        try {
            $this->_boot_email();
            $this->CI->email->to($to);
            $this->CI->email->subject($subject);
            $this->CI->email->message($body);
            $result = $this->CI->email->send(false);
            $this->CI->email->clear(true);
            return $result;
        } catch (Throwable $e) {
            log_message('error', 'Saas_mailer send failed: ' . $e->getMessage());
            return false;
        }
    }

    private function _fmt(float $n): string {
        return number_format($n, 0, ',', ' ') . ' FCFA';
    }

    // ── HTML Templates ─────────────────────────────────────────────────────

    private function _wrap(string $content): string {
        $co = $this->company;
        return <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:30px 0;">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.08);">
      <!-- Header -->
      <tr>
        <td style="background:#2c3136;padding:24px 32px;text-align:center;">
          <span style="font-size:22px;font-weight:bold;color:#fff;letter-spacing:1px;">
            Bon<span style="color:#37a000;">resto</span> SaaS
          </span>
        </td>
      </tr>
      <!-- Content -->
      <tr><td style="padding:32px;">
        {$content}
      </td></tr>
      <!-- Footer -->
      <tr>
        <td style="background:#f8f9fa;padding:20px 32px;border-top:1px solid #e9ecef;text-align:center;">
          <p style="margin:0;font-size:12px;color:#6c757d;">
            {$co['name']} · {$co['address']}<br>
            <a href="mailto:{$co['email']}" style="color:#37a000;">{$co['email']}</a>
            &nbsp;·&nbsp; {$co['phone']}
          </p>
        </td>
      </tr>
    </table>
  </td></tr>
</table>
</body>
</html>
HTML;
    }

    private function _tpl_welcome(array $tenant, string $client_key): string {
        $name    = htmlspecialchars($tenant['business_name']);
        $key     = htmlspecialchars($client_key);
        $license = base_url('dashboard/license');
        return <<<HTML
<h2 style="margin:0 0 8px;color:#1a202c;font-size:22px;">Bienvenue, {$name} ! 🎉</h2>
<p style="color:#4a5568;line-height:1.7;margin:0 0 24px;">
  Votre compte Bonresto SaaS est activé. Voici votre clé de licence pour activer votre plateforme.
</p>

<div style="background:#f0fdf4;border:2px dashed #37a000;border-radius:10px;padding:20px;text-align:center;margin-bottom:24px;">
  <p style="margin:0 0 6px;font-size:12px;color:#6b7280;text-transform:uppercase;letter-spacing:1px;">Votre clé de licence</p>
  <p style="margin:0;font-size:20px;font-weight:bold;color:#37a000;letter-spacing:3px;font-family:monospace;">{$key}</p>
</div>

<p style="color:#4a5568;line-height:1.7;margin:0 0 20px;">
  Pour activer votre licence, connectez-vous à votre tableau de bord Bonresto et rendez-vous dans
  <strong>Paramètres → Licence</strong>, ou cliquez sur le bouton ci-dessous.
</p>

<div style="text-align:center;margin:24px 0;">
  <a href="{$license}" style="background:#37a000;color:#fff;text-decoration:none;padding:14px 32px;border-radius:8px;font-weight:bold;font-size:15px;display:inline-block;">
    Activer ma licence →
  </a>
</div>

<p style="color:#9ca3af;font-size:13px;margin:0;">
  Gardez cette clé en lieu sûr. En cas de problème, contactez-nous à {$this->company['email']}.
</p>
HTML;
    }

    private function _tpl_invoice(array $inv): string {
        $name    = htmlspecialchars($inv['business_name'] ?? '');
        $num     = htmlspecialchars($inv['invoice_number']);
        $amount  = $this->_fmt((float)$inv['amount']);
        $plan    = htmlspecialchars($inv['plan_name'] ?? '—');
        $date    = date('d/m/Y', strtotime($inv['created_at']));
        $period  = ($inv['period_start'] && $inv['period_end'])
            ? date('d/m/Y', strtotime($inv['period_start'])) . ' au ' . date('d/m/Y', strtotime($inv['period_end']))
            : '—';
        $notes   = $inv['notes'] ? '<p style="color:#4a5568;font-size:13px;margin-top:16px;"><em>' . htmlspecialchars($inv['notes']) . '</em></p>' : '';

        return <<<HTML
<h2 style="margin:0 0 4px;color:#1a202c;">Facture {$num}</h2>
<p style="margin:0 0 24px;color:#6b7280;font-size:14px;">Émise le {$date}</p>

<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
  <tr>
    <td style="font-size:13px;color:#6b7280;padding-bottom:8px;">Client</td>
    <td style="font-size:13px;font-weight:bold;color:#1a202c;text-align:right;padding-bottom:8px;">{$name}</td>
  </tr>
  <tr>
    <td style="font-size:13px;color:#6b7280;padding-bottom:8px;">Plan</td>
    <td style="font-size:13px;color:#1a202c;text-align:right;padding-bottom:8px;">{$plan}</td>
  </tr>
  <tr>
    <td style="font-size:13px;color:#6b7280;padding-bottom:8px;">Période</td>
    <td style="font-size:13px;color:#1a202c;text-align:right;padding-bottom:8px;">{$period}</td>
  </tr>
  <tr style="border-top:2px solid #37a000;">
    <td style="font-size:16px;font-weight:bold;color:#1a202c;padding-top:12px;">TOTAL</td>
    <td style="font-size:20px;font-weight:bold;color:#37a000;text-align:right;padding-top:12px;">{$amount}</td>
  </tr>
</table>

<div style="background:#fef3c7;border-radius:8px;padding:14px 18px;margin-bottom:20px;">
  <p style="margin:0;font-size:13px;color:#92400e;">
    ⏳ Cette facture est en attente de règlement. Veuillez contacter votre commercial pour effectuer le paiement.
  </p>
</div>
{$notes}
HTML;
    }

    private function _tpl_payment_confirmed(array $inv): string {
        $name   = htmlspecialchars($inv['business_name'] ?? '');
        $num    = htmlspecialchars($inv['invoice_number']);
        $amount = $this->_fmt((float)$inv['amount']);
        $method = strtoupper($inv['payment_method'] ?? '');
        $date   = date('d/m/Y à H\hi', strtotime($inv['paid_at'] ?? 'now'));
        return <<<HTML
<h2 style="margin:0 0 8px;color:#1a202c;">Paiement reçu ✅</h2>
<p style="color:#4a5568;line-height:1.7;margin:0 0 24px;">
  Bonjour <strong>{$name}</strong>,<br>
  Nous avons bien reçu votre paiement. Merci !
</p>

<div style="background:#d1fae5;border-radius:10px;padding:20px 24px;margin-bottom:24px;">
  <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td style="font-size:13px;color:#065f46;padding-bottom:6px;">Facture</td>
      <td style="font-size:13px;font-weight:bold;color:#065f46;text-align:right;">{$num}</td>
    </tr>
    <tr>
      <td style="font-size:13px;color:#065f46;padding-bottom:6px;">Montant</td>
      <td style="font-size:15px;font-weight:bold;color:#065f46;text-align:right;">{$amount}</td>
    </tr>
    <tr>
      <td style="font-size:13px;color:#065f46;padding-bottom:6px;">Méthode</td>
      <td style="font-size:13px;color:#065f46;text-align:right;">{$method}</td>
    </tr>
    <tr>
      <td style="font-size:13px;color:#065f46;">Date</td>
      <td style="font-size:13px;color:#065f46;text-align:right;">{$date}</td>
    </tr>
  </table>
</div>

<p style="color:#4a5568;font-size:13px;margin:0;">
  Votre abonnement est actif. Pour toute question, contactez-nous à {$this->company['email']}.
</p>
HTML;
    }

    private function _tpl_expiry_reminder(array $tenant, array $sub, int $days): string {
        $name    = htmlspecialchars($tenant['business_name']);
        $plan    = htmlspecialchars($sub['plan_name'] ?? '');
        $expiry  = date('d/m/Y', strtotime($sub['end_date']));
        $urgency = $days <= 1
            ? '<div style="background:#fee2e2;border-radius:8px;padding:14px;margin-bottom:20px;"><p style="margin:0;color:#991b1b;font-weight:bold;">🚨 Votre abonnement expire DEMAIN !</p></div>'
            : '<div style="background:#fef3c7;border-radius:8px;padding:14px;margin-bottom:20px;"><p style="margin:0;color:#92400e;">⚠️ Votre abonnement expire dans <strong>' . $days . ' jours</strong>.</p></div>';
        $contact = htmlspecialchars($this->company['email']);
        return <<<HTML
<h2 style="margin:0 0 8px;color:#1a202c;">Renouvellement de votre abonnement</h2>
<p style="color:#4a5568;line-height:1.7;margin:0 0 20px;">
  Bonjour <strong>{$name}</strong>,
</p>
{$urgency}
<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
  <tr>
    <td style="font-size:13px;color:#6b7280;padding-bottom:8px;">Plan actuel</td>
    <td style="font-size:13px;font-weight:bold;color:#1a202c;text-align:right;">{$plan}</td>
  </tr>
  <tr>
    <td style="font-size:13px;color:#6b7280;">Date d'expiration</td>
    <td style="font-size:13px;font-weight:bold;color:#dc2626;text-align:right;">{$expiry}</td>
  </tr>
</table>
<p style="color:#4a5568;font-size:14px;line-height:1.7;margin:0 0 20px;">
  Pour renouveler votre abonnement et éviter toute interruption de service, contactez-nous dès maintenant.
</p>
<div style="text-align:center;">
  <a href="mailto:{$contact}" style="background:#37a000;color:#fff;text-decoration:none;padding:14px 32px;border-radius:8px;font-weight:bold;display:inline-block;">
    Contacter Bonresto →
  </a>
</div>
HTML;
    }

    private function _tpl_suspended(array $tenant): string {
        $name    = htmlspecialchars($tenant['business_name']);
        $contact = htmlspecialchars($this->company['email']);
        return <<<HTML
<h2 style="margin:0 0 8px;color:#1a202c;">Accès suspendu</h2>
<p style="color:#4a5568;line-height:1.7;margin:0 0 20px;">
  Bonjour <strong>{$name}</strong>,<br>
  Votre accès à la plateforme Bonresto a été suspendu suite à l'expiration de votre abonnement.
</p>
<div style="background:#fee2e2;border-radius:8px;padding:16px;margin-bottom:24px;">
  <p style="margin:0;color:#991b1b;">⛔ Votre compte est actuellement suspendu.</p>
</div>
<p style="color:#4a5568;font-size:14px;line-height:1.7;margin:0 0 20px;">
  Pour réactiver votre accès, contactez-nous immédiatement. Vos données sont conservées et votre service sera rétabli dès réception du paiement.
</p>
<div style="text-align:center;">
  <a href="mailto:{$contact}" style="background:#37a000;color:#fff;text-decoration:none;padding:14px 32px;border-radius:8px;font-weight:bold;display:inline-block;">
    Réactiver mon accès →
  </a>
</div>
HTML;
    }
}
