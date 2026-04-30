<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saas_jwt {

    private $secret;
    private $ttl = 86400; // 24 hours

    public function __construct() {
        $this->secret = getenv('SAAS_JWT_SECRET') ?: 'BonrestoSaasSecret2024!ChangeMe';
    }

    /** Generate a signed JWT token */
    public function generate(array $payload): string {
        $header  = $this->base64url(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
        $payload['iat'] = time();
        $payload['exp'] = time() + $this->ttl;
        $body    = $this->base64url(json_encode($payload));
        $sig     = $this->base64url(hash_hmac('sha256', "$header.$body", $this->secret, true));
        return "$header.$body.$sig";
    }

    /** Verify and decode a token. Returns payload array or null. */
    public function verify(string $token): ?array {
        $parts = explode('.', $token);
        if (count($parts) !== 3) return null;

        [$header, $body, $sig] = $parts;
        $expected = $this->base64url(hash_hmac('sha256', "$header.$body", $this->secret, true));

        if (!hash_equals($expected, $sig)) return null;

        $payload = json_decode($this->base64url_decode($body), true);
        if (!$payload || $payload['exp'] < time()) return null;

        return $payload;
    }

    /** Extract token from Authorization header */
    public function fromHeader(): ?string {
        $header = $_SERVER['HTTP_AUTHORIZATION']
               ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION']
               ?? apache_request_headers()['Authorization']
               ?? null;

        if ($header && preg_match('/Bearer\s+(.+)/i', $header, $m)) {
            return $m[1];
        }
        return null;
    }

    private function base64url(string $data): string {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64url_decode(string $data): string {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', (4 - strlen($data) % 4) % 4));
    }
}
