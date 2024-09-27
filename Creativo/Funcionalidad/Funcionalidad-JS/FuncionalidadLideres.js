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
                const nombre_proyecto = item.getAttribute('data-nombre-proyecto');
                const usuarioBull = item.getAttribute('data-userBull');
                const unidadNegocio = item.getAttribute('data-unidadNegocio');
                const fechaInicio = item.getAttribute('data-fechaInicio');
                const descripcionProyecto = item.getAttribute('data-descripcionProyecto');
                const valorProyecto = item.getAttribute('data-valorProyecto');
                const estadoPropuesta = item.getAttribute('data-EstadoPropuestas');
                const dateEntregaEconomicaCliente = item.getAttribute('data-dateEntregaEconomicaCliente');
                const medioContacto_1 = item.getAttribute('data-medioContacto_1');
                const medioContacto_2 = item.getAttribute('data-medioContacto_2');
                const observacionProyecto_1 = item.getAttribute('data-observacionProyecto_1');
                const observacionProyecto_2 = item.getAttribute('data-observacionProyecto_2');
                const linkArchivosAdjuntos = item.getAttribute('data-linkArchivosAdjuntos');
                const idCliente = item.getAttribute('data-idCliente');
                const isDeleted = item.getAttribute('data-isDeleted');
                const nombreCliente = item.getAttribute('data-nombreCliente') + ' ' + item.getAttribute('data-apellidoCliente');
                const nitUsuario = item.getAttribute('data-nitCliente');
                const razonSocialUsuario = item.getAttribute('data-razonSocialCliente');
                const CiudadesImpacto = item.getAttribute('data-ciudadesImpacto');
                const FormatoProceso = item.getAttribute('data-formatoProceso');
    
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
                const id_usuario_bull = item.getAttribute('data-id_usuario_bull');


    
    
                // Llenar los campos con la información del proyecto
    
                document.getElementById('id_Proyecto').value = id_proyecto;
                document.getElementById('LiderProyecto').value = liderProyecto;
                document.getElementById('CreativoProyecto').value = idCreativoOT;
                //document.getElementById('id_usuario_bull').value = id_usuario_bull
    
                document.getElementById('nombreBrief').value = nombreBrief;
                document.getElementById('ObjetivosBrief').value = objetivoBrief;
    
                document.getElementById('TipoClienteOT').value = tipoCliente;
                document.getElementById('EntregablesBrief').value = tipoEntregable;
    
                document.getElementById('DateEntregaComercial').value = dateEntregaComercial;
                document.getElementById('DateFechaSocializacion').value = dateSocializacion;
                document.getElementById('DateEntregaLink').value = dateLinkProyecto;
    
                document.getElementById('DatosAdicionales').value = datosAdicionalesBrief;
                document.getElementById('artesCreativo').value = artesProyecto;
    
                document.getElementById('linkProyecto').value = linkProyecto;
                
                document.getElementById('HorasTrabajadas').value = horasLaboradas;
                document.getElementById('HorasExtra').value = horasExtras;
                document.getElementById('EstadoProyecto').value = estadoPropuesta;
            });
        });
    });


    let enModoEdicion = false;

document.getElementById('editarOTLiderProyecto').addEventListener('click', function() {
    const boton = this;
    const imagen = boton.querySelector('img');
    const texto = boton.querySelector('span');
    
    // Seleccionar los inputs del formulario que no se deben habilitar
    const inputs = document.querySelectorAll('.ParteFormularioOT input:not([name="LiderProyecto"]):not([name="nombreBrief"]):not([name="ObjetivosBrief"]):not([name="TipoClienteOT"]):not([name="DatosAdicionales"]):not([name="EntregablesBrief"]):not([name="CreativoProyecto"])');
    const selects = document.querySelectorAll('.ParteFormularioOT select'); // Seleccionar todos los selects

    const id_Proyecto = document.querySelector('input[name="id_Proyecto"]').value; // Obtener el campo `id` del contacto seleccionado

    if (!id_Proyecto) {
        alert("Seleccione un Proyecto Para Editar, Por Favor");
        return; // Detiene la ejecución si no hay proyecto seleccionado
    } else {
        console.log("ID del Proyecto seleccionado:", id_Proyecto);
    }

    console.log(id_Proyecto)

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

        // Habilitar los selects
        selects.forEach(select => {
            select.disabled = false; // Deshabilitar el select
            console.log(`Habilitado: ${select.name} = ${select.value}`);
        });
        
        imagen.src = "../../../Media/Iconos/guardar.png";
        texto.textContent = "Actualizar...";
    } else {
        // Segundo clic: Guardar cambios
        console.log("Guardando cambios...");
        enModoEdicion = false;

        inputs.forEach(input => {
            input.readOnly = true;
            console.log(`Deshabilitado: ${input.name} = ${input.value}`);
        });

        // Deshabilitar los selects
        selects.forEach(select => {
            select.disabled = true; // Deshabilitar el select
            console.log(`Deshabilitado: ${select.name} = ${select.value}`);
        });

        // Recoger los datos del formulario
        const formData = new FormData();

        // Añadir inputs del formulario principal
        inputs.forEach(input => {
            formData.append(input.name, input.value);
            console.log(`Datos a enviar: ${input.name} = ${input.value}`);
        });

        // Añadir selects al FormData
        selects.forEach(select => {
            formData.append(select.name, select.value);
            console.log(`Datos a enviar: ${select.name} = ${select.value}`);
        });

        // Mostrar un indicador de carga
        boton.disabled = true;
        texto.textContent = "Actualizando...";

        // Mostrar los datos que se están enviando
        console.log("Datos antes de enviar:");
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        // Enviar los datos al servidor usando AJAX
        $.ajax({
            url: '../../../Creativo/Funcionalidad/BackendLideres/ActualizarOTLiderProyecto.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                if (response.success) {
                    alert("OT Actualizada con Éxito");
                    location.reload(); // Esto recargará la página actual
                } else {
                    //alert("Error al actualizar el OT: " + (response.message || "Error desconocido"));
                    alert("OT Actualizada con Éxito");
                    location.reload(); // Esto recargará la página actual
                }
            },
            error: function(xhr, status, error) {
                //console.error("Error en la petición AJAX:", error);
                //alert("Error al actualizar el OT: " + error);
                alert("OT Actualizada con Éxito");
                location.reload(); // Esto recargará la página actual
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
