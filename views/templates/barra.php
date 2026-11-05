<div class="barra-mobile">
    <div class="imagen-escuela-mobile">
        <img  src="/build/img/logo.webp" alt="Logotipo de Empresa">
    </div>
    <div class="menu">
        <img id="mobile-menu" src="build/img/menu.svg" alt="Imagen Menú">
    </div>

</div>
<div class="barra">
    <p>Hola: <span><?php  //echo $_SESSION['nombre'] ?></span></p>
    <p>Cargo: <span><?php //echo $_SESSION['nombre_rol'] ?? 'SELECCIONA UN ROL'; ?></span> <span></span></p>
    <a href="/logout" class="cerrar-sesion">Cerrar Sesion</a>
</div>