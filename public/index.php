<?php

session_start();

require_once __DIR__ . '/../includes/app.php';

use Controllers\ApiCategorias;
use Controllers\ApiProductosMenu;
use Controllers\PanelAdministrativoController;
use MVC\Router;


$router = new Router();

//Login

$router->get('/', [PanelAdministrativoController::class, 'index']);
$router->post('/', [PanelAdministrativoController::class, 'index']);

$router->get('/api/obtener_productos', [ApiProductosMenu::class, 'obtener_productos']);
$router->post('/api/obtener_productos', [ApiProductosMenu::class, 'obtener_productos']);

$router->get('/api/guardar_producto', [ApiProductosMenu::class, 'guardar_producto']);
$router->post('/api/guardar_producto', [ApiProductosMenu::class, 'guardar_producto']);

$router->get('/api/obtener_categorias', [ApiCategorias::class, 'obtener_categorias']);
$router->post('/api/obtener_categorias', [ApiCategorias::class, 'obtener_categorias']);

$router->get('/api/eliminar_producto', [ApiProductosMenu::class, 'eliminar_producto']);
$router->post('/api/eliminar_producto', [ApiProductosMenu::class, 'eliminar_producto']);


$router->comprobarRutas();