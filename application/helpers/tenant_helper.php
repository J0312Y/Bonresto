<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * tenant_helper — Fonctions de contrôle des features par plan SAAS
 *
 * can_use('reports')       → true/false selon le plan actif du tenant
 * is_superadmin()          → true si is_admin == 3 (compte Bonresto)
 * tenant_features()        → tableau complet des features
 */

if (!function_exists('tenant_features')) {
    function tenant_features(): array {
        static $cache = null;
        if ($cache !== null) return $cache;
        $raw = defined('CURRENT_TENANT_PLAN') ? CURRENT_TENANT_PLAN : '{}';
        $cache = json_decode($raw, true) ?: [];
        return $cache;
    }
}

if (!function_exists('can_use')) {
    /**
     * Vérifie si le tenant a accès à une feature.
     * Le super admin (is_admin=3) a toujours accès à tout.
     *
     * @param string $feature  Ex: 'reports', 'hrm', 'qrapp'
     */
    function can_use(string $feature): bool {
        // Super admin plateforme → accès total
        $CI =& get_instance();
        if ($CI->session->userdata('user_type') == 3) return true;

        // Pas de tenant actif (ex: localhost dev) → accès total
        if (!defined('CURRENT_TENANT_ID')) return true;

        $features = tenant_features();

        // Si la feature n'est pas dans la table → accès par défaut (core)
        if (!isset($features[$feature])) return true;

        return (bool)$features[$feature];
    }
}

if (!function_exists('is_superadmin')) {
    function is_superadmin(): bool {
        $CI =& get_instance();
        return $CI->session->userdata('user_type') == 3;
    }
}
