<?php
namespace Model;

use Model\Permisos;

class Boton extends ActiveRecord
{
    /*
    |--------------------------------------------------------------------------
    | PROPIEDADES DE LA CLASE
    |--------------------------------------------------------------------------
    |
    | Aquí declaramos atributos públicos del objeto.
    |
    | La palabra "string" antes del nombre es TIPADO DE PROPIEDADES.
    |
    | Esto significa:
    | - PHP espera que esa propiedad almacene texto
    | - ayuda a evitar errores
    | - mejora el autocompletado del IDE
    |
    | Esta característica se conoce como:
    |
    | → Typed Properties (Propiedades Tipadas)
    |
    | Disponible desde PHP 7.4
    |
    */

    public string $texto;
    public string $class;
    public string $href;
    public string $extras;

    /* Acontontinuacion vamos a definir variables que condicionan el renderizado de botones*/
    public $permisoRequerido;
    public $rolesRequeridos = [];

    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTOR
    |--------------------------------------------------------------------------
    |
    | El constructor es un método especial que se ejecuta
    | automáticamente cuando usamos:
    |
    | new Boton(...)
    |
    | Esta sintaxis:
    |
    | string $texto
    |
    | se llama:
    |
    | → Type Hinting o Parameter Type Declaration
    |
    | Significa que PHP obliga a que el parámetro sea un string.
    |
    | Ejemplo válido:
    |
    | new Boton("Crear", "btn", "/crear")
    |
    | Ejemplo inválido:
    |
    | new Boton(123, [], false)
    |
    | porque esos valores NO son strings.
    |
    | También tenemos:
    |
    | string $extras = ''
    |
    | Eso se llama:
    |
    | → Parámetro opcional con valor por defecto
    |
    | Si no se envía el cuarto argumento,
    | PHP usará '' automáticamente.
    |
    */

    public function __construct(
        string $texto,
        string $class,
        string $href,
        string $extras = '',
        $rolesRequeridos  = null,
        $permisoRequerido = null
    )
    {

        /*
        |--------------------------------------------------------------------------
        | $this
        |--------------------------------------------------------------------------
        |
        | $this representa al objeto actual.
        |
        | Estamos guardando los datos recibidos
        | dentro de las propiedades del objeto.
        |
        */

        $this->texto = $texto;
        $this->class = $class;
        $this->href = $href;
        $this->extras = $extras;
        /* Variables condicionales */
        $this->permisoRequerido = $permisoRequerido;

       // Si es array de roles o un solo rol
        if (is_array($rolesRequeridos)) 
        {
            $this->rolesRequeridos = $rolesRequeridos;
        } 
        elseif ($rolesRequeridos)
        {
            $this->rolesRequeridos = [$rolesRequeridos];
        }
        
        $this->permisoRequerido = $permisoRequerido;
    }

    // Método helper estático para construir botones desde configuración
    public static function construirDesdeConfiguracion($configBotones, $mapaContextos, $contexto = 'index')
    {
        $botones = [];
        
        if (isset($mapaContextos[$contexto])) 
        {
            foreach ($mapaContextos[$contexto] as $claveBoton) 
            {
                if (isset($configBotones[$claveBoton])) 
                {
                    $config = $configBotones[$claveBoton];
                    $botones[] = new self(
                        $config['titulo'],
                        $config['clases'],
                        $config['href'],
                        $config['extras'] ?? '',
                        $config['roles'] ?? null,
                        $config['permiso'] ?? null
                    );
                }
            }
        }
        
        return $botones;
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODO RENDER
    |--------------------------------------------------------------------------
    |
    | Un método es una función que pertenece a una clase.
    |
    | Esta sintaxis:
    |
    | : string
    |
    | se llama:
    |
    | → Return Type Declaration
    |
    | o tipado del valor de retorno.
    |
    | Significa que este método DEBE devolver un string.
    |
    | Si devolviera otra cosa:
    |
    | return 123;
    |
    | PHP generaría un error.
    |
    | Disponible desde PHP 7.
    |
    */

    public function renderizar($nombre_rol = null)
    {

        // Verificar permisos si se requiere
        if ($this->permisoRequerido && $nombre_rol) {
            if (!Permisos::tienePermiso($nombre_rol, $this->permisoRequerido)) {
                return ''; // No renderizar si no tiene permiso
            }
        }

        /*
        |--------------------------------------------------------------------------
        | INTERPOLACIÓN DE VARIABLES
        |--------------------------------------------------------------------------
        |
        | Dentro de comillas dobles:
        |
        | "{$this->texto}"
        |
        | PHP reemplaza automáticamente el valor.
        |
        | Esto se llama:
        |
        | → String Interpolation
        |
        */

        return "
            <a href='{$this->href}' class='{$this->class}'>
                {$this->texto}
                {$this->extras}
            </a>
        ";
    }

   // Método para verificar si el usuario puede ver el botón
    public function puedeMostrar($nombre_rol) 
    {
        // Verificar roles si se especificaron
        if (!empty($this->rolesRequeridos)) 
        {
            if (!in_array($nombre_rol, $this->rolesRequeridos)) 
            {
                return false;
            }
        }
        
        // Verificar permiso si se especificó
        if ($this->permisoRequerido)
        {
            return Permisos::tienePermiso($nombre_rol, $this->permisoRequerido);
        }
        
        return true;
    }
}