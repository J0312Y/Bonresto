<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Saas_cors — en-tetes CORS pour la console SaaS.
 *
 * Audit F-21. Trois defauts corriges :
 *
 *   1. Toute origine « localhost » etait reflechie AVEC
 *      Access-Control-Allow-Credentials: true. N'importe quelle page servie
 *      depuis un localhost — un autre projet de la machine, un outil de
 *      developpement — pouvait donc appeler l'API avec les cookies de session.
 *   2. Hors localhost, l'origine etait figee a « http://localhost », ce qui
 *      rendait la console inutilisable en production.
 *   3. Le test portait sur REQUEST_URI, chaine de requete comprise.
 *
 * Les origines autorisees viennent desormais de SAAS_CORS_ORIGINS (liste
 * separee par des virgules). Les origines de boucle locale ne sont admises
 * qu'en environnement de developpement.
 */
class Saas_cors {

    public function handle() {
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
        if (strpos($uri, '/saas/') === false) {
            return;
        }

        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
        if ($origin === '') {
            return;
        }

        $autorisees = array_filter(array_map('trim', explode(',', (string) getenv('SAAS_CORS_ORIGINS'))));

        $admise = in_array($origin, $autorisees, true);

        // En developpement uniquement, tout port de boucle locale est admis.
        if (!$admise && ENVIRONMENT === 'development') {
            $admise = (bool) preg_match('#^https?://(localhost|127\.0\.0\.1)(:\d+)?$#', $origin);
        }

        // Origine non autorisee : aucun en-tete CORS. Le navigateur bloquera.
        if (!$admise) {
            if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
                http_response_code(403);
                exit;
            }
            return;
        }

        header('Access-Control-Allow-Origin: ' . $origin);
        header('Vary: Origin');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Authorization, Content-Type, X-Requested-With, X-Api-Key');
        header('Access-Control-Max-Age: 600');

        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
            http_response_code(204);
            exit;
        }
    }
}
