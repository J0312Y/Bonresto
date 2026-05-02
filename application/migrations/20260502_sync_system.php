<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration: Sync System — Phase 1
 *
 * Adds sync tracking columns to operational tables and creates
 * the four new tables needed for the hybrid local/VPS sync system:
 *   - sync_queue        : outbound queue (local → VPS)
 *   - sync_online_orders: inbound tracker (VPS → local)
 *   - sync_config       : VPS connection config
 *   - sync_log          : audit trail
 *
 * Both api/ and application/ share the same restaurant DB,
 * so this single migration covers all sync needs.
 */
class Migration_Sync_system extends CI_Migration {

    // Tables that receive sync tracking columns
    const TRACKED_TABLES = [
        'customer_order',
        'order_menu',
        'item_foods',
        'variant',
        'item_category',
        'tablelist',
        'bill',
    ];

    public function up() {

        // ── 1. Add sync_uuid + sync tracking columns to operational tables ────

        $uuid_col = [
            'type'       => 'CHAR',
            'constraint' => 36,
            'null'       => TRUE,
            'default'    => NULL,
        ];

        $synced_col = [
            'type'       => 'TINYINT',
            'constraint' => 1,
            'null'       => FALSE,
            'default'    => 0,
        ];

        $synced_at_col = [
            'type' => 'DATETIME',
            'null' => TRUE,
            'default' => NULL,
        ];

        foreach (self::TRACKED_TABLES as $table) {
            if (!$this->db->field_exists('sync_uuid', $table)) {
                $this->dbforge->add_column($table, ['sync_uuid' => $uuid_col]);
                $this->db->query("ALTER TABLE `{$table}` ADD INDEX `idx_{$table}_sync_uuid` (`sync_uuid`)");
            }
            if (!$this->db->field_exists('synced_to_vps', $table)) {
                $this->dbforge->add_column($table, ['synced_to_vps' => $synced_col]);
            }
            if (!$this->db->field_exists('synced_at', $table)) {
                $this->dbforge->add_column($table, ['synced_at' => $synced_at_col]);
            }
        }

        // customer_order also tracks its sync origin and VPS counterpart
        if (!$this->db->field_exists('sync_origin', 'customer_order')) {
            $this->dbforge->add_column('customer_order', [
                'sync_origin' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 10,
                    'null'       => FALSE,
                    'default'    => 'local',
                    'comment'    => 'local|vps|website',
                ],
            ]);
        }
        if (!$this->db->field_exists('vps_order_id', 'customer_order')) {
            $this->dbforge->add_column('customer_order', [
                'vps_order_id' => [
                    'type'       => 'BIGINT',
                    'constraint' => 20,
                    'null'       => TRUE,
                    'default'    => NULL,
                    'comment'    => 'Corresponding order_id on VPS',
                ],
            ]);
        }
        // VPS side: mark when local server acknowledged receipt of an online order
        if (!$this->db->field_exists('ack_by_local_at', 'customer_order')) {
            $this->dbforge->add_column('customer_order', [
                'ack_by_local_at' => [
                    'type'    => 'DATETIME',
                    'null'    => TRUE,
                    'default' => NULL,
                    'comment' => 'Set on VPS when local server confirms it received this online order',
                ],
            ]);
            $this->db->query("ALTER TABLE `customer_order` ADD INDEX `idx_co_ack` (`ack_by_local_at`)");
        }

        // ── 2. sync_queue — outbound queue (local → VPS) ──────────────────────

