// datosMenu.js

export async function obtenerDatosMenu()
{

    // Mostrar indicador de carga
    Swal.fire({
        title: 'Cargando menú',
        text: 'Obteniendo categorías y productos...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    try
    {
        const [respuestaCategorias, respuestaProductos] = await Promise.all([
            fetch('/api/obtener_categorias'),
            fetch('/api/obtener_productos'),
            new Promise(resolve => setTimeout(resolve, 1000))
        ]);

        if (!respuestaCategorias.ok || !respuestaProductos.ok) {
            throw new Error('Error al obtener los datos del menú');
        }

        const datosCategorias = await respuestaCategorias.json();
        const datosProductos = await respuestaProductos.json();

        const categorias = datosCategorias.categorias;
        const productos = datosProductos.productos;

        const mapaCategorias = new Map(
            categorias.map(categoria => [
                Number(categoria.id),
                categoria.nombre_categoria
            ])
        );
        // Cerrar indicador de carga
        Swal.close();
        
        const productosConCategoria = productos.map(producto => ({
            ...producto,
            nombre_categoria: mapaCategorias.get(Number(producto.categoria))
                ?? 'Sin categoría'
        }));

        return { categorias, productos, productosConCategoria, mapaCategorias };
    } 
    catch (error)
    {
        Swal.fire({
            icon: 'error',
            title: 'Error al cargar el menú',
            text: error.message,
            confirmButtonText: 'Aceptar'
        });

        throw error;
    }

}