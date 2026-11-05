<?php 

    namespace Model;
    class Pedido_finalizado_detalle extends ActiveRecord 
    {

        // Base de datos
        protected static $tabla = 'pedidos_finalizados';
        protected static  $columnasDB =
        [
            'id',               //int AI PK
            'codigo',           //varchar(50)
            'mesa_numero',      //int
            'cliente',          // Esto es un alias de la consulta
            'total',            //decimal(10,2)
            'fecha',            //timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')
            'tipo',             // Esto es un alias de la consulta
            'metodo_pago',      //varchar(20)
        ];

        public $id;
        public $codigo;
        public $mesa_numero;
        public $cliente;
        public $total;
        public $fecha;
        public $tipo;
        public $metodo_pago;

        public function __construct($args = [])
        {
            $this->id = isset($args['id']) ? trim($args['id']) : null;
            $this->codigo = isset($args['codigo']) ? trim($args['codigo']) : '';
            $this->mesa_numero = isset($args['mesa_numero']) ? trim($args['mesa_numero']) : '';
            $this->cliente = isset($args['cliente']) ? trim($args['cliente']) : '';
            $this->total = isset($args['total']) ? trim($args['total']) : '';
            $this->fecha = isset($args['fecha']) ? trim($args['fecha']) : date('Y-m-d H:i:s');
            $this->tipo = isset($args['tipo']) ? trim($args['tipo']) : null;
            $this->metodo_pago = isset($args['metodo_pago']) ? trim($args['metodo_pago']) : '';
        }

        // public function validar()
        // {
        //     if(campoVacio($this->mesa_numero))
        //     {
        //         self::$alertas['error'][] = 'El numero de mesa es obligatorio';
        //     }
        //     if(campoVacio($this->codigo))
        //     {
        //         self::$alertas['error'][] = 'El codigo es obligatorio';
        //     }
        //     if(campoVacio($this->platos))
        //     {
        //         self::$alertas['error'][] = 'El o los platos son obligatorios';
        //     }
        //     if(campoVacio($this->total))
        //     {
        //         self::$alertas['error'][] = 'El total es obligatorio';
        //     }
        //     if(campoVacio($this->metodo_pago))
        //     {
        //         self::$alertas['error'][] = 'El método de pago es obligatorio';
        //     }
        //     if(campoVacio($this->monto_entregado))
        //     {
        //         self::$alertas['error'][] = 'El monto entregado es obligatorio';
        //     }
        //     if(campoVacio($this->items_detalle))
        //     {
        //         self::$alertas['error'][] = 'El detalle del item es obligatorio';
        //     }
        //     return self::$alertas;
        // }

    }
?>