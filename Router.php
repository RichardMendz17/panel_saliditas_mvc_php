<?php



namespace MVC;

class Router

{

    public array $getRoutes = [];

    public array $postRoutes = [];

    private array $publicRoutes = [

        'GET' => [

        '/', 

        '/productos',

        ],



        'POST' => [

        '/', 
        
        '/productos',
        ]

    ];



    // private array $protectedFreeRoutes = [

    //     '/cambiar-rol',

    //     '/seleccionar-rol'

    // ];



    private array $protectedRolesRoutes = [

        //-> Admin

        'Admin' => [

        ],

        //->Mesero

        'Waiter' => [

        ],

        //->Repartidor

        'Deliverer' =>[

        ],

        //->Cliente

        'Cliente' =>[

        ],

        //->Chef 

        'Chef' => [

        ]

 

    ];

    

    public function get($url, $fn)

    {

        $this->getRoutes[$url] = $fn;

    }



    public function post($url, $fn)

    {

        $this->postRoutes[$url] = $fn;

    }



    public function comprobarRutas()

    {

        $auth = $_SESSION['login'] ?? false;



        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?') ?: '/';

        $method = $_SERVER['REQUEST_METHOD'];



        $fn = $method === 'GET' ? ($this->getRoutes[$currentUrl] ?? null) : ($this->postRoutes[$currentUrl] ?? null);

        

        $this->checkAccess($currentUrl, $auth, $method);        

        if ( $fn ) {

            // Call user fn va a llamar una función cuando no sabemos cual sera

            call_user_func($fn, $this); // This es para pasar argumentos

        } else {

            echo "Página No Encontrada o Ruta no válida";

        }

    }



    private function checkAccess(string $currentUrl, bool $auth, string $method): void

    {

        if ($auth && $currentUrl === '/' )

        {

        // Si ya inicio sesión y trata regresar a la ruta de iniciar sesion lo redirecciona

        header('Location: /perfil');

        exit();

        }



        // Revisamos si la ruta actual esta en las rutas publicas

        if (in_array($currentUrl, $this->publicRoutes[$method] ?? [])) 

        {

            return;

        }



        if (!$auth)

        {

            // Si no ha iniciado sesión y trata de entrar a una ruta protegida

            header('Location: /');

            exit();

        }

    

        // Verificar que la ruta esté en las rutas libres para usuarios autenticados para el tipo de usuario 2

        // $tipo_usuario = $_SESSION['tipo_usuario'];

        // if ($tipo_usuario === 2) 

        // {

        //     if (in_array($currentUrl, $this->protectedFreeRoutes))

        //     {

        //         return;                  

        //     } 

        // }



        // Si no es admin capturamos el valor de la variable rol

        $rol = $_SESSION['rol'] ?? null;

        // En este punto el usuario ya se autentico y debieron declararse las variables de sesion

        // Si no tiene ningun rol por defecto vamos verificar que tenga algun rol asignado

        // if ($rol === null && $_SESSION['login'] === true)

        // {

        //     // Si es la primera vez que inicio sesion la siguiente variable debe estar en false

        //     if ($_SESSION['cambiando_rol'] === false)

        //     {

        //         //routesAllowedWithoutRole

        //         $routesAllowedWithoutRole = [        

        //             '/verificar-tipo-usuario', '/verificar-rol', '/seleccionar-rol', '/cambiar-rol'

        //         ];

        //         // Filtramos por el tipo de usuario para

        //         $tipo_usuario = $_SESSION['tipo_usuario'];

        //         switch ($tipo_usuario)

        //         {    // Tipo de usuario 1 para alumno

        //             case 1:

        //                 if (!in_array($currentUrl, $routesAllowedWithoutRole))

        //                 {

        //                     header('location: /verificar-tipo-usuario');

        //                     exit;

        //                 }

        //             break;

        //             // Tipo de usuario 2 para personal en general

        //             case 2:

        //                 if (!in_array($currentUrl, $routesAllowedWithoutRole))

        //                 {

        //                     header('location: /verificar-tipo-usuario');

        //                     exit;

        //                 }                 

        //             break;



        //             default:



        //             break;

        //         }

        //     }

        // }



        // isset() verifica que la variable exista y no sea null devuelve true.

        // !isset() niega eso: verifica que no exista.

        if (isset($_SESSION['rol'])  && $_SESSION['login'] === true ) 

        {

            // Mapeamos el número de rol a string

            $mapaRoles = [

                1 => 'Admin',

                2 => 'Waiter ',

                3 => 'Deliverer',

                4 => 'Client',

                5 => 'Chef     ',

            ];

            $rolNombre = $mapaRoles[$rol] ?? null;

            if (!$rolNombre || !in_array($currentUrl, $this->protectedRolesRoutes[$rolNombre] ?? []))

            {

                // No tiene permiso

                header('Location: /no-autorizado');

                exit();

            }

        }

    }



    public function render($view, $datos = [])

    {

        // Leer lo que le pasamos  a la vista

        foreach ($datos as $key => $value)

        {

            $$key = $value;  // Doble signo de dolar significa: variable variable, básicamente nuestra variable sigue siendo la original, pero al asignarla a otra no la reescribe, mantiene su valor, de esta forma el nombre de la variable se asigna dinamicamente

        }



        ob_start(); // Almacenamiento en memoria durante un momento...

        // entonces incluimos la vista en el layout

        include_once __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean(); // Limpia el Buffer

        include_once __DIR__ . '/views/layout.php';

    }

}

