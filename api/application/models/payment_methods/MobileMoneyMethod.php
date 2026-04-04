<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MobileMoneyMethod {
    private $ci;
    private $maxRetries = 3;
    private $retryDelay = 2; // secondes

    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->library('PhoneValidator');
        $this->ci->load->library('PaymentCallback');
    }

    public function processAirtelMoney($data) {
        // Valider le numéro de téléphone
        $validation = PhoneValidator::validate($data['phone_number'], 'Airtel');
        if (!$validation['isValid']) {
            return array(
                'status' => 'error',
                'message' => $validation['message']
            );
        }

        // Enregistrer la transaction en attente
        $reference = $this->ci->paymentcallback->registerPendingPayment([
            'order_id' => $data['order_id'],
            'payment_method_id' => 8,
            'phone_number' => $validation['formattedNumber'],
            'amount' => $data['amount']
        ]);

        try {
            // Tentative d'initiation du paiement avec retry
            $result = $this->initiateAirtelPayment($data, $validation['formattedNumber'], $reference);
            
            if ($result['status'] === 'success') {
                return array(
                    'status' => 'success',
                    'message' => 'Paiement Airtel Money initié',
                    'reference' => $reference,
                    'transaction_id' => $result['transaction_id'],
                    'payment_method_id' => 8
                );
            }

            // En cas d'échec, marquer comme échoué
            $this->ci->paymentcallback->updateTransactionStatus($reference, 'FAILED', $result);
            return array(
                'status' => 'error',
                'message' => $result['message'],
                'reference' => $reference
            );

        } catch (Exception $e) {
            // Logger l'erreur
            log_message('error', 'Airtel Money Error: ' . $e->getMessage());
            
            // Marquer la transaction comme échouée
            $this->ci->paymentcallback->updateTransactionStatus($reference, 'FAILED', [
                'error' => $e->getMessage()
            ]);

            return array(
                'status' => 'error',
                'message' => 'Erreur technique lors du paiement',
                'reference' => $reference
            );
        }
    }

    public function processMTNMoney($data) {
        // Valider le numéro de téléphone
        $validation = PhoneValidator::validate($data['phone_number'], 'MTN');
        if (!$validation['isValid']) {
            return array(
                'status' => 'error',
                'message' => $validation['message']
            );
        }

        // Enregistrer la transaction en attente
        $reference = $this->ci->paymentcallback->registerPendingPayment([
            'order_id' => $data['order_id'],
            'payment_method_id' => 9,
            'phone_number' => $validation['formattedNumber'],
            'amount' => $data['amount']
        ]);

        try {
            // Tentative d'initiation du paiement avec retry
            $result = $this->initiateMTNPayment($data, $validation['formattedNumber'], $reference);
            
            if ($result['status'] === 'success') {
                return array(
                    'status' => 'success',
                    'message' => 'Paiement MTN Money initié',
                    'reference' => $reference,
                    'transaction_id' => $result['transaction_id'],
                    'payment_method_id' => 9
                );
            }

            // En cas d'échec, marquer comme échoué
            $this->ci->paymentcallback->updateTransactionStatus($reference, 'FAILED', $result);
            return array(
                'status' => 'error',
                'message' => $result['message'],
                'reference' => $reference
            );

        } catch (Exception $e) {
            // Logger l'erreur
            log_message('error', 'MTN Money Error: ' . $e->getMessage());
            
            // Marquer la transaction comme échouée
            $this->ci->paymentcallback->updateTransactionStatus($reference, 'FAILED', [
                'error' => $e->getMessage()
            ]);

            return array(
                'status' => 'error',
                'message' => 'Erreur technique lors du paiement',
                'reference' => $reference
            );
        }
    }

    private function initiateAirtelPayment($data, $phone, $reference) {
        $this->ci->load->library('AirtelMoneyAPI');

        for ($attempt = 1; $attempt <= $this->maxRetries; $attempt++) {
            try {
                $result = $this->ci->airtelmoney->initiatePayment(
                    $phone,
                    $data['amount'],
                    $reference
                );

                if ($result['status'] === 'success') {
                    // Enregistrer les détails de la transaction
                    $this->ci->paymentcallback->updateTransactionStatus(
                        $reference, 
                        'PENDING', 
                        [
                            'airtel_transaction_id' => $result['transaction_id'],
                            'provider_response' => $result['data']
                        ]
                    );

                    return $result;
                }

                throw new Exception($result['message']);
            } catch (Exception $e) {
                if ($attempt === $this->maxRetries) {
                    throw $e;
                }
                sleep($this->retryDelay);
                continue;
            }
        }
    }

    private function initiateMTNPayment($data, $phone, $reference) {
        for ($attempt = 1; $attempt <= $this->maxRetries; $attempt++) {
            try {
                // TODO: Intégrer l'API réelle de MTN Mobile Money ici
                // Simulation d'une réponse API
                return [
                    'status' => 'success',
                    'transaction_id' => 'MTN_' . time(),
                    'message' => 'Transaction initiée'
                ];
            } catch (Exception $e) {
                if ($attempt === $this->maxRetries) {
                    throw $e;
                }
                sleep($this->retryDelay);
            }
        }
    }
}