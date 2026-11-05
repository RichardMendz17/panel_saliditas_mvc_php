(function() 
{

    document.addEventListener('DOMContentLoaded', function() 
    {

        function abrirModalAgregar() 
        {
            console.log('Imprimiendo Agregar Producto');

            document.getElementById('modal-title').innerText = 'Agregar Producto';

            document.getElementById('form-action').value = 'agregar';

            document.getElementById('producto-id').value = '';

            document.getElementById('producto-nombre').value = '';

            document.getElementById('producto-categoria').value = '';

            document.getElementById('producto-precio').value = '';

            document.getElementById('producto-activo').checked = true;

            document.getElementById('modal').classList.add('open');
        }

        function editarProducto(producto)
        {
            document.getElementById('modal-title').innerText = 'Editar Producto';

            document.getElementById('form-action').value = 'editar';

            document.getElementById('producto-id').value = producto.id;

            document.getElementById('producto-nombre').value = producto.nombre;

            document.getElementById('producto-categoria').value = producto.categoria;

            document.getElementById('producto-subcategoria').value = producto.subcategoria || '';

            document.getElementById('producto-precio').value = producto.precio;

            document.getElementById('producto-activo').checked = producto.activo == 1;

            document.getElementById('modal').classList.add('open');
        }

        function eliminarProducto(id, nombre) 
        {
            if (confirm(`¿Eliminar "${nombre}" permanentemente?`)) 
            {

                const form = document.createElement('form');

                form.method = 'POST';

                form.innerHTML = `<input name="action" value="eliminar"><input name="id" value="${id}">`;

                document.body.appendChild(form);

                form.submit();
            }
        }

        function cerrarModal()
        {
            document.getElementById('modal').classList.remove('open');
        }      

        //Editar

        document.querySelectorAll('.btn-editar').forEach(btn =>
        {
            btn.addEventListener('click', function () {

                const producto = {

                    id: this.dataset.id,

                    nombre: this.dataset.nombre,

                    categoria: this.dataset.categoria,

                    subcategoria: this.dataset.subcategoria,

                    precio: this.dataset.precio,

                    activo: this.dataset.activo,

                };

                editarProducto(producto);
            });

        });

        //Eliminar

        document.querySelectorAll('.btn-eliminar').forEach(btn =>{
            btn.addEventListener('click', function() {
                eliminarProducto(this.dataset.id, this.dataset.nombre);        
            });
        });

        document.getElementById('abrirModalAgregar').addEventListener('click', abrirModalAgregar);
        document.getElementById('btn-cerrar-modal').addEventListener('click', cerrarModal);

    });

})(); 



// Asi evitamos que haya una reasignacion del valor de variablas en caso de que existan con el mismo nombre pero en diferentes archivos