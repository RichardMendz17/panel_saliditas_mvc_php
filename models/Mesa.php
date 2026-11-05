<?php 

    namespace Model;
    class Mesa extends ActiveRecord {

    // Base de datos
    protected static $tabla = 'mesas';
    protected static  $columnasDB =
    [
        'id',           //int AI PK
        'numero_mesa',  //int
        'estado',       //varchar(20)

    ];

    public $id;
    public $numero_mesa;
    public $estado;

    public function __construct($args = [])
    {
        $this->id = isset($args['id']) ? trim($args['id']) : null;
        $this->numero_mesa = isset($args['numero_mesa']) ? trim($args['numero_mesa']) : '';
        $this->estado = isset($args['estado']) ? trim($args['estado']) : '';
    } 

    public function validar()
    {
        if(campoVacio($this->numero_mesa))
        {
            self::$alertas['error'][] = 'La Número de mesa es obligatorio';
        }
        if(campoVacio($this->estado))
        {
            self::$alertas['error'][] = 'El Estado del pedido es obligatorio';
        }
        return self::$alertas;
    }

}
?>