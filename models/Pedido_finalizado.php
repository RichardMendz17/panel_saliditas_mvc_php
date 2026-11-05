<?php 

    namespace Model;
    class Pedido_finalizado extends ActiveRecord 
    {
        // Base de datos
        protected static $tabla = 'pedidos_finalizados';
        protected static  $columnasDB =
        [
            'id',               //int AI PK
            'mesa_numero',      //int
            'codigo',           //varchar(50)
            'platos',           //longtext
            'total',            //decimal(10,2)
            'fecha',            //timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')
            'fecha_cobro',      //timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')
            'metodo_pago',      //varchar(20)
            'monto_entregado',  //decimal(10,2)
            'cambio',           //decimal(10,2)
            'items_detalle',    //longtext
        ];

        public $id;
        public $mesa_numero;
        public $codigo;
        public $platos;
        public $total;
        public $fecha;
        public $fecha_cobro;
        public $metodo_pago;
        public $monto_entregado;
        public $cambio;
        public $items_detalle;

        public function __construct($args = [])
        {
            $this->id = isset($args['id']) ? trim($args['id']) : null;
            $this->mesa_numero = isset($args['mesa_numero']) ? trim($args['mesa_numero']) : '';
            $this->codigo = isset($args['codigo']) ? trim($args['codigo']) : '';
            $this->platos = isset($args['platos']) ? trim($args['platos']) : '';
            $this->total = isset($args['total']) ? trim($args['total']) : '';
            $this->fecha = isset($args['fecha']) ? trim($args['fecha']) : date('Y-m-d H:i:s');
            $this->fecha_cobro = isset($args['fecha_cobro']) ? trim($args['fecha_cobro']) : '';
            $this->metodo_pago = isset($args['metodo_pago']) ? trim($args['metodo_pago']) : '';
            $this->monto_entregado = isset($args['monto_entregado']) ? trim($args['monto_entregado']) : '';
            $this->cambio = isset($args['cambio']) ? trim($args['cambio']) : '';
            $this->items_detalle = isset($args['items_detalle']) ? trim($args['items_detalle']) : '';
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