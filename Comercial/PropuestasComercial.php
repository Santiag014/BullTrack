<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $NombreUsuario = $_SESSION['NombreUsuario'];
    $CorreoUsuario = $_SESSION['CorreoUsuario'];
    $rol_user = $_SESSION['NombreRol'];
    $id_rol = $_SESSION['id_rol'];

    // Almacenar los datos del usuario en la sesión
    $_SESSION['datos_usuario'] = array(
        'id' => $id,
        'nombre' => $NombreUsuario,
        'correo' => $CorreoUsuario,
        'rol_user' => $rol_user,
    );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BullTrack</title>
    <link rel="icon" href="../Media/Iconos/logo512.png" type="image/x-icon">
    <link rel="stylesheet" href="../EstilosFuncionalidad/styles.css">
    <!-- <script src="./Funcionalidad-Backend/FuncionalidadComercial.js" defer></script> -->
     
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
                    <div class="TipoGrafia"><?php echo $NombreUsuario; ?></div>
                    <div class="TipoGrafia"><?php echo $rol_user; ?></div>      
                </div>
                <div class="InformacionModulos">
                <div class="ModulosDash" onclick="RedirigirHome(<?php echo $_SESSION['datos_usuario']['id']; ?>)">
                        <img src="../Media/Iconos/Home.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Home</span>
                    </div>
                    <div class="ModulosDash" onclick="ContactosCRM(<?php echo $_SESSION['datos_usuario']['id']; ?>)">
                        <img src="../Media/Iconos/User.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Contactos CRM</span>
                    </div>
                    <div class="ModulosDash" onclick="RedirigirPropuestas(<?php echo $_SESSION['datos_usuario']['id']; ?>)">
                        <img src="../Media/Iconos/Propuestas.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Propuestas</span>
                    </div>
                    <div class="ModulosDash" onclick="RedirigirAvancesOT(<?php echo $_SESSION['datos_usuario']['id']; ?>)">
                        <img src="../Media/Iconos/Avances.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Avances OT</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="GridHeaderApp">
            <!-- Breadcrumbs component will be rendered here -->
        </div>
        <div class="GridHeaderApp_2">
            <div class="BotonSalir" onclick="RedirigirLogin()">
                <img src="../Media/Iconos/Salir.png" alt="local-icon" width="20" height="20" class="local-icon">
                <span>Salir</span>
            </div>
        </div>
        
        <div class="GridContentApp">
            <div class="background-image_2">
                <div class="ContainerContactosCRM">
                    <div class="FormularioContactos">
                        <div class="FormContactos">
                            <div class="ParteSuperiorContacto">
                                <div class="InformacionCliente">
                                    <h3>Información de Propuesta</h3>
                                </div>
                                <div class="BotonesInteraccion">
                                    <button class="BotonesFormulario" id="editarBtn">
                                        <img src="../Media/Iconos/editar.png" alt="local-icon" width="20" height="20" class="">
                                        <span>Editar</span>
                                    </button>
                                    <button class="BotonesFormulario"  id="agregarBtn">
                                        <img src="../Media/Iconos/Agregar.png" alt="local-icon" width="20" height="20" class="">
                                        <span>Agregar</span>
                                    </button>
                                    <button class="BotonesFormulario"  id="eliminarBtn">
                                        <img src="../Media/Iconos/eliminar.png" alt="local-icon" width="20" height="20" class="">
                                        <span>Eliminar</span>
                                    </button>
                                </div>
                            </div>
                                    
                            <form class="ParteFormulario" method="post">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="NIT">N.I.T</label>
                                        <input type="text" id="NIT" name="NIT"  placeholder="Ingrese el N.I.T" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="RazonSocial">Razon Social</label>
                                        <input type="text" id="RazonSocial" name="RazonSocial" placeholder="Ingrese el N.I.T" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="NombreProyecto">Nombre Proyecto</label>
                                        <input type="text" id="NombreProyecto" name="NombreProyecto" placeholder="Ingrese el Nombre del Proyecto"  readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="DescipcionProyecto">Descripción Proyecto</label>
                                        <input type="text" id="DescipcionProyecto" name="DescipcionProyecto" placeholder="Ingrese la Descipción del Proyecto" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="UnidadNegocio">Unidad de Negocio</label>
                                        <input type="text" id="UnidadNegocio" name="UnidadNegocio" placeholder="Ingrese la Unidad de Negocios" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="FormatoProceso">Formato de Proceso</label>
                                        <input type="text" id="FormatoProceso" name="FormatoProceso" placeholder="Ingrese el Formato de Proceso" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="estadoPropuesta">Estado de la Propuesta</label>
                                        <input type="text" id="estadoPropuesta" name="estadoPropuesta" placeholder="Ingrese el Estado de la Propuesta" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="CiudadesImpacto">Ciudades de Impacto</label>
                                        <input type="text" id="CiudadesImpacto" name="CiudadesImpacto" placeholder="Ingrese Ciudades de Impacto" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="ValorPropuesta">Valor de la Propuesta</label>
                                        <input type="number" id="ValorPropuesta" name="ValorPropuesta" placeholder="Ingrese el Valor de la Propuesta" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="DateEntregaEconomica">Fecha Entrega Economica</label>
                                        <input type="date" id="DateEntregaEconomica" name="DateEntregaEconomica" placeholder="Ingrese la Fecha de Entrega Económica" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="ArchivosAdjuntosComercial">Archivos Enviados por el Cliente</label>
                                        <input type ="text" id="ArchivosAdjuntosComercial" name="ArchivosAdjuntosComercial" placeholder="Ingrese los Archivos" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="NecesidadOT">Necesita OT</label>
                                        <select id="NecesidadOT" name="NecesidadOT" disabled>
                                            <option value="si">Si</option>
                                            <option value="no" selected>No</option>
                                        </select>
                                    </div>
                                </div>
                            </form> 

                            <div class="SelectUserPropuesta" id="SelectUserPropuestas">
                                <h3>Selecciona tu Contacto</h3>
                                <div class="ContainerSelectUSer">
                                    <div class="CuadroFiltradoSelectUser">
                                        <div class="filterUserSelect">
                                            <input type="text" placeholder="Nombre del Proyecto...">
                                        </div>
                                        <div class="Lista_2">
                                            <ul>
                                                <li>
                                                    <div class="propuesta-item">
                                                        <div class="NombreContacto" style="font-size: 14px; font-weight: 600;">Nombre Proyecto 1</div>
                                                    </div>
                                                    <div class="propuesta-item">
                                                        <div class="NombreContacto" style="font-size: 14px; font-weight: 600;">Nombre Proyecto 1</div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="InformacionSelectedUser">
                                        <div>
                                            <div class="form-row_2">
                                                <div class="form-group">
                                                    <label for="Nombre">Nombre</label>
                                                    <input type="text" id="Nombre" name="Nombre"  placeholder="Ingrese el N.I.T" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Apellido">Apellido</label>
                                                    <input type="text" id="Apellido" name="Apellido" placeholder="Ingrese el N.I.T" readonly>
                                                </div>
                                            </div>
                                            <div class="form-row_2">
                                                <div class="form-group">
                                                    <label for="Cargo">Cargo</label>
                                                    <input type="text" id="Cargo" name="Cargo"  placeholder="Ingrese el N.I.T" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Celular">Celular</label>
                                                    <input type="text" id="Celular" name="Celular" placeholder="Ingrese el N.I.T" readonly>
                                                </div>
                                            </div>
                                            <div class="form-row_2">
                                                <div class="form-group">
                                                    <label for="Correo">Correo</label>
                                                    <input type="text" id="Correo" name="Correo"  placeholder="Ingrese el N.I.T" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Empresa">Empresa</label>
                                                    <input type="text" id="Empresa" name="Empresa" placeholder="Ingrese el N.I.T" readonly>
                                                </div>
                                            </div>
                                            <div class="form-row_2">
                                                <div class="form-group">
                                                    <label for="Ciudad">Ciudad</label>
                                                    <input type="text" id="Ciudad" name="Ciudad"  placeholder="Ingrese el N.I.T" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Web">Web</label>
                                                    <input type="text" id="Web" name="Web" placeholder="Ingrese el N.I.T" readonly>
                                                </div>
                                            </div>
                                            <div class="form-row_2">
                                                <div class="form-group">
                                                    <label for="NIT">N.I.T</label>
                                                    <input type="text" id="NIT" name="NIT"  placeholder="Ingrese el N.I.T" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="RazonSocial">Razon Social</label>
                                                    <input type="text" id="RazonSocial" name="RazonSocial" placeholder="Ingrese el N.I.T" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ButtonSeleccionarUser">
                                            <button class="BotonesFormulario"  id="SelectUser">
                                                <img src="../Media/Iconos/sleecionar.png" alt="local-icon" width="20" height="20" class="">
                                                <span>Seleccionar</span>
                                             </button>
                                        </div>
                                    </div>
                                </div>
                            </div> 

                            <form class="ParteFormularioOT-Agregar">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="LiderProyecto">Lider Proyecto</label>
                                        <input 
                                            type="text" 
                                            id="LiderProyecto" 
                                            name="LiderProyecto"   
                                            readonly
                                            placeholder="Lider del Proyecto"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="CreativoProyecto">Creativo</label>
                                        <input 
                                            type="text" 
                                            id="CreativoProyecto" 
                                            name="CreativoProyecto" 
                                            readonly
                                            placeholder="Creativos del Proyecto"
                                        />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Brief">Brief</label>
                                        <input 
                                            type="text" 
                                            id="Brief" 
                                            name="Brief"  
                                            readonly
                                            placeholder="Brief del Proyecto"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="ObjetivosBrief">Objetivo del Brief</label>
                                        <input 
                                            type="text" 
                                            id="ObjetivosBrief" 
                                            name="ObjetivosBrief"
                                            readonly
                                            placeholder="Objetivo del Brief"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="Link">Link</label>
                                        <input 
                                            type="text" 
                                            id="Link" 
                                            name="Link"
                                            readonly
                                            placeholder="Link del Proyecto"
                                        />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="TipoCliente">Tipo de Cliente</label>
                                        <input 
                                            type="text" 
                                            id="TipoCliente" 
                                            name="TipoCliente"
                                            readonly
                                            placeholder="Tipo de Cliente"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="Entregables">Entregables</label>
                                        <input 
                                            type="text" 
                                            id="Entregables" 
                                            name="Entregables"
                                            readonly
                                            placeholder="Entregables"
                                        />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="DateEntregaComercial">Fecha Entrega Comercial</label>
                                        <input 
                                            type="date" 
                                            id="DateEntregaComercial" 
                                            name="DateEntregaComercial"
                                            readonly
                                            placeholder="Fecha de Entrega Comercial"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="DateFechaSocializacion">Fecha Socialización</label>
                                        <input 
                                            type="date" 
                                            id="DateFechaSocializacion" 
                                            name="DateFechaSocializacion"
                                            readonly
                                            placeholder="Fecha de Socialización"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="DateEntregaLink">Fecha Entrega Link</label>
                                        <input 
                                            type="date" 
                                            id="DateEntregaLink" 
                                            name="DateEntregaLink"
                                            readonly
                                            placeholder="Fehca Entrga del Link"
                                        />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="DatosAdicionales">Datos Adicionales</label>
                                        <div class="custom-file-container">
                                            <input 
                                                type="file" 
                                                id="ArchivosAdjuntosBrief" 
                                                name="ArchivosAdjuntosBrief" 
                                                style="display: none;"
                                                placeholder="Datos Adicionales"
                                            />
                                            <span class="file-name" id="fileNameBrief">No se ha seleccionado ningún archivo</span>
                                            <label for="ArchivosAdjuntosBrief" class="custom-file-upload">
                                                Elegir archivo
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Artes">Artes</label>
                                        <div class="custom-file-container">
                                            <input 
                                                type="file" 
                                                id="fileUpload" 
                                                name="fileUpload" 
                                                style="display: none;"
                                                placeholder="Artes"
                                            />
                                            <span class="file-name" id="fileNameArtes">No se ha seleccionado ningún archivo</span>
                                            <label for="fileUpload" class="custom-file-upload">
                                                Elegir archivo
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form> 
                        </div>
                    </div>
                    <div class="ContactosCreados">
                        <div class="MostrarListaDesplegable">
                            <div class="InputFiltrar">
                                <input type="text" placeholder="Nombre del Proyecto...">
                            </div>
                            <div  class="InputFiltrar_2">

                                <select style="margin-right: 4px;">
                                    <option value="">Estado...</option>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                    <option value="pendiente">Pendiente</option>
                                </select>

                                <select style="margin-right: 0px;">
                                    <option value="">Cliente...</option>
                                    <option value="cliente1">Cliente 1</option>
                                    <option value="cliente2">Cliente 2</option>
                                    <option value="cliente3">Cliente 3</option>
                                </select>     
                                      
                            </div>
                            <div class="Lista">
                                <ul>
                                    <li>
                                        <div class="propuesta-item">
                                            <div class="NombreContacto" style="font-size: 14px; font-weight: 600;">Nombre Proyecto 1</div>
                                            <div class="CargoContacto" style="font-size: 13px; color: #262626;">En Producción</div>
                                            <div class="EmpresaContacto" style="font-size: 13px; color: #262626;">14/01/2006</div>
                                        </div>

                                        <div class="propuesta-item">
                                            <div class="NombreContacto" style="font-size: 14px; font-weight: 600;">Nombre Proyecto 2</div>
                                            <div class="CargoContacto" style="font-size: 13px; color: #262626;">Finalizado</div>
                                            <div class="EmpresaContacto" style="font-size: 13px; color: #262626;">14/01/2006</div>
                                        </div>

                                        <div class="propuesta-item">
                                            <div class="NombreContacto" style="font-size: 14px; font-weight: 600;">Nombre Proyecto 3</div>
                                            <div class="CargoContacto" style="font-size: 13px; color: #262626;">En Propuesta</div>
                                            <div class="EmpresaContacto" style="font-size: 13px; color: #262626;">14/01/2006</div>
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
</body>


