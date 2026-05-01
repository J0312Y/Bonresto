-- ============================================================
-- LAMUKA-TECH SAAS — Base de données dédiée
-- Créer la DB d'abord : CREATE DATABASE saas CHARACTER SET utf8 COLLATE utf8_general_ci;
-- Puis sélectionner la DB `saas` et exécuter ce fichier.
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- 1. ADMINS SAAS (toi — le fournisseur)
CREATE TABLE IF NOT EXISTS saas_admins (
    admin_id   INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(150) NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    role       VARCHAR(50)  DEFAULT 'admin',
    is_active  TINYINT      DEFAULT 1,
    created_at DATETIME     DEFAULT CURRENT_TIMESTAMP
);

-- Mot de passe par défaut : Admin@1234 — à changer immédiatement
INSERT IGNORE INTO saas_admins (name, email, password, role)
VALUES ('Super Admin', 'admin@lamuka-tech.com', MD5('Admin@1234'), 'super_admin');

-- 2. PLANS D'ABONNEMENT
CREATE TABLE IF NOT EXISTS saas_plans (
    plan_id    INT AUTO_INCREMENT PRIMARY KEY,
    plan_name  VARCHAR(100)   NOT NULL,
    price      DECIMAL(10,2)  DEFAULT 0,
    max_tables INT            DEFAULT 0,
    max_users  INT            DEFAULT 0,
    features   JSON           NOT NULL,
    is_active  TINYINT        DEFAULT 1,
    created_at DATETIME       DEFAULT CURRENT_TIMESTAMP
);

INSERT IGNORE INTO saas_plans (plan_id, plan_name, price, max_tables, max_users, features) VALUES
(1, 'Basic',       90000, 5,  3,  '{"hrm":false,"kitchen":true,"qr_order":false,"reports":false,"reservation":false}'),
(2, 'Pro',        175000, 20, 10, '{"hrm":true,"kitchen":true,"qr_order":true,"reports":true,"reservation":true}'),
(3, 'Enterprise', 350000, 0,  0,  '{"hrm":true,"kitchen":true,"qr_order":true,"reports":true,"reservation":true}');

-- 3. CLIENTS (un par restaurant)
CREATE TABLE IF NOT EXISTS saas_tenants (
    tenant_id     INT AUTO_INCREMENT PRIMARY KEY,
    business_name VARCHAR(200) NOT NULL,
    email         VARCHAR(150) NOT NULL UNIQUE,
    phone         VARCHAR(30),
    country       VARCHAR(100),
    is_active     TINYINT      DEFAULT 1,
    created_at    DATETIME     DEFAULT CURRENT_TIMESTAMP,
    license_invalidated_at DATETIME NULL
);

-- 4. ABONNEMENTS
CREATE TABLE IF NOT EXISTS saas_subscriptions (
    sub_id         INT AUTO_INCREMENT PRIMARY KEY,
    tenant_id      INT  NOT NULL,
    plan_id        INT  NOT NULL,
    status         ENUM('active','grace','expired','suspended') DEFAULT 'active',
    start_date     DATE NOT NULL,
    end_date       DATE NOT NULL,
    grace_end_date DATE NOT NULL,
    created_at     DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES saas_tenants(tenant_id),
    FOREIGN KEY (plan_id)   REFERENCES saas_plans(plan_id)
);

-- 5. CLÉS DE LICENSE
CREATE TABLE IF NOT EXISTS saas_license_keys (
    key_id       INT AUTO_INCREMENT PRIMARY KEY,
    tenant_id    INT          NOT NULL,
    client_key   VARCHAR(64)  NOT NULL UNIQUE,
    is_activated TINYINT      DEFAULT 0,
    activated_at DATETIME     NULL,
    server_url   VARCHAR(255) NULL,
    price        DECIMAL(10,2) NULL,
    created_at   DATETIME     DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES saas_tenants(tenant_id)
);

-- 6. PAIEMENTS
CREATE TABLE IF NOT EXISTS saas_payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    tenant_id  INT           NOT NULL,
    plan_id    INT           NOT NULL,
    amount     DECIMAL(10,2) NOT NULL,
    currency   VARCHAR(10)   DEFAULT 'XAF',
    status     ENUM('pending','paid','failed','refunded') DEFAULT 'pending',
    reference  VARCHAR(200)  NULL,
    created_at DATETIME      DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES saas_tenants(tenant_id)
);

-- 7. LOGS D'ACTIVITÉ
CREATE TABLE IF NOT EXISTS saas_activity_log (
    log_id     INT AUTO_INCREMENT PRIMARY KEY,
    tenant_id  INT          NOT NULL,
    action     VARCHAR(100) NOT NULL,
    description TEXT,
    meta       JSON NULL,
    created_at DATETIME     DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_tenant  (tenant_id),
    INDEX idx_created (created_at)
);

-- 8. ROLES (optionnel — pour l'équipe SaaS)
CREATE TABLE IF NOT EXISTS saas_roles (
    role_id     INT AUTO_INCREMENT PRIMARY KEY,
    role_name   VARCHAR(100) NOT NULL UNIQUE,
    permissions JSON         NOT NULL,
    created_at  DATETIME     DEFAULT CURRENT_TIMESTAMP
);

INSERT IGNORE INTO saas_roles (role_name, permissions) VALUES
('super_admin', '["*"]'),
('admin',       '["clients.view","clients.edit","licenses.view","licenses.edit","plans.view"]'),
('viewer',      '["clients.view","licenses.view","plans.view"]');

SET FOREIGN_KEY_CHECKS = 1;
