<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AirtelMoneyAPI {
    private $ci;
    private $config;
    private $access_token;
    private $token_expires;

    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->config->load('airtel_money', TRUE);
        $this->config = $this->ci->config->item('airtel_money');
        
        // Charger la librairie pour les logs
        $this->ci->load->library('Logger');
    }

    /**
     * Obtenir un token d'accès
     */
    private function getAccessToken() {
        // Vérifier si nous avons déjà un token valide
        if ($this->access_token && $this->token_expires > time()) {
            return $this->access_token;
        }

        $url = $this->config['api_base_url'] . $this->config['endpoints']['auth'];
        
        $headers = array(
            'Content-Type: application/json'
        );

        $data = array(
            'client_id' => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'grant_type' => 'client_credentials'
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode !== 200) {
            $this->ci->logger->error('Airtel Money Auth Error', [
                'response' => $response,
                'httpCode' => $httpCode
            ]);
            throw new Exception('Échec de l\'authentification Airtel Money');
        }

        $result = json_decode($response, true);
        if (!isset($result['access_token'])) {
            throw new Exception('Token non reçu de Airtel Money');
        }

        $this->access_token = $result['access_token'];
        $this->token_expires = time() + ($result['expires_in'] ?? 3600);

        return $this->access_token;
    }

    /**
     * Initier un paiement
     */
    public function initiatePayment($phoneNumber, $amount, $reference) {
        try {
            $token = $this->getAccessToken();
            
            $url = $this->config['api_base_url'] . $this->config['endpoints']['payment'];
            
            $headers = array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token,
                'X-Country: ' . $this->config['country_code'],
                'X-Currency: ' . $this->config['currency_code']
            );

            $data = array(
                'reference' => $reference,
                'subscriber' => array(
                    'country' => $this->config['country_code'],
                    'currency' => $this->config['currency_code'],
                    'msisdn' => $phoneNumber
                ),
                'transaction' => array(
                    'amount' => $amount,
                    'country' => $this->config['country_code'],
                    'currency' => $this->config['currency_code'],
                    'id' => $reference
                )
            );

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data)
            ));

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            // Logger la réponse
            $this->ci->logger->info('Airtel Money Payment Response', [
                'reference' => $reference,
                'response' => $response,
                'httpCode' => $httpCode
            ]);

            if ($httpCode !== 200 && $httpCode !== 202) {
                throw new Exception('Échec de l\'initiation du paiement: ' . $response);
            }

            $result = json_decode($response, true);
            
            return array(
                'status' => 'success',
                'transaction_id' => $result['transaction']['id'] ?? $reference,
                'message' => 'Paiement initié avec succès',
                'data' => $result
            );

        } catch (Exception $e) {
            $this->ci->logger->error('Airtel Money Payment Error', [
                'reference' => $reference,
                'error' => $e->getMessage()
            ]);

            return array(
                'status' => 'error',
                'message' => $e->getMessage()
            );
        }
    }

    /**
     * Vérifier le statut d'une transaction
     */
    public function checkTransactionStatus($transactionId) {
        try {
            $token = $this->getAccessToken();
            
            $url = $this->config['api_base_url'] . $this->config['endpoints']['transaction'] . $transactionId;
            
            $headers = array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token,
                'X-Country: ' . $this->config['country_code'],
                'X-Currency: ' . $this->config['currency_code']
            );

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers
            ));

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($httpCode !== 200) {
                throw new Exception('Échec de la vérification du statut');
            }

            $result = json_decode($response, true);
            
            return array(
                'status' => 'success',
                'transaction_status' => $result['status'] ?? 'UNKNOWN',
                'data' => $result
            );

        } catch (Exception $e) {
            return array(
                'status' => 'error',
                'message' => $e->getMessage()
            );
        }
    }
}