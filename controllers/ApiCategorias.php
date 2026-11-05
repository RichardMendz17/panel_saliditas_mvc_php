<?php 

namespace Controllers;

use Model\Categoria;

class ApiCategorias
{
    public static function obtener_categorias()
    {      
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            //Aqui vamos a capturar los productos por menu y por usario

            //$id_usuario_activo = $_SESSION['id'];

            $categorias = Categoria::all();
            echo json_encode(['categorias' => $categorias]);
        }
    }
}

?>