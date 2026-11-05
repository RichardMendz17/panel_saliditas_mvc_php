<?php
namespace Model;

use Model\Rol;

class PersonalRolDetalles extends ActiveRecord
{
    // Base de datos
    protected static $tabla = 'asignacion_roles';
    protected static  $columnasDB = 
    [
        'id',
        'id_personal',
        'nombre_personal', 
        'id_rol',
        'nombre_rol',
        'id_carrera',
        'nombre_Carrera'
    ];
    protected static $alertas = [];

    public $id;
    public $id_personal;
    public $nombre_personal;
    public $id_rol;
    public $nombre_rol;
    public $id_carrera;
    public $nombre_Carrera;

        
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->id_personal = isset($args['id_personal']) ? trim($args['id_personal']) : '';
        $this->nombre_personal = isset($args['nombre_personal']) ? trim($args['nombre_personal']) : '';
        $this->id_rol = isset($args['id_rol']) ? trim($args['id_rol']) : '';
        $this->nombre_rol = isset($args['nombre_rol']) ? trim($args['nombre_rol']) : '';
        $this->id_carrera = isset($args['id_carrera']) ? trim($args['id_carrera']) : '';
        $this->nombre_Carrera = $args['nombre_Carrera'] ?? NULL;

    }

    public static function obtenerColumnas()
    {
        return self::$columnasDB;
    }

    public function validarDatosdeBusqueda($rol_seleccionado, $id)
    {
        //// Validamos el rol

        //Obtener las columnas para elegir por cual buscar        
        $roles = Rol::all();

        // Crearemos un nuevo rol el cual nos permitira traernos todos los roles de un personal
        $nuevoRol = new Rol();
        $nuevoRol->id = 99;
        $nuevoRol->rol = 'Todos los pertencientes al siguiente id';

        $roles[] = $nuevoRol;

        $rol_valido = false;

        foreach ($roles as $rol)
        {
            if ($rol->id == $rol_seleccionado)
            {
                $rol_valido = true;
                break;
            }
        }
        if ($rol_valido == false ) 
        {
            self::$alertas['error'][] = 'El tipo de usuario seleccionado no es valido';
        }

        /// Validamos el formato del id
        if(campoVacio($id))
        {
            self::$alertas['error'][] = 'El ID del personal es obligatorio';
        } 
        else 
        {
            // Validar que tenga 8 dígitos exactos (o al menos 8)
            if (!preg_match('/^\d{8,}$/', $id))
            {
                self::$alertas['error'][] = 'El Número de Matrícula debe tener al menos 8 dígitos numéricos, con el primer digito diferente de 0';
            }

            // Validar que no sea '00000000' ni '00000001'
            if (in_array($this->id, ['00000000', '00000001']))
            {
                self::$alertas['error'][] = 'El Número de Matrícula no puede ser un valor inválido';
            }
        }
        
        return self::$alertas;

    }
}
?>