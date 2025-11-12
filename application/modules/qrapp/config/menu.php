<?php
// =====================================================================
// HMVC Menu configuration for QR App module (Bonresto / Bhojon system)
// =====================================================================

$HmvcMenu["qrapp"] = array(
    // Icône du module dans la sidebar
    "icon"  => "<i class='fa fa-qrcode' aria-hidden='true'></i>",
    "label" => "QR App",

    // =============================
    // Liste des sous-menus du module
    // =============================

    // 1️⃣ Gestion des tables QR
    "qr_table" => array(
        "controller" => "Qrtable",
        "method"     => "index",
        "permission" => "read",
        "menu_name"  => "QR Tables",
    ),

    // 2️⃣ Gestion des menus QR
    "qr_menu" => array(
        "controller" => "Qrmenu",
        "method"     => "index",
        "permission" => "read",
        "menu_name"  => "QR Menus",
    ),

    // 3️⃣ Paramètres de paiement QR
    "qr_payment" => array(
        "controller" => "Qrpayment",
        "method"     => "index",
        "permission" => "read",
        "menu_name"  => "Payment Settings",
    ),

    // 4️⃣ Historique ou statistiques (si tu veux)
    "qr_report" => array(
        "controller" => "Qrreport",
        "method"     => "index",
        "permission" => "read",
        "menu_name"  => "Reports",
    ),
);

