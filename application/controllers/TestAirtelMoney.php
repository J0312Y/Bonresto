<?php
require_once(APPPATH . 'controllers/Api.php');

class TestAirtelMoney extends Api {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('payment_methods/MobileMoneyMethod');
    }

    public function test_payment() {
        // Données de test
        $testData = array(
            'order_id' => '123',
            'phone_number' => '0899123456', // Numéro de test Airtel
            'amount' => 1000.00
        );

        try {
            // Initier le paiement
            $result = $this->mobilemoney->processAirtelMoney($testData);
            
            echo "Résultat initial:\n";
            print_r($result);

            if ($result['status'] === 'success') {
                // Attendre quelques secondes
                sleep(5);

                // Vérifier le statut
                $this->load->library('AirtelMoneyAPI');
                $status = $this->airtelmoney->checkTransactionStatus($result['transaction_id']);
                
                echo "\nStatut de la transaction:\n";
                print_r($status);
            }

        } catch (Exception $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }
}