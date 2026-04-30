<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/Saas_base.php';

class Payments extends Saas_base {

    /** GET /saas/payments */
    public function index() {
        $this->require_auth();
        $payments = $this->Saas_model->get_all_payments();
        foreach ($payments as &$p) {
            $p['payment_id'] = (int)$p['payment_id'];
            $p['amount']     = (float)$p['amount'];
        }
        $this->_json($payments);
    }

    /** POST /saas/payments — record a manual payment */
    public function create() {
        $this->require_auth();
        $body = $this->_body();

        if (empty($body['tenant_id']) || empty($body['amount'])) {
            $this->_abort(400, 'tenant_id et amount sont requis.');
        }

        $id = $this->Saas_model->record_payment([
            'tenant_id'  => (int)$body['tenant_id'],
            'plan_id'    => (int)($body['plan_id'] ?? 0),
            'amount'     => (float)$body['amount'],
            'currency'   => $body['currency'] ?? 'EUR',
            'status'     => $body['status'] ?? 'paid',
            'reference'  => $body['reference'] ?? null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->Saas_model->log_activity((int)$body['tenant_id'], 'payment_recorded', 'Paiement enregistré', [
            'amount'    => $body['amount'],
            'reference' => $body['reference'] ?? null,
        ]);

        $this->_json(['payment_id' => $id], 201);
    }
}
