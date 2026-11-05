<?php 

    namespace Model;
    class Pedido_item_historial extends ActiveRecord 
    {

        // Base de datos
        protected static $tabla = 'pedido_items_historial';
        protected static  $columnasDB =
        [
            'id',               //int AI PK
            'pedido_id',        //int
            'pedido_tipo',      //varchar(20)
            'producto_nombre',  //varchar(200)
            'cantidad',         //int
            'precio_unitario',  //decimal(10,2)
            'subtotal',         //decimal(10,2)(20)
            'extras',           //text
            'fecha_registro',   //timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')
            'metodo_pago',      //decimal(10,2)
        ];

        public $id;
        public $pedido_id;
        public $pedido_tipo;
        public $producto_nombre;
        public $cantidad;
        public $precio_unitario;
        public $subtotal;
        public $extras;
        public $fecha_registro;
        public $metodo_pago;

        public function __construct($args = [])
        {
            $this->id = isset($args['id']) ? trim($args['id']) : null;
            $this->pedido_id = isset($args['pedido_id']) ? trim($args['pedido_id']) : '';
            $this->pedido_tipo = isset($args['pedido_tipo']) ? trim($args['pedido_tipo']) : '';
            $this->producto_nombre = isset($args['producto_nombre']) ? trim($args['producto_nombre']) : '';
            $this->cantidad = isset($args['cantidad']) ? trim($args['cantidad']) : '';
            $this->precio_unitario = isset($args['precio_unitario']) ? trim($args['precio_unitario']) : '';
            $this->subtotal = isset($args['subtotal']) ? trim($args['subtotal']) : '';
            $this->extras = isset($args['extras']) ? trim($args['extras']) : '';
            $this->fecha_registro = isset($args['fecha_registro']) ? trim($args['fecha_registro']) : date('Y-m-d H:i:s');
            $this->metodo_pago = isset($args['metodo_pago']) ? trim($args['metodo_pago']) : '';
        }

        public function validar()
        {
            if(campoVacio($this->pedido_id))
            {
                self::$alertas['error'][] = 'El pedido es obligatorio de notificacion es obligatorio';
            }
            if(campoVacio($this->pedido_tipo))
            {
                self::$alertas['error'][] = 'El tipo de pedido es obligatorio';
            }
            if(campoVacio($this->producto_nombre))
            {
                self::$alertas['error'][] = 'El nombre del producto es obligatorio';
            }
            if(campoVacio($this->cantidad))
            {
                self::$alertas['error'][] = 'La cantidad es obligatoria';
            }
            if(campoVacio($this->precio_unitario))
            {
                self::$alertas['error'][] = 'El precio unitario es obligatorio';
            }
            if(campoVacio($this->subtotal))
            {
                self::$alertas['error'][] = 'El subtotal es obligatorio';
            }
            if(campoVacio($this->metodo_pago))
            {
                self::$alertas['error'][] = 'El método de pago es obligatorio';
            }
            return self::$alertas;
        }

    }
?>