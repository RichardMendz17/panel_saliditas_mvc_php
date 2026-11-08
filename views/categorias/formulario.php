<div class="campo">
    <label for="nombre">Nombre del Producto</label>
    <input 
        type="text"
        id="nombre"
        placeholder="Nombre del Aula"
        name="producto[nombre]"
        value="<?php echo s($producto->nombre); ?>"
    />
</div>

<div class="campo">
    <label for="nombre">Categoria del producto</label>
    <input 
        type="text"
        id="nombre"
        placeholder="Nombre del Aula"
        name="producto[categoria]"
        value="<?php echo s($producto->categoria); ?>"
    />
</div>

<div class="campo">
    <label for="nombre">Precio del Producto</label>
    <input 
        type="text"
        id="nombre"
        placeholder="Nombre del Aula"
        name="producto[precio]"
        value="<?php echo s($producto->precio); ?>"
    />
</div>

<div class="campo">
    <label for="nombre">Imagen del Aula</label>
    <input 
        type="text"
        id="nombre"
        placeholder="Nombre del Aula"
        name="producto[imagen]"
        value="<?php echo s($producto->imagen); ?>"
    />
</div>

<div class="campo">
    <label for="nombre">Estado del producto</label>
    <input 
        type="text"
        id="nombre"
        placeholder="Nombre del Aula"
        name="producto[activo]"
        value="<?php echo s($producto->activo); ?>"
    />
</div>