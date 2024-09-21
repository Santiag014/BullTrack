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
                    <div class="ModulosDash" onclick="RedirigirHome()">
                        <img src="../Media/Iconos/Home.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Home</span>
                      </div>
                    <div class="ModulosDash" onclick="ContactosCRM()">
                        <img src="../Media/Iconos/User.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Contactos CRM</span>
                    </div>
                    <div class="ModulosDash" onclick="RedirigirPropuestas()">
                        <img src="../Media/Iconos/Propuestas.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Propuestas</span>
                    </div>
                    <div class="ModulosDash" onclick="RedirigirAvancesOT()">
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
            <div class="BotonSalir">
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
                                    <h3>Información Avance OT</h3>
                                </div>
                                <div class="BotonesInteraccion">
                                    <button class="BotonesFormulario">
                                        <img src="../Media/Iconos/editar.png" alt="local-icon" width="20" height="20" class="">
                                        <span>Editar</span>
                                    </button>
                                </div>
                            </div>
                            <form class="ParteFormularioOT">
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
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="ObservacionesOT">Observaciones OT - Comercial</label>
                                        <input 
                                            type="text" 
                                            id="ObservacionesOT" 
                                            name="ObservacionesOT"
                                            readonly
                                            placeholder="Observaciones OT"
                                        />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="ContactosCreados">
                        <div class="MostrarListaDesplegable">
                            <div class="InputFiltrar">
                                <input type="text" placeholder="Buscar contactos...">
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
    <script src="./Funcionalidad-Backend/FuncionalidadComercial.js"></script>
</body>
</html>