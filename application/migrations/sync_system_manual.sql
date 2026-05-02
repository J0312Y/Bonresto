-- ============================================================
-- Sync System — Phase 1 — Manual SQL
-- Run this on BOTH local DB and VPS DB (restaurant1)
-- Date: 2026-05-02
-- ============================================================

-- ── 1. Sync columns on customer_order ────────────────────────────────────────

ALTER TABLE `customer_order`
  ADD COLUMN IF NOT EXISTS `sync_uuid`       CHAR(36)    NULL     DEFAULT NULL    COMMENT 'Globally unique ID across local+VPS',
  ADD COLUMN IF NOT EXISTS `sync_origin`     VARCHAR(10) NOT NULL DEFAULT 'local' COMMENT 'local|vps|website',
  ADD COLUMN IF NOT EXISTS `synced_to_vps`   TINYINT(1)  NOT NULL DEFAULT 0,
  ADD COLUMN IF NOT EXISTS `synced_at`       DATETIME    NULL     DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `vps_order_id`    BIGINT(20)  NULL     DEFAULT NULL    COMMENT 'Corresponding order_id on VPS',
  ADD COLUMN IF NOT EXISTS `ack_by_local_at` DATETIME    NULL     DEFAULT NULL    COMMENT 'Set on VPS when local confirms receipt of online order';

ALTER TABLE `customer_order`
  ADD INDEX IF NOT EXISTS `idx_co_sync_uuid`  (`sync_uuid`),
  ADD INDEX IF NOT EXISTS `idx_co_synced`     (`synced_to_vps`),
  ADD INDEX IF NOT EXISTS `idx_co_origin`     (`sync_origin`),
  ADD INDEX IF NOT EXISTS `idx_co_ack`        (`ack_by_local_at`);

-- ── 2. Sync columns on order_menu ────────────────────────────────────────────

ALTER TABLE `order_menu`
  ADD COLUMN IF NOT EXISTS `sync_uuid`     CHAR(36)   NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `synced_to_vps` TINYINT(1) NOT NULL DEFAULT 0,
  ADD COLUMN IF NOT EXISTS `synced_at`     DATETIME   NULL DEFAULT NULL;

ALTER TABLE `order_menu`
  ADD INDEX IF NOT EXISTS `idx_om_sync_uuid` (`sync_uuid`);

-- ── 3. Sync columns on item_foods ─────────────────────────────────────────────

ALTER TABLE `item_foods`
  ADD COLUMN IF NOT EXISTS `sync_uuid`     CHAR(36)   NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `synced_to_vps` TINYINT(1) NOT NULL DEFAULT 0,
  ADD COLUMN IF NOT EXISTS `synced_at`     DATETIME   NULL DEFAULT NULL;

ALTER TABLE `item_foods`
  ADD INDEX IF NOT EXISTS `idx_if_sync_uuid` (`sync_uuid`);

-- ── 4. Sync columns on variant ────────────────────────────────────────────────

ALTER TABLE `variant`
  ADD COLUMN IF NOT EXISTS `sync_uuid`     CHAR(36)   NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `synced_to_vps` TINYINT(1) NOT NULL DEFAULT 0,
  ADD COLUMN IF NOT EXISTS `synced_at`     DATETIME   NULL DEFAULT NULL;

ALTER TABLE `variant`
  ADD INDEX IF NOT EXISTS `idx_va_sync_uuid` (`sync_uuid`);

-- ── 5. Sync columns on item_category ─────────────────────────────────────────

ALTER TABLE `item_category`
  ADD COLUMN IF NOT EXISTS `sync_uuid`     CHAR(36)   NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `synced_to_vps` TINYINT(1) NOT NULL DEFAULT 0,
  ADD COLUMN IF NOT EXISTS `synced_at`     DATETIME   NULL DEFAULT NULL;

ALTER TABLE `item_category`
  ADD INDEX IF NOT EXISTS `idx_ic_sync_uuid` (`sync_uuid`);

-- ── 6. Sync columns on tablelist ──────────────────────────────────────────────

