<?php 

    namespace Model;
    class Carrito_mesa extends ActiveRecord {

    // Base de datos
    protected static $tabla = 'carritos_mesa';
    protected static  $columnasDB =
    [
        'id',           //int AI PK
        'mesa_id',      //int
        'items',        //text
        'total',        //decimal(10,2)
        'updated_at',   //timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')
    ];

    public $id;
    public $mesa_id;
    public $items;
    public $total;
    public $updated_at;

        
    public function __construct($args = [])
    {
        $this->id = isset($args['id']) ? trim($args['id']) : null;
        $this->mesa_id = isset($args['mesa_id']) ? trim($args['mesa_id']) : '';
        $this->items = isset($args['items']) ? trim($args['items']) : '';
        $this->total = isset($args['total']) ? trim($args['total']) : '';
        $this->updated_at = isset($args['updated_at']) ? trim($args['updated_at']) : null;
    } 

    public function validar()
    {
        if(campoVacio($this->mesa_id))
        {
            self::$alertas['error'][] = 'La mesa es obligatoria';
        }
        if(campoVacio($this->items))
        {
            self::$alertas['error'][] = 'Los items son obligatorios';
        }        
        if(campoVacio($this->total))
        {
            self::$alertas['error'][] = 'El total es obligatorio';
        }        

        return self::$alertas;
    }

}
?>