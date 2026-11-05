<?php 

    namespace Model;
    class Concepto extends ActiveRecord 
    {

        // Base de datos
        protected static $tabla = 'conceptos';
        protected static  $columnasDB = ['id', 'nombre_Concepto'];

        public $id;
        public $nombre_Concepto;

            
        public function __construct($args = []){
            $this->id = $args['id'] ?? NULL;
            $this->nombre_Concepto = isset($args['nombre_Concepto']) ? trim($args['nombre_Concepto']) : '';
        } 

        public function validar(){
            if(!$this->nombre_Concepto){
                self::$alertas['error'][] = 'El Concepto es obligatorio';
            }
            return self::$alertas;
        }

        public static function obtenerColumnas() {
            return self::$columnasDB;
        }


    }
?>