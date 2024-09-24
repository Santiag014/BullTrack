<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $NombreUsuario = $_SESSION['NombreUsuario'];
    $CorreoUsuario = $_SESSION['CorreoUsuario'];
    $rol_user = $_SESSION['NombreRol'];
    $id_rol = $_SESSION['id_rol'];
    $id_CRM = $_SESSION['id_CRM'];

    // Almacenar los datos del usuario en la sesión
    $_SESSION['datos_usuario'] = array(
        'id' => $id,
        'nombre' => $NombreUsuario,
        'correo' => $CorreoUsuario,
        'rol_user' => $rol_user,
    );
}
// Consulta para iterar por Contactos de CRM
include '../ConexionesBD/ConexcionDBcrm.php';
// Consulta para iterar por Contactos de BullTrack
include '../ConexionesBD/ConexionBDBullTrack.php';

// Consulta para obtener contactos de CRM
$sql = "SELECT * FROM contactos WHERE id_user = $id_CRM";
$resultado = mysqli_query($conexion, $sql);

$info_completa = []; // Asegúrate de inicializar el array

if ($resultado) {
    if (mysqli_num_rows($resultado) > 0) {
        while ($contacto = mysqli_fetch_assoc($resultado)) {
            // Almacena el contacto original
            $contacto_completo = $contacto;
            
            // Obtén el ID del contacto
            $id_contacto = $contacto['id'];

            // Consulta adicional en BullTrack para obtener información relacionada
            $sql_1 = "SELECT      
                SeguimientoComercial.id,
                SeguimientoComercial.id_user,
                SeguimientoComercial.id_unidadNegocio,
                SeguimientoComercial.dateCreated,
                SeguimientoComercial.nombreProyecto,
                SeguimientoComercial.descripcionProyecto,
                SeguimientoComercial.valorProyecto,
                SeguimientoComercial.estadoPropuesta,
                SeguimientoComercial.dateEntregaEconomicaCliente,
                SeguimientoComercial.medioContacto1,
                SeguimientoComercial.medioContacto2,
                SeguimientoComercial.observacionProyecto1,
                SeguimientoComercial.observacionProyecto2,
                SeguimientoComercial.archivosAdjuntos,
                SeguimientoComercial.id_contacto,
                SeguimientoComercial.formatoProceso,
                SeguimientoComercial.NecesitaOT,
                SeguimientoComercial.CiudadesImpacto,
                contacto_crm.nit_contacto, 
                contacto_crm.razon_social_contacto,
                contacto_crm.id_contactos_CRM,
                SeguimientoCreativo.dateEntrega,
                SeguimientoCreativo.nombreBrief,
                SeguimientoCreativo.objetivoBrief,
                SeguimientoCreativo.tipoEntregables,
                SeguimientoCreativo.TipoCliente
            FROM SeguimientoComercial 
            JOIN contacto_crm ON SeguimientoComercial.id_contacto = contacto_crm.id
            LEFT JOIN SeguimientoCreativo ON SeguimientoComercial.id = SeguimientoCreativo.id_comercial
            WHERE contacto_crm.id_contactos_CRM = $id_contacto AND SeguimientoComercial.isDeleted = 0;";
            
            $resultado2 = mysqli_query($conexion_bull, $sql_1);

            if ($resultado2) {
                // Almacena toda la información de proyectos
                $proyectos = [];
                if (mysqli_num_rows($resultado2) > 0) {
                    while ($proyecto = mysqli_fetch_assoc($resultado2)) {
                        $proyectos[] = $proyecto; // Almacena cada proyecto en un array
                    }
                    // Agrega los proyectos al contacto completo
                    $contacto_completo['proyectos'] = $proyectos;
                } else {
                    $contacto_completo['proyectos'] = []; // Si no hay proyectos, asigna un array vacío
                }
            } else {
                // Manejo de error para la segunda consulta
                $contacto_completo['error_bull'] = "Error en la consulta BullTrack: " . mysqli_error($conexion_bull);
            }
            
            // Agrega el contacto completo al array
            $info_completa[] = $contacto_completo;
        }
    } else {
        $info_completa['error'] = "No se encontraron contactos para el usuario.";
    }
} else {
    $info_completa['error'] = "Error en la consulta principal: " . mysqli_error($conexion);
}


