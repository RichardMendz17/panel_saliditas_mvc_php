<?php 
    // Esta cla nos ayuda a 
    namespace Model;
    use Model\Rol;
    class PersonalRolSeleccionado extends ActiveRecord {

    // Base de datos
    protected static $tabla = 'asignacion_roles';
    protected static  $columnasDB = 
        [
            'id',
            'id_rol',
            'id_personal',
            'id_carrera'
        ];
    protected static $alertas = [];

    public $id;
    public $id_rol;
    public $id_personal;
    public $id_carrera;


        
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->id_rol = isset($args['id_rol']) ? trim($args['id_rol']) : '';
        $this->id_personal = isset($args['id_personal']) ? trim($args['id_personal']) : '';
        $this->id_carrera = $args['id_carrera'] ?? NULL;

    }

    public static function obtenerColumnas()
    {
        return self::$columnasDB;
    }

    public function validar()
    { 
        if(campoVacio($this->id_rol)){
            self::$alertas['error'][] = 'Seleccionar un rol es obligatorio';
        } 
        if(!$this->id_personal){
            self::$alertas['error'][] = 'El id del Personal es obligatorio';
        } 
        return self::$alertas;
    }
    
    // Se valida carrera para el jefe de carrera
    public function validarCarrera()
    {
        if(campoVacio($this->id_carrera)){
            self::$alertas['error'][] = 'La carrera es obligatoria';
        }
        return self::$alertas;
    }

    public function obtenerNombreRol()
    {
            $nombre_rol = Rol::find($this->id_rol);
            return $nombre_rol ? $nombre_rol->rol : ''; 
    }
    
    public function asignarRolYRedirigir(int $idRol)
    {
        $_SESSION['rol'] = $idRol;
        // Buscar el nombre del rol sólo una vez
        $datos_rol = Rol::find($idRol);
        $_SESSION['nombre_rol'] = $datos_rol->rol ?? '';

        header('Location: /dashboard');
        exit;
    }
    }
?>