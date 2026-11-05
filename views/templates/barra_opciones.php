<!-- Abre barra de opciones -->
<div class="barra--opciones">

    <?php   
        if (isset($botones)) 
        {
    ?>
            <div class="barra-opciones__botones">
                <?php
                    foreach($botones as $boton):
                        if ($boton->puedeMostrar($nombre_rol)): 
                ?>
                            <?php echo $boton->renderizar(); ?>
                <?php
                        endif; 
                    endforeach; 
                ?>
            </div>
    <?php
        } 
    ?>
    <!-- Abre paginacion -->
    <?php 
        if (isset($paginacion) && !campoVacio($paginacion)) 
        {
    ?>
            <div class="barra-opciones__paginacion">
                <?php echo $paginacion ?? null; ?>
            </div>
    <?php
        }
    ?>
</div>
<!-- Cierra barra de opciones -->