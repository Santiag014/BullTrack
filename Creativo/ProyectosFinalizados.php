<?php
// Iniciar sesión y verificación de usuario (código no modificado)
session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $NombreUsuario = $_SESSION['NombreUsuario'];
    $CorreoUsuario = $_SESSION['CorreoUsuario'];
    $rol_user = $_SESSION['NombreRol'];
    $id_rol = $_SESSION['id_rol'];
    $id_CRM = $_SESSION['id_CRM'];
    $id_USER = $_SESSION['id'];

    $_SESSION['datos_usuario'] = array(
        'id' => $id,
        'nombre' => $NombreUsuario,
        'correo' => $CorreoUsuario,
        'rol_user' => $rol_user,
    );
}

// Función para imprimir de manera segura
function debug_print($message) {
    echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . "<br>\n";
}

// Conexión a BullTrack
include '../ConexionesBD/ConexionBDBullTrack.php';

//debug_print("Conexión a BullTrack establecida.");

// Consulta en BullTrack (SQL no modificado)
$sql_1 = "SELECT
    SeguimientoCreativo.id,
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
    SeguimientoComercial.CiudadesImpacto,
    contacto_crm.nit_contacto, 
    contacto_crm.razon_social_contacto,
    contacto_crm.id_contactos_CRM,
    SeguimientoCreativo.dateEntrega,
    SeguimientoCreativo.nombreBrief,
    SeguimientoCreativo.objetivoBrief,
    SeguimientoCreativo.tipoEntregables,
    SeguimientoCreativo.artesProyecto,
    SeguimientoCreativo.linkProyecto,
    SeguimientoCreativo.dateLinkProyecto,
    SeguimientoCreativo.datosAdicionalesBrief,
    SeguimientoCreativo.dateEntregaCliente,
    SeguimientoCreativo.id_archivoAdjuntoCreativo,
    SeguimientoCreativo.dateSocializacion,
    SeguimientoCreativo.TipoCliente,
    SeguimientoCreativo.EstadoProyecto,
    SeguimientoCreativo.Created,
    -- Subconsulta para horas trabajadas específicas del usuario
    (SELECT SUM(h.horasTrabajadas) 
     FROM CreativosHoras h 
     WHERE h.id_seguimiento_creativo = SeguimientoCreativo.id 
       AND h.usuario_id = $id_USER) AS horasTrabajadas,
    -- Subconsulta para horas extras específicas del usuario
    (SELECT SUM(h.horasExtras) 
     FROM CreativosHoras h 
     WHERE h.id_seguimiento_creativo = SeguimientoCreativo.id 
       AND h.usuario_id = $id_USER) AS horasExtras,
    GROUP_CONCAT(DISTINCT CASE WHEN CreativosHoras.rolCreativos = 1 THEN Usuarios.NombreUsuario END) AS NombreLider,
    GROUP_CONCAT(DISTINCT CASE WHEN CreativosHoras.rolCreativos = 0 THEN Usuarios.NombreUsuario END) AS CreativosOT,
    u.NombreUsuario
FROM 
    SeguimientoComercial 
JOIN 
    contacto_crm ON SeguimientoComercial.id_contacto = contacto_crm.id
JOIN 
    Usuarios u ON contacto_crm.id_usuario = u.id  -- Corrige la unión con Usuarios
INNER JOIN 
    SeguimientoCreativo ON SeguimientoComercial.id = SeguimientoCreativo.id_comercial
LEFT JOIN 
    CreativosHoras ON SeguimientoCreativo.id = CreativosHoras.id_seguimiento_creativo
LEFT JOIN 
    Usuarios ON CreativosHoras.usuario_id = Usuarios.id
WHERE 
    SeguimientoComercial.isDeleted = 0 
    AND SeguimientoCreativo.EstadoProyecto = 'Finalizados' AND SeguimientoCreativo.id IN (
      SELECT id_seguimiento_creativo
      FROM CreativosHoras
      WHERE usuario_id = $id_USER)
