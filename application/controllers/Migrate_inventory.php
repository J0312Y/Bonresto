<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Migration controller for inventory features on all tenant databases.
 * Adds: barcode column, ingredient_batches table, stock_movements enum update.
 * Also creates stock_transfers tables on SaaS DB.
 *
 * Usage:
 *   curl "https://yourdomain.com/migrate_inventory/run?key=YOUR_CRON_KEY"
 */
class Migrate_inventory extends CI_Controller
{
    public function run()
    {
        $key = $this->input->get('key') ?: ($_SERVER['HTTP_X_CRON_KEY'] ?? null);
        $this->config->load('saas_email', true);
        $valid_key = $this->config->item('saas_cron_key', 'saas_email');

        if (!cle_cron_valide($valid_key, $key)) {
            http_response_code(403);
            echo json_encode(['error' => 'Invalid cron key']);
            return;
        }

        // Read DB config for credentials
        $db = [];
        require APPPATH . 'config/database.php';
        $base_cfg = $db['saas'] ?? $db['default'];

        $saas_db = $this->load->database('saas', true);
        $tenants = $saas_db->select('tenant_id, db_name, business_name')
                           ->where('db_name IS NOT NULL')
                           ->where('db_name !=', '')
                           ->get('saas_tenants')
                           ->result();

        $results = [];

        // --- Migrate each tenant DB ---
        foreach ($tenants as $tenant) {
            $config = [
                'hostname' => $base_cfg['hostname'],
                'username' => $base_cfg['username'],
                'password' => $base_cfg['password'],
                'database' => $tenant->db_name,
                'dbdriver' => 'mysqli',
                'char_set' => 'utf8',
                'dbcollat' => 'utf8_general_ci',
            ];

            try {
                $tenant_db = $this->load->database($config, true);
                $errors = [];

                // 1. Add barcode column to ingredients (if not exists)
                $has_barcode = $tenant_db->query("SHOW COLUMNS FROM `ingredients` LIKE 'barcode'")->num_rows() > 0;
                if (!$has_barcode) {
                    $tenant_db->query("ALTER TABLE `ingredients` ADD COLUMN `barcode` VARCHAR(100) DEFAULT NULL AFTER `min_stock`");
                    $tenant_db->query("ALTER TABLE `ingredients` ADD UNIQUE KEY `idx_barcode` (`barcode`)");
                }

                // 2. Create ingredient_batches table
                $tenant_db->query("CREATE TABLE IF NOT EXISTS `ingredient_batches` (
                    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `ingredient_id` INT(11) NOT NULL,
                    `batch_number` VARCHAR(50) DEFAULT NULL,
                    `quantity_remaining` DECIMAL(10,2) NOT NULL DEFAULT 0,
                    `expiry_date` DATE DEFAULT NULL,
                    `purchase_detail_id` INT(11) DEFAULT NULL,
                    `unit_cost` DECIMAL(19,3) DEFAULT NULL,
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    KEY `idx_ingredient` (`ingredient_id`),
                    KEY `idx_expiry` (`expiry_date`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

                // 3. Update stock_movements enum to include transfer types
                $col_info = $tenant_db->query("SHOW COLUMNS FROM `stock_movements` LIKE 'movement_type'")->row();
                if ($col_info && strpos($col_info->Type, 'transfer_out') === false) {
                    $tenant_db->query("ALTER TABLE `stock_movements` MODIFY `movement_type`
                        ENUM('purchase','purchase_return','purchase_update','purchase_delete',
                             'production','production_delete','waste_packaging','waste_ingredient',
                             'adjustment','order','order_cancel','transfer_out','transfer_in') NOT NULL");
                }

                // 4. Insert language labels (ignore duplicates)
                $labels = [
                    ['stock_report', 'Stock Report', 'Rapport de stock'],
                    ['reorder_suggestions', 'Reorder Suggestions', 'Suggestions de reappro'],
                    ['expiry_tracking', 'Expiry Tracking', 'Suivi des expirations'],
                    ['recipe_cost', 'Recipe Cost', 'Cout de recette'],
                    ['supplier_price_history', 'Supplier Price History', 'Historique prix fournisseurs'],
                    ['inter_site_transfer', 'Inter-site Transfer', 'Transfert inter-sites'],
                ];
                foreach ($labels as $l) {
                    $exists = $tenant_db->where('phrase', $l[0])->count_all_results('language');
                    if ($exists == 0) {
                        $tenant_db->insert('language', [
                            'phrase'  => $l[0],
                            'english' => $l[1],
                            'french'  => $l[2],
                        ]);
                    }
                }

                $tenant_db->close();
                $results[] = ['tenant' => $tenant->business_name, 'db' => $tenant->db_name, 'status' => 'ok'];
            } catch (Exception $e) {
                $results[] = ['tenant' => $tenant->business_name, 'db' => $tenant->db_name, 'status' => 'error', 'message' => $e->getMessage()];
            }
        }

        // --- Migrate SaaS DB (stock_transfers tables) ---
        $saas_status = 'ok';
        try {
            $saas_db->query("CREATE TABLE IF NOT EXISTS `stock_transfers` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `from_tenant_id` INT(11) NOT NULL,
                `to_tenant_id` INT(11) NOT NULL,
                `status` ENUM('pending','confirmed','rejected') NOT NULL DEFAULT 'pending',
                `notes` VARCHAR(500) DEFAULT NULL,
                `created_by` INT(11) NOT NULL,
                `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `confirmed_by` INT(11) DEFAULT NULL,
                `confirmed_at` DATETIME DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `idx_from` (`from_tenant_id`),
                KEY `idx_to` (`to_tenant_id`),
                KEY `idx_status` (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

            $saas_db->query("CREATE TABLE IF NOT EXISTS `stock_transfer_items` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `transfer_id` INT(11) UNSIGNED NOT NULL,
                `ingredient_name` VARCHAR(255) NOT NULL,
                `ingredient_id_from` INT(11) NOT NULL,
                `ingredient_id_to` INT(11) DEFAULT NULL,
                `quantity` DECIMAL(10,2) NOT NULL,
                `unit` VARCHAR(50) DEFAULT NULL,
                `unit_cost` DECIMAL(19,3) DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `idx_transfer` (`transfer_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        } catch (Exception $e) {
            $saas_status = 'error: ' . $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode([
            'tenants_migrated' => count($results),
            'results'          => $results,
            'saas_db'          => $saas_status,
        ]);
    }
}
