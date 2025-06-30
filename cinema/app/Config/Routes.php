<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->match(['GET', 'POST'], '/register', 'UtenteController::register');
$routes->match(['GET', 'POST'], 'login', 'UtenteController::login');
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('logout', 'UtenteController::logout');
$routes->group('admin', ['filter' => 'auth:gestore'], static function ($routes) {
    $routes->get('films', 'Admin\FilmController::index');
    $routes->get('films/new', 'Admin\FilmController::new');   
    $routes->post('films/create', 'Admin\FilmController::create');
    $routes->get('films/edit/(:num)', 'Admin\FilmController::edit/$1');
    $routes->post('films/update/(:num)', 'Admin\FilmController::update/$1');
    $routes->post('films/delete/(:num)', 'Admin\FilmController::delete/$1');

    $routes->get('spettacoli', 'Admin\SpettacoloController::index');
    $routes->get('spettacoli/new', 'Admin\SpettacoloController::new');
    $routes->post('spettacoli/create', 'Admin\SpettacoloController::create');
    $routes->get('spettacoli/edit/(:num)', 'Admin\SpettacoloController::edit/$1');
    $routes->post('spettacoli/update/(:num)', 'Admin\SpettacoloController::update/$1');
    $routes->post('spettacoli/delete/(:num)', 'Admin\SpettacoloController::delete/$1');
});