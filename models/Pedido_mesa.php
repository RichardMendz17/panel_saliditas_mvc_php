<?php 

    namespace Model;
    class Pedido_mesa extends ActiveRecord 
    {

        // Base de datos
        protected static $tabla = 'pedidos_mesa';
        protected static  $columnasDB =
        [
            'id',               //int AI PK
            'mesa_id',          //int
            'codigo',           //varchar(20)
            'nombre_cliente',   //varchar(100)
            'telefono',         //varchar(20)
            'estado',           //varchar(20)
            'subtotal',         //decimal(10,2)
            'total',            //decimal(10,2)
            'created_at',       ///timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')

        ];

        public $id;
        public $mesa_numero;
        public $codigo;
        public $nombre_cliente;
        public $telefono;
        public $estado;
        public $subtotal;
        public $total;
        public $monto_entregado;
        public $created_at;


        public function __construct($args = [])
        {
            $this->id = isset($args['id']) ? trim($args['id']) : null;
            $this->mesa_numero = isset($args['mesa_numero']) ? trim($args['mesa_numero']) : '';
            $this->codigo = isset($args['codigo']) ? trim($args['codigo']) : '';
            $this->nombre_cliente = isset($args['nombre_cliente']) ? trim($args['nombre_cliente']) : '';
            $this->telefono = isset($args['telefono']) ? trim($args['telefono']) : '';
            $this->estado = isset($args['estado']) ? trim($args['estado']) : '';
            $this->subtotal = isset($args['subtotal']) ? trim($args['subtotal']) : '';
            $this->total = isset($args['total']) ? trim($args['total']) : '';
            $this->monto_entregado = isset($args['monto_entregado']) ? trim($args['monto_entregado']) : '';
            $this->created_at = isset($args['created_at']) ? trim($args['created_at']) : date('Y-m-d H:i:s');
        }

        public function validar()
        {
            if(campoVacio($this->mesa_numero))
            {
                self::$alertas['error'][] = 'El numero de mesa es obligatorio';
            }
            if(campoVacio($this->codigo))
            {
                self::$alertas['error'][] = 'El codigo es obligatorio';
            }
            if(campoVacio($this->nombre_cliente))
            {
                self::$alertas['error'][] = 'El nombre del cliente es obligatorio';
            }
            if(campoVacio($this->telefono))
            {
                self::$alertas['error'][] = 'El telefono del cliente es obligatorio';
            }
            if(campoVacio($this->estado))
            {
                self::$alertas['error'][] = 'El estado es obligatorio';
            }
            if(campoVacio($this->subtotal))
            {
                self::$alertas['error'][] = 'El subtotal es obligatorio';
            }
            if(campoVacio($this->total))
            {
                self::$alertas['error'][] = 'El total es obligatorio';
            }
            if(campoVacio($this->monto_entregado))
            {
                self::$alertas['error'][] = 'El monto entregado es obligatorio';
            }
            return self::$alertas;
        }

    }
?>