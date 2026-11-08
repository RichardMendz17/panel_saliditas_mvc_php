<?php if ($productos):  ?>
    <div class="contenedor-scroll-horizontal">
        <table class="registros">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del producto</th>
                        <th>Imagen</th>
                        <th>Precio</th>
                        <th>Categoria</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody > <!-- Mostrar los resultados -->
                    <?php foreach( $productos as $producto): ?>
                    <tr>
                        <td> <?php echo $producto->id;?> </td>
                        <td class="nombre_producto"> <?php echo $producto->nombre;?> </td>
                        <td> <img src="/imagenes/<?php echo $producto->imagen; ?>" class="imagen-tabla"> </td>
                        <td class="nombre_producto"> <?php echo $producto->precio;?> </td>
                        <td class="nombre_producto"> <?php echo $producto->categoria;?> </td>
                        <td class="acciones-crud">
                            <a href="productos-actualizar?id=<?php echo s($producto->id); ?>" 
                                class="boton-amarillo-block">Actualizar</a>
                            <form method="POST" action="productos-eliminar" class="form-eliminar">
                                <input type="hidden" name="id" value="<?php echo s($producto->id); ?>">
                                <input type="hidden" name="tipo" value="producto">
                                <input type="submit" class="boton-rojo-block" value="Eliminar">
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
        </table>
    </div>
<?php endif;?>

<div class="listado-header">
    <div class="columna">Id</div>
    <div class="columna">Nombre</div>
    <div class="columna">Imagen</div>
    <div class="columna">Categoria</div>
    <div class="columna">Estado</div>
    <div class="columna">Opciones</div>
</div>
<?php foreach( $productos as $producto): ?>
<li class="listado-item">
    <p> <?php echo $producto->id;?> </p>
    <p class="nombre_producto"> <?php echo $producto->nombre;?> </p>
    <p> <img src="/imagenes/<?php echo $producto->imagen; ?>" class="imagen-tabla"> </p>
    <p class="nombre_producto"> <?php echo $producto->precio;?> </p>
    <p class="nombre_producto"> <?php echo $producto->categoria;?> </p>
    <div class="acciones-crud">
        <a href="productos-actualizar?id=<?php echo s($producto->id); ?>" 
            class="boton-amarillo-inline">Actualizar</a>
        <form method="POST" action="productos-eliminar" class="form-eliminar">
            <input type="hidden" name="id" value="<?php echo s($producto->id); ?>">
            <input type="hidden" name="tipo" value="producto">
            <input type="submit" class="boton-rojo-inline" value="Eliminar">
        </form>
</div>
</li>
<?php endforeach; ?>