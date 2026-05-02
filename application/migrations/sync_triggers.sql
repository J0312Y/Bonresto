-- ============================================================
-- SYNC TRIGGERS — Serveur LOCAL uniquement
-- NE PAS exécuter sur le VPS (le VPS est esclave pour les
-- données de référence, pas de retour-sync nécessaire)
-- ============================================================
-- Exécution : coller dans phpMyAdmin (base restaurant1) OU :
--   mysql -u root -p restaurant1 < sync_triggers.sql
-- ============================================================

SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION';

-- Autoriser payload NULL : les triggers n'ont pas besoin de
-- sérialiser la ligne — Sync_manager relit la ligne au moment du push.
ALTER TABLE sync_queue MODIFY payload longtext DEFAULT NULL;

DELIMITER //

-- ─── MENU & ITEMS ────────────────────────────────────────────────────────────

DROP TRIGGER IF EXISTS trg_item_category_ins //
CREATE TRIGGER trg_item_category_ins AFTER INSERT ON item_category FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('item_category',NEW.CategoryID,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_item_category_upd //
CREATE TRIGGER trg_item_category_upd AFTER UPDATE ON item_category FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('item_category',NEW.CategoryID,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_item_category_del //
CREATE TRIGGER trg_item_category_del AFTER DELETE ON item_category FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('item_category',OLD.CategoryID,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_item_foods_ins //
CREATE TRIGGER trg_item_foods_ins AFTER INSERT ON item_foods FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('item_foods',NEW.ProductsID,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_item_foods_upd //
CREATE TRIGGER trg_item_foods_upd AFTER UPDATE ON item_foods FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('item_foods',NEW.ProductsID,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_item_foods_del //
CREATE TRIGGER trg_item_foods_del AFTER DELETE ON item_foods FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('item_foods',OLD.ProductsID,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_variant_ins //
CREATE TRIGGER trg_variant_ins AFTER INSERT ON variant FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('variant',NEW.variantid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_variant_upd //
CREATE TRIGGER trg_variant_upd AFTER UPDATE ON variant FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('variant',NEW.variantid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_variant_del //
CREATE TRIGGER trg_variant_del AFTER DELETE ON variant FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('variant',OLD.variantid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_foodvariable_ins //
CREATE TRIGGER trg_foodvariable_ins AFTER INSERT ON foodvariable FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('foodvariable',NEW.availableID,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_foodvariable_upd //
CREATE TRIGGER trg_foodvariable_upd AFTER UPDATE ON foodvariable FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('foodvariable',NEW.availableID,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_foodvariable_del //
CREATE TRIGGER trg_foodvariable_del AFTER DELETE ON foodvariable FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('foodvariable',OLD.availableID,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_add_ons_ins //
CREATE TRIGGER trg_add_ons_ins AFTER INSERT ON add_ons FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('add_ons',NEW.add_on_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_add_ons_upd //
CREATE TRIGGER trg_add_ons_upd AFTER UPDATE ON add_ons FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('add_ons',NEW.add_on_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_add_ons_del //
CREATE TRIGGER trg_add_ons_del AFTER DELETE ON add_ons FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('add_ons',OLD.add_on_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_menu_add_on_ins //
CREATE TRIGGER trg_menu_add_on_ins AFTER INSERT ON menu_add_on FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('menu_add_on',NEW.row_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_menu_add_on_upd //
CREATE TRIGGER trg_menu_add_on_upd AFTER UPDATE ON menu_add_on FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('menu_add_on',NEW.row_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_menu_add_on_del //
CREATE TRIGGER trg_menu_add_on_del AFTER DELETE ON menu_add_on FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('menu_add_on',OLD.row_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_check_addones_ins //
CREATE TRIGGER trg_check_addones_ins AFTER INSERT ON check_addones FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('check_addones',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_check_addones_upd //
CREATE TRIGGER trg_check_addones_upd AFTER UPDATE ON check_addones FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('check_addones',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_check_addones_del //
CREATE TRIGGER trg_check_addones_del AFTER DELETE ON check_addones FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('check_addones',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_menutype_ins //
CREATE TRIGGER trg_tbl_menutype_ins AFTER INSERT ON tbl_menutype FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_menutype',NEW.menutypeid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_menutype_upd //
CREATE TRIGGER trg_tbl_menutype_upd AFTER UPDATE ON tbl_menutype FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_menutype',NEW.menutypeid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_menutype_del //
CREATE TRIGGER trg_tbl_menutype_del AFTER DELETE ON tbl_menutype FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_menutype',OLD.menutypeid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_groupitems_ins //
CREATE TRIGGER trg_tbl_groupitems_ins AFTER INSERT ON tbl_groupitems FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_groupitems',NEW.groupid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_groupitems_upd //
CREATE TRIGGER trg_tbl_groupitems_upd AFTER UPDATE ON tbl_groupitems FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_groupitems',NEW.groupid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_groupitems_del //
CREATE TRIGGER trg_tbl_groupitems_del AFTER DELETE ON tbl_groupitems FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_groupitems',OLD.groupid,'delete','pending',NOW()); END//

-- ─── CONFIG RESTAURANT ───────────────────────────────────────────────────────

DROP TRIGGER IF EXISTS trg_setting_ins //
CREATE TRIGGER trg_setting_ins AFTER INSERT ON setting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('setting',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_setting_upd //
CREATE TRIGGER trg_setting_upd AFTER UPDATE ON setting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('setting',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_setting_del //
CREATE TRIGGER trg_setting_del AFTER DELETE ON setting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('setting',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_common_setting_ins //
CREATE TRIGGER trg_common_setting_ins AFTER INSERT ON common_setting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('common_setting',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_common_setting_upd //
CREATE TRIGGER trg_common_setting_upd AFTER UPDATE ON common_setting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('common_setting',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_common_setting_del //
CREATE TRIGGER trg_common_setting_del AFTER DELETE ON common_setting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('common_setting',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_currency_ins //
CREATE TRIGGER trg_currency_ins AFTER INSERT ON currency FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('currency',NEW.currencyid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_currency_upd //
CREATE TRIGGER trg_currency_upd AFTER UPDATE ON currency FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('currency',NEW.currencyid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_currency_del //
CREATE TRIGGER trg_currency_del AFTER DELETE ON currency FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('currency',OLD.currencyid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_language_ins //
CREATE TRIGGER trg_language_ins AFTER INSERT ON language FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('language',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_language_upd //
CREATE TRIGGER trg_language_upd AFTER UPDATE ON language FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('language',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_language_del //
CREATE TRIGGER trg_language_del AFTER DELETE ON language FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('language',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_themes_ins //
CREATE TRIGGER trg_themes_ins AFTER INSERT ON themes FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('themes',NEW.themeid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_themes_upd //
CREATE TRIGGER trg_themes_upd AFTER UPDATE ON themes FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('themes',NEW.themeid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_themes_del //
CREATE TRIGGER trg_themes_del AFTER DELETE ON themes FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('themes',OLD.themeid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_top_menu_ins //
CREATE TRIGGER trg_top_menu_ins AFTER INSERT ON top_menu FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('top_menu',NEW.menuid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_top_menu_upd //
CREATE TRIGGER trg_top_menu_upd AFTER UPDATE ON top_menu FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('top_menu',NEW.menuid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_top_menu_del //
CREATE TRIGGER trg_top_menu_del AFTER DELETE ON top_menu FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('top_menu',OLD.menuid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tax_settings_ins //
CREATE TRIGGER trg_tax_settings_ins AFTER INSERT ON tax_settings FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tax_settings',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tax_settings_upd //
CREATE TRIGGER trg_tax_settings_upd AFTER UPDATE ON tax_settings FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tax_settings',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tax_settings_del //
CREATE TRIGGER trg_tax_settings_del AFTER DELETE ON tax_settings FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tax_settings',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_payment_method_ins //
CREATE TRIGGER trg_payment_method_ins AFTER INSERT ON payment_method FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('payment_method',NEW.payment_method_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_payment_method_upd //
CREATE TRIGGER trg_payment_method_upd AFTER UPDATE ON payment_method FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('payment_method',NEW.payment_method_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_payment_method_del //
CREATE TRIGGER trg_payment_method_del AFTER DELETE ON payment_method FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('payment_method',OLD.payment_method_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_paymentmethod_ins //
CREATE TRIGGER trg_paymentmethod_ins AFTER INSERT ON paymentmethod FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('paymentmethod',NEW.payment_method_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_paymentmethod_upd //
CREATE TRIGGER trg_paymentmethod_upd AFTER UPDATE ON paymentmethod FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('paymentmethod',NEW.payment_method_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_paymentmethod_del //
CREATE TRIGGER trg_paymentmethod_del AFTER DELETE ON paymentmethod FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('paymentmethod',OLD.payment_method_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_paymentsetup_ins //
CREATE TRIGGER trg_paymentsetup_ins AFTER INSERT ON paymentsetup FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('paymentsetup',NEW.setupid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_paymentsetup_upd //
CREATE TRIGGER trg_paymentsetup_upd AFTER UPDATE ON paymentsetup FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('paymentsetup',NEW.setupid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_paymentsetup_del //
CREATE TRIGGER trg_paymentsetup_del AFTER DELETE ON paymentsetup FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('paymentsetup',OLD.setupid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_shipping_method_ins //
CREATE TRIGGER trg_shipping_method_ins AFTER INSERT ON shipping_method FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('shipping_method',NEW.ship_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_shipping_method_upd //
CREATE TRIGGER trg_shipping_method_upd AFTER UPDATE ON shipping_method FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('shipping_method',NEW.ship_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_shipping_method_del //
CREATE TRIGGER trg_shipping_method_del AFTER DELETE ON shipping_method FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('shipping_method',OLD.ship_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_delivaritime_ins //
CREATE TRIGGER trg_tbl_delivaritime_ins AFTER INSERT ON tbl_delivaritime FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_delivaritime',NEW.dtimeid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_delivaritime_upd //
CREATE TRIGGER trg_tbl_delivaritime_upd AFTER UPDATE ON tbl_delivaritime FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_delivaritime',NEW.dtimeid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_delivaritime_del //
CREATE TRIGGER trg_tbl_delivaritime_del AFTER DELETE ON tbl_delivaritime FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_delivaritime',OLD.dtimeid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_notificationsetting_ins //
CREATE TRIGGER trg_tbl_notificationsetting_ins AFTER INSERT ON tbl_notificationsetting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_notificationsetting',NEW.notifid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_notificationsetting_upd //
CREATE TRIGGER trg_tbl_notificationsetting_upd AFTER UPDATE ON tbl_notificationsetting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_notificationsetting',NEW.notifid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_notificationsetting_del //
CREATE TRIGGER trg_tbl_notificationsetting_del AFTER DELETE ON tbl_notificationsetting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_notificationsetting',OLD.notifid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_slider_ins //
CREATE TRIGGER trg_tbl_slider_ins AFTER INSERT ON tbl_slider FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_slider',NEW.slid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_slider_upd //
CREATE TRIGGER trg_tbl_slider_upd AFTER UPDATE ON tbl_slider FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_slider',NEW.slid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_slider_del //
CREATE TRIGGER trg_tbl_slider_del AFTER DELETE ON tbl_slider FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_slider',OLD.slid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_slider_type_ins //
CREATE TRIGGER trg_tbl_slider_type_ins AFTER INSERT ON tbl_slider_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_slider_type',NEW.stype_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_slider_type_upd //
CREATE TRIGGER trg_tbl_slider_type_upd AFTER UPDATE ON tbl_slider_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_slider_type',NEW.stype_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_slider_type_del //
CREATE TRIGGER trg_tbl_slider_type_del AFTER DELETE ON tbl_slider_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_slider_type',OLD.stype_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_sociallink_ins //
CREATE TRIGGER trg_tbl_sociallink_ins AFTER INSERT ON tbl_sociallink FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_sociallink',NEW.sid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_sociallink_upd //
CREATE TRIGGER trg_tbl_sociallink_upd AFTER UPDATE ON tbl_sociallink FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_sociallink',NEW.sid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_sociallink_del //
CREATE TRIGGER trg_tbl_sociallink_del AFTER DELETE ON tbl_sociallink FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_sociallink',OLD.sid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_widget_ins //
CREATE TRIGGER trg_tbl_widget_ins AFTER INSERT ON tbl_widget FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_widget',NEW.widgetid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_widget_upd //
CREATE TRIGGER trg_tbl_widget_upd AFTER UPDATE ON tbl_widget FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_widget',NEW.widgetid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_widget_del //
CREATE TRIGGER trg_tbl_widget_del AFTER DELETE ON tbl_widget FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_widget',OLD.widgetid,'delete','pending',NOW()); END//

-- ─── LOCALISATION ────────────────────────────────────────────────────────────

DROP TRIGGER IF EXISTS trg_tbl_country_ins //
CREATE TRIGGER trg_tbl_country_ins AFTER INSERT ON tbl_country FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_country',NEW.countryid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_country_upd //
CREATE TRIGGER trg_tbl_country_upd AFTER UPDATE ON tbl_country FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_country',NEW.countryid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_country_del //
CREATE TRIGGER trg_tbl_country_del AFTER DELETE ON tbl_country FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_country',OLD.countryid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_state_ins //
CREATE TRIGGER trg_tbl_state_ins AFTER INSERT ON tbl_state FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_state',NEW.stateid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_state_upd //
CREATE TRIGGER trg_tbl_state_upd AFTER UPDATE ON tbl_state FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_state',NEW.stateid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_state_del //
CREATE TRIGGER trg_tbl_state_del AFTER DELETE ON tbl_state FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_state',OLD.stateid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_city_ins //
CREATE TRIGGER trg_tbl_city_ins AFTER INSERT ON tbl_city FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_city',NEW.cityid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_city_upd //
CREATE TRIGGER trg_tbl_city_upd AFTER UPDATE ON tbl_city FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_city',NEW.cityid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_city_del //
CREATE TRIGGER trg_tbl_city_del AFTER DELETE ON tbl_city FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_city',OLD.cityid,'delete','pending',NOW()); END//

-- ─── CLIENTS ─────────────────────────────────────────────────────────────────

DROP TRIGGER IF EXISTS trg_customer_info_ins //
CREATE TRIGGER trg_customer_info_ins AFTER INSERT ON customer_info FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('customer_info',NEW.customer_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_customer_info_upd //
CREATE TRIGGER trg_customer_info_upd AFTER UPDATE ON customer_info FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('customer_info',NEW.customer_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_customer_info_del //
CREATE TRIGGER trg_customer_info_del AFTER DELETE ON customer_info FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('customer_info',OLD.customer_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_customer_type_ins //
CREATE TRIGGER trg_customer_type_ins AFTER INSERT ON customer_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('customer_type',NEW.customer_type_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_customer_type_upd //
CREATE TRIGGER trg_customer_type_upd AFTER UPDATE ON customer_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('customer_type',NEW.customer_type_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_customer_type_del //
CREATE TRIGGER trg_customer_type_del AFTER DELETE ON customer_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('customer_type',OLD.customer_type_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_billingaddress_ins //
CREATE TRIGGER trg_tbl_billingaddress_ins AFTER INSERT ON tbl_billingaddress FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_billingaddress',NEW.billaddressid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_billingaddress_upd //
CREATE TRIGGER trg_tbl_billingaddress_upd AFTER UPDATE ON tbl_billingaddress FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_billingaddress',NEW.billaddressid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_billingaddress_del //
CREATE TRIGGER trg_tbl_billingaddress_del AFTER DELETE ON tbl_billingaddress FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_billingaddress',OLD.billaddressid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_delivaryaddress_ins //
CREATE TRIGGER trg_tbl_delivaryaddress_ins AFTER INSERT ON tbl_delivaryaddress FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_delivaryaddress',NEW.delivaryid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_delivaryaddress_upd //
CREATE TRIGGER trg_tbl_delivaryaddress_upd AFTER UPDATE ON tbl_delivaryaddress FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_delivaryaddress',NEW.delivaryid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_delivaryaddress_del //
CREATE TRIGGER trg_tbl_delivaryaddress_del AFTER DELETE ON tbl_delivaryaddress FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_delivaryaddress',OLD.delivaryid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_shippingaddress_ins //
CREATE TRIGGER trg_tbl_shippingaddress_ins AFTER INSERT ON tbl_shippingaddress FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_shippingaddress',NEW.shipaddressid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_shippingaddress_upd //
CREATE TRIGGER trg_tbl_shippingaddress_upd AFTER UPDATE ON tbl_shippingaddress FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_shippingaddress',NEW.shipaddressid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_shippingaddress_del //
CREATE TRIGGER trg_tbl_shippingaddress_del AFTER DELETE ON tbl_shippingaddress FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_shippingaddress',OLD.shipaddressid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_membership_ins //
CREATE TRIGGER trg_membership_ins AFTER INSERT ON membership FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('membership',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_membership_upd //
CREATE TRIGGER trg_membership_upd AFTER UPDATE ON membership FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('membership',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_membership_del //
CREATE TRIGGER trg_membership_del AFTER DELETE ON membership FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('membership',OLD.id,'delete','pending',NOW()); END//

-- ─── OPÉRATIONS ──────────────────────────────────────────────────────────────

DROP TRIGGER IF EXISTS trg_tbl_kitchen_ins //
CREATE TRIGGER trg_tbl_kitchen_ins AFTER INSERT ON tbl_kitchen FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_kitchen',NEW.kitchenid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_kitchen_upd //
CREATE TRIGGER trg_tbl_kitchen_upd AFTER UPDATE ON tbl_kitchen FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_kitchen',NEW.kitchenid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_kitchen_del //
CREATE TRIGGER trg_tbl_kitchen_del AFTER DELETE ON tbl_kitchen FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_kitchen',OLD.kitchenid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_tablefloor_ins //
CREATE TRIGGER trg_tbl_tablefloor_ins AFTER INSERT ON tbl_tablefloor FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_tablefloor',NEW.tbfloorid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_tablefloor_upd //
CREATE TRIGGER trg_tbl_tablefloor_upd AFTER UPDATE ON tbl_tablefloor FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_tablefloor',NEW.tbfloorid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_tablefloor_del //
CREATE TRIGGER trg_tbl_tablefloor_del AFTER DELETE ON tbl_tablefloor FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_tablefloor',OLD.tbfloorid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_rest_table_ins //
CREATE TRIGGER trg_rest_table_ins AFTER INSERT ON rest_table FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('rest_table',NEW.tableid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_rest_table_upd //
CREATE TRIGGER trg_rest_table_upd AFTER UPDATE ON rest_table FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('rest_table',NEW.tableid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_rest_table_del //
CREATE TRIGGER trg_rest_table_del AFTER DELETE ON rest_table FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('rest_table',OLD.tableid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tablelist_ins //
CREATE TRIGGER trg_tablelist_ins AFTER INSERT ON tablelist FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tablelist',NEW.tableid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tablelist_upd //
CREATE TRIGGER trg_tablelist_upd AFTER UPDATE ON tablelist FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tablelist',NEW.tableid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tablelist_del //
CREATE TRIGGER trg_tablelist_del AFTER DELETE ON tablelist FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tablelist',OLD.tableid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_qr_tables_ins //
CREATE TRIGGER trg_qr_tables_ins AFTER INSERT ON qr_tables FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('qr_tables',NEW.table_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_qr_tables_upd //
CREATE TRIGGER trg_qr_tables_upd AFTER UPDATE ON qr_tables FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('qr_tables',NEW.table_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_qr_tables_del //
CREATE TRIGGER trg_qr_tables_del AFTER DELETE ON qr_tables FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('qr_tables',OLD.table_id,'delete','pending',NOW()); END//

DELIMITER ;

-- ─── SYNCHRONISATION INITIALE ────────────────────────────────────────────────
-- Injecter toutes les données existantes dans sync_queue
-- (backfill) pour que le VPS reçoive un miroir complet au premier push.

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'item_category', CategoryID, 'insert', 'pending', NOW() FROM item_category;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'item_foods', ProductsID, 'insert', 'pending', NOW() FROM item_foods;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'variant', variantid, 'insert', 'pending', NOW() FROM variant;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'foodvariable', availableID, 'insert', 'pending', NOW() FROM foodvariable;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'add_ons', add_on_id, 'insert', 'pending', NOW() FROM add_ons;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'menu_add_on', row_id, 'insert', 'pending', NOW() FROM menu_add_on;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'check_addones', id, 'insert', 'pending', NOW() FROM check_addones;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'tbl_menutype', menutypeid, 'insert', 'pending', NOW() FROM tbl_menutype;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'tbl_groupitems', groupid, 'insert', 'pending', NOW() FROM tbl_groupitems;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'setting', id, 'insert', 'pending', NOW() FROM setting;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'common_setting', id, 'insert', 'pending', NOW() FROM common_setting;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'currency', currencyid, 'insert', 'pending', NOW() FROM currency;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'language', id, 'insert', 'pending', NOW() FROM language;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'themes', themeid, 'insert', 'pending', NOW() FROM themes;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'top_menu', menuid, 'insert', 'pending', NOW() FROM top_menu;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'tax_settings', id, 'insert', 'pending', NOW() FROM tax_settings;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'payment_method', payment_method_id, 'insert', 'pending', NOW() FROM payment_method;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'paymentmethod', payment_method_id, 'insert', 'pending', NOW() FROM paymentmethod;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'paymentsetup', setupid, 'insert', 'pending', NOW() FROM paymentsetup;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'shipping_method', ship_id, 'insert', 'pending', NOW() FROM shipping_method;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'tbl_delivaritime', dtimeid, 'insert', 'pending', NOW() FROM tbl_delivaritime;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'tbl_country', countryid, 'insert', 'pending', NOW() FROM tbl_country;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'tbl_state', stateid, 'insert', 'pending', NOW() FROM tbl_state;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'tbl_city', cityid, 'insert', 'pending', NOW() FROM tbl_city;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'customer_info', customer_id, 'insert', 'pending', NOW() FROM customer_info;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'customer_type', customer_type_id, 'insert', 'pending', NOW() FROM customer_type;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'tbl_billingaddress', billaddressid, 'insert', 'pending', NOW() FROM tbl_billingaddress;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'tbl_delivaryaddress', delivaryid, 'insert', 'pending', NOW() FROM tbl_delivaryaddress;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'tbl_shippingaddress', shipaddressid, 'insert', 'pending', NOW() FROM tbl_shippingaddress;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'membership', id, 'insert', 'pending', NOW() FROM membership;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'tbl_kitchen', kitchenid, 'insert', 'pending', NOW() FROM tbl_kitchen;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'tbl_tablefloor', tbfloorid, 'insert', 'pending', NOW() FROM tbl_tablefloor;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'rest_table', tableid, 'insert', 'pending', NOW() FROM rest_table;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'tablelist', tableid, 'insert', 'pending', NOW() FROM tablelist;

INSERT INTO sync_queue (entity_type, entity_id, operation, status, created_at)
SELECT 'qr_tables', table_id, 'insert', 'pending', NOW() FROM qr_tables;

SELECT CONCAT('Backfill terminé — ', COUNT(*), ' entrées en queue') AS result FROM sync_queue WHERE status = 'pending';
