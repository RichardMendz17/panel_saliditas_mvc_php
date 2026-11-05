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

    <?php } ?>


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

<!-- Abre informacion_periodo -->
     <?php 
        if (isset($periodos) && isset($periodo_seleccionado)) 
        {
    ?>
            <div class="informacion_periodo">
                <?php 
                    foreach ($periodos as $periodo) 
                    {
                        if ($periodo->id == $periodo_seleccionado) 
                        {
                ?>
                            <div class="contenedor-scroll-horizontal">
                                <table class="registros">
                                        <thead>
                                            <tr>
                                                <th>Estado del Periodo:</th>
                                                <th>Tipo de Periodo</th>
                                                <th>Fecha de Inicio del periodo:</th>
                                                <th>Fecha de Cierre del periodo:</th>
                                                <?php 
                                                    if (isset($mostrar_Informacion_de_Inscripcion_al_Periodo)) 
                                                    {
                                                ?>
                                                    <th>Fecha de Limite de Inscripcion del periodo:</th>
                                                    <th>Cantidad máxima de cursos que puedes inscribir este periodo.</th>
                                                <?php    
                                                    } 
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody > <!-- Mostrar los resultados -->
                                            <tr>
                                                <td> <?php echo $periodo->estado; ?> </td>
                                                <td> <?php echo $periodo->tipo_periodo ?? ' No asignado'; ?> </td>
                                                <td> <?php echo $periodo->fecha_inicio; ?> </td>
                                                <td> <?php echo $periodo->fecha_fin; ?> </td>
                                                <?php
                                                    if (isset($mostrar_Informacion_de_Inscripcion_al_Periodo)) 
                                                    {
                                                ?>
                                                    <td> <?php echo $configuracion_modulo_periodo->fecha_limite_inscripcion ?? 'No asignado'; ?> </td>
                                                    <td> <?php echo $configuracion_modulo_periodo->maximo_cursos_por_periodo ?? ' No asignado'; ?> </td>
                                                <?php
                                                    }
                                                ?>
                                            </tr>
                                        </tbody>
                                </table>
                            </div>
                <?php
                        }
                    }
                ?>
            </div>
    <?php
        }
    ?>
<!-- Cierra informacion_periodo  -->