<?php 

    namespace Model;
    class ProductoDetalles extends ActiveRecord 
    {
        protected static $tabla = 'productos';

        // Base de datos
        protected static  $columnasDB =
        [
            'id',           //int AI PK
            'nombre',       //varchar(100)
            'categoria',    //varchar(50)
            'precio',       //decimal(10,2)
            'imagen',       //varchar(255)
            'activo',       //tinyint(1)
        ];

        public $id;
        public $nombre;
        public $categoria;
        public $precio;
        public $imagen;
        public $activo;

        protected static $aliasColumnasDB = [
            'productos.id',
            'productos.nombre',
            'categorias.nombre_categoria',
            'productos.precio',
            'productos.imagen',
            'productos.activo',
        ];

        public function __construct($args = [])
        {
            $this->id = isset($args['id']) ? trim($args['id']) : null;
            $this->nombre = isset($args['nombre']) ? trim($args['nombre']) : '';
            $this->categoria = isset($args['categoria']) ? trim($args['categoria']) : '';
            $this->precio = isset($args['precio']) ? trim($args['precio']) : '';
            $this->imagen = isset($args['imagen']) ? trim($args['imagen']) : '';
            $this->activo = isset($args['activo']) ? trim($args['activo']) : '';
        } 

        public static function buscarConCarrera($columna, $valor, $registros_por_pagina = 10, $offset = 0) 
        {
            // Seguridad básica: solo permitir columnas conocidas
            $columnaPermitida = in_array($columna, static::obtenerColumnas()) ? $columna : null;
            if (!$columnaPermitida) return [];

            // Escapar el nombre de la columna para evitar ambigüedad
            $columnaSQL = "alumnos." . self::$db->real_escape_string($columna);

            // Escapar el valor
            $valorSQL = self::$db->real_escape_string($valor);

            // Construir consulta con JOIN + WHERE + paginación
            $query = "SELECT 
                        alumnos.id, 
                        alumnos.nombre_Alumno, 
                        alumnos.apellido_Paterno, 
                        alumnos.apellido_Materno, 
                        alumnos.modalidad, 
                        alumnos.condicion_academica, 
                        alumnos.estado_academico, 
                        alumnos.comentarios, 
                        alumnos.id_Carrera,
                        alumnos.genero,
                        carreras.nombre_Carrera 
                    FROM alumnos 
                    LEFT OUTER JOIN carreras ON alumnos.id_Carrera = carreras.id 
                    WHERE {$columnaSQL} LIKE '%{$valorSQL}%'
                    ORDER BY alumnos.id DESC 
                    LIMIT {$registros_por_pagina} OFFSET {$offset}";

            return self::consultarSQL($query);
        }

        public static function contarFiltrados($columna, $valor)
        {
            // Agregar espacio al inicio para evitar error de sintaxis

            $join = '';
            if (strpos($columna, 'carreras.') !== false) {
                $join = ' LEFT OUTER JOIN carreras ON alumnos.id_Carrera = carreras.id';
            }

            // Corregir columna si viene sin prefijo (opcional)
            if ($columna === 'nombre_Carrera') {
                $columna = 'carreras.nombre_Carrera';
                $join = ' LEFT OUTER JOIN carreras ON alumnos.id_Carrera = carreras.id';
            }

            $esNumerico = $columna === 'alumnos.id';
            $valorSanitizado = $esNumerico ? intval($valor) : addslashes($valor);
            $where = $esNumerico 
                ? "{$columna} = {$valorSanitizado}" 
                : "{$columna} LIKE '%{$valorSanitizado}%'";

            $query = "SELECT COUNT(*) as total 
                    FROM alumnos 
                    {$join}
                    WHERE {$where}";
            // Usar conexión directa
            $resultado = self::$db->query($query);
            $fila = $resultado->fetch_assoc();
            return $fila['total'] ?? 0;

        }

}
