<?php 

    namespace Model;
    class Comanda extends ActiveRecord {

    // Base de datos
    protected static $tabla = 'comandas';
    protected static  $columnasDB = [
        'id',               //int AI PK
        'codigo_comanda',   //varchar(20)
        'mesero_id',        //int
        'mesa_id',          //int
        'estado',           //enum('pendiente','en_cocina','listo','entregado','pagado')
        'nombre_cliente',   //varchar(100)
        'total',            //datetime
        'notas_generales',  //datetime
        'created_at',       //datetime
        'updated_ad'        //datetime
        ];
    protected static $alertas = [];

    public $id;
    public $codigo_comanda;
    public $mesero_id;
    public $mesa_id;
    public $estado;
    public $total;
    public $notas_generales;
    public $created_at;
    public $updated_ad;

        
    public function __construct($args = []){
        $this->id = $args['id'] ?? NULL;
        $this->codigo_comanda = isset($args['codigo_comanda']) ? trim($args['codigo_comanda']) : '';
        $this->mesero_id = isset($args['mesero_id']) ? trim($args['mesero_id']) : '';
        $this->mesa_id = isset($args['mesa_id']) ? trim($args['mesa_id']) : '';
        $this->estado = isset($args['estado']) ? trim($args['estado']) : '';
        $this->total = isset($args['total']) ? trim($args['total']) : '';
        $this->notas_generales = isset($args['notas_generales']) ? trim($args['notas_generales']) : '';
        $this->created_at = isset($args['created_at']) ? trim($args['created_at']) : '';
        $this->updated_ad = isset($args['updated_ad']) ? trim($args['updated_ad']) : '';

    }

    public function validar()
    {
        if(campoVacio($this->codigo_comanda))
        {
            self::$alertas['error'][] = 'El codigo comanda es obligatorio';
        }
        if(campoVacio($this->mesero_id))
        {
            self::$alertas['error'][] = 'El mesero es obligatorio';
        }
        if(campoVacio($this->mesa_id))
        {
            self::$alertas['error'][] = 'La mesa es obligatoria';
        }
        if(campoVacio($this->estado))
        {
            self::$alertas['error'][] = 'El estado es obligatorio';
        }
        if(campoVacio($this->total))
        {
            self::$alertas['error'][] = 'El total es obligatorio';
        }
        return self::$alertas;
    }


    }
?>