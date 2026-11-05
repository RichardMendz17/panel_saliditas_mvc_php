<!-- <div class="barra-mobile">
    <div class="imagen-escuela-mobile">
        <img  src="/build/img/itssnalogo.avif" alt="Logotipo de Empresa">
    </div>
    <div class="menu">
        <img id="mobile-menu" src="build/img/menu.svg" alt="Imagen Menú">
    </div>
</div> -->

<div class="barra">
    <div class="barra-informacion">
        <div class="informacion_pagina">
            <img src="/build/img/logo.webp" class="logo" alt="Quesagina's" onerror="this.src='https://placehold.co/80x40?text=Q'">
            <span class="titulo"><?php echo $titulo_pagina; ?></span>
        </div>
        <div class="opciones_usuario">
            <p>Bienvenido: <span><?php echo $_SESSION['nombre'] ?? 'Invitado'; ?></span> </p>
            <p>Cargo: <span><?php echo $_SESSION['nombre_rol'] ?></span></p>
            <a href="/logout" class="boton-rojo-block-mini">Cerrar Sesión</a>
        </div>
    </div>

    <nav class="navegacion">
            <a 
            href="/dashboard_admin" 
            class="
            <?php echo ($sidebar_nav ==='dashboard_admin') ? 'activo' : ''; ?>
            boton-naranja-oscuro-mini">Cocina</a>
            <a 
            href="/dashboard_admin_productos" 
            class="
            <?php echo ($sidebar_nav ==='dashboard_admin_productos') ? 'activo' : ''; ?>
            boton-naranja-oscuro-mini">Administrar Productos</a>
            <a 
            href="/meseros_panel" 
            class="
            <?php echo ($sidebar_nav ==='panel_meseros') ? 'activo' : ''; ?>
            boton-naranja-oscuro-mini">Meseros Panel</a>
    </nav>
</div>