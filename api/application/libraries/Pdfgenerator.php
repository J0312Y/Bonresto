<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdfgenerator {

    public function __construct()
    {
        // Charger l’autoloader de Composer
        require_once FCPATH . 'vendor/autoload.php';
    }

    public function generate($html, $filename = '', $stream = TRUE, $paper = 'A4', $orientation = 'portrait')
    {
        // Options Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true); // autorise les images et CSS externes

        // Initialisation Dompdf
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();

        if ($stream) {
            // Afficher dans le navigateur
            $dompdf->stream($filename . ".pdf", array("Attachment" => 0));
        } else {
            // Retourner le PDF en string
            return $dompdf->output();
        }
    }
}
