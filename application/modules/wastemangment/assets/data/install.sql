INSERT INTO `language` (`id`, `phrase`, `english`, `french`) VALUES
(NULL, 'waste_tracking',       'Waste Tracking',           'Suivi des déchets'),
(NULL, 'packaging_food',       'Packaging Food',           'Emballage alimentaire'),
(NULL, 'purchase_food_waste',  'Purchase Food Waste',      'Achat de déchets alimentaires'),
(NULL, 'makeing_food_waste',   'Makeing Food Waste',       'Gestion des déchets alimentaires'),
(NULL, 'order_id',             'Order Id',                 'Numéro de commande'),
(NULL, 'used_items',           'Used items',               'Articles utilisés'),
(NULL, 'qnty',                 'Qnty',                     'Qté'),
(NULL, 'lost_price',           'Lost price',               'Prix de perte'),
(NULL, 'please_give_order_id', 'Please give order id',     'Veuillez saisir le numéro de commande'),
(NULL, 'ingredients_lost',     'Ingredients Lost',         'Ingrédients perdus'),
(NULL, 'present',              'Present',                  'Présent'),
(NULL, 'food_lost',            'Food lost',                'Nourriture perdue');

INSERT INTO sec_menu_item (menu_title, page_url, module, parent_menu, is_report, createby, createdate) VALUES ('waste_tracking', 'wastetracking', 'wastemangment', '0', '0', '3', '2020-12-03 00:00:00');
INSERT INTO sec_menu_item (menu_title, page_url, module, parent_menu, is_report, createby, createdate) SELECT 'packaging_food', 'addpackagingfood', 'wastemangment', sec_menu_item.menu_id, '0', '3', '2020-12-03 00:00:00' FROM sec_menu_item WHERE sec_menu_item.menu_title = 'waste_tracking';
INSERT INTO sec_menu_item (menu_title, page_url, module, parent_menu, is_report, createby, createdate) SELECT 'purchase_food_waste', 'addpurchasfoodwaste', 'wastemangment', sec_menu_item.menu_id, '0', '3', '2020-12-03 00:00:00' FROM sec_menu_item WHERE sec_menu_item.menu_title = 'waste_tracking';
INSERT INTO sec_menu_item (menu_title, page_url, module, parent_menu, is_report, createby, createdate) SELECT 'makeing_food_waste', 'makeingfoodwaste', 'wastemangment', sec_menu_item.menu_id, '0', '3', '2020-12-03 00:00:00' FROM sec_menu_item WHERE sec_menu_item.menu_title = 'waste_tracking';