// Array para almacenar todos los contactos
$todos_contactos = [];

// Consulta para obtener contactos de CRM
$sql = "SELECT * FROM contactos WHERE id_user = $id_CRM";
$resultado = mysqli_query($conexion, $sql);

if ($resultado) {
    if (mysqli_num_rows($resultado) > 0) {
        while ($contacto = mysqli_fetch_assoc($resultado)) {
            // Almacena el contacto original
            $contacto_completo = $contacto;
            
            // Obtén el ID del contacto
            $id_contacto = $contacto['id'];

            // Consulta adicional en la base de datos BullTrack filtrando por ID del contacto
            $sql2 = "SELECT contacto_crm.nit_contacto, contacto_crm.razon_social_contacto, contacto_crm.id_usuario, contacto_crm.id_contactos_CRM, contacto_crm.id FROM contacto_crm WHERE id_contactos_CRM = $id_contacto";
            $resultado2 = mysqli_query($conexion_bull, $sql2);

            if ($resultado2) {
                if (mysqli_num_rows($resultado2) > 0) {
                    // Aquí asumimos que solo se espera un contacto coincidente
                    $contacto_bull = mysqli_fetch_assoc($resultado2);
                    // Combina la información de ambas consultas
                    $contacto_completo = array_merge($contacto, $contacto_bull);
                }
            } else {
                // Manejo de error para la segunda consulta
                $contacto_completo['error_bull'] = "Error en la consulta BullTrack: " . mysqli_error($conexion_bull);
            }
            
            // Agrega el contacto completo al array
            $todos_contactos[] = $contacto_completo;
        }
    } else {
        $todos_contactos['error'] = "No se encontraron contactos para el usuario.";
    }
} else {
    $todos_contactos['error'] = "Error en la consulta principal: " . mysqli_error($conexion);
}