GROUP BY
    SeguimientoCreativo.id,
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
    SeguimientoComercial.CiudadesImpacto,
    contacto_crm.nit_contacto, 
    contacto_crm.razon_social_contacto,
    contacto_crm.id_contactos_CRM,
    SeguimientoCreativo.dateEntrega,
    SeguimientoCreativo.nombreBrief,
    SeguimientoCreativo.objetivoBrief,
    SeguimientoCreativo.tipoEntregables,
    SeguimientoCreativo.artesProyecto,
    SeguimientoCreativo.linkProyecto,
    SeguimientoCreativo.dateLinkProyecto,
    SeguimientoCreativo.datosAdicionalesBrief,
    SeguimientoCreativo.dateEntregaCliente,
    SeguimientoCreativo.id_archivoAdjuntoCreativo,
    SeguimientoCreativo.dateSocializacion,
    SeguimientoCreativo.TipoCliente,
    SeguimientoCreativo.EstadoProyecto,
    SeguimientoCreativo.Created,
    u.NombreUsuario;";

$resultado2 = mysqli_query($conexion_bull, $sql_1);
//debug_print("Consulta BullTrack ejecutada.");

// Inicializa el array para almacenar los resultados de BullTrack
$proyectos_bulltrack = []; 

// Verifica si hay resultados
if ($resultado2) {
    // Recorre cada fila del resultado
    while ($proyecto = mysqli_fetch_assoc($resultado2)) {
        // Usar id_contactos_CRM como clave
        $id_contacto_CRM = $proyecto['id_contactos_CRM'];
        
        // Verifica si la clave ya existe en el array
        if (!isset($proyectos_bulltrack[$id_contacto_CRM])) {
            // Si no existe, inicializa un array para esa clave
            $proyectos_bulltrack[$id_contacto_CRM] = [];
        }
        
        // Agrega el proyecto al array correspondiente a esa clave
        $proyectos_bulltrack[$id_contacto_CRM][] = $proyecto;
        
        //debug_print("Proyecto BullTrack agregado: ID_contactos_CRM " . $id_contacto_CRM);
    }
    
    // Muestra el número de proyectos almacenados
    //debug_print("Número de proyectos en BullTrack: " . count($proyectos_bulltrack));
} else {
    // Manejo de errores
    //debug_print("Error en la consulta BullTrack: " . mysqli_error($conexion_bull));
}

// Var_dump para depurar
//var_dump($proyectos_bulltrack);
//debug_print("Total de proyectos en BullTrack: " . count($proyectos_bulltrack));
 
// Conexión a CRM
include '../ConexionesBD/ConexcionDBcrm.php';
//include '../Creativo/Funcionalidad/BackendLideres/consultaCreativoLider.php';
//debug_print("Conexión a CRM establecida.");
 
// Consulta para obtener contactos de CRM
$sql_crm = "SELECT * FROM contactos;";
$resultado = mysqli_query($conexion, $sql_crm);
$info_completa = []; // Array para almacenar el resultado final
 
$total_contactos = 0;
$contactos_con_proyecto = 0;
 
//debug_print("Consulta CRM ejecutada.");
 
