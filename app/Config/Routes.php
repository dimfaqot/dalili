<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Landing::index');
$routes->get('/print', 'Landing::print');


$routes->get('/home', 'Home::index');
$routes->post('/delete', 'Home::delete');
$routes->post('home/update_profile', 'Home::update_profile');
$routes->post('home/update_data', 'Home::update_data');
$routes->post('home/rangkuman', 'Home::rangkuman');

$routes->get('/paket', 'Paket::index');
$routes->post('/paket/add', 'Paket::add');
$routes->post('/paket/update', 'Paket::update');

$routes->get('/pelanggan', 'Pelanggan::index');
$routes->post('/pelanggan/add', 'Pelanggan::add');
$routes->post('/pelanggan/update', 'Pelanggan::update');
$routes->post('/pelanggan/tagihan', 'Pelanggan::tagihan');
$routes->post('/pelanggan/lunas', 'Pelanggan::lunas');
$routes->post('/pelanggan/alamat', 'Pelanggan::alamat');
$routes->post('/pelanggan/pelanggan_by_alamat', 'Pelanggan::pelanggan_by_alamat');

$routes->get('/tagihan', 'Tagihan::index');
$routes->get('/laporan/(:any)/(:num)', 'Laporan::index/$1/$2');
