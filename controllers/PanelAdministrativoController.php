<?php 



namespace Controllers;



use MVC\Router;



class PanelAdministrativoController
{

    public static function index(Router $router)
    {

        $buscar = false;

        $crear = false;


        $alertas = [];

        $scripts_js = [

            'gestionar_productos_menu.js',
            'gestionar_categorias.js'

        ];

        //Asignamos la clase del body


        $router->render('panel_administrativo/index',
        [

            'titulo_pagina' => 'Panel Administrativo | CMS Restaurantes',

            'class_body_page' => '',

            'alertas' => $alertas,

            'sidebar_nav' => null,

            'buscar' => $buscar,

            'crear' => $crear,

            'scripts_js' => $scripts_js,

            // Navegacion

            //'total_cocina_pendientes' => $total_cocina_pendientes,
            

        ]);
    }
}

?>