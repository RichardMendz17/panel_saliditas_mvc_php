<?php

namespace Controllers;

use MVC\Router;
use Model\Categoria;

class CategoriasController
{

    public static function index(Router $router)
    {
        $categorias = Categoria::all();

        $alertas = [];

        // Muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null;

        $sidebar_nav = 'Categorias';

        $crear = '/categorias/crear';
        $buscar = '/categorias/buscar';

        $router->render('categorias/index', [
            'titulo_pagina' => 'Panel Categorias | CMS Restaurantes',
            'sidebar_nav' => $sidebar_nav,
            'categorias' => $categorias,
            'crear' => $crear,
            'buscar' => $buscar,
            'resultado' => $resultado,
            'alertas' => $alertas
        ]);
    }

    public static function crear(Router $router)
    {
        $errores = Categoria::getErrores();
        $vendedor = new Categoria();

        // Ejecutar el código después de que el usuario envia el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            /** Crea una nueva instancia */
            $vendedor = new Vendedor($_POST['vendedor']);

            // Validar
            $errores = $vendedor->validar();


            if(empty($errores)) {

                // Guarda en la base de datos
                $resultado = $vendedor->guardar();

                if($resultado) {
                    header('location: /vendedores');
                }
            }
        }

        $router->render('vendedores/crear', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }

    public static function actualizar(Router $router) {
        $id = validarORedireccionar('/admin');

        // Obtener los datos de la propiedad
        $vendedor = Vendedor::find($id);

        // Arreglo con mensajes de errores
        $errores = Vendedor::getErrores();

        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

                // Asignar los atributos
                $args = $_POST['vendedor'];
                $vendedor->sincronizar($args);

                // Validación
                $errores = $vendedor->validar();
                
                if(empty($errores)) {

                    // Guarda en la base de datos
                    $resultado = $vendedor->guardar();

                    if($resultado) {
                        header('location: /admin');
                    }
                }
        }

        $router->render('vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function eliminar(Router $router) {

    }
}