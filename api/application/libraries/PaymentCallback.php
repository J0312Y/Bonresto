<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentCallback {
    private $ci;
    private $timeout = 300; // 5 minutes timeout par défaut
    
    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->database();
    }

    // Enregistrer une nouvelle transaction en attente
    public function registerPendingPayment($data) {
        $transaction = array(
            'order_id' => $data['order_id'],
            'payment_method_id' => $data['payment_method_id'],
            'phone_number' => $data['phone_number'],
            'amount' => $data['amount'],
            'reference' => $this->generateReference(),
            'status' => 'PENDING',
            'created_at' => date('Y-m-d H:i:s'),
            'expires_at' => date('Y-m-d H:i:s', time() + $this->timeout)
        );

        $this->ci->db->insert('payment_transactions', $transaction);
        return $transaction['reference'];
    }

    // Vérifier et mettre à jour le statut d'une transaction
    public function checkTransactionStatus($reference) {
        $transaction = $this->ci->db->get_where('payment_transactions', ['reference' => $reference])->row();
        
        if (!$transaction) {
            return ['status' => 'error', 'message' => 'Transaction introuvable'];
        }

        // Vérifier si la transaction a expiré
        if (strtotime($transaction->expires_at) < time()) {
            $this->updateTransactionStatus($reference, 'EXPIRED');
            return ['status' => 'error', 'message' => 'Transaction expirée'];
        }

        return [
            'status' => 'success',
            'payment_status' => $transaction->status,
            'transaction' => $transaction
        ];
    }

    // Mettre à jour le statut d'une transaction
    public function updateTransactionStatus($reference, $status, $provider_data = null) {
        $update = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($provider_data) {
            $update['provider_data'] = json_encode($provider_data);
        }

        $this->ci->db->where('reference', $reference)
                     ->update('payment_transactions', $update);

        // Si le paiement est réussi, mettre à jour la commande
        if ($status === 'SUCCESS') {
            $transaction = $this->ci->db->get_where('payment_transactions', ['reference' => $reference])->row();
            if ($transaction) {
                $this->ci->db->where('order_id', $transaction->order_id)
                            ->update('customer_order', [
                                'order_status' => 1,
                                'paid_status' => 1,
                                'payment_details' => json_encode([
                                    'reference' => $reference,
                                    'method' => $transaction->payment_method_id,
                                    'phone' => $transaction->phone_number,
                                    'amount' => $transaction->amount,
                                    'paid_at' => date('Y-m-d H:i:s')
                                ])
                            ]);
            }
        }

        return true;
    }

    // Vérifier les transactions expirées
    public function checkExpiredTransactions() {
        $expired = $this->ci->db->where('status', 'PENDING')
                               ->where('expires_at <', date('Y-m-d H:i:s'))
                               ->get('payment_transactions')
                               ->result();

        foreach ($expired as $transaction) {
            $this->updateTransactionStatus($transaction->reference, 'EXPIRED');
        }

        return count($expired);
    }

    private function generateReference() {
        return uniqid('PAY_') . '_' . time();
    }
}