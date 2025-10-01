<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->group('', ['filter' => 'auth:guest'], function () use ($routes) {
    $routes->get("/login", "AuthController::login");
    $routes->post("/login", "AuthController::Authlogin");
    // $routes->get("/register", "AuthController::register");
    // $routes->post("/register", "AuthController::AuthRegister");
});

$routes->group('', ['filter' => 'auth:login'], function () use ($routes) {
    $routes->post("/logout", "AuthController::logout");

    $routes->get('/', 'DashboardController::index');

    $routes->group('/users', ['filter' => 'auth:admin'], function () use ($routes) {
        $routes->get("/", "UserController::index");
        $routes->get("add", "UserController::create");
        $routes->post("add", "UserController::store");
        $routes->get("detail/(:num)", "UserController::detail/$1");
        $routes->get("update-password/(:num)", "UserController::editPassword/$1");
        $routes->put("update-password/(:num)", "UserController::updatePassword/$1");
        $routes->get("update/(:num)", "UserController::edit/$1");
        $routes->put("update/(:num)", "UserController::update/$1");
        $routes->delete("delete/(:num)", "UserController::destroy/$1");
    });
});
