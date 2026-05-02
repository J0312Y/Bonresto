-- ============================================================
-- Sync System — Phase 1 — Compatible MySQL 5.7+
-- Run this on BOTH local DB and VPS DB (restaurant1)
-- Date: 2026-05-02
-- ============================================================

-- Désactive le mode strict pour éviter les erreurs sur les données existantes
SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION';

-- Utilise une procédure stockée pour ajouter les colonnes conditionnellement
-- (ADD COLUMN IF NOT EXISTS n'existe pas en MySQL 5.7)

DROP PROCEDURE IF EXISTS bonresto_add_col;
DROP PROCEDURE IF EXISTS bonresto_add_idx;

DELIMITER $$

CREATE PROCEDURE bonresto_add_col(
    IN tbl  VARCHAR(64),
    IN col  VARCHAR(64),
    IN def  TEXT
)
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME   = tbl
          AND COLUMN_NAME  = col
    ) THEN
        SET @sql = CONCAT('ALTER TABLE `', tbl, '` ADD COLUMN `', col, '` ', def);
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
    END IF;
END$$

CREATE PROCEDURE bonresto_add_idx(
    IN tbl  VARCHAR(64),
    IN idx  VARCHAR(64),
    IN cols TEXT
)
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM INFORMATION_SCHEMA.STATISTICS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME   = tbl
          AND INDEX_NAME   = idx
    ) THEN
        SET @sql = CONCAT('ALTER TABLE `', tbl, '` ADD INDEX `', idx, '` (', cols, ')');
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
    END IF;
END$$

DELIMITER ;

-- ── 1. customer_order ─────────────────────────────────────────────────────────
CALL bonresto_add_col('customer_order', 'sync_uuid',       "CHAR(36) NULL DEFAULT NULL COMMENT 'Globally unique ID across local+VPS'");
CALL bonresto_add_col('customer_order', 'sync_origin',     "VARCHAR(10) NOT NULL DEFAULT 'local' COMMENT 'local|vps|website'");
CALL bonresto_add_col('customer_order', 'synced_to_vps',   'TINYINT(1) NOT NULL DEFAULT 0');
CALL bonresto_add_col('customer_order', 'synced_at',       'DATETIME NULL DEFAULT NULL');
CALL bonresto_add_col('customer_order', 'vps_order_id',    "BIGINT(20) NULL DEFAULT NULL COMMENT 'Corresponding order_id on VPS'");
CALL bonresto_add_col('customer_order', 'ack_by_local_at', "DATETIME NULL DEFAULT NULL COMMENT 'Set on VPS when local confirms receipt of online order'");

CALL bonresto_add_idx('customer_order', 'idx_co_sync_uuid', '`sync_uuid`');
CALL bonresto_add_idx('customer_order', 'idx_co_synced',    '`synced_to_vps`');
CALL bonresto_add_idx('customer_order', 'idx_co_origin',    '`sync_origin`');
CALL bonresto_add_idx('customer_order', 'idx_co_ack',       '`ack_by_local_at`');

-- ── 2. order_menu ─────────────────────────────────────────────────────────────
CALL bonresto_add_col('order_menu', 'sync_uuid',     'CHAR(36) NULL DEFAULT NULL');
CALL bonresto_add_col('order_menu', 'synced_to_vps', 'TINYINT(1) NOT NULL DEFAULT 0');
CALL bonresto_add_col('order_menu', 'synced_at',     'DATETIME NULL DEFAULT NULL');
CALL bonresto_add_idx('order_menu', 'idx_om_sync_uuid', '`sync_uuid`');

-- ── 3. item_foods ─────────────────────────────────────────────────────────────
CALL bonresto_add_col('item_foods', 'sync_uuid',     'CHAR(36) NULL DEFAULT NULL');
CALL bonresto_add_col('item_foods', 'synced_to_vps', 'TINYINT(1) NOT NULL DEFAULT 0');
CALL bonresto_add_col('item_foods', 'synced_at',     'DATETIME NULL DEFAULT NULL');
CALL bonresto_add_idx('item_foods', 'idx_if_sync_uuid', '`sync_uuid`');

-- ── 4. variant ────────────────────────────────────────────────────────────────
CALL bonresto_add_col('variant', 'sync_uuid',     'CHAR(36) NULL DEFAULT NULL');
CALL bonresto_add_col('variant', 'synced_to_vps', 'TINYINT(1) NOT NULL DEFAULT 0');
CALL bonresto_add_col('variant', 'synced_at',     'DATETIME NULL DEFAULT NULL');
CALL bonresto_add_idx('variant', 'idx_va_sync_uuid', '`sync_uuid`');

-- ── 5. item_category ──────────────────────────────────────────────────────────
CALL bonresto_add_col('item_category', 'sync_uuid',     'CHAR(36) NULL DEFAULT NULL');
CALL bonresto_add_col('item_category', 'synced_to_vps', 'TINYINT(1) NOT NULL DEFAULT 0');
CALL bonresto_add_col('item_category', 'synced_at',     'DATETIME NULL DEFAULT NULL');
CALL bonresto_add_idx('item_category', 'idx_ic_sync_uuid', '`sync_uuid`');

