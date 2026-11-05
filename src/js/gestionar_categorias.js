import { obtenerDatosMenu } from './obtener_datos_menu.js';

(function() 
{
        document.addEventListener('DOMContentLoaded', function()
        {
            let categorias = [];

            obtener_categorias();

            async function obtener_categorias()
            {
                try
                {
                    const datos_menu = await obtenerDatosMenu();


                    categorias = datos_menu.categorias; // Accedemos unicamente a categorias

                    mostrarCategorias();
                } 
                catch (error)
                {
                    console.log(error);
                }
            }

            function mostrarCategorias(categorias_actualizadas = [], actualizar_categoria)
            {
                let arrayCategorias;

                limpiarCategorias();

                const contenedorCategorais = document.querySelector('#categorias');

                if (actualizar_categoria === true)
                {
                    arrayCategorias = categorias_actualizadas;
                    
                    if (arrayCategorias.length === 0)
                    {
                        const textoNoCategorias = document.createElement('li');
                        
                        textoNoCategorias.textContent= 'No hay categorias guardadas';

                        contenedorCategorais.appendChild(textoNoCategorias);
                        
                        return;
                    }
                }
                else
                {
                    arrayCategorias = categorias;
                    // Si aun no hay categorias guardadas
                    if (arrayCategorias.length === 0)
                    {
                        const textoNoCategorias = document.createElement('li');
                        
                        textoNoCategorias.textContent= 'No hay categorias guardadas';

                        contenedorCategorais.appendChild(textoNoCategorias);
                        
                        return;
                    }
                }

                arrayCategorias
                .slice()
                .sort((a, b) => b.id - a.id)
                .forEach(categoria =>{
                    // const selectContenedorCategorias = document.createElementNS('SELECT');
                    // selectContenedorCategorias.classList.add('w-full', 'appearance-none', 'rounded-lg', 'border', 'border-gray-300', 'bg-white', 'px-3', 'py-2', 'pr-10', 'text-sm', 'focus:border-orange-500', 'focus:ring-2', 'focus:ring-orange-200');
                    // selectContenedorCategorias.id = 'categoriaProducto';
                    
                    const selectContenedorCategorias = document.querySelector('#categoriaProducto');

                    const optionCategoria = document.createElement('OPTION');
                    optionCategoria.textContent = categoria.nombre_categoria;
                    optionCategoria.value = categoria.id;

                    selectContenedorCategorias.appendChild(optionCategoria);

                });
            }
            
            function limpiarCategorias()
            {
                const listadoCategorias = document.querySelector('#categorias');

                if(!listadoCategorias)
                {
                    console.error('No se encontro el contenedor de categorias');
                }
                categorias.innerHTML = '';
            }

        });
})(); 

// Asi evitamos que haya una reasignacion del valor de variablas en caso de que existan con el mismo nombre pero en diferentes archivos