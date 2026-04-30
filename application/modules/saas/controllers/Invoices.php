<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/Saas_base.php';

class Invoices extends Saas_base {

    /** GET /saas/invoices[?tenant_id=X] */
    public function index() {
        $this->require_auth();
        $tenant_id = (int)($this->input->get('tenant_id') ?? 0);
        $this->_json($this->Saas_model->get_all_invoices($tenant_id));
    }

    /** GET /saas/invoices/{id} */
    public function show(int $id) {
        $this->require_auth();
        $invoice = $this->Saas_model->get_invoice($id);
        if (!$invoice) $this->_abort(404, 'Facture introuvable.');
        $this->_json($invoice);
    }

    /** GET /saas/invoices/{id}/pdf — streams the PDF to the browser */
    public function pdf(int $id) {
        $this->require_auth();
        $invoice = $this->Saas_model->get_invoice($id);
        if (!$invoice) $this->_abort(404, 'Facture introuvable.');

        $html = $this->_invoice_pdf_html($invoice);

        $this->load->library('pdfgenerator');
        // stream = true → sends directly to browser
        $this->pdfgenerator->generate(
            $html,
            'Facture-' . $invoice['invoice_number'],
            true
        );
    }

    /** POST /saas/invoices */
    public function create() {
        $this->require_auth();
        $body = $this->_body();

        if (empty($body['tenant_id']) || empty($body['amount'])) {
            $this->_abort(400, 'tenant_id et amount sont requis.');
        }

        $id      = $this->Saas_model->create_invoice($body);
        $invoice = $this->Saas_model->get_invoice($id);

        $this->Saas_model->log_activity(
            (int)$body['tenant_id'],
            'invoice_created',
            'Facture créée : ' . $invoice['invoice_number'],
            ['by_admin' => $this->saas_admin['email'], 'amount' => $body['amount']]
        );

        // Send invoice email — if it succeeds, mark as 'sent'
        try {
            $this->load->library('saas_mailer');
            $ok = $this->saas_mailer->send_invoice($invoice);
            if ($ok) {
                $this->Saas_model->update_invoice_status($id, 'sent');
                $invoice['status'] = 'sent';
            }
        } catch (Throwable $e) {
            log_message('error', 'Invoice email failed: ' . $e->getMessage());
        }

        $this->_json($invoice, 201);
    }

    /** POST /saas/invoices/{id}/confirm */
    public function confirm(int $id) {
        $this->require_auth();
        $body   = $this->_body();
        $method = $body['payment_method'] ?? 'autre';

        $invoice = $this->Saas_model->get_invoice($id);
        if (!$invoice) $this->_abort(404, 'Facture introuvable.');
        if ($invoice['status'] === 'paid') $this->_abort(400, 'Facture déjà payée.');

        $this->Saas_model->confirm_payment($id, $method);
        $invoice = $this->Saas_model->get_invoice($id); // fresh with paid_at

        $this->Saas_model->log_activity(
            (int)$invoice['tenant_id'],
            'payment_confirmed',
            'Paiement confirmé — ' . $invoice['invoice_number'] . ' via ' . strtoupper($method),
            ['by_admin' => $this->saas_admin['email'], 'amount' => $invoice['amount'], 'method' => $method]
        );

        // Send payment confirmation email
        try {
            $this->load->library('saas_mailer');
            $this->saas_mailer->send_payment_confirmation($invoice);
        } catch (Throwable $e) {
            log_message('error', 'Payment confirmation email failed: ' . $e->getMessage());
        }

        $this->_json($invoice);
    }

    /** POST /saas/invoices/{id}/send — (re)send invoice email + set status to sent */
    public function send(int $id) {
        $this->require_auth();
        $invoice = $this->Saas_model->get_invoice($id);
        if (!$invoice) $this->_abort(404, 'Facture introuvable.');
        if ($invoice['status'] === 'paid') $this->_abort(400, 'La facture est déjà payée.');
        if ($invoice['status'] === 'cancelled') $this->_abort(400, 'La facture est annulée.');

        $this->load->library('saas_mailer');
        $ok = $this->saas_mailer->send_invoice($invoice);

        if (!$ok) $this->_abort(500, 'Échec de l\'envoi de l\'email. Vérifiez la configuration SMTP.');

        $this->Saas_model->update_invoice_status($id, 'sent');

        $this->Saas_model->log_activity(
            (int)$invoice['tenant_id'],
            'invoice_sent',
            'Facture envoyée par email — ' . $invoice['invoice_number'],
            ['by_admin' => $this->saas_admin['email'], 'to' => $invoice['client_email']]
        );

        $this->_json($this->Saas_model->get_invoice($id));
    }

    /** GET /saas/invoices/export — CSV download */
    public function export() {
        $this->require_auth();
        $invoices = $this->Saas_model->get_all_invoices(0);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="factures-' . date('Y-m-d') . '.csv"');

        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($out, ['Numéro', 'Client', 'Email', 'Plan', 'Montant (FCFA)', 'Statut', 'Méthode', 'Période début', 'Période fin', 'Payée le', 'Créée le'], ';');

        foreach ($invoices as $inv) {
            fputcsv($out, [
                $inv['invoice_number'],
                $inv['business_name'] ?? '',
                $inv['client_email'] ?? '',
                $inv['plan_name'] ?? '',
                $inv['amount'],
                $inv['status'],
                $inv['payment_method'] ?? '',
                $inv['period_start'] ?? '',
                $inv['period_end'] ?? '',
                $inv['paid_at'] ?? '',
                $inv['created_at'],
            ], ';');
        }
        fclose($out);
        exit;
    }

