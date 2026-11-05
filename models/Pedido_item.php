<?php 

    namespace Model;
    class Pedido_item extends ActiveRecord 
    {

        // Base de datos
        protected static $tabla = 'pedido_items';
        protected static  $columnasDB =
        [
            'id',               //int AI PK
            'pedido_id',        //int
            'nombre_producto',  //varchar(100)
            'categoria',        //varchar(50)
            'cantidad',         //int
            'precio_unitario',  //decimal(10,2)
            'extras',           //text
            'nota',             //varchar(255)
            'item_info',        //text        
            'tipo_quesadilla',  //varchar(50)
            'guisado',          //varchar(50)
            'tamaño',           //varchar(20)
            'tipo_producto',    //varchar(50)
            'item_completo'     //longtext    
        ];

        public $id;
        public $pedido_id;
        public $nombre_producto;
        public $categoria;
        public $cantidad;
        public $precio_unitario;
        public $extras;
        public $nota;
        public $item_info;
        public $tipo_quesadilla;
        public $guisado;
        public $tamaño;
        public $tipo_producto;
        public $item_completo;

        public function __construct($args = [])
        {
            $this->id = isset($args['id']) ? trim($args['id']) : null;
            $this->pedido_id = isset($args['pedido_id']) ? trim($args['pedido_id']) : '';
            $this->nombre_producto = isset($args['nombre_producto']) ? trim($args['nombre_producto']) : '';
            $this->categoria = isset($args['categoria']) ? trim($args['categoria']) : '';
            $this->cantidad = isset($args['cantidad']) ? trim($args['cantidad']) : '';
            $this->precio_unitario = isset($args['precio_unitario']) ? trim($args['precio_unitario']) : '';
            $this->extras = isset($args['extras']) ? trim($args['extras']) : '';
            $this->nota = isset($args['nota']) ? trim($args['nota']) : '';
            $this->item_info = isset($args['item_info']) ? trim($args['item_info']) : null;
            $this->tipo_quesadilla = isset($args['tipo_quesadilla']) ? trim($args['tipo_quesadilla']) : '';
            $this->guisado = isset($args['guisado']) ? trim($args['guisado']) : '';
            $this->tamaño = isset($args['tamaño']) ? trim($args['tamaño']) : '';
            $this->tipo_producto = isset($args['tipo_producto']) ? trim($args['tipo_producto']) : '';
            $this->item_completo = isset($args['item_completo']) ? trim($args['item_completo']) : '';
        }

        // public function validar()
        // {
        //     if(campoVacio($this->pedido_id))
        //     {
        //         self::$alertas['error'][] = 'El pedido es obligatorio de notificacion es obligatorio';
        //     }
        //     if(campoVacio($this->pedido_tipo))
        //     {
        //         self::$alertas['error'][] = 'El tipo de pedido es obligatorio';
        //     }
        //     if(campoVacio($this->producto_nombre))
        //     {
        //         self::$alertas['error'][] = 'El nombre del producto es obligatorio';
        //     }
        //     if(campoVacio($this->cantidad))
        //     {
        //         self::$alertas['error'][] = 'La cantidad es obligatoria';
        //     }
        //     if(campoVacio($this->precio_unitario))
        //     {
        //         self::$alertas['error'][] = 'El precio unitario es obligatorio';
        //     }
        //     if(campoVacio($this->subtotal))
        //     {
        //         self::$alertas['error'][] = 'El subtotal es obligatorio';
        //     }
        //     if(campoVacio($this->metodo_pago))
        //     {
        //         self::$alertas['error'][] = 'El método de pago es obligatorio';
        //     }
        //     return self::$alertas;
        // }

    }
?>