//var_dump($todos_contactos); // Muestra todos los contactos completos

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BullTrack</title>
    <link rel="icon" href="../Media/Iconos/logo512.png" type="image/x-icon">
    <link rel="stylesheet" href="../EstilosFuncionalidad/styles.css">
    <script src="./Funcionalidad/Funcionalidad-JS/FuncionalidadPropuestas.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     
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
                                    <button class="BotonesFormulario" id="editarPropuestasBtn">
                                        <img src="../Media/Iconos/editar.png" alt="local-icon" width="20" height="20" class="">
                                        <span>Editar</span>
                                    </button>
                                    <button class="BotonesFormulario"  id="agregarPropuestasBtn">
                                        <img src="../Media/Iconos/Agregar.png" alt="local-icon" width="20" height="20" class="">
                                        <span>Agregar</span>
                                    </button>
                                    <button class="BotonesFormulario"  id="eliminarPropuestasBtn">
                                        <img src="../Media/Iconos/eliminar.png" alt="local-icon" width="20" height="20" class="">
                                        <span>Eliminar</span>
                                    </button>
                                </div>
                            </div>
                                    
                            <form class="ParteFormularioPropuesta ">
                                <div class="form-row">
                                    <input type="hidden" id="id_Proyecto" name="id_Proyecto" value="">
                                    <div class="form-group">
                                        <label for="nombreCliente">Nombre Cliente</label>
                                        <input type="text" id="NombreCliente" name="NombreCliente"  placeholder="Ingrese el Nombre del Cliente" readonly>
                                    </div>
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
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="UnidadNegocio">Unidad de Negocio</label>
                                        <select id="UnidadNegocio" name="UnidadNegocio" placeholder="Ingrese la Descipción del Proyecto" disabled>
                                            <option value="Trade">Trade</option>
                                            <option value="Logistica" selected>Logistica</option>
                                            <option value="Digital" selected>Digital</option>
                                            <option value="BTL" selected>BTL</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="FormatoProceso">Formato de Proceso</label>
                                        <select id="FormatoProceso" name="FormatoProceso" placeholder="Ingrese el Formato de Proceso" disabled>
                                            <option value="Mantenimiento">Mantenimiento</option>
                                            <option value="Generación de Propuesta" selected>Generación de Propuesta</option>
                                            <option value="Licitación" selected>Licitación</option>
                                            <option value="Asignación" selected>Asignación</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="estadoPropuesta">Estado de la Propuesta</label>
                                        <select id="estadoPropuesta" name="estadoPropuesta" placeholder="Ingrese el Formato de Proceso" disabled>
                                            <option value="Propuesta">Propuesta</option>
                                            <option value="Vendida" selected>Vendida</option>
                                            <option value="No Aprobada" selected>No Aprobada</option>
                                            <option value="Licitación" selected>Licitación</option>
                                            <option value="Presentacion de Credenciales" selected>Presentación de Credenciales</option>
                                        </select>
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
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="FechaEntregaEconomica">Fecha Entrega Economica</label>
                                        <input type="datetime-local" id="FechaEntregaEconomica" name="FechaEntregaEconomica" placeholder="Ingrese la Fecha de Entrega Económica" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="Contacto_1">Contacto 1</label>
                                        <input type ="text" id="Contacto_1" name="Contacto_1" placeholder="Ingrese los Medios de Contacto" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="Contacto_2">Contacto 2</label>
                                        <input type ="text" id="Contacto_2" name="Contacto_2" placeholder="Ingrese los Medios de Contacto" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Observación_1">Observación 1</label>
                                        <input type="text" id="Observación_1" name="Observación_1" placeholder="Ingrese una Observación" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="Observación_2">Observación 2</label>
                                        <input type ="text" id="Observación_2" name="Observación_2" placeholder="Ingrese una Observación" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="ArchivosAdjuntosComercial">Archivos Enviados por el Cliente</label>
                                        <input type ="text" id="ArchivosAdjuntosComercial" name="ArchivosAdjuntosComercial" placeholder="Ingrese los Archivos" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="NecesidadOT">Necesita OT</label>
                                        <select id="NecesidadOTSelect" name="NecesidadOTSelect" disabled>
                                            <option value="Si">Si</option>
                                            <option value="No" selected>No</option>
                                        </select>
                                    </div>
                                </div>
                            </form> 

                            <div class="SelectUserPropuesta" id="SelectUserPropuestas">
                                <h3>Selecciona tu Contacto</h3>
                                <div class="ContainerSelectUSer">
                                    <div class="CuadroFiltradoSelectUser">
                                        <div class="filterUserSelect">
                                            <input type="text" placeholder="Nombre del Usuario...">
                                        </div>
                                        <div class="Lista_2">
                                            <ul>
                                                <?php
                                                if (!isset($todos_contactos['error'])) {
                                                    foreach ($todos_contactos as $contacto) {
                                                        echo '<li>';
                                                        echo '<div class="user-item" data-id="' . htmlspecialchars($contacto["id"]) . '" '
                                                            . 'data-id="' . htmlspecialchars($contacto["id"]) . '" '
                                                            . 'data-nombre="' . htmlspecialchars($contacto["nombre"]) . '" '
                                                            . 'data-apellido="' . htmlspecialchars($contacto["apellido"]) . '" '
                                                            . 'data-cargo="' . htmlspecialchars($contacto["cargo"]) . '" '
                                                            . 'data-celular="' . htmlspecialchars($contacto["celular"]) . '" '
                                                            . 'data-correo="' . htmlspecialchars($contacto["correo"]) . '" '
                                                            . 'data-empresa="' . htmlspecialchars($contacto["empresa"]) . '" '
                                                            . 'data-ciudad="' . htmlspecialchars($contacto["ciudad"]) . '" '
                                                            . 'data-direccion="' . htmlspecialchars($contacto["direccion"]) . '" '
                                                            . 'data-web="' . htmlspecialchars($contacto["web"]) . '" '
                                                            . 'data-nit="' . htmlspecialchars($contacto["nit_contacto"] ?? 'N/A') . '" '
                                                            . 'data-razon-social="' . htmlspecialchars($contacto["razon_social_contacto"] ?? 'N/A') . '">';
                                                    
                                                        echo '<div class="NombreContacto" style="font-size: 14px; font-weight: 600;">' . htmlspecialchars($contacto["nombre"]) . ' ' . htmlspecialchars($contacto["apellido"]) . '</div>';
                                                        echo '<div class="CargoContacto" style="font-size: 13px; color: #262626;">' . htmlspecialchars($contacto["cargo"]) . '</div>';
                                                        echo '<div class="EmpresaContacto" style="font-size: 13px; color: #262626;">' . htmlspecialchars($contacto["empresa"]) . '</div>';
                                                        
                                                        echo '</div>';
                                                        echo '</li>';
                                                    }
                                                    
                                                } else {
                                                    echo '<li>' . htmlspecialchars($todos_contactos['error']) . '</li>';
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="InformacionSelectedUser">
                                        <div>
                                            <div class="form-row_2">
                                                <div class="form-group">
                                                    <input type="hidden" id="id_contacro_crm" name="id_contacro_crm" value="">
                                                    <label for="Nombre">Nombre y Apellido</label>
                                                    <input type="text" id="Nombre" name="Nombre"   readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Cargo">Cargo</label>
                                                    <input type="text" id="Cargo" name="Cargo"  readonly>
                                                </div>
                                            </div>
                                            <div class="form-row_2">
                                                <div class="form-group">
                                                    <label for="Celular">Celular</label>
                                                    <input type="text" id="Celular" name="Celular"  readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Correo">Correo</label>
                                                    <input type="text" id="Correo" name="Correo"  readonly>
                                                </div>
                                            </div>
                                            <div class="form-row_2">
                                                <div class="form-group">
                                                    <label for="Empresa">Empresa</label>
                                                    <input type="text" id="Empresa" name="Empresa"  readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Ciudad">Ciudad</label>
                                                    <input type="text" id="Ciudad" name="Ciudad"  readonly>
                                                </div>
                                            </div>
                                            <div class="form-row_2">
                                                <div class="form-group">
                                                    <label for="Web">Web</label>
                                                    <input type="text" id="Web" name="Web"  readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Direccion">Dirección</label>
                                                    <input type="text" id="Direccion" name="Direccion"  readonly>
                                                </div>
                                            </div>
                                            <div class="form-row_2">
                                                <div class="form-group">
                                                    <label for="nit">N.I.T</label>
                                                    <input type="text" id="nit" name="nit"   readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="razon_social">Razon Social</label>
                                                    <input type="text" id="razon_social" name="razon_social" readonly>
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

                            <form class="ParteFormularioOT_RegistroPropuestas" id="FormualrioOTRegistroPropuestas" style="display: none;">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="Brief">Brief</label>
                                        <input 
                                            type="text" 
                                            id="Brief" 
                                            name="Brief"  
                                            readonly
                                            placeholder=" Ingrese el Nombre del Brief"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="ObjetivosBrief">Objetivo del Brief</label>
                                        <input 
                                            type="text" 
                                            id="ObjetivosBrief" 
                                            name="ObjetivosBrief"
                                            readonly
                                            placeholder="Ingrese el Objetivo del Brief"
                                        />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="tipoCliente">Tipo Cliente</label>
                                        <select id="tipoCliente" name="tipoCliente"  placeholder="Ingrese la Descipción del Proyecto" disabled>
                                            <option value="Cliente Potencial">Cliente Potencial</option>
                                            <option value="Cliente Nuevo" selected>Cliente Nuevo</option>
                                            <option value="Cliente Clave" selected>Cliente Clave</option>
                                        </select>
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
                                    <div class="form-group">
                                        <label for="dateEntregaCliente">Fecha Entrega Cliente</label>
                                        <input 
                                            type="datetime-local" 
                                            id="dateEntregaCliente" 
                                            name="dateEntregaCliente"
                                            readonly
                                            placeholder="Ingrese la Fecha de Entrega al Cliente"
                                        />
                                    </div>
                                </div>  
                            </form> 
                        </div>
                    </div>

                    
                    <div class="ContactosCreados">
                        <div class="MostrarListaDesplegable">
                            <div class="InputFiltrar">
                                <input type="text" placeholder="Nombre del Proyecto..." id="nombreProyecto">
                            </div>
                            <div class="InputFiltrar_2" id="estadoPropuesta" placeholder="Estado Propuesta">
                                <select style="margin-right: 4px;">
                                    <option value="">Estado Propuesta</option>
                                    <option value="activo">Propuesta</option>
                                    <option value="inactivo">Vendida</option>
                                    <option value="pendiente">No Aprobada</option>
                                    <option value="pendiente">Licitación</option>
                                    <option value="pendiente">Presentación Credenciales</option>
                                </select>
                                <select style="margin-right: 0px;">
                                    <option value="">Cliente...</option>
                                    <option value="cliente1">Cliente 1</option>
                                    <option value="cliente2">Cliente 2</option>
                                    <option value="cliente3">Cliente 3</option>
                                </select>     
                            </div> 

                            <div class="Lista" id="listaProyectos">
                                <ul>
                                    <?php
                                    // Verificar si la consulta se realizó correctamente
                                    if (!empty($info_completa)) {
                                        // Usar un bucle foreach para recorrer los contactos
                                        foreach ($info_completa as $contacto) {
                                            // Comprobar si hay proyectos
                                            if (!empty($contacto['proyectos'])) {
                                                // Iterar sobre cada proyecto
                                                foreach ($contacto['proyectos'] as $fila) {
                                                    echo '<li>';
                                                    echo '<div class="propuesta-item data-estadoPropuesta="inactivo"" '
                                                        . 'data-id_proyecto="' . htmlspecialchars($fila["id"]) . '" '
                                                        . 'data-nombre-proyecto="' . htmlspecialchars($fila["nombreProyecto"] ?? 'N/A') . '" '
                                                        . 'data-userBull="' . htmlspecialchars($fila["id_user"] ?? 'N/A') . '" '
                                                        . 'data-unidadNegocio="' . htmlspecialchars($fila["id_unidadNegocio"] ?? 'N/A') . '" '
                                                        . 'data-fechaInicio="' . htmlspecialchars($fila["dateCreated"] ?? 'N/A') . '" '
                                                        . 'data-descripcionProyecto="' . htmlspecialchars($fila["descripcionProyecto"] ?? 'N/A') . '" '
                                                        . 'data-valorProyecto="' . htmlspecialchars($fila["valorProyecto"] ?? 'N/A') . '" '
                                                        . 'data-estadoPropuesta="' . htmlspecialchars($fila["estadoPropuesta"] ?? 'N/A') . '" '
                                                        . 'data-dateEntregaEconomicaCliente="' . htmlspecialchars($fila["dateEntregaEconomicaCliente"] ?? 'N/A') . '" '
                                                        . 'data-medioContacto_1="' . htmlspecialchars($fila["medioContacto1"] ?? 'N/A') . '" '
                                                        . 'data-medioContacto_2="' . htmlspecialchars($fila["medioContacto2"] ?? 'N/A') . '" '
                                                        . 'data-observacionProyecto_1="' . htmlspecialchars($fila["observacionProyecto1"] ?? 'N/A') . '" '
                                                        . 'data-observacionProyecto_2="' . htmlspecialchars($fila["observacionProyecto2"] ?? 'N/A') . '" '
                                                        . 'data-linkArchivosAdjuntos="' . htmlspecialchars($fila["archivosAdjuntos"] ?? 'N/A') . '" '
                                                        . 'data-formatoProceso="' . htmlspecialchars($fila["formatoProceso"] ?? 'N/A') . '" '
                                                        . 'data-idCliente="' . htmlspecialchars($fila["idCliente"] ?? 'N/A') . '" '
                                                        . 'data-isDeleted="' . htmlspecialchars($fila["isDeleted"] ?? 'N/A') . '" '
                                                        . 'data-nitCliente="' . htmlspecialchars($fila["nit_contacto"] ?? 'N/A') . '" '
                                                        . 'data-razonSocialCliente="' . htmlspecialchars($fila["razon_social_contacto"] ?? 'N/A') . '" '
                                                        . 'data-nombreCliente="' . htmlspecialchars($contacto["nombre"] ?? 'N/A') . '" '
                                                        . 'data-apellidoCliente="' . htmlspecialchars($contacto["apellido"] ?? 'N/A') . '" '
                                                        . 'data-apellidoCliente="' . htmlspecialchars($contacto["apellido"] ?? 'N/A') . '" '
                                                        . 'data-ciudadesImpacto="' . htmlspecialchars($fila["CiudadesImpacto"] ?? 'N/A') . '" '
                                                        . 'data-NecesitaOT="' . htmlspecialchars($fila["NecesitaOT"] ?? 'N/A') . '" '
                                                        . 'data-nombreBrief="' . htmlspecialchars($fila["nombreBrief"] ?? 'N/A') . '" '
                                                        . 'data-objetivoBrief="' . htmlspecialchars($fila["objetivoBrief"] ?? 'N/A') . '" '
                                                        . 'data-tipoEntregable="' . htmlspecialchars($fila["tipoEntregables"] ?? 'N/A') . '" '
                                                        . 'data-tipoCliente="' . htmlspecialchars($fila["TipoCliente"] ?? 'N/A') . '" '
                                                        . 'data-dateEntrega="' . htmlspecialchars($fila["dateEntrega"] ?? 'N/A') . '" '
                                                        . '>';

                                                    // Mostrar información del proyecto
                                                    echo '<div class="NombreProyecto" id="NombreProyecto" style="font-size: 14px; font-weight: 600;">'
                                                        . htmlspecialchars($fila["nombreProyecto"] ?? 'No disponible') . '</div>';
                                                    
                                                    echo '<div class="ClienteProyecto"  style="font-size: 14px; font-weight: 600;">'
                                                        . htmlspecialchars($contacto["nombre"] ?? 'No disponible') . '  ' 
                                                        . htmlspecialchars($contacto["apellido"] ?? 'No disponible') . '</div>';
                                                    
                                                    echo '<div class="NombreEmpresa" style="font-size: 14px; color: #262626;">'
                                                        . htmlspecialchars($contacto["empresa"] ?? 'No disponible') . '</div>';
                                                    
                                                    echo '<div class="EstadoProyecto" style="font-size: 13px; color: #262626;">'
                                                        . htmlspecialchars($fila["estadoPropuesta"] ?? 'No disponible') . '</div>';
                                                    
                                                    // echo '<div class="FechaInicio" style="Sfont-size: 9px; color: #262626;">'
                                                    //     . htmlspecialchars($fila["dateCreated"] ?? 'No disponible') . '</div>';

                                                    echo '</div>'; // Cerrar propuesta-item
                                                    echo '</li>'; // Cerrar li
                                                }
                                            } else {
                                                echo '<li>No hay proyectos para el contacto ' . htmlspecialchars($contacto['razon_social_contacto'] ?? 'No disponible') . '.</li>';
                                            }
                                        }
                                    } else {
                                        echo '<li>No se encontraron resultados.</li>';
                                    }
                                    ?>
                                </ul>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<style>

</style>

</html>