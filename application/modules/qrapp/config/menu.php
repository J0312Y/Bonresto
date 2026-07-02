<?php
// =====================================================================
// HMVC Menu configuration for QR App module (Bonresto / Bhojon system)
// =====================================================================

$HmvcMenu["qrapp"] = array(
    // Icône du module dans la sidebar
    "icon"  => "<i class='fa fa-qrcode' aria-hidden='true'></i>",
    "label" => "QR App",

    // 1 - Liste des commandes QR
    "qr_order" => array(
        "controller" => "Qrorder",
        "method"     => "index",
        "permission" => "read",
        "menu_name"  => "QR Order List",
    ),

    // 2 - Gestion des tables QR
    "qr_table" => array(
        "controller" => "Qrtable",
        "method"     => "index",
        "permission" => "read",
        "menu_name"  => "All QR Tables",
    ),

    // 3 - Parametres de paiement QR
    "qr_payment" => array(
        "controller" => "Qrpayment",
        "method"     => "index",
        "permission" => "read",
        "menu_name"  => "QR Payment Settings",
    ),
);
