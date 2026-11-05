<?php

session_start();

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use Controllers\PanelAdministrativoController;
use Controllers\ProductosController;
use MVC\Router;


$router = new Router();

//Login
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

// $router->get('/', [PanelAdministrativoController::class, 'index']);
// $router->post('/', [PanelAdministrativoController::class, 'index']);

$router->get('/productos', [ProductosController::class, 'index']);
$router->get('/productos/crear', [ProductosController::class, 'crear']);
$router->post('/productos/crear', [ProductosController::class, 'crear']);
$router->get('/productos/actualizar', [ProductosController::class, 'actualizar']);
$router->post('/productos/actualizar', [ProductosController::class, 'actualizar']);
$router->post('/productos/eliminar', [ProductosController::class, 'eliminar']);


$router->comprobarRutas();