<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route["default_controller"] = "hungry";
$route['login']  = "dashboard/auth/index";
$route['logout'] = "dashboard/auth/logout";
$route['home'] = "hungry";
$route['menu'] = "hungry/menu";
$route['menu/(:any)'] = "hungry/menu/$1";
$route['searchitem'] = "hungry/searchitem";
$route['details/(:any)/(:any)'] = "hungry/details/$1/$2";
$route['reservation'] = "hungry/reservation";
$route['cart'] = "hungry/cart";
$route['checkcoupon'] = "hungry/checkcoupon";
$route['checkout'] = "hungry/checkout";
$route['payments/(:any)'] = "hungry/payments/$1";
$route['payment-process'] = "hungry/payments_process";
$route['mylogin'] = "hungry/login";
$route['signup'] = "hungry/signup";
$route['orderdelevered/(:any)'] = "hungry/orderdelevered/$1";
$route['about'] = "hungry/about";
$route['contact'] = "hungry/contact";
$route['privacy'] = "hungry/privacy";
$route['terms'] = "hungry/terms";
$route['gallery'] = "hungry/gallery";
$route['team'] = "hungry/team";
$route['myprofile'] = "hungry/myprofile";
$route['myorderlist'] = "hungry/myorderlist";
$route['vieworder/(:any)'] = "hungry/vieworder/$1";
$route['myoreservationlist'] = "hungry/myoreservationlist";
$route['app-terms'] = "hungry/termsqr";
$route['app-refund-policty'] = "hungry/refundpolicyqr";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['accounts/get_supplier_code'] = 'accounts/get_supplier_code';

// New Design
$route['online-order'] = "hungry/onlineorder";
$route['online-order/(:any)'] = "hungry/onlineorder/$1";

//Qr Route
$route['scanmenu/(:any)'] = "hungry/scanmenu/$1";
$route['qr-menu'] = "hungry/qrmenu";
$route['addtocartqr'] = "hungry/addtocartqr";
$route['qr-app-cart'] = "hungry/appcart";
$route['app-details/(:any)/(:any)'] = "hungry/appdetails/$1/$2";
$route['app-details-update/(:any)/(:any)/(:any)'] = "hungry/appdetailsedit/$1/$2/$3";
$route['paymentsqr/(:any)/(:any)/(:any)'] = "hungry/paymentsqr/$1/$2/$3";
$route['payment-processqr'] = "hungry/payments_processqr";
$route['apporedrlist'] = "hungry/apporedrlist";
$route['order-tracking/(:num)'] = "hungry/ordertracking/$1";
$route['order-status-api/(:num)'] = "hungry/orderstatusapi/$1";
$route['call-waiter'] = "hungry/callwaiter";
$route['request-bill'] = "hungry/requestbill";
$route['updatemyorder/(:any)'] = "hungry/updatemyorder/$1";
$route['update-summery/(:any)'] = "hungry/update_summery/$1";

// Route publique QR
$route['qrorder/(:num)'] = 'qrapp/qrpublic/index/$1';
$route['qrorder/submit'] = 'qrapp/qrpublic/submit_order';
//$route['qr-menu'] = 'qrapp/qrorder/index';
//$route['qrapp/Qrtable/update_payment_status'] = 'qrapp/Qrtable/update_payment_status';

//for the sound of reservation notification
$route['reservation/getSound'] = 'reservation/getSound';

// Optional: AJAX endpoint to load employees
$route['employee/get_all'] = 'employee/employeeback/get_all';



// License management routes
$route['dashboard/license']                   = 'dashboard/license/index';
$route['dashboard/license/activate']['POST']  = 'dashboard/license/activate';
$route['dashboard/license/refresh']           = 'dashboard/license/refresh';
$route['dashboard/license/expired']           = 'dashboard/license/expired';

// ── SaaS API Routes ───────────────────────────────────────────────────────────
// Auth
$route['saas/auth/login']['POST']           = 'saas/auth/login';
$route['saas/auth/me']['GET']               = 'saas/auth/me';
$route['saas/auth/change-password']['POST'] = 'saas/auth/change_password';
$route['saas/auth/profile']['PUT']          = 'saas/auth/update_profile';

// Dashboard
$route['saas/dashboard/stats']['GET']           = 'saas/dashboard/stats';
$route['saas/dashboard/recent-orders']['GET']   = 'saas/dashboard/recent_orders';
$route['saas/dashboard/clients-stats']['GET']   = 'saas/dashboard/clients_stats';
$route['saas/dashboard/clients-revenue']['GET'] = 'saas/dashboard/clients_revenue';

// Clients
$route['saas/clients']['GET']                          = 'saas/clients/index';
$route['saas/clients']['POST']                         = 'saas/clients/create';
$route['saas/clients/(:num)']['GET']                   = 'saas/clients/show/$1';
$route['saas/clients/(:num)']['PUT']                   = 'saas/clients/update/$1';
$route['saas/clients/(:num)/live']['GET']              = 'saas/clients/live/$1';
$route['saas/clients/(:num)/subscription']['PUT']      = 'saas/clients/subscription/$1';
$route['saas/clients/export']['GET']                   = 'saas/clients/export';
$route['saas/clients/(:num)/suspend']['POST']          = 'saas/clients/suspend/$1';
$route['saas/clients/(:num)/reactivate']['POST']       = 'saas/clients/reactivate/$1';
$route['saas/clients/(:num)/logo']['POST']             = 'saas/clients/upload_logo/$1';
$route['saas/clients/(:num)/logo']['DELETE']           = 'saas/clients/delete_logo/$1';

