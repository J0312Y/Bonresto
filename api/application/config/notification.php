<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Notification Configuration — 100% OneSignal
|--------------------------------------------------------------------------
| Toutes les notifications passent par OneSignal.
| L'ancienne API FCM Legacy a été désactivée par Google le 20 juin 2024.
|--------------------------------------------------------------------------
*/

// OneSignal - Même App ID pour tous (compte unique)
$config['onesignal_staff_app_id']      = '78ed384b-6ad2-47d0-9b57-c944ee4a2470';
$config['onesignal_waiter_ios_app_id'] = '78ed384b-6ad2-47d0-9b57-c944ee4a2470';
$config['onesignal_customer_app_id']   = '78ed384b-6ad2-47d0-9b57-c944ee4a2470';
$config['onesignal_hungry_app_id']     = '78ed384b-6ad2-47d0-9b57-c944ee4a2470';

// OneSignal REST API Key — hors du depot.
//
// Elle etait ecrite en clair ici, dans un fichier suivi par git et sur un
// depot public : elle a donc fuite, et la protection de GitHub a refuse le
// commit qui en ajoutait une nouvelle. Elle vit desormais dans .env, comme
// les autres secrets depuis l'audit F-01.
//
// env_get et non env_required : une cle absente doit degrader les
// notifications, pas empecher toute l'API de demarrer.
$config['onesignal_api_key']           = env_get('ONESIGNAL_API_KEY', '');