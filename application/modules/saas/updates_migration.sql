-- Run this once to add the updates system
-- mysql -u root -proot restaurant1 < updates_migration.sql

CREATE TABLE IF NOT EXISTS saas_updates (
    update_id    INT AUTO_INCREMENT PRIMARY KEY,
    title        VARCHAR(255) NOT NULL,
    version      VARCHAR(50)  NOT NULL,
    module       VARCHAR(100) NOT NULL,
    type         ENUM('config','code') NOT NULL DEFAULT 'config',
    target_type  ENUM('all','plan','tenant') NOT NULL DEFAULT 'all',
    target_id    INT NULL COMMENT 'plan_id or tenant_id depending on target_type',
    changelog    TEXT NULL,
    payload      LONGTEXT NULL COMMENT 'JSON: config object OR [{path, content_b64}] for code',
    status       ENUM('draft','published','archived') NOT NULL DEFAULT 'draft',
    created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    published_at DATETIME NULL,
    INDEX idx_status (status),
    INDEX idx_module (module),
    INDEX idx_target (target_type, target_id)
);

CREATE TABLE IF NOT EXISTS saas_update_deliveries (
    delivery_id  INT AUTO_INCREMENT PRIMARY KEY,
    update_id    INT NOT NULL,
    tenant_id    INT NOT NULL,
    status       ENUM('pending','applied','failed') NOT NULL DEFAULT 'pending',
    applied_at   DATETIME NULL,
    error_msg    TEXT NULL,
    UNIQUE KEY uq_update_tenant (update_id, tenant_id),
    INDEX idx_tenant (tenant_id),
    INDEX idx_status (status)
);
