<?php 

    namespace Model;
    class Categoria extends ActiveRecord 
    {
        // Base de datos
        protected static $tabla = 'categorias';
        protected static  $columnasDB =
        [
            'id',           //int AI PK
            'nombre_categoria',       //varchar(45)

        ];

        public $id;
        public $nombre_categoria;

        public function __construct($args = [])
        {
            $this->id = isset($args['id']) ? trim($args['id']) : null;
            $this->nombre_categoria = isset($args['nombre_categoria']) ? trim($args['nombre_categoria']) : '';
        } 

        public function validar()
        {
            if(campoVacio($this->nombre_categoria))
            {
                self::$alertas['error'][] = 'El nombre del producto es obligatorio';
            }
            return self::$alertas;
        }
    }
?>