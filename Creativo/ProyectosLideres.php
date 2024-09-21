<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BullTrack</title>
    <link rel="icon" href="../Media/Iconos/logo512.png" type="image/x-icon">
    <link rel="stylesheet" href="../EstilosFuncionalidad/styles.css">
</head>
<body>
    <div class="background-image" style="background-image: url(../Media/FonfoDash.jpg);"></div>
    <div class="GridContanier">
        <div class="GridInformacionUsuario">
            <div class="Marca">
                <img src="../Media/LogoBull_2.png" alt="FotoBullMarketing" class="logo_image_Dashboard">
            </div>
            <div class="InformacionDashboar">
                <div class="FotoUsuarioDashboard">
                    <div class="TipoGrafia_App"> <strong>BullTrack</strong> <br/> App Seguimiento Interno</div>
                    <img src="../Media/fotoPerfil.jpg" alt="FotoBullMarketing" class="logo_image_Dashboard">
                    <div class="TipoGrafia">Nombre Del Usuario</div>
                    <div class="TipoGrafia">Cargo</div>
                    <div class="TipoGrafia">Rol</div>    
                </div>
                <div class="InformacionModulos">
                    <div class="ModulosDash">
                        <img src="../Media/Iconos/User.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Proyectos Líderes</span>
                    </div>
                    <div class="ModulosDash">
                        <img src="../Media/Iconos/Propuestas.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Proyectos Creativos</span>
                    </div>
                    <div class="ModulosDash">
                        <img src="../Media/Iconos/Avances.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Proyectos Finalizados</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="GridHeaderApp">
            <!-- Breadcrumbs component will be rendered here -->
        </div>
        <div class="GridHeaderApp_2">
            <div class="BotonSalir">
                <img src="../Media/Iconos/Salir.png" alt="local-icon" width="20" height="20" class="local-icon">
                <span>Salir</span>
            </div>
        </div>
        
        <div class="GridContentApp">
            <div class="background-image_2">
                <div class="ContainerPropuestasComercial">
                    <div class="FormularioPropuestasComercial">
                        <div class="FormPropuestas">
                            <div class="ParteSuperiorPropuesta">
                                <div class="InformacionPropuesta">
                                    <h3>Propuestas Creativo Lider</h3>
                                </div>
                                <div class="BotonesInteraccion">
                                    <button class="BotonesFormulario" id="editarBtn">
                                        <img src="../Media/Iconos/editar.png" alt="local-icon" width="20" height="20" class="local-icon">
                                        <span>Editar OT</span>
                                    </button>
                                    <button class="BotonesFormulario" id="verDatosBtn">
                                        <img src="../Media/Iconos/PropuestasForms.png" alt="local-icon" width="20" height="20" class="local-icon">
                                        <span>Datos Propuesta</span>
                                    </button>
                                </div>
                            </div>
    
                            <!-- Form 1: ParteFormularioOT -->
                            <form id="form1" class="ParteFormularioOT">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="LiderProyecto">Lider Proyecto</label>
                                        <input type="text" id="LiderProyecto" name="LiderProyecto" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="CreativoProyecto">Creativo</label>
                                        <input type="text" id="CreativoProyecto" name="CreativoProyecto" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Brief">Brief</label>
                                        <div class="scrollable-container">
                                            <textarea id="Brief" name="Brief" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ObjetivosBrief">Objetivo del Brief</label>
                                        <div class="scrollable-container">
                                            <textarea id="ObjetivosBrief" name="ObjetivosBrief" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ObservacionesOT">Observaciones OT - Comercial</label>
                                        <div class="scrollable-container">
                                            <textarea id="ObservacionesOT" name="ObservacionesOT" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="TipoCliente">Tipo de Cliente</label>
                                        <input type="text" id="TipoCliente" name="TipoCliente" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="Entregables">Entregables</label>
                                        <input type="text" id="Entregables" name="Entregables" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="DateEntregaComercial">Fecha Entrega Comercial</label>
                                        <input type="date" id="DateEntregaComercial" name="DateEntregaComercial" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="DateFechaSocializacion">Fecha Socialización</label>
                                        <input type="date" id="DateFechaSocializacion" name="DateFechaSocializacion" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="DateEntregaLink">Fecha Entrega Link</label>
                                        <input type="date" id="DateEntregaLink" name="DateEntregaLink" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="DatosAdicionales">Datos Adicionales</label>
                                        <div class="custom-file-container">
                                            <input type="file" id="ArchivosAdjuntosBrief" name="ArchivosAdjuntosBrief" style="display: none;">
                                            <span class="file-name">No se ha seleccionado ningún archivo</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Artes">Artes</label>
                                        <div class="custom-file-container">
                                            <input type="file" id="fileUpload" name="fileUpload" style="display: none;">
                                            <span class="file-name">No se ha seleccionado ningún archivo</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="link">Link</label>
                                        <input type="text" id="link" name="link" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="HorasTrabajadas">Horas Trabajadas</label>
                                        <input type="text" id="HorasTrabajadas" name="HorasTrabajadas" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="HorasExtra">Horas Extra</label>
                                        <input type="text" id="HorasExtra" name="HorasExtra" readonly>
                                    </div>
                                </div>
                            </form>
    
                            <!-- Form 2: ParteFormulario -->
                            <form id="form2" class="ParteFormulario" style="display: none;">
                                <div class="titulo">Datos Adicionales Propueta Comercial</div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="NIT">N.I.T</label>
                                        <input type="text" id="NIT" name="NIT" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="RazonSocial">Razon Social</label>
                                        <input type="text" id="RazonSocial" name="RazonSocial" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="nombreProyecto">Nombre Proyecto</label>
                                        <input type="text" id="nombreProyecto" name="nombreProyecto" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="DescripcionProyecto">Descripción Proyecto</label>
                                        <input type="text" id="DescripcionProyecto" name="DescripcionProyecto" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="UnidadNegocio">Unidad de Negocio</label>
                                        <input type="text" id="UnidadNegocio" name="UnidadNegocio" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="FormatoProceso">Formato de Proceso</label>
                                        <input type="text" id="FormatoProceso" name="FormatoProceso" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="estadoPropuesta">Estado de la Propuesta</label>
                                        <input type="text" id="estadoPropuesta" name="estadoPropuesta" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="CiudadesImpacto">Ciudades de Impacto</label>
                                        <input type="text" id="CiudadesImpacto" name="CiudadesImpacto" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="ValorPropuesta">Valor de la Propuesta</label>
                                        <input type="number" id="ValorPropuesta" name="ValorPropuesta" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="DateEntregaEconomica">Fecha Entrega Economica</label>
                                        <input type="date" id="DateEntregaEconomica" name="DateEntregaEconomica" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="ArchivosAdjuntosComercial">Archivos Enviados por el Cliente</label>
                                        <input type="text" id="ArchivosAdjuntosComercial" name="ArchivosAdjuntosComercial" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="NecesidadOT">Necesita OT</label>
                                        <input type="text" id="NecesidadOT" name="NecesidadOT" readonly>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="ContactosCreados">
                        <div class="MostrarListaDesplegable">
                            <div class="InputFiltrar">
                                <input type="text" id="searchInput" placeholder="Buscar Propuestas...">
                            </div>
                            <div class="Lista">
                                <ul>
                                    <li>
                                        <div class="user-item">
                                            <div class="NombreContacto" style="font-size: 14px; font-weight: 600;">Juan Pérez</div>
                                            <div class="CargoContacto" style="font-size: 13px; color: #262626;">Gerente de Ventas</div>
                                            <div class="EmpresaContacto" style="font-size: 13px; color: #262626;">Empresa XYZ</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/Creativo//JavaScript/FuncionalidadCreativo.js"></script>
    <!-- <script>
        const propuestas = [
    { id: 1, nombreProyecto: 'Proyecto 1', estadoPropuesta: 'En progreso', fechaCreacion: '2024-09-16', NecesidadOT: 'True',  Brief: 'PropuestasONes', ObjetivosBrief: 'AtraerPersonas' },
    { id: 2, nombreProyecto: 'Proyecto 2', estadoPropuesta: 'Finalizado', fechaCreacion: '2024-08-25', NecesidadOT: 'False', Brief: 'PropuestaDos', ObjetivosBrief: 'MejorarVisibilidad' },
    { id: 3, nombreProyecto: 'Proyecto 3', estadoPropuesta: 'Pendiente', fechaCreacion: '2024-07-10', NecesidadOT: 'False', Brief: 'PropuestaTres', ObjetivosBrief: 'IncrementarVentas' },
    { id: 4, nombreProyecto: 'Proyecto 4', estadoPropuesta: 'En progreso', fechaCreacion: '2024-06-14', NecesidadOT: 'False', Brief: 'PropuestaCuatro', ObjetivosBrief: 'ExpandirMercado' },
    { id: 5, nombreProyecto: 'Proyecto 5', estadoPropuesta: 'Cancelado', fechaCreacion: '2024-09-01', NecesidadOT: 'True', Brief: 'PropuestaCinco', ObjetivosBrief: 'FortalecerRelaciones' }
];

