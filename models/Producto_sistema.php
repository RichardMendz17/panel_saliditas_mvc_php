<?php 

    namespace Model;
    class Producto_sistema extends ActiveRecord 
    {
        // Base de datos
        protected static $tabla = 'productos_sistema';
        protected static  $columnasDB =
        [
            'id',           //int AI PK
            'nombre',       //varchar(100)
            'categoria',    //varchar(50)
            'subcategoria', //varchar(50)
            'precio',       //decimal(10,2)
            'imagen',       //varchar(255)
            'activo',       //tinyint(1)
            'orden',        //int
            'created_at',   //timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')
            'updated_at',   //timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')
        ];

        public $id;
        public $nombre;
        public $categoria;
        public $subcategoria;
        public $precio;
        public $imagen;
        public $activo;
        public $orden;
        public $created_at;
        public $updated_at;

        public function __construct($args = [])
        {
            $this->id = isset($args['id']) ? trim($args['id']) : null;
            $this->nombre = isset($args['nombre']) ? trim($args['nombre']) : '';
            $this->categoria = isset($args['categoria']) ? trim($args['categoria']) : '';
            $this->subcategoria = isset($args['subcategoria']) ? trim($args['subcategoria']) : '';
            $this->precio = isset($args['precio']) ? trim($args['precio']) : '';
            $this->imagen = isset($args['imagen']) ? trim($args['imagen']) : '';
            $this->activo = isset($args['activo']) ? trim($args['activo']) : null;
            $this->orden = isset($args['orden']) ? trim($args['orden']) : null;
            $this->created_at = isset($args['created_at']) ? trim($args['created_at']) : date('Y-m-d H:i:s');
            $this->updated_at = isset($args['updated_at']) ? trim($args['updated_at']) : date('Y-m-d H:i:s');
        }

        public function validar()
        {
            if(campoVacio($this->nombre))
            {
                self::$alertas['error'][] = 'El nombre del producto sistema es obligatorio';
            }
            if(campoVacio($this->precio))
            {
                self::$alertas['error'][] = 'El precio es obligatorio';
            }
            return self::$alertas;
        }
    }
?>