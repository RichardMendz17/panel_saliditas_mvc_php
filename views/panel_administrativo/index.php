<style>

    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    body { font-family: 'Inter', sans-serif; }

    .no-scrollbar::-webkit-scrollbar { display: none; }

    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

</style>

<body class="bg-gray-50 text-gray-800 h-screen flex overflow-hidden">



    <!-- BARRA LATERAL (SIDEBAR) -->

    <aside class="hidden md:flex flex-col w-64 bg-white border-r border-gray-200 h-full z-20">

        <!-- Logo -->

        <div class="h-16 flex items-center px-6 border-b border-gray-100">

            <img src="build/img/logo.webp" alt="Logo CMS" class="h-8 object-contain">

        </div>



        <!-- Navegación -->

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">

            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-4">Principal</p>

            

            <!-- Opción Activa -->

            <a href="#" class="flex items-center gap-3 px-3 py-2 bg-orange-50 text-orange-600 rounded-lg font-medium transition">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>

                Inicio / Plantillas

            </a>

            

            <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-50 hover:text-orange-500 rounded-lg font-medium transition">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg>

                Métricas

            </a>



            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Crecimiento</p>



            <a href="#" class="flex items-center justify-between px-3 py-2 text-gray-600 hover:bg-gray-50 hover:text-orange-500 rounded-lg font-medium transition">

                <div class="flex items-center gap-3">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25h3a.75.75 0 01.75.75v7.5m-9-6h18" /></svg>

                    Tienda en Línea

                </div>

                <span class="text-[10px] bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full font-bold">PRO</span>

            </a>



            <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-50 hover:text-orange-500 rounded-lg font-medium transition">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" /></svg>

                Posicionamiento

            </a>



            <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-50 hover:text-orange-500 rounded-lg font-medium transition">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" /></svg>

                Cursos

            </a>



            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Ajustes</p>

            

            <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-50 hover:text-orange-500 rounded-lg font-medium transition">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>

                Perfil del Negocio

            </a>

            <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-50 hover:text-orange-500 rounded-lg font-medium transition">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>

                Configuración

            </a>

        </nav>



        <!-- Card de Usuario inferior -->

        <div class="p-4 border-t border-gray-100">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold">

                    CV

                </div>

                <div class="flex-1 min-w-0">

                    <p class="text-sm font-semibold text-gray-900 truncate">Cocina Viky</p>

                    <p class="text-xs text-gray-500 truncate">Plan Básico</p>

                </div>

            </div>

        </div>

    </aside>



    <!-- ÁREA PRINCIPAL -->

    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50 relative">

        

        <!-- Header Móvil (Solo visible en pantallas pequeñas) -->

        <header class="md:hidden flex items-center justify-between bg-white px-6 py-4 border-b border-gray-200">

            <img src="logo.webp" alt="Logo" class="h-6 object-contain">

            <button class="text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg></button>

        </header>



        <!-- Contenido scrolleable -->

        <div class="flex-1 overflow-y-auto p-6 md:p-10">

            

            <!-- Saludo y Métricas Rápidas -->

            <div class="mb-8">

                <h1 class="text-2xl font-bold text-gray-900">Hola, Cocina Viky 👋</h1>

                <p class="text-gray-500 mt-1">Aquí tienes un resumen del estado de tu menú hoy.</p>

            </div>



            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

                <!-- Métrica 1 -->

                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">

                    <div>

                        <p class="text-sm text-gray-500 font-medium mb-1">Visitas del QR hoy</p>

                        <h3 class="text-2xl font-bold text-gray-900">42</h3>

                    </div>

                    <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>

                    </div>

                </div>

                <!-- Métrica 2 -->

                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">

                    <div>

                        <p class="text-sm text-gray-500 font-medium mb-1">Platillo más visto</p>

                        <h3 class="text-lg font-bold text-gray-900 leading-tight">Enchiladas Suizas</h3>

                    </div>

                    <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" /></svg>

                    </div>

                </div>

                <!-- Botón Acción Directa -->

                <button class="bg-orange-500 hover:bg-orange-600 text-white p-5 rounded-xl shadow-sm flex flex-col justify-center items-center transition group">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 mb-2 group-hover:scale-110 transition-transform"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>

                    <span class="font-semibold">Editar Platillos y Precios</span>

                </button>

            </div>


            <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-x-4 gap-y-4 mb-2 lg:mb-0">

            <div class="flex items-center rounded-xl bg-orange-300 p-2 shadow-lg outline outline-black/5 dark:bg-slate-800 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10">
                <img class="size-10 shrink-0" src="build/img/restaurante.webp" alt="Restaurante logo" />
                <div>
                    <div class="text-base  text-black dark:text-white">Restaurante 1</div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Eslogan!</p>
                </div>
            </div>
            
            <div class="flex items-center rounded-xl bg-white p-2 shadow-lg outline outline-black/5 dark:bg-slate-800 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10">
                <img class="size-10 shrink-0" src="build/img/restaurante.webp" alt="Restaurante logo" />
                <div>
                    <div class="text-base  text-black dark:text-white">Restaurante 2</div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Eslogan!</p>
                </div>
            </div>

            
            <div class="flex items-center rounded-xl bg-white p-2 shadow-lg outline outline-black/5 dark:bg-slate-800 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10">
                <img class="size-10 shrink-0 my-2" src="build/img/restaurante.webp" alt="Restaurante logo" />
                <div>
                    <div class="text-base  text-black dark:text-white"> Restaurante 3</div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm"> Eslogan!</p>
                </div>
            </div>



            </div>

            <!-- Sección Plantillas -->

            <div class="mb-6 flex flex-col gap-y-4 lg:flex-row lg:items-center justify-between p-4 ">

                <h2 class="text-lg font-bold text-gray-900">Diseño de tu Menú <span>Restaurante 1</span></h2>

                <button class="p-3 flex bg-green-500 rounded justify-center text-center gap-4" id="crear_producto">
                    <svg width="20px" height="20px"  viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier"> 
                            <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
                            <path d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
                        </g>
                    </svg>
                    <p class="text-white font-bold text-sm">
                    Crea un nuevo producto
                    </p>
                </button>

                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg
                            class="h-5 w-5 text-gray-500"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M11 6C13.7614 6 16 8.23858 16 11M16.6588 16.6549L21 21M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </div>

                    <input
                        type="text"
                        placeholder="Buscar platillos..."
                        class="w-full rounded-lg border border-gray-300 py-2 pl-10 pr-3 text-sm outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-200"
                    />
                </div>

                <div class="relative" id="categorias">
                    <select
                        class="w-full appearance-none rounded-lg border border-gray-300 bg-white px-3 py-2 pr-10 text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-200"
                        id="categoriaProducto"

                    >
                        <option value="">Todos los productos</option>
                    </select>

                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                        <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="m7 10 5 5 5-5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>

            </div>



            <div class="grid xl:grid-cols-6 lg:grid-cols-4 grid-cols-2 gap-5 overflow-x-auto no-scrollbar pb-6 mb-4 " id="listado_productos_menu">
            </div>

            <!-- Banners de Upsell (Servicios adicionales) -->

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Banner Tienda -->

                <div class="bg-gray-900 rounded-xl p-6 relative overflow-hidden flex flex-col justify-between items-start">

                    <div class="absolute -right-6 -top-6 w-32 h-32 bg-orange-500 rounded-full opacity-20 blur-2xl"></div>

                    <div>

                        <span class="bg-orange-500 text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider mb-3 inline-block">Nuevo</span>

                        <h3 class="text-white font-bold text-xl mb-2">Activa tu Tienda en Línea</h3>

                        <p class="text-gray-400 text-sm mb-6 max-w-xs">Permite a tus clientes hacer pedidos a domicilio directamente desde tu menú y recibe notificaciones en WhatsApp.</p>

                    </div>

                    <button class="bg-white text-gray-900 font-semibold px-5 py-2.5 rounded-lg text-sm hover:bg-gray-100 transition">Conocer más</button>

                </div>



                <!-- Banner Posicionamiento -->

                <div class="bg-white border border-gray-200 rounded-xl p-6 flex flex-col justify-between items-start">

                    <div>

                        <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center mb-3">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" /></svg>

                        </div>

                        <h3 class="text-gray-900 font-bold text-lg mb-2">Aparece en Google Maps</h3>

                        <p class="text-gray-500 text-sm mb-6">Mejora el SEO local de tu restaurante y atrae comensales que buscan comida cerca de ti.</p>

                    </div>

                    <button class="text-orange-600 font-semibold text-sm hover:underline flex items-center gap-1">

                        Configurar posicionamiento &rarr;

                    </button>

                </div>

            </div>

        </div>

    </main>
    <?php  include_once __DIR__ . '/../templates/scripts.php' ?>
</body>
