<?php 

    namespace Model;
    class Pedido_activo extends ActiveRecord {

    // Base de datos
    protected static $tabla = 'pedidos_activos';
    protected static  $columnasDB =
    [
        'id',           //int AI PK
        'mesa_id',      //int
        'codigo',       //varchar(50)
        'platos',       //longtext
        'total',        //decimal(10,2)
        'created_at',   //timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')
    ];

    public $id;
    public $mesa_id;
    public $codigo;
    public $platos;
    public $total;
    public $created_at;
        
    public function __construct($args = [])
    {
        $this->id = isset($args['id']) ? trim($args['id']) : null;
        $this->mesa_id = isset($args['mesa_id']) ? trim($args['mesa_id']) : '';
        $this->codigo = isset($args['codigo']) ? trim($args['codigo']) : '';
        $this->platos = isset($args['platos']) ? trim($args['platos']) : '';
        $this->total = isset($args['total']) ? trim($args['total']) : '';
        $this->created_at = isset($args['created_at']) ? trim($args['created_at']) : date('Y-m-d H:i:s');
    } 

    public function validar()
    {
        if(campoVacio($this->mesa_id))
        {
            self::$alertas['error'][] = 'La mesa es obligatoria';
        }
        if(campoVacio($this->codigo))
        {
            self::$alertas['error'][] = 'El codigo es obligatorio';
        }        
        if(campoVacio($this->platos))
        {
            self::$alertas['error'][] = 'Los platos son obligatorios';
        }        
        if(campoVacio($this->total))
        {
            self::$alertas['error'][] = 'El total es obligatorio';
        }     
        return self::$alertas;
    }

}
?>