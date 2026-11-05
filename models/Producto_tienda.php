<?php 

    namespace Model;
    class Producto_tienda extends ActiveRecord 
    {
        // Base de datos
        protected static $tabla = 'productos_tienda';
        protected static  $columnasDB =
        [
            'id',           //int AI PK
            'nombre',       //varchar(100)
            'categoria',    //varchar(50)
            'precio',       //decimal(10,2)
            'imagen',       //varchar(255)
        ];

        public $id;
        public $nombre;
        public $categoria;
        public $precio;
        public $imagen;

        public function __construct($args = [])
        {
            $this->id = isset($args['id']) ? trim($args['id']) : null;
            $this->nombre = isset($args['nombre']) ? trim($args['nombre']) : '';
            $this->categoria = isset($args['categoria']) ? trim($args['categoria']) : '';
            $this->precio = isset($args['precio']) ? trim($args['precio']) : '';
            $this->imagen = isset($args['imagen']) ? trim($args['imagen']) : '';
        } 

        public function validar()
        {
            if(campoVacio($this->nombre))
            {
                self::$alertas['error'][] = 'El nombre del producto es obligatorio';
            }
            if(campoVacio($this->categoria))// Esto esta en duda ya que en ocasiones no sera necesario agregar categoria
            {
                self::$alertas['error'][] = 'La categoria del producto es obligatorioa';
            }
            if(campoVacio($this->precio))
            {
                self::$alertas['error'][] = 'El precio del producto es obligatorio';
            }
            return self::$alertas;
        }

    }
?>