-- ── 6. tablelist ──────────────────────────────────────────────────────────────
CALL bonresto_add_col('tablelist', 'sync_uuid',     'CHAR(36) NULL DEFAULT NULL');
CALL bonresto_add_col('tablelist', 'synced_to_vps', 'TINYINT(1) NOT NULL DEFAULT 0');
CALL bonresto_add_col('tablelist', 'synced_at',     'DATETIME NULL DEFAULT NULL');
CALL bonresto_add_idx('tablelist', 'idx_tl_sync_uuid', '`sync_uuid`');

-- ── 7. bill ───────────────────────────────────────────────────────────────────
CALL bonresto_add_col('bill', 'sync_uuid',     'CHAR(36) NULL DEFAULT NULL');
CALL bonresto_add_col('bill', 'synced_to_vps', 'TINYINT(1) NOT NULL DEFAULT 0');
CALL bonresto_add_col('bill', 'synced_at',     'DATETIME NULL DEFAULT NULL');
CALL bonresto_add_idx('bill', 'idx_bi_sync_uuid', '`sync_uuid`');

-- ── 8. Backfill UUID sur les lignes existantes ────────────────────────────────
UPDATE `customer_order` SET `sync_uuid` = UUID() WHERE `sync_uuid` IS NULL;
UPDATE `order_menu`     SET `sync_uuid` = UUID() WHERE `sync_uuid` IS NULL;
UPDATE `item_foods`     SET `sync_uuid` = UUID() WHERE `sync_uuid` IS NULL;
UPDATE `variant`        SET `sync_uuid` = UUID() WHERE `sync_uuid` IS NULL;
UPDATE `item_category`  SET `sync_uuid` = UUID() WHERE `sync_uuid` IS NULL;
UPDATE `tablelist`      SET `sync_uuid` = UUID() WHERE `sync_uuid` IS NULL;
UPDATE `bill`           SET `sync_uuid` = UUID() WHERE `sync_uuid` IS NULL;

-- ── 9. sync_queue ─────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `sync_queue` (
  `queue_id`    BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `entity_type` VARCHAR(50)         NOT NULL COMMENT 'customer_order|order_menu|item_foods|variant|item_category|tablelist|bill',
  `entity_id`   BIGINT(20)          NOT NULL COMMENT 'PK de la ligne modifiée',
  `operation`   VARCHAR(10)         NOT NULL COMMENT 'insert|update|delete',
  `payload`     LONGTEXT            NOT NULL COMMENT 'JSON snapshot de la ligne',
  `status`      VARCHAR(15)         NOT NULL DEFAULT 'pending' COMMENT 'pending|sent|failed|skipped',
  `attempts`    TINYINT(3)          NOT NULL DEFAULT 0,
  `last_error`  TEXT                NULL,
  `created_at`  DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sent_at`     DATETIME            NULL,
  PRIMARY KEY (`queue_id`),
  INDEX `idx_sq_status`  (`status`),
  INDEX `idx_sq_entity`  (`entity_type`, `entity_id`),
  INDEX `idx_sq_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ── 10. sync_online_orders ────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `sync_online_orders` (
  `id`             INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vps_order_id`   BIGINT(20)       NOT NULL COMMENT 'order_id sur le VPS',
  `vps_sync_uuid`  CHAR(36)         NOT NULL,
  `local_order_id` BIGINT(20)       NULL DEFAULT NULL COMMENT 'order_id créé localement après import',
  `status`         VARCHAR(15)      NOT NULL DEFAULT 'pending' COMMENT 'pending|imported|failed',
  `pulled_at`      DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `imported_at`    DATETIME         NULL,
  `last_error`     TEXT             NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_vps_order` (`vps_order_id`),
  INDEX `idx_soo_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ── 11. sync_config ───────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `sync_config` (
  `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vps_url`     VARCHAR(255)     NOT NULL COMMENT 'URL de base du VPS',
  `client_key`  VARCHAR(100)     NOT NULL COMMENT 'Même client_key que la licence',
  `sync_secret` VARCHAR(100)     NOT NULL COMMENT 'Secret HMAC-SHA256 partagé',
  `enabled`     TINYINT(1)       NOT NULL DEFAULT 1,
  `last_push`   DATETIME         NULL,
  `last_pull`   DATETIME         NULL,
  `updated_at`  DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ── 12. sync_log ──────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `sync_log` (
  `log_id`    BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `direction` VARCHAR(10)         NOT NULL COMMENT 'push|pull',
  `entity`    VARCHAR(50)         NOT NULL,
  `count`     INT(11)             NOT NULL DEFAULT 0,
  `status`    VARCHAR(15)         NOT NULL COMMENT 'ok|partial|failed',
  `message`   TEXT                NULL,
  `ran_at`    DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  INDEX `idx_sl_ran` (`ran_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ── Nettoyage ─────────────────────────────────────────────────────────────────
DROP PROCEDURE IF EXISTS bonresto_add_col;
DROP PROCEDURE IF EXISTS bonresto_add_idx;
