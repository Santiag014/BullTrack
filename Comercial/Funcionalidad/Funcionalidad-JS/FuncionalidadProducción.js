    // Redireccion Informacion Usuario
    function RedirigirLogin() { window.location.href = '../../logout.php'; }
    function RedirigirHome() { window.location.href = '../../Comercial/DashboardComercial.php'; }
    function ContactosCRM() { window.location.href = '../../Comercial/ContactosCRMComercial.php'; }
    function RedirigirPropuestas() { window.location.href = '../../Comercial/PropuestasComercial.php'; }
    function RedirigirAvancesOT() { window.location.href = '../../Comercial/AvancesOT.php'; }
    function RedirigirProduccon() { window.location.href = '../../Comercial/Produccion.php'; }
    function RedirigirProduccon() { window.location.href = '../../Comercial/Produccion.php'; }

/*----------------FUncionalidad Propuestas Comercial----------------*/

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
            const nombre_proyecto = item.getAttribute('data-nombre-proyecto');
            const usuarioBull = item.getAttribute('data-userBull');
            const unidadNegocio = item.getAttribute('data-unidadNegocio');
            const fechaInicio = item.getAttribute('data-fechaInicio');
            const descripcionProyecto = item.getAttribute('data-descripcionProyecto');
            const valorProyecto = item.getAttribute('data-valorProyecto');
            const estadoPropuesta = item.getAttribute('data-estadoPropuesta');
            const dateEntregaEconomicaCliente = item.getAttribute('data-dateEntregaEconomicaCliente');
            const medioContacto_1 = item.getAttribute('data-medioContacto_1');
            const medioContacto_2 = item.getAttribute('data-medioContacto_2');
            const observacionProyecto_1 = item.getAttribute('data-observacionProyecto_1');
            const observacionProyecto_2 = item.getAttribute('data-observacionProyecto_2');
            const linkArchivosAdjuntos = item.getAttribute('data-linkArchivosAdjuntos');
            const idCliente = item.getAttribute('data-idCliente');
            const isDeleted = item.getAttribute('data-isDeleted');
            const nombreCliente = item.getAttribute('data-nombreCliente') + ' ' + item.getAttribute('data-apellidoCliente');
            const dateDeletd = item.getAttribute('data-dateDeletd');
            const nitUsuario = item.getAttribute('data-nitCliente');
            const razonSocialUsuario = item.getAttribute('data-razonSocialCliente');
            const CiudadesImpacto = item.getAttribute('data-ciudadesImpacto');
            const NecesitaOT = item.getAttribute('data-NecesitaOT');
            const FormatoProceso = item.getAttribute('data-formatoProceso');

            const nombreBrief = item.getAttribute('data-nombreBrief');
            const objetivoBrief = item.getAttribute('data-objetivoBrief');
            const tipoEntregable = item.getAttribute('data-tipoEntregable');
            const tipoCliente = item.getAttribute('data-tipoCliente');
            const dateEntrega = item.getAttribute('data-dateEntrega');

            // Llenar los campos con la información del proyecto

            document.getElementById('id_Proyecto').value = id_proyecto;
            document.getElementById('NombreCliente').value = nombreCliente;
            document.getElementById('NIT').value = nitUsuario;
            document.getElementById('RazonSocial').value = razonSocialUsuario;
            document.getElementById('NombreProyecto').value = nombre_proyecto;
            document.getElementById('DescipcionProyecto').value = descripcionProyecto;
            document.getElementById('UnidadNegocio').value = unidadNegocio;
            document.getElementById('FormatoProceso').value = FormatoProceso;
            document.getElementById('estadoPropuesta').value = estadoPropuesta;
            document.getElementById('CiudadesImpacto').value = CiudadesImpacto;
            document.getElementById('ValorPropuesta').value = valorProyecto;
            document.getElementById('FechaEntregaEconomica').value = dateEntregaEconomicaCliente;
            document.getElementById('Contacto_1').value = medioContacto_1;
            document.getElementById('Contacto_2').value = medioContacto_2;
            document.getElementById('Observación_1').value = observacionProyecto_1;
            document.getElementById('Observación_2').value = observacionProyecto_2;
            document.getElementById('ArchivosAdjuntosComercial').value = linkArchivosAdjuntos;
        });
    });
});

    //Método de Filtrado
    document.addEventListener('DOMContentLoaded', function() {
        const nombreProyectoInput = document.getElementById('nombreProyecto');
        const estadoSelect = document.querySelector('.InputFiltrar_2 select:first-of-type'); // Selecciona el primer select
        const listaProyectos = document.querySelector('.Lista'); // Selecciona la lista de proyectos
        const userItems = document.querySelectorAll('.propuesta-item');
    
        // Función para filtrar proyectos por nombre y estado
        function filtrarProyectos() {
            const nombreProyecto = nombreProyectoInput.value.toLowerCase();
            const estadoSeleccionado = estadoSelect.value.toLowerCase();
    
            console.log('Filtrando proyectos:');
            console.log('Nombre del Proyecto:', nombreProyecto);
            console.log('Estado seleccionado:', estadoSeleccionado);
    
            // Obtener todos los proyectos en la lista
            const proyectos = listaProyectos.getElementsByClassName('propuesta-item'); // Asegúrate de que 'propuesta-item' está en tus elementos
    
            console.log('Total de proyectos:', proyectos.length);
    
            // Iterar sobre cada proyecto
            for (let i = 0; i < proyectos.length; i++) {
                const proyecto = proyectos[i];
                const estadoProyecto = proyecto.getAttribute('data-estadoPropuesta') ? 
                    proyecto.getAttribute('data-estadoPropuesta').toLowerCase() : ''; 
                const nombreProyectoTextoElement = proyecto.querySelector('.NombreProyecto');
                const nombreProyectoTexto = nombreProyectoTextoElement ? 
                    nombreProyectoTextoElement.textContent.toLowerCase() : '';
    
                console.log(`Filtrando proyecto ${i + 1}:`);
                console.log('Estado del Proyecto:', estadoProyecto);
                console.log('Nombre del Proyecto:', nombreProyectoTexto);
    
                // Verificar condiciones de filtrado
                const cumpleEstado = estadoSeleccionado === '' || estadoProyecto === estadoSeleccionado;
                const cumpleNombre = nombreProyecto === '' || nombreProyectoTexto.includes(nombreProyecto);
    
                console.log('Cumple Estado:', cumpleEstado);
                console.log('Cumple Nombre:', cumpleNombre);
    
                // Mostrar u ocultar proyecto
                if (cumpleEstado && cumpleNombre) {
                    proyecto.style.display = ''; // Mostrar
                    console.log(`Proyecto ${i + 1} mostrado`);
                } else {
                    proyecto.style.display = 'none'; // Ocultar
                    console.log(`Proyecto ${i + 1} oculto`);
                }
            }
        }
        // Event listeners para los inputs
        nombreProyectoInput.addEventListener('input', () => {
            console.log('Cambio en Nombre del Proyecto');
            filtrarProyectos();
        });
    
        estadoSelect.addEventListener('change', () => {
            console.log('Cambio en Estado de Propuesta');
            filtrarProyectos();
        });
    });

    // Función para mostrar/ocultar el formulario
    function toggleParteFormularioOT(NecesitaOT) {
        const parteFormulario = document.getElementById("FormualrioOTRegistroPropuestas");

        // Debug: Comprobar si se encontró el elemento
        if (parteFormulario) {
            console.log("Elemento encontrado:", parteFormulario);
        } else {
            console.error("Elemento no encontrado: FormularioOTRegistroPropuestas");
        }

        if (NecesitaOT === "Si") {
            parteFormulario.style.display = 'block'; // Mostrar el formulario adicional
            console.log("Formulario mostrado.");
        } else {
            parteFormulario.style.display = 'none'; // Ocultar el formulario adicional
            console.log("Formulario oculto.");
        }
    }

    // Parte Encargada de Actualizar un Registro en BullTrack con Consultas Multitablas
    let enModoEdicion = false;

    document.getElementById('editarPropuestasBtn').addEventListener('click', function() {
        const boton = this;
        const imagen = boton.querySelector('img');
        const texto = boton.querySelector('span');
        
        // Seleccionar los inputs del formulario que no se deben habilitar
        const inputs = document.querySelectorAll('.ParteFormularioPropuesta input:not([name="NIT"]):not([name="RazonSocial"]):not([name="NombreCliente"])');
        const selects = document.querySelectorAll('.ParteFormularioPropuesta select'); // Seleccionar todos los selects
        const textarea = document.querySelectorAll('.ParteFormularioPropuesta textarea'); // Seleccionar todos los textarea del FOrmulario Principal

        const id_Proyecto = document.querySelector('input[name="id_Proyecto"]').value; // Obtener el campo `id` del contacto seleccionado

        if (!id_Proyecto) {
            alert("Seleccione un Proyecto Para Editar, Por Favor");
            return;
        }
        
        console.log("Estado actual de enModoEdicion:", enModoEdicion);
    
        if (!enModoEdicion) {
            // Primer clic: Habilitar edición
            console.log("Entrando en modo edición...");
            enModoEdicion = true;
    
            // Habilitar los inputs del formulario principal
            inputs.forEach(input => {
                input.readOnly = false;
                console.log(`Habilitado: ${input.name} = ${input.value}`);
            });

             // Habilitar TextArea de OT
             textarea.forEach(textarea => {
                textarea.readOnly = false;
                console.log(`Habilitado TextArea OT: ${textarea.name}`);
            });
    
            // Habilitar selects
            selects.forEach(select => {
                select.disabled = false;
                console.log(`Habilitado select: ${select.name}`);
            });
            
            imagen.src = "../../../Media/Iconos/guardar.png";
            texto.textContent = "Actualizar...";
        } else {
            // Segundo clic: Guardar cambios
            console.log("Guardando cambios...");
            enModoEdicion = false;
    
            // Deshabilitar los inputs del formulario principal
            textarea.forEach(input => {
                input.readOnly = true;
                console.log(`Deshabilitado: ${input.name} = ${input.value}`);
            });

            inputs.forEach(input => {
                input.readOnly = true;
                console.log(`Deshabilitado: ${input.name} = ${input.value}`);
            });
    
            // Deshabilitar selects
            selects.forEach(select => {
                select.disabled = true;
                console.log(`Deshabilitado select: ${select.name}`);
            });
    
            // Recoger los datos del formulario
            const formData = new FormData();
    
            // Añadir inputs del formulario principal
            inputs.forEach(input => {
                formData.append(input.name, input.value);
                console.log(`Datos a enviar: ${input.name} = ${input.value}`);
            });

            textarea.forEach(input => {
                formData.append(input.name, input.value);
                console.log(`Datos a enviar: ${input.name} = ${input.value}`);
            });
    
            // Añadir selects
            selects.forEach(select => {
                formData.append(select.name, select.value);
                console.log(`Datos a enviar select: ${select.name} = ${select.value}`);
            });
    
            // Mostrar un indicador de carga
            boton.disabled = true;
            texto.textContent = "Actualizando...";
    
            // Mostrar los datos que se están enviando
            for (var pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
    
            // Enviar los datos al servidor usando AJAX
            $.ajax({
                url: '../../../Comercial/Funcionalidad/Backend-Propuestas/ActualizarPropuesta.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    console.log("Respuesta del servidor:", response);
                    if (response.success) {
                        alert("Contacto actualizado con éxito");
                        location.reload(); // Esto recargará la página actual
                    } else {
                        alert("Error al actualizar el contacto: " + (response.message || "Error desconocido"));
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la petición AJAX:", error);
                    alert("Error al actualizar el contacto: " + error);
                },
                complete: function() {
                    // Restaurar el botón a su estado original
                    boton.disabled = false;
                    imagen.src = "../../../Media/Iconos/editar.png";
                    texto.textContent = "Editar";
                }
            });
        }
    });
    
    //Logica Encargada de mnaejar la Seleccion de usuario para Registrar propuesta
    // Declarar la variable globalmente
    let idContactoCrm;

    // Seleccionar todos los elementos con la clase 'user-item'
    document.querySelectorAll('.user-item').forEach(item => {
        item.addEventListener('click', () => {
            // Cambia la clase 'selected' al elemento clicado
            document.querySelectorAll('.user-item').forEach(el => el.classList.remove('selected'));
            item.classList.add('selected');

            // Obtener los datos del contacto
            idContactoCrm = item.getAttribute('data-id');  // Asignar el valor de id_contacto_crm a la variable global
            const nombre = item.getAttribute('data-nombre') +  " " + item.getAttribute('data-apellido');
            const cargo = item.getAttribute('data-cargo');
            const celular = item.getAttribute('data-celular');
            const correo = item.getAttribute('data-correo');
            const empresa = item.getAttribute('data-empresa');
            const ciudad = item.getAttribute('data-ciudad');
            const direccion = item.getAttribute('data-direccion');
            const web = item.getAttribute('data-web');
            const nit = item.getAttribute('data-nit');
            const razon_social = item.getAttribute('data-razon-social');

            // Llenar los campos con la información del contacto
            document.getElementById('id_contacro_crm').value = idContactoCrm;  // Usar la variable global
            document.getElementById('Nombre').value = nombre;
            document.getElementById('Cargo').value = cargo;
            document.getElementById('Celular').value = celular;
            document.getElementById('Correo').value = correo;
            document.getElementById('Empresa').value = empresa;
            document.getElementById('Ciudad').value = ciudad;
            document.getElementById('Direccion').value = direccion;
            document.getElementById('Web').value = web;
            document.getElementById('nit').value = nit;
            document.getElementById('razon_social').value = razon_social;

            // Llenar los campos del formulario con la información del contacto seleccionado
            document.getElementById('NombreCliente').value = nombre;
            document.getElementById('NIT').value = nit;
            document.getElementById('RazonSocial').value = razon_social;
        });
    });

    console.log(idContactoCrm);  

document.addEventListener('DOMContentLoaded', () => {
    // Filtrado de las clases de los Usuarios en CRM
    const searchInputCrm = document.getElementById('nombreProyecto'); // Cambiado a ID correcto
    const userItems = document.querySelectorAll('.propuesta-item');

    searchInputCrm.addEventListener('input', () => {
        const searchTerm = searchInputCrm.value.toLowerCase();
        
        userItems.forEach(item => {
            const nombreProyecto = item.querySelector('.NombreProyecto').textContent.toLowerCase();
            const nombreCliente = item.querySelector('.ClienteProyecto').textContent.toLowerCase();
            const estadoProyecto = item.querySelector('.EstadoProyecto').textContent.toLowerCase();

            // Verifica si el término de búsqueda está en el nombre del proyecto, nombre del cliente o estado
            if (nombreProyecto.includes(searchTerm) || nombreCliente.includes(searchTerm) || estadoProyecto.includes(searchTerm)) {
                item.style.display = ''; // Mostrar si coincide
            } else {
                item.style.display = 'none'; // Ocultar si no coincide
            }
        });
    });
});


    // Lógica encargada de crear una propuesta y gestionar la visibilidad de la selección de usuario
let enAddRegister = false;

document.getElementById('agregarPropuestasBtn').addEventListener('click', function () {
    const boton = this;
    const imagen = boton.querySelector('img');
    const texto = boton.querySelector('span');

    // Seleccionar los inputs o divs que tienen las clases específicas
    const FormularioPropuestas = document.querySelectorAll('.ParteFormularioPropuesta');
    const SeleccionUsuario = document.querySelectorAll('.SelectUserPropuesta');

    const inputsFormualrioPropuesta = document.querySelectorAll('.ParteFormularioPropuesta input');
    const textareaFormularioPropuesta = document.querySelectorAll('.ParteFormularioPropuesta textarea');
    const selectsFormularioPropuesta = document.querySelectorAll('.ParteFormularioPropuesta select');

    const inputsOT = document.querySelectorAll('.ParteOT input'); // Asegúrate de tener esta clase
    const selectsOT = document.querySelectorAll('.ParteOT select');

    // Verificar el estado del botón para determinar si estamos agregando o guardando
    if (texto.textContent.trim() === "Agregar") {
        console.log("Preparando para agregar una nueva propuesta...");

        // Ocultar elementos de FormularioPropuestas
        FormularioPropuestas.forEach(function (element) {
            element.style.display = 'none'; // Ocultar
        });

        // Mostrar elementos de SeleccionUsuario
        SeleccionUsuario.forEach(function (element) {
            element.style.display = 'block'; // Mostrar
        });

        // Limpiar y deshabilitar los campos de la propuesta y OT
        textareaFormularioPropuesta.forEach(textarea => {
            textarea.value = ''; // Limpiar el valor del textarea
            textarea.readOnly = true; // Deshabilitar para edición
            console.log(`Campo limpiado: ${textarea.name}`);
        });

        [...inputsFormualrioPropuesta, ...inputsOT].forEach(input => {
            input.value = ''; // Limpiar valor
            input.readOnly = true; // Deshabilitar para edición
            console.log(`Campo limpio: ${input.name}`);
        });

        [...selectsFormularioPropuesta, ...selectsOT].forEach(select => {
            select.selectedIndex = 0; // Reiniciar el select
            select.disabled = true; // Deshabilitar
        });

        // Cambiar a estado de guardar
        imagen.src = "../../../Media/Iconos/guardar.png"; // Cambia la imagen a "guardar"
        texto.textContent = "Guardar"; // Cambia el texto a "Guardar"

        // Habilitar los campos para el siguiente clic
        [...inputsFormualrioPropuesta, ...inputsOT].forEach(input => {
            input.readOnly = false; // Habilitar para edición
        });

        [...selectsFormularioPropuesta, ...selectsOT].forEach(select => {
            select.disabled = false; // Habilitar select
        });

        textareaFormularioPropuesta.forEach(textarea => {
            textarea.readOnly = false; // Habilitar para edición
        });

    } else {
        console.log("Guardando nueva propuesta...");

        // Recoger los datos del formulario
        const formData = new FormData();
        [...inputsFormualrioPropuesta, ...inputsOT].forEach(input => {
            formData.append(input.name, input.value);
            console.log(`Datos a enviar: ${input.name} = ${input.value}`);
        });

        textareaFormularioPropuesta.forEach(textarea => {
            formData.append(textarea.name, textarea.value);
            console.log(`Datos a enviar: ${textarea.name} = ${textarea.value}`);
        });

        [...selectsFormularioPropuesta, ...selectsOT].forEach(select => {
            formData.append(select.name, select.value);
            console.log(`Datos a enviar: ${select.name} = ${select.value}`);
        });

        // Agregar la constante 'id_contacto_crm' al FormData
        formData.append('id_contacto_crm', idContactoCrm);
        console.log(`Datos a enviar: id_contacto_crm = ${idContactoCrm}`);

        // Enviar los datos al servidor usando AJAX para agregar la propuesta
        $.ajax({
            url: '../../../Comercial/Funcionalidad/Backend-Propuestas/AgregarPropuesta.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',  // Asegura que jQuery espere una respuesta JSON
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                if (response.success) {
                    alert("Propuesta agregada con éxito");
                    location.reload(); // Refresca la página
                } else {
                    alert("Error al agregar la propuesta: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la petición AJAX:", error);
                alert("Error al agregar la propuesta");
            },
            complete: function() {
                imagen.src = "../../../Media/Iconos/Agregar.png"; // Cambia la imagen de nuevo
                texto.textContent = "Agregar"; // Cambia el texto de nuevo
            }
        });
        
    }
});


    //Logica Encargada de Agregar una nueva OT
    let AddOT = false; // Variable que controla si estamos en modo edición o no

    document.getElementById('AgregarOrdenTrabajo').addEventListener('click', function() {
        const boton = this;
        const imagen = boton.querySelector('img');
        const texto = boton.querySelector('span');
    
        const formularioOT = document.querySelector('.ParteFormularioOT_RegistroPropuestas'); // Selecciona el formulario OT
        const FormulariosPropuesta = document.querySelectorAll('.ParteFormularioPropuesta'); // Selecciona todos los formularios de propuesta
    
        const inputsOT = formularioOT.querySelectorAll('input'); // Seleccionar inputs de OT
        const selectsOT = formularioOT.querySelectorAll('select'); // Seleccionar selects de OT
        const textAreaOT = formularioOT.querySelectorAll('textarea'); // Seleccionar textareas de OT

        const id_Proyecto = document.querySelector('input[name="id_Proyecto"]').value; // Obtener el campo `id` del contacto seleccionado

        if (!id_Proyecto) {
            alert("Seleccione un Proyecto Para Agregar la OT, Por Favor");
            return;
        }
    
        // Si el formulario no está visible, lo mostramos y habilitamos los campos
        if (!AddOT) {
            formularioOT.style.display = 'block'; // Mostrar el formulario OT (si estaba oculto)
            
            // Ocultar todos los formularios de propuesta
            FormulariosPropuesta.forEach(formulario => {
                formulario.style.display = 'none';
            });
    
            // Habilitar los inputs
            inputsOT.forEach(input => {
                input.readOnly = false;
            });
    
            // Habilitar los selects
            selectsOT.forEach(select => {
                select.disabled = false;
            });
    
            // Habilitar los textareas
            textAreaOT.forEach(textarea => {
                textarea.readOnly = false;
            });
    
            // Cambiar la imagen y el texto del botón para "Guardar"
            imagen.src = "../../../Media/Iconos/guardar.png";
            texto.textContent = "Guardar...";
    
            AddOT = true; // Cambiar a modo edición
        } else {
            // Si estamos en modo edición, proceder a guardar los datos
    
            // Deshabilitar los campos después de editar
            inputsOT.forEach(input => {
                input.readOnly = true;
            });
            selectsOT.forEach(select => {
                select.disabled = true;
            });
            textAreaOT.forEach(textarea => {
                textarea.readOnly = true;
            });
    
            // Recoger los datos del formulario
            const formData = new FormData();

            formData.append('id', id_Proyecto);
    
            // Añadir inputs de la parte OT
            inputsOT.forEach(input => {
                formData.append(input.name, input.value);
            });
    
            // Añadir selects de OT
            selectsOT.forEach(select => {
                formData.append(select.name, select.value);
            });
    
            // Añadir TextArea de OT
            textAreaOT.forEach(textarea => {
                formData.append(textarea.name, textarea.value);
            });
    
            // Mostrar un indicador de carga
            boton.disabled = true;
            texto.textContent = "Actualizando...";
    
            // Enviar los datos al servidor usando AJAX
            $.ajax({
                url: '../../../Comercial/Funcionalidad/Backend-Propuestas/AgregarOT.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    console.log("Respuesta del servidor:", response);
                    if (response.success) {
                        alert("Datos guardados con éxito");
                        location.reload(); // Recargar la página
    
                        // Mostrar los formularios de propuesta de nuevo
                        FormulariosPropuesta.forEach(formulario => {
                            formulario.style.display = 'block';
                        });
                    } else {
                        alert("Error al guardar los datos: " + (response.message || "Error desconocido"));
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la petición AJAX:", error);
                    alert("Error al guardar los datos: " + error);
                },
                complete: function() {
                    // Restaurar el botón a su estado original
                    boton.disabled = false;
                    imagen.src = "../../../Media/Iconos/editar.png";
                    texto.textContent = "Editar";
                    AddOT = false; // Volver al modo no edición
                }
            });
        }
    });
    
    //Parte encargada de Elegir el usuario
    document.getElementById('SelectUser').addEventListener('click', function() {
        const boton = this;
        const imagen = boton.querySelector('img');
        const texto = boton.querySelector('span');
        
        // Seleccionar los inputs o divs que tienen las clases específicas
        const FormularioPropuestas = document.querySelectorAll('.ParteFormularioPropuesta');
        const SeleecionUsuario = document.querySelectorAll('.SelectUserPropuesta');
        
        console.log("Estado actual de enAddRegister:", enAddRegister);

        // Ocultar elementos de SeleecionUsuario
        SeleecionUsuario.forEach(function(element) {
            element.style.display = 'none'; // Ocultar
        });

        // Mostrar elementos de FormularioPropuestas
        FormularioPropuestas.forEach(function(element) {
            element.style.display = 'block'; // Mostrar
        });
    });


    //Parte de Encargada de eliminar los Usuarios tanto en el CRM como en BullTrack
    document.getElementById('eliminarPropuestasBtn').addEventListener('click', function() {
    const id_Proyecto = document.querySelector('input[name="id_Proyecto"]').value; // Obtener el campo `id` del contacto seleccionado

    if (!id_Proyecto) {
        alert("No se ha seleccionado un contacto para eliminar.");
        return;
    }

    // Confirmar la eliminación antes de proceder
    if (confirm("¿Estás seguro de que deseas eliminar este Registro?")) {
        console.log("Eliminando registro con id:", id_Proyecto);

        // Recoger los datos necesarios para eliminar (en este caso solo el id del contacto)
        const formData = new FormData();
        formData.append('id', id_Proyecto);

        // Enviar los datos al servidor usando AJAX para eliminar
        $.ajax({
            url: '../../../Comercial/Funcionalidad/Backend-Propuestas/EliminarPropuesta.php', // Cambia a la ruta correcta para eliminar
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                if (response.success) {
                    alert("Contacto eliminado con éxito");
                    location.reload(); // Refresca la página para reflejar los cambios
                } else {
                    alert("Error al eliminar el contacto: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la petición AJAX:", error);
                alert("Error al eliminar el contacto");
            }
        });
    } else {
        console.log("Eliminación cancelada por el usuario.");
    }
});

    





    
    
    
    
    
    










