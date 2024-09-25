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
                    <div class="TipoGrafia_Rol">Rol</div>    
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
                            <!-- <form id="form2" class="ParteFormulario" style="display: none;">
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
                            </form> -->
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
</body>
</html>