// Plans
$route['saas/plans']['GET']              = 'saas/plans/index';
$route['saas/plans']['POST']             = 'saas/plans/create';
$route['saas/plans/(:num)']['PUT']       = 'saas/plans/update/$1';
$route['saas/plans/(:num)']['DELETE']    = 'saas/plans/delete/$1';

// Licenses
$route['saas/licenses']['GET']                    = 'saas/licenses/index';
$route['saas/licenses/generate']['POST']          = 'saas/licenses/generate';
$route['saas/licenses/activate']['POST']          = 'saas/licenses/activate';
$route['saas/licenses/check']['GET']              = 'saas/licenses/check';
$route['saas/licenses/updates-info']['GET']       = 'saas/licenses/updates_info';
$route['saas/licenses/refresh']['GET']            = 'saas/licenses/refresh';
$route['saas/licenses/(:num)/revoke']['POST']     = 'saas/licenses/revoke/$1';

// Updates
$route['saas/updates']['GET']                        = 'saas/updates/index';
$route['saas/updates']['POST']                       = 'saas/updates/create';
$route['saas/updates/applied']['POST']               = 'saas/updates/applied';
$route['saas/updates/(:num)']['GET']                 = 'saas/updates/show/$1';
$route['saas/updates/(:num)/publish']['POST']        = 'saas/updates/publish/$1';
$route['saas/updates/(:num)/archive']['POST']        = 'saas/updates/archive_update/$1';

// Payments
$route['saas/payments']['GET']   = 'saas/payments/index';
$route['saas/payments']['POST']  = 'saas/payments/create';

// Activity
$route['saas/activity']['GET']                  = 'saas/activity/index';
$route['saas/activity/export']['GET']           = 'saas/activity/export';
$route['saas/activity/tenant/(:num)']['GET']    = 'saas/activity/tenant/$1';
$route['saas/activity/report']['POST']          = 'saas/activity/report';

// Notifications
$route['saas/notifications']['GET'] = 'saas/notifications/index';

// Invoices
$route['saas/invoices/export']['GET']                = 'saas/invoices/export';
$route['saas/invoices']['GET']                       = 'saas/invoices/index';
$route['saas/invoices']['POST']                      = 'saas/invoices/create';
$route['saas/invoices/(:num)']['GET']                = 'saas/invoices/show/$1';
$route['saas/invoices/(:num)/pdf']['GET']            = 'saas/invoices/pdf/$1';
$route['saas/invoices/(:num)/send']['POST']          = 'saas/invoices/send/$1';
$route['saas/invoices/(:num)/confirm']['POST']       = 'saas/invoices/confirm/$1';
$route['saas/invoices/(:num)/cancel']['POST']        = 'saas/invoices/cancel/$1';

// Team
$route['saas/team']['GET']              = 'saas/team/index';
$route['saas/team']['POST']             = 'saas/team/create';
$route['saas/team/(:num)']['PUT']       = 'saas/team/update/$1';
$route['saas/team/(:num)']['DELETE']    = 'saas/team/remove/$1';

// Roles
$route['saas/roles']['GET']             = 'saas/roles/index';
$route['saas/roles']['POST']            = 'saas/roles/create';
$route['saas/roles/(:num)']['PUT']      = 'saas/roles/update/$1';
$route['saas/roles/(:num)']['DELETE']   = 'saas/roles/remove/$1';

// Settings
$route['saas/settings']['GET']              = 'saas/settings/index';
$route['saas/settings']['POST']             = 'saas/settings/save';
$route['saas/settings/test-smtp']['POST']   = 'saas/settings/test_smtp';

// Cron (protected by secret key)
$route['saas/cron/run']['GET'] = 'saas/cron/run';

// Bank list module routes
$route['setting/bank_list'] = 'setting/bank_list/index';
$route['setting/bank_list/index'] = 'setting/bank_list/index';
$route['setting/bank_list/create'] = 'setting/bank_list/create';
$route['setting/bank_list/updateintfrm/(:num)'] = 'setting/bank_list/updateintfrm/$1';
$route['setting/bank_list/delete/(:num)'] = 'setting/bank_list/delete/$1';
$route['setting/bank_list/bank_transaction'] = 'setting/bank_list/bank_transaction';
$route['setting/bank_list/bank_debit_credit_manage_add'] = 'setting/bank_list/bank_debit_credit_manage_add';
$route['setting/bank_list/bank_ledger/(:num)'] = 'setting/bank_list/bank_ledger/$1';

//set modules/config/routes.php
$modules_path = APPPATH.'modules/';     
$modules = scandir($modules_path);

foreach($modules as $module)
{
    if (is_dir($module)) {
        if($module === '.' || $module === '..') continue;
        if(is_dir($modules_path) . '/' . $module)
        {
            $routes_path = $modules_path . $module . '/config/route.php';
            if(file_exists($routes_path))
            {
                if (file_exists(APPPATH.'modules/'.$module.'/assets/data/env')){
                require($routes_path);
                }
            }
            else
            {
                continue;
            }
        }
    }
}

