<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sync_cron — Déclencheur de synchronisation Local ↔ VPS
 *
 * Ce contrôleur tourne sur le serveur LOCAL.
 * Il est appelé par le cron système toutes les minutes :
 *
 *   * * * * * curl -s "http://localhost/bonresto/index.php/sync_cron/run?key=SECRET" > /dev/null 2>&1
 *
 * Il peut aussi être appelé manuellement pour forcer une sync immédiate.
 *
 * Routes :
 *   GET /sync_cron/run?key=<SYNC_CRON_KEY>
 */
class Sync_cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * GET /sync_cron/run?key=<SYNC_CRON_KEY>
     * Lance un cycle complet push + pull.
     */
    public function run(): void {
        // Authentification par clé secrète (protège l'endpoint cron)
        $key      = $this->input->get('key');
        $expected = getenv('SYNC_CRON_KEY') ?: 'bonresto-sync-cron-2024';

        if ($key !== $expected) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Forbidden']);
            exit;
        }

        $this->load->library('Sync_manager');
        $result = $this->sync_manager->run();

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }
}