<!-- <script>
    // Asignar Si Necesita OT
    document.getElementById('editarBtn').addEventListener('click', () => alternarEstado('editarBtn'));
    document.getElementById('agregarBtn').addEventListener('click', () => alternarEstado('agregar'));
    document.getElementById('eliminarBtn').addEventListener('click', () => alternarEstado('eliminar'));
    document.getElementById('SelectUser').addEventListener('click', () => selectUser());

    const editarButton = document.querySelector('.BotonesInteraccion .BotonesFormulario:nth-child(1)');
    const agregarButton = document.querySelector('.BotonesInteraccion .BotonesFormulario:nth-child(2)');
    const eliminarButton = document.querySelector('.BotonesInteraccion .BotonesFormulario:nth-child(3)');

    const formPropuestas = document.querySelectorAll('.ParteFormulario input, .ParteFormulario select');
    const formInicial = document.getElementsByClassName('ParteFormulario')[0]; 
    const formSelectUsers = document.getElementsByClassName('SelectUserPropuesta')[0]; 
    const formOT = document.querySelectorAll('.ParteFormularioOT-Agregar input, .ParteFormularioOT-Agregar select');

    const necesidadOTSelect = document.getElementById('NecesidadOT');
    const parteFormularioOT = document.querySelector('.ParteFormularioOT-Agregar');
    const parteFormularioOTFields = parteFormularioOT.querySelectorAll('input, select, textarea');

    // Variable para rastrear el estado de los campos
    let fieldsEnabled = false;
    let isAddMode = false;
    let SelectUser = true;

    function toggleAddMode() {
        isAddMode = !isAddMode;
        formInicial.style.display = isAddMode ? 'none' : 'block';
        formSelectUsers.style.display = isAddMode ? 'block' : 'none';
    }

    function selectUser() {
        SelectUser = !SelectUser;
        formInicial.style.display = SelectUser ? 'block' : 'none';
        formSelectUsers.style.display = SelectUser ? 'none' : 'block';
    }

    function toggleFormFields() {
        fieldsEnabled = !fieldsEnabled;

        formPropuestas.forEach(field => {
            field[fieldsEnabled ? 'removeAttribute' : 'setAttribute']('readonly', 'readonly');
            field[fieldsEnabled ? 'removeAttribute' : 'setAttribute']('disabled', 'disabled');
        });

        formOT.forEach(field => {
            field[fieldsEnabled ? 'removeAttribute' : 'setAttribute']('readonly', 'readonly');
            field[fieldsEnabled ? 'removeAttribute' : 'setAttribute']('disabled', 'disabled');
        });

        toggleParteFormularioOT(); // Llamar a la función para actualizar el estado de OT
    }

    function toggleParteFormularioOT() {
        if (necesidadOTSelect && parteFormularioOT) {
            const value = necesidadOTSelect.value.toLowerCase();

            if (value === 'si') {
                parteFormularioOT.style.display = 'block';
                parteFormularioOTFields.forEach(field => {
                    field.removeAttribute('readonly');
                    field.removeAttribute('disabled');
                });
            } else {
                parteFormularioOT.style.display = 'none';
                parteFormularioOTFields.forEach(field => {
                    field.setAttribute('readonly', 'readonly');
                    field.setAttribute('disabled', 'disabled');
                });
            }
        }
    }

    // Llamar a la función cuando cambie el valor del select
    necesidadOTSelect.addEventListener('change', toggleParteFormularioOT);

    editarButton.addEventListener('click', toggleFormFields);
    
    const selectUserButton = document.getElementById('SelectUser'); // Asegúrate de que este ID exista en el HTML
    selectUserButton.addEventListener('click', selectUser);

    agregarButton.addEventListener('click', () => {
        toggleFormFields();
        toggleAddMode();
    });

    eliminarButton.addEventListener('click', () => {
        // Add logic for the "Delete" button if needed
    });

    // Initial setup: disable fields on page load
    disableFormFields();
