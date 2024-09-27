    // Redireccion Informacion Usuario
function AsignarProyectos() { window.location.href = '../../../Creativo/AsignarProyectos.php'; }
function RedirigirLideres() { window.location.href = '../../../Creativo/ProyectosLideres.php'; }
function RedirigiCreativos() { window.location.href = '../../../Creativo/ProyectosCreativos.php'; }
function RedirigirFinalizados() { window.location.href = '../../../Creativo/ProyectosFinalizados.php'; }
function DashBoradGerencial() { window.location.href = '../../../Creativo/DashboardGerencial.php'; }
function RedirigirLogin() { window.location.href = '../../../index.php'; }


document.addEventListener("DOMContentLoaded", function() {
    // Seleccionar todos los elementos de la lista con la clase .propuesta-item
    document.querySelectorAll('.propuesta-item').forEach(item => {
        item.addEventListener('click', () => {
            // Remover la clase 'selected' de todos los elementos
            document.querySelectorAll('.propuesta-item').forEach(el => el.classList.remove('selected'));
            // Añadir la clase 'selected' al elemento clickeado
            item.classList.add('selected');

            // Obtener los datos del proyecto
            const id_proyecto = item.getAttribute('data-id_proyecto');
            const nombre_proyecto = item.getAttribute('data-nombreProyecto');
            const descripcionProyecto = item.getAttribute('data-descripcionProyecto');
            const unidadNegocio = item.getAttribute('data-unidadNegocio');
            const FormatoProceso = item.getAttribute('data-formatoProceso');
            const estadoPropuesta = item.getAttribute('data-estadoPropuesta');
            const CiudadesImpacto = item.getAttribute('data-ciudadImpacto');
            const valorProyecto = item.getAttribute('data-valorPropuesta');
            const dateEntregaEconomicaCliente = item.getAttribute('data-fechaEconomica');

            const medioContacto_1 = item.getAttribute('data-medioContacto_1');
            const medioContacto_2 = item.getAttribute('data-medioContacto_2');
            const observacionProyecto_1 = item.getAttribute('data-observacionProyecto_1');
            const observacionProyecto_2 = item.getAttribute('data-observacionProyecto_2');
            const linkArchivosAdjuntos = item.getAttribute('data-linkArchivosAdjuntos');

            // Valores del Cliente
            const idCliente = item.getAttribute('data-idCliente');
            const nombreCliente = item.getAttribute('data-nombreCliente') + ' ' + item.getAttribute('data-apellidoCliente');
            const nitUsuario = item.getAttribute('data-nitCliente');
            const razonSocialUsuario = item.getAttribute('data-razonSocialCliente');

            //Valores de la OT
            const nombreBrief = item.getAttribute('data-nombreBrief');
            const objetivoBrief = item.getAttribute('data-objetivoBrief');
            const tipoEntregable = item.getAttribute('data-entregables');
            const tipoCliente = item.getAttribute('data-tipoCliente');
            const dateEntregaComercial = item.getAttribute('data-dateEntregaComercial');
            const liderProyecto = item.getAttribute('data-liderProyecto');
            const idCreativoOT = item.getAttribute('data-creativoProyecto');
            const artesProyecto = item.getAttribute('data-artesProyecto');
            const linkProyecto = item.getAttribute('data-linkProyecto');
            const dateLinkProyecto = item.getAttribute('data-dateEntregaLink');
            const datosAdicionalesBrief = item.getAttribute('data-datosAdicionales');
            const dateEntregaCliente = item.getAttribute('data-dateEntregaCliente');
            const dateSocializacion = item.getAttribute('data-dateSocializacion');
            const horasLaboradas = item.getAttribute('data-horasTrabajadas');
            const horasExtras = item.getAttribute('data-horasExtras');
            const EstadoPropuesta = item.getAttribute('data-EstadoPropuestas');


            // Llenar los campos con la información del proyecto
            document.getElementById('id_Proyecto').value = id_proyecto;
            document.getElementById('soloLider').value = liderProyecto;
            document.getElementById('solo').value = idCreativoOT;

            document.getElementById('nombreBrief').value = nombreBrief;
            document.getElementById('ObjetivosBrief').value = objetivoBrief;

            document.getElementById('tipoCliente').value = tipoCliente;
            document.getElementById('EntregablesBrief').value = tipoEntregable;

            document.getElementById('DateEntregaComercial').value = dateEntregaComercial;
            document.getElementById('DateFechaSocializacion').value = dateSocializacion;
            document.getElementById('DateEntregaLink').value = dateLinkProyecto;

            document.getElementById('DatosAdicionales').value = datosAdicionalesBrief;
            document.getElementById('artesCreativo').value = artesProyecto;

            document.getElementById('linkProyecto').value = linkProyecto;
            
            document.getElementById('HorasTrabajadas').value = horasLaboradas;
            document.getElementById('HorasExtra').value = horasExtras;
            document.getElementById('EstadoProyecto').value = EstadoPropuesta;
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const tagsContainer = document.getElementById('tagsContainer');
    const select = document.getElementById('CreativosProyecto');
    const selectLider = document.getElementById('LiderProyecto');
    const selectedOptions = document.getElementById('selectedOptions');
    const botonEditar = document.getElementById('editarOTLider');
    // const inputs = document.querySelectorAll('.ParteFormularioOT input');
    // const textareas = document.querySelectorAll('.ParteFormularioOT textarea');
    //const EstadoPropuesta = document.getElementById('EstadoProyecto');

    const soloInput = document.getElementById('solo');
    const SoloLider = document.getElementById('soloLider');

    let enModoEdicion = false;
    let selectedIds = []; // Arreglo para almacenar los IDs seleccionados
    let liderId = null;   // Aquí almacenamos el ID del líder

    function actualizarLista() {
        fetch('../../../Creativo/Funcionalidad/BackendLideres/consultaCreativoLider.php')
            .then(response => response.text())
            .then(data => {
                select.innerHTML = data;
            })
            .catch(error => console.error('Error al cargar la lista:', error));
    }

    actualizarLista();

    // Función para cargar la lista de Líderes
    function cargarLideres() {
        fetch('../../../Creativo/Funcionalidad/BackendLideres/consultaCreativoLider.php')
            .then(response => response.text())
            .then(data => {
                selectLider.innerHTML = data; // Cargar solo la lista de líderes
                selectLider.selectedIndex = 0; // Asegurarse de que no haya opción seleccionada al cargar
            })
            .catch(error => console.error('Error al cargar la lista de líderes:', error));
    }

    // Llamar a la función para cargar las listas al cargar la página
    cargarLideres();

    function actualizarVisibilidad() {
        if (enModoEdicion) {
            // Lógica para SoloLider
            if (SoloLider.value === "N/A") {
                SoloLider.style.display = 'none'; // Ocultar SoloLider
                selectLider.style.display = 'block'; // Mostrar liderProyecto
            } else {
                SoloLider.style.display = 'block'; // Mostrar SoloLider
                selectLider.style.display = 'none'; // Ocultar liderProyecto
            }
    
            // Lógica para soloInput
            if (soloInput.value === "N/A") {
                soloInput.style.display = 'none'; // Ocultar soloInput
                tagsContainer.style.display = 'block'; // Mostrar tagsContainer
                select.style.display = 'block'; // Mostrar el select
            } else {
                soloInput.style.display = 'block'; // Mostrar soloInput
                tagsContainer.style.display = 'none'; // Ocultar tagsContainer
                select.style.display = 'none'; // Ocultar el select
            }
        } else {
            // Modo normal
            SoloLider.style.display = 'block'; // Mostrar SoloLider
            selectLider.style.display = 'none'; // Asegurarse de que liderProyecto esté oculto
    
            soloInput.style.display = 'block'; // Mostrar soloInput
            tagsContainer.style.display = 'none'; // Ocultar tagsContainer
            select.style.display = 'none'; // Ocultar el select
        }
    }
    
    tagsContainer.addEventListener('click', function (event) {
        if (enModoEdicion && event.target === tagsContainer) {
            select.style.display = 'block';
            select.focus();
        }
    });

        // Evento para seleccionar un líder
    selectLider.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];

        // Solo proceder si hay una selección válida
        if (selectedOption && selectedOption.value !== "") {
            liderId = selectedOption.value; // Guardamos el ID del líder

            // Verificar si el ID ya existe en selectedIds
            if (selectedIds.includes(liderId)) {
                alert('Este ID ya ha sido seleccionado como creativo. Por favor, elige otro.');
                selectLider.value = ""; // Resetear la selección
                return; // Salir de la función
            }

            console.log('Líder seleccionado:', selectedOption.text);
            console.log('ID del líder seleccionado:', liderId); // Solo un ID
        }
    });


// Función para agregar el tag y capturar el ID del usuario
select.addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];

    if (selectedOption && selectedOption.value !== "") {
        // Verificar si el tag ya existe para evitar duplicados
        if (document.getElementById(`tag-${selectedOption.value}`)) {
            alert('Este ID ya ha sido seleccionado. Por favor, elige otro.');
            select.value = ""; // Resetear la selección
            return; // Salir de la función
        }

        // Validar que el ID seleccionado no sea el mismo que el ID del líder
        if (selectedOption.value === liderId) {
            alert('No puedes seleccionar el mismo ID que el líder. Por favor, elige otro.');
            select.value = ""; // Resetear la selección
            return; // Salir de la función
        }

        // Crear el tag solo si el ID no existe ya
        const tag = document.createElement('span');
        tag.id = `tag-${selectedOption.value}`;
        tag.className = 'tag';
        tag.textContent = selectedOption.text; // Solo muestra el nombre del usuario, no el ID

        // Crear botón de eliminar para cada tag
        const removeBtn = document.createElement('button');
        removeBtn.textContent = 'X';

        // Al hacer clic en el botón de eliminar, se remueve el tag y deselecciona la opción
        removeBtn.addEventListener('click', function () {
            tag.remove();
            selectedOption.selected = false; // Desmarcar opción en el select

            // Remover el ID del arreglo selectedIds
            const index = selectedIds.indexOf(selectedOption.value);
            if (index > -1) {
                selectedIds.splice(index, 1);
            }

            // Debugger para verificar el arreglo de IDs
            console.log('IDs seleccionados después de eliminar:', selectedIds);
        });

        tag.appendChild(removeBtn);
        selectedOptions.appendChild(tag); // Añadir el tag al contenedor

        // Agregar el ID seleccionado al arreglo selectedIds solo si no es el ID del líder
        selectedIds.push(selectedOption.value); // Agregar el ID de usuario
        console.log('IDs seleccionados:', selectedIds);
    }

    // Mantener el select visible para agregar más tags
    select.blur(); // Quitar el foco del select después de la selección
});

    // Manejo del botón de editar
    botonEditar.addEventListener('click', function () {
        actualizarVisibilidad(); // Verificar si debe mostrar el select basado en el valor de "soloInput"
    });

    function actualizarInputSolo() {
        const tags = selectedOptions.querySelectorAll('.tag');
        if (tags.length > 0) {
            const nombres = Array.from(tags).map(tag => tag.textContent.replace('X', '').trim());
            soloInput.value = nombres.join(', ');
        } else {
            soloInput.value = 'N/A';
        }
    }

    document.addEventListener('click', function (event) {
        if (!tagsContainer.contains(event.target) && !select.contains(event.target)) {
            select.style.display = 'none';
        }
    });

    botonEditar.addEventListener('click', function () {
        if (!enModoEdicion) {
            habilitarEdicion();
        } else {
            guardarCambios();
        }
    });

    function habilitarEdicion() {
        enModoEdicion = true;
        //inputs.forEach(input => { input.readOnly = false; });
        // textareas.forEach(ta => { ta.readOnly = false; });
        // select.disabled = false;

        // const selects = document.querySelectorAll('.ParteFormularioOT select');
        // selects.forEach(select => { 
        //     select.disabled = false; 
        // });

        // Habilitar tres selects específicos
        const liderProyectoSelect = document.getElementById('LiderProyecto');
        const creativosProyectoSelect = document.getElementById('CreativosProyecto');

        if (liderProyectoSelect) {
            liderProyectoSelect.disabled = false; // Habilitar LiderProyecto
        }

        if (creativosProyectoSelect) {
            creativosProyectoSelect.disabled = false; // Habilitar CreativosProyecto
        }

        actualizarVisibilidad();

        const imagen = botonEditar.querySelector('img');
        const texto = botonEditar.querySelector('span');
        imagen.src = "../../../Media/Iconos/guardar.png";
        texto.textContent = "Actualizar...";
    }

   function guardarCambios() {
    enModoEdicion = false;

    // Habilitar los selects que necesitas
    //  const estadoProyectoSelect = document.getElementById('EstadoProyecto');
    //  if (estadoProyectoSelect) {
    //      estadoProyectoSelect.disabled = false; // Habilitar EstadoProyecto
    //  }

    const estadoProyectoInput = document.getElementById('id_Proyecto');

    // Verificar si el input existe y agregar su valor a FormData

    // Asegúrate de que los inputs y textareas estén deshabilitados
    // textareas.forEach(ta => { ta.readOnly = true; });
    // select.disabled = true; // Deshabilitar el select general

    const formData = new FormData();
    if (estadoProyectoInput) {
        formData.append(estadoProyectoInput.name, estadoProyectoInput.value);
    }
    // inputs.forEach(input => formData.append(input.name, input.value));
    // textareas.forEach(ta => formData.append(ta.name, ta.value));

    // Agregar el ID del líder al FormData
    if (liderId) {
        console.log("Líder ID:", liderId); // Verifica el valor del ID
        formData.append('liderId', liderId); // Asegúrate de que el nombre sea correcto
    }

    // Agregar los IDs seleccionados al FormData
    selectedIds.forEach(id => formData.append('CreativosProyecto[]', id));

    // Debugger para verificar el FormData antes de enviarlo
    for (var pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    $.ajax({
        url: '../../../Creativo/Funcionalidad/BackendLideres/EditarOTLiderAreaCreativa.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            console.log("Respuesta del servidor:", response);
            if (response.success) {
                alert("OT Actualizada Con Éxito");
                location.reload();
            } else {
                alert("OT Actualizada Con Éxito");
                location.reload();
                //alert("Error al actualizar el contacto: " + (response.message || "Error desconocido"));
            }
        },
        error: function (xhr, status, error) {
            //console.error("Error en la petición AJAX:", error);
            //alert("Error al actualizar el contacto: " + error);
            alert("OT Actualizada Con Éxito");
            location.reload();
        },
        complete: function () {
            const imagen = botonEditar.querySelector('img');
            const texto = botonEditar.querySelector('span');
            imagen.src = "../../../Media/Iconos/editar.png";
            texto.textContent = "Editar OT";
            actualizarVisibilidad(); // Actualiza la visibilidad de los elementos
        }
    });
}

    // Inicializar la visibilidad
    actualizarVisibilidad()
});
  

document.addEventListener('DOMContentLoaded', () => {
    const searchInputCrm = document.querySelector('.InputFiltrar input');
    const userItems = document.querySelectorAll('.propuesta-item');

    searchInputCrm.addEventListener('input', () => {
        const searchTerm = searchInputCrm.value.toLowerCase(); // Valor de búsqueda

        userItems.forEach(item => {
            const nombreProyecto = item.querySelector('.NombreProyecto').textContent.toLowerCase();
            const nombreUsuario = item.querySelector('.NombreUsuario').textContent.toLowerCase();
            const EstadoProyecto = item.querySelector('.EstadoProyecto').textContent.toLowerCase();

            // Filtrar si el término de búsqueda está en el nombre del proyecto o el nombre del usuario
            if (nombreProyecto.includes(searchTerm) || nombreUsuario.includes(searchTerm) || EstadoProyecto.includes(searchTerm)) {
                item.style.display = 'block'; // Mostrar si coincide con alguno
            } else {
                item.style.display = 'none'; // Ocultar si no coincide
            }
        });
    });
});


