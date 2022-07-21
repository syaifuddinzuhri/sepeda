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
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
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
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['pengguna/all'] = "pengguna/getAll";
$route['penggunaCreate']['post'] = "pengguna/store";
$route['penggunaEdit/(:any)'] = "pengguna/edit/$1";
$route['penggunaUpdate/(:any)']['put'] = "pengguna/update/$1";
$route['penggunaDelete/(:any)']['delete'] = "pengguna/delete/$1";

$route['sepeda/all'] = "sepeda/getAll";
$route['sepedaCreate']['post'] = "sepeda/store";
$route['sepedaEdit/(:any)'] = "sepeda/edit/$1";
$route['sepedaUpdate/(:any)']['put'] = "sepeda/update/$1";
$route['sepedaDelete/(:any)']['delete'] = "sepeda/delete/$1";

$route['peminjaman/all'] = "peminjaman/getAll";
$route['peminjamanCreate']['post'] = "peminjaman/store";
$route['peminjamanEdit/(:any)'] = "peminjaman/edit/$1";
$route['peminjamanUpdate/(:any)']['put'] = "peminjaman/update/$1";
$route['peminjamanDelete/(:any)']['delete'] = "peminjaman/delete/$1";
