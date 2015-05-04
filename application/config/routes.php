<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "purchases";
$route['404_override'] = '';

$route['products/show/(:any)'] = "purchases/get_product_by_id/$1";
$route['checkout'] = "purchases/view_cart";
//end of routes.php