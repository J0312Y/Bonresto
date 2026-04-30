<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Bonresto SaaS — Email Configuration
| -------------------------------------------------------------------------
| Remplir avec les vraies credentials SMTP avant mise en production.
| Protocol: smtp | sendmail | mail
*/

$config['saas_email'] = [
    'protocol'   => 'smtp',
    'smtp_host'  => 'smtp.gmail.com',   // ou smtp.mailtrap.io pour les tests
    'smtp_port'  => 587,
    'smtp_crypto'=> 'tls',
    'smtp_user'  => 'votre@email.com',  // à configurer
    'smtp_pass'  => 'votre_mot_de_passe',
    'from_email' => 'noreply@bonresto.com',
    'from_name'  => 'Bonresto SaaS',
    'charset'    => 'utf-8',
    'mailtype'   => 'html',
    'newline'    => "\r\n",
    'crlf'       => "\r\n",
];

// Clé secrète pour le cron automatique (changer avant mise en production)
$config['saas_cron_key'] = 'bonresto-cron-secret-2026';

// Infos de la société pour les factures et emails
$config['saas_company'] = [
    'name'    => 'Bonresto',
    'address' => 'Abidjan, Côte d\'Ivoire',
    'email'   => 'contact@bonresto.com',
    'phone'   => '+225 00 00 00 00',
    'website' => 'https://bonresto.com',
    'logo_url'=> '', // URL absolue du logo
];
