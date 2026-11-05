<aside class="sidebar">
	<div class="contenedor-sidebar">
		<div class="imagen-escuela">
				<a href="dashboard">
				<img  src="/build/img/logo.webp" alt="Logotipo de Empresa">
				</a>
		</div>
		<div class="cerrar-menu">
				<img id="cerrar-menu" src="build/img/cerrar.svg" alt="Imagen Cerrar menu">
		</div>
    </div>
	<div class="contenedor-scroll-vertical">
		<nav class="sidebar-nav">
				<a class="<?php echo ($sidebar_nav === 'Productos') ? 'activo' : ''; ?>" href="/personal">Productos</a>
				<a class="<?php echo ($sidebar_nav === 'Categoria') ? 'activo' : ''; ?>" href="/alumnos">Categorias</a>
				<a class="<?php echo ($sidebar_nav ==='Perfil') ? 'activo' : ''; ?>" href="/perfil">Perfil</a>
		</nav>
	</div>
	<div class="cerrar-sesion-mobile">
			<a href="/logout" class="cerrar-sesion">Cerrar Sesión</a>
	</div>
</aside>