ALTER TABLE `tablelist`
  ADD COLUMN IF NOT EXISTS `sync_uuid`     CHAR(36)   NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `synced_to_vps` TINYINT(1) NOT NULL DEFAULT 0,
  ADD COLUMN IF NOT EXISTS `synced_at`     DATETIME   NULL DEFAULT NULL;

ALTER TABLE `tablelist`
  ADD INDEX IF NOT EXISTS `idx_tl_sync_uuid` (`sync_uuid`);

-- ── 7. Sync columns on bill ───────────────────────────────────────────────────

ALTER TABLE `bill`
  ADD COLUMN IF NOT EXISTS `sync_uuid`     CHAR(36)   NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `synced_to_vps` TINYINT(1) NOT NULL DEFAULT 0,
  ADD COLUMN IF NOT EXISTS `synced_at`     DATETIME   NULL DEFAULT NULL;

ALTER TABLE `bill`
  ADD INDEX IF NOT EXISTS `idx_bi_sync_uuid` (`sync_uuid`);

-- ── 8. Backfill UUID sur les lignes existantes ────────────────────────────────
-- (optionnel mais recommandé pour les données déjà présentes)

UPDATE `customer_order` SET `sync_uuid` = UUID() WHERE `sync_uuid` IS NULL;
UPDATE `order_menu`     SET `sync_uuid` = UUID() WHERE `sync_uuid` IS NULL;
UPDATE `item_foods`     SET `sync_uuid` = UUID() WHERE `sync_uuid` IS NULL;
UPDATE `variant`        SET `sync_uuid` = UUID() WHERE `sync_uuid` IS NULL;
UPDATE `item_category`  SET `sync_uuid` = UUID() WHERE `sync_uuid` IS NULL;
UPDATE `tablelist`      SET `sync_uuid` = UUID() WHERE `sync_uuid` IS NULL;
UPDATE `bill`           SET `sync_uuid` = UUID() WHERE `sync_uuid` IS NULL;

-- ── 9. sync_queue — file d'attente sortante (local → VPS) ────────────────────

CREATE TABLE IF NOT EXISTS `sync_queue` (
  `queue_id`    BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `entity_type` VARCHAR(50)         NOT NULL COMMENT 'customer_order|order_menu|item_foods|variant|item_category|tablelist|bill',
  `entity_id`   BIGINT(20)          NOT NULL COMMENT 'PK de la ligne modifiée',
  `operation`   VARCHAR(10)         NOT NULL COMMENT 'insert|update|delete',
  `payload`     LONGTEXT            NOT NULL COMMENT 'JSON snapshot de la ligne au moment de l enqueue',
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

-- ── 10. sync_online_orders — tracker entrant (VPS → local) ───────────────────

CREATE TABLE IF NOT EXISTS `sync_online_orders` (
  `id`             INT(11) UNSIGNED    NOT NULL AUTO_INCREMENT,
  `vps_order_id`   BIGINT(20)          NOT NULL COMMENT 'order_id sur le VPS',
  `vps_sync_uuid`  CHAR(36)            NOT NULL,
  `local_order_id` BIGINT(20)          NULL DEFAULT NULL COMMENT 'order_id créé localement après import',
  `status`         VARCHAR(15)         NOT NULL DEFAULT 'pending' COMMENT 'pending|imported|failed',
  `pulled_at`      DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `imported_at`    DATETIME            NULL,
  `last_error`     TEXT                NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_vps_order` (`vps_order_id`),
  INDEX `idx_soo_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ── 11. sync_config — configuration de la connexion VPS ──────────────────────

CREATE TABLE IF NOT EXISTS `sync_config` (
  `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vps_url`     VARCHAR(255)     NOT NULL COMMENT 'URL de base du VPS, ex: https://vps.example.com/bonresto/index.php',
  `client_key`  VARCHAR(100)     NOT NULL COMMENT 'Même client_key que la licence',
  `sync_secret` VARCHAR(100)     NOT NULL COMMENT 'Secret HMAC-SHA256 partagé pour signer les payloads',
  `enabled`     TINYINT(1)       NOT NULL DEFAULT 1,
  `last_push`   DATETIME         NULL,
  `last_pull`   DATETIME         NULL,
  `updated_at`  DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ── 12. sync_log — journal d'audit ───────────────────────────────────────────

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
