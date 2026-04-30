-- ============================================================
-- BONRESTO SAAS MIGRATION
-- Run this once on your database to enable multi-tenancy
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------
-- 1. SAAS ADMIN USERS (super admins who manage all tenants)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS saas_admins (
    admin_id    INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(150) NOT NULL,
    email       VARCHAR(150) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Default super admin (password: Admin@1234 — change immediately)
INSERT IGNORE INTO saas_admins (name, email, password)
VALUES ('Super Admin', 'admin@bonresto.com', MD5('Admin@1234'));

-- ------------------------------------------------------------
-- 2. SUBSCRIPTION PLANS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS saas_plans (
    plan_id     INT AUTO_INCREMENT PRIMARY KEY,
    plan_name   VARCHAR(100) NOT NULL,
    price       DECIMAL(10,2) DEFAULT 0,
    max_tables  INT DEFAULT 0,
    max_users   INT DEFAULT 0,
    features    JSON NOT NULL DEFAULT ('{}'),
    is_active   TINYINT DEFAULT 1,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT IGNORE INTO saas_plans (plan_id, plan_name, price, max_tables, max_users, features) VALUES
(1, 'Basic',      149.00,   5,  3,  '{"hrm":false,"kitchen":true,"qr_order":false,"reports":false,"online_payment":false,"whatsapp":false,"reservation":false}'),
(2, 'Pro',        299.00,  20, 10,  '{"hrm":true,"kitchen":true,"qr_order":true,"reports":true,"online_payment":true,"whatsapp":false,"reservation":true}'),
(3, 'Enterprise', 599.00,   0,  0,  '{"hrm":true,"kitchen":true,"qr_order":true,"reports":true,"online_payment":true,"whatsapp":true,"reservation":true}');

-- ------------------------------------------------------------
-- 3. TENANTS (one per restaurant/customer)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS saas_tenants (
    tenant_id       INT AUTO_INCREMENT PRIMARY KEY,
    business_name   VARCHAR(200) NOT NULL,
    email           VARCHAR(150) NOT NULL UNIQUE,
    phone           VARCHAR(30),
    country         VARCHAR(100),
    db_name         VARCHAR(100),           -- for future per-DB isolation
    is_active       TINYINT DEFAULT 1,
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ------------------------------------------------------------
-- 4. TENANT SUBSCRIPTIONS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS saas_subscriptions (
    sub_id          INT AUTO_INCREMENT PRIMARY KEY,
    tenant_id       INT NOT NULL,
    plan_id         INT NOT NULL,
    status          ENUM('active','grace','expired','suspended') DEFAULT 'active',
    start_date      DATE NOT NULL,
    end_date        DATE NOT NULL,
    grace_end_date  DATE NOT NULL,
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES saas_tenants(tenant_id),
    FOREIGN KEY (plan_id)   REFERENCES saas_plans(plan_id)
);

-- ------------------------------------------------------------
-- 5. LICENSE KEYS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS saas_license_keys (
    key_id          INT AUTO_INCREMENT PRIMARY KEY,
    tenant_id       INT NOT NULL,
    client_key      VARCHAR(64) NOT NULL UNIQUE,
    is_activated    TINYINT DEFAULT 0,
    activated_at    DATETIME,
    server_url      VARCHAR(255),
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES saas_tenants(tenant_id)
);

-- ------------------------------------------------------------
-- 6. PAYMENTS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS saas_payments (
    payment_id      INT AUTO_INCREMENT PRIMARY KEY,
    tenant_id       INT NOT NULL,
    plan_id         INT NOT NULL,
    amount          DECIMAL(10,2) NOT NULL,
    currency        VARCHAR(10) DEFAULT 'EUR',
    status          ENUM('pending','paid','failed','refunded') DEFAULT 'pending',
    reference       VARCHAR(200),
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES saas_tenants(tenant_id)
);

-- ------------------------------------------------------------
-- 7. ACTIVITY LOG (monitors what each tenant does)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS saas_activity_log (
    log_id          INT AUTO_INCREMENT PRIMARY KEY,
    tenant_id       INT NOT NULL,
    action          VARCHAR(100) NOT NULL,   -- e.g. 'order_placed', 'user_login'
    description     TEXT,
    meta            JSON,                    -- extra data (order_id, user_id, etc.)
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_tenant (tenant_id),
    INDEX idx_created (created_at)
);

-- ------------------------------------------------------------
-- 8. ADD tenant_id TO EXISTING TABLES (multi-tenancy)
--    Skip if column already exists
-- ------------------------------------------------------------

ALTER TABLE `user`
    ADD COLUMN IF NOT EXISTS `tenant_id` INT DEFAULT 1 AFTER `id`,
    ADD INDEX IF NOT EXISTS `idx_user_tenant` (`tenant_id`);

ALTER TABLE `customer_info`
    ADD COLUMN IF NOT EXISTS `tenant_id` INT DEFAULT 1 AFTER `customer_id`,
    ADD INDEX IF NOT EXISTS `idx_customer_tenant` (`tenant_id`);

ALTER TABLE `customer_order`
    ADD COLUMN IF NOT EXISTS `tenant_id` INT DEFAULT 1 AFTER `order_id`,
    ADD INDEX IF NOT EXISTS `idx_order_tenant` (`tenant_id`);

ALTER TABLE `item_category`
    ADD COLUMN IF NOT EXISTS `tenant_id` INT DEFAULT 1 AFTER `CategoryID`,
    ADD INDEX IF NOT EXISTS `idx_category_tenant` (`tenant_id`);

ALTER TABLE `tbl_products`
    ADD COLUMN IF NOT EXISTS `tenant_id` INT DEFAULT 1 AFTER `ProductsID`,
    ADD INDEX IF NOT EXISTS `idx_product_tenant` (`tenant_id`);

ALTER TABLE `rest_table`
    ADD COLUMN IF NOT EXISTS `tenant_id` INT DEFAULT 1 AFTER `tableid`,
    ADD INDEX IF NOT EXISTS `idx_table_tenant` (`tenant_id`);

ALTER TABLE `setting`
    ADD COLUMN IF NOT EXISTS `tenant_id` INT DEFAULT 1,
    ADD INDEX IF NOT EXISTS `idx_setting_tenant` (`tenant_id`);

SET FOREIGN_KEY_CHECKS = 1;
