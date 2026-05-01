-- ============================================================
-- BONRESTO SAAS — Fix missing tables & columns
-- Run once on the VPS saas database:
--   mysql -u root -p saas < saas_fix_missing_tables.sql
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Add missing columns to saas_tenants (skip if already done)
ALTER TABLE saas_tenants
    ADD COLUMN IF NOT EXISTS city        VARCHAR(100) NULL AFTER country,
    ADD COLUMN IF NOT EXISTS address     VARCHAR(255) NULL AFTER city,
    ADD COLUMN IF NOT EXISTS website     VARCHAR(255) NULL AFTER address,
    ADD COLUMN IF NOT EXISTS notes       TEXT         NULL AFTER website,
    ADD COLUMN IF NOT EXISTS logo_url    VARCHAR(500) NULL AFTER notes,
    ADD COLUMN IF NOT EXISTS license_invalidated_at DATETIME NULL AFTER logo_url;

-- 2. Add missing columns to saas_admins
ALTER TABLE saas_admins
    ADD COLUMN IF NOT EXISTS role      VARCHAR(50) DEFAULT 'admin' AFTER password,
    ADD COLUMN IF NOT EXISTS is_active TINYINT     DEFAULT 1       AFTER role;

-- 3. Add missing columns to saas_license_keys
ALTER TABLE saas_license_keys
    ADD COLUMN IF NOT EXISTS status     ENUM('active','revoked') DEFAULT 'active' AFTER client_key,
    ADD COLUMN IF NOT EXISTS revoked_at DATETIME NULL AFTER status,
    ADD COLUMN IF NOT EXISTS price      DECIMAL(10,2) NULL;

-- 4. Create saas_invoices (used by billing / ClientDetail)
CREATE TABLE IF NOT EXISTS saas_invoices (
    invoice_id      INT AUTO_INCREMENT PRIMARY KEY,
    invoice_number  VARCHAR(30)    NOT NULL UNIQUE,
    tenant_id       INT            NOT NULL,
    plan_id         INT            NULL,
    amount          DECIMAL(10,2)  NOT NULL,
    currency        VARCHAR(10)    DEFAULT 'FCFA',
    period_start    DATE           NULL,
    period_end      DATE           NULL,
    status          ENUM('draft','sent','paid','cancelled') DEFAULT 'draft',
    payment_method  VARCHAR(50)    NULL,
    notes           TEXT           NULL,
    paid_at         DATETIME       NULL,
    created_at      DATETIME       DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_tenant (tenant_id),
    INDEX idx_status (status),
    FOREIGN KEY (tenant_id) REFERENCES saas_tenants(tenant_id)
);

-- 5. Create saas_settings (used for SMTP, company info, etc.)
CREATE TABLE IF NOT EXISTS saas_settings (
    setting_id    INT AUTO_INCREMENT PRIMARY KEY,
    setting_key   VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT         NULL,
    updated_at    DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 6. Create saas_roles (team permissions)
CREATE TABLE IF NOT EXISTS saas_roles (
    role_id     INT AUTO_INCREMENT PRIMARY KEY,
    role_name   VARCHAR(100) NOT NULL UNIQUE,
    label       VARCHAR(150) NULL,
    color       VARCHAR(100) DEFAULT 'bg-gray-100 text-gray-600',
    permissions JSON         NOT NULL DEFAULT ('[]'),
    is_system   TINYINT      DEFAULT 0,
    created_at  DATETIME     DEFAULT CURRENT_TIMESTAMP
);

INSERT IGNORE INTO saas_roles (role_name, label, permissions, is_system) VALUES
('super_admin', 'Super Admin', '["*"]',                                                                        1),
('admin',       'Admin',       '["clients.view","clients.edit","licenses.view","licenses.edit","plans.view"]', 1),
('viewer',      'Lecteur',     '["clients.view","licenses.view","plans.view"]',                                1);

SET FOREIGN_KEY_CHECKS = 1;
