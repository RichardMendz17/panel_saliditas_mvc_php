<?php 

    namespace Model;
    class Pedido_llevar extends ActiveRecord 
    {
        // Base de datos
        protected static $tabla = 'pedidos_llevar';
        protected static  $columnasDB =
        [
            'id',               //int AI PK
            'nombre_cliente',   //varchar(100)
            'telefono',         //varchar(20)
            'items',            //longtext
            'total',            //decimal(10,2)
            'estado',           //varchar(20) Default 'pendiente'
            'metodo_pago',      //decimal(10,2)
            'monto_entregado',  //decimal(10,2)
            'cambio',           //decimal(10,2)
            'salsas',           //varchar(100)
            'fecha_creacion',   //timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')
            'fecha_listo',      //timestamp // como null 
            'fecha_entregado',  //timestamp // como null
            'codigo_seguridad', //varchar(10)
            'codigo_recogida',  //varchar(10)
            'items_detalle',    //longtext
            'nota_general',     //text
        ];

        public $id;
        public $nombre_cliente;
        public $telefono;
        public $items;
        public $total;
        public $estado;
        public $metodo_pago;
        public $monto_entregado;
        public $cambio;
        public $salsas;
        public $fecha_creacion;
        public $fecha_listo;
        public $fecha_entregado;
        public $codigo_seguridad;
        public $codigo_recogida;
        public $fecha_cobro;
        public $items_detalle;
        public $nota_general;

        public function __construct($args = [])
        {
            $this->id = isset($args['id']) ? trim($args['id']) : null;
            $this->nombre_cliente = isset($args['nombre_cliente']) ? trim($args['nombre_cliente']) : '';
            $this->telefono = isset($args['telefono']) ? trim($args['telefono']) : '';
            $this->nombre_cliente = isset($args['nombre_cliente']) ? trim($args['nombre_cliente']) : '';
            $this->telefono = isset($args['telefono']) ? trim($args['telefono']) : '';
            $this->items = isset($args['items']) ? trim($args['items']) : '';
            $this->total = isset($args['total']) ? trim($args['total']) : '';
            $this->estado = isset($args['estado']) ? trim($args['estado']) : '';
            $this->metodo_pago = isset($args['metodo_pago']) ? trim($args['metodo_pago']) : '';
            $this->monto_entregado = isset($args['monto_entregado']) ? trim($args['monto_entregado']) : null;
            $this->cambio = isset($args['cambio']) ? trim($args['cambio']) : null;
            $this->salsas = isset($args['salsas']) ? trim($args['salsas']) : '';
            $this->fecha_creacion = isset($args['fecha_creacion']) ? trim($args['fecha_creacion']) : date('Y-m-d H:i:s');
            $this->fecha_listo = isset($args['fecha_listo']) ? trim($args['fecha_listo']) : null;
            $this->fecha_entregado = isset($args['fecha_entregado']) ? trim($args['fecha_entregado']) : null;
            $this->codigo_seguridad = isset($args['codigo_seguridad']) ? trim($args['codigo_seguridad']) : '';
            $this->items_detalle = isset($args['items_detalle']) ? trim($args['items_detalle']) : '';
            $this->nota_general = isset($args['nota_general']) ? trim($args['nota_general']) : '';
        }

        public function validar()
        {
            if(campoVacio($this->nombre_cliente))
            {
                self::$alertas['error'][] = 'El nombre del cliente es obligatorio';
            }
            if(campoVacio($this->telefono))
            {
                self::$alertas['error'][] = 'El telefono del cliente es obligatorio';
            }
            if(campoVacio($this->nombre_cliente))
            {
                self::$alertas['error'][] = 'El nombre del cliente es obligatorio';
            }
            if(campoVacio($this->telefono))
            {
                self::$alertas['error'][] = 'El telefono es obligatoria';
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
            if(campoVacio($this->metodo_pago))
            {
                self::$alertas['error'][] = 'El metodo de pago es obligatorio';
            }
            if(campoVacio($this->salsas))
            {
                self::$alertas['error'][] = 'El o las salsas son obligatorias';
            }
            if(campoVacio($this->codigo_seguridad))
            {
                self::$alertas['error'][] = 'El codigo de seguridad es obligatorio';
            }
            if(campoVacio($this->items_detalle))
            {
                self::$alertas['error'][] = 'El detalle del item es obligatorio';
            }
            return self::$alertas;
        }

        function generarCodigoSeguridad($conn, $longitud = 4)
        {

            do
            {

                $codigo = str_pad(rand(0, 9999), $longitud, '0', STR_PAD_LEFT);

                $check = $conn->query("SELECT id FROM pedidos_llevar WHERE codigo_seguridad = '$codigo'");

            } while ($check && $check->num_rows > 0);

            return $codigo;

        }



        function generarCodigoRecogida($conn)
        {

            $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

            do {

                $codigo = '';

                for ($i = 0; $i < 5; $i++) {

                    $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];

                }

                $check = $conn->query("SELECT id FROM pedidos_llevar WHERE codigo_recogida = '$codigo'");

            } while ($check && $check->num_rows > 0);

            return $codigo;

        }
    }
?>