<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Migration controller to create stock_movements table on all tenant databases.
 *
 * Usage:
 *   curl "https://yourdomain.com/migrate_stock/run?key=YOUR_CRON_KEY"
 */
class Migrate_stock extends CI_Controller
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

        $saas_db = $this->load->database('saas', true);
        $tenants = $saas_db->select('tenant_id, db_name, business_name')
                           ->where('db_name IS NOT NULL')
                           ->where('db_name !=', '')
                           ->get('saas_tenants')
                           ->result();

        $results = [];

        // Read DB config to get credentials (may differ from $this->db on production)
        $db_config = [];
        require APPPATH . 'config/database.php';
        $base_cfg = $db['saas'] ?? $db['default'];

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

                $sql = "CREATE TABLE IF NOT EXISTS `stock_movements` (
                    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `ingredient_id` int(11) NOT NULL,
                    `movement_type` enum('purchase','purchase_return','purchase_update','purchase_delete','production','production_delete','waste_packaging','waste_ingredient','adjustment','order','order_cancel') NOT NULL,
                    `quantity_change` decimal(10,2) NOT NULL,
                    `quantity_after` decimal(10,2) NOT NULL,
                    `reference_id` int(11) DEFAULT NULL,
                    `reference_type` varchar(50) DEFAULT NULL,
                    `unit_cost` decimal(19,3) DEFAULT NULL,
                    `notes` varchar(500) DEFAULT NULL,
                    `adjustment_reason` enum('count_correction','damage','theft','expired','other') DEFAULT NULL,
                    `created_by` int(11) NOT NULL,
                    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    KEY `idx_ingredient` (`ingredient_id`),
                    KEY `idx_type` (`movement_type`),
                    KEY `idx_created_at` (`created_at`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

                $tenant_db->query($sql);
                $tenant_db->close();

                $results[] = ['tenant' => $tenant->business_name, 'db' => $tenant->db_name, 'status' => 'ok'];
            } catch (Exception $e) {
                $results[] = ['tenant' => $tenant->business_name, 'db' => $tenant->db_name, 'status' => 'error', 'message' => $e->getMessage()];
            }
        }

        header('Content-Type: application/json');
        echo json_encode(['migrated' => count($results), 'results' => $results]);
    }
}
