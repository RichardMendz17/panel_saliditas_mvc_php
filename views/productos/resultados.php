

<div class="listado-header">
    <div class="columna">Id</div>
    <div class="columna">Nombre</div>
    <div class="columna">Imagen</div>
    <div class="columna">Categoria</div>
    <div class="columna">Estado</div>
    <div class="columna">Opciones</div>
</div>
<?php foreach( $productosDetalles as $producto): ?>
<li class="listado-item">
    <p class="id_producto"> <span>Id:</span> <?php echo $producto->id;?> </p>
    <p class="nombre_producto"> </span> <?php echo $producto->nombre;?> </p>
    <img src="/imagenes/<?php echo $producto->imagen; ?>" class="imagen_producto">
    <p class="precio_producto"> $<?php echo $producto->precio;?> </p>
    <p class="categoria_producto"> <span>Categoria:</span> <?php echo $producto->categoria;?> </p>
    <div class="acciones-crud opciones_producto">
        <a href="productos-actualizar?id=<?php echo s($producto->id); ?>" 
            class="boton-amarillo-block">Actualizar</a>
        <form method="POST" action="productos-eliminar" class="form-eliminar">
            <input type="hidden" name="id" value="<?php echo s($producto->id); ?>">
            <input type="hidden" name="tipo" value="producto">
            <input type="submit" class="boton-rojo-block" value="Eliminar">
        </form>
    </div>
</li>
<?php endforeach; ?>