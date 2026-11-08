<?php if ($categorias):  ?>
    <div class="contenedor-scroll-horizontal">
        <table class="registros">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de la categoria</th>

                    </tr>
                </thead>
                <tbody > <!-- Mostrar los resultados -->
                    <?php foreach( $categorias as $categoria): ?>
                    <tr>
                        <td> <?php echo $categoria->id;?> </td>
                        <td class="nombre_producto"> <?php echo $categoria->nombre_categoria;?> </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
        </table>
    </div>
<?php endif;?>