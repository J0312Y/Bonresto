<<<<<<< HEAD
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



// Admin License Route
$route['admin/license'] = 'admin/license';
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

=======
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



// Admin License Route
$route['admin/license'] = 'admin/license';
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

>>>>>>> 8ea723d6e3a12d8fd308bc3d0ba986ebac1b4bea
