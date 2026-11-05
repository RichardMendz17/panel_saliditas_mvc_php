<?php 

    namespace Model;
    class Plato_item extends ActiveRecord 
    {

        // Base de datos
        protected static $tabla = 'plato_items';
        protected static  $columnasDB =
        [
            'id',               //int AI PK
            'plato_id',         //int
            'producto_nombre',  //varchar(100)
            'cantidad',         //int
            'precio_unitario',  //decimal(10,2)

        ];

        public $id;
        public $plato_id;
        public $producto_nombre;
        public $cantidad;
        public $precio_unitario;


        public function __construct($args = [])
        {
            $this->id = isset($args['id']) ? trim($args['id']) : null;
            $this->plato_id = isset($args['plato_id']) ? trim($args['plato_id']) : '';
            $this->producto_nombre = isset($args['producto_nombre']) ? trim($args['producto_nombre']) : '';
            $this->cantidad = isset($args['cantidad']) ? trim($args['cantidad']) : '';
            $this->precio_unitario = isset($args['precio_unitario']) ? trim($args['precio_unitario']) : '';
        } 

        public function validar()
        {
            if(campoVacio($this->plato_id))
            {
                self::$alertas['error'][] = 'El plato es es obligatorio';
            }
            if(campoVacio($this->producto_nombre))
            {
                self::$alertas['error'][] = 'El nombre del producto es obligatorio';
            }
            if(campoVacio($this->cantidad))
            {
                self::$alertas['error'][] = 'La cantidad  del item es obligatorio';
            }
            if(campoVacio($this->precio_unitario))
            {
                self::$alertas['error'][] = 'El precio unitario es obligatorio';
            }
            return self::$alertas;
        }

    }
?>