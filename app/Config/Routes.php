<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('politica-privacidade', 'Home::politica_privacidade');
$routes->get('set_redirect', 'Home::set_redirect');

$routes->group("auth", function ($routes) {
    $routes->match(['get', 'post'], 'login', 'Auth::login');
    $routes->match(['get', 'post'], 'register', 'Auth::register');
    $routes->get('logout', 'Auth::logout');
});

$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('', 'Admin::index');
    $routes->get('category', 'Admin::category');
    $routes->get('product', 'Admin::product');
    $routes->get('customs', 'Admin::customs');
});

$routes->group('config', ['filter' => 'admin'], function ($routes) {
    $routes->post('actions/save', 'Config::save',  ['filter' => 'admin']);
    $routes->get('actions/get', 'Config::get');
    $routes->post('actions/delete', 'Config::delete',  ['filter' => 'admin']);
});

$routes->group('category', function ($routes) {
    $routes->post('actions/save', 'Category::save', ['filter' => 'admin']);
    $routes->get('actions/get/(:num)', 'Category::get/$1');
    $routes->get('actions/all', 'Category::all');
    $routes->get('(:segment)', 'Category::category/$1');
    $routes->get('(:segment)/products/(:segment)', 'Category::product/$1/$2');
    $routes->get('actions/delete/(:num)', 'Category::delete/$1', ['filter' => 'admin']);
});

$routes->group('product', function ($routes) {
    $routes->post('actions/save', 'Product::save', ['filter' => 'admin']);
    $routes->get('actions/delete/(:num)', 'Product::delete/$1', ['filter' => 'admin']);
    $routes->get('actions/search/(:segment)', 'Product::search/$1');
    $routes->get('actions/all', 'Product::all');
    $routes->get('actions/get_last', 'Product::get_last');
});

$routes->group('stock',  ['filter' => 'admin'], function ($routes) {
    $routes->post('actions/save', 'ProductStock::save',  ['filter' => 'admin']);
    $routes->get('actions/get_by_product/(:num)', 'ProductStock::getByProduct/$1');
    $routes->get('actions/delete/(:num)', 'ProductStock::delete/$1', ['filter' => 'admin']);
    $routes->get('actions/all/(:num)', 'ProductStock::all/$1');
    $routes->get('actions/get_last', 'ProductStock::get_last');

});

$routes->group('cart', ['filter' => 'customer'], function ($routes) {
    $routes->get('/', 'Cart::index');
    $routes->post('actions/save', 'Cart::save');
    $routes->get('actions/get', 'Cart::get');
    $routes->post('actions/update_quantity', 'Cart::update_quantity');
    $routes->get('actions/delete/(:num)', 'Cart::delete/$1');
});
