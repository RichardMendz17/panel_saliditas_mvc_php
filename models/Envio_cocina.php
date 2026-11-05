<?php 

    namespace Model;
    class Envio_cocina extends ActiveRecord {

    // Base de datos
    protected static $tabla = 'envios_cocina';
    protected static  $columnasDB =
    [
        'id',               //int AI PK
        'mesa_numero',      //int
        'platos',           //longtext
        'total',            //decimal(10,2)
        'estado',           //varchar(20)
        'created_at',       //timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')
        'total_parcial',    //decimal(10,2)
        'plato_numero',     //int
        'salsas',           //varchar(100)
        'tipo_pedido',      //varchar(20)
        'cliente_nombre',   //varchar(100)
        'nota_general',      //text
    ];

    public $id;
    public $mesa_numero;
    public $platos;
    public $total;
    public $estado;
    public $created_at;
    public $total_parcial;
    public $plato_numero;
    public $salsas;
    public $tipo_pedido;
    public $cliente_nombre;
    public $nota_general;

    public function __construct($args = [])
    {
        $this->id = isset($args['id']) ? trim($args['id']) : null;
        $this->mesa_numero = isset($args['mesa_numero']) ? trim($args['mesa_numero']) : '';
        $this->platos = isset($args['platos']) ? trim($args['platos']) : '';
        $this->total = isset($args['total']) ? trim($args['total']) : '';
        $this->estado = isset($args['estado']) ? trim($args['estado']) : '';
        $this->created_at = isset($args['created_at']) ? trim($args['created_at']) : date('Y-m-d H:i:s');
        $this->total_parcial = isset($args['total_parcial']) ? trim($args['total_parcial']) : null;
        $this->plato_numero = isset($args['plato_numero']) ? trim($args['plato_numero']) : '';
        $this->salsas = isset($args['salsas']) ? trim($args['salsas']) : '';
        $this->tipo_pedido = isset($args['tipo_pedido']) ? trim($args['tipo_pedido']) : '';
        $this->cliente_nombre = isset($args['cliente_nombre']) ? trim($args['cliente_nombre']) : '';
        $this->nota_general = isset($args['nota_general']) ? trim($args['nota_general']) : '';
    } 

    public function validar()
    {
        if(campoVacio($this->fecha))
        {
            self::$alertas['error'][] = 'La fecha es obligatoria';
        }
        if(campoVacio($this->total_online))
        {
            self::$alertas['error'][] = 'El total en linea es obligatorio';
        }
        if(campoVacio($this->total_local))
        {
            self::$alertas['error'][] = 'El total local es obligatorio';
        }
        if(campoVacio($this->total_general))
        {
            self::$alertas['error'][] = 'El total general es obligatorio';
        }
        if(campoVacio($this->detalle_online))
        {
            self::$alertas['error'][] = 'El detalle online es obligatorio';
        }
        if(campoVacio($this->detalle_local))
        {
            self::$alertas['error'][] = 'El detalle local es obligatorio';
        }
        if(campoVacio($this->detalle_llevar))
        {
            self::$alertas['error'][] = 'El detalle llevar es obligatorio';
        } 
        if(campoVacio($this->total_efectivo))
        {
            self::$alertas['error'][] = 'El total efectivo es obligatorio';
        }
        if(campoVacio($this->total_tarjeta))
        {
            self::$alertas['error'][] = 'El total tarjeta es obligatorio';
        } 
        return self::$alertas;
    }

}
?>