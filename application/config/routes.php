<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Routing Menu for Admin
$route['data-admin'] = 'User/index/Admin';
$route['data-admin/list'] = 'User/ajax_list/Admin';
$route['data-admin/insert'] = 'User/insert/Admin';
$route['data-admin/edit/(:num)'] = 'User/edit/$1';
$route['data-admin/update'] = 'User/update';
$route['data-admin/delete'] = 'User/delete';
$route['data-admin/reset'] = 'User/reset';

//Routing Menu for Perawat
$route['data-perawat'] = 'User/index/Perawat';
$route['data-perawat/list'] = 'User/ajax_list/Perawat';
$route['data-perawat/insert'] = 'User/insert/Perawat';
$route['data-perawat/edit/(:num)'] = 'User/edit/$1';
$route['data-perawat/update'] = 'User/update';
$route['data-perawat/delete'] = 'User/delete';
$route['data-perawat/reset'] = 'User/reset';

//Routing Menu for Orang Tua
$route['data-orang-tua'] = 'User/index/Orang Tua';
$route['data-orang-tua/list'] = 'User/ajax_list/Orang Tua';
$route['data-orang-tua/insert'] = 'User/insert/Orang Tua';





