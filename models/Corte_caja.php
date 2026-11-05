<?php 

    namespace Model;
    class Corte_caja extends ActiveRecord {

    // Base de datos
    protected static $tabla = 'cortes_caja';
    protected static  $columnasDB =
    [
        'id',               //int AI PK
        'fecha',            //date
        'total_online',     //decimal(10,2)
        'total_local',      //decimal(10,2)
        'total_llevar',      //decimal(10,2)
        'total_general',    //decimal(10,2)
        'total_efectivo',   //decimal(10,2)
        'total_tarjeta',    //decimal(10,2)
        'detalle_online',   //longtext
        'detalle_local',    //longtext
        'detalle_llevar',   //longtext
        'created_at',       //timestamp // esta propiedad se asigna como date('Y-m-d H:i:s')


    ];

    public $id;
    public $fecha;
    public $total_online;
    public $total_local;
    public $total_llevar;
    public $total_general;
    public $total_efectivo;
    public $total_tarjeta;
    public $detalle_online;
    public $detalle_local;
    public $detalle_llevar;
    //public $created_at;

    public function __construct($args = [])
    {
        $this->id = isset($args['id']) ? trim($args['id']) : null;
        $this->fecha = isset($args['fecha']) ? trim($args['fecha']) : '';
        $this->total_online = isset($args['total_online']) ? trim($args['total_online']) : '';
        $this->total_local = isset($args['total_local']) ? trim($args['total_local']) : '';
        $this->total_llevar = isset($args['total_llevar']) ? trim($args['total_llevar']) : '';
        $this->total_general = isset($args['total_general']) ? trim($args['total_general']) : '';
        $this->total_efectivo = isset($args['total_efectivo']) ? trim($args['total_efectivo']) : '';
        $this->total_tarjeta = isset($args['total_tarjeta']) ? trim($args['total_tarjeta']) : '';
        $this->detalle_online = isset($args['detalle_online']) ? trim($args['detalle_online']) : '';
        $this->detalle_local = isset($args['detalle_local']) ? trim($args['detalle_local']) : '';
        $this->detalle_llevar = isset($args['detalle_llevar']) ? trim($args['detalle_llevar']) : '';
        $this->created_at = isset($args['created_at']) ? trim($args['created_at']) : date('Y-m-d H:i:s');
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