        if (!$this->db->table_exists('sync_queue')) {
            $this->dbforge->add_field([
                'queue_id' => [
                    'type'           => 'BIGINT',
                    'constraint'     => 20,
                    'unsigned'       => TRUE,
                    'auto_increment' => TRUE,
                ],
                'entity_type' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => FALSE,
                    'comment'    => 'customer_order|order_menu|item_foods|variant|item_category|tablelist|bill',
                ],
                'entity_id' => [
                    'type'       => 'BIGINT',
                    'constraint' => 20,
                    'null'       => FALSE,
                    'comment'    => 'PK of the changed row',
                ],
                'operation' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 10,
                    'null'       => FALSE,
                    'comment'    => 'insert|update|delete',
                ],
                'payload' => [
                    'type' => 'LONGTEXT',
                    'null' => FALSE,
                    'comment' => 'JSON snapshot of the row at queue time',
                ],
                'status' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 15,
                    'null'       => FALSE,
                    'default'    => 'pending',
                    'comment'    => 'pending|sent|failed|skipped',
                ],
                'attempts' => [
                    'type'       => 'TINYINT',
                    'constraint' => 3,
                    'null'       => FALSE,
                    'default'    => 0,
                ],
                'last_error' => [
                    'type' => 'TEXT',
                    'null' => TRUE,
                ],
                'created_at' => [
                    'type'    => 'DATETIME',
                    'null'    => FALSE,
                    'default' => '1970-01-01 00:00:00',
                ],
                'sent_at' => [
                    'type' => 'DATETIME',
                    'null' => TRUE,
                ],
            ]);
            $this->dbforge->add_key('queue_id', TRUE);
            $this->dbforge->create_table('sync_queue');
            $this->db->query("ALTER TABLE `sync_queue` ADD INDEX `idx_sq_status` (`status`)");
            $this->db->query("ALTER TABLE `sync_queue` ADD INDEX `idx_sq_entity` (`entity_type`, `entity_id`)");
            $this->db->query("ALTER TABLE `sync_queue` ADD INDEX `idx_sq_created` (`created_at`)");
        }

        // ── 3. sync_online_orders — inbound tracker (VPS → local) ────────────

        if (!$this->db->table_exists('sync_online_orders')) {
            $this->dbforge->add_field([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => TRUE,
                    'auto_increment' => TRUE,
                ],
                'vps_order_id' => [
                    'type'       => 'BIGINT',
                    'constraint' => 20,
                    'null'       => FALSE,
                    'comment'    => 'order_id on VPS',
                ],
                'vps_sync_uuid' => [
                    'type'       => 'CHAR',
                    'constraint' => 36,
                    'null'       => FALSE,
                ],
                'local_order_id' => [
                    'type'       => 'BIGINT',
                    'constraint' => 20,
                    'null'       => TRUE,
                    'default'    => NULL,
                    'comment'    => 'order_id created locally after import',
                ],
                'status' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 15,
                    'null'       => FALSE,
                    'default'    => 'pending',
                    'comment'    => 'pending|imported|failed',
                ],
                'pulled_at' => [
                    'type'    => 'DATETIME',
                    'null'    => FALSE,
                    'default' => '1970-01-01 00:00:00',
                ],
                'imported_at' => [
                    'type' => 'DATETIME',
                    'null' => TRUE,
                ],
                'last_error' => [
                    'type' => 'TEXT',
                    'null' => TRUE,
                ],
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('sync_online_orders');
            $this->db->query("ALTER TABLE `sync_online_orders` ADD UNIQUE KEY `uq_vps_order` (`vps_order_id`)");
            $this->db->query("ALTER TABLE `sync_online_orders` ADD INDEX `idx_soo_status` (`status`)");
        }

        // ── 4. sync_config — VPS connection config ────────────────────────────

        if (!$this->db->table_exists('sync_config')) {
            $this->dbforge->add_field([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => TRUE,
                    'auto_increment' => TRUE,
                ],
                'vps_url' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => FALSE,
                    'comment'    => 'Base URL of the VPS instance, e.g. https://vps.example.com/bonresto/index.php',
                ],
                'client_key' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => FALSE,
                    'comment'    => 'Same client_key as license — used as auth token',
                ],
                'sync_secret' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => FALSE,
                    'comment'    => 'HMAC-SHA256 shared secret for payload signing',
                ],
                'enabled' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'null'       => FALSE,
                    'default'    => 1,
                ],
                'last_push' => [
                    'type' => 'DATETIME',
                    'null' => TRUE,
                ],
                'last_pull' => [
                    'type' => 'DATETIME',
                    'null' => TRUE,
                ],
                'updated_at' => [
                    'type'    => 'DATETIME',
                    'null'    => FALSE,
                    'default' => '1970-01-01 00:00:00',
                ],
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('sync_config');
        }

        // ── 5. sync_log — audit trail ─────────────────────────────────────────

        if (!$this->db->table_exists('sync_log')) {
            $this->dbforge->add_field([
                'log_id' => [
                    'type'           => 'BIGINT',
                    'constraint'     => 20,
                    'unsigned'       => TRUE,
                    'auto_increment' => TRUE,
                ],
                'direction' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 10,
                    'null'       => FALSE,
                    'comment'    => 'push|pull',
                ],
                'entity' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => FALSE,
                ],
                'count' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => FALSE,
                    'default'    => 0,
                ],
                'status' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 15,
                    'null'       => FALSE,
                    'comment'    => 'ok|partial|failed',
                ],
                'message' => [
                    'type' => 'TEXT',
                    'null' => TRUE,
                ],
                'ran_at' => [
                    'type'    => 'DATETIME',
                    'null'    => FALSE,
                    'default' => '1970-01-01 00:00:00',
                ],
            ]);
            $this->dbforge->add_key('log_id', TRUE);
            $this->dbforge->create_table('sync_log');
            $this->db->query("ALTER TABLE `sync_log` ADD INDEX `idx_sl_ran` (`ran_at`)");
        }
    }

    public function down() {

        // Drop new tables
        $this->dbforge->drop_table('sync_log',           TRUE);
        $this->dbforge->drop_table('sync_config',        TRUE);
        $this->dbforge->drop_table('sync_online_orders', TRUE);
        $this->dbforge->drop_table('sync_queue',         TRUE);

        // Remove added columns from operational tables
        $extra_cols = ['sync_uuid', 'synced_to_vps', 'synced_at'];
        foreach (self::TRACKED_TABLES as $table) {
            foreach ($extra_cols as $col) {
                if ($this->db->field_exists($col, $table)) {
                    $this->dbforge->drop_column($table, $col);
                }
            }
        }
        foreach (['sync_origin', 'vps_order_id', 'ack_by_local_at'] as $col) {
            if ($this->db->field_exists($col, 'customer_order')) {
                $this->dbforge->drop_column('customer_order', $col);
            }
        }
    }
}
