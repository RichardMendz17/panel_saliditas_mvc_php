import { obtenerDatosMenu } from './obtener_datos_menu.js';

(function() 
{
    document.addEventListener('DOMContentLoaded', function()
    {
            let productos = [];

            let categorias = [];

            let arrayCategorias = [];

            obtenerProductos();

            //Obtener los productos
            async function obtenerProductos()
            {
                try
                {
                    const datos_menu = await obtenerDatosMenu();


                    productos = datos_menu.productosConCategoria; // Accedemos unicamente productosConCategoria

                    categorias = datos_menu.mapaCategorias;

                    arrayCategorias = datos_menu.categorias;

                    mostrarProductos();
                } 
                catch (error)
                {
                    console.log(error);
                }
            }

            // Mostrar productos
            function mostrarProductos(productos_actualizados = [], filtrar_productos)
            {
                let arrayProductos;

                limpiarProductos();        

                const contenedorProductos = document.querySelector('#listado_productos_menu');

                if (filtrar_productos === true)
                {
                    arrayProductos = productos_actualizados;

                    if (arrayProductos.length === 0)
                    {
                        const textoNoProductos = document.createElement('P');

                        textoNoProductos.textContent =
                            'No hay productos en el menú para esta categoría...';
                        textoNoProductos.classList.add('text-center', 'flex');
                        contenedorProductos.appendChild(textoNoProductos);

                        return;
                    }
                } 
                else
                {
                    // Si no se está filtrando, mostrar todos los productos
                    arrayProductos = productos;
                }


                // Si el menú completo no contiene productos
                if (arrayProductos.length === 0)
                {
                    const textoNoProductos = document.createElement('LI');

                    textoNoProductos.textContent = 'No hay productos en el menú...';

                    contenedorProductos.appendChild(textoNoProductos);
                    
                    return;
                }

                arrayProductos
                .slice()
                .sort((a, b) => a.nombre.localeCompare(b.nombre, 'es'))
                .forEach(producto => {
                    
                const contenedorProducto = document.createElement('DIV');
                contenedorProducto.dataset.id = producto.id;
                contenedorProducto.classList.add('flex', 'justify-center','flex-col', 'gap-3', 'min-w-[140px]', 'relative', 'group','border-2', 'border-orange-200', 'rounded', 'p-2'); // Clases para el contenedor principal

                // 1. Contenedor Imagen Producto
                const contenedorimagenProducto = document.createElement('DIV');
                contenedorimagenProducto.classList.add('w-[140px]', 'h-[200px]', 'mx-auto','bg-gray-50', 'border-2', 'border-orange-500', 'rounded', 'overflow-hidden', 'relative', 'group-hover:border-orange-500', 'group-hover:shadow-md', 'transition-all'); 
                // Clases específicas para el contenedor de imagen producto

                // 2. Imagen del producto
                const imagenProducto = document.createElement('IMG');
                imagenProducto.classList.add('w-full', 'h-full', 'object-cover', 'opacity-80', 'group-hover:opacity-100', 'transition-transform', 'duration-300', 'group-hover:scale-110');
                imagenProducto.alt = producto.nombre;
                imagenProducto.src = `build/img/${producto.imagen}`;            
                
                // 3. contenedor de editar el producto
                const contenedorEditarProducto = document.createElement('DIV');
                contenedorEditarProducto.classList.add('absolute', 'inset-0', 'bg-gradient-to-t', 'from-black/60', 'to-transparent',  'flex', 'items-end', 'p-2', 'justify-between');

                // 5. span de editar
                const spanEditar = document.createElement('P');
                spanEditar.textContent = `Editar`;
                spanEditar.setAttribute('id', 'Editar');
                spanEditar.classList.add('text-white', 'bg-gray-400','text-xs', 'font-bold', 'flex', 'items-center', 'gap-1', 'cursor-pointer', 'rounded', 'p-1', 'editar');
                spanEditar.dataset.id = producto.id;

                                // 5. span de editar
                const spanBorrar = document.createElement('P');
                spanBorrar.textContent = `Borrar`;
                spanBorrar.setAttribute('id', 'Borrar');
                spanBorrar.classList.add('text-red', 'bg-red-500','text-xs', 'font-bold', 'flex', 'flex-end', 'items-center', 'gap-1', 'cursor-pointer','rounded', 'p-1', 'borrar');
                spanBorrar.dataset.id = producto.id;
                spanBorrar.dataset.nombre = producto.nombre;

                // 6. contenedor sobre la descripcion del producto 
                const contenedorDescripcionProducto = document.createElement('DIV');
                contenedorDescripcionProducto.classList.add('sm:text-start', 'text-center');

                // 7. Nombre del platillo
                const nombrePlatillo = document.createElement('P');
                nombrePlatillo.classList.add('text-sm', 'font-bold', 'text-orange-600');
                nombrePlatillo.appendChild(document.createTextNode('Platillo: '));

                // 8. Span con el nombre del platillo
                const spanNombrePlatillo = document.createElement('SPAN');
                spanNombrePlatillo.textContent = producto.nombre;
                spanNombrePlatillo.classList.add('text-black', 'font-bold');
                
                // Insertar el span dentro del párrafo
                nombrePlatillo.appendChild(spanNombrePlatillo);
                
                // 9. Nombre del platillo
                const nombreCategoria = document.createElement('P');
                nombreCategoria.classList.add('text-sm', 'font-bold', 'text-orange-600');
                nombreCategoria.appendChild(document.createTextNode('Categoria: '));

                // 10. Span con el nombre de la categirua del platillo
                const spanCategoriaPlatillo = document.createElement('SPAN');
                spanCategoriaPlatillo.textContent = producto.nombre_categoria;
                spanCategoriaPlatillo.classList.add('text-black', 'font-bold');
                
                // Insertar el span dentro del párrafo
                nombreCategoria.appendChild(spanCategoriaPlatillo);
        
                // 7. Nombre del platillo
                const precioProducto = document.createElement('P');
                precioProducto.classList.add('text-sm', 'font-bold', 'text-orange-600');
                precioProducto.appendChild(document.createTextNode('Precio: '));

                // 8. Span con el nombre del platillo
                const spanPrecioProducto = document.createElement('SPAN');
                spanPrecioProducto.textContent = `$${producto.precio}`;
                spanPrecioProducto.classList.add('text-black', 'font-bold');
                
                // Insertar el span dentro del párrafo
                precioProducto.appendChild(spanPrecioProducto);

                // 7. Nombre del platillo
                const estadoProducto = document.createElement('P');
                estadoProducto.classList.add('text-sm', 'font-bold', 'text-orange-600');
                estadoProducto.appendChild(document.createTextNode('Estado: '));
                // 8. Span con el nombre del platillo
                const spanEstadoPlatillo = document.createElement('SPAN');
                spanEstadoPlatillo.textContent = producto.activo == 1 ? 'Activo' : 'Inactivo';
                spanEstadoPlatillo.classList.add('text-black', 'font-bold');
                
                // Insertar el span dentro del párrafo
                estadoProducto.appendChild(spanEstadoPlatillo);

                // 8. Contenedor de estatus
                const estatusDiv = document.createElement('DIV');
                estatusDiv.classList.add('columna-estatus', 'estatus');

                // Agregar elementos al contenedor principal
                contenedorProducto.appendChild(contenedorimagenProducto);
                contenedorimagenProducto.appendChild(imagenProducto);
                contenedorimagenProducto.appendChild(contenedorEditarProducto);
                contenedorEditarProducto.appendChild(spanEditar);
                contenedorEditarProducto.appendChild(spanBorrar);
                contenedorProducto.appendChild(contenedorDescripcionProducto);
                contenedorDescripcionProducto.appendChild(nombrePlatillo);
                contenedorDescripcionProducto.appendChild(nombreCategoria);
                contenedorDescripcionProducto.appendChild(precioProducto);
                contenedorDescripcionProducto.appendChild(estadoProducto);

                // Agregar al DOM
                contenedorProductos.appendChild(contenedorProducto);
                });
            }

            // Mostrar productos mediante categoria
            document.addEventListener('change', function (e)
            {
                let productos_filtrados = [];
                let filtrar_productos = false;

                if (e.target.id === 'categoriaProducto')
                {
                    const categoriaSeleccionada = e.target.value;

                    if (categoriaSeleccionada !== '')
                    {
                        productos_filtrados = productos.filter(productos => productos.categoria === Number(categoriaSeleccionada));
                        filtrar_productos = true;
                    } 
                    else 
                    {
                        productos_filtrados = productos;
                    }

                    mostrarProductos(productos_filtrados, filtrar_productos);
                }
            });

            // Limpiar productos de la pagina
            function limpiarProductos()
            {
                const listadoProductos = document.querySelector('#listado_productos_menu');
                // Verifica que el elemento exista
                if (!listadoProductos)
                {
                    console.error('No se encontró el contenedor listado_productos');
                    return;
                }
                //console.log('Limpiando alumnos...'); // Para depuración
                listadoProductos.innerHTML = ''; // Método más eficiente
            }
            
            // Modal eliminar un producto 
            document.addEventListener('click', async function (e) {
                const btn = e.target.closest('.borrar');

                if (!btn) return;

                e.preventDefault();

                const nombre_producto = btn.dataset.nombre || 'Producto ';
                const id = btn.dataset.id || '??';

                const result = await Swal.fire({
                    title: '¿Deseas eliminar este registro?',
                    html: `      
                    <p><strong>Producto:</strong> ${nombre_producto} </p>
                    <p><strong>Id del producto:</strong> ${id}</p>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                });

                if (result.isConfirmed)
                {
                    console.log('Mandando allamar eliminar_Producot()');
                    // Enviar los datos al servidor.
                    const datos_producto = new FormData();
                    datos_producto.append('id', id);

                    await eliminar_Producto(datos_producto, id);
                }
               
            });

            // Crear producto
            document.addEventListener('click', async function (e)
            {
                const id_crear_producto = e.target.closest('#crear_producto');

                if (!id_crear_producto)
                {
                    e.preventDefault();
                    return;    
                }

                const nuevo_producto_creado = {
                    id: '',                 //  Int
                    nombre: '',             //  String
                    categoria: '',          //  Int
                    activo: '',             //  String
                    imagen: '',             //  String
                    precio: '',             //  Int
                    nombre_categoria: '',   // String 
                };

                const nuevo_producto = await MostrarFormularioProducto(false, nuevo_producto_creado);

                // Si canceló, detener el proceso.
                if (!nuevo_producto) return;

                await guardar_Producto(datos_producto, false);

            });
            
            // Editar un producto
            document.addEventListener('click', async function (e)
            {
                const btn = e.target.closest('.editar');
                
                if (!btn) return;

                e.preventDefault();

                const id_producto = btn.dataset.id || '??';

                if (!id_producto) return;
                
                const productoEncontrado = productos.find(
                    producto => String(producto.id) === String(id_producto)
                );

                console.log('El producto encontrado para modificar es: ', productoEncontrado);
                if (!productoEncontrado) return;

                const resultado = await MostrarFormularioProducto(true, productoEncontrado);
                
                // Si canceló, detener el proceso.
                if (!resultado) return;

                
            });
            
            async function MostrarFormularioProducto(editar = false, producto = {})
            {
                const {
                    id,
                    nombre,
                    categoria = 0,
                    precio,
                    imagen,
                    activo
                } = producto;

                const opcionesCategorias = arrayCategorias.map(cat => `
                    <option
                        value="${cat.id}"
                        ${Number(cat.id) === Number(categoria) ? 'selected' : ''}
                    >
                        ${cat.nombre_categoria}
                    </option>
                `).join('');

                const arrayEstados = [
                    { value: 1, nombre: 'Activo' },
                    { value: 0, nombre: 'Inactivo' }
                ];

                const opcionesEstados = arrayEstados.map(estado => `
                    <option
                        value="${estado.value}"
                        ${Number(estado.value) === Number(activo) ? 'selected' : ''}
                    >
                        ${estado.nombre}
                    </option>
                `).join('');

                const { isConfirmed, value } = await Swal.fire({
                    title: editar ? `Editando: ${nombre}` : 'Creando nuevo producto del menú',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Guardar',
                    allowOutsideClick: false,
                    focusConfirm: false,

                    html: `
                        <input id="id_producto" value="${id}" type="hidden">

                        <div class="p-2 my-3 flex flex-col sm:flex-row sm:justify-between border-2 border-gray-100 bg-gray-200 rounded">
                            <label for="nombre_producto" class="text-black">
                                Nombre del producto:
                            </label>
                            <input
                                id="nombre_producto"
                                class="swal1-input text-center bg-gray-100"
                                value=" ${nombre ? nombre : ''}"
                            >
                        </div>

                        <div class="p-2 my-3 flex flex-col sm:flex-row sm:justify-between border-2 border-gray-100 bg-gray-200 rounded">
                            <label for="categoria_producto" class="text-black">
                                Categoría del producto:
                            </label>
                            <select
                                id="categoria_producto"
                                class="swal2-select text-center bg-gray-100"
                            >   
                                ${opcionesCategorias}
                            </select>
                        </div>

                        <div class="p-2 my-3 flex flex-col sm:flex-row sm:justify-between border-2 border-gray-100 bg-gray-200 rounded">
                            <label for="imagen_producto" class="text-black">
                                Imagen del producto:
                            </label>
                            <input
                                id="imagen_producto"
                                class="swal1-input text-center bg-gray-100"
                                value="${imagen ? imagen : ''}"
                            >
                        </div>

                        <div class="p-2 my-3 flex flex-col sm:flex-row sm:justify-between border-2 border-gray-100 bg-gray-200 rounded">
                            <label for="precio_producto" class="text-black">
                                Precio del producto:
                            </label>
                            <input
                                id="precio_producto"
                                type="number"
                                class="swal1-input text-center bg-gray-100"
                                value="${precio ? precio : ''}"
                            >
                        </div>

                        <div class="p-2 my-3 flex flex-col sm:flex-row sm:justify-between border-2 border-gray-100 bg-gray-200 rounded">
                            <label for="activo_producto" class="text-black">
                                Estado del producto:
                            </label>
                            <select
                                id="estado_producto"
                                class="swal2-select text-center bg-gray-100"
                            >
                                ${opcionesEstados}
                            </select>
                        </div>
                    `,

                    preConfirm: async () => {

                        const datosFormulario = {
                            id_producto: document.getElementById('id_producto').value,
                            nombre_producto: document.getElementById('nombre_producto').value.trim(),
                            imagen_producto: document.getElementById('imagen_producto').value.trim(),
                            precio_producto: document.getElementById('precio_producto').value,
                            estado_producto: document.getElementById('estado_producto').value,
                            categoria_producto: document.getElementById('categoria_producto').value
                        };

                        try 
                        {
                            const resultado = await guardar_Producto(datosFormulario, editar);

                            if (!resultado.resultado)
                            {
                                const listaAlertas = Object.entries(resultado.alertas)
                                    .map(([tipo, mensajes]) => `
                                        <div class="text-left">
                                            <p class="font-semibold capitalize">${tipo}:</p>
                                            <ul class="list-disc pl-5">
                                                ${mensajes.map(mensaje => `<li>${mensaje}</li>`).join('')}
                                            </ul>
                                        </div>
                                    `)
                                    .join('');

                                Swal.showValidationMessage(`
                                    <div class="flex flex-col gap-2">
                                        ${listaAlertas}
                                    </div>
                                `);

                                return false;
                            }
                            return {
                                producto: datosFormulario,
                                respuesta: resultado
                            };

                        } 
                        catch (error)
                        {
                            Swal.showValidationMessage(
                                'Error de conexión o respuesta inválida del servidor.'
                            );

                            return false;
                        }
                    }
                });

                
                // Si el usuario cancela, no hay datos que devolver.
                if (!isConfirmed) return null;

                console.log('Los valores proporcionados por el back cuando no hay errores es: ',value);

                actualizar_Productos(value.producto, editar);

                await Swal.fire({
                    title: editar ? '¡Producto actualizado!' : '¡Producto guardado!',
                    text: 'La operación se realizó correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });

                return value;
            }

            async function guardar_Producto(producto = {}, actualizando_producto = false)
            {
                 // Construimos la peticion
                const datos_producto = new FormData();

                datos_producto.append('id', producto.id_producto);
                datos_producto.append('nombre_producto', producto.nombre_producto);
                datos_producto.append('imagen_producto', producto.imagen_producto);
                datos_producto.append('precio_producto', producto.precio_producto);
                datos_producto.append('estado_producto', producto.estado_producto);
                datos_producto.append('categoria_producto', producto.categoria_producto);

                try 
                {
                    const respuesta = await fetch('/api/guardar_producto', {
                        method: 'POST',
                        body: datos_producto
                    });

                    if (!respuesta.ok)
                    {
                        throw new Error(`Error HTTP: ${respuesta.status}`);
                    }

                    const resultado = await respuesta.json();

                    return resultado;

                } 
                catch (error)
                {

                    console.error(error);

                    // Propagamos el error para que preConfirm lo gestione
                    throw error;
                }
            }

            //Actualizar producto en el arreglo y despues mostrarlo
            function actualizar_Productos(producto_actualizado, producto_nuevo = false)
            {
                if (producto_nuevo)
                {
                    console.log('El arreglo de productos original es: ', productos);
                    console.log('El producto que se va actualizar es: ', producto_actualizado);
                    productos = productos.map(producto => {
                        // 2. Comparamos si el ID del alumno actual coincide con el ID recibido
                        if (producto.id == producto_actualizado.id)
                        {
                            return {
                                ...producto,                   // Copia todas las propiedades existentes
                                activo: producto_actualizado.estado_producto,  
                                categoria: Number(producto_actualizado.categoria_producto),
                                imagen: producto_actualizado.imagen_producto,
                                nombre: producto_actualizado.nombre_producto,
                                precio: producto_actualizado.precio_producto,
                                nombre_categoria: categorias.get(Number(producto_actualizado.categoria_producto))
                                    ?? 'Sin categoría'
                                };
                        }
                        return producto;
                    });  
                    
                    mostrarProductos();

                }
                else
                {
                    const ObjetoNuevoProducto = {
                        activo: producto_actualizado.estado_producto,  
                        categoria: Number(producto_actualizado.categoria_producto),
                        imagen: producto_actualizado.imagen_producto,
                        nombre: producto_actualizado.nombre_producto,
                        precio: producto_actualizado.precio_producto,
                        nombre_categoria: categorias.get(Number(producto_actualizado.categoria_producto))
                            ?? 'Sin categoría'
                        };
                        console.log('El productto que se va agregar tien la siguiente estructura: ', ObjetoNuevoProducto);
                    productos.push(ObjetoNuevoProducto)
                    mostrarProductos();
                }

                
            }

            async function eliminar_Producto(datos_producto, id_producto)
            {
                try
                {
                    const url = `/api/eliminar_producto`;
                    const respuesta = await fetch(url, {
                        method:'POST',
                        body: datos_producto
                    });
                    const resultado = await respuesta.json();

                    if (!resultado.resultado)
                    {
                        const alertas = resultado.alertas ?? [];

                        if (alertas.length > 0)
                        {
                            Swal.showValidationMessage(
                                `<div class="flex flex-col gap-2">
                                    ${alertas.map(alerta => `
                                        <div class="flex items-center gap-2 text-red-600">
                                            <span
                                                class="swal2-icon swal2-warning swal2-icon-show"
                                                style="display: inline-flex; flex-shrink: 0; width: 24px; height: 24px; margin: 0; font-size: 18px;"
                                                role="img"
                                                aria-label="Advertencia"
                                            ></span>

                                            <span>
                                                ${typeof alerta === 'string'
                                                    ? alerta
                                                    : alerta.mensaje}
                                            </span>
                                        </div>
                                    `).join('')}
                                </div>`
                            );
                        } 
                        else
                        {
                            Swal.showValidationMessage(
                                'No se pudo eliminar el producto.'
                            );
                        }

                    }

                    retirar_Producto(id_producto);

                    Swal.fire({
                    title: `Producto eliminado correctamente`,
                    icon: "success",
                    });
                    return resultado;
                }
                catch (error)
                {
                    console.error(error);

                    Swal.showValidationMessage(
                        'Error de conexión o respuesta inválida del servidor.'
                    );

                    return false;
                }
            }
            

            function retirar_Producto(id)
            {
                productos = productos.filter(producto => producto.id != id);
                mostrarProductos();
            }

    });
})(); 



// Asi evitamos que haya una reasignacion del valor de variablas en caso de que existan con el mismo nombre pero en diferentes archivos