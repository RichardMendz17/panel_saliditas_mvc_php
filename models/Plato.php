<?php 

    namespace Model;
    class Plato extends ActiveRecord 
    {

        // Base de datos
        protected static $tabla = 'plato';
        protected static  $columnasDB =
        [
            'id',                       //int AI PK
            'comanda_id',               //int
            'numero_plato',             //int
            'instrucciones_especiales', //text
            'created_at',               //datetime // aqui es obligatorio asignar la fecha

        ];

        public $id;
        public $comanda_id;
        public $numero_plato;
        public $instrucciones_especiales;
        public $created_at;


        public function __construct($args = [])
        {
            $this->id = isset($args['id']) ? trim($args['id']) : null;
            $this->comanda_id = isset($args['comanda_id']) ? trim($args['comanda_id']) : '';
            $this->numero_plato = isset($args['numero_plato']) ? trim($args['numero_plato']) : '';
            $this->instrucciones_especiales = isset($args['instrucciones_especiales']) ? trim($args['instrucciones_especiales']) : '';
            $this->created_at = isset($args['created_at']) ? trim($args['created_at']) : '';
        } 

        public function validar()
        {
            if(campoVacio($this->comanda_id))
            {
                self::$alertas['error'][] = 'El comanda es obligatorio';
            }
            if(campoVacio($this->numero_plato))
            {
                self::$alertas['error'][] = 'El plato es obligatorio';
            }
            if(campoVacio($this->created_at))
            {
                self::$alertas['error'][] = 'La fecha de creacion es obligatorio';
            }
            return self::$alertas;
        }

    }
?>