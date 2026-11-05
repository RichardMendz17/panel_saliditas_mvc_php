<?php 

namespace Model;

use Model\TipoUsuario;
use Model\Alumno;
use Model\Personal;

class Usuario extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = [
        'id',
        'email', 
        'nombre', 
        'password', 
        'rol',  
        ];

    public $id;
    public $email;
    public $nombre;
    public $password;
    public $rol;
    public $confirm_password;
    public $password_actual;
    public $password_nuevo;
    // // Variable para usar en busqueda de registros de usuarios
    // public $columna_seleccionada;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->email = isset($args['email']) ? trim($args['email']) : '';
        $this->nombre = isset($args['email']) ? trim($args['email']) : '';
        $this->rol = isset($args['rol']) ? trim($args['rol']) : null;      
        $this->password = $args['password'] ?? '';
        $this->confirm_password = $args['confirm_password'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
    }

        //Validar login
    public function validarLogin()
    {
        if(!$this->email)
        {
            self::$alertas['error'][] = 'El Email del usuario es obligatorio';
        }
      
        if(!$this->password)
        {
            self::$alertas['error'][] = 'El Password del usuario es obligatorio';
        }
        return self::$alertas;
    }

        //Validación para cuentas nuevas
    public function validarNuevaCuenta()
    {
        if(!$this->email)
        {
            self::$alertas['error'][] = 'El Email del usuario es obligatorio';
        }
        if(!$this->password)
        {
            self::$alertas['error'][] = 'El Password del usuario es obligatorio';
        }
        if(strlen($this->password) < 6)
        {
            self::$alertas['error'][]= 'El Password debe contener al menos 6 caracteres';
        }
           
        return self::$alertas;
    }

    // //Validación para cuentas nuevas
    // public function validarNuevaCuentaTipoJefeDeCarrera($rol, $id_carrera)
    // {
    //     if($this->rol =! 3)
    //     {
    //         self::$alertas['error'][] = 'El rol no corresponde para crear un jefe de carrea';
    //     }
    //     if(campoVacio($id_carrera))
    //     {
    //         self::$alertas['error'][] = 'Para crear un jefe de carrera es obligatorio seleccionar la carrera';
    //     }
    //     return self::$alertas;
    // }

        //Valida un email
    public function validarEmail()
    {
        if(!$this->email)
        {
            self::$alertas['error'][] = 'El email es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
        {
            self::$alertas['error'][] = 'Email no válido';
        }
        return self::$alertas;
    }

        // Valida el Password
    public function validarPassword()
    {
        if (!$this->password)
        {
            self::$alertas['error'][] = 'El password no puede ir vacío';
        }
        if(strlen($this->password) < 6)
        {
            self::$alertas['error'][]= 'El Password debe contener al menos 6 caracteres';
        }     
    }

    public function validar_perfil(){
        if (!$this->email) {
            self::$alertas['error'][]= ' El Email es Obligatorio';
        }
        return self::$alertas;        
    }

    public function nuevo_password() : array
    {
        if (!$this->password_actual)
        {
            self::$alertas['error'][] = 'El Password Actual no puede ir vacío';
        }
        if (!$this->password_nuevo)
        {
            self::$alertas['error'][] = 'El Password Nuevo no puede ir vacío';
        }
        if ($this->password_nuevo && strlen($this->password_nuevo) < 6)
        {
            self::$alertas['error'][] = 'El Password debe contener al menos 6';
        }
        return self::$alertas;
    }

        // Comprobar el password
    public function comprobar_password() : bool
    {
        return password_verify($this->password_actual, $this->password);
    }

        // Hashea el password
    public function hashPassword() : void
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function obtenerTipoUsuario() 
    {
        $tipo_usuario = TipoUsuario::find($this->tipo_usuario);
        return $tipo_usuario ? $tipo_usuario->id : '';
        
    }

    public function obtenerNombreReal()
    {
        // Si es Alumno buscar en el modelo de alumno'
        if ($this->tipo_usuario === 1) 
        {
            $alumno = Alumno::find($this->persona_id);
            return $alumno ? $alumno->nombre_completo() : ''; 
        }
        // Si es personal del instituto
        else if ($this->tipo_usuario  === 2)
        {
            $persona = Personal::find($this->persona_id);
            return $persona ? $persona->nombre_completo() : ''; 
        }
    }


    // Validamos si al buscar viene con los campos necesarios
    public function validarBusquedaUsuario($tipo_usuario, $columna, $dato)
    {
        // Verificamos si se selecciono un tipo de usuario y si no agregamos alerta
        if (campoVacio($tipo_usuario)) 
        {
            self::$alertas['error'][] = 'Es obligatorio seleccionar un tipo de usuario valido Alumno/Personal';
        }
        else 
        {
            $tipos_usuario_validos = [ '1', '2'];
            if (!in_array($tipo_usuario, $tipos_usuario_validos, true)) 
            {
                self::$alertas['error'][] = 'El tipo de usuario no es valido';
            }
        }
        // Verificamos si la columna para filtrar el usuario fue seleccionada
        if (campoVacio($columna))
        {
            self::$alertas['error'][] = 'Es obligatorio seleccionar una columna valida para continuar la busqueda';
        }
        else 
        {
            $columnasValidas = ['email', 'rol',  'persona_id'];
            if (!in_array($columna, $columnasValidas, true)) 
            {
                self::$alertas['error'][] = 'La Columna no es valido';
            }
        }
                // Verificamos si la columna para filtrar el usuario fue seleccionada
        if (campoVacio($dato))
        {
            self::$alertas['error'][] = 'El dato de busqueda para filtrar registros es Obligatorio';
        }
        return self::$alertas;
    }
}



?>