    // Redireccion Informacion Usuario
    function RedirigirLogin() { window.location.href = '../../logout.php'; }
    function RedirigirHome() { window.location.href = '../../Comercial/DashboardComercial.php'; }
    function ContactosCRM() { window.location.href = '../../Comercial/ContactosCRMComercial.php'; }
    function RedirigirPropuestas() { window.location.href = '../../Comercial/PropuestasComercial.php'; }
    function RedirigirProduccon() { window.location.href = '../../../Comercial/Producción.php'; }
    function RedirigirAvancesOT() { window.location.href = '../../Comercial/AvancesOT.php'; }

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
            const nitUsuario = item.getAttribute('data-nitCliente');
            const razonSocialUsuario = item.getAttribute('data-razonSocialCliente');
            const CiudadesImpacto = item.getAttribute('data-ciudadesImpacto');
            const NecesitaOT = item.getAttribute('data-NecesitaOT');
            const FormatoProceso = item.getAttribute('data-formatoProceso');

            const nombreBrief = item.getAttribute('data-nombreBrief');
            const objetivoBrief = item.getAttribute('data-objetivoBrief');
            const tipoEntregable = item.getAttribute('data-tipoEntregable');
            const tipoCliente = item.getAttribute('data-tipoCliente');
            const dateEntregaComercial = item.getAttribute('data-dateEntregaComercial');
            const liderProyecto = item.getAttribute('data-liderProyecto');
            const idCreativoOT = item.getAttribute('data-creativosOT');
            const artesProyecto = item.getAttribute('data-artesProyecto');
            const linkProyecto = item.getAttribute('data-linkProyecto');
            const dateLinkProyecto = item.getAttribute('data-dateLinkProyecto');
            const datosAdicionalesBrief = item.getAttribute('data-datosAdicionalesBrief');
            const dateEntregaCliente = item.getAttribute('data-dateEntregaCliente');
            const dateSocializacion = item.getAttribute('data-dateSocializacion');

            // Llenar los campos con la información del proyecto

            document.getElementById('LiderProyecto').value = liderProyecto;
            document.getElementById('CreativosOT').value = idCreativoOT;

            document.getElementById('Brief').value = nombreBrief;
            document.getElementById('ObjetivosBrief').value = objetivoBrief;
            document.getElementById('linkProyecto').value = linkProyecto;

            document.getElementById('TipoCliente').value = tipoCliente;
            document.getElementById('Entregables').value = tipoEntregable;

            document.getElementById('DateEntregaComercial').value = dateEntregaComercial;
            document.getElementById('DateFechaSocializacion').value = dateSocializacion;
            document.getElementById('DateEntregaLink').value = dateLinkProyecto;

            document.getElementById('ArchivosAdjuntosBrief').value = datosAdicionalesBrief;
            document.getElementById('artesCreativo').value = artesProyecto;
            
            document.getElementById('ObservacionesOT').value = medioContacto_1;
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

    
    document.addEventListener('DOMContentLoaded', () => {
        const searchInputCrm = document.querySelector('.InputFiltrar input');
        const userItems = document.querySelectorAll('.propuesta-item');
    
        searchInputCrm.addEventListener('input', () => {
            const searchTerm = searchInputCrm.value.toLowerCase(); // Valor de búsqueda
    
            userItems.forEach(item => {
                const NombreProyecto = item.querySelector('.NombreProyecto').textContent.toLowerCase();
                const nombreEmpresa = item.querySelector('.NombreEmpresa').textContent.toLowerCase(); // Cambiar a EmpresaContacto
    
                // Filtrar si el término de búsqueda está en el nombre del contacto o el nombre de la empresa
                if (NombreProyecto.includes(searchTerm) || nombreEmpresa.includes(searchTerm)) {
                    item.style.display = 'block'; // Mostrar si coincide con alguno
                } else {
                    item.style.display = 'none'; // Ocultar si no coincide
                }
            });
        });
    });
    