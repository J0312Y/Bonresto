<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

// SaaS CORS — must run before routing so OPTIONS preflight is handled
$hook['pre_system'][] = [
    'class'    => 'Saas_cors',
    'function' => 'handle',
    'filename' => 'Saas_cors.php',
    'filepath' => 'hooks',
];

// License check — runs after every controller is constructed
$hook['post_controller_constructor'][] = [
    'class'    => 'License_check',
    'function' => 'check',
    'filename' => 'License_check.php',
    'filepath' => 'hooks',
];

// Tenant detection — switches DB based on subdomain.
//
// DOIT rester sur `pre_system`, et non `pre_controller`.
//
// MX/Base.php (HMVC) se termine par `new CI;` : il instancie un CI_Controller
// au chargement du fichier, ce qui declenche l'autoload de `database`. Cela se
// produit pendant load_class('Router'), donc AVANT `pre_controller`. La
// connexion etait alors etablie sur la base par defaut.
//
// Un CI_Controller classique s'en sortait — sa construction rejoue l'autoload
// global, qui relit config/database.php une fois la bascule faite. Mais
// MX_Controller ne rejoue que l'autoload du module : TOUS les controleurs de
// modules (reservation, qrapp, ordermanage, report, itemmanage...) servaient
// la base du tenant par defaut, quel que soit le sous-domaine.
//
// Le defaut restait invisible tant qu'un seul tenant reel pointait sur la base
// par defaut. Au deuxieme client, son back-office aurait affiche et modifie
// les donnees du premier.
$hook['pre_system'][] = [
    'class'    => 'TenantHook',
    'function' => 'detect',
    'filename' => 'TenantHook.php',
    'filepath' => 'hooks',
];

// Sync tick — DISABLED: Sync_manager library does not exist yet
// $hook['post_system'][] = [
//     'class'    => 'Sync_tick',
//     'function' => 'tick',
//     'filename' => 'Sync_tick.php',
//     'filepath' => 'hooks',
// ];
