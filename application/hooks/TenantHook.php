<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * TenantHook — Détecte le sous-domaine et bascule sur la DB du tenant.
 *
 * Exemple : lepetitbistro.bonresto.com → DB resto_42
 *
 * Sous-domaines réservés (ne font PAS de switch) :
 *   admin, www, api, saas, install
 */
class TenantHook {

    private array $reserved = ['admin', 'www', 'api', 'saas', 'install', 'localhost'];

    /**
     * Mapping slug plan (saas_plan_features / frontend) → slug sidebar (can_use).
     * Quand le plan contient 'pos' → on active aussi 'ordermanage' côté sidebar.
     * Les slugs qui sont identiques (hrm, accounts, etc.) n'ont pas besoin d'entrée.
     */
    private array $slugMap = [
        'pos'          => 'ordermanage',
        'orders'       => 'ordermanage',
        'menu'         => 'itemmanage',
        'stock'        => 'itemmanage',
        'reports'      => 'report',
    ];

    /**
     * Carte des dépendances entre modules vendables.
     * Clé = slug plan (frontend). Valeur = slugs plan des modules requis.
     * Les modules sans dépendances (pos, orders, menu, stock, tax, hrm,
     * whatsapp, crm, multisite, api, integrations, support_*, sla)
     * ne figurent pas ici.
     */
    private array $dependencies = [
        'reservations'  => ['pos', 'orders'],                            // pré-commande/arrivée charge order_model
        'delivery'      => ['pos', 'orders'],                            // livraison nécessite le système de commandes
        'production'    => ['menu', 'stock'],                            // recettes basées sur items/stocks
        'qrapp'         => ['menu', 'orders', 'reservations'],           // menu QR + commandes + réservation via Modules::run
        'wastemangment' => ['menu', 'stock', 'production', 'pos', 'orders'], // traçabilité déchets couvre tout le cycle
        'shiftmangment' => ['hrm'],                                      // planning shifts nécessite employee_history
        'accounts'      => ['purchase', 'hrm'],                          // comptabilité lit fournisseurs + salaires
        'reports'       => ['pos', 'orders', 'menu', 'stock', 'production', 'hrm'], // rapports couvrent tout
        'purchase'      => ['menu'],                                     // achats référencent ingredients/UoM d'itemmanage
    ];

    /**
     * Résout récursivement les dépendances et active les modules requis.
     * Ex: qrapp → reservations → pos, orders (transitif)
     */
    private function resolveDependencies(array &$features): void {
        $changed = true;
        while ($changed) {
            $changed = false;
            foreach ($this->dependencies as $module => $deps) {
                if (!empty($features[$module])) {
                    foreach ($deps as $dep) {
                        if (empty($features[$dep])) {
                            $features[$dep] = true;
                            $changed = true; // re-boucler pour les dépendances transitives
                        }
                    }
                }
            }
        }
    }

    public function detect(): void {
        $host = $_SERVER['HTTP_HOST'] ?? '';

        // Extraire le sous-domaine
        $parts     = explode('.', $host);
        $subdomain = count($parts) >= 3 ? $parts[0] : '';
        $is_reserved = empty($subdomain) || in_array(strtolower($subdomain), $this->reserved);

        // Localhost sans sous-domaine → sortie immédiate, pas de connexion DB
        if ($is_reserved && (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false)) {
            return;
        }

        // Charger la config DB — require peuple $db dans le scope courant
        $db = [];
        require APPPATH . 'config/database.php';
        $saas_cfg = $db['saas'] ?? $db['default'];

        $conn = @new mysqli(
            $saas_cfg['hostname'],
            $saas_cfg['username'],
            $saas_cfg['password'],
            $saas_cfg['database']
        );

        if ($conn->connect_error) {
            log_message('error', 'TenantHook: cannot connect to saas DB — ' . $conn->connect_error);
            return;
        }

        $slug      = $conn->real_escape_string($subdomain);
        $full_host = $conn->real_escape_string($host);

        // Sous-domaine réservé → pas de switch MAIS on cherche quand même par custom_domain

        // Cherche par slug (si pas réservé) OU par custom_domain (toujours)
        $where = $is_reserved
            ? "custom_domain='{$full_host}'"
            : "(slug='{$slug}' OR custom_domain='{$full_host}')";

        $res = $conn->query(
            "SELECT tenant_id, db_name, group_id FROM saas_tenants
             WHERE {$where} AND status='active' LIMIT 1"
        );

        // Pas réservé et aucun tenant trouvé → 404
        if (!$is_reserved && (!$res || $res->num_rows === 0)) {
            $conn->close();
            header('HTTP/1.1 404 Not Found');
            exit('<h1>Restaurant introuvable</h1>');
        }

        // Aucun tenant trouvé → on laisse CI gérer normalement
        if (!$res || $res->num_rows === 0) {
            $conn->close();
            return;
        }

        $tenant = $res->fetch_assoc();
        $tenant_id = (int)$tenant['tenant_id'];
        $group_id  = !empty($tenant['group_id']) ? (int)$tenant['group_id'] : 0;

        // 1. Features du plan actif (abonnement individuel)
        $features = [];
        $fsql = "SELECT pf.feature, pf.enabled
                 FROM saas_plan_features pf
                 JOIN saas_subscriptions s ON s.plan_id = pf.plan_id
                 WHERE s.tenant_id = {$tenant_id} AND s.status = 'active'";
        $fres = $conn->query($fsql);
        if ($fres) {
            while ($row = $fres->fetch_assoc()) {
                $features[$row['feature']] = (bool)$row['enabled'];
            }
        }

        // 1b. Fallback : si pas d'abonnement individuel, chercher l'abonnement groupe
        if (empty($features) && $group_id > 0) {
            $gsql = "SELECT pf.feature, pf.enabled
                     FROM saas_plan_features pf
                     JOIN saas_group_subscriptions gs ON gs.plan_id = pf.plan_id
                     JOIN saas_groups g ON g.group_id = gs.group_id AND g.billing_model = 'group'
                     WHERE gs.group_id = {$group_id} AND gs.status = 'active'";
            $gres = $conn->query($gsql);
            if ($gres) {
                while ($row = $gres->fetch_assoc()) {
                    $features[$row['feature']] = (bool)$row['enabled'];
                }
            }
        }

        // 2. Overrides par tenant (priorité sur le plan)
        $ores = $conn->query(
            "SELECT feature, enabled FROM saas_tenant_features WHERE tenant_id = {$tenant_id}"
        );
        if ($ores) {
            while ($row = $ores->fetch_assoc()) {
                $features[$row['feature']] = (bool)$row['enabled'];
            }
        }

        $conn->close();

        // Auto-activer les dépendances des modules souscrits (récursif)
        $this->resolveDependencies($features);

        // Traduire les slugs plan → slugs sidebar pour can_use()
        foreach ($this->slugMap as $planSlug => $sidebarSlug) {
            if (!empty($features[$planSlug])) {
                $features[$sidebarSlug] = true;
            }
        }

        // Stocker le tenant courant (accessible via CI plus tard)
        defined('CURRENT_TENANT_ID')   || define('CURRENT_TENANT_ID',   $tenant_id);
        defined('CURRENT_DB_NAME')     || define('CURRENT_DB_NAME',     $tenant['db_name']);
        defined('CURRENT_TENANT_PLAN') || define('CURRENT_TENANT_PLAN', json_encode($features));
        defined('CURRENT_GROUP_ID')    || define('CURRENT_GROUP_ID',    $group_id);

        // Modifier la config DB avant que CI charge la connexion
        $GLOBALS['_CI_TENANT_DB'] = $tenant['db_name'];
    }
}
