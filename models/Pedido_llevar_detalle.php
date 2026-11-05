<?php 

    namespace Model;
    class Pedido_llevar_detalle extends ActiveRecord 
    {
        // Base de datos
        protected static $tabla = 'pedidos_llevar';
        protected static  $columnasDB =
        [
            'id',           //int AI PK
            'codigo',       //varchar(10)
            'cliente',      //varchar(100)
            'total',        //decimal(10,2)
            'fecha',        //timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')
            'tipo',         // Esto es un alias de la consulta
            'telefono',     //varchar(20)
            'metodo_pago',  //decimal(10,2)
            'estado',       //varchar(20)
        ];

        public $id;
        public $codigo;
        public $cliente;
        public $total;
        public $fecha;
        public $tipo;
        public $telefono;
        public $metodo_pago;
        public $estado;

        public function __construct($args = [])
        {
            $this->id = isset($args['id']) ? trim($args['id']) : null;
            $this->codigo = isset($args['codigo']) ? trim($args['codigo']) : '';
            $this->cliente = isset($args['cliente']) ? trim($args['cliente']) : '';
            $this->fecha = isset($args['fecha']) ? trim($args['fecha']) : date('Y-m-d H:i:s');
            $this->tipo = isset($args['tipo']) ? trim($args['tipo']) : '';
            $this->telefono = isset($args['telefono']) ? trim($args['telefono']) : '';
            $this->metodo_pago = isset($args['metodo_pago']) ? trim($args['metodo_pago']) : '';
            $this->estado = isset($args['estado']) ? trim($args['estado']) : '';
        }

        // public function validar()
        // {
        //     if(campoVacio($this->nombre_cliente))
        //     {
        //         self::$alertas['error'][] = 'El nombre del cliente es obligatorio';
        //     }
        //     if(campoVacio($this->telefono))
        //     {
        //         self::$alertas['error'][] = 'El telefono del cliente es obligatorio';
        //     }
        //     if(campoVacio($this->nombre_cliente))
        //     {
        //         self::$alertas['error'][] = 'El nombre del cliente es obligatorio';
        //     }
        //     if(campoVacio($this->telefono))
        //     {
        //         self::$alertas['error'][] = 'El telefono es obligatoria';
        //     }
        //     if(campoVacio($this->items))
        //     {
        //         self::$alertas['error'][] = 'El o los items son obligatorios';
        //     }
        //     if(campoVacio($this->total))
        //     {
        //         self::$alertas['error'][] = 'El total es obligatorio';
        //     }
        //     if(campoVacio($this->estado))
        //     {
        //         self::$alertas['error'][] = 'El estado es obligatorio';
        //     }
        //     if(campoVacio($this->metodo_pago))
        //     {
        //         self::$alertas['error'][] = 'El metodo de pago es obligatorio';
        //     }
        //     if(campoVacio($this->salsas))
        //     {
        //         self::$alertas['error'][] = 'El o las salsas son obligatorias';
        //     }
        //     if(campoVacio($this->codigo_seguridad))
        //     {
        //         self::$alertas['error'][] = 'El codigo de seguridad es obligatorio';
        //     }
        //     if(campoVacio($this->items_detalle))
        //     {
        //         self::$alertas['error'][] = 'El detalle del item es obligatorio';
        //     }
        //     return self::$alertas;
        // }
    }
?>