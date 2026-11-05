<?php
namespace Model;
class ActiveRecord {

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];
    protected static $aliasColumnasDB = [];

    // Cache de tipos de columnas
    private static $tiposColumnasCache = [];    


    // Alertas y Mensajes
    protected static $alertas = [];
    //valida que un campo este totalmente vacio


    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }
    // Validación
    public static function getAlertas() {
        return static::$alertas;
    }

    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!campoVacio($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }

        return $resultado;
    }

    public static function obtenerColumnas() {
        return static::$columnasDB;
    }

    public static function obtenerTiposColumnas()
    {
        $tabla = static::$tabla;
        
        // Si ya está en caché, devolverlo
        if (isset(self::$tiposColumnasCache[$tabla])) {
            return self::$tiposColumnasCache[$tabla];
        }
        
        $query = "DESCRIBE " . $tabla;
        $resultado = self::$db->query($query);
        
        $tipos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $campo = $fila['Field'];
            $tipoDB = $fila['Type'];
            $tipos[$campo] = self::determinarTipoPHP($tipoDB);
        }
        
        // Guardar en caché
        self::$tiposColumnasCache[$tabla] = $tipos;
        return $tipos;
    }

    // Determinar el tipo PHP según el tipo MySQL
    private static function determinarTipoPHP($tipoDB)
    {
        // Tipos enteros
        if (strpos($tipoDB, 'int') !== false || 
            strpos($tipoDB, 'tinyint') !== false ||
            strpos($tipoDB, 'smallint') !== false ||
            strpos($tipoDB, 'mediumint') !== false ||
            strpos($tipoDB, 'bigint') !== false) {
            
            // Si es tinyint(1) es booleano
            if (strpos($tipoDB, 'tinyint(1)') !== false) {
                return 'boolean';
            }
            return 'integer';
        }
        
        // Tipos decimales
        if (strpos($tipoDB, 'decimal') !== false ||
            strpos($tipoDB, 'float') !== false ||
            strpos($tipoDB, 'double') !== false ||
            strpos($tipoDB, 'real') !== false) {
            return 'float';
        }
        
        // Tipos de fecha/hora
        if (strpos($tipoDB, 'date') !== false ||
            strpos($tipoDB, 'time') !== false ||
            strpos($tipoDB, 'datetime') !== false ||
            strpos($tipoDB, 'timestamp') !== false ||
            strpos($tipoDB, 'year') !== false) {
            return 'datetime';
        }
        
        // Tipos JSON
        if (strpos($tipoDB, 'json') !== false) {
            return 'array';
        }
        
        // Todo lo demás es string
        return 'string';
    }

    // Devuelve las alias para consultas personalizadas
    public static function obtenerColumnasAlias()
    {
        return static::$aliasColumnasDB;
    }

    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Convertir valor según el tipo
    private static function castValue($value, $tipo)
    {
        if ($value === null) {
            return null;
        }
        
        switch ($tipo) {
            case 'integer':
                return (int) $value;
                
            case 'float':
                return (float) $value;
                
            case 'boolean':
                return (bool) $value;
                
            case 'datetime':
                return $value; // Puedes formatearlo si quieres
                
            case 'array':
                return json_decode($value, true);
                
            case 'string':
            default:
                return (string) $value;
        }
    }
    // Busca un registro por su id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Obtener Registro
    public static function get($limite)
    {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT {$limite} ORDER BY id DESC";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Paginar los registros
    public static function paginar($por_pagina, $offset){
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT {$por_pagina} OFFSET {$offset} ";
        $resultado = self::consultarSQL($query);
        return $resultado;  
    }

    // Paginar los registros con mas atributos
    public static function whereAllPaginado($columna, $valor, $limite, $offset)
    {
        $columna = self::$db->escape_string($columna);
        $valor = self::$db->escape_string($valor);
        $limite = (int)$limite;
        $offset = (int)$offset;

        $query = "SELECT * FROM ". static::$tabla ." WHERE $columna = '$valor' LIMIT $limite OFFSET $offset";
        $resultado = self::SQL($query);
        return $resultado;
    }

    // Busqueda Where con Columna
    // Solo devuelve el primer registro encontrado
    public static function where($columna, $valor)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = '{$valor}' ";
        $resultado = self::consultarSQL($query);
        //debuguear($query);
        return array_shift( $resultado ) ; 
    }
    
    //Buscar un registro por multiples columnas
    public static function buscarPorMultiples(array $columnas, array $valores)
    {
        if (count($columnas) !== count($valores)) return null;

        $condiciones = [];
        foreach ($columnas as $index => $columna) {
            $valor = static::$db->escape_string($valores[$index]);
            $condiciones[] = "{$columna} = '{$valor}'";
        }

        $sql = "SELECT * FROM " . static::$tabla . " WHERE " . implode(" AND ", $condiciones) . " LIMIT 1";
        $resultado = static::consultarSQL($sql);
        return array_shift($resultado); // Devuelve el primer objeto encontrado o null
    }

    //Devuelve la cantidad total de los registros encontrados
    public static function whereAllCount($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = '{$valor}'";
        $resultado = self::consultarSQL($query);
        return (string) count($resultado); // Convertimos el número a string
    }

    // Traer la cantidad total de registros contados
    public static function total()
    {
        $query = "SELECT COUNT(*) FROM " . static::$tabla;
        $resultado = self::$db->query($query);
        $total = $resultado->fetch_array();
        return array_shift($total);
    }

    // Trae la cantidad total de registros con filtros
    public static function contarConFiltros($query) 
    {
        // Convertimos la consulta SELECT en una consulta COUNT
        $query = preg_replace('/SELECT.*?FROM/i', 'SELECT COUNT(*) as total FROM', $query, 1);
        
        // Eliminamos ORDER BY, LIMIT y OFFSET que no son necesarios para el conteo
        $query = preg_replace('/ORDER BY.*/i', '', $query);
        $query = preg_replace('/LIMIT \d+/i', '', $query);
        $query = preg_replace('/OFFSET \d+/i', '', $query);
        $resultado = self::SQL($query);
        return $resultado[0]->total ?? 0;
    }


    // Busca todos los registros que pertenecen a un id 
    public static function belongsTo($columna, $valor)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = '{$valor}'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca TODOS los registros que coinciden con múltiples columnas y valores
    public static function belongsToMultiples(array $columnas, array $valores)
    {
        if (count($columnas) !== count($valores)) return [];
        
        $condiciones = [];
        foreach ($columnas as $index => $columna) {
            $valor = self::$db->escape_string($valores[$index]);
            $condiciones[] = "{$columna} = '{$valor}'";
        }
        
        $sql = "SELECT * FROM " . static::$tabla . " WHERE " . implode(" AND ", $condiciones);
        $resultado = self::consultarSQL($sql);
        return $resultado; // Devuelve TODOS los objetos encontrados (array)
    }

    // SQL para Consultas Avanzadas que retorna un array de objetos
    public static function SQL($consulta)
    {
        $query = $consulta;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // SQLContar para Consultas Avanzadas.
    public static function SQLContar($consulta)
    {
        $resultado = self::consultarSQL($consulta); // Esto devuelve un arreglo de objetos
        return (string) count($resultado); // Convertimos el número a string
    }

    // unicoSQL para Consultas Avanzadas. sin devolver un objeto
    public static function unicoSQL($consulta)
    {
        $query = $consulta;
        $resultado = self::$db->query($query);
        return $resultado;
    }    
    
    // Consultar por un registro y obtener un objeto para no tener que ciclar
    public static function obtenerUnico($query)
    {
        $resultados = self::consultarSQL($query);
        return $resultados[0] ?? null;
    }

    // Método para crear objeto con tipos correctos
    protected static function crearObjeto($registro)
    {
        $objeto = new static;
        $tipos = static::obtenerTiposColumnas();
        
        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $tipo = $tipos[$key] ?? 'string';
                $objeto->$key = self::castValue($value, $tipo);
            }
        }
        return $objeto;
    }

    // crea un nuevo registro
    public function crear()
    {
        // try 
        // {
            $atributos = $this->sanitizarAtributos();
            
            $columnas = implode(', ', array_keys($atributos));
            $valores = implode(', ', array_map(function($valor) {
                return  is_null($valor) ? 'NULL' : "'" . $valor . "'";
            }, array_values($atributos)));

            $query = "INSERT INTO " . static::$tabla . " ($columnas) VALUES ($valores)";
            //debuguear($query);
            $resultado = self::$db->query($query);

            // Si la consulta falla, devolver el error de MySQL
            if ($resultado === false)
            {
                return [
                    'resultado' => false,
                    'error' => self::$db->error,
                    'codigo' => self::$db->errno,
                    'query' => $query // Opcional: para depuración
                ];
            }
            return [
                'resultado' => $resultado ? true : false,
                'id' => $resultado ? self::$db->insert_id : self::$db->error
            ];

            // return [
            //     'resultado' => $resultado ,
            //     'id' => self::$db->insert_id
            // ]; 
        //  }

        // catch (\mysqli_sql_exception $e)
        // {
        //     return false;
        //     //Se aplico un try catch porque en ocasiones no se crea el nuevo registro
        // }
    }
    
    public function actualizar()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach($atributos as $key => $value)
        {
            if ($value === null)
            {
                $valores[] = "{$key}=null";            
            } else 
                {
                    $valores[] = "{$key}='{$value}'";
                }

        }

        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(" ,  ", $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 
        $resultado = self::$db->query($query);
        return [
        'resultado' => $resultado,
        'id' => $this->id 
        ];
    }

    // Eliminar un registro - Toma el ID de Active Record
    public function eliminar()
    {
        try
        {
            $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        
            $resultado = self::$db->query($query);
            return $resultado;
            // return [
            //     'resultado' => $resultado ? true : false,
            //     'id' => $resultado ? self::$db->insert_id : $query
            // ]; 
        } 
        catch (\mysqli_sql_exception $e)
        {
            return false;
            //Se aplico un try catch porque algunas fk de tablas tienen resctriction en ambas action
        }       
    }

    public static function consultarSQL($query)
    {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc())
        {
            $array[] = static::crearObjeto($registro);
        }
        // liberar la memoria
        $resultado->free();
        // retornar los resultados
        return $array;
    }

    // Identificar y unir los atributos de la BD
    public function atributos()
    {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id' && !$this instanceof Alumno && !$this instanceof Personal) continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos() 
    {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            if ($value === null) {
                $sanitizado[$key] = NULL; // sin comillas
            } else {
                $sanitizado[$key] = self::$db->escape_string($value); // solo escape
            }
        }

        return $sanitizado;
    }

    public function sincronizar($args=[])
    { 
        foreach($args as $key => $value)
        {
            if(property_exists($this, $key) && !is_null($value))
            {
                $this->$key = $value;
            }
        }
    }

    /**
     * Obtiene un solo valor de la base de datos (ej: SUM, COUNT, MAX, etc.)
     * 
     * @param string $consulta La consulta SQL
     * @return mixed El valor obtenido o null si no hay resultados
     */
    public static function obtenerValor($consulta, $default = 0)
    {
        $resultado = self::consultarSQL($consulta);
        
        // Si no hay resultados o está vacío
        if (empty($resultado) || !isset($resultado[0]))
        {
            return $default;
        }
        
        // Obtener el primer objeto y extraer su primer valor
        $primerObjeto = $resultado[0];
        $propiedades = get_object_vars($primerObjeto);
        $primerValor = reset($propiedades);
        
        return $primerValor ?? $default;
    }

    public static function obtenerValorFormateado($consulta, $decimales = 2)
    {
        $valor = self::obtenerValor($consulta);
        return number_format((float) $valor, $decimales);
    }
    
}