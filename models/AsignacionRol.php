<?php 

    namespace Model;
    class AsignacionRol extends ActiveRecord {

    // Base de datos
    protected static $tabla = 'asignacion_roles';
    protected static  $columnasDB = ['id', 'id_personal', 'id_rol', 'id_carrera'];
    protected static $alertas = [];

    public $id;
    public $id_personal;
    public $id_rol;
    public $id_carrera;

        
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->id_personal = isset($args['id_personal']) ? trim($args['id_personal']) : '';
        $this->id_rol = isset($args['id_rol']) ? trim($args['id_rol']) : '';
        $this->id_carrera = $args['id_carrera'] ?? NULL;;
    }

    public function validar()
    {
        if(campoVacio($this->id_personal))
        {
            self::$alertas['error'][] = 'El Personal es obligatorio';
        }
        if(campoVacio($this->id_rol))
        {
            self::$alertas['error'][] = 'El Rol es obligatorio';
        }
        return self::$alertas;
    }

    // Se valida carrera para el jefe de carrera
    public function validarCarrera()
    {
        if(campoVacio($this->id_carrera))
        {
            self::$alertas['error'][] = 'La carrera es obligatoria';
        }
        return self::$alertas;
    }

    public static function obtenerColumnas() 
    {
        return self::$columnasDB;
    }
    }
?>