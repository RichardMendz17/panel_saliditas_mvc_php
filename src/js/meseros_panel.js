(function() 
{
	document.addEventListener('DOMContentLoaded', function()
	{
		const colores = [
			'#E74C3C', 
			'#3498DB', 
			'#2ECC71',
			'#F39C12',
			'#9B59B6', 
			'#1ABC9C', 
			'#E67E22', 
			'#27AE60', 
			'#7F8C8D', 
			'#16A085'
		];

		let platos = [];

		let mesaActual = 1;

		let codigoActual = null;

		let platoSeleccionado = null;

		let productoSeleccionado = null;

		let pedidoAEntregar = null;

		let itemsLlevar = [];

		let productoSeleccionadoLlevar = null;

		let esModoLlevar = false;

		function obtenerSalsasPedido()
		{
			let salsas = [];
			document.querySelectorAll('.salsa-pedido:checked').forEach(cb => {

				salsas.push(cb.value);

			});
			if (salsas.length === 0 || (salsas.length === 1 && salsas[0] === 'Sin salsa')) return 'Sin salsa';
			return salsas.join(', ');
		}

		function obtenerSalsasPedidoLlevar()
		{
			let salsas = [];

			document.querySelectorAll('.salsa-pedido-llevar:checked').forEach(cb => {

				salsas.push(cb.value);

			});

			if (salsas.length === 0 || (salsas.length === 1 && salsas[0] === 'Sin salsa')) return 'Sin salsa';

			return salsas.join(', ');
		}

		function mostrarToast(mensaje, esExito = true)
		{
			const toast = document.createElement('div');

			toast.className = `toast-confirmacion ${!esExito ? 'toast-error' : ''}`;

			toast.innerHTML = mensaje;

			document.body.appendChild(toast);

			setTimeout(() => toast.classList.add('mostrar'), 10);

			setTimeout(() => {

				toast.classList.remove('mostrar');

				setTimeout(() => toast.remove(), 300);

			}, 3000);
		}

		async function hacerFetch(data)
		{
			try 
			{
				const url = `/api/meseros_panel`;
				const response = await fetch(url,
				{
					method: 'POST',

					headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },

					body: JSON.stringify(data)
				});

				if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

				return await response.json();
			} 
			catch (error)
			{
				console.error('Fetch error:', error);

				mostrarToast('Error de conexión: ' + error.message, false);

				return null;
			}
		}

		function getPrecioFinal(item)
		{
			let precio = item.precioBase;
			if (item.extras && item.extras.quesoExtra === true)
			{
				precio += 5;
			}
			return precio;
		}

		async function cargarMesa(mesa)
		{
			const data = await hacerFetch({ 
				action: 'cargar',
				mesa: mesa
			});
			if (data && data.success)
			{
				platos = data.platos || [];
				platos.forEach(plato => {

					if (plato.items)
						{
						plato.items.forEach(item => { 
							if (item.enviado === undefined) item.enviado = true;
						});
					}

					if (plato.abierto === undefined) plato.abierto = false;

				});

				codigoActual = data.codigo;
				renderPlatos();
				actualizarContador();
			}
		}

		async function guardarMesa()
		{
			await hacerFetch({ 
				action: 'guardar', 
				mesa: mesaActual, 
				platos: platos, 
				total: calcularTotal() });
		}

		function calcularTotal()
		{
			let total = 0;
			platos.forEach(plato => {

				if (plato.items)
				{
					plato.items.forEach(item => {
						total += getPrecioFinal(item) * item.cantidad;
					});
				}
			});
			return total;
		}

		function calcularTotalLlevar()
		{
			let total = 0;
			itemsLlevar.forEach(item => {
				total += getPrecioFinal(item) * item.cantidad;
			});
			return total;
		}

		function actualizarContador()
		{
			let count = 0;
			platos.forEach(plato => { if (plato.items) plato.items.forEach(item => count += item.cantidad); });
			document.getElementById('cart-count').innerText = count;			
			const pendientes = platos.reduce((c, plato) => c + (plato.items?.filter(i => !i.enviado).length || 0), 0);
			const btnEnviar = document.getElementById('enviar-cocina');
			if (btnEnviar)
			{
				btnEnviar.innerHTML = pendientes > 0 ? `
				<i class="fas fa-utensils">
				</i> ENVIAR A COCINA (${pendientes} nuevo${pendientes !== 1 ? 's' : ''})` : `
				<i class="fas fa-utensils">
				</i> ENVIAR A COCINA (sin nuevos)`;
			}
		}

		async function enviarCocina()
		{
			let platosConNuevos = [];

			platos.forEach((plato, idx) => {
				if (plato.items?.length)
				{
					const itemsNoEnviados = plato.items.filter(item => !item.enviado);
					if (itemsNoEnviados.length) platosConNuevos.push({ plato_numero: idx + 1, items: itemsNoEnviados });
				}
			});

			if (!platosConNuevos.length)
			{
				mostrarToast('No hay productos nuevos para enviar a cocina', false);
				return;
			}

			const salsas = obtenerSalsasPedido();

			const data = await hacerFetch({ 
				action: 'cocina', 

				mesa: mesaActual, 

				platos: platosConNuevos,

				tipo_pedido: 'mesa',

				salsas: salsas
			});			

			if (data?.success)
			{
				platosConNuevos.forEach(platoInfo => {
					const platoOriginal = platos[platoInfo.plato_numero - 1];
					if (platoOriginal?.items)
					{
						platoInfo.items.forEach(itemEnviado => {
							const itemOriginal = platoOriginal.items.find(item => item.id === itemEnviado.id);
							if (itemOriginal) itemOriginal.enviado = true;
						});
					}
				});

				mostrarToast(`Enviado a cocina con salsas: ${salsas}`, true);

				const btnMesa = document.querySelector(`.mesa-btn[data-mesa="${mesaActual}"]`);

				if (btnMesa && !btnMesa.classList.contains('ocupada'))
				{
					btnMesa.classList.add('ocupada');
					if (!btnMesa.querySelector('.mesa-estado'))
					{
						const span = document.createElement('span');
						span.className = 'mesa-estado';
						span.innerHTML = '<i class="fas fa-circle"></i> Ocupada';
						btnMesa.appendChild(span);
					}
				}

				renderPlatos();

				await guardarMesa();

				actualizarContador();

				document.getElementById('resumen-modal').classList.remove('abierto');
			}
		}

		function abrirModalExtras(producto, esLlevar, platoIdx = null)
		{
			const categoria = producto.categoria;
			const esQuesadilla = categoria === 'QUESADILLAS';
			const esPambazo = categoria === 'PAMBAZOS';
			const esBebida = categoria === 'BEBIDAS';
			if (esLlevar)
			{
				productoSeleccionadoLlevar = producto;
				esModoLlevar = true;
				platoSeleccionado = null;
				document.getElementById('extras-producto').innerHTML = `<i class="fas fa-plus-circle"></i> Agregar <strong>${producto.nombre}</strong> al pedido`;
			} 
			else
			{
				if (platoIdx === null || platoSeleccionado === null)
				{
					mostrarToast('Primero selecciona un plato', false);
					return;
				}
				productoSeleccionado = producto;
				esModoLlevar = false;
				document.getElementById('extras-producto').innerHTML = `<i class="fas fa-plus-circle"></i> Agregar <strong>${producto.nombre}</strong> al PLATO ${platoSeleccionado + 1}`;
			}

			document.querySelector('.preparacion-section').style.display = 'none';

			document.querySelector('.pambazo-section').style.display = 'none';

			document.querySelector('input[name="preparacion"][value="frita"]').checked = true;

			document.querySelector('input[name="pambazo_tipo"][value="adobado"]').checked = true;

			document.getElementById('ex-lechuga').checked = true;

			document.getElementById('ex-crema').checked = true;

			document.getElementById('ex-queso-rayado').checked = true;

			document.getElementById('ex-cebolla').checked = false;

			document.getElementById('ex-queso-extra').checked = false;

			document.getElementById('ex-nota').value = '';

			if (esBebida)
			{
				document.querySelector('.quesoextra-section').style.display = 'none';

				document.querySelector('.notas-section').style.display = 'none';

				document.querySelector('.ingredientes-section').style.display = 'none';
			} 
			else
			{
				document.querySelector('.quesoextra-section').style.display = 'block';

				document.querySelector('.notas-section').style.display = 'block';

				document.querySelector('.ingredientes-section').style.display = 'block';
				if (esQuesadilla)
				{
					document.querySelector('.preparacion-section').style.display = 'block';
				} 
				else if (esPambazo)
				{
					document.querySelector('.pambazo-section').style.display = 'block';
				}
			}
			document.getElementById('extras-modal').classList.add('abierto');
		}

		function cerrarModalExtras()
		{
			document.getElementById('extras-modal').classList.remove('abierto');
			productoSeleccionado = null;
			productoSeleccionadoLlevar = null;
		}

		function confirmarExtras()
		{
			const categoria = (esModoLlevar ? productoSeleccionadoLlevar?.categoria : productoSeleccionado?.categoria) || '';
			const esBebida = categoria === 'BEBIDAS';

			let extras = {};

			if (esBebida)
			{
				extras = { nota: document.getElementById('ex-nota').value };
			} 
			else 
			{
				extras.preparacion = document.querySelector('input[name="preparacion"]:checked')?.value || 'frita';

				extras.tipo_pambazo = document.querySelector('input[name="pambazo_tipo"]:checked')?.value || 'adobado';

				extras.lechuga = document.getElementById('ex-lechuga').checked;

				extras.crema = document.getElementById('ex-crema').checked;

				extras.cebolla = document.getElementById('ex-cebolla').checked;

				extras.quesoRayado = document.getElementById('ex-queso-rayado').checked;

				extras.quesoExtra = document.getElementById('ex-queso-extra').checked;

				extras.nota = document.getElementById('ex-nota').value;
			}

			if (esModoLlevar && productoSeleccionadoLlevar)
			{
				agregarItemLlevar(productoSeleccionadoLlevar.nombre, extras, productoSeleccionadoLlevar.precio, productoSeleccionadoLlevar.categoria);
			} 
			else if (productoSeleccionado)
			{
				agregarProducto(productoSeleccionado.nombre, extras, productoSeleccionado.precio, productoSeleccionado.categoria);
			}
			cerrarModalExtras();
		}

		function agregarProducto(nombre, extras, precio, categoria)
		{
			if (platoSeleccionado === null)
			{
				mostrarToast('Selecciona un plato primero', false);
				return;
			}

			if (!platos[platoSeleccionado])
			{
				mostrarToast('Error: Plato no encontrado', false);
				return;
			}

			if (!platos[platoSeleccionado].items)
			{
				platos[platoSeleccionado].items = [];
			}

			const nuevoItem = {
				id: Date.now(), 

				nombre: nombre, 

				cantidad: 1, 

				precioBase: precio,

				categoria: categoria,

				extras: extras, 

				nota: extras.nota || '', 

				enviado: false
			};

			platos[platoSeleccionado].items.push(nuevoItem);

			renderPlatos();

			guardarMesa();

			actualizarContador();				

			let mensaje = `Agregado: ${nombre}`;

			if (extras.quesoExtra) mensaje += ` con Queso Extra (+$5)`;

			mensaje += ` al PLATO ${platoSeleccionado + 1}`;

			mostrarToast(mensaje, true);
		}

		function renderPlatos()
		{
			const container = document.getElementById('platos-container');
			if (!platos.length)
			{
				container.innerHTML = '<div style="text-align:center; padding:40px; color:#999;"><i class="fas fa-info-circle"></i> Sin platos - Presiona "Agregar Nuevo Plato"</div>';
				return;
			}

			container.innerHTML = '';

			platos.forEach((plato, idx) => {
				const color = colores[idx % colores.length];

				let totalPlato = 0, pendientesPlato = 0;

				if (plato.items)
				{
					plato.items.forEach(item => {
						totalPlato += getPrecioFinal(item) * item.cantidad;
						if (!item.enviado) pendientesPlato += item.cantidad;
					});
				}

				const div = document.createElement('div');

				div.className = 'plato-card';

				div.innerHTML = `
					<div class="plato-header" style="background: ${color};" onclick="togglePlato(${idx})">

						<div class="plato-numero">
							<span>
								<i class="fas fa-utensils"></i>
								</span><span>PLATO ${idx + 1}
							</span>

						${pendientesPlato > 0 ? `<span class="badge-enviado">
							<i class="fas fa-clock"></i>
							${pendientesPlato} pendiente${pendientesPlato !== 1 ? 's' : ''}</span>` : '<span class="badge-enviado"><i class="fas fa-check"></i> Enviado</span>'}</div>

						<div class="plato-total">$${totalPlato.toFixed(2)}</div>

						<button class="btn-eliminar-plato" onclick="event.stopPropagation(); eliminarPlato(${idx})"><i class="fas fa-trash-alt"></i></button>

					</div>

					<div class="plato-items ${plato.abierto ? 'abierto' : ''}">

						${renderItemsPlato(plato.items || [], idx)}

						<button 
							class="btn-agregar-producto btn-abrir-menu-para-plato" 
							data-id="${idx}"
							>
							<i class="fas fa-plus-circle"></i> 
							AGREGAR PRODUCTO
						</button>

					</div>
				`;
				container.appendChild(div);
			});
		}

		function renderItemsPlato(items, platoIdx)
		{
			if (!items.length) return '<div style="text-align:center; padding:20px;"><i class="fas fa-info-circle"></i> Sin productos</div>';
			return items.map((item, itemIdx) => {
				const precio = getPrecioFinal(item);
				let detalles = [];				
				if (item.categoria)
				{
					let categoriaMostrar = item.categoria;
					if (categoriaMostrar === 'QUESADILLAS') categoriaMostrar = 'Quesadilla';
					else if (categoriaMostrar === 'GORDITAS') categoriaMostrar = 'Gordita';
					else if (categoriaMostrar === 'PAMBAZOS') categoriaMostrar = 'Pambazo';
					else if (categoriaMostrar === 'SOPES') categoriaMostrar = 'Sope';
					else if (categoriaMostrar === 'HUARACHES') categoriaMostrar = 'Huarache';
					else if (categoriaMostrar === 'FLAUTAS') categoriaMostrar = 'Flauta';
					detalles.push(`<i class="fas fa-tag"></i> ${categoriaMostrar}`);
				}

				if (item.extras?.preparacion)
				{
					if (item.extras.preparacion === 'frita') detalles.push('<i class="fas fa-fire"></i> Frita');
					else if (item.extras.preparacion === 'comal') detalles.push('<i class="fas fa-egg"></i> Al Comal');
				}

				if (item.extras?.tipo_pambazo)
				{
					if (item.extras.tipo_pambazo === 'adobado') detalles.push('<i class="fas fa-pepper-hot"></i> Adobado');
					else if (item.extras.tipo_pambazo === 'natural') detalles.push('<i class="fas fa-leaf"></i> Natural');
				}

				if (item.extras?.lechuga === false) detalles.push('<i class="fas fa-leaf"></i> Sin Lechuga');

				if (item.extras?.crema === false) detalles.push('<i class="fas fa-tint"></i> Sin Crema');

				if (item.extras?.cebolla === true) detalles.push('<i class="fas fa-onion"></i> Cebolla');

				if (item.extras?.quesoRayado === false) detalles.push('<i class="fas fa-cheese"></i> Sin Queso Rayado');

				if (item.extras?.quesoExtra === true) detalles.push('<i class="fas fa-cheese"></i> Queso Extra (+$5)');

				return `

					<div class="item-plato ${item.enviado ? 'enviado' : ''}">

						<div class="item-info">

							<div class="item-nombre-producto">${item.cantidad}x ${item.nombre}</div>

							<div class="item-precio">$${(precio * item.cantidad).toFixed(2)}</div>

							${detalles.length ? `<div class="item-extras">${detalles.join(' | ')}</div>` : ''}

							${item.extras?.nota ? `<div class="item-extras"><i class="fas fa-sticky-note"></i> ${item.extras.nota}</div>` : ''}

						</div>

						<div class="item-actions">

							${!item.enviado ? `

								<button onclick="cambiarCantidad(${platoIdx}, ${itemIdx}, -1)">-</button>

								<span>${item.cantidad}</span>

								<button onclick="cambiarCantidad(${platoIdx}, ${itemIdx}, 1)">+</button>

							` : `<span style="font-size:11px;"><i class="fas fa-check"></i> Enviado</span>`}

							<button class="btn-eliminar-item" onclick="eliminarItem(${platoIdx}, ${itemIdx})"><i class="fas fa-trash-alt"></i></button>
						</div>
					</div>
				`;
			}).join('');
		}

		function agregarItemLlevar(nombre, extras, precio, categoria)
		{
			console.log("Agregando item a llevar:", nombre);

			const nuevoItem = 
			{
				id: Date.now(), 

				nombre: nombre, 

				cantidad: 1, 

				precioBase: precio,

				categoria: categoria,

				extras: extras, 

				nota: extras.nota || ''
			};

			itemsLlevar.push(nuevoItem);

			console.log("Items llevar actualizados:", itemsLlevar);

			renderItemsLlevar();			

			let mensaje = `Agregado: ${nombre}`;

			if (extras.quesoExtra) mensaje += ` con Queso Extra (+$5)`;

			mensaje += ` al pedido`;

			mostrarToast(mensaje, true);
		}

		function renderItemsLlevar()
		{
			console.log("Renderizando items llevar, cantidad:", itemsLlevar.length);
			const container = document.getElementById('items-llevar-list');
			if (!itemsLlevar.length)
			{
				container.innerHTML = '<div style="text-align:center; padding:30px; color:#999;"><i class="fas fa-info-circle"></i> Sin productos - Presiona "Agregar Producto"</div>';
				document.getElementById('total-llevar').innerText = '0';
				return;
			}

			let html = '';

			itemsLlevar.forEach((item, idx) => {
				const precio = getPrecioFinal(item);
				let detalles = [];
			
				if (item.categoria)
				{
					let categoriaMostrar = item.categoria;
					if (categoriaMostrar === 'QUESADILLAS') categoriaMostrar = 'Quesadilla';
					else if (categoriaMostrar === 'GORDITAS') categoriaMostrar = 'Gordita';
					else if (categoriaMostrar === 'PAMBAZOS') categoriaMostrar = 'Pambazo';
					else if (categoriaMostrar === 'SOPES') categoriaMostrar = 'Sope';
					else if (categoriaMostrar === 'HUARACHES') categoriaMostrar = 'Huarache';
					else if (categoriaMostrar === 'FLAUTAS') categoriaMostrar = 'Flauta';
					detalles.push(`<i class="fas fa-tag"></i> ${categoriaMostrar}`);
				}

				if (item.extras?.preparacion)
				{
					if (item.extras.preparacion === 'frita') detalles.push('<i class="fas fa-fire"></i> Frita');
					else if (item.extras.preparacion === 'comal') detalles.push('<i class="fas fa-egg"></i> Al Comal');
				}

				if (item.extras?.tipo_pambazo)
				{
					if (item.extras.tipo_pambazo === 'adobado') detalles.push('<i class="fas fa-pepper-hot"></i> Adobado');
					else if (item.extras.tipo_pambazo === 'natural') detalles.push('<i class="fas fa-leaf"></i> Natural');
				}

				if (item.extras?.lechuga === false) detalles.push('<i class="fas fa-leaf"></i> Sin Lechuga');

				if (item.extras?.crema === false) detalles.push('<i class="fas fa-tint"></i> Sin Crema');

				if (item.extras?.cebolla === true) detalles.push('<i class="fas fa-onion"></i> Cebolla');

				if (item.extras?.quesoRayado === false) detalles.push('<i class="fas fa-cheese"></i> Sin Queso Rayado');

				if (item.extras?.quesoExtra === true) detalles.push('<i class="fas fa-cheese"></i> Queso Extra (+$5)');					

				html += `
					<div class="item-llevar">

						<div class="item-info">

							<div class="item-nombre-producto">${item.cantidad}x ${item.nombre}</div>

							<div class="item-precio">$${(precio * item.cantidad).toFixed(2)}</div>

							${detalles.length ? `<div class="item-extras">${detalles.join(' | ')}</div>` : ''}

							${item.extras?.nota ? `<div class="item-extras"><i class="fas fa-sticky-note"></i> ${item.extras.nota}</div>` : ''}
						</div>

						<div class="item-actions">
							<button onclick="cambiarCantidadLlevar(${idx}, -1)">-</button>

							<span>${item.cantidad}</span>

							<button onclick="cambiarCantidadLlevar(${idx}, 1)">+</button>

							<button class="btn-eliminar-item" onclick="eliminarItemLlevar(${idx})"><i class="fas fa-trash-alt"></i></button>
						</div>

					</div>
				`;
			});
			container.innerHTML = html;
			document.getElementById('total-llevar').innerText = calcularTotalLlevar().toFixed(2);
		}

		function cambiarCantidadLlevar(idx, delta)
		{
			if (itemsLlevar[idx])
			{
				const nueva = itemsLlevar[idx].cantidad + delta;
				if (nueva <= 0) itemsLlevar.splice(idx, 1);
				else itemsLlevar[idx].cantidad = nueva;
				renderItemsLlevar();
			}
		}

		function eliminarItemLlevar(idx)
		{
			itemsLlevar.splice(idx, 1);
			renderItemsLlevar();
		}

		async function enviarPedidoLlevarACocina()
		{
			const nombre = document.getElementById('cliente-nombre-llevar').value.trim();
			if (!nombre)
			{
				mostrarToast('Ingrese el nombre del cliente', false);
				return;
			}

			if (itemsLlevar.length === 0)
			{
				mostrarToast('Agregue al menos un producto al pedido', false);
				return;
			}

			const total = calcularTotalLlevar();

			const salsas = obtenerSalsasPedidoLlevar();

			const notaGeneral = document.getElementById('nota-general-llevar').value.trim();

			if (!confirm(`Confirmar envío a cocina del pedido para ${nombre}?\nSalsas: ${salsas}\nTotal: $${total.toFixed(2)}`))
			{
				return;
			}		

			const telefono = document.getElementById('cliente-telefono-llevar').value.trim();

			const itemsParaGuardar = JSON.parse(JSON.stringify(itemsLlevar));

			itemsParaGuardar.forEach(item => {
				item.salsas_pedido = salsas;
			});

			const data = await hacerFetch({ 
				action: 'guardar_llevar', 

				nombre_cliente: nombre, 

				telefono: telefono, 

				items: itemsParaGuardar, 

				total: total,

				salsas: salsas,

				nota_general: notaGeneral
			});

			if (data?.success)
			{
				mostrarToast(`Pedido enviado a cocina para ${nombre}\nCódigo seguridad: ${data.codigo_seguridad || 'N/A'}\nCódigo recogida: ${data.codigo_recogida || 'N/A'}`, true);

				document.getElementById('cliente-nombre-llevar').value = '';

				document.getElementById('cliente-telefono-llevar').value = '';

				document.getElementById('nota-general-llevar').value = '';

				document.querySelectorAll('.salsa-pedido-llevar').forEach(cb => cb.checked = false);

				itemsLlevar = [];

				renderItemsLlevar();

				cargarPedidosLlevar();
			}
		}

		async function cargarPedidosLlevar()
		{
			const data = await hacerFetch({ 
				action: 'obtener_pedidos_llevar' 
			});
			if (data?.success)
			{
				const container = document.getElementById('lista-pedidos-llevar');
				if (!data.pedidos || data.pedidos.length === 0)
				{
					container.innerHTML = '<div style="text-align:center; padding:20px;"><i class="fas fa-info-circle"></i> No hay pedidos activos</div>';
					return;
				}

				let html = '';

				data.pedidos.forEach(pedido => {
					let estadoText = pedido.estado === 'cocina' ? 'En cocina' : 'Listo';
					let estadoClass = pedido.estado === 'cocina' ? 'estado-cocina' : 'estado-listo';
					let estadoIcon = pedido.estado === 'cocina' ? '<i class="fas fa-fire"></i>' : '<i class="fas fa-check-circle"></i>';				

					let productosHTML = '';

					if (pedido.items && Array.isArray(pedido.items))
					{
						pedido.items.forEach(item => {
							let precio = item.precioBase;
							if (item.extras?.quesoExtra === true) precio += 5;
							let salsasItem = item.salsas_pedido || 'Sin salsa';
							productosHTML += `<div><i class="fas fa-utensil-spoon"></i> ${item.cantidad || 1}x ${item.nombre} - $${(precio * (item.cantidad || 1)).toFixed(2)} - <i class="fas fa-pepper-hot"></i> ${salsasItem}</div>`;
						});
					}

					html += `
						<div class="pedido-card" data-pedido-id="${pedido.id}">

							<div class="pedido-header">

								<span class="pedido-nombre"><i class="fas fa-user"></i> ${pedido.nombre_cliente}</span>

								<span class="pedido-estado ${estadoClass}">${estadoIcon} ${estadoText}</span>

							</div>

							${pedido.telefono ? `<div><i class="fas fa-phone"></i> ${pedido.telefono}</div>` : ''}

							<div class="pedido-productos">${productosHTML || '<div><i class="fas fa-info-circle"></i> Sin productos</div>'}</div>

							<div class="pedido-total">Total: $${parseFloat(pedido.total).toFixed(2)}</div>
					`;

					if (pedido.nota_general)
					{
						html += `<div class="producto-nota" style="margin-top:8px;"><i class="fas fa-sticky-note"></i> Nota: ${pedido.nota_general}</div>`;
					}

					

					if (pedido.codigo_seguridad || pedido.codigo_recogida)
					{
						html += `<div class="codigos-pedido">

							<p><strong><i class="fas fa-key"></i> Código seguridad:</strong> ${pedido.codigo_seguridad || 'N/A'}</p>

							<p><strong><i class="fas fa-box"></i> Código recogida:</strong> ${pedido.codigo_recogida || 'N/A'}</p>

						</div>`;
					}

					html += `<div class="pedido-actions">`;

					if (pedido.estado === 'cocina')
					{
						html += `<button class="btn-listo btn-marcar-listo-llevar" data-id="${pedido.id}"><i class="fas fa-check"></i> Marcar como Listo</button>`;
					}

					if (pedido.estado === 'listo')
					{
						html += `<button class="btn-cobrar-llevar btn-abrir-modal-pago-llevar" data-id="${pedido.id}" data-total="${pedido.total}"><i class="fas fa-dollar-sign"></i> Cobrar y Entregar</button>`;
					}

					html += `</div></div>`;
				});
				container.innerHTML = html;
			} 
			else
			{
				document.getElementById('lista-pedidos-llevar').innerHTML = '<div style="text-align:center; padding:20px; color:red;"><i class="fas fa-exclamation-triangle"></i> Error al cargar pedidos</div>';
			}
		}

		document.addEventListener('click',  function(e) {
			//1.- Marcar listo llevar
			const btnMarcarListoLlevar = e.target.closest('.btn-marcar-listo-llevar');
			if (!btnMarcarListoLlevar)
			{
				return; // No hacer nada si no se hizo clic en el botón
			} 
			// Prevenir comportamiento por defecto
			e.preventDefault();
			const id_marcar_listo = btnMarcarListoLlevar.dataset.id;
			if (btnMarcarListoLlevar)
			{
				marcarListoLlevar(id_marcar_listo);
			}
		});
		
		document.addEventListener('click', function(e) {
			//1.- Abrir Modal Pago Llevar
			const btnAbrirModalPagoLlevar =  e.target.closest('.btn-abrir-modal-pago-llevar');

			if (!btnAbrirModalPagoLlevar)
			{
				return; // No hacer nada si no se hizo clic en el botón
			} 

			// Prevenir comportamiento por defecto
			e.preventDefault();

			const id = btnAbrirModalPagoLlevar.dataset.id;
			const total = Number(btnAbrirModalPagoLlevar.dataset.total).toFixed(2);
			console.log('Abriendo modal pago llevar', btnAbrirModalPagoLlevar, 'id:', id, ' total:', total);

			if (btnAbrirModalPagoLlevar)
			{
				abrirModalPagoLlevar(id, total);
			}
		});

		async function marcarListoLlevar(pedidoId)
		{
			const data = await hacerFetch({ 
				action: 'marcar_listo',
				pedido_id: pedidoId 
			});
			if (data?.success)
			{
				mostrarToast('Pedido marcado como listo', true);
				cargarPedidosLlevar();
			}
		}

		let pedidoLlevarCobrando = null;

		function abrirModalPagoLlevar(pedidoId, total)
		{
			pedidoLlevarCobrando = pedidoId;

			document.getElementById('pago-llevar-total').innerText = total;

			document.getElementById('monto-entregado-llevar').value = '';

			document.getElementById('cambio-calculo-llevar').innerHTML = '';

			document.getElementById('modal-pago-llevar').classList.add('abierto');

			document.getElementById('monto-entregado-llevar').oninput = function() {

				const total = parseFloat(document.getElementById('pago-llevar-total').innerText);

				const monto = parseFloat(this.value) || 0;

				if (monto >= total)
				{
					document.getElementById('cambio-calculo-llevar').innerHTML = `<i class="fas fa-money-bill"></i> Cambio: $${(monto - total).toFixed(2)}`;
				} 
				else if (monto > 0)
				{
					document.getElementById('cambio-calculo-llevar').innerHTML = `<i class="fas fa-exclamation-triangle"></i> Faltan $${(total - monto).toFixed(2)}`;
				} 
				else
				{
					document.getElementById('cambio-calculo-llevar').innerHTML = '';
				}
			};

			document.getElementById('metodo-pago-llevar').onchange = function() {
				document.getElementById('campos-efectivo-llevar').style.display = this.value === 'efectivo' ? 'block' : 'none';
			};
		}

        // UN event listener para cerrarModalPagoLlevar
        document.addEventListener('click', function(e) 
        {
            const btnCerrarModalPagoLlevar = e.target.closest('.btn-cerrar-modal-pago-llevar');
            if (btnCerrarModalPagoLlevar)
            {
                e.preventDefault();
				cerrarModalPagoLlevar();
                return;
            }
        });

		function cerrarModalPagoLlevar() { document.getElementById('modal-pago-llevar').classList.remove('abierto'); }


        // UN event listener para confirmarCobroLlevar
        document.addEventListener('click', function(e) 
        {
            const btnConfirmarCobroLlevar = e.target.closest('.btn-confirmar-cobro-llevar');
            if (btnConfirmarCobroLlevar)
            {
                e.preventDefault();
				confirmarCobroLlevar();
                return;
            }
        });

		async function confirmarCobroLlevar()
		{
			if (!pedidoLlevarCobrando) return;

			const total = parseFloat(document.getElementById('pago-llevar-total').innerText);

			const metodoPago = document.getElementById('metodo-pago-llevar').value;

			let montoEntregado = 0;

			if (metodoPago === 'efectivo')
			{
				montoEntregado = parseFloat(document.getElementById('monto-entregado-llevar').value) || 0;
				if (montoEntregado < total)
				{
					mostrarToast(`Monto insuficiente`, false);
					return;
				}
			}

			const data = await hacerFetch({ 
				action: 'cobrar_llevar', 
				pedido_id: pedidoLlevarCobrando, 
				metodo_pago: metodoPago, 
				monto_entregado: montoEntregado 
			});

			if (data?.success)
			{
				mostrarToast(`Pedido cobrado exitosamente!\nCódigos: ${data.codigo_seguridad || 'N/A'} / ${data.codigo_recogida || 'N/A'}`, true);
				cargarPedidosLlevar();
				cerrarModalPagoLlevar();
				pedidoLlevarCobrando = null;
			}
		}

		function cargarMenu(containerId, esLlevar = false)
		{
            const url = `/api/obtener_productos`;

			console.log("Cargando menú para:", esLlevar ? "LLEVAR" : "MESA");
			fetch(url)
			.then(r => r.json())
			.then(data => {
				if (data.productos && data.productos.length)
				{
					const container = document.getElementById(containerId);
					if (!container) return;
					container.innerHTML = '';
					const prodPorCat = {};
					data.productos.forEach(p =>
					{ 
						if (p.activo == 1) 
						{ 
							if (!prodPorCat[p.categoria]) prodPorCat[p.categoria] = []; prodPorCat[p.categoria].push(p); 
						} 
					});

					const orden = [
						'QUESADILLAS', 
						'GORDITAS', 
						'PAMBAZOS', 
						'SOPES',
						'HUARACHES', 
						'FLAUTAS', 
						'BEBIDAS'];

					orden.forEach(cat => {

						if (prodPorCat[cat]?.length)
						{
							const div = document.createElement('div');

							div.className = 'categoria';

							div.innerHTML = `<div class="categoria-titulo"><i class="fas fa-utensils"></i> ${cat}</div><div class="productos-grid"></div>`;

							const grid = div.querySelector('.productos-grid');

							prodPorCat[cat].forEach(item => {

								const btn = document.createElement('button');

								btn.className = 'producto-btn';

								btn.innerHTML = `${item.nombre}<div class="producto-precio">$${item.precio}</div>`;

								btn.onclick = () => {

									console.log("Producto seleccionado:", item.nombre, "esLlevar:", esLlevar);

									if (esLlevar)
									{
										abrirModalExtras(item, true);

										cerrarMenuFlotante();
									} 
									else
									{
										if (platoSeleccionado !== null)
										{
											abrirModalExtras(item, false, platoSeleccionado);
											cerrarMenuFlotante();
										} 
										else
										{
											mostrarToast('Primero selecciona un plato', false);
										}
									}
								};
								grid.appendChild(btn);
							});
							container.appendChild(div);
						}
					});
				}
			}).catch(e => console.error(e));
		}

        // UN event listener para cerrarModalPagoLlevar
        document.addEventListener('click', function(e) 
        {
            const btnAbirMenuParaPlato = e.target.closest('.btn-abrir-menu-para-plato');
            if (btnAbirMenuParaPlato)
            {
                e.preventDefault();
				const id = btnAbirMenuParaPlato.dataset.id;
				console.log('El plato cuenta con el id: ', id);
				abrirMenuParaPlato(id);
                return;
            }
        });

		function abrirMenuParaPlato(idx)
		{
			platoSeleccionado = idx;
			console.log('Abriendo menu para plato con el id: ', idx);
			if (platos[idx] && !platos[idx].abierto)
			{
				platos[idx].abierto = true;
				renderPlatos();
				console.log('Se renderizo render platos');
			}
			else 
			{
				console.log('NO SE RENDERIZO PLATOS');
			}


			menu_flotante = document.getElementById('menu-flotante').style.display = 'block';
			menu_productos_flotantes = document.getElementById('menu-productos-flotante');

			if (document.getElementById('menu-productos-flotante').innerHTML === '')
			{
				cargarMenu('menu-productos-flotante', false);
				console.log('Se renderizo menu productos flotantes');
			}
			else
			{
				console.log('no se renderizo menu productos flotantes: ', menu_productos_flotantes.innerHTML)
			}
		}

		function abrirMenuLlevar()
		{
			console.log("Abriendo menú para llevar");

			// Limpiar el contenido anterior del menú flotante
			document.getElementById('menu-productos-flotante').innerHTML = '';

			document.getElementById('menu-flotante').style.display = 'block';

			cargarMenu('menu-productos-flotante', true);
		}

        // UN event listener para cerrarMenuFlotante
        document.addEventListener('click', function(e) 
        {
            const btnCerrarMenuFlotante = e.target.closest('.btn-cerrar-menu-flotante');
            if (btnCerrarMenuFlotante)
            {
                e.preventDefault();
				cerrarMenuFlotante();
                return;
            }
        });
		
		function cerrarMenuFlotante()
		{
			document.getElementById('menu-flotante').style.display = 'none';
		}

		window.togglePlato = (idx) => { if (platos[idx]) { platos[idx].abierto = !platos[idx].abierto; renderPlatos(); guardarMesa(); } };

		window.eliminarPlato = (idx) => { if (confirm('¿Eliminar este plato?')) { platos.splice(idx, 1); if (platoSeleccionado === idx) platoSeleccionado = null; if (platoSeleccionado > idx) platoSeleccionado--; renderPlatos(); guardarMesa(); actualizarContador(); } };

		window.cambiarCantidad = (platoIdx, itemIdx, delta) => {

			if (platos[platoIdx]?.items[itemIdx])
			{
				const item = platos[platoIdx].items[itemIdx];

				const nueva = item.cantidad + delta;

				if (nueva <= 0) platos[platoIdx].items.splice(itemIdx, 1);

				else item.cantidad = nueva;

				renderPlatos(); guardarMesa(); actualizarContador();
			}
		};

		window.eliminarItem = (platoIdx, itemIdx) => { if (platos[platoIdx]?.items[itemIdx]) { platos[platoIdx].items.splice(itemIdx, 1); renderPlatos(); guardarMesa(); actualizarContador(); } };

		function mostrarResumen()
		{
			document.getElementById('res-mesa').innerText = mesaActual;

			document.getElementById('res-codigo').innerHTML = codigoActual ? `<i class="fas fa-qrcode"></i> Código: <strong>${codigoActual}</strong>` : '<i class="fas fa-info-circle"></i> Sin pedido activo';

			const total = calcularTotal();

			document.getElementById('res-total').innerText = total.toFixed(2);

			let html = '';

			platos.forEach((plato, idx) => {

				let totalPlato = 0;

				html += `<div class="resumen-plato" style="border-left-color: ${colores[idx % colores.length]}; margin-bottom: 15px; padding: 10px; border-left: 4px solid;"><strong><i class="fas fa-utensils"></i> PLATO ${idx + 1}</strong><br>`;

				if (plato.items)
				{
					plato.items.forEach(item => {

						const precio = getPrecioFinal(item);

						totalPlato += precio * item.cantidad;

						html += `&nbsp;&nbsp;• ${item.enviado ? '<i class="fas fa-check-circle" style="color:#28a745;"></i>' : '<i class="fas fa-clock" style="color:#ff9800;"></i>'} ${item.cantidad}x ${item.nombre}`;

						if (item.extras?.quesoExtra) html += ` <i class="fas fa-cheese"></i> Queso Extra`;

						html += ` = <strong>$${(precio * item.cantidad).toFixed(2)}</strong><br>`;

						if (item.extras?.preparacion)
						{
							if (item.extras.preparacion === 'frita') html += `&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-fire"></i> Frita<br>`;

							else if (item.extras.preparacion === 'comal') html += `&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-egg"></i> Al Comal<br>`;
						}

						if (item.extras?.tipo_pambazo)
						{
							if (item.extras.tipo_pambazo === 'adobado') html += `&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-pepper-hot"></i> Adobado<br>`;

							else if (item.extras.tipo_pambazo === 'natural') html += `&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-leaf"></i> Natural<br>`;
						}

						if (item.extras?.cebolla) html += `&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-onion"></i> Cebolla<br>`;

						if (item.extras?.nota && item.extras.nota !== '') html += `&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-sticky-note"></i> ${item.extras.nota}<br>`;
					});
				}
				html += `<strong>Subtotal: $${totalPlato.toFixed(2)}</strong></div>`;
			});

			html += `<div class="resumen-plato" style="margin-top:10px;"><strong><i class="fas fa-pepper-hot"></i> SALSAS DEL PEDIDO:</strong> ${obtenerSalsasPedido()}</div>`;

			document.getElementById('resumen-lista').innerHTML = html || '<div style="text-align:center; padding:20px;"><i class="fas fa-info-circle"></i> Sin productos</div>';

			document.getElementById('resumen-modal').classList.add('abierto');
		}

		

		async function cambiarMesa(mesa)
		{
			if (mesaActual === mesa) return;

			await guardarMesa();

			mesaActual = mesa;

			platoSeleccionado = null;

			await cargarMesa(mesaActual);

			document.querySelectorAll('.mesa-btn').forEach(btn => {
				btn.classList.remove('seleccionada');
				if (parseInt(btn.dataset.mesa) === mesa) btn.classList.add('seleccionada');
			});
			mostrarToast(`Cambiaste a MESA ${mesa}`, true);
		}

		function abrirModalPago()
		{
			const total = calcularTotal();

			if (total === 0) { mostrarToast('No hay productos para cobrar', false); return; }

			document.getElementById('pago-total').innerText = total.toFixed(2);

			document.getElementById('monto-entregado').value = '';

			document.getElementById('cambio-calculo').innerHTML = '';

			document.getElementById('modal-pago').classList.add('abierto');

			document.getElementById('monto-entregado').oninput = function() {

				const total = parseFloat(document.getElementById('pago-total').innerText);

				const monto = parseFloat(this.value) || 0;

				if (monto >= total)
				{
					document.getElementById('cambio-calculo').innerHTML = `<i class="fas fa-money-bill"></i> Cambio: $${(monto - total).toFixed(2)}`;
				} 
				else if (monto > 0)
				{
					document.getElementById('cambio-calculo').innerHTML = `<i class="fas fa-exclamation-triangle"></i> Faltan $${(total - monto).toFixed(2)}`;
				} 
				else
				{
					document.getElementById('cambio-calculo').innerHTML = '';
				}
			};

			document.getElementById('metodo-pago').onchange = function() {
				document.getElementById('campos-efectivo-pago').style.display = this.value === 'efectivo' ? 'block' : 'none';
			};
		}

        // UN event listener para cerrarModalPago
        document.addEventListener('click', function(e) 
        {
            const btnCerrarModalPago = e.target.closest('.btn-cerrar-modal-pago');
            if (btnCerrarModalPago)
            {
                e.preventDefault();
				cerrarModalPago();
                return;
            }
        });
		
		function cerrarModalPago() { document.getElementById('modal-pago').classList.remove('abierto'); }

        // UN event listener para cerrarModalTicket
        document.addEventListener('click', function(e) 
        {
            const btnCerrarModalTicket = e.target.closest('.btn-cerrar-modal-ticket');
            if (btnCerrarModalTicket)
            {
                e.preventDefault();
				cerrarModalTicket();
                return;
            }
        });
		function cerrarModalTicket() { document.getElementById('modal-ticket').classList.remove('abierto'); }

        // UN event listener para confirmarCobro
        document.addEventListener('click', function(e) 
        {
            const btnConfirmarCobro = e.target.closest('.btn-confirmar-cobro');
            if (btnConfirmarCobro)
            {
                e.preventDefault();
				confirmarCobro();
                return;
            }
        });
		
		async function confirmarCobro()
		{
			const total = parseFloat(document.getElementById('pago-total').innerText);

			const metodoPago = document.getElementById('metodo-pago').value;

			let montoEntregado = 0;		

			if (metodoPago === 'efectivo')
			{
				montoEntregado = parseFloat(document.getElementById('monto-entregado').value) || 0;
				if (montoEntregado < total)
				{
					mostrarToast(`El monto entregado ($${montoEntregado.toFixed(2)}) es menor al total ($${total.toFixed(2)})`, false);
					return;
				}
			}

			const productosActuales = JSON.parse(JSON.stringify(platos));

			const data = await hacerFetch({ 
				action: 'cobrar', 
				mesa: mesaActual, 
				metodo_pago: metodoPago, 
				monto_entregado: montoEntregado 
			});

			if (data?.success)
			{
				mostrarToast(`Mesa ${mesaActual} cobrada exitosamente! Total: $${data.total.toFixed(2)}`, true);

				let productosLista = [];

				productosActuales.forEach(plato => {
					if (plato.items) plato.items.forEach(item => {
						productosLista.push({

							nombre: item.nombre, cantidad: item.cantidad, precioBase: item.precioBase,

							precioFinal: getPrecioFinal(item),

							extras: item.extras
						});
					});
				});

				const fecha = new Date().toLocaleString();

				let itemsHTML = '';

				productosLista.forEach(item => {
					
					itemsHTML += `<div><strong>${item.cantidad}x ${item.nombre}</strong> - $${(item.precioFinal * item.cantidad).toFixed(2)}</div>`;

					if (item.extras?.preparacion)
					{
						if (item.extras.preparacion === 'frita') itemsHTML += `<div style="font-size:11px; margin-left:15px;"><i class="fas fa-fire"></i> Frita</div>`;

						else if (item.extras.preparacion === 'comal') itemsHTML += `<div style="font-size:11px; margin-left:15px;"><i class="fas fa-egg"></i> Al Comal</div>`;
					}

					if (item.extras?.tipo_pambazo)
					{
						if (item.extras.tipo_pambazo === 'adobado') itemsHTML += `<div style="font-size:11px; margin-left:15px;"><i class="fas fa-pepper-hot"></i> Adobado</div>`;

						else if (item.extras.tipo_pambazo === 'natural') itemsHTML += `<div style="font-size:11px; margin-left:15px;"><i class="fas fa-leaf"></i> Natural</div>`;
					}

					if (item.extras?.cebolla) itemsHTML += `<div style="font-size:11px; margin-left:15px;"><i class="fas fa-onion"></i> Cebolla</div>`;

					if (item.extras?.nota && item.extras.nota !== '') itemsHTML += `<div style="font-size:11px; margin-left:15px;"><i class="fas fa-sticky-note"></i> ${item.extras.nota}</div>`;
				});

				document.getElementById('ticket-html').innerHTML = `

					<div style="text-align:center"><h2 style="color:#FF5700">QUESAGINA'S</h2><p>${fecha}</p></div>

					<div><strong>MESA: ${mesaActual}</strong><br>Método: ${metodoPago === 'efectivo' ? '<i class="fas fa-money-bill"></i> Efectivo' : '<i class="fas fa-credit-card"></i> Tarjeta'}</div>

					<div style="border-top:1px dashed #000; margin:10px 0">${itemsHTML}</div>

					<div style="text-align:right; font-size:20px"><strong>TOTAL: $${data.total.toFixed(2)}</strong></div>

					<button class="btn-whatsapp-modal" onclick="compartirWhatsAppTicket()"><i class="fab fa-whatsapp"></i> Compartir</button>

					<button class="btn-imprimir-modal" onclick="imprimirTicket()"><i class="fas fa-print"></i> Imprimir</button>
				`;

				document.getElementById('modal-ticket').classList.add('abierto');			

				platos = [];

				codigoActual = null;

				renderPlatos();

				actualizarContador();

				cerrarModalPago();

				const btnMesa = document.querySelector(`.mesa-btn[data-mesa="${mesaActual}"]`);

				if (btnMesa)
				{
					btnMesa.classList.remove('ocupada');
					const estadoSpan = btnMesa.querySelector('.mesa-estado');
					if (estadoSpan) estadoSpan.remove();
				}
				await guardarMesa();
			}
		}

		document.getElementById('btn-buscar-pedido')?.addEventListener('click', async () => {

			const codigo = document.getElementById('codigo-entrega').value.trim();
			if (!codigo || codigo.length !== 4)
			{ 
				mostrarToast('Ingrese un código de 4 dígitos', false); return;
			}

			mostrarToast('Buscando pedido...', true);

			const data = await hacerFetch({ 
				action: 'buscar_pedido_activo', 
				codigo: codigo 
			});

			if (data?.success && data.pedido)
			{
				pedidoAEntregar = data.pedido;

				document.getElementById('codigo-pedido-mostrar').innerHTML = `<i class="fas fa-key"></i> ${pedidoAEntregar.codigo_seguridad || codigo}`;

				document.getElementById('cliente-nombre').innerText = pedidoAEntregar.nombre_cliente;

				document.getElementById('pedido-total').innerText = parseFloat(pedidoAEntregar.total).toFixed(2);

				document.getElementById('pedido-fecha').innerText = new Date(pedidoAEntregar.fecha_creacion).toLocaleString();

				document.getElementById('info-pedido-entrega').style.display = 'block';
			}
			else
			{
				mostrarToast('Pedido no encontrado o ya fue entregado', false);
				document.getElementById('info-pedido-entrega').style.display = 'none';
				pedidoAEntregar = null;
			}
		});

		document.getElementById('btn-confirmar-entrega')?.addEventListener('click', async () => {

			if (!pedidoAEntregar)
			{ 
				mostrarToast('No hay pedido seleccionado', false); return;
			}

			if (confirm(`Confirmar entrega del pedido de ${pedidoAEntregar.nombre_cliente} por $${parseFloat(pedidoAEntregar.total).toFixed(2)}?`))
			{
				const data = await hacerFetch({ 
					action: 'confirmar_entrega', 
					pedido_id: pedidoAEntregar.id 
				});
				if (data?.success)
				{
					mostrarToast(`Pedido entregado a ${pedidoAEntregar.nombre_cliente}`, true);
					
					document.getElementById('codigo-entrega').value = '';
					
					document.getElementById('info-pedido-entrega').style.display = 'none';

					pedidoAEntregar = null;
				} 
				else
				{
					mostrarToast('Error al entregar pedido', false);
				}
			}
		});

		document.getElementById('codigo-entrega')?.addEventListener('keypress', (e) => { if (e.key === 'Enter') document.getElementById('btn-buscar-pedido').click(); });

		document.querySelectorAll('.nav-btn').forEach(btn => {

			btn.addEventListener('click', () => {
				const section = btn.dataset.section;

				if (!section) return;

				document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));

				document.querySelectorAll('.section-content').forEach(c => c.classList.remove('active'));

				btn.classList.add('active');

				document.getElementById(`section-${section}`).classList.add('active');

				if (section === 'llevar')
				{
					cargarPedidosLlevar();
				} 
				else if (section === 'entregar')
				{
					setTimeout(() => document.getElementById('codigo-entrega')?.focus(), 100);
				}
			});
		});

		document.getElementById('btn-agregar-plato')?.addEventListener('click', () => {
			platos.push({ id: Date.now(), items: [], abierto: true });

			renderPlatos();

			guardarMesa();

			mostrarToast(`Nuevo plato agregado`, true);
		});

		document.getElementById('btn-agregar-item-llevar')?.addEventListener('click', () => abrirMenuLlevar());

		document.getElementById('btn-enviar-cocina-llevar')?.addEventListener('click', () => enviarPedidoLlevarACocina());

		document.getElementById('cart-btn')?.addEventListener('click', () => mostrarResumen());

		document.getElementById('enviar-cocina')?.addEventListener('click', () => enviarCocina());

		document.getElementById('cobrar-mesa')?.addEventListener('click', () => abrirModalPago());

		document.getElementById('cerrar-resumen')?.addEventListener('click', () => document.getElementById('resumen-modal').classList.remove('abierto'));

		document.getElementById('confirmar-extras')?.addEventListener('click', () => confirmarExtras());

		document.getElementById('cancelar-extras')?.addEventListener('click', () => cerrarModalExtras());

		window.compartirWhatsAppTicket = () => {

			const telefono = prompt("Número del cliente (10 dígitos):", "");

			if (telefono?.length >= 10)
			{
				const ticketText = document.getElementById('ticket-html').innerText;
				window.open(`https://wa.me/52${telefono}?text=${encodeURIComponent(ticketText)}`, '_blank');
			}
		};

		window.imprimirTicket = () => {
			const ventana = window.open('', '_blank');

			ventana.document.write(`<html><head><title>Ticket</title><style>body{font-family:monospace;width:300px;margin:0 auto;padding:20px;}</style></head><body>${document.getElementById('ticket-html').innerHTML}</body></html>`);

			ventana.document.close();

			ventana.print();

			ventana.close();
		};

		document.querySelectorAll('.mesa-btn').forEach(btn => {
			btn.addEventListener('click', () => cambiarMesa(parseInt(btn.dataset.mesa)));
		});

		cargarMesa(1);

		const primerMesa = document.querySelector('.mesa-btn[data-mesa="1"]');

		if (primerMesa) primerMesa.classList.add('seleccionada');			

		cargarMenu('menu-productos', false);

		setInterval(() => {
			if (document.getElementById('section-llevar').classList.contains('active'))
			{
				cargarPedidosLlevar();
			}
		}, 3000);

		setTimeout(() => {
			cargarPedidosLlevar();
		}, 500);	

		document.addEventListener('keydown', (e) => {
			if (document.getElementById('section-tomar')?.classList.contains('active'))
			{
				if (e.key === 'z' || e.key === 'Z') { e.preventDefault(); enviarCocina(); }
				else if (e.key === 'x' || e.key === 'X') { e.preventDefault(); mostrarResumen(); }
			}
		});

	});
})(); 

// Asi evitamos que haya una reasignacion del valor de variablas en caso de que existan con el mismo nombre pero en diferentes archivos