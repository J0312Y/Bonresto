-- Phase 3: Waiter Call / Request Bill
CREATE TABLE IF NOT EXISTS `waiter_call` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `table_id` INT(11) NOT NULL,
  `customer_id` INT(11) DEFAULT NULL,
  `call_type` ENUM('waiter','bill') NOT NULL DEFAULT 'waiter',
  `status` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0=pending,1=acknowledged,2=completed',
  `created_at` DATETIME NOT NULL,
  `acknowledged_at` DATETIME DEFAULT NULL,
  `acknowledged_by` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_table_status` (`table_id`, `status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
