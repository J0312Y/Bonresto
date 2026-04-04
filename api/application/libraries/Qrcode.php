<?php
require_once APPPATH . 'libraries/qrg/qrlib.php';

class Qrcode
{
    public function generate($data, $filePath = null, $size = 10, $margin = 4)
    {

// Check if a file path is provided
        if ($filePath) {
            QRcode::png($data, $filePath, QR_ECLEVEL_L, $size, $margin);
            return $filePath; // Return the saved file path
        } else {
            QRcode::png($data, false, QR_ECLEVEL_L, $size, $margin);
        }

    }

}