    /** POST /saas/invoices/{id}/cancel */
    public function cancel(int $id) {
        $this->require_auth();
        $invoice = $this->Saas_model->get_invoice($id);
        if (!$invoice) $this->_abort(404, 'Facture introuvable.');
        if ($invoice['status'] === 'paid') $this->_abort(400, 'Impossible d\'annuler une facture payée.');

        $this->Saas_model->update_invoice_status($id, 'cancelled');

        $this->Saas_model->log_activity(
            (int)$invoice['tenant_id'],
            'invoice_cancelled',
            'Facture annulée : ' . $invoice['invoice_number'],
            ['by_admin' => $this->saas_admin['email']]
        );

        $this->_json(['success' => true]);
    }

    // ── PDF HTML template ──────────────────────────────────────────────────

    private function _invoice_pdf_html(array $inv): string {
        $this->config->load('saas_email');
        $co      = $this->config->item('saas_company');
        $num     = htmlspecialchars($inv['invoice_number']);
        $name    = htmlspecialchars($inv['business_name'] ?? '');
        $email   = htmlspecialchars($inv['client_email'] ?? '');
        $plan    = htmlspecialchars($inv['plan_name'] ?? '—');
        $amount  = number_format((float)$inv['amount'], 0, ',', ' ') . ' FCFA';
        $date    = date('d/m/Y', strtotime($inv['created_at']));
        $status  = $inv['status'];
        $badge   = match($status) {
            'paid'      => ['label' => 'PAYÉE', 'bg' => '#d1fae5', 'color' => '#065f46'],
            'cancelled' => ['label' => 'ANNULÉE', 'bg' => '#fee2e2', 'color' => '#991b1b'],
            default     => ['label' => 'EN ATTENTE', 'bg' => '#fef3c7', 'color' => '#92400e'],
        };
        $period  = ($inv['period_start'] && $inv['period_end'])
            ? date('d/m/Y', strtotime($inv['period_start'])) . ' — ' . date('d/m/Y', strtotime($inv['period_end']))
            : '—';
        $method  = $inv['payment_method'] ? strtoupper($inv['payment_method']) : '';
        $paid_at = $inv['paid_at'] ? date('d/m/Y à H\hi', strtotime($inv['paid_at'])) : '';
        $notes   = $inv['notes'] ? '<p style="font-size:12px;color:#6b7280;margin-top:8px;"><em>' . htmlspecialchars($inv['notes']) . '</em></p>' : '';

        return <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 13px; color: #1a202c; background: #fff; padding: 40px; }
  .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 36px; border-bottom: 3px solid #37a000; padding-bottom: 20px; }
  .logo-text { font-size: 22px; font-weight: bold; color: #2c3136; }
  .logo-text span { color: #37a000; }
  .company-info { font-size: 11px; color: #6b7280; text-align: right; line-height: 1.6; }
  .invoice-title { font-size: 28px; font-weight: bold; color: #2c3136; margin-bottom: 4px; }
  .invoice-meta { font-size: 12px; color: #6b7280; margin-bottom: 24px; }
  .badge { display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: bold; }
  .section { margin-bottom: 24px; }
  table.info { width: 100%; border-collapse: collapse; }
  table.info td { padding: 8px 10px; font-size: 13px; border-bottom: 1px solid #f0f0f0; }
  table.info td:first-child { color: #6b7280; width: 40%; }
  table.total { width: 100%; border-collapse: collapse; margin-top: 20px; }
  table.total td { padding: 10px 10px; }
  table.total tr.total-row td { font-size: 16px; font-weight: bold; border-top: 2px solid #37a000; padding-top: 12px; }
  table.total tr.total-row td:last-child { color: #37a000; text-align: right; font-size: 20px; }
  .footer { margin-top: 40px; border-top: 1px solid #e5e7eb; padding-top: 16px; font-size: 11px; color: #9ca3af; text-align: center; }
</style>
</head>
<body>

<div class="header">
  <div>
    <div class="logo-text">Bon<span>resto</span> SaaS</div>
    <div style="font-size:11px;color:#6b7280;margin-top:4px;">{$co['address']}</div>
  </div>
  <div class="company-info">
    {$co['name']}<br>
    {$co['email']}<br>
    {$co['phone']}
  </div>
</div>

<div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:28px;">
  <div>
    <div class="invoice-title">Facture {$num}</div>
    <div class="invoice-meta">Émise le {$date}</div>
    <span class="badge" style="background:{$badge['bg']};color:{$badge['color']};">{$badge['label']}</span>
  </div>
  <div style="text-align:right;font-size:13px;color:#6b7280;">
    <strong style="display:block;color:#1a202c;font-size:14px;">{$name}</strong>
    {$email}
  </div>
</div>

<div class="section">
  <table class="info">
    <tr>
      <td>Plan</td>
      <td><strong>{$plan}</strong></td>
    </tr>
    <tr>
      <td>Période</td>
      <td>{$period}</td>
    </tr>
    {$this->_pdf_row_if('Méthode de paiement', $method)}
    {$this->_pdf_row_if('Date de paiement', $paid_at)}
  </table>
  {$notes}
</div>

<table class="total">
  <tr class="total-row">
    <td>TOTAL TTC</td>
    <td style="text-align:right;">{$amount}</td>
  </tr>
</table>

<div class="footer">
  {$co['name']} · {$co['address']} · {$co['email']} · {$co['phone']}
</div>

</body>
</html>
HTML;
    }

    private function _pdf_row_if(string $label, string $value): string {
        if ($value === '') return '';
        $l = htmlspecialchars($label);
        $v = htmlspecialchars($value);
        return "<tr><td>{$l}</td><td>{$v}</td></tr>";
    }
}
