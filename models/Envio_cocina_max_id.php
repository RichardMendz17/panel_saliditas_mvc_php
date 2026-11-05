<?php 

    namespace Model;
    class Envio_cocina_max_id extends ActiveRecord {

    // Base de datos
    protected static $tabla = 'envios_cocina';
    protected static  $columnasDB =
    [
        'max_id',               //int AI PK

    ];

    public $max_id;

    public function __construct($args = [])
    {
        $this->max_id = isset($args['max_id']) ? trim($args['max_id']) : null;

    } 

}
?>