</script> -->

<script>
   const estados = {
    editar: {
        iconoOriginal: '../Media/Iconos/editar.png',
        textoOriginal: 'Editar',
        iconoModificado: '../Media/Iconos/guardar.png',
        textoModificado: 'Guardar'
    },
    agregar: {
        iconoOriginal: '../Media/Iconos/Agregar.png',
        textoOriginal: 'Agregar',
        iconoModificado: '../Media/Iconos/guardar.png',
        textoModificado: 'Guardar'
    },
};

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('editarBtn').dataset.estado = 'original';
    document.getElementById('agregarBtn').dataset.estado = 'original';
    document.getElementById('eliminarBtn').dataset.estado = 'original';

    function alternarEstado(btnId) {
        const boton = document.getElementById(btnId);
        const img = boton.querySelector('img');
        const span = boton.querySelector('span');

        alert(`Botón presionado: ${btnId}`);
        alert(`Estado inicial: ${boton.dataset.estado}`);

        if (btnId === 'editarBtn' || btnId === 'agregarBtn') {
            const estadoActual = boton.dataset.estado;
            alert(`Estado actual: ${estadoActual}`);

            if (estadoActual === 'original') {
                img.src = estados[btnId].iconoModificado;
                span.textContent = estados[btnId].textoModificado;
                boton.dataset.estado = 'guardar';
                alert(`Estado cambiado a: guardar`);
            } else {
                img.src = estados[btnId].iconoOriginal;
                span.textContent = estados[btnId].textoOriginal;
                boton.dataset.estado = 'original';
                alert(`Estado cambiado a: original`);
            }
        } else {
            const estadoActual = boton.dataset.estado;
            alert(`Estado actual: ${estadoActual} en eliminar`);

            if (estadoActual === 'modificado') {
                img.src = estados[btnId].iconoOriginal;
                span.textContent = estados[btnId].textoOriginal;
                boton.dataset.estado = 'original';
                alert(`Estado cambiado a: original`);
            } else {
                img.src = estados[btnId].iconoModificado;
                span.textContent = estados[btnId].textoModificado;
                boton.dataset.estado = 'modificado';
                alert(`Estado cambiado a: modificado`);
            }
        }
    }

    document.getElementById('editarBtn').addEventListener('click', () => {
        console.log('Editar botón presionado');
        alternarEstado('editarBtn');
    });
    document.getElementById('agregarBtn').addEventListener('click', () => alternarEstado('agregarBtn'));
    document.getElementById('eliminarBtn').addEventListener('click', () => alternarEstado('eliminarBtn'));
});



</script>

<script src="./Funcionalidad/FuncionalidadComercial.js"></script> 

</html>