<?php 

    namespace Model;
    class Pedido extends ActiveRecord 
    {
        // Base de datos
        protected static $tabla = 'pedidos';
        protected static  $columnasDB =
        [
            'id',               //int AI PK
            'codigo_recogida',  //varchar(10)
            'tipo_entrega',     //enum('tienda','domicilio')
            'nombre_cliente',   //varchar(100)
            'telefono',         //varchar(20)
            'ubicacion',        //text
            'tipo_pago',        //enum('efectivo','tarjeta')
            'monto_efectivo',   //decimal(10,2)
            'cambio_para',      //decimal(10,2)
            'total',            //decimal(10,2)
            'salsas',           //varchar(50)
            'pedido_detalle',   //text
            'estado',           //enum('pendiente','aceptado','rechazado','preparando','listo','entregado')
            'fecha_creacion',   //timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')
            'codigo_seguridad', //varchar(10)
            'fecha_cobro',      //timestamp // esta propiedad se asigna como null
            'items_detalle',    //longtext
            'metodo_pago',      //varchar(20)
        ];

        public $id;
        public $codigo_recogida;
        public $tipo_entrega;
        public $nombre_cliente;
        public $telefono;
        public $ubicacion;
        public $tipo_pago;
        public $monto_efectivo;
        public $cambio_para;
        public $total;
        public $salsas;
        public $pedido_detalle;
        public $estado;
        public $fecha_creacion;
        public $codigo_seguridad;
        public $fecha_cobro;
        public $items_detalle;
        public $metodo_pago;

        public function __construct($args = [])
        {
            $this->id = isset($args['id']) ? trim($args['id']) : null;
            $this->codigo_recogida = isset($args['codigo_recogida']) ? trim($args['codigo_recogida']) : '';
            $this->tipo_entrega = isset($args['tipo_entrega']) ? trim($args['tipo_entrega']) : '';
            $this->nombre_cliente = isset($args['nombre_cliente']) ? trim($args['nombre_cliente']) : '';
            $this->telefono = isset($args['telefono']) ? trim($args['telefono']) : '';
            $this->ubicacion = isset($args['ubicacion']) ? trim($args['ubicacion']) : '';
            $this->tipo_pago = isset($args['tipo_pago']) ? trim($args['tipo_pago']) : '';
            $this->monto_efectivo = isset($args['monto_efectivo']) ? trim($args['monto_efectivo']) : null;
            $this->cambio_para = isset($args['cambio_para']) ? trim($args['cambio_para']) : null;
            $this->total = isset($args['total']) ? trim($args['total']) : '';
            $this->salsas = isset($args['salsas']) ? trim($args['salsas']) : '';
            $this->pedido_detalle = isset($args['pedido_detalle']) ? trim($args['pedido_detalle']) : '';
            $this->estado = isset($args['estado']) ? trim($args['estado']) : 'pendiente';
            $this->fecha_creacion = isset($args['fecha_creacion']) ? trim($args['fecha_creacion']) : date('Y-m-d H:i:s');
            $this->codigo_seguridad = isset($args['codigo_seguridad']) ? trim($args['codigo_seguridad']) : '';
            $this->fecha_cobro = isset($args['fecha_cobro']) ? trim($args['fecha_cobro']) : null;
            $this->items_detalle = isset($args['items_detalle']) ? trim($args['items_detalle']) : '';
            $this->metodo_pago = isset($args['metodo_pago']) ? trim($args['metodo_pago']) : '';
        }

        public function validar()
        {
            if(campoVacio($this->codigo_recogida))
            {
                self::$alertas['error'][] = 'El codigo de recogida es obligatorio';
            }
            if(campoVacio($this->tipo_entrega))
            {
                self::$alertas['error'][] = 'El tipo de entrega es obligatorio';
            }
            if(campoVacio($this->nombre_cliente))
            {
                self::$alertas['error'][] = 'El nombre del cliente es obligatorio';
            }
            if(campoVacio($this->telefono))
            {
                self::$alertas['error'][] = 'El telefono es obligatoria';
            }
            if(campoVacio($this->ubicacion))
            {
                self::$alertas['error'][] = 'La ubicacion es obligatoria';
            }
            if(campoVacio($this->tipo_pago))
            {
                self::$alertas['error'][] = 'El tipo de pago obligatorio';
            }
            if(campoVacio($this->total))
            {
                self::$alertas['error'][] = 'El total es obligatorio';
            }
            if(campoVacio($this->pedido_detalle))
            {
                self::$alertas['error'][] = 'El detalle del pedido es obligatorio';
            }
            if(campoVacio($this->estado))
            {
                self::$alertas['error'][] = 'El estado del pedido es obligatorio';
            }
            if(campoVacio($this->codigo_seguridad))
            {
                self::$alertas['error'][] = 'El codigo de seguridad es obligatorio';
            }
            if(campoVacio($this->items_detalle))
            {
                self::$alertas['error'][] = 'El detalle del item es obligatorio';
            }
            if(campoVacio($this->metodo_pago))
            {
                self::$alertas['error'][] = 'El metodo de pago es obligatorio';
            }
            return self::$alertas;
        }
    }
?>