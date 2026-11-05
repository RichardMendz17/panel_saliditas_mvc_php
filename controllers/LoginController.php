<?php 

namespace Controllers;

use Model\Rol;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarLogin();

            if(empty($alertas))
            {
                // Verificar que el usuario exista
                $usuario = new Usuario((array) Usuario::where('email', $usuario->email));
                if (!$usuario)
                {
                    Usuario::setAlerta('error', 'El usuario No existe');
                    $_SESSION['login'] = false; // Fuerza logout
                }
                if($usuario->estado_usuario !== 'Activo')
                {
                    Usuario::setAlerta('error', 'El usuario se encuentra desactivado');
                    $_SESSION['login'] = false; // Fuerza logout
                }
                else 
                {
                    // El usuario existe
                    if (password_verify($_POST['password'], $usuario->password)) 
                    {
                        //Iniciar la sesión
                        session_start();
                        $_SESSION['login'] = true;
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        // $_SESSION['cambiando_rol'] = false;
                        $_SESSION['nombre'] = $usuario->obtenerNombreReal();
                        // Posteriormente de capturar los datos previos
                        // Verificamos el tipo de usuario si es alumno o personal

                        $rol = new Rol;
                        $rol_del_usuario = $rol::find($usuario->rol);
                        // Asignamos valores a la variable global SESSION
                        $_SESSION['rol'] =  (int)$rol_del_usuario->id;
                        $_SESSION['nombre_rol'] = $rol_del_usuario->rol;
                        header('location: /verificar_rol');
                        exit;
                        // Identificamos el tipo de usuario
                    } 
                    else 
                    {
                        Usuario::setAlerta('error', '❌ Contraseña Incorrecta');
                        $_SESSION = []; 
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();

        //Asignamos la clase del body
        $class_body_page = "login-page";

        // Render a la vista
        $router->render('auth/login', [
            'titulo_pagina' => 'Login',
            'class_body_page' => $class_body_page,
            'alertas' => $alertas
        ]);
    }

    public static function logout()
    {
        $_SESSION = [];
        session_destroy();
        header('Location: /iniciar_sesion');
        exit;
    }

}