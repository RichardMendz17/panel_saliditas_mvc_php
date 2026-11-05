<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> <?php echo $titulo_pagina ?? '' ?></title>

    <link rel="stylesheet" href="build/css/app.css">
   
    <link rel="icon" type="image/webp" href="build/img/logo.webp">

</head>

    <?php echo $contenido; ?>

    <?php echo $script ?? ''; ?>


</html>

