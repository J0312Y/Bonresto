<?php
// module name
$HmvcMenu["qrapp"] = array(
    // icône du module
    "icon" => "<i class='fa fa-qrcode' aria-hidden='true'></i>", 

    // Liste des QR commandes
    "qr_order_list" => array(
        "controller" => "qrorder",
        "method"     => "index",
        "permission" => "read"
    ),

    // QR de toutes les tables
    "all_table_qr" => array(
        "controller" => "qrtable",
        "method"     => "index",
        "permission" => "read"
    ),

    // Paramètres de paiement QR
    "qr_payment_setting" => array(
        "controller" => "qrpayment",
        "method"     => "index",
        "permission" => "update"
    ),
);
