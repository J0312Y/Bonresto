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
