<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Routing Menu for Admin
$route['data-admin'] = 'User/index/Admin';
$route['data-admin/list'] = 'User/ajax_list/Admin';
$route['data-admin/insert'] = 'User/insert/Admin';
$route['data-admin/edit/(:num)'] = 'User/edit/$1/Admin';
$route['data-admin/update'] = 'User/update/Admin';
$route['data-admin/delete'] = 'User/delete';
$route['data-admin/reset'] = 'User/reset';

//Routing Menu for Perawat
$route['data-perawat'] = 'User/index/Perawat';
$route['data-perawat/list'] = 'User/ajax_list/Perawat';
$route['data-perawat/insert'] = 'User/insert/Perawat';
$route['data-perawat/edit/(:num)'] = 'User/edit/$1/Perawat';
$route['data-perawat/update'] = 'User/update/Perawat';
$route['data-perawat/delete'] = 'User/delete';
$route['data-perawat/reset'] = 'User/reset';

//Routing Menu for Orang Tua
$route['data-orang-tua'] = 'User/index/Orang Tua';
$route['data-orang-tua/list'] = 'User/ajax_list/Orang Tua';
$route['data-orang-tua/insert'] = 'User/insert/Orang Tua';
$route['data-orang-tua/edit/(:num)'] = 'User/edit/$1/Orang Tua';
$route['data-orang-tua/update'] = 'User/update/Orang Tua';
$route['data-orang-tua/delete'] = 'User/delete';
$route['data-orang-tua/reset'] = 'User/reset';
$route['home'] = 'dashboard/index_orangtua';

//Routing Menu for Bayi
$route['data-bayi'] = 'Bayi/index/Perawat';
$route['data-bayi/list'] = 'Bayi/ajax_list';
$route['data-bayi/insert'] = 'Bayi/insert';
$route['data-bayi/edit/(:any)'] = 'Bayi/edit/$1';
$route['data-bayi/update'] = 'Bayi/update';
$route['data-bayi/delete'] = 'Bayi/delete';

//Routing Menu for Perkembangan Bayi
$route['perkembangan-bayi'] = 'Perkembanganbayi/index';
$route['perkembangan-bayi/list'] = 'Perkembanganbayi/ajax_list';
$route['perkembangan-bayi/insert'] = 'Perkembanganbayi/insert';
$route['perkembangan-bayi/delete'] = 'Perkembanganbayi/delete';
$route['perkembangan-bayi/edit/(:any)'] = 'Perkembanganbayi/edit/$1';
$route['perkembangan-bayi/detail/(:any)'] = 'Perkembanganbayi/detail/$1';
$route['perkembangan-bayi/update'] = 'Perkembanganbayi/update';












