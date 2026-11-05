(function() 
{

        document.addEventListener('DOMContentLoaded', function() {
        const selectRol = document.querySelector('#Rol');
        const inputPersonaId = document.querySelector('#persona_id');
        const nombre_personal = document.querySelector('#nombre_personal');
        selectRol.addEventListener('change', () => {

            if (selectRol.value === '2')  // Comparación
            {
                console.log('El usuario selecciono el rol de tipo jefe de carrera');
                cargarCarreras(); //Cargamos las carreras

            }
            else 
            {
                limpiarContenedorCarreras();
            }
            // Opcional: limpiar input y resultados al cambiar rol
            inputPersonaId.value = '';
            ocultarSugerencias();
        });

        inputPersonaId.addEventListener('input', () => {
            const rolId = selectRol.value;
            const personaId = inputPersonaId.value.trim();
            if (!rolId) {
                mostrarAlerta('Primero debe seleccionar un rol', 'error', selectRol.parentElement);
                return; // No buscar si no hay rol
            }

            if (personaId.length < 4) {
                // Opcional: ocultar sugerencias si el texto es muy corto
                ocultarSugerencias();
                return;
            }

            buscarEntidad(rolId, personaId);
        });

        async function cargarCarreras() 
        {
            const carreras = await ObtenerCarreras();            
            // Retorna solo el arreglo de carreras o un arreglo vacío
            if (carreras)
            {
                console.log('Imprimiendo carreras obtenidas:', carreras);
                MostrarSelectCarreras(carreras);
            }
            return []; // Arreglo vacío si no hay datos
        }

        // Buscamos Carreras
        async function ObtenerCarreras() 
        {
            try 
            {
                const url_carreras = `/api/carreras`;
                // Treamos las carreras
                const respuesta = await fetch(url_carreras);
                const resultado = await respuesta.json();
                //console.log('Imprimiendo carreras', resultado.carreras)
                if (!respuesta.ok) throw new Error('Error en la petición para traer carreras');
                //console.log('Esto es de carreras', resultado_carreras.carreras);
                return resultado.carreras;
            }
            catch (error) 
            {
                //console.error('Error al buscar entidad:', error);
                mostrarAlerta('Error al solicitar carreras', 'error', inputPersonaId.parentElement);
            }
        }
        
        // Limpiar carreras
        function limpiarContenedorCarreras()
        {
            const contenedor_carreras = document.querySelector('#contenedor-carreras');
            contenedor_carreras.innerHTML = '';
        }

        // Mostrar Carreras
        function MostrarSelectCarreras(carreras)
        {
            const contenedorCarreras = document.querySelector('#contenedor-carreras');

            if (!contenedorCarreras) {
                console.error('No se encontró el contenedor #contenedor-carreras');
                return;
            }
            
            // Limpiar contenedor
            contenedorCarreras.innerHTML = '';
            // Creamos el label para el select
            const label_Carreras = document.createElement('label');
            label_Carreras.setAttribute('for', 'carrera');
            label_Carreras.textContent = 'Selecciona una carrera para el jefe de carrera';
            contenedorCarreras.appendChild(label_Carreras);

            if(carreras.length !== 0)
            {
                // Crear UN SOLO select
                const select_carrera = document.createElement('select');
                select_carrera.id = 'carrera';
                select_carrera.name = 'asignacion_rol[id_carrera]';
                // Opción por defecto
                const optionDefault = document.createElement('option');
                optionDefault.value = '';
                optionDefault.textContent = 'Selecciona una carrera';
                optionDefault.disabled = true;
                optionDefault.selected = true;
                select_carrera.appendChild(optionDefault);
                
                // Recorrer las carreras y crear options
                carreras.forEach(carrera => {
                    const option = document.createElement('option');
                    option.value = carrera.id;
                    option.textContent = carrera.nombre_Carrera;
                    select_carrera.appendChild(option);
                });
                
                // Agregar el select al contenedor
                contenedorCarreras.appendChild(select_carrera);
                
                // Opcional: agregar evento cuando se selecciona una carrera
                select_carrera.addEventListener('change', (event) => {
                    const carreraId = event.target.value;
                    if(carreraId) {
                        console.log('Carrera seleccionada:', carreraId);
                        // Aquí puedes llamar a otra función si necesitas
                        // crear_Usuario_Password(carreraId);
                    }
                });
            }
            else
            {
                // Si no hay carreras, mostrar mensaje
                contenedorCarreras.innerHTML = '<p>No hay carreras disponibles</p>';
            }
        }

        async function buscarEntidad(rolId, personaId) {
            try {
                // Definir la URL para buscar según rol
                let url = '';
                //Alumnos
                // Personal 
                if (['0', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14' ].includes(rolId)) 
                {
                    url = `/api/personal-buscar?numero_control=${encodeURIComponent(personaId)}`;
                } 

                const respuesta = await fetch(url);
                const resultado = await respuesta.json();
                if (!respuesta.ok) throw new Error('Error en la petición');

                // Procesar resultado según tabla

                personal_Encontrado = resultado.personal_Detalles;    
                console.log(personal_Encontrado, 'Personal encontrado');          
                // Resultado personal 
                if (!personal_Encontrado || personal_Encontrado.length === 0)
                {
                    mostrarAlerta('No hay coincidencias en el personal ', 'error', inputPersonaId.parentElement);
                    ocultarSugerencias();
                    return;
                }
                    console.log(personal_Encontrado)                
                    mostrarSugerencias(personal_Encontrado, rolId);
                

            } catch (error) 
                {
                console.error('Error al buscar entidad:', error);
                mostrarAlerta('Error al realizar la búsqueda', 'error', inputPersonaId.parentElement);
                }
        }

        function mostrarSugerencias(registro_Encontrado, rolId){
            const contenedorSugerencias = document.querySelector('#sugerencias-alumnos');
            contenedorSugerencias.innerHTML = '';
            if(registro_Encontrado.length === 0)
            {
                ocultarSugerencias();
            }
            registro_Encontrado.forEach(registro => {
                const sugerencia = document.createElement('div');
                sugerencia.classList.add('sugerencia');
                // Mostramos las sugerencia con las propiedades adecuadas
                // Para Personal institucional
                if (['0', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14'].includes(rolId)) 
                {
                    sugerencia.innerHTML = `
                    <div class="sugerencia-contenido">
                        <span class="registro-id">${registro.id}</span>
                        <span class="registro-nombre">
                            ${registro.nombre}
                            ${registro.apellido_Paterno}
                            ${registro.apellido_Materno}
                        </span>
                    </div>
                    `;              
                }

                sugerencia.addEventListener('click', () => {
                    inputPersonaId.value = registro.id;
                    nombre_personal.value = `${registro.nombre} ${registro.apellido_Paterno} ${registro.apellido_Materno}`;
                    ocultarSugerencias(); 
                });
                contenedorSugerencias.appendChild(sugerencia);
            });
        }

        function ocultarSugerencias() {
            const contenedorSugerencias = document.querySelector('#sugerencias-alumnos');
            contenedorSugerencias.innerHTML = ''; // Borra todo el contenido
        }
        function removerPersonalSeleccionado() {
            inputPersonaId.value= '';
            nombre_personal.value = ''
        }
        //Muestra un mensaje en la interfaz
        function mostrarAlerta(mensaje, tipo, referencia, tiempo = 3000)
        {
            //Previene la creación de multiples alertas
            const alertaPrevia = document.querySelector('.alerta');

            if (alertaPrevia) 
            {
                alertaPrevia.remove();
            }
            const alerta = document.createElement('DIV');
            alerta.classList.add('alerta', tipo);
            alerta.classList.add('centrar-texto');
            alerta.innerHTML = mensaje;

            referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);
            setTimeout(()=>{
                alerta.remove();
            }, tiempo);

        }

    });
    
})();
