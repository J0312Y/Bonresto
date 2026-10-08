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
                // Le module appelle 167 phrases ; six seulement etaient semees.
                // display() rend false sur une phrase absente, donc 161 libelles
                // s'affichaient vides : colonnes sans en-tete, boutons mutiques,
                // messages de confirmation reduits a un numero. L'insertion reste
                // conditionnee a l'absence, les traductions deja en base priment.
                $labels = [
                    ['stock_report', 'Stock Report', 'Rapport de stock'],
                    ['reorder_suggestions', 'Reorder Suggestions', 'Suggestions de reappro'],
                    ['expiry_tracking', 'Expiry Tracking', 'Suivi des expirations'],
                    ['recipe_cost', 'Recipe Cost', 'Cout de recette'],
                    ['supplier_price_history', 'Supplier Price History', 'Historique prix fournisseurs'],
                    ['inter_site_transfer', 'Inter-site Transfer', 'Transfert inter-sites'],

                    ['active_ingredients', 'Active Ingredients', 'Ingredients actifs'],
                    ['actual_quantity', 'Actual Quantity', 'Quantite reelle'],
                    ['add_ingredient', 'Add Ingredient', 'Ajouter un ingredient'],
                    ['additional_details', 'Additional Details', 'Details complementaires'],
                    ['adjustment_error', 'Adjustment error', 'Erreur d\'ajustement'],
                    ['adjustment_history', 'Adjustment History', 'Historique des ajustements'],
                    ['all_above_threshold', 'All items above threshold', 'Tous les articles au-dessus du seuil'],
                    ['all_ingredients_active', 'All ingredients are active', 'Tous les ingredients sont actifs'],
                    ['all_option', 'All', 'Tous'],
                    ['available_stock', 'Available Stock', 'Stock disponible'],
                    ['avg_daily_consumption', 'Avg. Daily Consumption', 'Consommation moyenne par jour'],
                    ['back_btn', 'Back', 'Retour'],
                    ['barcode_not_found', 'Barcode not found', 'Code-barres introuvable'],
                    ['batch_label', 'Batch', 'Lot'],
                    ['below_min_threshold', 'Below Minimum Threshold', 'Sous le seuil minimum'],
                    ['cancel_btn', 'Cancel', 'Annuler'],
                    ['choose_ingredient', 'Choose an ingredient', 'Choisir un ingredient'],
                    ['choose_option', 'Choose...', 'Choisir...'],
                    ['confirm_reception', 'Confirm Reception', 'Confirmer la reception'],
                    ['confirm_reception_q', 'Confirm reception of this transfer?', 'Confirmer la reception de ce transfert ?'],
                    ['confirmation_error', 'Confirmation error', 'Erreur de confirmation'],
                    ['consumption_30days', 'Consumption (30 days)', 'Consommation (30 jours)'],
                    ['consumption_label', 'Consumption', 'Consommation'],
                    ['current_stock', 'Current stock:', 'Stock actuel :'],
                    ['current_stock_col', 'Current Stock', 'Stock actuel'],
                    ['date_label', 'Date', 'Date'],
                    ['day_s', 'day(s)', 'jour(s)'],
                    ['days_label', 'Days', 'Jours'],
                    ['days_overdue', 'Days Overdue', 'Jours de retard'],
                    ['days_remaining', 'Days Remaining', 'Jours restants'],
                    ['deficit_col', 'Deficit', 'Deficit'],
                    ['difference_label', 'Difference', 'Ecart'],
                    ['dish_label', 'Dish', 'Plat'],
                    ['dormant_stock', 'Dormant Stock', 'Stock dormant'],
                    ['enter_actual_qty', 'Enter the actual counted quantity', 'Saisir la quantite reellement comptee'],
                    ['expired_lots', 'Expired Lots', 'Lots perimes'],
                    ['expiring_in', 'Expiring in', 'Expire dans'],
                    ['expiry_date_col', 'Expiry Date', 'Date d\'expiration'],
                    ['filter_btn', 'Filter', 'Filtrer'],
                    ['food_cost_pct', 'Food Cost %', 'Cout matiere %'],
                    ['food_cost_subtitle', 'Cost and margin per recipe', 'Cout et marge par recette'],
                    ['from_date', 'From', 'Du'],
                    ['from_sender', 'From', 'De'],
                    ['generate_po', 'Generate Purchase Order', 'Generer le bon de commande'],
                    ['individual_adjustment', 'Individual Adjustment', 'Ajustement individuel'],
                    ['ingredient_cost', 'Ingredient Cost', 'Cout des ingredients'],
                    ['ingredient_label', 'Ingredient', 'Ingredient'],
                    ['ingredient_not_found', 'Ingredient not found', 'Ingredient introuvable'],
                    ['ingredients_adjusted', 'ingredient(s) adjusted', 'ingredient(s) ajuste(s)'],
                    ['ingredients_to_transfer', 'Ingredients to transfer', 'Ingredients a transferer'],
                    ['insufficient_stock', 'Insufficient stock', 'Stock insuffisant'],
                    ['inventory_error', 'Inventory error', 'Erreur d\'inventaire'],
                    ['items_preloaded', 'items preloaded', 'articles precharges'],
                    ['last_movement', 'Last Movement', 'Dernier mouvement'],
                    ['last_price', 'Last Price', 'Dernier prix'],
                    ['last_supplier', 'Last Supplier', 'Dernier fournisseur'],
                    ['margin_label', 'Margin', 'Marge'],
                    ['min_threshold', 'Minimum threshold:', 'Seuil minimum :'],
                    ['missing_data', 'Missing data', 'Donnees manquantes'],
                    ['movement_history', 'Movement History', 'Historique des mouvements'],
                    ['movement_type', 'Movement Type', 'Type de mouvement'],
                    ['mvt_adjustment', 'Adjustment', 'Ajustement'],
                    ['mvt_order', 'Order', 'Commande'],
                    ['mvt_order_cancel', 'Order Cancelled', 'Commande annulee'],
                    ['mvt_production', 'Production', 'Production'],
                    ['mvt_production_delete', 'Production Deleted', 'Production supprimee'],
                    ['mvt_purchase', 'Purchase', 'Achat'],
                    ['mvt_purchase_delete', 'Purchase Deleted', 'Achat supprime'],
                    ['mvt_purchase_return', 'Purchase Return', 'Retour d\'achat'],
                    ['mvt_purchase_update', 'Purchase Updated', 'Achat modifie'],
                    ['mvt_transfer_in', 'Transfer In', 'Transfert entrant'],
                    ['mvt_transfer_out', 'Transfer Out', 'Transfert sortant'],
                    ['mvt_waste_ingredient', 'Ingredient Waste', 'Perte d\'ingredient'],
                    ['mvt_waste_packaging', 'Packaging Waste', 'Perte d\'emballage'],
                    ['never_label', 'Never', 'Jamais'],
                    ['new_stock_transfer', 'New Stock Transfer', 'Nouveau transfert de stock'],
                    ['new_transfer', 'New Transfer', 'Nouveau transfert'],
                    ['next_days', 'next days', 'prochains jours'],
                    ['no_adjustment', 'No adjustment recorded', 'Aucun ajustement enregistre'],
                    ['no_consumption_data', 'No consumption data', 'Aucune donnee de consommation'],
                    ['no_consumption_month', 'No consumption this month', 'Aucune consommation ce mois-ci'],
                    ['no_data_received', 'No data received', 'Aucune donnee recue'],
                    ['no_difference', 'No difference with current stock', 'Aucun ecart avec le stock actuel'],
                    ['no_expiring_lots', 'No lots expiring', 'Aucun lot proche de l\'expiration'],
                    ['no_group_warning', 'This restaurant does not belong to a group', 'Ce restaurant n\'appartient a aucun groupe'],
                    ['no_ingredient_selected', 'No ingredient selected', 'Aucun ingredient selectionne'],
                    ['no_movements', 'No movement recorded', 'Aucun mouvement enregistre'],
                    ['no_pending_transfer', 'No pending transfer', 'Aucun transfert en attente'],
                    ['no_production_recipe', 'No production recipe', 'Aucune recette de production'],
                    ['no_purchase_history', 'No purchase history', 'Aucun historique d\'achat'],
                    ['no_recipe_ingredients', 'No ingredient in this recipe', 'Aucun ingredient dans cette recette'],
                    ['no_transfer_received', 'No transfer received', 'Aucun transfert recu'],
                    ['no_transfer_sent', 'No transfer sent', 'Aucun transfert envoye'],
                    ['note_label', 'Note', 'Note'],
                    ['notes_label', 'Notes', 'Notes'],
                    ['pending_confirmation', 'Pending confirmation', 'En attente de confirmation'],
                    ['pending_label', 'Pending', 'En attente'],
                    ['pending_transfers', 'Pending Transfers', 'Transferts en attente'],
                    ['physical_inventory', 'Physical Inventory', 'Inventaire physique'],
                    ['physical_inventory_subtitle', 'Count all ingredients and record the differences', 'Compter tous les ingredients et enregistrer les ecarts'],
                    ['price_evolution', 'Price Evolution', 'Evolution des prix'],
                    ['price_xaf', 'Price (XAF)', 'Prix (XAF)'],
                    ['qty_adjusted', 'Qty Adjusted', 'Quantite ajustee'],
                    ['qty_change', 'Qty Change', 'Variation'],
                    ['qty_consumed', 'Qty Consumed', 'Quantite consommee'],
                    ['qty_remaining', 'Qty Remaining', 'Quantite restante'],
                    ['qty_to_order', 'Qty to Order', 'Quantite a commander'],
                    ['quantity_label', 'Quantity', 'Quantite'],
                    ['real_quantity', 'Real Quantity', 'Quantite reelle'],
                    ['reason_counting', 'Count correction', 'Correction de comptage'],
                    ['reason_damage', 'Damage', 'Casse'],
                    ['reason_expired', 'Expired', 'Perime'],
                    ['reason_label', 'Reason', 'Motif'],
                    ['reason_other', 'Other', 'Autre'],
                    ['reason_theft', 'Theft', 'Vol'],
                    ['recipient_label', 'Recipient', 'Destinataire'],
                    ['reference_label', 'Reference', 'Reference'],
                    ['reject_btn', 'Reject', 'Refuser'],
                    ['reject_confirm', 'Reject this transfer?', 'Refuser ce transfert ?'],
                    ['reorder_subtitle', 'Ingredients below their minimum threshold', 'Ingredients sous leur seuil minimum'],
                    ['save_adjustment', 'Save Adjustment', 'Enregistrer l\'ajustement'],
                    ['scan_barcode', 'Scan Barcode', 'Scanner le code-barres'],
                    ['scan_placeholder', 'Scan or type a barcode', 'Scanner ou saisir un code-barres'],
                    ['searching_label', 'Searching...', 'Recherche...'],
                    ['select_ingredient_history', 'Select an ingredient to see its history', 'Choisir un ingredient pour voir son historique'],
                    ['selling_price', 'Selling Price', 'Prix de vente'],
                    ['send_transfer', 'Send Transfer', 'Envoyer le transfert'],
                    ['sender_label', 'Sender', 'Expediteur'],
                    ['status_confirmed', 'Confirmed', 'Confirme'],
                    ['status_critical', 'Critical', 'Critique'],
                    ['status_label', 'Status', 'Statut'],
                    ['status_pending', 'Pending', 'En attente'],
                    ['status_rejected', 'Rejected', 'Refuse'],
                    ['status_urgent', 'Urgent', 'Urgent'],
                    ['status_watch', 'Watch', 'A surveiller'],
                    ['stock_adjusted_success', 'Stock adjusted successfully', 'Stock ajuste avec succes'],
                    ['stock_adjustment', 'Stock Adjustment', 'Ajustement de stock'],
                    ['stock_after', 'Stock After', 'Stock apres'],
                    ['subtotal_label', 'Subtotal', 'Sous-total'],
                    ['supplier_label', 'Supplier', 'Fournisseur'],
                    ['system_stock', 'System Stock', 'Stock theorique'],
                    ['target_restaurant', 'Target Restaurant', 'Restaurant destinataire'],
                    ['to_date', 'To', 'Au'],
                    ['top_consumed_month', 'Top Consumed (month)', 'Les plus consommes (mois)'],
                    ['total_label', 'Total', 'Total'],
                    ['total_movements', 'total movements', 'mouvements au total'],
                    ['total_stock_value', 'Total Stock Value', 'Valeur totale du stock'],
                    ['transfer_confirmed', 'Transfer confirmed', 'Transfert confirme'],
                    ['transfer_error', 'Transfer error', 'Erreur de transfert'],
                    ['transfer_invalid', 'Invalid transfer', 'Transfert invalide'],
                    ['transfer_reason', 'Transfer reason', 'Motif du transfert'],
                    ['transfer_rejected', 'Transfer rejected', 'Transfert refuse'],
                    ['transfer_sent_success', 'Transfer sent successfully', 'Transfert envoye avec succes'],
                    ['transfers_received', 'Transfers Received', 'Transferts recus'],
                    ['transfers_sent', 'Transfers Sent', 'Transferts envoyes'],
                    ['unit_cost_label', 'Unit Cost', 'Cout unitaire'],
                    ['unit_label', 'Unit', 'Unite'],
                    ['unit_price', 'Unit Price', 'Prix unitaire'],
                    ['unknown_label', 'Unknown', 'Inconnu'],
                    ['validate_inventory', 'Validate Inventory', 'Valider l\'inventaire'],
                    ['variant_label', 'Variant', 'Variante'],
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