if ($resultado && mysqli_num_rows($resultado) > 0) {
    //debug_print("Número de filas en resultado CRM: " . mysqli_num_rows($resultado));
    while ($contacto = mysqli_fetch_assoc($resultado)) {
        $total_contactos++;
        $id_contacto_CRM = $contacto['id'];
 
        //debug_print("Procesando contacto CRM: ID " . $id_contacto_CRM);
 
        // Verifica si este contacto tiene un proyecto relacionado en BullTrack
        if (isset($proyectos_bulltrack[$id_contacto_CRM])) {
            $contactos_con_proyecto++;
            // Asegúrate de que puedas manejar múltiples proyectos por contacto
            $proyecto_bulltrack = $proyectos_bulltrack[$id_contacto_CRM];
           
            // Si un contacto puede tener varios proyectos, agrégalo a un array
            if (isset($info_completa[$id_contacto_CRM])) {
                // Ya existe un contacto, así que solo agrega el proyecto
                $info_completa[$id_contacto_CRM]['proyectos'][] = $proyecto_bulltrack;
            } else {
                // No existe, así que crea la entrada
                $contacto_completo = array_merge($contacto, ['proyectos' => [$proyecto_bulltrack]]);
                $info_completa[$id_contacto_CRM] = $contacto_completo;
            }
        }
    }
} else {
    $info_completa['error'] = "No se encontraron contactos en CRM.";
    if (!$resultado) {
    }
}
//var_dump($info_completa);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BullTrack</title>
    <link rel="icon" href="../Media/Iconos/logo512.png" type="image/x-icon">
    <link rel="stylesheet" href="../EstilosFuncionalidad/styles.css">
    <script src="./Funcionalidad/Funcionalidad-JS/FuncionalidadLideres.js" defer></script>
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
                    <div class="TipoGrafia_Rol"><?php echo $rol_user; ?></div>       
                </div>
                <div class="InformacionModulos">
                <?php if ($id_rol == 4): ?>
                        <div class="ModulosDash" onclick="AsignarProyectos(<?php echo $_SESSION['datos_usuario']['id']; ?>)">
                            <img src="../Media/Iconos/asignar_boton.png" alt="local-icon" width="20" height="20" class="local-icon">
                            <span>Asignar OTs</span>
                        </div>
                    <?php endif; ?>
                    <div class="ModulosDash" onclick="RedirigirLideres()">
                        <img src="../Media/Iconos/lider.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Proyectos Líderes</span>
                    </div>
                    <div class="ModulosDash" onclick="RedirigiCreativos()">
                        <img src="../Media/Iconos/creativos.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Proyectos Creativos</span>
                    </div>
                    <div class="ModulosDash" onclick="RedirigirFinalizados()">
                        <img src="../Media/Iconos/Propuestas.png" alt="local-icon" width="20" height="20" class="local-icon">
                        <span>Proyectos Finalizados</span>
                    </div>
                    <!-- Mostrar Dashboard Gerencial solo si id_rol es 4 -->
                    <?php if ($id_rol == 4): ?>
                        <div class="ModulosDash" onclick="DashBoradGerencial(<?php echo $_SESSION['datos_usuario']['id']; ?>)">
                            <img src="../Media/Iconos/gerencia.png" alt="local-icon" width="20" height="20" class="local-icon">
                            <span>Dashboard Gerencial</span>
                        </div>
                    <?php endif; ?>
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
                <div class="ContainerPropuestasComercial">
                    <div class="FormularioPropuestasComercial">
                        <div class="FormPropuestas">
                            <div class="ParteSuperiorPropuesta">
                                <div class="InformacionPropuesta">
                                    <h3>Asignar Ots</h3>
                                </div>
                                <div class="BotonesInteraccion">
                                    <!-- <button class="BotonesFormulario" id="editarOTLider" data-creativoProyecto="Creativo_1,Creativo_4,Creativo_5">
                                        <img src="../Media/Iconos/editar.png" alt="local-icon" width="20" height="20" class="local-icon">
                                        <span>Asignar OT</span>
                                    </button> -->
                                    <!-- <button class="BotonesFormulario" id="verDatosBtn">
                                        <img src="../Media/Iconos/PropuestasForms.png" alt="local-icon" width="20" height="20" class="local-icon">
                                        <span>Datos Propuesta</span>
                                    </button> -->
                                </div>
                            </div>
    
                            <!-- Form 1: ParteFormularioOT -->
                            <form id="form1" class="ParteFormularioOT">
                            <div class="form-row">
                                    <input type="hidden" id="id_Proyecto" name="id_Proyecto" value="">
                                    <div class="form-group">
                                        <label for="LiderProyecto">Lider Proyecto</label>
                                        <input type="text" id="LiderProyecto" name="LiderProyecto" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="CreativosProyecto">Creativo</label>
                                        <input type="text" id="CreativoProyecto" name="CreativoProyecto" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="nombreBrief">Brief</label>
                                        <div class="scrollable-container">
                                            <textarea id="nombreBrief" name="nombreBrief" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ObjetivosBrief">Objetivo del Brief</label>
                                        <div class="scrollable-container">
                                            <textarea id="ObjetivosBrief" name="ObjetivosBrief" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="TipoClienteOT">Tipo Cliente</label>
                                        <select id="TipoClienteOT" name="TipoClienteOT"  placeholder="Ingrese la Descipción del Proyecto" disabled>
                                            <option value="" select></option>
                                            <option value="Cliente Potencial">Cliente Potencial</option>
                                            <option value="Cliente Nuevo" >Cliente Nuevo</option>
                                            <option value="Cliente Clave" >Cliente Clave</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="EntregablesBrief">Entregables</label>
                                        <input type="text" id="EntregablesBrief" name="EntregablesBrief" readonly >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="DateEntregaComercial">Fecha Entrega Comercial</label>
                                        <input type="datetime-local" id="DateEntregaComercial" name="DateEntregaComercial" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="DateFechaSocializacion">Fecha Socialización</label>
                                        <input type="datetime-local" id="DateFechaSocializacion" name="DateFechaSocializacion" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="DateEntregaLink">Fecha Entrega Link</label>
                                        <input type="datetime-local" id="DateEntregaLink" name="DateEntregaLink" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                    <label for="DatosAdicionales">Datos Adicionales</label>
                                        <input type="text" id="DatosAdicionales" name="DatosAdicionales" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="artesCreativo">Artes</label>
                                        <input type="text" id="artesCreativo" name="artesCreativo" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="linkProyecto">Link</label>
                                        <input type="text" id="linkProyecto" name="linkProyecto" readonly>
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
                                    <div class="form-group">
                                        <label for="EstadoProyecto">Estado del Proyecto</label>
                                        <select id="EstadoProyecto" name="EstadoProyecto"  placeholder="Ingrese la Descipción del Proyecto" disabled>
                                            <option value="" select></option>
                                            <option value="Sin Asignar">Sin Asignar</option>
                                            <option value="En Producción" >En Producción</option>
                                            <option value="Finalizados" >Finalizados</option>
                                        </select>
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
                            </form>
                        </div>
                    </div>
                    <div class="ContactosCreados">
                        <div class="MostrarListaDesplegable">
                            <div class="InputFiltrar">
                                <input type="text" placeholder="Buscar OT...">
                            </div>
                            <div class="Lista" id="listaProyectos">
                                <ul>
                                <?php
                                    if (!empty($info_completa) && is_array($info_completa)) {
                                        echo '<div class="Lista" id="listaProyectos">';
                                        echo '<ul>';
                                        
                                        foreach ($info_completa as $id_contacto => $contacto) {
                                            if (isset($contacto['proyectos']) && is_array($contacto['proyectos'])) {
                                                foreach ($contacto['proyectos'] as $proyectos) {
                                                    foreach ($proyectos as $proyecto) {
                                                        echo '<li>';
                                                        echo '<div class="propuesta-item" '
                                                            //Valores para Datos Adicionales
                                                            . 'data-id_proyecto="' . htmlspecialchars($proyecto["id"] ?? 'N/A') . '" '
                                                            . 'data-nombreProyecto="' . htmlspecialchars($proyecto["nombreProyecto"] ?? 'N/A') . '" '
                                                            . 'data-descripcionProyecto="' . htmlspecialchars($proyecto["descripcionProyecto"] ?? 'N/A') . '" '
                                                            . 'data-unidadNegocio="' . htmlspecialchars($proyecto["id_unidadNegocio"] ?? 'N/A') . '" '
                                                            . 'data-formatoProceso="' . htmlspecialchars($proyecto["formatoProceso"] ?? 'N/A') . '" '
                                                            . 'data-estadoPropuesta="' . htmlspecialchars($proyecto["estadoPropuesta"] ?? 'N/A') . '" '
                                                            . 'data-ciudadImpacto="' . htmlspecialchars($proyecto["CiudadesImpacto"] ?? 'N/A') . '" '
                                                            . 'data-valorPropuesta="' . htmlspecialchars($proyecto["valorProyecto"] ?? 'N/A') . '" '
                                                            . 'data-nombreUsuario="' . htmlspecialchars($proyecto["NombreUsuario"] ?? 'N/A') . '" '
                                                            . 'data-fechaEconomica="' . htmlspecialchars($proyecto["dateEntregaEconomicaCliente"] ?? 'N/A') . '" '

                                                            //Valores para la OT
                                                            . 'data-liderProyecto="' . htmlspecialchars($proyecto["NombreLider"] ?? 'N/A') . '" '
                                                            . 'data-creativoProyecto="' . htmlspecialchars($proyecto["CreativosOT"] ?? 'N/A') . '" '
                                                            . 'data-nombreBrief="' . htmlspecialchars($proyecto["nombreBrief"] ?? 'N/A') . '" '
                                                            . 'data-objetivoBrief="' . htmlspecialchars($proyecto["objetivoBrief"] ?? 'N/A') . '" '
                                                            . 'data-tipoCliente="' . htmlspecialchars($proyecto["TipoCliente"] ?? 'N/A') . '" '
                                                            . 'data-entregables="' . htmlspecialchars($proyecto["tipoEntregables"] ?? 'N/A') . '" '
                                                            . 'data-dateEntregaComercial="' . htmlspecialchars($proyecto["dateEntrega"] ?? 'N/A') . '" '
                                                            . 'data-dateSocializacion="' . htmlspecialchars($proyecto["dateSocializacion"] ?? 'N/A') . '" '
                                                            . 'data-dateEntregaLink="' . htmlspecialchars($proyecto["dateLinkProyecto"] ?? 'N/A') . '" '
                                                            . 'data-datosAdicionales="' . htmlspecialchars($proyecto["datosAdicionalesBrief"] ?? 'N/A') . '" '
                                                            . 'data-artesProyecto="' . htmlspecialchars($proyecto["artesProyecto"] ?? 'N/A') . '" '
                                                            . 'data-linkProyecto="' . htmlspecialchars($proyecto["linkProyecto"] ?? 'N/A') . '" '
                                                            . 'data-horasTrabajadas="' . htmlspecialchars($proyecto["horasTrabajadas"] ?? 'N/A') . '" '
                                                            . 'data-horasExtras="' . htmlspecialchars($proyecto["horasExtras"] ?? 'N/A') . '" '
                                                            . 'data-EstadoPropuestas="' . htmlspecialchars($proyecto["EstadoProyecto"] ?? 'N/A') . '" '
                                                            . '>';

                                                        // Contenido visible del proyecto
                                                        echo '<div class="NombreProyecto" id="NombreProyecto" style="font-size: 14px; font-weight: 600;">'
                                                            . htmlspecialchars($proyecto["nombreProyecto"] ?? 'No disponible') . '</div>';

                                                        echo '<div class="NombreUsuario" id="NombreUsuario" style="font-size: 14px; font-weight: 450;">'
                                                            . htmlspecialchars($proyecto["NombreUsuario"] ?? 'No disponible') . '</div>';

                                                        echo '<div class="Empresa" id="Empresa" style="font-size: 14px; font-weight: 450;">'
                                                            . htmlspecialchars($contacto["empresa"] ?? 'No disponible') . '</div>';
                                                        
                                                        echo '<div class="EstadoProyecto" style="font-size: 13px; color: #262626;">'
                                                            . htmlspecialchars($proyecto["EstadoProyecto"] ?? 'Sin Asignar') . '</div>';

                                                        echo '<div class="FechaCreacion" style="font-size: 13px; color: #262626;">'
                                                            . htmlspecialchars($proyecto["Created"] ?? 'No disponible') . '</div>';

                                                        echo '</div>'; // Cerrar propuesta-item
                                                        echo '</li>';
                                                    }
                                                }
                                            }
                                        }
                                        
                                        echo '</ul>';
                                        echo '</div>'; // Cerrar listaProyectos
                                    } else {
                                        //echo '<p>No se encontraron proyectos para mostrar.</p>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </script>
</body>
</html>