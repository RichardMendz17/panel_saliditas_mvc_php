<?php 

namespace Model;
class Permisos extends ActiveRecord 
{

    /* Actualmente modelo funciona para establecer a que botones y tipo de informacion */
    /* es posible visualizar dependiendo del rol*/
    /* Sin embargo no limita el acceso a algun url del sistema como lo realiza el archivo router.php*/
    /* El archivo router.php tiene un apartado para establecer las urls a las que se tiene accedo departe del rol */

    private static $permisos = [

        'Administrador' => [
            'ver_informacion_inscripcion_periodo',

            /*Permiso para crear, buscar tipo de curso */
            'crear_tipo_curso', 'buscar_tipo_curso',

            /* Permiso para el controlador de PersonalController */
            'personal_crear',

            /* Permiso para crear y buscar alumno */
            'crear_alumno', 'buscar_alumno',

            /*  Permiso para crear y buscar periodo */
            'crear_periodo', 'buscar_periodo',

            /*  Permiso para crear carrera y buscar carrera */
            'crear_carrera', 'buscar_carrera',

            /* Permiso para crear aula y buscar aula */
            'crear_aula', 'buscar_aula',

            /* Permiso para crear usuario y buscar usuario */
            'crear_usuario', 'buscar_usuario',

            /** Pemiso para crear rol a un usuario y buscar el rol del usuarios */
            'crear_rol_usuario', 'buscar_rol_usuario'
        ],

        'Alumno' => [
            'ver_informacion_inscripcion_periodo',

            //Modulo de referencias
            'crear_referencia',
            
            /*Corregir referencia*/
            'referencia_corregir'
        ],

        'Jefe de Carrera'=> [
            /*Vacio por el momento*/ 
        ],

        'Coordinador de Actividades Extraescolares'  => [

            /* Permisos para ver informacion de inscripcion por periodo*/
            'ver_informacion_inscripcion_periodo',

            /*Permisos para accede al CRUD de cursos de Actividades extraescolares */
            'crear_curso_actividades_extraescolares',

            /*Permiso para crear, buscar tipo de curso */
            'crear_tipo_curso', 'buscar_tipo_curso',

            /* Permiso para importar cursos */
            'importar_cursos'
        ],

        'Instructor de Actividades Extraescolares' => [
            /* Permisos para ver informacion de inscripcion por periodo*/
            'ver_informacion_inscripcion_periodo',
        ],

        'Coordinador de Créditos Complementarios' => [
            /* Ver informacion de inscripcion al periodo */
            'ver_informacion_inscripcion_periodo',

            /*Permisos para Crear curso de creditos complementarios */
            'crear_curso_creditos_complementarios',

            /*Permiso para crear, buscar, actualizar y eliminar tipo de curso */
            'crear_tipo_curso', 'buscar_tipo_curso'  
        ],
        
        'Supervisor de Créditos Complementarios' => [
            /* Permisos para ver informacion de inscripcion por periodo*/
            'ver_informacion_inscripcion_periodo',
        ],

        'Coordinador de Residencias Profesionales'=> [
            /*Vacio por el momento*/ 
        ],

        'Asesor interno de Residencia Profesional'=> [
            /*Vacio por el momento*/ 
        ],

        'Asesor externo de Residencia Profesional'=> [
            /*Vacio por el momento*/ 
        ],

        'Coordinador de Lenguas Extranjeras' => [
            //'ver_informacion_basica_periodo',
            'ver_informacion_inscripcion_periodo',
        ],

        'Docente de Lenguas Extranjeras' => [
            //'ver_informacion_basica_periodo',
            'ver_informacion_inscripcion_periodo',
        ],

        'Responsable de Caja'=> [
            /* Crear, buscar y revisar referencias pendientes */
            'crear_referencia' , 'buscar_referencia',
            'referencias_pendientes', 'referencias',
            
            /* Referencias por corregir */
            'referencias_por_corregir',

            /* Crear y buscar concepto */
            'crear_concepto','buscar_concepto',

            /* Ver mas detalles de refencia */
            'referencia_ver_detalles',
            
            /* Referencia Atender */
            'referencia_atender'

        ],

        'Operador de Caja'=> [
            /* Crear, buscar y revisar referencias pendientes */
            'crear_referencia' , 'buscar_referencia',
            'referencias_pendientes', 'referencias',
            
            /* Ver mas detalles de refencia */
            'referencia_ver_detalles',
            
            /* Referencia Atender */
            'referencia_atender'
        ],

        'Coordinador de titulaciones'=> [
            /*Vacio por el momento*/ 
        ]
    ];

    public static function tienePermiso($nombre_rol, $permiso)
    {
        return isset(self::$permisos[$nombre_rol]) && in_array($permiso, self::$permisos[$nombre_rol]);
    }
}
?>