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
                                    <h3>Información Usuarios CRM</h3>
                                </div>
                                <div class="BotonesInteraccion">
                                    <button class="BotonesFormulario">
                                        <img src="../Media/Iconos/editar.png" alt="local-icon" width="20" height="20" class="">
                                        <span>Editar</span>
                                    </button>
                                    <button class="BotonesFormulario">
                                        <img src="../Media/Iconos/Agregar.png" alt="local-icon" width="20" height="20" class="">
                                        <span>Agregar</span>
                                    </button>
                                    <button class="BotonesFormulario">
                                        <img src="../Media/Iconos/eliminar.png" alt="local-icon" width="20" height="20" class="">
                                        <span>Eliminar</span>
                                    </button>
                                </div>
                            </div>
                            
                            <form class="ParteFormulario">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre">
                                    </div>
                                    <div class="form-group">
                                        <label for="apellido">Apellido</label>
                                        <input type="text" id="apellido" name="apellido" placeholder="Ingrese el apellido">
                                    </div>
                                    <div class="form-group">
                                        <label for="cargo">Cargo</label>
                                        <input type="text" id="cargo" name="cargo" placeholder="Ingrese el cargo">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="celular">Celular</label>
                                        <input type="tel" id="celular" name="celular" placeholder="Ingrese el celular">
                                    </div>
                                    <div class="form-group">
                                        <label for="correo">Correo</label>
                                        <input type="email" id="correo" name="correo" placeholder="Ingrese el correo">
                                    </div>
                                    <div class="form-group">
                                        <label for="direccion">Dirección</label>
                                        <input type="text" id="direccion" name="direccion" placeholder="Ingrese la dirección">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="empresa">Empresa</label>
                                        <input type="text" id="empresa" name="empresa" placeholder="Ingrese la empresa">
                                    </div>
                                    <div class="form-group">
                                        <label for="ciudad">Ciudad</label>
                                        <input type="text" id="ciudad" name="ciudad" placeholder="Ingrese la ciudad">
                                    </div>
                                    <div class="form-group">
                                        <label for="web">Web</label>
                                        <input type="text" id="web" name="web" placeholder="Ingrese la web">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="NIT">N.I.T</label>
                                        <input type="text" id="NIT" name="NIT" placeholder="Ingrese el NIT">
                                    </div>
                                    <div class="form-group">
                                        <label for="ciudad">Razón Social</label>
                                        <input type="text" id="ciudad" name="ciudad" placeholder="Ingrese la Razon Social">
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
                                            <div class="NombreContacto" style="font-size: 14px; font-weight: 600;">Nicol Cortez</div>
                                            <div class="CargoContacto" style="font-size: 13px; color: #262626;">Comercial</div>
                                            <div class="EmpresaContacto" style="font-size: 13px; color: #262626;">BullMarketing</div>
                                        </div>
                                        <div class="user-item">
                                            <div class="NombreContacto" style="font-size: 14px; font-weight: 600;">Santiago Párraga</div>
                                            <div class="CargoContacto" style="font-size: 13px; color: #262626;">DataAnalisty</div>
                                            <div class="EmpresaContacto" style="font-size: 13px; color: #262626;">BullMarketing</div>
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