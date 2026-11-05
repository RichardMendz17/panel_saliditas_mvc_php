<?php 

    namespace Model;
    class Historial_venta extends ActiveRecord {

    // Base de datos
    protected static $tabla = 'historial_ventas';
    protected static  $columnasDB =
    [
        'id',               //int AI PK
        'tipo',             //varchar(20)
        'codigo',           //varchar(50)
        'cliente',          //varchar(100)
        'productos',        //text
        'total',            //decimal(10,2)
        'fecha',            //timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')
        'detalle_local',    //longtext
        'metodo_pago',      //varchar(20)
        'estado',           //varchar(20)
    ];

    public $id;
    public $tipo;
    public $codigo;
    public $cliente;
    public $productos;
    public $total;
    public $fecha;
    public $detalle_local;
    public $estado;


        
    public function __construct($args = [])
    {
        $this->id = isset($args['id']) ? trim($args['id']) : NULL;
        $this->tipo = isset($args['tipo']) ? trim($args['tipo']) : '';
        $this->codigo = isset($args['codigo']) ? trim($args['codigo']) : '';
        $this->cliente = isset($args['cliente']) ? trim($args['cliente']) : '';
        $this->productos = isset($args['productos']) ? trim($args['productos']) : '';
        $this->total = isset($args['total']) ? trim($args['total']) : '';
        $this->fecha = isset($args['fecha']) ? trim($args['fecha']) : date('Y-m-d H:i:s');
        $this->detalle_local = isset($args['detalle_local']) ? trim($args['detalle_local']) : '';
        $this->estado = isset($args['estado']) ? trim($args['estado']) : '';
    } 

    public function validar()
    {
        if(campoVacio($this->fecha))
        {
            self::$alertas['error'][] = 'La fecha es obligatoria';
        }
        if(campoVacio($this->tipo))
        {
            self::$alertas['error'][] = 'El tipo es obligatorio';
        }
        if(campoVacio($this->codigo))
        {
            self::$alertas['error'][] = 'El codigo es obligatorio';
        }
        if(campoVacio($this->productos))
        {
            self::$alertas['error'][] = 'El productos es obligatorio';
        }
        if(campoVacio($this->total))
        {
            self::$alertas['error'][] = 'El total es obligatorio';
        }
        if(campoVacio($this->detalle_local))
        {
            self::$alertas['error'][] = 'El detalle local es obligatorio';
        }
        if(campoVacio($this->estado))
        {
            self::$alertas['error'][] = 'El estado es obligatorio';
        } 
        return self::$alertas;
    }

}
?>