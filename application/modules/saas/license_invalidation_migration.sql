-- Run once: adds license invalidation tracking to saas_tenants
-- mysql -u root -proot restaurant1 < license_invalidation_migration.sql

ALTER TABLE saas_tenants
    ADD COLUMN IF NOT EXISTS license_invalidated_at DATETIME NULL DEFAULT NULL
        COMMENT 'Set by SaaS when admin changes plan; triggers immediate refresh on client';
