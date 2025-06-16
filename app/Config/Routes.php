<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Landing::index');


$routes->get('/home', 'Home::index');
$routes->post('/delete', 'Home::delete');
$routes->post('home/update_profile', 'Home::update_profile');
$routes->post('home/update_data', 'Home::update_data');

$routes->get('/paket', 'Paket::index');
$routes->post('/paket/add', 'Paket::add');
$routes->post('/paket/update', 'Paket::update');

$routes->get('/pelanggan', 'Pelanggan::index');
$routes->post('/pelanggan/add', 'Pelanggan::add');
$routes->post('/pelanggan/update', 'Pelanggan::update');
$routes->post('/pelanggan/tagihan', 'Pelanggan::tagihan');
$routes->post('/pelanggan/lunas', 'Pelanggan::lunas');

$routes->get('/tagihan', 'Tagihan::index');
$routes->get('/laporan/(:any)/(:num)', 'Laporan::index/$1/$2');
