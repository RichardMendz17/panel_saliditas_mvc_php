<?php 

    namespace Model;
    class Mesero extends ActiveRecord {

    // Base de datos
    protected static $tabla = 'mesero';
    protected static  $columnasDB = [
        'id',               //int AI PK
        'nombre',           //varchar(30)
        // 'apellido_Paterno', //varchar(20)
        // 'apellido_Materno', //varchar(20)
        // 'genero',           //varchar(9)
        // 'estado',           //enum('Activo','Inactivo')
        'telefono',         //varchar(20)
        'activo',           //tinyint
        'fecha_registro'    //datetime
        ];

    //Nota aun falta editar la tabla de Mesero para los campos faltantes que agregue personalmente Atte: DevRichard

    public $id;
    public $nombre;
    public $apellido_Paterno;
    public $apellido_Materno;
    public $genero;
    public $estado;
    public $telefono;
    public $activo;
    public $fecha_registro;

        
    public function __construct($args = [])
    {
        $this->id = isset($args['id']) ? trim($args['id']) : null;
        // $this->nombre = isset($args['nombre']) ? trim($args['nombre']) : '';
        // $this->apellido_Paterno = isset($args['apellido_Paterno']) ? trim($args['apellido_Paterno']) : '';
        // $this->apellido_Materno = isset($args['apellido_Materno']) ? trim($args['apellido_Materno']) : '';
        // $this->genero = isset($args['genero']) ? trim($args['genero']) : '';
        // $this->estado = isset($args['estado']) ? trim($args['estado']) : '';
        $this->telefono = isset($args['telefono']) ? trim($args['telefono']) : '';
        $this->activo = isset($args['activo']) ? trim($args['activo']) : '';
        $this->fecha_registro = isset($args['fecha_registro']) ? trim($args['fecha_registro']) : '';
     
    } 

    public function validar()
    {
        if(campoVacio($this->id))
        {
            self::$alertas['error'][] = 'El Número de la Matrícula es obligatorio';
        } 
        if(campoVacio($this->nombre))
        {
            self::$alertas['error'][] = 'El Nombre es obligatorio';
        }
        // if(campoVacio($this->apellido_Paterno))
        // {
        //     self::$alertas['error'][] = 'El Apellido Paterno es obligatorio';
        // }
        // if(campoVacio($this->apellido_Materno))
        // {
        //     self::$alertas['error'][] = 'El Apellido Materno es obligatorio';
        // }    
        // if(campoVacio($this->genero))
        // {
        //     self::$alertas['error'][] = 'El Genero es obligatorio';
        // }
        // if(campoVacio($this->estado))
        // {
        //     self::$alertas['error'][] = 'El Estado del personal es obligatorio';
        // }
        if(campoVacio($this->telefono))
        {
            self::$alertas['error'][] = 'El telefono del personal es obligatorio';
        } 

        return self::$alertas;
    }

    public function validarPersonalActivo($personal)
    {
        // Validamos el valor para el campo requisitos
        if ($personal->estado != 'Activo')
        {
            self::$alertas['error'][] = 'El personal no se encuentra activo para asignarle pedidos';
        }
        return self::$alertas;
    }

    public function nombre_completo()
    {
        return "{$this->nombre} {$this->apellido_Paterno} {$this->apellido_Materno}";
    }

}
?>