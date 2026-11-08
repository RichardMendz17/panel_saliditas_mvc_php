<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Producto;
use MVC\Router;

class ProductosController
{

    public static function index(Router $router)
    {
        $alertas = [];
        isAuth();
        
        // Obtenemos la pagina actual
        $pagina_actual = $_GET['page'] ?? 1;
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        //Validamos que la pagina actual exista y que no sea menor a 1
        if (!$pagina_actual || $pagina_actual < 1)
        {
            header('Location: /productos?page=1');
        }

        // Indicamos cuantos registros queremos por pagina
        $registros_por_pagina = 8;
        // Traemos el total de registros
        $total = Producto::total();

        // En base al total de registros y a los registros que deseamos mostrar por pagina vamos a crear un objeto
        // de la clase Paginación que se encargara de realizar toda la logica necesaria

        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        $productos = Producto::paginar($registros_por_pagina, $paginacion->offset());

        $query = "SELECT alumnos.id, alumnos.nombre_Alumno, alumnos.apellido_Paterno, alumnos.apellido_Materno, alumnos.id_periodo_inicio, ";
        $query .= "alumnos.modalidad, alumnos.condicion_academica, alumnos.estado_academico, ";
        $query .= "alumnos.comentarios, alumnos.telefono, alumnos.correo_institucional, alumnos.genero, ";
        $query .= "carreras.nombre_Carrera, periodos.meses_Periodo, periodos.year ";
        $query .= "FROM alumnos ";
        $query .= "LEFT OUTER JOIN carreras ON alumnos.id_Carrera = carreras.id ";
        $query .= "LEFT OUTER JOIN periodos ON alumnos.id_periodo_inicio = periodos.id ";
        $query .= "ORDER BY alumnos.id DESC ";
        $query .= "LIMIT {$registros_por_pagina} OFFSET {$paginacion->offset()}";

        $productoDetalles = AlumnoDetalles::SQL($query);

        $alertas = Alumno::getAlertas(); 

        $sidebar_nav = 'Productos';

        $router->render('productos/index', [
            'titulo_pagina' => 'Panel Productos | CMS Restaurantes',
            'sidebar_nav' => $sidebar_nav,
            'productos' => $productos,
            'alertas' => $alertas

        ]);
    }

    public static function crear(Router $router) {
        $errores = Vendedor::getErrores();
        $vendedor = new Vendedor;

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