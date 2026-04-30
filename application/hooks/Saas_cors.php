<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saas_cors {

    public function handle() {
        // Only apply to /saas/* routes
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        if (stripos($uri, '/saas/') === false) return;

        $allowed_origins = [
            'http://localhost:5173',   // Vite dev server
            'http://localhost:4173',   // Vite preview
            'http://localhost',
            'http://127.0.0.1',
        ];

        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
        $allow  = in_array($origin, $allowed_origins) ? $origin : $allowed_origins[0];

        header("Access-Control-Allow-Origin: $allow");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Authorization, Content-Type, X-Requested-With');

        // Respond immediately to preflight
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }
    }
}
