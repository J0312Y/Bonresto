-- 🔹 Insertion des phrases (ignorer les doublons)
INSERT IGNORE INTO `language` (`phrase`, `english`) VALUES
('facebooklogin', 'Facebook Login'),
('add_facebook_app', 'Facebook Setting'),
('api_key', 'Api Key'),
('secret_key', 'Secret Key'),
('facebook_api', 'Facebook Api'),
('facebook_login', 'Facebook Login');

-- 🔹 Ajouter le champ facebook_id dans customer_info (si non existant)
ALTER TABLE `customer_info`
ADD COLUMN IF NOT EXISTS `facebook_id` VARCHAR(100) NULL DEFAULT NULL AFTER `cuntomer_no`;

-- 🔹 Menu principal Facebook Setting
INSERT IGNORE INTO `sec_menu_item`
(`menu_title`, `page_url`, `module`, `parent_menu`, `is_report`, `createby`, `createdate`)
VALUES ('add_facebook_app', 'facebookloginback', 'facebooklogin', '0', '0', '3', NOW());

-- 🔹 Sous-menu Facebook Api lié au menu principal
INSERT IGNORE INTO `sec_menu_item`
(`menu_title`, `page_url`, `module`, `parent_menu`, `is_report`, `createby`, `createdate`)
SELECT 'facebook_api', 'showsetting', 'facebooklogin', sec_menu_item.menu_id, '0', '3', NOW()
FROM sec_menu_item 
WHERE sec_menu_item.menu_title = 'add_facebook_app';
