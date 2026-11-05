<?php



use Model\Pedido_item;

use Model\Pedido_llevar;



function debuguear($variable) : string {

    echo "<pre>";

    var_dump($variable);

    echo "</pre>";

    exit;

}



// Escapa / Sanitizar el HTML

function s($html) : string {

    return htmlspecialchars((string) $html, ENT_QUOTES, 'UTF-8');

    return $s;

}



function validarORedireccionar(string $url ){

    // Validar URL por ID válido

    $id = $_GET['id'] ?? null;

    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id === null) {

        header("Location: {$url}");

    }

    return $id;

}

    // Hashea el password

function hashNewPassword($password)

{

    $password = password_hash($password, PASSWORD_BCRYPT);

    return $password;

} 



// Retorna true si el campo esta vacio, si se comple alguna de las 3 condiciones

function campoVacio($valor)
{
    // Si no es array, aplicar las condiciones originales

    return $valor === null || $valor === '' || $valor === false;

}


function arregloVacio($valor)
{
    // Si es un array, verificar si no tiene ningún dato útil
    if(is_array($valor))
    {
        // Si el array está literalmente vacío (sin elementos)
        if(count($valor) === 0)
        {
            return true;
        }

        // Recorrer el array para ver si algún elemento NO está vacío

        foreach($valor as $item)
        {
            // Si encuentra un string no vacío o cualquier valor no vacío
            if(is_string($item) && trim($item) !== '')
            {
                return false; // Tiene al menos un mensaje válido
            }

            if(!is_string($item) && !empty($item))
            {
                return false; // Tiene un valor no string y no vacío
            }
        }
        // Si llegó aquí, todos los elementos están vacíos
        return true;
    }
}


// Valida tipo de contenido 

function validarTipoContenido($tipo)

{

    $tipos = ['producto', 'pedido', 'personal', 'rol_personal'];



    return in_array($tipo, $tipos);

}



// Función que revisa que el usuario este autenticado

function isAuth() : void {

    if(!isset($_SESSION['login'])) {

        header('Location: /');

    }

}



// Verificar el rol



// Administrador

function es_admin(){

    return isset($_SESSION['rol']) && $_SESSION['rol'] === 0;

}



// Estudiante

function es_student(){

    return isset($_SESSION['rol']) && $_SESSION['rol'] === 1;

}



// Jefe de Carrera

function es_career_manager(){

    return isset($_SESSION['rol']) && $_SESSION['rol'] === 2;

}



// Coordinador de Actividades Extraescolares

function es_extracurricular_activities_coordinator(){

    return isset($_SESSION['rol']) && $_SESSION['rol'] === 3;

}



    // Instructor de actividades extraescolares

function es_extracurricular_activities_instructor(){

    return isset($_SESSION['rol']) && $_SESSION['rol'] === 4;

}



// Coordinador de Créditos Complementarios

function es_complementary_credits_coordinator(){

    return isset($_SESSION['rol']) && $_SESSION['rol'] === 5;

}



    // Supervisor de creditos complementarios

function es_complementary_credits_supervisor(){

    return isset($_SESSION['rol']) && $_SESSION['rol'] === 6;

}

// Coordinador de Residencias Profesionales

function es_professional_residency_coordinator(){

    return isset($_SESSION['rol']) && $_SESSION['rol'] === 7;

}

// Asesor interno de residencia profesional

function es_internal_professional_residency_advisor(){

    return isset($_SESSION['rol']) && $_SESSION['rol'] === 8;

}

// Asesor externo de residencia profesional

function es_external_professional_residency_advisor(){

    return isset($_SESSION['rol']) && $_SESSION['rol'] === 9;

}

// Coordinador de lenguas extranjeras

function es_foreign_languages_coordinator(){

    return isset($_SESSION['rol']) && $_SESSION['rol'] === 10;

}

// Docente de ingles

function es_english_teacher(){

    return isset($_SESSION['rol']) && $_SESSION['rol'] === 11;

}

// Responsable de Caja

function es_cashier_responsible(){

    return isset($_SESSION['rol']) && $_SESSION['rol'] === 12;

}

// Operador de caja

function es_cashier_operator(){

    return isset($_SESSION['rol']) && $_SESSION['rol'] === 13;

}

// Coordinador de titulaciones

function es_degree_programs_coordinator(){

    return isset($_SESSION['rol']) && $_SESSION['rol'] === 14;

}







// Muestra los mensajes 

function mostrarCodigo($codigo) {

    $mensaje = '';



    switch ($codigo) {

        case 1:

            $mensaje =  "Creado Correctamente";

            break;

        case 2:

            $mensaje =  "Actualizado Correctamente";

            break;

        case 3:

            $mensaje =  "Eliminado Correctamente";

            break;  

        case 4:

            $mensaje =  "Registro(s) Encontrado(s)";

            break;     

        case 5:

            $mensaje =  "No es posible modificar un ID cuando se actualiza";

            break;                  

        default: 

            $mensaje = false;

            break;      

    }

    return $mensaje;

}




