<?php  include_once __DIR__ . '/header-productos.php'; ?>
<h1 class="nombre-pagina">Nuevo Producto</h1>
<p class="descripcion-pagina">Crea un nuevo producto | Rellena el formulario</p>

<div class="contenedor-sm">

    <?php   include_once __DIR__ . '/../templates/alertas.php';   ?>

    <form method="POST" class="formulario">

        <?php include_once __DIR__ . '/formulario.php'; ?>
        
        <input type="submit" class="boton-azul-flex" value="Guardar Producto">
    </form>

</div>

<?php  include_once __DIR__ . '/footer-productos.php'; ?>