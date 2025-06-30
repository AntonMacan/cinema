<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->match(['GET', 'POST'], '/register', 'UtenteController::register');
$routes->match(['GET', 'POST'], 'login', 'UtenteController::login');