-- ============================================================
-- BONRESTO SAAS — Fix missing tables & columns (MySQL 5.7+)
-- Run once on the VPS saas database:
--   mysql -u root -p saas < saas_fix_missing_tables.sql
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ── Helper procedure to add a column only if missing ─────────────────────────
DROP PROCEDURE IF EXISTS _saas_add_col;
DELIMITER //
CREATE PROCEDURE _saas_add_col(
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
        SET @s = CONCAT('ALTER TABLE `', tbl, '` ADD COLUMN `', col, '` ', def);
        PREPARE _stmt FROM @s;
        EXECUTE _stmt;
        DEALLOCATE PREPARE _stmt;
    END IF;
END //
DELIMITER ;

-- ── 1. saas_tenants — columns added individually ─────────────────────────────
CALL _saas_add_col('saas_tenants', 'city',                    'VARCHAR(100) NULL');
CALL _saas_add_col('saas_tenants', 'address',                 'VARCHAR(255) NULL');
CALL _saas_add_col('saas_tenants', 'website',                 'VARCHAR(255) NULL');
CALL _saas_add_col('saas_tenants', 'notes',                   'TEXT NULL');
CALL _saas_add_col('saas_tenants', 'logo_url',                'VARCHAR(500) NULL');
CALL _saas_add_col('saas_tenants', 'license_invalidated_at',  'DATETIME NULL');

-- ── 2. saas_admins ────────────────────────────────────────────────────────────
CALL _saas_add_col('saas_admins', 'role',      "VARCHAR(50) DEFAULT 'admin'");
CALL _saas_add_col('saas_admins', 'is_active', 'TINYINT DEFAULT 1');

-- ── 3. saas_license_keys ─────────────────────────────────────────────────────
CALL _saas_add_col('saas_license_keys', 'status',     "ENUM('active','revoked') DEFAULT 'active'");
CALL _saas_add_col('saas_license_keys', 'revoked_at', 'DATETIME NULL');
CALL _saas_add_col('saas_license_keys', 'price',      'DECIMAL(10,2) NULL');

-- ── 4. saas_invoices ─────────────────────────────────────────────────────────
-- Create if not exists (minimal schema — columns added below via procedure)
CREATE TABLE IF NOT EXISTS saas_invoices (
    invoice_id  INT AUTO_INCREMENT PRIMARY KEY,
    tenant_id   INT           NOT NULL,
    amount      DECIMAL(10,2) NOT NULL,
    created_at  DATETIME      DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES saas_tenants(tenant_id)
);

-- Add every column that may be missing (safe on both new and existing tables)
CALL _saas_add_col('saas_invoices', 'invoice_number', 'VARCHAR(30) NULL');
CALL _saas_add_col('saas_invoices', 'plan_id',        'INT NULL');
CALL _saas_add_col('saas_invoices', 'currency',       "VARCHAR(10) DEFAULT 'FCFA'");
CALL _saas_add_col('saas_invoices', 'period_start',   'DATE NULL');
CALL _saas_add_col('saas_invoices', 'period_end',     'DATE NULL');
CALL _saas_add_col('saas_invoices', 'status',         "ENUM('draft','sent','paid','cancelled') DEFAULT 'draft'");
CALL _saas_add_col('saas_invoices', 'payment_method', 'VARCHAR(50) NULL');
CALL _saas_add_col('saas_invoices', 'notes',          'TEXT NULL');
CALL _saas_add_col('saas_invoices', 'paid_at',        'DATETIME NULL');

-- ── 5. saas_settings ─────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS saas_settings (
    setting_id    INT AUTO_INCREMENT PRIMARY KEY,
    setting_key   VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT         NULL,
    updated_at    DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ── 6. saas_roles ─────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS saas_roles (
    role_id     INT AUTO_INCREMENT PRIMARY KEY,
    role_name   VARCHAR(100) NOT NULL UNIQUE,
    permissions JSON         NOT NULL DEFAULT ('[]'),
    created_at  DATETIME     DEFAULT CURRENT_TIMESTAMP
);

-- Add columns that may not exist yet (table existed before with fewer columns)
CALL _saas_add_col('saas_roles', 'label',     'VARCHAR(150) NULL AFTER role_name');
CALL _saas_add_col('saas_roles', 'color',     "VARCHAR(100) DEFAULT 'bg-gray-100 text-gray-600'");
CALL _saas_add_col('saas_roles', 'is_system', 'TINYINT DEFAULT 0');

INSERT IGNORE INTO saas_roles (role_name, label, permissions, is_system) VALUES
('super_admin', 'Super Admin', '["*"]',                                                                        1),
('admin',       'Admin',       '["clients.view","clients.edit","licenses.view","licenses.edit","plans.view"]', 1),
('viewer',      'Lecteur',     '["clients.view","licenses.view","plans.view"]',                                1);

-- ── Cleanup ───────────────────────────────────────────────────────────────────
DROP PROCEDURE IF EXISTS _saas_add_col;

SET FOREIGN_KEY_CHECKS = 1;
