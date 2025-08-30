<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'FrontController::index');
$routes->get('/search', 'FrontController::index');

$routes->post('/otp/send', 'OtpController::send');
$routes->get('/otp/request', 'OtpController::request');
$routes->post('/otp/verify', 'OtpController::verify');
