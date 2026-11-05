<?php 

    namespace Model;
    class Pedido_cocina extends ActiveRecord
    {
        // Base de datos
        protected static $tabla = 'pedidos_cocina';
        protected static  $columnasDB =
        [
            'id',               //int AI PK
            'mesa_id',          //int
            'codigo',           //varchar(20)
            'nombre_cliente',   //varchar(100)
            'telefono',         //varchar(20)
            'items',            //text
            'total',            //decimal(10,2)
            'estado',           //varchar(20)
            'created_at',       //timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')
        ];

        public $id;
        public $mesa_id;
        public $codigo;
        public $nombre_cliente;
        public $telefono;
        public $items;
        public $total;
        public $estado;
        public $created_at;
            
        public function __construct($args = [])
        {
            $this->id = isset($args['id']) ? trim($args['id']) : null;
            $this->mesa_id = isset($args['mesa_id']) ? trim($args['mesa_id']) : '';
            $this->codigo = isset($args['codigo']) ? trim($args['codigo']) : '';
            $this->nombre_cliente = isset($args['nombre_cliente']) ? trim($args['nombre_cliente']) : '';
            $this->telefono = isset($args['telefono']) ? trim($args['telefono']) : '';
            $this->items = isset($args['items']) ? trim($args['items']) : '';
            $this->total = isset($args['total']) ? trim($args['total']) : '';
            $this->estado = isset($args['estado']) ? trim($args['estado']) : '';
            $this->created_at = isset($args['created_at']) ? trim($args['created_at']) : date('Y-m-d H:i:s');
        } 

        public function validar()
        {
            if(campoVacio($this->mesa_id))
            {
                self::$alertas['error'][] = 'La mesa es obligatoria';
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
            if(campoVacio($this->items))
            {
                self::$alertas['error'][] = 'El o los items son obligatorios';
            } 
            if(campoVacio($this->total))
            {
                self::$alertas['error'][] = 'El total es obligatorio';
            } 
            if(campoVacio($this->estado))
            {
                self::$alertas['error'][] = 'El estado es obligatorio';
            } 
            return self::$alertas;
        }
    }
?>