let selectedPropuesta = null;
let editMode = false;
let showForm1 = true;
let showForm2 = false;
let selectedFile = null;

const form1 = document.getElementById('form1');
const form2 = document.getElementById('form2');
const editarBtn = document.getElementById('editarBtn');
const verDatosBtn = document.getElementById('verDatosBtn');
const searchInput = document.getElementById('searchInput');
const propuestasList = document.getElementById('propuestasList');
const botonSalir = document.getElementById('botonSalir');

const archivosAdjuntosBrief = document.getElementById('ArchivosAdjuntosBrief');
const fileUpload = document.getElementById('fileUpload');

document.addEventListener('DOMContentLoaded', initializeApp);
editarBtn.addEventListener('click', handleEdit);
verDatosBtn.addEventListener('click', handleViewDataProposal);
searchInput.addEventListener('keyup', handleSearch);
botonSalir.addEventListener('click', handleLogout);
archivosAdjuntosBrief.addEventListener('change', handleFileSelect);
fileUpload.addEventListener('change', handleFileSelect);

document.getElementById('proyectosLider').addEventListener('click', () => navigateTo('/ProyectosLider'));
document.getElementById('proyectosCreativos').addEventListener('click', () => navigateTo('/ProyectosCreativo'));
document.getElementById('proyectosFinalizados').addEventListener('click', () => navigateTo('/ProyectosFinalizados'));

