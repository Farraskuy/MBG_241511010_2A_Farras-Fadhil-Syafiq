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

    // $routes->group('/users', ['filter' => 'auth:admin'], function () use ($routes) {
    //     $routes->get("/", "UserController::index");
    //     $routes->get("add", "UserController::create");
    //     $routes->post("add", "UserController::store");
    //     $routes->get("detail/(:num)", "UserController::detail/$1");
    //     $routes->get("update-password/(:num)", "UserController::editPassword/$1");
    //     $routes->put("update-password/(:num)", "UserController::updatePassword/$1");
    //     $routes->get("update/(:num)", "UserController::edit/$1");
    //     $routes->put("update/(:num)", "UserController::update/$1");
    //     $routes->delete("delete/(:num)", "UserController::destroy/$1");
    // });

    $routes->group('/bahan-baku', ['filter' => 'auth:gudang'], function () use ($routes) {
        $routes->get("/", "BahanBakuController::index");
        $routes->get("create", "BahanBakuController::create");
        $routes->post("create", "BahanBakuController::store");
        $routes->get("detail/(:num)", "BahanBakuController::detail/$1");
        $routes->get("update/(:num)", "BahanBakuController::edit/$1");
        $routes->put("update/(:num)", "BahanBakuController::update/$1");
        $routes->delete("delete/(:num)", "BahanBakuController::destroy/$1");
    });

    $routes->group('/permintaan-bahan', function () use ($routes) {
        $routes->get("/", "PermintaanBahanController::index");
        $routes->get("detail/(:num)", "PermintaanBahanController::detail/$1");

        $routes->group('', ['filter' => 'auth:gudang'], function () use ($routes) {
            $routes->post("reject/(:num)", "PermintaanBahanController::reject/$1");
            $routes->post("approve/(:num)", "PermintaanBahanController::approve/$1");
        });

        $routes->group('', ['filter' => 'auth:dapur'], function () use ($routes) {
            $routes->get("create", "PermintaanBahanController::create");
            $routes->post("add-bahan/(:num)", "PermintaanBahanController::addBahan/$1");
            $routes->post("remove-bahan/(:num)", "PermintaanBahanController::removeBahan/$1");
            $routes->post("create", "PermintaanBahanController::store");
            $routes->delete("delete/(:num)", "PermintaanBahanController::destroy/$1");
        });
    });
});
