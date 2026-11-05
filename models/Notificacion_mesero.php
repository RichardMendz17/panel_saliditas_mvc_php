<?php 

    namespace Model;
    class Notificacion_mesero extends ActiveRecord 
    {

        // Base de datos
        protected static $tabla = 'notificaciones_mesero';
        protected static  $columnasDB =
        [
            'id',               //int AI PK
            'tipo',             //varchar(20)
            'pedido_id',        //int
            'mensaje',          //text
            'cliente_nombre',   //varchar(100)
            'cliente_telefono', //varchar(20)
            'estado',           //varchar(20)
            'created_at',       //timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')
        ];

        public $id;
        public $tipo;
        public $pedido_id;
        public $mensaje;
        public $cliente_nombre;
        public $cliente_telefono;
        public $estado;
        public $created_at;

        public function __construct($args = [])
        {
            $this->id = isset($args['id']) ? trim($args['id']) : null;
            $this->tipo = isset($args['tipo']) ? trim($args['tipo']) : '';
            $this->pedido_id = isset($args['pedido_id']) ? trim($args['pedido_id']) : '';
            $this->mensaje = isset($args['mensaje']) ? trim($args['mensaje']) : '';
            $this->cliente_nombre = isset($args['cliente_nombre']) ? trim($args['cliente_nombre']) : '';
            $this->cliente_telefono = isset($args['cliente_telefono']) ? trim($args['cliente_telefono']) : '';
            $this->estado = isset($args['estado']) ? trim($args['estado']) : '';
            $this->created_at = isset($args['created_at']) ? trim($args['created_at']) : date('Y-m-d H:i:s');
        }

        public function validar()
        {
            if(campoVacio($this->tipo))
            {
                self::$alertas['error'][] = 'El tipo de notificacion es obligatorio';
            }
            if(campoVacio($this->pedido_id))
            {
                self::$alertas['error'][] = 'El identificador del pedido es obligatorio';
            }
            if(campoVacio($this->cliente_nombre))
            {
                self::$alertas['error'][] = 'El nombre del cliente es obligatorio';
            }
            if(campoVacio($this->cliente_telefono))
            {
                self::$alertas['error'][] = 'El telefono del cliente es obligatorio';
            }
            if(campoVacio($this->estado))
            {
                self::$alertas['error'][] = 'El estado es obligatorio';
            }
            return self::$alertas;
        }

    }
?>