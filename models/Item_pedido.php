<?php 

    namespace Model;
    class Item_pedido extends ActiveRecord {

    // Base de datos
    protected static $tabla = 'Items_pedido';
    protected static  $columnasDB =
    [
        'id',               //int AI PK
        'pedido_id',        //id
        'producto_nombre',  //varchar(100)
        'cantidad',         //int
        'precio_unitario',  //decimal(10, 2)
        'sin_lechuga',      //tinyint
        'sin_crema',        //tinyint
        'sin_queso_rayado', //tinyint
        'queso_extra',      //tinyint
        'comentario',       //text
    ];

    public $id;
    public $pedido_id;
    public $producto_nombre;
    public $cantidad;
    public $precio_unitario;
    public $sin_lechuga;
    public $sin_crema;
    public $sin_queso_rayado;
    public $queso_extra;
    public $comentario;

    public function __construct($args = [])
    {
        $this->id = isset($args['id']) ? trim($args['id']) : null;
        $this->pedido_id = isset($args['pedido_id']) ? trim($args['pedido_id']) : '';
        $this->producto_nombre = isset($args['producto_nombre']) ? trim($args['producto_nombre']) : '';
        $this->cantidad = isset($args['cantidad']) ? trim($args['cantidad']) : '';
        $this->precio_unitario = isset($args['precio_unitario']) ? trim($args['precio_unitario']) : '';
        $this->sin_lechuga = isset($args['sin_lechuga']) ? trim($args['sin_lechuga']) : '';
        $this->sin_crema = isset($args['sin_crema']) ? trim($args['sin_crema']) : null;
        $this->sin_queso_rayado = isset($args['sin_queso_rayado']) ? trim($args['sin_queso_rayado']) : '';
        $this->queso_extra = isset($args['queso_extra']) ? trim($args['queso_extra']) : '';
        $this->comentario = isset($args['comentario']) ? trim($args['comentario']) : '';
    } 

    public function validar()
    {
        if(campoVacio($this->pedido_id))
        {
            self::$alertas['error'][] = 'La Id del pedido es obligatorio';
        }
        if(campoVacio($this->producto_nombre))
        {
            self::$alertas['error'][] = 'El Nombre del producto es obligatorio';
        }
        if(campoVacio($this->cantidad))
        {
            self::$alertas['error'][] = 'La cantidad es obligatoria';
        }
        if(campoVacio($this->precio_unitario))
        {
            self::$alertas['error'][] = 'El precio unitario es obligatorio';
        }
        return self::$alertas;
    }

}
?>