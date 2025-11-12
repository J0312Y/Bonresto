<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Configuration Airtel Money
|--------------------------------------------------------------------------
|
| Configuration pour l'intégration de l'API Airtel Money
|
*/

$config['airtel_money'] = array(
    'client_id' => 'YOUR_CLIENT_ID',
    'client_secret' => 'YOUR_CLIENT_SECRET',
    'api_base_url' => 'https://openapiuat.airtel.africa', // URL de test
    'country_code' => 'CD', // Code pays pour RDC
    'currency_code' => 'CDF', // Franc Congolais
    'environment' => 'sandbox', // 'sandbox' ou 'production'
    
    // Points d'accès de l'API
    'endpoints' => array(
        'auth' => '/auth/oauth2/token',
        'payment' => '/merchant/v1/payments/',
        'transaction' => '/standard/v1/payments/',
        'refund' => '/standard/v1/payments/refund'
    )
);