<?php

$mensaje = "";



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $subdominio = trim($_POST['subdominio']);

    $subdominio = preg_replace('/[^a-z0-9\-]/', '', strtolower($subdominio));

    $rootdomain = "saliditas.com.mx";



    if (!empty($subdominio)) {

        // Ruta de la carpeta física donde vivirá el subdominio

        $carpeta_destino = __DIR__ . '/' . $subdominio;



        if (is_dir($carpeta_destino)) {

            $mensaje = "<p style='color:orange;'>El subdominio '{$subdominio}' ya existe.</p>";

        } else {

            // Crear la carpeta física automáticamente

            if (mkdir($carpeta_destino, 0755, true)) {

                // Crear un archivo index.php base dentro del subdominio nuevo

                $contenido = "<?php\n";

                $contenido .= "echo '<h1>Bienvenido al subdominio: " . htmlspecialchars($subdominio) . "</h1>';\n";

                $contenido .= "?>";

                

                file_put_contents($carpeta_destino . '/index.php', $contenido);



                $mensaje = "<p style='color:green;'>¡Éxito! El subdominio <strong>{$subdominio}.{$rootdomain}</strong> fue creado correctamente.</p>";

            } else {

                $mensaje = "<p style='color:red;'>No se pudo crear la carpeta en el servidor.</p>";

            }

        }

    } else {

        $mensaje = "<p style='color:orange;'>Escribe un nombre válido.</p>";

    }

}

?>



<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Creador de Subdominios</title>

    <style>

        body { font-family: Arial, sans-serif; margin: 50px; background: #f4f4f9; }

        .box { background: white; padding: 20px; border-radius: 8px; max-width: 400px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }

        input[type="text"] { width: 100%; padding: 10px; margin: 10px 0; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }

        button { background: #28a745; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; width: 100%; }

        button:hover { background: #218838; }

    </style>

</head>

<body>



<div class="box">

    <h2>Crear Subdominio</h2>

    <form method="POST">

        <label for="subdominio">Nombre del subdominio:</label>

        <input type="text" id="subdominio" name="subdominio" placeholder="ej. tienda, clientes" required>

        <button type="submit">Crear Subdominio</button>

    </form>

    

    <?php echo $mensaje; ?>

</div>



</body>

</html>