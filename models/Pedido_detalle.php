<?php 

    namespace Model;
    class Pedido_detalle extends ActiveRecord 
    {
        // Base de datos
        protected static $tabla = 'pedidos';
        protected static  $columnasDB =
        [
            'id',               //int AI PK
            'codigo',           //varchar(10)
            'cliente',          //varchar(100)
            'total',            //decimal(10,2)
            'fecha',            //timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')
            'tipo',             //enum('efectivo','tarjeta')
            'telefono',         //varchar(20)
            'metodo_pago',      //varchar(20)
        ];

        public $id;
        public $codigo;
        public $cliente;
        public $total;
        public $fecha;
        public $tipo;
        public $telefono;
        public $metodo_pago;

        public function __construct($args = [])
        {
            $this->id = isset($args['id']) ? trim($args['id']) : null;
            $this->codigo = isset($args['codigo']) ? trim($args['codigo']) : '';
            $this->cliente = isset($args['cliente']) ? trim($args['cliente']) : '';
            $this->total = isset($args['total']) ? trim($args['total']) : '';
            $this->fecha = isset($args['fecha']) ? trim($args['fecha']) : date('Y-m-d H:i:s');
            $this->tipo = isset($args['tipo']) ? trim($args['tipo']) : '';
            $this->telefono = isset($args['telefono']) ? trim($args['telefono']) : '';
            $this->metodo_pago = isset($args['metodo_pago']) ? trim($args['metodo_pago']) : '';
        }

        // public function validar()
        // {
        //     if(campoVacio($this->codigo_recogida))
        //     {
        //         self::$alertas['error'][] = 'El codigo de recogida es obligatorio';
        //     }
        //     if(campoVacio($this->tipo_entrega))
        //     {
        //         self::$alertas['error'][] = 'El tipo de entrega es obligatorio';
        //     }
        //     if(campoVacio($this->nombre_cliente))
        //     {
        //         self::$alertas['error'][] = 'El nombre del cliente es obligatorio';
        //     }
        //     if(campoVacio($this->telefono))
        //     {
        //         self::$alertas['error'][] = 'El telefono es obligatoria';
        //     }
        //     if(campoVacio($this->ubicacion))
        //     {
        //         self::$alertas['error'][] = 'La ubicacion es obligatoria';
        //     }
        //     if(campoVacio($this->tipo_pago))
        //     {
        //         self::$alertas['error'][] = 'El tipo de pago obligatorio';
        //     }
        //     if(campoVacio($this->total))
        //     {
        //         self::$alertas['error'][] = 'El total es obligatorio';
        //     }
        //     if(campoVacio($this->pedido_detalle))
        //     {
        //         self::$alertas['error'][] = 'El detalle del pedido es obligatorio';
        //     }
        //     if(campoVacio($this->estado))
        //     {
        //         self::$alertas['error'][] = 'El estado del pedido es obligatorio';
        //     }
        //     if(campoVacio($this->codigo_seguridad))
        //     {
        //         self::$alertas['error'][] = 'El codigo de seguridad es obligatorio';
        //     }
        //     if(campoVacio($this->items_detalle))
        //     {
        //         self::$alertas['error'][] = 'El detalle del item es obligatorio';
        //     }
        //     if(campoVacio($this->metodo_pago))
        //     {
        //         self::$alertas['error'][] = 'El metodo de pago es obligatorio';
        //     }
        //     return self::$alertas;
        // }
    }
?>