function initializeApp() {
    renderPropuestasList(propuestas);
    updateFormFields();
}

function handleEdit() {
    if (selectedPropuesta) {
        editMode = !editMode;
        updateFormFields();
        editarBtn.textContent = editMode ? 'Guardar' : 'Editar OT';
        editarBtn.removeEventListener('click', handleEdit);
        editarBtn.addEventListener('click', editMode ? handleSave : handleEdit);
    } else {
        showAlert('Por favor, seleccione un Contacto para Editar.');
    }
}

function handleSave() {
    if (selectedPropuesta) {
        // Update selectedPropuesta with form values
        selectedPropuesta.Brief = document.getElementById('Brief').value;
        selectedPropuesta.ObjetivosBrief = document.getElementById('ObjetivosBrief').value;
        selectedPropuesta.ObservacionesOT = document.getElementById('ObservacionesOT').value;
        selectedPropuesta.DateEntregaComercial = document.getElementById('DateEntregaComercial').value;
        selectedPropuesta.DateFechaSocializacion = document.getElementById('DateFechaSocializacion').value;
        selectedPropuesta.DateEntregaLink = document.getElementById('DateEntregaLink').value;
        selectedPropuesta.link = document.getElementById('link').value;
        selectedPropuesta.HorasTrabajadas = document.getElementById('HorasTrabajadas').value;
        selectedPropuesta.HorasExtra = document.getElementById('HorasExtra').value;
        
        editMode = false;
        updateFormFields();
        editarBtn.textContent = 'Editar OT';
        editarBtn.removeEventListener('click', handleSave);
        editarBtn.addEventListener('click', handleEdit);
    }
}

function handleViewDataProposal() {
    if (selectedPropuesta) {
        showForm1 = !showForm1;
        showForm2 = !showForm2;
        form1.style.display = showForm1 ? 'block' : 'none';
        form2.style.display = showForm2 ? 'block' : 'none';
        verDatosBtn.textContent = showForm2 ? 'Cerrar' : 'Datos Propuesta';
    } else {
        showAlert('Por favor, seleccione un Proyecto a Observar');
    }
}

function handleSearch(e) {
    const searchTerm = e.target.value.toLowerCase();
    const filteredPropuestas = propuestas.filter(propuesta => 
        propuesta.nombreProyecto.toLowerCase().includes(searchTerm)
    );
    renderPropuestasList(filteredPropuestas);
}

function renderPropuestasList(propuestasToRender) {
    propuestasList.innerHTML = '';
    const propuestasConOT = propuestasToRender.filter(propuesta => propuesta.NecesidadOT === 'True' || propuesta.NecesidadOT === true);
    propuestasConOT.forEach(propuesta => {
        const li = document.createElement('li');
        li.textContent = propuesta.nombreProyecto;
        li.addEventListener('click', () => selectPropuesta(propuesta));
        propuestasList.appendChild(li);
    });
}

function selectPropuesta(propuesta) {
    selectedPropuesta = propuesta;
    updateFormFields();
}

function updateFormFields() {
    if (selectedPropuesta) {
        const inputs = document.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.readOnly = !editMode;
        });

        // Update form fields with selectedPropuesta data
        document.getElementById('Brief').value = selectedPropuesta.Brief || '';
        document.getElementById('ObjetivosBrief').value = selectedPropuesta.ObjetivosBrief || '';
        document.getElementById('nombreProyecto').value = selectedPropuesta.nombreProyecto || '';
        document.getElementById('estadoPropuesta').value = selectedPropuesta.estadoPropuesta || '';
        document.getElementById('NecesidadOT').value = selectedPropuesta.NecesidadOT || '';
        
        // Update other fields as necessary
    } else {
        // Clear form fields if no propuesta is selected
        const inputs = document.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.value = '';
        });
    }
}

function handleFileSelect(event) {
    const fileInput = event.target;
    const fileName = fileInput.files[0] ? fileInput.files[0].name : "No se ha seleccionado ningún archivo";
    fileInput.parentElement.querySelector('.file-name').textContent = fileName;
}

function showAlert(message) {
    // Implement your preferred way of showing alerts
    alert(message);
}

function handleLogout() {
    // Implement logout logic here
    navigateTo('/');
}

function navigateTo(path) {
    // Implement navigation logic here
    console.log(`Navigating to ${path}`);
    // In a real application, you might use window.location.href = path;
}

// Additional utility functions

function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
}

function validateForm() {
    // Implement form validation logic here
    return true; // Return true if form is valid, false otherwise
}
    </> -->
</body>
</html>