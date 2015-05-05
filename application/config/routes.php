<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "purchases";
$route['404_override'] = '';

$route['/admins/get_order_by_id/(:any)'] = "admins/get_order_by_id/$1";
$route['/admins/get_product_by_id/(:any)'] = "admins/get_product_by_id/$1";
$route['products/show/(:any)'] = "purchases/get_product_by_id/$1";
$route['checkout'] = "purchases/view_cart";

//end of routes.php