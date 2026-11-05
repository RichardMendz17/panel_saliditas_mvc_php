<?php 

namespace Controllers;

use Model\BitacoraEventos;
use Model\Producto;

class ApiProductosMenu
{
    public static function obtener_productos()
    {      
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            //Aqui vamos a capturar los productos por menu y por usario

            //$id_usuario_activo = $_SESSION['id'];

            $productos = Producto::all();
            echo json_encode(['productos' => $productos]);
        }
    }

    public static function guardar_producto()
    {      
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            //Aqui vamos a capturar los productos por menu y por usario
            $id = $_POST['id'] ?? null;
            if (!campoVacio($id))
            {
                $id = filter_var($id, FILTER_VALIDATE_INT);
            }

            $nombre_producto = $_POST['nombre_producto'];
            $imagen_producto = $_POST['imagen_producto'] ?? '';
            $precio_producto = $_POST['precio_producto'];
            $estado_producto = $_POST['estado_producto'];
            $categoria_producto = $_POST['categoria_producto'] ?? '';
        
            //$id_usuario_activo = $_SESSION['id'];
            //Generamos el registro
            $producto_guardar = new Producto([
                'id' => $id,
                'nombre' => $nombre_producto,
                'categoria' => $categoria_producto,
                'precio' => $precio_producto, 
                'imagen' => $imagen_producto, 
                'activo' => $estado_producto, 
            ]);

            $alertas = $producto_guardar->validar();

            if (arregloVacio($alertas))
            {
                $resultado = $producto_guardar->guardar();
                $tabla = 'productos';
                $id_registro = $resultado['id'];
                // if (!campoVacio($id_registro))
                // {
                //     $evento = new BitacoraEventos;
                //     $evento->eventos(2, $id_registro, $tabla);
                // }

                echo json_encode([
                    'resultado' => $resultado,
                    'tipo' => $resultado ? 'exito' : 'error'
                ]);
                exit;
            } 
            else
            {
                echo json_encode([
                    'resultado' => false,
                    'alertas' => $alertas ,
                    'tipo' => 'error'
                ]);
                exit;   
            }
        }
    }

    public static function eliminar_producto()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            //Aqui vamos a capturar los productos por menu y por usario
                $id = $_POST['id'] ?? '';
                $id = filter_var($id, FILTER_VALIDATE_INT);

                $producto = Producto::find($id);

                if (!campoVacio($producto))
                {
                    $resultado = $producto->eliminar();

                    if (!campoVacio($resultado))
                    {
                        echo json_encode([
                            'resultado' => $resultado,
                            'alertas' => $alertas ?? '',
                            'tipo' => $resultado ? 'exito' : 'error'
                        ]);
                        exit;                    
                    } 
                    else
                    {
                        echo json_encode([
                            'resultado' => $resultado = false,
                            'alertas' => 'Ocurrio un problema al tratar de eliminar este producto',
                            'tipo' => 'error'
                        ]);
                        exit;
                    }
                }
                else
                {
                    echo json_encode([
                        'resultado' => $resultado = false,
                        'alertas' => 'No se encontro el producto con el id se recibio',
                        'tipo' => 'error'
                    ]);
                    exit;
                }



        }
    }
}

?>